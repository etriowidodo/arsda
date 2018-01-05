<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmPenyelesaianPratutLimpah */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-penyelesaian-pratut-limpah-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_pratut_limpah')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_pratut')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'no_surat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sifat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lampiran')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tgl_dikeluarkan')->textInput() ?>

    <?= $form->field($model, 'dikeluarkan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kepada')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'di_kepada')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'perihal')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_penandatangan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pangkat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jabatan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'created_ip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_time')->textInput() ?>

    <?= $form->field($model, 'updated_ip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <?= $form->field($model, 'updated_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
