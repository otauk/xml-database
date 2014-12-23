<?php session_start();
include ("../login/bin/login_func.php");
loggedInUser();
include("header_backend.php");
include("upload2.php");
$id = $_POST["id"];
include("../conn.php");
// Kunden-DB für kunden_id
$abfrage = "SELECT * FROM kunden_db";
$erg = $con->query($abfrage);
// EINTRAG LÖSCHEN
if (isset($_POST["ak"])) {
	if($_POST["ak"]=="de") {
		$sqlab = 	"DELETE FROM docs_db WHERE ID = $id";
		mysqli_query($con,$sqlab);
		$invoice_no2 = $_POST["invoice_no2"];
		$confirmation = "<div class='alert red'>Rechnung <em>$invoice_no2</em> wurde gelöscht</div>";
	}
}
// XML-Datenbank
?>
		<div class="main">
			<div class="content">
				<div class="text">
					<h1>Verwaltung XML-Dateien</h1>
					<?php echo $confirmation;?>
					<?php
						if (!isset($_POST["upload"]) OR isset($fehler)) {
						?>
					<h2>Upload XML-Datei</h2>
						<form name="upload" action="xml_mitarbeiter2.php" method="POST" enctype="multipart/form-data">
							<input type="hidden" name="upload" value="1" />
							<a class="form_btn upload" id="button-file">
							<?php
									if (isset($document)) {echo $document;}else echo "XML-Datei wählen";
									?>
							</a>
							<input type="file" name="document" class="form_btn" id="input-file" />
							<button type="submit" class="form_btn submit">Upload</button>
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
						//	Kundennummer aus Auftragsnummer extrahieren (an 3. Stelle ein "-" ?)
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
							exit();
						}
						else {
							$customer = $row->name;
						}

						// Ausgabe der Daten
						echo "<h2>Rechnungsdaten</h2>";
						echo "<hr/><p>Laborlieferdatum: ".$dateFormat->format('d.m.Y')."</p>";
						echo "<hr/><p>Laborrechnungsnummer: ".$Response->Rechnung->attributes()->Laborrechnungsnummer."</p>";
						echo "<hr/><p>Auftragsnummer: ".$order_no."</p>";
						echo "<hr/><p>Kunde: ".$customer."</p>";
						?>
						<form name="dbEntry" action="xml_mitarbeiter2.php" method="POST">
							<div class="fieldname">Patient:</div>
							<input type="text" value="<?=$patient;?>" name="patient" class="textfield" required="required" maxlength="100"/>
							<div class="topspace"></div>
							<button type="submit" class="form_btn submit">Eintragen</button>
						</form>
				<hr class="topspace"/>
				<h2>Liste aller XML-Dateien</h2>
				<div id="editor"></div>
					<table class="tbl">
						<tr>
								<td>
									Laborrechnungsnummer
								</td>
								<td>
									Rechnungsdatum
								</td>
								<td>
									Kunde
								</td>
								<td>
									Name des Dokuments
								</td>
								<td>
									eingetragen am
								</td>
								<td></td>
						</tr>
						<form name="f" method="POST">
					<?php
						// Zu Testzwecken hier unten
						$sql ="SELECT * FROM docs_db ORDER BY insert_date DESC";
						$result = $con->query($sql);
						while ($row = $result->fetch_assoc()) {
							$kunden_id = $row["kunden_id"];
							$sql_name = "SELECT name FROM kunden_db WHERE kunden_id =  $kunden_id";
							$result_name = $con->query($sql_name);
							while ($row_name = $result_name->fetch_assoc()) {
								$kname = $row_name["name"];
							}
							$id = $row["ID"];
							$invoice_no2 = $row["invoice_no"];
							$insert_date = $row["insert_date"];
							$timestamp = strtotime($insert_date);
							$insert_date_format = date('d.m.Y H:i:s', $timestamp);
					?>
						<tr>
							<td>
								<?=$invoice_no2;?>
							</td>
							<td>
								<?=$row["invoice_date"];?>
							</td>
							<td>
								<?=$kname;?>
							</td>
							<td>
								<?=$row["document"];?>
							</td>
							<td>
								<?=$insert_date_format;?>
							</td>
							<td class="rightside">
									<input name='ak' type='hidden' />
									<input name='id' type='hidden' />
									<input name='check' type='hidden' value='1'/>
									<input name='invoice_no2' type="hidden" value="<?=$invoice_no2;?>" />
									<a class='form_btn reset' onClick='javascript:send(2,<?=$id;?>);'>
										Löschen
									</a>
							</td>
						</tr>
						</form>
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