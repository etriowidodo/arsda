<?php
	use yii\helpers\Html;	
	$this->title = 'Duplik (S-17)';
	$isNewRecord = ($model['tanggal_s17'] == ''?1:0);
?>

<div class="role-create">
	<?php echo $this->render('_form', ['model' => $model, 'isNewRecord' => $isNewRecord ]); ?>
</div>

<script type="text/javascript">
$(document).ready(function(){
	$("body").addClass('fixed sidebar-collapse');
	$(".sidebar-toggle").click(function(){
		 $("html, body").animate({scrollTop: 0}, 500);
	});
	
	function tgl_auto($tgl){
		var a = $tgl.toString().split('-');
		return a[2]+'-'+a[1]+'-'+a[0];
	}
	
	$('#duplik-form').validator({disable:false}).on('submit', function(e){
		if(!e.isDefaultPrevented()){
			for(var instanceName in CKEDITOR.instances){
				CKEDITOR.instances[instanceName].updateElement();
			}	
			if($('#jawaban_eksepsi').val() == '' || $('#jawaban_provisi').val() == '' || $('#jawaban_pokokperkara').val() == '' || $('#jawaban_rekonvensi').val() == '' || 
			$('#primair_primeksepsi').val() == '' || $('#primair_primprovisi').val() == '' || $('#primair_primpokokperkara').val() == '' || 
			$('#primair_primrekonvensi').val() == '' || $('#primair_primkonvensi').val() == '' || $('#subsidair').val() == ''){
				bootbox.confirm({ 
					message: "Text Editor dalam panel [JAWABAN, PRIMAIR, SUBSIDAIR] masih ada yang kosong. Apakah anda masih ingin tetap menyimpan data?",
					size: "small",
					closeButton: false,
					buttons: {
						confirm: {label:'<div style="min-width:30px">Ya</div>', className:'btn-primary pull-right jarak-kanan'},
						cancel: {label:'<div style="min-width:30px">Tidak</div>', className:'btn-default pull-right'}
					},
					callback: function(result){
						if(result){
							$(".bootbox-confirm").modal('hide');
							$(".bootbox-confirm").one('hidden.bs.modal', function(){
								$("body").addClass("modal-open");
							});
							cekUploadReplik();
							return false;
						}
					}
				});
				return false;
			} else{
				cekUploadReplik();
				return false;
			}
		}
	});
			
	function cekUploadReplik(){
		var filenya = $("#file_replik")[0].files[0];
		if(typeof(filenya) == 'undefined'){
			bootbox.confirm({ 
				message: "Anda belum mengunggah file Replik Penggugat. Apakah anda yakin ingin tetap menyimpan data?",
				size: "small",
				closeButton: false,
				buttons: {
					confirm: {label:'<div style="min-width:30px">Ya</div>', className:'btn-primary pull-right jarak-kanan'},
					cancel: {label:'<div style="min-width:30px">Tidak</div>', className:'btn-default pull-right'}
				},
				callback: function(result){
					if(result){
						$(".bootbox-confirm").modal('hide');
						$(".bootbox-confirm").one('hidden.bs.modal', function(){
							$("body").addClass("modal-open");
						});
						cekUploadDuplik();
						return false;
					}
				}
			});
			return false;
		} else{
			cekUploadDuplik();
			return false;
		}
	}

	function cekUploadDuplik(){
		var filenya = $("#file_s17")[0].files[0];
		if(typeof(filenya) == 'undefined'){
			bootbox.confirm({ 
				message: "Anda belum mengunggah file S-17 (Duplik Tergugat). Apakah anda yakin ingin tetap menyimpan data?",
				size: "small",
				closeButton: false,
				buttons: {
					confirm: {label:'<div style="min-width:30px">Ya</div>', className:'btn-primary pull-right jarak-kanan'},
					cancel: {label:'<div style="min-width:30px">Tidak</div>', className:'btn-default pull-right'}
				},
				callback: function(result){
					if(result){
						$(".bootbox-confirm").modal('hide');
						validasi_upload();
						return false;
					}
				}
			});
			return false;
		} else{
			validasi_upload();
			return false;
		}
	}

	function validasi_upload(){
		$("body").addClass("loading");
		var filenya 	= $("#file_replik")[0].files[0], fname = '', fsize = 0, extnya = '';
		var filenya2 	= $("#file_s17")[0].files[0], fname2 = '', fsize2 = 0, extnya2 = '';
		var arrExt 		= [".doc", ".odt", ".docx", ".rtf", ".pdf" ];

		$("#error_custom1,#error_custom2,#error_custom3,#error_custom4,#error_custom5").html('');
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
			
		if(fname && $.inArray(extnya, arrExt) == -1){
			$("body").removeClass("loading");
			$("#error_custom4").html('<i style="color:#dd4b39; font-size:12px;">* Tipe file hanya .odt,.doc,.docx,.pdf</i>');
			setErrorFocus($("#error_custom4"), $("#duplik-form"), false);
			return false;
		} else if(fname && fsize > (2 * 1024 * 1024)){
			$("body").removeClass("loading");
			$("#error_custom4").html('<i style="color:#dd4b39; font-size:12px;">* File Max 2MB</i>');
			setErrorFocus($("#error_custom4"), $("#duplik-form"), false);
			return false;
		} else if(fname2 && $.inArray(extnya2, arrExt) == -1){
			$("body").removeClass("loading");
			$("#error_custom5").html('<i style="color:#dd4b39; font-size:12px;">* Tipe file hanya .odt, .doc, .docx, .pdf</i>');
			setErrorFocus($("#error_custom5"), $("#duplik-form"), false);
			return false;
		} else if(fname2 && fsize2 > (2 * 1024 * 1024)){
			$("body").removeClass("loading");
			$("#error_custom5").html('<i style="color:#dd4b39; font-size:12px;">* File Max 2MB</i>');
			setErrorFocus($("#error_custom5"), $("#duplik-form"), false);
			return false;
		} else{														
			$('#duplik-form').validator('destroy').off("submit");
			$('#duplik-form').submit();			
		}
	}	
});
</script>
