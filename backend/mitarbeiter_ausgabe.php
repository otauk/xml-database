<?php session_start();
include ("../login/bin/login_func.php");
loggedInAdmin();
include("header_backend.php");
	// EINTRAG LÖSCHEN
$id = $_POST["id"];
$rechnungsnummer_display = $_POST["rechnungsnummer_display"];
include("../conn.php");
if (isset($_POST["ak"])) {
	if($_POST["ak"]=="de") {
		// Abfrage für Protokoll
		$del = "SELECT * FROM docs_db WHERE ID = $id";
		$delq = $con->query($del);
		$delerg = mysqli_fetch_object($delq);
		$del_no = $delerg->auftragsnummer;
		// Löschvorgang
		$sqlab = 	"DELETE FROM docs_db WHERE ID = $id";
		mysqli_query($con,$sqlab);
		include("../include/log_entry.php");
		log_entry("XML-Datei >>$del_no<< gelöscht");
		$confirmation = "<div class='alert red'>Rechnung <em>$del_no</em> wurde gelöscht</div>";
	}
}
$suche = $_POST["suchfeld"];

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
	<a href="mitarbeiter_upload.php" class='form_btn forward'>Neue Datei hinzufügen</a>

<!-- // ~~~~~~~~~~~~~~ SUCHE ~~~~~~~~~~~~~ // -->

	<form name="suche" id="suche" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
	<input type="text" class='textfield' id="suchfeld" name="suchfeld"/>
	<input type="submit" class="dis_btn form_btn" value="Suche" />
	<?php if ($suche) {echo "<input type='submit' class='form_btn' value='Alles anzeigen' />";} else "";?>
	</form>

<!-- ~~ Button disable wenn Feld leer ~~ -->
<script>
	$(document).ready(function() {
		$('.dis_btn').attr('disabled','disabled');
		$('input[type="text"]').keyup(function() {
			if($(this).val() != '') {
				$('input[type="submit"]').removeAttr('disabled');
				}
		});
	});
</script>

	<?php echo $confirmation;?>
					<table class="tbl tablesorter" id="mitarbeiterTable">
						<thead>
							<tr>
								<th>
									Laborlieferdatum
								</th>
								<th>
									Laborrechnungsnummer
								</th>
								<th>
									Auftragsnummer
								</th>
								<th>
									Kunde
								</th>
								<th>
									Patient
								</th>
								<th>
									eingetragen am
								</th>
								<td></td>
							</tr>
						</thead>
						<tbody>

	<?php
	// Zu Testzwecken hier unten
	$sql ="SELECT * FROM docs_db";
	$suche =  $con->real_escape_string($_POST['suchfeld']);
	$suche_query = " WHERE patient LIKE  '%".$suche."%' OR auftragsnummer LIKE  '%".$suche."%' OR kunden_id LIKE  '%".$suche."%' OR rechnungsnummer LIKE  '%".$suche."%' OR lieferdatum LIKE  '%".$suche."%'";
	if ($suche) {$sql .= ' '.$suche_query.' ';}
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
</tbody>
					</table>
					</form>
				</div>
			</div>
		</div>
	</div>
<script>
$(document).ready(function() {
	$("#mitarbeiterTable").tablesorter({ sortList:[5,0] });
});
</script>
</body>
</html>