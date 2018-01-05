<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBA13Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-ba13-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_ba13') ?>

    <?= $form->field($model, 'id_t8') ?>

    <?= $form->field($model, 'tgl_pengeluaran') ?>

    <?= $form->field($model, 'no_surat') ?>

    <?= $form->field($model, 'tgl_penahanan') ?>

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
