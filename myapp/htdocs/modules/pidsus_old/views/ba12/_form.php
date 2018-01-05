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

											</div>
											<div>
												<div>
					                                </div>  
					                                		
							                </div>
											<div>
												<div class="box box-solid">
													<div class="box-header with-border">
														<div class="form-group">
															<label for="nomor_surat" class="control-label col-md-3">Tanggal BA </label>
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

													</div><!-- /.box-header -->

							                    <div>


							                    <div class="box box-solid">



													<?=$viewFormFunction->returnSuratIsi ($this, $form,$modelSuratIsi)?>



					                        </div></div></div>

					                        
						        	<div>
						        		
							        	<div class="col-md-6">

								          </div>
								         
							        	<div class="col-md-1">
							        		<?= Html::submitButton( 'Simpan', ['class' => 'btn btn-primary', 'name'=>'btnSubmit', 'value'=>'simpan','id' => 'btnSimpan'])  ?>
								        </div>
								        
								        <div class="col-md-1">
								          	<?=Html::a('Batal', ['../pidsus/ba12'], ['data-pjax'=>0, 'class' => 'btn btn-danger', 'title'=>'cancel','id' => 'btnCancel']) ?>
						    			 </div>						    			 
						    			  		      		     	
							        	<div class="col-md-1">
								      			<?= Html::submitButton('Cetak', ['data-pjax'=>0, 'class' => 'btn btn-success', 'name'=>'btnCetak', 'id'=>'btnCetak', 'value'=>'ba12']) ?>
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
