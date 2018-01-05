<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\MsPedomanSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ms-pedoman-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'uu') ?>

    <?= $form->field($model, 'pasal') ?>

    <?= $form->field($model, 'kategori') ?>

    <?= $form->field($model, 'ancaman_hari') ?>

    <?= $form->field($model, 'ancaman_bulan') ?>

    <?php // echo $form->field($model, 'ancaman_tahun') ?>

    <?php // echo $form->field($model, 'denda') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
