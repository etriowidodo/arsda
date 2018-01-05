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
/* @var $model app\models\PdsTutSurat */
/* @var $form yii\widgets\ActiveForm */

$sqlJaksa="select * from pidsus.get_jaksa_p2('".$_SESSION['idSatkerUser']."')";

$sqlPenandatangan="select * from pidsus.get_penandatangan	('".$idSatker."','".$model->id_jenis_surat."') order by id_penandatangan";

$sqlTdw="select * from pidsus.pds_tut_tersangka where id_pds_tut='$model->id_pds_tut'";
?>

<div class="pds-tut-surat-form">

  <div class="pds-tut-form">

   <div>
    <div class="box box-primary">
	<div class="box-header">

        </div>
    <?php $form = ActiveForm::begin(
	 [
                'id' => 'ba1-form',
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




 </br>
					                       
					                        
											<div>
							                    <div>
							                    <div>
							                    
					                            <?=$viewFormFunction->returnSuratIsi ($this, $form,$modelSuratIsi)?> 
					                            <?= $viewFormFunction->returnSelect2($sqlTdw,$form,$modelSaksiTersangka,'id_tersangka','Terdakwa','id_pds_tut_tersangka','nama_tersangka','Pilih Terdakwa ...','terdakwa','full')?>
					                             
					                            <?= $viewFormFunction->returnSelect2($sqlPenandatangan,$form,$model,'id_ttd','Penandatangan','id_penandatangan','nama_penandatangan','Pilih Penandatangan ...','penandatangan','full')?>
					                                 		
					                            </div>
					                            </br></br>
					                        
					                        
					               
						        	<div>
							        	<div class="col-md-8">
								        	</div>
							        	<div class="col-md-1">
							        		
								          	<?= Html::submitButton( 'Simpan', ['class' => 'btn btn-primary', 'name'=>'btnSubmit', 'value'=>'simpan','id' => 'btnSimpan']) ?>
								        </div>
								        
								        <div class="col-md-1">	        		
								          	<?=Html::a('Batal', ['index'], ['data-pjax'=>0, 'class' => 'btn btn-danger', 'title'=>'cancel','id' => 'btnCancel']) ?>
						    			 </div>						    			 
						    			<div class="col-md-1"><input type="hidden" id="hdnIdPdsTutSurat" value="<?= $model->id_pds_tut_surat ?>"/><a class="btn btn-danger" id="hapus-surat-tut"> Hapus</a></div>
						    			<div class="col-md-1">
								      			<?= Html::submitButton('Cetak', ['data-pjax'=>0, 'class' => 'btn btn-success', 'name'=>'btnCetak', 'data' => ['confirm' => 'Apakah anda yakin ingin menyimpan lalu Cetak?'], 'value'=>'ba1']) ?>
								      	</div>	
								      	
							        </div>
					                      </br>  		
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
//$viewFormFunction->setJs($this,$form,$model,$modelTut);    

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
