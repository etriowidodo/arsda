<?php

use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use \kartik\time\TimePicker;
use kartik\widgets\Select2;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;

require('..\modules\pidsus\controllers\viewFormFunction.php');
$viewFormFunction=new viewFormFunction();

$idSatker=$_SESSION['idSatkerUser'];
/* @var $this yii\web\View */
/* @var $model app\models\PdsLidSurat */
/* @var $form yii\widgets\ActiveForm */

$sqlPenerimaSurat="select * from pidsus.get_penerima_laporan ('".$idSatker."') order by nama_penerima_lap";
?>

<div class="pds-lid-surat-form">

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
					                                    <label for="lokasiSurat" class="control-label col-md-3">Tanggal dan Jam Surat</label>
					                                    <div class="col-md-3"><?=
					                                             $form->field($model, 'tgl_surat')->widget(DateControl::classname(), [
					                                                'type'=>DateControl::FORMAT_DATE,
					                                                'ajaxConversion'=>false,
					                                                'options' => [
					                                                    'pluginOptions' => [
					                                                        'autoclose' => true, 'startDate' => $viewFormFunction->getPreviousSuratDate($model), 'endDate' => $_SESSION['todayDate'],
					                                                    		
					                                                    ]
					                                                ],
					                                             	'readonly'=>true,
					                                            ])?>
					                                    </div>
					                                    <div class='col-md-3'>

														<?= $form->field($model, 'jam_surat')->widget(TimePicker::classname(), [
															'pluginOptions' => [

																'showMeridian' => false,
																'minuteStep' => 1,

															]
														]);?>
					                                    </div>
													</div>
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
													<?=
													Select2::widget([
														'name' => 'select_jaksa',
														'id' => 'select_jaksa',
														'data' => ArrayHelper::map($modelJaksa,'id_nip_jaksa','peg_nama'),
														'options' => ['placeholder' => 'Pilih Jaksa ...'],
														'pluginOptions' => [
															'allowClear' => true
														],
													]);
													?>
													</br>
													<span class="pull-right"><a id="tambah-jaksa" class="btn btn-success">Tambah Jaksa</a>&nbsp;&nbsp;<a id="hapus-jpu" class="btn btn-danger">Hapus Jaksa</a></span>
													</br></br>
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
																<td><input type="text" name="nip_jpu_update[]" class="form-control" readonly="true" value="<?= $value->pegawai->peg_nip_baru ?>"></td>
																<td><input type="text" name="nama_jpu_update[]" class="form-control" readonly="true" value="<?= $value->pegawai->peg_nama ?>"></td>
																<td><input type="checkbox" name="hapus-jpu-check" value="<?= $value->id_jaksa ?>"> </td>
															</tr>
														<?php endforeach; ?>
														</tbody>
													</table>
													

													<?php
													$this->registerJs("$(document).ready(function(){
										        $('#tambah-jaksa').click(function(){
													var valueddl =$('#select_jaksa').val();
													var valuetext=$('#select_jaksa option:selected').text();				
													var data = valueddl.split('#');
													var data2 = valuetext.split('(');				
													var element2 =  document.getElementById('trjpu'+data[0]);		
													if(data[0]!='' && element2 == null){
										                $('#tbody_jpu').append(
										                     '<tr id=\"trjpu'+data[0]+'\">' +
										                        '<td><input type=\"hidden\" name=\"nip_jpu[]\" readonly=\"true\" value=\"'+data[0]+'\"><input type=\"text\" class=\"form-control\" name=\"nip_jpu2[]\" readonly=\"true\" value=\"'+data[1]+'\"> </td>' +
										                        '<td><input type=\"text\" class=\"form-control\" name=\"nama_jpu[]\" readonly=\"true\" value=\"'+data2[0]+'\"> </td>' +
										                        '<td><input type=\"checkbox\" name=\"hapus-jpu-check\" value=\"'+data[0]+'\"> </td>' +
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
												
												  
							                </div>
									
					                       <div>
							                    <div>
							                    <div class="box box-solid">
							                    
					                            <?=$viewFormFunction->returnSuratIsi ($this, $form,$modelSuratIsi)?>        		
					                            </div>
					                           
					               <div class="box box-solid">
						        	<div>
						        		
							        	<div class="col-md-6">
								        	 </div>
							        	<div class="col-md-1">
							        		
								          	<?= Html::submitButton( 'Simpan', ['class' => 'btn btn-primary', 'name'=>'btnSubmit', 'value'=>'simpan','id' => 'btnSimpan']) ?>
								        </div>
								        <div class="col-md-1">	        		
								          	<?=Html::a('Batal', ['index'], ['data-pjax'=>0, 'class' => 'btn btn-danger', 'title'=>'cancel','id' => 'btnCancel']) ?>
						    			 </div>						    			 
						    			 <div class="col-md-1">
								      			<?= Html::submitButton('Cetak', ['data-pjax'=>0, 'class' => 'btn btn-success', 'name'=>'btnCetak', 'id'=>'btnCetak', 'value'=>'pidsus11']) ?>
								      	</div>
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
</div>
<?php 
//$viewFormFunction->setJs($this,$form,$model,$modelLid);    

?>
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

</div>
