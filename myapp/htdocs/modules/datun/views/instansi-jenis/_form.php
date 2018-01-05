<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;

	$this->title = 'Ubah Jenis Instansi';
?>
<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/datun/instansi-jenis/simpan">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div style="border-color: #f39c12;padding: 15px;overflow: hidden;" class="box box-primary">
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-4">Kode</label>
                <div class="col-md-2">
                    <input type="text" id="kode" name="kode" class="form-control" value="<?php echo $model['kode_jenis_instansi'];?>" readonly />
				</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-4">Deskripsi</label>
                <div class="col-md-8">
                    <input type="text" id="deskripsi" name="deskripsi" class="form-control" value="<?php echo $model['deskripsi_jnsinstansi'];?>" required data-error="Deskripsi belum diisi" />
                	<div class="help-block with-errors"></div>
				</div>
            </div>
        </div>
    </div>
</div>

<hr style="border-color: #c7c7c7;margin: 10px 0;">
<div class="box-footer text-center"> 
    <button class="btn btn-warning jarak-kanan" type="submit" id="simpan">Ubah</button>
    <a href="/datun/instansi-jenis/index" class="btn btn-danger">Batal</a>
</div>
</form>

<div class="modal-loading-new"></div>
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
<script type="text/javascript">
$(document).ready(function(){
	$('#role-form').validator({disable:false}).on('submit', function(e){
		if(!e.isDefaultPrevented()){
			$("body").addClass("loading");
			$('#role-form').validator('destroy').off("submit");
			$('#role-form').submit();
		}
	});
});
</script>


