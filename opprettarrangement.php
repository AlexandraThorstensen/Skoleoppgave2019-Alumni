<?php
// Denne siden er utviklet av David Stenersen, siste gang endret 28.05.2019

include 'session.php';
include 'tilkobling.php';

$date = date('m/d/Y h:i:s ', time());         

try {
    if (isset($_POST['lagrearrangement'])) {
        $sql = "INSERT INTO arrangement (arrangementDato, arrangementNavn, arrangementSted, arrangementTekst, opprettetAv) VALUES (?,?,?,?,?)";

        $stmt = $db->prepare($sql);
        $stmt->bindValue(1, $_POST['tidspunkt'], PDO::PARAM_STR);
        $stmt->bindValue(2, $_POST['navn'], PDO::PARAM_STR);
        $stmt->bindValue(3, $_POST['sted'], PDO::PARAM_STR);
        $stmt->bindValue(4, $_POST['tekst'], PDO::PARAM_STR);
        $stmt->bindValue(5, $brukerid, PDO::PARAM_INT);
        $stmt->execute();
        header("Location: arrangement.php");
    }          
}

catch(PDOException $e)
    {
    //echo $sql . "<br>" . $e->getMessage(); //feilmelding. 
}
?>

<!DOCTYPE html>
<html>
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Opprett arrangement</title>
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
    <li class="tykkbrodsmule">Opprett arrangement</li>
</ul> 

<section class="opprettarrangement">
    <article class="nyarrangement">
        <h1>Opprett nytt arrangement</h1>
            <form action="opprettarrangement.php" method="post">
                <input type="text" name="navn" autofocus placeholder="Navn på arrangement" required><br><br>
                <input type="datetime-local" name="tidspunkt" min="<?php echo $date;?>" placeholder="Tidspunkt for arrangementet åååå.mm.dd hh.mm" required><br><br>
                <input type="text" name="sted" placeholder="Sted for arrangement" required><br><br>
                <textarea maxlength="500" name="tekst" placeholder="Legg inn en beskrivelse med relevant informasjon om arrangementet." required></textarea>
                <input class="skjemaknapp" type="submit" name="lagrearrangement" value="Lagre arrangement">
            </form>
    </article>
</section>
    
<a href="arrangement.php"><button>Tilbake til arrangement</button></a>
  
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