<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use app\models\MsAgama;
use app\models\MsPendidikan;
use app\models\MsJkl;

use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\DugaanPelanggaran */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="modalContent">
    <?php
    $form = ActiveForm::begin([
                'id' => 'dugaan-pelanggaran-modalpelapor',
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


    <div class="box box-primary" style="padding: 15px 0px;">



        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">NIK</label>
                    <div class="col-md-8 kejaksaan">
                        <!--<input id="nik" class="form-control" type="text" maxlength="32">-->
						<?php
						echo MaskedInput::widget([
						'name' => 'nik',
						'mask' => '9',
						'id' => 'nik',
						'clientOptions' => ['repeat' => 20, 'greedy' => false]
					  ]);
						?>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Nama</label>
                    <div class="col-md-8 kejaksaan">
                        <input id="nama" class="form-control" type="text" maxlength="32">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12" style="margin-top: 15px;">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Tempat lahir</label>
                    <div class="col-md-8 kejaksaan">
                        <input id="tempat_lahir" class="form-control" type="text" maxlength="32">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Tanggal lahir</label>
                    <span class="pull-left" style="width: 210px;margin-left: 15px;">
                        <?=
                        $form->field($model, 'tgl_lahir')->widget(DatePicker::classname(), [
                            'options' => ['placeholder' => 'Tanggal Lahir ...', 'id' => 'tgl_lahir'],
                            'type' => DatePicker::TYPE_COMPONENT_APPEND,
                            'pluginOptions' => [
                                'autoclose' => true
                            ],
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'dd-mm-yyyy'
                            ]
                        ]);
                        ?>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Jenis Kelamin</label>
                    <div class="col-md-8 kejaksaan">
                        <?=
                        $form->field($model, 'jkl')->dropDownList(
                                ArrayHelper::map(MsJkl::find()->all(), 'id_jkl', 'nama'), ['prompt' => 'Pilih Jenis Kelamin',
                            'id' => 'jkl'
                                ]
                        )
                        ?>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Pendidikan</label>
                    <div class="col-md-8 kejaksaan">
                        <?=
                        $form->field($model, 'pendidikan')->dropDownList(
                                ArrayHelper::map(MsPendidikan::find()->all(), 'id_pendidikan', 'nama'), ['prompt' => 'Pilih Pendidikan',
                            'id' => 'pendidikan'
                                ]
                        )
                        ?>
                    </div>			
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label col-md-2">Alamat</label>
                    <div class="col-md-10 kejaksaan">
                        <textarea id="alamat" class="form-control" rows="2"></textarea>
                    </div>
                </div>
            </div>     
        </div>

        <div class="col-md-12" style="margin-top: 15px;">

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Agama</label>
                    <div class="col-md-8 kejaksaan">
                        <?=
                        $form->field($model, 'agama')->dropDownList(
                                ArrayHelper::map(MsAgama::find()->all(), 'id_agama', 'nama'), ['prompt' => 'Pilih Agama',
                            'id' => 'agama'
                                ]
                        )
                        ?>
                    </div>			
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Pekerjaan</label>
                    <div class="col-md-8 kejaksaan">
                        <input id="pekerjaan" class="form-control" type="text" maxlength="32">
                    </div>
                </div>
            </div>
        </div>

		<div class="col-md-12">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label col-md-2">Keterangan</label>
                    <div class="col-md-10 kejaksaan">
                        <textarea id="keterangan" class="form-control" rows="2"></textarea>
                    </div>
                </div>
            </div>     
        </div>





    </div>
    <hr style="border-color: #c7c7c7;margin: 10px 0;">
    <div class="box-footer">
        <button class="btn btn-primary" type="button" id="btn-tambah-pelapor">Simpan</button>
    </div>

    <?php ActiveForm::end(); ?>
</div>	