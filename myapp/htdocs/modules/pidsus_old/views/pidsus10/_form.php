<?php

use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use \kartik\time\TimePicker;
use kartik\widgets\Select2;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;

require('..\modules\pidsus\controllers\viewFormFunction.php');
$viewFormFunction=new viewFormFunction();

$idSatker=$_SESSION['idSatkerUser'];
/* @var $this yii\web\View */
/* @var $model app\models\PdsLidSurat */
/* @var $form yii\widgets\ActiveForm */

//$sqlPenerimaSurat="select * from pidsus.get_penerima_laporan ('".$idSatker."') order by nama_penerima_lap";
$sqlJaksa="select * from pidsus.get_jaksa_p2('".$model->id_pds_lid_surat."')";
$tglLap=new datetime($modelLid->tgl_lap);
?>

<div class="pds-lid-surat-form">

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
					                                    <label for="lokasiSurat" class="control-label col-md-3">Tanggal dan Jam Surat</label>
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
													</div>
													<?= $viewFormFunction->returnSelect2($sqlJaksa,$form,$model,'id_ttd','Penerima Paket','peg_nik','peg_nama','Pilih Penerima Paket ...','penandatangan','full')?>

												
							                </div>
									
					                       <div>
							                    <div>
							                    <div class="box box-solid">
							                    
					                            <?=$viewFormFunction->returnSuratIsi ($this, $form,$modelSuratIsi)?>        		
					                            </div>
												<?=str_replace('$noPdsLid',$modelLid->no_lap,str_replace('$tglPdsLid',$tglLap->format('d F Y'),$viewFormFunction->returnDetailFull ($form,$modelSuratDetail,$this,'pidsus10')))?>
													<div>

														<div class="col-md-6">
															<?php //$viewFormFunction->returnDropDownListStatus($form,$model,$modelLid->id_status)?>
														</div>

														<div class="col-md-1">

															<?= Html::submitButton( 'Simpan', ['class' => 'btn btn-primary', 'name'=>'btnSubmit', 'value'=>'simpan','id' => 'btnSimpan']) ?>
														</div>

														<div class="col-md-1">
															<?=Html::a('Batal', ['../pidsus/pidsus10'], ['data-pjax'=>0, 'class' => 'btn btn-danger', 'title'=>'cancel','id' => 'btnCancel']) ?>
														</div>
														<div class="col-md-1">

															<?= Html::submitButton('Cetak', ['data-pjax'=>0, 'class' => 'btn btn-success', 'name'=>'btnCetak', 'id'=>'btnCetak', 'value'=>'pidsus10']) ?>
														</div>
													</div>


								        </div>
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
