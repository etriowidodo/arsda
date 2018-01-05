<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP27 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-p27-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'no_register_perkara')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'no_surat_p27')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tgl_ba')->textInput() ?>

    <?= $form->field($model, 'no_putusan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tgl_putusan')->textInput() ?>

    <?= $form->field($model, 'id_tersangka')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keterangan_tersangka')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keterangan_saksi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dari_benda')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dari_petunjuk')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alasan')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'dikeluarkan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tgl_surat')->textInput() ?>

    <?= $form->field($model, 'id_penandatangan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_kejati')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_kejari')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_cabjari')->textInput(['maxlength' => true]) ?>

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