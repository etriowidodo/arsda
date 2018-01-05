<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP26Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-p26-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_p26') ?>

    <?= $form->field($model, 'id_perkara') ?>

    <?= $form->field($model, 'id_p13') ?>

    <?= $form->field($model, 'no_surat') ?>

    <?= $form->field($model, 'tgl_ba') ?>

    <?php // echo $form->field($model, 'tgl_persetujuan') ?>

    <?php // echo $form->field($model, 'id_tersangka') ?>

    <?php // echo $form->field($model, 'kasus_posisi') ?>

    <?php // echo $form->field($model, 'pasal_disangka') ?>

    <?php // echo $form->field($model, 'barbuk') ?>

    <?php // echo $form->field($model, 'alasan') ?>

    <?php // echo $form->field($model, 'dikeluarkan') ?>

    <?php // echo $form->field($model, 'tgl_dikeluarkan') ?>

    <?php // echo $form->field($model, 'id_penandatangan') ?>

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
