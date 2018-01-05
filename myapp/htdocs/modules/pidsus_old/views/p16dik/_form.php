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
$sqlPenerimaSurat="select * from pidsus.get_penerima_laporan ('".$idSatker."') order by nama_penerima_lap";
$sqlPenandatangan="select * from pidsus.get_penandatangan	('".$idSatker."','".$model->id_jenis_surat."') order by id_penandatangan";
$sqlSifatSurat="select id_detail, nama_detail from pidsus.parameter_detail where id_header=10 order by no_urut";

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
							                    <div class="row">
								                <div class="col-md-12">
								                	
							                    	<div class="form-group">
					                                    <label for="nomor_surat" class="control-label col-md-3">Nomor Surat </label>
					                                    <div class="col-md-6"><?= $form->field($model, 'no_surat')->textInput(['readonly' => $readOnly]) ?></div>
					                                </div> 
					                                </div>
					                            </div>
					                            <div class="box box-solid">
													<div class="box-header with-border">
							
													<h3 class="box-title">Tersangka</h3>
													</div> 
					                            <div class="row">
								                <div class="col-md-12">
								                	
					                                
								                    <div class="form-group">
								                        <label class="control-label col-md-3">Nama</label>
								                        <div class="col-md-6">
								                            <?php echo $form->field($modelTersangka, 'nama_tersangka'); ?>
								                        </div>
								                    </div>
								                </div>
								            </div>
								
								            <div class="row">
								                <div class="col-md-12">
								                    <div class="form-group">
								                        <label class="control-label col-md-3">Tempat & Tgl Lahir</label>
								                        <div class="col-md-3">
								                            <?php echo $form->field($modelTersangka, 'tempat_lahir'); ?>
								                        </div>
								                        <div class="col-md-3">
								                            <?php
								                            echo $form->field($modelTersangka, 'tgl_lahir')->widget(DateControl::className(), [
								                                'type' => DateControl::FORMAT_DATE,
								                                'ajaxConversion' => false,
								                                'options' => [
								                                    'pluginOptions' => [
								                                        'autoclose' => true, 'startDate' => $viewFormFunction->getPreviousSuratDate($model), 'endDate' => $_SESSION['todayDate']
								                                    ]
								                                ]
								                            ]);
								                            ?>
								                        </div>
								                    </div>
								                </div>
								            </div>
								
								            <div class="row">
								
												<div class="col-md-12">
								                    <div class="form-group">
								                        <label class="control-label col-md-3">Identitas & No</label>
								                        <div class="col-md-3">
								                            <?= $viewFormFunction->returnSelect2ParameterDetail($form,$modelTersangka,'jenis_id','Jenis Identitas',67,'')?>
								                        </div>
								                        <div class="col-md-3">
								                            <?php echo $form->field($modelTersangka, 'nomor_id') ?>
								                        </div>
								                    </div>
								                
								                </div>
								
								
								            </div>
								
								            <div class="row">
								
								                <div class="col-md-12">
								                    <div class="form-group">
								                        <label class="control-label col-md-3">Jenis Kelamin</label>
								                        <div class="col-md-3">
								                            <?= $viewFormFunction->returnSelect2ParameterDetail($form,$modelTersangka,'jenis_kelamin','Jenis Kelamin',5,'')?>
								                        </div>
								                        <label class="control-label col-md-1">Agama</label>
								                        <div class="col-md-2">
								                            <?= $viewFormFunction->returnSelect2ParameterDetail($form,$modelTersangka,'agama','Agama',4,'')?>
								                        </div>
								                    </div>
								                </div>
								
								            </div>
								            <div class="row">
								                <div class="col-md-12">
								                    <div class="form-group">
								                        <label class="control-label col-md-3">Alamat</label>
								                        <div class="col-md-6">
								                            <?php echo $form->field($modelTersangka, 'alamat')->textarea() ?>
								                        </div>
								                    </div>
								                </div>
								            </div>
								
								            <div class="row">
								               
								
								                <div class="col-md-12">
								                    <div class="form-group">
								                        <label class="control-label col-md-3">Pendidikan</label>
								                        <div class="col-md-3">
								                           <?= $viewFormFunction->returnSelect2ParameterDetail($form,$modelTersangka,'pendidikan','Pendidikan',6,'')?>
								                        </div>
								                        <label class="control-label col-md-1">Pekerjaan</label>
								                        <div class="col-md-2">
								                            <?php echo $form->field($modelTersangka, 'pekerjaan') ?>
								                        </div>
								                    </div>
								                </div>
								                
								            </div>
								
								            <div class="row">
								
								                <div class="col-md-12">
								                    <div class="form-group">
								                        <label class="control-label col-md-3">Kewarganegaraan</label>
								                        <div class="col-md-3">
								                            <?php echo $form->field($modelTersangka, 'kewarganegaraan') ?>
								                        </div>
								                    
								                        <label class="control-label col-md-1">Suku</label>
								                        <div class="col-md-2">
								                            <?php echo $form->field($modelTersangka, 'suku') ?>
								                        </div>
								                    </div>
								                </div>
								
								
								            </div>
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
												
												</div>
							                </div>
							                <div class="box box-solid">
							                    <div class="box-header with-border">
									                <span class="pull-right"><a class="btn btn-primary" id="popUpJpu"><i class="glyphicon glyphicon-user"></i> Tambah JPU</a></span>
									                <h3 class="box-title">
									                    Jaksa
									                </h3>
									            </div>
							                    <div class="box-body">   		 
											<div>
												<div class="col-md-3"></div>
							                    <div class="col-md-6">
					                            <div id="shown_jpu"></div>
					                            <div id="temp_jpu"></div>
					                            <table id="table_jpu" class="table table-bordered">
			                                    <thead>
			                                        <tr>
			                                            <th>NIK</th>
			                                            <th>Nama</th>
			                                            <th></th>
			                                        </tr>
			                                    </thead>
			                                    <tbody id="tbody_jpu">
			                                            <?php foreach ($modelJaksa as $value): ?>
			                                                <tr id="trjpu<?=  $value->id_jaksa ?>">
			                                                    <td><input type="text" name="nip_jpu_update[]" class="form-control" readonly="true" value="<?= $value->id_jaksa ?>"></td>
			                                                    <td><input type="text" name="nama_jpu_update[]" class="form-control" readonly="true" value="<?= $value->pegawai->peg_nama ?>"></td>
			                                                    <td><a id="btn-hapus-jpu" class="btn btn-danger" onclick="hapusJpu('<?= $value->id_jaksa ?>')">Hapus</a> </td>
			                                                </tr>
			                                            <?php endforeach; ?>
			                                    </tbody>
			                                </table>
							                  
							                   <?php 
							                   $this->registerJs("$(document).ready(function(){
										        $('#tambah-jaksa').click(function(){
													if($('#select_jaksa').val()!=''){
										                $('#tbody_jpu').append(
										                     '<tr id=\"trjpu'+$('#select_jaksa').val()+'\">' +
										                        '<td><input type=\"text\" class=\"form-control\" name=\"nip_jpu[]\" readonly=\"true\" value=\"'+$('#select_jaksa').val()+'\"> </td>' +
										                        '<td><input type=\"text\" class=\"form-control\" name=\"nama_jpu[]\" readonly=\"true\" value=\"'+$('#select_jaksa option:selected').text()+'\"> </td>' +
										                        '<td><a class=\"btn btn-danger\" onclick=\"hapusJpuPop(\''+$('#select_jaksa').val()+'\')\">Hapus</a> </td>' +
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
											<div>
							                    <div>
							                    <div class="box box-solid">
							                    
					                            <?=$viewFormFunction->returnSuratIsi ($this, $form,$modelSuratIsi)?>        		
					                            
					                         	
					                            <?= $viewFormFunction->returnSelect2($sqlPenandatangan,$form,$model,'id_ttd','Penandatangan','id_penandatangan','nama_penandatangan','Pilih Penandatangan ...','penandatangan','full')?>	
					                      </div>  </div></div> 
					                      	
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
						        		
							        	<div class="col-md-6">
								        	<?php //$viewFormFunction->returnDropDownListStatus($form,$model,$modelLid->id_status)?>
								          </div>
								         
							        	<div class="col-md-1">
							        		
								          	<?= Html::submitButton( 'Simpan', ['class' => 'btn btn-primary', 'name'=>'btnSubmit', 'value'=>'simpan','id' => 'btnSimpan']) ?>
								        </div>
								        
								        <div class="col-md-1">	        		
								          	<?=Html::a('Batal', ['../pidsus/default/viewlaporandik?id='.$model->id_pds_dik], ['data-pjax'=>0, 'class' => 'btn btn-danger', 'title'=>'cancel','id' => 'btnCancel']) ?>
						    			 </div>						    			 
						    			  		      		     	
							        	<div class="col-md-1">
								      			<?= Html::submitButton('Cetak', ['data-pjax'=>0, 'class' => 'btn btn-success', 'name'=>'btnCetak', 'id'=>'btnCetak', 'value'=>'pidsus13']) ?>
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

<?php
$script1 = <<< JS
	$('#popUpJpu').click(function(){
		$('#m_jpu').html('');
        $('#m_jpu').load('/pidsus/p15/jpu');
        $('#m_jpu').modal('show');
	});
JS;
$this->registerJs($script1);
Modal::begin([
    'id' => 'm_jpu',
    'header' => '<h7>Tambah JPU</h7>'
]);
Modal::end();
?>
