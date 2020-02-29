<?php
include 'session.php';
include 'adminsjekk.php';
include 'tilkobling.php';

$q = $db->prepare("SELECT * FROM regler;");
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
    <title>Vilkår for bruk</title>
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
    <li><b>Vilkår for bruk</b></li>
</ul> 
    
<section class="regler">
	<article class="regler-bruk">
	<h1>Vilkår for bruk av nettstedet</h1>
	<br><br>
    <span><?php echo $Bruk;?></span>
	<br><br>
	<a href="redigerreglerback.php"><button>Rediger vilkår for bruk av nettsted</button></a>
    <br>
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
<!-- Denne siden er kontrollert av Alexandra Thorstensen, siste gang 16.05.2019 -->
</html>