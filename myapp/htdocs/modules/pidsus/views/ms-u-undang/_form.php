<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use app\modules\datun\models\searchs\Instansi as pilih;
?>

<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/pidsus/ms-u-undang/simpan" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div class="box box-primary">
    <div class="box-body">
        <div id="error_custom0"></div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">ID</label>        
                        <div class="col-md-3">
                            <input type="text" name="id" id="id" class="form-control" value="<?php echo $model['id'];?>" <?php echo (!$isNewRecord)?'readonly':'';?> required data-error="ID belum diisi" maxlength="2" />
                        </div>
                        <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors" id="kodenya"></div></div>
                </div>
            </div>
        </div>
        <div class="row">        
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Undang-undang</label>
                    <div class="col-md-8">
                        <input type="text" name="uu" id="uu" class="form-control" value="<?php echo $model['uu'];?>" maxlength="50" required="" data-error="Undang-undang belum diisi"/>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div> 
        </div>
        <div class="row">        
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Deskripsi</label>
                    <div class="col-md-8">
                        <input type="text" id="deskripsi" name="deskripsi" class="form-control" value="<?php echo $model['deskripsi'];?>" maxlength="255"/>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div> 
        </div>
        <div class="row">        
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tentang</label>
                    <div class="col-md-8">
                        <input type="text" id="tentang" name="tentang" class="form-control" value="<?php echo $model['tentang'];?>" maxlength="400"/>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div> 
        </div>
        <div class="row">        
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tanggal Diundangkan</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" name="tanggal" id="tanggal" class="form-control datepicker" placeholder="DD-MM-YYYY" value="<?php echo $model['tanggal'];?>" />
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>

<hr style="border-top: 4px double #ccc; margin:0px -15px 15px;">
<div class="box-footer text-center"> 
    <input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $isNewRecord; ?>" />
    <button class="btn btn-pidsus jarak-kanan" type="submit" id="simpan1" name="simpan1">
    <i class="fa fa-floppy-o jarak-kanan"></i><?php echo ($isNewRecord)?'Simpan':'Ubah';?></button>
    <a href="/pidsus/ms-u-undang/index" class="btn btn-danger"><i class="fa fa-reply jarak-kanan"></i>Batal</a>
</div>
</form>

<style>
	h3.box-title{
		font-weight: bold;
	}
	.form-horizontal .form-group-sm .control-label{
		font-size: 12px;
	}
	.help-block{
		margin-bottom: 0px;
		margin-top: 0px;
		font-size: 12px;
	}
	.select2-search--dropdown .select2-search__field{
		font-family: arial;
		font-size: 11px;
		padding: 4px 3px;
	}
	.form-group-sm .select2-container > .selection,
	.select2-results__option{
		font-family: arial;
		font-size: 11px;
	}
	fieldset.scheduler-border{
		border: 1px solid #ddd;
		margin:0;
		padding:10px;
	}
	legend.scheduler-border{
		border-bottom: none;
		width: inherit;
		margin:0;
		padding:0px 5px;
		font-size: 14px;
		font-weight: bold;
	}
</style>