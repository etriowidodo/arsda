<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP42Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-p42-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_p42') ?>

    <?= $form->field($model, 'no_perkara') ?>

    <?= $form->field($model, 'ket_saksi') ?>

    <?= $form->field($model, 'ket_ahli') ?>

    <?= $form->field($model, 'ket_surat') ?>

    <?php // echo $form->field($model, 'petunjuk') ?>

    <?php // echo $form->field($model, 'ket_tersangka') ?>

    <?php // echo $form->field($model, 'barbuk') ?>

    <?php // echo $form->field($model, 'unsur_dakwaan') ?>

    <?php // echo $form->field($model, 'memberatkan') ?>

    <?php // echo $form->field($model, 'meringankan') ?>

    <?php // echo $form->field($model, 'tgl_dikeluarkan') ?>

    <?php // echo $form->field($model, 'id_penandatangan') ?>

    <?php // echo $form->field($model, 'id_perkara') ?>

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
