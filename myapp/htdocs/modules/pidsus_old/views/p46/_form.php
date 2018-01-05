<?php

use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;

use yii\bootstrap\Modal;

require('..\modules\pidsus\controllers\viewFormFunction.php');
$viewFormFunction=new viewFormFunction();
$idSatker=$_SESSION['idSatkerUser'];
/* @var $this yii\web\View */
/* @var $model app\models\PdsLid */
/* @var $form yii\widgets\ActiveForm */

$sqlLokasi="Select distinct inst_lokinst from kepegawaian.kp_inst_satker";
$sqlPenerimaSurat="select * from pidsus.get_penerima_laporan ('".$idSatker."') order by nama_penerima_lap";
$sqlPenandatangan="select * from pidsus.get_jaksa_satker	('".$idSatker."') order by peg_nama";
$sqlSifatSurat="select id_detail, nama_detail from pidsus.parameter_detail where id_header=10 order by no_urut";
/*)$sqlPerihal="SELECT 'Pemberitahuan dan permintaan persetujuan lelang benda sitaan/barang bukti yang lekas rusak' AS perihal,
 0 AS ORDERNO UNION SELECT 'Pemberitahuan dan permintaan persetujuan lelang benda sitaan/barang bukti yang membahayakan',
 1  UNION SELECT 'Pemberitahuan dan permintaan persetujuan lelang benda sitaan/barang bukti yang berbiaya tinggi',2 
 ORDER BY ORDERNO";*/


$tglLap=new datetime($modelDik->tgl_spdp);
?>

<div class="pds-lid-form">

   <div>
    <div class="box box-primary">
	<div class="box-header">
            <center></center>
        </div>
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
							    <div>
							        <div><div class="box-body">
							                <div>
							                    <div>
												  
													<div class="form-group">
														<label for="kepada" class="control-label col-md-3">Kepada Yth </label>
														<div class="col-md-6"><?= $form->field($model, 'kepada')->textInput(['readonly' => $readOnly]) ?></div>
													</div>
													<div class="form-group">
														<label for="kepada" class="control-label col-md-3">Melalui </label>
														<div class="col-md-6"><?= $form->field($model, 'kepada_melalui')->textInput(['readonly' => $readOnly]) ?></div>
													</div>
													<?= $viewFormFunction->returnSelect2($sqlLokasi,$form,$model,'kepada_lokasi','Di','inst_lokinst','inst_lokinst','Pilih Lokasi ...','lokasiPenerima','full')?>

												</div>
											</div>
											<div>
												<div>
					                                </div>  
					                                		
							                </div>
											<div>
												<div class="box box-solid">
													<div class="box-header with-border">


													</div><!-- /.box-header -->

							                    <div>


							                    <div class="box box-solid">



													<?=$viewFormFunction->returnSuratIsi ($this, $form,$modelSuratIsi)?>

													<div class="form-group">
														<label for="lokasiSurat" class="control-label col-md-3">Dikeluarkan</label>
														<div class="col-md-3"><?= $viewFormFunction->returnSelect2($sqlLokasi,$form,$model,'lokasi_surat','Lokasi Penerima Laporan','inst_lokinst','inst_lokinst','Pilih Lokasi ...','lokasi_penerima')?></div>
														<div class="col-md-3"><?=
															$form->field($model, 'tgl_surat')->widget(DateControl::classname(), [
																'type'=>DateControl::FORMAT_DATE,
																'ajaxConversion'=>false,
																'options' => [
																	'pluginOptions' => [
																		'autoclose' => true, 'startDate' => $viewFormFunction->getPreviousSuratDate($model), 'endDate' => $_SESSION['todayDate']
																	]
																],
																'readonly'=>true,
															])?>
														</div>
													</div>
													<?= $viewFormFunction->returnSelect2($sqlPenandatangan,$form,$model,'id_ttd','Yang Menyerahkan','peg_nik','peg_nama','Pilih Penandatangan ...','penandatangan','full')?>
					                        </div></div></div>
					                 
					                        
						        	<div>
						        		
							        	<div class="col-md-6">
								        	<?php //$viewFormFunction->returnDropDownListStatus($form,$model,$modelLid->id_status)?>
								          </div>
								         
							        	<div class="col-md-1">
							        		
								          	<?= Html::submitButton( 'Simpan', ['class' => 'btn btn-primary', 'name'=>'btnSubmit', 'value'=>'simpan','id' => 'btnSimpan']) ?>
								        </div>
								        
								        <div class="col-md-1">	        		
								          	<?=Html::a('Batal', ['../pidsus/p46'], ['data-pjax'=>0, 'class' => 'btn btn-danger', 'title'=>'cancel','id' => 'btnCancel']) ?>
						    			 </div>						    			 
						    			  		      		     	
							        	<div class="col-md-1">
								      			<?= Html::submitButton('Cetak', ['data-pjax'=>0, 'class' => 'btn btn-success', 'name'=>'btnCetak', 'id'=>'btnCetak', 'value'=>'p46']) ?>
								      	</div>	
							        </div>
					                        
							            </div>
							        </div>
							    </div>
							    <div class="box-footer">
						        </div>    
							</div>
        
		
    <?php ActiveForm::end(); ?>
</div>
</div>


</div>
