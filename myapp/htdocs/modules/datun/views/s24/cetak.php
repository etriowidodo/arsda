<?php
	use app\modules\datun\models\S24;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../modules/datun/template/S24.docx');

	$namaSatker = Yii::$app->inspektur->getNamaSatker();
	$lokSatker 	= Yii::$app->inspektur->getLokasiSatker()->lokasi;
	$almtSatker = Yii::$app->inspektur->getLokasiSatker()->alamat;
	$arrDocnya 	= array('isFile'=>false, 'parseDivsAsPs'=>true, 'downloadImages'=>false);
	$kode_tk 	= $_SESSION['kode_tk'];
	$arrBidang 	= array('JAKSA AGUNG MUDA PERDATA DAN TATA USAHA NEGARA', 'KAJATI', 'KAJARI', 'KACABJARI');
	$tglS24		= date('d-m-Y',strtotime($model['tanggal_s24'])); 
	$tanggal_putusan= date('d-m-Y',strtotime($model['tanggal_putusan']));
	
	//$amarPutusan 	= '<table border="0" style="border-collapse:collapse; margin-left:56.6pt;"><tbody><tr><td>'.$model['amar_putusan'].'</td></tr></tbody></table>';
	//$alasan		 	= '<table border="0" style="border-collapse:collapse; margin-left:56.6pt;"><tbody><tr><td>'.$model['alasan_penundaan_s24'].'</td></tr></tbody></table>';
	
	 $amarPutusan 	= ($model['amar_putusan'])? $model['amar_putusan']:'........................';
	 $alasan		= ($model['alasan_penundaan_s24'])? $model['alasan_penundaan_s24']:'........................';
	
	$tembusan_surat = "<p> </p>";
	
	$sql2 = "select no_temb_s24 as no_urut, deskripsi_tembusan_su as tembusan from datun.s24_tembusan 
			where no_register_perkara = '".$model['no_register_perkara']."' and nomor = '".$model['nomor']."' 
			and no_putusan = '".$model['no_putusan']."' and no_register_skks = '".$model['no_register_skks']."'
			and tanggal_s24 = '".$model['tanggal_s24']."' and tanggal_putusan = '".$model['tanggal_putusan']."'	order by no_temb_s24";
	$res2 = S24::findBySql($sql2)->asArray()->all();
	if(count($res2) > 0){
		$nom2 = 0;
		foreach($res2 as $data2){
			$nom2++;
			$tembusan_surat .= '<span style="font-family:Trebuchet MS; font-size:11pt;">'.$nom2.'. '.$data2['tembusan'].'</span><br />';
		}
	}
	
	$docx->replaceVariableByText(array('alamat_kejaksaan'=>$almtSatker), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nama_kejaksaan'=>strtoupper($namaSatker)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('perihal'=>($model['perihal'])?ucwords($model['perihal']):' '), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('lokasi_keluar'=>$lokSatker), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_s24'=>($tglS24)?tgl_indo($tglS24):' '), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('yth'=>($model['kepada_yth_s24'])?ucwords($model['kepada_yth_s24']):' '), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('di'=>($model['di_s24'])?$model['di_s24']:' '), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tergugat'=>($model['tergugat'])?$model['tergugat']:' '), array('parseLineBreaks'=>true)); 
	$docx->replaceVariableByText(array('noPerdata'=>$model['no_register_perkara']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nmPengadilan'=>$model['nama_pengadilan']), array('parseLineBreaks'=>true)); 
	$docx->replaceVariableByText(array('noPutusan'=>$model['no_putusan']), array('parseLineBreaks'=>true)); 
	$docx->replaceVariableByText(array('tgl_putusan'=>tgl_indo($tanggal_putusan)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByHTML('amar_putusan', 'inline',$amarPutusan, $arrDocnya);
	$docx->replaceVariableByHTML('alasan_penundaan', 'block', '<div style=" line-height:30px; font-family:Calibri;"> '.$alasan.'</div>', $arrDocnya);
	$docx->replaceVariableByHTML('tembusan', 'block', $tembusan_surat, $arrDocnya);
	$docx->replaceVariableByText(array('nmPutusan'=>($model['nama_pegawai'])?$model['nama_pegawai']:' '), array('parseLineBreaks'=>true)); 
	$docx->replaceVariableByText(array('nip'=>($model['nip_pegawai'])?$model['nip_pegawai']:' '), array('parseLineBreaks'=>true)); 
 
	$docx->createDocx('template/datun/s24');
	$file = 'template/datun/s24.docx';
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