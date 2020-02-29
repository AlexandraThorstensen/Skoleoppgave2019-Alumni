<?php
include 'session.php';
?>

<!DOCTYPE html>
<html>
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kontakt oss</title>
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
    <li class="tykkbrodsmule">Kontakt oss</li>
</ul> 
    
<section class="kontakt">
	<article class="kontaktform">
        <h1>Kontakt oss</h1><br><br>
		<h2>Spørsmål vedr. innlogging:</h2>
		<p><a href="mailto:david.stenersen@gmail.com">Kontakt David Stenersen</a></p><br>
	
		<h2>Savner du en funksjon på siden?</h2>
		<p><a href="mailto:alexandra.thorstensen@hotmail.com">Kontakt Alexandra Thorstensen</a></p><br>
		
		<h2>Spørsmål vedr. innhold på nettsiden:</h2>
		<p><a href="mailto:malin_skaar54@hotmail.com">Kontakt Malin Skår</a></p><br>
	</article>

	<article class="kontaktform-info">
        <h1>Har du spørsmål?</h1>
        <p>Dersom du har problemer med din brukerkonto, spørsmål eller kommentar knyttet til innhold på siden, eller forslag til nye funksjoner på nettsiden - kontakt en av oss.</p>
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