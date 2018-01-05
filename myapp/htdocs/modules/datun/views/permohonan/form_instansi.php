<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
?>	
<div id="wrapper-modal-ins">
    <form class="form-horizontal" id="frm-m1">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-3">Jenis Instansi</label>
                    <div class="col-md-8">
                        <input type="text" name="m1_jenis" id="m1_jenis" class="form-control" value="<?php echo $model['kode_jenis_instansi']; ?>" maxlength="2" readonly />
                    </div>
                </div>
            </div>
        </div>
    
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-3">Kode</label>
                    <div class="col-md-8">
                        <input type="text" name="m1_instansi" id="m1_instansi" class="form-control" value="<?php echo $model['kode_instansi']; ?>" maxlength="3" <?php echo (!$model['isNewRecord'])?'readonly':'';?> />
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-3">Deskripsi</label>
                    <div class="col-md-8">
                        <input type="text" name="m1_deskripsi" id="m1_deskripsi" class="form-control" value="<?php echo $model['deskripsi_instansi']; ?>" />
                    </div>
                </div>
            </div>
        </div>
    
        <div class="row">
            <div class="col-md-12">
                <div class="help-block with-errors text-red" style="font-style:italic" id="errornya-modal-ins"></div>
            </div>
        </div>
    
        <hr style="border-color: #c7c7c7;margin: 10px 0;">
        <div class="box-footer text-center"> 
            <input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $model['isNewRecord'];?>" />
            <button type="button" id="simpan_form_instansi" class="btn btn-warning btn-sm jarak-kanan"><i class="fa fa-floppy-o jarak-kanan"></i>Simpan</button>
            <a class="btn btn-danger btn-sm" id="form_keluar"><i class="fa fa-reply jarak-kanan"></i>Kembali</a>
        </div>
    </form>
    <div class="modal-loading-new"></div>
</div>
<style>
	#wrapper-modal-ins.loading {overflow: hidden;}
	#wrapper-modal-ins.loading .modal-loading-new {display: block;}

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
</style>
