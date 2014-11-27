<?php session_start();
include ("../login/bin/login_func.php");
loggedInUser();
include("header_backend.php");
include("upload.php");
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
					<?php echo $confirmation; ?>
					<h2>Upload XML-Datei</h2>
						<form name="upload" action="xml_mitarbeiter.php" method="POST" enctype="multipart/form-data">
							<input type="hidden" name="check" value="1" />
							<div class="fieldname">Kunde:</div>
							<label>
							<select name="kunden_id">
							<option value="">...bitte wählen Sie einen Kunden</option>
							<?php
								while ($rowk = $erg->fetch_assoc()) {
									if (isset($kunden_id)) {
										if ($kunden_id == $rowk[kunden_id]) {
											$sel = 'selected';
										} else $sel ='';
									}
									echo "<option value='$rowk[kunden_id]' $sel>".$rowk["name"]."</option>";
									}
							?>
							</select>
							</label>
							<div class="fieldname">Rechnungsnummer:</div>
							<input type="text" value="<?=$invoice_no;?>" name="invoice_no" class="textfield" required="required" maxlength="5"/>
							<div class="fieldname">Rechnungsdatum:</div>
							<input type="text" value="<?=$invoice_date;?>" name="invoice_date" class="textfield" id="datepicker" required="required">
							<div class="fieldname">XML-Dokument:</div>
							<a class="form_btn upload" id="button-file">XML-Datei wählen</a>

							<input type="file" name="document" class="form_btn" id="input-file" />
							<div class="topspace">
								<button type="submit"  class='form_btn submit'>Upload</button>
							</div>
						</form>
				<hr class="topspace"/>
				<h2>Liste aller XML-Dateien</h2>
				<div id="editor"></div>
					<table class="tbl">
						<tr>
								<td>
									Rechnungsnummer
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