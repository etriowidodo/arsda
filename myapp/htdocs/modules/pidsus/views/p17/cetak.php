<?php
	use app\modules\datun\models\Sp1;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../modules/pidsus/template/P-17.docx');

	$namaSatker     = Yii::$app->inspektur->getNamaSatker();
	$lokSatker 	= Yii::$app->inspektur->getLokasiSatker()->lokasi;
	$almtSatker     = Yii::$app->inspektur->getLokasiSatker()->alamat;
	$tgl_ttd 	= date('d-m-Y',strtotime($model['tgl_dikeluarkan']));
	$tgl_spdp 	= date('d-m-Y',strtotime($model['tgl_spdp']));
	$tgl_terima 	= date('d-m-Y',strtotime($model['tgl_terima']));
        $whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' and no_spdp = '".$_SESSION["no_spdp"]."' and tgl_spdp = '".$_SESSION["tgl_spdp"]."'";
        
	if(strtoupper($model['penandatangan_status_ttd']) == 'ASLI')
		$jabatan_ttd = $model['penandatangan_jabatan_ttd'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'A.N')
		$jabatan_ttd = "An. ".$model['penandatangan_jabatan_ttd']."\n".$model['penandatangan_jabatan_pejabat'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'PLT')
		$jabatan_ttd = "Plt. ".$model['penandatangan_jabatan_ttd'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'PLH')
		$jabatan_ttd = "Plh. ".$model['penandatangan_jabatan_ttd'];
        
        $sifat=[1=>'Biasa','Rahasia','Segera','Sangat Segera'];
	
        $sql = "select a.nama from pidsus.pds_spdp_tersangka a "
                . " where ".$whereDefault;
	$res = Sp1::findBySql($sql)->asArray()->all();
        if(count($res)==1)$nama_tersangka =$res[0]['nama'];
        else if(count($res)==2)$nama_tersangka =$res[0]['nama'].' dan '.$res[1]['nama'];
        else if(count($res)>2)$nama_tersangka =$res[0]['nama'].' dkk';
        
	$sql2 = "select no_urut, deskripsi_tembusan as tembusan from pidsus.pds_p17_tembusan 
			where ".$whereDefault." and no_p17 = '".$model['no_p17']."'";
	$res2 = Sp1::findBySql($sql2)->asArray()->all();
	if(count($res2) > 0){
		$nom2 = 0;
		foreach($res2 as $data2){
			$nom2++;
			$tembusan_surat .= '<span style="font-family:Times New Roman; font-size:12pt;">'.$nom2.'. '.$data2['tembusan'].'</span><br />';
		}
	}else{
            $tembusan_surat = '<span style="font-family:Times New Roman; font-size:12pt;">-</span><br />';
        }

	$docx->replaceVariableByText(array('alamat_kejaksaan'=>$almtSatker), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('Kejaksaan'=>strtoupper($namaSatker)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nomor'=>$model['no_p17']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('sifat'=>$sifat[$model['sifat']]), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('lampiran'=>$model['lampiran']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('dikeluarkan'=>$model['dikeluarkan']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tanggal_dikeluarkan'=>tgl_indo($tgl_ttd)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('kepada'=>$model['kepada']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('di_tempat'=>$model['di_kepada']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('pasal'=>$model['undang_pasal']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nomor_spdp'=>$model['no_spdp']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_spdp'=>tgl_indo($tgl_spdp)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_terima'=>tgl_indo($tgl_terima)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tersangka'=>$nama_tersangka), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('peri'=>$nama_tersangka), array('parseLineBreaks'=>true));
        
	$docx->replaceVariableByText(array('lokasi_keluar'=>$lokSatker), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_ttd'=>tgl_indo($tgl_ttd)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('ttd_jabatannya'=>$jabatan_ttd), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('ttd_nama'=>$model['penandatangan_nama']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('ttd_detil'=>$model['penandatangan_pangkat'].' NIP.'.$model['penandatangan_nip']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByHTML('tembusan', 'inline', $tembusan_surat, $arrDocnya);

	$docx->createDocx('template/pidsus/P-17');
	$file = 'template/pidsus/P-17.docx';
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