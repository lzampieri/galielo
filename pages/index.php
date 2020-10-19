<?php require('templates/top.php'); ?>
<?php require('../scripts/loadparams.php'); ?>
    <script type="text/javascript">
        var chart;
        window.onload = async function() {
            $('button').hide();
            chart = await (await fetch("/api/chart.php")).json();
            populateTable();
            $('button').show();
        }
        </script>

    <script type="text/javascript">
        function compareAtt(a, b) {    
            if (a.PuntiA < b.PuntiA) return 1;
            if (a.PuntiA > b.PuntiA) return -1;
            return 0;    
        }
        function compareDif(a, b) {    
            if (a.PuntiD < b.PuntiD) return 1;
            if (a.PuntiD > b.PuntiD) return -1;
            return 0;    
        }
        function compareAvg(a, b) {    
            if (a.PuntiA + a.PuntiD < b.PuntiA + b.PuntiD) return 1;
            if (a.PuntiA + a.PuntiD > b.PuntiA + b.PuntiD) return -1;
            return 0;    
        }

        var tutti = false;
        var punti = 0; // 0: tutto, 1: attacco, 2: difesa

        function populateTable() {
            var content = `
                <thead class="bg-primary">
                <tr>
                    <th>Nome</th>
                    <th>Punti</th>
                    <th>Partite giocate</th>
                    <th>Partite nell'ultimo mese</th>
                </tr>
                </thead>
            `;
            
            if( punti == 1 ) chart.sort(compareAtt);
            else if( punti == 2 ) chart.sort(compareDif);
            else chart.sort(compareAvg);

            var iconBed = '<i class="fas fa-bed"></i>';
            var iconCrown = '<i class="fas fa-crown"></i>';
            var iconBlender = '<i class="fas fa-blender"></i>';

            chart.forEach( function(row) {
                var valore, partite, partitemese;
                var icon = '';
                if ( punti == 1 ) {
                    valore = row.PuntiA;
                    partite = row.PartiteAttacco + 0;
                    partitemese = row.PartiteMeseAttacco + 0;
                }
                else if ( punti == 2 ) {
                    valore = row.PuntiD;
                    partite = row.PartiteDifesa + 0;
                    partitemese = row.PartiteMeseDifesa + 0;
                }
                else {
                    valore = Math.ceil (( row.PuntiA + row.PuntiD ) / 2);
                    partite = row.PartiteAttacco + row.PartiteDifesa;
                    partitemese = row.PartiteMeseAttacco + row.PartiteMeseDifesa;
                }
                
                if( partitemese <= <?php echo $params['PartiteLetto']; ?> ) icon += iconBed;
                if( valore > <?php echo $params['PuntiCorona']; ?>) icon+= iconCrown;
                if( valore < <?php echo $params['PuntiFrullat']; ?>) icon+= iconBlender;

                if ( tutti || partitemese > <?php echo $params['PartiteLetto']; ?> ) {
                    content += `
                    <tr>
                        <td>${icon}${row.Nome}</td>
                        <td>${valore}</td>
                        <td>${partite}</td>
                        <td>${partitemese}</td>
                    </tr>
                    `;
                }
            });

            $('#chart')[0].innerHTML = content;
        }
        
        $('#switchDormienti').on('change.bootstrapSwitch', function(event) {
            console.log("Stuff");
        })
        </script>


<?php require('templates/header.php'); ?>

<div class="row justify-content-end m-1 col-md-10">
    <div class="btn-group btn-group-toggle" data-toggle="buttons">
        <label class="btn btn-secondary active">
            <input type="radio" name="options" onClick="tutti=false;populateTable();" checked> Attivi
        </label>
        <label class="btn btn-secondary">
            <input type="radio" name="options" onClick="tutti=true;populateTable();"> Tutti
        </label>
    </div>
</div>

<div class="row justify-content-end m-1 col-md-10">
    <div class="btn-group btn-group-toggle" data-toggle="buttons">
        <label class="btn btn-secondary active">
            <input type="radio" name="options" onClick="punti=0;populateTable();" checked> Totale
        </label>
        <label class="btn btn-secondary">
            <input type="radio" name="options" onClick="punti=1;populateTable();"> Attacco
        </label>
        <label class="btn btn-secondary">
            <input type="radio" name="options" onClick="punti=2;populateTable();"> Difesa
        </label>
    </div>
</div>

<div class="row justify-content-end m-1 col-md-10">
    <table class="table table-striped table-hover" id="chart">
        <tr><td class="text-center"><div class="spinner-border text-primary" role="status">
        <span class="sr-only">Loading...</span>
        </div>
        </td></tr>
    </table>
</div>


<?php require('templates/footer.php'); ?>