<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\MasterPeraturanSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-peraturan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_peraturan') ?>

    <?= $form->field($model, 'isi_peraturan') ?>

    <?= $form->field($model, 'tgl_perja') ?>

    <?= $form->field($model, 'kode_surat') ?>

    <?= $form->field($model, 'pasal') ?>

    <?php // echo $form->field($model, 'tgl_inactive') ?>

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
