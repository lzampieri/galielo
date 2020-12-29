<?php require("../template/header.php"); ?>

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

        $.get('../api/player.php', function(data) {
            res = JSON.parse(data);
            res.forEach( r => { players[r.ID] = r });
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
        // Parse author rif to players
        t.Author = t.Author.replace(/(@\d+)/g, function(match) {
            id = parseInt( match.substr(1));
            if( players[id] ) return `
            <a href="/elo/player_stats.php?id=${id}" class="text-info" data-toggle="tooltip" title="${id}">
                ${ players[id].Nome }
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
            <a href="/elo/player_stats.php?id=${id}" class="text-info" data-toggle="tooltip" title="${id}">
                ${ players[id].Nome }
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
                <a  class="text-success" data-toggle="tooltip" title="${match_to_string(matches[id])}">
                    ${id}
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
        }
    }

    $( document ).ready(load_players)

</script>

<div class="container justify-content-md-center col-md-7">
<form onsubmit="post_tweet(event)" novalidate>
<div class="card mb-3" id="tweet_card_new">
    <div class="card-header form-inline">
        <i class="fa fa-user"></i> <input type="text" class="form-control flex-fill mx-2" placeholder="Autore" id="author_input" minlength="3" required/>
        <span class="float-right"><script>document.write(moment().format('DD/MM/Y, HH:mm'));</script>  <i class="fa fa-clock"></i></span>
    </div>
    <div class="card-body">
        <textarea class="form-control" id="tweet_input" rows="5" placeholder="Tweet..." minlength="5" required></textarea>
        Puoi usare <i>@id</i> per nominare una persona, sostituendo <i>id</i> con l'ID visibile nella pagina personale della persona, oppure <i>#id</i> per collegare una partita. Usando <i>@id</i>, puoi anche firmarti nel campo <i>autore</i>.
    </div>
    <div class="card-footer">
        <button class="btn btn-success float-right" id="btn_save">
            <div class="spinner-border spinner-border-sm spinner_save" role="status" id="spinner_save">
                <span class="sr-only">Loading...</span>
            </div>
            <i class="fas fa-trash"></i>
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

<?php require("../template/footer.php"); ?>