<?php
	use app\modules\pidsus\models\PdsP23;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../modules/pidsus/template/P-23.docx');

	$namaSatker     = Yii::$app->inspektur->getNamaSatker();
	$lokSatker 	= Yii::$app->inspektur->getLokasiSatker()->lokasi;
	$almtSatker     = Yii::$app->inspektur->getLokasiSatker()->alamat;
	$tgl_surat      = date('d-m-Y',strtotime($model['tgl_dikeluarkan']));
	$tanggalP22     = date('d-m-Y',strtotime($model['tgl_p22']));
        $tgl_berkas	= date('d-m-Y',strtotime($model['tgl_berkas']));
	$tgl_terima     = date('d-m-Y',strtotime($model['tgl_terima']));
        $whereDefault 	= "a.id_kejati = '".$_SESSION["kode_kejati"]."' and a.id_kejari = '".$_SESSION["kode_kejari"]."' and a.id_cabjari = '".$_SESSION["kode_cabjari"]."' 
                            and a.no_spdp = '".$_SESSION["no_spdp"]."' and a.tgl_spdp = '".$_SESSION["tgl_spdp"]."'";
        
        $sifat=[1=>'Biasa','Rahasia','Segera','Sangat Segera'];
        
	if(strtoupper($model['penandatangan_status_ttd']) == 'ASLI')
		$jabatan_ttd = $model['penandatangan_jabatan_ttd'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'A.N')
		$jabatan_ttd = "An. ".$model['penandatangan_jabatan_ttd']."\n".$model['penandatangan_jabatan_pejabat'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'PLT')
		$jabatan_ttd = "Plt. ".$model['penandatangan_jabatan_ttd'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'PLH')
		$jabatan_ttd = "Plh. ".$model['penandatangan_jabatan_ttd'];
	
        $sql = "select distinct a.no_urut, a.nama, a.tmpt_lahir, to_char(a.tgl_lahir, 'DD-MM-YYYY') as tgl_lahir, a.id_jkl, a.umur 
		from pidsus.pds_terima_berkas_tersangka a where ".$whereDefault." and a.no_berkas = '".$model['no_berkas']."' order by a.no_urut";
	$res = PdsP23::findBySql($sql)->asArray()->all();
        if(count($res)==1)$nama_tersangka =$res[0]['nama'];
        else if(count($res)==2)$nama_tersangka =$res[0]['nama'].' dan '.$res[1]['nama'];
        else if(count($res)>2)$nama_tersangka =$res[0]['nama'].' dkk';
        
        $sql = "select distinct a.no_urut, a.undang, a.pasal
		from pidsus.pds_terima_berkas_pengantar_uu a where ".$whereDefault." and a.no_berkas = '".$model['no_berkas']."' and a.no_pengantar = '".$model['no_pengantar']."' order by a.no_urut";
	$res = PdsP23::findBySql($sql)->asArray()->all();
        $dft_pasal     = Yii::$app->inspektur->getGeneratePasalUU($res);
        
	$sql2 = "select a.no_urut as no_urut, a.tembusan as tembusan from pidsus.pds_p23_tembusan a
		where ".$whereDefault." and a.no_berkas = '".$model['no_berkas']."' order by a.no_urut";
	$res2 = PdsP23::findBySql($sql2)->asArray()->all();
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
	$docx->replaceVariableByText(array('dikeluarkan'=>$model['dikeluarkan']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tanggal_dikeluarkan'=>tgl_indo($tgl_surat)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('nomor_surat'=>$model['no_surat']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('sifat'=>$sifat[$model['sifat']]), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('kepada'=>$model['kepada']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('lampiran'=>$model['lampiran']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('di_tempat'=>$model['di_kepada']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tersangka_lampiran'=>$nama_tersangka), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('nomor_p22'=>$model['no_p22']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tanggal_p22'=>tgl_indo($tanggalP22)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('pasal'=>$dft_pasal), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('kepala'=>($jabatan_ttd)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nama_penandatangan'=>$model['penandatangan_nama']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('pangkat'=>($model['penandatangan_pangkat'])), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nip_penandatangan'=>$model['penandatangan_nip']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByHTML('tembusan', 'inline', $tembusan_surat, $arrDocnya);

	$docx->createDocx('template/pidsus/P-23');
	$file = 'template/pidsus/P-23.docx';
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