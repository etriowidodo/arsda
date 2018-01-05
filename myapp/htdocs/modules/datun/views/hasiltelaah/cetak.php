<?php
	use app\modules\datun\models\Sp1;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../modules/datun/template/S-T.docx');

	$namaSatker = Yii::$app->inspektur->getNamaSatker();
	$lokSatker 	= Yii::$app->inspektur->getLokasiSatker()->lokasi;
	$almtSatker = Yii::$app->inspektur->getLokasiSatker()->alamat;
	$arrDocnya 	= array('isFile'=>false, 'parseDivsAsPs'=>true, 'downloadImages'=>false);
	$kode_tk 	= $_SESSION['kode_tk'];
	$arrBidang 	= array('Jaksa Agung Muda Perdata dan Tata Usaha Negara', 'KAJATI', 'KAJARI', 'KACABJARI');
	$tgl_surat 	= date('d-m-Y',strtotime($model['tanggal_permohonan']));
	$tgl_telaah	= date('d-m-Y',strtotime($model['tanggal_telaah']));
	$lampiran 	= ($model['lampiran_keputusan'])?$model['lampiran_keputusan']:'-';
	$tembusan 	= "-";
		
	if(strtoupper($model['penandatangan_status']) == 'ASLI')
		$jabatan_ttd = $model['penandatangan_ttdjabat'];
	else if(strtoupper($model['penandatangan_status']) == 'A.N')
		$jabatan_ttd = "An. ".$model['penandatangan_ttdjabat']."\n".$model['penandatangan_jabatan'];
	else if(strtoupper($model['penandatangan_status']) == 'PLT')
		$jabatan_ttd = "Plt. ".$model['penandatangan_ttdjabat'];
	else if(strtoupper($model['penandatangan_status']) == 'PLH')
		$jabatan_ttd = "Plh. ".$model['penandatangan_ttdjabat'];

	$sql2 = "select no_temb_tt as no_urut, deskripsi_tembusan as tembusan from datun.keputusan_telaah_tembusan 
			where no_register_perkara = '".$model['no_register_perkara']."' and no_surat = '".$model['no_surat']."' order by no_temb_tt";
	$res2 = Sp1::findBySql($sql2)->asArray()->all();
	$tembusan = '';
	if(count($res2) > 0){
		$nom2 = 0;
		foreach($res2 as $data2){
			$nom2++;
			$tembusan .= '<span style="font-family:Trebuchet MS; font-size:11pt;">'.$nom2.'. '.$data2['tembusan'].'</span><br />';
		}
	}

	$alasan1 = '<table border="0" style="border-collapse:collapse; margin-left:28.3pt;"><tbody><tr><td>'.$model['alasan1'].'</td></tr></tbody></table>';
	$alasan2 = '<table border="0" style="border-collapse:collapse; margin-left:28.3pt;"><tbody><tr><td>'.$model['alasan2'].'</td></tr></tbody></table>';

	$docx->replaceVariableByText(array('nama_header'=>strtoupper($namaSatker)), array('parseLineBreaks'=>true, 'target'=>'header'));
	$docx->replaceVariableByText(array('lokasi_header'=>strtoupper($lokSatker)), array('parseLineBreaks'=>true, 'target'=>'header'));

	$docx->replaceVariableByText(array('no_surat_telaah'=>($model['no_surat_telaah'])?$model['no_surat_telaah']:'............'), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('lokasi_satker'=>$lokSatker), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tanggal_telaah'=>($tgl_telaah)?tgl_indo($tgl_telaah):'............'), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('sifat_surat'=>($model['sifat_surat'])?$model['sifat_surat']:'............'), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('lampiran_surat'=>$lampiran), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('perihal_surat'=>($model['perihal'])?$model['perihal']:'-'), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('kepada_yth'=>($model['untuk'])?$model['untuk']:'............'), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tempat'=>($model['tempat'])?$model['tempat']:'............'), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('no_permohonan'=>($model['no_surat'])?$model['no_surat']:'............'), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_permohonan'=>tgl_indo($tgl_surat)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('bidang_kejaksaan'=>$arrBidang[$kode_tk]), array('parseLineBreaks'=>true));
	$docx->replaceVariableByHTML('alasan1', 'block', str_replace('&nbsp;', ' ', $alasan1), $arrDocnya);
	$docx->replaceVariableByHTML('alasan2', 'block', str_replace('&nbsp;', ' ', $alasan2), $arrDocnya);
	$docx->replaceVariableByText(array('penandatangan_ttdjabatan'=>$jabatan_ttd), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('penandatangan_nama'=>$model['penandatangan_nama']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('penandatangan_detil'=>$model['penandatangan_pangkat'].' NIP.'.$model['penandatangan_nip']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByHTML('tembusan_ttd', 'inline', $tembusan, $arrDocnya);

	$docx->createDocx('template/datun/Hasil-Telaah');
	$file = 'template/datun/Hasil-Telaah.docx';
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