<?php
	use yii\helpers\Html;
	if($model->isNewRecord){
		$this->title = 'Tambah Instansi';
		$isNewRecord = 1;
		$model = array();
	} else{
		$this->title = 'Ubah Instansi';
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
				url		: "/datun/instansi/cekinstansi",
				data	: $("#role-form").serialize(),
				cache	: false,
				dataType: 'json',
				success : function(data){ 
					if(data.hasil){
						$("body").removeClass("loading");
						$("#err_kode_jnsnya").html('<span style="color:#dd4b39;">Kode Intansi sudah ada</span>');
						setErrorFocus($("#err_kode_jnsnya"), $("#role-form"), false);
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
