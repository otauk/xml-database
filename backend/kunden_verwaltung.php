<?php session_start();
include ("../login/bin/login_func.php");
loggedInUser();
include("header_backend.php");
include("ajax_kunden.php");
include("../conn.php");
// Variablen
$id = $_POST["id"];
$kunden_id = $_POST["kunden_id"];
$name = $_POST["name"];
$mail = $_POST["mail"];
$fehler = "";
$confirmation = "";
// Gesendet?
if (isset ($_POST["check"])) {
// Validierung
	$reg_kunden_id = "/^[0-9]{5}+$/";
	$kunden_id_check = "(SELECT kunden_id FROM kunden_db)";
	$kunden_id_result = mysqli_query($con,$kunden_id_check);

	if (empty($kunden_id)) {
		$fehler .= "<div class='alert red margin-tb-15 w50'>Bitte geben Sie eine kunden_id an</div>";
	} else if (!preg_match($reg_kunden_id,$kunden_id)) {
		$fehler .= "<div class='alert red margin-tb-15 w50'>Keine gültige kunden_id!</div>";
	}
	if (empty($name)) {
		$fehler .= "<div class='alert red margin-tb-15 w50'>Bitte geben Sie den Namen des Kunden an</div>";
	}
	if (empty($mail)) {
		$fehler .= "<div class='alert red margin-tb-15 w50'>Bitte geben Sie die E-Mail-Adresse des Kunden an</div>";
	}
// Nur wenn KEINE Fehler vorliegen, hier weiter...
	if (empty($fehler)) {
		// Einträge ändern/löschen
		if (isset($_POST["ak"])) {
			// NEUER EINTRAG
			if($_POST["ak"]=="up") {
				$id = $_POST["id"];
				$sqlab =	"UPDATE kunden_db SET "
							."kunden_id = '$kunden_id',"
							."name = '$name', "
							."mail = '$mail' "
							." WHERE ID = $id";
				mysqli_query($con,$sqlab);
				$confirmation = "<div class='alert green'>Datensatz <em>$name ($kunden_id)</em> erfolgreich geändert</div>";
				}
			}
		} else $confirmation = $fehler;
	// EINTRAG LÖSCHEN
	if($_POST["ak"]=="de") {
		$sqlab = 	"DELETE FROM kunden_db WHERE ID = ".$_POST["id"];
		mysqli_query($con,$sqlab);
		$confirmation = "<div class='alert red'>Kunde <em>$name ($kunden_id)</em> wurde gelöscht</div>";
		}
}
// Ausgabe aller Kundendaten
$sql="SELECT * FROM kunden_db";
$result = mysqli_query($con,$sql);
?>
		<div class="main">
			<div class="content">
				<div class="text">
					<h1>Kundenverwaltung</h1>
					<h2>Kunden ändern/löschen</h2>
					<?=$confirmation;?>
					<form name='f' action='kunden_verwaltung.php' method='POST'>
						<input name='ak' type='hidden' />
						<input name='id' type='hidden' />
						<input name='check' type='hidden' value='1'/>
						<div id="editor"></div>
					</form>
					<table class="tbl">
						<tr>
							<td>Kunden-ID</td>
							<td>Name des Kunden</td>
							<td>E-Mail-Adresse des Kunden</td>
							<td>
							</td>
						</tr>
					<?php
						while($row = mysqli_fetch_array($result)) {
					?>
						<tr>
							<td><?=$row["kunden_id"];?></td>
							<td><?=$row["name"];?></td>
							<td><?=$row["mail"];?></td>
							<td class="rightside">
								<button class='form_btn edit' onclick='showKunde(this.name)' name='<?=$row["ID"];?>'>Eintrag ändern</button>
							</td>
						</tr>
					<?php
						}
					?>
					</table>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
<?php mysqli_close($con);?>