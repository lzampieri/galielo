<?php
$situa = mysqli_fetch_assoc(query("SELECT * FROM torn_direct WHERE tornID = ".$torn["ID"]));
$sq1 = mysqli_fetch_assoc(query("SELECT * FROM torn_sq WHERE ID = ".$situa["sq1"]));
$sq2 = mysqli_fetch_assoc(query("SELECT * FROM torn_sq WHERE ID = ".$situa["sq2"]));
$sq3 = mysqli_fetch_assoc(query("SELECT * FROM torn_sq WHERE ID = ".$situa["sq3"]));
$sq4 = mysqli_fetch_assoc(query("SELECT * FROM torn_sq WHERE ID = ".$situa["sq4"]));
$sq[$situa["sq1"]] = $sq1["att"].", ".$sq1["dif"];
$sq[$situa["sq2"]] = $sq2["att"].", ".$sq2["dif"];
$sq[$situa["sq3"]] = $sq3["att"].", ".$sq3["dif"];
$sq[$situa["sq4"]] = $sq4["att"].", ".$sq4["dif"];
#echo http_build_query($sq, '', '/');
?>

<div align="center">
<div class="width70" align="center">
    <div class="w3-card-4 w3-padding width40 float w3-margin-bottom">
    <?php if($situa["win14"] != 0) {?>
    	<p>Squadra vincente</p>
        <p class="w3-card-4"><?php echo $sq[$situa["win14"]]; ?></p>
        <p>Squadra perdente</p>
        <p class="w3-card-4"><?php echo $sq[$situa["sq1"]+$situa["sq4"]-$situa["win14"]]; ?></p>
        <p>Punteggio finale: 10-<?php echo $situa["pti14"];?>
    <?php } else { ?>
    	<p>Squadre sfidanti:</p>
        <p><?php echo $sq[$situa["sq1"]] ?></p>
        <p><?php echo $sq[$situa["sq4"]] ?></p>
        <form method="post" action="savedirects.php">
        	<input type="hidden" value="<?php echo $torn["ID"]; ?>" name="tid" />
            <input type="hidden" value="14" name="match" />
            <input type="hidden" value="<?php echo $sq[$situa["sq1"]]; ?>" name="nome1" />
            <input type="hidden" value="<?php echo $sq[$situa["sq4"]]; ?>" name="nome2" />
            <input type="hidden" value="<?php echo $situa["sq1"]; ?>" name="id1" />
            <input type="hidden" value="<?php echo $situa["sq4"]; ?>" name="id2" />
            <button type="submit" class="w3-btn far fa-plus-square" />
        </form>
    <?php } ?>
    </div>
    
    <div class="width20collapse float">Placeholder</div>
    
    <div class="w3-card-4 width40 w3-padding float w3-margin-bottom">
    <?php if($situa["win23"] != 0) {?>
    	<p>Squadra vincente</p>
        <p class="w3-card-4"><?php echo $sq[$situa["win23"]]; ?></p>
        <p>Squadra perdente</p>
        <p class="w3-card-4"><?php echo $sq[$situa["sq2"]+$situa["sq3"]-$situa["win23"]]; ?></p>
        <p>Punteggio finale: 10-<?php echo $situa["pti23"];?>
    <?php } else { ?>
    	<p>Squadre sfidanti:</p>
        <p><?php echo $sq[$situa["sq2"]] ?></p>
        <p><?php echo $sq[$situa["sq3"]] ?></p>
        <form method="post" action="savedirects.php">
        	<input type="hidden" value="<?php echo $torn["ID"]; ?>" name="tid" />
            <input type="hidden" value="23" name="match" />
            <input type="hidden" value="<?php echo $sq[$situa["sq2"]]; ?>" name="nome1" />
            <input type="hidden" value="<?php echo $sq[$situa["sq3"]]; ?>" name="nome2" />
            <input type="hidden" value="<?php echo $situa["sq2"]; ?>" name="id1" />
            <input type="hidden" value="<?php echo $situa["sq3"]; ?>" name="id2" />
            <button type="submit" class="w3-btn far fa-plus-square" />
        </form>
    <?php } ?>
