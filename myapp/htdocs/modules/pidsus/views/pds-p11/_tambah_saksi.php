<div id="wrapper-modal-tsk">
    <form class="form-horizontal" id="frm-m1">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-3">Nama</label>        
                        <div class="col-md-7">
                            <select name="nama" id="nama" class="select2" style="width:100%">
                                <option></option>
                                
                            </select>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-3">Alamat</label>        
                        <div class="col-md-7">
                            <textarea class="form-control" style="height: 100px" name="alamat" id="alamat"></textarea>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-3">Keterangan</label>        
                        <div class="col-md-7">
                            <textarea class="form-control" style="height: 100px" name="ket" id="ket"></textarea>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer" style="text-align:center;">
            <button class="btn btn-warning jarak-kanan pilih-jpn" id="simpan_usul" type="button">Simpan</button>
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