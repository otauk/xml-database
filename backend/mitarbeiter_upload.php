<?php session_start();
include ("../login/bin/login_func.php");
loggedInAdmin();
include("../conn.php");
include("upload.php");
include("header_backend.php");
$id = $_POST["id"];
// Kunden-DB für kunden_id
$abfrage = "SELECT * FROM kunden_db";
$erg = $con->query($abfrage);
?>
		<div class="main">
			<div class="content">
				<div class="text">
					<h1>Upload XML-Dateien</h1>
					<?php echo $confirmation;?>
					<?php

	if (
	(!isset($_POST["upload"])
		or
		isset($fehler))
	and
	(!isset($_POST["entry"]))
) {

?>
						<form name="upload" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
							<input type="hidden" name="upload" value="1" />
							<a class="form_btn upload" id="button-file">
							<?php
	if (!empty($document)) {echo $document;}else echo "XML-Datei wählen";
?>
							</a>
							<input type="file" name="document" class="form_btn" id="input-file" />
							<button type="submit" class="form_btn submit" >Upload</button>
						</form>
						<?php
 }
?>
						<?php
$xmlFile = "upload/".$document;
$Response = @simplexml_load_file($xmlFile) or die;
$date = $Response->Rechnung->attributes()->Laborlieferdatum;
// Datum formatieren
$dateFormat = new DateTime($date);
$order_no = $Response->Rechnung->attributes()->Auftragsnummer;
// Kundennummer aus Auftragsnummer extrahieren (an 3. Stelle ein "-" ?)
$case = substr($order_no,2,1);
if ($case == "-") {
	$customer = substr($order_no, 3,5);
}
else {
	$customer = substr($order_no, 0,6);
}
// Kundennummer vorhanden? Dann Kunde ausgeben, sonst Fehlermeldung
$abfrage = "SELECT * FROM kunden_db WHERE kunden_id = '$customer' LIMIT 1";
$ergebnis = $con->query($abfrage);
$row = mysqli_fetch_object($ergebnis);
$kunden_id = $row->kunden_id;
if ( $row->kunden_id != $customer) {
	echo "
							<div class='topspace'></div>
							<div class='alert red'>
								Kunde mit id <em>$customer</em> nicht vorhanden.
								Bitte
									<a href='kunden_neuanlage.php'>
										<button class='form_btn' >
											neu anlegen
										</button>
									</a>
							</div>";
	//exit();
}
else {
	$customer = $row->name;
}

// Ausgabe der Daten
$lieferdatum = $dateFormat->format('d.m.Y');
$rechnungsnummer  = $Response->Rechnung->attributes()->Laborrechnungsnummer;
$auftragsnummer = $order_no;
?>
						<h2>Rechnungsdaten</h2>
						<form name="dbEntry" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
						<input type="hidden" name="entry" value="1" />
						<table class="tbl">
							<tr>
								<td class="small">Laborlieferdatum: </td><td><?php echo $lieferdatum;?></td>
								<input type="hidden" value="<?php echo $lieferdatum;?>" name="lieferdatum" />
							</tr>
							<tr>
								<td class="small">Laborrechnungsnummer: </td><td><?php echo $rechnungsnummer;?></td>
								<input type="hidden" value="<?php echo $rechnungsnummer;?>" name="rechnungsnummer" />
							</tr>
							<tr>
							<td class="small">Auftragsnummer: </td><td><?php echo $order_no;?></td>
						<input type="hidden" value="<?php echo $order_no;?>" name="auftragsnummer"/>
							</tr>
							<tr>
						<td class="small">Kunde: </td><td><?php echo $customer;?></td>
						<input type="hidden" value="<?php echo $kunden_id;?>" name="kunde" />
							</tr>
						</table>
						<div class="fieldname">Patient:</div>
						<input type="text" value="<?php echo $patient;?>" name="patient" class="textfield" required="required" maxlength="100"/>
						<div class="topspace"></div>
						<input type="submit" class="form_btn submit dis_btn" value="Eintragen in Datenbank">
						</form>
					</table>
				</div>
			</div>
		</div>
	</div>
</body>
</html>

<script>
	$(document).ready(function() {
		$('.dis_btn').attr('disabled', 'disabled');
		$('input[type="text"]').keyup(function() {
			if($(this).val().length > 3 ) {
				$('input[type="submit"]').removeAttr('disabled');
			}
			else {
				$('.dis_btn').attr('disabled', 'disabled');
			}
		});
	});
	</script>