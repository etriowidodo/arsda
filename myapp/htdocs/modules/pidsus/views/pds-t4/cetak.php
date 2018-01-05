<?php
	use app\modules\datun\models\Sp1;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../modules/pidsus/template/T-4.docx');

	$namaSatker     = Yii::$app->inspektur->getNamaSatker();
	$lokSatker 	= Yii::$app->inspektur->getLokasiSatker()->lokasi;
	$almtSatker     = Yii::$app->inspektur->getLokasiSatker()->alamat;
	$tgl_minta_perpanjang       = date('d-m-Y',strtotime($model['tgl_minta_perpanjang']));
	$tgl_lahir       = date('d-m-Y',strtotime($model['tgl_lahir']));
        $tgl_ttd 	= date('d-m-Y',strtotime($model['tgl_dikeluarkan']));
        $tgl_mulai_penahanan 	= date('d-m-Y',strtotime($model['tgl_mulai_penahanan']));
        $tgl_selesai_penahanan 	= date('d-m-Y',strtotime($model['tgl_selesai_penahanan']));
        $whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' and no_spdp = '".$_SESSION["no_spdp"]."' and tgl_spdp = '".$_SESSION["tgl_spdp"]."'";
        
        if(strtoupper($model['penandatangan_status_ttd']) == 'ASLI')
		$jabatan_ttd = $model['penandatangan_jabatan_ttd'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'A.N')
		$jabatan_ttd = "An. ".$model['penandatangan_jabatan_ttd']."\n".$model['penandatangan_jabatan_pejabat'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'PLT')
		$jabatan_ttd = "Plt. ".$model['penandatangan_jabatan_ttd'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'PLH')
		$jabatan_ttd = "Plh. ".$model['penandatangan_jabatan_ttd'];
        
        $sql2 = "select no_urut, deskripsi_tembusan as tembusan from pidsus.pds_t4_tembusan 
			where ".$whereDefault." and no_minta_perpanjang = '".$model['no_minta_perpanjang']."' and no_t4 = '".$model['no_t4']."'";
	$res2 = Sp1::findBySql($sql2)->asArray()->all();
	if(count($res2) > 0){
		$nom2 = 0;
		foreach($res2 as $data2){
			$nom2++;
			$tembusan_surat .= '<span style="font-family:Times New Roman; font-size:12pt;">'.$nom2.'. '.$data2['tembusan'].'</span><br />';
		}
        }else{
            $tembusan_surat = '<span style="font-family:Times New Roman; font-size:12pt;">-</span><br />';
        }

        $arrJnsThn = array(1=>"Rutan", "Rumah", "Kota");
	$docx->replaceVariableByText(array('Kejaksaan'=>strtoupper($namaSatker)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nomor_surat'=>$model['no_t4']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('Kepala'=> strtoupper($model['penandatangan_jabatan_pejabat'])), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('kejaksaan'=> ''), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('nomor_riwayat'=> $model['no_minta_perpanjang']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tanggal_riwayat'=> tgl_indo($tgl_minta_perpanjang)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('penyidik'=> $model['penyidik']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('nm_tersangka'=> $model['nama']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('uraian_perkara'=> $model['ket_kasus']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('pasal'=> $model['undang_pasal']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('nama'=> $model['nama']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tmpt_lahir'=> $model['tmpt_lahir']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl_lahir'=> tgl_indo($tgl_lahir)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('jenis_kelamin'=> $model['jenis_kelamin']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('warganegara'=> $model['warganegara']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tmpt_tinggal'=> $model['alamat']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('agama'=> $model['agama']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('pekerjaan'=> $model['pekerjaan']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('pendidikan'=> $model['pendidikan']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl_mulai'=> tgl_indo($tgl_mulai_penahanan)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl_selesai'=> tgl_indo($tgl_selesai_penahanan)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('lokasi_tahanan'=> $model['lokasi_penahanan']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('lokasi_lp'=> $arrJnsThn[$model['jenis_penahanan']]), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('dikeluarkan'=> $model['dikeluarkan']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl_dikeluarkan'=>tgl_indo($tgl_ttd)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('kepala'=>$jabatan_ttd), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nama_penandatangan'=>$model['penandatangan_nama']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('ttd_detil'=>$model['penandatangan_pangkat'].' NIP.'.$model['penandatangan_nip']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByHTML('tembusan', 'inline', $tembusan_surat, $arrDocnya);
        
	$docx->createDocx('template/pidsus/T-4');
	$file = 'template/pidsus/T-4.docx';
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