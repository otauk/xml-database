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
$name= "SELECT name FROM kunden_db WHERE kunden_id = $kid_erg";
$name_result = mysqli_query($con,$name);
$res= mysqli_fetch_array($name_result);
$name_erg = $res["name"];
// dokumente ausgeben
$sql="SELECT * FROM docs_db WHERE kunden_id = $kid_erg ORDER BY insert_date DESC";
$result = mysqli_query($con,$sql);
$result_num = mysqli_num_rows($result);
?>
		<div class="main">
			<div class="content">
				<div class="text">
					<h1>Kundenportal</h1>
					<h2><?=$name_erg;?></h2>
					<?php
						if (empty($result_num)) {
						echo "<div class='alert yellow'>Bisher liegen leider keine Einträge vor</div>";
						}
						else {
						?>
					<table class="tbl">
						<tr>
							<td>
								Rechnungsnummer
							</td>
							<td>
								Rechnungsdatum
							</td>
							<td>
								Name des Dokuments
							</td>
							<td>
								eingetragen am
							</td>
							<td>
							</td>
						</tr>
					<?php
						while($row = mysqli_fetch_array($result)) {
							$inv_date =	date('d.m.Y', strtotime($row['invoice_date']));
							$re_date = date('d.m.Y', strtotime($row['insert_date']));
					?>
						<tr>
							<td>
								<?=$row["invoice_no"];?>
							</td>
							<td>
								<?=$inv_date;?>
							</td>
							<td>
								<?=$row["document"];?>
							</td>
							<td>
								<?=$re_date;?>
							</td>
							<td class="rightside">
				<a class='form_btn download ' href="upload/<?=$row["document"];?>">Download</a>
							</td>
						</tr>
					<?php
						}
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