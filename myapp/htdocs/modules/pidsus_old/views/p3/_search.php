<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PdsLidRenlidSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pds-lid-renlid-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_pds_lid_renlid') ?>

    <?= $form->field($model, 'id_pds_lid_surat') ?>

    <?= $form->field($model, 'no_urut') ?>

    <?= $form->field($model, 'laporan') ?>

    <?= $form->field($model, 'kasus_posisi') ?>

    <?php // echo $form->field($model, 'dugaan_pasal') ?>

    <?php // echo $form->field($model, 'alat_bukti') ?>

    <?php // echo $form->field($model, 'sumber') ?>

    <?php // echo $form->field($model, 'pelaksana') ?>

    <?php // echo $form->field($model, 'tindakan_hukum') ?>

    <?php // echo $form->field($model, 'tempat') ?>

    <?php // echo $form->field($model, 'koor_dan_dal') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <?php // echo $form->field($model, 'create_by') ?>

    <?php // echo $form->field($model, 'create_date') ?>

    <?php // echo $form->field($model, 'update_by') ?>

    <?php // echo $form->field($model, 'update_date') ?>

    <?php // echo $form->field($model, 'waktu') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
