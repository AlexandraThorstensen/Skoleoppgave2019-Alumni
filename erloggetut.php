<?php
// Denne siden er utviklet av Alexandra Thorstensen day., siste gang endret 13.12.2018

session_start();
unset($_SESSION['brukernavn']);
session_destroy();

header("Location: default.php");
// Denne siden er kontrollert av David Stenersen, siste gang 24.01.2019
?>