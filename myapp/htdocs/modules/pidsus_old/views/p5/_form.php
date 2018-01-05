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

$sqlPenandatangan="select * from pidsus.get_jaksa_p2	('".$model->id_pds_lid_surat."') order by peg_nama";
?>

<div class="pds-lid-surat-form">

  <div class="pds-lid-form">

   <div>
    <div class="box box-primary">
	<div class="box-header">
            <center></center>
        </div>
    <?php
	$form = ActiveForm::begin(
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

					                                    <div class="col-md-3"><?= $form->field($model, 'lokasi_surat')->textInput(['readonly' => $readOnly]) ?></div>
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
													</div>
												<div class="form-group">
															<label for="penerimaSurat" class="control-label col-md-3">Kepada Yth</label>
															<div class="col-md-6"><?= $form->field($model, 'kepada')->textInput(['readonly' => $readOnly]) ?></div>
													</div>
												<div class="form-group">
					                                    <label for="lokasiPenerima" class="control-label col-md-3">Di</label>
					                                    <div class="col-md-6"><?= $form->field($model, 'kepada_lokasi')->textInput(['readonly' => $readOnly]) ?></div>
					                                </div>
												
							                </div>
									
					                       <div>
							                    <div>
							                    <div class="box box-solid">
							                  
					                            <?=$viewFormFunction->returnSuratIsi ($this, $form,$modelSuratIsi)?>        		
					                            <?= $viewFormFunction->returnSelect2($sqlPenandatangan,$form,$model,'id_ttd','Jaksa penyelidik','peg_nik','peg_nama','Pilih Jaksa Penyelidik ...','Penyelidik','full')?>
												</div>
												
					                            <div class="box box-solid">
							                    <div class="box-header with-border">
							                        
							                        <h3 class="box-title">Tembusan  :</h3>
							                    </div>
					                           <?=$viewFormFunction->returnTembusanDynamic ($form,$modelTembusan,$this)?>      		
					                            </div>
					                            
					                            

					               <div class="box box-solid">
						        	<div>
						        		
							        	<div class="col-md-7">
								        	 </div>
							        	<div class="col-md-1">
							        		
								          	<?= Html::submitButton( 'Simpan', ['class' => 'btn btn-primary', 'name'=>'btnSubmit', 'value'=>'simpan','id' => 'btnSimpan']) ?>
								        </div>
								        
								        <div class="col-md-1">	        		
								          	<?=Html::a('Batal', ['../pidsus/default/viewlaporan?id='.$model->id_pds_lid], ['data-pjax'=>0, 'class' => 'btn btn-danger', 'title'=>'cancel','id' => 'btnCancel']) ?>
						    			 </div>						    			 
						    			 <div class="col-md-1"><input type="hidden" id="hdnIdPdsLidSurat" value="<?= $model->id_pds_lid_surat ?>"/><a class="btn btn-danger" id="hapus-surat-lid"> Hapus</a></div> 		      		     	
							        	<div class="col-md-1">
								      			<?= Html::submitButton('Cetak', ['data-pjax'=>0, 'class' => 'btn btn-success', 'name'=>'btnCetak', 'id'=>'btnCetak', 'value'=>'p5']) ?>
								      	</div>	
							        </div>
					               </div>              		
					                        </div></div>      
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

</div>
