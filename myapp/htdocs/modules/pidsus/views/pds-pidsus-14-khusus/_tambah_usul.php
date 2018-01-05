<?php use app\modules\pidsus\models\PdsPidsus14Khusus; ?>
<div id="wrapper-modal-tsk">
    <form class="form-horizontal" id="frm-m1">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-3">Nama</label>        
                        <div class="col-md-7">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $model['nama'];?>" />
                            <div class="help-block with-errors with-errors-modal-saksi" id="error_custom_saksi_nama"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-3">Jabatan</label>        
                        <div class="col-md-7">
                            <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?php echo $model['jabatan'];?>" maxlength="150" />
                            <div class="help-block with-errors with-errors-modal-saksi"></div>
                        </div>
                    </div>
                </div>
            </div>
			<div class="row">
                <div class="col-md-12">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-3">Alamat</label>        
                        <div class="col-md-7">
                            <textarea class="form-control" style="height:70px" id="alamat" name="alamat"><?php echo $model['alamat'];?></textarea>
                            <div class="help-block with-errors with-errors-modal-saksi" id="error_custom_alamat"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-3">Waktu Pelaksanaan</label>        
                        <div class="col-md-3">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input type="text" name="waktu_pelaksanaan" id="waktu_pelaksanaan" class="form-control" value="<?php echo $model['waktu_pelaksanaan'];?>" />
                            </div>
                            <div class="help-block with-errors with-errors-modal-saksi" id="error_custom_waktu_pelaksanaan"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-3">Jaksa yang Melaksanakan</label>        
                        <div class="col-md-7">
                            <select name="jaksa" id="jaksa" style="width:100%">
                                <option></option>
								<?php 
                                    $sqlOpt = "
                                            select nip_jaksa||'#'||nama_jaksa||'#'||gol_jaksa||'#'||pangkat_jaksa||'#'||jabatan_jaksa as id, nama_jaksa as nama 
                                            from pidsus.pds_p8_khusus_jaksa 
                                            where id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' 
                                                    and id_cabjari = '".$_SESSION["kode_cabjari"]."' and no_pidsus18 = '".$_SESSION["pidsus_no_pidsus18"]."' and no_p8_khusus = '".$_SESSION["pidsus_no_p8_khusus"]."'
                                            order by no_urut";
                                    $resOpt = PdsPidsus14Khusus::findBySql($sqlOpt)->asArray()->all();
                                    foreach($resOpt as $dOpt){
                                        $selected = ($model['jaksa'] == $dOpt['id'])?'selected':'';
                                        echo '<option value="'.$dOpt['id'].'" '.$selected.'>'.$dOpt['nama'].'</option>';
                                    }
                                ?>
                            </select>
                            <div class="help-block with-errors with-errors-modal-saksi" id="error_custom_jaksa"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-3">Keperluan</label>        
                        <div class="col-md-4">
                            <select name="status_keperluan" id="status_keperluan" style="width:100%">
                                <option></option>
                                <option <?php echo ($model['status_keperluan'] == "Saksi")?'selected':'';?>>Saksi</option>
                                <option <?php echo ($model['status_keperluan'] == "Ahli")?'selected':'';?>>Ahli</option>
                                <option <?php echo ($model['status_keperluan'] == "Tersangka")?'selected':'';?>>Tersangka</option>
                            </select>
                            <div class="help-block with-errors with-errors-modal-saksi" id="error_custom_status_keperluan"></div>
                        </div>
                    </div>
                </div>
            </div>
			<div class="row">
                <div class="col-md-12">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-3">&nbsp;</label>        
                        <div class="col-md-7">
                            <textarea class="form-control" style="height:70px" id="keperluan" name="keperluan"><?php echo $model['keperluan'];?></textarea>
                            <div class="help-block with-errors with-errors-modal-saksi" id="error_custom_keperluan"></div>
                        </div>
                    </div>
                </div>
            </div>
			<div class="row">
                <div class="col-md-12">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-3">Keterangan</label>        
                        <div class="col-md-7">
                            <textarea class="form-control" style="height:70px" id="keterangan" name="keterangan"><?php echo $model['keterangan'];?></textarea>
                            <div class="help-block with-errors with-errors-modal-saksi" id="error_custom_keterangan"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer text-center"> 
            <input type="hidden" name="tr_id" id="tr_id" value="" />
            <button type="button" id="simpan_form_saksi" class="btn btn-warning btn-sm jarak-kanan"></button>
            <a data-dismiss="modal" class="btn btn-danger btn-sm" id="form_keluar"><i class="fa fa-reply jarak-kanan"></i>Kembali</a>
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
	$("#waktu_pelaksanaan").datepicker({								  
		defaultDate: new Date(tglASDF123),
		dateFormat: 'dd-mm-yy',
		changeMonth: true,
		changeYear: true,
		yearRange: "c-80:c+10",
		dayNamesMin: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
		monthNamesShort: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
	});
	$("#jaksa, #status_keperluan").select2({placeholder:"Pilih salah satu", allowClear:true});
});
</script>