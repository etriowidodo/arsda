<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmPenetapanBarbukSurat */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-penetapan-barbuk-surat-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_penetapan_barbuk_surat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_penetapan_barbuk')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nama_surat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'no_surat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tgl_surat')->textInput() ?>

    <?= $form->field($model, 'tgl_diterima')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
