<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<script>

</script>
	<?php 
	$form = ActiveForm::begin([
		'options' => ['enctype' => 'multipart/form-data'],
		'id' => 'was16c-form',
		'type' => ActiveForm::TYPE_HORIZONTAL,
		'enableAjaxValidation' => false,
		'fieldConfig' => [
			'autoPlaceholder' => false
		],
		'formConfig' => [
			'deviceSize' => ActiveForm::SIZE_SMALL,
			'showLabels' => false

		],
	]); 
	?>
	
<div class="box box-primary">
	<div class="box-header with-border">	
		<div class="col-md-12">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4">Pilih Terlapor</label>
					<div class="col-md-8">	
						<?= $form->field($model, 'no_register')->textInput(['maxlength' => true]) ?>
						<?= $form->field($model, 'id_register')->hiddenInput(['maxlength' => true]) ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

    <?php ActiveForm::end(); ?>