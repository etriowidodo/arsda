<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP24Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-p24-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_p24') ?>

    <?= $form->field($model, 'id_berkas') ?>

    <?= $form->field($model, 'tgl_surat') ?>

    <?= $form->field($model, 'ket_saksi') ?>

    <?= $form->field($model, 'ket_ahli') ?>

    <?php // echo $form->field($model, 'alat_bukti') ?>

    <?php // echo $form->field($model, 'benda_sitaan') ?>

    <?php // echo $form->field($model, 'ket_tersangka') ?>

    <?php // echo $form->field($model, 'fakta_hukum') ?>

    <?php // echo $form->field($model, 'yuridis') ?>

    <?php // echo $form->field($model, 'kesimpulan') ?>

    <?php // echo $form->field($model, 'pendapat') ?>

    <?php // echo $form->field($model, 'saran') ?>

    <?php // echo $form->field($model, 'petunjuk') ?>

    <?php // echo $form->field($model, 'status_berkas')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
