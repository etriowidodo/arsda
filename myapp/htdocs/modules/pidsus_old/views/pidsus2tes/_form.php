<?php

use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use kartik\widgets\DatePicker;

require('..\modules\pidsus\controllers\viewFormFunction.php');
$viewFormFunction=new viewFormFunction();
$idSatker=$_SESSION['idSatkerUser'];
/* @var $this yii\web\View */
/* @var $model app\models\PdsLid */
/* @var $form yii\widgets\ActiveForm */

$sqlLokasi="Select distinct inst_lokinst from kepegawaian.kp_inst_satker";
$sqlPenerimaSurat="select * from pidsus.get_penerima_laporan ('".$idSatker."') order by nama_penerima_lap";
$sqlPenandatangan="select * from pidsus.get_penandatangan	('".$idSatker."','".$model->id_jenis_surat."') order by id_penandatangan";
$sqlSifatSurat="select id_detail, nama_detail from pidsus.parameter_detail where id_header=10 order by no_urut";
echo  $_SESSION['debug'];
?>

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
									<div class="box-body">
							                <div class="box box-solid"	>
							                    <div>
							                    	<div class="form-group">
														<?php echo  $_SESSION['debug'];?>
					                                    <label for="nomor_surat" class="control-label col-md-3">Nomor Surat </label>
					                                    <div class="col-md-6"></div>
					                                </div>  
					                                <?= $viewFormFunction->returnSelect2($sqlSifatSurat,$form,$model,'sifat_surat','Sifat Surat','id_detail','nama_detail','Pilih Sifat Surat ...','sifat_surat','full')?>
					                                <div class="form-group">
					                                    <label for="no_surat" class="control-label col-md-3">Lampiran </label>
					                                    <div class="col-md-6"><?= $form->field($model, 'lampiran_surat')->textInput(['readonly' => $readOnly]) ?></div>
					                                </div> 
					                                <div class="form-group">
													  <label for="lampiran" class="control-label col-md-3">Perihal </label>
													  <div class="col-md-6"><?= $form->field($model, 'perihal_lap')->textArea(array('maxlength' => 4000, 'rows' => 3, 'cols' => 50,'readonly' => $readOnly)) ?></div>
													</div>   													
					                                <div class="form-group">
					                                    <label for="lokasiSurat" class="control-label col-md-3">Dikeluarkan</label>
					                                    <div class="col-md-3"><?= $viewFormFunction->returnSelect2($sqlLokasi,$form,$model,'lokasi_surat','Lokasi Penerima Laporan','inst_lokinst','inst_lokinst','Pilih Lokasi ...','lokasi_penerima')?></div>
					                               		<div class="col-md-3"><?=
					                                             $form->field($model, 'tgl_surat')->widget(DateControl::classname(), [
					                                                'type'=>DateControl::FORMAT_DATE,
					                                                'ajaxConversion'=>false,
					                                                'options' => [
					                                                    'pluginOptions' => [
					                                                        'autoclose' => true, 'startDate' => $viewFormFunction->getPreviousSuratDate($model), 'endDate' => $_SESSION['todayDate'],
																			
					                                                    ]
					                                                ],
					                                             	'readonly'=>true,
					                                            ])

															;
															?>
					                                    </div>
													</div>
												<div class="form-group">
															<label for="penerimaSurat" class="control-label col-md-3">Kepada Yth</label>
															<div class="col-md-6"><?= $form->field($model, 'kepada')->textInput(['readonly' => $readOnly]) ?></div>
													</div> 
												 <div class="form-group">
															<label for="penerimaSurat" class="control-label col-md-3">Di</label>
															<div class="col-md-6"><?= $form->field($model, 'kepada_lokasi')->textInput(['readonly' => $readOnly]) ?></div>
													</div> 	
													
												</div>
							                </div>
											<div>
							                    <div>
							                    <div class="box box-solid">
							                 
					                            <?=$viewFormFunction->returnSuratIsi ($this, $form,$modelSuratIsi)?>
					                            </div>
					                       
					                            

					                            <?= $viewFormFunction->returnSelect2($sqlPenandatangan,$form,$model,'id_ttd','Penandatangan','id_penandatangan','nama_penandatangan','Pilih Penandatangan ...','penandatangan','full')?>

					                             </div>
					                        </div></div>
					                         <div class="box box-solid">
							                    <div class="box-header with-border">
							                        
							                        <h3 class="box-title">Tembusan :</h3>
							                    </div><!-- /.box-header -->
							                    <div class="box-body">   		 
											<div>
							                    <div>
					                            <?=$viewFormFunction->returnTembusanDynamic ($form,$modelTembusan,$this,'lid')?>
					                             
								                		
					                            </div>
					                        </div>           		
					                        </div></div></br>
					                        
						        	<div>
						        		
							        	<div class="col-md-5">
								        	<?php //$viewFormFunction->returnDropDownListStatus($form,$model,$modelLid->id_status)?>
								          </div>
								         
							        	<div class="col-md-1">
							        		
								          	<?= Html::submitButton( 'Simpan', ['class' => 'btn btn-primary', 'name'=>'btnSubmit', 'value'=>'simpan','data' => ['confirm' => 'Apakah anda yakin ingin Menyimpan']]) ?>
								        </div>
								        <div class="col-md-1">	        		
								          	<?=Html::a('Batal', ['../pidsus/default/viewlaporan?id='.$model->id_pds_lid], ['data-pjax'=>0, 'class' => 'btn btn-danger', 'title'=>'cancel', 'data' => ['confirm' => 'Apakah anda yakin ingin membatalkan?']]) ?>
						    			 </div>						    			 										
								        <div class="col-md-1">
								        	<input type="hidden" id="hdnIdPdsLidSurat" value="<?= $model->id_pds_lid_surat ?>"/><a class="btn btn-danger" id="hapus-surat"> Hapus</a>
								        </div>						    			  		      		     	
							        	<div class="col-md-1">
								      			<?= Html::submitButton('Cetak', ['data-pjax'=>0, 'class' => 'btn btn-success', 'name'=>'btnCetak', 'data' => ['confirm' => 'Apakah anda yakin ingin menyimpan lalu mencetak?'], 'value'=>'pidsus2']) ?>
								      	</div>	
							        </div>
					                        
							            </div>
							    </div>  
							</div>
        
		
    <?php ActiveForm::end(); ?>
</div>
</div>

</div>