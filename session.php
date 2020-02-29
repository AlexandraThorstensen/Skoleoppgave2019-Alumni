<?php
// Denne siden er utviklet av David Stenersen Day., siste gang endret 13.12.2018
session_start();

$brukerid = $_SESSION['idbruker'];
$brukertype = $_SESSION['brukertype'];
$bruker = $_SESSION['brukernavn'];
$epost = $_SESSION['epost'];
$profiltxt = $_SESSION['profiltekst'];
$profilbilde = $_SESSION['profilbilde'];

$melding = $_SESSION['melding'];

if (isset($_SESSION['loggetinn']) == true) {
} 
else {
    header("Location: default.php");
}

// Denne siden er kontrollert av Alexandra Thorstensen og David Stenersen, siste gang 28.01.2019

?>