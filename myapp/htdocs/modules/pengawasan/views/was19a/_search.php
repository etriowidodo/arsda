<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was19aSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="was19a-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_was_19a') ?>

    <?= $form->field($model, 'no_was_19a') ?>

    <?= $form->field($model, 'id_register') ?>

    <?= $form->field($model, 'inst_satkerkd') ?>

    <?= $form->field($model, 'tgl_was_19a') ?>

    <?php // echo $form->field($model, 'sifat_surat') ?>

    <?php // echo $form->field($model, 'jml_lampiran') ?>

    <?php // echo $form->field($model, 'satuan_lampiran') ?>

    <?php // echo $form->field($model, 'kpd_was_19a') ?>

    <?php // echo $form->field($model, 'id_terlapor') ?>

    <?php // echo $form->field($model, 'ttd_was_19a') ?>

    <?php // echo $form->field($model, 'ttd_peg_nik') ?>

    <?php // echo $form->field($model, 'ttd_id_jabatan') ?>

    <?php // echo $form->field($model, 'upload_file') ?>

    <?php // echo $form->field($model, 'flag') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'created_ip') ?>

    <?php // echo $form->field($model, 'created_time') ?>

    <?php // echo $form->field($model, 'updated_ip') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'updated_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>