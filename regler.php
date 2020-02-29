<?php
include 'session.php';
?>

<!DOCTYPE html>
<html>
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vilkår for bruk</title>
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
    <li class="tykkbrodsmule">Vilkår for bruk</li>
</ul> 
    
<section class="regler">
	<article class="regler-bruk">
	<h1>Bruk av nettstedet</h1><br><br>
	<br><br>
    <span><?php echo $bruk;?></span>
    <br>
	</article>

	<article class="regler-oppforsel">
	<h1>Oppførsel</h1>
	<br><br>
    <span><?php echo $oppforsel;?></span>
    <br>
	</article>
	
	<article class="regler-personvern">
	<h1>Personvern</h1>
	<br><br>
    <span><?php echo $personvern;?></span>
    <br>
	</article>
	
	<article class="regler-misbruk">
	<h1>Konsekvenser for misbruk</h1>
	<br><br>
    <span><?php echo $misbruk;?></span>
    <br>
	</article>
	
</section>
    
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
<!-- Denne siden er utviklet av Malin Skår, siste gang endret 12.12.2018 -->  
<!-- Denne siden er kontrollert av Alexandra Thorstensen, siste gang 31.05.2019 -->
</html>