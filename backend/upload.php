<?php
// Verzeichnis für Bilder-Upload
$target = $_SERVER['DOCUMENT_ROOT']."xml/backend/upload/";
$target = $target . basename( $_FILES['document']['name']);
$document=($_FILES['document']['name']);
// Variablen einsammeln
$lieferdatum = $_POST["lieferdatum"];
$rechnungsnummer = $_POST["rechnungsnummer"];
$auftragsnummer = $_POST["auftragsnummer"];
$kunde = $_POST["kunde"];
$patient = $_POST["patient"];

// Upload gesendet?
if (isset ($_POST["upload"])) {
	if (empty($document)) {$fehler .= "<div class='alert red margin-tb-15 w50'>Keine Datei ausgewählt</div>";}
	// Dateityp XML?
	if (!empty($document)) {
		$type = explode(".",$document);
		if(strtolower(end($type)) != 'xml') {$fehler .= "<div class='alert red margin-tb-15 w50'>Bitte nur XML-Dateien hochladen</div>";}
	}
		//  Nur wenn KEINE Fehler vorliegen, hier weiter
		if (empty($fehler)) {
			if ($document!=NULL) {
				if(move_uploaded_file($_FILES['document']['tmp_name'], $target)) {
				//Tells you if its all ok
				$confirmation = "<div class='alert green'>Upload  erfolgreich</div>";
				}
				else {
				//Gives and error if its not
				$confirmation = "<div class='alert red'>Sorry, there was a problem uploading your file.</div>";
				}
			}
		}
		// Abbruch
		else {$confirmation = $fehler;}
}

// Patient gesendet?
if (isset ($_POST["entry"])) {
	if (empty($patient)) {$entryfehler .= "<div class='alert red margin-tb-15 w50'>Bitte geben Sie den Namen des Patienten an</div>";}
	if (empty($entryfehler)) {
	// Eintrag vornehmens
		$sqlab = 	"INSERT INTO docs_db
					(kunden_id, lieferdatum, rechnungsnummer, auftragsnummer, document, patient)
					VALUES ('$kunde', '$lieferdatum', '$rechnungsnummer', '$auftragsnummer', '$document', '$patient')";
		$query = mysqli_query ($con, $sqlab);
		$query or die;
		$confirmation = "<div class='alert green'>Daten erfolgreich &uuml;bernommen</div>";
		header ("LOCATION: mitarbeiter_ausgabe.php");
	}
	else {$confirmation = $entryfehler;}
}
?>