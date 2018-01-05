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

$sqlLokasi="Select distinct inst_satkerkd, inst_nama from kepegawaian.kp_inst_satker";
$sqlPenerimaSurat="select * from pidsus.get_penerima_laporan ('".$idSatker."') order by nama_penerima_lap";
$sqlPenandatangan="select * from pidsus.get_jaksa_p2	('".$model->id_pds_lid_surat."')";
$tglLap=new datetime($modelLid->tgl_lap);
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
							                    <div>
							                    	<div class="form-group">
					                                    <label for="lokasiSurat" class="control-label col-md-3">Dikeluarkan</label>
					                                    <div class="col-md-2"><?= $form->field($model, 'lokasi_surat')->textInput(['readonly' => $readOnly]) ?></div>
					                               		
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
					                                    <div class='col-md-2'>
					                                    <?= $form->field($model, 'jam_surat')->widget(TimePicker::classname(), [
															'pluginOptions' => [

																'showMeridian' => false,
																'minuteStep' => 1,

															]
														]);?>
					                                    </div>
													</div>
													
												<?= $viewFormFunction->returnSelect2($sqlPenandatangan,$form,$model,'id_ttd','Yang Menyerahkan','peg_nik','peg_nama','Pilih Penandatangan ...','penandatangan','full')?>
					                        	
												
							                </div>
									
					                       <div>
							                    <div>


					                            <?=$viewFormFunction->returnSuratIsi ($this, $form,$modelSuratIsi)?>
													<?=str_replace('$noPdsLid',$modelLid->no_lap,str_replace('$tglPdsLid',$tglLap->format('d F Y'),$viewFormFunction->returnDetailFull ($form,$modelSuratDetail,$this,'pidsus9')))?>
												<?= $viewFormFunction->returnSelect2($sqlPenerimaSurat,$form,$model,'id_ttd2','Yang Menerima','id_penerima_lap','nama_penerima_lap','Pilih Kepada ...','yang_menerima','full')?>
												<?php if(empty($_SESSION['idPdsDik'])){?>
													<?= $viewFormFunction->returnSelect2($sqlLokasi,$form,$modelLid,'id_satker_kirim','Instansi Penyidikan','inst_satkerkd','inst_nama','kode satker ..',$_SESSION['idSatkerUser'],'full')?>
													<!-- <div class="form-group">
					                                    <label for="lokasiPenyelidikan" class="control-label col-md-3">Instansi Penyidikan</label>
					                                    <div class="col-md-6">
															<?php //$viewFormFunction->returnSelect2WithoutModel($sqlLokasi,$form,'inst_satkerkd','inst_nama','Pilih Instansi Penyidikan','lokasi_penyelidikan',$_SESSION['idSatkerUser'])?>

														</div>
													 -->

					                             </div>
					                             <div class="form-group">
					                                    <label for="isSend" class="control-label col-md-3">Kirim Ke Penyidikan</label>
					                                    <div class="col-md-6"><?= $form->field($modelLid, 'is_final')->checkbox(array('label'=>'')); ?>
															<!--<input type="checkbox" name="isSend" value="1" class-form-control></input> --></div>
					                             </div>
					                             <?php } else {
					                             	echo $viewFormFunction->returnSelectDisable($sqlLokasi,$form,$modelLid,'id_satker_kirim','Instansi Penyidikan','inst_satkerkd','inst_nama','kode satker ..',$_SESSION['idSatkerUser'],'full');
					                             }?>
					               <div class="box box-solid">
						        	<div>
						        		
							        	<div class="col-md-5">
								        	 </div>
							        	<div class="col-md-1">
							        		
								          	<?= Html::submitButton( 'Simpan', ['class' => 'btn btn-primary', 'name'=>'btnSubmit', 'value'=>'simpan','id' => 'btnSimpan']) ?>
								        </div>
								        
								        <div class="col-md-1">	        		
								          	<?=Html::a('Batal', ['../pidsus/default/viewlaporan?id='.$model->id_pds_lid], ['data-pjax'=>0, 'class' => 'btn btn-danger', 'title'=>'cancel','id' => 'btnCancel']) ?>
						    			 </div>						    			 
						    			<div class="col-md-1"><input type="hidden" id="hdnIdPdsLidSurat" value="<?= $model->id_pds_lid_surat ?>"/><a class="btn btn-danger" id="hapus-surat-lid"> Hapus</a></div>  		      		     	
							        	<div class="col-md-1">
								      			<?= Html::submitButton('Cetak', ['data-pjax'=>0, 'class' => 'btn btn-success', 'name'=>'btnCetak', 'id'=>'btnCetak', 'value'=>'pidsus2']) ?>
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
