<?php

use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $model app\models\PdsLid */

require('..\modules\pidsus\controllers\viewFormFunction.php');
$viewFormFunction=new viewFormFunction();
$idSatker=$_SESSION['idSatkerUser'];

/* @var $this yii\web\View */
/* @var $model app\models\PdsLid */
/* @var $form yii\widgets\ActiveForm */
$typeSurat = 'p1';
$sqlLokasi="Select distinct inst_lokinst from kepegawaian.kp_inst_satker";
$sqlPenerimaSurat="select * from pidsus.get_penerima_laporan ('".$idSatker."') order by nama_penerima_lap";
$sqlPenandatangan="select * from pidsus.get_penandatangan	('".$idSatker."','".$typeSurat."') order by id_penandatangan";
$sqlJenisKasus="select id_detail, nama_detail from pidsus.parameter_detail where id_header=9";

$this->title = 'Laporan Penyelidikan';
header("Location:draftlaporan?type=pidsus1");
//'window.location=\''.$_SESSION['urlDefaultString'].'viewlaporan?id=\'+this.id'
die();
?>
<div class="pds-lid-update">


   <div class="pds-lid-form">

   
    <div class="box box-primary">
	<div class="box-header">
            <center></center>
        </div>
    <?php $form = ActiveForm::begin(
	 [
                'id' => 'p2-form',
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'enableAjaxValidation' => false,
                'fieldConfig' => [
                    'autoPlaceholder'=>false
                ],
                'formConfig' => [
                    'deviceSize' => ActiveForm::SIZE_LARGE,
                    'labelSpan' => 1,
                    'showLabels'=>false

                ]
            ]); ?>

        <div>

            <?= $viewFormFunction->returnSelectDisable($sqlJenisKasus,$form,$model,'jenis_kasus','Kasus','id_detail','nama_detail','','jenis_kasus','full')?>

            <?php if ($typeSurat!='pidsus1'){?>
               <div class="form-group">
                    <label for="asal_surat_lap" class="control-label col-md-3">Asal Surat</label>
                    <div class="col-md-6"><?= $form->field($model, 'asal_surat_lap')->textInput(['readonly' => true]) ?></div>

                </div>
                <div class="form-group">
                    <label for="no_surat_p1" class="control-label col-md-3">Nomor Surat</label>
                    <div class="col-md-6"><?= $form->field($model, 'no_surat_lap')->textInput(['readonly' => true]) ?></div>
                </div>
                <div class="form-group">
                    <label for="tgl_surat" class="control-label col-md-3">Tanggal Diterima</label>
                    <div class="col-md-6"><?=
                        $form->field($model, 'tgl_diterima')->widget(DateControl::classname(), [
                            'type'=>DateControl::FORMAT_DATE,
                            'ajaxConversion'=>false,
                            'options' => [
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'mask' => 'Pilih Tanggal...',
                                ]
                            ],
                            'readonly'=>true
                        ])?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="perihal" class="control-label col-md-3">Perihal</label>
                    <div class="col-md-6"><?= $form->field($model, 'perihal_lap')->textInput(['readonly' => true]) ?></div>
                </div>
                <div class="form-group">
                    <label for="tgl_surat" class="control-label col-md-3">Tanggal Surat</label>
                    <div class="col-md-6"><?=
                        $form->field($model, 'tgl_lap')->widget(DateControl::classname(), [
                            'type'=>DateControl::FORMAT_DATE,
                            'ajaxConversion'=>false,
                            'options' => [
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'mask' => 'Pilih Tanggal...',
                                ]
                            ],
                            'readonly'=>true
                        ])?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="uraian" class="control-label col-md-3">Uraian Kasus </label>
                    <div class="col-md-6"><?= $form->field($model, 'uraian_surat_lap')->textArea(array('maxlength' => 4000, 'rows' => 6, 'cols' => 50,'readonly' => true)) ?></div>
                </div>
                <div class="form-group">
                    <label for="uraian" class="control-label col-md-3">Isi</label>
                    <div class="col-md-6"><?= $form->field($model, 'isi_surat_lap')->textArea(array('maxlength' => 4000, 'rows' => 6, 'cols' => 50,'readonly' => true)) ?></div>
                </div>
                <?= $viewFormFunction->returnSelectDisable($sqlPenerimaSurat,$form,$model,'penerima_lap','Pembuat Catatan','id_penerima_lap','nama_penerima_lap','Pilih Pembuat Catatan ...','penerima_lap','full')?>
                <?= $viewFormFunction->returnSelectDisable($sqlPenandatangan,$form,$model,'penandatangan_lap','Penandatangan','id_penandatangan','nama_penandatangan','Pilih Penandatangan ...','penandatangan','full')?>
            <?php } else if($typeSurat=='p1'){?>

                <div class="form-group">
                    <label for="no_surat_p1" class="control-label col-md-3">Nomor  P-1</label>
                    <div class="col-md-6"><?= $form->field($model, 'no_lap')->textInput(['readonly' => false]) ?></div>
                </div>
                <div class="form-group">
                <label for="tgl_surat" class="control-label col-md-3">Tanggal Diterima</label>
                <div class="col-md-6"><?=
                    $form->field($model, 'tgl_diterima')->widget(DateControl::classname(), [
                        'type'=>DateControl::FORMAT_DATE,
                        'ajaxConversion'=>false,
                        'options' => [
                            'pluginOptions' => [
                                'autoclose' => true,
                                'mask' => 'Pilih Tanggal...',
                            ]
                        ],
                        'readonly'=>true
                    ])?>
                </div>
                </div><?= $viewFormFunction->returnSelectDisable($sqlPenerimaSurat,$form,$model,'penerima_lap','Penerima Laporan','id_penerima_lap','nama_penerima_lap','Pilih Penerima ...','penerima_lap','full')?>
                <?= $viewFormFunction->returnSelectDisable($sqlLokasi,$form,$model,'lokasi_lap','Lokasi Penerima Laporan','inst_lokinst','inst_lokinst','Pilih Lokasi ...','lokasi_penerima','full')?>
                <div class="form-group">
                    <label for="pelapor" class="control-label col-md-3">Pelapor</label>
                    <div class="col-md-6"><?= $form->field($model, 'pelapor')->textInput(['readonly' => true]) ?></div>
                </div>

                <div class="form-group">
                    <label for="isi" class="control-label col-md-3">Isi</label>
                    <div class="col-md-6"><?= $form->field($model, 'isi_surat_lap')->textArea(array('maxlength' => 4000, 'rows' => 6, 'cols' => 50,'readonly' => false)) ?></div>
                </div>
            <?php }?>








        </div>
</div>

</div>
