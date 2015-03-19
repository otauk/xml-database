<?php session_start();
include ("../login/bin/login_func.php");
loggedInUser();
include("header_backend.php");
// ##################### Variablen #####################
$check = $_POST["check"];
$kunden_id = $_POST["kunden_id"];
$name = $_POST["name"];
$mail = $_POST["mail"];
$fehler = "";
$confirmation = "";
// ##################### Gesendet? #####################
if (isset ($_POST["check"])) {
			// db-Verbindung herstellen
		include("../conn.php");
		$kunden_id_check = "SELECT kunden_id FROM kunden_db";
		$kunden_id_result = $con->query($kunden_id_check);
// ##################### Validierung #####################
	$reg_kunden_id = "/^[0-9]+$/";
	if (empty($kunden_id)) {
		$fehler .= "<div class='alert red margin-tb-15 w50'>Bitte geben Sie eine Kunden-ID an</div>";
	}
	else if (strlen($kunden_id) < 4 OR strlen($kunden_id) > 7) {
		$fehler .= "<div class='alert red margin-tb-15 w50'>Kunden-ID muss zwischen 4 und 7 Stellen haben</div>";
	}
	else if (!preg_match($reg_kunden_id,$kunden_id)) {
		$fehler .= "<div class='alert red margin-tb-15 w50'>Keine gültige Kunden-ID!</div>";
	}
	while($row = $kunden_id_result->fetch_assoc()) {
			if($row["kunden_id"] == $kunden_id) {
				$fehler .= "<div class='alert red margin-tb-15 w50'>Kunden-ID bereits vergeben!</div>";
			}
		}
	if (empty($name)) {
		$fehler .= "<div class='alert red margin-tb-15 w50'>Bitte geben Sie den Namen des Kunden an</div>";
	}
// Nur wenn KEINE Fehler vorliegen, hier weiter...
	if (empty($fehler)) {
		// Wurde das Formular gesendet?
		if (isset($_POST["ak"])) {
			// NEUER EINTRAG
			if($_POST["ak"]=="in") {
				$sqlab = 	"INSERT INTO kunden_db
								(kunden_id, name) values (
								'$kunden_id',
								'$name'
								)";
				mysqli_query ($con, $sqlab);
				$confirmation = "<div class='alert green margin-tb-15 w50'>Der Eintrag wurde erfolgreich gespeichert</div>";
				include("../include/log_entry.php");
				log_entry("Neuen Kunden >>$name<< angelegt");
			}
		}
		// ...sonst hier weiter:
// ##################### Fehlermeldung #####################
	} // Ende if (emtpy $fehler)
	// Fehlermeldung ausgeben
	else $confirmation = $fehler;
// ##################### Formularausgabe #####################
}// Ende gesamte Aktion
 ?>
		<div class="main">
			<div class="content">
				<div class="text">
					<h1>Kundenverwaltung</h1>
					<h2>Kunde erfassen</h2>
					<?=$confirmation;?>
					<form name='f' action='kunden_neuanlage.php' method='POST'>
						<input name='ak' type='hidden' value='in'/>
						<input name='id' type='hidden' />
						<input name='check' type='hidden' value='1'/>
						<div class="fieldname">Kunden-ID (z.B. 1234567):</div>
						<input class="textfield" type="text" name='kunden_id' size='50' maxlength="7" required='required' placeholder='12345' value="<?=$kunden_id;?>"/>
						<div class="fieldname">Name (z.B. Zahnarztpraxis Meier):</div>
						<input class="textfield"  type="text" name='name' size='50' required='required' placeholder='Name des Kunden' value="<?=$name;?>"/>
					<div class="topspace"></div>
					<a  class='form_btn submit' onClick='javascript:send(0,0);'>
						Eingaben senden
					</a>
					<button type="reset" class='form_btn reset'>
						Eingaben löschen
					</button>
				</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
