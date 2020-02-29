<?php
// Denne siden er utviklet av David Stenersen, siste gang endret 28.05.2019

include 'session.php';
include 'tilkobling.php';

try { 
    //Spørring som viser fram alle kommende arrangement, samt om innlogget bruker har registrert påmelding.
    $q = $db->prepare("SELECT Arrangement.*, bruker.brukerNavn FROM arrangement INNER JOIN bruker ON arrangement.opprettetAv = bruker.idbruker WHERE arrangementDato < NOW();");
    $q->bindValue(1, $brukerid, PDO::PARAM_INT);
    $q->execute();
    $results=$q->fetchAll();   
}

catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

?>

<!DOCTYPE html>
<html>
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tidligere arrangement</title>
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
    <li><a href="arrangement.php">Arrangement</a></li>
    <li class="tykkbrodsmule">Tidligere arrangement</li>
</ul> 

<section class="tidligerearrangement">
    <?php foreach ($results as $q): ?>
        <article class="tidligerearrangement-article">
        <?php 
            echo '<p class="tidspunktopprettet">Opprettet ' .$q['tidspunkt']. '<br>Av <a style="font-weight: 900" href="profil.php?brukernavn='.$q['brukerNavn'].'">'.$q['brukerNavn'].'</a></p>';
            echo '<h1>' .$q['arrangementNavn']. '</h1>';
            echo '<p class="dato">Tidspunkt: '  .$q['arrangementDato']. '</p>' ;
            echo '<p class="sted">Sted: '  .$q['arrangementSted']. '</p>' ;
            echo '<p>Beskrivelse: ' .$q['arrangementTekst']. '</p>';
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

</html>