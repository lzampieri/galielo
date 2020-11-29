<?php require("../template/header.php"); ?>

<script>
    var players = [];

    function load_players() {
        $.get("../api/player.php", function(data) {
            // Convert in array details
            JSON.parse(data).forEach( function(e) { players[e.ID] = e; })

            // Load matches
            load_matches()
        })
    }

    function load_matches() {
        $.get("../api/match.php", function(data) {
            // Parse result
            var matches = JSON.parse(data);

            // Funny icons
            var skull = "  <i class=\"fas fa-skull\"></i>"

            // Match list
            $('#match_list').DataTable({
                data: matches.map( function(m) {return ( {
                    date: new Date(m.Timestamp),
                    winners: "<a href=\"player_stats.php?id=" + m.Att1 + "\">" + players[m.Att1].Nome + "</a> (" + m.VarA1 + ") - <a href=\"player_stats.php?id=" + m.Dif1 + "\">" + players[m.Dif1].Nome + "</a> (" + m.VarD1 + ")",
                    losers:  "<a href=\"player_stats.php?id=" + m.Att2 + "\">" + players[m.Att2].Nome + "</a> (" + m.VarA2 + ") - <a href=\"player_stats.php?id=" + m.Dif2 + "\">" + players[m.Dif2].Nome + "</a> (" + m.VarD2 + ")",
                    points: m.Pt1.toString() + " - " + m.Pt2 + ( m.Pt2 == 0 ? skull : "")
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

<div class="row justify-content-end mb-3">
    <a href="add_match.php"><button class="btn btn-success"><i class="fas fa-plus-circle"></i> Aggiungi</button></a>
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
    <div class="spinner-border" role="status" id="spinner">
        <span class="sr-only">Loading...</span>
    </div>
</div>
<?php require("../template/footer.php"); ?>