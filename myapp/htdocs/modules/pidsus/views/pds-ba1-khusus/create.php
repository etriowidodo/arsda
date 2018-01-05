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
			validasi_upload();
			return false;
		}
	});

	function validasi_upload(){
		$("body").addClass("loading");
		var filenya 	= $("#file_template")[0].files[0], fname = '', fsize = 0, extnya = '';
		var filenya2 	= $("#file_unggah_pertanyaan")[0].files[0], fname2 = '', fsize2 = 0, extnya2 = '';
		var arrExt 		= [".doc", ".docx", ".pdf", ".jpg", ".jpeg"];
		var tgl_p8_umum  	= new Date(tgl_auto($("#tgl_p8_umum").val()));
		var tgl_ba1_umum 	= new Date(tgl_auto($("#tgl_ba1_umum").val()));
		var tgl_lahir 		= new Date(tgl_auto($("#tgl_lahir").val()));
		var hariIni 		= new Date('<?php echo date('Y-m-d');?>');
		$(".with-errors").html("");

		if(typeof(filenya) != 'undefined'){
			fsize 	= filenya.size, 
			fname 	= filenya.name, 
			extnya 	= fname.substr(fname.lastIndexOf(".")).toLowerCase();
		}

		if(typeof(filenya2) != 'undefined'){
			fsize2 	= filenya2.size, 
			fname2 	= filenya2.name, 
			extnya2 = fname2.substr(fname2.lastIndexOf(".")).toLowerCase();
		}

		if(fname && $.inArray(extnya, arrExt) == -1){
			$("body").removeClass("loading");
			$("#error_custom_file_template").html('<i style="color:#dd4b39; font-size:12px;">* Tipe file yang diperbolehkan hanya .doc, .docx, .pdf, dan .jpg</i>');
			setErrorFocus($("#error_custom_file_template"), $("#role-form"), false);
			return false;
		} else if(fname && fsize > (5 * 1024 * 1024)){
			$("body").removeClass("loading");
			$("#error_custom_file_template").html('<i style="color:#dd4b39; font-size:12px;">* Ukuran file yang diperbolehkan maksimal 5MB</i>');
			setErrorFocus($("#error_custom_file_template"), $("#role-form"), false);
			return false;
		} else if(fname2 && $.inArray(extnya2, arrExt) == -1){
			$("body").removeClass("loading");
			$("#error_custom_file_unggah_pertanyaan").html('<i style="color:#dd4b39; font-size:12px;">* Tipe file yang diperbolehkan hanya .doc, .docx, .pdf, dan .jpg</i>');
			setErrorFocus($("#error_custom_file_unggah_pertanyaan"), $("#role-form"), false);
			return false;
		} else if(fname2 && fsize2 > (5 * 1024 * 1024)){
			$("body").removeClass("loading");
			$("#error_custom_file_unggah_pertanyaan").html('<i style="color:#dd4b39; font-size:12px;">* Ukuran file yang diperbolehkan maksimal 5MB</i>');
			setErrorFocus($("#error_custom_file_unggah_pertanyaan"), $("#role-form"), false);
			return false;
		} else if(tgl_p8_umum > tgl_ba1_umum){
			$("body").removeClass("loading");
			$("#error_custom_tgl_ba1_umum").html('<i style="color:#dd4b39; font-size:12px;">Tanggal BA-1 Umum lebih kecil dari tanggal P-8 Umum</i>');
			setErrorFocus($("#error_custom_tgl_ba1_umum"), $("#role-form"), false);
			return false;
		} else if(tgl_ba1_umum > hariIni){
			$("body").removeClass("loading");
			$("#error_custom_tgl_ba1_umum").html('<i style="color:#dd4b39; font-size:12px;">Maximal tanggal BA-1 Umum adalah hari ini</i>');
			setErrorFocus($("#error_custom_tgl_ba1_umum"), $("#role-form"), false);
			return false;
		} else{
			$('#role-form').validator('destroy').off("submit");
			$('#role-form').submit();
		}
	}
});
</script>
