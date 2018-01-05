<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmPenyelesaianPratutLimpahTersangka */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-penyelesaian-pratut-limpah-tersangka-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_pratut_limpah_tersangka')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_ms_tersangka_berkas')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status_penahanan')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
