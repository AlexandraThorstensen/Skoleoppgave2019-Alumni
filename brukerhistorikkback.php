<?php
// Denne siden er utviklet av Alexandra Thorstensen, siste gang endret 03.06.2019

include 'session.php';
include 'adminsjekk.php';
include 'tilkobling.php';

try {
    $brukernavn = $_GET['brukernavn'];
    
    $q = $db->prepare("SELECT * FROM bruker WHERE brukerNavn = ?;");
    $q->bindValue(1, $brukernavn, PDO::PARAM_STR);
    $q->execute();
    $resultat = $q->fetchAll(PDO::FETCH_ASSOC);
    
    $q1 = $db->prepare("SELECT * FROM rapporter WHERE konklusjon = ? AND rapportertMot = ?");
    $q1->bindValue(1, "Utestengt", PDO::PARAM_STR);
    $q1->bindValue(2, $brukernavn, PDO::PARAM_STR);
    $q1->execute();
    $resultat1 = $q1->fetchAll(PDO::FETCH_ASSOC);
    $idrapport = $resultat1['idrapport'];
    $rapportertav = $resultat1['rapportertAv'];
    $rapportertmot = $resultat1['rapportertMot'];
    $tidspunkt = $resultat1['tidspunkt'];
    $beskrivelse = $resultat1['beskrivelse'];
    $kategori = $resultat1['kategori'];
    $behandletav = $resultat1['behandletAv'];
    
    $q2 = $db->prepare("SELECT * FROM rapporter WHERE konklusjon != 'Utestengt' AND konklusjon != 'Falsk rapportering' AND rapportertMot = ?");
    $q2->bindValue(1, $brukernavn, PDO::PARAM_STR);
    $q2->execute();
    
    $resultat2 = $q2->fetchAll(PDO::FETCH_ASSOC);
    $idrapport = $resultat2['idrapport'];
    $rapportertav = $resultat2['rapportertAv'];
    $rapportertmot = $resultat2['rapportertMot'];
    $tidspunkt = $resultat2['tidspunkt'];
    $beskrivelse = $resultat2['beskrivelse'];
    $kategori = $resultat2['kategori'];
    $behandletav = $resultat2['behandletAv'];
    
    $q3 = $db->prepare("SELECT * FROM rapporter WHERE konklusjon = 'Falsk rapportering' AND rapportertMot = ?");
    $q3->bindValue(1, $brukernavn, PDO::PARAM_STR);
    $q3->execute();
    $resultat3 = $q3->fetchAll(PDO::FETCH_ASSOC);
    $idrapport = $resultat3['idrapport'];
    $rapportertav = $resultat3['rapportertAv'];
    $rapportertmot = $resultat3['rapportertMot'];
    $tidspunkt = $resultat3['tidspunkt'];
    $beskrivelse = $resultat3['beskrivelse'];
    $kategori = $resultat3['kategori'];
    $behandletav = $resultat3['behandletAv'];        
}

catch(PDOException $e) {
    echo $q . "<br>" . $e->getMessage();
}

// Denne siden er kontrollert av Alexandra Thorstensen., siste gang endret 03.06.2019
?>

<!DOCTYPE html>
<html>
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $brukernavn;?>`s historikk</title>
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
    <li><a href="rapporterback.php">Rapporter</a></li>
    <li class="tykkbrodsmule"><?php echo $brukernavn;?>`s historikk</li>
</ul> 
       
