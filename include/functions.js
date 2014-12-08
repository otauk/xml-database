
$(document).ready(function(){
	// Custom input type=file field
	$('#button-file').click(function() {
    	$('#input-file').trigger('click');
	});

	// Name der Upload-Datei
    $("#input-file").change(function(){
        getFileName($(this).attr("id"));
    });

	getFileName = function(id){
	    var str = '';
	    var files = document.getElementById(id).files;
	    for (var i = 0; i < files.length; i++){
	        str += files[i].name;
	    }
	    $("#button-file").text(str);
	}

  $(function() {
  $('#datepicker').datepicker({
       prevText: '&#x3c;zurück', prevStatus: '',
        prevJumpText: '&#x3c;&#x3c;', prevJumpStatus: '',
        nextText: 'Vor&#x3e;', nextStatus: '',
        nextJumpText: '&#x3e;&#x3e;', nextJumpStatus: '',
        currentText: 'heute', currentStatus: '',
        todayText: 'heute', todayStatus: '',
        clearText: '-', clearStatus: '',
        closeText: 'schließen', closeStatus: '',
        monthNames: ['Januar','Februar','März','April','Mai','Juni',
        'Juli','August','September','Oktober','November','Dezember'],
        monthNamesShort: ['Jan','Feb','Mär','Apr','Mai','Jun',
        'Jul','Aug','Sep','Okt','Nov','Dez'],
        dayNames: ['Sonntag','Montag','Dienstag','Mittwoch','Donnerstag','Freitag','Samstag'],
        dayNamesShort: ['So','Mo','Di','Mi','Do','Fr','Sa'],
        dayNamesMin: ['So','Mo','Di','Mi','Do','Fr','Sa'],
      showMonthAfterYear: false,
      //showOn: 'button',
     // buttonImage: '../img/calendar.png',
      //buttonImageOnly: true,
      dateFormat:'dd.mm.yy',
      showButtonPanel: true
    }
  );

});

 });