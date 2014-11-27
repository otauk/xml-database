<?php session_start();
include ("../login/bin/login_func.php");
loggedInAdmin();
include("header_backend.php");
?>
		<div class="main">
			<div class="content">
				<div class="text">
					<h1>Verwaltung</h1>
					<div class="topspace">
						<a href="xml_mitarbeiter.php" class='form_btn edit'>XML-Datenbank</a>
					</div>
					<div class="topspace">
						<a href="user_neuanlage.php" class='form_btn edit'>Neuen Benutzer anlegen</a>
					</div>
					<hr/>
					<div>
						<a href="kunden_neuanlage.php" class='form_btn edit'>Neuen Kunden anlegen</a>
					</div>
					<div class="topspace">
						<a href="kunden_verwaltung.php" class='form_btn edit'>Kundenverwaltung</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
