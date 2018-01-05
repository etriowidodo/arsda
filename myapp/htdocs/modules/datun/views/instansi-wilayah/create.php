<?php
	use yii\helpers\Html;
	if($model->isNewRecord){
		$this->title = 'Tambah Wilayah Instansi';
		$isNewRecord = 1;
		$model = array();
	} else{
		$this->title = 'Ubah Wilayah Instansi';
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
			$('#role-form').validator('destroy').off("submit");
			$('#role-form').submit();
		}
	});
});
</script>
