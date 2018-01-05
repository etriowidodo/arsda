<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PidumPdmSpdpSearch */
/* @var $form yii\widgets\ActiveForm */
?>
    <div class="was9-search" style="margin-top:20px;">

       <?php $form = ActiveForm::begin([
                  'method' => 'get',
                  'id'=>'searchFormWas12', 
                  'options'=>['name'=>'searchFormWas12'],
                  // 'fieldConfig' => [
                  //             'options' => [
                  //                 'tag' => false,
                  //                 ],
                  //             ],
              ]); ?>
    <div class="col-md-5">
         <div class="form-group">
            <?php $model->cari=$_GET['Was12InspeksiSearch']['cari'];?>
            <?= $form->field($model, 'cari')->input('cari', ['placeholder' => "Masukan Karakter Yang Dicari"])->label(false) ?>
         </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Cari', ['class' => 'btn btn-primary']) ?>
        <?php
        ?>
        <?= Html::a('Refresh', ['/pengawasan/was12-inspeksi/'], ['class'=>'btn btn-default']) ?>
    </div> 

    <?php ActiveForm::end(); ?>

    </div>
