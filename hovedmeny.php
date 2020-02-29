<?php
// Denne siden er utviklet av David Stenersen og Alexandra Thorstensen day., siste gang endret 12.12.2018
echo   
'   <nav class="logo-meny">
        <a href="hjem.php"><img class="usn-logo" src="./Bilder/USN_header_logo.png" alt="Header_logo"></a>
    </nav>
    
    <nav class="hamburgermeny">    
        <a href="javascript:void(0);" class="icon" onclick="myFunction()">Meny</a>
    </nav>
   
    <nav class="navigasjon" id="toppnavigasjon">
        <a href="finnmedlemmer.php">Finn medlemmer</a>
        <a href="nyheter.php">Nyheter</a>
        <a href="arrangement.php">Arrangement</a>
		<a href="vilkaar/regler.html" onclick="window.open(this.href); return false;" onkeypress="window.open(this.href); return false;">Vilkår</a>
    </nav>';

// Denne siden er kontrollert av Alexandra Thorstensen, siste gang 29.05.2019
?>