<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was21 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="was21-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'no_was_21')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_register')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'inst_satkerkd')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tgl_was_21')->textInput() ?>

    <?= $form->field($model, 'sifat_surat')->textInput() ?>

    <?= $form->field($model, 'jml_lampiran')->textInput() ?>

    <?= $form->field($model, 'satuan_lampiran')->textInput() ?>

    <?= $form->field($model, 'perihal')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kpd_was_21')->textInput() ?>

    <?= $form->field($model, 'ttd_was_21')->textInput() ?>

    <?= $form->field($model, 'id_terlapor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pendapat')->textInput() ?>

    <?= $form->field($model, 'id_peraturan')->textInput() ?>

    <?= $form->field($model, 'tingkat_kd')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kputusan_ja')->textInput() ?>

    <?= $form->field($model, 'ttd_peg_nik')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ttd_id_jabatan')->textInput() ?>

    <?= $form->field($model, 'upload_file')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'flag')->textInput(['maxlength' => true]) ?>

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
