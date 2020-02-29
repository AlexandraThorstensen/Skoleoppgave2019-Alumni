<?php
include 'session.php';
include 'tilkobling.php';

try { 
    if (isset($_POST['search'])) {
        $sokefrase = $_POST['search'];
        $q = $db->prepare("SELECT * FROM bruker WHERE brukerNavn LIKE ?;");
        $q->bindValue(1, "%$sokefrase%", PDO::PARAM_STR);
        $q->execute();
        $results=$q->fetchAll();
        
        $q1 = $db->prepare("SELECT bruker.brukerNavn, bruker.ePost, interesser.interesse FROM interesser INNER JOIN brukerinteresser ON interesser.idinteresse = brukerinteresser.idinteresse INNER JOIN bruker ON brukerinteresser.idbruker = bruker.idbruker WHERE interesser.interesse LIKE ?;");
        $q1->bindValue(1, "%$sokefrase%", PDO::PARAM_STR);
        $q1->execute();
        $results1=$q1->fetchAll();
        
        $q2 = $db->prepare("SELECT bruker.brukerNavn, bruker.ePost, studieNavn FROM studie INNER JOIN brukerstudie ON studie.idstudie = brukerstudie.idstudie INNER JOIN bruker ON brukerstudie.idbruker = bruker.idbruker WHERE studie.studieNavn LIKE ?;");
        $q2->bindValue(1, "%$sokefrase%", PDO::PARAM_STR);
        $q2->execute();
        $results2=$q2->fetchAll();   
    }
}

catch(PDOException $e) {
    echo $q . "<br>" . $e->getMessage();
}

// Denne siden er kontrollert av David Stenersen., siste gang endret 02.06.2019
?>

<!DOCTYPE html>
<html>
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Finn medlemmer</title>
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
    <li class="tykkbrodsmule">Finn medlemmer</li>
</ul> 
    
<section class="finnmedlemmer">
	<article class="finnmedlemmer-article">
		<h1>Finn medlemmer</h1>
        <br><br>
        <form method="post" id="formfinnmedlemmer" action="finnmedlemmer.php">
            <input type="text" name="search" placeholder="Søk etter brukernavn eller interesse.." required>
            <input class="skjemaknapp" type="submit" id="sok" name="sok" value="SØK">
        </form>

        <table>
            <thead>
                <tr>
                    <th>Brukernavn</th>
                    <th>Epost</th>
                    <th>Type</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $row): ?>
                    <tr onclick="linkRad('profil.php?brukernavn=<?= $row['brukerNavn'];?>');">
                        <td><?= $row['brukerNavn'];?></td>
                        <td><?= $row['ePost'];?></td>
                        <td>Brukerprofil</td>
                    </tr>
                <?php endforeach; ?>
                
                <?php foreach ($results1 as $row): ?>
                    <tr onclick="linkRad('profil.php?brukernavn=<?= $row['brukerNavn'];?>');">
                        <td><?= $row['brukerNavn'];?></td>
                        <td><?= $row['ePost'];?></td>
                        <td>Interesse: <?= $row['interesse'];?></td>
                    </tr>
                <?php endforeach; ?>
                
                <?php foreach ($results2 as $row): ?>
                    <tr onclick="linkRad('profil.php?brukernavn=<?= $row['brukerNavn'];?>');">
                        <td><?= $row['brukerNavn'];?></td>
                        <td><?= $row['ePost	'];?></td>
                        <td>Studie: <?= $row['studieNavn'];?></td>
                    </tr>
                <?php endforeach; ?>  
                
            </tbody>
        </table>
    </article>
</section>
    
<button class="knapptiltoppen" onclick="topFunction()" id="knapp-til-toppen" title="Gå til topp">Til toppen</button>
    
<script>
    <?php include 'hamburgermeny.php';?>
    <?php include 'linkheleraden.php';?>
    <?php include 'knapptiltoppen.php';?>   
</script>

</main>

<footer>
    <?php include 'footer.php';?>
</footer>

</body>
<!-- Denne siden er utviklet av David Stenersen, siste gang endret 02.06.2019 --> 
<!-- Denne siden er kontrollert av Alexandra Thorstensen, siste gang 31.05.2019 -->
</html>