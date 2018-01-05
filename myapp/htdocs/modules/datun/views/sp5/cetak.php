<?php
	use app\modules\datun\models\Sp1;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../modules/datun/template/S-5.docx');

	$namaSatker = Yii::$app->inspektur->getNamaSatker();
	$lokSatker 	= Yii::$app->inspektur->getLokasiSatker()->lokasi;
	$almtSatker = Yii::$app->inspektur->getLokasiSatker()->alamat;
	$arrDocnya 	= array('isFile'=>false, 'parseDivsAsPs'=>true, 'downloadImages'=>false);
	$kode_tk 	= $_SESSION['kode_tk'];
	$arrBidang 	= array('Jaksa Agung Muda Perdata dan Tata Usaha Negara', 'KAJATI', 'KAJARI', 'KACABJARI');
	$tgl_surat 	= date('d-m-Y',strtotime($model['tanggal_permohonan']));
	$tgl_ttd 	= date('d-m-Y',strtotime($model['tanggal_ttd']));
	$tgl_sp1 	= date('d-m-Y',strtotime($model['tanggal_sp1']));
		
	$sql1 = "select nip, nama, gol_jpn, pangkat_jpn, jabatan_jpn, pangkat_jpn||' ('||gol_jpn||')' as pangkatgol   
			from datun.sp1_timjpn where no_register_perkara = '".$model['no_register_perkara']."' and no_surat = '".$model['no_surat']."'";
	$res1 = Sp1::findBySql($sql1)->asArray()->all();
	if(count($res1) > 0){
		$jaksa_negara = '<table border="0" width="100%" style="border-collapse:collapse;"><tbody>';
		$nom1 = 0;
		$css1 = 'style="font-family:Trebuchet MS; font-size:11pt; font-weight:bold;" width="50%" align="left"';
		$css2 = '<br /><br /><br /><br />';
		foreach($res1 as $data1){
			$nom1++;
			$jaksa_negara .= (($nom1 % 2) != 0)?'<tr><td '.$css1.'>'.$css2.$data1['nama'].'</td>':'<td '.$css1.'>'.$css2.$data1['nama'].'</td></tr>';
		}
		$jaksa_negara .= ((count($res1) % 2) != 0)?'<td '.$css1.'>&nbsp;</td></tr>':'';
		$jaksa_negara .= '</tbody></table>';
	} else{
		$jaksa_negara = '<p>&nbsp;</p>';
	}

	$kasus_dt 	= '<table border="0" style="border-collapse:collapse; margin-left:56.6pt;"><tbody><tr><td>'.$model['posisi_kasus_dt'].'</td></tr></tbody></table>';
	$kasus_ft 	= '<table border="0" style="border-collapse:collapse; margin-left:56.6pt;"><tbody><tr><td>'.$model['posisi_kasus_ft'].'</td></tr></tbody></table>';
	$masalah 	= '<table border="0" style="border-collapse:collapse; margin-left:28.3pt;"><tbody><tr><td>'.$model['permasalahan'].'</td></tr></tbody></table>';
	$analisa 	= '<table border="0" style="border-collapse:collapse; margin-left:28.3pt;"><tbody><tr><td>'.$model['analisa'].'</td></tr></tbody></table>';
	$kesimpulan = '<table border="0" style="border-collapse:collapse; margin-left:28.3pt;"><tbody><tr><td>'.$model['kesimpulan'].'</td></tr></tbody></table>';
	$saran 		= '<table border="0" style="border-collapse:collapse; margin-left:28.3pt;"><tbody><tr><td>'.$model['saran'].'</td></tr></tbody></table>';
	$srtPrincipel = ($model['kode_jenis_instansi'] == '01' || $model['kode_jenis_instansi'] == '06')?'':'Nomor '.$model['no_surat'].', ';
	$srtPrincipel .= 'Tanggal '.tgl_indo($tgl_surat);

	$docx->replaceVariableByText(array('lokasi_header'=>strtoupper($namaSatker)), array('parseLineBreaks'=>true, 'target'=>'header'));
	$docx->replaceVariableByText(array('permasalahan_permohonan'=>$model['permasalahan_pemohon']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('instansi_wilayah'=>$model['wil_instansi']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('variabel_permohonan'=>$srtPrincipel), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('no_permohonan'=>$model['no_surat']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_permohonan'=>tgl_indo($tgl_surat)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('bidang_kejaksaan'=>$arrBidang[$kode_tk]), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('no_sp1'=>$model['no_sp1']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_sp1'=>tgl_indo($tgl_sp1)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByHTML('posisi_kasus_data', 'block', $kasus_dt, $arrDocnya);
	$docx->replaceVariableByHTML('posisi_kasus_fakta', 'block', $kasus_ft, $arrDocnya);
	$docx->replaceVariableByHTML('permasalahan', 'block', $masalah, $arrDocnya);
	$docx->replaceVariableByHTML('analisa', 'block', $analisa, $arrDocnya);
	$docx->replaceVariableByHTML('kesimpulan', 'block', $kesimpulan, $arrDocnya);
	$docx->replaceVariableByHTML('saran', 'block', $saran, $arrDocnya);
	$docx->replaceVariableByText(array('lokasi_satker'=>$lokSatker), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_ttd'=>tgl_indo($tgl_ttd)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByHTML('timJPN', 'block', $jaksa_negara, $arrDocnya);

	$docx->createDocx('template/datun/S-5');
	$file = 'template/datun/S-5.docx';
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