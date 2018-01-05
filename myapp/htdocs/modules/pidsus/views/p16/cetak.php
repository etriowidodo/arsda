<?php
	use app\modules\datun\models\Sp1;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../modules/pidsus/template/P-16.docx');

	$namaSatker     = Yii::$app->inspektur->getNamaSatker();
	$lokSatker 	= Yii::$app->inspektur->getLokasiSatker()->lokasi;
	$almtSatker     = Yii::$app->inspektur->getLokasiSatker()->alamat;
	$tgl_spdp       = date('d-m-Y',strtotime($model['tgl_spdp']));
	$tgl_ttd 	= date('d-m-Y',strtotime($model['tgl_dikeluarkan']));
        $whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' and no_spdp = '".$_SESSION["no_spdp"]."' and tgl_spdp = '".$_SESSION["tgl_spdp"]."'";
        
	if(strtoupper($model['penandatangan_status_ttd']) == 'ASLI')
		$jabatan_ttd = $model['penandatangan_jabatan_ttd'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'A.N')
		$jabatan_ttd = "An. ".$model['penandatangan_jabatan_ttd']."\n".$model['penandatangan_jabatan_pejabat'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'PLT')
		$jabatan_ttd = "Plt. ".$model['penandatangan_jabatan_ttd'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'PLH')
		$jabatan_ttd = "Plh. ".$model['penandatangan_jabatan_ttd'];
	
        $sql = "select a.*,b.nama as jkl,c.nama as kwr,d.nama as agama from pidsus.pds_spdp_tersangka a "
                . "left join public.ms_jkl b on a.id_jkl=b.id_jkl "
                . "left join public.ms_warganegara c on a.warganegara=c.id "
                . "left join public.ms_agama d on a.id_agama=d.id_agama "
                . " where ".$whereDefault;
	$res = Sp1::findBySql($sql)->asArray()->all();
        if(count($res)==1)$nama_tersangka =$res[0]['nama'];
        else if(count($res)==2)$nama_tersangka =$res[0]['nama'].' dan '.$res[1]['nama'];
        else if(count($res)>2)$nama_tersangka =$res[0]['nama'].' dkk';
        
	$tersangka = '<table border="0" width="100%" style="border-collapse:collapse;"><tbody>';
	if(count($res) > 0){
		$nom1 = 0;
		foreach($res as $data1){
			$nom1++;
                        $suku=($data1['warganegara']==1)?'Suku '.$data1['suku']:'';
			$tersangka .= '
				<tr>
					<td style="font-family:Times New Roman; font-size:12pt;" width="25.3%"></td>
					<td style="font-family:Times New Roman; font-size:12pt;" width="20.9%">Nama Lengkap</td>
					<td style="font-family:Times New Roman; font-size:12pt;" width="2.9%">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;" width="45%">'.$data1['nama'].'</td>
				</tr>
				<tr>
					<td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
					<td style="font-family:Times New Roman; font-size:12pt;">Tempat Lahir</td>
					<td style="font-family:Times New Roman; font-size:12pt;">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;">'.$data1['tmpt_lahir'].'</td>
				</tr>
				<tr>
					<td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
					<td style="font-family:Times New Roman; font-size:12pt;">Umur/Tanggal Lahir</td>
					<td style="font-family:Times New Roman; font-size:12pt;">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;">'.$data1['umur'].' Tahun / '.tgl_indo(date('d-m-Y',strtotime($data1['tgl_lahir']))).'</td>
				</tr>
                                <tr>
					<td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
					<td style="font-family:Times New Roman; font-size:12pt;">Jenis Kelamin</td>
					<td style="font-family:Times New Roman; font-size:12pt;">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;">'.$data1['jkl'].'</td>
				</tr>
                                <tr>
					<td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
					<td style="font-family:Times New Roman; font-size:12pt;">Kebangsaan/Kewarganegaraan</td>
					<td style="font-family:Times New Roman; font-size:12pt;">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;">'.$data1['kwr'].' '.$suku.'</td>
				</tr>
                                <tr>
					<td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
					<td style="font-family:Times New Roman; font-size:12pt;">Tempat Tinggal</td>
					<td style="font-family:Times New Roman; font-size:12pt;">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;">'.$data1['alamat'].'</td>
				</tr>
                                <tr>
					<td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
					<td style="font-family:Times New Roman; font-size:12pt;">Agama</td>
					<td style="font-family:Times New Roman; font-size:12pt;">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;">'.ucwords($data1['agama']).'</td>
				</tr>
                                <tr>
					<td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
					<td style="font-family:Times New Roman; font-size:12pt;">Pekerjaan</td>
					<td style="font-family:Times New Roman; font-size:12pt;">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;">'.$data1['pekerjaan'].'</td>
				</tr>
				<tr><td colspan="6">&nbsp;</td></tr>
			';
		}
	} else{
		$tersangka .= '
			<tr>
				<td width="18.9%" style="font-family:Times New Roman; font-size:12pt;">Kepada</td>
				<td width="3.1%" style="font-family:Times New Roman; font-size:12pt;">:</td>
				<td width="78%" style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
			</tr>
			<tr><td colspan="3">&nbsp;</td></tr>
		';
	}
	$tersangka .= '</tbody></table>';
        
	$sql1 = "select nip, nama, gol_jaksa, pangkat_jaksa, jabatan_jaksa, pangkat_jaksa||' ('||gol_jaksa||')' as pangkatgol   
			from pidsus.pds_p16_jaksa where ".$whereDefault." and no_p16 = '".$model['no_p16']."'";
	$res1 = Sp1::findBySql($sql1)->asArray()->all();
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
					<td style="font-family:Times New Roman; font-size:12pt;" width="57.3%">'.$data1['nama'].'</td>
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
					<td style="font-family:Times New Roman; font-size:12pt;">Kantor Pengacara Negara</td>
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

	$sql2 = "select no_urut, deskripsi_tembusan as tembusan from pidsus.pds_p16_tembusan 
			where ".$whereDefault." and no_p16 = '".$model['no_p16']."'";
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

	$docx->replaceVariableByText(array('alamat_kejaksaan'=>$almtSatker), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nama_kejaksaan'=>strtoupper($namaSatker)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nomor_print'=>$model['no_p16']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('pasal'=>$model['undang_pasal']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('Kejaksaan_lower'=>ucwords($namaSatker)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_spdp'=>tgl_indo($tgl_spdp)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('asal_penyidik'=>$model['asal_penyidik']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByHTML('detil_tersangka', 'block', $tersangka, $arrDocnya);
	$docx->replaceVariableByText(array('tersangka'=>$nama_tersangka), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('lokasi_keluar'=>$lokSatker), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_ttd'=>tgl_indo($tgl_ttd)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('ttd_jabatannya'=>$jabatan_ttd), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('ttd_nama'=>$model['penandatangan_nama']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('ttd_detil'=>$model['penandatangan_pangkat'].' NIP.'.$model['penandatangan_nip']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByHTML('timJPN', 'block', $jaksa_negara, $arrDocnya);
	$docx->replaceVariableByHTML('tembusan', 'inline', $tembusan_surat, $arrDocnya);

	$docx->createDocx('template/pidsus/P-16');
	$file = 'template/pidsus/P-16.docx';
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