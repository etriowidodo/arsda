<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmPenyelesaianPratutLimpahJaksaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-penyelesaian-pratut-limpah-jaksa-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_pratut_limpah_jaksa') ?>

    <?= $form->field($model, 'peg_nip') ?>

    <?= $form->field($model, 'nama') ?>

    <?= $form->field($model, 'pangkat') ?>

    <?= $form->field($model, 'jabatan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
