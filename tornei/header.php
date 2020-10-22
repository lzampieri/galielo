<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous"  />

<header class="w3-container w3-center width100">
	<img src="/img/logoConSub.png" class="width70 w3-padding"  />
    <div class="width60 w3-bar w3-dark-grey">
        <a href="../index.php"><button class="w3-bar-item w3-button" id="btnhome">Home</button></a>
        <a href="index.php"><button class="w3-bar-item w3-button" id="btntorn">Torneo</button></a>
        <a href="storico.php"><button class="w3-bar-item w3-button" id="btnstor">Storico</button></a>
        <a href="iscr.php"><button class="w3-bar-item w3-button" id="btniscr">Iscrizioni</button></a>
    </div>
    <br /><br />
    
<script>
var sel = " w3-red";
if( window.location.pathname.indexOf("tornei/index") !== -1 || window.location.pathname.length < 9 ) {
	document.getElementById("btntorn").className += sel;
} else if(window.location.pathname.indexOf("storico") !== -1) {
	document.getElementById("btnstor").className += sel;
} else if(window.location.pathname.indexOf("iscr") !== -1) {
	document.getElementById("btniscr").className += sel;
};  
</script>
</header>