<script type="text/javascript">
function openPage(evt, param) {
	var pages;
    pages = document.getElementsByClassName("page");
    for (i = 0; i < pages.length; i++) {
        pages[i].style.display = "none";
    }
    thispage = document.getElementsByClassName("page-"+param);
	for (i = 0; i < thispage.length; i++) {
        thispage[i].style.display = "";
    }
	if(evt != null) {
		buttons = document.getElementsByClassName("select-button");
		for (i = 0; i < buttons.length; i++) {
			buttons[i].className = buttons[i].className.replace(" w3-red", "");
		}
		evt.currentTarget.className += " w3-red";
	}
}

oldonload = window.onload;

function start() {
	openPage(null,"0");
	oldonload();
}

window.onload = start;
</script>

<?php
require_once("script/utilities.php");

function b($cid,$id) {
	if((int)$cid == (int)$id)
		return "<b>";
	return "";
}


function nb($cid,$id) {
	if((int)$cid == (int)$id)
		return "</b>";
	return "";
}

if(isset($id))
$result = query("SELECT p.*, a1.Nome as a1Name, a2.Nome as a2Name, d1.Nome as d1Name, d2.Nome as d2Name FROM partite AS p JOIN giocatori AS a1 ON a1.ID = Att1 JOIN giocatori AS a2 ON a2.ID = Att2 JOIN giocatori AS d1 ON d1.ID = Dif1 JOIN giocatori AS d2 ON d2.ID = Dif2 WHERE a1.ID = $id OR a2.ID = $id OR d1.ID = $id OR d2.ID = $id ORDER BY Timestamp DESC");
else {
	$result = query("SELECT p.*, a1.Nome as a1Name, a2.Nome as a2Name, d1.Nome as d1Name, d2.Nome as d2Name FROM partite AS p JOIN giocatori AS a1 ON a1.ID = Att1 JOIN giocatori AS a2 ON a2.ID = Att2 JOIN giocatori AS d1 ON d1.ID = Dif1 JOIN giocatori AS d2 ON d2.ID = Dif2 ORDER BY Timestamp DESC");
	$id = -1;
}
?>
<div align="center">
<?php
require("allerrors.php");
?>
	<table class="w3-card-4 w3-table-all width60">
    <thead>
    <tr class="w3-light-grey"> 
    	<th>Data</th>
        <th>Vincitori</th>
        <th>Perdenti</th>
        <th>Punteggio</th>
        <th></th>
    </tr>
    </thead>
    <?php
	$first = ($id >= 0 ? false : true);
	$count = 0;
	$pgcount = 0;
	while( $row = mysqli_fetch_assoc($result) ) {
		$count+=1;
		if($count == 25) {
			$count = 0;
			$pgcount+=1;
		}
	?>
    <tr <?php echo "class=\"page-$pgcount page\""; ?> >
    	<td><?php echo $row["Timestamp"]; ?></td>
        <td><?php echo b($row["Att1"],$id).$row["a1Name"].nb($row["Att1"],$id)." (+".$row["VarA1"]."), ".b($row["Dif1"],$id).$row["d1Name"].nb($row["Dif1"],$id)." (+".$row["VarD1"].")"; ?></td>
        <td><?php echo b($row["Att2"],$id).$row["a2Name"].nb($row["Att2"],$id)." (".$row["VarA2"]."), ".b($row["Dif2"],$id).$row["d2Name"].nb($row["Dif2"],$id)." (".$row["VarD2"].")"; ?></td>
        <td><?php echo $row["Pt1"]." - ".$row["Pt2"];
		if($row["Pt2"] == 0) echo "  <i class=\"fas fa-skull\"></i>"
		?>
        
        </td>
        <td><?php if($first) echo "<a href=\"deleteit.php\"><button class=\"w3-button\"><div class=\"far fa-trash\"></div></button></a>";?></td>
    </tr>
    <?php 
	$first = false;
	} ?>
    </table>
    
    <?php if($pgcount > 0) { ?>
    <div class="w3-bar w3-border width60 w3-margin-top" align="center">
    <?php 
	$cc = 0;
	while($cc <= $pgcount) { ?>
      <button class="w3-bar-item w3-button select-button <?php
	  if($cc == 0) echo "w3-red";
      echo "\" onclick=\"openPage(event,'".$cc."')\""; 
	  ?> > <?php echo $cc+1; ?> </button>
    <?php $cc+=1; } ?>
    </div>
	<?php } ?>
</div>