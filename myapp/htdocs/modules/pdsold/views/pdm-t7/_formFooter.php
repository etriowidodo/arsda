<?php
use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\VwPenandatangan;


use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use kartik\widgets\FileInput;
use app\modules\pdsold\models\MsLoktahanan;
use yii\web\Session;
?>

<div class="col-sm-12">
    <div class="box box-warning">
        <div class="box-body">
		
            <div class="class-md-12 pull-right" style="width:400px;">
			 <div class="form-inline col-md-12 " style="padding:0;">
   
			<div class="col-md-4">
	Dikeluarkan Di
                <?= $form->field($model, 'dikeluarkan')->textInput(['value' => \Yii::$app->globalfunc->getSatker()->inst_lokinst,'style'=>'width:120px;']) ?>
				</div>
				<div class="col-md-4">
				<br>
             <?=
                $form->field($model, 'tgl_dikeluarkan')->widget(DateControl::className(), [
                    'type' => DateControl::FORMAT_DATE,
                    'ajaxConversion' => false,
                    'options' => [
                        'pluginOptions' => [
                            'autoclose' => true
                        ]
                    ]
                ]);
                ?></div></div>
				

                <div class="col-md-8">
				               Penanda Tangan
                    <?php

                    echo Yii::$app->globalfunc->returnDropDownList($form,$model, VwPenandatangan::find()->all(),'peg_nik','nama','id_penandatangan')  ?>
                </div>
            </div>
			<br>
            <div class="col-md-8 pull-left">
                <?= Yii::$app->globalfunc->getTembusan($form,$GlobalConst,$this,$id_table, $model->id_perkara) ?>
            </div>
        </div>
    </div>
</div>
