<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was21Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="was21-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_was_21') ?>

    <?= $form->field($model, 'no_was_21') ?>

    <?= $form->field($model, 'id_register') ?>

    <?= $form->field($model, 'inst_satkerkd') ?>

    <?= $form->field($model, 'tgl_was_21') ?>

    <?php // echo $form->field($model, 'sifat_surat') ?>

    <?php // echo $form->field($model, 'jml_lampiran') ?>

    <?php // echo $form->field($model, 'satuan_lampiran') ?>

    <?php // echo $form->field($model, 'perihal') ?>

    <?php // echo $form->field($model, 'kpd_was_21') ?>

    <?php // echo $form->field($model, 'ttd_was_21') ?>

    <?php // echo $form->field($model, 'id_terlapor') ?>

    <?php // echo $form->field($model, 'pendapat') ?>

    <?php // echo $form->field($model, 'id_peraturan') ?>

    <?php // echo $form->field($model, 'tingkat_kd') ?>

    <?php // echo $form->field($model, 'kputusan_ja') ?>

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
