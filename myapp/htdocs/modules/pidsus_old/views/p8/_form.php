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
							                    	<div class="form-group">
					                                    <label for="nomor_surat" class="control-label col-md-3">Nomor Surat </label>
					                                    <div class="col-md-6"><?= $form->field($model, 'no_surat')->textInput(['readonly' => $readOnly]) ?></div>
					                                </div>  
					                               
												<div class="box box-solid">
							                    <div class="box-header with-border">
									                <span class="pull-right"><a class="btn btn-primary" id="popUpJpu"><i class="glyphicon glyphicon-user"></i> Tambah Jaksa Penyelidik</a>&nbsp;<a id="hapus-jpu-check" class="btn btn-danger">Hapus Jaksa Penyelidik</a></span>
									                <h3 class="box-title">
									                    Jaksa
									                </h3>
									            </div>
							                    <div class="box-body">   		 
											<div>
												<div class="col-md-12">
					                            <div id="shown_jpu"></div>
					                            <div id="temp_jpu"></div>
					                            <table id="table_jpu" class="table table-bordered">
			                                    <thead>
			                                        <tr>
			                                            <th class="col-md-2">NIK</th>
			                                            <th>NIP Baru </th>
			                                            <th>Nama</th>
			                                            <th>Jabatan</th>
			                                            <th>Pangkat Jaksa</th>
			                                            <th class="col-md-1">Golongan</th>
			                                            <th></th>
			                                        </tr>
			                                    </thead>
			                                    <tbody id="tbody_jpu">
			                                            <?php foreach ($modelJaksa as $value): ?>
			                                                <tr id="trjpu<?=  $value->id_jaksa ?>">
			                                                    <td><input type="text" name="nip_jpu_update[]" class="form-control" readonly="true" value="<?= $value->id_jaksa ?>"></td>
			                                                    <td><input type="text" name="nip_jpu_update[]" class="form-control" readonly="true" value="<?= $value->pegawai->peg_nip_baru ?>"></td>
			                                                    <td><input type="text" name="nama_jpu_update[]" class="form-control" readonly="true" value="<?= $value->pegawai->peg_nama ?>"></td>
			                                                    <td><input type="text" name="nama_jpu_update[]" class="form-control" readonly="true" value="<?= $value->pegawai->pegJbtakhirstk->ref_jabatan_desc ?>"></td>
			                                                    <td><input type="text" name="nama_jpu_update[]" class="form-control" readonly="true" value="<?= $value->pegawai->golongan->gol_pangkatjaksa ?>"></td>
			                                                    <td><input type="text" name="nama_jpu_update[]" class="form-control" readonly="true" value="<?= $value->pegawai->golongan->gol_kd ?>"></td>
			                                                    <td><input type="checkbox" name="hapusJaksaCheck" value="<?= $value->id_jaksa ?>" > </td>
			                                                </tr>
			                                            <?php endforeach; ?>
			                                    </tbody>
			                                </table>
							                  
							                   <?php 
							                   $this->registerJs(" $(document).ready(function(){
														$('#hapus-jpu-check').click(function(){
														var r = confirm('Apakah anda yakin akan menghapus jaksa yang dipilih?');
													    if (r == true) {
														var checkboxes = document.getElementsByName('hapusJaksaCheck');	
							                   			var deleteJaksaList =[];
														for (var i=0, n=checkboxes.length;i<n;i++) {
							                   			  var checkJaksa=checkboxes[i];		
														  if (checkboxes[i].checked) 
														  {
															$('#tbody_jpu').append(
													       '<input type=\"hidden\" name=\"hapus_jpu[]\" value=\"'+checkboxes[i].value+'\">'
															   );
															deleteJaksaList.push(checkboxes[i].value);
														  }
														}
							                   			for(var i=0;i<deleteJaksaList.length;i++){
							                   				$('#trjpu'+deleteJaksaList[i]).remove();
														}
														var newcheckboxes = document.getElementsByName('hapusNewJaksaCheck');
							                   			var deleteNewJaksaList = [];
														for (var i=0, n=newcheckboxes.length;i<n;i++) {
														  if (newcheckboxes[i].checked) 
														  {		
																
															deleteNewJaksaList.push(newcheckboxes[i].value);
														  }
														}
							                   			for(var i=0;i<deleteNewJaksaList.length;i++){
							                   				$('#trjpu'+deleteNewJaksaList[i]).remove();
														}
														}
															});
											        });
														
											");
							                   ?>      		
					                            </div>
					                        </div>           		
					                        </div></div></br>
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
											<div>
							                    <div>
							                    <div class="box box-solid">
							                   
					                            <?=$viewFormFunction->returnSuratIsi ($this, $form,$modelSuratIsi)?>        		
					                            
					                           
					                            <?= $viewFormFunction->returnSelect2($sqlPenandatangan,$form,$model,'id_ttd','Penandatangan','id_penandatangan','nama_penandatangan','Pilih Penandatangan ...','penandatangan','full')?>	
												</div>
					                        </div></div> 
					                         <div class="box box-solid">
							                    <div class="box-header with-border">
							                        
							                        <h3 class="box-title">Tembusan :</h3>
							                    </div><!-- /.box-header -->
							                    <div class="box-body">   		 
											<div>
							                    <div>
					                            <?=$viewFormFunction->returnTembusanDynamic ($form,$modelTembusan,$this,'lid')?>
					                             
								                		
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
								          	<?=Html::a('Batal', ['../pidsus/default/viewlaporan?id='.$model->id_pds_lid], ['data-pjax'=>0, 'class' => 'btn btn-danger', 'title'=>'cancel','id' => 'btnCancel']) ?>
						    			 </div>						    			 
						    			  <div class="col-md-1"><input type="hidden" id="hdnIdPdsLidSurat" value="<?= $model->id_pds_lid_surat ?>"/><a class="btn btn-danger" id="hapus-surat-lid"> Hapus</a></div>		      		     	
							        	<div class="col-md-1">
								      			<?= Html::submitButton('Cetak', ['data-pjax'=>0, 'class' => 'btn btn-success', 'name'=>'btnCetak', 'id'=>'btnCetak', 'value'=>'pidsus2']) ?>
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
        $('#m_jpu').load('/pidsus/p8/jpu');
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
</div>
