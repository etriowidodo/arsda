<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use app\components\GlobalConstMenuComponent;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmPenandatangan */
/* @var $form yii\widgets\ActiveForm */
?>


<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">
        <?php
        $form = ActiveForm ::begin(
                        [
                            'id' => 'pdm-penandatangan-form',
                            'type' => ActiveForm::TYPE_HORIZONTAL,
                            'enableAjaxValidation' => false,
                            'fieldConfig' => [
                                'autoPlaceholder' => false
                            ],
                            'formConfig' => [
                                'deviceSize' => ActiveForm::SIZE_SMALL,
                                'labelSpan' => 1,
                                'showLabels' => false
                            ]
        ]);
        ?>

        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
           <div class="form-group">
                        <label class="control-label col-md-2">Nama</label>
                        <div class="col-md-4" style="width:10">
                            <?php
                            echo $form->field($model, 'nama', [
                                'addon' => [
                                    'append' => [
                                        'content' => Html::a('Pilih', '', ['class' => 'btn btn-warning', 'data-toggle' => 'modal', 'data-target' => '#_m_jpu2']),
                                        'asButton' => true
                                    ]
                                ]
                            ]);
                            ?>
                        </div>
                    </div>
             <div class="form-group hide">
                        <label class="control-label col-md-2">Nip</label>
                        <div class="col-md-4"  style="width:10" >
                       <?= $form->field($model, 'peg_nik') ?>
                    </div>
                    </div>
					
					<!--bowo 30 mei 2016 #menambahkan field peg_nip_baru-->
					<div class="form-group">
                        <label class="control-label col-md-2">NIP</label>
                        <div class="col-md-4"  style="width:10" >
                       <?= $form->field($model, 'peg_nip_baru') ?>
                    </div>
                    </div>
            
            <div class="form-group">
                        <label class="control-label col-md-2">Pangkat</label>
                        <div class="col-md-4"  style="width:10" >
                        <?= $form->field($model, 'pangkat') ?>
                       
                    </div>
                    </div>  
              <div class="form-group">
                        <label class="control-label col-md-2">Jabatan</label>
                        <div class="col-md-4"  style="width:10">
                        <?= $form->field($model, 'jabatan')->textArea([
    'id' => 'Jabatan', 
    'rows' => 4
]) ?>
                    </div>
                    </div>
            <!-- <div class="form-group ">
            <label class="control-label col-md-2">Active</label>
            <div class="col-md-4"  style="width:10">
             <?= $form->field($model,'is_active')->checkbox();?> 	
            </div>
            
        </div>-->
    
 <div class="box-footer">
            <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
    <?php ActiveForm::end(); ?>

</div>
</section>

<?php
Modal::begin([
    'id' => '_m_jpu2',
    'header' => 'Data Penyidik',
    'options' => [
        'data-url' => '',
    ],
]);
?> 

<?=
$this->render('_m_jpu2', [
    'model' => $model,
    'searchJPU' => $searchJPU,
    'dataJPU' => $dataJPU,
])
?>

<?php
Modal::end();
?>  
