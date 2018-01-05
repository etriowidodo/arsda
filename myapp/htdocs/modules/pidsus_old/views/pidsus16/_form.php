<?php

use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;

use yii\bootstrap\Modal;

require('..\modules\pidsus\controllers\viewFormFunction.php');
$viewFormFunction=new viewFormFunction();
$idSatker=$_SESSION['idSatkerUser'];
/* @var $this yii\web\View */
/* @var $model app\models\PdsLid */
/* @var $form yii\widgets\ActiveForm */

$sqlLokasi="Select distinct inst_lokinst from kepegawaian.kp_inst_satker";
$sqlPenerimaSurat="select * from pidsus.get_penerima_laporan ('".$idSatker."') order by nama_penerima_lap";
$sqlPenandatangan="select peg_nik id_penandatangan, peg_nama nama_penandatangan from pidsus.get_jaksa_p8dik	('".$model->id_pds_dik_surat."') order by peg_nama";
$sqlSifatSurat="select id_detail, nama_detail from pidsus.parameter_detail where id_header=10 order by no_urut";
$sqlKepada="select id_detail, nama_detail from pidsus.parameter_detail where id_header=131 order by no_urut";
/*)$sqlPerihal="SELECT 'Pemberitahuan dan permintaan persetujuan lelang benda sitaan/barang bukti yang lekas rusak' AS perihal,
 0 AS ORDERNO UNION SELECT 'Pemberitahuan dan permintaan persetujuan lelang benda sitaan/barang bukti yang membahayakan',
 1  UNION SELECT 'Pemberitahuan dan permintaan persetujuan lelang benda sitaan/barang bukti yang berbiaya tinggi',2 
 ORDER BY ORDERNO";*/

