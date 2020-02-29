<?php
// Denne siden er utviklet av David Stenersen, siste gang endret 05.05.2019

include 'session.php';
include 'tilkobling.php';

try { 
    $avsender = $_GET['brukernavn'];
    
    if (empty($avsender)) {
        header("Location: hjem.php");
    }
    
    //Spørring som henter samtale
    $q = $db->prepare("SELECT * FROM meldinger WHERE (tilBruker=? AND fraBruker = ?) OR (tilBruker=? AND fraBruker=?) ORDER BY tidspunkt DESC;");
    $q->bindValue(1, $bruker, PDO::PARAM_STR);
    $q->bindValue(2, $avsender, PDO::PARAM_STR);
    $q->bindValue(3, $avsender, PDO::PARAM_STR);
    $q->bindValue(4, $bruker, PDO::PARAM_STR);
    $q->execute();
    
    //Spørring som oppdaterer lest samtale.
    $sql = "UPDATE meldinger SET mottakerLest = NOW() WHERE mottakerLest is null AND tilBruker = ? AND frabruker = ?;";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1, $bruker, PDO::PARAM_STR);
    $stmt->bindValue(2, $avsender, PDO::PARAM_STR);
    $stmt->execute(); 
    
    //Spørring etter profilbilde til mottaker.
    $q1 = $db->prepare("SELECT brukerprofil.profilbilde FROM bruker INNER JOIN brukerprofil ON bruker.idbruker = brukerprofil.idbruker WHERE bruker.brukerNavn = ?;");
    $q1->bindValue(1, $avsender, PDO::PARAM_STR);
    $q1->execute();
    $row = $q1->fetch(PDO::FETCH_ASSOC);
    $profilbilde_mottaker = $row['profilbilde'];  
    
    //Spørring etter profilbilde til bruker.
    $q2 = $db->prepare("SELECT brukerprofil.profilbilde FROM bruker INNER JOIN brukerprofil ON bruker.idbruker = brukerprofil.idbruker WHERE bruker.brukerNavn = ?;");
    $q2->bindValue(1, $bruker, PDO::PARAM_STR);
    $q2->execute();
    $row1 = $q2->fetch(PDO::FETCH_ASSOC);
    $Profilbilde= row1['profilbilde'];  
    $_SESSION['profilbilde'] = $row1['profilbilde'];
    
    if (isset($_POST['sendsamtale'])) {
        $sql = "INSERT INTO meldinger (tilBruker, fraBruker, melding)  VALUES (?,?,?)";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(1, $avsender, PDO::PARAM_STR);
        $stmt->bindValue(2, $bruker, PDO::PARAM_STR);
        $stmt->bindValue(3, $_POST['tekst'], PDO::PARAM_STR);
        $stmt->execute();
        header( "Location: samtale.php?brukernavn=".$avsender);
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
    <title>Samtale i innboks</title>
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
    <li class="tykkbrodsmule">Samtale med <?php echo $avsender;?></li>
</ul> 
    
<section class="innbokssamtale"> 
    <article class="samtaler">
        <h1>Samtale med <?php echo $avsender;?></h1>
            <?php foreach ($q as $q): ?>
        
            <?php 
            if ($q['fraBruker'] == $bruker){
                echo '<article class="samtaleboble degselv">';
                if (isset($_SESSION['profilbilde'])){
                    echo '<img src="profilbilde/' .$_SESSION['profilbilde']. '"alt="Avatar" class="right" style="width:100%;">';} 
                else {
                    echo '<img src="profilbilde/eecfb60143253e626e7b31b818f671b617e1d928.png" alt="Avatar" class="right" style="width:100%;"';}
                echo '<p>' .$q['melding']. '</p>' ;
                echo '<span class="tidspunktopprettet">' .$q['tidspunkt']. '</span>';
                echo '</article>';}
        
            else {
                echo '<article class="samtaleboble">';
                if (isset($profilbilde_mottaker)){
                    echo '<img src="profilbilde/'.$profilbilde_mottaker.'"alt="Avatar" style="width:100%;">';} 
                else {
                    echo '<img src="profilbilde/eecfb60143253e626e7b31b818f671b617e1d928.png"';}
                echo '<p>' .$q['melding']. '<p>' ;
                echo '<span class="tidspunktopprettet">'.$q['tidspunkt'].'</span>' ;
                echo '</article>';}
            ?>
            
            <?php endforeach;?>
         </article>
    
    <article class="skrivmld">
        <form method="post" id="form1" action="samtale.php?brukernavn=<?php echo $avsender;?>">
            <textarea maxlength="1000" name="tekst" placeholder="<?php echo "Skriv melding til ", $avsender;?>" placeholder="tekst"></textarea>
            <input class="skjemaknapp" type="submit" name="sendsamtale" value="Send">
        </form>
    </article>      
</section>
    
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

</html>