<?php

use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;

require('..\modules\pidsus\controllers\viewFormFunction.php');
$viewFormFunction=new viewFormFunction();

/* @var $this yii\web\View */
/* @var $model app\models\PdsLidSurat */
/* @var $form yii\widgets\ActiveForm */
$idSatker=$_SESSION['idSatkerUser'];
$sqlPenerimaSurat="select nama_detail as kepada, no_urut as ORDERNO from pidsus.parameter_detail where id_header =39";
$sqlPengirimSurat="select nama_detail as dari, no_urut as ORDERNO from pidsus.parameter_detail where id_header =40";

$sqlPenandatangan="select peg_nik id_penandatangan, peg_nama nama_penandatangan from pidsus.get_jaksa_satker('".$idSatker."') order by peg_nama";

$tglLap=new datetime($modelLid->tgl_spdp);

?>

<div class="pds-lid-surat-form">

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
												 <div class="form-group">
					                                    <label for="lampiran" class="control-label col-md-3">Kepada Yth </label>
					                                    <div class="col-md-6"><?= $form->field($model, 'kepada')->textInput(['readonly' => true]) ?></div>
					                                </div> 
													<?= $viewFormFunction->returnSelect2($sqlPengirimSurat,$form,$model,'dari','Dari','dari','dari','Pilih pengirim ...','dari','full')?>	
													
			
							                    <div class="form-group">
														<label for="tgl_surat" class="control-label col-md-3">Tanggal Surat</label>
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
					                                 <div class="form-group">
					                                    <label for="lampiran" class="control-label col-md-3">Lampiran </label>
					                                    <div class="col-md-6"><?= $form->field($model, 'lampiran_surat')->textInput(['readonly' => $readOnly]) ?></div>
					                                </div> 
					                                <div class="form-group">
													  <label for="perihal" class="control-label col-md-3">Perihal </label>
													  <div class="col-md-6"><?= $form->field($model, 'perihal_lap')->textArea(array('maxlength' => 4000, 'rows' => 3, 'cols' => 50,'readonly' => $readOnly)) ?></div>
													</div>  
																				                
							                </div>
							                
					               <?php 
										// echo $viewFormFunction->returnDetailFull ($form, $modelSuratDetail, $this) 
									?>
									
					                        <div>
							                    <div>
							                   
					                            <?=$viewFormFunction->returnSuratIsi ($this, $form,$modelSuratIsi)?>
												<?=str_replace('$noPdsLid',$modelLid->no_spdp,str_replace('$tglPdsLid',$tglLap->format('d-M-Y'),$viewFormFunction->returnDetailFull ($form,$modelSuratDetail,$this,'pidsus7lid')))?>
					                            </div>
					                        </div>
									
						        	<div>

									 <?=$viewFormFunction->returnSelect2($sqlPenandatangan,$form,$model,'id_ttd','Penandatangan','id_penandatangan','nama_penandatangan','Pilih Penandatangan ...','penandatangan','full')?>

							        	<div class="col-md-6">
								        	<?php //$viewFormFunction->returnDropDownListStatus($form,$model,$modelLid->id_status)?>
								          </div>
							        	<div class="col-md-1" style="align: right;">
							        		
								          	<?= Html::submitButton( 'Simpan', ['class' => 'btn btn-primary', 'name'=>'btnSubmit', 'value'=>'simpan','id' => 'btnSimpan']) ?>
								        </div>
								        
								        <div class="col-md-1">	        		
								          	<?=Html::a('Batal', ['../pidsus/default/viewlaporan?id='.$model->id_pds_lid], ['data-pjax'=>0, 'class' => 'btn btn-danger', 'title'=>'cancel','id' => 'btnCancel']) ?>
						    			 </div>						    			 
						    			<div class="col-md-1"><input type="hidden" id="hdnIdPdsLidSurat" value="<?= $model->id_pds_lid_surat ?>"/><a class="btn btn-danger" id="hapus-surat-lid"> Hapus</a></div>
							        	<div class="col-md-1">
								      			<?= Html::submitButton('Cetak', ['data-pjax'=>0, 'class' => 'btn btn-success', 'name'=>'btnCetak', 'id'=>'btnCetak', 'value'=>'pidsus7lid']) ?>
								      	</div>	
							        </div>
					             </div></div></br>      
							            </div>
							        </div>
							    </div>
							    <div class="box-footer">
						        </div>    
							</div>
        					
		
    <?php ActiveForm::end(); ?>
</div>
<?php 
//$viewFormFunction->setJs($this,$form,$model,$modelLid);

?>
<script>
function hapusJpu(id)
{
   $('#tbody_jpu').append(
       '<input type=\"hidden\" name=\"hapus_jpu[]\" value=\"'+id+'\">'
   );

   $('#trjpu'+id).remove();
};
	
function hapusJpuPop(id)
{
$('#trjpu'+id).remove();
};
</script>

</div>
