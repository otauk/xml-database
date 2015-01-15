<?php session_start();
include ("../login/bin/login_func.php");
loggedInAdmin();
include("header_backend.php");
	// EINTRAG LÖSCHEN
$id = $_POST["id"];
include("../conn.php");
if (isset($_POST["ak"])) {
	if($_POST["ak"]=="de") {
		$sqlab = 	"DELETE FROM docs_db WHERE ID = $id";
		mysqli_query($con,$sqlab);
		$confirmation = "<div class='alert red'>Rechnung <em>$rechnungsnummer_display</em> wurde gelöscht</div>";
	}
}
?>
<div class="main">
	<div class="content">
		<div class="text">

	<form name="f" method="POST">
		<input name='ak' type='hidden' />
			<input name='id' type='hidden'/>
		<input name='check' type='hidden' value='1'/>
		<input name='rechnungsnummer_display' type="hidden" value="<?=$rechnungsnummer_display;?>" />
	<h1>Liste aller XML-Dateien</h1>
	<a href="mitarbeiter_upload.php" class='form_btn download'>Neue Datei hinzufügen</a>
	<?php echo $confirmation;?>
				<div id="editor"></div>
					<table class="tbl">
						<tr>
								<td>
									Laborlieferdatum
								</td>
								<td>
									Laborrechnungsnummer
								</td>
								<td>
									Auftragsnummer
								</td>
								<td>
									Kunde
								</td>
								<td>
									Patient
								</td>
								<td>
									eingetragen am
								</td>
								<td></td>
						</tr>

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
	$lieferdatum_display = $row["lieferdatum"];
	$rechnungsnummer_display = $row["rechnungsnummer"];
	$auftragsnummer_display = $row["auftragsnummer"];
	$patient_display = $row["patient"];
	$insert_date = $row["insert_date"];
	$timestamp = strtotime($insert_date);
	$insert_date_format = date('d.m.Y H:i:s', $timestamp);
	?>
							<tr>
								<td>
									<?=$lieferdatum_display;?>
								</td>
								<td>
									<?=$rechnungsnummer_display;?>
								</td>
								<td>
									<a href="upload/<?=$auftragsnummer_display;?>.xml"><?=$auftragsnummer_display;?></a>
								</td>
								<td>
									<?=$kname;?>
								</td>
								<td>
									<?=$patient_display;?>
								</td>
								<td>
									<?=$insert_date_format;?>
								</td>
								<td class="rightside">
										<a class='form_btn reset' onClick='javascript:send(2,<?=$id;?>);'>
											Löschen
										</a>
								</td>
							</tr>
	<?php


	}
	?>

</form>
					</table>
				</div>
			</div>
		</div>
	</div>
</body>
</html>