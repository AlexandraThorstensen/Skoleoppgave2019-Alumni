<?php
//global $db;
//$dsn = "mysql:host=158.36.139.21; dbname=alumni07";
//$username = "alumni07_adm";
//$password = "aLumNi07_ADM";
$dsn = "mysql:host=localhost; dbname=alumni07";
$username = "root";
$password = "root";

$db = new PDO($dsn, $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$melding = "";
 
// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
//echo "Connected successfully";
?>