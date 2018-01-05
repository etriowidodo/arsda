<?php
	use app\modules\pidsus\models\PdsPidsus7Umum;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../modules/pidsus/template/Pidsus-7-Umum.docx');

	$namaSatker     = Yii::$app->inspektur->getNamaSatker();
	$lokSatker 	= Yii::$app->inspektur->getLokasiSatker()->lokasi;
	$almtSatker     = Yii::$app->inspektur->getLokasiSatker()->alamat;
	$tgl_pidsus7    = date('d-m-Y',strtotime($model['tgl_pidsus7']));
	$tgl_ekspose    = date('d-m-Y',strtotime($model['tgl_ekspose']));
	$tgl_p8_umum 	= date('d-m-Y',strtotime($model['tgl_p8_umum']));
        
        $id_kejati	= $_SESSION['kode_kejati'];
        $id_kejari	= $_SESSION['kode_kejari'];
        $id_cabjari	= $_SESSION['kode_cabjari'];
        
        $whereDefault 	= "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_p8_umum = '".$_SESSION["pidsus_no_p8_umum"]."'";
        
        $kejaksaan      = ($id_kejati.$id_kejari.$id_cabjari=="000000")?'Direktur Penyidikan Jaksa Agung Muda Tindak Pidana Khusus': 'Kepala '.ucwords(strtolower($namaSatker));

        if($id_kejati == "00" && $id_kejari == "00" && $id_cabjari == "00"){
            $kepada = 'JAMPIDSUS';
        } else if($id_kejati != "00" && $id_kejari == "00" && $id_cabjari == "00"){
            $kepada = 'KAJATI '.$namaSatker;
        } else if($id_kejati != "00" && $id_kejari != "00" && $id_cabjari == "00"){
            $kepada = 'KAJARI '.$namaSatker;
        } else if($id_kejati != "00" && $id_kejari != "00" && $id_cabjari != "00"){
            $kepada = 'KACABJARI '.$namaSatker;
        }
           
        if(strtoupper($model['penandatangan_status_ttd']) == 'ASLI')
		$jabatan_ttd = $model['penandatangan_jabatan_ttd'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'A.N')
		$jabatan_ttd = "An. ".$model['penandatangan_jabatan_ttd']."\n".$model['penandatangan_jabatan_pejabat'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'PLT')
		$jabatan_ttd = "Plt. ".$model['penandatangan_jabatan_ttd'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'PLH')
		$jabatan_ttd = "Plh. ".$model['penandatangan_jabatan_ttd'];
       
        
	$docx->replaceVariableByText(array('Kejaksaan'=>strtoupper($namaSatker)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('kejaksaan1'=>$kejaksaan), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('kepada'=>$kepada), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl_pidsus7'=>tgl_indo($tgl_pidsus7)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tindak_pidana'=>$model['laporan_pidana']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl_ekspose'=>tgl_indo($tgl_ekspose)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tmp_ekspose'=>$model['di_tempat']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByHTML('posisi_kasus', 'inline', $model['posisi_kasus'], $arrDocnya);
        $docx->replaceVariableByHTML('pendapat_pemapar', 'inline', $model['pendapat_pemapar'], $arrDocnya);
        $docx->replaceVariableByHTML('pendapat_pimpinan', 'inline', $model['pendapat_pimpinan'], $arrDocnya);
        $docx->replaceVariableByHTML('kesimpulan', 'inline', $model['kesimpulan'], $arrDocnya);
        $docx->replaceVariableByHTML('saran', 'block', $model['saran'], $arrDocnya);
        $docx->replaceVariableByText(array('ttd_nama'=>$model['nama_jaksa']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ttd_detil'=>$model['pangkat_jaksa'].' NIP.'.$model['nip_jaksa']), array('parseLineBreaks'=>true));
        
        $docx->createDocx('template/pidsus/Pidsus-7-Umum');
	$file = 'template/pidsus/Pidsus-7-Umum.docx';
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