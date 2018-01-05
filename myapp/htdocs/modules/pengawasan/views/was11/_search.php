<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LapduSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sp-was1-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="col-md-5">
         <div class="form-group">
            <?php $model->cari=$_GET['was11']['cari'];?>
            <?= $form->field($model, 'cari')->input('cari', ['placeholder' => "Masukan Karakter Yang Dicari"])->label(false) ?>
         </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Cari', ['class' => 'btn btn-primary']) ?>
        <?php
        ?>
        <?= Html::a('Refresh', ['/pengawasan/was11/'], ['class'=>'btn btn-default']) ?>
    </div> 

    <?php ActiveForm::end(); ?>

</div>
