<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP47Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-p47-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_p47') ?>

    <?= $form->field($model, 'id_perkara') ?>

    <?= $form->field($model, 'kepada') ?>

    <?= $form->field($model, 'di_kepada') ?>

    <?= $form->field($model, 'dikeluarkan') ?>

    <?php // echo $form->field($model, 'tgl_dikeluarkan') ?>

    <?php // echo $form->field($model, 'id_tersangka') ?>

    <?php // echo $form->field($model, 'dakwaan') ?>

    <?php // echo $form->field($model, 'pengadilan_negeri') ?>

    <?php // echo $form->field($model, 'lokasi') ?>

    <?php // echo $form->field($model, 'alasan') ?>

    <?php // echo $form->field($model, 'penetapan_hakim') ?>

    <?php // echo $form->field($model, 'hukpid') ?>

    <?php // echo $form->field($model, 'denda') ?>

    <?php // echo $form->field($model, 'biaya_perkara') ?>

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
