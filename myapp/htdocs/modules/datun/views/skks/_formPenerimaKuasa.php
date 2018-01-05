<?php 
	use app\modules\datun\models\Skk;
	if($isNewRecord){
		$sql1 = "select nip as nip_pegawai, nama as nama_pegawai, jabatan_jpn as jabatan_pegawai, pangkat_jpn as pangkat_pegawai, gol_jpn as gol_pegawai 
				from datun.sp1_timjpn where no_register_perkara = '".$model['no_register_perkara']."' and no_surat = '".$model['no_surat']."'";
		$res1 = Skk::findBySql($sql1)->asArray()->all();
	} else{
		$sql1 = "select nip_pegawai, nama_pegawai, jabatan_pegawai, pangkat_pegawai, gol_pegawai, alamat_instansi from datun.skks_anak 
				where no_register_perkara = '".$model['no_register_perkara']."' and no_surat = '".$model['no_surat']."' and no_register_skk = '".$model['no_register_skk']."' 
				and tanggal_skk = '".$model['tanggal_skk']."' and no_register_skks = '".$model['no_register_skks']."' order by no_urut";
		$res1 = Skk::findBySql($sql1)->asArray()->all();
	}
	$sqlCek = "
		select string_agg(penerima_kuasa, '#') as penerima_kuasa_all from (
			select penerima_kuasa from datun.skk where no_register_perkara = '".$model['no_register_perkara']."' and no_surat = '".$model['no_surat']."' 
				and no_register_skk = '".$model['no_register_skk']."' and tanggal_skk = '".$model['tanggal_skk']."'
			union all
			select a.penerima_kuasa from datun.skks a 
			left join datun.skk b on a.no_register_perkara = b.no_register_perkara and a.no_surat = b.no_surat 
				and a.pemberi_kuasa = b.no_register_skk and a.tanggal_skk = b.tanggal_skk 
			left join datun.skks c on a.no_register_perkara = c.no_register_perkara and a.no_surat = c.no_surat 
				and a.no_register_skk = c.no_register_skk and a.tanggal_skk = c.tanggal_skk and a.pemberi_kuasa = c.no_register_skks
			where a.no_register_perkara = '".$model['no_register_perkara']."' and a.no_surat = '".$model['no_surat']."' 
				and a.no_register_skk = '".$model['no_register_skk']."' and a.tanggal_skk = '".$model['tanggal_skk']."'
		) a";
	$resCek = Skk::findBySql($sqlCek)->asArray()->scalar();
	$arrCek = explode("#", $resCek);
	$arrPnk = array("JAMDATUN"=>"JAMDATUN", "KAJATI"=>"KAJATI", "KAJARI"=>"KAJARI", "KACABJARI"=>"KACABJARI", "JPN"=>"TIM JPN");
?>

<div class="row">
	<div class="col-md-12">
		<div class="form-group form-group-sm">
			<label class="control-label col-md-4">Penerima Kuasa</label>
			<div class="col-md-8">
				<?php if($isNewRecord){ ?>
                <select id="penerima_kuasa" name="penerima_kuasa" class="select2" style="width:100%" required data-error="Penerima kuasa belum dipilih">
					<option></option>
					<?php
						foreach($arrPnk as $idx=>$val){
							$selected = ($model['penerima_kuasa'] == $idx)?'selected':'';
							echo (!in_array($idx, $arrCek) || $idx == 'JPN')?'<option value="'.$idx.'" '.$selected.'>'.$val.'</option>':'';
						}
					?>
				</select>
                <?php } else{ ?>
                <input type="hidden" name="penerima_kuasa" id="penerima_kuasa" value="<?php echo $model['penerima_kuasa'];?>" />
                <input type="text" name="penerima_kuasa_txt" id="penerima_kuasa_txt" class="form-control" value="<?php echo $arrPnk[$model['penerima_kuasa']];?>" readonly />
                <?php } ?>
                
                <div class="help-block with-errors" id="error_custom4"></div>
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
				</div>
			</div>
		</div>
	</div>        
	<div class="row">
		<div class="col-md-12">
			<div class="form-group form-group-sm">
				<label class="control-label col-md-4">Alamat Instansi</label>
				<div class="col-md-8">
					<textarea id="alamat_penerima" name="alamat_penerima[]" class="form-control" style="height:90px;"><?php echo $res1[0]['alamat_instansi'];?></textarea>
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
					<th class="text-center" width="38%">Nama</th>
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
								<td>'.$nip.'<br />'.$nmp.'</td>
								<td>'.$gol.'</td>
								<td class="text-center"><input type="checkbox" name="cekModalJpn[]" id="cekModalJpn_'.$nom.'" class="hRowJpn" value="'.$nip.'" /></td>
							</tr>';
						}
					}
                ?>
			</tbody>
		</table>
	</div>
	<div class="box-footer" style="border-top:1px solid #f4f4f4; text-align:left !important; padding:5px; 10px;">
		<p style="margin-bottom:0px; font-size:12px;"><i>* JPN yang di tugaskan minimal 2 orang</i></p>
	</div>
</div>
<div class="err_pknya"></div>

