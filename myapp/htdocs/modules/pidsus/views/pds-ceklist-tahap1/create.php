<?php
	use yii\helpers\Html;
	$isNewRecord = (!$model['id_ceklist'])?1:0;
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
		var filenya = $("#file_template")[0].files[0], fname = '', fsize = 0, extnya = '';
		var arrExt 	= [".doc", ".odt", ".docx", ".rtf", ".pdf" ];
		var tgl_berkas 		= new Date(tgl_auto($("#tgl_berkas").val()));
		var tgl_pengantar 	= new Date(tgl_auto($("#tgl_pengantar").val()));
		var tgl_mulai 	= ($("#tgl_mulai").val() != "")?new Date(tgl_auto($("#tgl_mulai").val())):"";
		var tgl_selesai = ($("#tgl_selesai").val() != "")?new Date(tgl_auto($("#tgl_selesai").val())):"";
		$(".with-errors").html("");

		if(typeof(filenya) != 'undefined'){
			fsize 	= filenya.size, 
			fname 	= filenya.name, 
			extnya 	= fname.substr(fname.lastIndexOf(".")).toLowerCase();
		}

		if(fname && $.inArray(extnya, arrExt) == -1){
			$("body").removeClass("loading");
			$("#error_custom_file_template").html('<i style="color:#dd4b39; font-size:12px;">* Tipe file hanya .odt,.doc,.docx,.pdf</i>');
			setErrorFocus($("#error_custom_file_template"), $("#role-form"), false);
			return false;
		} else if(fname && fsize > (2 * 1024 * 1024)){
			$("body").removeClass("loading");
			$("#error_custom_file_template").html('<i style="color:#dd4b39; font-size:12px;">* File Max 2MB</i>');
			setErrorFocus($("#error_custom_file_template"), $("#role-form"), false);
			return false;
		} else if(tgl_mulai && (tgl_mulai < tgl_pengantar)){
			$("body").removeClass("loading");
			$("#error_custom_waktu_penelitian").html('<i style="color:#dd4b39; font-size:12px;">Tanggal mulai penelitian tidak boleh lebih kecil daripada tanggal pengantar</i>');
			setErrorFocus($("#error_custom_waktu_penelitian"), $("#role-form"), false);
			return false;
		} else if(tgl_mulai && tgl_selesai && (tgl_selesai < tgl_mulai)){
			$("body").removeClass("loading");
			$("#error_custom_waktu_penelitian").html('<i style="color:#dd4b39; font-size:12px;">Tanggal selesai tidak boleh lebih kecil daripada tanggal mulai</i>');
			setErrorFocus($("#error_custom_waktu_penelitian"), $("#role-form"), false);
			return false;
		} else{
			$('#role-form').validator('destroy').off("submit");
			$('#role-form').submit();
		}
	}
});
</script>
