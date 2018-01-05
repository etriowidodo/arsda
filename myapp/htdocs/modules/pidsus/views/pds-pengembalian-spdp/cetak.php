<?php
	use app\modules\pidsus\models\PdsPengembalianSpdp;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../modules/pidsus/template/Pengembalian-SPDP.docx');

	$whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' 
						and no_spdp = '".$model["no_spdp"]."' and tgl_spdp = '".$model["tgl_spdp"]."'";

	$namaSatker = Yii::$app->inspektur->getNamaSatker();
	$lokSatker 	= Yii::$app->inspektur->getLokasiSatker()->lokasi;
	$almtSatker = Yii::$app->inspektur->getLokasiSatker()->alamat;
	$arrDocnya 	= array('isFile'=>false, 'parseDivsAsPs'=>true, 'downloadImages'=>false);

	$tgl_spdp 	= date('d-m-Y',strtotime($model['tgl_spdp']));
	$tgl_terima = date('d-m-Y',strtotime($model['tgl_terima']));
	$tgl_dikeluarkan = date('d-m-Y',strtotime($model['tgl_dikeluarkan']));
	$tembusan_surat = "";
	$tersangka 	= "";

	//echo '<pre>';print_r($model); exit;
	$temp1 = ($model['tersangka_berkas'])?$model['tersangka_berkas']:$model['tersangka'];
	$arrt1 = explode("#", $temp1);
	if(count($arrt1) == 1) $tersangka .= $arrt1[0];
	else if(count($arrt1) == 2) $tersangka .= $arrt1[0]." dan ".$arrt1[1];
	else if(count($arrt1) > 2) $tersangka .= $arrt1[0]." dkk";

	if(strtoupper($model['penandatangan_status_ttd']) == 'ASLI')
		$jabatan_ttd = $model['penandatangan_jabatan_ttd'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'A.N')
		$jabatan_ttd = "An. ".$model['penandatangan_jabatan_ttd']."\n".$model['penandatangan_jabatan_pejabat'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'PLT')
		$jabatan_ttd = "Plt. ".$model['penandatangan_jabatan_ttd'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'PLH')
		$jabatan_ttd = "Plh. ".$model['penandatangan_jabatan_ttd'];
		
	$sql2 = "select no_urut as no_urut, deskripsi_tembusan as tembusan from pidsus.pds_spdp_kembali_tembusan 
			where ".$whereDefault." and no_spdp_kembali = '".$model['no_spdp_kembali']."' order by no_urut";
	$res2 = PdsPengembalianSpdp::findBySql($sql2)->asArray()->all();
	if(count($res2) > 0){
		$nom2 = 0;
		foreach($res2 as $data2){
			$nom2++;
			$tembusan_surat .= '<span style="font-family:Times New Roman; font-size:12pt;">'.$data2['no_urut'].'. '.$data2['tembusan'].'</span><br />';
		}
	}

	$docx->replaceVariableByText(array('kejaksaan'=>strtoupper($namaSatker)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nomor_spdp'=>$model['no_spdp']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tanggal_spdp'=>tgl_indo($tgl_spdp)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tanggal_terima'=>tgl_indo($tgl_terima)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nomor'=>$model['no_spdp_kembali']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('dikeluarkan'=>$model['dikeluarkan']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_dikeluarkan'=>tgl_indo($tgl_dikeluarkan)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nama_tersangka'=>$tersangka), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('sifat'=>$model['sifat_surat']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('lampiran'=>$model['lampiran']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('perihal'=>$model['perihal']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('kepada'=>$model['kepada']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('di_tempat'=>$model['di_kepada']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('ttd_jabatannya'=>$jabatan_ttd), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('ttd_nama'=>$model['penandatangan_nama']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('ttd_detil'=>$model['penandatangan_pangkat'].' NIP.'.$model['penandatangan_nip']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByHTML('tembusan', 'inline', $tembusan_surat, $arrDocnya);

	$docx->createDocx('template/pidsus/Pengembalian-SPDP');
	$file = 'template/pidsus/Pengembalian-SPDP.docx';
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