<?php
	use yii\helpers\Html;
	if($model->isNewRecord){
		$this->title = 'Config';
		$model 	= array();
		$act 	= 1;
	} else{
		$this->title = 'Ubah Config';
		$act = 0;
	}
?>
<div class="pdm-config-create">
	<?php echo $this->render('_form', ['model' => $model, 'act'=>$act]); ?>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#role-form").validator({disable:false});
	});
</script>