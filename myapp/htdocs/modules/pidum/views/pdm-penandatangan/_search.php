<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmPenandatanganSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-penandatangan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'peg_nik') ?>

    <?= $form->field($model, 'nama') ?>

    <?= $form->field($model, 'pangkat') ?>

    <?= $form->field($model, 'jabatan') ?>

    <?= $form->field($model, 'keterangan') ?>
	
	<!--bowo 30 mei 2016 #menambahkan field peg_nip_baru-->	
	 <?= $form->field($model, 'peg_nip_baru') ?>
	  
    <?php // echo $form->field($model, 'is_active') ?>

    <?php // echo $form->field($model, 'flag') ?>

    <?php // echo $form->field($model, 'id_ttd') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
