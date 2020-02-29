<?php
// Denne siden er utviklet av David Stenersen , siste gang endret 05.03.2019

include 'session.php';
include 'adminsjekk.php';
include 'tilkobling.php';

try {      
    $q = $db->prepare("SELECT fraBruker, max(tidspunkt) FROM meldinger WHERE tilBruker = ? GROUP BY fraBruker ORDER BY max(tidspunkt) DESC;"); 
    $q->bindValue(1, $bruker);
    $q->execute();
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
    <title>Innboks</title>
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
    <li class="tykkbrodsmule">Innboks</li>
</ul>
    
<section class="innboksmeny">
    <article class="innboksknappene">
        <a href="sendmeldingback.php"><button>Send ny melding</button></a>
    </article>
</section>

<section class="innboks"> 
    <article class="samtaleoversikt">  
        <form method="post" action="innboksback.php">
            <table>
                <thead>
                    <th class="meldingoverskrift">Avsender</th>
                    <th class="meldingoverskrift">Tidspunkt</th>
                </thead>
                
                <tbody>
                    <?php foreach ($q as $q): ?>
                    <tr onclick="linkRad('samtaleback.php?brukernavn=<?= $q['fraBruker'];?>');">       
                        <td class="meldingoversikt"><?php echo $q['fraBruker']; ?></td>
                        <td class="meldingoversikt"><?php echo $q['max(tidspunkt)']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </form>
    </article>
</section>
        
<button class="knapptiltoppen" onclick="topFunction()" id="knapp-til-toppen" title="Gå til topp">Til toppen</button>
    
<script>
    <?php include 'hamburgermeny.php';?>
    <?php include 'linkheleraden.php';?>
    <?php include 'knapptiltoppen.php';?>   
</script>

</main>

<footer class="footerback">
    <?php include 'footerback.php';?>
</footer>

</body>
<!-- Denne siden er utviklet av Malin Skår, siste gang endret 14.12.2018 --> 
<!-- Denne siden er kontrollert av Alexandra Thorstensen, siste gang 06.06.2019 -->
</html>