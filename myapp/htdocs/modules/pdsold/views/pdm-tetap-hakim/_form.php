<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use app\components\GlobalConstMenuComponent;
use app\components\ConstDataComponent;
use yii\helpers\ArrayHelper;
use kartik\datecontrol\DateControl;
use yii\bootstrap\Modal;
use yii\web\Session;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmTetapHakim */
/* @var $form yii\widgets\ActiveForm */
?>

<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">
	<?php
        $form = ActiveForm::begin([
                    'id' => 'pdm-tetap-hakim-form',
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
	<div class="form-group">
		<label class="control-label col-md-2">Wilayah Kerja</label>
	<div class="col-md-4">
		<input class="form-control" value="<?php echo Yii::$app->globalfunc->getNamaSatker($modelSpdp->wilayah_kerja)->inst_nama ?>">
	</div>
</div>       

<div class="form-group">
            <label class="control-label col-md-2">Nomor Surat</label>
            <div class="col-md-4">
                 <?= $form->field($model, 'no_surat') ?>
        </div>
	
        <div class="col-md-4"> <?php
		echo $form->field($model, 'tgl_surat')->widget(DateControl::classname(), [
                                                'type'=>DateControl::FORMAT_DATE,
                                                'ajaxConversion'=>false,
                                                'options' => [
                                                    'pluginOptions' => [
                                                        'autoclose' => true
                                                    ]
                                                ]
                                            ]);
                                        ?>
		
		
			
		</div>
</div>

<div class="form-group">
<label class="control-label col-md-2">Tanggal Terima</label>
        <div class="col-md-4"> <?php
			echo $form->field($model, 'tgl_terima')->widget(DateControl::classname(), [
                                                'type'=>DateControl::FORMAT_DATE,
                                                'ajaxConversion'=>false,
                                                'options' => [
                                                    'pluginOptions' => [
                                                        'autoclose' => true
                                                    ]
                                                ]
                                            ]);
                                        ?>
		
		
			
	</div>	        
 </div>	
 
<div class="form-group">
            <label class="control-label col-md-2">Pengadilan</label>
            <div class="col-md-4">
			<?php
				$pengadilan = (new \yii\db\Query())
                        ->select('id,nama')
                        ->from('pidum.pdm_ms_status_data')
                        ->where(['is_group' =>ConstDataComponent::JenisPengadilan])
                        ->all();
                echo $form->field($model, 'id_msstatusdata')->dropDownList(ArrayHelper::map($pengadilan, 'id', 'nama'), ['prompt' => '--Pilih Pengadilan--'], ['label' => '']); 		

			?>
            </div>
</div>	


<div class="form-group">
            <label class="control-label col-md-2">Lokasi</label>
            <div class="col-md-4">
			 <?= $form->field($model, 'lokasi') ?>
            </div>
</div>		
	

<div class="form-group">
            <label class="control-label col-md-2">Uraian</label>
            <div class="col-md-4">
			 <?= $form->field($model, 'uraian')->textInput(['maxlength' => true]) ?>
            </div>
</div>		
 	
	
	
  <hr style="border-color: #c7c7c7;margin: 10px 0;">
    <div class="box-footer" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
</div>
    <?php ActiveForm::end(); ?>

</div>
</section>
