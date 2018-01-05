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
					                                <?= $viewFormFunction->returnSelect2($sqlSifatSurat,$form,$model,'sifat_surat','Sifat Surat','id_detail','nama_detail','Pilih Sifat Surat ...','sifat_surat','full')?>		
					                                <div class="form-group">
					                                    <label for="no_surat" class="control-label col-md-3">Lampiran </label>
					                                    <div class="col-md-6"><?= $form->field($model, 'lampiran_surat')->textInput(['readonly' => $readOnly]) ?></div>
					                                </div> 
					                                <div class="form-group">
													  <label for="lampiran" class="control-label col-md-3">Perihal </label>
													  <div class="col-md-6"><?= $form->field($model, 'perihal_lap')->textArea(array('maxlength' => 4000, 'rows' => 6, 'cols' => 50,'readonly' => $readOnly)) ?></div>
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
					                                    <label for="no_surat" class="control-label col-md-3">Kepada Yth. </label>
					                                    <div class="col-md-6"><?= $form->field($model, 'kepada')->textInput(['readonly' => $readOnly]) ?></div>
					                                </div> 
					                             <?= $viewFormFunction->returnSelect2($sqlLokasi,$form,$model,'kepada_lokasi','Di','inst_lokinst','inst_lokinst','Pilih Lokasi ...','lokasiPenerima','full')?>	
												
												</div>
							                </div>
											<div>
							                    <div>
							                    <div class="box box-solid">
							                    
					                            <?=$viewFormFunction->returnSuratIsi ($this, $form,$modelSuratIsi)?>        		
					                            </div>
					                            </br>
					                            <div class="box box-primary" style="border-color: #f39c12">
												<div class="box-header with-border" style="border-color: #c7c7c7;">
													<div class="col-md-6" style="padding: 0px;">
														<h3 class="box-title"> <a class="btn btn-primary" id="tambah_calon_terpanggil"><i
																	class="glyphicon glyphicon-plus"></i> Tambah Target Pemanggilan</a></h3>
													</div>



												</div>
												<div class="box-header with-border">
													<table id="table_terpanggil" class="table table-bordered">
														<thead>
														<tr>
															<th>Nama </th>
															<th>Keterangan</th>
															<th class="col-md-1"></th>
														</tr>
														</thead>
														<tbody id="tbody_tersangka">

														<?php
														if ($modelPanggilan != null) {
															foreach ($modelPanggilan as $key => $value) {
																echo "<tr id='tr_id".$value['id_pds_tut_surat_panggilan']."'>
                                <td>" . $value['nama_terpanggil'] . "</td>
								<td>".$value['keterangan']."</td>
                                <td><span class='glyphicon glyphicon-pencil' onclick='editTersangka(\"".$value['id_pds_tut_surat_panggilan']."\")'></span><a class='btn btn-danger btn-sm glyphicon glyphicon-remove hapus' onclick='hapusTersangka(\"".$value['id_pds_tut_surat_panggilan']."\")'></a></td>
                              </tr>";

															}
														}
														?>

														</tbody>
													</table>
												</div>
											</div>
					                            <?= $viewFormFunction->returnSelect2($sqlPenandatangan,$form,$model,'id_ttd','Penandatangan','id_penandatangan','nama_penandatangan','Pilih Penandatangan ...','penandatangan','full')?>	
					                        </div></div> </br>
					                         <div class="box box-solid">
							                    <div class="box-header with-border">
							                        
							                        <h3 class="box-title">Tembusan :</h3>
							                    </div><!-- /.box-header -->
							                    <div class="box-body">   		 
											<div>
							                    <div>
					                            <?=$viewFormFunction->returnTembusanDynamic ($form,$modelTembusan,$this,'tut')?>
					                             
								                		
					                            </div>
					                        </div>           		
					                        </div></div></br>
					                        
						        	<div>
						        		
							        	<div class="col-md-5">
								        	<?php //$viewFormFunction->returnDropDownListStatus($form,$model,$modelLid->id_status)?>
								          </div>
								         
							        	<div class="col-md-1">
							        		
								          	<?= Html::submitButton( 'Simpan', ['class' => 'btn btn-primary', 'name'=>'btnSubmit', 'value'=>'simpan','id' => 'btnSimpan']) ?>
								        </div>
								        
								        <div class="col-md-1">	        		
								          	<?=Html::a('Batal', ['../pidsus/default/viewlaporantut?id='.$model->id_pds_tut], ['data-pjax'=>0, 'class' => 'btn btn-danger', 'title'=>'cancel','id' => 'btnCancel']) ?>
						    			 </div>						    			 
						    			  <div class="col-md-1"><input type="hidden" id="hdnIdPdsTutSurat" value="<?= $model->id_pds_tut_surat ?>"/><a class="btn btn-danger" id="hapus-surat-tut"> Hapus</a></div>
						    			  		      		     	
							        	<div class="col-md-1">
								      			<?= Html::submitButton('Cetak', ['data-pjax'=>0, 'class' => 'btn btn-success', 'name'=>'btnCetak', 'id'=>'btnCetak', 'value'=>'p38']) ?>
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
<?php
Modal::begin([
	'id' => 'm_terpanggil',
	'header' => '<h7>Tambah Target Pemanggilan</h7>'
]);
//echo $this->render('_popTersangka', ['modelTersangka' => $modelTersangka]);
Modal::end();
?>
<?php
$script = <<< JS
        $('#tambah_calon_terpanggil').click(function(){
            $('#m_terpanggil').html('');
            $('#m_terpanggil').load('/pidsus/p38/show-terpanggil');
            $('#m_terpanggil').modal('show');
        });




JS;
$this->registerJs($script);
?>
<script>
	function hapusTersangka(id)
	{
		if(confirm("Hapus Data Tersangka?")){
			$.get("/pidsus/p38/delete-terpanggil?id="+id);
			$("#tr_id"+id).remove();
			
		}
	}
	function hapusTersangkaOld(id)
	{
		if(confirm("Hapus Data Target Pemanggilan?")){
			$.get("/pidsus/p38/delete-terpanggil?id="+id);
			$("#tr_id"+id).remove();
			
		}
	}
	function editTersangka(id)
	{
		 $('#m_terpanggil').html('');
         $('#m_terpanggil').load('/pidsus/p38/edit-terpanggil?id='+id);
         $('#m_terpanggil').modal('show');
	}	
</script>

