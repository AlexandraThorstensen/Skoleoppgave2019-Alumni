<?php
// Denne siden er utviklet av Alexandra Thorstensen, siste gang endret 02.05.2019
include 'session.php';
include 'tilkobling.php';

try {
    $q = $db->prepare("SELECT * FROM nyheter ORDER BY tidspunkt DESC LIMIT 3;");
    $q->bindValue(1, $brukerid, PDO::PARAM_INT);
    $q->execute();
    $results = $q->fetchAll();
    
    $q = $db->prepare("SELECT * FROM arrangement ORDER BY tidspunkt DESC LIMIT 3;");
    $q->bindValue(1, $brukerid, PDO::PARAM_INT);
    $q->execute();
    $results2 = $q->fetchAll();   
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
    <title>Hjem</title>
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
    <li class="tykkbrodsmule">Hjem</li>
</ul> 
    
<section class="hjem">
	<article class="nyheter-hjem">
        <h1>De tre siste nyhetene</h1>
        <br>
        <?php foreach ($results as $q): ?>
        <br>
        <?php
        echo '<article class="hjem-articleiarticle">';
        echo '<p class="tidspunktopprettet">Opprettet: ' .$q['tidspunkt']. '</p>';
        echo '<h2> <a href="arrangement.php"> ' .$q['nyhetNavn']. '</a> </h2>';
        echo '<p>' .$q['nyhetTekst']. '</p>';
        echo '</article>';
        ?>
        <?php endforeach;?>
	</article>

    <article class="arrangement-hjem">
		<h1>De tre siste opprettet arrangement</h1>
        <br>
        <?php foreach ($results2 as $q): ?>
        <br>
        <?php
        echo '<article class="hjem-articleiarticle">';
        echo '<p class="tidspunktopprettet">Opprettet: ' .$q['tidspunkt']. '</p>';
        echo '<h2> <a href="arrangement.php"> ' .$q['arrangementNavn']. '</a> </h2>';
        echo '<p class="dato">Tidspunkt: '  .$q['arrangementDato']. '</p>' ;
        echo '<p class="sted">Sted: '  .$q['arrangementSted']. '</p>' ;
        echo '<p>Beskrivelse: ' .$q['arrangementTekst']. '</p>';
        echo '</article>';
        ?>
        <?php endforeach;?>
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
<!-- Denne siden er utviklet av Alexandra Thorstensen, siste gang endret 06.03.2019 --> 
<!-- Denne siden er kontrollert av Alexandra Thorstensen, siste gang 31.05.2019 -->
</html>