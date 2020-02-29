<?php
// Denne siden er utviklet av David Stenersen, siste gang endret 24.04.2019

include 'session.php';
include 'adminsjekk.php';
include 'tilkobling.php';

try { 
    $q = $db->prepare("SELECT COUNT(brukerNavn) FROM bruker WHERE sistInnlogget > NOW() - INTERVAL 24 HOUR;");
    $q->execute();
    $resultat = $q->fetchAll(PDO::FETCH_COLUMN, 0);
    
    $q = $db->prepare("SELECT COUNT(brukerNavn) FROM bruker WHERE forsteInnlogging > NOW() - INTERVAL 24 HOUR;");
    $q->execute();
    $resultat1 = $q->fetchAll(PDO::FETCH_COLUMN, 0);

    $q = $db->prepare("SELECT COUNT(idarrangement) FROM arrangement WHERE tidspunkt > NOW() - INTERVAL 24 HOUR;");
    $q->execute();
    $resultat2 = $q->fetch(PDO::FETCH_ASSOC);
    
    $q = $db->prepare("SELECT COUNT(idmelding) FROM meldinger WHERE tidspunkt > NOW() - INTERVAL 24 HOUR;");
    $q->execute();
    $resultat3 = $q->fetch(PDO::FETCH_ASSOC);
    
    $q = $db->prepare("SELECT * FROM bruker ORDER BY idbruker DESC LIMIT 5;");
    $q->execute();   
    $resultat4 = $q->fetchAll(PDO::FETCH_ASSOC);
    $brukertype = $resultat4['brukerType'];
    $brukernavn = $resultat4['brukerNavn'];
    $epost = $resultat4['ePost'];
    
    $q = $db->prepare("SELECT brukerNavn, feilLogginnSiste, feilIP FROM bruker WHERE feilLogginnSiste IS NOT NULL ORDER BY feilLogginnSiste DESC LIMIT 5;");
    $q->execute();   
    $resultat5 = $q->fetchAll(PDO::FETCH_ASSOC); 
    $brukernavn = $resultat5['brukerNavn'];
    $feilloggin = $resultat5['feilLogginnSiste'];
    $feilip = $resultat5['feilIP'];
}

catch(PDOException $e) {
    echo $q . "<br>" . $e->getMessage();
}

// Denne siden er kontrollert av Alexandra Thorstensen., siste gang endret 15.05.2019
?>

<!DOCTYPE html>
<html>
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin hjem</title>
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
    <li class="tykkbrodsmule">Hjem</li>
</ul>
    
<section class="hjemantallback">
	<article class="brukere-hjem">
		<h1>Brukere</h1>
        <p><?php foreach ($resultat as $output) { ?>
            <?php echo "Antall innlogginger i dag: "  . $output;?>
            <?php } ?>
        </p>
        <p><?php foreach ($resultat1 as $output) { ?>
            <?php echo "Antall registrerte brukere i dag: "  . $output;?>
            <?php } ?>
        </p> 
	</article>
	
	<article class="arrangementer-hjem">
		<h1>Arrangementer</h1>
        <p><?php foreach ($resultat2 as $output) { ?>
            <?php echo "Antall arrangementer opprettet idag: "  . $output;?>
            <?php } ?>
        </p>
	</article>
    
    <article class="meldinger-hjem">
        <h1>Meldinger</h1>
        <p><?php foreach ($resultat3 as $output) { ?>
            <?php echo "Antall meldinger sendt idag: "  . $output;?>
            <?php } ?>
        </p>
	</article>
</section>

<section class="hjemrapporterback">
    <article class="fembrukere-article">
        <h1>Siste 5 registrerte brukere:</h1>
            <table>
                <thead>
                    <tr>
                        <th>Brukertype</th>
                        <th>Brukernavn</th>
                        <th>E-Post</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resultat4 as $row):?>
                    <tr onclick="linkRad('profil.php?brukernavn=<?= $row['brukerNavn'];?>');">
                        <td><?= $row['brukerType'];?></td>
                        <td><?= $row['brukerNavn'];?></td>
                        <td><?= $row['ePost'];?></td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
    </article>
    
    <article class="femfeillogin-article">
        <h1>Siste 5 feilet login:</h1>
            <table>
                <thead>
                    <tr>
                        <th>Brukernavn</th>
                        <th>Siste feilet login</th>
                        <th>IP-adresse</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resultat5 as $row):?>
                        <tr onclick="linkRad('brukerhistorikkback.php?brukernavn=<?= $row['brukerNavn'];?>');">
                            <td><?= $row['brukerNavn'];?></td>
                            <td><?= $row['feilLogginnSiste'];?></td>
                            <td><?= $row['feilIP'];?></td>
                        </tr>
                        <?php endforeach;?>
                </tbody>
            </table>
    </article>
</section>
    
<button class="knapptiltoppen" onclick="topFunction()" id="knapp-til-toppen" title="Gå til topp">Til toppen</button>
    
<script>
    <?php include 'hamburgermeny.php';?>
    <?php include 'linkheleraden.php';?>
    <?php include 'knapptiltoppen.php';?>   
</script>

</main>

<footer class="footerback">
    <?php include 'footerback.php';?>
</footer>

</body>
<!-- Denne siden er utviklet av Alexandra Thorstensen, siste gang 06.03.2019 -->
<!-- Denne siden er kontrollert av Alexandra Thorstensen, siste gang 04.06.2019 -->
</html>