<?php
	use app\modules\pidsus\models\PdsPidsus18;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../modules/pidsus/template/Pidsus-18.docx');

	$namaSatker     = Yii::$app->inspektur->getNamaSatker();
	$lokSatker 	= Yii::$app->inspektur->getLokasiSatker()->lokasi;
	$almtSatker     = Yii::$app->inspektur->getLokasiSatker()->alamat;
	$tgl_p8_umum 	= date('d-m-Y',strtotime($model['tgl_p8_umum']));
	$tgl_dikeluarkan= date('d-m-Y',strtotime($model['tgl_pidsus18']));
        $id_kejati	= $_SESSION['kode_kejati'];
        $id_kejari	= $_SESSION['kode_kejari'];
        $id_cabjari	= $_SESSION['kode_cabjari'];
        
        $kejaksaan      = ($id_kejati.$id_kejari.$id_cabjari=="000000")?'DIREKTUR PENYIDIKAN JAKSA AGUNG MUDA TINDAK PIDANA KHUSUS':'KEPALA '.strtoupper($namaSatker);
        
        $whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."'";
        
        if(strtoupper($model['penandatangan_status_ttd']) == 'ASLI')
		$jabatan_ttd = $model['penandatangan_jabatan_ttd'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'A.N')
		$jabatan_ttd = "An. ".$model['penandatangan_jabatan_ttd']."\n".$model['penandatangan_jabatan_pejabat'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'PLT')
		$jabatan_ttd = "Plt. ".$model['penandatangan_jabatan_ttd'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'PLH')
		$jabatan_ttd = "Plh. ".$model['penandatangan_jabatan_ttd'];
        
        $sql1 = "select a.*, b.nama as jkl, c.nama as kwr, d.nama as agama, e.nama as pendidikan
                from pidsus.pds_pidsus18_tersangka a 
                left join public.ms_jkl b on a.id_jkl=b.id_jkl
                left join public.ms_warganegara c on a.warganegara=c.id
                left join public.ms_agama d on a.id_agama=d.id_agama
                left join public.ms_pendidikan e on a.id_pendidikan=e.id_pendidikan
                where ".$whereDefault." and no_pidsus18 = '".$model['no_pidsus18']."' order by no_urut_tersangka";
	$res1 = PdsPidsus18::findBySql($sql1)->asArray()->all();
        
        $sqlPasal = "Select * from pidsus.pds_pidsus18_uu_pasal where ".$whereDefault." and no_pidsus18 = '".$model['no_pidsus18']."'";
        $resPasal = PdsPidsus18::findBySql($sqlPasal)->asArray()->all();
        $pasal = Yii::$app->inspektur->getGeneratePasalUU($resPasal);
        
	$tersangka = '<table border="0" width="100%" style="border-collapse:collapse;"><tbody>'
                        . '<tr>
                                <td style="font-family:Times New Roman; font-size:12pt;" width="18.9%">Menetapkan</td>
                                <td style="font-family:Times New Roman; font-size:12pt;" width="3.1%">:</td>
                                <td style="font-family:Times New Roman; font-size:12pt;" width="5.9%" colspan="4">Seseorang dengan identitas berikut ini :</td>
                                
                        </tr>';
	if(count($res1) > 0){
		$nom1 = 0;
		foreach($res1 as $data1){
			$nom1++;
			$tersangka .= '
				<tr>
					<td style="font-family:Times New Roman; font-size:12pt;"></td>
					<td style="font-family:Times New Roman; font-size:12pt;"></td>
					<td style="font-family:Times New Roman; font-size:12pt;">-</td>
					<td style="font-family:Times New Roman; font-size:12pt;" width="11.9%">Nama lengkap</td>
					<td style="font-family:Times New Roman; font-size:12pt;" width="2.9%">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;" width="57.3%">'.$data1['nama'].'</td>
				</tr>
				<tr>
					<td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
					<td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
					<td style="font-family:Times New Roman; font-size:12pt;">-</td>
					<td style="font-family:Times New Roman; font-size:12pt;">Tempat lahir</td>
					<td style="font-family:Times New Roman; font-size:12pt;">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;">'.$data1['tmpt_lahir'].'</td>
				</tr>
				<tr>
					<td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
					<td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
					<td style="font-family:Times New Roman; font-size:12pt;">-</td>
					<td style="font-family:Times New Roman; font-size:12pt;">Umur / Tanggal lahir</td>
					<td style="font-family:Times New Roman; font-size:12pt;">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;">'.$data1['umur'].' / '.tgl_indo(date('d-m-Y',strtotime($data1['tgl_lahir']))).'</td>
				</tr>
                                <tr>
					<td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
					<td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
					<td style="font-family:Times New Roman; font-size:12pt;">-</td>
					<td style="font-family:Times New Roman; font-size:12pt;">Jenis kelamin</td>
					<td style="font-family:Times New Roman; font-size:12pt;">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;">'.$data1['jkl'].'</td>
				</tr>
                                <tr>
					<td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
					<td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
					<td style="font-family:Times New Roman; font-size:12pt;">-</td>
					<td style="font-family:Times New Roman; font-size:12pt;">Kebangsaan/Kewarganegaraan</td>
					<td style="font-family:Times New Roman; font-size:12pt;">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;">'.$data1['kwr'].'</td>
				</tr>
                                <tr>
					<td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
					<td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
					<td style="font-family:Times New Roman; font-size:12pt;">-</td>
					<td style="font-family:Times New Roman; font-size:12pt;">Tempat tinggal</td>
					<td style="font-family:Times New Roman; font-size:12pt;">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;">'.$data1['alamat'].'</td>
				</tr>
                                <tr>
					<td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
					<td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
					<td style="font-family:Times New Roman; font-size:12pt;">-</td>
					<td style="font-family:Times New Roman; font-size:12pt;">Agama</td>
					<td style="font-family:Times New Roman; font-size:12pt;">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;">'.$data1['agama'].'</td>
				</tr>
                                <tr>
					<td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
					<td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
					<td style="font-family:Times New Roman; font-size:12pt;">-</td>
					<td style="font-family:Times New Roman; font-size:12pt;">Pekerjaan</td>
					<td style="font-family:Times New Roman; font-size:12pt;">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;">'.$data1['pekerjaan'].'</td>
				</tr>
				<tr>
					<td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
					<td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
					<td style="font-family:Times New Roman; font-size:12pt;">-</td>
					<td style="font-family:Times New Roman; font-size:12pt;">Pendidikan</td>
					<td style="font-family:Times New Roman; font-size:12pt;">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;">'.$data1['pendidikan'].'</td>
				</tr>
			';
                       
		}
                $tersangka .='<tr>
                                        <td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
                                        <td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
                                        <td style="font-family:Times New Roman; font-size:12pt;" colspan="4">Sebagai tersangka dalam perkara dugaan tindak pidana '.$model['tindak_pidana'].
                                        ' dengan sangkaan '.$pasal.'</td>
                                    </tr><tr><td colspan="6">&nbsp;</td></tr>'; 
	} else{
		$tersangka .= '
			<tr>
				<td width="18.9%" style="font-family:Times New Roman; font-size:12pt;">Menetapkan</td>
				<td width="3.1%" style="font-family:Times New Roman; font-size:12pt;">:</td>
				<td width="78%" style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
			</tr>
			<tr><td colspan="3">&nbsp;</td></tr>
		';
	}
	$tersangka .= '</tbody></table>';
        
        $sql2 = "select no_urut, tembusan as tembusan from pidsus.pds_pidsus18_tembusan 
			where ".$whereDefault."and no_pidsus18 = '".$model['no_pidsus18']."' order by no_urut";
	$res2 = PdsPidsus18::findBySql($sql2)->asArray()->all();
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
        $docx->replaceVariableByText(array('kejaksaan1'=> $kejaksaan), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('kejaksaan2'=> ucwords(strtolower($kejaksaan))), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('nomor_print'=>$model['no_pidsus18']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('no_p8'=>$model['no_p8_umum']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl_p8'=> tgl_indo($tgl_p8_umum)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tindak_pidana'=>$model['laporan_pidana']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByHTML('tersangka', 'block', $tersangka, $arrDocnya);
        $docx->replaceVariableByText(array('lokasi_keluar'=>$model['tempat_dikeluarkan']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl_ttd'=>tgl_indo($tgl_dikeluarkan)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ttd_jabatannya'=>$jabatan_ttd), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ttd_nama'=>$model['penandatangan_nama']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ttd_detil'=>$model['penandatangan_pangkat'].' NIP.'.$model['penandatangan_nip']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByHTML('tembusan', 'inline', $tembusan_surat, $arrDocnya);
        
	$docx->createDocx('template/pidsus/Pidsus-18');
	$file = 'template/pidsus/Pidsus-18.docx';
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