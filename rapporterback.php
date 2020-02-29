<?php
// Denne siden er utviklet av David Stenersen, siste gang endret 24.04.2019

include 'session.php';
include 'adminsjekk.php';
include 'tilkobling.php';

try {
    //SELECT COUNT(konklusjon) AS antallKonklusjoner FROM rapporter WHERE konklusjon = "Utestengt" AND rapportertMot = "en"
    
    //SELECT bruker.*, (SELECT COUNT(konklusjon) FROM rapporter WHERE konklusjon = "Utestengt" AND rapportertMot = "en") AS antallKonklusjoner FROM bruker
    
    //Brukerinfo og antall karanter på bruker "en"
    //SELECT bruker.*, count(konklusjon) AS antallKonklusjoner FROM bruker INNER JOIN rapporter ON bruker.brukerNavn = rapporter.rapportertMot WHERE konklusjon = "Utestengt" AND rapportertMot = "en";
    
    //Alle som har hatt karantene, med antall karantener
    //SELECT bruker.*, count(konklusjon) AS antallKonklusjoner FROM bruker INNER JOIN rapporter ON bruker.brukerNavn = rapporter.rapportertMot WHERE konklusjon = "Utestengt" GROUP BY idbruker
    
    //$q = $db->prepare("SELECT bruker.*, count(konklusjon) AS antallKonklusjoner FROM bruker INNER JOIN rapporter ON bruker.brukerNavn = rapporter.rapportertMot WHERE konklusjon = ? AND rapportertMot = ?");
    //$q->bindValue(1, "Utestengt", PDO::PARAM_STR);
    //$q->bindValue(2, $brukernavn, PDO::PARAM_STR);
    //$q->execute(); 
    
    $q = $db->prepare("SELECT * FROM bruker ORDER BY idbruker");
    $q->execute();   
    $resultat = $q->fetchAll(PDO::FETCH_ASSOC); 
    $idbruker = $resultat['idbruker'];
    $brukertype = $resultat['brukerType'];
    $brukernavn = $resultat['brukerNavn'];
    $epost = $resultat['ePost'];
}

catch(PDOException $e) {
    echo $q . "<br>" . $e->getMessage();
}

// Denne siden er kontrollert av Alexandra Thorstensen., siste gang endret 16.05.2019
?>

<!DOCTYPE html>
<html>
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rapporter</title>
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
    <li class="tykkbrodsmule">Rapporter</li>
</ul> 
       
<section class="rapporter">
    <article class="allebrukere-article">
        <h1>Alle brukere i databasen:</h1>
        <p>Klikk på en bruker for å se historikk om advarsel og karantene.</p>
        <p>Klikk på Brukertype, Brukernavn eller E-Post for å sortere alfabetisk.</p>
            <table id="sortering">
                <thead>
                    <tr>
                        <th>IDnummer</th>
                        <th onclick="sortTable(1)">Brukertype</th>
                        <th onclick="sortTable(2)">Brukernavn</th>
                        <th onclick="sortTable(3)">E-Post</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resultat as $row): ?>
                        <tr onclick="linkRad('brukerhistorikkback.php?brukernavn=<?= $row['brukerNavn'];?>');">
                            <td><?= $row['idbruker'];?></td>
                            <td><?= $row['brukerType'];?></td>
                            <td><?= $row['brukerNavn'];?></td>
                            <td><?= $row['ePost'];?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
    </article>
    
</section>
 
<button class="knapptiltoppen" onclick="topFunction()" id="knapp-til-toppen" title="Gå til topp">Til toppen</button>
    
<script> 
    <?php include 'hamburgermeny.php';?>
    <?php include 'sortereliste.php';?>
    <?php include 'linkheleraden.php';?>
    <?php include 'knapptiltoppen.php';?>   
</script>

</main>

<footer class="footerback">
    <?php include 'footerback.php';?>
</footer>

</body>
<!-- Denne siden er utviklet av David Stenersen, siste gang endret 24.04.2019 --> 
<!-- Denne siden er kontrollert av Alexandra Thorstensen, siste gang 03.06.2019 -->
</html>