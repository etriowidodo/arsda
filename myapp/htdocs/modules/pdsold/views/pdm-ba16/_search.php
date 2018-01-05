<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBa16Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-ba16-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_ba16') ?>

    <?= $form->field($model, 'id_perkara') ?>

    <?= $form->field($model, 'tgl_surat') ?>

    <?= $form->field($model, 'id_tersangka') ?>

    <?= $form->field($model, 'nama1') ?>

    <?php // echo $form->field($model, 'umur1') ?>

    <?php // echo $form->field($model, 'pekerjaan1') ?>

    <?php // echo $form->field($model, 'nama2') ?>

    <?php // echo $form->field($model, 'umur2') ?>

    <?php // echo $form->field($model, 'pekerjaan2') ?>

    <?php // echo $form->field($model, 'penggeledahan') ?>

    <?php // echo $form->field($model, 'nama_geledah') ?>

    <?php // echo $form->field($model, 'alamat_geledah') ?>

    <?php // echo $form->field($model, 'pekerjaan_geledah') ?>

    <?php // echo $form->field($model, 'penyitaan') ?>

    <?php // echo $form->field($model, 'nama_sita') ?>

    <?php // echo $form->field($model, 'alamat_sita') ?>

    <?php // echo $form->field($model, 'pekerjaan_sita') ?>

    <?php // echo $form->field($model, 'flag') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'created_ip') ?>

    <?php // echo $form->field($model, 'created_time') ?>

    <?php // echo $form->field($model, 'updated_ip') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'updated_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
