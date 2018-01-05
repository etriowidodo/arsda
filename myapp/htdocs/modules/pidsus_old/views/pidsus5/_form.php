<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\bootstrap\Modal;

require('..\modules\pidsus\controllers\viewFormFunction.php');
$viewFormFunction=new viewFormFunction();
$idSatker=$_SESSION['idSatkerUser'];
/* @var $this yii\web\View */
/* @var $model app\models\PdsLid */
/* @var $form yii\widgets\ActiveForm */

$sqlPenandatangan="select * from pidsus.get_penandatangan	('".$idSatker."','".$model->id_jenis_surat."') order by id_penandatangan";
$sqlSifatSurat="select id_detail, nama_detail from pidsus.parameter_detail where id_header=10 order by no_urut";
$sqlPenerimaSurat="select * from pidsus.pds_lid_usulan_permintaan_data where id_pds_lid_surat in (select id_pds_lid_surat from pidsus.pds_lid_surat where id_jenis_surat='pidsus4' and id_pds_lid ='".$model->id_pds_lid."') order by nama";

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
					                                    <label for="nomor_surat" class="control-label col-md-3">Nomor Surat </label>
					                                    <div class="col-md-6"><?= $form->field($model, 'no_surat')->textInput(['readonly' => $readOnly]) ?></div>
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
					                                    <label for="lokasiSurat" class="control-label col-md-3">Lokasi Surat</label>
					                                    <div class="col-md-6"><?= $form->field($model, 'lokasi_surat')->textInput(['readonly' => $readOnly]) ?></div>
					                                </div>  
													<div class="form-group">
														<label for="tgl_surat" class="control-label col-md-3">Tanggal Surat</label>
														<div class="col-md-6"><?=
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
												<?php if ($model->id_jenis_surat=='pidsus5a') {?>														
												 

															 <?= $viewFormFunction->returnSelect2($sqlPenerimaSurat,$form,$model,'kepada','Penerima Surat','nama','nama','Pilih Penerima Surat ...','nama','full')?>

												<?php }
												 else if ($model->id_jenis_surat=='pidsus5b') {?>														
													<div class="form-group">
															<label for="penerimaSurat" class="control-label col-md-3">Penerima  Surat</label>
															<div class="col-md-6"><?= $form->field($model, 'kepada')->textInput(['readonly' => $readOnly]) ?></div>
													</div> 
												<?php }
												 else if ($model->id_jenis_surat=='pidsus5c') {?>														
													<div class="form-group">
															<label for="penerimaSurat" class="control-label col-md-3">Penerima  Surat</label>
															<div class="col-md-6"><?= $form->field($model, 'kepada')->textInput(['readonly' => $readOnly]) ?></div>
													</div> 
												<?php }?>	 
												<div class="form-group">
					                                    <label for="lokasiPenerima" class="control-label col-md-3">Di</label>
					                                    <div class="col-md-6"><?= $form->field($model, 'kepada_lokasi')->textInput(['readonly' => $readOnly]) ?></div>
					                                </div>
					                             
					                            	<?=$viewFormFunction->returnSuratIsi ($this, $form,$modelSuratIsi)?>  
					                        	
												</div>
							                </div>
							            
					                         <div class="box box-solid">
							                
							                    <div class="box-body">  
					                        <div>
							                    <div>
					                                  		
					                            </div>
					                        </div></div></div>
					       <?php if ($model->id_jenis_surat=='pidsus5b'){?>
					                        	<div class="box box-solid">
							                    <div class="box-header with-border">
							                        
							                        <h3 class="box-title">Target Pemanggilan:</h3>
							                    </div><!-- /.box-header -->
							                    <div class="box-body">   		 
											<div>
												<div class="col-md-3"></div>
							                    <div class="col-md-6">
					                            <div id="shown_jpu"></div>
					                            <div id="temp_jpu"></div>
					                            <table id="table_jpu" class="table table-bordered">
			                                    <thead>
			                                        <tr>
			                                            <th>Nama</th>
			                                            <th></th>
			                                        </tr>
			                                    </thead>
			                                    <tbody id="tbody_jpu">
			                                            <?php foreach ($modelPermintaanData as $value): ?>
			                                                <tr id="trjpu<?=  $value->id_pds_lid_permintaan_data ?>">
			                                                    <td><input type="hidden" name="id_penerima_update[]" class="form-control" readonly="true" value="<?= $value->id_pds_lid_permintaan_data ?>">
			                                                    	<input type="text" name="nama_penerima_update[]" class="form-control" readonly="true" value="<?= $value->nama_tindakan_lain ?>"></td>
			                                                    <td><input type='checkbox' name='hapusPermintaanDataCheck' value='<?= $value->id_pds_lid_permintaan_data ?>' > </td>
			                                                </tr>
			                                            <?php endforeach; ?>
			                                    </tbody>
			                                </table>
							                    <?=
							                    Select2::widget([
							                    		'name' => 'select_pd',
							                    		'id' => 'select_pd',
							                    		'data' => ArrayHelper::map($modelPermintaanData4,'id_pds_lid_usulan_permintaan_data','nama'),
																'options' => ['placeholder' => 'Pilih Individu'],
																'pluginOptions' => [
																'allowClear' => true
																],
							                    ]);
							                   ?> 
											   </br>
							                   <a id="tambah-pd" class="btn btn-success">Tambah Target</a>&nbsp;&nbsp;&nbsp;<a id="hapus-pd" class="btn btn-danger">Hapus Target</a>
						 							
							                   <?php 
							                   $this->registerJs("$(document).ready(function(){
										        $('#tambah-pd').click(function(){
													if($('#select_pd').val()!=''){
										                $('#tbody_jpu').append(
										                     '<tr id=\"trjpu'+$('#select_pd').val()+'\">' +
										                        '<td><input type=\"hidden\" class=\"form-control\" name=\"id_pd_insert[]\" readonly=\"true\" value=\"'+$('#select_pd').val()+'\">' +
										                        '<input type=\"text\" class=\"form-control\" name=\"nama_pd_insert[]\" readonly=\"true\" value=\"'+$('#select_pd option:selected').text()+'\"> </td>' +
										                        '<td><input type=\"checkbox\" name=\"hapusPermintaanDataCheck\" value=\"'+$('#select_pd').val()+'\" > </td>' +
										                    '</tr>'      
							                   			);
														}
										            });
							                   	$('#hapus-pd').click(function(){
														var r = confirm('Apakah anda yakin akan menghapus target pemanggilan yang dipilih?');
													    if (r == true) {
														var checkboxes = document.getElementsByName('hapusPermintaanDataCheck');	
							                   			var deletePermintaanDataList =[];
														for (var i=0, n=checkboxes.length;i<n;i++) {
							                   			  var checkPermintaanData=checkboxes[i];		
														  if (checkboxes[i].checked) 
														  {
															$('#tbody_jpu').append(
													       '<input type=\"hidden\" name=\"hapus_pd[]\" value=\"'+checkboxes[i].value+'\">'
															   );
															deletePermintaanDataList.push(checkboxes[i].value);
														  }
														}
							                   			for(var i=0;i<deletePermintaanDataList.length;i++){
							                   				$('#trjpu'+deletePermintaanDataList[i]).remove();
														}
														
														}
															});
										        });
							                   		
							                   		"
							                   		
							                   		);
							                   ?>      		
					                            </div>
					                        </div>           		
					                        </div></div>
					                
					                        <?php }?>
					                        <?= $viewFormFunction->returnSelect2($sqlPenandatangan,$form,$model,'id_ttd','Penandatangan','id_penandatangan','nama_penandatangan','Pilih Penandatangan ...','penandatangan','full')?>

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
					                        </div></div></br>
					               <div class="box box-solid">
						        	<div>
						        		
							        	<div class="col-md-6"></div>
							        	<div class="col-md-1">
							        		
								          	<?= Html::submitButton( 'Simpan', ['class' => 'btn btn-primary', 'name'=>'btnSubmit', 'value'=>'simpan','id' => 'btnSimpan']) ?>
								        </div>
								        <div class="col-md-1">	        		
								          	<?=Html::a('Batal', ['../pidsus/pidsus5/index'], ['data-pjax'=>0, 'class' => 'btn btn-danger', 'title'=>'cancel','id' => 'btnCancel']) ?>
						    			 </div>
						    			 <div class="col-md-1">
								      			<?= Html::submitButton('Cetak', ['data-pjax'=>0, 'class' => 'btn btn-success', 'name'=>'btnCetak', 'id'=>'btnCetak', 'value'=>'pidsus5']) ?>
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
$js = <<< JS
      
JS;

?>
<script>
function hapusJpu(id)
{
   $('#tbody_jpu').append(
       '<input type=\"hidden\" name=\"hapus_pd[]\" value=\"'+id+'\">'
   );

   $('#trjpu'+id).remove();
};
	
function hapusJpuPop(id)
{
$('#trjpu'+id).remove();
};
</script>
