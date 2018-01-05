<?php
	use app\modules\pidsus\models\PdsRendak;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../modules/pidsus/template/Rencana-Dakwaan.docx');

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
	
        $sql = "select distinct a.*,b.nama as jkl,c.nama as kwr,d.nama as agama
		from pidsus.pds_terima_berkas_tersangka a 
                left join public.ms_jkl b on a.id_jkl=b.id_jkl
                left join public.ms_warganegara c on a.warganegara=c.id
                left join public.ms_agama d on a.id_agama=d.id_agama
                where ".$whereDefault." and a.no_berkas = '".$model['no_berkas']."' order by a.no_urut";
	$res = PdsRendak::findBySql($sql)->asArray()->all();
        if(count($res)==1)$nama_tersangka =$res[0]['nama'];
        else if(count($res)==2)$nama_tersangka =$res[0]['nama'].' dan '.$res[1]['nama'];
        else if(count($res)>2)$nama_tersangka =$res[0]['nama'].' dkk';
        
	$tersangka = '<table border="0" width="100%" style="border-collapse:collapse;"><tbody>';
	$penahanan = '<table border="0" width="100%" style="border-collapse:collapse;"><tbody>';
	if(count($res) > 0){
		$nom1 = 0;
		foreach($res as $data1){
			$nom1++;
                        $suku=($data1['warganegara']==1)?'Suku '.$data1['suku']:'';
			$tersangka .= '
				<tr>
					<td style="font-family:Times New Roman; font-size:12pt;" width="13.9%">Nama Lengkap</td>
					<td style="font-family:Times New Roman; font-size:12pt;" width="2.9%">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;" width="45%">'.$data1['nama'].'</td>
				</tr>
				<tr>
					<td style="font-family:Times New Roman; font-size:12pt;">Tempat Lahir</td>
					<td style="font-family:Times New Roman; font-size:12pt;">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;">'.$data1['tmpt_lahir'].'</td>
				</tr>
				<tr>
					<td style="font-family:Times New Roman; font-size:12pt;">Umur/Tanggal Lahir</td>
					<td style="font-family:Times New Roman; font-size:12pt;">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;">'.$data1['umur'].' Tahun / '.tgl_indo(date('d-m-Y',strtotime($data1['tgl_lahir']))).'</td>
				</tr>
                                <tr>
					<td style="font-family:Times New Roman; font-size:12pt;">Jenis Kelamin</td>
					<td style="font-family:Times New Roman; font-size:12pt;">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;">'.$data1['jkl'].'</td>
				</tr>
                                <tr>
					<td style="font-family:Times New Roman; font-size:12pt;">Kebangsaan/ Kewarganegaraan</td>
					<td style="font-family:Times New Roman; font-size:12pt;">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;">'.$data1['kwr'].' '.$suku.'</td>
				</tr>
                                <tr>
					<td style="font-family:Times New Roman; font-size:12pt;">Tempat Tinggal</td>
					<td style="font-family:Times New Roman; font-size:12pt;">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;">'.$data1['alamat'].'</td>
				</tr>
                                <tr>
					<td style="font-family:Times New Roman; font-size:12pt;">Agama</td>
					<td style="font-family:Times New Roman; font-size:12pt;">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;">'.ucwords($data1['agama']).'</td>
				</tr>
                                <tr>
					<td style="font-family:Times New Roman; font-size:12pt;">Pekerjaan</td>
					<td style="font-family:Times New Roman; font-size:12pt;">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;">'.$data1['pekerjaan'].'</td>
				</tr>
				<tr><td colspan="3">&nbsp;</td></tr>
			';
                        
                        $penahanan .= '
				<tr>
					<td style="font-family:Times New Roman; font-size:12pt;"colspan="4" >Penahanan : '.$data1['nama'].'</td>
				</tr>
				<tr>
                                        <td style="font-family:Times New Roman; font-size:12pt;" width="4%">1.</td>
					<td style="font-family:Times New Roman; font-size:12pt;" width="25%">Rutan sejak</td>
					<td style="font-family:Times New Roman; font-size:12pt;" width="2.9%">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;" width="60%"></td>
				</tr>
				<tr>
					<td style="font-family:Times New Roman; font-size:12pt;">2.</td>
                                        <td style="font-family:Times New Roman; font-size:12pt;">Rumah sejak</td>
					<td style="font-family:Times New Roman; font-size:12pt;">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;"></td>
				</tr>
                                <tr>
                                        <td style="font-family:Times New Roman; font-size:12pt;">3.</td>
					<td style="font-family:Times New Roman; font-size:12pt;">Kota</td>
					<td style="font-family:Times New Roman; font-size:12pt;">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;"></td>
				</tr>
                                <tr>
                                        <td style="font-family:Times New Roman; font-size:12pt;">4.</td>
					<td style="font-family:Times New Roman; font-size:12pt;">Perpanjangan penahanan oleh / tanggal</td>
					<td style="font-family:Times New Roman; font-size:12pt;">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;"></td>
				</tr>
                                <tr>
                                        <td style="font-family:Times New Roman; font-size:12pt;">5.</td>
					<td style="font-family:Times New Roman; font-size:12pt;">Pengalihan jenis penahanan oleh/tanggal</td>
					<td style="font-family:Times New Roman; font-size:12pt;">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;"></td>
				</tr>
                                <tr>
                                        <td style="font-family:Times New Roman; font-size:12pt;">6.</td>
					<td style="font-family:Times New Roman; font-size:12pt;">Penangguhan penahanan tanggal</td>
					<td style="font-family:Times New Roman; font-size:12pt;">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;"></td>
				</tr>
                                <tr>
                                        <td style="font-family:Times New Roman; font-size:12pt;">7.</td>
					<td style="font-family:Times New Roman; font-size:12pt;">Pencabutan penangguhan penahanan oleh/tanggal</td>
					<td style="font-family:Times New Roman; font-size:12pt;">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;"></td>
				</tr>
                                <tr>
                                        <td style="font-family:Times New Roman; font-size:12pt;">8.</td>
					<td style="font-family:Times New Roman; font-size:12pt;">Dikeluarkan dari tahanan oleh/tanggal</td>
					<td style="font-family:Times New Roman; font-size:12pt;">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;"></td>
				</tr>
				<tr><td colspan="3">&nbsp;</td></tr>
			';
		}
	} else{
		$tersangka .= '
			<tr><td colspan="3">&nbsp;</td></tr>
		';
	}
	$tersangka .= '</tbody></table>';
	$penahanan .= '</tbody></table>';
        
	$sqla = "select distinct a.no_urut, a.undang, a.pasal
		from pidsus.pds_terima_berkas_pengantar_uu a where ".$whereDefault." and a.no_berkas = '".$model['no_berkas']."' and a.no_pengantar = '".$model['no_pengantar']."' order by a.no_urut";
	$resa = PdsRendak::findBySql($sqla)->asArray()->all();
        $dft_pasal     = Yii::$app->inspektur->getGeneratePasalUU($resa);
