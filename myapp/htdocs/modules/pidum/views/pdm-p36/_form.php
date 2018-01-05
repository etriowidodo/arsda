<?php

use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\VwPenandatangan;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use kartik\widgets\TimePicker;
use kartik\widgets\FileInput;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP36 */
/* @var $form yii\widgets\ActiveForm */
?>

<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">

        <?php
        $form = ActiveForm::begin(
                        [
                            'id' => 'p36-form',
                            'type' => ActiveForm::TYPE_HORIZONTAL,
                            'enableAjaxValidation' => false,
                            'fieldConfig' => [
                                'autoPlaceholder' => false
                            ],
                            'formConfig' => [
                                'deviceSize' => ActiveForm::SIZE_SMALL,
                                'labelSpan' => 2,
                                'showLabels' => false
                            ]
        ]);
        ?>

        <?= $this->render('//default/_formHeaderV', ['form' => $form, 'model' => $model, 'kode'=>'_p36']) ?>

        <!-- <div class="box box-primary" style="border-color: #f39c12;padding: 12px 15px 20px 15px;overflow: hidden;"> -->
        <div class="box box-warning">
            <div class="box-header with-border" style="padding-left:0px;">
                <div class="col-md-6" style="padding-left:6px">
                    <h3 class="box-title">Tempat dan Waktu Persidangan</h3>
                </div>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label class="control-label col-sm-2">Tersangka</label>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'tersangka')->textarea() ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2">Pengadilan</label>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'pengadilan')->textInput(['value' => ($model->isNewRecord)? Yii::$app->globalfunc->GetConfSatker()->p_negeri : $model->pengadilan]) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Alamat</label>
                    <div class="col-sm-4">
                        <?php echo $form->field($model, 'alamat')->textarea(['colspan' => '6', 'value' => ($model->isNewRecord)? Yii::$app->globalfunc->GetConfSatker()->alamat_p_negeri : $model->alamat]) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Tanggal</label>
                    <div class="col-sm-4">
                        <?php
                        echo $form->field($model, 'tgl_sidang')->widget(DateControl::className(), [
                            'type' => DateControl::FORMAT_DATE,
                            'ajaxConversion' => false,
                            'options' => [
                                'options' => [
                                    'placeholder' => 'Tanggal Sidang',
                                ],
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'startDate' => '-1m',
                                    'endDate' => '+1y'
                                ]
                            ]
                        ]);
                        ?>
                    </div>
                    <label class="control-label col-sm-1">Jam</label>
                    <div class="col-sm-2">
                        <?php
                   
                            echo $form->field($model, 'jam')->widget(TimePicker::classname(), [
                                'pluginOptions'=>[
                                    //'template'=>false,
                                    'defaultTime'=>false,
                                    'showSeconds'=>false,
                                    'showMeridian'=>false,
                                    'minuteStep'=>1,
                                ],
                              ]);
                            
                        ?>
                    </div>
                </div>

                

            </div>
        </div>

        <div class="box box-primary" style="border-color: #f39c12">
        <div class="box-header with-border" style="border-color: #c7c7c7;">
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Upload File</label>
                        <div class="col-md-6">
                            <?php
                            $preview = "";
                            if($model->file_upload!=""){
                               echo '<object width="160px" id="print" height="160px" data="'.$model->file_upload.'"></object>'; 
                            }
                            echo FileInput::widget([
                                'name' => 'attachment_3',
                                'id'   =>  'filePicker',
                                'pluginOptions' => [
                                    'showPreview' => true,
                                    'showCaption' => true,
                                    'showRemove' => true,
                                    'showUpload' => false,
                                    'initialPreview' =>  $preview
                                ],
                            ]);
                            ?>
                            
                            
                            <?= $form->field($model, 'file_upload')->hiddenInput()?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::P36, 'id_table' => $model->no_surat_p36]) ?>
        <div class="box-footer">
            <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning', 'id' => 'input_ubah']) ?>
            <?php if (!$model->isNewRecord): ?>    
                <?= Html::a('Cetak', ['cetak', 'id' => rawurldecode($model->no_surat_p36)], ['class' => 'btn btn-warning']) ?>
            <?php endif ?>
        </div>
    </div>
    
    <?= $form->field($model, 'nama_ttd')->hiddenInput() ?>
    <?= $form->field($model, 'pangkat_ttd')->hiddenInput() ?>
    <?= $form->field($model, 'jabatan_ttd')->hiddenInput() ?>
    <?php ActiveForm::end(); ?>
</section>

<?php

$this->registerJs( "
    var handleFileSelect = function(evt) {
         var files = evt.target.files;
         var file = files[0];

         if (files && file) {
             var reader = new FileReader();
             // console.log(file);
             reader.onload = function(readerEvt) {
                 var binaryString = readerEvt.target.result;
                 var mime = 'data:'+file.type+';base64,';
                 console.log(mime);
                 document.getElementById('pdmp36-file_upload').value = mime+btoa(binaryString);
                 // window.open(mime+btoa(binaryString));
             };
             reader.readAsBinaryString(file);
         }
     };

     if (window.File && window.FileReader && window.FileList && window.Blob) {
         document.getElementById('filePicker').addEventListener('change', handleFileSelect, false);
     } else {
         alert('The File APIs are not fully supported in this browser.');
     }

 ", \yii\web\View::POS_END);
?>