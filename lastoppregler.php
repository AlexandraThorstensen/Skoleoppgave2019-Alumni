<?php
// Denne siden er utviklet av Malin Skår., siste gang endret 02.06.2019

include 'tilkobling.php';

try {
    $q = $db->prepare("SELECT * FROM regler;");
    $q->execute();
    $row = $q->fetch(PDO::FETCH_ASSOC);
    
	$_SESSION['bruk'] = $row['bruk']; 
	$vilkaar[] = $row['bruk'];
    
	if (isset($_POST['btnlagrebruk'])) {
        $sql = "UPDATE regler SET bruk = ? WHERE idregler=1";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(1, $_POST['vilkaar'], PDO::PARAM_STR);
        $stmt->execute(); 
        header('Location: reglerback.php');
	}
		
	if (isset($_POST['btnlagrebruk'])) {
		$handle = fopen("vilkaar/regler.html",'w');
		$output = "";
		fwrite($handle,"<!DOCTYPE html>\n");
		fwrite($handle,"<html>\n");
		fwrite($handle,"<head>\n");
		fwrite($handle,"<script language=javascript type=text/javascript>\n;
						function windowClose() {\n;
						window.open('','_parent','');\n;
						window.close();\n;
						}\n;
						</script>\n");
		fwrite($handle,"<meta charset='UTF-8'>\n");
		fwrite($handle,"<meta name='viewport' content='width=device-width, initial-scale=1'>\n");
		fwrite($handle,"<title>Vilkår for bruk</title>\n");
		fwrite($handle,"<link rel='stylesheet' href='vilkaarcss.css'>\n");
		fwrite($handle,"</head>\n");
		fwrite($handle,"<body>\n");
		fwrite($handle,"<header>\n");
		fwrite($handle,"<div class='header'> \n");
		fwrite($handle,"<p></p> \n");
		fwrite($handle,"</div> \n");
		fwrite($handle,"</header>\n");
		fwrite($handle,"<main> \n");
		fwrite($handle,"<section class='visregler'>\n");
		fwrite($handle,"<article class='regler'>\n");
		fwrite($handle,"<h1>Vilkår for bruk av nettstedet</h1> \n");
		fwrite($handle,"<br><br>\n");
		foreach($vilkaar AS $vilkaarene) {
			$output .= $vilkaarene."\n";
		}
		fwrite($handle,$output);
		fwrite($handle,"<br>\n");
		fwrite($handle,"<button class=skjemaknapp onclick=windowClose();>Lukk</button>\n");
		fwrite($handle,"</article>\n");
		fwrite($handle,"</section>\n");
		fwrite($handle,"</main>\n");
		fwrite($handle,"</body>\n");
		fwrite($handle,"</html>\n");
		fclose($handle); 
    }
}

catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage(); //feilmelding. 
    }
//Denne siden er kontrollert av Malin Skår, siste gang 02.06.2019

?>

