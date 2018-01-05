<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmPengantarTahap1Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-pengantar-tahap1-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_pengantar') ?>

    <?= $form->field($model, 'id_berkas') ?>

    <?= $form->field($model, 'no_pengantar') ?>

    <?= $form->field($model, 'tgl_pengantar') ?>

    <?= $form->field($model, 'tgl_terima') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
