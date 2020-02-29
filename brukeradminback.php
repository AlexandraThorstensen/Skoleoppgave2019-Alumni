<?php
// Denne siden er utviklet av Alexandra Thorstensen , siste gang endret 06.03.2019

include 'session.php';
include 'adminsjekk.php';
include 'tilkobling.php';

try { 
    $q = $db->prepare("SELECT * FROM bruker WHERE brukerType = 'Bruker' AND idbruker <> ?;");
    $q->bindValue(1, $brukerid, PDO::PARAM_INT);
    $q->execute();
    $results=$q->fetchAll();
    $valgt_bruker = $_POST['bruker_valg'];
    
    $q = $db->prepare("SELECT * FROM bruker WHERE brukerType = 'Admin' AND idbruker <> ?;");
    $q->bindValue(1, $brukerid, PDO::PARAM_INT);
    $q->execute();
    $results1=$q->fetchAll();
    $valgt_bruker_slett = $_POST['bruker_valg_slett'];
    
    $q = $db->prepare("SELECT * FROM bruker WHERE feilLogginnSiste > NOW() - INTERVAL 15 MINUTE;");
    $q->bindValue(1, $brukerid, PDO::PARAM_INT);
    $q->execute();
    $results2=$q->fetchAll();
    $bruker_apne = $_POST['bruker_apne'];

    if (isset($_POST['search'])) {
        $sokefrase = $_POST['search'];
        $q = $db->prepare("SELECT * FROM bruker WHERE brukerNavn LIKE ?;");
        $q->bindValue(1, "%$sokefrase%", PDO::PARAM_STR);
        $q->execute();
        $results3=$q->fetchAll();
        
        $q1 = $db->prepare("SELECT bruker.brukerNavn, bruker.ePost, interesser.interesse FROM interesser INNER JOIN brukerinteresser ON interesser.idinteresse = brukerinteresser.idinteresse INNER JOIN bruker ON brukerinteresser.idbruker = bruker.idbruker WHERE interesser.interesse LIKE ?;");
        $q1->bindValue(1, "%$sokefrase%", PDO::PARAM_STR);
        $q1->execute();
        $results4=$q1->fetchAll();   
        
        $q2 = $db->prepare("SELECT bruker.brukerNavn, bruker.ePost, studieNavn FROM studie INNER JOIN brukerstudie ON studie.idstudie = brukerstudie.idstudie INNER JOIN bruker ON brukerstudie.idbruker = bruker.idbruker WHERE studie.studieNavn LIKE ?;");
        $q2->bindValue(1, "%$sokefrase%", PDO::PARAM_STR);
        $q2->execute();
        $results5=$q2->fetchAll();   
    }
    
    if (isset($_POST['bruker_valg'])) {
        $q = $db->prepare("UPDATE bruker SET brukerType = ? WHERE idbruker = ?");
        $q->bindValue(1, "Admin", PDO::PARAM_STR);
        $q->bindValue(2, $_POST['bruker_valg'], PDO::PARAM_STR);
        $q->execute();
        header("Location: brukeradminback.php");
    }
    
    if (isset($_POST['bruker_valg_slett'])) {
        $q = $db->prepare("UPDATE bruker SET brukerType = ? WHERE idbruker = ?");
        $q->bindValue(1, "Bruker", PDO::PARAM_STR);
        $q->bindValue(2, $_POST['bruker_valg_slett'], PDO::PARAM_STR);
        $q->execute();
        header("Location: brukeradminback.php");
    }
    
    if (isset($_POST['bruker_apne'])) {
        $q = $db->prepare("UPDATE bruker SET feilLogginnSiste = ? WHERE idbruker = ?");
        $q->bindValue(1, NULL, PDO::PARAM_STR);
        $q->bindValue(2, $_POST['bruker_apne'], PDO::PARAM_STR);
        $q->execute();    
    }   
}

