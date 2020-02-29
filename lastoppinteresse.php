<?php
// Denne siden er utviklet av David Stenersen , siste gang endret 07.02.2019

include 'tilkobling.php';
include 'session.php';

if (isset($_POST['slett_valg'])) {
    $sql = "DELETE FROM brukerinteresser WHERE idinteresse = ? AND idbruker = ?";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1, $_POST['slett_valg'], PDO::PARAM_INT);
    $stmt->bindValue(2, $brukerid, PDO::PARAM_INT);
    $stmt->execute();
    if($_SESSION['brukertype'] == "Bruker"){
        header("Location: minprofil.php");
    }
    else {
        header("Location: minprofilback.php");
    }
}

if (isset($_POST['interesse_valg'])) {
    //Lagrer valgt interesse fra listeboks til brukerinteresser.
    $sql = "INSERT INTO brukerinteresser (idinteresse, idbruker)  VALUES (?,?)";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1, $_POST['interesse_valg'], PDO::PARAM_INT);
    $stmt->bindValue(2, $brukerid, PDO::PARAM_INT);
    $stmt->execute();
    if($_SESSION['brukertype'] == "Bruker"){
        header("Location: minprofil.php");
    }
    else {
        header("Location: minprofilback.php");
    }
}

if (isset($_POST['leggtil'])) {
    //Sjekk at motatt interesse ikke er opprettet.
    $q = $db->prepare("SELECT * FROM interesser WHERE interesse = :interesse;");
    $q->bindValue(':interesse', $_POST['ny_interesse']);
    $q->execute();
    $row = $q->fetch(PDO::FETCH_ASSOC);
    $_SESSION['idinteresse'] = $row['idinteresse']; 

    
    if ($q->rowCount() == 1) { 
        //Interesse allerede opprettet av annen bruker - knytter bruker til interesse.
        $sql = "INSERT INTO brukerinteresser (idinteresse, idbruker) VALUES (?,?)";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(1, $_SESSION['idinteresse'], PDO::PARAM_INT);
        $stmt->bindValue(2, $brukerid, PDO::PARAM_INT);
        $stmt->execute();
        if($_SESSION['brukertype'] == "Bruker"){
            header("Location: minprofil.php");
        }
        else {
            header("Location: minprofilback.php");
        }
    }
    
    else {
        //Både interesse og brukerinteresse lagres.
        $sql = "INSERT INTO interesser (interesse)  VALUES (?)";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(1, $_POST['ny_interesse'], PDO::PARAM_STR);
        $stmt->execute(); 
        $interessenr = $db->lastInsertId(); 
        
        $sql = "INSERT INTO brukerinteresser (idinteresse, idbruker) VALUES (?,?)";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(1, $interessenr, PDO::PARAM_INT);
        $stmt->bindValue(2, $brukerid, PDO::PARAM_INT);
        $stmt->execute();
        if($_SESSION['brukertype'] == "Bruker"){
            header("Location: minprofil.php");
        }
        else {
            header("Location: minprofilback.php");
        }
    }
}
// Denne siden er kontrollert av David Stenersen , sist kontrollert 07.02.2019
?>