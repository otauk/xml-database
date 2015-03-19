<?php
session_start();
// Eintrag in log_db über den logout
include("../include/log_entry.php");
log_entry(Logout);
// Unset all of the session variables.
$_SESSION = array();
// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
// Finally, destroy the session.
session_destroy();
require_once("header_login.php");
?>
<div id='main_login'>
	<div class='alert green'>Logout erfolgreich.</div>
	<div class='topspace'>
		<a href='../index.php' class='form_btn back'>Zum Login</a>
	</div>
</div>
</div>