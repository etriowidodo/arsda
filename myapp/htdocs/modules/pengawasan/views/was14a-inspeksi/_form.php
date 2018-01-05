<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\DasarSpWasMaster */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="was15-inspeksi-form">

    <?php $form = ActiveForm::begin(
    ); ?>

    <?//= $form->field($model, 'id_dasar_spwas')->textInput(['maxlength' => true]) ?>
    <div class="box box-primary">
        <div class="box-body" style="padding:15px;">
            <div class="col-md-12" style="padding-right: 0px;padding-left: 0px;">
                <div class="col-md-5">
                    <div class="form-group">
                        <label class="control-label col-md-4">Nomor Surat</label>
                        <div class="col-md-8">
                            <input id="dipamaster-tahun" class="form-control" name="DipaMaster[tahun]" maxlength="4" type="text">
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label class="control-label col-md-4">Tanggal Surat</label>
                        <div class="col-md-8">
                            <input id="dipamaster-tahun" class="form-control" name="DipaMaster[tahun]" maxlength="4" type="text">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12" style="padding-right: 0px;padding-left: 0px;padding-top: 10px;">
                <div class="col-md-5">
                    <div class="form-group">
                        <label class="control-label col-md-4">Perihal</label>
                        <div class="col-md-8">
                            <textarea class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label class="control-label col-md-4">Lampiran</label>
                        <div class="col-md-8">
                            <input id="dipamaster-tahun" class="form-control" name="DipaMaster[tahun]" maxlength="4" type="text">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12" style="padding-right: 0px;padding-left: 0px;padding-top: 10px;">
                <div class="col-md-5">
                    <div class="form-group">
                        <label class="control-label col-md-4">Kepada</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <input type="hidden" name="" id="" value="">
                                <input type="text" name="" id="" class="form-control" value="" readonly="">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-primary btn-sm" id="btn_instansi">Pilih</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label class="control-label col-md-4">Di -</label>
                        <div class="col-md-8">
                            <input id="dipamaster-tahun" class="form-control" name="DipaMaster[tahun]" maxlength="4" type="text">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12" style="padding-right: 0px;padding-left: 0px;padding-top: 10px;">
                <div class="col-md-5">
                    <div class="form-group">
                        <label class="control-label col-md-4">Surat Perintah</label>
                        <div class="col-md-8"> 
                            <input id="dipamaster-tahun" class="form-control" name="DipaMaster[tahun]" maxlength="4" type="text" readonly="">
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label class="control-label col-md-4">No Surat Perintah</label>
                        <div class="col-md-8">
                            <input id="dipamaster-tahun" class="form-control" name="DipaMaster[tahun]" maxlength="4" type="text" readonly="">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12" style="padding-right: 0px;padding-left: 0px;padding-top: 10px;">
                <div class="col-md-5">
                    <div class="form-group">
                        <label class="control-label col-md-4">Tanggal Surat Perintah</label>
                        <div class="col-md-8">
                            <input id="dipamaster-tahun" class="form-control" name="DipaMaster[tahun]" maxlength="4" type="text" readonly="">
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label class="control-label col-md-4">Nama Terlapor</label>
                        <div class="col-md-8">
                            <select class="form-control">
                                <option>- Pilih -</option>
                                <option>1</option>
                                <option>2</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12" style="padding-right: 0px;padding-left: 0px;padding-top: 10px;">
                <div class="col-md-5">
                    <div class="form-group">
                        <label class="control-label col-md-4">Pasal Yang Dilanggar</label>
                        <div class="col-md-8">
                            <input id="dipamaster-tahun" class="form-control" name="DipaMaster[tahun]" maxlength="4" type="text" readonly="">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-12" style="padding-top: 15px;">
                <div class="panel panel-primary">
                    <div class="panel-heading">Pelanggaran Disiplin </div>
                        <div class="panel-body">
                        <textarea class="ckeditor" id="" name=""></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6" style="padding-top: 15px;">
                <div class="panel panel-primary">
                    <div class="panel-heading">Penandatangan</div>
                    <div class="panel-body">
                        <div class="col-md-12 row">
                            <div class="form-group">
                                <label class="control-label col-md-3">NIP</label>
                                <div class="col-md-9">
                                    <input id="dipamaster-tahun" class="form-control" name="DipaMaster[tahun]" maxlength="4" type="text">
                                </div>
                            </div>
                        </div><br>
                        <div class="col-md-12 row" style="padding-top: 15px;">
                            <div class="form-group">
                                <label class="control-label col-md-3">Nama</label>
                                <div class="col-md-9">
                                    <input id="dipamaster-tahun" class="form-control" name="DipaMaster[tahun]" maxlength="4" type="text">
                                </div>
                            </div>
                        </div><br>
                        <div class="col-md-12 row" style="padding-top: 15px;">
                            <div class="form-group">
                                <label class="control-label col-md-3">Jabatan</label>
                                <div class="col-md-9">
                                    <input id="dipamaster-tahun" class="form-control" name="DipaMaster[tahun]" maxlength="4" type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6" style="padding-top: 15px;">
                <div class="panel panel-primary">
                    <div class="panel-heading">Tembusan</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <a class="btn btn-primary btn-sm hapusTembusan jarak-kanan" title="Hapus"><i class="fa fa-trash"></i> Hapus</a>
                            <a class="btn btn-primary btn-sm" id="tambah-tembusan" title="Tambah Tembusan"><i class="fa fa-plus jarak-kanan"></i> Tembusan</a><br>  
                        </div>
                        <div class="col-md-12" style="padding-left: 0px;">
                            <div class="table-responsive">
                                <table id="table_tembusan" class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td class="text-center">
                                                <input id="box1" type="checkbox">
                                            </td>
                                            <td><input type="text" name="" class="form-control input-sm" value=""></td>
                                            <td><input type="text" name="" class="form-control input-sm" value=""></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12" style="padding-top: 15px;padding-bottom: 15px;">
                <label>Unggah Berkas WAS-14A</label>
                <input type="file">
            </div>
        </div>
    </div>
		  
	<div class="form-group" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
        <input action="action" type="button" value="Kembali" class="btn btn-primary" onclick="history.go(-1);" />
    </div>
</div>
