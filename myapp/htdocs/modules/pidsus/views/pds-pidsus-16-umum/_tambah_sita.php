<?php
	use app\modules\pidsus\models\PdsPidsus16Umum;
	//echo '<pre>'; print_r($model); echo '</pre>';
        $tgl_penyitaan = ($model['tgl_penyitaan'])?date('d-m-Y',strtotime($model['tgl_penyitaan'])):'';
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
                <div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-5">Disita dari</label>        
                        <div class="col-md-7">
                            <input type="text" name="modal_disita_dari" id="modal_disita_dari" class="form-control" value="<?php echo $model['disita_dari'];?>" required data-error="Kolom [Disita dari] belum diisi" maxlength="150" />
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
                <div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-5">Tempat Penyitaan</label>        
                        <div class="col-md-7">
                            <input type="text" name="modal_tempat_penyitaan" id="modal_tempat_penyitaan" class="form-control" value="<?php echo $model['tempat_penyitaan'];?>" required data-error="Kolom [Tempat Penyitaan] belum diisi" maxlength="150" />
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
        
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Pemilik</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-5">Nama</label>        
                        <div class="col-md-7">
                            <input type="text" name="modal_nama_pemilik" id="modal_nama_pemilik" class="form-control" value="<?php echo $model['nama_pemilik'];?>" required data-error="Nama pemilik belum diisi" />
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-5">Pekerjaan</label>        
                        <div class="col-md-7">
                            <input type="text" name="modal_pekerjaan_pemilik" id="modal_pekerjaan_pemilik" class="form-control" value="<?php echo $model['pekerjaan_pemilik'];?>" required data-error="Pekerjaan pemilik belum diisi" />
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-5">Alamat</label>        
                        <div class="col-md-7">
                            <textarea class="form-control" id="modal_alamat_pemilik" name="modal_alamat_pemilik" style="height: 100px"><?php echo $model['alamat_pemilik'];?></textarea>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="row">
                <div class="col-sm-12">
                    <a class="btn btn-danger btn-sm disabled" id="btn_hapusjpn_sita"><i class="fa fa-trash" style="font-size:14px;"></i></a>
                    <a class="btn btn-success btn-sm" id="btn_tambahjpn_sita"><i class="fa fa-user-plus jarak-kanan"></i>Tambah Jaksa</a>
                </div>		
            </div>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-jpn-sita-modal">
                    <thead>
                        <tr>
                            <th class="text-center" width="7%"><input type="checkbox" name="allCheckJpnSita" id="allCheckJpnSita" class="allCheckJpnSita" /></th>
                            <th class="text-center" width="7%">No</th>
                            <th class="text-center" width="38%">NIP / Nama</th>
                            <th class="text-center" width="48%">Jabatan / Pangkat &amp; Golongan</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
						if(count($model['jpnsitaid']) == 0){
							echo '<tr><td colspan="4">Data tidak ditemukan</td></tr>';
						} else{
							$nom = 0;
							foreach($model['jpnsitaid'] as $data){
								$nom++;	
								list($nip_jaksa, $nama_jaksa, $gol_jaksa, $pangkat_jaksa, $jabatan_jaksa) = explode("|##|", $data);						
								echo '
								<tr data-id="'.$nip_jaksa.'">
									<td class="text-center">
										<input type="checkbox" name="cekJpnSitaModal[]" id="cekJpnSitaModal_'.$nom.'" class="hRowJpnSita" value="'.$nip_jaksa.'" />
									</td>
									<td class="text-center">
										<span class="frmnojpnsita" data-row-count="'.$nom.'">'.$nom.'</span><input type="hidden" name="modal_jpnsitaid[]" value="'.$data.'" />
									</td>
									<td>'.$nip_jaksa.'<br />'.$nama_jaksa.'</td>
									<td>'.$jabatan_jaksa.'<br />'.$pangkat_jaksa.' ('.$gol_jaksa.')</td>
								</tr>';
							}
						}
                     ?>	
                    </tbody>
                </table>
            </div>
        </div>
    </div>			
        
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Waktu Pelaksanaan</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-2">Jam</label>       
                        <div class="col-md-5">
                            <div class="input-group bootstrap-timepicker">
                                <div class="input-group-addon picker" style="border-right:0px;"><i class="fa fa-clock-o"></i></div>
                                <input type="text" name="modal_jam_penyitaan" id="modal_jam_penyitaan" class="form-control timepicker" value="<?php echo $model['jam_penyitaan']; ?>" required data-error="Jam penyitaan belum diisi" />
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-2">Tanggal</label>        
                        <div class="col-md-5">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input type="text" name="modal_tgl_penyitaan" id="modal_tgl_penyitaan" class="form-control datepicker" value="<?php echo $tgl_penyitaan;?>" required data-error="Tanggal penyitaan belum diisi" />
                            </div>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Keperluan</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">       
                            <div class="col-md-12">
                                <textarea name="modal_sita_keperluan" id="modal_sita_keperluan" class="form-control" style="height:100px"><?php echo $model['sita_keperluan'];?></textarea>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Keterangan</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">       
                            <div class="col-md-12">
                                <textarea name="modal_sita_keterangan" id="modal_sita_keterangan" class="form-control" style="height:100px"><?php echo $model['sita_keterangan'];?></textarea>
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
	$('.allCheckJpnSita, .hRowJpnSita').iCheck({checkboxClass:'icheckbox_square-pink'});
        $(".timepicker").timepicker({"defaultTime":false, "showMeridian":false, "minuteStep":1, "dropdown":true, "scrollbar":true});
	$("#modal_jam_penyitaan").on('focus', function(){
		$(this).prev().trigger('click');
	});
        
        var tglASDF123 = '<?php echo date("Y").",".date("m").",".date("d");?>';
        $("#modal_tgl_penyitaan").datepicker({								  
		defaultDate: new Date(tglASDF123),
		dateFormat: 'dd-mm-yy',
		changeMonth: true,
		changeYear: true,
		yearRange: "c-80:c+10",
		dayNamesMin: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
		monthNamesShort: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
        });
});
</script>