</div>
    
<?php if($situa["win23"] != 0 && $situa["win14"] != 0) {
	?>
	<div class="width70" align="center">
		<div class="w3-card-4 w3-padding width40 float w3-margin-bottom">
			<p class="w3-blue w3-card-4 w3-large">Finalina</p>
			<?php if($situa["winina"] != 0) {?>
                <p>Squadra vincente</p>
                <p class="w3-card-4"><?php echo $sq[$situa["winina"]]; ?></p>
                <p>Squadra perdente</p>
                <p class="w3-card-4"><?php echo $sq[$situa["sq1"]+$situa["sq2"]+$situa["sq3"]+$situa["sq4"]-$situa["win14"]-$situa["win23"]-$situa["winina"]]; ?></p>
                <p>Punteggio finale: 10-<?php echo $situa["ptiina"];?>
            <?php } else { ?>
                <p>Squadre sfidanti:</p>
                <p><?php echo $sq[$situa["sq1"]+$situa["sq4"]-$situa["win14"]]; ?></p>
                <p><?php echo $sq[$situa["sq2"]+$situa["sq3"]-$situa["win23"]]; ?></p>
                <form method="post" action="savedirects.php">
                    <input type="hidden" value="<?php echo $torn["ID"]; ?>" name="tid" />
                    <input type="hidden" value="ina" name="match" />
                    <input type="hidden" value="<?php echo $sq[$situa["sq1"]+$situa["sq4"]-$situa["win14"]]; ?>" name="nome1" />
                    <input type="hidden" value="<?php echo $sq[$situa["sq2"]+$situa["sq3"]-$situa["win23"]]; ?>" name="nome2" />
                    <input type="hidden" value="<?php echo $situa["sq1"]+$situa["sq4"]-$situa["win14"]; ?>" name="id1" />
                    <input type="hidden" value="<?php echo $situa["sq2"]+$situa["sq3"]-$situa["win23"]; ?>" name="id2" />
            <button type="submit" class="w3-btn far fa-plus-square" />
                </form>
            <?php } ?>
			</div>
            
			<div class="width20collapse float">Placeholder</div>
            
			<div class="w3-card-4 width40 w3-padding float w3-margin-bottom">
			<p class="w3-blue w3-card-4 w3-large">FINALE</p>
			<?php if($situa["winfin"] != 0) {?>
                <p>Squadra vincente</p>
                <p class="w3-card-4 w3-large w3-blue"><?php echo $sq[$situa["winfin"]]; ?></p>
                <p>Squadra perdente</p>
                <p class="w3-card-4"><?php echo $sq[$situa["win14"]+$situa["win23"]-$situa["winfin"]]; ?></p>
                <p>Punteggio finale: 10-<?php echo $situa["ptifin"];?>
            <?php } else { ?>
                <p>Squadre sfidanti:</p>
                <p><?php echo $sq[$situa["win14"]]; ?></p>
                <p><?php echo $sq[$situa["win23"]]; ?></p>
                <form method="post" action="savedirects.php">
                    <input type="hidden" value="<?php echo $torn["ID"]; ?>" name="tid" />
                    <input type="hidden" value="fin" name="match" />
                    <input type="hidden" value="<?php echo $sq[$situa["win14"]]; ?>" name="nome1" />
                    <input type="hidden" value="<?php echo $sq[$situa["win23"]]; ?>" name="nome2" />
                    <input type="hidden" value="<?php echo $situa["win14"]; ?>" name="id1" />
                    <input type="hidden" value="<?php echo $situa["win23"]; ?>" name="id2" />
                    <button type="submit" class="w3-btn far fa-plus-square" />
                </form>
            <?php } ?>
		</div>
	</div>
<?php } ?>
</div>