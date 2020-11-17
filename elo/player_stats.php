<?php require("../template/header.php"); ?>

<script>
    var id = <?php echo $_GET["id"] ?>;
    var players = [];

    function load_players() {
        $.get("../api/player.php", function(data) {
            // Convert in array details
            JSON.parse(data).forEach( e => { players[e.ID] = e; })
            
            // Selected player always in bold
            players[id].Nome = "<b>"+players[id].Nome+"</b>"

            // Load details for selected players
            load_player_data()
        })
    }

    // For hidding series on points graph
    function toggleDataSeries(e){
        if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
            e.dataSeries.visible = false;
        }
        else{
            e.dataSeries.visible = true;
        }
        e.chart.render();
    }

    function load_player_data() {
        $.get("../api/player.php?id="+id, function(data) {

            // Base details
            var player_details = JSON.parse(data);
            $('#name').html(`${player_details["Nome"]} <span class="badge badge-info">${id}</span>`);
            $('#points').html(0.5 * (player_details["PuntiA"] + player_details["PuntiD"]));
            $('#pointsA').html(player_details["PuntiA"]);
            $('#pointsD').html(player_details["PuntiD"]);

            // Counts matches
            winA = 0
            winD = 0
            losA = 0
            losD = 0
            winwith = []
            totwith = []
            pointsD = []
            pointsA = []
            pointsT = []
            countPointsA = player_details["PuntiA"]
            countPointsD = player_details["PuntiD"]
            player_details.matches.forEach(function(match) {
                pointsD.push( {x: new Date(match.Timestamp), y: countPointsD })
                pointsA.push( {x: new Date(match.Timestamp), y: countPointsA })
                pointsT.push( {x: new Date(match.Timestamp), y: 0.5*(countPointsA+countPointsD) })
                if( match.Att1 == id ) {
                    winA += 1
                    winwith.push(match.Dif1)
                    totwith.push(match.Dif1)
                    countPointsA -= match.VarA1
                } else if( match.Dif1 == id ) {
                    winD += 1
                    winwith.push(match.Att1)
                    totwith.push(match.Att1)
                    countPointsD -= match.VarD1
                } else if( match.Att2 == id ) {
                    losA += 1
                    totwith.push(match.Dif2)
                    countPointsA -= match.VarA2
                } else if( match.Dif2 == id ) {
                    losD += 1
                    totwith.push(match.Att2)
                    countPointsD -= match.VarA2
                }
            })
            
            $("#ratioA").html( `${winA} vinte su ${winA+losA} <span class="badge badge-secondary">${(winA/(winA+losA)*100).toFixed(0)}%</span>` )
            $("#ratioD").html( `${winD} vinte su ${winD+losD} <span class="badge badge-secondary">${(winD/(winD+losD)*100).toFixed(0)}%</span>` )
            $("#ratioT").html( `${winA+winD} vinte su ${winA+losA+winD+losD} <span class="badge badge-secondary">${((winA+winD)/(winD+losD+winA+losA)*100).toFixed(0)}%</span>` )

            // Sort and select first _cutoff_ players, adding "other" field
            const sumOf = (array) => { sum=0; array.forEach( x => sum+= x.y ); return sum; };
            const compare = (a, b) => b.y - a.y;
            winwith = _.countBy(winwith)
            totwith = _.countBy(totwith)

            allwith = Object.keys(totwith).map( key => ({ name: players[key].Nome, tot: totwith[key], win: ( key in winwith ? winwith[key] : 0)}))

            cutoff = Math.min( 8, Object.keys(totwith).length, Object.keys(winwith).length)
            winwith_cut = Object.keys(winwith).map( key => ({ label: players[key].Nome, y: winwith[key] })).sort(compare).slice(0,cutoff)
            totwith_cut = Object.keys(totwith).map( key => ({ label: players[key].Nome, y: totwith[key] })).sort(compare).slice(0,cutoff)

            winwith_cut[cutoff] = { label: "Altri", y: winA + winD - sumOf(winwith_cut)}
            totwith_cut[cutoff] = { label: "Altri", y: winA + winD + losA + losD - sumOf(totwith_cut)}

            // Friend chart
            new CanvasJS.Chart("friends_chart", {
                theme: "light2",
                exportEnabled: false,
                animationEnabled: false,
                title: {
                    text: "Compagno di gioco preferito"
                },
                data: [{
                    type: "pie",
                    startAngle: 25,
                    toolTipContent: "<b>{label}</b>: {y}",
                    showInLegend: "true",
                    legendText: "{label}",
                    indexLabelFontSize: 16,
                    indexLabel: "{label} - {y}",
                    dataPoints: totwith_cut
                }]
            }).render();

            // Friend chart win
            new CanvasJS.Chart("friends_chart_win", {
                theme: "light2",
                exportEnabled: false,
                animationEnabled: false,
                title: {
                    text: "Compagno di gioco preferito, sulle vittorie."
                },
                data: [{
                    type: "pie",
                    startAngle: 25,
                    toolTipContent: "<b>{label}</b>: {y}",
                    showInLegend: "true",
                    legendText: "{label}",
                    indexLabelFontSize: 16,
                    indexLabel: "{label} - {y}",
                    dataPoints: winwith_cut
                }]
            }).render();

            // Friend chart list
            $('#friend_chart_list').DataTable({
                data: allwith,
                columns: [
                    { data: 'name' },
                    { data: 'tot' },
                    { data: 'win' }
                ],
                paging:   false,
                ordering: true,
                info:     false,
                order: [[ 1, "desc" ]],
                searching: false
            })
            
            // Points chart
            new CanvasJS.Chart("points_trend", {
                theme: "light2",
                exportEnabled: false,
                animationEnabled: true,
                zoomEnabled: true,
                zoomType: "x",
                title: {
                    text: "Andamento del punteggio"
                },
                axisX: {
                    valueFormatString: "MMM YY",
		            labelAngle: -30
                },
                legend:{
                    cursor: "pointer",
                    itemclick: toggleDataSeries
                },
                data: [{
                    name: "Attacco",
                    type: "spline",
		            markerType: "none",
                    showInLegend: true,
                    dataPoints: pointsA
                }, {
                    name: "Difesa",
                    type: "spline",
		            markerType: "none",
                    showInLegend: true,
                    dataPoints: pointsD
                }, {
                    name: "Totale",
                    type: "spline",
		            markerType: "none",
                    showInLegend: true,
                    dataPoints: pointsT
                } ]
            }).render();

            // Match list
            $('#match_list').DataTable({
                data: player_details.matches.map( m => ( {
                    date: new Date(m.Timestamp),
                    winners: players[m.Att1].Nome + " (" + m.VarA1 + ") - " + players[m.Dif1].Nome + " (" + m.VarD1 + ")",
                    losers: players[m.Att2].Nome + " (" + m.VarA2 + ") - " + players[m.Dif2].Nome + " (" + m.VarD2 + ")",
                    points: m.Pt1.toString() + " - " + m.Pt2
                })),
                columns: [
                    { data: 'date' },
                    { data: 'winners' },
                    { data: 'losers' },
                    { data: 'points' }
                ],
                columnDefs: [ {
                    targets: 0,
                    render: $.fn.dataTable.render.moment( 'DD/MM/Y, HH:mm' )
                } ],        
                paging:   true,
                ordering: true,
                info:     true,
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
                }
            })

        })
    }

    $( document ).ready(load_players)

