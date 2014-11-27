<?php
/* Database-Settings */
$server = "localhost";
$user = "d01c63c9";
$pass = "AFnPqDrvAFzMPYX7";
$dbase = "d01c63c9";
mysql_connect($server, $user, $pass) or die ("keine Verbindung möglich.
 Benutzername oder Passwort sind falsch");
mysql_select_db($dbase) or die ("Die Datenbank existiert nicht.");
?>