<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PdmBa4TersangkaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-ba4-tersangka-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'no_register_perkara') ?>

    <?= $form->field($model, 'tgl_ba4') ?>

    <?= $form->field($model, 'id_peneliti') ?>

    <?= $form->field($model, 'no_reg_tahanan') ?>

    <?= $form->field($model, 'no_reg_perkara') ?>

    <?php // echo $form->field($model, 'alasan') ?>

    <?php // echo $form->field($model, 'id_penandatangan') ?>

    <?php // echo $form->field($model, 'upload_file') ?>

    <?php // echo $form->field($model, 'no_urut_tersangka') ?>

    <?php // echo $form->field($model, 'tmpt_lahir') ?>

    <?php // echo $form->field($model, 'tgl_lahir') ?>

    <?php // echo $form->field($model, 'alamat') ?>

    <?php // echo $form->field($model, 'no_identitas') ?>

    <?php // echo $form->field($model, 'no_hp') ?>

    <?php // echo $form->field($model, 'warganegara') ?>

    <?php // echo $form->field($model, 'pekerjaan') ?>

    <?php // echo $form->field($model, 'suku') ?>

    <?php // echo $form->field($model, 'nama') ?>

    <?php // echo $form->field($model, 'id_jkl') ?>

    <?php // echo $form->field($model, 'id_identitas') ?>

    <?php // echo $form->field($model, 'id_agama') ?>

    <?php // echo $form->field($model, 'id_pendidikan') ?>

    <?php // echo $form->field($model, 'umur') ?>

    <?php // echo $form->field($model, 'id_kejati') ?>

    <?php // echo $form->field($model, 'id_kejari') ?>

    <?php // echo $form->field($model, 'id_cabjari') ?>

    <?php // echo $form->field($model, 'created_ip') ?>

    <?php // echo $form->field($model, 'created_time') ?>

    <?php // echo $form->field($model, 'updated_ip') ?>

    <?php // echo $form->field($model, 'nama_ttd') ?>

    <?php // echo $form->field($model, 'pangkat_ttd') ?>

    <?php // echo $form->field($model, 'jabatan_ttd') ?>

    <?php // echo $form->field($model, 'updated_time') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'foto') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
