<?php
// Denne siden er utviklet av Alexandra Thorstensen, siste gang endret 31.05.2019
include 'tilkobling.php';

session_start();

try {   
    if (isset($_POST['sendpassord'])) {
        $q = $db->prepare("SELECT * FROM bruker WHERE brukernavn = ? AND ePost = ?");
        $q->bindValue(1, $_POST['brukernavn'], PDO::PARAM_STR);
        $q->bindValue(2, $_POST['email'], PDO::PARAM_STR);
        $q->execute();
        $results=$q->fetchAll();
        
        if($q->rowCount() == 1) {
            $generere_passord = md5(time() . rand());
            include 'salt.php';
            $passord_kryptert = sha1($salt.$generere_passord);
            
            $sql = "UPDATE bruker SET passord = ? WHERE brukerNavn = ?";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(1, $passord_kryptert, PDO::PARAM_STR);
            $stmt->bindValue(2, $_POST['brukernavn'], PDO::PARAM_STR);
            $stmt->execute(); 
            
            ini_set("SMTP","s120.hbv.no");
            ini_set("smtp_port","25");
            date_default_timezone_set("Europe/Oslo");
            $til = $_POST['email'];
            $fra = "ikkesvar@usnalumni.no";
            $subject = "Ditt nye passord til USN IT Alumni!";
            $melding = "Du kan loggee inn med følgende passord " .$generere_passord;
            $headers = "From: " . $fra . "\r\n" .
                    'X-Mailer: PHP/' . phpversion() . "\r\n" .
                    "MIME-Version: 1.0\r\n" .
                    "Content-Type: text/html; charset=utf-8\r\n" .
                    "Content-Transfer-Encoding: 8bit\r\n\r\n";
            mail($til, $subject, $melding, $headers);
            header("Location: default.php");
        }
        
        else {

            
        }
    }
}
     


catch(PDOException $e) {
    echo $q . "<br>" . $e->getMessage();
}

// Denne siden er kontrollert av Alexandra Thorstensen, siste gang 31.05.2019
?>

<!DOCTYPE html>
<html>
  
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Glemt passord</title>
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
    <li class="tykkbrodsmule">Glemt passord</li>
</ul> 

<section class="glemtpassord">   
    <article class="glemtpassord-article">
        <h1>Glemt passord</h1>
		<p>Skriv inn din e-postadresse og brukernavn for å få tilsendt et nytt passord</p>
		<form method="post" action="glemtpassord.php">
            <input type="text" name="brukernavn" placeholder="Ditt brukernavn" required>
			<input type="email" name="email" placeholder="E-postadresse" required>
			<input class="skjemaknapp" type="submit" name="sendpassord" value="Send nytt passord">
		</form>
        <span id="melding" style="color: red;"><?php echo($melding); ?></span>
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
<!-- Denne siden er utviklet av Alexandra Thorstensen, siste gang endret 31.05.2019 --> 
<!-- Denne siden er kontrollert av Alexandra Thorstensen, siste gang 31.05.2019 -->
</html>