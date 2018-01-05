<?php

use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;

require('..\modules\pidsus\controllers\viewFormFunction.php');
$viewFormFunction=new viewFormFunction();
/* @var $this yii\web\View */
/* @var $model app\models\PdsLid */
/* @var $form yii\widgets\ActiveForm */


?>

<div class="pds-lid-form">


    <div class="box box-primary">
	<div class="box-header">


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
	<?php 
		//$viewFormFunction->returnHeadForm($typeSurat,$form,$model,$modelSurat);  
		$viewFormFunction->returnMainForm($form,$model); 
		$viewFormFunction->returnP1AdditionalForm($form,$model);
		?>
		<?php if($model->id_status<>'2'){?>
        <div class="box-footer">
        	<div class="col-md-8">
        		
	        	<div class="col-md-4">
		        	<?= $viewFormFunction->returnDropDownList($form,$model,'Select * from pidsus.status','id_status','nama_status','id_status')?>
		         </div>
		         
	        	<div class="col-md-4">
	        		
		          	<?= Html::submitButton( 'Simpan', ['class' => 'btn btn-primary', 'name'=>'btnSubmit', 'value'=>'simpan','id' => 'btnSimpan']) ?>
		        </div>
	        </div>
        </div>
        <?php }?>
		
    <?php //ActiveForm::end(); ?>

</div>


