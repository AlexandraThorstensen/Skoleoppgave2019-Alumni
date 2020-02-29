<?php
// Denne siden er utviklet av David Stenersen og Alexandra Thorstensen, siste gang endret 13.12.2018
include 'tilkobling.php';

session_start();

if (isset($_POST['logginn'])) {
    
    $sql = "SELECT * FROM bruker WHERE (brukerNavn = ? and passord = ?) AND (feilLogginnSiste < NOW() - INTERVAL 10 MINUTE OR feilLogginnSiste IS NULL);";
    $sth = $db->prepare($sql);

    include 'salt.php';
    $passord_kryptert = sha1($salt.$_POST['passord']);
    if ($sth->execute(array($_POST['bruker'], $passord_kryptert))) {
        
        $melding = "Feil brukernavn eller passord.";
        
        if ($row = $sth->fetch()) {
            $_SESSION['idbruker'] = $row['idbruker'];
            $_SESSION['brukertype'] = $row['brukerType'];
            $_SESSION['epost'] = $row['ePost']; 
            $_SESSION['brukernavn'] = $row['brukerNavn']; 
            $_SESSION['loggetinn'] = true;

            if($_SESSION['brukertype'] == "Admin"){
                //Login gjennomført, tilbakestill feilLogginnnTeller.
                $sql = "UPDATE bruker SET feilLogginnnTeller = '0', sistInnlogget = NOW() WHERE brukerNavn = ?";
                $stmt = $db->prepare($sql);
                $stmt->bindValue(1, $_POST['bruker'], PDO::PARAM_STR);
                $stmt->execute();
                header("Location: hjemback.php");}
            
            else {
                //Login gjennomført, tilbakestill feilLogginnnTeller.
                $sql = "UPDATE bruker SET feilLogginnnTeller = '0', sistInnlogget = NOW() WHERE brukerNavn = ?";
                $stmt = $db->prepare($sql);
                $stmt->bindValue(1, $_POST['bruker'], PDO::PARAM_STR);
                $stmt->execute();
                header("Location: hjem.php");}
        }

        else {
            //Login feilet, søker etter brukernavn og feilLogginnnTeller.
            $q = $db->prepare("SELECT * FROM bruker WHERE brukerNavn = ?;");
            $q->bindValue(1, $_POST['bruker']);
            $q->execute();
            $row = $q->fetch(PDO::FETCH_ASSOC);
            
            $_SESSION['feilLogginnnTeller'] = $row['feilLogginnnTeller'];
            
            if ($q->rowCount() == 1) { 
                //Rad funnet, vi tar verdien, legger til 1 antall mislykket forsøk, og oppdaterer databasen.
                $result = $row['feilLogginnnTeller'] + 1;
                $IPadresse = $_SERVER['REMOTE_ADDR'];
                $sql = "UPDATE bruker SET feilLogginnnTeller = ?, feilIP = ? WHERE brukerNavn = ?";
                $stmt = $db->prepare($sql);
                $stmt->bindValue(1, $result, PDO::PARAM_INT);
                $stmt->bindValue(2, $IPadresse, PDO::PARAM_STR);
                $stmt->bindValue(3, $_POST['bruker'], PDO::PARAM_STR);
                $stmt->execute();
                $melding = "Feil brukernavn eller passord - maks fem mislykkede forsøk.";

                if($result > 4) {
                    //Teller har oversteget 3 mislykkede forsøk - feilLogginnSiste oppdateres med tidspunkt.
                    $sql = "UPDATE bruker SET feilLogginnSiste = NOW() WHERE brukerNavn = ?";
                    $stmt = $db->prepare($sql);
                    $stmt->bindValue(1, $_POST['bruker'], PDO::PARAM_STR);
                    $stmt->execute();
                    $melding = "Maks antall mislykkede forsøk oppnådd, prøv igjen om 10 minutter.";
                    var_dump($stmt);}
            }
        }
    }
}

// Denne siden er kontrollert av Alexandra Thorstensen og David Stenersen, siste gang 28.01.2019
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
    <li class="tykkbrodsmule">Forside</li>
</ul> 

<section class="default">   
    <article class="logg-inn">
        <h1>Eksisterende bruker</h1>
		<p>Logg inn med ditt brukernavn for å få tilgang til innhold</p>
		<form method="post" action="default.php">
			<input type="text" id="bruker" name="bruker" autofocus placeholder="Brukernavn" maxlength="45" required>
			<input type="password" id="passord" name="passord" autofocus placeholder="Passord" maxlength="40" required>
			<input class="skjemaknapp" type="submit" id="logginn" name="logginn" value="Logg inn">
		</form>
        <p><a href="glemtpassord.php">Glemt passord?</a></p>
        <span id="melding" style="color: red;"><?php echo($melding); ?></span>
        <?php $mld=$_GET['melding']; echo $mld;?>
	</article>
	
	<article class="ny-bruker">
		<h1>Ny bruker?</h1>
		<p>Medlemskap er gratis, men en forutsetning for å kunne bruke siden.<br> 
		Registrer deg for å holde kontakten med nåværende og tidligere studenter. 
        <a href="registrer.php"><button class="knapp-til-registrer">Registrer deg</button></a></p>
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
<!-- Denne siden er utviklet av Alexandra Thorstensen, siste gang endret 06.03.2019 --> 
<!-- Denne siden er kontrollert av Alexandra Thorstensen, siste gang 31.05.2019 -->
</html>