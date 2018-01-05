<div id="wrapper-modal-tsk">
    <form class="form-horizontal" id="frm-m1">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-3">Nama</label>        
                        <div class="col-md-7">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $model['nama'];?>" />
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-3">Jabatan</label>        
                        <div class="col-md-7">
                            <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?php echo $model['jabatan'];?>" />
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-3">Waktu Pelaksanaan</label>        
                        <div class="col-md-7">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input type="text" name="wkt_pelaksanaan" id="wkt_pelaksanaan" class="form-control datepicker" value="<?php echo $model['wkt_pelaksanaan'];?>"/>
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-3">Jaksa yang Melaksanakan</label>        
                        <div class="col-md-7">
                            <select name="jabatan" id="jabatan" class="select2" style="width:100%">
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
                        <label class="control-label col-md-3">Keperluan</label>        
                        <div class="col-md-7">
                            <textarea class="form-control" style="height: 100px" id="keperluan" name="keperluan"></textarea>
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
            var tglASDF123 = '<?php echo date("Y").",".date("m").",".date("d");?>';
            $(".datepicker").datepicker({								  
		defaultDate: new Date(tglASDF123),
		dateFormat: 'dd-mm-yy',
		changeMonth: true,
		changeYear: true,
		yearRange: "c-80:c+10",
		dayNamesMin: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
		monthNamesShort: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
            });
            $(".select2").select2({placeholder:"Pilih salah satu", allowClear:true});
	});
</script>