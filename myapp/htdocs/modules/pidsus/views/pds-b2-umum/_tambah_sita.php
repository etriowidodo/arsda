<?php
	use app\modules\pidsus\models\PdsPidsus16Umum;
	//echo '<pre>'; print_r($model); echo '</pre>';
?>
<div id="wrapper-modal-sita">
    <form class="form-horizontal" id="form-modal-sita">
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-5">Nama Barang yang Disita</label>        
                        <div class="col-md-7">
                            <input type="text" name="modal_nama_barang_disita" id="modal_nama_barang_disita" class="form-control" value="<?php echo $model['nama_barang_disita'];?>" required data-error="Nama barang belum diisi" maxlength="100" />
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-5">Jenis Barang yang Disita</label>        
                        <div class="col-md-7">
                            <input type="text" name="modal_jenis_barang_disita" id="modal_jenis_barang_disita" class="form-control" value="<?php echo $model['jenis_barang_disita'];?>" required data-error="Kolom [Jenis Barang yang Disita] belum diisi" maxlength="100" />
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-5">Jumlah Barang yang Disita</label>        
                        <div class="col-md-3">
                            <input type="text" name="modal_jumlah_barang_disita" id="modal_jumlah_barang_disita" class="form-control" value="<?php echo $model['jumlah_barang_disita'];?>" required data-error="Kolom [Jumlah Barang yang Disita] belum diisi" />
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
      
    <div class="box-footer" style="text-align:center;">
        <input type="hidden" name="evt_penyitaan_sukses" id="evt_penyitaan_sukses" />
        <input type="hidden" name="nurec_penyitaan" id="nurec_penyitaan" value="" />
        <input type="hidden" name="tr_id_penyitaan" id="tr_id_penyitaan" value="" />
        <button type="submit" id="simpan_form_penyitaan" class="btn btn-warning btn-sm jarak-kanan"></button>
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
	$(".select2").select2({placeholder:"Pilih salah satu", allowClear:true});
});
</script>