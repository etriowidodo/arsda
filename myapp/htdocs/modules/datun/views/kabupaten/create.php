<?php
	use yii\helpers\Html;
	if($model->isNewRecord){
		$this->title = 'Tambah Kabupaten/Kota';
		$isNewRecord = 1;
		$model = array();
	} else{
		$this->title = 'Ubah Kabupaten/Kota';
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
			$.ajax({
				type	: "POST",
				url		: '<?php echo Yii::$app->request->baseUrl.'/datun/kabupaten/cekwilayah'; ?>',
				data	: $("#role-form").serialize(),
				cache	: false,
				dataType: 'json',
				success : function(data){ 
					if(data.hasil){
						$("body").removeClass("loading");
						$("#kodenya").html('<span style="color:#dd4b39;">Kode kabupaten/kota sudah ada</span>').parents(".form-group").addClass("has-error");
						setErrorFocus($("#kode_kab"), $("#role-form"), true);
					} else{
						$('#role-form').validator('destroy').off("submit");
						$('#role-form').submit();
					}
				}
			});
			return false;
		}
	});
});
</script>
