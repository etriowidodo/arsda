<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP25Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-p25-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_p25') ?>

    <?= $form->field($model, 'id_berkas') ?>

    <?= $form->field($model, 'no_surat') ?>

    <?= $form->field($model, 'dikeluarkan') ?>

    <?= $form->field($model, 'tgl_surat') ?>

    <?php // echo $form->field($model, 'id_penandatangan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
