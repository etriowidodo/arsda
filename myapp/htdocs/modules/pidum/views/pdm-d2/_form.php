<?php

use app\components\GlobalConstMenuComponent;
use app\components\ConstDataComponent;
use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Url;



/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmD2 */
/* @var $form yii\widgets\ActiveForm */
?>


<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">
	<?php 
        $form = ActiveForm::begin([
                    'id' => 'pdm-d2-form',
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
            <div class="box-header with-border">
		    <h3 class="box-title">PENGAKUAN</h3>
            </div>
			<br>
		    <div class="form-group" style="margin:left=5px">
            <label class="control-label col-md-2">Nama</label>
            <div class="col-md-4">
                 <?= $form->field($terdakwa, 'nama')->textInput(['readonly'=>true, 'disabled'=>true]) ?>
        </div>
        </div>
		
		 <div class="form-group">
            <label class="control-label col-md-2">Tanggal lahir</label>
            <div class="col-md-4">
                 <?=
			$form->field($terdakwa, 'tgl_lahir')->widget(DateControl::className(), [
				'type' => DateControl::FORMAT_DATE,
                'readonly'=>true,
                'disabled'=>true,
				'ajaxConversion' => false,
				'options' => [
					'pluginOptions' => [
						'autoclose' => true,
						'startDate'=>''
					]
				]
			]);
			?>
        </div>
        </div>
		
		
		  <div class="form-group">
            <label class="control-label col-md-2">Alamat</label>
            <div class="col-md-4">
                 <?= $form->field($terdakwa, 'alamat')->textInput(['readonly'=>true, 'disabled'=>true]) ?>
        </div>
        </div>
		
		
		 <div class="form-group">
            <label class="control-label col-md-2">Pekerjaan</label>
            <div class="col-md-4">
                 <?= $form->field($terdakwa, 'pekerjaan')->textInput(['readonly'=>true, 'disabled'=>true]) ?>
        </div>
        </div>
				
		</div>
		
		<div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="box-header with-border">
                <h3 class="box-title">PEMBAYARAN PALING LAMBAT</h3>
            </div>
			<br>
			<div class="form-group">
                <label class="control-label col-md-2">Tanggal Limit</label>
                <div class="col-md-3">
    			<?php echo
    			$form->field($model, 'tgl_setor')->widget(DateControl::className(), [
    				'type' => DateControl::FORMAT_DATE,
    				'ajaxConversion' => false,
    				'options' => [
    					'pluginOptions' => [
    						'autoclose' => true,
    						'startDate'=>'',
                'endDate' => '+1y',
    					]
    				]
    			]);
    			?>
                </div>
            </div>
		</div>
    		
			
		<div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="box-header with-border">
                <h3 class="box-title">SYARAT</h3>
            </div>
			<br>
			
		<div class="form-group">
		<div class="control-label col-md-4">
		  <?php $jenis = $d1->id_msstatusdata==1 ? 'Denda' : 'Biaya Perkara';
            echo $form->field($model,'is_lunas')->radioList(['1' => 'Sanggup Melunasi Pembayaran '.$jenis, '0' => 'Tidak Sanggup Melunasi Pembayaran '.$jenis]); 
		  ?> 	
	</div>
	</div>
	
	   <div class="form-group">
		 <label class="control-label col-md-2">Sebesar Rp</label>
        <div class="col-md-3">
                 <?php $jenis = $d1->id_msstatusdata==1 ? 'denda' : 'biaya_perkara';
                    echo $form->field($model, 'nilai', ['inputOptions'=>['value'=> $jenis==1 ? $putusan->denda : $putusan->biaya_perkara]])->textInput(['readonly'=>true]); ?>
        </div>
      </div>
    </div>		

            <div class="form-group" style="margin-left:0px">
            <label class="control-label col-md-2">Dikeluarkan & Tanggal</label>
                <div class="col-md-4">
                    <?php if($model->isNewRecord){
                                               echo $form->field($model, 'dikeluarkan')->input('text', ['value' => Yii::$app->globalfunc->getSatker()->inst_lokinst]);
                                            }else{
                                               echo $form->field($model, 'dikeluarkan');
                                            } ?>
                </div>
                    <div class="col-md-3">
                        <?= $form->field($model, 'tgl_dikeluarkan')->widget(DateControl::className(),[
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

           <div class="form-group" style="margin-left:0px">
               <label class="control-label col-md-2">Jaksa Penerima</label>
               <div class="col-md-4">
                   <?=
                      $form->field($model, 'nama_ttd', [
                          'addon' => [
                             'append' => [
                                'content' => Html::a('Pilih', '', ['class' => 'btn btn-warning', 'data-toggle' => 'modal', 'data-target' => '#m_jpu']),
                                  'asButton' => true
                             ]
                         ]
                     ]);
                   ?>
                   <?= $form->field($model, 'id_penandatangan')->hiddenInput(); ?>
                   <?= $form->field($model, 'pangkat_ttd')->hiddenInput(); ?>
                   <?= $form->field($model, 'jabatan_ttd')->hiddenInput(); ?>
               </div>
           </div>
			
			
</div>
      <hr style="border-color: #c7c7c7;margin: 10px 0;">
      <div class="box-footer" style="text-align: center;">
            <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
          <?php if(!$model->isNewRecord): ?>  
            <a class="btn btn-warning" href="<?= Url::to(['pdm-d2/cetak?no_eksekusi=' . $model->no_eksekusi]) ?>">Cetak</a>
          <?php endif ?>  
        </div>

        <?php ActiveForm::end(); ?>
	

<?php
Modal::begin([
    'id' => 'm_jpu',
    'header' => '<h7>Pilih Jaksa</h7>'
]);

?>
<?=
$this->render('_m_jpu', [
    'model' => $model,
    'searchJPU' => $searchJPU,
    'dataJPU' => $dataJPU,
])
?>
<?php
Modal::end();
?> 
		
</div>
</section>		