<section class="brukerhistorikk">
    <article class="profilhistorikk-article">
        <h1>Brukerinformasjon:</h1>
        <h2>Brukernavn: <?php echo $brukernavn;?></h2>
        <?php foreach ($resultat as $q): ?>
            <?php echo '<p>IDbruker: ' .$q['idbruker']. '</p>';?>
            <?php echo '<p>Brukertype: ' .$q['brukerType']. '</p>';?>
            <?php echo '<p>E-post: ' .$q['ePost']. '</p>';?>
        <?php endforeach;?>
    </article>
    
    <article class="allekarantener">
        <h1>Alle karantener <?php echo $brukernavn;?> har blitt satt i:</h1>
            <?php if ($resultat1) { ?>
            <table>
                <thead>
                    <tr>
                        <th>IDrapport</th>
                        <th>Rapportert av</th>
                        <th>Brukernavn</th>
                        <th>Tidspunkt</th>
                        <th>Beskrivelse</th>
                        <th>Kategori</th>
                        <th>Behandlet av</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resultat1 as $row): ?>
                    <tr>
                        <?php echo '<td>' .$row['idrapport']. '</td>';?>
                        <td><?= $row['rapportertAv'];?></td>
                        <td><?= $row['rapportertMot'];?></td>
                        <td><?= $row['tidspunkt'];?></td>
                        <td><?= $row['beskrivelse'];?></td>
                        <td><?= $row['kategori'];?></td>
                        <td><?= $row['behandletAv'];?></td>
                        <?php endforeach;?>
                    </tr>
                </tbody>
            </table>
            <?php
                } else {
            ?>
            <p>Har ingen karantener</p>
            <?php
                }
            ?>
    </article>
    
    <article class="alleadvarsler">
        <h1>Alle advarsler som har blitt sendt til <?php echo $brukernavn;?>:</h1>
        <?php if ($resultat2) { ?>
        <table>
            <thead>
                <tr>
                    <th>IDrapport</th>
                    <th>Rapportert av</th>
                    <th>Brukernavn</th>
                    <th>Tidspunkt</th>
                    <th>Beskrivelse</th>
                    <th>Kategori</th>
                    <th>Behandlet av</th>
                </tr>
            </thead>
                <tbody>
                    <?php foreach ($resultat2 as $row): ?>
                    <tr>
                        <?php echo '<td>' .$row['idrapport']. '</td>';?>
                        <td><?= $row['rapportertAv'];?></td>
                        <td><?= $row['rapportertMot'];?></td>
                        <td><?= $row['tidspunkt'];?></td>
                        <td><?= $row['beskrivelse'];?></td>
                        <td><?= $row['kategori'];?></td>
                        <td><?= $row['behandletAv'];?></td>
                        <?php endforeach;?>
                    </tr>
                </tbody>
            </table>
            <?php
                } else {
            ?>
            <p>Har ingen advarsler</p>
            <?php
                }
            ?>
    </article>
    
    <article class="alleignorer">
        <h1>Alle rapporteringer som har blitt ignorert <?php echo $brukernavn;?>:</h1>
        <?php if ($resultat3) { ?>
        <table>
            <thead>
                <tr>
                    <th>IDrapport</th>
                    <th>Rapportert av</th>
                    <th>Brukernavn</th>
                    <th>Tidspunkt</th>
                    <th>Beskrivelse</th>
                    <th>Kategori</th>
                    <th>Behandlet av</th>
                </tr>
            </thead>
                <tbody>
                    <?php foreach ($resultat3 as $row1): ?>
                    <tr>
                        <?php echo '<td>' .$row1['idrapport']. '</td>';?>
                        <td><?= $row1['rapportertAv'];?></td>
                        <td><?= $row1['rapportertMot'];?></td>
                        <td><?= $row1['tidspunkt'];?></td>
                        <td><?= $row1['beskrivelse'];?></td>
                        <td><?= $row1['kategori'];?></td>
                        <td><?= $row['behandletAv'];?></td>
                        <?php endforeach;?>
                    </tr>
                </tbody>
            </table>
            <?php
                } else {
            ?>
            <p>Har ingen ignorerte rapporter</p>
            <?php
                }
            ?>
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
<!-- Denne siden er utviklet av Alexandra Thorstensen siste gang endret 03.06.2019 --> 
<!-- Denne siden er kontrollert av Alexandra Thorstensen, siste gang 03.06.2019 -->
</html>