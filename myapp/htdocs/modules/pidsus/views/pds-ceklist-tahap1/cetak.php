<?php
	use app\modules\pidsus\models\PdsCeklistTahap1;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../modules/pidsus/template/Checklist.docx');

	$namaSatker     = Yii::$app->inspektur->getNamaSatker();
	$lokSatker 	= Yii::$app->inspektur->getLokasiSatker()->lokasi;
	$almtSatker     = Yii::$app->inspektur->getLokasiSatker()->alamat;
	$tgl_pengantar  = date('d-m-Y',strtotime($model['tgl_pengantar']));
	$tgl_berkas     = date('d-m-Y',strtotime($model['tgl_berkas']));
	$tgl_mulai      = date('d-m-Y',strtotime($model['tgl_mulai']));
	$tgl_selesai    = date('d-m-Y',strtotime($model['tgl_selesai']));
        $tgl_pentuntutan = date('d-m-Y',strtotime($_SESSION["tgl_spdp"]. "+60 days"));
        
        $whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' and no_spdp = '".$_SESSION["no_spdp"]."' and tgl_spdp = '".$_SESSION["tgl_spdp"]."'";
        
        $sql = "select nama from pidsus.pds_terima_berkas_tersangka "
                . " where ".$whereDefault." and no_berkas = '".$_SESSION["no_berkas"]."' and no_pengantar = '".$model['no_pengantar']."'";
	$res = PdsCeklistTahap1::findBySql($sql)->asArray()->all();
        if(count($res)==1)$nama_tersangka =$res[0]['nama'];
        else if(count($res)==2)$nama_tersangka =$res[0]['nama'].' dan '.$res[1]['nama'];
        else if(count($res)>2)$nama_tersangka =$res[0]['nama'].' dkk';
        
        $sql1 = "select pasal from pidsus.pds_terima_berkas_pengantar_uu "
                . " where ".$whereDefault." and no_berkas = '".$_SESSION["no_berkas"]."' and no_pengantar = '".$model['no_pengantar']."'";
	$res1 = PdsCeklistTahap1::findBySql($sql1)->asArray()->all();
        $disangkakan     = Yii::$app->inspektur->getGeneratePasalUU($res1);
        
        $docx->replaceVariableByText(array('Kejaksaan'=>strtoupper($namaSatker)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tanggal'=>tgl_indo($tgl_pengantar)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_penyerahan'=>tgl_indo($tgl_berkas)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('jam_penyerahan'=>'-'), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('no_berkas'=>$model['no_berkas']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_berkas_perkara'=>tgl_indo($tgl_berkas)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('jenis_perkara'=>'-'), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('jpu_peneliti'=>'-'), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('no_rp7'=>$model['no_berkas']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nama_peneliti'=>$model['nama_ttd']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nip_peneliti'=>$model['nip_ttd']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('pangkat_peneliti'=>$model['pangkat_ttd']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('waktu_peneliti'=>tgl_indo($tgl_mulai).' s/d '.tgl_indo($tgl_selesai)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nama_tersangka'=>$nama_tersangka), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('disangkakan'=>$disangkakan), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('masa_penyidik'=>'-'), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('penuntutan'=>tgl_indo($tgl_pentuntutan)), array('parseLineBreaks'=>true));
        
	$docx->createDocx('template/pidsus/Checklist');
	$file = 'template/pidsus/Checklist.docx';
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