<?php

use app\modules\pdsold\models\PdmP47;

use app\modules\pdsold\models\VwPenandatangan;
use dosamigos\ckeditor\CKEditorAsset;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm as ActiveForm2;
use yii\widgets\MaskedInput;
CKEditorAsset::register($this);
/* @var $this View */
/* @var $model PdmP47 */
/* @var $form ActiveForm2 */
?>

<div class="pdm-p47-form">

    <?php
    $form = ActiveForm::begin(
                    [
                        'id' => 'p47-form',
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

    <div class="col-sm-12">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">

                </h3>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label class="control-label col-sm-1">Dikeluarkan</label>
                    <div class="col-sm-3">
                        <?php
                        if ($model->isNewRecord) {
                            echo $form->field($model, 'dikeluarkan')->input('text', ['value' => Yii::$app->globalfunc->getSatker()->inst_lokinst]);
                        } else {
                            echo $form->field($model, 'dikeluarkan');
                        }
                        ?>
                    </div>
                    <div class="col-sm-2"><?=
                        $form->field($model, 'tgl_dikeluarkan')->widget(DateControl::className(), [
                            'type' => DateControl::FORMAT_DATE,
                            'ajaxConversion' => false,
                            'options' => [
                                'options' => [
                                    'placeholder' => 'Tanggal Terima',
                                ],
                                'pluginOptions' => [
                                    'autoclose' => true
                                ]
                            ]
                        ]);
                        ?></div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-1">Kepada Yth</label>
                    <div class="col-sm-3">
                        <?php
                        echo $form->field($model, 'kepada');
                        ?>
                    </div>

                </div>
                <div class="form-group">
                    <label class="control-label col-sm-1">Di</label>
                    <div class="col-sm-3">
                        <?php
                        echo $form->field($model, 'di_kepada');
                        ?>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">
                    <i class="glyphicon glyphicon-user"></i> Terdakwa
                </h3>
            </div>
            <div class="box-body">
                <div class='form-group'>
                    <label class='control-label col-sm-2'>Nama</label>
                    <div class='col-sm-4'><?= $terdakwa->nama?></div>
                </div>
                <div class='form-group'>
                    <label class='control-label col-sm-2'>Tempat Lahir</label>
                    <div class='col-sm-4'><?= $terdakwa->tmpt_lahir?></div>
                </div>
                <div class='form-group'>
                    <label class='control-label col-sm-2'>Tanggal Lahir</label>
                    <div class='col-sm-4'><?= $terdakwa->tgl_lahir?></div>
                </div>
                <div class='form-group'>
                    <label class='control-label col-sm-2'>Jenis Kelamin</label>
                    <div class='col-sm-4'><?= $terdakwa->is_jkl?></div>
                </div>
                <div class='form-group'>
                    <label class='control-label col-sm-2'>Tempat Tinggal</label>
                    <div class='col-sm-4'><?= $terdakwa->alamat?></div>
                </div>
                <div class='form-group'>
                    <label class='control-label col-sm-2'>Agama</label>
                    <div class='col-sm-4'><?= $terdakwa->is_agama?></div>
                </div>
                <div class='form-group'>
                    <label class='control-label col-sm-2'>Pekerjaan</label>
                    <div class='col-sm-4'><?= $terdakwa->pekerjaan?></div>
                </div>
                <div class='form-group'>
                    <label class='control-label col-sm-2'>Pendidikan</label>
                    <div class='col-sm-4'><?= $terdakwa->is_pendidikan ?></div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Dakwaan</label>
                    <div class="col-sm-4">
                        <?php echo $form->field($model, 'dakwaan')->textarea() ?>

                        <?php
                        $this->registerCss("div[contenteditable] {
                                outline: 1px solid #d2d6de;
                                min-height: 100px;
                            }");
                        $this->registerJs("
                                CKEDITOR.inline( 'PdmP47[dakwaan]');
                                CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
                                CKEDITOR.config.autoParagraph = false;

                            ");
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2"></label>
                    <div class="col-sm-8">
                        <?= $form->field($model, 'pengadilan')->radio(['label' => 'Pengadilan Tinggi', 'value' => 1, 'uncheck' => null]) ?>
                        <?= $form->field($model, 'pengadilan')->radio(['label' => 'Pengadilan Negeri', 'value' => 0, 'uncheck' => null]) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Pengadilan Tinggi/Negeri</label>
                    <div class="col-sm-4">
                        <?php echo $form->field($model, 'pengadilan_negeri')->textInput(['placeholder'=>'Cth. Jakarta Selatan']) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Lokasi</label>
                    <div class="col-sm-4">
                        <?php echo $form->field($model, 'lokasi')->textInput(['placeholder'=>'Cth. Jl.Ahmad Yani...']) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Alasan</label>
                    <div class="col-sm-4">
                        <?php echo $form->field($model, 'alasan')->textarea() ?>

                        <?php
                        $this->registerCss("div[contenteditable] {
                                outline: 1px solid #d2d6de;
                                min-height: 100px;
                            }");
                        $this->registerJs("
                                CKEDITOR.inline( 'PdmP47[alasan]');
                                CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
                                CKEDITOR.config.autoParagraph = false;

                            ");
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Penetapan Hakim</label>
                    <div class="col-sm-4">
                        <?php echo $form->field($model, 'penetapan_hakim')->textarea() ?>

                        <?php
                        $this->registerCss("div[contenteditable] {
                                outline: 1px solid #d2d6de;
                                min-height: 100px;
                            }");
                        $this->registerJs("
                                CKEDITOR.inline( 'PdmP47[penetapan_hakim]');
                                CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
                                CKEDITOR.config.autoParagraph = false;

                            ");
                        ?>
                    </div>
                </div>
               <!--  <div class="form-group">
                    <label class="control-label col-sm-2">Hukuman Pidana</label>
                    <div class="col-sm-4">
                        <?php echo $form->field($model, 'hukpid') ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Biaya Perkara</label>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <div class="input-group-addon">Rp</div>
                                <?= MaskedInput::widget([
                                                                          'name' => 'PdmP47[biaya_perkara]',
                                                                          'value' => $model->biaya_perkara,
                                                                          'mask' => '9',
                                                                          'clientOptions' => [
                                                                              'repeat' => 10, 
                                                                              'greedy' => false
                                                                          ]
                                                                  ]);
                                                                  ?>
                                                              </div>
                    </div>
                </div> -->
                <div class="form-group">
                <label class="control-label col-sm-2">Jaksa</label>
                    <div class="col-sm-4">
                    <?php
                            echo $form->field($model, 'nama_ttd', [
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
                <div class="form-group">
                    <div class="col-md-6">
                    <div class="box-header with-border">
                        <div class="col-md-12" style="padding: 0px; margin-bottom: 10px">
                            <h3 class="box-title">
                                <a class='btn btn-danger delete hapus hapuspertimbangan'></a>
                                &nbsp;
                                <a class="btn btn-primary tambah_pertimbangan">+ Pertimbangan</a>
                            </h3>
                        </div>
                        <table id="table_grid_timbang" class="table table-bordered table-striped">
                            <thead>
                                <th></th>
                                <th style="width: 96%"></th>
                            </thead>
                            <tbody id="tbody_grid_timbang">
                            <?php if(!$model->isNewRecord){ ?>
                                <?php $pertimbangan = json_decode($model->pertimbangan);//foreach($penasehat_hkm as $value): ?>
                                <?php for($i=0; $i < count($pertimbangan);$i++){ ?>
                                    <tr>
                                        <td style="height: 70px"><input type='checkbox' name='new_check[]' class='hapusTimbang'></td>
                                        <td width="98%"><textarea name="txt_nama_timbang[]" id=""  type='textarea' class='form-control'><?=$pertimbangan[$i]?></textarea></td>
                                    </tr>
                                    <?php } ?>
                            <?php }else{ ?>
                                    <tr>
                                        <td style="height: 70px"><input type='checkbox' name='new_check[]' class='hapusTimbang'></td>
                                        <td width="98%"><textarea name="txt_nama_timbang[]" id=""  type='textarea' class='form-control'>Tidak menerapkan atau menetapkan penuuran hukum tidak sebagaimana mestinya yakni dalam hal....</textarea></td>
                                    </tr>
                                    <tr>
                                        <td style="height: 70px"><input type='checkbox' name='new_check[]' class='hapusTimbang'></td>
                                        <td width="98%"><textarea name="txt_nama_timbang[]" id=""  type='textarea' class='form-control'>Dalam cara mengadili tidak dilaksanakan menurut ketentuan Undang-uadang yakni dalam hal.. </textarea></td>
                                    </tr>
                                    <tr>
                                        <td style="height: 70px"><input type='checkbox' name='new_check[]' class='hapusTimbang'></td>
                                        <td width="98%"><textarea name="txt_nama_timbang[]" id=""  type='textarea' class='form-control'>Melampaui batas kewenangan mengadili dengan cara..</textarea></td>
                                    </tr>
                                
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box-body">   
        <div class="col-md-8 pull-left">   
            <?= Yii::$app->globalfunc->getTembusan($form,'P-47',$this,$model->no_akta, '') ?>

        </div>
    </div>

    <div class="form-group" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
        <?php if (!$model->isNewRecord) { ?>
            <a class="btn btn-warning" href="<?= Url::to(['pdm-p47/cetak?id=' . $model->no_akta]) ?>">Cetak</a>
        <?php } ?>
    </div>
        <?php
                //
                    echo $form->field($model, 'nip_ttd')->hiddenInput();
                    echo $form->field($model, 'jabatan_ttd')->hiddenInput();
                    echo $form->field($model, 'pangkat_ttd')->hiddenInput();
               /* }else{
                    echo Html::hiddenInput('PdmJaksaSaksi[nip]', null, ['id' => 'pdmjaksasaksi-nip']);
                    echo Html::hiddenInput('PdmJaksaSaksi[jabatan]', null, ['id' => 'pdmjaksasaksi-jabatan']);
                    echo Html::hiddenInput('PdmJaksaSaksi[pangkat]', null, ['id' => 'pdmjaksasaksi-pangkat']);
                }*/
                
            ?>

    <?php ActiveForm::end(); ?>

</div>
<?php
Modal::begin([
    'id' => 'm_jpu',
    'header' => 'Data Jaksa Pelaksana',
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
$script1 = <<< JS
    var id=1;
    $('.tambah_pertimbangan').on('click', function() {
        $("#table_grid_timbang > tbody").append("<tr id='"+id+"'><td><input type='checkbox' name='new_check[]' class='hapusTimbang'></td><td><textarea type='textarea' class='form-control' name='txt_nama_timbang[]' /></td></tr>");
        
        $(".date-picker").kvDatepicker({
            format:'dd-m-yyyy',
            autoclose: true
        });
        id++;
    });
        
    $('.hapuspertimbangan').click(function(){
         $.each($('input[type=\"checkbox\"][name=\"new_check[]\"]'),function(x)
            {
                var input = $(this);
                if(input.prop('checked')==true)
                {   var id = input.parent().parent();
                    id.remove();
                }
            }
         )
    });
JS;
$this->registerJs($script1);
?>
