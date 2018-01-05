<?php
	use yii\helpers\Html;
	$this->title 	= 'Mediasi';
	$isNewRecord 	= ($model['proses_mediasi'] == ''?1:0);
	$tanggal_skk 	= ($model['tanggal_skk'])?date("d-m-Y", strtotime($model['tanggal_skk'])):"";
	$tgl_diterima 	= ($model['tanggal_diterima'])?date("d-m-Y", strtotime($model['tanggal_diterima'])):"";
	$tgl_skks 		= ($model['tgl_skks'])?date("d-m-Y", strtotime($model['tgl_skks'])):"";
	$cstatus	 	= ($model['status'] == 'S-13' || $model['status'] == 'EKSEPSI (S-14)'||$model['status'] == 'DUPLIK (S-17)' || $model['status'] == 'S-18' || 
					   $model['status'] == 'S-19A' || $model['status'] == 'KESIMPULAN (S-22)' ?1:0); 
?>
<div class="role-create">
	<?php echo $this->render('_form', [
		'model' 		=> $model,
		'tanggal_skk' 	=> $tanggal_skk,
		'tgl_diterima' 	=> $tgl_diterima,
		'tgl_skks' 		=> $tgl_skks,
		'isNewRecord' 	=> $isNewRecord,
		'cstatus'		=> $cstatus,
		]); ?>
</div>

<script type="text/javascript">
$(document).ready(function(){			
	$('#role-form').validator({disable:false}).on('submit', function(e){
		if(!e.isDefaultPrevented()){
			var filenya = $("#file_template")[0].files[0];
			if(typeof(filenya) == 'undefined' && $("#proses_mediasi").val() == 'Berhasil'){
				bootbox.confirm({ 
					message: "Upload File Mediasi Masih Kosong. Tetap Simpan Data Tanpa Melampirkan File Mediasi..?",
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
	});

	function validasi_upload(){
		$("body").addClass("loading");
		var filenya = $("#file_template")[0].files[0], fname = '', fsize = 0, extnya = '';
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
			setErrorFocus($("#cek_error"), $("#harian-form"), false);
			return false;
		} else if(fname && fsize > (2 * 1024 * 1024)){
			$("body").removeClass("loading");
			$("#cek_error").html('<i style="color:#dd4b39; font-size:12px;">* File Max 2MB</i>');
			setErrorFocus($("#cek_error"), $("#harian-form"), false);
			return false;
		} else{
			$('#role-form').validator('destroy').off("submit");
			$('#role-form').submit();
		}
	}

});
</script>
