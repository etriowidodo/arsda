<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $model app\models\PdsLidRenlid */
/* @var $form yii\widgets\ActiveForm */
$readOnly=false;
?>

<div class="pds-lid-renlid-form">

    <?php $form = ActiveForm::begin(
	 [
                'id' => 'surat-form',
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'enableAjaxValidation' => false,
                'fieldConfig' => [
                    'autoPlaceholder'=>false
                ],
                'formConfig' => [
                    'deviceSize' => ActiveForm::SIZE_SMALL,
                    'labelSpan' => 1,
                    'showLabels'=>false

                ]
            ]); ?>
 	
 	<div>
							        <div><div class="box-body">
							                <div>
							                    <div>
							                    	<div class="form-group">
					                                    <label for="no_urut" class="control-label col-md-3">No Urut</label>
					                                    <div class="col-md-6"><?= $form->field($model, 'no_urut')->textInput(['readonly' => $readOnly,'maxlength'=>2,'style'=>'width:50px']) ?></div>
					                                </div> 
							                    	<div class="form-group">
					                                    <label for="kasus_posisi" class="control-label col-md-3">Kasus Posisi</label>
					                                    <div class="col-md-6"><?= $form->field($model, 'kasus_posisi')->textarea(['readonly' => $readOnly]) ?></div>
					                                </div> 
							                    	<div class="form-group">
					                                    <label for="pasal_disangkakan" class="control-label col-md-3">Pasal Disangkakan</label>
					                                    <div class="col-md-6"><?= $form->field($model, 'pasal_disangkakan')->textarea(['readonly' => $readOnly]) ?></div>
					                                </div> 
							                    	<div class="form-group">
					                                    <label for="alat_bukti" class="control-label col-md-3">Alat Bukti</label>
					                                    <div class="col-md-6"><?= $form->field($model, 'alat_bukti')->textarea(['readonly' => $readOnly]) ?></div>
					                                </div> 
							                    	<div class="form-group">
					                                    <label for="tindakan_hukum" class="control-label col-md-3">Tindakan Hukum</label>
					                                    <div class="col-md-6"><?= $form->field($model, 'tindakan_hukum')->textarea(['readonly' => $readOnly]) ?></div>
					                                </div> 
							                    	<div class="form-group">
					                                    <label for="waktu_tempat" class="control-label col-md-3">Waktu dan Tempat</label>
					                                    <div class="col-md-6"><?= $form->field($model, 'waktu_tempat')->textarea(['readonly' => $readOnly]) ?></div>
					                                </div> 
							                    	<div class="form-group">
					                                    <label for="koor_dan_dal" class="control-label col-md-3">Koor dan Dal</label>
					                                    <div class="col-md-6"><?= $form->field($model, 'koor_dan_dal')->textarea(['readonly' => $readOnly]) ?></div>
					                                </div> 
					                                
							                    	<div class="form-group">
					                                    <label for="keterangan" class="control-label col-md-3">Keterangan</label>
					                                    <div class="col-md-6"><?= $form->field($model, 'keterangan')->textarea(['readonly' => $readOnly]) ?></div>
					                                </div> 
   												</div>
   											</div>
   											</div>
   											</div>
     

    <div class="form-group">
	<div class="col-md-5">
								        	
								          </div>
	<div class="col-md-1"></div><div class="col-md-1"></div>
	<div class="col-md-1">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Simpan', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','id' => 'btnSimpan']) ?>
    </div>
	<div class="col-md-1">	        		
		<?=Html::a('Batal', ['../pidsus/p8a/index'], ['data-pjax'=>0, 'class' => 'btn btn-danger', 'title'=>'cancel','id' => 'btnCancel']) ?>
						    			 </div>		
</div>
    <?php ActiveForm::end(); ?>

</div>
