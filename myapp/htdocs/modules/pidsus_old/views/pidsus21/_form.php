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
$sqlPenerimaSurat="select id_detail, nama_detail from pidsus.parameter_detail where id_header=55 order by no_urut";
$sqlDariSurat="select id_detail, nama_detail from pidsus.parameter_detail where id_header=56 order by no_urut";
$sqlPenandatangan="select peg_nik id_penandatangan, peg_nama nama_penandatangan from pidsus.get_jaksa_p8dik	('".$model->id_pds_dik_surat."') order by peg_nama";
$sqlSifatSurat="select id_detail, nama_detail from pidsus.parameter_detail where id_header=10 order by no_urut";
$sqlPerihalSurat="select id_detail, nama_detail from pidsus.parameter_detail where id_header=52 order by no_urut";
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
							                       <?= $viewFormFunction->returnSelect2($sqlPenerimaSurat,$form,$model,'kepada','Kepada Yth.','nama_detail','nama_detail','Pilih Penerima Surat ...','kepada','full')?>		
					                                <?= $viewFormFunction->returnSelect2($sqlDariSurat,$form,$model,'dari','Dari','nama_detail','nama_detail','Pilih Pengirim Surat ...','dari','full')?>		
					                                <div class="form-group">
					                                    <label for="no_surat" class="control-label col-md-3">Nomor </label>
					                                    <div class="col-md-6"><?= $form->field($model, 'no_surat')->textInput(['readonly' => $readOnly]) ?></div>
					                                </div> 
													<div class="form-group">
					                                    <label for="lokasiSurat" class="control-label col-md-3">Tanggal</label>
					                                    <div class="col-md-6"><?=
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
												<div class="form-group">
					                                    <label for="no_surat" class="control-label col-md-3">Lampiran </label>
					                                    <div class="col-md-6"><?= $form->field($model, 'lampiran_surat')->textInput(['readonly' => $readOnly]) ?></div>
					                                </div> 
					                                <?= $viewFormFunction->returnSelect2($sqlPerihalSurat,$form,$model,'perihal_lap','Perihal','nama_detail','nama_detail','Pilih Perihal Surat ...','perihal_lap','full')?>		
					                                  													
					                               
												</div>
							                </div>
											<div>
							                    <div>
							                    <div class="box box-solid">
							                    
					                            <?=$viewFormFunction->returnSuratIsi ($this,$form,$modelSuratIsi)?>
					                           <?=str_replace('$noPdsDik',$modelDik->no_spdp,str_replace('$tglPdsDik',$tglLap->format('d-M-Y'),$viewFormFunction->returnDetailFullDik3 ($form,$modelSuratDetail,$this,'pidsus21')))?>
					                            <?= $viewFormFunction->returnSelect2($sqlPenandatangan,$form,$model,'id_ttd','Penandatangan','id_penandatangan','nama_penandatangan','Pilih Penandatangan ...','penandatangan','full')?>	
					                      </div>   </div></div>
					                        
						        	<div>
						        		
							        	<div class="col-md-6">
								        	<?php //$viewFormFunction->returnDropDownListStatus($form,$model,$modelLid->id_status)?>
								          </div>
								         
							        	<div class="col-md-1">
							        		
								          	<?= Html::submitButton( 'Simpan', ['class' => 'btn btn-primary', 'name'=>'btnSubmit', 'value'=>'simpan']) ?>
								        </div>
								        
								        <div class="col-md-1">	        		
								          	<?=Html::a('Batal', ['../pidsus/default/viewlaporandik?id='.$model->id_pds_dik], ['data-pjax'=>0, 'class' => 'btn btn-danger', 'title'=>'cancel']) ?>
						    			 </div>						    			 
						    			  		      		     	
							        	<div class="col-md-1">
								      			<?= Html::submitButton('Cetak', ['data-pjax'=>0, 'class' => 'btn btn-success', 'name'=>'btnCetak', 'value'=>'pidsus20a']) ?>
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
