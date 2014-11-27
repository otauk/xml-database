<?php
/**
*	Beim Aufruf jeder Seite wird geprüft, ob
*	-> User eingeloggt?
* 	Falls nicht,
*	-> redirect auf die Login-Seite
* 	-> Abbruch des Scripts
* 	Falls ja,
* 	-> Script ausführen
*/
function loggedInUser () {
if(!isset($_SESSION["intern"]))
   {
   header('Location:http://www.zahnspar-zentrum.de/xml/index.php');
   exit;
   }
}

function loggedInAdmin () {
if(!isset($_SESSION["admin"]))
   {
   header('Location:http://www.zahnspar-zentrum.de/xml/index.php');
   exit;
   }
}
?>