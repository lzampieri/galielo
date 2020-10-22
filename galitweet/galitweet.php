<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaliElo</title>
<link rel="stylesheet" type="text/css" href="../css/w3.css" />
<link rel="stylesheet" type="text/css" href="../css/style.css" />


<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<!-- JQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(document).ready( function() {
        $('#fail_banner').hide();
        $('#success_banner').hide();
        $('#new_post_form').submit( submit_form );
    });

    function submit_form(event) {
        $('#submit_button').prop("disabled",true);
        event.preventDefault();
        $.post( 'api/tweets.php', {
            addnew: true,
            author: $('#name')[0].value,
            post: $('#post')[0].value
        }).done( function(data) {
            result = $.parseJSON(data);
            if( result['success'] ) {
                $('#fail_banner').hide();
                $('#success_banner').show();
                $('#name')[0].value="";
                $('#post')[0].value="";
            } else {
                $('#fail_banner').show();
                $('#fail_banner')[0].innerHTML = result['error'];
                $('#success_banner').hide();
            }
            $('#submit_button').prop("disabled",false);
        })
    }
</script>

<?php
require_once("../script/utilities.php");
?>

</head>

<body class="w3-light-grey">
<br /><br />
<div align="center">

<?php require("../header.php"); ?>

<div align="center">
	<form class="w3-container w3-card-4 w3-light-grey w3-text-blue w3-margin w3-padding width60" id="new_post_form">
        <div class="w3-green width40" id="success_banner">Spedito!</div>
        <div class="w3-red width40" id="fail_banner">Errore.</div>
        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-user"></i></div>
            <div class="w3-rest">
              <input class="w3-input w3-border" id="name" type="text" placeholder="Autore" maxlength="50">
            </div>
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-comment-dots"></i></div>
                <div class="w3-rest">
                    <input class="w3-input w3-border" id="post" type="text" placeholder="Massimo 280 caratteri!" maxlength="280">
                </div>
            <button class="w3-button w3-block w3-blue w3-padding" id="submit_button" >Spedisci!</button>
        </div>    
    </form>
</div>

</div>
</body>
</html>