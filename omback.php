<?php
include 'session.php';
include 'adminsjekk.php';
?>

<!DOCTYPE html>
<html>
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Om oss</title>
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
    <li class="tykkbrodsmule">Om oss</li>
</ul> 
    
<section class="om">
	<article class="om-oss">
	<h1>Om USN Ringerike IT-Alumni</h1>
	<p>USN Ringerike IT-Alumni ble stiftet for at nåværende og tidligere IT-studenter ved USN Ringerike skal kunne holde kontakt etter endte studier.
	Vi har som mål at siden skal bidra til innovativ idèmyldring mellom erfarne og uerfarne mennesker innenfor IT-feltet, og har samtidig implementert øvrige funksjoner som vi mener er nyttig.
	Våre medlemmer er alltid velkommen til å foreslå forbedringer og nye funksjoner på nettstedet, og siden skal til enhver tid gjenspeile brukernes ønsker og behov.</p>
	
	<h1>Hvorfor må jeg være medlem for å kunne se innholdet på siden?</h1>
	<p>Vi ønsker å verifisere at alle våre medlemmer er nåværende eller tidligere IT-studenter ved USN Ringerike, og det er derfor forutsatt registrering med info som finnes i USN sin database. 
	Man skal kunne vise interesse for en ny jobb uten å bekymre seg for represalier på arbeidsplassen og selge bøker til seriøse interessenter. Gruppen man diskuterer IT, jobb og studier med er
	relevant - og en deler også arrangementer og ledige stillinger med en relevant gruppe mennesker. 
	
	<h1>Hvorfor skal jeg bli medlem?</h1>
	<p>Dersom du blir medlem kan du lese nyheter som er relatert til din bransje og dine interesser, du kan selge pensum som nåværende eller tidligere student, få invitasjon til interessante
	og relevante arrangementer, diskutere kode med erfarne og uerfarne mennesker, utveksle idèer og spørsmål med studenter og andre som jobber i og utenfor IT-bransjen, utlyse og søke ledige stillinger - 
	og sist men ikke minst holde kontakten med dine tidligere medstudenter.</p>
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
<!-- Denne siden er utviklet av Malin Skår, siste gang endret 12.12.2018 -->    
<!-- Denne siden er kontrollert av Alexandra Thorstensen, siste gang 04.06.2019 -->
</html>