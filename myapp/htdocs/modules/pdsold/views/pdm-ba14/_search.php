<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBA14Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-ba14-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_ba14') ?>

    <?= $form->field($model, 'id_t8') ?>

    <?= echo $form->field($model, 'tgl_pengeluaran') ?>

    <?=  //echo $form->field($model, 'no_surat') ?>

    <?= //echo $form->field($model, 'tgl_penahanan') ?>

    <?php // echo $form->field($model, 'id_ms_loktahanan') ?>

    <?php // echo $form->field($model, 'tgl_mulai') ?>

    <?php // echo $form->field($model, 'id_penandatangan') ?>

    <?php // echo $form->field($model, 'kepala_rutan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
