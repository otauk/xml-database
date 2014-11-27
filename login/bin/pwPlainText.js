function plain() {
	if (document.getElementById("plain_check").checked==true) {
		document.getElementById("passwort").type="text";
		document.getElementById("passwort2").type="text";
		}
	else {
		document.getElementById("passwort").type="password";
		document.getElementById("passwort2").type="password";
		}
}
