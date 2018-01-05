<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\VLaporanP6Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vlaporan-p4-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'tgl_terima') ?>

    <?= $form->field($model, 'wilayah_kerja') ?>

    <?= $form->field($model, 'nama_lengkap') ?>

    <?= $form->field($model, 'kasus_posisi') ?>

    <?= $form->field($model, 'asal_perkara') ?>

    <?php // echo $form->field($model, 'tgl_dihentikan') ?>

    <?php // echo $form->field($model, 'tgl_dikesampingkan') ?>

    <?php // echo $form->field($model, 'tgl_dikirim_ke') ?>

    <?php // echo $form->field($model, 'no_denda_ganti') ?>

    <?php // echo $form->field($model, 'tgl_denda_ganti') ?>

    <?php // echo $form->field($model, 'tgl_dilimpahkan') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
