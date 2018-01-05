<?php
	use app\modules\pidsus\models\PdsB2Umum;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../modules/pidsus/template/B-2-Umum.docx');

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
        
        $sql2 = "select no_urut, tembusan as tembusan from pidsus.pds_b2_umum_tembusan 
			where ".$whereDefault." and no_b2_umum = '".$model['no_b2_umum']."' order by no_urut";
	$res2 = PdsB2Umum::findBySql($sql2)->asArray()->all();
	if(count($res2) > 0){
		$nom2 = 0;
		foreach($res2 as $data2){
			$nom2++;
			$tembusan_surat .= '<span style="font-family:Times New Roman; font-size:12pt;">'.$nom2.'. '.$data2['tembusan'].'</span><br />';
		}
        }else{
            $tembusan_surat = '<span style="font-family:Times New Roman; font-size:12pt;">-</span><br />';
        }
        
        $sql3 = "select penggeledahan_terhadap, nama, jabatan, tempat_penggeledahan, alamat_penggeledahan from pidsus.pds_b2_umum_pengeledahan 
			where ".$whereDefault." and no_b2_umum = '".$model['no_b2_umum']."' order by no_urut_penggeledahan";
	$res3 = PdsB2Umum::findBySql($sql3)->asArray()->all();
	if(count($res3) > 0){
		foreach($res3 as $data3){
                        if($data3['penggeledahan_terhadap'] == 'Subyek'){
                                $ygDigeledah = $data3['nama'].' '.$data3['jabatan'];
                        } else if($data3['penggeledahan_terhadap'] == 'Obyek'){
                                $ygDigeledah = $data3['tempat_penggeledahan'].' '.$data3['alamat_penggeledahan'];
                        }
			$penggeledahan .= $ygDigeledah.', ';
		}
                $penggeledahan = substr($penggeledahan, 0,-2);
        }else{
            $penggeledahan = '-';
        }
        
        $sql4 = "select nama_barang_disita from pidsus.pds_b2_umum_penyitaan 
			where ".$whereDefault." and no_b2_umum = '".$model['no_b2_umum']."' order by no_urut_penyitaan";
	$res4 = PdsB2Umum::findBySql($sql4)->asArray()->all();
	if(count($res4) > 0){
		foreach($res4 as $data4){
			$penyitaan .= $data4['nama_barang_disita'].', ';
		}
                $penyitaan = substr($penyitaan, 0,-2);
        }else{
            $penyitaan = '-';
        }
        
        
        $sifat=[1=>'Biasa','Rahasia','Segera','Sangat Segera'];
	$docx->replaceVariableByText(array('Kejaksaan'=>strtoupper($namaSatker)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('no_b2'=>$model['no_b2_umum']), array('parseLineBreaks'=>true));
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
        $docx->replaceVariableByText(array('penggeledahan'=>$penggeledahan), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('penyitaan'=>$penyitaan), array('parseLineBreaks'=>true));
        $docx->replaceVariableByHTML('tembusan', 'inline', $tembusan_surat, $arrDocnya);
        $docx->replaceVariableByText(array('ttd_jabatannya'=>$jabatan_ttd), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ttd_nama'=>$model['penandatangan_nama']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ttd_detil'=>$model['penandatangan_pangkat'].' NIP.'.$model['penandatangan_nip']), array('parseLineBreaks'=>true));
        
	$docx->createDocx('template/pidsus/B-2-Umum');
	$file = 'template/pidsus/B-2-Umum.docx';
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