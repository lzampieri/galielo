<?php require("../template/header.php"); ?>

<script>
    var activeplayers = [];
    var inactiveplayers = [];
    var playersnames = [];
    var sending = false;

    function load_players() {
        $.get("../api/player.php", function(data) {
            // Convert in array details
            JSON.parse(data).forEach( function(e) {
                if( e.CountRecent > 10 )
                    activeplayers.push(e)
                else
                    inactiveplayers.push(e)
                playersnames[e.ID] = e.Nome
            })
            
            // Sort
            const compare = function(a, b) { textA = a.Nome.toUpperCase(); textB = b.Nome.toUpperCase(); return (textA < textB) ? -1 : (textA > textB) ? 1 : 0; }
            activeplayers.sort(compare);
            inactiveplayers.sort(compare);

            // Append items
            activegroup = $('<optgroup>', { label: "Attivi" })
            activeplayers.forEach( function(p) {
                activegroup.append( $('<option>', { value: p.ID, text: p.Nome }))
            })
            activegroup.appendTo($('select'))
            
            inactivegroup = $('<optgroup>', { label: "Altri" })
            inactiveplayers.forEach( function(p) {
                inactivegroup.append( $('<option>', { value: p.ID, text: p.Nome }))
            })
            inactivegroup.appendTo($('select'))

            // Enable
            $('#att1')[0].disabled = false;
            $('#dif1')[0].disabled = false;
            $('#att2')[0].disabled = false;
            $('#dif2')[0].disabled = false;
        })
    }

    function hide_alerts() {
        $('#pleaseselect').hide()
        $('#pleasepoints').hide()
        $('#genericalert').hide()
        $('#savespinner').hide()
        $('#ccup').hide()
    }

    function check() {
        $('#submitButton')[0].disabled = true;
        hide_alerts()
        
        att1 = $('#att1')[0].value
        dif1 = $('#dif1')[0].value
        att2 = $('#att2')[0].value
        dif2 = $('#dif2')[0].value
        pt2 = $('#pt2')[0].value

        if( !att1 || !att2 || !dif1 || !dif2 ) {
            $('#pleaseselect').show()
            $('#submitButton')[0].disabled = false
            return
        }
        dict = {}
        dict[att1] = "1"
        dict[att2] = "1"
        dict[dif1] = "1"
        dict[dif2] = "1"
        if( Object.keys(dict).length != 4 ) {
            $('#pleaseselect').show()
            $('#submitButton')[0].disabled = false
            return
        }

        if(!pt2) {
            $('#pleasepoints').show()
            $('#submitButton')[0].disabled = false
            return
        }

        pt2 = parseInt(pt2)

        $('#modalText').html(`${playersnames[att1]}, ${playersnames[dif1]} vincono 10 - ${pt2} contro ${playersnames[att2]}, ${playersnames[dif2]}`)

        $('#confirmModal').modal('show')

        // Prevent modal closing when saving stuff
        $('#confirmModal').on('hide.bs.modal', function(e){
            if( sending ) {
                e.preventDefault();
                e.stopImmediatePropagation();
                return false;
            }
        });
        
        $('#submitButton')[0].disabled = false
    }
    
    function send() {
        if( sending ) return;
        sending = true;

        // Make spinner spinning
        $('#savespinner').show()

        // Make the request
        $.post("/api/match.php", {
            add: true,
            att1: parseInt($('#att1')[0].value),
            att2: parseInt($('#att2')[0].value),
            dif1: parseInt($('#dif1')[0].value),
            dif2: parseInt($('#dif2')[0].value),
            pt1: 10,
            pt2: parseInt($('#pt2')[0].value)
            }, received)
    }

    function received(data) {
        sending = false;
        info = JSON.parse(data);

        if( info["success"] ) {
            $('#successModalText').html(`${playersnames[info["Att1"]]} (${info["VarA1"]}), ${playersnames[info["Dif1"]]} (${info["VarD1"]}) vincono per ${info["Pt1"]} - ${info["Pt2"]} contro ${playersnames[info["Att2"]]} (${info["VarA2"]}), ${playersnames[info["Dif2"]]} (${info["VarD2"]})`);
            $('#confirmModal').modal('hide');
            $('#successModal').modal('show');
            if( info["ccup"] )
                $('#ccup').show();
        } else {
            $('#genericalert').show();
            $('#genericalert').html( info["error_message"]);
            $('#confirmModal').modal('hide')
        }
    }

    $( document ).ready(function () {
        hide_alerts()
        load_players()
    })
</script>

<div class="alert alert-danger" role="alert" id="pleaseselect">
    Seleziona quattro diversi giocatori.
</div>
<div class="alert alert-danger" role="alert" id="pleasepoints">
    Inserisci i punteggi.
</div>
<div class="alert alert-danger" role="alert" id="genericalert">
    Errore di inserimento.
</div>
<div class="row justify-content-around mb-3">
    <div class="card text-center col-md-4">
        <div class="card-header">
            <h4 id="name">Squadra vincitrice</h4>
        </div>
        <div class="card-body">
            <h5 class="card-title">Attacco</h5>
            <select class="form-control" id="att1" disabled>
            </select>
            <hr>
            <h5 class="card-title">Difesa</h5>
            <select class="form-control" id="dif1" disabled>
            </select>
            <hr>
            <h5 class="card-title">Punti</h5>
            <input type="number" class="form-control" value="10"  disabled />
            </select>
        </div>
    </div>
    <div class="card text-center col-md-4">
        <div class="card-header">
            <h4 id="name">Squadra perdente</h4>
        </div>
        <div class="card-body">
            <h5 class="card-title">Attacco</h5>
            <select class="form-control" id="att2" disabled>
            </select>
            <hr>
            <h5 class="card-title">Difesa</h5>
            <select class="form-control" id="dif2" disabled>
            </select>
            <hr>
            <h5 class="card-title">Punti</h5>
            <input type="number" id="pt2" class="form-control" />
        </div>
    </div>
</div>
<div class="row justify-content-center mb-3">
    Si ricorda che, in caso di vittoria ai vantaggi, è necessario inserire il punteggio 10-9.
</div>

<div class="row justify-content-center mb-3">
    <button type="button" class="btn btn-primary" onClick="check()" id="submitButton"><i class="fas fa-save"></i> Salva</button>
</div>

<div class="modal" tabindex="-1" id="confirmModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Conferma dati inseriti</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="modalText"></p>
      </div>
      <div class="modal-footer">
        <div class="spinner-border text-primary" role="status" id="savespinner">
            <span class="sr-only">Loading...</span>
        </div>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annulla</button>
        <button type="button" class="btn btn-primary" onclick="send()"><i class="fas fa-save"></i> Conferma</button>
      </div>
    </div>
  </div>
</div>

<div class="modal" tabindex="-1" id="successModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Partita salvata!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="successModalText"></p>
        <div class="alert alert-success" role="alert" id="ccup">
            È stata anche riassegnata la coppa dei campioni!
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-plus-circle"></i> Inserisci ancora</button>
        <a href="/"><button type="button" class="btn btn-primary">Classifica</button></a>
      </div>
    </div>
  </div>
</div>

<?php require("../template/footer.php"); ?>