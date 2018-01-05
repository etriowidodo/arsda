<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\MsPenyidik */
/* @var $form yii\widgets\ActiveForm */
?>


<section class="content" style="padding: 0px;">
<div class ="content-wrapper-1">
  
      <?php $form = ActiveForm::begin(
	 [
                'id' => 'penyidik-form',
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
            <div class="form-group">
                        <label class="control-label col-md-2">Id Asal Surat</label>
                        <div class="col-md-4"  style="width:10">
                    <?php
                            $group = (new \yii\db\Query())
                                    ->select('id_asalsurat, nama')
                                    ->from('pidum.ms_asalsurat')
                                    ->all();
                            $listnama = ArrayHelper::map($group, 'id_asalsurat', 'nama');
                            echo $form->field($model, 'id_asalsurat')->dropDownList($listnama, ['prompt' => '--Pilih--'], ['label' => '']);

   ?>
                       
    </div>
    </div>  
    
    <div class="form-group">
    <label class="control-label col-md-2">Nama</label>
    <div class="col-md-4"  style="width:10">
              <?= $form->field($model, 'nama') ?>
    </div>
    </div>
  </div>  
    
    <hr style="border-color: #c7c7c7;margin: 10px 0;">
    <div class="box-footer" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
    </div>
    </div>
</section>
    <?php ActiveForm::end(); ?>


