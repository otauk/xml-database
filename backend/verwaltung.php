<?php session_start();
include ("../login/bin/login_func.php");
loggedInAdmin();
include("header_backend.php");
?>
		<div class="main">
			<div class="content">
				<div class="text">
					<h1>Upload</h1>
					<div class="topspace">
						<a href="mitarbeiter_upload.php" class='form_btn forward'>Neue Datei hinzufügen</a>
					</div>
					<div class="topspace">
						<a href="mitarbeiter_ausgabe.php" class='form_btn edit'>Liste aller XML-Dateien</a>
					</div>
					<hr/>
					<h1>Verwaltung</h1>
					<div>
						<a href="kunden_neuanlage.php" class='form_btn edit'>Neuen Kunden anlegen</a>
					</div>
					<div class="topspace">
						<a href="kunden_verwaltung.php" class='form_btn edit'>Kunden verwalten</a>
					</div>
					<div class="topspace">
						<a href="user_neuanlage.php" class='form_btn edit'>Neuen Benutzer anlegen</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
