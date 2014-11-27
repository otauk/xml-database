<?php
$q = intval($_GET['q']);

$con = mysqli_connect('localhost','d01c63c9','AFnPqDrvAFzMPYX7','d01c63c9');
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"docs_db");
$sql="SELECT * FROM docs_db WHERE id = '".$q."'";
$result = mysqli_query($con,$sql);

echo "<table class='tbl'>
<tr>
<td>ID</td>
<td>Rechnungsnummer</td>
<td>Rechnungsdatum</td>
<td>Name des Dokuments</td>
<td>eingetragen am</td>
</tr>";

while($row = mysqli_fetch_array($result)) {
  echo "<tr>";
  echo "<td><input type='textfield' size=3 name='ID' value='" . $row['ID'] . "'</td>";
  echo "<td><input type='textfield' name='name' value='" . $row['name'] . "'</td>";
  echo "<td><input type='textfield' name='invoice_date' value='" . $row['invoice_date'] . "'</td>";
  echo "<td><input type='textfield' name='document' value='" . $row['document'] . "'</td>";
   echo "<td><input type='textfield' name='insert_date' value='" . $row['insert_date'] . "'</td>";
   echo "<td><a href='' class='form_btn save'>Änderungen speichern</a></td>";
  echo "</tr>";
}
echo "</table>";

mysqli_close($con);
?>