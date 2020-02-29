<?php
// Denne siden er utviklet av David Stenersen Day., siste gang endret 07.02.2019

include 'session.php';
include 'tilkobling.php';

try {
    if (isset($_POST['minprofilknapp'])) {
        $q = $db->prepare("SELECT * FROM brukerprofil WHERE idbruker = :idbruker;");
        $q->bindValue(':idbruker', $brukerid);
        $q->execute();
        $row = $q->fetch(PDO::FETCH_ASSOC);

        if($q->rowCount() == 1) { 
            $sql = "UPDATE brukerprofil SET profiltekst=? WHERE idbruker=?";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(1, $_POST['tekst'], PDO::PARAM_STR);
            $stmt->bindValue(2, $brukerid, PDO::PARAM_INT);
            $stmt->execute(); 
            header("Location: minprofil.php");
        }

        else { 
            $sql = "INSERT INTO brukerprofil (idbruker, profiltekst)  VALUES (?,?)";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(1, $brukerid, PDO::PARAM_INT);
            $stmt->bindValue(2, $_POST['tekst'], PDO::PARAM_STR);
            $stmt->execute(); 
            header("Location: minprofil.php");
        }
    }
}

catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage(); //feilmelding. 
}
//Denne siden er kontrollert av David Stenersen, siste gang 07.02.2019
?>

<!DOCTYPE html>

<html>
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rediger profiltekst</title>
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
    <li class="tykkbrodsmule">Redigere profiltekst</li>
</ul> 
 
<section class="redigerprofiltekst">
    <article class="profiltekst">
        <h1>Profiltekst</h1>
            <form method="post" id="form1" action="redigerprofiltekst.php">
                <textarea maxlength="500" name="tekst" placeholder="Vennligst legg inn profilinformasjon - maks 500 tegn." placeholder="tekst"><?php echo $profiltxt;?></textarea>
                <input class="skjemaknapp" type="submit" name="minprofilknapp" value="Oppdater">
                <br>
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
<!-- Denne siden er utviklet av David Stenersen, siste gang endret 07.02.2019 --> 
<!-- Denne siden er kontrollert av Alexandra Thorstensen, siste gang 31.05.2019 -->
</html>