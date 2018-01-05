<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBA12Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-ba12-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_ba12') ?>

    <?= $form->field($model, 'id_t8') ?>

    <?= $form->field($model, 'tgl_penahanan') ?>

    <?= $form->field($model, 'no_surat') ?>

    <?= $form->field($model, 'tgl_surat') ?>

    <?php // echo $form->field($model, 'id_penandatangan') ?>

    <?php // echo $form->field($model, 'kepala_rutan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
