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
        'id'=>'searchForm', 
        'options'=>['name'=>'searchForm'],
    ]); ?>
    <div class="col-md-5">
         <div class="form-group">
            <?php $model->cari=$_GET['SpWas1Search']['cari'];?>
            <?= $form->field($model, 'cari')->input('cari', ['placeholder' => "Masukan Karakter Yang Dicari"])->label(false) ?>
         </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Cari', ['class' => 'btn btn-primary']) ?>
        <?php
        ?>
        <?= Html::a('Refresh', ['/pengawasan/sp-was-1/'], ['class'=>'btn btn-default']) ?>
    </div> 

    <?php ActiveForm::end(); ?>

</div>
