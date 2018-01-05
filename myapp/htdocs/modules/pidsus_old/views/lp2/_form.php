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
$sqlSatker="select inst_satkerkd,inst_nama from kepegawaian.kp_inst_satker";
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
           <div class="box-body">
							                <div>
							                    <div>
				<div class="form-group">
					 <label for="id_satker" class="control-label col-md-3">Satuan Kerja</label>
					 <div class="col-md-6"> <?= $viewFormFunction->returnSelect2withoutmodel($sqlSatker,$form,'inst_satkerkd','inst_nama','Pilih Satuan Kerja ...','select_satker')?> </div>
				</div> 
				<div class="form-group">
					 <label for="jenis_kasus" class="control-label col-md-3">Jenis Kasus</label>
					 <div class="col-md-6"><?= $viewFormFunction->returnSelect2ParameterDetailWithoutModel($form,'select_jenis_kasus','Jenis Kasus','49') ?></div>
				</div> 
				<div class="form-group">
					 <label for="jenis_kasus" class="control-label col-md-3">Periode</label>
					 <div class="col-md-3"><?= $viewFormFunction->returnSelect2ParameterDetailWithoutModel($form,'select_bulan','Bulan','11','no_urut') ?></div>
					<div class="col-md-3"><?= $viewFormFunction->returnSelect2ParameterDetailWithoutModel($form,'select_tahun','Tahun','12','nama_detail') ?></div>
				</div> 
				</br>
          
						        	<div class="form-group">
						        		
							        	<div class="col-md-8">
								        	<?php //$viewFormFunction->returnDropDownListStatus($form,$model,$modelLid->id_status)?>
								          </div>	
								          
							        	<div class="col-md-1">
							        		
								          	<?= Html::submitButton($model->isNewRecord ? 'Tambah' : 'Cetak', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
								        </div>	
							        </div>
				</br>
          
					  </div></div></div>                      
							           
        
		
    <?php ActiveForm::end(); ?>
</div>
</div>

</div>
