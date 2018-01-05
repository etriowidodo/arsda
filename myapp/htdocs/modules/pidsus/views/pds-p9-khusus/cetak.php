<?php
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../modules/pidsus/template/P-9-Umum.docx');

	$namaSatker     = Yii::$app->inspektur->getNamaSatker();
	$lokSatker 	= Yii::$app->inspektur->getLokasiSatker()->lokasi;
	$almtSatker     = Yii::$app->inspektur->getLokasiSatker()->alamat;
        $tgl_pemanggilan = ($model['tgl_pemanggilan'])?date('d-m-Y',strtotime($model['tgl_pemanggilan'])):'';
        $tgl_p9_umum = ($model['tgl_p9_umum'])?date('d-m-Y',strtotime($model['tgl_p9_umum'])):'';
        $tgl_p8_umum = ($model['tgl_p8_umum'])?date('d-m-Y',strtotime($model['tgl_p8_umum'])):'';
        $id_kejati	= $_SESSION['kode_kejati'];
        $id_kejari	= $_SESSION['kode_kejari'];
        $id_cabjari	= $_SESSION['kode_cabjari'];
        $whereDefault 	= "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_p8_umum = '".$_SESSION["pidsus_no_p8_umum"]."'";
        
        $kejaksaan      = ($id_kejati.$id_kejari.$id_cabjari=="000000")?'Direktur Penyidikan Jaksa Agung Muda Tindak Pidana Khusus': 'Kepala '.ucwords(strtolower($namaSatker));
        
        if(strtoupper($model['penandatangan_status_ttd']) == 'ASLI')
		$jabatan_ttd = $model['penandatangan_jabatan_ttd'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'A.N')
		$jabatan_ttd = "An. ".$model['penandatangan_jabatan_ttd']."\n".$model['penandatangan_jabatan_pejabat'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'PLT')
		$jabatan_ttd = "Plt. ".$model['penandatangan_jabatan_ttd'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'PLH')
		$jabatan_ttd = "Plh. ".$model['penandatangan_jabatan_ttd'];
        
	$docx->replaceVariableByText(array('Kejaksaan'=>strtoupper($namaSatker)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('saksi_tsk'=>strtoupper($model['diperiksa_sebagai'])), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('saksi_tsk1'=>strtolower($model['diperiksa_sebagai'])), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tindak_pidana'=>$model['laporan_pidana']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nomor_p9'=>$model['no_p9_umum']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('kepada'=>$model['kepada_nama']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('di_tempat'=>$model['di_tempat']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('hari_panggil'=>$model['hari_pemanggilan']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_panggil'=>tgl_indo($tgl_pemanggilan)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('jam_panggil'=>$model['jam_pemanggilan']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tmp_panggil'=>$model['tempat_pemanggilan']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('hadap_panggil'=>$model['menghadap_kepada']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('kejaksaan1'=>$kejaksaan), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('nomor_p8'=>$model['no_p8_umum']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl_p8'=>tgl_indo($tgl_p8_umum)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl_ttd'=>tgl_indo($tgl_p9_umum)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tempat_ttd'=>$lokSatker), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ttd_jabatannya'=>$jabatan_ttd), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ttd_nama'=>$model['penandatangan_nama']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ttd_detil'=>$model['penandatangan_pangkat'].' NIP.'.$model['penandatangan_nip']), array('parseLineBreaks'=>true));
        
	$docx->createDocx('template/pidsus/P-9-Umum');
	$file = 'template/pidsus/P-9-Umum.docx';
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