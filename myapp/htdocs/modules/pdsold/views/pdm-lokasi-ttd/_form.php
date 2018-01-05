<?php

use yii\helpers\Html;
use kartik\builder\Form;
use kartik\widgets\ActiveForm;
use kartik\select2\Select2Asset;
use kartik\datecontrol\DateControl;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmPratutPutusan */
/* @var $form yii\widgets\ActiveForm */
?>

<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">
        <?php
        $form = ActiveForm ::begin(
                        [
                            'id' => 'pdm-lokasi-ttd-form',
                            'type' => ActiveForm::TYPE_HORIZONTAL,
                            'enableAjaxValidation' => false,
                            'fieldConfig' => [
                                'autoPlaceholder' => false
                            ],
                            'formConfig' => [
                                'deviceSize' => ActiveForm::SIZE_SMALL,
                                'labelSpan' => 1,
                                'showLabels' => false
                            ]
        ]);
        ?>

        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            
            <div class="form-group">
                <label class="control-label col-md-2">Lokasi</label>
                <div class="col-md-4">
<?php 
//print_r($model->lokasi);exit;
if($model->id != null) { 
?>
                  <textarea id="lokasi" class="form-control" name="PdmLokasiTtd" rows="4" ><?php echo $model->lokasi; ?></textarea>
<?php } else {?>
 <textarea id="lokasi" class="form-control" name="PdmLokasiTtd" rows="4" ></textarea>
<?php }?>
				</div>
            </div>

                </div>
            </div>
			
	        
      <div class="box-footer" style="text-align: center;">
            <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
      </div> 
      
</section>