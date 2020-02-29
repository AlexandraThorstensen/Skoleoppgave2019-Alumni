<?php
include 'tilkobling.php';
include 'session.php';
include 'adminsjekk.php';

$q = $db->prepare("SELECT bruk FROM regler;");
$q->execute();
$row = $q->fetch(PDO::FETCH_ASSOC);

$_SESSION['bruk'] = $row['bruk']; 
$Bruk = $row['bruk'];
?>

<!DOCTYPE html>

<html>
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Redigere vilkår</title>
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
    <li><a href="reglerback.php">Vilkår for bruk</a></li>
    <li><b>Redigere vilkår</b></li>
</ul> 
 
<section class="rediger">
    <article class="bruk">
        <h1>Endre vilkår for bruk av nettsted</h1>
        <!–– Må gjøres responsiv, endre skrift-str i tekst i boks ––>
            <form method="post" id="form1" action="lastoppregler.php">
                <br>
                <textarea maxlength="5000" name="vilkaar" placeholder="Legg inn vilkår for bruk av nettsted - maks 1000 tegn." placeholder="vilkaar"><?php echo $Bruk;?></textarea>
                <br><br>
                <input class="skjemaknapp" type="submit" name="btnlagrebruk" value="Lagre endringer">
            </form>
    </article>
	
	<article class="hjelpetekst-bruk">
	<h1>Hjelp til formatering av tekst</h1>
	<h2>For overskrift:</h2> 
	<p>&lt;h2&gt; Tittel på overskrift &lt;/h2&gt;</p><br>
	<h2>For linjeskift:</h2>
	<p>Dette er linje èn, etter denne setningen vil jeg begynne på ny linje. &lt;br&gt;<br> 
	Dette er linje to.</p>
	
	</article>
</section>

    
<button class="knapptiltoppen" onclick="topFunction()" id="knapp-til-toppen" title="Gå til topp">Til toppen</button>
    
<script>
    <?php include 'hamburgermeny.php';?>
    <?php include 'knapptiltoppen.php';?>   
</script>

</main>

<footer class="footerback">
    <?php include 'footerback.php';?>
</footer>

</body>
<!-- Denne siden er utviklet av Malin Skår, siste gang endret 15.05.2019 --> 
<!-- Denne siden er kontrollert av Alexandra Thorstensen, siste gang 16.05.2019 -->
</html>