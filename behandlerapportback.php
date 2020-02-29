<?php
// Denne siden er utviklet av David Stenersen, siste gang endret 24.04.2019

include 'session.php';
include 'adminsjekk.php';
include 'tilkobling.php';

try {
    //Variabel sendt fra oversikt hvor bruker har valgt sak som skal behandles. 
    $brukernavn = $_GET['brukernavn'];
    $rapportnr = $_GET['rapportnummer'];
    $epostadr = $_GET['ePost'];
    
    //Spørring utføres med oversendt variabel - innhold legges i tabell.
    $q = $db->prepare("SELECT rapporter.*, bruker.ePost FROM rapporter INNER JOIN bruker ON rapporter.rapportertMot = bruker.brukerNavn WHERE rapportertMot = ?;");
    $q->bindValue(1, $brukernavn, PDO::PARAM_STR);
    $q->execute();
    $resultat = $q->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_POST['advarsel'])) {
        $sql = "UPDATE rapporter SET konklusjon = ?, behandletAv = ? WHERE idrapport = ?";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(1, $_POST['beskjed'], PDO::PARAM_STR);
        $stmt->bindValue(2, $bruker, PDO::PARAM_STR);
        $stmt->bindValue(3, $rapportnr, PDO::PARAM_INT);
        $stmt->execute();
        
        //Beskjed sendes til rapportert bruker.
        $sql = "INSERT INTO meldinger (tilBruker, fraBruker, melding)  VALUES (?,?,?)";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(1, $brukernavn, PDO::PARAM_STR);
        $stmt->bindValue(2, $bruker, PDO::PARAM_STR);
        $beskjed = $_POST['beskjed'] + "Mvh Admin";
        $stmt->bindValue(3, $_POST['beskjed'], PDO::PARAM_STR);
        $stmt->execute();
        header("Location: ubehandletrapportback.php?brukernavn= $brukernavn");    
    }
    
    if (isset($_POST['utestegning'])) {
        
        //Utestegning valgt 
        $sql = "UPDATE bruker SET feilLogginnSiste = ? WHERE brukerNavn = ?";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(1, $_POST['tidspunkt'], PDO::PARAM_STR);
        $stmt->bindValue(2, $brukernavn, PDO::PARAM_STR);
        $stmt->execute();
        
        $sql = "UPDATE rapporter SET konklusjon = ?, behandletAv = ? WHERE idrapport = ?";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(1, "Utestengt", PDO::PARAM_STR);
        $stmt->bindValue(2, $bruker, PDO::PARAM_STR);
        $stmt->bindValue(3, $rapportnr, PDO::PARAM_INT);
        $stmt->execute();
            
        ini_set("SMTP","s120.hbv.no");
        ini_set("smtp_port","25");
        date_default_timezone_set("Europe/Oslo");
        $til = $_GET['ePost'];
        $fra = "ikkesvar@usnalumni.no";
        $subject = "Du har blitt utestengt fra USN alumni!";
        $melding = "Du har blitt utestengt fra USN alumni til " . $_POST['tidspunkt'];
        $headers = "From: " . $fra . "\r\n" .
				'X-Mailer: PHP/' . phpversion() . "\r\n" .
				"MIME-Version: 1.0\r\n" .
				"Content-Type: text/html; charset=utf-8\r\n" .
				"Content-Transfer-Encoding: 8bit\r\n\r\n";
        mail($til, $subject, $melding, $headers);
        header("Location: ubehandletrapportback.php?brukernavn= $brukernavn");    
    }
    
    if (isset($_POST['ignorer'])) {
        //Ved falsk rapportering kan man ignorere den. 
        $sql = "UPDATE rapporter SET konklusjon = ?, behandletAv = ? WHERE idrapport = ?";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(1, "Falsk rapportering", PDO::PARAM_STR);
        $stmt->bindValue(2, $bruker, PDO::PARAM_STR);
        $stmt->bindValue(3, $rapportnr, PDO::PARAM_INT);
        $stmt->execute();
        header("Location: ubehandletrapportback.php?brukernavn= $brukernavn");
    }
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
    <title>Behandle <?php echo $brukernavn;?>`s rapportering</title>
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
    <li><a href="ubehandletrapportback.php">Ubehandlet rapporter</a></li>
    <li class="tykkbrodsmule">Behandle <?php echo $brukernavn;?>`s rapportering</li>
</ul> 
    
<section class="behandlerapport">
    <article class="rapporthistorikk-article">
        <h1>Rapporteringshistorikk til <?php echo $brukernavn;?>:</h1>
            <table>
                <thead>
                    <tr>
                        <th>Rapportnummer</th>
                        <th>Rapportert av</th>
                        <th>Tidspunkt</th>
                        <th>Situasjonsbeskrivelse</th>
                        <th>Kategori</th>
                        <th>Konklusjon</th>
                        <th>Behandlet av</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resultat as $row):?>
                    <tr>
                        <td><?= $row['idrapport'];?></td>
                        <td><?= $row['rapportertAv'];?></td>
                        <td><?= $row['tidspunkt'];?></td>
                        <td><?= $row['beskrivelse'];?></td>
                        <td><?= $row['kategori'];?></td>
                        <td><?= $row['konklusjon'];?></td>
                        <td><?= $row['behandletAv'];?></td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
    </article>
</section>

<section class="behandlerapportmeny">
    <article class="giadvarsel">
        <h1>Gi advarsel</h1>
            <p>Skriv inn beskjed til bruker om at de får en advarsel for regelbrudd</p>
        <form action="" method="post">
            <input type="hidden" name="rapportnr" value="<?php echo $rapportnr;?>">
            <input type="hidden" name="rapportert_mot" value="<?php echo $brukernavn;?>">
            <input type="text" name="beskjed" placeholder="Skriv beskjed til bruker.." required>
            <input class="skjemaknapp" type="submit" name="advarsel" value="Gi advarsel">
        </form>
    </article>
    
    <article class="karantene">
        <h1>Sett <?php echo $brukernavn;?> i karantene</h1>
            <p>Skriv inn datoen for hvor lenge brukeren skal sitte i karantene</p>
            <form action="" method="post">
                <input type="hidden" name="rapportnr" value="''">
                <input type="datetime-local" name="tidspunkt" placeholder="Dato og tid for karantene åååå.mm.dd hh.ss" required>
                <input class="skjemaknapp" type="submit" name="utestegning" value="Utesteng">
            </form>
    </article>
    
    <article class="ignorererapport">
        <h1>Ignorer rapporting</h1>
        <p>Trykk på ignorer hvis ikke bruker har brutt noen regler eller hvis rapporteringen er falsk</p>
        <form action="" method="post">
            <input type="hidden" name="rapportnr" value="<?php echo $rapportnr;?>">
            <input class="skjemaknapp" type="submit" name="ignorer" value="Ignorere">
        </form>          
    </article>
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
<!-- Denne siden er kontrollert av David Stenersen, siste gang 06.06.19 -->
</html>