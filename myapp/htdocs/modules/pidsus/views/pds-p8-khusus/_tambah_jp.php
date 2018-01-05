<div id="wrapper-modal-jps">
    <form class="form-horizontal" id="form-modal-jaksa-penyidik">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-2">Nama</label>        
                    <div class="col-md-8">
                        <div class="input-group">
                            <input type="hidden" name="mjp_nip_jaksa" id="mjp_nip_jaksa" value="" />
                            <input type="hidden" name="mjp_gol_jaksa" id="mjp_gol_jaksa" value="" />
                            <input type="hidden" name="mjp_pangkat_jaksa" id="mjp_pangkat_jaksa" value="" />
                            <input type="hidden" name="mjp_jabatan_jaksa" id="mjp_jabatan_jaksa" value="" />
                            <input type="text" class="form-control" id="mjp_nama_jaksa" name="mjp_nama_jaksa" placeholder="--Pilih Jaksa--" readonly />
                            <div class="input-group-btn"><button type="button" class="btn btn-success btn-sm" id="btn_tambah_mjp"><i class="fa fa-search"></i></button></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-2">Jabatan</label>        
                    <div class="col-md-8">
                        <select name="mjp_jabatan_p8" id="mjp_jabatan_p8" class="select2" style="width:100%">
                            <option></option>
                            <option value="1">Koordinator</option>
                            <option value="2">Ketua Tim</option>
                            <option value="3">Wakil Ketua</option>
                            <option value="4">Sekretaris</option>
                            <option value="5">Anggota</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
		<div class="help-block with-errors" id="error_custom_modal1"></div>
        <div class="box-footer" style="text-align:center;">
            <button type="button" class="btn btn-warning jarak-kanan" id="modalPilihJaksaPenyidik">Simpan</button>
            <button type="button" class="btn btn-danger" id="modalBatalJaksaPenyidik">Batal</button>
        </div>
    </form>
</div>

<div class="modal fade" id="modal_list_jaksa_penyidik" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" style="width:1000px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Daftar Jaksa</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<style>
	#wrapper-modal-jps.loading {overflow: hidden;}
	#wrapper-modal-jps.loading .modal-loading-new {display: block;}

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