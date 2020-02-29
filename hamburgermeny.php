<?php
echo   
'//Javascript som tar bort meny og legger den til block med hamburger meny når media query når kriteriet oppgitt i CSS-filen.

function myFunction() {
    var x = document.getElementById("toppnavigasjon");
    if (x.className === "navigasjon") {
        x.className += " responsive";
    } else {
        x.className = "navigasjon";
    }
}';
// Denne siden er utviklet av David Stenersen day., siste gang endret 12.12.2018
// Denne siden er kontrollert av David Stenersen, siste gang 13.12.2018
?>