//        if(count($resa) > 0){
//		foreach($resa as $data2){
//			$dft_pasal .= $data2['pasal'] . ' ' . $data2['undang'] . ', ';
//		}
//                $dft_pasal = preg_replace("/, $/", "", $dft_pasal);
//        }else{
//            $dft_pasal = '';
//        }

	$sql2 = "select a.no_urut as no_urut, a.tembusan as tembusan from pidsus.pds_rendak_tembusan a
		where ".$whereDefault." and a.no_berkas = '".$model['no_berkas']."' order by a.no_urut";
	$res2 = PdsRendak::findBySql($sql2)->asArray()->all();
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
        $docx->replaceVariableByHTML('tersangka', 'block', $tersangka, $arrDocnya);
        $docx->replaceVariableByHTML('dakwaan', 'inline', $model['dakwaan'], $arrDocnya);
        $docx->replaceVariableByHTML('penahanan', 'block', $penahanan, $arrDocnya);
        $docx->replaceVariableByText(array('pasal'=>$dft_pasal), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('dikeluarkan'=>$model['dikeluarkan']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl_dikeluarkan'=>tgl_indo($tgl_ttd)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nama_jpu'=>$model['penandatangan_nama']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('ttd_detil'=>$model['penandatangan_pangkat'].' NIP.'.$model['penandatangan_nip']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByHTML('tembusan', 'inline', $tembusan_surat, $arrDocnya);

	$docx->createDocx('template/pidsus/Rencana-Dakwaan');
	$file = 'template/pidsus/Rencana-Dakwaan.docx';
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