<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm  as ActiveForm2;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\MsJenisPerkara */
/* @var $form yii\widgets\ActiveForm */
?>

<section class="content" style="padding: 0px;">

     <div class="content-wrapper-1">

    <?php  $form = ActiveForm::begin([
                    'id' => 'ms-jenis-perkara-form',
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
					<label class="control-label col-md-4">Jenis Pidana</label>
					<div class="col-md-8 pull-right">
						 <?php
                            echo $form->field($model, 'kode_pidana')->dropDownList(["1"=>"OHARDA","2"=>"KAMNEGTIBUM","3"=>"TPUL"]);
                            ?>
						
					</div>
				</div>
			</div>
		</div>
		<!--<div class="col-md-12">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4">Jenis Perkara</label>
					<div class="col-md-8">
						<?= $form->field($model, 'jenis_perkara')->textInput(['maxlength' => true]) ?>
					</div>
				</div>
			</div>
		</div>-->
		<div class="col-md-12">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4">Nama</label>
					<div class="col-md-8">
						<?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>
					</div>
				</div>
			</div>
		</div>
		
    </div>

    

    <div class="box-footer" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
		<?= Html::a('Batal', $model->isNewRecord ? ['index'] : ['../pdsold/ms-jenis-pidana/index'], ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

	</div>
</section>

