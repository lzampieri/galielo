<?php require("../template/header.php"); ?>
<?php require_once("../api/utilities.php"); ?>

<div class="row justify-content-center mb-3">
    <div class="card text-center col-md-8">
        <div class="card-header">
            <h3>GaliElo</h3>
        </div>
        <div class="card-body">
            <h4 class="card-title">Classifica generale</h4>
            Rientrano nella classifica generale tutti coloro che hanno giocato almeno <?php echo get_game_param('active_threshold'); ?> partite negli ultimi 30 giorni. Tutti gli altri sono visibili nella classifica completa.<br/>
            Sono disponibili i seguenti badge:<br/>
            <i class="fas fa-crown"></i> per chi supera i <?php echo get_game_param("crown_threshold"); ?> punti;<br/>
            <i class="fas fa-blender"></i> per chi scende sotto i <?php echo get_game_param("blender_threshold"); ?> punti;<br/>
            <i class="fas fa-bed"></i> per i dormienti.<br/>
        </div>
        <div class="card-body">
            <h4 class="card-title">Punti</h4>
            Una spiegazione del metodo di assegnazione dei punti si trova <a href="../texspiegazione/document.pdf">cliccando qui</a>. I punti totali sono calcolati dalla media dei punti in attacco e di quelli in difesa.
        </div>
        <div class="card-body">
            <h4 class="card-title">Coppia dei campioni</h4>
            Vengono nominati vincitori della Coppia dei campioni coloro che riescono a battere al meglio delle tre partite la Coppia precedente (ovvero, devono aver sconfitto la precedente Coppia due volte subendo al massimo una sconfitta in mezzo).
        </div>
    </div>
</div>
<div class="row justify-content-center mb-3">
    <a href="https://github.com/lzampieri/galielo"><img src="github.png" width=200px/></a>
</div>
<div class="row justify-content-center mb-3">
    <a href="../api/seelog.php">Site log</a>
</div>

<?php require("../template/footer.php"); ?>