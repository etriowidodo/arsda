<?php

use app\modules\pidum\models\PdmSysMenu;
use kartik\builder\Form;
use kartik\form\ActiveForm;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmTemplateTembusan */
/* @var $form yii\widgets\ActiveForm */
?>

<section class="content" style="padding: 0px;">
<div class ="content-wrapper-1">

<div class="pdm-template-tembusan-form">

    <?php $form = ActiveForm::begin(
	 [
                'id' => 'pdm-template-tembusan-form',
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
                echo Form::widget([ /* kode berkas */
                    'model' => $model,
                    'form' => $form,
                    'columns' => 1,
                    'attributes' => [
                        'kd_berkas' => [
                            'label' => 'Kode',
                            'labelSpan' => 2,
                            'columns' => 8,
                            'attributes' => [
                                'kd_berkas' => [
                                    'type' => Form::INPUT_WIDGET,
                                    'widgetClass' => '\kartik\widgets\Select2',
                                    'options' => [
                                        'data' => ArrayHelper::map(PdmSysMenu::find()->asArray()->all(), 'kd_berkas', 'kd_berkas'),
                                        'options' => [
                                            'placeholder' => 'Pilih Kode Persuratan',
                                        ],
                                    ],
                                    'columnOptions' => ['colspan' => 8],
                                ],
                            ]
                        ],
                                
                    ],
                     
                ]);
                ?>
				</div>
                </div>
				</div>
				
				<div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <?php
					echo Form::widget([ /* nama */
                    'model' => $model,
                    'form' => $form,
                    'columns' => 1,
                    'attributes' => [
                        'tembusan' => [
                            'label' => 'Nama',
                            'labelSpan' => 2,
                            'columns' => 6,
                            'attributes' => [
                                'tembusan' => [
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
				
				<div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <?php
					echo Form::widget([ /* nomor surat */
                    'model' => $model,
                    'form' => $form,
                    'columns' => 1,
                    'attributes' => [
                        'no_urut' => [
                            'label' => 'No Urut',
                            'labelSpan' => 2,
                            'columns' => 6,
                            'attributes' => [
                                'no_urut' => [
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
				
				<div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <?php
					echo Form::widget([ /* keterangan */
                    'model' => $model,
                    'form' => $form,
                    'columns' => 1,
                    'attributes' => [
                        'keterangan' => [
                            'label' => 'Keterangan',
                            'labelSpan' => 2,
                            'columns' => 6,
                            'attributes' => [
                                'keterangan' => [
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
</section>
