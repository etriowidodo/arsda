$(function(){
	var tglASDF123 = $("body").data("tgl");
	$(".kv-toggle").off();
    $(".kv-toggle").tree();

	$(window).bind("load resize", function() {
        var topOffset 	= $(".main-header").height();
		var width 		= (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
		var height 		= (this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height;
        height 			= (height - topOffset);
		if (height < 1) 
			height = 1;
		if (height > topOffset){
			var jmenu = parseInt(height);
			$("div.wrapper").css("min-height", (jmenu)+"px");
			var offsetContent = ($(".main-header").outerHeight() + $(".main-footer").outerHeight());
			$("content-wrapper").css("min-height", (jmenu - offsetContent)+"px");
        }
		var offsetSidebar = jmenu - $(".main-sidebar .user-panel").innerHeight();
		$(".sidebar-menu").slimscroll({
			alwaysVisible : false,
			height: jmenu+"px",
			color: "rgba(0,0,0,0.2)",
			size: "3px",
			opacity:0.2,
		}).css({"width":"100%"});
		$(".sidebar-menu").css({"height":"auto", "max-height":offsetSidebar});
		$(".main-sidebar .slimScrollDiv").css({"height":"auto", "max-height":offsetSidebar});
	});

	$('.sidebar-toggler').click(function(){
		if($('body').hasClass('fullpage')){
			$('body').removeClass('fullpage');
			$(this).children('.fa').removeClass('fa-arrow-down').addClass('fa-bars');
		} else {
			$('body').addClass('fullpage');
			$(this).children('.fa').removeClass('fa-bars').addClass('fa-arrow-down');
		}
	});

    $("input[type='checkbox']:not(.simple), input[type='radio']:not(.simple)").iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue'
    });

	$(".select2").select2({
		placeholder: "Pilih salah satu",
		allowClear: true
	});

	$(".form-inputfile").each(function(){
		var $input = $(this), 
			$label = $input.next("label"), 
			labelVal = $label.html();
		$input.on('change', function(e){
			var fileName = e.target.value.split( '\\' ).pop();
			if(fileName) $label.find("input").val(fileName);
		});
	});	

	$(".datepicker").datepicker({								  
		defaultDate: new Date(tglASDF123),
		dateFormat: 'dd-mm-yy',
		changeMonth: true,
		changeYear: true,
		yearRange: "c-80:c+10",
		dayNamesMin: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
		monthNamesShort: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
	});
	
	$.fn.modal.Constructor.prototype.enforceFocus = function(){
		var thismodal = this;
		$(document).off('focusin.bs.modal')
		.on('focusin.bs.modal', function(e){
			if(thismodal.$element[0] !== e.target && !thismodal.$element.has(e.target).length && !$(e.target).hasClass('select2-search__field')){
				thismodal.$element.trigger('focus');
			}
		});
	}

	$(document).on("keydown", ".number-only", function(e){
		var code = (e.keyCode ? e.keyCode : e.which);
		if($.inArray(code,[46,8,9,27,13,110,190,116]) !== -1 || ($.inArray(code,[65,67,88,82,84,76,87,81,78,116]) !== -1 && (e.ctrlKey === true || e.metaKey === true)) || 
		(code >= 35 && code <= 40)){
			return;
		}
		if((e.shiftKey || (code < 48 || code > 57)) && (code < 96 || code > 105)){
			e.preventDefault();
		}
	});

	$(document).on("keydown", ".number-only-strip", function(e){
		var code = (e.keyCode ? e.keyCode : e.which);
		if($.inArray(code,[46,8,9,27,13,110,190,116,173]) !== -1 || ($.inArray(code,[65,67,88,82,84,76,87,81,78,116]) !== -1 && (e.ctrlKey === true || e.metaKey === true)) || 
		(code >= 35 && code <= 40)){
			return;
		}
		if((e.shiftKey || (code < 48 || code > 57)) && (code < 96 || code > 105)){
			e.preventDefault();
		}
	});

});

function setErrorFocus(elemnya, formnya, isFocus){
	var scrolnya = formnya.scrollTop() + (elemnya.offset().top - formnya.position().top) + (elemnya.height()/2);
	$("html, body").animate({ scrollTop: scrolnya - ($(".main-header").height() + $("section.content-header").height())}, 500);
	if(isFocus){
		elemnya.focus();
	}
}

function notify_hapus(tipe, pesan){
	$.notify({
		icon:"fa fa-info jarak-kanan", 
		message:pesan
	}, {
		type:tipe, 
		delay:3000,
		showProgressbar: true, 
		placement: {from:"top", align:"center"},
		template:'<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">'+
			'<button type="button" aria-hidden="true" class="close" data-notify="dismiss" style="margin-top:-10px;">&times;</button>'+
			'<span data-notify="icon"></span><span data-notify="title">{1}</span><span data-notify="message">{2}</span>'+
			'<div class="progress progress-notify" data-notify="progressbar">'+
				'<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>'+
			'</div>'+
			'<a href="{3}" target="{4}" data-notify="url"></a>'+
		'</div>'
	});
}

$('.accordion').on('show hide', function (n) {
    $(n.target).siblings('.accordion-heading').find('.accordion-toggle i').toggleClass('fa fa-chevron-up fa fa-chevron-down');
});

function tgl_auto($tgl){
	var a = $tgl.toString().split('-');
	return a[2]+'-'+a[1]+'-'+a[0];
}

function objSize(obj) {
    var count = 0;
    if (typeof obj == "object"){
		if(Object.keys){
			count = Object.keys(obj).length;
		} else if(window._){
			count = _.keys(obj).length;
		} else if(window.$){
			count = $.map(obj, function() { return 1; }).length;
		} else{
			for(var key in obj) if(obj.hasOwnProperty(key)) count++;
		}
    }
    return count;
}