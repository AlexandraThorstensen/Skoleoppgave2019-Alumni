<?php
// Denne siden er utviklet av David Stenersen, siste gang endret 28.05.2019

include 'session.php';
include 'tilkobling.php';

try {
    //Spørring som viser fram alle kommende arrangement, samt om innlogget bruker har registrert påmelding.
    $q = $db->prepare("SELECT Arrangement.*, bruker.brukerNavn, EXISTS (SELECT 1 FROM brukerarrangement WHERE brukerarrangement.idarrangement = Arrangement.idarrangement AND brukerarrangement.idbruker = ?) AS paameldt FROM arrangement INNER JOIN bruker ON arrangement.opprettetAv = bruker.idbruker WHERE arrangementDato > NOW() ORDER BY arrangementDato DESC;");
    $q->bindValue(1, $brukerid, PDO::PARAM_INT);
    $q->execute();
    $results = $q->fetchAll();

    //Melde seg på arrangement.
    if (isset($_POST['paamelding'])) {
        $sql = "INSERT INTO brukerarrangement (idarrangement, idbruker)  VALUES (?,?)";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(1, $_POST['ArrangementID'], PDO::PARAM_STR);
        $stmt->bindValue(2, $brukerid, PDO::PARAM_STR);
        $stmt->execute();
        header("Location: arrangement.php");
    }  

    //Melde seg av arrangement.
    if (isset($_POST['avmelding'])) {
        $sql = "DELETE FROM brukerarrangement WHERE idarrangement = ? AND idbruker = ?";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(1, $_POST['ArrangementID'], PDO::PARAM_INT);
        $stmt->bindValue(2, $brukerid, PDO::PARAM_INT);
        $stmt->execute();
        header("Location: arrangement.php");
    }
}

catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage(); //feilmelding. 
}
?>

<!DOCTYPE html>
<html>
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Arrangement</title>
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
    <li class="tykkbrodsmule">Arrangement</li>
</ul> 

<section class="arrangementmeny">
    <article class="arrangementknappene">
        <a href="opprettarrangement.php"><button>Opprett arrangement</button></a>
        <a href="tidligerearrangement.php"><button>Se tidligere arrangement</button></a>
    </article>
</section>
    
<section class="arrangement">
    <?php foreach ($results as $q): ?>
        <article class="allearrangement">
            <?php
            echo '<p class="tidspunktopprettet">Opprettet ' .$q['tidspunkt']. '<br>Av <a style="font-weight: 900" href="profil.php?brukernavn='.$q['brukerNavn'].'">'.$q['brukerNavn'].'</a></p>';
            echo '<h1>' .$q['arrangementNavn']. '</h1>';
            echo '<p class="dato">Tidspunkt: '  .$q['arrangementDato']. '</p>' ;
            echo '<p class="sted">Sted: '  .$q['arrangementSted']. '</p>' ;
            echo '<p>Beskrivelse: ' .$q['arrangementTekst']. '</p>';

            if ($resultat['brukerarrangement.idbruker'] == NULL) {
                echo '<p>Påmeldte: Det er ingen påmeldte</p>';
            }

            else {
                echo '<p>Påmeldte: ' .$resultat['brukerarrangement.idbruker']. '</p>';
            }

            //Om innlogget bruker allerede har meldt påmelding til arrangementet kommer dette formet tilgjengelig.
            if ($q['paameldt'] == 1) {
                echo '<form action="" method="post">';
                echo '<input type="hidden" name="ArrangementID" value="' .$q['idarrangement']. '">';
                echo '<input class="skjemaknapp" type="submit" name="avmelding" value="Meld meg av">';
                echo '</form>';
            }

            //Om innlogget bruker allerede har meldt påmelding til arrangementet kommer dette formet tilgjengelig.            
            else {
                echo '<form action="" method="post">';
                echo '<input type="hidden" name="ArrangementID" value="' .$q['idarrangement']. '">';
                echo '<input class="skjemaknapp" type="submit" name="paamelding" value="Meld meg på">';
                echo '</form>';    
            }
            ?>
        </article>
    <?php endforeach;?>
    
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
<!-- Denne siden er utviklet av David Stenersen, siste gang endret 28.05.2019 -->  
<!-- Denne siden er kontrollert av Alexandra Thorstensen, siste gang 31.05.2019 -->
</html>