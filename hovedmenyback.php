<?php
// Denne siden er utviklet av Alexandra Thorstensen day., siste gang endret 12.12.2018
include 'adminsjekk.php';

echo   
'    <nav class="logo-meny">
        <a href="hjemback.php"><img class="usn-logo" src="./Bilder/USN_header_logo.png" alt="Header_logo"></a>
    </nav>
    
    <nav class="hamburgermeny">    
        <a href="javascript:void(0);" class="icon" onclick="myFunction()">Meny</a>
    </nav>
    
    <nav class="navigasjon" id="toppnavigasjon">
        <a href="brukeradminback.php">Administrer brukere</a>
        <a href="rapporterback.php">Systemrapport</a>
        <a href="ubehandletrapportback.php">Rapporterte brukere</a>
        <a href="nyheterback.php">Nyheter</a>
        <a href="reglerback.php">Vilkår</a>
    </nav>';

// Denne siden er kontrollert av Alexandra Thorstensen, siste gang 03.06.2019
?>
