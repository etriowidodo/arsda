<?php
	use yii\helpers\Html;
	use app\modules\datun\models\MsWilayahSearch as MsWilayah;
	use app\modules\datun\models\MsWilayahkabSearch as MsWilayahkab;
	use yii\widgets\ActiveForm;
?>
<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/datun/wilayah/simpankab">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div style="border-color: #f39c12;padding: 15px;overflow: hidden;" class="box box-primary">

    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-4">Kode Provinsi</label>
                <div class="col-md-8">
                    <input type="hidden" id="kode" name="kode" value="<?php echo $model['id_prop'];?>" />
                    <input type="text" id="kodeTxt" name="kodeTxt" class="form-control" value="<?php echo $model['proptxt'];?>" readonly />
                    <div class="help-block with-errors"></div>
				</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-4">Kode Kabupaten</label>
                <div class="col-md-2">
                    <input type="text" id="kode_kab" name="kode_kab" class="form-control" maxlength="2" value="<?php echo $model['id_kabupaten_kota'];?>" required data-minlength="2" data-error="Kode Kabupaten harus diisi dengan 2 karakter" <?php echo (!$isNewRecord?'readonly':''); ?> />
				</div>
                <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors"></div></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-4">Deskripsi</label>
                <div class="col-md-8">
                    <input type="text" id="deskripsi" name="deskripsi" class="form-control" value="<?php echo $model['deskripsi_kabupaten_kota'];?>" required data-error="Deskripsi belum diisi" />
                	<div class="help-block with-errors"></div>
				</div>
            </div>
        </div>
    </div>

</div>

<hr style="border-color: #c7c7c7;margin: 10px 0;">
<div class="box-footer text-center"> 
    <input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $isNewRecord; ?>" />
    <button class="btn btn-warning jarak-kanan" type="submit" id="simpan"><?php echo ($isNewRecord)?'Simpan':'Simpan';?></button>
    <a href="<?php echo '/datun/wilayah/viewkab?id='.$model['id_prop'];?>" class="btn btn-danger">Batal</a>
</div>
</form>
<div class="modal-loading-new"></div>

