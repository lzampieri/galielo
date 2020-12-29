<?php require("../template/header.php"); ?>

<script>
    var id1 = <?php echo $_GET["id1"] ?>;
    var id2 = <?php echo $_GET["id2"] ?>;
    var players = [];

    function load_players() {
        $.get("../api/player.php", function(data) {
            // Convert in array details
            JSON.parse(data).forEach( function(e) { players[e.ID] = e; })

            // Base details
            $('#name1').html(`<a href="player_stats.php?id=${id1}">${players[id1].Nome} <span class="badge badge-info">${id1}</span></a>`);
            $('#name2').html(`<a href="player_stats.php?id=${id2}">${players[id2].Nome} <span class="badge badge-info">${id2}</span></a>`);
            
            // Selected players always in bold
            players[id1].Nome = "<b>"+players[id1].Nome+"</b>"
            players[id2].Nome = "<b>"+players[id2].Nome+"</b>"

            // Load details for selected players
            load_couple_data()
        })
    }

    function load_couple_data() {
        $.get("../api/match.php", function(data) {
            // Parse result
            var matches = JSON.parse(data);

            // Matches counting
            var a1d2w = 0; // 1 att, 2 dif, win
            var a2d1w = 0; // 2 att, 1 dif, win
            var a1d2l = 0; // 1 att, 2 dif, lose
            var a2d1l = 0; // 2 att, 1 dif, lose
            var vs1w = 0; // 1 vs 2, win 1
            var vs2w = 0; // 1 vs 2, win 2
            matches = matches.filter( function(m) {
                if( m.Att1 == id1 && m.Dif1 == id2 ) a1d2w++;
                else if( m.Att1 == id2 && m.Dif1 == id1 ) a2d1w++;
                else if( m.Att2 == id1 && m.Dif2 == id2 ) a1d2l++;
                else if( m.Att2 == id2 && m.Dif2 == id1 ) a2d1l++;
                else if( ( m.Att1 == id1 || m.Dif1 == id1 ) && ( m.Att2 == id2 || m.Dif2 == id2 ) ) vs1w++;
                else if( ( m.Att1 == id2 || m.Dif1 == id2 ) && ( m.Att2 == id1 || m.Dif2 == id1 ) ) vs2w++;
                else return false;
                return true;
            });

            // Fill stats
            var sqtot = a1d2w + a2d1w + a1d2l + a2d1l;
            var sqw = a1d2w + a2d1w;
            $('#efficiency').html(`Efficienza <span class="badge badge-success">${ (sqw / sqtot * 100).toFixed(1) } %</span><br/><small>(${sqw} vittorie su ${sqtot})</small>`);
            $('#efficiency_bar').css('width', (sqw / sqtot * 100).toFixed(1) + "%")

            var a1d2 = a1d2w + a1d2l;
            var a2d1 = a2d1w + a2d1l;
            $('#conf1').html(`Attaccante ${players[id1].Nome}, Difensore ${players[id2].Nome}: <span class="badge badge-warning">${ (a1d2 / sqtot * 100).toFixed(1) } %</span><br/><small>(${a1d2} partite su ${sqtot})</small>`);
            $('#conf2').html(`Attaccante ${players[id2].Nome}, Difensore ${players[id1].Nome}: <span class="badge badge-info">${ (a2d1 / sqtot * 100).toFixed(1) } %</span><br/><small>(${a2d1} partite su ${sqtot})</small>`);
            $('#configurations_bar').css('width', (a1d2 / sqtot * 100).toFixed(1) + "%")

            $('#efficiency_1').html(`Efficienza <span class="badge badge-warning">${ (a1d2w / a1d2 * 100).toFixed(1) } %</span><br/><small>(${a1d2w} vittorie su ${a1d2})</small>`);
            $('#efficiency_bar_1').css('width', (a1d2w / a1d2 * 100).toFixed(1) + "%")

            $('#efficiency_2').html(`Efficienza <span class="badge badge-info">${ (a2d1w / a2d1 * 100).toFixed(1) } %</span><br/><small>(${a2d1w} vittorie su ${a2d1})</small>`);
            $('#efficiency_bar_2').css('width', (a2d1w / a2d1 * 100).toFixed(1) + "%")

            $('#versus').html(`${players[id1].Nome} <span class="badge badge-warning">${vs1w}</span> - ${players[id2].Nome} <span class="badge badge-info">${vs2w}</span>`);
            $('#versus_bar').css('width', ( vs1w / (vs1w + vs2w) * 100).toFixed(1) + "%")

            // Match list
            var skull = "  <i class=\"fas fa-skull\"></i>"
            $('#match_list').DataTable({
                data: matches.map( function(m) {return ( {
                    date: new Date(m.Timestamp),
                    winners: "<a href=\"couple_stats.php?id1=" + m.Att1 + "&id2=" + m.Dif1 + "\">" + players[m.Att1].Nome + "(" + m.VarA1 + ") - " + players[m.Dif1].Nome + " (" + m.VarD1 + ")</a>",
                    losers:  "<a href=\"couple_stats.php?id1=" + m.Att2 + "&id2=" + m.Dif2 + "\">" + players[m.Att2].Nome + " (" + m.VarA2 + ") - " + players[m.Dif2].Nome + " (" + m.VarD2 + ")</a>",
                    points: m.Pt1.toString() + " - " + m.Pt2 + ( m.Pt2 == 0 ? skull : "" )
                })}),
                columns: [
                    { data: 'date' },
                    { data: 'winners' },
                    { data: 'losers' },
                    { data: 'points' }
                ],
                columnDefs: [ {
                    targets: 0,
                    render: $.fn.dataTable.render.moment( 'DD/MM/Y, HH:mm' )
                },{
                    targets: [0,3],
                    className: 'not-mobile'
                },{
                    targets: [1,2],
                    className: 'all'
                } ],        
                paging:   true,
                ordering: true,
                info:     true,
                fixedHeader: true,
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.childRowImmediate,
                        type: 'none',
                    }
                },
                order: [[ 0, "desc" ]],
                bLengthChange: false,
                pageLength: 25,
                oLanguage: {
                    sSearch: "Cerca: ",
                    oPaginate: {
                        sPrevious: "Indietro",
                        sNext: "Avanti"
                    },
                    sInfo: "Da _START_ a _END_ di _TOTAL_ partite",
                    sInfoFiltered: "(filtrate da _MAX_ totali)",
                    sInfoEmpty: "",
                    sZeroRecords: "Nessun risultato",
                    sEmptyTable: "Nessuna partita",
                    sInfoThousands: "'"
                },
                initComplete: function() {$('#spinner').hide()}
            })
        })
    }

    $( document ).ready(load_players)

