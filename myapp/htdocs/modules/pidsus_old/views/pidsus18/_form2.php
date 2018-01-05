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
					                                													
					                                <div class="form-group">
					                                    <label for="lokasiSurat" class="control-label col-md-3">Dikeluarkan</label>
					                                    <div class="col-md-3"><?= $viewFormFunction->returnSelect2($sqlLokasi,$form,$model,'lokasi_surat','Lokasi Penerima Laporan','inst_lokinst','inst_lokinst','Pilih Lokasi ...','lokasi_penerima')?></div>
					                               		<div class="col-md-3"><?=
					                                             $form->field($model, 'tgl_surat')->widget(DateControl::classname(), [
					                                                'type'=>DateControl::FORMAT_DATE,
					                                                'ajaxConversion'=>false,
					                                                'options' => [
					                                                    'pluginOptions' => [
					                                                        'autoclose' => true
					                                                    ]
					                                                ],
					                                             	'readonly'=>$readOnly,
					                                            ])?>
					                                    </div>
													</div>
												
												</div>
							                </div>
											<div>
							                    <div>
							                    <div class="box box-solid">
							                    
					                            <?=$viewFormFunction->returnSuratIsi ($this, $form,$modelSuratIsi)?>        		
					                            </div>
					                        
					                            	
					                        </div></div>

											<div class="box box-primary" style="border-color: #f39c12">
												<div class="box-header with-border" style="border-color: #c7c7c7;">
													<div class="col-md-6" style="padding: 0px;">
														<h3 class="box-title"> <a class="btn btn-primary" id="tambah_calon_tersangka"><i
																	class="glyphicon glyphicon-plus"></i> Tambah Tersangka</a>&nbsp;<a id="hapus-tersangka-check" class="btn btn-danger">Hapus Tersangka</a></h3>
													</div>



												</div>
												<div class="box-header with-border">
													<table id="table_tersangka" class="table table-bordered">
														<thead>
														<tr>
															<th>Nama</th>
															<th>Nomor Id</th>
															<th></th>
														</tr>
														</thead>
														<tbody id="tbody_tersangka">

														<?php
														if ($modelTersangkaUpdate != null) {
															foreach ($modelTersangkaUpdate as $key => $value) {
																echo "<tr id='tr_id".$value['id_pds_dik_tersangka']."' ondblclick='editTersangka(\"".$value['id_pds_dik_tersangka']."\")'>
                                <td>" . $value['nama_tersangka'] . "</td>
								<td>".$value['nomor_id']."</td>
                                <td><input type='checkbox' name='hapusTersangkaCheck' value='". $value['id_pds_dik_tersangka'] ."' > </td>
								</tr>";

															}
														}
														?>

														</tbody>
													</table>
												</div>
											</div>
											<div id="hiddenId"></div>


					                        <?= $viewFormFunction->returnSelect2($sqlPenandatangan,$form,$model,'id_ttd','Penandatangan','id_penandatangan','nama_penandatangan','Pilih Penandatangan ...','penandatangan','full')?>
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
								          	<?=Html::a('Batal', ['index'], ['data-pjax'=>0, 'class' => 'btn btn-danger', 'title'=>'cancel','id' => 'btnCancel']) ?>
						    			 </div>						    			 
						    			  		      		     	
							        	<div class="col-md-1">
								      			<?= Html::submitButton('Cetak', ['data-pjax'=>0, 'class' => 'btn btn-success', 'name'=>'btnCetak', 'id'=>'btnCetak', 'value'=>'pidsus18']) ?>
								      	</div>	
							        </div>
					                        
							            </div>
							        </div>
							    </div>
							</div>
        
		
    <?php ActiveForm::end(); ?>
</div>
</div>

</div>
<?php
Modal::begin([
	'id' => 'm_tersangka',
	'header' => '<h7>Tambah Tersangka</h7>'
]);
//echo $this->render('_popTersangka', ['modelTersangka' => $modelTersangka]);
Modal::end();
?>

<?php
$script = <<< JS
        $('#tambah_calon_tersangka').click(function(){
            $('#m_tersangka').html('');
            $('#m_tersangka').load('/pidsus/pidsus18/show-tersangka');
            $('#m_tersangka').modal('show');
        });




JS;
$this->registerJs($script);
?>
<script>
	function hapusTersangka(id)
	{
		if(confirm("Hapus Data Tersangka?")){
			$.get("delete-tersangka?id="+id);
			$("#tr_id"+id).remove();
			
		}
	}
	function hapusTersangkaOld(id)
	{
		if(confirm("Hapus Data Tersangka?")){
			$.get("delete-tersangka?id="+id);
			$("#tr_id"+id).remove();
			
		}
	}
	function editTersangka(id)
	{
		 $('#m_tersangka').html('');
         $('#m_tersangka').load('/pidsus/pidsus18/edit-tersangka?id='+id);
         $('#m_tersangka').modal('show');
	}

	$(document).ready(function(){
		$('#hapus-tersangka-check').click(function(){
			bootbox.dialog({
                message: "Apakah anda yakin akan menghapus tersangka yang dipilih??",
                buttons:{
                    ya : {
                        label: "Ya",
                        className: "btn-warning",
                        callback: function(){
                        	var checkboxes = document.getElementsByName('hapusTersangkaCheck');	
                			var deleteJaksaList =[];
	                		for (var i=0, n=checkboxes.length;i<n;i++) {
	                			  var checkJaksa=checkboxes[i];		
	                		  if (checkboxes[i].checked) 
	                		  {
	                			deleteJaksaList.push(checkboxes[i].value);
	                		  }
	                		}
	                			for(var i=0;i<deleteJaksaList.length;i++){
	                				$.get("delete-tersangka?id="+deleteJaksaList[i]);
	                				$("#tr_id"+deleteJaksaList[i]).remove();
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
