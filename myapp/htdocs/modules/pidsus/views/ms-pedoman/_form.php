<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use app\modules\datun\models\searchs\Instansi as pilih;
?>

<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/pidsus/ms-pedoman/simpan" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div class="box box-primary">
    <div class="box-body">
        <div id="error_custom0"></div>
        
        <div class="row">        
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Undang-undang</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <input type="hidden" name="id" id="id" value="<?php echo $model['id'];?>"/>
                            <input type="text" name="uu" id="uu" class="form-control" value="<?php echo $model['uu'];?>" readonly required data-error="Undang-undang belum diisi"/>
                            <span class="input-group-btn">
                                <button class="btn btn-sm" type="button" id="undang" <?php if($model['id']!=""){echo 'disabled';}?>>Pilih</button>
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
                        <div class="input-group input-group-sm">
                            <input type="hidden" name="id_pasal" id="id_pasal" value="<?php echo $model['id_pasal'];?>"/>
                            <input type="text" name="pasal" id="pasal" readonly class="form-control" value="<?php echo $model['pasal'];?>" required data-error="Pasal belum diisi"/>
                            <div class="help-block with-errors"></div>
                            <span class="input-group-btn">
                                <button class="btn" type="button" id="pilih_pasal" <?php if($model['id_pasal']!=""){echo 'disabled';}?>>Pilih</button>
                            </span>
                        </div>
                        
                    </div>
                </div>
            </div> 
        </div>
        <div class="row">        
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Kategori</label>
                    <div class="col-md-8">
                        <select id="kategori" <?php if($model['kategori']!=""){echo 'disabled=""';}?> name="kategori" class="select2" style="width:100%;" required data-error="Kategori belum dipilih">
                            <option></option>
                            <option value="1">I (Tidak ada hal yang meringankan)</option>
                            <option value="2">II (Hal yang memberatkan lebih dominan tetapi ada hal yang meringankan)</option>
                            <option value="3">III (Antara hal yang memberatkan dan meringankan sebanding)</option>
                            <option value="4">IV (Lebih dominan hal yang meringankan tetapi ada hal yang memberatkan)</option>
                            <option value="5">V (Tidak ada hal yang memberatkan)</option>
                        </select>
                        <?php if($model['kategori']!=""){?> <input type="hidden" name="kategori" id="kategori" class="form-control" value="<?php echo $model['kategori'];?>"/> <?php }?>
                        <div class="help-block with-errors" id="kodenya"></div>
                    </div>
                </div>
            </div> 
        </div>
        <div class="row">        
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tuntutan Pidana</label>
                    <div class="col-md-8">
                        <input type="text" name="tuntutan_pidana" id="tuntutan_pidana" class="form-control" value="<?php echo $model['tuntutan_pidana'];?>" maxlength="255"/>
                    </div>
                </div>
            </div> 
        </div>
        <div class="row">        
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Ancaman</label>
                    <div class="col-md-8">
                        <input type="text" name="ancaman" id="ancaman" class="form-control" value="<?php echo $model['ancaman'];?>" maxlength="255"/>
                    </div>
                </div>
            </div> 
        </div>
        <div class="row">        
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Denda</label>
                    <div class="col-md-8">
                        <input type="number" name="denda" id="denda" class="form-control" value="<?php echo $model['denda'];?>" data-fv-integer-message="Hanya input numerik" />
                    </div>
                    <div class="help-block with-errors"></div>
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
    <a href="/pidsus/ms-pedoman/index" class="btn btn-danger"><i class="fa fa-reply jarak-kanan"></i>Batal</a>
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

<!--Pasal-->
<div class="modal fade" id="form_pasal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Pasal</h4>
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
        <?php if($model['kategori']!=""){ ?>
             $("#kategori").select2().select2('val','<?php echo $model['kategori'];?>');
        <?php }?>
        $("#undang").on('click', function(e){
            $("#pilih_undang").find(".modal-body").load("/pidsus/ms-pedoman/getformundang");
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
        
        $("#pilih_pasal").on('click', function(e){
            var id=$('#id').val();
            if(id==""){
                bootbox.alert({
                    message: "Silahkan pilih Undang-undang terlebih dahulu",
                    size: 'small',
                    callback: function(){
                        $("#pilih_pasal").focus();
                    }
                }); 
            }else{
                $("#form_pasal").find(".modal-body").load("/pidsus/ms-pedoman/getformpasal?id="+id);
                $("#form_pasal").modal({backdrop:"static"});
            }
        });
        $("#form_pasal").on('show.bs.modal', function(e){
            $("body").addClass("loading");
        }).on('shown.bs.modal', function(e){
            $("body").removeClass("loading");
        }).on('click','.selection_one',function(e){
            var id = $(this).data('id');
            var tm = id.toString().split("|#|");
            $("#id_pasal").val(tm[0]);
            $("#pasal").val(tm[1]);
            $("#form_pasal").modal('hide');
        });
    });
</script>