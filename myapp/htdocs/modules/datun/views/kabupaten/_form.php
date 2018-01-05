<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use app\modules\datun\models\Provinsi;
	$kodeTxt = $model['id_prop']." | ".$model['deskripsi'];
?>
<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/datun/kabupaten/simpan">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div style="border-color: #f39c12;padding: 15px;overflow: hidden;" class="box box-primary">
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-4">Provinsi</label>
                <div class="col-md-8">
					<?php if($isNewRecord){ ?>
                    <select id="kode" name="kode" class="select2" style="width:100%;" required data-error="Provinsi belum dipilh">
                        <option></option>
                        <?php 
							$resOpt = Provinsi::findBySql("select * from datun.m_propinsi order by id_prop")->asArray()->all();
                            foreach($resOpt as $dOpt){
                                echo '<option value="'.$dOpt['id_prop'].'">'.$dOpt['deskripsi'].'</option>';
                            }
                        ?>
                    </select>
					<?php } else{ ?>
                	<input type="hidden" name="kode" id="kode" value="<?php echo $model['id_prop'];?>" />
                    <input type="text" name="kode_txt" id="kode_txt" class="form-control" value="<?php echo $kodeTxt;?>" readonly />
					<?php } ?>
                	<div class="help-block with-errors"></div>
				</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-4">Kode Kabupaten/Kota</label>
                <div class="col-md-2">
                    <input type="text" id="kode_kab" name="kode_kab" maxlength="2" class="form-control" value="<?php echo $model['id_kabupaten_kota'];?>" required data-error="Kode kabupaten/kota belum diisi" <?php echo (!$isNewRecord)?'readonly':'';?> />
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
    <a href="/datun/kabupaten/index" class="btn btn-danger">Batal</a>
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