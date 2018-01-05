<?php
	use app\modules\pidsus\models\PdsB1Umum;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../modules/pidsus/template/B-1-Umum.docx');

	$namaSatker     = Yii::$app->inspektur->getNamaSatker();
	$lokSatker 	= Yii::$app->inspektur->getLokasiSatker()->lokasi;
	$almtSatker     = Yii::$app->inspektur->getLokasiSatker()->alamat;
	$tgl_p8_umum 	= date('d-m-Y',strtotime($model['tgl_p8_umum']));
	$tgl_dikeluarkan= date('d-m-Y',strtotime($model['tgl_dikeluarkan']));
        $id_kejati	= $_SESSION['kode_kejati'];
        $id_kejari	= $_SESSION['kode_kejari'];
        $id_cabjari	= $_SESSION['kode_cabjari'];
        
        $kejaksaan      = ($id_kejati.$id_kejari.$id_cabjari=="000000")?'DIREKTUR PENYIDIKAN JAKSA AGUNG MUDA TINDAK PIDANA KHUSUS':'KEPALA '.strtoupper($namaSatker);
        
        $whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' and no_p8_umum = '".$model["no_p8_umum"]."'";
        
        if(strtoupper($model['penandatangan_status_ttd']) == 'ASLI')
		$jabatan_ttd = $model['penandatangan_jabatan_ttd'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'A.N')
		$jabatan_ttd = "An. ".$model['penandatangan_jabatan_ttd']."\n".$model['penandatangan_jabatan_pejabat'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'PLT')
		$jabatan_ttd = "Plt. ".$model['penandatangan_jabatan_ttd'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'PLH')
		$jabatan_ttd = "Plh. ".$model['penandatangan_jabatan_ttd'];
        
        $sql2 = "select no_urut, tembusan as tembusan from pidsus.pds_b1_umum_tembusan 
			where ".$whereDefault." and no_b1_umum = '".$model['no_b1_umum']."' order by no_urut";
	$res2 = PdsB1Umum::findBySql($sql2)->asArray()->all();
	if(count($res2) > 0){
		$nom2 = 0;
		foreach($res2 as $data2){
			$nom2++;
			$tembusan_surat .= '<span style="font-family:Times New Roman; font-size:12pt;">'.$nom2.'. '.$data2['tembusan'].'</span><br />';
		}
        }else{
            $tembusan_surat = '<span style="font-family:Times New Roman; font-size:12pt;">-</span><br />';
        }
        
        
        $sifat=[1=>'Biasa','Rahasia','Segera','Sangat Segera'];
	$docx->replaceVariableByText(array('Kejaksaan'=>strtoupper($namaSatker)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('no_b1'=>$model['no_b1_umum']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('dikeluarkan'=>$model['dikeluarkan']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tanggal_dikeluarkan'=>tgl_indo($tgl_dikeluarkan)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('kepada'=>$model['kepada']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('di_tempat'=>$model['di_tempat']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('sifat'=>$sifat[$model['sifat']]), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('lamp'=>$model['lampiran']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('kejaksaan1'=> ucwords(strtolower($kejaksaan))), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('no_p8'=>$model['no_p8_umum']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl_p8'=>tgl_indo($tgl_p8_umum)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tindak_pidana'=>$model['laporan_pidana']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('berupa_barang'=>$model['berupa_barang']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('diduga_telah'=>$model['diduga_telah']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('simpan_di'=>$model['simpan_di']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('dikuasai1'=>$model['dikuasai']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByHTML('tembusan', 'inline', $tembusan_surat, $arrDocnya);
        $docx->replaceVariableByText(array('ttd_jabatannya'=>$jabatan_ttd), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ttd_nama'=>$model['penandatangan_nama']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ttd_detil'=>$model['penandatangan_pangkat'].' NIP.'.$model['penandatangan_nip']), array('parseLineBreaks'=>true));
        
	$docx->createDocx('template/pidsus/B-1-Umum');
	$file = 'template/pidsus/B-1-Umum.docx';
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