<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use app\modules\datun\models\searchs\Instansi as pilih;
?>

<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/pidsus/ms-pasal/simpan" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div class="box box-primary">
    <div class="box-body">
        <div id="error_custom0"></div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">ID Pasal</label>        
                        <div class="col-md-3">
                            <input type="text" name="id_pasal" id="id_pasal" class="form-control" value="<?php echo $model['id_pasal'];?>" <?php echo (!$isNewRecord)?'readonly':'';?> required data-error="ID Pasal belum diisi" maxlength="3" />
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
                        <div class="input-group input-group-sm">
                            <input type="hidden" name="id" id="id" value="<?php echo $model['id'];?>"/>
                            <input type="text" name="uu" id="uu" class="form-control" value="<?php echo $model['uu'];?>" readonly maxlength="50" required="" data-error="Undang-undang belum diisi"/>
                            <span class="input-group-btn">
                                <button class="btn" type="button" id="undang">Pilih</button>
                            </span>
                        </div>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div> 
        </div>
        <div class="row">        
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Pasal</label>
                    <div class="col-md-8">
                        <input type="text" id="pasal" name="pasal" class="form-control" value="<?php echo $model['pasal'];?>" maxlength="50" required data-error="Pasal belum diisi"/>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div> 
        </div>
        <div class="row">        
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Bunyi</label>
                    <div class="col-md-8">
                        <textarea id="bunyi" name="bunyi" class="form-control" style="height:100px"><?php echo $model['bunyi'];?></textarea>
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
    <a href="/pidsus/ms-pasal/index" class="btn btn-danger"><i class="fa fa-reply jarak-kanan"></i>Batal</a>
</div>
</form>

<!--Undang Undang-->
<div class="modal fade" id="pilih_undang" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Undang Undang</h4>
            </div>
            <div class="modal-body">
                
            </div>
        </div>
    </div>
</div>

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
<script>
    $(function() {
       $("#undang").on('click', function(){
            $("#pilih_undang").modal({
                backdrop:"static",
                keyboard:false
            });
        });
        
        $("#undang").on('click', function(e){
            $("#pilih_undang").find(".modal-body").load("/pidsus/ms-pasal/getformundang");
            $("#pilih_undang").modal({backdrop:"static"});
        });
        
        $("#pilih_undang").on('show.bs.modal', function(e){
            $("body").addClass("loading");
        }).on('shown.bs.modal', function(e){
            $("body").removeClass("loading");
        }).on('click','.selection_one',function(e){
            var id = $(this).data('id');
            var tm = id.toString().split("|#|");
            $("#id").val(tm[0]);
            $("#uu").val(tm[1]);
            $("#pilih_undang").modal('hide');
        });
    });
</script>