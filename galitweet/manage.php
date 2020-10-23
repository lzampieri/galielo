<?php
require_once("../script/utilities.php");
if( !check_if_admin() ) {
    header("location: ../private/login.php");
    exit();
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Amministrazione - GaliElo</title>

<link rel="stylesheet" type="text/css" href="../css/w3.css" />
<link rel="stylesheet" type="text/css" href="../css/style.css" />
<script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js" integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl" crossorigin="anonymous"></script>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<!-- JQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    iconHourglass = '<i class="w3-text-blue w3-xxlarge fa fa-hourglass-half"></i>';
    $(document).ready( function() {
        $('#post_list')[0].innerHTML = iconHourglass;
        load_tweets();
    });

    function compareTimestamp(a, b) {    
            if (a.Timestamp < b.Timestamp) return 1;
            if (a.Timestamp > b.Timestamp) return -1;
            return 0;    
    }

    async function load_tweets() {
        $('#post_list')[0].innerHTML = iconHourglass;
        $.get( 'api/tweets.php?all', function(data) {
            result = $.parseJSON(data).sort(compareTimestamp);
            content = "";
            result.forEach( function(row) {
                var data = new Date(row.Timestamp*1000).toLocaleDateString("it-IT") + " " + new Date(row.Timestamp*1000).toLocaleTimeString("it-IT");
                var hide_eye = "", hide_slash = "";
                if( row.Visible ) hide_slash = "style=\"display: none;\"";
                else hide_eye = "style=\"display: none;\"";
                content += `
                    <div class="w3-card-4 w3-light-grey w3-margin w3-padding width60">
                        <div class="w3-row w3-padding w3-border-bottom">
                            <div class="w3-third w3-left-align"><i class="fa fa-user"></i>  ${row.Author}</div>
                            <div class="w3-third w3-center-align">
                                <div class="visible" data-id="${row.ID}" ${hide_eye}><i class="fa fa-eye visible"></i></div>
                                <div class="non-visible" data-id="${row.ID}" ${hide_slash}><i class="fa fa-eye-slash"></i></div>
                                <button class="w3-button w3-blue change-visibility" data-id="${row.ID}" data-status="${row.Visible}"><i class="fa fa-sync-alt"></i></button>
                            </div>
                            <div class="w3-third w3-right-align">${data}  <i class="fa fa-clock"></i></div>
                        </div>
                        <div class="w3-row w3-padding">
                            ${row.Text}
                        </div>
                    </div>
                `
            })
            if( content == "" ) content = "Ancora nessun tweet :(";
            $('#post_list')[0].innerHTML = content;
            $('.change-visibility').click( change_visibility );
        })
    }

    function change_visibility() {
        $(this).prop("disabled",true);
        var id = $(this).data()['id'];
        var status = $(this).data()['status'];
        var newstatus = ( status + 1)%2;
        $.post( 'api/tweets.php', {
            changevisibility: true,
            ID: id,
            Visibility: newstatus
        }).done( function(data) {
            try {
                result = $.parseJSON(data);
            }
            catch(e) {
                result['success'] = false;
                result['error'] = data;
            }
            if( !result['success'] ) {
                alert(result['error']);
            } else {
                var id = result['id'];
                var visibility = result['visibility'];
                if( visibility ) {
                    $(`.visible[data-id=${id}]`).show();
                    $(`.non-visible[data-id=${id}]`).hide();
                } else {
                    $(`.visible[data-id=${id}]`).hide();
                    $(`.non-visible[data-id=${id}]`).show();
                }
                $(`.change-visibility[data-id=${id}]`).prop("disabled",false).data("status",visibility);
            }
        })
    }
</script>

</head>
<body class="w3-light-grey">
<a href="../private/admin.php"><button class="w3-button w3-blue">&lt;&lt;Indietro</button></a><br />
<div align="center" id="post_list">
    In caricamento...
</div>
</body>
</html>