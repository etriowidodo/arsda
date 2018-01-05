<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\datecontrol\DateControl;
use \kartik\time\TimePicker;
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
$sqlLokasi="Select distinct inst_lokinst from kepegawaian.kp_inst_satker";
$sqlSaksi="select nama as value, nama_jabatan as text  from pidsus.get_list_saksi_pidsus14_ddl('".$model->id_pds_dik_surat."','saksi')";		
$modelSaksi=Yii::$app->db->createCommand($sqlSaksi)->queryAll();
$sqlAhli="select nama as value, nama_jabatan as text  from pidsus.get_list_saksi_pidsus14_ddl('".$model->id_pds_dik_surat."','ahli')";		
$modelAhli=Yii::$app->db->createCommand($sqlAhli)->queryAll();
?>

<div class="pds-dik-form">

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
												<div class="form-group">
													<label for="nomor_surat" class="control-label col-md-3">Nomor Surat </label>
													<div class="col-md-6"><?= $form->field($model, 'no_surat')->textInput(['readonly' => $readOnly]) ?></div>
												</div>
												
													<?= $viewFormFunction->returnSelect2($sqlSifatSurat,$form,$model,'sifat_surat','Sifat Surat','id_detail','nama_detail','Pilih Sifat Surat ...','sifat_surat','full')?><div class="form-group">
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
																	'autoclose' => true, 'startDate' => $viewFormFunction->getPreviousSuratDate($model), 'endDate' => $_SESSION['todayDate']
																]
															],
															'readonly'=>true,
														])?>
													</div>
												</div>
												<div class="form-group">
													<label for="lampiran" class="control-label col-md-3">Kepada </label>
													<div class="col-md-6"><?= $form->field($model, 'kepada')->textInput(['readonly' => $readOnly]) ?></div>
												</div>

												
											</div>
											<?=$viewFormFunction->returnSuratIsi ($this, $form,$modelSuratIsi)?>
							                

									

									<div class="box box-solid">
							                    <div class="box-header with-border">
							                        
							                        <h3 class="box-title"></h3>
							                    <?php if($model->id_status==434){?>    
							                   <a id="tambah-permintaan-data" class="btn btn-success">Tambah Saksi</a>
							                   <a id="hapus-permintaan-data" class="btn btn-danger">Hapus Saksi</a>
							                   <?php } elseif($model->id_status==435){?>
							                   
							                   <a id="tambah-permintaan-data" class="btn btn-success">Tambah Ahli</a>
							                   <a id="hapus-permintaan-data" class="btn btn-danger">Hapus Ahli</a>
							                   <?php }?>
							                    </div><!-- /.box-header -->
							                    <div class="box-body">   		 
											<div>
							                    <div>
					                            <div id="shown_jpu"></div>
					                            <div id="temp_jpu"></div>
					                            <table id="table_jpu" class="table table-bordered">
			                                    <thead>
			                                        <tr>
			                                        	<th class="col-md-3">Nama Lengkap</th>
														<th class="col-md-3">Alamat</th>
			                                        	<th class="col-md-3">Keterangan</th>
			                                            <th class="col-md-1"></th>
			                                        </tr>
			                                    </thead>
			                                    <tbody id="tbody_jpu">
			                                            <?php foreach ($modelSuratPanggilan as $index=> $value): ?>
			                                                <div><tr id="trpd<?=  $value->id_pds_dik_surat_panggilan ?>">
			                                                	<td><?php if($model->id_status==435) {
			                                                		echo $form->field($value, "[$index]nama_lengkap")->widget(Select2::classname(), [
			                                                				'data' => ArrayHelper::map($modelAhli,'value','text'),
			                                                				'options' => ['placeholder' => 'Pilih Ahli'],
			                                                				'pluginOptions' => [
			                                                						'allowClear' => true
			                                                				],
			                                                		]);
			                                                	}
			                                                	else{
			                                                		echo $form->field($value, "[$index]nama_lengkap")->widget(Select2::classname(), [
			                                                				'data' => ArrayHelper::map($modelSaksi,'value','text'),
			                                                				'options' => ['placeholder' => 'Pilih Saksi'],
			                                                				'pluginOptions' => [
			                                                						'allowClear' => true
			                                                				],
			                                                		]);
			                                                	}
			                                                	?>
			                                                	</td>
																	<td><?= $form->field($value, "[$index]alamat")->textInput(["readonly" => $readOnly]) ?>
																	</td>
			                                                	<td><?= $form->field($value, "[$index]keterangan")->textInput(["readonly" => $readOnly])
																	?>
			                                                	</td>

			                                                	<?php if($readOnly==false){?>
			                                                   	<td><input type="checkbox" name="hapus-pd-check"  value="<?= $value->id_pds_dik_surat_panggilan ?>"></td>
			                                                	<?php }?>
			                                                </tr></div>
			                                            <?php endforeach; ?>
			                                    </tbody>
			                                </table>
			                                 <?php if($readOnly==false){?>
						 					   	
							                   <?php }
							                  if($model->id_status==435) {
							                   $this->registerJs("$(document).ready(function(){
							                   		var x=1;
										        $('#tambah-permintaan-data').click(function(){
							                   			
										                $('#tbody_jpu').append(
										                     	'<tr id=\"trpd'+x+'\">'+
			                                                	'<td>".str_replace("<select","<select class=\"form-control\" ",str_replace("'","\"",preg_replace("/\s+/"," ",$viewFormFunction->returnDropDownListNoFormModel($sqlAhli, 'value', 'text', 'nama_lengkap_sp_insert[]'))))."</td>'+
			                                                	'<td><input type=\"text\" name=\"alamat_sp_insert[]\" class=\"form-control\" \" value=\"\"></td>'+
			                                                	'<td><input type=\"text\" name=\"keterangan_sp_insert[]\" class=\"form-control\" \" value=\"\"></td>'+
							                   					'<td><input type=\"checkbox\" name=\"hapus-pd-check\"  value=\"'+x+'\"></td>'+
																'</tr>'      
							                   			);
							                   		x++;
										            });
										        });
							                   		"
							                   		
							                   		);
							                  }
							                  else {
							                  	$this->registerJs("$(document).ready(function(){
							                   		var x=1;
										        $('#tambah-permintaan-data').click(function(){
							        
										                $('#tbody_jpu').append(
										                     	'<tr id=\"trpd'+x+'\">'+
			                                                	'<td>".str_replace("<select","<select class=\"form-control\" ",str_replace("'","\"",preg_replace("/\s+/"," ",$viewFormFunction->returnDropDownListNoFormModel($sqlSaksi, 'value', 'text', 'nama_lengkap_sp_insert[]'))))."</td>'+
			                                                	'<td><input type=\"text\" name=\"alamat_sp_insert[]\" class=\"form-control\" \" value=\"\"></td>'+
			                                                	'<td><input type=\"text\" name=\"keterangan_sp_insert[]\" class=\"form-control\" \" value=\"\"></td>'+
							                   					'<td><input type=\"checkbox\" name=\"hapus-pd-check\"  value=\"'+x+'\"></td>'+
																'</tr>'
							                   			);
							                   		x++;
										            });
										        });
							                   		"
							                  	
							                  	);
							                  }
							                   ?>      		
					                            </div>
					                            
					                        </div>           		
					                        </div></div>
					               <?=$viewFormFunction->returnSelect2($sqlPenandatangan,$form,$model,'id_ttd','Penandatangan','id_penandatangan','nama_penandatangan','Pilih Penandatangan ...','penandatangan','full')?>
					                 </br>
						        	<div>
						        	              
							        	<div class="col-md-6">
								        	<?php //$viewFormFunction->returnDropDownListStatus($form,$model,$modelLid->id_status)?>
								          </div>
							        	<div class="col-md-1" style="align: right;">
							        		
								          	<?= Html::submitButton( 'Simpan', ['class' => 'btn btn-primary', 'name'=>'btnSubmit', 'value'=>'simpan','id' => 'btnSimpan']) ?>
								        </div>
								        
								        <div class="col-md-1">	        		
								          	<?=Html::a('Batal', ['index'], ['data-pjax'=>0, 'class' => 'btn btn-danger', 'title'=>'cancel','id' => 'btnCancel']) ?>
						    			 </div>						    			 
						    			  		      		     	
							        	<div class="col-md-1">
								      			<?= Html::submitButton('Cetak', ['data-pjax'=>0, 'class' => 'btn btn-success', 'name'=>'btnCetak', 'id'=>'btnCetak', 'value'=>'p11']) ?>
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
$viewFormFunction->setJs($this,$form,$model,$modelDik);