$tglLap=new datetime($modelDik->tgl_spdp);
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
							        				<?= $viewFormFunction->returnSelect2($sqlKepada,$form,$model,'kepada','Kepada','nama_detail','nama_detail','','kepada','full')?>
													
													<div class="form-group">
														<label for="no_surat" class="control-label col-md-3">Lampiran </label>
														<div class="col-md-6"><?= $form->field($model, 'lampiran_surat')->textInput(['readonly' => $readOnly]) ?></div>
													</div>
													<div class="form-group">
														<label for="lampiran" class="control-label col-md-3">Tanggal  </label>
														<div class="col-md-6"><?=
															$form->field($model, 'tgl_surat')->widget(DateControl::classname(), [
																'type'=>DateControl::FORMAT_DATE,
																'ajaxConversion'=>false,
																'options' => [
																	'pluginOptions' => [
																		'autoclose' => true, 'startDate' => $_SESSION['globalStartDate'], 'endDate' => $_SESSION['todayDate']
																	]
																],
																'readonly'=>true,
															])?>
														</div>
													</div>
													<div class="form-group">
														<label for="lampiran" class="control-label col-md-3">Perihal </label>
														<div class="col-md-6"><?= $form->field($model, 'perihal_lap')->textArea(array('maxlength' => 4000, 'rows' => 3, 'cols' => 50,'readonly' => $readOnly)) ?></div>
													</div>
													<div class="box box-primary" style="border-color: #f39c12">
												<div class="box-header with-border" style="border-color: #c7c7c7;">
													<div class="col-md-6" style="padding: 0px;">
														<h3 class="box-title"> <a class="btn btn-primary" id="tambah_target_pemanggilan"><i
																	class="glyphicon glyphicon-plus"></i> Tambah Objek/ Subjek Geledah</a>&nbsp;&nbsp;&nbsp;<a id="hapus-tp-check" class="btn btn-danger">Hapus Objek/ Subjek Geledah</a></h3>
													</div>



												</div>
												<div class="box-header with-border">
													<table id="table_target_pemanggilan" class="table table-bordered">
														<thead>
														<tr>
															<th>No </th>
															<th>Subyek/Obyek </th>
															<th>Jaksa Yang Melaksanakan dan Waktu Pelaksanaan</th>
															<th>Keperluan</th>
															<th>Keterangan</th>
															<th></th>
														</tr>
														</thead>
														<tbody id="tbody_tp">

														<?php
														if ($modelPemanggilan != null) {
															foreach ($modelPemanggilan as $key => $value) {
																echo "<tr id='tr_id_panggil".$value['id_pds_dik_surat_target_pemanggilan']."' ondblclick='editTargetPemanggilan(\"".$value['id_pds_dik_surat_target_pemanggilan']."\")'>
                                <td>" .$value['no_urut']."</td>
								<td>" . $value['nama_jabatan'] . $value['tempat_lokasi'] . "</td>
								<td>".$value->pegawai['peg_nama']." ".$value['waktu_pelaksanaan']."</td>
								<td>".$value['keperluan']."</td>
								<td>".$value['keterangan']."</td>
                                <td><input type='checkbox' name='hapusTargetPemanggilanCheck' value='".$value['id_pds_dik_surat_target_pemanggilan']."' ></td>
                              </tr>";

															}
														}
														?>
														 <?php 
							                   $this->registerJs(" $(document).ready(function(){
							                   			$('#tambah_target_pemanggilan').click(function(){
												            $('#m_target_pemanggilan').html('');
												            $('#m_target_pemanggilan').load('/pidsus/pidsus16/showtargetpemanggilan');
												            $('#m_target_pemanggilan').modal('show');
												        });
														$('#hapus-tp-check').click(function(){
							                   			
														bootbox.dialog({
										                message: \"Apakah anda ingin menghapus target pemanggilan yang dipilih?\",
										                buttons:{
										                    ya : {
										                        label: \"Ya\",
										                        className: \"btn-warning\",
										                        callback: function(){
																	var checkboxes = document.getElementsByName('hapusTargetPemanggilanCheck');	
																                   			var deleteTargetPemanggilanList =[];
																							for (var i=0, n=checkboxes.length;i<n;i++) {
																                   			  var checkTargetPemanggilan=checkboxes[i];		
																							  if (checkboxes[i].checked) 
																							  {
																								$('#tbody_jpu').append(
																						       '<input type=\"hidden\" name=\"hapus_target_pemanggilan[]\" value=\"'+checkboxes[i].value+'\">'
																								   );
																								deleteTargetPemanggilanList.push(checkboxes[i].value);
																							  }
																							}
																                   			for(var i=0;i<deleteTargetPemanggilanList.length;i++){
																                   				$.get('deletetargetpemanggilan?id='+deleteTargetPemanggilanList[i]);
																                   				$('#tr_id_panggil'+deleteTargetPemanggilanList[i]).remove();
																							}
										                        }
										                    },
										                    tidak : {
										                        label: \"Tidak\",
										                        className: \"btn-warning\",
										                        callback: function(result){
										                        }
										                    },
										                },
										            });
															});
											        });
														
											");
							                   ?> 	
														</tbody>
													</table>
												</div>
											</div>
											
											<div class="box box-primary" style="border-color: #f39c12">
												<div class="box-header with-border" style="border-color: #c7c7c7;">
													<div class="col-md-6" style="padding: 0px;">
														<h3 class="box-title"> <a class="btn btn-primary" id="tambah_penyitaan"><i
																	class="glyphicon glyphicon-plus"></i> Tambah Item yang Disita</a>&nbsp;&nbsp;&nbsp;<a id="hapus-sita-check" class="btn btn-danger">Hapus Item yang Disita</a></h3>
													</div>



												</div>
												<div class="box-header with-border">
													<table id="table_tersangka" class="table table-bordered">
														<thead>
														<tr>
															<th>No </th>
															<th>Item </th>
															<th>Disita Dari dan Tempat Penyitaan </th>
															<th>Jaksa Yang Melaksanakan dan Waktu Pelaksanaan</th>
															<th>Keperluan</th>
															<th>Keterangan</th>
															<th></th>
														</tr>
														</thead>
														<tbody id="tbody_sita">

														<?php
														if ($modelPenyitaan != null) {
															foreach ($modelPenyitaan as $key => $value) {
																echo "<tr id='tr_id_sita".$value['id_pds_dik_surat_penyitaan']."' ondblclick='editPenyitaan(\"".$value['id_pds_dik_surat_penyitaan']."\")'>
                                <td>" .$value['no_urut']."</td>
								<td>" . $value['nama_jabatan'] . $value['tempat_lokasi'] . "</td>
								<td>" . $value['dari_dan_tempat']. "</td>
								<td>".$value->pegawai['peg_nama']." ".$value['waktu_pelaksanaan']."</td>
								<td>".$value['keperluan']."</td>
								<td>".$value['keterangan']."</td>
                                <td><input type='checkbox' name='hapusPenyitaanCheck' value='".$value['id_pds_dik_surat_penyitaan']."' ></td>
                              </tr>";

															}
														}
														?>
														 <?php 
							                   $this->registerJs(" $(document).ready(function(){
							                   			$('#tambah_penyitaan').click(function(){
												            $('#m_penyitaan').html('');
												            $('#m_penyitaan').load('/pidsus/pidsus16/showpenyitaan');
												            $('#m_penyitaan').modal('show');
												        });
														$('#hapus-sita-check').click(function(){
							                   			
														bootbox.dialog({
										                message: \"Apakah anda ingin menghapus item sitaan yang dipilih?\",
										                buttons:{
										                    ya : {
										                        label: \"Ya\",
										                        className: \"btn-warning\",
										                        callback: function(){
																	var checkboxes = document.getElementsByName('hapusPenyitaanCheck');	
																                   			var deletePenyitaanList =[];
																							for (var i=0, n=checkboxes.length;i<n;i++) {
																                   			  var checkPenyitaan=checkboxes[i];		
																							  if (checkboxes[i].checked) 
																							  {
																								$('#tbody_jpu').append(
																						       '<input type=\"hidden\" name=\"hapus_penyitaan[]\" value=\"'+checkboxes[i].value+'\">'
																								   );
																								deletePenyitaanList.push(checkboxes[i].value);
																							  }
																							}
																                   			for(var i=0;i<deletePenyitaanList.length;i++){
																                   				$.get('deletepenyitaan?id='+deletePenyitaanList[i]);
																                   				$('#tr_id_sita'+deletePenyitaanList[i]).remove();
																							}
										                        }
										                    },
										                    tidak : {
										                        label: \"Tidak\",
										                        className: \"btn-warning\",
										                        callback: function(result){
										                        }
										                    },
										                },
										            });
															});
											        });
														
											");
							                   ?> 	
														</tbody>
													</table>
												</div>
											</div>
															
											<div>
												<div class="box box-solid">
													<div class="box-header with-border">

													</div><!-- /.box-header -->

							                    <div>


							                    <div class="box box-solid">



													<?=$viewFormFunction->returnSuratIsi ($this, $form,$modelSuratIsi)?>
											
					                            <?= $viewFormFunction->returnSelect2($sqlPenandatangan,$form,$model,'id_ttd','Penandatangan','id_penandatangan','nama_penandatangan','Pilih Penandatangan ...','penandatangan','full')?>	
					                        </div></div></div>
					                         
					                        
						        	<div>
						        		
							        	<div class="col-md-6">
								        	<?php //$viewFormFunction->returnDropDownListStatus($form,$model,$modelLid->id_status)?>
								          </div>
								         
							        	<div class="col-md-1">
							        		
								          	<?= Html::submitButton( 'Simpan', ['class' => 'btn btn-primary', 'name'=>'btnSubmit', 'value'=>'simpan','id' => 'btnSimpan']) ?>
								        </div>
								        
								        <div class="col-md-1">	        		
								          	<?=Html::a('Batal', ['../pidsus/pidsus16'], ['data-pjax'=>0, 'class' => 'btn btn-danger', 'title'=>'cancel','id' => 'btnCancel']) ?>
						    			 </div>						    			 
						    			  		      		     	
							        	<div class="col-md-1">
								      			<?= Html::submitButton('Cetak', ['data-pjax'=>0, 'class' => 'btn btn-success', 'name'=>'btnCetak', 'id'=>'btnCetak', 'value'=>'pidsus16']) ?>
								      	</div>	
							        </div>
					                        
							            </div>
							        </div>
							    </div>
							    <div class="box-footer">
						        </div>    
							</div>
        
		
    <?php ActiveForm::end(); 
    

    Modal::begin([
    		'id' => 'm_target_pemanggilan',
    		'header' => '<h7>Tambah Target Pemanggilan</h7>'
    ]);
    //echo $this->render('_popTersangka', ['modelTersangka' => $modelTersangka]);
    Modal::end();

    Modal::begin([
    		'id' => 'm_penyitaan',
    		'header' => '<h7>Tambah Item Sitaan</h7>'
    ]);
    //echo $this->render('_popTersangka', ['modelTersangka' => $modelTersangka]);
    Modal::end();
    ?>
</div>
</div>


<script>
function editTargetPemanggilan(id)
{
	 $('#m_target_pemanggilan').html('');
     $('#m_target_pemanggilan').load('/pidsus/pidsus16/edittargetpemanggilan?id='+id);
     $('#m_target_pemanggilan').modal('show');
}

function editPenyitaan(id)
{
	 $('#m_penyitaan').html('');
     $('#m_penyitaan').load('/pidsus/pidsus16/editpenyitaan?id='+id);
     $('#m_penyitaan').modal('show');
}
</script>
</div>
