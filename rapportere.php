<?php

include 'session.php';
include 'tilkobling.php';

try {
    $brukernavn = $_GET['brukernavn'];
    
    if (isset($_POST['sendmelding'])) {
        $sql = "INSERT INTO rapporter (rapportertAv, rapportertMot, beskrivelse, kategori) VALUES (?,?,?,?)";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(1, $bruker, PDO::PARAM_STR);
        $stmt->bindValue(2, $brukernavn, PDO::PARAM_STR);
        $stmt->bindValue(3, $_POST['tekst'], PDO::PARAM_STR);
        $stmt->bindValue(4, $_POST['kategori'], PDO::PARAM_STR);
        $stmt->execute();
        header("Location: profil.php?brukernavn=".$brukernavn);
    }
    
    if (empty($brukernavn)) {
        header("Location: hjem.php");
    }
}          

catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage(); //feilmelding. 
}
?>

<!DOCTYPE html>
<html>
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rapportere <?php echo $brukernavn;?></title>
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
    <li><a href="finnmedlemmer.php">Finn medlemmer</a></li>
    <li><a href="profil.php?brukernavn=<?= $brukernavn;?>"><?php echo $brukernavn;?>'s profil</a></li>
    <li class="tykkbrodsmule">Rapportere</li>
</ul> 

<section class="rapportere">
	<article class="rapportere-article">
		<h1>Rapporter <?php echo $brukernavn;?> for misbruk</h1>
            <form action="" method="post">
                <label for="select">Velg emne: </label>
                   <select name="kategori" required>
                       <option value="Falsk identitet">Personen utgi seg for å være en annen</option>
                       <option value="Falskt profilbilde">Falskt profilbilde</option>
                       <option value="Falskt navn">Falskt navn</option>
                       <option value="Upassende innhold">Personen poster upassende innhold</option>
                       <option value="Upassende melding">Personen sender upassende meldinger</option>
                       <option value="Annet">Annet</option>
                   </select>
                   
                <label for="tekst">Beskrivelse av hendelsen: </label>
                   <textarea maxlength="500" name="tekst" placeholder="Hjelp oss å forstå hendelsen.." required></textarea>
                   <input class="skjemaknapp" type="submit" name="sendmelding" value="Send rapport">
            </form>
	</article>
</section>
    
<a href="profil.php?brukernavn=<?= $brukernavn;?>"><button>Tilbake til <?php echo $brukernavn;?> sin profil</button></a>
  
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
<!-- Denne siden er utviklet av David Stenersen, siste gang endret 02.06.2019 --> 
<!-- Denne siden er kontrollert av Alexandra Thorstensen, siste gang 02.06.2019 -->
</html>