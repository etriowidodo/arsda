<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\pengawasan\models\Pegawai;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\InspekturModelSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="penandatangan-master-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($jbtn, 'peg_nip_baru') ?>

    <?= $form->field($jbtn, 'nama') ?>

    <?= $form->field($model, 'bidang_inspektur') ?>

    <?= $form->field($model, 'kode_surat') ?>

    <?= $form->field($model, 'flag') ?>

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
