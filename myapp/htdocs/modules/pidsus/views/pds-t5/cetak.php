<?php
	use app\modules\pidsus\models\PdsT5;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../modules/pidsus/template/T-5.docx');

	$namaSatker     = Yii::$app->inspektur->getNamaSatker();
	$lokSatker 	= Yii::$app->inspektur->getLokasiSatker()->lokasi;
	$almtSatker     = Yii::$app->inspektur->getLokasiSatker()->alamat;
	$tgl_minta_perpanjang       = date('d-m-Y',strtotime($model['tgl_minta_perpanjang']));
	$tgl_resume       = date('d-m-Y',strtotime($model['tgl_resume']));
        $tgl_ttd 	= date('d-m-Y',strtotime($model['tgl_dikeluarkan']));
        $whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' and no_spdp = '".$_SESSION["no_spdp"]."' and tgl_spdp = '".$_SESSION["tgl_spdp"]."'";
        
        $sifat=[1=>'Biasa','Rahasia','Segera','Sangat Segera'];
        
        if(strtoupper($model['penandatangan_status_ttd']) == 'ASLI')
		$jabatan_ttd = $model['penandatangan_jabatan_ttd'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'A.N')
		$jabatan_ttd = "An. ".$model['penandatangan_jabatan_ttd']."\n".$model['penandatangan_jabatan_pejabat'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'PLT')
		$jabatan_ttd = "Plt. ".$model['penandatangan_jabatan_ttd'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'PLH')
		$jabatan_ttd = "Plh. ".$model['penandatangan_jabatan_ttd'];
        
        $sql2 = "select no_urut, deskripsi_tembusan as tembusan from pidsus.pds_t5_tembusan 
			where ".$whereDefault." and no_minta_perpanjang = '".$model['no_minta_perpanjang']."' and no_t5 = '".$model['no_t5']."'";
	$res2 = PdsT5::findBySql($sql2)->asArray()->all();
	if(count($res2) > 0){
		$nom2 = 0;
		foreach($res2 as $data2){
			$nom2++;
			$tembusan_surat .= '<span style="font-family:Times New Roman; font-size:12pt;">'.$nom2.'. '.$data2['tembusan'].'</span><br />';
		}
        }else{
            $tembusan_surat = '<span style="font-family:Times New Roman; font-size:12pt;">-</span><br />';
        }

        
	$docx->replaceVariableByText(array('Kejaksaan'=>strtoupper($namaSatker)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nomor'=>$model['no_t5']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('sifat'=>$sifat[$model['sifat']]), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('lampiran'=> $model['lampiran']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('dikeluarkan'=> $model['dikeluarkan']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tanggal_dikeluarkan'=>tgl_indo($tgl_ttd)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('kepada'=>$model['kepada']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tempat'=>$model['di_kepada']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tempat'=>$model['di_kepada']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('nomor_riwayat'=> $model['no_minta_perpanjang']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tanggal_riwayat'=> tgl_indo($tgl_minta_perpanjang)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tersangka'=> $model['nama']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tanggal_resume'=> tgl_indo($tgl_resume)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('alasan'=> $model['alasan']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('nama_tersangka'=> $model['nama']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ttd_jabatannya'=>$jabatan_ttd), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('ttd_nama'=>$model['penandatangan_nama']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('ttd_detil'=>$model['penandatangan_pangkat'].' NIP.'.$model['penandatangan_nip']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByHTML('tembusan', 'inline', $tembusan_surat, $arrDocnya);
        
	$docx->createDocx('template/pidsus/T-5');
	$file = 'template/pidsus/T-5.docx';
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