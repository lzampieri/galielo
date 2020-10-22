<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous"  />

<header class="w3-container w3-center width100">
	<img src="/img/logoConSub.png" class="width70 w3-padding"  />
    <div class="width60 w3-bar w3-dark-grey">
        <a href="/index.php"><button class="w3-bar-item w3-button" id="btnhome">Home</button></a>
        <a href="/ccup.php"><button class="w3-bar-item w3-button" id="btnccup">CdC</button></a>
        <a href="/allmatch.php"><button class="w3-bar-item w3-button" id="btnallmatch">Partite</button></a>
        <a href="/signup.php"><button class="w3-bar-item w3-button" id="btnsignup">Iscrizioni</button></a>
        <!--a href="/tornei/"><button class="w3-bar-item w3-button" id="btntornei">Tornei</button></a-->
        <a href="/galitweet/galitweet.php"><button class="w3-bar-item w3-button" id="btngalitweet">GaliTweet</button></a>
        <a href="/12h/12h.php"><button class="w3-bar-item w3-button" id="btn12h">12h</button></a>
        <a href="/monitor.php"><button class="w3-bar-item w3-button" id="monitor">Monitor</button></a>
        <a href="/about.php"><button class="w3-bar-item w3-button" id="btnabout">About</button></a>
        <a href="/private/admin.php"><button class="w3-bar-item w3-button" id="btnadmin">Admin</button></a>
    </div>
    <br /><br />
    
<script>
var sel = " w3-red";
if(window.location.pathname.indexOf("index") !== -1 || window.location.pathname.length < 2 ) {
	document.getElementById("btnhome").className += sel;
} else if(window.location.pathname.indexOf("allmatch") !== -1) {
	document.getElementById("btnallmatch").className += sel;
} else if(window.location.pathname.indexOf("signup") !== -1) {
	document.getElementById("btnsignup").className += sel;
} else if(window.location.pathname.indexOf("about") !== -1) {
	document.getElementById("btnabout").className += sel;
}  else if(window.location.pathname.indexOf("admin") !== -1) {
	document.getElementById("btnadmin").className += sel;
}  else if(window.location.pathname.indexOf("12h") !== -1) {
	document.getElementById("btn12h").className += sel;
} else if(window.location.pathname.indexOf("galitweet") !== -1) {
	document.getElementById("btngalitweet").className += sel;
}/* else if(window.location.pathname.indexOf("tornei") !== -1) {
	document.getElementById("btntornei").className += sel;
} /* else if(window.location.pathname.indexOf("classcompl") !== -1) {
	document.getElementById("btnsleep").className += sel;
} */ else if(window.location.pathname.indexOf("ccup") !== -1) {
	document.getElementById("btnccup").className += sel;
};  
</script>
</header>