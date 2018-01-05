<?php   use app\modules\pidsus\models\PdsP14Umum;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../modules/pidsus/template/P-14-Umum.docx');

	$namaSatker     = Yii::$app->inspektur->getNamaSatker();
	$lokSatker 	= Yii::$app->inspektur->getLokasiSatker()->lokasi;
	$almtSatker     = Yii::$app->inspektur->getLokasiSatker()->alamat;
        $tgl_p8_umum    = ($model['tgl_p8_umum'])?date('d-m-Y',strtotime($model['tgl_p8_umum'])):'';
        $tgl_pidsus7    = ($model['tgl_pidsus7'])?date('d-m-Y',strtotime($model['tgl_pidsus7'])):'';
        $tgl_surat_persetujuan = ($model['tgl_surat_persetujuan'])?date('d-m-Y',strtotime($model['tgl_surat_persetujuan'])):'';
        $tgl_dikeluarkan= ($model['tgl_dikeluarkan'])?date('d-m-Y',strtotime($model['tgl_dikeluarkan'])):'';
        $id_kejati	= $_SESSION['kode_kejati'];
        $id_kejari	= $_SESSION['kode_kejari'];
        $id_cabjari	= $_SESSION['kode_cabjari'];
        
        $kejaksaan      = ($id_kejati.$id_kejari.$id_cabjari=="000000")?'Direktur Penyidikan Jaksa Agung Muda Tindak Pidana Khusus': 'Kepala '.ucwords(strtolower($namaSatker));
        
        $whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' 
						and no_p8_umum = '".$_SESSION["pidsus_no_p8_umum"]."'";
        if(strtoupper($model['penandatangan_status_ttd']) == 'ASLI')
		$jabatan_ttd = $model['penandatangan_jabatan_ttd'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'A.N')
		$jabatan_ttd = "An. ".$model['penandatangan_jabatan_ttd']."\n".$model['penandatangan_jabatan_pejabat'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'PLT')
		$jabatan_ttd = "Plt. ".$model['penandatangan_jabatan_ttd'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'PLH')
		$jabatan_ttd = "Plh. ".$model['penandatangan_jabatan_ttd'];
        
        $sql2 = "select no_urut, tembusan as tembusan from pidsus.pds_p14_umum_tembusan 
			where ".$whereDefault;
	$res2 = PdsP14Umum::findBySql($sql2)->asArray()->all();
	if(count($res2) > 0){
		$nom2 = 0;
		foreach($res2 as $data2){
			$nom2++;
			$tembusan_surat .= '<span style="font-family:Times New Roman; font-size:12pt;">'.$nom2.'. '.$data2['tembusan'].'</span><br />';
		}
        }else{
            $tembusan_surat = '<span style="font-family:Times New Roman; font-size:12pt;">-</span><br />';
        }
        
        $a = explode(",", $model['alasan']);
        $list_alasan = array(1=>'Tidak terdapat cukup bukti','Peristiwa yang dilakukan bukan merupakan tindak pidana','Penyidikan harus ditutup demi hukum');
                   
       if(count($a) > 0){
                $s = 'a';
		foreach($a as $key=>$value){
                    $alasan .= '<span style="font-family:Times New Roman; font-size:12pt;">'.$s.'. '.$list_alasan[$value].'</span><br />';
                    $s = chr(ord($s) + 1);
		}
        }else{
            $alasan = '<span style="font-family:Times New Roman; font-size:12pt;">-</span><br />';
        }
        $alasan1 = ((in_array("1", $a))?'tidak terdapat cukup bukti, ':'').
                  ((in_array("2", $a))?'peristiwa yang dilakukan bukan merupakan tindak pidana, ':'').
                  ((in_array("3", $a))?'penyidikan harus ditutup demi hukum, ':'');
        
        $alasan1 = substr($alasan1, 0,-2);
       
	$docx->replaceVariableByText(array('Kejaksaan'=>strtoupper($namaSatker)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('kejaksaan1'=>strtoupper($kejaksaan)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('kejaksaan2'=>$kejaksaan), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl_pidsus7'=>tgl_indo($tgl_pidsus7)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tindak_pidana'=>$model['laporan_pidana']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByHTML('alasan', 'inline', $alasan, $arrDocnya);
        $docx->replaceVariableByText(array('no_p8'=>$model['no_p8_umum']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('no_sp'=>$model['no_surat_persetujuan']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl_sp'=>tgl_indo($tgl_surat_persetujuan)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('nama_jaksa'=>$model['nama_jaksa']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('pangkat_jaksa'=>$model['pangkat_jaksa']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nip_jaksa'=>$model['nip_jaksa']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('jabatan_jaksa'=>$model['jabatan_jaksa']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('alasan1'=>$alasan1), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('lokasi_keluar'=>$model['dikeluarkan']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl_ttd'=>tgl_indo($tgl_dikeluarkan)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ttd_jabatannya'=>$jabatan_ttd), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ttd_nama'=>$model['penandatangan_nama']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ttd_detil'=>$model['penandatangan_pangkat'].' NIP.'.$model['penandatangan_nip']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByHTML('tembusan', 'inline', $tembusan_surat, $arrDocnya);
             
        $docx->createDocx('template/pidsus/P-14-Umum');
	$file = 'template/pidsus/P-14-Umum.docx';
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