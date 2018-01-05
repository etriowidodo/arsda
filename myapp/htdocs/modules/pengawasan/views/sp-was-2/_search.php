<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\SpWas2Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sp-was2-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="col-md-5">
         <div class="form-group">
            <?php $model->cari=$_GET['SpWas2Search']['cari'];?>
            <?= $form->field($model, 'cari')->input('cari', ['placeholder' => "Masukan Karakter Yang Dicari"])->label(false) ?>
         </div>
    </div>
    <?//= $form->field($model, 'id_sp_was2') ?>

    <?//= $form->field($model, 'no_sp_was_2') ?>

    <?//= $form->field($model, 'inst_satkerkd') ?>

    <?//= $form->field($model, 'id_register') ?>

    <?//= $form->field($model, 'tgl_sp_was_2') ?>

    <?php // echo $form->field($model, 'ttd_sp_was_2') ?>

    <?php // echo $form->field($model, 'perja') ?>

    <?php // echo $form->field($model, 'tgl_1') ?>

    <?php // echo $form->field($model, 'tgl_2') ?>

    <?php // echo $form->field($model, 'anggaran') ?>

    <?php // echo $form->field($model, 'thn_dipa') ?>

    <?php // echo $form->field($model, 'ttd_peg_nik') ?>

    <?php // echo $form->field($model, 'ttd_id_jabatan') ?>

    <?php // echo $form->field($model, 'upload_file') ?>

    <?php // echo $form->field($model, 'is_deleted') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'created_ip') ?>

    <?php // echo $form->field($model, 'created_time') ?>

    <?php // echo $form->field($model, 'updated_ip') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'updated_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Cari', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Refresh', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
