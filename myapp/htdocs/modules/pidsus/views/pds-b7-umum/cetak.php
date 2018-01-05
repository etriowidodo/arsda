<?php
	use app\modules\pidsus\models\PdsB7Umum;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../modules/pidsus/template/B-7-Umum.docx');

	$namaSatker     = Yii::$app->inspektur->getNamaSatker();
	$lokSatker 	= Yii::$app->inspektur->getLokasiSatker()->lokasi;
	$almtSatker     = Yii::$app->inspektur->getLokasiSatker()->alamat;
	$tgl_p8_umum 	= date('d-m-Y',strtotime($model['tgl_p8_umum']));
	$tgl_dikeluarkan= date('d-m-Y',strtotime($model['tgl_dikeluarkan']));
        $tgl_b4 	= date('d-m-Y',strtotime($model['tgl_b4']));
        $id_kejati	= $_SESSION['kode_kejati'];
        $id_kejari	= $_SESSION['kode_kejari'];
        $id_cabjari	= $_SESSION['kode_cabjari'];
        
        $kejaksaan      = ($id_kejati.$id_kejari.$id_cabjari=="000000")?'DIREKTUR PENYIDIKAN JAKSA AGUNG MUDA TINDAK PIDANA KHUSUS':strtoupper($namaSatker);
        
        $whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' and no_p8_umum = '".$model["no_p8_umum"]."'";
        
        if(strtoupper($model['penandatangan_status_ttd']) == 'ASLI')
		$jabatan_ttd = $model['penandatangan_jabatan_ttd'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'A.N')
		$jabatan_ttd = "An. ".$model['penandatangan_jabatan_ttd']."\n".$model['penandatangan_jabatan_pejabat'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'PLT')
		$jabatan_ttd = "Plt. ".$model['penandatangan_jabatan_ttd'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'PLH')
		$jabatan_ttd = "Plh. ".$model['penandatangan_jabatan_ttd'];
        
        $sql1 = "select no_urut, tembusan as tembusan from pidsus.pds_b7_umum_tembusan 
			where ".$whereDefault." and no_b7_umum = '".$model['no_b7_umum']."' order by no_urut";
	$res1 = PdsB7Umum::findBySql($sql1)->asArray()->all();
	if(count($res1) > 0){
		$nom1 = 0;
		foreach($res1 as $data1){
			$nom1++;
			$tembusan_surat .= '<span style="font-family:Times New Roman; font-size:12pt;">'.$nom1.'. '.$data1['tembusan'].'</span><br />';
		}
        }else{
            $tembusan_surat = '<span style="font-family:Times New Roman; font-size:12pt;">-</span><br />';
        }
                
        $sql2 = "select nama_barang_disita from pidsus.pds_b4_umum_penyitaan 
		where ".$whereDefault." and no_b4_umum = '".$model['no_b4_umum']."' order by no_urut_penyitaan";
	$res2 = PdsB7Umum::findBySql($sql2)->asArray()->all();
	if(count($res2) > 0){
            foreach($res2 as $data2){
                    $penyitaan .= '<span style="font-family:Times New Roman; font-size:12pt;">- '.$data2['nama_barang_disita'].'</span><br />';
            }
        }else{
            $penyitaan = '<span style="font-family:Times New Roman; font-size:12pt;">-</span><br />';
        }
        
        
        $sifat=[1=>'Biasa','Rahasia','Segera','Sangat Segera'];
	$docx->replaceVariableByText(array('Kejaksaan'=>strtoupper($namaSatker)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('no_b7'=>$model['no_b7_umum']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('no_p8'=>$model['no_p8_umum']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_p8'=>tgl_indo($tgl_p8_umum)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('dikeluarkan'=>$model['dikeluarkan']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tanggal_dikeluarkan'=>tgl_indo($tgl_dikeluarkan)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('kepada'=>$model['kepada']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('di_tempat'=>$model['di_tempat']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('sifat'=>$sifat[$model['sifat']]), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('lamp'=>$model['lampiran']), array('parseLineBreaks'=>true));
	
        $docx->replaceVariableByText(array('no_b4'=>$model['no_b4_umum']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl_b4'=>$tgl_b4), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('Kejaksaan1'=> ucwords(strtolower($kejaksaan))), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tindak_pidana'=>$model['perkara']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('harus_dilakukan'=>$model['hal_dilakukan']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByHTML('barang_sita', 'inline', $penyitaan, $arrDocnya);
        $docx->replaceVariableByHTML('tembusan', 'inline', $tembusan_surat, $arrDocnya);
        $docx->replaceVariableByText(array('ttd_jabatannya'=>$jabatan_ttd), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ttd_nama'=>$model['penandatangan_nama']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ttd_detil'=>$model['penandatangan_pangkat'].' NIP.'.$model['penandatangan_nip']), array('parseLineBreaks'=>true));
        
	$docx->createDocx('template/pidsus/B-7-Umum');
	$file = 'template/pidsus/B-7-Umum.docx';
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