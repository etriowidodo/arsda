<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm  as ActiveForm2;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\MsJenisPidana */
/* @var $form yii\widgets\ActiveForm */
?>


<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">

 <?php  $form = ActiveForm::begin([
                    'id' => 'backup-data-insert-form',
                    'type' => ActiveForm::TYPE_HORIZONTAL,
                    'enableAjaxValidation' => false,
                    'fieldConfig' => [
                        'autoPlaceholder' => false
                    ],
                    'formConfig' => [
                        'deviceSize' => ActiveForm::SIZE_SMALL,
                        'showLabels' => false
                    ]
        ]); 
	?>
	<div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
		
		<div class="col-md-12">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4">Last Backup </label>
					<div class="col-md-8">
						<?= $form->field($model, 'last_backup')->textInput(['maxlength' => true,'value'=>date("Y-m-d h:i:s")]) ?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4">Penyimpanan Path File</label>
					<div class="col-md-8">
						<?= $form->field($model, 'file')->textInput(['maxlength' => true,'value'=>'D:\TestFolder']) ?>
					</div>
				</div>
			</div>
		</div>
    </div>
    <div class="box-footer" style="text-align: center;">
        <?= Html::submitButton('Proses' , ['class' => 'btn btn-warning','name'=>'actionButton','value'=>'Export']) ?>
		<!-- <input type="file" id="FileUpload" onchange="selectFolder(event)" webkitdirectory mozdirectory msdirectory odirectory directory multiple />
 -->
    </div>

    <?php ActiveForm::end(); ?>

	</div>
</section>
<script type="text/javascript">
// function selectFolder(e) {
//     var theFiles = e.target.files;
//     var relativePath = theFiles[0].webkitRelativePath;
//     // var folder = relativePath.split("/");
//     alert(relativePath);
// }
</script>

