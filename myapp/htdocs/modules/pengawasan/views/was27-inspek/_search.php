<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was27InspekSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="was27-inspek-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_was_27_inspek') ?>

    <?= $form->field($model, 'id_register') ?>

    <?= $form->field($model, 'inst_satkerkd') ?>

    <?= $form->field($model, 'no_was_27_inspek') ?>

    <?= $form->field($model, 'tgl') ?>

    <?php // echo $form->field($model, 'sifat_surat') ?>

    <?php // echo $form->field($model, 'jml_lampiran') ?>

    <?php // echo $form->field($model, 'satuan_lampiran') ?>

    <?php // echo $form->field($model, 'data_data') ?>

    <?php // echo $form->field($model, 'upload_file_data') ?>

    <?php // echo $form->field($model, 'analisa') ?>

    <?php // echo $form->field($model, 'kesimpulan') ?>

    <?php // echo $form->field($model, 'rncn_henti_riksa_1_was_27_ins') ?>

    <?php // echo $form->field($model, 'rncn_henti_riksa_2_was_27_ins') ?>

    <?php // echo $form->field($model, 'pendapat_1_was_27_ins') ?>

    <?php // echo $form->field($model, 'pendapat') ?>

    <?php // echo $form->field($model, 'persetujuan') ?>

    <?php // echo $form->field($model, 'ttd_was_27_inspek') ?>

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