</script>

<div class="row justify-content-center mb-3">
    <div class="card text-center col-md-6">
        <div class="card-header">
            <h4 id="name">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            </h4>
            <h4 id="points" />
            <h6 id="ratioT" />
        </div>
        <div class="card-body">
            <h5 class="card-title">Attacco</h5>
            <p id="pointsA" />
            <p id="ratioA" />
            <hr>
            <h5 class="card-title">Difesa</h5>
            <p id="pointsD" />
            <p id="ratioD" />
        </div>
    </div>
</div>

<div class="row justify-content-center mb-3">
    <div class="col-md-8" id="friends_chart" style="height: 370px;"></div>
</div>

<div class="row justify-content-center mb-3">
    <div class="col-md-8" id="friends_chart_win" style="height: 370px;"></div>
</div>
<div class="row justify-content-center mb-3">
    <a class="btn btn-primary" data-toggle="collapse" href="#friend_chart_collapse" role="button" aria-expanded="false" aria-controls="friend_chart_collapse">
        Mostra dati
    </a>
</div>
<div class="row justify-content-center mb-3">
    <div class="justify-content-center collapse" id="friend_chart_collapse">
        <table class="table table-striped table-hover" id="friend_chart_list">
            <thead>
                <tr>
                    <th scope="col">Compagno</th>
                    <th scope="col">Partite</th>
                    <th scope="col">Vittorie</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<div class="row justify-content-center mb-3">
    <div class="col-md-8" id="points_trend" style="height: 370px;"></div>
</div>

<div class="row justify-content-center mb-b">
    <table class="table table-striped table-hover" id="match_list">
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