<?php

use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;

require('..\modules\pidsus\controllers\viewFormFunction.php');
$viewFormFunction=new viewFormFunction();
$idSatker='3173';
/* @var $this yii\web\View */
/* @var $model app\models\PdsLid */
/* @var $form yii\widgets\ActiveForm */


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
							        <div><div class="box-body">
							                <div>
							                    <div class="col-md-6">
							                    	<div class="form-group">
					                                    <label for="nomor_surat" class="control-label col-md-4">Nomor Surat </label>
					                                    <div class="col-md-6"><?= $form->field($model, 'no_surat')->textInput(['readonly' => $readOnly]) ?></div>
					                                </div>  
					                                <div class="form-group">
					                                    <label for="sifat_surat" class="control-label col-md-4">Sifat Surat </label>
					                                    <div class="col-md-6"><?= $form->field($model, 'sifat_surat')->textInput(['readonly' => $readOnly]) ?></div>
					                                </div>  
					                                <div class="form-group">
													  <label for="lampiran" class="control-label col-md-4">Lampiran </label>
													  <div class="col-md-6"><?= $form->field($model, 'lampiran_surat')->textArea(array('maxlength' => 4000, 'rows' => 6, 'cols' => 50,'readonly' => $readOnly)) ?></div>
													</div>   
					                                <div class="form-group">
					                                    <label for="no_surat" class="control-label col-md-4">Perihal </label>
					                                    <div class="col-md-6"><?= $form->field($model, 'perihal_lap')->textInput(['readonly' => $readOnly]) ?></div>
					                                </div>                 		
												</div>
												
							                    <div class="col-md-6">
													
					                                <div class="form-group">
					                                    <label for="lokasiSurat" class="control-label col-md-4">Lokasi Surat</label>
					                                    <div class="col-md-6"><?= $form->field($model, 'lokasi_surat')->textInput(['readonly' => $readOnly]) ?></div>
					                                </div>  
													<div class="form-group">
														<label for="tgl_surat" class="control-label col-md-4">Tanggal Surat</label>
														<div class="col-md-6"><?=
					                                             $form->field($model, 'tgl_surat')->widget(DateControl::classname(), [
					                                                'type'=>DateControl::FORMAT_DATE,
					                                                'ajaxConversion'=>false,
					                                                'options' => [
					                                                    'pluginOptions' => [
					                                                        'autoclose' => true
					                                                    ]
					                                                ],
					                                             	'readonly'=>$readOnly,
					                                            ])?>
					                                    </div>
													</div>
													
												<div class="form-group">
														<label for="penerimaSurat" class="control-label col-md-4">Penerima  Surat</label>
														<div class="col-md-6"><?=  $viewFormFunction->returnDropDownList($form,$model,"select * from pidsus.get_penerima_laporan ('".$idSatker."') order by nama_penerima_lap",'id_penerima_lap','nama_penerima_lap','kepada')   ?></div>
												</div>  
												<div class="form-group">
					                                    <label for="lokasiPenerima" class="control-label col-md-4">Lokasi Penerima Surat</label>
					                                    <div class="col-md-6"><?= $form->field($model, 'kepada_lokasi')->textInput(['readonly' => $readOnly]) ?></div>
					                                </div>
					                             
												<div class="form-group">
														<label for="satker" class="control-label col-md-4">Penandatangan </label>
														<div class="col-md-6"><?= $viewFormFunction->returnDropDownList($form,$model,"select * from pidsus.get_penandatangan	('".$idSatker."','".$typeSurat."') order by id_penandatangan",'id_penandatangan','nama_penandatangan','id_ttd') ?></div>
												</div>
												</div>
							                </div>
							                <?php if (!$model->isNewRecord){?>
											<div>
							                    <div class="col-md-6">
					                            <?=$viewFormFunction->returnSuratIsi ($this, $form,$modelSuratIsi)?>        		
					                            </div>
					                        </div> </br></br>
					                         <div class="box box-solid">
							                    <div class="box-header with-border">
							                        
							                        <h3 class="box-title">Tembusan:</h3>
							                    </div><!-- /.box-header -->
							                    <div class="box-body">   		 
											<div>
							                    <div class="col-md-6">
					                            <?=$viewFormFunction->returnTembusan ($form,$modelTembusan)?>        		
					                            </div>
					                        </div>           		
					                        </div></div></br>
					                        <?php }?>
						        	<div>
						        		<?php if($modelLid->id_status==7 || $modelLid->id_status==8){?>
							        	<div class="col-md-8">
								        	<?= $viewFormFunction->returnDropDownListStatus($form,$model,$modelLid->id_status)?>
								          </div>
								         <?php }?>
							        	<div class="col-md-4">
							        		
								          	<?= Html::submitButton( 'Simpan', ['class' => 'btn btn-primary', 'name'=>'btnSubmit', 'value'=>'simpan','id' => 'btnSimpan']) ?>
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
