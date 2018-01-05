<?php
	use app\modules\datun\models\S25;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../modules/datun/template/S25.docx');
	
	function integerToRoman($n){
		 $n = intval($n);
		 $result = '';
		 
		 $lookup = array('M' => 1000,
		 'CM' => 900,
		 'D' => 500,
		 'CD' => 400,
		 'C' => 100,
		 'XC' => 90,
		 'L' => 50,
		 'XL' => 40,
		 'X' => 10,
		 'IX' => 9,
		 'V' => 5,
		 'IV' => 4,
		 'I' => 1);
		 
		 foreach($lookup as $roman => $value){
		  $matches = intval($n/$value);			 
		  $result .= str_repeat($roman,$matches);	 
		  $n = $n % $value;
		 }
		 
		 return $result;
	}
	
	$namaSatker = Yii::$app->inspektur->getNamaSatker();
	$lokSatker 	= Yii::$app->inspektur->getLokasiSatker()->lokasi;
	$almtSatker = Yii::$app->inspektur->getLokasiSatker()->alamat;
	$arrDocnya 	= array('isFile'=>false, 'parseDivsAsPs'=>true, 'downloadImages'=>false);
	$kode_tk 	= $_SESSION['kode_tk'];
	$arrBidang 	= array('JAKSA AGUNG MUDA PERDATA DAN TATA USAHA NEGARA', 'KAJATI', 'KAJARI', 'KACABJARI');
	$tgl_permohonan = ($model['tanggal_permohonan'])?tgl_indo(date('d-m-Y',strtotime($model['tanggal_permohonan']))):'...............';
	$tgl_diterima 	= ($model['tanggal_diterima'])?tgl_indo(date('d-m-Y',strtotime($model['tanggal_diterima']))):'...............';
	$tgl_pengadilan = ($model['tanggal_panggilan_pengadilan'])?tgl_indo(date('d-m-Y',strtotime($model['tanggal_panggilan_pengadilan']))):'...............';
	$tanggal_putusan= ($model['tanggal_putusan'])?tgl_indo(date('d-m-Y',strtotime($model['tanggal_putusan']))):'...............';
	$tanggalS25		= ($model['tanggal_s25'])?tgl_indo(date('d-m-Y',strtotime($model['tanggal_s25']))):'...............';
	$tanggalSkk		= ($model['tanggal_skk'])?tgl_indo(date('d-m-Y',strtotime($model['tanggal_skk']))):'...............'; 
	$tanggalSkks	= ($model['tanggal_skks'])?tgl_indo(date('d-m-Y',strtotime($model['tanggal_skks']))):'...............'; 
	$tgl_permohonan_banding= ($model['tgl_permohonan_banding'])?tgl_indo(date('d-m-Y',strtotime($model['tgl_permohonan_banding']))):'...............';
	$tembusan_surat = "";
	$jaksa_negara 	= "";
	$amarPutusan 	= ($model['amar_putusan'])? '<div style=" line-height:30px; font-family:Trebuchet MS;"> '.$model['amar_putusan'].'</div>':'........................';
	$alasanBanding 	= ($model['alasan_banding'])? '<div style=" line-height:30px; font-family:Trebuchet MS;"> '.$model['alasan_banding'].'</div>':'........................';
	$petitum_pri 	= ($model['isi_petitum_primer'])? '<div style=" line-height:30px; font-family:Trebuchet MS;"> '.$model['isi_petitum_primer'].'</div>':'........................';
	$petitum_sub 	= ($model['isi_petitum_subsider'])? '<div style=" line-height:30px; font-family:Trebuchet MS;"> '.$model['isi_petitum_subsider'].'</div>':'........................';
	$cpimpinan_pemohon=($model['pimpinan_pemohon']!=''?strtoupper($model['pimpinan_pemohon']):'...............');
	$cjab_skks		=($model['jab_skks']!=''?strtoupper($model['jab_skks']):'...............');
	$jaksa_negara1	="...............";
	$jaksa_negara2	="...............";
	if($model['tanggal_s25']){
		$where = " and a.tanggal_s25 = '".$model['tanggal_s25']."' ";
	} else {
		$where ="";
	}
	
	/* $sql2 = "select a.nip, a.nama, a.jabatan from datun.s25_anak a
			inner join datun.s25 b on a.no_putusan=b.no_putusan and a.tanggal_putusan=b.tanggal_putusan 
			and a.no_register_skks=b.no_register_skks and a.tanggal_s25=b.tanggal_s25
			where a.no_register_skks='".$model['no_register_skks']."' and a.no_putusan = '".$model['no_putusan']."' 
			and a.tanggal_putusan = '".$model['tanggal_putusan']."'".$where."order by a.nip"; */
		if($model['no_register_skks']!=''){ 	
				$sqlx = "select nip_pegawai,nama_pegawai from datun.skks_anak
					where no_register_skks='".$model['no_register_skks']."' and no_register_perkara='".$_SESSION['no_register_perkara']."' and no_surat='".$_SESSION['no_surat']."' and  no_register_skk='".$model['no_register_skk']."' and tanggal_skk='".$model['tanggal_skk']."' order by nip_pegawai";
		}else if($model['no_register_skk']!=''){
				$sqlx = "select nip_pegawai,nama_pegawai from datun.skk_anak where  no_register_perkara='".$_SESSION['no_register_perkara']."' and no_surat='".$_SESSION['no_surat']."' and  no_register_skk='".$model['no_register_skk']."' and tanggal_skk='".$model['tanggal_skk']."' order by nip_pegawai";
		}	
	$res2 = S25::findBySql($sqlx)->asArray()->all();

	$kuasa_skk ="";	
	if(count($res2) > 0){
		$nom2 = 0;
		$kuasa_skk = '<table border="0" width="100%" style="border-collapse:collapse;"><tbody>';
		foreach($res2 as $data2){
			$nom2++;
			$kuasa_skk .= '
				<tr>
					<td style="font-family:Trebuchet MS; font-size:11pt;" width="2%">'.$nom2.'. </td>
					<td style="font-family:Trebuchet MS; font-size:11pt;" width="98%">'.$data2['nama_pegawai'].'</td>
				</tr>';
		}
		
		//Start TTD=========================================
		$jaksa_negara1 = '<table border="0" width="100%" style="border-collapse:collapse;"><tbody>';
		$jaksa_negara2 = '<table border="0" width="100%" style="border-collapse:collapse;"><tbody>';
		$nom1 = 0;
		foreach($res2 as $data1){
			$nom1++;
			$kuasa = $data1['nama_pegawai'];
			if ($nom1 % 2 !=0){
			$jaksa_negara1 .= '
				<tr>
					<td style="font-family:Trebuchet MS; font-size:11pt;" width="2%"><br><br><br><br>'.$nom1.'. </td>
					<td style="font-family:Trebuchet MS; font-size:11pt;" width="98%"><br><br><br><br>'.$kuasa.'</td>
				</tr>';
			} else {
				$jaksa_negara2 .= '
				<tr>
					<td style="font-family:Trebuchet MS; font-size:11pt;" width="2%"><br><br><br><br>'.$nom1.'. </td>
					<td style="font-family:Trebuchet MS; font-size:11pt;" width="98%"><br><br><br><br>'.$kuasa.'</td>
				</tr>';		
			}
		}
		$jaksa_negara1 .= '</tbody></table>'; 
		$jaksa_negara2 .= '</tbody></table>'; 
		//End TTD==================================================
		$kuasa_skk .= '</tbody></table>'; 
	} else {
		$kuasa_skk ="..............";
	}
	
	
	if($model['no_register_skks']) {
		$sql3 = "select tanggal_s11, waktu_sidang from datun.s11 
			where no_register_skk='".$model['no_register_skk']."' and tanggal_skk='".$model['tanggal_skk']."' and no_register_perkara = '".$model['no_register_perkara']."' and no_surat = '".$model['no_surat']."' and no_register_skks='".$model['no_register_skks']."'";
	} else if ($model['no_register_skk']){
		$sql3 = "select tanggal_s11, waktu_sidang from datun.s11 
			where no_register_skk='".$model['no_register_skk']."' and tanggal_skk='".$model['tanggal_skk']."' and no_register_perkara = '".$model['no_register_perkara']."' and no_surat = '".$model['no_surat']."'";
	}
	$res3 = S25::findBySql($sql3)->asArray()->all();
	$tgl_sidang=".............";
	if(count($res3) > 0){
		$nom2 = 0;
		foreach($res3 as $data3){
			$nom2++;
			$tgl_sidang = tgl_indo(date('d-m-Y',strtotime($data3['tanggal_s11'])));
		}
	}
		
	////Berdasarkan////
	$sql1 ="";	
		if($model['no_register_skk']){
			$sql1 = "
				(
					select a.no_register_perkara, a.no_surat, a.no_register_skk, a.tanggal_skk, a.no_register_skk as no_register_skks, 
					a.tanggal_skk as tanggal_skks, f.deskripsi_inst_wilayah as pemberi_kuasa, 
					case when a.penerima_kuasa = 'JPN' then '' else b.jabatan_pegawai end as penerima_kuasa, 
					'Surat Kuasa Khusus dengan hak substitusi' as tipenya, a.created_date 
					from datun.skk a
					join datun.skk_anak b on a.no_register_perkara = b.no_register_perkara and a.no_surat = b.no_surat 
						and a.no_register_skk = b.no_register_skk and a.tanggal_skk = b.tanggal_skk 
					join datun.permohonan c on a.no_register_perkara = c.no_register_perkara and a.no_surat = c.no_surat 
					join datun.jenis_instansi d on c.kode_jenis_instansi = d.kode_jenis_instansi
					join datun.instansi e on c.kode_jenis_instansi = e.kode_jenis_instansi and c.kode_instansi = e.kode_instansi and c.kode_tk = e.kode_tk
					join datun.instansi_wilayah f on c.kode_jenis_instansi = f.kode_jenis_instansi and c.kode_instansi = f.kode_instansi 
						and c.kode_provinsi = f.kode_provinsi and c.kode_kabupaten = f.kode_kabupaten and c.no_urut_wil = f.no_urut
					where a.no_register_perkara = '".$model['no_register_perkara']."' and a.no_surat = '".$model['no_surat']."' 
						and a.no_register_skk = '".$model['no_register_skk']."' and a.tanggal_skk = '".$model['tanggal_skk']."' 
					limit 1
				)";
				$order_tgl="tanggal_skk";
				if ($model['no_register_skks']) {
					$sql1 .=" union all 
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
							coalesce(d.jabatan_pegawai, f.jabatan_pegawai) as pemberi_kuasa, '' as penerima_kuasa, 
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
								and a.no_register_skk = '".$model['no_register_skk']."' and a.tanggal_skk = '".$model['tanggal_skk']."' and a.penerima_kuasa = 'JPN' and a.no_register_skks = '".$model['no_register_skks']."'
							limit 1 
						)";
						$order_tgl="tanggal_skks";
					}
				$sql1 .=" order by ".$order_tgl." , created_date";
			$res1 = S25::findBySql($sql1)->asArray()->all();
			if(count($res1) > 0){
				$sehubungan = '';
				$jumlah = 0;
				foreach($res1 as $data1){
					$jumlah++;
					if($jumlah == 1){
						$sehubungan .= $data1['tipenya'].' Nomor : '.$data1['no_register_skks'].' tanggal '.tgl_indo(date('d-m-Y', strtotime($data1['tanggal_skks'])));
						$sehubungan .= ' dari '.$data1['pemberi_kuasa'].' Kepada '.$data1['penerima_kuasa'];
					} else{
						$sehubungan .= '#'.$data1['tipenya'].' Nomor : '.$data1['no_register_skks'].' tanggal '.tgl_indo(date('d-m-Y', strtotime($data1['tanggal_skks'])));
						$sehubungan .= ' dari '.$data1['pemberi_kuasa'].' Kepada '.$data1['penerima_kuasa'];
					}
				}
			}
		} else {
			$sehubungan = '......................';
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
		////END BERDASARKAN////

	$docx->replaceVariableByText(array('alamat_kejaksaan'=>$almtSatker), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tergugat'=>strtoupper($model['status_pemohon']).' '.integerToRoman($model['no_status_pemohon'])), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tergugat_isi'=>ucwords(strtolower($model['status_pemohon'])).' '.integerToRoman($model['no_status_pemohon'])), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('berdasarkan'=>$sehubungan), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nama_kejaksaan'=>strtoupper($namaSatker)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('di_kejaksaan'=>ucwords($namaSatker)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('penggugat'=>strtoupper($model['penggugat'])), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('deskripsi_inst_wilayah'=>($model['tergugat'])?$model['tergugat']:'..............'), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('noPutusan'=>strtoupper($model['no_putusan'])), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_putusan'=>$tanggal_putusan), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_s25'=>$tanggalS25), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('lokasi_keluar'=>$lokSatker), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('yth'=>($model['kepada_yth_s25'])?$model['kepada_yth_s25']:' '), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('diS25'=>($model['di_s25'])?$model['di_s25']:' '), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('melalui'=>($model['melalui'])?$model['melalui']:' '), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('jabatan'=>$model['jabatan_pegawai']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('no_skk'=>$model['no_register_skk']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_skk'=>$tanggalSkk), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('no_skks'=>$model['no_register_skks']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_skks'=>$tanggalSkks), array('parseLineBreaks'=>true));
	$docx->replaceVariableByHTML('kuasa', 'block', $kuasa_skk, $arrDocnya);
	$docx->replaceVariableByText(array('no_perdata'=>$model['no_register_perkara']), array('parseLineBreaks'=>true)); 
	$docx->replaceVariableByText(array('tanggal_perdata'=>$tgl_pengadilan), array('parseLineBreaks'=>true));
	$docx->replaceVariableByHTML('amarPutusan', 'block', $amarPutusan, $arrDocnya); 
	$docx->replaceVariableByText(array('tgl_sidang'=>$tgl_sidang), array('parseLineBreaks'=>true)); 
	$docx->replaceVariableByText(array('tgl_permohonan_banding'=>$tgl_permohonan_banding), array('parseLineBreaks'=>true)); 
	$docx->replaceVariableByText(array('noPermohonanBanding'=>($model['no_permohonan_banding'])?$model['no_permohonan_banding']:'..............'), array('parseLineBreaks'=>true));
	$docx->replaceVariableByHTML('alasanBanding', 'block', $alasanBanding, $arrDocnya); 
	$docx->replaceVariableByText(array('namaPengadilan'=>($model['nama_pengadilan'])?$model['nama_pengadilan']:'..............'), array('parseLineBreaks'=>true));
	$docx->replaceVariableByHTML('petitumPrimer', 'block', $petitum_pri, $arrDocnya);  
	$docx->replaceVariableByHTML('petitumSubsider', 'block', $petitum_sub, $arrDocnya);
	$docx->replaceVariableByHTML('kuasa_jpn1', 'block', $jaksa_negara1, $arrDocnya);
	$docx->replaceVariableByHTML('kuasa_jpn2', 'block', $jaksa_negara2, $arrDocnya);
	$docx->replaceVariableByText(array('jns_instansi'=>($model['jns_instansi'])?$model['jns_instansi']:'..............'), array('parseLineBreaks'=>true)); 
	$docx->replaceVariableByText(array('sts_pemohon'=>$model['status_pemohon']), array('parseLineBreaks'=>true)); 
	/* $docx->replaceVariableByText(array('no_sts_pemohon'=>($model['no_status_pemohon'])?$model['no_status_pemohon']:'..............'), array('parseLineBreaks'=>true)); */
	$docx->replaceVariableByText(array('pimpinan_pemohon'=>$cpimpinan_pemohon),array('parseLineBreaks'=>true));	
	$docx->replaceVariableByText(array('jabatan_skks'=>$cjab_skks),array('parseLineBreaks'=>true));	
	
	$docx->createDocx('template/datun/S25');
	$file = 'template/datun/S25.docx';
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