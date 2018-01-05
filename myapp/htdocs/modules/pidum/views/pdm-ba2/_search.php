<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBa2Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-ba2-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_ba2') ?>

    <?= $form->field($model, 'tgl_pembuatan') ?>

    <?= $form->field($model, 'jam') ?>

    <? /* = $form->field($model, 'id_penandatangan') */ ?> 

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
