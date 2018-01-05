<?php
	use app\modules\datun\models\LaporanPrincipal;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../modules/datun/template/L-Prinsipal.docx');

	$namaSatker             = Yii::$app->inspektur->getNamaSatker();
	$lokSatker 	            = Yii::$app->inspektur->getLokasiSatker()->lokasi;
	$almtSatker             = Yii::$app->inspektur->getLokasiSatker()->alamat;
	$arrDocnya 	            = array('isFile'=>false, 'parseDivsAsPs'=>true, 'downloadImages'=>false);
	$kode_tk 	            = $_SESSION['kode_tk'];
	$arrBidang 	            = array('JAKSA AGUNG MUDA PERDATA DAN TATA USAHA NEGARA', 'KAJATI', 'KAJARI', 'KACABJARI');
	$tgl_diterima 	        = date('d-m-Y',strtotime($model['tanggal_diterima']));
	$tanggal_putusan        = date('d-m-Y',strtotime($model['tanggal_putusan']));
	$tanggal_prinsipal      = date('d-m-Y',strtotime($model['tanggal_prinsipal']));
	$tanggalSkk             = date('d-m-Y',strtotime($model['tanggal_skk']));
	$tanggalSkks            = date('d-m-Y',strtotime($model['tanggal_skks']));
	$tembusan_surat         = "";
	$jaksa_negara 	        = "";
	$pihak		 			= ($model['pihak'])? '<div style=" line-height:30px; font-family:Trebuchet MS;"> '.$model['pihak'].'</div>':'........................';
	$kasus_posisi 			= ($model['kasus_posisi'])? '<div style=" line-height:30px; font-family:Trebuchet MS;"> '.$model['kasus_posisi'].'</div>':'........................';
	$penanganan_perkara		= ($model['penanganan_perkara'])? '<div style=" line-height:30px; font-family:Trebuchet MS;"> '.$model['penanganan_perkara'].'</div>':'........................';
	$resume 				= ($model['resume'])? '<div style=" line-height:30px; font-family:Trebuchet MS;"> '.$model['resume'].'</div>':'........................';
	$cdeskripsi_inst_wilayah=($model['tergugat']!=''?$model['tergugat']:'<p></p>');
	
	if(strtoupper($model['penandatangan_status']) == 'ASLI')
		$jabatan_ttd = $model['penandatangan_ttdjabat'];
	else if(strtoupper($model['penandatangan_status']) == 'A.N')
		$jabatan_ttd = "An. ".$model['penandatangan_ttdjabat']."\n".$model['penandatangan_jabatan'];
	else if(strtoupper($model['penandatangan_status']) == 'PLT')
		$jabatan_ttd = "Plt. ".$model['penandatangan_ttdjabat'];
	else if(strtoupper($model['penandatangan_status']) == 'PLH')
		$jabatan_ttd = "Plh. ".$model['penandatangan_ttdjabat'];
		
	$tembusan_surat = "<p> </p>";
	
	$sql2 = "select no_tembusan as no_urut, deskripsi_tembusan as tembusan from datun.laporan_prinsipal_tembusan 
			where nomor_prinsipal = '".$model['nomor_prinsipal']."' and no_putusan = '".$model['no_putusan']."' 
			and tanggal_putusan = '".$model['tanggal_putusan']."' and no_register_skks = '".$model['no_register_skks']."'
			order by no_tembusan";
	$res2 = LaporanPrincipal::findBySql($sql2)->asArray()->all();
	if(count($res2) > 0){
		$nom2 = 0;
		$tembusan_surat = "";
		foreach($res2 as $data2){
			$nom2++;
			$tembusan_surat .= '<span style="font-family:Trebuchet MS; font-size:11pt;">'.$nom2.'. '.$data2['tembusan'].'</span><br />';
		}
	}
	
	
	$docx->replaceVariableByText(array('alamat_kejaksaan'=>$almtSatker), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nama_kejaksaan'=>strtoupper($namaSatker)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('di_kejaksaan'=>ucwords($namaSatker)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('no_prinsipal'=>$model['nomor_prinsipal']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('sifat'=>($model['sifat'])?$model['sifat']:' '), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('lampiran'=>($model['lampiran'])?$model['lampiran']:' '), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('perihal'=>($model['perihal'])?$model['perihal']:' '), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_prinsipal'=>($tanggal_prinsipal)?tgl_indo($tanggal_prinsipal):' '), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('lokasi_keluar'=>$lokSatker), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('yth'=>($model['kepada_yth'])?$model['kepada_yth']:' '), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('di'=>($model['di'])?$model['di']:' '), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('no_skk'=>$model['no_register_skk']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_skk'=>tgl_indo($tanggalSkk)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('no_skks'=>$model['no_register_skks']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_skks'=>tgl_indo($tanggalSkks)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('no_perdata'=>$model['no_register_perkara']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('penggugat'=>strtoupper($model['penggugat'])), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('sts_tergugat'=>$model['status_tergugat']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('no_sts_tergugat'=>$model['no_status_tergugat']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tergugat'=>strtoupper($model['tergugat'])), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('sts_pemohon'=>$model['status_pemohon']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('no_sts_pemohon'=>$model['no_status_pemohon']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByHTML('pihak', 'block', $pihak, $arrDocnya);
	$docx->replaceVariableByHTML('kasus_posisi', 'block', $kasus_posisi, $arrDocnya);
	$docx->replaceVariableByHTML('resume', 'block', $resume, $arrDocnya);
	$docx->replaceVariableByHTML('penanganan_perkara', 'block', $penanganan_perkara, $arrDocnya);
	$docx->replaceVariableByHTML('tembusan', 'block', $tembusan_surat, $arrDocnya);
	$docx->replaceVariableByText(array('jab_jaksa'=>$model['jabatan_pegawai']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('deskripsi_inst_wilayah'=>$cdeskripsi_inst_wilayah),array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('penerima_kuasa'=>$model['penerima_kuasa']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('ttd_jabatannya'=>($jabatan_ttd)?$jabatan_ttd:' '), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('ttd_nama'=>($model['penandatangan_nama'])?$model['penandatangan_nama']:' '), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('ttd_detil'=>($model['penandatangan_pangkat'])?$model['penandatangan_pangkat'].' NIP.'.$model['penandatangan_nip']:' '), array('parseLineBreaks'=>true));

	
	
	$docx->createDocx('template/datun/L-Prinsipal');
	$file = 'template/datun/L-Prinsipal.docx';
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