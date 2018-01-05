<?php

use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;

require('..\modules\pidsus\controllers\viewFormFunction.php');
$viewFormFunction=new viewFormFunction();
$idSatker=$_SESSION['idSatkerUser'];
/* @var $this yii\web\View */
/* @var $model app\models\PdsLid */

$this->title = 'Approval Laporan/Pengaduan: ' . ' ' . $model->no_lap;
//$this->params['breadcrumbs'][] = ['label' => 'Pidsus', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->no_lap, 'url' => ['view', 'id' => $model->no_lap]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pds-lid-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="pds-lid-form">

   <div>
    <div class="box box-primary">
	<div class="box-header">
            <center></center>
        </div>
    <?php $form = ActiveForm::begin(
	 [
                'id' => 'p2-form',
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
							    <div>
							        <div><div class="box-body">
							                <div>
							                    <div class="col-md-6">
							                    	<div class="form-group">
					                                    <label for="lokasi_surat" class="control-label col-md-4">Asal Surat </label>
					                                   <label for="perihal" class="control-label col-md-6" style="font-weight: normal;text-align: left;"><?=$model->lokasi_lap?></label>
					                                </div>  
					                                <div class="form-group">
					                                    <label for="no_surat" class="control-label col-md-4">Nomor Surat </label>
					                                    <label for="perihal" class="control-label col-md-6" style="font-weight: normal;text-align: left;"><?=$model->no_lap?></label>
					                               </div>  
													<div class="form-group">
														<label for="tgl_surat" class="control-label col-md-4">Tanggal</label>
														<label for="perihal" class="control-label col-md-6" style="font-weight: normal;text-align: left;"><?=$model->tgl_lap?></label>
					                               </div>
					                                <div class="form-group">
					                                    <label for="perihal" class="control-label col-md-4">Nomor P1</label>
					                                   <label for="perihal" class="control-label col-md-6" style="font-weight: normal;text-align: left;"><?=$model->no_surat_lap?></label>
					                               </div>               		
												</div>
												
							                    <div class="col-md-6">
													
					                                <div class="form-group">
					                                    <label for="perihal" class="control-label col-md-4">Perihal</label>
					                                    <label for="perihal" class="control-label col-md-6" style="font-weight: normal;text-align: left;"><?=$model->perihal_lap?></label>
					                              </div>  
													<div class="form-group">
														<label for="tgl_surat" class="control-label col-md-4">Tanggal Terima</label>
														<label for="perihal" class="control-label col-md-6" style="font-weight: normal;text-align: left;"><?=$model->tgl_diterima?></label>
					                              
													</div>
													
												<div class="form-group">
														<label for="satker" class="control-label col-md-4">Penerima </label>
														<div class="col-md-6"><?= $viewFormFunction->returnDropDownList($form,$model,"select * from pidsus.get_penerima_laporan ('".$idSatker."') order by nama_penerima_lap",'id_penerima_lap','nama_penerima_lap','penerima_lap',true) ?></div>
												</div>  
												<div class="form-group">
														<label for="satker" class="control-label col-md-4">Penandatangan </label>
														<div class="col-md-6"><?= $viewFormFunction->returnDropDownList($form,$model,"select * from pidsus.get_penandatangan	('".$idSatker."','".$typeSurat."') order by id_penandatangan",'id_penandatangan','nama_penandatangan','penandatangan_lap',true) ?></div>
												</div>  
												</div>
							                </div>
											
							            </div>
							        </div>
							    </div>    
							</div>
		<div">
				   <div>
					<div class="form-group">
					  <label for="isi" class="control-label col-md-2">Isi</label>
					  <div class="col-md-8"><?= $form->field($model, 'isi_surat_lap')->textArea(array('maxlength' => 4000, 'rows' => 6, 'cols' => 50,'readonly' => true)) ?></div>
					</div>  
					<div class="form-group">
					  <label for="uraian" class="control-label col-md-2">Uraian Kasus </label>
					  <div class="col-md-8"><?= $form->field($model, 'uraian_surat_lap')->textArea(array('maxlength' => 4000, 'rows' => 6, 'cols' => 50,'readonly' => true)) ?></div>
					</div> 
				 </div>
				</div>
        <div class="box-footer">
        	<div class="col-md-8">
        		
	        	<div class="col-md-4">
		        	<?= $viewFormFunction->returnDropDownListStatus($form,$model,'2')?>
		         </div>
		         
	        	<div class="col-md-4">
	        		
		          	<?= Html::submitButton( 'Simpan', ['class' => 'btn btn-primary', 'name'=>'btnSubmit', 'value'=>'simpan','id' => 'btnSimpan']) ?>
		        </div>
	        </div>
        </div>
		
    <?php //ActiveForm::end(); ?>
</div>
</div>

</div>
    

</div>
