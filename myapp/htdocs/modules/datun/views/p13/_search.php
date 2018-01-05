<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PidumPdmSpdpSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pidum-pdm-spdp-search">

    <?php
    $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
    ]);
    ?>
    <div class="col-md-12" style="padding: 0px;">
    <div class="col-md-6" style="padding: 0px;">
        <?= $form->field($model, 'no_surat')->label('Pencarian') ?>
    </div>
    <div class="col-md-6"></div>
    </div>


    <div class="col-md-6"></div>

    <?php // echo $form->field($model, 'tgl_terima') ?>

    <?php // echo $form->field($model, 'ket_kasus') ?>

        <?php // echo $form->field($model, 'id_status')  ?>

    <div class="form-group">
    <?= Html::submitButton('Cari', ['class' => 'btn btn-primary']) ?>
    </div>
    <hr style="border-color: #b8b8b8;">
<?php ActiveForm::end(); ?>

</div>
