<?php require("../template/header.php"); ?>
<script>
    var datatable = 0
    var state = 'T'
    var sleepers = false

    // Get params
    <?php require_once("../api/utilities.php"); ?>
    var active_threshold = <?php echo get_game_param("active_threshold"); ?>;
    var crown_threshold = <?php echo get_game_param("crown_threshold"); ?>;
    var blender_threshold = <?php echo get_game_param("blender_threshold"); ?>;

    function load_players() {
        $.get("../api/player.php", function(data) {
            // Convert in array details
            players = JSON.parse(data)

            // Funny icons
            var bed = "  <i class=\"fas fa-bed\"></i>"
            var crown = "  <i class=\"fas fa-crown\"></i>"
            var blender = "  <i class=\"fas fa-blender\"></i>"

            // Renderers
            function render_points ( data, type, row ) {
                return data.toString() + ( data > crown_threshold ? crown : "") + ( data < blender_threshold ? blender : "");
            }
            function render_matches ( data, type, row ) {
                return data.toString() + ( data < active_threshold ? bed : "");
            }


            // Players list
            datatable = $('#players_list').DataTable({
                data: players.map( function(p) {return ( {
                    label: "<a href=\"player_stats.php?id=" + p.ID + "\">" + p.Nome + "</a>",
                    ptT: 0.5 * ( p.PuntiA + p.PuntiD ),
                    ptA: p.PuntiA,
                    ptD: p.PuntiD,
                    matchT: p.CountA + p.CountD,
                    matchA: p.CountA,
                    matchD: p.CountD,
                    recentT: p.CountRecentA + p.CountRecentD,
                    recentA: p.CountRecentA,
                    recentD: p.CountRecentD
                })}),
                columns: [
                    { data: 'label' },
                    { data: 'ptT' },
                    { data: 'matchT' },
                    { data: 'recentT' },
                    { data: 'ptA' },
                    { data: 'matchA' },
                    { data: 'recentA' },
                    { data: 'ptD' },
                    { data: 'matchD' },
                    { data: 'recentD' },
                ],
                columnDefs: [ {
                    targets: [1, 4, 7],
                    render: render_points
                }, {
                    targets: [3, 6, 9],
                    render: render_matches
                }, {
                    targets: [1, 2, 3],
                    className: 'T'
                },{
                    targets: [4, 5, 6],
                    className: 'A'
                },{
                    targets: [7, 8, 9],
                    className: 'D'
                } ],        
                paging:   false,
                ordering: true,
                info:     true,
                fixedHeader: true,
                // responsive: {
                //     details: {
                //         display: $.fn.dataTable.Responsive.display.childRowImmediate,
                //         type: 'none',
                //     }
                // },
                order: [[ 1, "desc" ]],
                bLengthChange: false,
                oLanguage: {
                    sSearch: "Cerca: ",
                    oPaginate: {
                        sPrevious: "Indietro",
                        sNext: "Avanti"
                    },
                    sInfo: "_TOTAL_ giocatori",
                    sInfoFiltered: "(filtrati da _MAX_ totali)",
                    sInfoEmpty: "",
                    sZeroRecords: "Nessun risultato",
                    sEmptyTable: "Nessuna partita",
                    sInfoThousands: "'"
                },
                initComplete: function() {
                    $('#spinner').hide()
                    $.fn.dataTable.ext.search.push(search_filter)
                }
            })
            
            select_rows(false)
            select_columns('T')
        })
    }

    function select_columns(c) {
        state = c
        if( datatable ) {
            datatable.columns('.T').visible( state == 'T' )
            datatable.columns('.D').visible( state == 'D' )
            datatable.columns('.A').visible( state == 'A' )
            index = { 'T': 1, 'A': 4, 'D': 7 }
            datatable.order( [ index[state], 'desc'] )
            datatable.draw()
        } 
        $('.sel').prop('disabled', false)
        $('.sel'+state).prop('disabled', true)
    }

    function select_rows(sleep) {
        sleepers = sleep
        $('.act').prop('disabled', false)
        $('.act'+(sleep ? 'T' : 'A')).prop('disabled', true)
        datatable.draw()
    }

    function search_filter(settings, data, dataIndex) {
        index = { 'T': 3, 'A': 6, 'D': 9 }
        if( data[ index[ state ] ] > <?php echo get_game_param("active_threshold"); ?> || sleepers ) {
            return true;
        }
        return false;
    }

    $( document ).ready(load_players)

</script>

<div class="alert alert-primary" role="alert">
    Hey! Vuoi uno spoiler sul nuovo sito del galielo, in fase di sviluppo? <a href="http://lzampieri.altervista.org/galielo">Eccolo qui!</a>
</div>

<div class="alert alert-primary" role="info">
    24h? <a href="../24h">24h!</a>
</div>

<div
 class="row justify-content-end mb-3">
    <a href="add_player.php"><button class="btn btn-success"><i class="fas fa-plus-circle"></i> Iscriviti</button></a>
    <a href="add_match.php"><button class="btn btn-success"><i class="fas fa-plus-circle"></i> Aggiungi</button></a>
</div>

<div class="row justify-content-end mb-3">
    <button class="btn btn-success sel selT" onClick="select_columns('T')">Tutto</button>
    <button class="btn btn-success sel selA" onClick="select_columns('A')">Attacco</button>
    <button class="btn btn-success sel selD" onClick="select_columns('D')">Difesa</button>
</div>
<div class="row justify-content-end mb-3">
    <button class="btn btn-success act actT" onClick="select_rows(true)">Tutti</button>
    <button class="btn btn-success act actA" onClick="select_rows(false)">Attivi</button>
</div>

<div class="row justify-content-md-center mb-3">
    <table class="table table-striped table-hover" id="players_list" style="width:100%">
        <thead>
            <tr>
                <th scope="col">Nome</th>
                <th scope="col">Punti</th>
                <th scope="col">Partite totali</th>
                <th scope="col">Partite ultimo mese</th>
                <th scope="col">Punti (A)</th>
                <th scope="col">Partite totali (A)</th>
                <th scope="col">Partite ultimo mese (A)</th>
                <th scope="col">Punti (D)</th>
                <th scope="col">Partite totali (D)</th>
                <th scope="col">Partite ultimo mese (D)</th>
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