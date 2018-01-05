<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmNotaPendapat */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-nota-pendapat-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'no_register_perkara')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jenis_nota_pendapat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_nota_pendapat')->textInput() ?>

    <?= $form->field($model, 'kepada')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dari_nip_jaksa_p16a')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dari_nama_jaksa_p16a')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dari_jabatan_jaksa_p16a')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dari_pangkat_jaksa_p16a')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tgl_nota')->textInput() ?>

    <?= $form->field($model, 'perihal_nota')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dasar_nota')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'pendapat_nota')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'flag_saran')->textInput() ?>

    <?= $form->field($model, 'saran_nota')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'flag_pentunjuk')->textInput() ?>

    <?= $form->field($model, 'petunjuk_nota')->textarea(['rows' => 6]) ?>

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