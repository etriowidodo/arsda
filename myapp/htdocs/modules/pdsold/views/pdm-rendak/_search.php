<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmRendakSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-rendak-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_rendak') ?>

    <?= $form->field($model, 'id_perkara') ?>

    <?= $form->field($model, 'id_berkas') ?>

    <?= $form->field($model, 'dikeluarkan') ?>

    <?= $form->field($model, 'tgl_dikeluarkan') ?>

    <?php // echo $form->field($model, 'id_penandatangan') ?>

    <?php // echo $form->field($model, 'nama') ?>

    <?php // echo $form->field($model, 'pangkat') ?>

    <?php // echo $form->field($model, 'jabatan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
