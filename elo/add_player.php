<?php require("../template/header.php"); ?>

<script>
    var inserting = false;

    function hide_stuff() {
        $('#inserting_spinner').hide();
        $('#tooshort_alert').hide();
    }

    function ask_for_confirm() {
        hide_stuff();
        var name = $('#thename')[0].value;
        if( name.length < 5 ) {
            $('#tooshort_alert').show();
            return;
        }

        $('#confirmModal').modal('show');
        $('#confirmModal_thename').html(name);

        // Prevent modal closing when saving stuff
        $('#confirmModal').on('hide.bs.modal', function(e){
            if( inserting ) {
                e.preventDefault();
                e.stopImmediatePropagation();
                return false;
            }
        });
    }

    function confirmed_insertion() {
        if( inserting ) return;
        inserting = true;

        // Make spinner spinning
        $('#inserting_spinner').show()

        // Make the request
        $.post("/api/player.php", {
            add: true,
            name: $('#thename')[0].value
            }, doneinserting)
    }

    function doneinserting(data) {
        details =  JSON.parse(data);
        inserting = false;
        hide_stuff();
        $('#confirmModal').modal('hide');
        $('#successModal').modal('show');
        $('#theid').html( details['ID'] );
    }

    $( document ).ready(hide_stuff)

</script>

<div class="row justify-content-center mb-3">
    <div class="card text-center col-md-6">
        <div class="card-header">
            <h3>Iscrizioni</h3>
        </div>
        <div class="card-body">
            <div class="alert alert-danger" role="alert" id="tooshort_alert">
                Dai non ci credo che nome e cognome stai sotto i 5 caratteri.
            </div>
            <h5 class="card-title">Nome e Cognome:</h5>
            <input type="text" class="form-control" name="thename" id="thename" maxlength="50" />
            <h5 class="card-title">Punti iniziali:</h5>
            <h5 class="card-title">
                <?php require_once("../api/utilities.php"); echo get_game_param("starting_points"); ?>
            </h5>
            <button type="button" class="btn btn-primary" onClick="ask_for_confirm()"><i class="fas fa-save"></i> Iscriviti</button>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" id="confirmModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Conferma</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Confermi che ti chiami <i id="confirmModal_thename"></i>?
      </div>
      <div class="modal-footer">
        <div class="spinner-border text-primary" role="status" id="inserting_spinner">
            <span class="sr-only">Loading...</span>
        </div>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annulla</button>
        <button type="button" class="btn btn-primary" onclick="confirmed_insertion()"><i class="fas fa-save"></i> Conferma</button>
      </div>
    </div>
  </div>
</div>

<div class="modal" tabindex="-1" id="successModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Iscrizione effettuata!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Benvenuto! Ti è stato assegnato il numero <span class="badge badge-info" id="theid"></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-plus-circle"></i> Inserisci ancora</button>
        <a href="/"><button type="button" class="btn btn-primary">Home</button></a>
      </div>
    </div>
  </div>
</div>

<?php require("../template/footer.php"); ?>