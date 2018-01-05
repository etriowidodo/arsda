<?php

use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use kartik\widgets\Select2;
use kartik\time\TimePicker;

require('..\modules\pidsus\controllers\viewFormFunction.php');
$viewFormFunction=new viewFormFunction();
$idSatker=$_SESSION['idSatkerUser'];
/* @var $this yii\web\View */
/* @var $model app\models\PdsLid */
/* @var $form yii\widgets\ActiveForm */

$sqlLokasi="Select distinct inst_lokinst from kepegawaian.kp_inst_satker";
$sqlPenerimaSurat="select nama_detail as kepada, no_urut as ORDERNO from pidsus.parameter_detail where id_header =48";
$sqlPenandatangan="select peg_nik id_penandatangan,peg_nama nama_penandatangan,id_nip_jaksa from pidsus.get_jaksa_p8dik('".$model->id_pds_dik_surat."')";
$sqlSifatSurat="select id_detail, nama_detail from pidsus.parameter_detail where id_header=10 order by no_urut";
$sqlTersangka ="select * from pidsus.get_list_tersangka_ddl('".$model->id_pds_dik_surat."')";
$modelTersangka=Yii::$app->db->createCommand($sqlTersangka)->queryAll();
$modelJenisPermintaanData=Yii::$app->db->createCommand("select * from pidsus.get_jenisPermintaanData() order by value")->queryAll();

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
							                    	 <?= $viewFormFunction->returnSelect2($sqlPenerimaSurat,$form,$model,'kepada','Kepada','kepada','kepada','Pilih Penerima ...','kepada','full')?>	
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
					                                <div class="form-group">
													  <label for="lampiran" class="control-label col-md-3">Perihal </label>
													  <div class="col-md-6"><?= $form->field($model, 'perihal_lap')->textArea(array('maxlength' => 4000, 'rows' => 3, 'cols' => 50,'readonly' => $readOnly)) ?></div>
													</div>   													
					                              
												  
					                            
												</div>
							                </div>
											<div>
							                    <div>
							                    <div class="box box-solid">
							                   
					                            <?=$viewFormFunction->returnSuratIsi ($this, $form,$modelSuratIsi)?>        		
					                            
					                          
					                            											<div>
							                    <div>
					                            <div id="shown_jpu"></div>
					                            <div id="temp_jpu"></div>
					                            <table id="table_jpu" class="table table-bordered">
			                                    <thead>
			                                        <tr>
			                                        	<th width="200">Nama</th>
			                                        	<th width="200">Jabatan</th>
			                                            <th width="200">Waktu Pelaksanaan</th>
			                                            <th width="270">Jaksa Yang Melaksanakan</th>
			                                            <th width="200">Keperluan</th>
			                                            <th width="50"></th>
			                                        </tr>
			                                    </thead>
			                                    <tbody id="tbody_jpu">
			                                            <?php foreach ($modelPermintaanData as $index=> $value): ?>
			                                                <div><tr id="trpd<?=  $value->id_pds_dik_usulan_permintaan_data ?>">
			                                                	<td><?php 
			                                                		if($model->id_status!=431){
			                                                			echo $form->field($value, "[$index]nama")->textInput(["readonly" => $readOnly]);
			                                                		}
																	else{
																		echo $form->field($value, "[$index]nama")->widget(Select2::classname(), [
																			'data' => ArrayHelper::map($modelTersangka,'nama_tersangka','nama_tersangka'),
																			'options' => ['placeholder' => 'Pilih tersangka'],
																			'pluginOptions' => [
																			'allowClear' => true
																			],
																			]);
																	}
			                                                		?>
			                                                	<td><?= $form->field($value, "[$index]jabatan_nama")->textInput(["readonly" => $readOnly]) ?>
			                                                	</td>
			                                                    <td><?= $form->field($value, "[$index]waktu_pelaksanaan")->textInput(["readonly" => $readOnly]) ?>
			                                                	</td>
			                                                    
			                                                    <td>
																		<?= $form->field($value, "[$index]jaksa_pelaksanaan")->widget(Select2::classname(), [
																			'data' => ArrayHelper::map($modelJaksa,'peg_nik','peg_nama'),
																			'options' => ['placeholder' => 'Pilih jaksa'],
																			'pluginOptions' => [
																			'allowClear' => true
																			],
																			]);?>
			                                                    </td>
																<td><?= $form->field($value, "[$index]keperluan")->widget(Select2::classname(), [
																			'data' => ArrayHelper::map($modelJenisPermintaanData,'value','text'),
																			'options' => ['placeholder' => ''],
																			'pluginOptions' => [
																			'allowClear' => true
																			],
																			]);?>
			                                                	</td>
			                                                   <?php if($readOnly==false){?>
			                                                   	<td><a id="btn-hapus-pd" class="btn btn-danger" onclick="hapusPd('<?= $value->id_pds_dik_usulan_permintaan_data ?>')">Hapus</a> </td>
			                                                	<?php }?>
			                                                </tr></div>
			                                            <?php endforeach; ?>
			                                    </tbody>
			                                </table>
			                                 <?php if($readOnly==false){?>
							                   <a id="tambah-permintaan-data" class="btn btn-success">Tambah Permintaan</a>
						 
							                   <?php }
							                   if($model->id_status!=431){
							                   $this->registerJs("$(document).ready(function(){
							                   		var x=1;
										        $('#tambah-permintaan-data').click(function(){
							                   			
										                $('#tbody_jpu').append(
										                     	'<tr id=\"trpd'+x+'\">'+
			                                                	'<td><input type=\"text\" name=\"nama_pd_insert[]\" class=\"form-control\" \" value=\"\"></td>'+ 
			                                                	'<td><input type=\"text\" name=\"jabatan_pd_insert[]\" class=\"form-control\" \" value=\"\"></td>'+ 
							                   					'<td><input type=\"text\" name=\"waktu_pd_insert[]\" class=\"form-control\" \" value=\"\" ></td>'+ 
			                                                    '<td>'+ 
			                                                    '". str_replace("<select","<select class=\"form-control\" ",str_replace("'","\"",preg_replace("/\s+/"," ",
			                                                    		Html::dropDownList('jaksa_pd_insert[]',null,ArrayHelper::map($modelJaksa,'peg_nik','peg_nama'))))) ."'+ 
			                                                    '</td>'+ 
			                                                    '<td>".str_replace("<select","<select class=\"form-control\" ",str_replace("'","\"",preg_replace("/\s+/"," ",$viewFormFunction->returnDropDownListNoFormModel("select * from pidsus.get_jenisPermintaanData() order by value",'value','text','keperluan_pd_insert[]'))))."</td>'+			                                                    
			                                                	'<td><a id=\"btn-hapus-jpu\" class=\"btn btn-danger\" onclick=\"hapusPdPop(\''+x+'\')\">Hapus</a> </td>'+ 
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
			                                                	'<td>".str_replace("<select","<select class=\"form-control\" ",str_replace("'","\"",preg_replace("/\s+/"," ",$viewFormFunction->returnDropDownListNoFormModel($sqlTersangka, 'nama_tersangka', 'nama_tersangka', 'nama_pd_insert[]'))))."</td>'+
							                   					
			                                                	'<td><input type=\"text\" name=\"jabatan_pd_insert[]\" class=\"form-control\" \" value=\"\"></td>'+ 
							                   					'<td><input type=\"text\" name=\"waktu_pd_insert[]\" class=\"form-control\" \" value=\"\" ></td>'+
			                                                    '<td>'+
			                                                    '". str_replace("<select","<select class=\"form-control\" ",str_replace("'","\"",preg_replace("/\s+/"," ",
							                   				                                                    		Html::dropDownList('jaksa_pd_insert[]',null,ArrayHelper::map($modelJaksa,'peg_nik','peg_nama'))))) ."'+
			                                                    '</td>'+
			                                                    '<td>".str_replace("<select","<select class=\"form-control\" ",str_replace("'","\"",preg_replace("/\s+/"," ",$viewFormFunction->returnDropDownListNoFormModel("select * from pidsus.get_jenisPermintaanData() order by value",'value','text','keperluan_pd_insert[]'))))."</td>'+
			                                                	'<td><a id=\"btn-hapus-jpu\" class=\"btn btn-danger\" onclick=\"hapusPdPop(\''+x+'\')\">Hapus</a> </td>'+
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
					                       </div>
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
						        		
							        	<div class="col-md-5">
								        	<?php //$viewFormFunction->returnDropDownListStatus($form,$model,$modelLid->id_status)?>
								          </div>
								         
							        	<div class="col-md-1">
							        		
								          	<?= Html::submitButton( 'Simpan', ['class' => 'btn btn-primary', 'name'=>'btnSubmit', 'value'=>'simpan','id' => 'btnSimpan']) ?>
								        </div>
								        
								        <div class="col-md-1">	        		
								          	<?=Html::a('Batal', ['../pidsus/default/viewlaporandik?id='.$model->id_pds_dik], ['data-pjax'=>0, 'class' => 'btn btn-danger', 'title'=>'cancel','id' => 'btnCancel']) ?>
						    			 </div>						    			 
						    			<div class="col-md-1">
								      			<?= Html::submitButton('Cetak', ['data-pjax'=>0, 'class' => 'btn btn-success', 'name'=>'btnCetak', 'id'=>'btnCetak', 'value'=>'pidsus14']) ?>
								      	</div>	
							        </div>
					                        
							            </div></div> </div>
							        </div>
							    </div>
							    <div class="box-footer">
						        </div>    
							</div>
        
		
    <?php ActiveForm::end(); ?>
</div>
</div>

<script>
function hapusPd(id)
{
   $('#tbody_jpu').append(
       '<input type=\"hidden\" name=\"hapus_pd[]\" value=\"'+id+'\">'
   );

   $('#trpd'+id).remove();
};
	
function hapusPdPop(id)
{
$('#trpd'+id).remove();
};
</script>
</div>
