<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidsus\models\PdsDikMatrixPerkara */
/* @var $form yii\widgets\ActiveForm */
$sqlTersangka="select * from pidsus.get_list_tersangka_ddl('".$_SESSION["idPdsDikSurat"]."')";
$sqlKasusPosisi="select distinct id_jenis_surat from pidsus.jenis_surat";
require('..\modules\pidsus\controllers\viewFormFunction.php');
$viewFormFunction=new viewFormFunction();
?>

<div class="pds-dik-matrix-perkara-form">

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
		<div class="form-group">
			<label for="no_urut" class="control-label col-md-3">Nomor </label>
			<div class="col-md-6"><?= $form->field($model, 'no_urut')->textInput(['readonly' => $readOnly]) ?></div>
		</div>  
		<div class="form-group">
			<label for="id_dik_tersangka" class="control-label col-md-3">Nama Tersangka </label>
			<div class="col-md-6"><?= $viewFormFunction->returnSelect2($sqlTersangka,$form,$model,'id_dik_tersangka','Nama Tersangka','id_pds_dik_tersangka','nama_tersangka','Pilih Tersangka ...','id_dik_tersangka')?></div>
		</div>  
		<div class="form-group">
			<label for="kasus_posisi" class="control-label col-md-3">Kasus Posisi</label>
			<div class="col-md-6"><?= $viewFormFunction->returnSelect2($sqlKasusPosisi,$form,$model,'kasus_posisi','Nama Tersangka','id_jenis_surat','id_jenis_surat','Pilih Kasus Posisi ...','kasus_posisi')?></div>
		</div>  
		<div class="form-group">
			<label for="pasal_disangkakan" class="control-label col-md-3">Pasal Disangkakan </label>
			<div class="col-md-6"><?= $form->field($model, 'pasal_disangkakan')->textArea(array('maxlength' => 4000, 'rows' => 6, 'cols' => 50,'readonly' => $readOnly)) ?></div>
		</div>    
		<div class="form-group">
			<label for="uraian_fakta" class="control-label col-md-3">Uraian Fakta</label>
			<div class="col-md-6"><?= $form->field($model, 'uraian_fakta')->textArea(array('maxlength' => 4000, 'rows' => 6, 'cols' => 50,'readonly' => $readOnly)) ?></div>
		</div>  
		<div class="form-group">
			<label for="alat_bukti" class="control-label col-md-3">Uraian Fakta</label>
			<div class="col-md-6"><?= $form->field($model, 'alat_bukti')->textArea(array('maxlength' => 4000, 'rows' => 6, 'cols' => 50,'readonly' => $readOnly)) ?></div>
		</div>  
		<div class="form-group">
			<label for="barang_bukti" class="control-label col-md-3">Uraian Fakta</label>
			<div class="col-md-6"><?= $form->field($model, 'barang_bukti')->textArea(array('maxlength' => 4000, 'rows' => 6, 'cols' => 50,'readonly' => $readOnly)) ?></div>
		</div>  
		<div class="form-group">
			<label for="keterangan" class="control-label col-md-3">Uraian Fakta</label>
			<div class="col-md-6"><?= $form->field($model, 'keterangan')->textArea(array('maxlength' => 4000, 'rows' => 6, 'cols' => 50,'readonly' => $readOnly)) ?></div>
		</div>  
	</div>

<div class="box-footer">   	
	        	<div class="col-md-7">
		        	<?php //$viewFormFunction->returnDropDownListStatus($form,$model,$model->id_status)?>		        
		         </div>		         
	        	<div class="col-md-1">	        		
		          	<?= Html::submitButton( 'Simpan', ['class' => 'btn btn-primary', 'name'=>'btnSubmit', 'value'=>'simpan','id' => 'btnSimpan']) ?>
		      	</div>	     	
	        	<div class="col-md-1">		   		
		          	<?=Html::a('Batal',$model->isNewRecord ? ['index'] : ['../pidsus/p7'], ['data-pjax'=>0, 'class' => 'btn btn-danger', 'title'=>'cancel','id' => 'btnCancel']) ?>
    			 </div>
		      		<?php if(!$model->isNewRecord){ if($typeSurat=='p1'){?> 		      		     	
	        	<div class="col-md-1">
	        			<?= Html::submitButton('Cetak', ['data-pjax'=>0, 'class' => 'btn btn-success', 'name'=>'btnCetak', 'id'=>'btnCetak', 'value'=>'p1']) ?>
		      	</div>	
		      	<?php } else if($typeSurat=='pidsus1'){?>
		      	<div class="col-md-1">
		      			<?= Html::submitButton('Cetak', ['data-pjax'=>0, 'class' => 'btn btn-success', 'name'=>'btnCetak', 'id'=>'btnCetak', 'value'=>'pidsus1']) ?>
		      			
		      	</div>	
		      		<?php }}?>  
	    </div>

    <?php ActiveForm::end(); ?>

</div>
