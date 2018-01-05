<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use dosamigos\ckeditor\CKEditorInline;
use dosamigos\ckeditor\CKEditor;
use app\components\GlobalConstMenuComponent;
use yii\bootstrap\Modal;
use app\modules\pidum\models\PdmPenandatangan;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP21 */
/* @var $form yii\widgets\ActiveForm */
?>


<section class="content" style="padding: 0px;">
<div class ="content-wrapper-1">

<div class="box box-primary">
	<div class="box-header"></div>
    <?php
				
		$form = ActiveForm::begin ( [ 
				'id' => 'p21-form',
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
				 
		] );
	?>
		<div class="box-body">
	        <div class="form-group">
	            <label class="control-label col-md-2">Wilayah Kerja</label>
	            <div class="col-md-4">
	                <input class="form-control" value="<?php echo \Yii::$app->globalfunc->getNamaSatker($modelSpdp->wilayah_kerja)->inst_nama ?>">
	            </div>
	        </div>
			<?php echo Yii::$app->globalfunc->returnHeaderSuratSifat($form,$model) ?>
	        
			<div class="panel box box-warning">
	            <div class="box-header with-border">
	                <h3 class="box-title">
	                    
	                </h3>
	            </div>
	            <div class="form-group">
	                <label for="nomor" class="control-label col-md-2">Kepada Yth</label>
	                <div class="col-md-4">
	                	<?php echo $form->field($model, 'kepada')?>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="nomor" class="control-label col-md-2">DI</label>
	                <div class="col-md-4">
	                	<?php echo $form->field($model, 'di')?>
	                </div>
	            </div>
	        </div>
	      <!--  <div class="panel box box-warning">
	            <div class="box-header with-border">
	                <h3 class="box-title">Dasar Acuan</h3>
	            </div>
	            <div class="form-group">
	                <label for="nomor" class="control-label col-md-2">Nomor</label>
	
	                <div class="col-md-4"><input type="text" class="form-control" value="<?= $modelSpdp->no_surat ?>" readonly="true">
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="tanggal" class="control-label col-md-2">Tanggal</label>
	
	                <div class="col-md-4"><input type="text" class="form-control" value="<?= date('d-m-Y', strtotime($modelSpdp->tgl_surat)) ?>" readonly="true"></div>
	            </div>
	            <div class="form-group">
	                <label for="tanggal" class="control-label col-md-2">Pasal</label>
	
	                <div class="col-md-6">
	                	<?= $form->field($modelSpdp, 'undang_pasal')->widget(CKEditor::className(), [
					        'options' => ['rows' => 6],
					        'preset' => 'basic',
	                		'clientOptions' => [
					            'removePlugins' => 'toolbar',
	                			'readOnly' => 'true'
					        ],
					    ])?>
	                </div>
	            </div>
	        </div> -->
	        <div class="panel box box-warning">
	            <div class="box-header with-border">
	                <h3 class="box-title">
	                    Tersangka
	                </h3>
	            </div>
	            <table id="table_jpu" class="table table-bordered">
	                <thead>
	                <tr>
	                    <th>Nama</th>
	                </tr>
	                </thead>
	                <tbody id="tbody_tersangka">
	
	                <?php
	                if($modelTersangka != null){
	                    foreach($modelTersangka as $key => $value){
	                        echo "<tr><td>".$value['nama']."</td></tr>";
	                    }
	                }
	                ?>
	
	                </tbody>
	            </table>
	        </div>
	        
	        <div class="form-group">
	            <label for="nomor" class="control-label col-md-2">Dikeluarkan & tanggal</label>
	            <div class="col-md-4">
	              	<?php echo $form->field($model, 'dikeluarkan')->input('text', ['value' => \Yii::$app->globalfunc->getSatker()->inst_lokinst])?>
	            </div>
	            <div class="col-md-3">
	              	<?= $form->field($model, 'tgl_surat')->widget(DateControl::className(),[
                    'type'=>DateControl::FORMAT_DATE,
                    'ajaxConversion'=>false,
                    'options' => [
						'options' => ['placeholder' => 'Tanggal Dikeluarkan'],
                        'pluginOptions' => [
                            'autoclose' => true
                        ]
                    ]
                ]); ?>
	            </div>
            </div>
            <div class="form-group">
	            <label for="nomor" class="control-label col-md-2">Penandatangan</label>
	            <div class="col-md-4">
	              	<?php
                        $penandatangan=(new \yii\db\Query())
                                        ->select('peg_nik,nama')
                                        ->from('pidum.vw_penandatangan')
                                        ->where(['is_active' =>'1'])
                                        ->all();
                        $list = ArrayHelper::map($penandatangan,'peg_nik','nama');
                        echo $form->field($model, 'id_penandatangan')->dropDownList($list, 
                                ['prompt' => '---Pilih---'], 
                                ['label'=>'']);
                        ?>
	            </div>
            </div>
			<div class="panel box box-warning">
    <div class="box-header with-border">
    </div>            
                <?= Yii::$app->globalfunc->getTembusan($form,GlobalConstMenuComponent::P21,$this,$model->id_p21, $model->id_perkara) ?>
</div>
         
			</div>
			</div>
     	
		
	<hr style="border-color: #c7c7c7; margin:10 px 0;">
    <div class="box-footer" style="text-align: center;">
    <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
       <a class="btn btn-warning" href="<?= \yii\helpers\Url::to(['pdm-p21/cetak?id='.$model->id_perkara])?>">Cetak</a>
    </div>
	<div>
		
	   	<?php ActiveForm::end(); ?>
                  
</div>

</section>