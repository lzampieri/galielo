<?php require("../template/header.php"); ?>

<script>
    var id = <?php echo $_GET["id"] ?>;
    var players = [];

    function load_players() {
        $.get("../api/player.php", function(data) {
            // Convert in array details
            JSON.parse(data).forEach( e => { players[e.ID] = e; })
            load_player_data()
        })
    }

    function load_player_data() {
        $.get("../api/player.php?id="+id, function(data) {

            // Base details
            var player_details = JSON.parse(data);
            $('#name').html(player_details["Nome"]);
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
            player_details.matches.forEach(function(match) {
                if( match.Att1 == id ) {
                    winA += 1
                    winwith.push(match.Dif1)
                    totwith.push(match.Dif1)
                } else if( match.Dif1 == id ) {
                    winD += 1
                    winwith.push(match.Att1)
                    totwith.push(match.Att1)
                } else if( match.Att2 == id ) {
                    losA += 1
                    totwith.push(match.Dif2)
                } else if( match.Dif2 == id ) {
                    losD += 1
                    totwith.push(match.Att2)
                }
            })
            
            $("#ratioA").html( `${winA} vinte su ${winA+losA} <span class="badge badge-secondary">${(winA/(winA+losA)*100).toFixed(0)}%</span>` )
            $("#ratioD").html( `${winD} vinte su ${winD+losD} <span class="badge badge-secondary">${(winD/(winD+losD)*100).toFixed(0)}%</span>` )
            $("#ratioT").html( `${winA+winD} vinte su ${winA+losA+winD+losD} <span class="badge badge-secondary">${((winA+winD)/(winD+losD+winA+losA)*100).toFixed(0)}%</span>` )

            // Sort and select first _cutoff_ players, adding "other" field
            cutoff = 8
            const sumOf = (array) => { sum=0; array.forEach( x => sum+= x.y ); return sum; };
            const compare = (a, b) => b.y - a.y;
            winwith = _.countBy(winwith)
            winwith = Object.keys(winwith).map( key => ({ label: players[key].Nome, y: winwith[key] })).sort(compare).slice(0,cutoff)
            winwith[cutoff] = { label: "Altri", y: winA + winD - sumOf(winwith)}
            totwith = _.countBy(totwith)
            totwith = Object.keys(totwith).map( key => ({ label: players[key].Nome, y: totwith[key] })).sort(compare).slice(0,cutoff)
            totwith[cutoff] = { label: "Altri", y: winA + winD + losA + losD - sumOf(totwith)}

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
                    dataPoints: totwith
                }]
            }).render();

            // Friend chart
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
                    dataPoints: winwith
                }]
            }).render();

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
<?php require("../template/footer.php"); ?>