<?php
// Denne siden er utviklet av Alexandra Thorstensen, siste gang endret 06.06.2019

include 'session.php';
include 'tilkobling.php';

try {
    $q = $db->prepare("SELECT * FROM nyheter ORDER BY tidspunkt DESC;");
    $q->bindValue(1, $brukerid, PDO::PARAM_INT);
    $q->execute();
    $results = $q->fetchAll();
}

catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage(); //feilmelding. 
}
?>

<!DOCTYPE html>
<html>
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nyheter</title>
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
    <li class="tykkbrodsmule">Nyheter</li>
</ul> 
    
<section class="nyheter">
    <?php foreach ($results as $q): ?>
	<article class="allenyheter">
       <?php
        echo '<p class="tidspunktopprettet">Opprettet: ' .$q['tidspunkt']. '</p>';
        echo '<h2>' .$q['nyhetNavn']. '</a> </h2>';
        echo '<p>' .$q['nyhetTekst']. '</p>';
        ?>
	</article>
    <?php endforeach;?>
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
<!-- Denne siden er utviklet av Malin Skår, siste gang endret 14.12.2018 -->
<!-- Denne siden er kontrollert av Alexandra Thorstensen, siste gang 05.06.2019 -->
</html>