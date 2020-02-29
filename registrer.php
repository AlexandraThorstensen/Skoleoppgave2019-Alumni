<?php
// Denne siden er utviklet av David Stenersen og Alexandra Thorstensen day., siste gang endret 13.12.2018
include 'tilkobling.php';

session_start();

try {
	$bruker="";
	$email="";
	$passord="";
	$passordtest="";

	if(isset($_POST['registrerprofil'])){
		$bruker=$_POST['bruker'];
		$email=$_POST['email'];
		$passord=$_POST['passord'];
		$passordtest=$_POST['passordtest'];

}
    if (isset($_POST['registrerprofil'])) {
        $sql = "SELECT * FROM bruker WHERE brukerNavn = ?";
        $sth = $db->prepare($sql);
        
        if ($sth->execute(array($_POST['bruker']))) {
            if ($row = $sth->fetchAll()) {
                $melding = "Dette brukernavnet er opptatt, velg et nytt!";}
        
            else {
                $sql2 = "SELECT * FROM bruker WHERE ePost = ?";
                $sth2 = $db->prepare($sql2);

                if ($sth2->execute(array($_POST['email']))) {
                    if ($row = $sth2->fetchAll()) {
                        $melding = "Denne e-postadressen er allerede registrert til en profil!";}
		
                   
                    else {           
                        if ($_POST['passord'] == $_POST['passordtest']) {
                            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            include 'salt.php';
                            $passord_kryptert = sha1($salt.$_POST['passord']);
                            $sql = "INSERT INTO bruker (brukerType, brukerNavn, passord, ePost) VALUES ('Bruker','".$_POST["bruker"]."','".$passord_kryptert."','".$_POST["email"]."')";

                            $db->exec($sql);

                            $_SESSION['idbruker'] = $row['idbruker'];
                            $_SESSION['brukertype'] = $row['brukerType'];
                            $_SESSION['epost'] = $row['ePost']; 
                            $_SESSION['brukernavn'] = $row['brukerNavn']; 
                            $_SESSION['loggetinn'] = true;

                            header("Location: default.php?melding=Velkommen til USN Ringerike IT-Alumni! Din profil har nå blitt opprettet, logg inn med brukernavn og passord!");
                        }

                        else {
                            $melding = "Passord matcher ikke hverandre, skriv på dem nytt!";}
                    }
                } 
            }
        }
    }
}

catch(PDOException $e)
    {
    //echo $sql . "<br>" . $e->getMessage(); //feilmelding. 
    }

$db = null;
// Denne siden er kontrollert av Alexandra Thorstensen, siste gang 06.02.2019
?>


<!DOCTYPE html>
<html>
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>USN Ringerike IT Alumni</title>
    <link rel="stylesheet" href="css.css">
</head>
    
<body>

<main>

<nav class="hovedmenyutlogget">
    <nav class="logo-meny">
        <a href="default.php"><img class="usn-logo" src="./Bilder/USN_header_logo.png" alt="Header_logo"></a>
    </nav>
</nav>

<ul class="brodsmuler">
    <li><a href="default.php">Forside</a></li>
    <li class="tykkbrodsmule">Registrer deg</li>
</ul>
    
<section class="registrer">
	<article class="registrer-deg">
		<h1>Registrer deg</h1>
        <p>Registrer deg for å få tilgang til innholdet på siden.</p>
		<form method="post" id="formregistrer" action="registrer.php">
            <input type="text" name="bruker" autofocus placeholder="Brukernavn" required value="<?php echo $bruker;?>"<br>
			<input type="email" name="email" placeholder="E-postadresse" required value="<?php echo $email;?>"<br>
			<input type="password" name="passord" placeholder="Passord" required value="<?php echo $passord;?>"<br>
            <input type="password" name="passordtest" placeholder="Gjenta passord" required value="<?php echo $passordtest;?>"<br>
			<input class="skjemaknapp" type="submit" name="registrerprofil" value="Registrer profil"><br>
		</form> 
		<p>Allerede medlem?<br><a href="default.php">Logg inn</a></p>
        <span id="melding" style="color: red;"><?php echo($melding); ?></span>
	</article>
    
    <article class="registrer-info">
        <h1>Innloggingsinfo</h1>
		<p><strong>Brukernavn:</strong><br> Registrer valgfritt brukernavn.<br></p>
        <p><strong>E-postadresse:</strong><br> Registrer med din USN-epost.<br></p>
        <p><strong>Passord:</strong><br> Velg et passord. Passordet må være minst 8 tegn langt og bestå av små- og store bokstaver<br></p>
	</article>
</section>
    
<button class="knapptiltoppen" onclick="topFunction()" id="knapp-til-toppen" title="Gå til topp">Til toppen</button>
    
<script>
    <?php include 'hamburgermeny.php';?>
    <?php include 'knapptiltoppen.php';?>   
</script>

</main>
    
<footer>
    <?php include 'footerutlogget.php';?>
</footer>
  
</body>
<!-- Denne siden er utviklet av Alexandra Thorstensen, siste gang endret 14.12.2018 -->
<!-- Denne siden er kontrollert av Alexandra Thorstensen, siste gang 31.05.2019 -->
</html>

