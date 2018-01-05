<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Was9Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="was9-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?//= $form->field($model, 'id_was9') ?>

    <?= $form->field($model, 'tanggal_was9') ?>

    <?= $form->field($model, 'perihal_was9') ?>

    <?= $form->field($model, 'lampiran_was9') ?>

    <?= $form->field($model, 'id_saksi_was9') ?>

    <?php // echo $form->field($model, 'id_register') ?>

    <?php // echo $form->field($model, 'jenis_saksi') ?>

    <?php // echo $form->field($model, 'nip') ?>

    <?php // echo $form->field($model, 'hari_pemeriksaan_was9') ?>

    <?php // echo $form->field($model, 'tanggal_pemeriksaan_was9') ?>

    <?php // echo $form->field($model, 'jam_pemeriksaan_was9') ?>

    <?php // echo $form->field($model, 'tempat_pemeriksaan_was9') ?>

    <?php // echo $form->field($model, 'nip_penandatangan') ?>

    <?php // echo $form->field($model, 'nama_penandatangan_was9') ?>

    <?php // echo $form->field($model, 'pangkat_penandatangan') ?>

    <?php // echo $form->field($model, 'golongan_penandatangan') ?>

    <?php // echo $form->field($model, 'jabatan_penandatangan') ?>

    <?php // echo $form->field($model, 'was9_file') ?>

    <?php // echo $form->field($model, 'id_sp_was') ?>

    <?php // echo $form->field($model, 'sifat_was9') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
