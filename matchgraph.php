<?php
if(!isset($id)) {
	exit();
	}
?>
<div align="center"  class="width70">
<script>
window.onload = function() {
	
var dataAtt = [];
var dataDif = [];

	
<?php 
require_once("script/utilities.php");
$result = query("SELECT * FROM giocatori WHERE ID = $id");
if(mysqli_num_rows($result) != 1) {
	header("location: index.php");
	exit();
}
$gioc = mysqli_fetch_assoc($result);
echo "dataAtt.push({x: new Date(".time()."000),y: ".$gioc["PuntiA"]."});\n";
echo "dataDif.push({x: new Date(".time()."000),y: ".$gioc["PuntiD"]."});\n";
$result = query("SELECT TIMESTAMPDIFF(SECOND, '1970-01-01 0:00:00',  Timestamp)-7200 AS Time, VarA1 AS var FROM partite WHERE Att1 = $id UNION SELECT TIMESTAMPDIFF(SECOND,'1970-01-01 0:00:00', Timestamp)-7200 AS Time, VarA2 AS var FROM partite WHERE Att2 = $id ORDER BY Time DESC");
while( $row = mysqli_fetch_assoc($result) ) {
	echo "dataAtt.push({x: new Date(".$row["Time"]."000),y: ".$gioc["PuntiA"]."});\n";
	$gioc["PuntiA"] -= $row["var"];
}
$result = query("SELECT TIMESTAMPDIFF(SECOND, '1970-01-01 0:00:00',  Timestamp)-7200 AS Time, VarD1 AS var FROM partite WHERE Dif1 = $id UNION SELECT TIMESTAMPDIFF(SECOND,'1970-01-01 0:00:00', Timestamp)-7200 AS Time, VarD2 AS var FROM partite WHERE Dif2 = $id ORDER BY Time DESC");
while( $row = mysqli_fetch_assoc($result) ) {
	echo "dataDif.push({x: new Date(".$row["Time"]."000),y: ".$gioc["PuntiD"]."});\n";
	$gioc["PuntiD"] -= $row["var"];
}

?>
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2",
	zoomEnabled: true,
	zoomType: "xy",
	axisY: {
		title: "Punti",
		titleFontSize: 24,
		includeZero: false
	},
	axisX: {
		valueFormatString: "D MMM",
		labelAngle: -30
		},
	data: [{
		type: "spline",
		markerType: "none",
		showInLegend: true, 
		legendText: "Attacco",
		dataPoints: dataAtt
	},{
		type: "spline",
		markerType: "none",
		showInLegend: true,
		legendText: "Difesa",
		dataPoints: dataDif
	}]
});
	
	chart.render();

 
}
</script>

<div id="chartContainer" style="height: 370px; width: 100%;"></div>

<script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
<script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>

Seleziona un'area del grafico per ingrandirla.
</div>