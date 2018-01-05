<?php

use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use \kartik\time\TimePicker;

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


$tglLap=new datetime($modelTut->tgl_spdp);
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
														<label for="lokasiSurat" class="control-label col-md-3">Tanda Terima</label>
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
														<div class='col-md-3'>
															<?= $form->field($model, 'jam_surat')->widget(TimePicker::classname(), [
																'pluginOptions' => [

																	'showMeridian' => false,
																	'minuteStep' => 1,

																]
															]);?>
														</div>

														<div class="col-md-3"><?= $viewFormFunction->returnSelect2($sqlLokasi,$form,$model,'lokasi_surat','Lokasi Penerima Laporan','inst_lokinst','inst_lokinst','Pilih Lokasi ...','lokasi_penerima')?></div>

													</div>

												</div>
											</div>
											<div>
												<div>
					                                </div>  
					                                		
							                </div>
											<div>
												<div class="box box-solid">
													 <!-- /.box-header -->

							                    <div>


							                    <div class="box box-solid">

													<?=$viewFormFunction->returnSuratIsi ($this, $form,$modelSuratIsi)?>
												<?=str_replace('$noPdsTut',$modelTut->no_spdp,str_replace('$tglPdsTut',$tglLap->format('d-M-Y'),$viewFormFunction->returnDetailFullTut ($form,$modelSuratDetail,$this)))?>

					                            <?= $viewFormFunction->returnSelect2($sqlPenandatangan,$form,$model,'id_ttd','Yang Menyerahkan','peg_nik','peg_nama','Pilih Penandatangan ...','penandatangan','full')?>
					                        </div></div></div>

					                        
						        	<div>
						        		
							        	<div class="col-md-6">
								        	<?php //$viewFormFunction->returnDropDownListStatus($form,$model,$modelLid->id_status)?>
								          </div>
								         
							        	<div class="col-md-1">
							        		
								          	<?= Html::submitButton( 'Simpan', ['class' => 'btn btn-primary', 'name'=>'btnSubmit', 'value'=>'simpan']) ?>
								        </div>
								        
								        <div class="col-md-1">	        		
								          	<?=Html::a('Batal', ['../pidsus/p34'], ['data-pjax'=>0, 'class' => 'btn btn-danger', 'title'=>'cancel']) ?>
						    			 </div>						    			 
						    			  		      		     	
							        	<div class="col-md-1">
								      			<?= Html::submitButton('Cetak', ['data-pjax'=>0, 'class' => 'btn btn-success', 'name'=>'btnCetak', 'value'=>'p34']) ?>
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
