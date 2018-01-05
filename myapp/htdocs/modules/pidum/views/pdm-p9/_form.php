<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use kartik\builder\Form;
use yii\bootstrap\Modal;
use yii\db\Query;
use yii\web\View;

use app\modules\pidum\models\VwPenandatangan;
use app\components\GlobalConstMenuComponent;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP9 */
/* @var $form yii\widgets\ActiveForm */
?>


<section class="content" style="padding: 0px;">
<div class="content-wrapper-1">
    <?php 
	$form = ActiveForm::begin(
	[
                'id' => 'p9-form',
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
	<div class="panel box box-warning">
     <div class="box-body">
	<div class="form-group">
        <label for="nomor" class="control-label col-md-2">Nomor Surat </label>
		<div class="col-md-3"><?= $form->field($model, 'no_surat') ?></div>
		
		 <label class="control-label col-md-2">Kepada</label>
            <div class="col-md-3">
                <?= $form->field($model, 'kepada')->textInput(['maxlength' => true]) ?>
    </div>
	</div>
		
	<div class="form-group">
            <label class="control-label col-md-2">Tanggal</label>
	<div class="col-md-3">
    <?php
    echo $form->field($model, 'tgl_panggilan')->widget(DateControl::classname(), [
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
	
	 <label for="di" class="control-label col-md-2">Di</label>
				<div class="col-md-3">
				 <?=$form->field($model, 'di_kepada')->textInput(['maxlength' => true]) ?>
	</div>
	
	<div class="col-md-12">
<?php
echo Form::widget([ /* waktu*/
	'model' => $model,
	'form' => $form,
	'columns' => 2,
	'attributes' => [
		'jam_kunjungan' => [
			'label' => 'Jam',
			'labelSpan' => 2,
			'columns' => 12,
			'attributes' => [
				'jam' => [
					'type' => Form::INPUT_WIDGET,
					'widgetClass' => '\kartik\widgets\TimePicker',
					'options' => [
						'pluginOptions'=>[
					  
							'defaultTime'=>false,
							'showSeconds'=>false,
							'showMeridian'=>false,
							'minuteStep'=>1,
						],
						'options' => [
							'placeholder'=>'Jam'
						]
					],
					'columnOptions' => ['colspan' => 3],
				],
			]
		],
	]
]);
?>
        </div>
			
	
	
	<div class="col-md-12">
			<div class="form-group">	
			<label class="control-label col-md-2">Tempat</label>
            <div class="col-md-3">
                <?= $form->field($model, 'tempat')->textInput(['maxlength' => true]) ?>
            </div>
			  <label class="control-label col-md-2">Menghadap</label>
            <div class="col-md-3">
                <?= $form->field($model, 'menghadap')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

			
	    <div class="form-group hide">
          
			
			<label class="control-label col-md-2">Sebagai</label>
            <div class="col-md-3">
                <?= $form->field($model, 'sebagai')->textInput(['maxlength' => true]) ?>
        </div>
        </div>
	
	</div>
	</div>			
</div>		
</div>


<div class="panel box box-warning">
	<div class="box-header with-border hide">
    <div class="form-group">
    <h3 class="box-title" style="margin-left:10px">SAKSI</h3>
    </div>
	<div class="form-group" style="margin-left:10px">
			<?php
				$new = [1 => 'Saksi', 2 => 'Ahli'];
				echo $form->field($model, 'id_msstatusdata')
				->radioList($new, ['inline' => true]);
			?>
	</div>
    </div>

    <div class="box-header with-border">
    <div class="form-group">
    <h3 class="box-title" style="margin-left:10px">SAKSI / AHLI</h3>
    </div>
	<div class="form-group" style="margin-left:10px">
			<?php
				$new = ['Saksi' => 'Saksi', 'Ahli' => 'Ahli'];
				echo $form->field($model, 'sebagai')
				->radioList($new, ['inline' => true]);
			?>
	</div>
    </div>
		
	<div class="form-group">
        <label class="control-label col-md-2">Nama</label>
    <div class="col-md-3"> 
	<?=$form->field($modelPanggilanSaksi, 'nama');
	?>

    </div>
	</div>
	
	
<div class="form-group">
    <label class="control-label col-md-2">Alamat</label>
    <div class="col-md-6"> 
	 <?=$form->field($modelPanggilanSaksi, 'alamat')->textArea(['rows' => 3]); ?>
</div>
</div>

<div class="form-group">
    <label class="control-label col-md-2">Pekerjaan</label>
    <div class="col-md-3"> 
	 <?=$form->field($modelPanggilanSaksi, 'pekerjaan'); ?>
	 
</div>
</div>
	</div>
		

<div class="panel box box-warning">	   
<br>
	<div class="form-group">
		<label class="control-label col-md-2">Dikeluarkan di</label>
		<div class="col-md-3">
		<?php
			if($model->isNewRecord) echo $form->field($model, 'dikeluarkan')->textInput(['value' => \Yii::$app->globalfunc->getSatker()->inst_lokinst]);
			else  echo $form->field($model, 'dikeluarkan');
		?>
		</div>
		
		 <label class="control-label col-md-2">Tanggal</label>
		<div class="col-md-3">
			 <?php
    echo $form->field($model, 'tgl_dikeluarkan')->widget(DateControl::classname(), [
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
             <label for="id_penandatangan" class="control-label col-md-2">Penanda Tangan</label>
			<div class="col-md-3">
			 <?php  echo Yii::$app->globalfunc->returnDropDownList($form,$model, VwPenandatangan::find()->all(),'peg_nik','nama','id_penandatangan')  ?>
			</div>
		</div>
		</div>
              
               
    <div class="box-footer" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
		<?php if (!$model->isNewRecord): ?>
        <a class="btn btn-warning" href="<?= \yii\helpers\Url::to(['pdm-p9/cetak?id='.$model->id_p9]) ?>">Cetak</a>
		<?php endif ?>
    </div>
	<?php ActiveForm::end(); ?>   
	 
 
</section>
</div>
		 