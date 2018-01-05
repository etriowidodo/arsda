<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBA11Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-ba11-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_ba11') ?>

    <?= $form->field($model, 'id_berkas') ?>

    <?= $form->field($model, 'tgl_surat') ?>

    <?= $form->field($model, 'reg_nomor') ?>

    <?= $form->field($model, 'reg_perkara') ?>

    <?php // echo $form->field($model, 'tahanan') ?>

    <?php // echo $form->field($model, 'ke_tahanan') ?>

    <?php // echo $form->field($model, 'tgl_mulai') ?>

    <?php // echo $form->field($model, 'kepala_rutan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
