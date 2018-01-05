<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm  as ActiveForm2;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use app\modules\pdsold\models\MsJenisPidana;
/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\MsUUndang */
/* @var $form yii\widgets\ActiveForm */
?>

<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">

    <?php  $form = ActiveForm::begin([
                    'id' => 'ms-undang-undang-form',
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
					<label class="control-label col-md-4">ID</label>
					<div class="col-md-8">
						<?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4">Jenis Tindak Pidana</label>
					<div class="col-md-8">
						<?php 
						 echo $form->field($model, 'jns_tindak_pidana')->dropDownList(
                                ArrayHelper::map(MsJenisPidana::find()->all(), 'kode_pidana', 'akronim'));
						?>
						
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4">Undang-Undang</label>
					<div class="col-md-8">
						<?= $form->field($model, 'uu')->textInput(['maxlength' => true]) ?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="col-md-8">
				<div class="form-group">
					<label class="control-label col-md-3">Tentang</label>
					<div class="col-md-8">
						<?= $form->field($model, 'tentang')->textArea(['maxlength' => true]) ?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="col-md-8">
				<div class="form-group">
					<label class="control-label col-md-3">Deskripsi</label>
					<div class="col-md-8">
						<?= $form->field($model, 'deskripsi')->textArea(['maxlength' => true]) ?>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-md-12">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4">Tanggal Diundangkan</label>
					<div class="col-md-8">
						<?=

                                $form->field($model, 'tanggal')->widget(DateControl::className(), [
                                    'type' => DateControl::FORMAT_DATE,
                                    'ajaxConversion' => false,
                                    'options' => [
                                        'options'=>[
                                            'placeholder'=>'DD-MM-YYYY',//jaka | tambah placeholder format tanggal
											'style'=>'width:28%',
                                        ],
                                        'pluginOptions' => [
                                            'autoclose' => true
                                        ]
                                    ]
                                ]);                                
                                ?>
					</div>
				</div>
			</div>
		</div>
    </div>

    

    <div class="box-footer" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
		<?= Html::a('Batal', $model->isNewRecord ? ['index'] : ['../pdsold/ms-u-undang/index'], ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

	</div>
</section>
