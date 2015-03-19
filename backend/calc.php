<?php session_start();
include ("../login/bin/login_func.php");
loggedInAdmin();
include("header_backend.php");

function options ($bereich, $zahn) {
global $con;
$sql = "SELECT * FROM calc";
$result = $con->query($sql);
echo "<select name='".$bereich.$zahn."'>";
echo "<option value=''> -/- </option>";
	while ($row = $result->fetch_object()) {
	$option = $row->option;
	$name = $row->option_name;
	$value = $row->preis;
	echo "<option value='".$value."'>".$option."</option>";
	}
echo "</select>";
echo $bereich.$zahn;
$con->close;
}
?>
		<div class="main">
			<div class="content">
				<div class="text">
					<h1>KVA-Calc</h1>
					<h2>Ihr Ergebnis: <span id='sum'> </span>&nbsp;&euro; &nbsp;&nbsp;</h2>
					<div class="bereich leftside">
						<?php for ($i=8;$i>0;$i--) {options (1,$i);} ?>
					</div>
					<div class="bereich">
						<?php for ($i=1;$i<9;$i++) {options (2,$i);} ?>
					</div>
					<div class="bereich leftside">
						<?php for ($i=8;$i>0;$i--) {options (4,$i);} ?>
					</div>
					<div class="bereich">
						<?php for ($i=1;$i<9;$i++) {options (3,$i);} ?>
					</div>
					<input type="checkbox" id="korea" />Korea ja/nein
					<div class="topspace">
					<button class="form_btn reset">Reset</button>
					</div>
				</div>
			</div>
		</div>
	</div>
<script>
$(document).ready(function() {
	$('select').change(function(){

		// Formatierung der gewählten Optionen
		if ($(this).val() != '') {
			$(this).css('background-color', 'rgb(52, 152, 219)');
			$(this).css('color', '#fff');
		}
		else {
			$(this).css('background-color', 'rgba(50,50,50,0.1)');
			$(this).css('color', '#333');
		}

		// Variable für Berechnungen
	    var sum = 0;
	    $('select :selected').each(function() {
	        sum += Number($(this).val());
	    });

	    // Reset des gesamten Rechners
		$('.reset').click(function() {
			$('select').css('background-color', '');
			$('select').css('color', '#333');
			$('select :selected').removeAttr('selected');
			sum = 0;
			$("#sum").html('');
		});

		// Produktion in Südkorea
		// Hier ebenfalls eine Select-Box einführen und den Preis entsprechend berechnen

		//Ausgabe des Ergebnisses
		$("#sum").number(sum,2, ',', '.');

	});


});
</script>
</body>
</html>