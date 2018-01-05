<?php
use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\PdmPenandatangan;
use app\modules\pdsold\models\VwTerdakwa;
use app\modules\pdsold\models\VwTerdakwaT2;
use kartik\datecontrol\DateControl;
use kartik\widgets\TimePicker;
use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP30 */
/* @var $form yii\widgets\ActiveForm */
?>

<section class="content" style="padding: 0">
    <div class="content-wrapper-1">
        <?php
        $form = ActiveForm::begin(
            [
                'id' => 'p33-form',
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'enableAjaxValidation' => false,
                'fieldConfig' => [
                    'autoPlaceholder' => false
                ],
                'formConfig' => [
                    'deviceSize' => ActiveForm::SIZE_SMALL,
                    'labelSpan' => 1,
                    'showLabels' => false,
                ]
            ]
        )
        ?>
        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="form-group">
                <label class="control-label col-sm-2">Tanggal surat</label>
                <div class="col-sm-3">
                    <?=
                    $form->field($model, 'tgl_p33')->widget(DateControl::className(), [
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

        <!-- </div> -->
        <!-- end tab satu -->

        <!-- tab dua -->
        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="form-group">
                <label class="control-label col-sm-2">Nama Penerima</label>
                <div class="col-sm-3">
                   <?= $form->field($model, 'nama')?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2">Alamat Penerima</label>
                <div class="col-sm-6">
                   <?= $form->field($model, 'alamat')->textarea()?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2">Pekerjaan Penerima</label>
                <div class="col-sm-3">
                   <?= $form->field($model, 'pekerjaan')?>
                </div>
            </div>
        </div>
        <!-- end tab dua -->

        <!-- tab tiga -->
<!--            <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
                <div class="form-group">
                    <label class="control-label col-sm-2">Terdakwa</label>
                    <div class="col-sm-4">
                        <?php
                            //echo $form->field($model, 'id_tersangka')->dropDownList(
                            //ArrayHelper::map(VwTerdakwaT2::find()->where(['no_register_perkara'=>$no_register_perkara])->all(), 'no_urut_tersangka', 'nama'), ['prompt' => 'Pilih Tersangka']);
                        ?>
                    </div>
                </div>
            </div>-->
        <!-- end tab tiga -->

        <!-- tab empat -->
       <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="form-group">
                <label class="control-label col-sm-2">Di keluarkan</label>
                <div class="col-sm-3">
                    <?= $form->field($model, 'dikeluarkan')->textInput(['placeholder' => 'Bertempat di','value' => \Yii::$app->globalfunc->getSatker()->inst_lokinst]); ?>
                </div>
                <label class="control-label col-sm-2">Tanggal dkeluarkan</label>
                <div class="col-sm-3">
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
            </div>
            <div class="form-group">
                <div class="col-sm-12" style="margin-left: -15px">
                    <div class="col-sm-6">
                        <?php
                        if ($model->isNewRecord) {?>
                        <div class="form-group field-pdmjaksasaksi-nama required">
                            <label class="control-label col-md-4">Petugas Kejaksaan</label>
                            <div class="input-group">
                                <input type="text" id="pdmjaksasaksi-nama" class="form-control" name="PdmJaksaSaksi[nama]" style="margin-left: 20px">
                                <div class="input-group-btn">
                                    <a class="btn btn-warning" data-toggle="modal" data-target="#m_jpu" style="margin-left: 20px">Pilih</a>
                                </div>
                            </div>
                        </div>
                        <?php
                            } else {
                        ?>
                            <div class="form-group field-pdmjaksasaksi-nama required">
                                <label class="control-label col-md-4">Petugas Kejaksaan</label>
                                    <div class="input-group">
                                        <input value ="<?= $modelpeg['nama']?>" type="text" id="pdmjaksasaksi-nama" class="form-control" name="PdmJaksaSaksi[nama]" style="margin-left: 20px">
                                        <div class="input-group-btn">
                                            <a class="btn btn-warning" data-toggle="modal" data-target="#m_jpu" style="margin-left: 20px">Pilih</a>
                                        </div>
                                    </div>
                                <?php
//                                echo $form->field($modelpeg, 'peg_nip_baru')->hiddenInput();
//                                echo $form->field($modelpeg, 'nama')->hiddenInput();
//                                echo $form->field($modelpeg, 'gol_pangkat2')->hiddenInput();
                                ?>
                                <div class="col-sm-12"></div>
                                <div class="col-sm-12">
                                    <div class="help-block"></div>
                                </div>
                            </div>
                        <?php
                        }
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
                                        $preview = ["<a href='".$model->file_upload."' target='_blank'><div class='file-preview-text'><h2><i class='glyphicon glyphicon-file'></i></h2></div></a>"
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
                                    
                                    
                                    <?= $form->field($model, 'file_upload')->hiddenInput()?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


           <div class="box-footer" style="text-align: center;">
                <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
               </a>
               
           <?php
           if ($model->isNewRecord){ ?>
            <a class="btn btn-warning" href="<?= \yii\helpers\Url::to(["pdm-p33/cetak_draft?id=".$no_register_perkara])?>">Cetak Draft</a>
           <?php }else{ ?>
            <a class="btn btn-warning" href="<?= \yii\helpers\Url::to(["pdm-p33/cetak?id=".$no_register_perkara])?>">Cetak</a>
           <?php } 
//           if(!$model->isNewRecord ){
//               echo $form->field($modeljaksi, 'nip')->hiddenInput();
//               echo $form->field($modeljaksi, 'jabatan')->hiddenInput();
//               echo $form->field($modeljaksi, 'pangkat')->hiddenInput();
//           }else{
//               echo Html::hiddenInput('PdmJaksaSaksi[nip]', NULL, ['id' => 'pdmjaksasaksi-nip']);
//               echo Html::hiddenInput('PdmJaksaSaksi[nama]', NULL, ['id' => 'pdmjaksasaksi-nama']);
//               echo Html::hiddenInput('PdmJaksaSaksi[pangkat]', NULL, ['id' => 'pdmjaksasaksi-pangkat']);
               echo Html::hiddenInput('PdmJaksaSaksi[nip]', $model->nip_pegawai, ['id' => 'pdmjaksasaksi-nip']);
//               echo Html::hiddenInput('PdmJaksaSaksi[nama]', $model->nama_pegawai, ['id' => 'pdmjaksasaksi-nama']);
               echo Html::hiddenInput('PdmJaksaSaksi[pangkat]', $model->pangkat_pegawai, ['id' => 'pdmjaksasaksi-pangkat']);
//           }
           ?>
            </div>
        <?php ActiveForm::end(); ?>
        
        
    </div>
</section>
<?php
Modal::begin([
    'id' => 'm_jpu',
    'header' => 'Data Pegawai Kejaksaan',
    'options' => [
        'data-url' => '',
    ],
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
                    document.getElementById('pdmp33-file_upload').value = mime+btoa(binaryString);
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


    $(document).ready(function(){
  
    

}); ", \yii\web\View::POS_END);
?>