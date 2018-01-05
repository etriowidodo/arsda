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
			var kasus 		= $('#tab_kasus').val(), putusan = $('#tab_putusan').val(),kesimpulan = $('#tab_kesimpulan').val();
			var filenya 	= $("#file_template")[0].files[0]; 
			var cek			= $("#cek_file").val();
			var msg			="";
			var msg1		="";
			var msg2		="";
						
			if(kasus == '' || putusan == '' || kesimpulan == '' || (cek == 0 && typeof(filenya) == 'undefined')){
				if (kasus == '' || putusan == '' || kesimpulan == '') { 
					msg+="Text editor", msg1+=" dan ", msg2="ada yang";
				} 
				if (cek == 0 && typeof(filenya) == 'undefined') {
					msg+=msg1+"File nodis";
				}
				msg+=" masih "+msg2+" kosong, Apakah anda tetap ingin menyimpan data?";
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
							validasi_upload();
							return false;
						}
					}
				});	
			} else{
				validasi_upload();
				return false;
			}
			return false;
		}
	});

	function validasi_upload(){
		$("body").addClass("loading");
		var filenya 		= $("#file_template")[0].files[0], fname = '', fsize = 0, extnya = '';
		var arrExt 			= [".doc", ".odt", ".docx", ".rtf", ".pdf" ];
		var tgl_prinsipal	= new Date(tgl_auto($("#tanggal_prinsipal").val()));
		var tgl_nodis		= new Date(tgl_auto($("#tanggal_nodis").val()));
		var hariIni 		= new Date('<?php echo date('Y-m-d');?>');

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
			$("#error_custom3").html('<i style="color:#dd4b39; font-size:12px;">* Tipe file hanya .odt,.doc,.docx,.pdf</i>');
			setErrorFocus($("#error_custom3"), $("#role-form"), false);
			return false;
		} else if(fname && fsize > (2 * 1024 * 1024)){
			$("body").removeClass("loading");
			$("#error_custom3").html('<i style="color:#dd4b39; font-size:12px;">* File Max 2MB</i>');
			setErrorFocus($("#error_custom3"), $("#role-form"), false);
			return false;
		} else if(tgl_nodis < tgl_prinsipal){
			$("body").removeClass("loading");
			$("#error_custom5").html('<i style="color:#dd4b39; font-size:12px;">Tanggal nodis harus lebih besar atau sama dengan tanggal prinsipal</i>');
			setErrorFocus($("#tanggal_nodis"), $("#role-form"), false);
			return false;
		} else if(tgl_nodis > hariIni){
			$("body").removeClass("loading");
			$("#error_custom5").html('<i style="color:#dd4b39; font-size:12px;">Maximal tanggal nodis adalah hari ini</i>');
			setErrorFocus($("#tanggal_nodis"), $("#role-form"), false);
			return false;
		} else{
			$.ajax({
				type	: "POST",
				url		: '<?php echo Yii::$app->request->baseUrl.'/datun/nota-dinas-laporan-principal/cek'; ?>',
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
