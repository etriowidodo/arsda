<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was16cSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="was16c-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

<div class="col-md-6">
    <div class="form-group">
        <label class="control-label col-md-2">Cari</label>
        <div class="col-md-10">
        <?= $form->field($model, 'cari',[
                                      'addon' => [
                                        'append' => [
                                            'content' => Html::submitButton('Cari', ['class'=>'btn btn-primary']),
                                            'asButton' => true
                                        ]
                                    ]
                                ])->label(false) ?>
        </div>
    </div>
</div>


    
    

    <div class="form-group">
        <?//= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?//= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
