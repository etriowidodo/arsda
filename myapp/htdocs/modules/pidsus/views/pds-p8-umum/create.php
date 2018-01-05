<?php
	use yii\helpers\Html;
	if($model->isNewRecord){
		$isNewRecord = 1;
		$model 	= array();
	} else{
		$isNewRecord = 0;
	}
?>
<div class="role-create">
	<?php echo $this->render('_form', ['model' => $model, 'isNewRecord'=>$isNewRecord]); ?>
</div>
<script type="text/javascript">
$(document).ready(function(){
	<?php if($isNewRecord){ ?>
	$("body").addClass('fixed sidebar-collapse');
	$(".sidebar-toggle").click(function(){
		 $("html, body").animate({scrollTop: 0}, 500);
	});
	<?php } ?>

	$('#role-form').validator({disable:false}).on('submit', function(e){
		if(!e.isDefaultPrevented()){
			if($("input[name='jaksa[]']").length == 0){
				bootbox.confirm({ 
					message: "Tabel Jaksa Penyidik masih kosong. Apakah anda ingin tetap menyimpan data?",
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
			}else{
				validasi_upload();
				return false;
			}
		}
	});

	function validasi_upload(){
		$("body").addClass("loading");
		var filenya 	= $("#file_template")[0].files[0], fname = '', fsize = 0, extnya = '';
		var arrExt 		= [".doc", ".docx", ".pdf", ".jpg", ".jpeg"];
		var tgl_p6 		= new Date(tgl_auto($("#tgl_p6").val()));
		var tgl_p8_umum = new Date(tgl_auto($("#tgl_p8_umum").val()));
		var hariIni 	= new Date('<?php echo date('Y-m-d');?>');
		$(".with-errors").html("");

		if(typeof(filenya) != 'undefined'){
			fsize 	= filenya.size, 
			fname 	= filenya.name, 
			extnya 	= fname.substr(fname.lastIndexOf(".")).toLowerCase();
		}

		if(fname && $.inArray(extnya, arrExt) == -1){
			$("body").removeClass("loading");
			$("#error_custom_file_template").html('<i style="color:#dd4b39; font-size:12px;">* Tipe file yang diperbolehkan hanya .doc, .docx, .pdf, dan .jpg</i>');
			setErrorFocus($("#error_custom_file_template"), $("#role-form"), false);
			return false;
		} else if(fname && fsize > (2 * 1024 * 1024)){
			$("body").removeClass("loading");
			$("#error_custom_file_template").html('<i style="color:#dd4b39; font-size:12px;">* Ukuran file yang diperbolehkan maksimal 2MB</i>');
			setErrorFocus($("#error_custom_file_template"), $("#role-form"), false);
			return false;
		} else if($("#penandatangan_nip").val() == "" || $("#penandatangan_nama").val() == ""){
			$("body").removeClass("loading");
			$("#error_custom_penandatangan").html('<i style="color:#dd4b39; font-size:12px;">Penandatangan belum dipilih</i>');
			setErrorFocus($("#penandatangan_nama"), $("#role-form"), false);
			return false;
		} else if($("#no_urut_p6").val() == ""){
			$("body").removeClass("loading");
			$("#error_custom_no_urut_p6").html('<i style="color:#dd4b39; font-size:12px;">P-6 belum dipilih</i>');
			setErrorFocus($("#no_urut_p6"), $("#role-form"), false);
			return false;
		} else if(tgl_p6 > tgl_p8_umum){
			$("body").removeClass("loading");
			$("#error_custom_tgl_p8_umum").html('<i style="color:#dd4b39; font-size:12px;">Tanggal P-8 umum lebih kecil dari tanggal P-6</i>');
			setErrorFocus($("#tgl_p8_umum"), $("#role-form"), false);
			return false;
		} else if(tgl_p8_umum > hariIni){
			$("body").removeClass("loading");
			$("#error_custom_tgl_p8_umum").html('<i style="color:#dd4b39; font-size:12px;">Maximal tanggal P-8 umum adalah hari ini</i>');
			setErrorFocus($("#tgl_p8_umum"), $("#role-form"), false);
			return false;
		} else{
			$.ajax({
				type	: "POST",
				url		: '<?php echo Yii::$app->request->baseUrl.'/pidsus/pds-p8-umum/cekp8umum'; ?>',
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