catch(PDOException $e) {
    echo $q . "<br>" . $e->getMessage();
}

// Denne siden er kontrollert av Alexandra Thorstensen., siste gang endret 07.06.2019
?>

<!DOCTYPE html>
<html>
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Brukeradministrering</title>
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
    <li class="tykkbrodsmule">Brukeradministrering</li>
</ul> 
    
<section class="brukeradminback">    
    <article class="brukerprivilegium-article">
        <h1>Endring av brukerprivilegium</h1>
        <p>Hvis du ønsker at en bruker skal få adminrettigheter, velg bruker fra rullgardinen og trykk på "Gi adminrettighet".</p>
        <form action="brukeradminback.php" method="post">
            <select name="bruker_valg">
                <option value="" disabled selected hidden>Velg bruker</option><?php foreach ($results as $output) { ?>
                <option value ="<?php echo $output['idbruker']; ?>"><?php echo $output["brukerNavn"];?></option>
                <?php } ?>
                <input class="skjemaknapp" type="submit" name="button" value="Gi adminrettighet"/>
            </select>
        </form>

        <p class="p-margintop">Hvis du ikke vil at en admin skal ha adminrettigheter, velg bruker fra rullgardinen og trykk på "Slett adminrettighet"</p>
        <form action="brukeradminback.php" method="post">
            <select name="bruker_valg_slett">
                <option value="" disabled selected hidden>Velg bruker</option><?php foreach ($results1 as $output) { ?>
                <option value ="<?php echo $output['idbruker']; ?>"><?php echo $output["brukerNavn"];?></option>
                <?php } ?>
                <input class="skjemaknapp" type="submit" name="button" value="Slett adminrettighet"/>
            </select>                 
        </form>
    </article>
    
    <article class="utestengtbruker-article">
        <h1>Åpne utestengelse</h1>
        <p>Hvis du vil åpne en utestengelsen før tiden, velg navn fra rullegardinen og trykk på "Åpne tilgang".</p>
        <form action="brukeradminback.php" method="post">
            <select name="bruker_apne">
                <option value="" disabled selected hidden>Velg navn</option><?php foreach ($results2 as $output) { ?>
                <option value ="<?php echo $output['idbruker']; ?>"><?php echo $output["brukerNavn"];?></option>
                <?php } ?>
                <input class="skjemaknapp" type="submit" name="button" value="Åpne tilgang"/>
            </select>                 
        </form>
    </article>
    
    <article class="sokbruker-article">
        <h1>Søk</h1>
        <form method="post" action="brukeradminback.php">
            <input type="text" name="search" placeholder="Søk etter brukernavn, interesse eller studie.."  required>
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
                <?php foreach ($results3 as $row): ?>
                    <tr onclick="linkRad('profilback.php?brukernavn=<?= $row['brukerNavn'];?>');">
                        <td><?= $row['brukerNavn'];?></td>
                        <td><?= $row['ePost'];?></td>
                        <td>Brukerprofil</td>
                    </tr>
                <?php endforeach; ?>
                
                <?php foreach ($results4 as $row): ?>
                    <tr onclick="linkRad('profilback.php?brukernavn=<?= $row['brukerNavn'];?>');">
                        <td><?= $row['brukerNavn'];?></td>
                        <td><?= $row['ePost'];?></td>
                        <td>Interesse: <?= $row['interesse'];?></td>
                    </tr>
                <?php endforeach; ?>
                
                <?php foreach ($results5 as $row): ?>
                    <tr onclick="linkRad('profilback.php?brukernavn=<?= $row['brukerNavn'];?>');">
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

<footer class="footerback">
    <?php include 'footerback.php';?>
</footer>

</body>
<!-- Denne siden er utviklet av Alexandra Thorstensen, siste gang endret 06.03.2019 --> 
<!-- Denne siden er kontrollert av Alexandra Thorstensen, siste gang 07.06.2019 -->
</html>