<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\VLaporanP6 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vlaporan-p4-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tgl_terima')->textInput() ?>

    <?= $form->field($model, 'wilayah_kerja')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nama_lengkap')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kasus_posisi')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'asal_perkara')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tgl_dihentikan')->textInput() ?>

    <?= $form->field($model, 'tgl_dikesampingkan')->textInput() ?>

    <?= $form->field($model, 'tgl_dikirim_ke')->textInput() ?>

    <?= $form->field($model, 'no_denda_ganti')->textInput() ?>

    <?= $form->field($model, 'tgl_denda_ganti')->textInput() ?>

    <?= $form->field($model, 'tgl_dilimpahkan')->textInput() ?>

    <?= $form->field($model, 'keterangan')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
