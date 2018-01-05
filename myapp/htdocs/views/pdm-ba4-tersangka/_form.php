<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PdmBa4Tersangka */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-ba4-tersangka-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'no_register_perkara')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tgl_ba4')->textInput() ?>

    <?= $form->field($model, 'id_peneliti')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'no_reg_tahanan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'no_reg_perkara')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alasan')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'id_penandatangan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'upload_file')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'no_urut_tersangka')->textInput() ?>

    <?= $form->field($model, 'tmpt_lahir')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tgl_lahir')->textInput() ?>

    <?= $form->field($model, 'alamat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'no_identitas')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'no_hp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'warganegara')->textInput() ?>

    <?= $form->field($model, 'pekerjaan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'suku')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_jkl')->textInput() ?>

    <?= $form->field($model, 'id_identitas')->textInput() ?>

    <?= $form->field($model, 'id_agama')->textInput() ?>

    <?= $form->field($model, 'id_pendidikan')->textInput() ?>

    <?= $form->field($model, 'umur')->textInput() ?>

    <?= $form->field($model, 'id_kejati')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_kejari')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_cabjari')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_ip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_time')->textInput() ?>

    <?= $form->field($model, 'updated_ip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated_time')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated_by')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
