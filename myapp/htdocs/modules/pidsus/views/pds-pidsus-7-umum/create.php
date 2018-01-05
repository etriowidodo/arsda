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
		var filenya  = $("#file_template")[0].files[0], fname = '', fsize = 0, extnya = '';
		var fileupl1 = $("#file_upload_posisi_kasus")[0].files[0], fname1 = '', fsize1 = 0, extnya1 = '';
		var fileupl2 = $("#file_upload_pendapat_pemapar")[0].files[0], fname2 = '', fsize2 = 0, extnya2 = '';
		var fileupl3 = $("#file_upload_pendapat_pimpinan")[0].files[0], fname3 = '', fsize3 = 0, extnya3 = '';
		var fileupl4 = $("#file_kesimpulan")[0].files[0], fname4 = '', fsize4 = 0, extnya4 = '';
		var fileupl5 = $("#file_saran")[0].files[0], fname5 = '', fsize5 = 0, extnya5 = '';
		var arrExt 	 = [".doc", ".docx", ".pdf", ".jpg", ".jpeg"];
		var tgl_p8_umum = new Date(tgl_auto($("#tgl_p8_umum").val()));
		var tgl_pidsus7 = new Date(tgl_auto($("#tgl_pidsus7").val()));
		var tgl_ekspose = new Date(tgl_auto($("#tgl_ekspose").val()));
		var hariIni 	= new Date('<?php echo date('Y-m-d');?>');
		$(".with-errors").html("");

		if(typeof(filenya) != 'undefined'){
			fsize 	= filenya.size, 
			fname 	= filenya.name, 
			extnya 	= fname.substr(fname.lastIndexOf(".")).toLowerCase();
		}

		if(typeof(fileupl1) != 'undefined'){
			fsize1 	= fileupl1.size, 
			fname1 	= fileupl1.name, 
			extnya1 = fname1.substr(fname1.lastIndexOf(".")).toLowerCase();
		}

		if(typeof(fileupl2) != 'undefined'){
			fsize2 	= fileupl2.size, 
			fname2 	= fileupl2.name, 
			extnya2 = fname2.substr(fname2.lastIndexOf(".")).toLowerCase();
		}

		if(typeof(fileupl3) != 'undefined'){
			fsize3 	= fileupl3.size, 
			fname3 	= fileupl3.name, 
			extnya3 = fname3.substr(fname3.lastIndexOf(".")).toLowerCase();
		}

		if(typeof(fileupl14) != 'undefined'){
			fsize4 	= fileupl4.size, 
			fname4 	= fileupl4.name, 
			extnya4 = fname4.substr(fname4.lastIndexOf(".")).toLowerCase();
		}

		if(typeof(fileupl5) != 'undefined'){
			fsize5 	= fileupl5.size, 
			fname5 	= fileupl5.name, 
			extnya5 = fname5.substr(fname5.lastIndexOf(".")).toLowerCase();
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
		} else if(tgl_p8_umum > tgl_pidsus7){
			$("body").removeClass("loading");
			$("#error_custom_tgl_pidsus7").html('<i style="color:#dd4b39; font-size:12px;">Tanggal Nota Dinas lebih kecil dari tanggal P-8 Umum</i>');
			setErrorFocus($("#error_custom_tgl_pidsus7"), $("#role-form"), false);
			return false;
		} else if(tgl_p8_umum > tgl_ekspose){
			$("body").removeClass("loading");
			$("#error_custom_tgl_ekspose").html('<i style="color:#dd4b39; font-size:12px;">Tanggal Ekspose lebih kecil dari tanggal P-8 Umum</i>');
			setErrorFocus($("#error_custom_tgl_ekspose"), $("#role-form"), false);
			return false;
		} else if(tgl_ekspose > tgl_pidsus7){
			$("body").removeClass("loading");
			$("#error_custom_tgl_ekspose").html('<i style="color:#dd4b39; font-size:12px;">Tanggal Ekspose lebih besar dari tanggal Nota Dinas</i>');
			setErrorFocus($("#error_custom_tgl_ekspose"), $("#role-form"), false);
			return false;
		} else if(tgl_pidsus7 > hariIni){
			$("body").removeClass("loading");
			$("#error_custom_tgl_pidsus7").html('<i style="color:#dd4b39; font-size:12px;">Maximal tanggal Nota Dinas adalah hari ini</i>');
			setErrorFocus($("#error_custom_tgl_pidsus7"), $("#role-form"), false);
			return false;
		} else{
			$('#role-form').validator('destroy').off("submit");
			$('#role-form').submit();
		}
	}
});
</script>
