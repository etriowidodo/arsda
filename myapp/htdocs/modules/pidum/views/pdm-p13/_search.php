<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP13Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-p13-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_p13') ?>

    <?= $form->field($model, 'id_ba5') ?>

    <?= $form->field($model, 'no_surat') ?>

    <?= $form->field($model, 'sifat') ?>

    <?= $form->field($model, 'lampiran') ?>

    <?php // echo $form->field($model, 'dikeluarkan') ?>

    <?php // echo $form->field($model, 'tgl_surat') ?>

    <?php // echo $form->field($model, 'kepada') ?>

    <?php // echo $form->field($model, 'ket_saksi') ?>

    <?php // echo $form->field($model, 'ket_ahli') ?>

    <?php // echo $form->field($model, 'ket_surat') ?>

    <?php // echo $form->field($model, 'petunjuk') ?>

    <?php // echo $form->field($model, 'ket_tersangka') ?>

    <?php // echo $form->field($model, 'hukum') ?>

    <?php // echo $form->field($model, 'yuridis') ?>

    <?php // echo $form->field($model, 'kesimpulan') ?>

    <?php // echo $form->field($model, 'saran') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
