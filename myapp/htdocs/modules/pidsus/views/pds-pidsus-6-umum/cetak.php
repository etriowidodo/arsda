<?php
	use app\modules\pidsus\models\PdsPidsus6Umum;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../modules/pidsus/template/Pidsus-6-Umum.docx');

	$namaSatker     = Yii::$app->inspektur->getNamaSatker();
	$lokSatker 	= Yii::$app->inspektur->getLokasiSatker()->lokasi;
	$almtSatker     = Yii::$app->inspektur->getLokasiSatker()->alamat;
	$tgl_p6 	= date('d-m-Y',strtotime($model['tgl_p6']));
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
        
        $sql1 = "select nip_jaksa, nama_jaksa, gol_jaksa, pangkat_jaksa, jabatan_jaksa, pangkat_jaksa||' ('||gol_jaksa||')' as pangkatgol   
			from pidsus.pds_pidsus6_umum_penelaah where ".$whereDefault." and no_pidsus6_umum = '".$model['no_pidsus6_umum']."' order by no_urut";
	$res1 = PdsPidsus6Umum::findBySql($sql1)->asArray()->all();
	$jaksa_negara = '<table border="0" width="100%" style="border-collapse:collapse;"><tbody>';
	if(count($res1) > 0){
		$nom1 = 0;
		foreach($res1 as $data1){
			$nom1++;
			$jaksa_negara .= '
				<tr>
					<td style="font-family:Times New Roman; font-size:12pt;" width="18.9%">'.($nom1 == 1?'Kepada':'&nbsp;').'</td>
					<td style="font-family:Times New Roman; font-size:12pt;" width="3.1%">'.($nom1 == 1?':':'&nbsp;').'</td>
					<td style="font-family:Times New Roman; font-size:12pt;" width="5.9%">'.$nom1.'.</td>
					<td style="font-family:Times New Roman; font-size:12pt;" width="11.9%">Nama</td>
					<td style="font-family:Times New Roman; font-size:12pt;" width="2.9%">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;" width="57.3%">'.$data1['nama_jaksa'].'</td>
				</tr>
				<tr>
					<td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
					<td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
					<td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
					<td style="font-family:Times New Roman; font-size:12pt;">Pangkat</td>
					<td style="font-family:Times New Roman; font-size:12pt;">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;">'.$data1['pangkatgol'].'</td>
				</tr>
				<tr>
					<td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
					<td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
					<td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
					<td style="font-family:Times New Roman; font-size:12pt;">Jabatan</td>
					<td style="font-family:Times New Roman; font-size:12pt;">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;">'.$data1['jabatan_jaksa'].'</td>
				</tr>
				<tr><td colspan="6">&nbsp;</td></tr>
			';
		}
	} else{
		$jaksa_negara .= '
			<tr>
				<td width="18.9%" style="font-family:Times New Roman; font-size:12pt;">Kepada</td>
				<td width="3.1%" style="font-family:Times New Roman; font-size:12pt;">:</td>
				<td width="78%" style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
			</tr>
			<tr><td colspan="3">&nbsp;</td></tr>
		';
	}
	$jaksa_negara .= '</tbody></table>';
        
        $sql2 = "select no_urut, tembusan as tembusan from pidsus.pds_pidsus6_umum_tembusan 
			where ".$whereDefault."and no_pidsus6_umum = '".$model['no_pidsus6_umum']."' order by no_urut";
	$res2 = PdsPidsus6Umum::findBySql($sql2)->asArray()->all();
	if(count($res2) > 0){
		$nom2 = 0;
		foreach($res2 as $data2){
			$nom2++;
			$tembusan_surat .= '<span style="font-family:Times New Roman; font-size:12pt;">'.$nom2.'. '.$data2['tembusan'].'</span><br />';
		}
        }else{
            $tembusan_surat = '<span style="font-family:Times New Roman; font-size:12pt;">-</span><br />';
        }
        
	$docx->replaceVariableByText(array('nama_kejaksaan'=>strtoupper($namaSatker)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('kejaksaan1'=>$kejaksaan), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('nomor_print'=>$model['no_pidsus6_umum']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByHTML('timJPN', 'block', $jaksa_negara, $arrDocnya);
        $docx->replaceVariableByText(array('lokasi_keluar'=>$model['tempat_dikeluarkan']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl_ttd'=>tgl_indo($tgl_dikeluarkan)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ttd_jabatannya'=>$jabatan_ttd), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ttd_nama'=>$model['penandatangan_nama']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ttd_detil'=>$model['penandatangan_pangkat'].' NIP.'.$model['penandatangan_nip']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByHTML('tembusan', 'inline', $tembusan_surat, $arrDocnya);
        
	$docx->createDocx('template/pidsus/Pidsus-6-Umum');
	$file = 'template/pidsus/Pidsus-6-Umum.docx';
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