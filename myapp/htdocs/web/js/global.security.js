$(document).ready(function(){
    $("input[type='checkbox']:not(.simple), input[type='radio']:not(.simple)").iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue'
    });

	$(".select2").select2({
		placeholder: "Pilih salah satu",
		allowClear: true
	});

});