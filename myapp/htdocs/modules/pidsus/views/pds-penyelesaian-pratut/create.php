<?php
	use yii\helpers\Html;
	$isNewRecord = (!$model['id_penyelesaian_pratut'])?1:0;
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
		var arrExt 		= [".doc", ".docx", ".pdf", ".jpg", ".jpeg"];
		//var tgl_spdp 	= new Date(tgl_auto($("#tgl_spdp").val()));
		//var tgldittd 	= new Date(tgl_auto($("#tgldittd").val()));
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
		} else{
			$('#role-form').validator('destroy').off("submit");
			$('#role-form').submit();
			return false;
		}
	}
});
</script>
