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
/* @var $form yii\widgets\ActiveForm */
$sqlLokasi="Select distinct inst_lokinst from kepegawaian.kp_inst_satker";
$sqlPenerimaSurat="select * from pidsus.get_penerima_laporan ('".$idSatker."') order by nama_penerima_lap";
$sqlPenandatangan="select * from pidsus.get_penandatangan	('".$idSatker."','".$typeSurat."') order by id_penandatangan";
$sqlJenisKasus="select id_detail, nama_detail from pidsus.parameter_detail where id_header=9";
$sqlStatusSelesai = "select id_detail, nama_detail from pidsus.parameter_detail where id_header=46";
//$sqlStatus = 'select pidsus.get_last_surat_lid(l.id_pds_lid)';
if($typeSurat=='p1'){
	$readOnly=true;
}
else $readOnly=false;
?>

<div class="pds-lid-form">

   
    <div class="box box-primary">
	<div class="box-header">

    <?php $form = ActiveForm::begin(
	 [
                'id' => 'surat-form',
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'enableAjaxValidation' => false,
                'fieldConfig' => [
                    'autoPlaceholder'=>false
                ],
                'formConfig' => [
                    'deviceSize' => ActiveForm::SIZE_LARGE,
                    'labelSpan' => 1,
                    'showLabels'=>false

                ]
            ]); ?>
	
		<div>
		
													
													<?php if ($typeSurat=='pidsus1'){?>
							                    		<?php //$viewFormFunction->returnSelect2($sqlLokasi,$form,$model,'asal_surat_lap','Asal Surat','inst_lokinst','inst_lokinst','Pilih Lokasi ...','asal_surat','full')?>
													<div class="form-group">
															<label for="pelapor" class="control-label col-md-3">Asal Surat</label>
															<div class="col-md-6"><?= $form->field($model, 'pelapor')->textInput(['readonly' => $readOnly]) ?></div>
													</div>
														<div class="form-group">
					                                    <label for="asal_surat" class="control-label col-md-3">Lokasi Surat</label>
					                                    <div class="col-md-6"><?= $form->field($model, 'asal_surat_lap')->textInput(['readonly' => $readOnly]) ?></div>
					                                </div>
					                                <div class="form-group">
					                                    <label for="no_surat_lap" class="control-label col-md-3">Nomor Surat</label>
					                                    <div class="col-md-6"><?= $form->field($model, 'no_surat_lap')->textInput(['readonly' => $readOnly]) ?></div>
					                                </div>

														<div class="form-group">
															<label for="tgl_surat" class="control-label col-md-3">Tanggal Surat</label>
															<div class="col-md-6"><?=
																$form->field($model, 'tgl_lap')->widget(DateControl::classname(), [
																	'type'=>DateControl::FORMAT_DATE,
																	'ajaxConversion'=>false,
																	'options' => [
																		'pluginOptions' => [
																			'autoclose' => true,
																			'mask' => 'Pilih Tanggal...',
																			'startDate' => $_SESSION['globalStartDate'],
																			'endDate' => $_SESSION['todayDate'],
																			'daysOfWeekDisabled' => [0, 6],
																		]
																	],
																	'readonly'=>$readOnly
																])?>
															</div>
														</div>
					                                <div class="form-group">
														<label for="tgl_surat" class="control-label col-md-3">Tanggal Diterima</label>
														<div class="col-md-6"><?=
					                                             $form->field($model, 'tgl_diterima')->widget(DateControl::classname(), [
					                                                'type'=>DateControl::FORMAT_DATE,
					                                                'ajaxConversion'=>false,
					                                                'options' => [
					                                                    'pluginOptions' => [
					                                                        'autoclose' => true,
        																	'mask' => 'Pilih Tanggal...',
																			'startDate' => $_SESSION['globalStartDate'],
																			'endDate' => $_SESSION['todayDate'],
					                                                    	'daysOfWeekDisabled' => [0, 6],
					                                                    ]
					                                                ],
					                                             	'readonly'=>$readOnly
					                                            ])?>
					                                    </div>
													</div>
													
													<div class="form-group">
					                                    <label for="perihal" class="control-label col-md-3">Perihal</label>
					                                    <div class="col-md-6"><?= $form->field($model, 'perihal_lap')->textInput(['readonly' => $readOnly]) ?></div>
					                                </div>

														<div class="form-group">
															<label for="isi" class="control-label col-md-3">Isi</label>
															<div class="col-md-6"><?= $form->field($model, 'isi_surat_lap')->textArea(array('maxlength' => 4000, 'rows' => 6, 'cols' => 50,'readonly' => $readOnly)) ?></div>
														</div>
													<div class="form-group">
													  <label for="uraian" class="control-label col-md-3">Uraian Kasus </label>
													  <div class="col-md-6"><?= $form->field($model, 'uraian_surat_lap')->textArea(array('maxlength' => 4000, 'rows' => 6, 'cols' => 50,'readonly' => $readOnly)) ?></div>
													</div>


													<?= $viewFormFunction->returnSelect2($sqlPenerimaSurat,$form,$model,'penerima_lap','Pembuat Catatan','id_penerima_lap','nama_penerima_lap','Pilih Pembuat Catatan ...','penerima_lap','full')?>
												   <?= $viewFormFunction->returnSelect2($sqlPenandatangan,$form,$model,'penandatangan_lap','Penandatangan','id_penandatangan','nama_penandatangan','Pilih Penandatangan ...','penandatangan','full')?>
							                    	<?php } else if($typeSurat=='p1'){?>
							                    		
							                    	<div class="form-group">
					                                    <label for="no_surat_p1" class="control-label col-md-3">Nomor  P-1</label>
					                                    <div class="col-md-6"><?= $form->field($model, 'no_lap')->textInput(['readonly' => false]) ?></div>
					                                </div>  
					                                <div class="form-group">
														<label for="tgl_surat" class="control-label col-md-3">Tanggal Diterima</label>
														<div class="col-md-6"><?=
					                                             $form->field($model, 'tgl_diterima')->widget(DateControl::classname(), [
					                                                'type'=>DateControl::FORMAT_DATE,
					                                                'ajaxConversion'=>false,
					                                                'options' => [
					                                                    'pluginOptions' => [
					                                                        'autoclose' => true,
        																	'mask' => 'Pilih Tanggal...',
					                                                    ]
					                                                ],
					                                             	'readonly'=>$readOnly
					                                            ])?>
					                                    </div>
													</div><?= $viewFormFunction->returnSelectDisable($sqlPenerimaSurat,$form,$model,'penerima_lap','Penerima Laporan','id_penerima_lap','nama_penerima_lap','Pilih Penerima ...','penerima_lap','full')?>
												<?= $viewFormFunction->returnSelectDisable($sqlLokasi,$form,$model,'lokasi_lap','Lokasi Penerima Laporan','inst_lokinst','inst_lokinst','Pilih Lokasi ...','lokasi_penerima','full')?>	
												<div class="form-group">
														<label for="pelapor" class="control-label col-md-3">Pelapor</label>
														<div class="col-md-6"><?= $form->field($model, 'asal_surat_lap')->textInput(['readonly' => true]) ?></div>
												</div>
												 
													 <div class="form-group">
														  <label for="isi" class="control-label col-md-3">Isi</label>
														  <div class="col-md-6"><?= $form->field($model, 'isi_surat_lap')->textArea(array('maxlength' => 4000, 'rows' => 6, 'cols' => 50,'readonly' => $readOnly)) ?></div>
													</div>
														<div class="form-group">
															<label for="isi" class="control-label col-md-3">Minta dilindungi Identitasnya</label>
															<div class="col-md-6"><?= $form->field($model, 'flag_dirahasiakan')->checkbox(array('label'=>'')); ?></div>
														</div>
							                    	<?php }?> 
													
					                                
													
												
												
													 
							               
										
							</div>
        <div class="box-footer">   	
	        	<div class="col-md-<?= $model->isNewRecord ? '7' : '6' ?>">
		        	<?php //$viewFormFunction->returnDropDownListStatus($form,$model,$model->id_status)?>	<input id="hdn_type_surat" type="hidden" value="<?=$typeSurat ?>">	        
		         </div>		         
	        	<div class="col-md-1">	        		
		          	<?= Html::submitButton( 'Simpan', ['class' => 'btn btn-primary', 'name'=>'btnSubmit', 'value'=>'simpan','id' => 'btnSimpanPidsus1']) ?>
		      	</div>	     	
	        	<div class="col-md-1">		   		
		          	<?=Html::a('Batal',$model->isNewRecord ? ['index'] : ['../pidsus/default/index'], ['data-pjax'=>0, 'class' => 'btn btn-danger', 'title'=>'cancel','id' => 'btnCancel']) ?>
    			 </div>
		      		<?php  if($typeSurat=='p1'){?>
	        	<div class="col-md-1">
	        			<?= Html::submitButton('Cetak', ['data-pjax'=>0, 'class' => 'btn btn-success', 'name'=>'btnCetak', 'id'=>'btnCetak', 'value'=>'p1']) ?>
		      	</div>	
		      	<?php } else if($typeSurat=='pidsus1'){?>
		      	<div class="col-md-1">
		      			<?= Html::submitButton('Cetak', ['data-pjax'=>0, 'class' => 'btn btn-success', 'name'=>'btnCetak', 'id'=>'btnCetak', 'value'=>'pidsus1']) ?>

		      	</div>
		      		<?php }?>
	    </div>
		
    <?php ActiveForm::end(); ?>

</div>
