<?php
// Denne siden er utviklet av David Stenersen , siste gang endret 07.02.2019

include 'session.php';
include 'tilkobling.php';

try {  
    //Legger interesser som bruker ikke har valgt som interesse i listeboks.
    $q = $db->prepare("SELECT * FROM interesser WHERE idinteresse NOT IN (SELECT idinteresse FROM brukerinteresser WHERE idbruker = ?)");
    $q->bindValue(1, $brukerid, PDO::PARAM_INT);
    $q->execute();
    $results=$q->fetchAll();
    $interesse_valg = $_POST['interesse_valg'];
    
    //Legger interesser brukeren har valgt i listeboks.
    $q = $db->prepare("SELECT * FROM brukerinteresser INNER JOIN interesser ON brukerinteresser.idinteresse = interesser.idinteresse WHERE brukerinteresser.idbruker = ?");
    $q->bindValue(1, $brukerid, PDO::PARAM_INT);
    $q->execute();
    $results_sletting=$q->fetchAll();
}

catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }
//Denne siden er kontrollert av David Stenersen, siste gang 07.02.2019 -->
?>

<!DOCTYPE html>

<html>
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rediger interesser</title>
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
    <li><a href="minprofil.php">Min Profil</a></li>
    <li class="tykkbrodsmule">Redigere interesser</li>
</ul> 
 
<section class="redigerinteresse"> 
    <article class="velginteresse">
        <h1>Velg interesse for din profil</h1>
        <br><br>
        <form action="lastoppinteresse.php" method="post">
            <select name="interesse_valg">
                <option value="" disabled selected hidden>Velg interesse</option><?php foreach ($results as $output) { ?>
                <option value ="<?php echo $output['idinteresse']; ?>"><?php echo $output["interesse"];?></option>
                <?php } ?>
                <input class="skjemaknapp" type="submit" name="button" value="Velg"/>
            </select>
        </form>
    </article>
    
    <article class="slettinteresser">
        <h1>Slett interesse fra din profil</h1>
        <br><br>
        <form action="lastoppinteresse.php" method="post">
            <select name="slett_valg">
                <option value="" disabled selected hidden>Slett interesse</option>
                <?php foreach ($results_sletting as $output) { ?>
                <option value ="<?php echo $output['idinteresse']; ?>"><?php echo $output["interesse"]; ?></option>
                <?php } ?>
                <input class="skjemaknapp" type="submit" name="button" value="Slett"/>
            </select>
        </form>
    </article>
 
    <article class="leggtilinteresser">
        <h1>Legg til interesse som ikke finnes fra før</h1>
        <br><br>
        <form method="post" id="form" action="lastoppinteresse.php">
            <input type="text" name="ny_interesse" placeholder="Legg til ny interesse.">
            <input class="skjemaknapp" type="submit" id="leggtil" name="leggtil" value="Legg til" >
        </form>
    </article>    
</section>

<a href="minprofil.php"><button>Tilbake til din profil</button></a>
    
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
<!-- Denne siden er utviklet av Alexandra Thorstensen og David Stenersen, siste gang endret 07.02.2019 --> 
<!-- Denne siden er kontrollert av Alexandra Thorstensen, siste gang 31.05.2019 -->
</html>