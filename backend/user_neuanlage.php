<?php session_start();
include ("../login/bin/login_func.php");
loggedInUser();
include("header_backend.php");
include("../conn.php");
// Kunden-DB für kunden_id
$abfrage = "SELECT * FROM kunden_db";
$erg = $con->query($abfrage);
// ##################### Variablen #####################
$check = $_POST["check"];
$name = $_POST["name"];
$pw = $_POST["pw"];
$kunden_id = $_POST["kunden_id"];
$mail = $_POST["mail"];
$fehler = "";
$confirmation = "";
// ##################### gesendet? #####################
if (isset ($_POST["check"])) {
// ##################### Validierung #####################
	if (empty($kunden_id)) {
		$fehler .= "<div class='alert red margin-tb-15 w50'>Bitte wählen Sie einen Kunden aus</div>";
	}
	if (empty($name)) {
		$fehler .= "<div class='alert red margin-tb-15 w50'>Bitte geben Sie einen Benutzernamen an</div>";
	}
	if (empty($pw)) {
		$fehler .= "<div class='alert red margin-tb-15 w50'>Bitte geben Sie ein Passwort an</div>";
	}
// Nur wenn KEINE Fehler vorliegen, hier weiter...
	if (empty($fehler)) {
		// Wurde das Formular gesendet?
		if (isset($_POST["ak"])) {
			// NEUER EINTRAG
			if($_POST["ak"]=="in") {
				$pw_md5 = md5($pw);
				$sqlab = 	"INSERT INTO user_db
								(name, pw, kunden_id) values (
								'$name',
								'$pw_md5',
								'$kunden_id'
								)";
				mysqli_query ($con, $sqlab);
				include("../include/log_entry.php");
				log_entry("Benutzer $name angelegt");
				$confirmation = "<div class='alert green margin-tb-15 w50'>Der Eintrag wurde erfolgreich gespeichert
				<p>
				Es wurden folgende Daten übernommen:
				</p>
				<p>
				Kunde: $kunden_id<br/>
				Benutzername: $name<br/>
				Passwort: $pw<br/>
				</div>";
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
					<h1>Benutzerverwaltung</h1>
					<h2>Neuen Benutzer erfassen</h2>
					<?=$confirmation;?>
					<form name='f' action='user_neuanlage.php' method='POST'>
						<input name='ak' type='hidden' value='in'/>
						<input name='id' type='hidden' />
						<input name='check' type='hidden' value='1'/>
						<div class="fieldname">Für welchen Kunden soll ein Benutzer angelegt werden?</div>
						<label>
						<select name="kunden_id">
							<option value=""></option>
							<?php
								while ($row = $erg->fetch_assoc()) {
									if (isset($kunden_id)) {
										if ($kunden_id == $row[kunden_id]) {
											$sel = 'selected';
										} else $sel ='';
									}
									echo "<option value='$row[kunden_id]' $sel>".$row["name"]."</option>";
									}
							?>
							</select>
						</label>
						<div class="fieldname">Benutzername:</div>
						<input class="textfield"  type="text" name='name' size='50' required='required' placeholder='qwerty123' value="<?=$name;?>"/>
						<?php
							include("../include/pwgen.php");
							$passwort = passwort_create();
						?>
												<div class="fieldname">Passwort:</div>
						<input class="textfield"  type="text" name='pw' size='50' required='required' placeholder='test123' value="<?=$passwort;?>"/>
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
