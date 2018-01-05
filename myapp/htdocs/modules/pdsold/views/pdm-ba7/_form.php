<?php

use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmT9 */
/* @var $form yii\widgets\ActiveForm */
?>

<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">
        <?php
        $form = ActiveForm::begin(
                        [
                            'id' => 'BA10-form',
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

            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Tanggal Berita Acara</label>
                        <div class="col-md-8">
                            <?=
                            $form->field($model, 'tgl_ba7')->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'options' => [
                                    'pluginOptions' => [
                                        'autoclose' => true
                                    ]
                                ]
                            ]);
                            ?>
                        </div>

                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group"> 
                        <label class="control-label col-md-4">Nama Terdakwa</label>
                                <div class="col-md-8">
                                    <?php
                                    echo $form->field($model, 'nama_tersangka_ba4', [
                                        'addon' => [
                                            'append' => [
                                                'content' => Html::a('Pilih', 'javascript:void(0)', ['id'=>'show_tersangka','class' => 'btn btn-warning']),
                                                'asButton' => true
                                            ]
                                        ]
                                    ]);
                                    ?>
                                </div>
                    </div>
                </div>

            </div>
             <div class="col-md-12"> 

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Nomor Surat T7</label>
                        <div class="col-md-8">
                            <?= $form->field($modelT7, 'no_surat_t7')->textInput(['readonly'=>true ]) ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Tanggal Dikeluarkan T7</label>
                        <div class="col-md-8">
                            <?= $form->field($modelT7,'tgl_dikeluarkan')->textInput(['value' => ($modelT7->tgl_dikeluarkan=="")?"":date('d-m-Y', strtotime($modelT7->tgl_mulai)), 'readonly'=>true]) ?>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-12"> 

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Jenis Penahanan</label>
                        <div class="col-md-8">
                            <?= $form->field($modelT7, 'no_surat_t7')->textInput(['id'=>'tindakan_status','value' => $modelT7->tindakanStatus->nama, 'readonly'=>true]) ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Tanggal Mulai Tahanan</label>
                        <div class="col-md-8">
                            <?= $form->field($modelT7,'tgl_mulai')->textInput(['value' => ($modelT7->tgl_mulai=="")?"":date('d-m-Y', strtotime($modelT7->tgl_mulai)), 'readonly'=>true]) ?>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-12">
                <div class="col-md-6">    
                    <div class="form-group">
                        <label class="control-label col-md-4">Tahanan</label>
                        <div class="col-md-8">
                            <?= $form->field($modelT7, 'no_surat_t7')->textInput(['id'=>'lok_tahanan','value' => $modelT7->lokTahanan->nama, 'readonly'=>true]) ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Selama</label>
                        <div class="col-md-2">
                            <?= $form->field($modelT7, 'lama')->textInput(['readonly'=>true]);?>
                        </div>
                        <div class="col-md-2" style="margin-left:-22px;">Hari</div>
                    </div>
                </div>
            </div>


            <div class="col-md-12"> 
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Kepala Rutan</label>
                        <div class="col-md-8"><?= $form->field($model, 'kepala_rutan') ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4">Upload File</label>
                             <div class="col-md-8">
                                     <?php 
                                // echo '<label class="control-label col-md-4">Upload Document</label>';
                                     $preview = "";
                                     if($model->upload_file!="")
                                     {
                                        $preview =  [
                                                    "<a href='".$model->upload_file."' target='_blank'><div class='file-preview-text'><h2><i class='glyphicon glyphicon-file'></i></h2></div></a>"
                                                     ];
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
                                    <!-- <a href="<?= $model->upload_file?>">Lihat File</a>
                                    <input id="filePicker" type="file" /> -->
                                </div>
                        </div>
                </div>

            </div>

             <?= $form->field($model, 'no_surat_t7')->hiddenInput() ?>
             <?= $form->field($model, 'upload_file')->hiddenInput() ?>
        </div>
        <hr style="border-color: #c7c7c7;margin: 10px 0;">
      <div class="box-footer" style="text-align: center;">
            <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
            <?php if(!$model->isNewRecord): ?>
                <a class="btn btn-warning" href="<?= Url::to(['pdm-ba7/cetak?no_register_perkara='.$model->no_register_perkara.'&tgl_ba7='.$model->tgl_ba7]) ?>">Cetak</a>
            <?php endif ?>  
            </div>

    </div>



</section>
<?php ActiveForm::end(); ?>

<?php
Modal::begin([
    'id' => 'm_tersangka',
    'header' => '<h7>Data Tersangka</h7>'
]);
?> 

<?php
Modal::end();
?> 
<?php
$script = <<< JS
        var handleFileSelect = function(evt) {
            var files = evt.target.files;
            var file = files[0];

            if (files && file) {
                var reader = new FileReader();
                // console.log(file);
                reader.onload = function(readerEvt) {
                    var binaryString = readerEvt.target.result;
                    var mime = "data:"+file.type+";base64,";
                    console.log(mime);
                    document.getElementById("pdmba7-upload_file").value = mime+btoa(binaryString);
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



            $('.tambah-tembusan').click(function(){
                $('.tembusan').append(
               '<br /><input type="text" class="form-control" style="margin-left:60px"name="mytext[]">'
                )
            });
             $('#show_tersangka').click(function(){                
                    $('#m_tersangka').html('');
                    $('#m_tersangka').load('/pdsold/pdm-ba7/refer-tersangka');
                    $('#m_tersangka').modal('show');                    
            });


JS;
$this->registerJs($script);
?>
<br>





