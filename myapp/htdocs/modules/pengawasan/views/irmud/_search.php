<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LapduSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lapdu-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="col-md-5">
         <div class="form-group">
            <?php $model->cari=$_GET['LapduSearch']['cari'];?>
            <?= $form->field($model, 'cari')->input('cari', ['placeholder' => "Masukan Karakter Yang Dicari"])->label(false) ?>
         </div>
    </div>

    <?//= $form->field($model, 'tanggal_surat_diterima') ?>

    <?//= $form->field($model, 'cari2') ?>

    <?//= $form->field($model, 'perihal_lapdu') ?>

    <?//= $form->field($model, 'tanggal_surat_lapdu') ?>

    <?php // echo $form->field($model, 'ringkasan_lapdu') ?>

    <?php // echo $form->field($model, 'file_lapdu') ?>

    <?php // echo $form->field($model, 'id_media_pelaporan') ?>

    <?php // echo $form->field($model, 'inst_satkerkd') ?>

    <div class="form-group">
        <?= Html::submitButton('Cari', ['class' => 'btn btn-primary']) ?>
        <?php
        //echo "<a class='btn btn-primary btn-sm'><i class='glyphicon glyphicon-search'> Cari </i></a>";
        ?>
        <?= Html::a('Refresh', ['/pengawasan/inspektur/'], ['class'=>'btn btn-default']) ?>
    </div> 

    <?php ActiveForm::end(); ?>

</div>
