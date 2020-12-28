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

    function load_tweets() {
        $('#more_button').hide();
        $('#spinner').show();

        var request = "../api/tweet.php";
        if( last_id > -1 ) request += "?below="+last_id;
        $.get(request, function(data) {
            // Parse result
            tweets = JSON.parse(data);

            tweets.forEach( function(t) {
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

                $('#end_of_tweets').before(`
                <div class="card mb-3 tweet" id="tweet_card_${t.ID}">
                    <div class="card-header">
                        <i class="fa fa-user"></i> ${ t.Author } <span class="float-right"> ${  moment(t.Timestamp).format('DD/MM/Y, HH:mm') } <i class="fa fa-clock"></i>
                    </div>
                    <div class="card-body">
                        ${ t.Text }
                    </div>
                    ${ remove_div }
                </div>
                `);
            })

            // Activate tooltips
            $("body").tooltip({ selector: '[data-toggle=tooltip]' });

            // Hide spinners
            $('.spinner_remove').hide();
            // Hiding loading spinner
            $('#spinner').hide();
            // Showing more_button
            if( tweets.length == 50 )
                $('#more_button').show();
        })
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

    $( document ).ready(load_players)

</script>

<div class="container justify-content-md-center col-md-7">
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