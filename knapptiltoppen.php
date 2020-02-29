<?php
//Javascript som scroller til top, hentet fra https://www.w3schools.com/howto/howto_js_scroll_to_top.asp

echo   
'   
window.onscroll = function() {scrollFunction()};
    
//Satt til 20, dvs at når bruker scroller ned 20px vil scroll-to-top være tilgjengelig.
function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("knapp-til-toppen").style.display = "block";
    } else {
        document.getElementById("knapp-til-toppen").style.display = "none";
    }
}

function topFunction() {
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}';
// Denne siden er utviklet av David Stenersen day., siste gang endret 10.12.2018
// Denne siden er kontrollert av Alexandra Thorstensen, siste gang 06.03.2019
?>