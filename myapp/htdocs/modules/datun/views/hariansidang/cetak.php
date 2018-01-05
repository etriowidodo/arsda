<?php
	use app\modules\datun\models\Sp1;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');

	$docx 	= new CreateDocxFromTemplate('../modules/datun/template/S-11.docx');
	$title	= Yii::$app->inspektur->getNamaSatker();	
	$alamat	= Yii::$app->inspektur->getLokasiSatker()->alamat;
	$lokasi	= Yii::$app->inspektur->getLokasiSatker()->lokasi;
	
	$waktu_tgl 		= ($head['tanggal_s11'])?date("d-m-Y", strtotime($head['tanggal_s11'])):date("Y-m-d");
	$tanggal_skk 	= ($head['tanggal_skk'])?date("d-m-Y", strtotime($head['tanggal_skk'])):"";
	$tanggal_skks 	= ($head['tgl_skks'])?date("d-m-Y", strtotime($head['tgl_skks'])):"";
	$waktu_jam 		= ($head['waktu_sidang'] == '00:00:00' || !$head['waktu_sidang'])?"":"Pukul ".substr($head['waktu_sidang'],0,-3)." ".Yii::$app->inspektur->getTimeFormat();
	$arrDocnya 		= array('isFile'=>false, 'parseDivsAsPs'=>true, 'downloadImages'=>false);

	/* BUAT PENGGUGAT */
	$sql1 = "select nama_instansi, no_urut from datun.lawan_pemohon where no_surat = '".$head['no_surat']."' and no_register_perkara = '".$head['no_register_perkara']."' 
			 order by no_urut";
	$res1 = Sp1::findBySql($sql1)->asArray()->all();
	$penggugat = "";
	foreach ($res1 as $val) {
		$penggugat .= $val['no_urut'].". ".$val['nama_instansi']."</br>";
		$penggugat .="<br>";
	}		
	/*END BUAT PENGGUGAT */

	/* BUAT STATUS PEMOHON DAN TURUT TERGUGAT */
	$sql2 = "
	select distinct initcap(a.status_pemohon) as status_pemohon, a.no_status_pemohon, 
	d.deskripsi_inst_wilayah as namanya
	from datun.permohonan a 
	join datun.jenis_instansi b on a.kode_jenis_instansi = b.kode_jenis_instansi
	join datun.instansi c on a.kode_jenis_instansi = c.kode_jenis_instansi and a.kode_instansi = c.kode_instansi and a.kode_tk = c.kode_tk
	join datun.instansi_wilayah d on a.kode_jenis_instansi = d.kode_jenis_instansi and a.kode_instansi = d.kode_instansi and a.kode_provinsi = d.kode_provinsi 
		and a.kode_kabupaten = d.kode_kabupaten and a.kode_tk = d.kode_tk and a.no_urut_wil = d.no_urut		
	where a.no_register_perkara = '".$head['no_register_perkara']."' and a.no_surat = '".$head['no_surat']."'
	union all
	select distinct initcap(status_tergugat) as status_pemohon, no_status_tergugat as no_status_pemohon, nama_instansi as namanya 
	from datun.turut_tergugat
	where no_register_perkara = '".$head['no_register_perkara']."' and no_surat = '".$head['no_surat']."'
	order by status_pemohon, no_status_pemohon";
	$res2 = Sp1::findBySql($sql2)->asArray()->all();
	$tergugat = '<table border="0" width="100%" style="border-collapse:collapse;"><tbody>';
	$jumTg = 0;
	foreach ($res2 as $dataTg){
		$jumTg++;
		$css1 = 'style="font-family:Trebuchet MS; font-size:11pt;"';
		$tergugat .= '
			<tr>
				<td '.$css1.' width="5.5%">'.($jumTg == 1?'b.':'').'</td>
				<td '.$css1.' width="22.1%">'.$dataTg['status_pemohon'].' '.$dataTg['no_status_pemohon'].'</td>
				<td '.$css1.' width="4.6%" align="center">:</td>
				<td '.$css1.' width="67.7%">'.$dataTg['namanya'].'</td>
			</tr>';
	}
	$tergugat .= '</tbody></table>';
	$tergugat2 = ucwords(strtolower($head['status_pemohon'].' '.$head['no_status_pemohon']));
	/* END BUAT STATUS PEMOHON DAN TURUT TERGUGAT */
	
	/* START BUAT MAJELIS HAKIM */
	$sql3 = "select status_majelis, majelis_hakim from datun.s11_majelis_hakim 
			 where no_register_perkara = '".$head['no_register_perkara']."' and no_surat = '".$head['no_surat']."' and tanggal_s11 = '".$head['tanggal_s11']."' 
			 order by no_urut_majelis";
	$res3 = Sp1::findBySql($sql3)->asArray()->all();
	$majelis = '';
	foreach($res3 as $val) {
		$majelis .=$val['status_majelis']." : ".$val['majelis_hakim'].".</br>";
		$majelis .="<br>";
	}
	/* END BUAT MAJELIS HAKIM */
	
	/* START BUAT KUASA PENGGUGAT */
	$sql4 = "select kuasa_penggugat from datun.s11_kuasa_penggugat 
			 where no_register_perkara = '".$head['no_register_perkara']."' and no_surat = '".$head['no_surat']."' and tanggal_s11='".$head['tanggal_s11']."' 
			 order by no_urut_kuasa_penggugat";
	$kuasa_gugat = Sp1::findBySql($sql4)->asArray()->all();
	if (count($kuasa_gugat)>1) {
		$baris = $kuasa_gugat[0]['kuasa_penggugat'].' .DKK';
	} else {
		$baris = $kuasa_gugat[0]['kuasa_penggugat'];
	}		
	/* END BUAT KUASA PENGGUGAT */

	/* START BUAT JPN */
	$sql5 = "
	select coalesce(c.nip_pegawai, b.nip_pegawai) as nip_pegawai, coalesce(c.nama_pegawai, b.nama_pegawai) as nama_pegawai,  
	coalesce(c.jabatan_pegawai, b.jabatan_pegawai) as jabatan_pegawai, coalesce(c.pangkat_pegawai, b.pangkat_pegawai) as pangkat_pegawai, 
	coalesce(c.gol_pegawai, b.gol_pegawai) as gol_pegawai
	from datun.s11 a  
	join datun.skk_anak b on a.no_register_skk = b.no_register_skk and a.no_register_perkara = b.no_register_perkara and a.no_surat = b.no_surat 
		and a.tanggal_skk = b.tanggal_skk 
	left join datun.skks_anak c on a.no_register_skk = c.no_register_skk and a.no_register_perkara = c.no_register_perkara and a.no_surat = c.no_surat 
		and a.tanggal_skk = c.tanggal_skk and a.no_register_skks = c.no_register_skks 
	where a.no_register_perkara = '".$head['no_register_perkara']."' and a.no_surat = '".$head['no_surat']."' and a.tanggal_s11 = '".$head['tanggal_s11']."' 
	order by b.no_urut, c.no_urut";
	$res5 = Sp1::findBySql($sql5)->asArray()->all();
	if(count($res5) > 0){
		$jaksa_negara = '<table border="0" width="100%" style="border-collapse:collapse;"><tbody>';
		$nom1 = 0;
		$css1 = 'style="font-family:Trebuchet MS; font-size:11pt; font-weight:bold;" width="50%" align="center"';
		$css2 = '<br /><br /><br /><br />';
		foreach($res5 as $data1){
			$nom1++;
			$jpn .=$nom1.'. '.$data1['nama_pegawai']."</br>";
			$jpn .="<br>";
			
			if($nom1==1){
				$jaksa_negara .= (($nom1 % 2) != 0)?'<tr><td '.$css1.'>'.$css2.$data1['nama_pegawai'].'</td>':'<td '.$css1.'>'.$css2.$data1['nama_pegawai'].'</td></tr>';
				//$jaksa_negara .= '<tr><td colspan="2" '.$css1.'>'.$css2.$data1['nama_pegawai'].'</td>';
			} else{
				$jaksa_negara .= (($nom1 % 2) != 0)?'<tr><td '.$css1.'>'.$css2.$data1['nama_pegawai'].'</td>':'<td '.$css1.'>'.$css2.$data1['nama_pegawai'].'</td></tr>';
			}
		}
		$jaksa_negara .= ((count($res1) % 2) != 0)?'<td '.$css1.'>&nbsp;</td></tr>':'';
		$jaksa_negara .= '</tbody></table>';
	} else{
		$jaksa_negara = '<p>&nbsp;</p>';
	}
	/* END BUAT JPN */

	/* START BUAT BERDASARKAN */
	$sql6 = "
		(
			select a.no_register_perkara, a.no_surat, a.no_register_skk, a.tanggal_skk, a.no_register_skk as no_register_skks, 
			a.tanggal_skk as tanggal_skks, f.deskripsi_inst_wilayah as pemberi_kuasa, 
			case when a.penerima_kuasa = 'JPN' then 'Jaksa Pengacara Negara' else b.jabatan_pegawai end as penerima_kuasa, 
			'Surat Kuasa Khusus dengan hak substitusi' as tipenya, a.created_date 
			from datun.skk a
			join datun.skk_anak b on a.no_register_perkara = b.no_register_perkara and a.no_surat = b.no_surat 
				and a.no_register_skk = b.no_register_skk and a.tanggal_skk = b.tanggal_skk 
			join datun.permohonan c on a.no_register_perkara = c.no_register_perkara and a.no_surat = c.no_surat 
			join datun.jenis_instansi d on c.kode_jenis_instansi = d.kode_jenis_instansi
			join datun.instansi e on c.kode_jenis_instansi = e.kode_jenis_instansi and c.kode_instansi = e.kode_instansi and c.kode_tk = e.kode_tk
			join datun.instansi_wilayah f on c.kode_jenis_instansi = f.kode_jenis_instansi and c.kode_instansi = f.kode_instansi 
				and c.kode_provinsi = f.kode_provinsi and c.kode_kabupaten = f.kode_kabupaten and c.kode_tk = f.kode_tk and c.no_urut_wil = f.no_urut
			where a.no_register_perkara = '".$head['no_register_perkara']."' and a.no_surat = '".$head['no_surat']."' 
				and a.no_register_skk = '".$head['no_register_skk']."' and a.tanggal_skk = '".$head['tanggal_skk']."' 
			limit 1
		)
		union all 
		select a.no_register_perkara, a.no_surat, a.no_register_skk, a.tanggal_skk, a.no_register_skks, a.tanggal_ttd as tanggal_skks, 
		coalesce(d.jabatan_pegawai, f.jabatan_pegawai) as pemberi_kuasa, b.jabatan_pegawai as penerima_kuasa, 'Surat Kuasa Khusus Substitusi' as tipenya, a.created_date 
		from datun.skks a
		join datun.skks_anak b on a.no_register_perkara = b.no_register_perkara and a.no_surat = b.no_surat 
			and a.no_register_skk = b.no_register_skk and a.tanggal_skk = b.tanggal_skk and a.no_register_skks = b.no_register_skks
		left join datun.skks c on a.no_register_perkara = c.no_register_perkara and a.no_surat = c.no_surat 
			and a.no_register_skk = c.no_register_skk and a.tanggal_skk = c.tanggal_skk and a.pemberi_kuasa = c.no_register_skks
		left join datun.skks_anak d on c.no_register_perkara = d.no_register_perkara and c.no_surat = d.no_surat 
			and c.no_register_skk = d.no_register_skk and c.tanggal_skk = d.tanggal_skk and c.no_register_skks = d.no_register_skks
		left join datun.skk e on a.no_register_perkara = e.no_register_perkara and a.no_surat = e.no_surat 
			and a.pemberi_kuasa = e.no_register_skk and a.tanggal_skk = e.tanggal_skk 
		left join datun.skk_anak f on f.no_register_perkara = e.no_register_perkara and f.no_surat = e.no_surat 
			and f.no_register_skk = e.no_register_skk and f.tanggal_skk = e.tanggal_skk 
		where a.no_register_perkara = '".$head['no_register_perkara']."' and a.no_surat = '".$head['no_surat']."' 
			and a.no_register_skk = '".$head['no_register_skk']."' and a.tanggal_skk = '".$head['tanggal_skk']."' and a.penerima_kuasa != 'JPN' 
		union all 
		(
			select a.no_register_perkara, a.no_surat, a.no_register_skk, a.tanggal_skk, a.no_register_skks, a.tanggal_ttd as tanggal_skks, 
			coalesce(d.jabatan_pegawai, f.jabatan_pegawai) as pemberi_kuasa, 'Jaksa Pengacara Negara' as penerima_kuasa, 
			'Surat Kuasa Khusus Substitusi' as tipenya, a.created_date 
			from datun.skks a
			join datun.skks_anak b on a.no_register_perkara = b.no_register_perkara and a.no_surat = b.no_surat 
				and a.no_register_skk = b.no_register_skk and a.tanggal_skk = b.tanggal_skk and a.no_register_skks = b.no_register_skks
			left join datun.skks c on a.no_register_perkara = c.no_register_perkara and a.no_surat = c.no_surat 
				and a.no_register_skk = c.no_register_skk and a.tanggal_skk = c.tanggal_skk and a.pemberi_kuasa = c.no_register_skks
			left join datun.skks_anak d on c.no_register_perkara = d.no_register_perkara and c.no_surat = d.no_surat 
				and c.no_register_skk = d.no_register_skk and c.tanggal_skk = d.tanggal_skk and c.no_register_skks = d.no_register_skks
			left join datun.skk e on a.no_register_perkara = e.no_register_perkara and a.no_surat = e.no_surat 
				and a.pemberi_kuasa = e.no_register_skk and a.tanggal_skk = e.tanggal_skk 
			left join datun.skk_anak f on f.no_register_perkara = e.no_register_perkara and f.no_surat = e.no_surat 
				and f.no_register_skk = e.no_register_skk and f.tanggal_skk = e.tanggal_skk 
			where a.no_register_perkara = '".$head['no_register_perkara']."' and a.no_surat = '".$head['no_surat']."' 
				and a.no_register_skk = '".$head['no_register_skk']."' and a.tanggal_skk = '".$head['tanggal_skk']."' and a.no_register_skk = '".$head['no_register_skks']."'
			limit 1
		)
		order by tanggal_skks, created_date";
	$res6 = Sp1::findBySql($sql6)->asArray()->all();
	//echo '<pre>'; print_r($res2); exit;
	if(count($res6) > 0){
		$sehubungan = '';
		$jumlah = 0;
		foreach($res6 as $data1){
			$jumlah++;
			if($jumlah == 1){
				$sehubungan .= $data1['tipenya'].(!in_array($head['kode_jenis_instansi'], array("01","06"))?' Nomor : '.$data1['no_register_skks']:'');
				$sehubungan .= ' tanggal '.tgl_indo(date('d/m/Y', strtotime($data1['tanggal_skks']))).' dari '.$data1['pemberi_kuasa'].' kepada '.$data1['penerima_kuasa'];
			} else if($data1['no_register_skks'] == $model['no_register_skks']){
				break;
			} else{
				$sehubungan .= '#'.$data1['tipenya'].' Nomor : '.$data1['no_register_skks'].' tanggal '.tgl_indo(date('d/m/Y', strtotime($data1['tanggal_skks'])));
				$sehubungan .= ' dari '.$data1['pemberi_kuasa'].' kepada '.$data1['penerima_kuasa'];
			}
		}
	}
	$arrSehubungan 	= explode("#", $sehubungan);
	$sehubungan 	= "";
	$jumSehubungan  = 0; 
	foreach($arrSehubungan as $datax){
		$jumSehubungan++;
		$separator 	= ($jumSehubungan == count($arrSehubungan) - 1)?' dan ':', ';
		$sehubungan .= $datax.$separator;
	}
	$sehubungan = substr($sehubungan,0,-2);
	/* END BUAT BERDASARKAN */
		
	$docx->replaceVariableByText(array('nama_satker'=>$title),array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('alamat'=>$alamat),array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('no_register_perkara'=>strtoupper($head['no_register_perkara'])),array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('kejaksaan'=>$title),array('parseLineBreaks'=>true));
	$docx->replaceVariableByHTML('penggugat', 'inline','<div style="text-align:left;font-family:Trebuchet MS; font-size:11pt;">'.$penggugat.'</div>', $arrDocnya);
	$docx->replaceVariableByHTML('tergugat', 'block', $tergugat, $arrDocnya);	
	$docx->replaceVariableByText(array('tergugat2'=>$tergugat2),array('parseLineBreaks'=>true));
	$docx->replaceVariableByHTML('kasus_posisi', 'block','<div style="text-align:left; font-family:Trebuchet MS; font-size:11pt;">'.$head['kasus_posisi'].'</div>', $arrDocnya);
	$docx->replaceVariableByText(array('berdasarkan'=>$sehubungan),array('parseLineBreaks'=>true));		
	$docx->replaceVariableByHTML('waktu_hari', 'inline','<div style="text-align:left; font-family:Trebuchet MS; font-size:11pt;">'.$head['hari'].'</div>', $arrDocnya);
	$docx->replaceVariableByHTML('waktu_tgl', 'inline','<div style="text-align:left; font-family:Trebuchet MS; font-size:11pt;">'.tgl_indo($waktu_tgl).'</div>', $arrDocnya);
	$docx->replaceVariableByHTML('waktu_jam', 'inline','<div style="text-align:left; font-family:Trebuchet MS; font-size:11pt;">'.$waktu_jam.'</div>', $arrDocnya);


	$docx->replaceVariableByHTML('pengadilan', 'inline','<div style="text-align:left; font-family:Trebuchet MS; font-size:11pt;">'.$head['nama_pengadilan'].'</div>', $arrDocnya);
	$docx->replaceVariableByHTML('majelis', 'inline','<div style="text-align:left; font-family:Trebuchet MS; font-size:11pt;">'.$majelis.'</div>', $arrDocnya);
	$docx->replaceVariableByHTML('panitera', 'inline','<div style="text-align:left; font-family:Trebuchet MS; font-size:11pt;">'.$head['panitera'].'</div>', $arrDocnya);


	$docx->replaceVariableByHTML('agenda_sidang', 'inline','<div style="text-align:left; font-family:Trebuchet MS; font-size:11pt;">'.$head['agenda_sidang'].'</div>', $arrDocnya);
	$docx->replaceVariableByHTML('isi_laporan', 'block','<div style="text-align:left; font-family:Trebuchet MS; font-size:11pt;">'.$head['isi_laporan'].'</div>', $arrDocnya);
	$docx->replaceVariableByHTML('analisa', 'block','<div style="text-align:left; font-family:Trebuchet MS; font-size:11pt;">'.$head['analisa_laporan'].'</div>', $arrDocnya);
	$docx->replaceVariableByHTML('kesimpulan', 'block','<div style="text-align:left; font-family:Trebuchet MS; font-size:11pt;">'.$head['kesimpulan'].'</div>', $arrDocnya);
	$docx->replaceVariableByHTML('resume', 'block','<div style="text-align:left; font-family:Trebuchet MS; font-size:11pt;">'.$head['resume'].'</div>', $arrDocnya);


	$docx->replaceVariableByText(array('berdasarkan'=>$sehubungan),array('parseLineBreaks'=>true));		
	$docx->replaceVariableByHTML('jaksa_negara', 'block',$jaksa_negara, $arrDocnya);
	$docx->replaceVariableByHTML('jpn', 'block','<div style="text-align:left; font-family:Trebuchet MS; font-size:11pt;">'.$jpn.'</div>', $arrDocnya);

	$docx->replaceVariableByHTML('kuasa_penggugat', 'inline','<div style="text-align:left;font-family:Trebuchet MS; font-size:11pt;">'.$baris.'</div>', $arrDocnya);
	$docx->replaceVariableByHTML('lokasi', 'inline','<div style="text-align:left; font-family:Trebuchet MS; font-size:11pt;">'.$lokasi.'</div>', $arrDocnya);
	
	$docx->createDocx('template/datun/S-11');
	
	$file = 'template/datun/S-11.docx';

	if (file_exists($file)) {
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="'.basename($file).'"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		readfile($file);
		exit;
	}

?>