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
$sqlPenandatangan="select * from pidsus.get_penandatangan	('".$idSatker."','".$model->id_jenis_surat."') order by id_penandatangan";
$sqlSifatSurat="select id_detail, nama_detail from pidsus.parameter_detail where id_header=10 order by no_urut";
/*)$sqlPerihal="SELECT 'Pemberitahuan dan permintaan persetujuan lelang benda sitaan/barang bukti yang lekas rusak' AS perihal,
 0 AS ORDERNO UNION SELECT 'Pemberitahuan dan permintaan persetujuan lelang benda sitaan/barang bukti yang membahayakan',
 1  UNION SELECT 'Pemberitahuan dan permintaan persetujuan lelang benda sitaan/barang bukti yang berbiaya tinggi',2 
 ORDER BY ORDERNO";*/
$sqlJaksa=" select * from pidsus.get_jaksa_p8dik('".$model->id_pds_dik_surat."')";

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
											<div>
												<div class="box box-solid">
													<div class="box-header with-border">
														<div class="form-group">
															<label for="lokasiSurat" class="control-label col-md-3">Berita Acara</label>
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
															<div class="col-md-3"><?= $viewFormFunction->returnSelect2($sqlLokasi,$form,$model,'lokasi_surat','Lokasi Penerima Laporan','inst_lokinst','inst_lokinst','Pilih Lokasi ...','lokasi_penerima')?></div>

														</div>
														
														<div class="box box-solid"><h3 class="box-title">Jaksa Penyidik:</h3></div>
														<div class="box-body">
														<div>
															<div class="col-md-3"></div>
															<div class="col-md-6">
																<div id="shown_jpu"></div>
																<div id="temp_jpu"></div>
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
																			<td><input type="text" name="nip_jpu_update[]" class="form-control" readonly="true" value="<?= $value->id_jaksa ?>"></td>
																			<td><input type="text" name="nama_jpu_update[]" class="form-control" readonly="true" value="<?= $value->pegawai->peg_nama ?>"></td>
																			<td><input type="checkbox" name="hapus-jpu-check" value="<?= $value->id_jaksa ?>"> </td>
															
																		</tr>
																	<?php endforeach; ?>
																	</tbody>
																</table>
																<?=
																Select2::widget([
																	'name' => 'select_jaksa',
																	'id' => 'select_jaksa',
																	'data' => ArrayHelper::map($modelJaksa,'peg_nik','peg_nama'),
																	'options' => ['placeholder' => 'Pilih Jaksa ...'],
																	'pluginOptions' => [
																		'allowClear' => true
																	],
																]);
																?>
																</br>
																<a id="tambah-jaksa" class="btn btn-success">Tambah Jaksa</a>
																<a id="hapus-jpu" class="btn btn-danger">Hapus Jaksa</a>

																<?php
																$this->registerJs("$(document).ready(function(){
										        $('#tambah-jaksa').click(function(){
													if($('#select_jaksa').val()!=''){
										                $('#tbody_jpu').append(
										                     '<tr id=\"trjpu'+$('#select_jaksa').val()+'\">' +
										                        '<td><input type=\"text\" class=\"form-control\" name=\"nip_jpu[]\" readonly=\"true\" value=\"'+$('#select_jaksa').val()+'\"> </td>' +
										                        '<td><input type=\"text\" class=\"form-control\" name=\"nama_jpu[]\" readonly=\"true\" value=\"'+$('#select_jaksa option:selected').text()+'\"> </td>' +
										                        '<td><input type=\"checkbox\" name=\"hapus-jpu-check\" value=\"'+$('#select_jaksa').val()+'\"> </td>' +
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
													</div>

														<div class="box box-solid"><h3 class="box-title">Saksi:</h3></div>
											<div class="box-body">
												<div>
													<div class="col-md-3"></div>
													<div class="col-md-6">
														<div id="shown_jsks"></div>
														<div id="temp_jsks"></div>
														<table id="table_jsks" class="table table-bordered">
															<thead>
															<tr>
																<th>NIP</th>
																<th>Nama</th>
																<th></th>
															</tr>
															</thead>
															<tbody id="tbody_jsks">
															<?php foreach ($modelSuratJaksaSaksi as $value): ?>
																<tr id="trjsks<?=  $value->id_jaksa ?>">
																	<td><input type="text" name="nip_jsks_update[]" class="form-control" readonly="true" value="<?= $value->id_jaksa ?>"></td>
																	<td><input type="text" name="nama_jsks_update[]" class="form-control" readonly="true" value="<?= $value->pegawai->peg_nama ?>"></td>
																	<td><input type="checkbox" name="hapus-jsks-check" value="<?= $value->id_jaksa ?>"> </td>
															
																</tr>
															<?php endforeach; ?>
															</tbody>
														</table>
														<?=
														Select2::widget([
															'name' => 'select_jaksa_saksi',
															'id' => 'select_jaksa_saksi',
															'data' => ArrayHelper::map($modelJaksaAll,'peg_nik','peg_nama'),
															'options' => ['placeholder' => 'Pilih Jaksa Saksi ...'],
															'pluginOptions' => [
																'allowClear' => true
															],
														]);
														?>
														</br>
														<a id="tambah-jaksa-saksi" class="btn btn-success">Tambah Jaksa</a>
														<a id="hapus-jsks" class="btn btn-danger">Hapus Jaksa</a>
														<?php
														$this->registerJs("$(document).ready(function(){
										        $('#tambah-jaksa-saksi').click(function(){
													if($('#select_jaksa_saksi').val()!=''){
										                $('#tbody_jsks').append(
										                     '<tr id=\"trjsks'+$('#select_jaksa_saksi').val()+'\">' +
										                        '<td><input type=\"text\" class=\"form-control\" name=\"nip_jsks[]\" readonly=\"true\" value=\"'+$('#select_jaksa_saksi').val()+'\"> </td>' +
										                        '<td><input type=\"text\" class=\"form-control\" name=\"nama_jsks[]\" readonly=\"true\" value=\"'+$('#select_jaksa_saksi option:selected').text()+'\"> </td>' +
										                        '<td><input type=\"checkbox\" name=\"hapus-jsks-check\" value=\"'+$('#select_jaksa_saksi').val()+'\"> </td>' +
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
											</div>
</br></br>
														<?=$viewFormFunction->returnSuratIsi ($this, $form,$modelSuratIsi)?>
													
													<div>
						        		
							        	<div class="col-md-6">

								          </div>
								         
							        	<div class="col-md-1">
							        		<?= Html::submitButton( 'Simpan', ['class' => 'btn btn-primary', 'name'=>'btnSubmit', 'value'=>'simpan','id' => 'btnSimpan'])  ?>
								        </div>
								        
								        <div class="col-md-1">
								          	<?=Html::a('Batal', ['../pidsus/ba17'], ['data-pjax'=>0, 'class' => 'btn btn-danger', 'title'=>'cancel','id' => 'btnCancel']) ?>
						    			 </div>						    			 
						    			  		      		     	
							        	<div class="col-md-1">
								      			<?= Html::submitButton('Cetak', ['data-pjax'=>0, 'class' => 'btn btn-success', 'name'=>'btnCetak', 'id'=>'btnCetak', 'value'=>'ba17']) ?>
								      	</div>	
							        </div>
					                   
													</div><!-- /.body -->
														
													</div>
													
													<!-- /.box-header -->
													


												
											</div><!-- /.box-header -->
											

							                    </div></div>

					                        
						        	     
							            </div>
							        </div>
							    </div>
							       
							</div>
        
		
    <?php ActiveForm::end(); ?>
</div>
</div>
	   <script>

		   function hapusJsks(id)
		   {
			   $('#tbody_jsks').append(
				   '<input type=\"hidden\" name=\"hapus_jsks[]\" value=\"'+id+'\">'
			   );

			   $('#trjsks'+id).remove();
		   };


		   function hapusJsksPop(id)
		   {
			   $('#trjsks'+id).remove();
		   };


		   function hapusJpu(id)
		   {
			   $('#tbody_jpu').append(
				   '<input type=\"hidden\" name=\"hapus_jpu[]\" value=\"'+id+'\">'
			   );

			   $('#trjpu'+id).remove();
		   };
		   function hapusKet(id)
		   {
			   $('#tbody_ket').append(
				   '<input type=\"hidden\" name=\"hapus_ket[]\" value=\"'+id+'\">'
			   );

			   $('#trket'+id).remove();
		   };

		   function hapusJpuPop(id)
		   {
			   $('#trjpu'+id).remove();
		   };

		   $('#hapus-jpu').click(function(){
				var r = confirm('Apakah anda yakin akan menghapus jaksa yang dipilih?');
				var deleteJaksaList=[];
				var deleteNewJaksaList=[];
			    if (r == true) {
				var checkboxes = document.getElementsByName('hapus-jpu-check');	
				for (var i=0, n=checkboxes.length;i<n;i++) {
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
				var newcheckboxes = document.getElementsByName('hapus-jpu-check');
				for (var i=0, n=newcheckboxes.length;i<n;i++) {
				  if (newcheckboxes[i].checked) 
				  {		
						deleteNewJaksaList.push(newcheckboxes[i].value);
				  }
				}
				for (var i=0;i<deleteNewJaksaList.length;i++){
						$('#trjpunew'+deleteNewJaksaList[i]).remove();
				}
			}});

		   $('#hapus-jsks').click(function(){
				var r = confirm('Apakah anda yakin akan menghapus jaksa yang dipilih?');
				var deleteJaksaList=[];
				var deleteNewJaksaList=[];
			    if (r == true) {
				var checkboxes = document.getElementsByName('hapus-jsks-check');	
				for (var i=0, n=checkboxes.length;i<n;i++) {
				  if (checkboxes[i].checked) 
				  {
					$('#tbody_jpu').append(
			       '<input type=\"hidden\" name=\"hapus_jsks[]\" value=\"'+checkboxes[i].value+'\">'
					   );
					deleteJaksaList.push(checkboxes[i].value);
				  }
				}
				for(var i=0;i<deleteJaksaList.length;i++){
					   $('#trjsks'+deleteJaksaList[i]).remove();
				}
				var newcheckboxes = document.getElementsByName('hapus-jsks-check');
				for (var i=0, n=newcheckboxes.length;i<n;i++) {
				  if (newcheckboxes[i].checked) 
				  {		
						deleteNewJaksaList.push(newcheckboxes[i].value);
				  }
				}
				for (var i=0;i<deleteNewJaksaList.length;i++){
						$('#trjsks'+deleteNewJaksaList[i]).remove();
				}
			}});
	   </script>

</div>
