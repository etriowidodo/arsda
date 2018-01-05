<?php

use app\components\GlobalConstMenuComponent;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use kartik\widgets\FileInput;
use app\modules\pdsold\models\MsLoktahanan;
use yii\web\Session;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\pdmt7 */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="panel box box-warning">
    <div class="box-header">
    </div>
    <?php
    $form = ActiveForm::begin(
                    [
                        'id' => 't7-form',
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

    <div class="box-body">
        
        
        
        <div class="col-md-6">
                 <div class="form-group">
                    <label class="control-label col-md-4">Nomor Surat T7</label>
                    <div class="col-md-7">
                        <?= $form->field($model, 'no_surat_t7')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>    
        </div>
        <div class="col-md-6">
                 <div class="form-group">
                    <label class="control-label col-md-4">No Reg Tahanan Kejaksaan</label>
                    <div class="col-md-7">
                        <?= $form->field($model, 'no_reg_tahanan_jaksa')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>    
        </div>
        <div class="clearfix"></div>
        <div class="col-md-6">
             <div class="form-group">
                    <label class="control-label col-md-4">Undang-undang No</label>
                    <div class="col-md-4"> 
                        <?= $form->field($model, 'undang')->textInput(['maxlength' => true]) ?>
                    </div>
                     <label class="control-label col-md-1">Tahun</label>
                    <div class="col-md-2"> 
                        <?= $form->field($model, 'tahun')->textInput(['maxlength' => true]) ?>
                    </div>
                </div> 
        </div>
        <div class="col-md-6">
                 <div class="form-group">
                     <label class="control-label col-md-3">Tentang</label>
                        <div class="col-md-8"> 
                            <?= $form->field($model, 'tentang')->textInput(['maxlength' => true]) ?>
                        </div>
                </div>    
        </div>

           <div class="clearfix"></div>

        
       
        <div class="col-md-6">
             <div class="form-group">
                     <label class="control-label col-md-4">Surat Perintah Penahanan Dari</label>
                        <div class="col-md-7"> 
                            <?= $form->field($model, 'penahanan_dari')->textInput(['maxlength' => true]) ?>
                        </div>
                </div> 
        </div>
        <div class="col-md-6">
                 <div class="form-group">
                     <label class="control-label col-md-3">No Surat</label>
                        <div class="col-md-4"> 
                            <?= $form->field($model, 'no_surat_perintah')->textInput(['maxlength' => true]) ?>
                        </div>
                        <label class="control-label col-md-1">Tanggal</label>
                        <div class="col-md-3"> 
                            <?=
                            $form->field($model, 'tgl_srt_perintah')->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'options' => [
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                    ]
                                ]
                            ]);
                            ?>
                        </div>
                </div>    
        </div>
           <div class="clearfix"></div>

        <div class="box box-warning"><!-- 
            <div class="box-header with-border">
                <h3 class="box-title">
                    <i class="glyphicon glyphicon-user"></i> Terdakwa
                </h3>

                
            </div> -->
             <div class="box-body">
                    <div class="col-md-6">
                    <div class="form-group">
                        <label for="tindakan_status" class="control-label col-sm-4">Tindakan</label>
                        <div class="col-sm-6">
                              <?php $tindakan_status = ArrayHelper::map($modelTindakanStatus, 'id', 'nama') ?>
                            <?= $form->field($model, 'tindakan_status')->dropDownList($tindakan_status, ['prompt' => '---Pilih---']) ?>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" style="padding-left: 10px;">
                        <label class="control-label col-md-3">Nama Terdakwa</label>
                                <div class="col-md-6">
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
                    <div class="clearfix"></div>
                    <div class="col-md-6">
                        <div class="form-group">
                             <label class="control-label col-md-4">Jaksa Penuntut Umum</label>
                                    <div class="col-md-6">
                                        <?php
                                        echo $form->field($model, 'nama_jaksa', [
                                            'addon' => [
                                                'append' => [
                                                    'content' => Html::a('Pilih', '', ['class' => 'btn btn-warning', 'data-toggle' => 'modal', 'data-target' => '#m_jpu']),
                                                    'asButton' => true
                                                ]
                                            ]
                                        ]);
                                        ?>
                                    </div>
                        </div>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label col-md-3">Tahanan</label>
                                <div class="col-md-6 kejaksaan">
                                    <?=
                                    $form->field($model, 'id_ms_loktahanan')->dropDownList(
                                            ArrayHelper::map(MsLoktahanan::find()->all(), 'id_loktahanan', 'nama'), ['prompt' => 'Pilih Jenis Tahanan',
                                            ]
                                    )
                                    ?>
                                </div>
                        </div>
                    <div class="clearfix"></div>
                    <div class="col-md-6">
                        <div class="form-group">
                             <label class="control-label col-md-4">Lokasi Tahanan</label>
                                <div class="col-md-6"> 
                                    <?= $form->field($model, 'lokasi_tahanan')->textInput(['maxlength' => true]) ?>
                                </div>
                        </div>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label col-md-3">Selama</label>
                                <div class="col-md-4"> 
                                    <?= $form->field($model, 'lama')->textInput(['maxlength' => true]) ?>
                                </div>
                            <label class="control-label col-md-1">Tanggal</label>
                                <div class="col-md-3"> 
                                    <?=
                                    $form->field($model, 'tgl_mulai')->widget(DateControl::className(), [
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
                    <div class="clearfix"></div>

            </div>
            
        </div>
 <div class="box box-warning">
             <div class="box-body">
        <div class="form-group">
            <label class="control-label col-md-2">Dikeluarkan Di</label>
            <div class="col-md-3"> 
                <?= $form->field($model, 'dikeluarkan')->textInput(['value' => \Yii::$app->globalfunc->getSatker()->inst_lokinst]) ?>
            </div>
            <label class="control-label col-md-1">Tanggal</label>
            <div class="col-md-2"> 
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
                ?>
            </div>
             <label class="control-label col-md-1">Upload File</label>

            <div class="col-md-3">
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
        <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::T7, 'id_table' => $model->no_surat_t7]) ?>

        <div class="box-footer" style="text-align: center;">
            <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
            <?php if (!$model->isNewRecord): ?>    
                <?= Html::a('Cetak', ['cetak', 'no_register_perkara'=>$model->no_register_perkara,'no_surat_t7' => $model->no_surat_t7], ['class' => 'btn btn-warning']) ?>
            <?php endif ?>
        </div>
    </div>
       <?= $form->field($model, 'tgl_ba4')->hiddenInput() ?>
         <?= $form->field($model, 'no_urut_tersangka')->hiddenInput() ?>
         <?= $form->field($model, 'no_surat_p16a')->hiddenInput() ?>
         <?= $form->field($model, 'upload_file')->hiddenInput() ?>
          <?= $form->field($model, 'no_jaksa_p16a')->hiddenInput()  ?>
          <?= $form->field($model, 'nama')->hiddenInput()  ?>
          <?= $form->field($model, 'pangkat')->hiddenInput()  ?>
          <?= $form->field($model, 'jabatan')->hiddenInput()  ?>
    <?php ActiveForm::end(); ?>

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
                    document.getElementById("pdmt7-upload_file").value = mime+btoa(binaryString);
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
            $('#m_tersangka').load('/pdsold/pdm-t7/refer-tersangka');
            $('#m_tersangka').modal('show');
                    
            });
JS;
    $this->registerJs($script);
    ?>

</div>


<?php
Modal::begin([
    'id' => 'm_jpu',
    'header' => 'Data JPU',
    'options' => [
        'data-url' => '',
    ],
]);
?> 

<?=
$this->render('_m_jpu', [
    'model' => $model,
    'searchJPU' => $searchJPU,
    'dataProviderJPU' => $dataProviderJPU,
])
?>

<?php
Modal::end();
?>

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