<?php
// Denne siden er utviklet av David Stenersen, siste gang endret 07.02.2019
include 'session.php';
include 'adminsjekk.php';
include 'tilkobling.php';

try {
    $brukernavn = $_GET['brukernavn'];
    
    $q = $db->prepare("SELECT * FROM Bruker WHERE bruker.brukerNavn =?");
    $q->bindValue(1, $brukernavn, PDO::PARAM_STR);
    $q->execute();
    $row = $q->fetch(PDO::FETCH_ASSOC);
    $se_profil_brukerid = $row['idbruker'];    
    
    if (empty($brukernavn)) {
        header("Location: hjem.php");
    }
    
    else {
        
        $q = $db->prepare("SELECT * FROM bruker INNER JOIN brukerprofil ON bruker.idbruker = brukerprofil.idbruker WHERE bruker.idbruker = ?");
        $q->bindValue(1, $se_profil_brukerid, PDO::PARAM_INT);
        $q->execute();
        $row = $q->fetchAll(PDO::FETCH_ASSOC);

        $q = $db->prepare("SELECT * FROM brukerstudie INNER JOIN studie ON brukerstudie.idstudie = studie.idstudie WHERE brukerstudie.idbruker = ?");
        $q->bindValue(1, $se_profil_brukerid, PDO::PARAM_INT);
        $q->execute();
        $row1 = $q->fetchAll(PDO::FETCH_ASSOC);

        $Profiltekst2 = $row['profiltekst']; 
        $_SESSION['profilbilde'] = $row['profilbilde'];
        $_SESSION['studieNavn'] = $row['studieNavn'];
        $_SESSION['kull'] = $row['kull'];

        $q = $db->prepare("SELECT interesser.interesse FROM brukerinteresser INNER JOIN interesser ON brukerinteresser.idinteresse = interesser.idinteresse WHERE brukerinteresser.idbruker = ?");
        $q->bindValue(1, $se_profil_brukerid, PDO::PARAM_INT);
        $q->execute();
        $resultat = $q->fetchAll(PDO::FETCH_ASSOC);
    }
}

catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage(); //feilmelding. 
}

// Denne siden er kontrollert av Alexandra Thorstensen., siste gang endret 07.06.2019
?>

<!DOCTYPE html>
<html>
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $brukernavn;?>`s profil</title>
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
    <li><a href="brukeradminback.php">Brukeradministrering</a></li>
    <li class="tykkbrodsmule"><?php echo $brukernavn;?>`s profil</li>
</ul> 

<section class="profilmeny">
    <article class="profilknappene">
        <a href="samtale.php?brukernavn=<?php echo $brukernavn;?>"><button class="button">Send melding</button></a>
        <a href="rapportereback.php?brukernavn=<?php echo $brukernavn;?>"><button class="button">Rapportere</button></a>
        <a href="brukerhistorikkback.php?brukernavn=<?php echo $brukernavn;?>"><button class="button">Brukerhistorikk</button></a>
    </article>    
</section>
    
<section class="profil">
    <article class="personalia-profil">
        <h1>Personalia</h1>
        <span id="melding" style="color: red; float: right;"><?php $mld=$_GET['melding']; echo $mld;?></span>
        
        <?php if ($row) { ?>
            <?php foreach ($row as $q): ?>
                <?php echo '<p>Brukernavn: ' .$q['brukerNavn']. '</p>';?>
                <?php echo '<p>E-post: ' .$q['ePost']. '</p>';?>
                <?php if ($q['fornavn']) { ?>
                    <?php echo '<p>Fornavn: ' .$q['fornavn']. '</p>';?>
                <?php } ?>
                <?php if ($q['etternavn']) { ?>
                    <?php echo '<p>Etternavn: ' .$q['etternavn']. '</p>';?>
                <?php } ?>
                <?php if ($q['bosted']) { ?>
                    <?php echo '<p>Bosted: ' .$q['bosted']. '</p>';?>
                <?php } ?>
            <?php endforeach;?>

            <?php foreach ($row1 as $r): ?>
                <?php if ($r['studieNavn']) { ?>
                    <?php echo '<p>Studie: '.$r['studieNavn'].'</p>';?>      
                <?php } ?>
                <?php if ($r['kull']) { ?>
                    <?php echo '<p>Kull: '.$r['kull'].'</p>';?>      
                <?php } ?>
            <?php endforeach;?>
        <?php
            } else {
        ?>
        <p>Har ikke lagt inn personalia enda!</p>
        <?php
            }
        ?>
    </article>

    <article class="profiltekst-profil">
        <h1>Profiltekst</h1>
          <?php foreach ($row as $q): ?>
                <?php echo '<p>' .$q['profiltekst']. '</p>';?>
        <?php endforeach;?>
    </article>
    
    <article class="profilbilde-profil">
        <h1>Profilbilde</h1>
        <br><br>
        <img src="profilbilde/<?php if (isset($_SESSION['profilbilde'] )){echo $_SESSION['profilbilde'];} else {echo "eecfb60143253e626e7b31b818f671b617e1d928.png";}?>" alt="Profilbilde" class="profilbilde" width="180px">
        <br><br>
    </article>

    <article class="interesser-profil">
        <h1>Interesser</h1>
        <?php if ($resultat) { ?>
            <ul>
                <?php foreach ($resultat as $row): ?>
                    <?php if ($row['interesse']) { ?>
                        <?php echo '<li>'.$row['interesse'].'</li>';?>
                    <?php } ?>
                <?php endforeach;?>
            </ul>
        <?php
            } else {
        ?>
        <p>Har ikke lagt inn interesser enda!</p>
        <?php
            }
        ?>
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
<!-- Denne siden er utviklet av Alexandra Thorstensen og Malin Skår, siste gang endret 14.12.2018 --> 
<!-- Denne siden er kontrollert av Alexandra Thorstensen, siste gang 02.06.2019 -->
</html>