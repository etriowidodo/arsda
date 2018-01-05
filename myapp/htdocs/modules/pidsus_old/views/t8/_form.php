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
							                    <div>
							                    	<div class="form-group">
					                                    <label for="nomor_surat" class="control-label col-md-3">Nomor Surat </label>
					                                    <div class="col-md-6"><?= $form->field($model, 'no_surat')->textInput(['readonly' => $readOnly]) ?></div>
					                                    
					                                </div>  
					                                		
							                </div>
											<div>
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
																			<td><a id="btn-hapus-jpu" class="btn btn-danger" onclick="hapusJpu('<?= $value->id_jaksa ?>')">Hapus</a> </td>
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
													</div></div>
							                    <div>


							                    <div class="box box-solid">



													<?=$viewFormFunction->returnSuratIsi ($this, $form,$modelSuratIsi)?>
												<?=str_replace('$noPdsDik',$modelDik->no_spdp,str_replace('$tglPdsDik',$tglLap->format('d-M-Y'),$viewFormFunction->returnDetailFullDik3 ($form,$modelSuratDetail,$this,'t8')))?>
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
					                            <?= $viewFormFunction->returnSelect2($sqlPenandatangan,$form,$model,'id_ttd','Penandatangan','id_penandatangan','nama_penandatangan','Pilih Penandatangan ...','penandatangan','full')?>	
					                        </div></div></div>
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
							        		
								          	<?= Html::submitButton( 'Simpan', ['class' => 'btn btn-primary', 'name'=>'btnSubmit', 'value'=>'simpan']) ?>
								        </div>
								        
								        <div class="col-md-1">	        		
								          	<?=Html::a('Batal', ['../pidsus/t8'], ['data-pjax'=>0, 'class' => 'btn btn-danger', 'title'=>'cancel']) ?>
						    			 </div>						    			 
						    			  		      		     	
							        	<div class="col-md-1">
								      			<?= Html::submitButton('Cetak', ['data-pjax'=>0, 'class' => 'btn btn-success', 'name'=>'btnCetak', 'value'=>'t8']) ?>
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
	   </script>

</div>
