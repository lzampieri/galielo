<?php require('templates/top.php'); ?>
<?php require('../scripts/loadparams.php'); ?>
    <script type="text/javascript">
        var chart;
        window.onload = async function() {
            $('button').hide();
            chart = await (await fetch("/api/oka.php")).json();
            populateTable();
            $('button').show();
        }
        </script>

    <script type="text/javascript">
        function compare(a, b) {    
            if (a.Timestamp < b.Timestamp) return 1;
            if (a.Timestamp > b.Timestamp) return -1;
            return 0;    
        }

        function populateTable() {
            var content = `
                <thead class="bg-primary">
                <tr>
                    <th>Data</th>
                    <th>Vincitori</th>
                    <th>Sconfitti</th>
                    <th>Punteggio</th>
                </tr>
                </thead>
            `;

            var iconSkull = '<i class="fas fa-skull"></i> ';

            chart.sort(compare);

            chart.forEach( function(row) {
                var icon = '';
                if( row.Pt2 == 0 ) icon = iconSkull;
                content += `
                    <tr>
                        <td>${row.Timestamp}</td>
                        <td>${row.NomeAtt1} (${row.VarA1}), ${row.NomeDif1} (${row.VarD1})</td>
                        <td>${row.NomeAtt2} (${row.VarA2}), ${row.NomeDif2} (${row.VarD2})</td>
                        <td>${icon}${row.Pt1} - ${row.Pt2}</td>
                    </tr>
                `;
            });

            $('#matches')[0].innerHTML = content;
            $('#matches').DataTable();
        }
        </script>


<?php require('templates/header.php'); ?>

<div class="row justify-content-end m-1 col-md-10">
    <table class="table table-striped table-hover" id="matches">
        <tr><td class="text-center"><div class="spinner-border text-primary" role="status">
        <span class="sr-only">Loading...</span>
        </div>
        </td></tr>
    </table>
</div>


<?php require('templates/footer.php'); ?>