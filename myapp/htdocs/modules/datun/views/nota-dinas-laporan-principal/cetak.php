<?php
	use app\modules\datun\models\NotaDinasLaporanPrincipal;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../modules/datun/template/nodis.docx');

	$namaSatker = Yii::$app->inspektur->getNamaSatker();
	$lokSatker 	= Yii::$app->inspektur->getLokasiSatker()->lokasi;
	$almtSatker = Yii::$app->inspektur->getLokasiSatker()->alamat;
	$arrDocnya 	= array('isFile'=>false, 'parseDivsAsPs'=>true, 'downloadImages'=>false);
	$kode_tk 	= $_SESSION['kode_tk'];
	$arrBidang 	= array('JAKSA AGUNG MUDA PERDATA DAN TATA USAHA NEGARA', 'KAJATI', 'KAJARI', 'KACABJARI');
	$tgl_nodis	= date('d-m-Y',strtotime($model['tanggal_nodis']));
	$tgl_skk	= date('d-m-Y',strtotime($model['tanggal_skk']));
	$tgl_skks	= date('d-m-Y',strtotime($model['tanggal_skks']));
	$kasus_posisi 			= ($model['kasus_posisi'])? '<div style=" line-height:30px; font-family:Trebuchet MS;"> '.$model['kasus_posisi'].'</div>':'........................';
	$putusan_aquo	 		= ($model['putusan_aquo'])? '<div style=" line-height:30px; font-family:Trebuchet MS;"> '.$model['putusan_aquo'].'</div>':'........................'; 
	$kesimpulan		 		= ($model['kesimpulan'])? '<div style=" line-height:30px; font-family:Trebuchet MS;"> '.$model['kesimpulan'].'</div>':'........................'; 
	$tembusan_surat 		= "<p> </p>";
	
	if(strtoupper($model['penandatangan_status']) == 'ASLI')
		$jabatan_ttd = $model['penandatangan_ttdjabat'];
	else if(strtoupper($model['penandatangan_status']) == 'A.N')
		$jabatan_ttd = "An. ".$model['penandatangan_ttdjabat']."\n".$model['penandatangan_jabatan'];
	else if(strtoupper($model['penandatangan_status']) == 'PLT')
		$jabatan_ttd = "Plt. ".$model['penandatangan_ttdjabat'];
	else if(strtoupper($model['penandatangan_status']) == 'PLH')
		$jabatan_ttd = "Plh. ".$model['penandatangan_ttdjabat'];
		
	
	$sql2 = "select no_tembusan as no_urut, deskripsi_tembusan as tembusan from datun.nodis_tembusan 
			where no_register_skks = '".$model['no_register_skks']."' and no_putusan = '".$model['no_putusan']."'
			and tanggal_putusan = '".$model['tanggal_putusan']."' and nomor_prinsipal = '".$model['nomor_prinsipal']."'
			and nomor_nodis = '".$model['nomor_nodis']."' order by no_tembusan";
	$res2 = NotaDinasLaporanPrincipal::findBySql($sql2)->asArray()->all();
	if(count($res2) > 0){
		$nom2 = 0;
		$tembusan_surat	="";
		foreach($res2 as $data2){
			$nom2++;
			$tembusan_surat .= '<span style="font-family:Trebuchet MS; font-size:11pt;">'.$nom2.'. '.$data2['tembusan'].'</span><br />';
		}
	} 

	$docx->replaceVariableByText(array('alamat_kejaksaan'=>$almtSatker), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nama_kejaksaan'=>strtoupper($namaSatker)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('kepada_yth'=>($model['kepada_yth'])?strtoupper($model['kepada_yth']):' '), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('dari'=>($model['dari'])?$model['dari']:' '), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nomor'=>$model['nomor_nodis']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_nodis'=>tgl_indo($tgl_nodis)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('sifat'=>($model['sifat'])?$model['sifat']:' '), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('lampiran'=>($model['lampiran'])?$model['lampiran']:' '), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('perihal'=>($model['perihal'])?$model['perihal']:' '), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('pemberi'=>$model['deskripsi_instansi']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('jab_skk'=>($model['jab_skk'])?$model['jab_skk']:' '), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nm_kejaksaan'=>$namaSatker), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('no_skk'=>$model['no_register_skk']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_skk'=>tgl_indo($tgl_skk)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('no_skks'=>$model['no_register_skks']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_skks'=>tgl_indo($tgl_skks)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('no_perkara'=>$model['no_register_perkara']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('penggugat'=>strtoupper($model['penggugat'])), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tergugat'=>strtoupper($model['tergugat'])), array('parseLineBreaks'=>true));
	$docx->replaceVariableByHTML('kasus', 'block', $kasus_posisi, $arrDocnya); 
	$docx->replaceVariableByHTML('putusan', 'block', $putusan_aquo, $arrDocnya); 
	$docx->replaceVariableByHTML('kesimpulan', 'block', $kesimpulan, $arrDocnya);
	$docx->replaceVariableByText(array('ttd_jabatannya'=>($jabatan_ttd)?$jabatan_ttd:' '), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('ttd_nama'=>($model['penandatangan_nama'])?$model['penandatangan_nama']:' '), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('ttd_detil'=>($model['penandatangan_pangkat'])?$model['penandatangan_pangkat'].' NIP.'.$model['penandatangan_nip']:' '), array('parseLineBreaks'=>true));
	$docx->replaceVariableByHTML('tembusan', 'block', $tembusan_surat, $arrDocnya);
	$docx->replaceVariableByText(array('sts_tergugat'=>$model['status_tergugat']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('no_sts_tergugat'=>$model['no_status_tergugat']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('sts_pemohon'=>$model['status_pemohon']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('no_sts_pemohon'=>$model['no_status_pemohon']), array('parseLineBreaks'=>true));

	$docx->createDocx('template/datun/nodis');
	$file = 'template/datun/nodis.docx';
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