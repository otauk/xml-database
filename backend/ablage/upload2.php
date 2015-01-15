<?
// Verzeichnis für Bilder-Upload
$target = $_SERVER['DOCUMENT_ROOT']."xml/backend/upload/";
$target = $target . basename( $_FILES['document']['name']);
// Variablen einsammeln
$kunden_id = $_POST["kunden_id"];
$invoice_no = $_POST["invoice_no"];
$invoice_date = $_POST["invoice_date"];
$document=($_FILES['document']['name']);

// Formular gesendet?
if (isset ($_POST["upload"])) {
	if (empty($document)) {$fehler .= "<div class='alert red margin-tb-15 w50'>Keine Datei ausgewählt</div>";}
	// Dateityp XML?
	if (!empty($document)) {
		$type = explode(".",$document);
		if(strtolower(end($type)) != 'xml') {$fehler .= "<div class='alert red margin-tb-15 w50'>Bitte nur XML-Dateien hochladen</div>";}
	}
		//  Nur wenn KEINE Fehler vorliegen, hier weiter
			if (empty($fehler)) {
		// Eintrag vornehmen
		/*
		$sqlab = 	"INSERT INTO docs_db
					(kunden_id, invoice_no, document, invoice_date)
					VALUES ('$kunden_id', '$invoice_no', '$document', '$invoice_date')";
		$query = mysqli_query ($con, $sqlab);
		$query or die ("<p>A fatal MySQL error occured</p>.\n<br />Query: " . $query . "<br />\nError: (" . mysqli_errno() . ") " . mysqli_error());
		*/
		// Bilder-Upload?
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
			else $confirmation = "<div class='alert green'>Daten erfolgreich &uuml;bernommen</div>";
		}
		// Abbruch
		else {$confirmation = $fehler;}
}
?>