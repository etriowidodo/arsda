<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PdsLidSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pds-lid-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_pds_lid') ?>

    <?= $form->field($model, 'id_satker') ?>

    <?= $form->field($model, 'no_lap') ?>

    <?= $form->field($model, 'tgl_diterima') ?>

    <?= $form->field($model, 'penerima_lap') ?>

    <?php // echo $form->field($model, 'lokasi_lap') ?>

    <?php // echo $form->field($model, 'pelapor') ?>

    <?php // echo $form->field($model, 'perihal_lap') ?>

    <?php // echo $form->field($model, 'asal_surat_lap') ?>

    <?php // echo $form->field($model, 'no_surat_lap') ?>

    <?php // echo $form->field($model, 'tgl_lap') ?>

    <?php // echo $form->field($model, 'isi_surat_lap') ?>

    <?php // echo $form->field($model, 'uraian_surat_lap') ?>

    <?php // echo $form->field($model, 'penandatangan_lap') ?>

    <?php // echo $form->field($model, 'create_by') ?>

    <?php // echo $form->field($model, 'create_date') ?>

    <?php // echo $form->field($model, 'update_by') ?>

    <?php // echo $form->field($model, 'update_date') ?>

    <?php // echo $form->field($model, 'id_status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
