<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmPenyelesaianPratutLimpahJaksa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-penyelesaian-pratut-limpah-jaksa-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_pratut_limpah_jaksa')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'peg_nip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pangkat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jabatan')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
