<?php
	use app\modules\pidsus\models\PdsPidsus20cUmum;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../modules/pidsus/template/Pidsus-20c-Umum.docx');

	$namaSatker     = Yii::$app->inspektur->getNamaSatker();
	$lokSatker 	= Yii::$app->inspektur->getLokasiSatker()->lokasi;
	$almtSatker     = Yii::$app->inspektur->getLokasiSatker()->alamat;
	$tgl_pidsus20c_umum= date('d-m-Y',strtotime($model['tgl_dikeluarkan']));
	$tgl_p8_umum 	= date('d-m-Y',strtotime($model['tgl_p8_umum']));
	$tgl_b4 	= date('d-m-Y',strtotime($model['tgl_b4']));
	$tgl_pelaksanaan 	= date('d-m-Y',strtotime($model['tgl_penggeledahan']));
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
                
        $sql3 = "select no_urut, tembusan as tembusan from pidsus.pds_pidsus20c_umum_tembusan 
			where ".$whereDefault." and no_pidsus20c_umum='".$model['no_pidsus20c_umum']."'";
	$res3 = PdsPidsus20cUmum::findBySql($sql3)->asArray()->all();
	if(count($res3) > 0){
		$nom2 = 0;
		foreach($res3 as $data3){
			$nom2++;
			$tembusan_surat .= '<span style="font-family:Times New Roman; font-size:12pt;">'.$nom2.'. '.$data3['tembusan'].'</span><br />';
		}
        }else{
            $tembusan_surat = '<span style="font-family:Times New Roman; font-size:12pt;">-</span><br />';
        }
        
        $sql4 = "select nama_jaksa from pidsus.pds_b4_umum_jaksa 
			where ".$whereDefault." and no_b4_umum = '".$model['no_b4_umum']."' order by no_urut";
	$res4 = PdsPidsus20cUmum::findBySql($sql4)->asArray()->all();
	if(count($res4) > 0){
		$i = 1;
                $nom4 = 'a';
		foreach($res4 as $data4){
			$jaksa .= '<span style="font-family:Times New Roman; font-size:12pt;">'.$nom4.'. '.$data4['nama_jaksa'].'</span><br />';
                        $nom4 = chr(ord($nom4) + $i);
                        $i++;
		}
        }else{
            $jaksa = '<span style="font-family:Times New Roman; font-size:12pt;">-</span><br />';
        }
        
        $sifat=[1=>'Biasa','Rahasia','Segera','Sangat Segera'];
	$docx->replaceVariableByText(array('Kejaksaan'=>strtoupper($namaSatker)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('kejaksaan1'=>$kejaksaan), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_surat'=>tgl_indo($tgl_pidsus20c_umum)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('dikeluarkan'=>$lokSatker), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('no_pidsus20c'=>$model['no_pidsus20c_umum']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('kepada'=>$model['kepada']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('di_tempat'=>$model['di_tempat']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('sifat'=>$sifat[$model['sifat']]), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('lamp'=>$model['lampiran']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('nomor_b4'=>$model['no_b4_umum']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_b4'=>tgl_indo($tgl_b4)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tindak_pidana'=>$model['laporan_pidana']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByHTML('jaksa', 'inline', $jaksa, $arrDocnya);
        $docx->replaceVariableByText(array('hari_pelaksanaan'=> Yii::$app->globalfunc->GetNamaHari($model['tgl_penggeledahan'])), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tanggal_pelaksanaan'=>tgl_indo($tgl_pelaksanaan)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tempat_pelaksanaan'=>$model['tempat_pelaksanaan']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('jam_pelaksanaan'=>'Pukul '.$model['jam_penggeledahan']), array('parseLineBreaks'=>true));
	
	$docx->replaceVariableByText(array('ttd_jabatannya'=>$jabatan_ttd), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ttd_nama'=>$model['penandatangan_nama']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ttd_detil'=>$model['penandatangan_pangkat'].' NIP.'.$model['penandatangan_nip']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByHTML('tembusan', 'inline', $tembusan_surat, $arrDocnya);
        
        $docx->createDocx('template/pidsus/Pidsus-20c-Umum');
	$file = 'template/pidsus/Pidsus-20c-Umum.docx';
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