<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\SkWas4cSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sk-was4c-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_sk_was_4c') ?>

    <?= $form->field($model, 'no_sk_was_4c') ?>

    <?= $form->field($model, 'inst_satkerkd') ?>

    <?= $form->field($model, 'id_register') ?>

    <?= $form->field($model, 'tgl_sk_was_4c') ?>

    <?php // echo $form->field($model, 'ttd_sk_was_4c') ?>

    <?php // echo $form->field($model, 'perja') ?>

    <?php // echo $form->field($model, 'tgl_1') ?>

    <?php // echo $form->field($model, 'tgl_2') ?>

    <?php // echo $form->field($model, 'anggaran') ?>

    <?php // echo $form->field($model, 'thn_dipa') ?>

    <?php // echo $form->field($model, 'ttd_peg_nik') ?>

    <?php // echo $form->field($model, 'upload_file') ?>

    <?php // echo $form->field($model, 'is_deleted') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'created_ip') ?>

    <?php // echo $form->field($model, 'created_time') ?>

    <?php // echo $form->field($model, 'updated_ip') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'updated_time') ?>

    <?php // echo $form->field($model, 'ttd_id_jabatan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
