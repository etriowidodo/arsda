<?php

use app\modules\pdsold\models\PdmP46;
use dosamigos\ckeditor\CKEditorAsset;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm as ActiveForm2;
CKEditorAsset::register($this);
/* @var $this View */
/* @var $model PdmP46 */
/* @var $form ActiveForm2 */
?>

<div class="pdm-p46-form">

    <?php
    $form = ActiveForm::begin(
        [
            'id' => 'p46-form',
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
                        if($model->isNewRecord){
                            echo $form->field($model, 'dikeluarkan')->input('text', ['value' => Yii::$app->globalfunc->getSatker()->inst_lokinst]);
                        }else{
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
                    <label class="control-label col-sm-2">Alasan</label>
                    <div class="col-sm-4">
                        <?php echo $form->field($model, 'alasan')->textarea() ?>

                        <?php

                        $this->registerCss("div[contenteditable] {
                                outline: 1px solid #d2d6de;
                                min-height: 100px;
                            }");
                        $this->registerJs("
                                CKEDITOR.inline( 'PdmP46[alasan]');
                                CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
                                CKEDITOR.config.autoParagraph = false;

                            ");
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Pengadilan Tinggi</label>
                    <div class="col-sm-4">
                        <?php $conf = Yii::$app->globalfunc->GetConfSatker();
                        echo $form->field($model, 'pengadilan_tinggi')->textInput(['value'=> $model->isNewRecord ? $conf->p_tinggi : $model->pengadilan_tinggi]); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Biaya Perkara</label>
                    <div class="col-sm-4">
                        <?php echo $form->field($model, 'biaya_perkara'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Tanggal Pengajuan</label>
                    <div class="col-sm-4">
                        <?php echo $form->field($model, 'tgl_pengajuan')->widget(DateControl::className(), [
                            'type' => DateControl::FORMAT_DATE,
                            'ajaxConversion' => false,
                            'options' => [
                                'options' => [
                                    'placeholder' => 'Tanggal Pengajuan',
                                ],
                                'pluginOptions' => [
                                    'autoclose' => true
                                ]
                            ]
                        ]); ?>
                    </div>
                </div>
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
            </div>
        </div>
    </div>

    <div class="form-group" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
        <?php if(!$model->isNewRecord){ ?>
            <a class="btn btn-warning" href="<?= Url::to(['pdm-p46/cetak?id='.$model->no_akta])?>">Cetak</a>
        <?php } ?>
    </div>
	<?php
            //if(!$model->isNewRecord ){
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
