<?php require("../template/header.php"); ?>
<?php require_once("../api/utilities.php"); ?>

<script>
    var tweets = [];
    var players = [];
    var matches = [];
    var last_id = -1;
    var huid = get_huid();

    function load_players() {
        $('#more_button').hide();
        $('#spinner').show();
        $('.spinner_save').hide();
        if( Cookies.get('last_author') )
            $('#author_input')[0].value = Cookies.get('last_author');

        $.get('../api/player.php', function(data) {
            // Convert in array details    
            res = JSON.parse(data);
            res.forEach( r => { 
                r['active'] = ( r.CountRecentA + r.CountRecentD > <?php echo get_game_param("active_threshold"); ?> );
                players[r.ID] = r;
            });

            // Sort
            const compare = function(a, b) { textA = a.Nome.toUpperCase(); textB = b.Nome.toUpperCase(); return (textA < textB) ? -1 : (textA > textB) ? 1 : 0; }
            res.sort(compare);

            // Append items
            tag_modal_list = $('#tag_modal_list');
            active = $( '<div>' ).append( $('<h4>', { text: "Attivi" }) );
            inactive = $( '<div> ' ).append( $('<h4>', { text: "Altri" }) );

            res.forEach( function(p) {
                if( p.active )
                    active.append(`
                        <button class="btn btn-light btn-block text-left"
                            onclick="insert_tag(${p.ID})">${p.Nome}</button>
                    `);
                else inactive.append(`
                        <button class="btn btn-light btn-block text-left"
                            onclick="insert_tag(${p.ID})">${p.Nome}</button>
                    `);
            });
            
            tag_modal_list.append( active );
            tag_modal_list.append( inactive );

            load_matches();
        })
    }

    function load_matches() {
        $.get('../api/match.php', function(data) {
            res = JSON.parse(data);
            res.forEach( r => { matches[r.ID] = r });
            load_tweets();
        })
    }

    function match_to_string(m) {
        return players[m.Att1].Nome + ", " + players[m.Dif1].Nome + " (10) - " + players[m.Att2].Nome + ", " + players[m.Dif2].Nome + " (" + m.Pt2 + ") - " + moment(m.Timestamp).format('DD/MM/Y HH:mm');
    }

    function parse_tweet(t, extra_info="") {
        // Check strings nature
        t.Author = t.Author.toString();
        t.Text = t.Text.toString();

        // Parse author rif to players
        t.Author = t.Author.replace(/(@\d+)/g, function(match) {
            id = parseInt( match.substr(1));
            if( players[id] ) return `
            <a href="/elo/player_stats.php?id=${id}" class="text-info">
                ${ players[id].Nome }
                <span class="badge badge-info">@${id}</span>
            </a>
            `;
            else return `
            <a  class="text-danger" data-toggle="tooltip" title="Giocatore non esistente">
                ${id}
            </a>
        `});

        // Parse text rif to players
        t.Text = t.Text.replace(/(@\d+)/g, function(match) {
            id = parseInt( match.substr(1));
            if( players[id] ) return `
            <a href="/elo/player_stats.php?id=${id}" class="text-info">
                ${ players[id].Nome }
                <span class="badge badge-info">@${id}</span>
            </a>
            `;
            else return `
            <a  class="text-danger" data-toggle="tooltip" title="Giocatore non esistente">
                ${id}
            </a>
        `});

        // Parse text rif to matches
        t.Text = t.Text.replace(/(#\d+)/g, function(match) {
            id = parseInt( match.substr(1));
            if( matches[id] ) return `
                <a  class="text-info">
                    ${match_to_string(matches[id])}
                <span class="badge badge-info">#${id}</span>
                </a>
            `;
            else return  `
                <a  class="text-danger" data-toggle="tooltip" title="Partita non esistente">
                    ${id}
                </a>
        `});
        
        // Delete button for the author
        var remove_div = "";
        if( t.HUID == huid )
            remove_div =  `
                <div class="card-footer">
                <button class="btn btn-danger float-right" onclick="remove_tweet(${t.ID})" id="btn_remove_${t.ID}">
                    <div class="spinner-border spinner-border-sm spinner_remove" role="status" id="spinner_remove_${t.ID}">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <i class=\"fas fa-trash\"></i>
                </button>
                </div>
        `;

        return `
        <div class="card mb-3 tweet" id="tweet_card_${t.ID}">
            <div class="card-header">
                <i class="fa fa-user"></i> ${ t.Author } ${extra_info} <span class="float-right"> ${  moment(t.Timestamp).format('DD/MM/Y, HH:mm') } <i class="fa fa-clock"></i></span>
            </div>
            <div class="card-body">
                ${ t.Text }
            </div>
            ${ remove_div }
        </div>
        `;
    }

    function load_tweets() {
        $('#more_button').hide();
        $('#spinner').show();

        var request = "../api/tweet.php";
        if( last_id > -1 ) request += "?below="+last_id;
        $.get(request, function(data) {
            // Parse result
            tweets = JSON.parse(data);

            tweets.forEach( function(t) {
                $('#end_of_tweets').before( parse_tweet(t) );
            });

            prepare_tweets();
        })
    }

    function prepare_tweets() {
        // Activate tooltips
        $("body").tooltip({ selector: '[data-toggle=tooltip]' });

        // Hide spinners
        $('.spinner_remove').hide();
        // Hiding loading spinner
        $('#spinner').hide();
        // Showing more_button
        if( tweets.length == 50 )
            $('#more_button').show();
    }

    function remove_tweet(tweet_id) {
        $(`#btn_remove_${tweet_id}`)[0].disabled = true;
        $(`#spinner_remove_${tweet_id}`).show();
        $.post("/api/tweet.php", {
            hide: true,
            id: tweet_id,
            uuid: get_uuid()
            }, function(data) {
                res = JSON.parse(data);
                if( res.success )
                    $(`#tweet_card_${res.id}`).remove();
                else alert("Errore. Prego ricaricare la pagina.");
            })
    }

    function post_tweet(event) {
        event.preventDefault();
        $('form')[0].classList.add('was-validated');
        if( $('form')[0].checkValidity() ) {
            $('#btn_save')[0].disabled = true;
            $('#spinner_save').show();
            $.post("/api/tweet.php", {
                add: true,
                author: $('#author_input')[0].value,
                text: $('#tweet_input')[0].value,
                huid: get_huid()
            }, saved_tweet);
        }
    }

    function saved_tweet(data) {
        res = JSON.parse(data);
        if( res.success ) {
            $('#btn_save')[0].disabled = false;
            $('#spinner_save').hide();
            $('form')[0].classList.remove('was-validated');
            $('form').after( parse_tweet(res,"<span class=\"alert alert-success\">NEW!</span>") );
            prepare_tweets();
            $(`#tweet_card_${res.ID}`)[0].classList.add("show");
            Cookies.set('last_author',$('#author_input')[0].value, { expires: 365 });
            $('#tweet_input')[0].value = "";
        }
    }

    function insert_tag(theid) {
        $('#tag_modal').modal('hide');
        $('#tweet_input')[0].value += "@" + theid;
    }

    $( document ).ready(load_players)

