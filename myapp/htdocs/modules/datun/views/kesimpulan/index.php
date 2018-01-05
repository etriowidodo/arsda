<?php
	use yii\helpers\Html;	
	$this->title = 'Kesimpulan Tergugat (S-22)';
	$isNewRecord = ($model['tanggal_s22'] == ''?1:0);
?>

<div class="role-create">
	<?php echo $this->render('_form', ['model' => $model, 'isNewRecord' => $isNewRecord]); ?>
</div>
<div class="modal-loading-new"></div>

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

	$('#role-form').validator({disable:false}).on('submit', function(e){
		if(!e.isDefaultPrevented()){
			for(var instanceName in CKEDITOR.instances){
				CKEDITOR.instances[instanceName].updateElement();
			}	
			if($('#pokok').val() == '' || $('#tanggapan').val() == '' || $('#penjelasan').val() == '' || $('#kesimpulan').val() == '' ||
			$('#eksepsi').val() == '' || $('#provisi').val() == '' || $('#perkara').val() == '' || $('#rekonpensi').val() == '' || 
			$('#konpensi').val() == '' || $('#subsidair').val() == ''){
				bootbox.confirm({ 
					message: "Text Editor dalam panel [KESIMPULAN, PRIMAIR, SUBSIDAIR] masih ada yang kosong. Apakah anda masih ingin tetap menyimpan data?",
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
		var filenya = $("#file_s22")[0].files[0];
		if(typeof(filenya) == 'undefined'){
			bootbox.confirm({ 
				message: "Anda belum mengunggah file S-22 (Kesimpulan Tergugat). Apakah anda yakin ingin tetap menyimpan data?",
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
		var filenya = $("#file_s22")[0].files[0], fname = '', fsize = 0, extnya = '';
		var arrExt 	= [".doc", ".odt", ".docx", ".rtf", ".pdf" ];
		
		$(".with-errors").html('');
		if(typeof(filenya) != 'undefined'){
			fsize 	= filenya.size, 
			fname 	= filenya.name, 
			extnya 	= fname.substr(fname.lastIndexOf(".")).toLowerCase();
		}
		
		if(fname && $.inArray(extnya, arrExt) == -1){
			$("body").removeClass("loading");
			$("#cek_error").html('<i style="color:#dd4b39; font-size:12px;">* Tipe file hanya .odt,.doc,.docx,.pdf</i>');
			setErrorFocus($("#cek_error"), $("#role-form"), false);
			return false;
		} else if(fname && fsize > (2 * 1024 * 1024)){
			$("body").removeClass("loading");
			$("#cek_error").html('<i style="color:#dd4b39; font-size:12px;">* File Max 2MB</i>');
			setErrorFocus($("#cek_error"), $("#role-form"), false);
			return false;
		} else{
			$('#role-form').validator('destroy').off("submit");
			$('#role-form').submit();
					
		}
		return false;
	}
});
</script>

