<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use app\modules\datun\models\InstansiJenis;

	$jnsTxt	= $model['kode_jenis_instansi'].' || '.$model['deskripsi_jnsinstansi'];
?>
<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/datun/instansi/simpan">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div style="border-color: #f39c12;padding: 15px;overflow: hidden;" class="box box-primary">
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-3">Kode Jenis Instansi</label>
                <div class="col-md-8">
					<?php if($isNewRecord){ ?>
                    <select id="kode_jns" name="kode_jns" class="select2" style="width:100%;" required data-error="Kode jenis instansi belum dipilh">
                        <option></option>
                        <?php 
                            $sqlOpt = "select * from datun.jenis_instansi order by kode_jenis_instansi";
                            $resOpt = InstansiJenis::findBySql($sqlOpt)->asArray()->all();
                            foreach($resOpt as $dOpt){
                                echo '<option value="'.$dOpt['kode_jenis_instansi'].'">'.$dOpt['deskripsi_jnsinstansi'].'</option>';
                            }
                        ?>
                    </select>
					<?php } else{ ?>
                	<input type="hidden" name="kode_jns" id="kode_jns" value="<?php echo $model['kode_jenis_instansi'];?>" />
                    <input type="text" name="jns_txt" id="jns_txt" class="form-control" value="<?php echo $jnsTxt;?>" readonly />
					<?php } ?>
                	<div class="help-block with-errors"></div>
				</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-3">Kode Instansi</label>
                <div class="col-md-2">
                	<input type="text" name="kode_ins" id="kode_ins" class="form-control" maxlength="3" value="<?php echo $model['kode_instansi'];?>" required data-error="Kode instansi belum diisi" <?php echo (!$isNewRecord)?'readonly':'';?> />
				</div>
                <div class="col-md-offset-3 col-md-8"><div class="help-block with-errors" id="err_kode_jnsnya"></div></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-3">Deskripsi</label>
                <div class="col-md-8">
                	<input type="text" name="deskripsi" id="deskripsi" class="form-control" value="<?php echo $model['deskripsi_instansi'];?>" required data-error="Deksripsi belum diisi" />
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
    <a href="/datun/instansi/index" class="btn btn-danger">Batal</a>
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
