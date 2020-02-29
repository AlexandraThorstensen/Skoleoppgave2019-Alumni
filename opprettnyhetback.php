<?php
// Denne siden er utviklet av David Stenersen, siste gang endret 28.05.2019

include 'session.php';
include 'adminsjekk.php';
include 'tilkobling.php';

try {
    if (isset($_POST['lagrenyhet'])) {
        $sql = "INSERT INTO nyheter (nyhetNavn, nyhetTekst, opprettetAv) VALUES (?,?,?)";

        $stmt = $db->prepare($sql);
        $stmt->bindValue(1, $_POST['navn'], PDO::PARAM_STR);
        $stmt->bindValue(2, $_POST['tekst'], PDO::PARAM_STR);
        $stmt->bindValue(3, $brukerid, PDO::PARAM_INT);
        $stmt->execute();
        header("Location: nyheterback.php");
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
    <title>Opprett nyhet</title>
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
    <li><a href="nyheterback.php">Nyheter</a></li>
    <li class="tykkbrodsmule">Opprett nyhet</li>
</ul> 

<section class="opprettnyhet">
    <article class="nynyhet">
        <h1>Opprett nyhet</h1>
            <form action="opprettnyhetback.php" method="post">
                <input type="text" name="navn" placeholder="Navn på nyheten" required><br><br>
                <textarea maxlength="500" name="tekst" placeholder="Legg inn nyheten.." required></textarea>
                <input class="skjemaknapp" type="submit" name="lagrenyhet" value="Lagre nyhet">
            </form>
    </article>
</section>
    
<a href="nyheterback.php"><button>Tilbake til nyheter</button></a>
  
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
<!-- Denne siden er kontrollert av Alexandra Thorstensen, siste gang 04.06.2019 -->
</html>