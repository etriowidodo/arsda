<?php use yii\helpers\Html; ?>
<div class="role-create"><?php echo $this->render('_form', ['head'=>$head]); ?></div>
<div class="modal-loading-new"></div>

<script type="text/javascript">
$(document).ready(function(){
	$("body").addClass('fixed sidebar-collapse');
	$(".sidebar-toggle").click(function(){
		 $("html, body").animate({scrollTop: 0}, 500);
	});

	$('#role-form').validator({disable:false}).on('submit', function(e){
		if(!e.isDefaultPrevented()){
			for(var instanceName in CKEDITOR.instances){
				CKEDITOR.instances[instanceName].updateElement();
			}
			var alasan = $('#tab_alasan').val(), primair = $('#tab_primair').val(),subsidair = $('#tab_subsidair').val();  
			var no_banding = $('#no_permohonan_kasasi').val(), tgl_banding = $('#tgl_permohonan_kasasi').val();
			var filenya 	= $("#file_template")[0].files[0] , cek	 = $("#cek_file").val(); 
			var filenya2	= $("#file_template2")[0].files[0], cek2 = $("#cek_file2").val();
			var filenya3	= $("#file_template3")[0].files[0], cek3 = $("#cek_file3").val();
			var msg ="",msg1="",msg2="";
						
			if(alasan == '' || primair == '' || subsidair == '' || no_banding == '' || tgl_banding == '' ){
				if (alasan == '' || primair == '' || subsidair == '') {msg+="Text editor"; msg1=","; msg2="ada yang"; } 
				if (no_banding ==''){ msg+=msg1+" Nomor akta pernyataan kasasi"; msg1="," } 
				if (tgl_banding ==''){ msg+=msg1+" Tanggal akta pernyataan kasasi";  msg1=","} 
				msg+=" masih "+msg2+" kosong.";
				msg+=" Apakah anda tetap ingin menyimpan data?";
				
				bootbox.confirm({ 
					message: msg,
					size: "small",
					closeButton: false,
					buttons: {
						confirm: {label:'<div style="min-width:30px">Ya</div>', className:'btn-primary pull-right jarak-kanan'},
						cancel: {label:'<div style="min-width:30px">Tidak</div>', className:'btn-default pull-right'}
					},
					callback: function(result){
						if(result){
							bootbox.hideAll();
							booxqution1();
							return false;
						}
					}
				});
			} else{
				booxqution1();
				return false;
			}			
			return false;
		}
	});
	
	function booxqution1(){
		var filenya3	= $("#file_template3")[0].files[0], cek3 = $("#cek_file3").val();
		if (cek3 == 0 && typeof(filenya3) == 'undefined') {
			bootbox.confirm({ 
			message: "File akte penyerahan kasasi masih kosong, tetap simpan data tanpa melampirkan file akte penyerahan kasasi?",
			size: "small",
			closeButton: false,
			buttons: {
				confirm: {label:'<div style="min-width:30px">Ya</div>', className:'btn-primary pull-right jarak-kanan'},
				cancel: {label:'<div style="min-width:30px">Tidak</div>', className:'btn-default pull-right'}
			},
			callback: function(result){
				if(result){
					bootbox.hideAll();	
					booxqution2();
					return false;
					}
				}
			});	
		} else {
			booxqution2();
			return false;
		}
	}
	
	function booxqution2(){
		var filenya2	= $("#file_template2")[0].files[0], cek2 = $("#cek_file2").val();
		if (cek2 == 0 && typeof(filenya2) == 'undefined') {
			bootbox.confirm({ 
			message: "File pernyataan kasasi masih kosong, tetap simpan data tanpa melampirkan file pernyataan kasasi?",
			size: "small",
			closeButton: false,
			buttons: {
				confirm: {label:'<div style="min-width:30px">Ya</div>', className:'btn-primary pull-right jarak-kanan'},
				cancel: {label:'<div style="min-width:30px">Tidak</div>', className:'btn-default pull-right'}
			},
			callback: function(result){
				if(result){
					bootbox.hideAll();	
					booxqution3();
					return false;
					}
				}
			});	
		} else {
			booxqution3();
			return false;
		}
	}
	
	function booxqution3(){
		var filenya 	= $("#file_template")[0].files[0] , cek	 = $("#cek_file").val(); 
		if (cek == 0 && typeof(filenya) == 'undefined') {
			bootbox.confirm({ 
			message: "File S-26 masih kosong, tetap simpan data tanpa melampirkan file S-26?",
			size: "small",
			closeButton: false,
			buttons: {
				confirm: {label:'<div style="min-width:30px">Ya</div>', className:'btn-primary pull-right jarak-kanan'},
				cancel: {label:'<div style="min-width:30px">Tidak</div>', className:'btn-default pull-right'}
			},
			callback: function(result){
				if(result){
					bootbox.hideAll();	
					validasi_upload();
					return false;
					}
				}
			});	
		} else {
			validasi_upload();
			return false;
		}
	}

	function validasi_upload(){
		$("body").addClass("loading");
		var filenya 	            = $("#file_template")[0].files[0], fname = '', fsize = 0, extnya = '';
		var arrExt 		            = [".doc", ".odt", ".docx", ".rtf", ".pdf" ];
		var filenya2 	            = $("#file_template2")[0].files[0], fname2 = '', fsize2 = 0, extnya2 = '';
		var arrExt2 	            = [".doc", ".odt", ".docx", ".rtf", ".pdf" ];
		var filenya3 	            = $("#file_template3")[0].files[0], fname3 = '', fsize3 = 0, extnya3 = '';
		var arrExt3 	            = [".doc", ".odt", ".docx", ".rtf", ".pdf" ];
		
		var tgl_skks				= ($("#tanggal_skks").val())? new Date(tgl_auto($("#tanggal_skks").val())): new Date(tgl_auto($("#tanggal_skk").val()));
		var war						= ($("#tanggal_skks").val())?'SKKS':'SKK';
		
		var tanggal_putusan			= ($("#tanggal_putusan").val())?new Date(tgl_auto($("#tanggal_putusan").val())):tgl_skks;
		var war2					= ($("#tanggal_putusan").val())?'putusan TK I':war;
		
		var tanggal_s26	            = new Date(tgl_auto($("#tanggal_s26").val()));
		var tgl_permohonan_kasasi	= new Date(tgl_auto($("#tgl_permohonan_kasasi").val()));
		var hariIni 	            = new Date('<?php echo date('Y-m-d');?>');

		$("#error_custom1, #error_custom2,#error_custom3,#error_custom4,#error_custom5,#error_custom8,#error_custom9").html('');
		if(typeof(filenya) != 'undefined'){
			fsize 	= filenya.size, 
			fname 	= filenya.name, 
			extnya 	= fname.substr(fname.lastIndexOf(".")).toLowerCase();
		}
		if(typeof(filenya2) != 'undefined'){
			fsize2 	= filenya2.size, 
			fname2 	= filenya2.name, 
			extnya2	= fname2.substr(fname2.lastIndexOf(".")).toLowerCase();
		}
		if(typeof(filenya3) != 'undefined'){
			fsize3 	= filenya3.size, 
			fname3 	= filenya3.name, 
			extnya3	= fname3.substr(fname3.lastIndexOf(".")).toLowerCase();
		}
		
		if(fname && $.inArray(extnya, arrExt) == -1){
			$("body").removeClass("loading");
			$("#error_custom3").html('<i style="color:#dd4b39; font-size:12px;">* Tipe file hanya .odt,.doc,.docx,.pdf</i>');
			setErrorFocus($("#error_custom3"), $("#role-form"), false);
			return false;
		} else if(fname && fsize > (2 * 1024 * 1024)){
			$("body").removeClass("loading");
			$("#error_custom3").html('<i style="color:#dd4b39; font-size:12px;">* File Max 2MB</i>');
			setErrorFocus($("#error_custom3"), $("#role-form"), false);
			return false;
		} else if(fname2 && $.inArray(extnya2, arrExt2) == -1){
			$("body").removeClass("loading");
			$("#error_custom9").html('<i style="color:#dd4b39; font-size:12px;">* Tipe file hanya .odt,.doc,.docx,.pdf</i>');
			setErrorFocus($("#error_custom9"), $("#role-form"), false);
			return false;
		} else if(fname2 && fsize2 > (2 * 1024 * 1024)){
			$("body").removeClass("loading");
			$("#error_custom9").html('<i style="color:#dd4b39; font-size:12px;">* File Max 2MB</i>');
			setErrorFocus($("#error_custom9"), $("#role-form"), false);
			return false;
		} else if(fname3 && $.inArray(extnya3, arrExt3) == -1){
			$("body").removeClass("loading");
			$("#error_custom10").html('<i style="color:#dd4b39; font-size:12px;">* Tipe file hanya .odt,.doc,.docx,.pdf</i>');
			setErrorFocus($("#error_custom10"), $("#role-form"), false);
			return false;
		} else if(fname3 && fsize3 > (2 * 1024 * 1024)){
			$("body").removeClass("loading");
			$("#error_custom10").html('<i style="color:#dd4b39; font-size:12px;">* File Max 2MB</i>');
			setErrorFocus($("#error_custom10"), $("#role-form"), false);
			return false;
		} else if(tanggal_s26 && tanggal_s26 < tanggal_putusan){
			$("body").removeClass("loading");
			$("#error_custom5").html('<i style="color:#dd4b39; font-size:12px;">Tanggal S26 harus lebih besar atau sama dengan tanggal '+war2+'</i>');
			setErrorFocus($("#tanggal_s26"), $("#role-form"), false);
			return false;
		} else if(tanggal_s26 && tanggal_s26 > hariIni){
			$("body").removeClass("loading");
			$("#error_custom5").html('<i style="color:#dd4b39; font-size:12px;">Maximal tanggal S26 adalah hari ini</i>');
			setErrorFocus($("#tanggal_s26"), $("#role-form"), false);
			return false;
		} else if (tgl_permohonan_kasasi && tgl_permohonan_kasasi < tanggal_putusan ) {
			$("body").removeClass("loading");
			$("#error_custom8").html('<i style="color:#dd4b39; font-size:12px;">Tanggal akta pernyataan kasasi harus lebih besar atau sama dengan tanggal '+war2+'</i>');
			setErrorFocus($("#tgl_permohonan_kasasi"), $("#role-form"), false);
			return false;
		} else if (tgl_permohonan_kasasi && tgl_permohonan_kasasi > hariIni ) {
			$("body").removeClass("loading");
			$("#error_custom8").html('<i style="color:#dd4b39; font-size:12px;">Maximal tanggal akta pernyataan kasasi adalah hari ini</i>');
			setErrorFocus($("#tgl_permohonan_kasasi"), $("#role-form"), false);
			return false;
		} else{
		/* 	$.ajax({
				type	: "POST",
				url		: '<?php echo Yii::$app->request->baseUrl.'/datun/sp1/ceksp1'; ?>',
				data	: $("#role-form").serialize(),
				cache	: false,
				dataType: 'json',
				success : function(data){ 
					if(!data.hasil){
						$("body").removeClass("loading");
						$("#"+data.element).html(data.error);
						setErrorFocus($("#"+data.element), $("#role-form"), false);
					} else{
						$('#role-form').validator('destroy').off("submit");
						$('#role-form').submit();
					}
				}
			}); */
			$('#role-form').validator('destroy').off("submit");
			$('#role-form').submit();
			//return false;
		}
	}
});
</script>
