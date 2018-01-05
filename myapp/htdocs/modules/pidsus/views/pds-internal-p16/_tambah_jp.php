<div id="wrapper-modal-tsk">
    <form class="form-horizontal" id="frm-m1">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-2">Nama</label>        
                        <div class="col-md-8">
                            <div class="input-group">
                                <input type="text" class="form-control" id="nama_jp" name="nama_jp" value="<?php echo $model['nama_jp'];?>" placeholder="--Pilih Jaksa--" readonly />
                                <div class="input-group-btn"><button type="button" class="btn btn-success btn-sm" id="btn_tambahjpn" title="Cari">...</button></div>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-2">Jabatan</label>        
                        <div class="col-md-8">
                            <select name="jabatan" id="jabatan" class="select2" style="width:100%">
                                <option></option>
                                <option value="1">Koordinator</option>
                                <option value="2">Ketua Tim</option>
                                <option value="3">Wakil Ketua</option>
                                <option value="4">Sekretaris</option>
                                <option value="5">Anggota</option>
                            </select>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer" style="text-align:center;">
            <button class="btn btn-warning jarak-kanan pilih-jpn" type="button">Simpan</button>
            <button class="btn btn-danger" data-dismiss="modal" type="button">Batal</button>
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