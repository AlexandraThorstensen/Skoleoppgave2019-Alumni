<?php
// Denne siden er utviklet av David Stenersen Day., siste gang endret 03.02.2019

include 'session.php';
include 'tilkobling.php';

try {
    
    if (!isset($_FILES['opplastningsfil']['error']) ||
        is_array($_FILES['opplastningsfil']['error']))
    {throw new RuntimeException('Invalid parameters.');}

    switch ($_FILES['opplastningsfil']['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            throw new RuntimeException($melding = "Opplastning mislykket - ingen fil lastet opp.");
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException($melding = "Opplastning mislykket - fil overstiger maksimal filstørrelse.");
        default:
            throw new RuntimeException($melding = "Ukjent feil");
    }
    
    if ($_FILES['opplastningsfil']['size'] > 1000000) {
        throw new RuntimeException($melding = "Opplastning mislykket - fil overstiger maksimal filstørrelse.");
    }
    
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    if (false === $ext = array_search(
        $finfo->file($_FILES['opplastningsfil']['tmp_name']),
        array(
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',), true)) {
        throw new RuntimeException($melding = "Opplastning mislykket - kun filformat JPG, PNG og GIF.");
    }
    
    $filnavn = (sha1_file($_FILES['opplastningsfil']['tmp_name']) . '.' . $ext);
    
    //Hva er det her? Sjekk på om bildet allerede er i databasen?
    if (!move_uploaded_file(
        $fileHash = $_FILES['opplastningsfil']['tmp_name'],
        sprintf('./profilbilde/%s.%s',
            sha1_file($_FILES['opplastningsfil']['tmp_name']),
            $ext))) {
        throw new RuntimeException('Failed to move uploaded file.');
    }
    
    try {
        $q = $db->prepare("SELECT * FROM brukerprofil WHERE idbruker = :idbruker;");
        $q->bindValue(':idbruker', $brukerid);
        $q->execute();
        $row = $q->fetch(PDO::FETCH_ASSOC);
        
        if($q->rowCount() == 1) {
            $sql = "UPDATE brukerprofil SET profilbilde= ? WHERE idbruker= ?";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(1, $filnavn, PDO::PARAM_STR);
            $stmt->bindValue(2, $brukerid, PDO::PARAM_STR);
            $stmt->execute();
            if($_SESSION['brukertype'] == "Bruker"){
                header("Location: minprofil.php");
            }
            else {
                header("Location: minprofilback.php");
            }
        }
        
        else {
            $sql = "INSERT INTO brukerprofil (idbruker, profilbilde) VALUES (?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(1, $brukerid, PDO::PARAM_STR);
            $stmt->bindValue(2, $filnavn, PDO::PARAM_STR);
            $stmt->execute();
            if($_SESSION['brukertype'] == "Bruker"){
                header("Location: minprofil.php");
            }
            else {
                header("Location: minprofilback.php");
            }
        }

    } 
    
    catch (RuntimeException $e) {
        echo $e->getMessage();
    }
        
}

catch (RuntimeException $e) {
    echo $e->getMessage();
}
//Denne siden er kontrollert av David Stenersen, siste gang 07.02.2019
?>