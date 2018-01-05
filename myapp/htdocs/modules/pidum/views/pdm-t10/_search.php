<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmT10Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-t10-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_t10') ?>

    <?= $form->field($model, 'id_t8') ?>

    <?= $form->field($model, 'no_surat') ?>

    <?= $form->field($model, 'keperluan') ?>

    <?= $form->field($model, 'jam') ?>

    <?php // echo $form->field($model, 'tgl_kunjungan') ?>

    <?php // echo $form->field($model, 'dikeluarkan') ?>

    <?php // echo $form->field($model, 'id_penandatangan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
