<?php
// Denne siden er utviklet av David Stenersen, siste gang endret 24.04.2019

include 'session.php';
include 'adminsjekk.php';
include 'tilkobling.php';

try {
    $q = $db->prepare("SELECT rapporter.*, bruker.ePost FROM rapporter INNER JOIN bruker ON rapporter.rapportertMot = bruker.brukerNavn WHERE rapporter.behandletAv IS NULL ORDER BY tidspunkt ASC;");
    $q->execute();   
    $resultat = $q->fetchAll(PDO::FETCH_ASSOC);
}

catch(PDOException $e) {
    echo $q . "<br>" . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ubehandlet rapporter</title>
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
    <li class="tykkbrodsmule">Ubehandlet rapporter</li>
</ul> 


<section class="ubehandletrapporter">
    <?php foreach ($resultat as $q): ?>
    
    <article class="ubehandletrapporter-article">
        <?php 
            echo '<h1> Rapport #' .$q['idrapport']. '</h1>' ;
            echo '<p>Emne: ' .$q['kategori']. '</p>' ;
            echo '<p class="time-left"> Opprettet den: ' .$q['tidspunkt']. '</p>' ;
            echo '<p>Sak opprettet av: <a href="profilback.php?brukernavn='.$q['rapportertAv'].'">'.$q['rapportertAv'].'</a></p>';
            echo '<p>Sak omhandler: <a href="profilback.php?brukernavn='.$q['rapportertMot'].'">'.$q['rapportertMot'].'</a></p>';
            echo '<p>Beskrivelse: ' .$q['beskrivelse']. '</p>' ;

            echo '<a href="behandlerapportback.php?brukernavn=' .$q['rapportertMot']. '&rapportnummer=' .$q['idrapport'].'&ePost=' .$q['ePost'].'"><button class="button">Behandle rapportering</button></a>'
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

<footer class="footerback">
    <?php include 'footerback.php';?>
</footer>

</body>
<!-- Denne siden er utviklet av David Stenersen, siste gang endret 24.04.2019 --> 
<!-- Denne siden er kontrollert av Alexandra Thorstensen, siste gang 02.06.19 -->
</html>