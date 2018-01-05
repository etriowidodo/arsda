<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmD3Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-d3-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_d3') ?>

    <?= $form->field($model, 'id_perkara') ?>

    <?= $form->field($model, 'nama') ?>

    <?= $form->field($model, 'alamat') ?>

    <?= $form->field($model, 'is_keputusan') ?>

    <?php // echo $form->field($model, 'no_surat') ?>

    <?php // echo $form->field($model, 'tgl_putus') ?>

    <?php // echo $form->field($model, 'biaya_perkara') ?>

    <?php // echo $form->field($model, 'jml_denda') ?>

    <?php // echo $form->field($model, 'angsur_denda') ?>

    <?php // echo $form->field($model, 'sisa_denda') ?>

    <?php // echo $form->field($model, 'jml_denda_ganti') ?>

    <?php // echo $form->field($model, 'angsur_denda_ganti') ?>

    <?php // echo $form->field($model, 'sisa_denda_ganti') ?>

    <?php // echo $form->field($model, 'jml_uang_ganti') ?>

    <?php // echo $form->field($model, 'angsur_uang_ganti') ?>

    <?php // echo $form->field($model, 'sisa_uang_ganti') ?>

    <?php // echo $form->field($model, 'dikeluarkan') ?>

    <?php // echo $form->field($model, 'tgl_dikeluarkan') ?>

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
