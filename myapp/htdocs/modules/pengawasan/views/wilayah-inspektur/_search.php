<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\InspekturModelSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dipa-master-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'id'     => 'SearchForm',
        'options'=> ['name'=>'SearchForm'],
       /* 'fieldConfig' => [
                            'options' => [
                                'tag' => true,
                            ],
                        ],*/
    ]); ?>

    <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-2"><span><b>Cari</b></span></label>
                <div class="col-md-10">
                      <!-- <div class="form-group input-group"> -->
                      <?= $form->field($model, 'cari')->label(false); ?>
                      <!-- <span class="input-group-btn"> -->
                        <!-- <button type="submit" class="btn btn-primary">Search</button> -->
                      <!-- </span> -->
                      <!-- </div> -->
                </div>
            </div>
        </div>
  

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
