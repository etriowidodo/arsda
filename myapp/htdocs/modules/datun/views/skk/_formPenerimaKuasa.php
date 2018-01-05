<?php 
	use app\modules\datun\models\Skk;
	if($isNewRecord)
		$res1 = array();
	else{
		$sql1 = "select nip_pegawai, nama_pegawai, jabatan_pegawai, pangkat_pegawai, gol_pegawai, alamat_instansi from datun.skk_anak 
				where no_register_perkara = '".$model['no_register_perkara']."' and no_surat = '".$model['no_surat']."' and no_register_skk = '".$model['no_register_skk']."' 
				and tanggal_skk = '".$model['tanggal_skk']."' order by no_urut";
		$res1 = Skk::findBySql($sql1)->asArray()->all();
	}
?>

<?php if($model['kode_jenis_instansi'] && $model['kode_jenis_instansi'] == '06'){ ?>
<div class="row">
	<div class="col-md-12">
		<div class="form-group form-group-sm">
			<label class="control-label col-md-4">Penerima Kuasa</label>
			<div class="col-md-8">
				<select id="penerima_kuasa" name="penerima_kuasa" class="select2" style="width:100%" required data-error="Penerima kuasa belum diisi">
                	<option></option>
					<option value="JAMDATUN" <?php echo ($model['penerima_kuasa'] == 'JAMDATUN')?'selected':'';?>>JAMDATUN</option>
					<option value="KAJATI" <?php echo ($model['penerima_kuasa'] == 'KAJATI')?'selected':'';?>>KAJATI</option>
					<option value="KAJARI" <?php echo ($model['penerima_kuasa'] == 'KAJARI')?'selected':'';?>>KAJARI</option>
					<option value="KACABJARI" <?php echo ($model['penerima_kuasa'] == 'KACABJARI')?'selected':'';?>>KACABJARI</option>
					<option value="JPN" <?php echo ($model['penerima_kuasa'] == 'JPN')?'selected':'';?>>TIM JPN</option>
				</select>
                <div class="help-block with-errors"></div>
			</div>
		</div>
	</div>
</div>
<div id="frm_modal_penerima_ja" class="<?php echo ($model['penerima_kuasa'] == 'JPN')?'hide':'';?>">
	<div class="row">
		<div class="col-md-12">
			<div class="form-group form-group-sm">
				<label class="control-label col-md-4">Nama</label>
				<div class="col-md-8">
					<div class="input-group">
						<input type="hidden" id="nip_penerima" name="nip_penerima[]" value="<?php echo $res1[0]['nip_pegawai'];?>" />
						<input type="text" id="nama_penerima" name="nama_penerima[]" class="form-control" value="<?php echo $res1[0]['nama_pegawai'];?>" readonly />
						<div class="input-group-btn"><button type="button" name="btn-cari" id="btn-cari-peg" class="btn btn-success btn-sm">...</button></div>
					</div>
                    <div class="help-block with-errors" id="error_custom5"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group form-group-sm">
				<label class="control-label col-md-4">Jabatan</label>
				<div class="col-md-8">
					<input type="text" id="jabatan_penerima" name="jabatan_penerima[]" value="<?php echo $res1[0]['jabatan_pegawai'];?>" class="form-control" />
                	<div class="help-block with-errors"></div>
				</div>
			</div>
		</div>
	</div>        
	<div class="row">
		<div class="col-md-12">
			<div class="form-group form-group-sm">
				<label class="control-label col-md-4">Alamat Instansi</label>
				<div class="col-md-8">
					<textarea id="alamat_penerima" name="alamat_penerima[]" class="form-control" style="height:125px;"><?php echo $res1[0]['alamat_instansi'];?></textarea>
                	<div class="help-block with-errors"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="frm_modal_penerima_jpn" class="<?php echo ($model['penerima_kuasa'] != 'JPN')?'hide':'';?>">
	<div class="row">
		<div class="col-sm-10"><a class="btn btn-success btn-sm" id="btn_tambahjpn"><i class="fa fa-user-plus jarak-kanan"></i>Tambah JPN</a></div>	
		<div class="col-sm-2"><a class="btn btn-danger btn-sm disabled text-right" id="btn_hapusjpn">Hapus</a></div>	
	</div>
	<p style="margin-bottom:10px;"></p>		

	<div class="table-responsive">
		<table class="table table-bordered table-hover table-jpn-modal">
			<thead>
				<tr>
					<th class="text-center" width="8%">No</th>
					<th class="text-center" width="38%">NIP/Nama</th>
					<th class="text-center" width="30%">Pangkat & Golongan</th>
					<th class="text-center" width="8%"><input type="checkbox" name="allCheckJpn" id="allCheckJpn" class="allCheckJpn" /></th>
				</tr>
			</thead>
			<tbody>
				<?php 
					if(count($res1) == 0)
						echo '<tr><td colspan="4">JPN tidak ditemukan</td></tr>';
					else{
						foreach($res1 as $idx1=>$data1){
							$nom = ($idx1 + 1);
							$nip = $data1['nip_pegawai'];
							$nmp = $data1['nama_pegawai'];
							$gol = $data1['pangkat_pegawai']." (".$data1['gol_pegawai'].")";
							$wow = $nip."#".$nmp."#".$gol."#".$data1['gol_pegawai']."#".$data1['pangkat_pegawai']."#".$data1['jabatan_pegawai'];

							echo '<tr data-id="'.$nip.'">
								<td class="text-center">
									<span class="frmnojpn" data-row-count="'.$nom.'">'.$nom.'</span>
									<input type="hidden" name="jpnid[]" value="'.$wow.'" />
								</td>
								<td>'.$nip.'<br>'.$nmp.'</td>
								<td>'.$gol.'</td>
								<td class="text-center"><input type="checkbox" name="cekModalJpn[]" id="cekModalJpn_'.$nom.'" class="hRowJpn" value="'.$nip.'" /></td>
							</tr>';
						}
					}
                ?>
			</tbody>
		</table>
	</div>
	<div class="help-block with-errors" id="error_custom5A"></div>
</div>
<?php } else if($model['kode_jenis_instansi'] && $model['kode_jenis_instansi'] != '06'){ ?>
<?php if($model['kode_tk'] == '0'){ ?>
<div class="row">
    <div class="col-md-12">
        <div class="form-group form-group-sm">
            <label class="control-label col-md-4">Penerima Kuasa</label>
            <div class="col-md-8">
                <select id="penerima_kuasa" name="penerima_kuasa" class="select2" style="width:100%" required data-error="Penerima kuasa belum diisi">
                	<option></option>
					<option value="JA" <?php echo ($model['penerima_kuasa'] == 'JA')?'selected':'';?>>JAKSA AGUNG</option>
					<option value="JAMDATUN" <?php echo ($model['penerima_kuasa'] == 'JAMDATUN')?'selected':'';?>>JAMDATUN</option>
                </select>
                <div class="help-block with-errors"></div>
            </div>
        </div>
    </div>
</div>	
<?php } else if($model['kode_tk'] == '1'){ ?>
<div class="row">
    <div class="col-md-12">
        <div class="form-group form-group-sm">
            <label class="control-label col-md-4">Penerima Kuasa</label>
            <div class="col-md-8">
                <select id="penerima_kuasa" name="penerima_kuasa" class="select2" style="width:100%" required data-error="Penerima kuasa belum diisi">
                	<option></option>
					<option value="JA" <?php echo ($model['penerima_kuasa'] == 'JA')?'selected':'';?>>JAKSA AGUNG</option>
					<option value="JAMDATUN" <?php echo ($model['penerima_kuasa'] == 'JAMDATUN')?'selected':'';?>>JAMDATUN</option>
                	<option value="KAJATI" <?php echo ($model['penerima_kuasa'] == 'KAJATI')?'selected':'';?>>KAJATI</option>
                </select>
                <div class="help-block with-errors"></div>
            </div>
        </div>
    </div>
</div>	
<?php } else if($model['kode_tk'] == '2'){ ?>
<div class="row">
    <div class="col-md-12">
        <div class="form-group form-group-sm">
            <label class="control-label col-md-4">Penerima Kuasa</label>
            <div class="col-md-8">
                <select id="penerima_kuasa" name="penerima_kuasa" class="select2" style="width:100%" required data-error="Penerima kuasa belum diisi">
                	<option></option>
					<option value="JA" <?php echo ($model['penerima_kuasa'] == 'JA')?'selected':'';?>>JAKSA AGUNG</option>
					<option value="JAMDATUN" <?php echo ($model['penerima_kuasa'] == 'JAMDATUN')?'selected':'';?>>JAMDATUN</option>
                	<option value="KAJATI" <?php echo ($model['penerima_kuasa'] == 'KAJATI')?'selected':'';?>>KAJATI</option>
                	<option value="KAJARI" <?php echo ($model['penerima_kuasa'] == 'KAJARI')?'selected':'';?>>KAJARI</option>
                </select>
                <div class="help-block with-errors"></div>
            </div>
        </div>
    </div>
</div>	
<?php } else if($model['kode_tk'] == '3'){ ?>
<div class="row">
    <div class="col-md-12">
        <div class="form-group form-group-sm">
            <label class="control-label col-md-4">Penerima Kuasa</label>
            <div class="col-md-8">
                <select id="penerima_kuasa" name="penerima_kuasa" class="select2" style="width:100%" required data-error="Penerima kuasa belum diisi">
                	<option></option>
					<option value="JA" <?php echo ($model['penerima_kuasa'] == 'JA')?'selected':'';?>>JAKSA AGUNG</option>
					<option value="JAMDATUN" <?php echo ($model['penerima_kuasa'] == 'JAMDATUN')?'selected':'';?>>JAMDATUN</option>
                	<option value="KAJATI" <?php echo ($model['penerima_kuasa'] == 'KAJATI')?'selected':'';?>>KAJATI</option>
                	<option value="KAJARI" <?php echo ($model['penerima_kuasa'] == 'KAJARI')?'selected':'';?>>KAJARI</option>
                	<option value="KACABJARI" <?php echo ($model['penerima_kuasa'] == 'KACABJARI')?'selected':'';?>>KACABJARI</option>
                </select>
                <div class="help-block with-errors"></div>
            </div>
        </div>
    </div>
</div>	
<?php } ?>

<div class="row">
    <div class="col-md-12">
        <div class="form-group form-group-sm">
            <label class="control-label col-md-4">Nama</label>
            <div class="col-md-8">
                <div class="input-group">
                    <input type="hidden" id="nip_penerima" name="nip_penerima[]" value="<?php echo $res1[0]['nip_pegawai'];?>" />
                	<input type="text" id="nama_penerima" name="nama_penerima[]" class="form-control" value="<?php echo $res1[0]['nama_pegawai'];?>" readonly />
                    <div class="input-group-btn"><button type="button" name="btn-cari" id="btn-cari-peg" class="btn btn-success btn-sm">...</button></div>
                	<div class="help-block with-errors" id="error_custom5B"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group form-group-sm">
            <label class="control-label col-md-4">Jabatan</label>
            <div class="col-md-8">
                <input type="text" id="jabatan_penerima" name="jabatan_penerima[]" class="form-control" value="<?php echo $res1[0]['jabatan_pegawai'];?>" />
                <div class="help-block with-errors"></div>
            </div>
        </div>
    </div>
</div>        
<div class="row">
    <div class="col-md-12">
        <div class="form-group form-group-sm">
            <label class="control-label col-md-4">Alamat Instansi</label>
            <div class="col-md-8">
                <textarea id="alamat_penerima" name="alamat_penerima[]" class="form-control" style="height:125px;"><?php echo $res1[0]['alamat_instansi'];?></textarea>
                <div class="help-block with-errors"></div>
            </div>
        </div>
    </div>
</div>
<?php } else{ ?>
<div class="row">
	<div class="col-md-12">
		<div class="form-group form-group-sm">
			<label class="control-label col-md-4">Nama</label>
			<div class="col-md-8">
				<input type="text" class="form-control" readonly />
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="form-group form-group-sm">
			<label class="control-label col-md-4">Jabatan</label>
			<div class="col-md-8">
				<input type="text" class="form-control" readonly />
			</div>
		</div>
	</div>
</div>        
<div class="row">
	<div class="col-md-12">
		<div class="form-group form-group-sm">
			<label class="control-label col-md-4">Alamat Instansi</label>
			<div class="col-md-8">
				<textarea class="form-control" style="height:125px;" readonly></textarea>
			</div>
		</div>
	</div>
</div>
<?php } ?>
