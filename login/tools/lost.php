<?php session_start();
include("header_login.php");
include ("../../conn.php");
// Variablen
$username = $_POST["username"];
$mail = $_POST["mail"];
$check = $_POST["check"];

/* |||||||||| FUNKTION PASSWORT ERZEUGEN |||||||||| */
function passwort_create($zeichen = 8)
	{
	$chars = array_merge(
		range(0, 9),
        range('a', 'z'),
        range('A', 'Z')
    );
    shuffle($chars);
    return implode('', array_slice($chars, 0, $zeichen));
	}

// Formular gesendet?
if ($check == 1) {
	// Daten vorhanden?
	$query = "SELECT * FROM user_db WHERE mail = '$mail' AND name = '$username'";
	$result = $con->query($query);
	$menge = mysqli_num_rows($result);
	$dsatz = mysqli_fetch_assoc($result);
	$id = $dsatz["ID"];

	if($menge == 1) {
		// Neues Passwort setzen
		$new_passwort = passwort_create();

		// 3. Neues Passwort in DB hinterlegen
		$eintrag =	"UPDATE user_db set pw = md5('$new_passwort') WHERE ID = $id";
		$eintragen = mysqli_query($con, $eintrag);
		// Eintrag erfolgreich?
			if($eintragen == true) {
				$confirmation = "<div class='alert green'>Neues Passwort wurde gesetzt.<br/>
				Eine Mail wurde an <b>$mail</b> verschickt.
				</div>";
			}

		// 4. Neues Passwort per Mail an $mail verschicken
		$sender            = "Dentalglobal GmbH";
		$sendermail        = "info@dentalglobal.de";
		$subject         = "Neues Passwort gesetzt";
		$header = 'Content-type: text/html; charset=utf-8' . "\r\n";
		$header .= "From: $sender <$sendermail>\r\n";
		$header .= "Reply-to: <$sendermail>\r\n";
		$header .= "Return-path: <$sendermail>\r\n";
		$text = "
			<p>
				Diese Mail wurde automatisch generiert.
			</p>
			<p>
				Ihre neues Passwort lautet: <strong>$new_passwort</strong>
			<p>
				Ihre Dentalglobal GmbH
			</p>
		";
		mail($mail, $subject, $text, $header);
	}
	else {
        $confirmation = "<div class='alert red'>Benutzername und/oder E-Mail Adresse nicht vorhanden.</div>";
        }
}
?>
<div id="main_login">
    <div class="content">
        <form action="lost.php" name='lost' method="POST">
            <input name="check" type="hidden" value="1"/>
			<div class="heading">Neues Passwort anfordern</div>
			  <?php echo $confirmation; ?>
            <div class="fieldname">Ihr Benutzername:</div>
            <input type="text" size="50" maxlength="50" name="username" class="textfield" required="required">
            <div class="fieldname">Ihre E-Mail Adresse:</div>
            <input type="text" size="50" maxlength="50" name="mail" class="textfield" required="required">
			<div class='topspace'>
			 <a  class='form_btn password' onClick='lost.submit();'>
				&nbsp; Passwort anfordern
			</a>

			<a class='form_btn reset' onClick='javascript:document.lost.reset();'>
				&nbsp; Formular löschen
			</a>
			</div>
			<hr>
			<div>
		<a href='../../index.php' class='form_btn back'> Zum Login</a>
	</div>
        </form>
    </div>
</div>