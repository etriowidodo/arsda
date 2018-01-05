<?php
	use yii\helpers\Html;
	if(!$model['no_pidsus13_khusus']){
		$isNewRecord = 1;
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
			validasi_upload();
			return false;
		}
	});

	function validasi_upload(){
		$("body").addClass("loading");
		var filenya             = $("#file_template")[0].files[0], fname = '', fsize = 0, extnya = '';
		var arrExt 		= [".doc", ".docx", ".pdf", ".jpg", ".jpeg"];
                var tgl_p8_khusus 	= new Date(tgl_auto($("#tgl_p8_khusus").val()));
		var tgl_pidsus13_khusus 	= new Date(tgl_auto($("#tgl_pidsus13_khusus").val()));
		var hariIni             = new Date('<?php echo date('Y-m-d');?>');		

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
		} else if($("#no_p8_khusus").val() == "" || $("#tgl_p8_khusus").val() == ""){
			$("body").removeClass("loading");
			$("#error_custom_no_p8_khusus").html('<i style="color:#dd4b39; font-size:12px;">Nomor P-8 Khusus Harus diisi</i>');
			setErrorFocus($("#error_custom_no_p8_khusus"), $("#role-form"), false);
			return false;
		} else if(tgl_p8_khusus > tgl_pidsus13_khusus){
			$("body").removeClass("loading");
			$("#error_custom_tgl_pidsus13_khusus").html('<i style="color:#dd4b39; font-size:12px;">Tanggal Pidsus 13 Khusus lebih kecil dari tanggal P-8 Khusus</i>');
			setErrorFocus($("#error_custom_tgl_pidsus13_khusus"), $("#role-form"), false);
			return false;
		} else if(tgl_pidsus13_khusus > hariIni){
			$("body").removeClass("loading");
			$("#error_custom_tgl_pidsus13_khusus").html('<i style="color:#dd4b39; font-size:12px;">Maximal tanggal Pidsus 13 Khusus adalah hari ini</i>');
			setErrorFocus($("#error_custom_tgl_pidsus13_khusus"), $("#role-form"), false);
			return false;
		} else{
			$.ajax({
				type	: "POST",
				url		: '<?php echo Yii::$app->request->baseUrl.'/pidsus/pds-pidsus-13-khusus/cekpidsus13khusus'; ?>',
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
