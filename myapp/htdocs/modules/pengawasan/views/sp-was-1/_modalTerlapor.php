<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
// use kartik\widgets\DatePicker;
use app\modules\pengawasan\models\SumberLaporan;
use kartik\datecontrol\DateControl;
use app\models\MsAgama;
use app\models\MsPendidikan;
use app\models\MsWarganegara;
use yii\bootstrap\Modal;
// use app\models\MsJkl;

use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\DugaanPelanggaran */
/* @var $form yii\widgets\ActiveForm */
?>
<!--<style>
#pelapor-kewarganegaraan_pelapor {
 background-color: #FFF;
  cursor: text;
}
</style>-->
<div class="modalContent">
    <?php
    $form = ActiveForm::begin([
                'id' => 'modalterlapor',
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
                    <label class="control-label col-md-4">NIP</label>
                    <div class="col-md-8 kejaksaan">
                       <?php
                            echo $form->field($modelPegawaiTerlapor, 'nip', [
                                'addon' => [
                                    'append' => [
                                        'content' => Html::a('Pilih', '', ['class' => 'btn btn-primary', 'data-toggle' => 'modal', 'data-target' => '#peg_terlapor']),
                                        'asButton' => true
                                    ]
                                ]
                            ]);
                            ?>
                    </div>
                </div>
            </div>
        </div>
<?=  $form->field($modelPegawaiTerlapor, 'nrp_pegawai_terlapor')->hiddenInput();?>
        <div class="col-md-12">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label col-md-2">Nama</label>
                    <div class="col-md-10 kejaksaan">
					<?php	
					if(!$modelPegawaiTerlapor->isNewRecord){
                        echo $form->field($modelPegawaiTerlapor, 'nama_pegawai_terlapor')->textInput();
                      }else{
                        echo $form->field($modelPegawaiTerlapor, 'nama_pegawai_terlapor')->textInput();
                      }
                      ?>
                        <?//= $form->field($modelPegawaiTerlapor, 'nama_pegawai_terlapor')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>

        </div>

		<div class="col-md-12">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label col-md-2">Jabatan</label>
                    <div class="col-md-10 kejaksaan">
                        <?= $form->field($modelPegawaiTerlapor, 'jabatan_pegawai_terlapor')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>

        </div>
            
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Golongan</label>
                    <div class="col-md-8 kejaksaan"> 
						   <?= $form->field($modelPegawaiTerlapor, 'golongan_pegawai_terlapor')->textInput(['maxlength' => true])?>
						  
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label col-md-2">Pangkat</label>
                    <div class="col-md-10 kejaksaan">
                    <?= $form->field($modelPegawaiTerlapor, 'pangkat_pegawai_terlapor')->textInput(['maxlength' => true])?>
					<input type="hidden" name="cek" value="" id="cek">
                    </div>
                </div>
            </div>     
        </div>

        <div class="col-md-12">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label col-md-2">Satker</label>
                    <div class="col-md-10 kejaksaan">
                    <?= $form->field($modelPegawaiTerlapor, 'satker_pegawai_terlapor')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>   
        </div>

    </div>
    <hr style="border-color: #c7c7c7;margin: 10px 0;">
    <div class="box-footer">
        <button class="btn btn-primary" type="button" id="btn-tambah-terlapor">Simpan</button>
        <button class="btn btn-primary"  data-dismiss="modal" type="button">Batal</button>
    </div>

    <?php ActiveForm::end(); ?>
</div>	