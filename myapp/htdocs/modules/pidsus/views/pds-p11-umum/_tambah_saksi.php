<?php
	use app\modules\pidsus\models\PdsPidsus16Umum;
	//echo '<pre>'; print_r($model); echo '</pre>';
?>
<div id="wrapper-modal-gldh">
    <form class="form-horizontal" id="form-modal-gldh">
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-md-10">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-3">Nama</label>        
                        <div class="col-md-7">
                            <div class="input-group input-group-sm">
                                <input type="text" name="modal_nama_saksi" id="modal_nama_saksi" class="form-control" value="<?php echo $model['nama_saksi'];?>" required data-error="Kolom [Nama] belum diisi" />
                                <span class="input-group-btn"><button class="btn" type="button" id="pilih_saksi"><i class="fa fa-search"></i></button></span>
                            </div>
                            <div class="help-block with-errors" id="error_custom_nama_saksi"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-10">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-3">Alamat</label>        
                        <div class="col-md-7">
                            <textarea name="modal_alamat_saksi" id="modal_alamat_saksi" class="form-control" style="height:80px"><?php echo $model['alamat_saksi'];?></textarea>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-10">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-3">Keterangan</label>        
                        <div class="col-md-7">
                            <textarea class="form-control" id="modal_keterangan_saksi" name="modal_keterangan_saksi" style="height:80px"><?php echo $model['keterangan_saksi'];?></textarea>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="box-footer" style="text-align:center;">
        <input type="hidden" name="modal_status_saksi" id="modal_status_saksi" value="<?php echo $model['status_saksi'];?>" />
        <input type="hidden" name="evt_penggeledahan_sukses" id="evt_penggeledahan_sukses" />
        <input type="hidden" name="nurec_penggeledahan" id="nurec_penggeledahan" value="" />
        <input type="hidden" name="tr_id_penggeledahan" id="tr_id_penggeledahan" value="" />
        <button type="submit" id="simpan_form_penggeledahan" class="btn btn-warning btn-sm jarak-kanan"></button>
        <a data-dismiss="modal" class="btn btn-danger btn-sm"><i class="fa fa-reply jarak-kanan"></i>Kembali</a>
    </div>
    </form>
</div>
<style>
	#wrapper-modal-tsk.loading {overflow: hidden;}
	#wrapper-modal-tsk.loading .modal-loading-new {display: block;}

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
<div class="modal-loading-new"></div> 
<script type="text/javascript">
$(document).ready(function(){
});
</script>