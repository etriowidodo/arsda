<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidsus\models\PdsDikSuratSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pds-dik-surat-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_pds_dik_surat') ?>

    <?= $form->field($model, 'id_pds_dik') ?>

    <?= $form->field($model, 'id_jenis_surat') ?>

    <?= $form->field($model, 'no_surat') ?>

    <?= $form->field($model, 'tgl_surat') ?>

    <?php // echo $form->field($model, 'lokasi_surat') ?>

    <?php // echo $form->field($model, 'sifat_surat') ?>

    <?php // echo $form->field($model, 'lampiran_surat') ?>

    <?php // echo $form->field($model, 'perihal_lap') ?>

    <?php // echo $form->field($model, 'kepada') ?>

    <?php // echo $form->field($model, 'kepada_lokasi') ?>

    <?php // echo $form->field($model, 'id_ttd') ?>

    <?php // echo $form->field($model, 'create_by') ?>

    <?php // echo $form->field($model, 'create_date') ?>

    <?php // echo $form->field($model, 'update_by') ?>

    <?php // echo $form->field($model, 'update_date') ?>

    <?php // echo $form->field($model, 'id_pds_dik_surat_parent') ?>

    <?php // echo $form->field($model, 'id_status') ?>

    <?php // echo $form->field($model, 'jam_surat') ?>

    <?php // echo $form->field($model, 'create_ip') ?>

    <?php // echo $form->field($model, 'update_ip') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
