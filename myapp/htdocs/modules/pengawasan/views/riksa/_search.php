<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Was1Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lapdu-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="col-md-12">
        <div class="form-group">
         <label class="control-label col-md-1" style="margin-top: 5px;">Cari</label>
            <div class="col-md-5">
            <?php $model->cari=$_GET['Was1Search']['cari'];?>
            <?php echo $form->field($model, 'cari', [
                                'addon' => [
                                    'append' => [
                                        'content' => Html::submitButton('<i class="fa fa-search">  </i> Cari', ['class' => 'btn btn-default btn-cari']),
                                        'asButton' => true
                                    ],
                                    
                                ],

                            ])->label(false);
            ?>
            </div>
        </div>
    </div>

    <?//= $form->field($model, 'tanggal_surat_diterima') ?>

    <?//= $form->field($model, 'cari2') ?>

    <?//= $form->field($model, 'perihal_lapdu') ?>

    <?//= $form->field($model, 'tanggal_surat_lapdu') ?>

    <?php // echo $form->field($model, 'ringkasan_lapdu') ?>

    <?php // echo $form->field($model, 'file_lapdu') ?>

    <?php // echo $form->field($model, 'id_media_pelaporan') ?>

    <?php // echo $form->field($model, 'inst_satkerkd') ?>

    <div class="form-group">
        <?//= Html::submitButton('Cari', ['class' => 'btn btn-primary']) ?>
        <?php
        //echo "<a class='btn btn-primary btn-sm'><i class='glyphicon glyphicon-search'> Cari </i></a>";
        ?>
        <?//= Html::a('Refresh', ['/pengawasan/was1/'], ['class'=>'btn btn-default']) ?>
    </div> 

    <?php ActiveForm::end(); ?>

</div>
