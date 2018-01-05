<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
?>
<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/datun/ttd-jabatan/simpan">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div style="border-color: #f39c12;padding: 15px;overflow: hidden;" class="box box-primary">
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-4">Kode</label>
                <div class="col-md-2">
                    <input type="text" id="kode" name="kode" class="form-control" maxlength="2" value="<?php echo $model['kode'];?>" <?php echo (!$isNewRecord)?'readonly':'';?> required data-error="Kode belum diisi" />
				</div>
                <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors" id="kodenya"></div></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-4">Deskripsi</label>
                <div class="col-md-8">
                    <input type="text" id="deskripsi" name="deskripsi" class="form-control" value="<?php echo $model['deskripsi'];?>" required data-error="Deskripsi belum diisi" />
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
    <a href="/datun/ttd-jabatan/index" class="btn btn-danger">Batal</a>
</div>
</form>

<div class="modal-loading-new"></div>
<style>
	h3.box-title{
		font-weight: bold;
	}
	.help-block{
		margin-bottom: 0px;
		margin-top: 0px;
	}
</style>