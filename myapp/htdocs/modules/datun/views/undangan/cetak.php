<?php
	use app\modules\datun\models\Sp1;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../modules/datun/template/S-3.docx');

	$namaSatker = Yii::$app->inspektur->getNamaSatker();
	$lokSatker 	= Yii::$app->inspektur->getLokasiSatker()->lokasi;
	$almtSatker = Yii::$app->inspektur->getLokasiSatker()->alamat;
	$arrDocnya 	= array('isFile'=>false, 'parseDivsAsPs'=>true, 'downloadImages'=>false);
	$tmp_waktu	= explode(":", $model['waktu']);
	$tembusan 	= "";
	$arrSKK 	= array("JA"=>"Jaksa Agung Republik Indonesia", "JAMDATUN"=>"Jaksa Agung Muda Perdata dan Tata Usaha Negara", "KAJATI"=>"Kajati", "KAJARI"=>"Kajari", 
					"KACABJARI"=>"Kacabjari", "JPN"=>"Tim Jaksa Pengacara Negara");
	$arrBidang 	= array('Jaksa Agung Muda Perdata dan Tata Usaha Negara', 'KAJATI', 'KAJARI', 'KACABJARI');

	$tgl_undangan 	= date('d-m-Y',strtotime($model['tanggal_surat_undangan']));
	$tgl_kedatangan = date('d-m-Y',strtotime($model['tanggal']));
	$jam_kedatangan = $tmp_waktu[0].':'.$tmp_waktu[1].' '.Yii::$app->inspektur->getTimeFormat();
		
	if($model['tipenya'] == '1'){
		$sql2 = "select no_tembusan, deskripsi_tembusan from datun.surat_undangan_telaah_tembusan 
				where no_register_perkara = '".$model['no_register_perkara']."' and no_surat = '".$model['no_surat']."' and no_surat_undangan = '".$model['no_surat_undangan']."' 
				order by no_tembusan";
		$res2 = Sp1::findBySql($sql2)->asArray()->all();
		$sehubungan = 'Surat Perintah Telaah (SP-1) Nomor : '.$model['no_sp1'].' tanggal '.tgl_indo($model['tanggal_ttd'], 'long', 'db');
		$sehubungan .= ' dari '.$arrBidang[$model['kode_tk']].' kepada Tim Jaksa Pengacara Negara';
	} else if($model['tipenya'] == '2'){
		/*$sql1 = "
			select * from(
				select a.no_register_perkara, a.no_surat, a.no_register_skk, a.tanggal_skk, a.no_register_skk as no_register_skks, 
				a.tanggal_skk as tanggal_skks, e.deskripsi_inst_wilayah as pemberi_kuasa, a.penerima_kuasa, 'Surat Kuasa Khusus dengan hak substitusi' as tipenya, 
				a.created_date from datun.skk a
				join datun.permohonan b on a.no_register_perkara = b.no_register_perkara and a.no_surat = b.no_surat 
				join datun.jenis_instansi c on b.kode_jenis_instansi = c.kode_jenis_instansi
				join datun.instansi d on b.kode_jenis_instansi = d.kode_jenis_instansi and b.kode_instansi = d.kode_instansi and b.kode_tk = d.kode_tk
				join datun.instansi_wilayah e on b.kode_jenis_instansi = e.kode_jenis_instansi and b.kode_instansi = e.kode_instansi 
					and b.kode_provinsi = e.kode_provinsi and b.kode_kabupaten = e.kode_kabupaten and b.no_urut_wil = e.no_urut
				union all 
				select a.no_register_perkara, a.no_surat, a.no_register_skk, a.tanggal_skk, a.no_register_skks, a.tanggal_ttd as tanggal_skks, 
				coalesce(b.penerima_kuasa, c.penerima_kuasa) as pemberi_kuasa, a.penerima_kuasa, 'Surat Kuasa Khusus Substitusi' as tipenya, 
				a.created_date from datun.skks a
				left join datun.skks b on a.no_register_perkara = b.no_register_perkara and a.no_surat = b.no_surat 
				and a.no_register_skk = b.no_register_skk and a.tanggal_skk = b.tanggal_skk and a.pemberi_kuasa = b.no_register_skks
				left join datun.skk c on a.no_register_perkara = c.no_register_perkara and a.no_surat = c.no_surat 
				and a.pemberi_kuasa = c.no_register_skk and a.tanggal_skk = c.tanggal_skk 
				where (a.penerima_kuasa != 'JPN' or a.is_active != 0)
			) a
			where no_register_perkara = '".$model['no_register_perkara']."' and no_surat = '".$model['no_surat']."' and no_register_skk = '".$model['no_register_skk']."' 
				and tanggal_skk = '".$model['tanggal_skk']."' order by tanggal_skks, created_date";
		$res1 = Sp1::findBySql($sql1)->asArray()->all();
		if(count($res1) > 0){
			$sehubungan = '';
			$jumlah = 0;
			foreach($res1 as $data1){
				$jumlah++;
				$separator 	= ($jumlah == count($res1) - 1)?' dan ':', ';
				$pemberi 	= (array_key_exists($data1['pemberi_kuasa'], $arrSKK))?$arrSKK[$data1['pemberi_kuasa']]:$data1['pemberi_kuasa'];
				$sehubungan .= $data1['tipenya'].' Nomor : '.$data1['no_register_skks'].' tanggal '.tgl_indo(date('d/m/Y', strtotime($data1['tanggal_skks']))).' dari '.$pemberi.' Kepada '.$arrSKK[$data1['penerima_kuasa']].$separator;
			}
		}
		$sehubungan = substr($sehubungan,0,-2);*/
		$sql1 = "
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
				where a.no_register_perkara = '".$model['no_register_perkara']."' and a.no_surat = '".$model['no_surat']."' 
					and a.no_register_skk = '".$model['no_register_skk']."' and a.tanggal_skk = '".$model['tanggal_skk']."' 
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
			where a.no_register_perkara = '".$model['no_register_perkara']."' and a.no_surat = '".$model['no_surat']."' 
				and a.no_register_skk = '".$model['no_register_skk']."' and a.tanggal_skk = '".$model['tanggal_skk']."' and a.penerima_kuasa != 'JPN' 
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
				where a.no_register_perkara = '".$model['no_register_perkara']."' and a.no_surat = '".$model['no_surat']."' 
					and a.no_register_skk = '".$model['no_register_skk']."' and a.tanggal_skk = '".$model['tanggal_skk']."' and a.penerima_kuasa = 'JPN' and a.is_active = 1
				limit 1
			)
			order by tanggal_skks, created_date";
		$res1 = Sp1::findBySql($sql1)->asArray()->all();
		if(count($res1) > 0){
			$sehubungan = '';
			$jumlah = 0;
			foreach($res1 as $data1){
				$jumlah++;
				if($jumlah == 1){
					$sehubungan .= $data1['tipenya'].(!in_array($model['kode_jenis_instansi'], array("01","06"))?' Nomor : '.$data1['no_register_skks']:'');
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
	
		$sql2 = "select no_tembusan, deskripsi_tembusan from datun.surat_undangan_sidang_tembusan 
				where no_register_perkara = '".$model['no_register_perkara']."' and no_surat = '".$model['no_surat']."' and no_register_skk = '".$model['no_register_skk']."' 
				and tanggal_skk = '".$model['tanggal_skk']."' and no_surat_undangan = '".$model['no_surat_undangan']."' order by no_tembusan";
		$res2 = Sp1::findBySql($sql2)->asArray()->all();
	}
	if(count($res2) > 0){
		$nom2 = 0;
		foreach($res2 as $data2){
			$nom2++;
			$tembusan .= '<span style="font-family:Trebuchet MS; font-size:11pt;">'.$nom2.'. '.$data2['deskripsi_tembusan'].'</span><br />';
		}
	}

	$docx->replaceVariableByText(array('nama_satker'=>strtoupper($namaSatker)), array('parseLineBreaks'=>true, 'target'=>'header'));
	$docx->replaceVariableByText(array('nama_satker_biasa'=>$namaSatker), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('no_undangan'=>$model['no_surat_undangan']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('sifat_undangan'=>$model['sifat_undangan']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('lampiran_undangan'=>$model['lampiran']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('perihal_undangan'=>$model['perihal']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('lokasi_satker'=>$lokSatker), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_undangan'=>tgl_indo($tgl_undangan)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('kepada_yth'=>$model['kepada_yth']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tempat'=>$model['di']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('sehubungan_dengan'=>$sehubungan), array('parseLineBreaks'=>true));

	$docx->replaceVariableByText(array('hari'=>str_replace("&#039;", "'", $model['hari'])), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_kedatangan'=>tgl_indo($tgl_kedatangan)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('waktu'=>$jam_kedatangan), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tempat_acara'=>$model['tempat']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('acara'=>$model['acara']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('bertemu'=>$model['bertemu']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('penandatangan_ttdjabat'=>$model['penandatangan_ttdjabat']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('penandatangan_nama'=>$model['penandatangan_nama']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByHTML('tembusan_ttd', 'inline', $tembusan, $arrDocnya);

	$docx->createDocx('template/datun/S-3');
	$file = 'template/datun/S-3.docx';
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