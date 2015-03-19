<?php
$q = intval($_GET['q']);
include("../conn.php");
$sql="SELECT * FROM kunden_db WHERE id = '".$q."'";
$result = $con->query($sql);
while($row = mysqli_fetch_array($result)) {
	$id = $row["ID"];
 ?>

<div class="fieldname">Kunden-ID (z.B. 12345):</div>
						<input class="textfield" type="text" name='kunden_id' size='50' maxlength="5" required='required' placeholder='12345' value="<?=$row['kunden_id'];?>"/>
						<div class="fieldname">Name (z.B. Zahnarztpraxis Meier):</div>
						<input class="textfield"  type="text" name='name' size='50' required='required' placeholder='Name des Kunden' value="<?=$row['name'];?>"/>
					<div class="topspace"></div>
					<a class='form_btn submit' onClick='javascript:send(1,<?=$id;?>);'>Änderungen speichern</a>
					<a class='form_btn reset' onClick='javascript:send(2,<?=$id;?>);'>Eintrag löschen</a>
					<a class='form_btn logout' onClick='javascript:send(0,0);'>Abbrechen</a>
<?php }
mysqli_close($con);
?>