<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PidumPdmSpdpSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<div style="border-color: #f39c12;padding: 15px;overflow: hidden;" class="box box-primary">



    <div class="pidum-pdm-spdp-search">

        <?php
        $form = ActiveForm::begin([
                    'action' => ['index'],
                    'method' => 'get',
        ]);
        ?>
        <div class="col-md-12">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <?=
                $form->field($model, 'id_perkara', [
                    'addon' => [
                        'append' => [
                            'content' => Html::submitButton('Cari', ['class' => 'btn btn-warning']),
                            'asButton' => true
                        ]
                    ]
                ])->label(false)
                ?>
            </div>
            <div class="col-md-2"></div>
        </div>


        <?php // echo $form->field($model, 'tgl_terima') ?>

        <?php // echo $form->field($model, 'ket_kasus') ?>

        <?php // echo $form->field($model, 'id_status')   ?>

        <div class="form-group">

        </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>

<hr style="border-color: #c7c7c7;margin: 10px 0;">