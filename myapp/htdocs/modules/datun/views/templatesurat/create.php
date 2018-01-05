<?php
	use yii\helpers\Html;
	if($model->isNewRecord){
		$this->title = 'Template Surat';
		$isNewRecord = 1;
		$model = array();
	} else{
		$this->title = 'Ubah Template Surat';
		$isNewRecord = 0;
	}
?>
<div class="role-create">
	<?php echo $this->render('_form', ['model' => $model, 'isNewRecord'=>$isNewRecord]); ?>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('#role-form').validator({disable:false}).on('submit', function(e){
		if(!e.isDefaultPrevented()){
			$("body").addClass("loading");
			var filenya = $("#file_template")[0].files[0], fname = '', fsize = 0, extnya = '';
			var arrExt 	= [".docx"];
			if(typeof(filenya) != 'undefined'){
				fsize 	= filenya.size, 
				fname 	= filenya.name, 
				extnya 	= fname.substr(fname.lastIndexOf(".")).toLowerCase();
			}
			if(fname && $.inArray(extnya, arrExt) == -1){
				$("body").removeClass("loading");
				$(".with-errors").eq(2).html("Tipe file yang diperbolehkan hanya [.docx]").parents(".form-group").addClass("has-error");
				return false
			} else if(fname && fsize > (2 * 1024 * 1024)){
				$("body").removeClass("loading");
				$(".with-errors").eq(2).html("Ukuran file terlalu besar").parents(".form-group").addClass("has-error");
				return false
			} else{
				$.ajax({
					type	: "POST",
					url		: '<?php echo Yii::$app->request->baseUrl.'/datun/templatesurat/cekrole'; ?>',
					data	: $("#role-form").serialize(),
					cache	: false,
					dataType: 'json',
					success : function(data){
						if(data.hasil){
							$("body").removeClass("loading");
							$("#kodenya").html('<span style="color:#dd4b39;">Kode Intansi sudah ada</span>').parents(".form-group").addClass("has-error");
							setErrorFocus($("#kode_template_surat"), $("#role-form"), true);
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
});
</script>
