<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBA3Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-ba3-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_ba3') ?>

    <?= $form->field($model, 'id_perkara') ?>

    <?= $form->field($model, 'tgl_pembuatan') ?>

    <?= $form->field($model, 'jam') ?>

    <?= $form->field($model, 'id_ms_saksi_ahli') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
