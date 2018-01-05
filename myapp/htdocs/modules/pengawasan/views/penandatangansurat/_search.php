<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use kartik\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\InspekturModelSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="penandatangan-surat-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'id'=>'searchForm', 
        'options'=>['name'=>'searchForm']
    ]); ?>
    <div class="col-md-12 col-sm-6 col-xs-12">
        <div class="form-group">
            <label class="control-label col-md-1" style="margin-top: 5px;">Cari</label>
            <div class="col-md-5">
    <?= $form->field($model, 'id_surat',[
                                'addon' => [
                                    'append' => [
                                        'content' => Html::submitButton('<i class="fa fa-search"> Cari </i>', ['class' => 'btn btn-primary btn-cari']),
                                        'asButton' => true
                                    ],
                                    
                                ],

                            ])->label(false); ?>
            </div>
        </div>
    </div>

    <?//= $form->field($model, 'nip') ?>

    <?//= $form->field($model, 'id_jabatan') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'created_ip') ?>

    <?php // echo $form->field($model, 'created_time') ?>

    <?php // echo $form->field($model, 'updated_ip') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'updated_time') ?>

    <div class="form-group">
        <?//= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?//= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
