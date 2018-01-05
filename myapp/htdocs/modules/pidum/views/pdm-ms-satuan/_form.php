<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmMsSatuan */
/* @var $form yii\widgets\ActiveForm */
?>



<section class="content" style="padding: 0px;">
<div class ="content-wrapper-1">

<div class="pdm-ms-satuan-form">

    <?php $form = ActiveForm::begin(
	 [
                'id' => 'ms-rentut-form',
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'enableAjaxValidation' => false,
                'fieldConfig' => [
                    'autoPlaceholder'=>false
                ],
                'formConfig' => [
                    'deviceSize' => ActiveForm::SIZE_SMALL,
                    'labelSpan' => 1,
                    'showLabels'=>false

                ]
            ]); 
	?>
	
	<div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <?php
					echo Form::widget([ /* nomor surat */
                    'model' => $model,
                    'form' => $form,
                    'columns' => 1,
                    'attributes' => [
                        'nama' => [
                            'label' => 'Nama',
                            'labelSpan' => 2,
                            'columns' => 6,
                            'attributes' => [
                                'nama' => [
                                    'type' => Form::INPUT_TEXT,
                                    'columnOptions' => ['colspan' =>4],
                                ],
                            ]
                        ],
                    ]
                ]);
                ?>
                    </div>
                </div>
				</div>
			</div>

    <hr style="border-color: #c7c7c7;margin: 10px 0;">
    <div class="box-footer" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
</div>
