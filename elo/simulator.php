<?php require("../template/header.php"); ?>

<script>
    var sending = false;

    function hide_alerts() {
        $('#genericalert').hide()
        $('#outputModal').hide()
    }

    function send() {
        if (sending) return;
        sending = true;

        // // Make spinner spinning
        // $('#savespinner').show()

        // Make the request
        $.post("/api/simulator.php", {
            pt_att1: parseInt($('#pt_att1')[0].value),
            pt_att2: parseInt($('#pt_att2')[0].value),
            pt_dif1: parseInt($('#pt_dif1')[0].value),
            pt_dif2: parseInt($('#pt_dif2')[0].value),
            pt1: 10,
            pt2: parseInt($('#pt2')[0].value)
        }, received)
    }

    function received(data) {
        sending = false;
        info = JSON.parse(data);

        if (info["success"]) {
            $('#outputModalText').html(`${info["pt_att1"]} (${info["var_att1"]}), ${info["pt_dif1"]} (${info["var_dif1"]}) vincono per ${info["pt1"]} - ${info["pt2"]} contro ${info["pt_att2"]} (${info["var_att2"]}), ${info["pt_dif2"]} (${info["var_dif2"]})`);
            $('#outputModal').show()
        } else {
            $('#genericalert').show();
            $('#genericalert').html(info["error_message"]);
        }
    }

    $(document).ready(function() {
        hide_alerts();
    })
</script>

<div class="alert alert-danger" role="alert" id="genericalert">
    Errore di inserimento.
</div>

<div class="row justify-content-around mb-3">
    <div class="card text-center col-md-4">
        <div class="card-header">
            <h4 id="name">Squadra vincitrice</h4>
        </div>
        <div class="card-body">
            <h5 class="card-title">Attacco (punti)</h5>
            <input type="number" id="pt_att1" name="pt_att1" class="form-control" />
            <hr>
            <h5 class="card-title">Difesa (punti)</h5>
            <input type="number" id="pt_dif1" name="pt_dif1" class="form-control" />
            <hr>
            <h5 class="card-title">Punti</h5>
            <input type="number" class="form-control" value="10" disabled />
            </select>
        </div>
    </div>
    <div class="card text-center col-md-4">
        <div class="card-header">
            <h4 id="name">Squadra perdente</h4>
        </div>
        <div class="card-body">
            <h5 class=" card-title">Attacco (punti)</h5>
            <input type="number" id="pt_att2" name="pt_att2" class="form-control" />
            <hr>
            <h5 class="card-title">Difesa (punti)</h5>
            <input type="number" id="pt_dif2" name="pt_dif2" class="form-control" />
            <hr>
            <h5 class="card-title">Punti</h5>
            <input type="number" id="pt2" class="form-control" />
        </div>
    </div>
</div>
<div class="row justify-content-center mb-3">
    Si ricorda che, in caso di vittoria ai vantaggi, è necessario inserire il punteggio 10-9.<br />
    Questo simulatore è utile solo a calcolare la variazione di punteggi, nessun dato viene salvato.
</div>

<div class="row justify-content-center mb-3">
    <button type="button" class="btn btn-primary" onClick="send()" id="submitButton">Simula</button>
</div>

<div class="modal" tabindex="-1" id="outputModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Partita simulata!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="$('#outputModal').hide()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="outputModalText"></p>
            </div>
        </div>
    </div>
</div>

<?php require("../template/footer.php"); ?>