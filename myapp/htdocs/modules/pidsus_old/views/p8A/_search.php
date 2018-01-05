<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PdsDikRendikSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pds-dik-rendik-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_pds_dik_rendik') ?>

    <?= $form->field($model, 'id_pds_dik_surat') ?>

    <?= $form->field($model, 'no_urut') ?>

    <?= $form->field($model, 'kasus_posisi') ?>

    <?= $form->field($model, 'pasal_disangkakan') ?>

    <?php // echo $form->field($model, 'alat_bukti') ?>

    <?php // echo $form->field($model, 'tindakan_hukum') ?>

    <?php // echo $form->field($model, 'waktu_tempat') ?>

    <?php // echo $form->field($model, 'koor_dan_dal') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <?php // echo $form->field($model, 'create_by') ?>

    <?php // echo $form->field($model, 'create_date') ?>

    <?php // echo $form->field($model, 'update_by') ?>

    <?php // echo $form->field($model, 'update_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
