<?php require("../template/header.php"); ?>

<script>
    var players = [];

    function load_players() {
        $.get("../api/player.php", function(data) {
            // Convert in array details
            JSON.parse(data).forEach( function(e) { players[e.ID] = e; })

            // Load matches
            load_ccup()
        })
    }

    async function load_ccup() {
        $.get("../api/ccup.php", function(data) {
            // Parse result
            var ccups = JSON.parse(data);
            ccups = ccups.filter( m => m.Hidden == 0 );

            // Currents
            $('#att').html(players[ccups[0].Att].Nome);
            $('#dif').html(players[ccups[0].Dif].Nome);
            $('#date').html("Da "+ moment().diff(moment(ccups[0].TimeP1),'hours') + " ore<br/>Vinta il " + moment(ccups[0].TimeP1).format('DD/MM/Y, HH:mm'))

            // CCup list
            $('#ccup_list').DataTable({
                data: ccups.map( function(m) {return ( {
                    date: new Date(m.TimeP1),
                    att: players[m.Att].Nome,
                    dif: players[m.Dif].Nome,
                    points: "10-" + m.PtP1 + ", 10-" + m.PtP2
                })}),
                columns: [
                    { data: 'date' },
                    { data: 'att' },
                    { data: 'dif' },
                    { data: 'points' }
                ],
                columnDefs: [  {
                    targets: 0,
                    render: $.fn.dataTable.render.moment( 'DD/MM/Y, HH:mm' )
                }, {
                    targets: [3],
                    className: 'not-mobile'
                },{
                    targets: [1,2],
                    className: 'all'
                }],        
                paging:   true,
                ordering: false,
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
                    sInfo: "Da _START_ a _END_ di _TOTAL_ assegnazioni",
                    sInfoFiltered: "(filtrate da _MAX_ totali)",
                    sInfoEmpty: "",
                    sZeroRecords: "Nessun risultato",
                    sEmptyTable: "Nessuna assegnazione",
                    sInfoThousands: "'"
                },
                initComplete: function() {$('#spinner').hide()}
            }).draw();

            // Stats
            // Owning time per person
            count_time = players.map( p => ( {
                label: p.Nome,
                y: 0
            } ) );
            for( i = 1; i < ccups.length; i++ ) {
                timediff = moment( ccups[i - 1].TimeP1 ).diff( moment( ccups[i].TimeP1 ), 'hours' );
                count_time[ ccups[i].Att ].y += timediff;
                count_time[ ccups[i].Dif ].y += timediff; 
            }
            timediff = moment().diff( moment( ccups[0].TimeP1 ), 'hours' );
            count_time[ ccups[0].Att ].y += timediff;
            count_time[ ccups[0].Dif ].y += timediff;

            const timeOrdered = function (a, b) { return b.y - a.y };
            console.log(count_time);
            count_time_cut = count_time.sort(timeOrdered).slice(0,10);
            new CanvasJS.Chart("hours_of_possession", {
                theme: "light1",
                animationEnabled: true,
                exportEnabled: false,
                axisY: {
                    title: "Possesso (in ore)",
                    includeZero: true,
                },
                data: [{
                    type: "bar",
                    indexLabel: "{y}",
                    dataPoints: count_time_cut
                }]
            }).render();
        })
    }

    $( document ).ready(load_players)

</script>

<div class="row justify-content-center mb-3">
    <div class="card text-center col-md-6">
        <div class="card-header">
            <h3>Attuali detentori</h3>
        </div>
        <div class="card-body">
            <h4 class="card-title" id="att"></h4>
            <h4 class="card-title" id="dif"></h4>
            <p id="date"></p>
            <div class="spinner-border" role="status" id="spinner">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center mt-3">
    <h3>Possessori più duraturi</h3>
</div>
<div class="row justify-content-center mb-3">
    <div class="col-md-8" id="hours_of_possession" style="height: 370px;"></div>
</div>

<div class="row justify-content-center mt-3">
    <h3>Precedenti</h3>
</div>
<div class="row justify-content-md-center mb-3">
    <table class="table table-striped table-hover" id="ccup_list" style="width:100%">
        <thead>
            <tr>
                <th scope="col">Data</th>
                <th scope="col">Attaccante</th>
                <th scope="col">Difensore</th>
                <th scope="col">Punteggi</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>


<?php require("../template/footer.php"); ?>