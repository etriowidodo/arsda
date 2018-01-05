<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="irmud-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_irmud') ?>

    <?= $form->field($model, 'nama_irmud') ?>

    <?= $form->field($model, 'akronim') ?>


    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
