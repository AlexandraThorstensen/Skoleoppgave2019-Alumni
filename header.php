<?php
// Denne siden er utviklet av Alexandra Thorstensen day., siste gang endret 14.12.2018

if($_SESSION['brukertype'] == "Admin"){
    echo '<div class="headertekst">
    <a href="hjemback.php"><img class="bytt" src="./Bilder/bytt.png" alt="Bytt"> Til adminmodus</a>
    
    <a href="innboks.php"><img class="konvolutt" src="./Bilder/konvolutt.png" alt="Konvolutt"> Innboks</a>
    
    <a href="minprofil.php"><img class="bruker" src="./Bilder/bruker.png" alt="Bruker"> Min profil</a>
    
    <a href="erloggetut.php" ><img class="loggut" src="./Bilder/loggut.png" alt="Logg ut"> Logg ut</a>
    </div>';
    
    echo '<div class="headerutentekst">
    <a href="hjemback.php"><img class="bytt" src="./Bilder/bytt.png" alt="Bytt"></a>
    
    <a href="#innboks.php"><img class="konvolutt" src="./Bilder/konvolutt.png" alt="Konvolutt"></a>

    <a href="minprofilback.php"><img class="bruker" src="./Bilder/bruker.png" alt="Bruker"></a>

    <a href="erloggetut.php" ><img class="loggut" src="./Bilder/loggut.png" alt="Logg ut"></a>
    </div>';

}

if($_SESSION['brukertype'] == "Bruker"){
    echo '<div class="headertekst">
    <a href="innboks.php"><img class="konvolutt" src="./Bilder/konvolutt.png" alt="Konvolutt"> Innboks</a>
    
    <a href="minprofil.php"><img class="bruker" src="./Bilder/bruker.png" alt="Bruker"> Min profil</a>
    
    <a href="erloggetut.php" ><img class="loggut" src="./Bilder/loggut.png" alt="Logg ut"> Logg ut</a>
    </div>';
    
    echo '<div class="headerutentekst">
    <a href="innboks.php"><img class="konvolutt" src="./Bilder/konvolutt.png" alt="Konvolutt"></a>

    <a href="minprofil.php"><img class="bruker" src="./Bilder/bruker.png" alt="Bruker"></a>

    <a href="erloggetut.php" ><img class="loggut" src="./Bilder/loggut.png" alt="Logg ut"></a>
    </div>';

}


// Denne siden er kontrollert av Alexandra Thorstensen, siste gang 28.04.2019
?>

<!-- Ikoner hentet fra https://www.iconfinder.com/DesignRevision og https://www.iconfinder.com/designmodo -->