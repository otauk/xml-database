<?php session_start();
include ("../login/bin/login_func.php");
loggedInUser();
include("header_backend.php");
include("../conn.php");
// kunden_id abfragen
$kid = "SELECT * FROM user_db WHERE name = '$username'";
$kid_result = mysqli_query($con,$kid);
$erg = mysqli_fetch_array($kid_result);
$kid_erg = $erg["kunden_id"];
//
$name= "SELECT * FROM kunden_db WHERE kunden_id = $kid_erg";
$name_result = mysqli_query($con,$name);
$res= mysqli_fetch_array($name_result);
$name_erg = $res["name"];
// dokumente ausgeben
$sql="SELECT * FROM docs_db WHERE kunden_id = $kid_erg ";
$sql_order = " ORDER BY insert_date DESC";
// Suchbegriff vorhanden?
//$suche = $_GET["suchfeld"];
$suche =  $con->real_escape_string($_GET['suchfeld']);
$suche_query = "AND patient LIKE  '%".$suche."%' OR auftragsnummer LIKE  '%".$suche."%' OR rechnungsnummer LIKE  '%".$suche."%' OR lieferdatum LIKE  '%".$suche."%'";
if ($suche) {$sql .= ' '.$suche_query.$sql_order.' ';}
else $sql = $sql.$sql_order;
$result = $con->query($sql);
if($suche) {$result_search = mysqli_num_rows($result);}
else $result_num = mysqli_num_rows($result);
?>
		<div class="main">
			<div class="content">
				<div class="text">
					<h1>Kundenportal XML-Rechnungen</h1>
					<h2><?=$name_erg;?></h2>

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


					<?php
						if ($suche AND empty($result_search)) {
						echo "<div class='alert yellow'>Ihre Suche nach <em>$suche</em> liefert leider kein Ergebnis</div>";

						}
						else if (!$suche AND empty($result_num)) {
						echo "<div class='alert yellow'>Bisher liegen leider keine Einträge vor</div>";
							}
						else {
						?>
					<table class="tbl tablesorter" id="kundenTable">
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
								Patient
							</th>
							<th>
								eingetragen am
							</th>
							<td>
							</td>
						</tr>
						</thead>
						<tbody>
					<?php
						while($row = mysqli_fetch_array($result)) {
							$inv_date =	date('d.m.Y', strtotime($row['invoice_date']));
							$re_date = date('d.m.Y', strtotime($row['insert_date']));
							// Suffix entfernen
							$dokname = $row["document"];
							$ext = reset((explode(".", $dokname)));
					?>
						<tr>
							<td>
								<?=$row["lieferdatum"];?>
							</td>
							<td>
								<?=$row["rechnungsnummer"];?>
							</td>
							<td>
								<?=$row["auftragsnummer"];?>
							</td>
							<td>
								<?=$row["patient"];?>
							</td>
							<td>
								<?=$re_date;?>
							</td>
							<td class="rightside">
				<a class='form_btn download counter' href="upload/<? echo $row["auftragsnummer"].".XML";?>" target="_blank">Download</a>
							</td>
						</tr>
					<?php
						}
					}
					?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
<script>

$(document).ready(function()
    {

    $("#kundenTable").tablesorter({
	    sortList:[5,0]
	});

	$('.counter').onclick(function() {
		$.get( "test.php", function( data ) {
			alert( "Data Loaded: " + data );
		});
	});

});


</script>
</body>
</html>
<?php mysqli_close($con);?>