<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use app\models\MsAgama;
use app\models\MsPendidikan;
use app\models\MsJkl;
use app\models\MsIdentitas;

/* @var $this yii\web\View */
/* @var $model app\models\DugaanPelanggaran */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="modalContent">
    <?php
    $form = ActiveForm::begin([
                'id' => 'dugaan-pelanggaran-modalpelapor',
				'action' => Yii::$app->urlManager->createUrl(['pidum/pdm-ba15/updatetersangka']),
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


    <div class="box box-primary">
        <div class="box-header"></div>
        <div class="box-body">

			<div class="form-group">
                <label class="control-label col-md-2">Jenis Identitas</label>
                <div class="col-md-4 kejaksaan">
                    <?=
                    $form->field($modelTersangka, 'id_identitas')->dropDownList(
                            ArrayHelper::map(MsIdentitas::find()->all(), 'id_identitas', 'nama'), ['prompt' => 'Pilih Jenis Identitas',
                        'id' => 'update_jenis_identitas'
                            ]
                    )
                    ?>
                </div>
            </div>
            <br />
			
			<input id="update_id_tersangka" name="update_id_tersangka" class="form-control" type="hidden" style="width:200px" maxlength="32">
			
			<input id="update_id_perkara" name="update_id_perkara" class="form-control" type="hidden" style="width:200px" maxlength="32">
			
			
            <div class="form-group">
                <label class="control-label col-md-2">Nomor Identitas</label>
                <div class="col-md-3 kejaksaan">
                    <input id="update_no_identitas" name="update_no_identitas" class="form-control" type="text" style="width:200px" maxlength="32">
                </div>
            </div>
            <br />

            <div class="form-group">
                <label class="control-label col-md-2">Nama</label>
                <div class="col-md-4 kejaksaan">
                    <input id="update_nama" name="update_nama" class="form-control" type="text" style="width:200px" maxlength="32">
                </div>
            </div>
            <br />

            <div class="form-group">
                <label class="control-label col-md-2">Jenis Kelamin</label>
                <div class="col-md-4 kejaksaan">
                    <?=
                    $form->field($modelTersangka, 'id_jkl')->dropDownList(
                            ArrayHelper::map(MsJkl::find()->all(), 'id_jkl', 'nama'), ['prompt' => 'Pilih Jenis Kelamin',
                        'id' => 'update_jkl'
                            ]
                    )
                    ?>
                </div>
            </div>
            <br />

            <div class="form-group">
                <label class="control-label col-md-2">TTL</label>
                <div class="col-md-4 kejaksaan">
                    <input id="update_tempat_lahir" name="update_tempat_lahir" class="form-control" type="text" style="width:200px" maxlength="32">
                </div>
                <div class="col-md-6">
                    <span class="pull-right">
                        <?=
                        $form->field($modelTersangka, 'tgl_lahir')->widget(DatePicker::classname(), [
                            'options' => ['placeholder' => 'Tanggal Lahir ...', 'id' => 'update_tgl_lahir'],
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
            <br />

			
			<div class="form-group">
                <label class="control-label col-md-2">Alamat</label>
                <div class="col-md-8 kejaksaan">
                    <textarea id="update_alamat" name="update_alamat" class="form-control" rows="2"></textarea>
                </div>
            </div>
            <br />
			

			<div class="form-group">
                <label class="control-label col-md-2">Warga Negara</label>
                <div class="col-md-8 kejaksaan">
                    <input id="update_warganegara" name="update_warganegara" class="form-control" type="text" style="width:200px" maxlength="32">
                </div>
            </div>
            <br />
			
			
			<div class="form-group">
                <label class="control-label col-md-2">Suku</label>
                <div class="col-md-8 kejaksaan">
                    <input id="update_suku" name="update_suku" class="form-control" type="text" style="width:200px" maxlength="32">
                </div>
            </div>
            <br />
			
			
            <div class="form-group">
                <label class="control-label col-md-2">Pendidikan</label>
                <div class="col-md-4 kejaksaan">
                    <?=
                    $form->field($modelTersangka, 'id_pendidikan')->dropDownList(
                            ArrayHelper::map(MsPendidikan::find()->all(), 'id_pendidikan', 'nama'), ['prompt' => 'Pilih Pendidikan',
                        'id' => 'update_pendidikan'
                            ]
                    )
                    ?>
                </div>			
            </div>	
            <br />


            <div class="form-group">
                <label class="control-label col-md-2">Agama</label>
                <div class="col-md-4 kejaksaan">
                    <?=
                    $form->field($modelTersangka, 'id_agama')->dropDownList(
                            ArrayHelper::map(MsAgama::find()->all(), 'id_agama', 'nama'), ['prompt' => 'Pilih Agama',
                        'id' => 'update_agama'
                            ]
                    )
                    ?>
                </div>			
            </div>	
            <br />

            <div class="form-group">
                <label class="control-label col-md-2">Pekerjaan</label>
                <div class="col-md-4 kejaksaan">
                    <input id="update_pekerjaan" name="update_pekerjaan" class="form-control" type="text" style="width:200px" maxlength="32">
                </div>
            </div>
            <br />



        </div>	


    </div>
    <div class="box-footer">
        <button class="btn btn-success" type="submit" id="btn-update-tersangka">Ubah</button>
    </div>

    <?php ActiveForm::end(); ?>
</div>	