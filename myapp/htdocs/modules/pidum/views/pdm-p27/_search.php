<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP27Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-p27-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'no_register_perkara') ?>

    <?= $form->field($model, 'no_surat_p27') ?>

    <?= $form->field($model, 'tgl_ba') ?>

    <?= $form->field($model, 'no_putusan') ?>

    <?= $form->field($model, 'tgl_putusan') ?>

    <?php // echo $form->field($model, 'id_tersangka') ?>

    <?php // echo $form->field($model, 'keterangan_tersangka') ?>

    <?php // echo $form->field($model, 'keterangan_saksi') ?>

    <?php // echo $form->field($model, 'dari_benda') ?>

    <?php // echo $form->field($model, 'dari_petunjuk') ?>

    <?php // echo $form->field($model, 'alasan') ?>

    <?php // echo $form->field($model, 'dikeluarkan') ?>

    <?php // echo $form->field($model, 'tgl_surat') ?>

    <?php // echo $form->field($model, 'id_penandatangan') ?>

    <?php // echo $form->field($model, 'id_kejati') ?>

    <?php // echo $form->field($model, 'id_kejari') ?>

    <?php // echo $form->field($model, 'id_cabjari') ?>

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