<?php
$q = intval($_GET['q']);
include("../conn.php");
$sql="SELECT * FROM kunden_db WHERE id = '".$q."'";
$result = $con->query($sql);
/*
echo "<table class='tbl'>
<tr>
<td>Kunden-ID</td>
<td>Name des Kunden</td>
<td>E-Mail-Adresse des Kunden</td>
</tr>";
*/
while($row = mysqli_fetch_array($result)) {
	$id = $row["ID"];
 ?>

<!--
	  echo "<tr>";
  echo "<td><input type='textfield' size=5 maxlength='5' name='kunden_id' value='" . $row['kunden_id'] . "'</td>";
  echo "<td><input type='textfield' name='name' value='" . $row['name'] . "'</td>";
  echo "<td><input type='textfield' name='mail' value='" . $row['mail'] . "'</td>";
   echo "<td class='rightside'><a class='form_btn submit' onClick='javascript:send(1,$id);'>Speichern</a>
								<a class='form_btn reset' onClick='javascript:send(2,$id);'>Löschen</a></td>";
  echo "</tr>";
}
echo "</table>";

mysqli_close($con);
-->

<div class="fieldname">Kunden-ID (z.B. 12345):</div>
						<input class="textfield" type="text" name='kunden_id' size='50' maxlength="5" required='required' placeholder='12345' value="<?=$row['kunden_id'];?>"/>
						<div class="fieldname">Name (z.B. Zahnarztpraxis Meier):</div>
						<input class="textfield"  type="text" name='name' size='50' required='required' placeholder='Name des Kunden' value="<?=$row['name'];?>"/>
						<div class="fieldname">E-Mail (info@info.de):</div>
						<input class="textfield"  type="text" name='mail' size='50' required='required' placeholder='info@info.de' value="<?=$row['mail'];?>"/>
					<div class="topspace"></div>
					<a class='form_btn submit' onClick='javascript:send(1,<?=$id;?>);'>Speichern</a>
								<a class='form_btn reset' onClick='javascript:send(2,<?=$id;?>);'>Löschen</a>
<?php }
mysqli_close($con);
?>