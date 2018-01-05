<?php

use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;

require('..\modules\pidsus\controllers\viewFormFunction.php');
$viewFormFunction=new viewFormFunction();

/* @var $this yii\web\View */
/* @var $model app\models\PdsDikSurat */
/* @var $form yii\widgets\ActiveForm */

$sqlJaksa="select * from pidsus.get_jaksa_p2('".$_SESSION['idSatkerUser']."')";
$sqlSaksi="select nama_saksi, id_pds_dik_saksi from pidsus.pds_dik_saksi where id_pds_dik_usulan_permintaan_data in(select id_pds_dik_usulan_permintaan_data from pidsus.get_list_saksi_pidsus14_ddl('".$model->id_pds_dik_surat."','saksi'))"
?>

<div class="pds-dik-surat-form">

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
							                    <div>
					                                 <div class="form-group">
					                                    <label for="lokasiSurat" class="control-label col-md-3">Dikeluarkan</label>
					                                    <div class="col-md-3"><?= $form->field($model, 'lokasi_surat')->textInput(['readonly' => $readOnly]) ?></div>
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
									<?php /*
									<div>
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
			                                            <th>NIP</th>
			                                            <th>Nama</th>
			                                            <th></th>
			                                        </tr>
			                                    </thead>
			                                    <tbody id="tbody_jpu">
			                                            <?php foreach ($modelJaksa as $value): 
					                                             ?>
			                                                <tr id="trjpu<?=  $value->id_jaksa ?>">
			                                                    <td><input type="text" name="nip_jpu_update[]" class="form-control" readonly="true" value="<?= $value->id_jaksa ?>"></td>
			                                                    <td><input type="text" name="nama_jpu_update[]" class="form-control" readonly="true" value="<?= $value->pegawai->peg_nama ?>"></td>
			                                                    <td><a id="btn-hapus-jpu" class="btn btn-danger" onclick="hapusJpu('<?= $value->id_jaksa ?>')">Hapus</a> </td>
			                                                </tr>
			                                            <?php 
					                                             endforeach; ?>
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
					                        </div></div>
 */ ?>
									<div>
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
										</div></div>




 </br>
					                       
					                        
											<div>
							                    <div>
							                    
					                            <?=$viewFormFunction->returnSuratIsi ($this, $form,$modelSuratIsi)?>        		
					                            </div>
					                            
					                            </br></br>
					                        <div>
							                    <div>
							                    <?php
							                    if ($model->id_jenis_surat=='ba1sks'){
							                   	 echo $viewFormFunction->returnSelect2($sqlSaksi,$form,$modelSuratSaksi,'id_saksi','Nama Saksi','id_pds_dik_saksi','nama_saksi','Pilih saksi ...','nama_saksi','full');?>
												 <div class="form-group">
					                                    <label for="lokasiSurat" class="control-label col-md-3"></label>
					                                    <div class="col-md-6">
					                                    	<span class="pull-right"><button id="btnEditSaksi" class="btn btn-primary" type="button"><i class="fa"></i> Ubah Data Saksi</button></span>
					                                    </div>
													</div>
													<?php }?>
							                </div>
							                </div>
					                            </br>
					                        <div>
							                    <div>
							                    
							                    <div class="box-header with-border">
							                        
							                        <h3 class="box-title">Keterangan/Jawaban :</h3>
							                    </div>					                                
							                    <table id="table_ket" class="table table-bordered">
			                                    <thead>
			                                        <tr>
			                                            <th><div class="col-md-1">No</div></th>
			                                            <th><div class="col-md-4">Pertanyaan</div></th>
			                                            <th><div class="col-md-4">Jawaban</div></th>
			                                            <th></th>
			                                        </tr>
			                                    </thead>
			                                    <tbody id="tbody_ket">
			                                                <?php foreach ($modelKeterangan as $index=> $valueket): ?>
			                                                <div><tr id="trket<?=  $valueket->id_pds_dik_surat_keterangan ?>">
			                                                	<td class="col-md-1"><?= $form->field($valueket, "[$index]no_urut")->textInput(["readonly" => $readOnly]) ?>
			                                                	</td>
			                                                	<td><?= $form->field($valueket, "[$index]pertanyaan")->textArea(array('maxlength' => 4000, 'rows' => 3, 'cols' => 50,'readonly' => $readOnly)) ?>
																</td>
			                                                    <td><?= $form->field($valueket, "[$index]jawaban")->textArea(array('maxlength' => 4000, 'rows' => 3, 'cols' => 50,'readonly' => $readOnly)) ?>
																</td>
			                                                   	<td><a id="btn-hapus-pd" class="btn btn-danger" onclick="hapusKet('<?= $valueket->id_pds_dik_surat_keterangan ?>')">Hapus</a> </td>			                                                	
			                                                </tr></div>
			                                            <?php endforeach; ?>
			                                    </tbody>
			                                </table> 
			                                <a id="tambah-keterangan" class="btn btn-success">Tambah Keterangan</a>
						 
							                   <?php 
							                   $this->registerJs("$(document).ready(function(){
							                   	var x=1;	
										        $('#tambah-keterangan').click(function(){
													    $('#tbody_ket').append(
										                     '<tr id=\"trket'+x+'\">' +
							                   					'<td><input type=\"text\" class=\"form-control\" name=\"no_urut[]\"></input></td>'+
										                        '<td><textarea class=\"form-control\" name=\"pertanyaan[]\" value=\"\"></textarea> </td>' +
										                        '<td><textarea class=\"form-control\" name=\"jawaban[]\" value=\"\"></textarea> </td>' +
										                        '<td><a class=\"btn btn-danger\" onclick=\"hapusKet('+x+')\">Hapus</a> </td>' +
										                    '</tr>'      
							                   			);
							                   		x++;
										            });
										        });
							                   		"
							                   		
							                   		);
							                   ?>  	  		
					                            </div>
					                        </div> </br></br>
					               
						        	<div>
							        	<div class="col-md-8">
								        	</div>
							        	<div class="col-md-1">
							        		
								          	<?= Html::submitButton( 'Simpan', ['class' => 'btn btn-primary', 'name'=>'btnSubmit', 'value'=>'simpan','id' => 'btnSimpan']) ?>
								        </div>
								        
								        <div class="col-md-1">	        		
								          	<?=Html::a('Batal', ['index'], ['data-pjax'=>0, 'class' => 'btn btn-danger', 'title'=>'cancel','id' => 'btnCancel']) ?>
						    			 </div>						    			 
						    			<div class="col-md-1">
								      			<?= Html::submitButton('Cetak', ['data-pjax'=>0, 'class' => 'btn btn-success', 'name'=>'btnCetak', 'id'=>'btnCetak', 'value'=>'ba1sks']) ?>
								      	</div>	
								      	
							        </div>
					                      </br>  		
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
    <?php
Modal::begin([
	'id' => 'm_saksi',
	'header' => '<h7>Saksi</h7>'
]);
//echo $this->render('_popTersangka', ['modelTersangka' => $modelTersangka]);
Modal::end();
$script = <<< JS
        $('#btnEditSaksi').click(function(){
			var idUPD=$('#pdsdiksuratsaksi-id_saksi').val();
            $('#m_saksi').html('');
            $('#m_saksi').load('/pidsus/ba1/editsaksi?id='+idUPD);
            $('#m_saksi').modal('show');
        });




JS;
$this->registerJs($script);
?>
</div>
<?php 
//$viewFormFunction->setJs($this,$form,$model,$modelDik);    

?>
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
</script>
<?php
$script1 = <<< JS
	$('#popUpJpu').click(function(){
		$('#m_jpu').html('');
        $('#m_jpu').load('/pidsus/p2/jpu');
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
