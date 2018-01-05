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
?>

<script>
function hapusJpu(id)
	{
	   $('#tbody_jpu').append(
		   '<input type="hidden" name="hapus_jpu[]" value="'+id+'">'
	   );

	   $('#trjpu'+id).remove();
	};
		
	function hapusJpuPop(id)
	{
	$('#trjpu'+id).remove();
	};
</script>
<div class="pds-lid-surat-form">

  <div class="pds-lid-form">

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
           
							        <div class="box-body">
							                <div>
							                    <div>
							                    	<div class="form-group">
					                                    <label for="nomor_surat" class="control-label col-md-3">Nomor Surat </label>
					                                    <div class="col-md-6"><?= $form->field($model, 'no_surat')->textInput(['readonly' => $readOnly]) ?></div>
					                                </div>  
								<div class="box box-solid">
										<div class="box-header with-border">

											<h3 class="box-title">Jaksa:</h3>
										</div><!-- /.box-header -->
										<div class="box-body">
											<div>
												<div class="col-md-3"></div>
												<div class="col-md-6">
													<div id="shown_jpu"></div>
													<div id="temp_jpu"></div>
													<?=
													Select2::widget([
														'name' => 'select_jaksa',
														'id' => 'select_jaksa',
														'data' => ArrayHelper::map($modelJaksa,'id_jaksa_fungsional','nama_jaksa_fungsional'),
														'options' => ['placeholder' => 'Pilih Jaksa ...'],
														'pluginOptions' => [
															'allowClear' => true
														],
													]);
													?>
													</br>
													<span class="pull-right"><a id="tambah-jaksa" class="btn btn-success">Tambah Jaksa</a>&nbsp;<a id="hapus-jpu" class="btn btn-danger">Hapus Jaksa</a></span>
													</br></br>
													<table id="table_jpu" class="table table-bordered">
														<thead>
														<tr>
															<th>NIP</th>
															<th>Nama</th>
															<th></th>
														</tr>
														</thead>
														<tbody id="tbody_jpu">
														<?php foreach ($modelSuratJaksa as $value): ?>
															<tr id="trjpu<?=  $value->id_jaksa ?>">
																<td><input type="text" name="nip_jpu_update[]" class="form-control" readonly="true" value="<?= $value->pegawai->peg_nip_baru ?>"></td>
																<td><input type="text" name="nama_jpu_update[]" class="form-control" readonly="true" value="<?= $value->pegawai->peg_nama ?>"></td>
																<td><input type="checkbox" name="hapus-jpu-check" value="<?= $value->id_jaksa ?>"> </td>
															</tr>
														<?php endforeach; ?>
														</tbody>
													</table>
													

													<?php
													$this->registerJs("$(document).ready(function(){
										        $('#tambah-jaksa').click(function(){
													var valueddl =$('#select_jaksa').val();
													var valuetext=$('#select_jaksa option:selected').text();				
													var data = valueddl.split('#');
													var data2 = valuetext.split('(');				
													var element2 =  document.getElementById('trjpu'+data[0]);		
													if(data[0]!='' && element2 == null){
										                $('#tbody_jpu').append(
										                     '<tr id=\"trjpu'+data[0]+'\">' +
										                        '<td><input type=\"hidden\" name=\"nip_jpu[]\" readonly=\"true\" value=\"'+data[0]+'\"><input type=\"text\" class=\"form-control\" name=\"nip_jpu2[]\" readonly=\"true\" value=\"'+data[1]+'\"> </td>' +
										                        '<td><input type=\"text\" class=\"form-control\" name=\"nama_jpu[]\" readonly=\"true\" value=\"'+data2[0]+'\"> </td>' +
										                        '<td><input type=\"checkbox\" name=\"hapus-jpu-check\" value=\"'+data[0]+'\"> </td>' +
										                    '</tr>'
							                   			);
														}
										            });
										        });
							                   		"

													);
													?>
												</div>
											</div>
										</div></div></br>	
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
														<label for="satker" class="control-label col-md-3">Penandatangan </label>
														<div class="col-md-6"><?= $viewFormFunction->returnDropDownList($form,$model,"select * from pidsus.get_penandatangan	('".$idSatker."','".$model->id_jenis_surat."') order by id_penandatangan",'id_penandatangan','nama_penandatangan','id_ttd') ?></div>
												</div>
							                </div>
									
					                       <div>
							                   <div class="box box-solid">
							                    <div class="box-header with-border">
							                        
							                        <h3 class="box-title">Tembusan :</h3>
							                    </div><!-- /.box-header -->
							                    <div class="box-body">   		 
											<div>
							                    <div>
					                            <?=$viewFormFunction->returnTembusanDynamic ($form,$modelTembusan,$this)?>
					                             
								                		
					                            </div>
					                        </div>           		
					                        </div></br>
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
								      			<?= Html::submitButton('Cetak', ['data-pjax'=>0, 'class' => 'btn btn-success', 'name'=>'btnCetak', 'id'=>'btnCetak', 'value'=>'pidsus6']) ?>
								      	</div>	
							        </div>
					               </div>              		
					                        </div></div></br>      
							            </div>
							        </div>
							    <div class="box-footer">
						        </div>    
        					
		
    <?php ActiveForm::end(); ?>

</div></div></div>
