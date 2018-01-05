<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\datecontrol\DateControl;
use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\PdmPenandatangan;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP11 */
/* @var $form yii\widgets\ActiveForm */
?>
<section class="content" style="padding: 0px;">
   <div class ="content-wrapper-1">
<?php
        $form = ActiveForm ::begin(
            [
                'id' => 'p10-form',
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
            ]);
		 
        ?>

        
            
        <?= $this->render('//default/_formHeader', ['form' => $form, 'model' => $model]) ?>
     		
	
								
		<div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class ="form-group">
        
                <label for="ket_ahli" class="control-label col-sm-3">Keterangan Ahli</label>
			    <div class="col-md-8"><?= $form->field($model, 'ket_ahli')->textarea() ?></div>
          </div>
        </div>
								
			<div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="box-header with-border">
                <h3 class="box-title">Tersangka</h3>
            </div><br>
            <?php
            if($modelTersangka != null){
                foreach($modelTersangka as $key => $value){
                    ?>
                    <div class="form-group">
                        <div class="col-md-4"><input type="text" class="form-control" value="<?= $value['nama'] ?>" readonly="true"></div>
                    </div>
                    <?php
                }
            }
            ?>
			</div>
             <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::P10, 'id_table' => $model->id_p10]) ?>
			
</section>
 

  
  <hr style="border-color: #c7c7c7;margin: 10px 0;">
    <div class="box-footer" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
		<?php if(!$model->isNewRecord){ ?>
			<a class="btn btn-warning" href="<?= \yii\helpers\Url::to(['pdm-p10/cetak?id='.$model->id_p10] ) ?>">Cetak</a>
		<?php } ?>
    </div>
        <div id="hiddenId"></div>
    <?php ActiveForm::end(); ?>