</script>

<div class="container justify-content-md-center col-md-7">
<form onsubmit="post_tweet(event)" novalidate>
<div class="card mb-3" id="tweet_card_new">
    <div class="card-header form-inline">
        <i class="fa fa-user"></i>
            <input type="text" class="form-control flex-fill mx-2" placeholder="Autore" id="author_input" minlength="3" required/>
        <span class="float-right"><script>document.write(moment().format('DD/MM/Y, HH:mm'));</script>  <i class="fa fa-clock"></i></span>
    </div>
    <div class="card-body">
        <textarea class="form-control" id="tweet_input" rows="5" placeholder="Tweet..." minlength="5" required></textarea>
        <!-- Puoi usare <i>@id</i> per nominare una persona, sostituendo <i>id</i> con l'ID visibile nella pagina personale della persona, oppure <i>#id</i> per collegare una partita. Usando <i>@id</i>, puoi anche firmarti nel campo <i>autore</i>. -->
    </div>
    <div class="card-footer">
        <button class="btn btn-info" id="btn_tag" type="button" onclick="$('#tag_modal').modal('show');">
            <i class="fas fa-at"></i>
        </button>
        <button class="btn btn-info float-right" id="btn_save" type="submit">
            <div class="spinner-border spinner-border-sm spinner_save" role="status" id="spinner_save">
                <span class="sr-only">Loading...</span>
            </div>
            <i class="fas fa-paper-plane"></i>
        </button>
    </div>
</div>
</form>

<div class="row justify-content-center" id="end_of_tweets">
    <div class="spinner-border" role="status" id="spinner">
        <span class="sr-only">Loading...</span>
    </div>
</div>
</div>
<div class="row justify-content-center" id="more_button">
    <button class="btn btn-success" onclick="load_tweets()"><i class="fas fa-plus-circle"></i> Carica altro</button>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="tag_modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Nomina un giocatore</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="tag_modal_list">
      </div>
    </div>
  </div>
</div>

<?php require("../template/footer.php"); ?>