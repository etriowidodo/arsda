<?php
	use app\modules\pidsus\models\PdsPidsus16Umum;
	//echo '<pre>'; print_r($model); echo '</pre>';
        $tgl_penggeledahan = ($model['tgl_penggeledahan'])?date('d-m-Y',strtotime($model['tgl_penggeledahan'])):'';
?>
<div id="wrapper-modal-gldh">
    <form class="form-horizontal" id="form-modal-gldh">
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-5">Penggeledahan Terhadap</label>        
                        <div class="col-md-7">
                            <select name="modal_penggeledahan_terhadap" id="modal_penggeledahan_terhadap" class="select2" style="width:100%" required data-error="Kolom [Penggeledahan Terhadap] belum dipilih">
                                <option></option>
                                <option <?php echo ($model['penggeledahan_terhadap'] == 'Subyek')?'selected':'';?>>Subyek</option>
                                <option <?php echo ($model['penggeledahan_terhadap'] == 'Obyek')?'selected':'';?>>Obyek</option>
                            </select>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row subyek" <?php echo ($model['penggeledahan_terhadap'] != 'Subyek')?'hidden':'';?>>
                <div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-5">Nama</label>        
                        <div class="col-md-7">
                            <input type="text" name="modal_gldh_nama" id="modal_gldh_nama" class="form-control" value="<?php echo $model['gldh_nama'];?>" required data-error="Kolom [Nama] belum diisi" />
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-5">Jabatan</label>        
                        <div class="col-md-7">
                            <input type="text" name="modal_gldh_jabatan" id="modal_gldh_jabatan" class="form-control" value="<?php echo $model['gldh_jabatan'];?>" required data-error="Kolom [Jabatan] belum diisi" />
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row obyek" <?php echo ($model['penggeledahan_terhadap'] != 'Obyek')?'hidden':'';?>>
                <div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-5">Tempat Penggeledahan</label>        
                        <div class="col-md-7">
                            <input type="text" name="modal_tempat_penggeledahan" id="modal_tempat_penggeledahan" class="form-control" value="<?php echo $model['tempat_penggeledahan'];?>" required data-error="Kolom [Tempat Penggeledahan] belum diisi" />
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-5">Alamat Penggeledahan</label>        
                        <div class="col-md-7">
                            <textarea name="modal_alamat_penggeledahan" id="modal_alamat_penggeledahan" class="form-control" style="height:70px" required data-error="Kolom [Alamat Penggeledahan] belum diisi"><?php echo $model['alamat_penggeledahan'];?></textarea>
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
                            <input type="text" name="modal_gldh_nama_pemilik" id="modal_gldh_nama_pemilik" class="form-control" value="<?php echo $model['gldh_nama_pemilik'];?>" required data-error="Nama pemilik belum diisi" />
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-5">Pekerjaan</label>        
                        <div class="col-md-7">
                            <input type="text" name="modal_gldh_pekerjaan_pemilik" id="modal_gldh_pekerjaan_pemilik" class="form-control" value="<?php echo $model['gldh_pekerjaan_pemilik'];?>" required data-error="Pekerjaan pemilik belum diisi" />
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
                            <textarea class="form-control" id="modal_gldh_alamat_pemilik" name="modal_gldh_alamat_pemilik" style="height: 100px"><?php echo $model['gldh_alamat_pemilik'];?></textarea>
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
                    <a class="btn btn-danger btn-sm disabled" id="btn_hapusjpn_gldh"><i class="fa fa-trash" style="font-size:14px;"></i></a>
                    <a class="btn btn-success btn-sm" id="btn_tambahjpn_gldh"><i class="fa fa-user-plus jarak-kanan"></i>Tambah Jaksa</a>
                </div>		
            </div>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-jpn-gldh-modal">
                    <thead>
                        <tr>
                            <th class="text-center" width="7%"><input type="checkbox" name="allCheckJpnGldh" id="allCheckJpnGldh" class="allCheckJpnGldh" /></th>
                            <th class="text-center" width="7%">No</th>
                            <th class="text-center" width="38%">NIP / Nama</th>
                            <th class="text-center" width="48%">Jabatan / Pangkat &amp; Golongan</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
						if(count($model['jpngldhid']) == 0){
							echo '<tr><td colspan="4">Data tidak ditemukan</td></tr>';
						} else{
							$nom = 0;
							foreach($model['jpngldhid'] as $data){
								$nom++;	
								list($nip_jaksa, $nama_jaksa, $gol_jaksa, $pangkat_jaksa, $jabatan_jaksa) = explode("|##|", $data);						
								echo '
								<tr data-id="'.$nip_jaksa.'">
									<td class="text-center">
										<input type="checkbox" name="cekJpnGldhModal[]" id="cekJpnGldhModal_'.$nom.'" class="hRowJpnGldh" value="'.$nip_jaksa.'" />
									</td>
									<td class="text-center">
										<span class="frmnojpngldh" data-row-count="'.$nom.'">'.$nom.'</span><input type="hidden" name="modal_jpngldhid[]" value="'.$data.'" />
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
                                <input type="text" name="modal_jam_penggeledahan" id="modal_jam_penggeledahan" class="form-control timepicker" value="<?php echo $model['jam_penggeledahan']; ?>" required data-error="Jam penggeledahan belum diisi" />
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
                                <input type="text" name="modal_tgl_penggeledahan" id="modal_tgl_penggeledahan" class="form-control datepicker" value="<?php echo $tgl_penggeledahan;?>" required data-error="Tanggal penggeledahan belum diisi" />
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
                                <textarea name="modal_gldh_keperluan" id="modal_gldh_keperluan" class="form-control" style="height:100px"><?php echo $model['gldh_keperluan'];?></textarea>
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
                                <textarea name="modal_gldh_keterangan" id="modal_gldh_keterangan" class="form-control" style="height:100px"><?php echo $model['gldh_keterangan'];?></textarea>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="box-footer" style="text-align:center;">
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
        $(".timepicker").timepicker({"defaultTime":false, "showMeridian":false, "minuteStep":1, "dropdown":true, "scrollbar":true});
	$("#modal_jam_penggeledahan").on('focus', function(){
		$(this).prev().trigger('click');
	});
        
        var tglASDF123 = '<?php echo date("Y").",".date("m").",".date("d");?>';
        $("#modal_tgl_penggeledahan").datepicker({								  
		defaultDate: new Date(tglASDF123),
		dateFormat: 'dd-mm-yy',
		changeMonth: true,
		changeYear: true,
		yearRange: "c-80:c+10",
		dayNamesMin: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
		monthNamesShort: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
        });
        
	$(".select2").select2({placeholder:"Pilih salah satu", allowClear:true});
	$('.allCheckJpnGldh, .hRowJpnGldh').iCheck({checkboxClass:'icheckbox_square-pink'});
	$('#modal_penggeledahan_terhadap').on('change',function(){
		var nilai = $(this).val();
		if(nilai == 'Subyek'){
			$('.obyek').slideUp();
			$('.subyek').slideDown();
		} else if(nilai == 'Obyek'){
			$('.subyek').slideUp();
			$('.obyek').slideDown();
		} else{
			$('.subyek').slideUp();
			$('.obyek').slideUp();
		}
		$("#form-modal-gldh").validator('update');
	});
});
</script>