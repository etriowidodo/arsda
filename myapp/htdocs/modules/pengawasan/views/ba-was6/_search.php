<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PidumPdmSpdpSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<div style="border-color: #FFFFFF;padding: 15px;overflow: hidden;" class="box box-primary">



    <div class="was10-search">

        <?php
        $form = ActiveForm::begin([
                    'options' => ['enctype' => 'multipart/form-data'],
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
		
		  <div class="col-md-12">
                <div class="col-md-10">
                    <div class="form-group">
                        <label class="control-label col-md-2">No. Surat</label>
                        <div class="col-md-4">
							<?php
							$session = Yii::$app->session;
							$searchModel = new \app\modules\pengawasan\models\Was1Search();
							$noRegister = $searchModel->searchRegister($session->get('was_register'))->no_register;
							?>
						<?= $form->field($model, 'no_register')->textInput(['maxlength' => true, 'readonly' => 'readonly', 'value'=>$noRegister]) ?>
                        </div>
                    </div>
                </div>
            </div>	


        <div class="form-group">

        </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>
