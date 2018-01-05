<?php use yii\helpers\Html; ?>
<div class="role-create"><?php echo $this->render('_form', ['model'=>$model, 'head'=>$head]); ?></div>
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
			var pihak 		= $('#tab_para').val(), kasus = $('#tab_kasus').val(), penanganan = $('#tab_penanganan').val(),resume = $('#tab_resume').val();
			var filenya 	= $("#file_template")[0].files[0]; 
			var cek			= $("#cek_file").val();
			var msg			="";
			var msg1		="";
			var msg2		= "";
			
			if(pihak == '' || kasus == '' || penanganan == '' || resume == ''){
				msg+="Text editor masih ada yang kosong. Apakah anda tetap ingin menyimpan data?";
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
							booxqution3();
							return false;
						}
					}
				});	
			} else{
				booxqution3();
				return false;
			}
			return false;
		}
	});
	
	function booxqution3(){
		var filenya 	= $("#file_template")[0].files[0] , cek	 = $("#cek_file").val(); 
		if (cek == 0 && typeof(filenya) == 'undefined') {
			bootbox.confirm({ 
			message: "File laporan prinsipal masih kosong, tetap simpan data tanpa melampirkan file laporan prinsipal?",
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
		
		var tgl_skks			    = ($("#tanggal_skks").val())? new Date(tgl_auto($("#tanggal_skks").val())): new Date(tgl_auto($("#tanggal_skk").val()));
		var war					    = ($("#tanggal_skks").val())?'SKKS':'SKK';
		
		var tanggal_putusan			= ($("#tanggal_putusan").val())?new Date(tgl_auto($("#tanggal_putusan").val())):tgl_skks;
		var war2					= ($("#tanggal_putusan").val())?'putusan TK I':war
		
		var tgl_prinsipal           = new Date(tgl_auto($("#tanggal_prinsipal").val()));
		var hariIni 	            = new Date('<?php echo date('Y-m-d');?>');

		$("#error_custom1, #error_custom2, #error_custom3, #error_custom4, #error_custom5, #error_custom6, #error_custom7").html('');
		if(typeof(filenya) != 'undefined'){
			fsize 	= filenya.size, 
			fname 	= filenya.name, 
			extnya 	= fname.substr(fname.lastIndexOf(".")).toLowerCase();
		}

		/* if ($("#penandatangan_nip").val() == "" || $("#penandatangan_nama").val() == ""){
			$("body").removeClass("loading");
			$("#error_custom7").html('<i style="color:#dd4b39; font-size:12px;">Nama pejabat penandatangan belum dipilih</i>');
			setErrorFocus($("#penandatangan_nama"), $("#role-form"), false);
			return false;
		} else  */
		if(fname && $.inArray(extnya, arrExt) == -1){
			$("body").removeClass("loading");
			$("#error_custom1").html('<i style="color:#dd4b39; font-size:12px;">* Tipe file hanya .odt,.doc,.docx,.pdf</i>');
			setErrorFocus($("#error_custom1"), $("#role-form"), false);
			return false;
		} else if(fname && fsize > (2 * 1024 * 1024)){
			$("body").removeClass("loading");
			$("#error_custom1").html('<i style="color:#dd4b39; font-size:12px;">* File Max 2MB</i>');
			setErrorFocus($("#error_custom1"), $("#role-form"), false);
			return false;
		} else if(tgl_prinsipal < tanggal_putusan){
			$("body").removeClass("loading");
			$("#error_custom6").html('<i style="color:#dd4b39; font-size:12px;">Tanggal laporan prinsipal harus lebih besar atau sama dengan tanggal '+war2+'</i>');
			setErrorFocus($("#tanggal_prinsipal"), $("#role-form"), false);
			return false;
		} else if(tgl_prinsipal > hariIni){
			$("body").removeClass("loading");
			$("#error_custom6").html('<i style="color:#dd4b39; font-size:12px;">Maximal tanggal laporan prinsipal adalah hari ini</i>');
			setErrorFocus($("#tanggal_prinsipal"), $("#role-form"), false);
			return false;
		} else{
			$.ajax({
				type	: "POST",
				url		: '<?php echo Yii::$app->request->baseUrl.'/datun/laporan-principal/cek'; ?>',
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
			});
			return false;
		}
	}
});
</script>
