<?php
// Denne siden er utviklet av David Stenersen , siste gang endret 05.03.2019

include 'session.php';
include 'tilkobling.php';

try {  
    $q = $db->prepare("SELECT brukerNavn FROM bruker WHERE brukerNavn <> ?");
    $q->bindValue(1, $bruker);
    $q->execute();
    $results=$q->fetchAll();
    $interesse_valg = $_POST['brukerNavn'];
        
    if (isset($_POST['mottaker_valg']) && ($_POST['tekst'])) {
        $sql = "INSERT INTO meldinger (tilBruker, fraBruker, melding)  VALUES (?,?,?)";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(1, $_POST['mottaker_valg'], PDO::PARAM_STR);
        $stmt->bindValue(2, $bruker, PDO::PARAM_STR);
        $stmt->bindValue(3, $_POST['tekst'], PDO::PARAM_STR);
        $stmt->execute();
        header("Location: Sendmelding.php?melding=Meldingen din er sendt.");
    } 
}

catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Send melding</title>
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
    <li><a href="innboks.php">Innboks</a></li>
    <li class="tykkbrodsmule">Send melding</li>
</ul> 
    
<section class="sendmeldinger"> 
    <article class="sendmelding">
        <h1>Send melding</h1>
        <form action="sendmelding.php" method="post">
            <select name="mottaker_valg">
                <option value="" disabled selected hidden>Velg mottaker</option>
                <?php foreach ($results as $output) { ?>
                <option><?php echo $output["brukerNavn"];?></option>
                <?php } ?>
            </select>
            <br><br>
            <textarea name="tekst" cols="70" rows="10" maxlength="1000" WRAP=SOFT></textarea>
            <input class="skjemaknapp" type="submit" name="sendmelding" value="Send melding">
            <br>
            <?php $mld=$_GET['melding']; echo $mld;?>
            <span id="melding" style="color: red;"><?php echo($melding); ?></span>
        </form>
        <br>
    </article>
</section>
    
<a href="innboks.php"><button>Tilbake til innboks</button></a>
 
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
<!-- Denne siden er kontrollert av Alexandra Thorstensen, siste gang 31.05.2019 -->
</html>