<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm  as ActiveForm2;
use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\MsJenisPidana */
/* @var $form yii\widgets\ActiveForm */
?>


<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">

 <?php  $form = ActiveForm::begin([
                    'id' => 'restore-data-insert-form',
                    'type' => ActiveForm::TYPE_HORIZONTAL,
                    'method' => 'POST',
                    'action' => '/restore-data/insert',
                    'enableAjaxValidation' => false,
                    'fieldConfig' => [
                        'autoPlaceholder' => false
                    ],
                    'formConfig' => [
                        'deviceSize' => ActiveForm::SIZE_SMALL,
                        'showLabels' => false
                    ],
				'options' => [
                            'enctype' => 'multipart/form-data',
                        ]
        ]); 
	?>
	<div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
		
		<div class="col-md-12">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4">Pilih File Backup </label>
					<div class="col-md-8">
						<?php
							//echo '<label class="control-label">Upload Document</label>';
								echo FileInput::widget([
								    'name' => 'file_restore_data',
								    'pluginOptions' => [
		                                'showPreview' => false,
		                                'showUpload' => true,
		                                'showRemove' => false,
										 'showClose' => false,
		                                'showCaption'=> true,
		                                'browseLabel'=>'...',
		                            ]
								]);
						?>
					</div>
				</div>
			</div>
		</div>
    </div>
 
    <div class="box-footer" style="text-align: center;">
    </div>
    <?php ActiveForm::end(); ?>
	</div>
</section>




