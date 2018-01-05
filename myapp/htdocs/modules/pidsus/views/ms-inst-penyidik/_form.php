<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use app\modules\datun\models\searchs\Instansi as pilih;
?>

<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/pidsus/ms-inst-penyidik/simpan" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div class="box box-primary">
    <div class="box-body">
        <div id="error_custom0"></div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Kode Instansi Penyidik</label>        
                        <div class="col-md-3">
                            <input type="text" name="kode_ip" id="kode_ip" class="form-control" value="<?php echo $model['kode_ip'];?>" <?php echo (!$isNewRecord)?'readonly':'';?> required data-error="Kode IP belum diisi" maxlength="2" />
                        </div>
                        <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors" id="kodenya"></div></div>
                </div>
            </div>
        </div>
        <div class="row">        
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Nama Instansi Penyidik</label>
                    <div class="col-md-8">
                        <input type="text" name="nama" id="nama" class="form-control" value="<?php echo $model['nama'];?>" maxlength="100"/>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div> 
        </div>
        <div class="row">        
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Akronim</label>
                    <div class="col-md-8">
                        <input type="text" id="akronim" name="akronim" class="form-control" value="<?php echo $model['akronim'];?>" maxlength="50"/>
                        <div class="help-block with-errors"></div>
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
    <a href="/pidsus/ms-inst-penyidik/index" class="btn btn-danger"><i class="fa fa-reply jarak-kanan"></i>Batal</a>
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