<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $model app\modules\pidsus\models\PdsDikTersangka */
/* @var $form yii\widgets\ActiveForm */

require('..\modules\pidsus\controllers\viewFormFunction.php');
$viewFormFunction=new viewFormFunction();
?>

<div class="pds-dik-tersangka-form">
<div class="box box-primary">
	<div class="box-header">
    <?php $form = ActiveForm::begin([
            'id' => 'surat-form',
            'type' => ActiveForm::TYPE_HORIZONTAL,
            'enableAjaxValidation' => false,
            'fieldConfig' => [
                'autoPlaceholder' => false
            ],
            'formConfig' => [
                'deviceSize' => ActiveForm::SIZE_SMALL,
                'showLabels' => false
            ]
        ]);
?>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2">Nama</label>
                        <div class="col-md-10">
                            <?php echo $form->field($model, 'nama_tersangka'); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2">Tempat & Tgl Lahir</label>
                        <div class="col-md-4">
                            <?php echo $form->field($model, 'tempat_lahir'); ?>
                        </div>
                        <div class="col-md-6">
                            <?php
                            echo $form->field($model, 'tgl_lahir')->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'options' => [
                                    'pluginOptions' => [
                                        'autoclose' => true, 'startDate' => $viewFormFunction->getPreviousSuratDate($model), 'endDate' => $_SESSION['todayDate']
                                    ]
                                ]
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">


                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Identitas & No</label>
                        <div class="col-md-8">
                            <?= $viewFormFunction->returnSelect2ParameterDetail($form,$model,'jenis_id','Jenis Identitas',36,'')?>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <div class="col-md-12">
                            <?php echo $form->field($model, 'nomor_id') ?>
                        </div>
                    </div>
                </div>


            </div>

            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Jenis Kelamin</label>
                        <div class="col-md-8">
                            <?= $viewFormFunction->returnSelect2ParameterDetail($form,$model,'jenis_kelamin','Jenis Kelamin',5,'')?>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Agama</label>
                        <div class="col-md-8">
                            <?= $viewFormFunction->returnSelect2ParameterDetail($form,$model,'agama','Agama',4,'')?>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2">Alamat</label>
                        <div class="col-md-10">
                            <?php echo $form->field($model, 'alamat')->textarea() ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
               

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Pendidikan</label>
                        <div class="col-md-8">
                           <?= $viewFormFunction->returnSelect2ParameterDetail($form,$model,'pendidikan','Pendidikan',6,'')?>
                        </div>
                    </div>
                </div>
				
				<div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Pekerjaan</label>
                        <div class="col-md-8">
                            <?php echo $form->field($model, 'pekerjaan') ?>
                        </div>
                    </div>
                </div>
                
            </div>

            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Kewarganegaraan</label>
                        <div class="col-md-8">
                            <?php echo $form->field($model, 'kewarganegaraan') ?>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Suku</label>
                        <div class="col-md-8">
                            <?php echo $form->field($model, 'suku') ?>
                        </div>
                    </div>
                </div>

				
			    
            </div>
            <div class="row">
            <div class="col-md-10"></div>
            <div class="col-md-1" style="align:right;">
			       <?= Html::submitButton( 'Simpan', ['class' => 'btn btn-primary', 'name'=>'btnSubmit', 'value'=>'simpan','id' => 'btnSimpan']) ?>
			</div>    
			<div class="col-md-1" style="align:right;">
			       <?=Html::a('Batal', ['index'], ['data-pjax'=>0, 'class' => 'btn btn-danger', 'title'=>'cancel','id' => 'btnCancel']) ?>
			</div>    
       		</div>
    <?php ActiveForm::end(); ?>
</div></div>
</div>
