<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\InspekturModelSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kejagung-bidang-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_kejagung_bidang') ?>

    <?= $form->field($model, 'nama_kejagung_bidang') ?>

    <?= $form->field($model, 'id_inspektur') ?>

    <?= $form->field($model, 'akronim') ?>


    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
