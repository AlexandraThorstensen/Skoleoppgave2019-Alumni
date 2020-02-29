<?php
// Denne siden er utviklet av David Stenersen og Alexandra Thorstensen, siste gang endret 07.02.2019
include 'session.php';
include 'tilkobling.php';

try {
    $q = $db->prepare("SELECT * FROM bruker INNER JOIN brukerprofil ON bruker.idbruker = brukerprofil.idbruker WHERE bruker.idbruker = ?");
	$q->bindValue(1, $brukerid, PDO::PARAM_INT);
	$q->execute();
	$row = $q->fetchAll(PDO::FETCH_ASSOC);
    
    $q = $db->prepare("SELECT * FROM brukerstudie INNER JOIN studie ON brukerstudie.idstudie = studie.idstudie WHERE brukerstudie.idbruker = ?");
	$q->bindValue(1, $brukerid, PDO::PARAM_INT);
	$q->execute();
	$row1 = $q->fetchAll(PDO::FETCH_ASSOC);
        
	$_SESSION['profiltekst'] = $row['profiltekst']; 
	$_SESSION['profilbilde'] = $row['profilbilde'];
    $_SESSION['studieNavn'] = $row['studieNavn'];
    $_SESSION['kull'] = $row['kull'];
    
    $path = "profilbilde/";
    $file = $row["profilbilde"];

	$q = $db->prepare("SELECT interesser.interesse FROM brukerinteresser INNER JOIN interesser ON brukerinteresser.idinteresse = interesser.idinteresse WHERE brukerinteresser.idbruker = ?");
	$q->bindValue(1, $brukerid, PDO::PARAM_INT);
	$q->execute();
    $resultat = $q->fetchAll(PDO::FETCH_ASSOC);
      
}

catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage(); //feilmelding. 
}
//Denne siden er kontrollert av Alexandra Thorstensen, siste gang 07.02.2019
?>

<!DOCTYPE html>
<html>
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Min profil</title>
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
    <li class="tykkbrodsmule">Min profil</li>
</ul> 
    	
<section class="minprofil">
    <article class="personalia-minprofil">
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
        <a href="redigerpersonalia.php"><button>Rediger personalia</button></a>
    </article>

    <article class="profiltekst-minprofil">
        <h1>Profiltekst</h1>
            <?php foreach ($row as $q): ?>
                <?php echo '<p>' .$q['profiltekst']. '</p>';?>
            <?php endforeach;?>
        <a href="redigerprofiltekst.php"><button>Rediger profiltekst</button></a>
    </article>
    
    <article class="profilbilde-minprofil">
        <h1>Profilbilde</h1>
        <?php foreach ($row as $q): ?>
        
    <img src = "<?php echo $path.$file ?>">
        
        <?php echo '<img src = "'.$path.$file.'">';?>
        
        <?php echo '<img src = "'.$path.$row["profilbilde"].'">';?>
        
        <img src="profilbilde/<?php if (isset($_SESSION['profilbilde'] )){echo $_SESSION['profilbilde'];} else {echo "eecfb60143253e626e7b31b818f671b617e1d928.png";}?>" alt="Profilbilde" class="profilbilde" width="180px">

        <?php endforeach;?>
        <a href="redigerprofilbilde.php"><button>Rediger profilbilde</button></a>
    </article>

    <article class="interesser-minprofil">
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
        <a href="redigerinteresse.php"><button>Rediger interesser</button></a>
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
<!-- Denne siden er utviklet av Alexandra Thorstensen og Malin Skår, siste gang endret 14.12.2018 --> 
<!-- Denne siden er kontrollert av Alexandra Thorstensen, siste gang 31.05.2019 -->
</html>