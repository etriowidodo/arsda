<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm  as ActiveForm2;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\MsPasal */
/* @var $form yii\widgets\ActiveForm */
?>

<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">

    <?php  $form = ActiveForm::begin([
                    'id' => 'ms-pasal-form',
                    'type' => ActiveForm::TYPE_HORIZONTAL,
                    'enableAjaxValidation' => false,
                    'fieldConfig' => [
                        'autoPlaceholder' => false
                    ],
                    'formConfig' => [
                        'deviceSize' => ActiveForm::SIZE_SMALL,
                        'showLabels' => false
                    ]
        ]); ?>
	
	<div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
		<div class="col-md-12">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4">ID Pasal</label>
					<div class="col-md-8">
						<?= $form->field($model, 'id_pasal')->textInput(['maxlength' => true]) ?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4">Undang-Undang</label>
					<div class="col-md-8 pull-right">
						 <?php
                            echo $form->field($model, 'id', [
                                'addon' => [
                                    'append' => [
                                        'content' => Html::a('Pilih', '', ['class' => 'btn btn-warning', 'data-toggle' => 'modal', 'data-target' => '#_undang']),
                                        'asButton' => true
                                    ]
                                ]
                            ]);
                            ?>
						
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-12" id="label_tentang"></label>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4">Pasal</label>
					<div class="col-md-8">
						<?= $form->field($model, 'pasal')->textInput(['maxlength' => true]) ?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4">Bunyi</label>
					<div class="col-md-8">
						<?= $form->field($model, 'bunyi')->textArea(['maxlength' => true]) ?>
					</div>
				</div>
			</div>
		</div>
		
    </div>

    

    <div class="box-footer" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
		<?= Html::a('Batal', $model->isNewRecord ? ['index'] : ['../pidum/ms-u-undang/index'], ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

	</div>
</section>

<?php
Modal::begin([
    'id' => '_undang',
    'header' => 'Daftar Undang-Undang',
    'options' => [
        'data-url' => '',
    ],
]);
?> 

<?=
$this->render('_undang', [
    'model' => $model,
    'searchUU' => $searchUU,
    'dataUU' => $dataUU,
])
?>

<?php
Modal::end();
?>  

<?php
$js = <<< JS
	$(document).ready(function(){
		$("#mspasal-uu").prop("readonly",true);
		$(".panel-heading").hide();
		$(".kv-panel-before").hide();
		$(".close").hide();
	});
	
	 
JS;
$this->registerJs($js);
?>