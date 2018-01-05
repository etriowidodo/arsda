<?php
	use app\modules\pidsus\models\PdsPidsus15Umum;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../modules/pidsus/template/Pidsus-15-Umum.docx');

	$namaSatker     = Yii::$app->inspektur->getNamaSatker();
	$lokSatker 	= Yii::$app->inspektur->getLokasiSatker()->lokasi;
	$almtSatker     = Yii::$app->inspektur->getLokasiSatker()->alamat;
	$tgl_pidsus15_umum= date('d-m-Y',strtotime($model['tgl_pidsus15_umum']));
	$tgl_p8_umum 	= date('d-m-Y',strtotime($model['tgl_p8_umum']));
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
        
        $sifat=[1=>'Biasa','Rahasia','Segera','Sangat Segera'];
        
        $sql2 = "select undang, pasal, dakwaan from pidsus.pds_pidsus15_umum_uu_pasal 
			where ".$whereDefault." and no_pidsus15_umum='".$model['no_pidsus15_umum']."'";
	$res2 = PdsPidsus15Umum::findBySql($sql2)->asArray()->all();
        $dakwaan=['','Juncto','Dan','Atau','Subsider'];
	if(count($res2) > 0){
		foreach($res2 as $data2){
			$undang_pasal .= $data2['undang'].' '.$data2['pasal'].' '.strtolower($dakwaan[$data2['dakwaan']]).' ';
		}
        }else{
            $undang_pasal = '';
        }
        $undang_pasal= substr($undang_pasal, 0,-2);
        
        $posisi_kasus=$model['posisi_kasus']==''?'&nbsp;':$model['posisi_kasus'];
        
        $sql3 = "select no_urut, tembusan as tembusan from pidsus.pds_pidsus15_umum_tembusan 
			where ".$whereDefault." and no_pidsus15_umum='".$model['no_pidsus15_umum']."'";
	$res3 = PdsPidsus15Umum::findBySql($sql3)->asArray()->all();
	if(count($res3) > 0){
		$nom2 = 0;
		foreach($res3 as $data3){
			$nom2++;
			$tembusan_surat .= '<span style="font-family:Times New Roman; font-size:12pt;">'.$nom2.'. '.$data3['tembusan'].'</span><br />';
		}
        }else{
            $tembusan_surat = '<span style="font-family:Times New Roman; font-size:12pt;">-</span><br />';
        }
        
	$docx->replaceVariableByText(array('Kejaksaan'=>strtoupper($namaSatker)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('kejaksaan1'=>$kejaksaan), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_surat'=>tgl_indo($tgl_pidsus15_umum)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('dikeluarkan'=>$lokSatker), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('no_pidsus15'=>$model['no_pidsus15_umum']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('sifat'=>$sifat[$model['sifat']]), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('lamp'=>$model['lampiran']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('hal'=>$model['perihal']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('kepada'=>$model['kepada']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('di_tempat'=>$model['di_kepada']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('no_p8'=>$model['no_p8_umum']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tindak_pidana'=>$model['laporan_pidana']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_p8'=>tgl_indo($tgl_p8_umum)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByHTML('posisi_kasus', 'inline', $posisi_kasus, $arrDocnya);
        $docx->replaceVariableByText(array('undang_pasal'=>$model['berdasarkan_uu']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('keperluan'=>strtolower($model['keperluan'])), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('nama_saksi'=>$model['nama_saksi']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('jabatan_saksi'=>$model['jabatan_saksi']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ijin_dari'=>$model['ijin']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('alasan'=>$model['alasan']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('uraian_penanganan_perkara'=>$model['uraian_penanganan_perkara']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ttd_jabatannya'=>$jabatan_ttd), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ttd_nama'=>$model['penandatangan_nama']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ttd_detil'=>$model['penandatangan_pangkat'].' NIP.'.$model['penandatangan_nip']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByHTML('tembusan', 'inline', $tembusan_surat, $arrDocnya);
        
        $docx->createDocx('template/pidsus/Pidsus-15-Umum');
	$file = 'template/pidsus/Pidsus-15-Umum.docx';
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