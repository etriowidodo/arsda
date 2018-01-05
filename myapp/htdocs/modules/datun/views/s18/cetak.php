<?php
	use app\modules\datun\models\Sp1;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');

	$docx 		= new CreateDocxFromTemplate('../modules/datun/template/S-18.docx');
	$title		= Yii::$app->inspektur->getNamaSatker();	
	$alamat		= Yii::$app->inspektur->getLokasiSatker()->alamat;
	$lokasi		= Yii::$app->inspektur->getLokasiSatker()->lokasi;
	$arrDocnya 	= array('isFile'=>false, 'parseDivsAsPs'=>true, 'downloadImages'=>false);

	function integerToRoman($n){
		$n = intval($n);
		$result = '';
		$lookup = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
		foreach($lookup as $roman => $value){
			$matches = intval($n/$value);			 
			$result .= str_repeat($roman,$matches);	 
			$n = $n % $value;
		}
		return $result;
	}	

	if($model['no_register_skks'] != ''){
		$sqlx = "
		select nip_pegawai, nama_pegawai from datun.skks_anak
		where no_register_perkara = '".$model['no_register_perkara']."' and no_surat = '".$model['no_surat']."' and no_register_skk = '".$model['no_register_skk']."' 
			and tanggal_skk = '".$model['tanggal_skk']."' and no_register_skks = '".$model['no_register_skks']."' 
		order by no_urut";
	} else if($model['no_register_skk']!=''){		
		$sqlx = "
		select nip_pegawai, nama_pegawai from datun.skk_anak 
		where no_register_perkara = '".$model['no_register_perkara']."' and no_surat = '".$model['no_surat']."' and no_register_skk = '".$model['no_register_skk']."' 
			and tanggal_skk = '".$model['tanggal_skk']."' 
		order by no_urut";
	} 
	$model_jpn = Sp1::findBySql($sqlx)->asArray()->all();			
	if(count($model_jpn) > 0){
		$jaksa_negara = '<table border="0" width="100%" style="border-collapse:collapse;"><tbody>';
		$nom1 = 0;
		$css1 = 'style="font-family:Trebuchet MS; font-size:11pt; font-weight:bold;" width="50%" align="left"';
		$css2 = '<br /><br /><br /><br />';
		foreach($model_jpn as $data1){
			$nom1++;
			$jaksa_negara .= (($nom1 % 2) != 0)?'<tr><td '.$css1.'>'.$css2.$data1['nama_pegawai'].'</td>':'<td '.$css1.'>'.$css2.$data1['nama_pegawai'].'</td></tr>';
			$jaksa_negara1 .= $nom1.'. '.$data1['nama_pegawai'].'<br></br>';
		}
		$jaksa_negara .= ((count($model_jpn) % 2) != 0)?'<td '.$css1.'>&nbsp;</td></tr>':'';
		$jaksa_negara .= '</tbody></table>';
	} else{
		$jaksa_negara = '<p>&nbsp;</p>';
		$jaksa_negara1 = '<p>&nbsp;</p>';
	}
			
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
				and a.no_register_skk = '".$model['no_register_skk']."' and a.tanggal_skk = '".$model['tanggal_skk']."' and a.no_register_skk = '".$model['no_register_skks']."'
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
	/* END BUAT BERDASARKAN */

	$tglS18 		= ($model['tanggal_s18'])?date("d-m-Y", strtotime($model['tanggal_s18'])):"............";
	$tglSJM 		= ($model['tanggal_sita_jaminan'])?date("d-m-Y", strtotime($model['tanggal_sita_jaminan'])):"............";
	$noSitaJaminan	= ($model['nomor_sita_jaminan'])?$model['nomor_sita_jaminan'] :'............';

	$convert 			= ($model['kepada_yth'])?$model['kepada_yth']:'..............';	
	$ctempat			= ($model['tempat'] != ''?$model['tempat']:'..............');	
	$cstatus_pemohon	= ($model['status_pemohon']!=''?$model['status_pemohon']:'');
	$cnostatus_pemohon	= ($model['no_status_pemohon']!=''?$model['no_status_pemohon']:'');
	$cnama_pengadilan	= ($model['nama_pengadilan']!=''?$model['nama_pengadilan']:'');	
	$cno_register_perkara = ($model['no_register_perkara']!=''?$model['no_register_perkara']:'');	
	$cdeskripsi_inst_wilayah = ($model['deskripsi_inst_wilayah']!=''?$model['deskripsi_inst_wilayah']:'<p></p>');

	$alasan 			= '<table border="0" style="border-collapse:collapse; margin-left:28.3pt;"><tbody><tr><td>'.$model['alasan'].'</td></tr></tbody></table>';		
	$primair 			= '<table border="0" style="border-collapse:collapse; margin-left:28.3pt;"><tbody><tr><td>'.$model['primair'].'</td></tr></tbody></table>';		
	$subsidair 			= '<table border="0" style="border-collapse:collapse; margin-left:50.3pt;"><tbody><tr><td>'.$model['subsidair'].'</td></tr></tbody></table>';		

	$docx->replaceVariableByText(array('wilayahkerja'=>strtoupper($title)),array('parseLineBreaks'=>true));			
	$docx->replaceVariableByText(array('tanggal_diterima'=>tgl_indo($tglS18)),array('parseLineBreaks'=>true));		
	$docx->replaceVariableByText(array('status_pemohon'=>$cstatus_pemohon),array('parseLineBreaks'=>true));			
	$docx->replaceVariableByText(array('no_status_pemohon'=>integerToRoman($cnostatus_pemohon)),array('parseLineBreaks'=>true));			
	$docx->replaceVariableByText(array('lokasi'=>$lokasi),array('parseLineBreaks'=>true));		
	$docx->replaceVariableByText(array('nomor_sita_jaminan'=>$noSitaJaminan),array('parseLineBreaks'=>true));		
	$docx->replaceVariableByText(array('tanggal_sita_jaminan'=>tgl_indo($tglSJM)),array('parseLineBreaks'=>true));		

	$docx->replaceVariableByText(array('kepada_yth'=>$convert),array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tempat'=>$ctempat),array('parseLineBreaks'=>true));		
	$docx->replaceVariableByText(array('berdasarkan'=>$sehubungan), array('parseLineBreaks'=>true));		
	$docx->replaceVariableByText(array('no_register_perkara'=>$cno_register_perkara),array('parseLineBreaks'=>true));

	$docx->replaceVariableByText(array('nama_pengadilan'=>$cnama_pengadilan),array('parseLineBreaks'=>true));		

	$docx->replaceVariableByHTML('alasan', 'block','<div style="margin-left:18px; line-height:30px; font-family:Trebuchet MS;">'.$alasan.'</div>', $arrDocnya);	
	$docx->replaceVariableByHTML('primair', 'block','<div style="margin-left:18px; line-height:30px; font-family:Trebuchet MS;">'.$primair.'</div>', $arrDocnya);
	$docx->replaceVariableByHTML('subsidair', 'block','<div style="margin-left:18px; line-height:30px; font-family:Trebuchet MS;">'.$subsidair.'</div>', $arrDocnya);	

	$docx->replaceVariableByHTML('jpn', 'block', $jaksa_negara, $arrDocnya);
	   
	$docx->createDocx('template/datun/PERLAWANAN TERGUGAT');
	$file = 'template/datun/PERLAWANAN TERGUGAT.docx';
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