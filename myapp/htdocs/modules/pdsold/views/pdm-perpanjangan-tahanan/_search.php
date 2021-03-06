<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmPerpanjanganTahananSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-perpanjangan-tahanan-search">

     <?php
        $form = ActiveForm::begin([
                    'action' => ['index'],
                    'method' => 'get',
        ]);
        ?>
        <div class="col-md-12">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="form-group">
                    <div class="col-md-10">
                        <?=
                        $form->field($model, 'id_perpanjangan', [
                            'addon' => [
                                'append' => [
                                    'content' => Html::submitButton('Cari', ['class' => 'btn btn-warning']),
                                    'asButton' => true
                                ]
                            ]
                        ])->label(false)
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>


        <?php // echo $form->field($model, 'tgl_terima') ?>

        <?php // echo $form->field($model, 'ket_kasus') ?>

        <?php // echo $form->field($model, 'id_status')   ?>

        <div class="form-group">

        </div>
        <?php ActiveForm::end(); ?>

</div>
