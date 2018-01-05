<?php

use app\components\GlobalConstMenuComponent;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use app\modules\pdsold\models\PdmMsStatusT8;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmT8 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="panel box box-warning">
    <div class="box-header"></div>
    <?php
    $form = ActiveForm::begin(
                    [
                        'id' => 't8-form',
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
        <div class="form-group hide">
            <label class="control-label col-md-2">Wilayah Kerja</label>
            <div class="col-md-4">
                <input class="form-control" value="<?php echo \Yii::$app->globalfunc->getNamaSatker($modelSpdp->wilayah_kerja)->inst_nama ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Nomor Surat</label>

            <div class="col-md-4"><?= $form->field($model, 'no_surat_t8')->textInput(['placeholder' => 'Nomor Surat']); ?></div>

        </div>



        <div class="form-group">
            <label for="tahun" class="control-label col-md-2">Tgl surat permohonan</label>

            <div class="col-md-4"><?=
                $form->field($model, 'tgl_permohonan')->widget(DateControl::className(), [
                    'type' => DateControl::FORMAT_DATE,
                    'ajaxConversion' => false,
                    'options' => [
                        'options' => ['placeholder' => 'Tanggal surat permohonan'],
                        'pluginOptions' => [
                            'autoclose' => true
                        ]
                    ]
                ]);
                ?></div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Jaksa Penuntut Umum</label>
            <div class="col-md-4">
                <?php
                if ($model->isNewRecord) {?>
                    <div class="form-group field-pdmjaksasaksi-nama required">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <input type="text" id="pdmjaksasaksi-nama" class="form-control" name="PdmJaksaSaksi[nama]">
                                <div class="input-group-btn">
                                    <a class="btn btn-warning" data-toggle="modal" data-target="#m_jpu">Pilih</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12"></div>
                        <div class="col-sm-12">
                            <div class="help-block"></div>
                        </div>
                    </div>
            <?php
                } else {
            ?>

                    <div class="form-group field-pdmjaksasaksi-nama required">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <input value ="<?= $modeljaksi['nama']?>" type="text" id="pdmjaksasaksi-nama" class="form-control" name="PdmJaksaSaksi[nama]">
                                <div class="input-group-btn">
                                    <a class="btn btn-warning" data-toggle="modal" data-target="#m_jpu">Pilih</a>
                                </div>
                            </div>
                            <?php
                            echo $form->field($modeljaksi, 'no_surat_p16a')->hiddenInput();
                            echo $form->field($modeljaksi, 'no_urut')->hiddenInput();
                            ?>
                        </div>
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
        <div class="form-group">
            <label for="tahun" class="control-label col-md-2">Putusan</label>

            <div class="col-md-4">
                <?php
                if (!$model->isNewRecord) {
                    echo $form->field($model, 'id_ms_status_t8')->dropDownList(
                    ArrayHelper::map(PdmMsStatusT8::find()->all(), 'id', 'nama'), ['prompt' => 'Pilih Putusan']);
                } else {
                    echo $form->field($model, 'id_ms_status_t8')->dropDownList(
                    ArrayHelper::map(PdmMsStatusT8::find()->where('id <= 2')->all(), 'id', 'nama'), ['prompt' => 'Pilih Putusan']);
                }
                ?>
                </div>
            <?php
            echo $form->field($modeljaksi, 'no_surat_p16a')->hiddenInput();
            echo $form->field($modeljaksi, 'no_urut')->hiddenInput();
            ?>
        </div>
        
    </div>    
    <div class="panel box box-warning">
        <div class="box-header with-border">
            <h3 class="box-title">
                <i class="glyphicon glyphicon-user"></i> Terdakwa
            </h3>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Nama</label>
            <div class="col-sm-4">
                <?php
                
                echo Yii::$app->globalfunc->getTerdakwaT2($form, $model, $no_register_perkara, $this);
//                echo Yii::$app->globalfunc->getTerdakwa($form, $model, $modelSpdp, $this);
                ?>
            </div>
        </div>
        <div id="data-terdakwa">
            <?php
            if ($model->id_tersangka != null)
                echo Yii::$app->globalfunc->getIdentitasTerdakwaT2($model->no_register_perkara,$model->id_tersangka);
//                echo 'celek';
            ?>

        </div>
    </div>
<!--    <div class="form-group">
        <label class="control-label col-sm-2">No. Surat T7</label>
        <div class="col-sm-4">
            <?php //$form->field($model, 'no_surat_t7')->textInput(['value' => $no_surat_t7->no_surat_t7, 'readonly' => true]) ?>
        </div>
    </div>-->
    
    <div class="form-group">
        <label class="control-label col-sm-2">Tanggal Penangguhan</label>
        <div class="col-sm-4">
            <?=
            $form->field($model, 'tgl_penangguhan')->widget(DateControl::className(), [
                'type' => DateControl::FORMAT_DATE,
                'ajaxConversion' => false,
                'options' => [
                    'options' => ['placeholder' => 'Tanggal penangguhan'],
                    'pluginOptions' => [
                        'autoclose' => true
                    ]
                ]
            ]);
            ?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2">Terhitung mulai tanggal</label>
        <div class="col-sm-4">
            <?=
            $form->field($model, 'tgl_mulai')->widget(DateControl::className(), [
                'type' => DateControl::FORMAT_DATE,
                'ajaxConversion' => false,
                'options' => [
                    'options' => ['placeholder' => 'Terhitung mulai tanggal'],
                    'pluginOptions' => [
                        'autoclose' => true
                    ]
                ]
            ]);
            ?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2">Jaminan</label>
        <div class="col-sm-4">
            <?= $form->field($model, 'jaminan')->textInput(['placeholder' => 'Jaminan']); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2">Hari Lapor</label>
        <div class="col-sm-4">
            <?= $form->field($model, 'hari_lapor')->textInput(['placeholder' => 'Hari Lapor']); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2">Kepala Rutan</label>
        <div class="col-sm-4">
            <?= $form->field($model, 'kepala_rutan')->textInput(['placeholder' => 'Kepala Rutan']); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2">Dikeluarkan di</label>
        <div class="col-sm-4">
            <?= $form->field($model, 'dikeluarkan')->input('text', ['value' => \Yii::$app->globalfunc->getSatker()->inst_lokinst]) ?>
        </div>
        <div class="col-sm-4">
            <?=
            $form->field($model, 'tgl_dikeluarkan')->widget(DateControl::className(), [
                'type' => DateControl::FORMAT_DATE,
                'ajaxConversion' => false,
                'options' => [
                    'options' => ['placeholder' => 'Tanggal dikeluarkan'],
                    'pluginOptions' => [
                        'autoclose' => true
                    ]
                ]
            ]);
            ?>
        </div>
    </div>
    <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::T8, 'id_table' => $model->no_surat_t8]) ?>


    <div class="box-footer" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
        <?php if (!$model->isNewRecord): ?>
            <a class="btn btn-warning" href="<?= Url::to(['pdm-t8/cetak?id=' . $model->no_surat_t8]) ?>">Cetak</a>
        <?php endif ?>	
        <?php
//        if (!$model->isNewRecord) {
//            echo $form->field($modeljaksi, 'nip')->hiddenInput();
//            echo $form->field($modeljaksi, 'jabatan')->hiddenInput();
//            echo $form->field($modeljaksi, 'pangkat')->hiddenInput();
//            echo $form->field($modeljaksi, 'no_register_perkara')->hiddenInput();
//            echo $form->field($modeljaksi, 'no_surat_p16a')->hiddenInput();
//            echo $form->field($modeljaksi, 'no_urut')->hiddenInput();
//        } else {
            echo Html::hiddenInput('PdmJaksaSaksi[no_register_perkara]', null, ['id' => 'pdmjaksasaksi-no_register_perkara']);
            echo Html::hiddenInput('PdmJaksaSaksi[no_surat_p16a]', null, ['id' => 'pdmjaksasaksi-no_surat_p16a']);
            echo Html::hiddenInput('PdmJaksaSaksi[no_urut]', null, ['id' => 'pdmjaksasaksi-no_urut']);
            echo Html::hiddenInput('PdmJaksaSaksi[nip]', null, ['id' => 'pdmjaksasaksi-nip']);
            echo Html::hiddenInput('PdmJaksaSaksi[jabatan]', null, ['id' => 'pdmjaksasaksi-jabatan']);
            echo Html::hiddenInput('PdmJaksaSaksi[pangkat]', null, ['id' => 'pdmjaksasaksi-pangkat']);
//        }
        ?>
    </div>
</div>
<?php
$script = <<< JS
        $('.tambah-tembusan').click(function(){
            $('.tembusan').append(
           '<br /><input type="text" class="form-control" style="margin-left:60px"name="mytext[]">'
            )
        });

JS;
$this->registerJs($script);
?>

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

