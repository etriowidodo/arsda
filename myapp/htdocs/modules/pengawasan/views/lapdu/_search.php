<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LapduSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lapdu-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'id'=>'searchFormLapdu', 
            'options'=>['name'=>'searchFormLapdu'],
    ]); ?>
     <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-sm-2">Cari</label>
                    <div class="col-sm-8 kejaksaan">
                            <?= $form->field($model, 'cari',[
                                                'addon' => [
                                                    'append' => [
                                                        'content' => Html::button('Cari', ['class'=>'btn btn-default','type'=>'submit', 'id'=>'Mcari_cabjari']),
                                                        'asButton' => true
                                                    ]
                                                ]
                                            ])->textInput(['placeholder'=>'Cari'])->label(false) ?>
                            <?//= $form->field($model, 'nomor_surat_lapdu')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>

   

    <div class="form-group">
        <?//= Html::submitButton('Cari', ['class' => 'btn btn-primary']) ?>
        <?php
        // echo "<a class='btn btn-primary btn-sm'><i class='glyphicon glyphicon-search'> Cari </i></a>";
        ?>
        <?//= Html::a('Refresh', ['/pengawasan/lapdu/'], ['class'=>'btn btn-default']) ?>
    </div> 

    <?php ActiveForm::end(); ?>

</div>
