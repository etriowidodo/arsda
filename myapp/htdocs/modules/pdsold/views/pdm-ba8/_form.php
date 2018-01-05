<?php

use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use kartik\widgets\FileInput;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmT9 */
/* @var $form yii\widgets\ActiveForm */
?>

<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">
        <?php
        $form = ActiveForm::begin(
                        [
                            'id' => 'BA8-form',
                            'type' => ActiveForm::TYPE_HORIZONTAL,
                            'enableAjaxValidation' => false,
                            'fieldConfig' => [
                                'autoPlaceholder' => false
                            ],
                            'formConfig' => [
                                'deviceSize' => ActiveForm::SIZE_SMALL,
                                'labelSpan' => 1,
                                'showLabels' => false
                            ],
                            'options' => [
                                'enctype' => 'multipart/form-data',
                            ]
        ]);
        
        ?>

        <div class="box box-primary" style="border-color: #f39c12;padding: 15px 15px 0px 15px;overflow: hidden;">
            <div class="col-md-12">
                <div class="col-md-6">
                   <div class="form-group">
                        <label class="control-label col-md-4">Tanggal Berita Acara</label>
                        <div class="col-md-4">
                            <?=
                            $form->field($model, 'tgl_ba8')->widget(DateControl::className(), [
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
                        <label class="control-label col-md-4">Dari Penahanan</label>
                        <div class="col-md-8">
                            <?php
                            $penahan = (new \yii\db\Query())
                                    ->select('id_loktahanan,nama')
                                    ->from('pidum.ms_loktahanan')
                                    ->all();
                            $lists = ArrayHelper::map($penahan, 'id_loktahanan', 'nama');
                            echo $form->field($model, 'tahanan')->dropDownList($lists, ['prompt' => '---Pilih---'], ['label' => '']);
                            ?>
                      </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Menjadi</label>
                        <div class="col-md-8">
                              <?php
                            $ketahanan = (new \yii\db\Query())
                                    ->select('id_loktahanan,nama')
                                    ->from('pidum.ms_loktahanan')
                                    ->all();
                            $list = ArrayHelper::map($ketahanan, 'id_loktahanan', 'nama');
                            echo $form->field($model, 'ke_tahanan')->dropDownList($list, ['prompt' => '---Pilih---'], ['label' => '']);
                            ?>
                    
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
            <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Kepala Rutan</label>
                            <div class="col-md-8">
                                 <?= $form->field($model, 'kepala_rutan') ?>
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
            <!--end box box-primary-->
        </div>
         <?= $form->field($model, 'upload_file')->hiddenInput() ?>
         <?= $form->field($model, 'no_surat_t7')->hiddenInput() ?>
      <hr style="border-color: #c7c7c7;margin: 10px 0;">
      <div class="box-footer" style="text-align: center;">
          
            <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => 'btn btn-warning']) ?>
             <?php if(!$model->isNewRecord): ?>       
            <a class="btn btn-warning" href="<?= Url::to(['pdm-ba8/cetak?no_register_perkara=' . $model->no_register_perkara.'&tgl_ba8='.$model->tgl_ba8]) ?>">Cetak</a>
          <?php endif ?>
      </div>
    </div>
    <!--end content-wrapper-1-->

</section>
<!--end section-->

<?php 

?>

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
                    document.getElementById("pdmba8-upload_file").value = mime+btoa(binaryString);
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
                    $('#m_tersangka').load('/pdsold/pdm-ba8/refer-tersangka');
                    $('#m_tersangka').modal('show');                    
            });


JS;
$this->registerJs($script);
?>
<br>
