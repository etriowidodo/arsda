<?php
	use app\modules\pidsus\models\PdsPidsus12Umum;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../modules/pidsus/template/Pidsus-12-Umum.docx');

	$namaSatker     = Yii::$app->inspektur->getNamaSatker();
	$lokSatker 	= Yii::$app->inspektur->getLokasiSatker()->lokasi;
	$almtSatker     = Yii::$app->inspektur->getLokasiSatker()->alamat;
	$tgl_pidsus12_umum= date('d-m-Y',strtotime($model['tgl_pidsus12_umum']));
	$tgl_p8_umum 	= date('d-m-Y',strtotime($model['tgl_p8_umum']));
        
        $id_kejati	= $_SESSION['kode_kejati'];
        $id_kejari	= $_SESSION['kode_kejari'];
        $id_cabjari	= $_SESSION['kode_cabjari'];
        
        $whereDefault 	= "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_p8_umum = '".$_SESSION["pidsus_no_p8_umum"]."'";
        
        $kejaksaan      = ($id_kejati.$id_kejari.$id_cabjari=="000000")?'Direktur Penyidikan Jaksa Agung Muda Tindak Pidana Khusus': 'Kepala '.ucwords(strtolower($namaSatker));
        
        if($model['tindak_pidana'] == 'Korupsi'){
            if($id_kejati == "00" && $id_kejari == "00" && $id_cabjari == "00"){
                $kepada = 'DIREKTUR PENUNTUTAN';
            } else if($id_kejati != "00" && $id_kejari == "00" && $id_cabjari == "00"){
                $kepada = 'KAJATI '.$namaSatker;
            } else if($id_kejati != "00" && $id_kejari == "00" && $id_cabjari == "00"){
                $kepada = 'KAJARI '.$namaSatker;
            } else if($id_kejati != "00" && $id_kejari == "00" && $id_cabjari == "00"){
                $kepada = 'KACABJARI '.$namaSatker;
            }
        }else{
            $kepada = 'JAKSA AGUNG REPUBLIK INDONESIA';
        }
                
        $penyidik = ($model['tindak_pidana'] == 'Korupsi')?'Jaksa Penyidik':'Penyidik Ad Hoc';
        
        if(strtoupper($model['penandatangan_status_ttd']) == 'ASLI')
		$jabatan_ttd = $model['penandatangan_jabatan_ttd'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'A.N')
		$jabatan_ttd = "An. ".$model['penandatangan_jabatan_ttd']."\n".$model['penandatangan_jabatan_pejabat'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'PLT')
		$jabatan_ttd = "Plt. ".$model['penandatangan_jabatan_ttd'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'PLH')
		$jabatan_ttd = "Plh. ".$model['penandatangan_jabatan_ttd'];
        
        $sql2 = "select no_urut, tembusan as tembusan from pidsus.pds_pidsus12_umum_tembusan 
			where ".$whereDefault;
	$res2 = PdsPidsus12Umum::findBySql($sql2)->asArray()->all();
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
	$docx->replaceVariableByText(array('kejaksaan1'=>$kejaksaan), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('kepada'=>$kepada), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('dari'=>$model['penandatangan_jabatan_ttd']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tindak_pidana'=>$model['laporan_pidana']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('no_pidsus12'=>$model['no_pidsus12_umum']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_pidsus12'=>tgl_indo($tgl_pidsus12_umum)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('lamp'=>$model['lampiran']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('no_p8'=>$model['no_p8_umum']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_p8'=>tgl_indo($tgl_p8_umum)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tindak_pidana'=>$model['laporan_pidana']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('penyidik'=>$penyidik), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('Kejaksaan_1'=> ucwords(strtolower($namaSatker))), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ttd_jabatannya'=>$jabatan_ttd), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ttd_nama'=>$model['penandatangan_nama']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ttd_detil'=>$model['penandatangan_pangkat'].' NIP.'.$model['penandatangan_nip']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByHTML('tembusan', 'inline', $tembusan_surat, $arrDocnya);
        
	$docx->createDocx('template/pidsus/Pidsus-12-Umum');
	$file = 'template/pidsus/Pidsus-12-Umum.docx';
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