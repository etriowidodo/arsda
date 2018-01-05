<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBA10Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-ba10-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_ba10') ?>

    <?= $form->field($model, 'id_berkas') ?>

    <?= $form->field($model, 'tgl_surat') ?>

    <?= $form->field($model, 'stat_penahanan') ?>

    <?= $form->field($model, 'stat_pidana') ?>

    <?php // echo $form->field($model, 'kepala_rutan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
