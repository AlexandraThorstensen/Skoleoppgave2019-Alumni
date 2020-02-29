<?php
include 'session.php';
include 'tilkobling.php';
?>

<!DOCTYPE html>

<html>
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Min profil</title>
    <link rel="stylesheet" href="css.css">
</head>
    
<body>
     
<header>
    <?php include 'header.php';?>
</header>
 
<main>    
    
<nav class="hovedmeny">
    <?php include 'hovedmeny.php';?>  
</nav>

<ul class="brodsmuler">
    <li><a href="hjem.php">Hjem</a></li>
    <li><a href="minprofil.php">Rediger profilbilde</a></li>
    <li class="tykkbrodsmule">Redigere profilbilde</li>
</ul> 
 
<section class="redigerprofilbilde">
    <article class="profilbilde">
        <h1>Last opp profilbilde</h1><br><br>
       
        <form method="POST" action="lastoppprofilbilde.php" enctype="multipart/form-data">
            <p>Tillatte filtyper: jpg, png, gif.<br>
            <br>
            <input class="opplastningsfil" name="opplastningsfil" type="file"/>
            <input class="skjemaknapp" type="submit" value="Last opp"/>
        </form>
	</article>
</section>

<a href="minprofil.php"><button>Tilbake til din profil</button></a>
    
<button class="knapptiltoppen" onclick="topFunction()" id="knapp-til-toppen" title="Gå til topp">Til toppen</button>
    
<script>
    <?php include 'hamburgermeny.php';?>
    <?php include 'knapptiltoppen.php';?>   
</script>

</main>

<footer>
    <?php include 'footer.php';?>
</footer>

</body>
<!-- Denne siden er utviklet av David Stenersen, siste gang endret 07.02.2019 --> 
<!-- Denne siden er kontrollert av Alexandra Thorstensen, siste gang 31.05.2019 -->
</html>