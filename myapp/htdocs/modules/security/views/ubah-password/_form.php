<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
?>
<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/autentikasi/ubah-password/simpan">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div style="border-color: #f39c12;padding: 15px;overflow: hidden;" class="box box-primary">
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-4">Password Lama</label>
                <div class="col-md-8">
                	<input type="password" name="oldpass" id="oldpass" class="form-control" required data-error="Password lama belum diisi" />
                	<div class="help-block with-errors"></div>
				</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-4">Password Baru</label>
                <div class="col-md-8">
                	<input type="password" name="newpass" id="newpass" class="form-control" required data-error="Password baru belum diisi" />
                	<div class="help-block with-errors"></div>
				</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-4">Konfirmasi Password Baru</label>
                <div class="col-md-8">
                	<input type="password" name="cnewpass" id="cnewpass" class="form-control" required data-match="#newpass" data-match-error="Password baru tidak sama dengan konfirmasi password" data-error="Konfirmasi Password belum diisi" />
                	<div class="help-block with-errors"></div>
				</div>
            </div>
        </div>
    </div>
</div>

<hr style="border-color: #c7c7c7;margin: 10px 0;">

<div class="box-footer text-center"> 
    <button class="btn btn-warning jarak-kanan" type="submit" id="simpan"><?php echo ($isNewRecord)?'Ubah':'Ubah';?></button>
    <a href="<?php echo Yii::$app->homeUrl;?>" class="btn btn-danger">Menu Utama</a>
</div>
</form>
<div class="modal-loading-new"></div>
