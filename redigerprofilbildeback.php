<?php
include 'session.php';
include 'adminsjekk.php';
include 'tilkobling.php';
?>

<!DOCTYPE html>

<html>
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rediger profilbilde</title>
    <link rel="stylesheet" href="css.css">
    <link rel="stylesheet" href="cssback.css">
</head>
    
<body>
     
<header>
    <?php include 'headerback.php';?>
</header>
 
<main>    
    
<nav class="hovedmenyback">
    <?php include 'hovedmenyback.php';?>  
</nav>

<ul class="brodsmuler">
    <li><a href="hjemback.php">Hjem</a></li>
    <li><a href="minprofilback.php">Min Profil</a></li>
    <li class="tykkbrodsmule">Redigere profilbilde</li>
</ul> 
 
<section class="redigerprofilbilde">
    <article class="profilbilde">
        <h1>Last opp profilbilde</h1><br><br>
       
        <form method="POST" action="lastoppprofilbilde.php" enctype="multipart/form-data">
            <p>Tillatte filtyper: jpg, png, gif. 
            <br>
            <input class="opplastningsfil" name="opplastningsfil" type="file"/>
            <input class="skjemaknapp" type="submit" value="Last opp"/>
        </form>
	</article>
</section>

<a href="minprofilback.php"><button>Tilbake til din profil</button></a>
    
<button class="knapptiltoppen" onclick="topFunction()" id="knapp-til-toppen" title="Gå til topp">Til toppen</button>
    
<script>
    <?php include 'hamburgermeny.php';?>
    <?php include 'knapptiltoppen.php';?>   
</script>

</main>

<footer class="footerback">
    <?php include 'footerback.php';?>
</footer>

</body>
<!-- Denne siden er utviklet av David Stenersen, siste gang endret 07.02.2019 --> 
<!-- Denne siden er kontrollert av Alexandra Thorstensen, siste gang 06.06.2019 -->
</html>