</script>

<div class="row justify-content-center mb-3">
    <div class="card text-center col-md-6">
        <div class="card-header">
            <h4 id="name1">
            <h4 id="name2">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            </h4>
        </div>
        <div class="card-body">
            <h4 class="card-title">Squadra</h4>
            <p id="efficiency" />
            <div class="progress bg-danger">
                <div class="progress-bar bg-success" role="progressbar" style="width: 0%" id="efficiency_bar"></div>
            </div>
            <h4 class="card-title mt-3">Configurazioni</h4>
            <ol>
                <li id="conf1" />
                <li id="conf2" />
            </ol>
            <p id="configurations" />
            <div class="progress bg-info">
                <div class="progress-bar bg-warning" role="progressbar" style="width: 0%" id="configurations_bar"></div>
            </div> 
            <h4 class="card-title mt-3">Configurazione 1</h4>
            <p id="efficiency_1" />
            <div class="progress bg-danger">
                <div class="progress-bar bg-success" role="progressbar" style="width: 0%" id="efficiency_bar_1"></div>
            </div>
            <h4 class="card-title my-3">Configurazione 2</h4>
            <p id="efficiency_2" />
            <div class="progress bg-danger">
                <div class="progress-bar bg-success" role="progressbar" style="width: 0%" id="efficiency_bar_2"></div>
            </div>
            <hr/>
            <h4 class="card-title">Sfide</h4>
            <p id="versus" />
            <div class="progress bg-info">
                <div class="progress-bar bg-warning" role="progressbar" style="width: 0%" id="versus_bar"></div>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-md-center mb-3">
    <table class="table table-striped table-hover" id="match_list" style="width:100%">
        <thead>
            <tr>
                <th scope="col">Data</th>
                <th scope="col">Vincitori</th>
                <th scope="col">Perdenti</th>
                <th scope="col">Punteggio</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<?php require("../template/footer.php"); ?>