?>
<script>
function hapusSp(id)
{
   $('#tbody_jpu').append(
       '<input type=\"hidden\" name=\"hapus_sp[]\" value=\"'+id+'\">'
   );

   $('#trpd'+id).remove();
};
	
function hapusSpPop(id)
{
$('#trpd'+id).remove();
};
$(document).ready(function(){
	$('#hapus-permintaan-data').click(function(){
		bootbox.dialog({
            message: "Apakah anda yakin akan menghapus saksi/ahli yang dipilih?",
            buttons:{
                ya : {
                    label: "Ya",
                    className: "btn-warning",
                    callback: function(){
                    	var checkboxes = document.getElementsByName('hapus-pd-check');	
            			var deleteSaksiList =[];
                		for (var i=0, n=checkboxes.length;i<n;i++) {		
                		  if (checkboxes[i].checked) 
                		  {
                			deleteSaksiList.push(checkboxes[i].value);
                		  }
                		}
                			for(var i=0;i<deleteSaksiList.length;i++){
                				 $('#tbody_jpu').append(
                					       '<input type=\"hidden\" name=\"hapus_sp[]\" value=\"'+deleteSaksiList[i]+'\">'
                					   );

                					   $('#trpd'+deleteSaksiList[i]).remove();
                		}
                    }
                },
                tidak : {
                    label: "Tidak",
                    className: "btn-warning",
                    callback: function(result){
                    }
                },
            },
        });	
	
		});
});		
</script>
