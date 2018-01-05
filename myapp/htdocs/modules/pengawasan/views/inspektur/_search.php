<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\WasDisposisiInspekturSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="was-disposisi-inspektur-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'no_urut') ?>

    <?= $form->field($model, 'id_tingkat') ?>

    <?= $form->field($model, 'id_kejati') ?>

    <?= $form->field($model, 'id_kejari') ?>

    <?= $form->field($model, 'id_cabjari') ?>

    <?php // echo $form->field($model, 'id_wilayah') ?>

    <?php // echo $form->field($model, 'id_level1') ?>

    <?php // echo $form->field($model, 'id_level2') ?>

    <?php // echo $form->field($model, 'id_level3') ?>

    <?php // echo $form->field($model, 'id_level4') ?>

    <?php // echo $form->field($model, 'no_register') ?>

    <?php // echo $form->field($model, 'id_inspektur') ?>

    <?php // echo $form->field($model, 'tanggal_disposisi') ?>

    <?php // echo $form->field($model, 'isi_disposisi') ?>

    <?php // echo $form->field($model, 'file_inspektur') ?>

    <?php // echo $form->field($model, 'id_irmud') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'urut_terlapor') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'created_ip') ?>

    <?php // echo $form->field($model, 'created_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
