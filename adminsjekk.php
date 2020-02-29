<?php
include 'session.php';
include 'tilkobling.php';

if($_SESSION['brukertype'] == "Bruker"){
    $sql = "INSERT INTO rapporter (rapportertAv, rapportertMot, beskrivelse, kategori) VALUES (?,?,?,?)";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1, $bruker, PDO::PARAM_STR);
    $stmt->bindValue(2, $bruker, PDO::PARAM_STR);
    $stmt->bindValue(3, "Bruker prøver å få tilgang til admin-område", PDO::PARAM_STR);
    $stmt->bindValue(4, "Sikkerhetstrussel", PDO::PARAM_STR);
    $stmt->execute();
    
    unset($_SESSION['brukernavn']);
    session_destroy();
    header("Location: default.php");   
;}

?>