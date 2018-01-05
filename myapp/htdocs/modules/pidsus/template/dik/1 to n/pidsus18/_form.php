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
$sqlPenandatangan="select * from pidsus.get_penandatangan	('".$idSatker."','".$model->id_jenis_surat."') order by id_penandatangan";
$sqlSifatSurat="select id_detail, nama_detail from pidsus.parameter_detail where id_header=10 order by no_urut";

?>

<div class="pds-lid-form">

   <div>
    <div class="box box-primary">
	<div class="box-header">

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
					                                    <label for="nomor_surat" class="control-label col-md-3">Nomor Surat </label>
					                                    <div class="col-md-6"><?= $form->field($model, 'no_surat')->textInput(['readonly' => $readOnly]) ?></div>
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
					                                                        'autoclose' => true, 'startDate' => $viewFormFunction->getPreviousSuratDate($model), 'endDate' => $_SESSION['todayDate']
					                                                    ]
					                                                ],
					                                             	'readonly'=>true,
					                                            ])?>
					                                    </div>
													</div>
												
												</div>
							                </div>
											<div>
							                    <div>
							                    <div class="box box-solid">
							                    
					                            <?=$viewFormFunction->returnSuratIsi ($this, $form,$modelSuratIsi)?>        		
					                            </div>
					                        
					                            	
					                        </div></div> 
					                        <div class="box box-solid">
							                    <div class="box-header with-border">
							                        
							                        <h3 class="box-title">Tersangka :</h3>
							                    </div><!-- /.box-header -->
							                    <div class="box-body">   		 
											<div>
												<div class="form-group">
					                                    <label for="Nama" class="control-label col-md-3">Nama</label>
					                                    <div class="col-md-6"><?= $form->field($modelTersangka, 'nama_tersangka')->textInput(['readonly' => $readOnly]) ?></div>
					                                </div> 
												<div class="form-group">
					                                    <label for="ttl" class="control-label col-md-3">Tempat/Tanggal Lahir</label>
					                                    <div class="col-md-3"><?= $form->field($modelTersangka, 'tempat_lahir')->textInput(['readonly' => $readOnly]) ?></div>
					                                	<div class="col-md-3"><?=
					                                             $form->field($modelTersangka, 'tgl_lahir')->widget(DateControl::classname(), [
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
												<?= $viewFormFunction->returnSelect2ParameterDetail($form,$modelTersangka,'jenis_kelamin','Jenis Kelamin',5)?>
												<div class="form-group">
					                                    <label for="kewarganegaraan" class="control-label col-md-3">Kewarganegaraan</label>
					                                    <div class="col-md-6"><?= $form->field($modelTersangka, 'kewarganegaraan')->textInput(['readonly' => $readOnly]) ?></div>
					                                </div> 
												<div class="form-group">
					                                    <label for="alamat" class="control-label col-md-3">Alamat</label>
					                                   <div class="col-md-6"><?= $form->field($modelTersangka, 'alamat')->textArea(array('maxlength' => 4000, 'rows' => 6, 'cols' => 50,'readonly' => $readOnly)) ?></div>
													 </div> 
												<?= $viewFormFunction->returnSelect2ParameterDetail($form,$modelTersangka,'agama','Agama',4)?>
												<div class="form-group">
					                                    <label for="pekerjaan" class="control-label col-md-3">Pekerjaan</label>
					                                    <div class="col-md-6"><?= $form->field($modelTersangka, 'kewarganegaraan')->textInput(['readonly' => $readOnly]) ?></div>
					                                </div>
					                                <?= $viewFormFunction->returnSelect2ParameterDetail($form,$modelTersangka,'pendidikan','Pendidikan',6)?>
												
					                        </div>           		
					                        </div></div>
					                        <?= $viewFormFunction->returnSelect2($sqlPenandatangan,$form,$model,'id_ttd','Penandatangan','id_penandatangan','nama_penandatangan','Pilih Penandatangan ...','penandatangan','full')?>
					                         <div class="box box-solid">
							                    <div class="box-header with-border">
							                        
							                        <h3 class="box-title">Tembusan :</h3>
							                    </div><!-- /.box-header -->
							                    <div class="box-body">   		 
											<div>
							                    <div>
					                            <?=$viewFormFunction->returnTembusanDynamic ($form,$modelTembusan,$this,'dik')?>
					                             
								                		
					                            </div>
					                        </div>           		
					                        </div></div>
					                        
						        	<div>
						        		
							        	<div class="col-md-6">
								        	<?php //$viewFormFunction->returnDropDownListStatus($form,$model,$modelLid->id_status)?>
								          </div>
								         
							        	<div class="col-md-1">
							        		
								          	<?= Html::submitButton( 'Simpan', ['class' => 'btn btn-primary', 'name'=>'btnSubmit', 'value'=>'simpan','id' => 'btnSimpan']) ?>
								        </div>
								        
								        <div class="col-md-1">	        		
								          	<?=Html::a('Batal', ['index'], ['data-pjax'=>0, 'class' => 'btn btn-danger', 'title'=>'cancel','id' => 'btnCancel']) ?>
						    			 </div>						    			 
						    			  		      		     	
							        	<div class="col-md-1">
								      			<?= Html::submitButton('Cetak', ['data-pjax'=>0, 'class' => 'btn btn-success', 'name'=>'btnCetak', 'id'=>'btnCetak', 'value'=>'pidsus18']) ?>
								      	</div>	
							        </div>
					                        
							            </div>
							        </div>
							    </div>
							</div>
        
		
    <?php ActiveForm::end(); ?>
</div>
</div>

</div>
