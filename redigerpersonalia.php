<?php
include 'session.php';
include 'tilkobling.php';

try {
    if (isset($_POST['oppdaterpersonalia'])) {
        $q = $db->prepare("SELECT * FROM brukerprofil WHERE idbruker = ?");
        $q->bindValue(1, $brukerid, PDO::PARAM_INT);
        $q->execute();
        $resultat = $q->fetch(PDO::FETCH_ASSOC);
        
        $_SESSION['fornavn'] = $resultat['fornavn'];
        $_SESSION['etternavn'] = $resultat['etternavn'];
        $_SESSION['bosted'] = $resultat['bosted'];
        
        if($brukerid AND $resultat['fornavn'] == NULL) { 
                $sql = "INSERT INTO brukerprofil (idbruker, fornavn)  VALUES (?,?)";
                $stmt = $db->prepare($sql);
                $stmt->bindValue(1, $brukerid, PDO::PARAM_INT);
                $stmt->bindValue(2, $_POST['fornavn'], PDO::PARAM_STR);
                $stmt->execute(); 
                header("Location: minprofil.php?melding=Fornavn er oppdatert!");
        }
        
        else {
            $sql = "UPDATE brukerprofil SET fornavn=? WHERE idbruker=?";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(1, $_POST['fornavn'], PDO::PARAM_STR);
            $stmt->bindValue(2, $brukerid, PDO::PARAM_INT);
            $stmt->execute(); 
            header("Location: minprofil.php");
            header("Location: minprofil.php?melding=Fornavn er oppdatert!");
        }
        
        
        //else if($resultat['etternavn'] == NULL) { 
        //    $sql = "INSERT INTO brukerprofil (idbruker, etternavn)  VALUES (?,?)";
        //    $stmt = $db->prepare($sql);
        //    $stmt->bindValue(1, $brukerid, PDO::PARAM_INT);
        //    $stmt->bindValue(2, $_POST['etternavn'], PDO::PARAM_STR);
        //    $stmt->execute(); 
        //    header("Location: minprofil.php");
        //}
        
        //else if($resultat['bosted'] == NULL) { 
        //    $sql = "INSERT INTO brukerprofil (idbruker, bosted)  VALUES (?,?)";
        //    $stmt = $db->prepare($sql);
        //    $stmt->bindValue(1, $brukerid, PDO::PARAM_INT);
        //    $stmt->bindValue(2, $_POST['bosted'], PDO::PARAM_STR);
        //    $stmt->execute(); 
        //    header("Location: minprofil.php");
        //}
    }
    
    $q = $db->prepare("SELECT * FROM studie");
    $q->execute();
    $resultat1=$q->fetchAll();
    
    if (isset($_POST['oppdaterstudie'])) {
        $q = $db->prepare("SELECT * FROM brukerstudie WHERE idbruker = ?");
        $q->bindValue(1, $brukerid, PDO::PARAM_INT);
        $q->execute();
        $row = $q->fetch(PDO::FETCH_ASSOC);
    
        if($q->rowCount() == 1) { 
            $sql = "UPDATE brukerstudie SET idstudie=? AND kull=? WHERE idbruker=? AND kull=?";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(1, $_POST['studie_valg'], PDO::PARAM_STR);
            $stmt->bindValue(2, $_POST['kull'], PDO::PARAM_STR);
            $stmt->bindValue(3, $brukerid, PDO::PARAM_INT);
            $stmt->bindValue(4, $_POST['kull'], PDO::PARAM_INT);
            $stmt->execute(); 
            header("Location: minprofil.php");
        }
    
        else {
            $sql = "INSERT INTO brukerstudie (idstudie, idbruker, kull)  VALUES (?,?,?)";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(1, $_POST['studie_valg'], PDO::PARAM_INT);
            $stmt->bindValue(2, $brukerid, PDO::PARAM_INT);
            $stmt->bindValue(3, $_POST['kull'], PDO::PARAM_INT);
            $stmt->execute();
            header("Location: minprofil.php");
        }
    }
    
    if (isset($_POST['byttpassord'])) {
        if ($_POST['nyttpassord'] == $_POST['bekreftnyttpassord']) {
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            include 'salt.php';
            $nyttpassord_kryptert = sha1($salt.$_POST['nyttpassord']);
            $sql = "UPDATE bruker SET passord = '".$nyttpassord_kryptert."' WHERE idbruker = '".$brukerid."'";
            $db->exec($sql);

            header("Location: minprofil.php?melding=Ditt passord er endret!");
        }
    
        else {
            $melding = "Passord matcher ikke hverandre, skriv på dem nytt!";
        }    
    } 
        
    if (isset($_POST['byttepost']) == "Bytt epost") {
        $sql = "SELECT * FROM bruker WHERE ePost = ?";
        $sth = $db->prepare($sql);
        if ($sth->execute(array($_POST['gammelepost']))) {
            if ($row = $sth->fetchAll()) {
                if ($_POST['nyepost'] == $_POST['bekreftnyepost']) {
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = "UPDATE bruker SET ePost = '".$_POST["bekreftnyepost"]."' WHERE idbruker = '".$brukerid."'";
                    $db->exec($sql);
                    header("Location: minprofil.php?melding=Din epostadresse har blitt endret!");
                }

                else {
                    $melding1 = "Epostadressene matcher ikke hverandre, skriv på dem nytt!";
                }
            }
            else {
                $melding1 = "Feil epostadresse!";
            }
        }
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
    <title>Min profil</title>
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
    <li><a href="minprofil.php">Min profil</a></li>
    <li class="tykkbrodsmule">Rediger personalia</li>
</ul> 
    	
<section class="redigerpersonalia">
	<article class="byttpersonalia">
        <h1>Personalia</h1>
            <form method="post" action="redigerpersonalia.php">
                <input type="text" id="fornavn" name="fornavn" autofocus placeholder="Fornavn"><br>
                <input type="text" id="etternavn" name="etternavn" placeholder="Etternavn"><br>
                <input type="text" id="bosted" name="bosted" placeholder="Bosted"><br>
                <input class="skjemaknapp" type="submit" name="oppdaterpersonalia" value="Oppdater Personalia">
            </form>
    </article>
    
    <article class="byttstudie">
        <h1>Studie</h1>
            <form method="post" action="">
                <select name="studie_valg">
                    <option value="" disabled selected hidden>Velg studie</option>
                    <?php foreach ($resultat1 as $output) { ?>
                    <option value ="<?php echo $output['idstudie']; ?>"><?php echo $output['studieNavn'];?></option>
                    <?php } ?>
                </select>
                <input type="number" name="kull" min="1980" max="<?php echo date("Y"); ?>" placeholder="Kull">
                <input class="skjemaknapp" type="submit" name="oppdaterstudie" value="Oppdater Studie">
            </form>
    </article>
	
    <article class="byttpassord">
        <h1>Bytt passord</h1>
            <form method="post" name="byttpassord" action="redigerpersonalia.php">
                <input type="password" id="nyttpassord" name="nyttpassord" placeholder="Oppgi nytt passord"><br>
				<input type="password" id="bekreftnyttpassord" name="bekreftnyttpassord" placeholder="Bekreft nytt passord"><br>
				<input class="skjemaknapp" type="submit" name="byttpassord" value="Endre passord">
			</form>
            <span id="melding" style="color: red;"><?php echo($melding); ?></span>
            <br>
    </article>
        
    <article class="byttepost">
        <h1>Bytt epost</h1>
            <form method="post" name="byttepost" action="redigerpersonalia.php">
                <input type="email" id="gammelepost" name="gammelepost" placeholder="Oppgi gammel epost" required>
                <br>
				<input type="email" id="nyepost" name="nyepost" placeholder="Oppgi ny epost" required><br>
				<input type="email" id="bekreftnyepost" name="bekreftnyepost" placeholder="Bekreft ny epost" required><br>
				<input class="skjemaknapp" type="submit" name="byttepost" value="Bytt epost">
			</form>
            <span id="melding" style="color: red;"><?php echo($melding1); ?></span>
            <br>
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
<!-- Denne siden er utviklet av Alexandra Thorstensen og Malin Skår, siste gang endret 14.12.2018 --> 
<!-- Denne siden er kontrollert av Alexandra Thorstensen, siste gang 31.05.2019 -->
</html>