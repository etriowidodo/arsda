<?php
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../modules/pidsus/template/p-6.docx');

	$namaSatker     = Yii::$app->inspektur->getNamaSatker();
	$lokSatker 	= Yii::$app->inspektur->getLokasiSatker()->lokasi;
	$almtSatker     = Yii::$app->inspektur->getLokasiSatker()->alamat;
	$tgl_p6 	= date('d-m-Y',strtotime($model['tgl_p6']));
        
	$docx->replaceVariableByText(array('kejaksaan'=>strtoupper($namaSatker)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('hari_ini'=>Yii::$app->globalfunc->GetNamaHari($model['tgl_p6'])), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_p6'=>tgl_indo($tgl_p6)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nama_jaksa'=>$model['nama_jaksa']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('pangkat_jaksa'=>$model['pangkat_jaksa']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nip_jaksa'=>$model['nip_jaksa']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('jabatan_jaksa'=> ucwords(strtolower($model['jabatan_jaksa']))), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('melaporkan_kepada'=> $model['melaporkan_kepada']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('melaporkan_dari'=> $model['melaporkan_dari']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tentang_tindak_pidana'=> $model['tindak_pidana']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('diduga_dilakukan_oleh'=> $model['dilakukan_oleh']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('kasus_posisi'=> $model['kasus_posisi']), array('parseLineBreaks'=>true));
        
	$docx->createDocx('template/pidsus/p-6');
	$file = 'template/pidsus/p-6.docx';
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