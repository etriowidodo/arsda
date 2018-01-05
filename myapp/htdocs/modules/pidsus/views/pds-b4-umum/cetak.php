<?php
	use app\modules\pidsus\models\PdsB4Umum;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../modules/pidsus/template/B-4-Umum.docx');

	$namaSatker     = Yii::$app->inspektur->getNamaSatker();
	$lokSatker 	= Yii::$app->inspektur->getLokasiSatker()->lokasi;
	$almtSatker     = Yii::$app->inspektur->getLokasiSatker()->alamat;
	$tgl_p8_umum 	= date('d-m-Y',strtotime($model['tgl_p8_umum']));
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
			from pidsus.pds_b4_umum_jaksa where ".$whereDefault." and no_b4_umum = '".$model['no_b4_umum']."' order by no_urut";
	$res1 = PdsB4Umum::findBySql($sql1)->asArray()->all();
	$jaksa_negara = '<table border="0" width="100%" style="border-collapse:collapse;"><tbody>';
	if(count($res1) > 0){
		$nom1 = 0;
		foreach($res1 as $data1){
			$nom1++;
			$jaksa_negara .= '
				<tr>
					<td style="font-family:Times New Roman; font-size:12pt;" width="17.3%">'.($nom1 == 1?'Kepada':'&nbsp;').'</td>
					<td style="font-family:Times New Roman; font-size:12pt;" width="3.1%">'.($nom1 == 1?':':'&nbsp;').'</td>
					<td style="font-family:Times New Roman; font-size:12pt;" width="4.5%">'.$nom1.'.</td>
					<td style="font-family:Times New Roman; font-size:12pt;" width="9.9%">Nama</td>
					<td style="font-family:Times New Roman; font-size:12pt;" width="2.9%">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;" width="62.3%">'.$data1['nama_jaksa'].'</td>
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
					<td style="font-family:Times New Roman; font-size:12pt;">NIP</td>
					<td style="font-family:Times New Roman; font-size:12pt;">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;">'.$data1['nip_jaksa'].'</td>
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
        
        $sql2 = "select no_urut, tembusan as tembusan from pidsus.pds_b4_umum_tembusan 
			where ".$whereDefault." and no_b4_umum = '".$model['no_b4_umum']."' order by no_urut";
	$res2 = PdsB4Umum::findBySql($sql2)->asArray()->all();
	if(count($res2) > 0){
		$nom2 = 0;
		foreach($res2 as $data2){
			$nom2++;
			$tembusan_surat .= '<span style="font-family:Times New Roman; font-size:12pt;">'.$nom2.'. '.$data2['tembusan'].'</span><br />';
		}
        }else{
            $tembusan_surat = '<span style="font-family:Times New Roman; font-size:12pt;">-</span><br />';
        }
        
        $sql3 = "select penggeledahan_terhadap,nama,jabatan,tempat_penggeledahan,alamat_penggeledahan from pidsus.pds_b4_umum_pengeledahan 
			where ".$whereDefault." and no_b4_umum = '".$model['no_b4_umum']."' order by no_urut_penggeledahan";
	$res3 = PdsB4Umum::findBySql($sql3)->asArray()->all();
	if(count($res3) > 0){
		$i = 0;
                $nom3 = 'a';
		foreach($res3 as $data3){
			$i++;
                        if($data3['penggeledahan_terhadap'] == 'Subyek'){
                                $ygDigeledah = $data3['nama'].' '.$data3['jabatan'];
                        } else if($data3['penggeledahan_terhadap'] == 'Obyek'){
                                $ygDigeledah = $data3['tempat_penggeledahan'].' '.$data3['alamat_penggeledahan'];
                        }
			$tabel_geledah .= '<span style="font-family:Times New Roman; font-size:12pt;">'.$nom3.'. '.$ygDigeledah.'</span><br />';
                        $nom3 = chr(ord($nom3) + $i);
		}
        }else{
            $tabel_geledah = '<span style="font-family:Times New Roman; font-size:12pt;">-</span><br />';
        }
        
        $sql4 = "select nama_barang_disita from pidsus.pds_b4_umum_penyitaan 
			where ".$whereDefault." and no_b4_umum = '".$model['no_b4_umum']."' order by no_urut_penyitaan";
	$res4 = PdsB4Umum::findBySql($sql4)->asArray()->all();
	if(count($res4) > 0){
		$i = 1;
                $nom4 = 'a';
		foreach($res4 as $data4){
			$tabel_penyitaan .= '<span style="font-family:Times New Roman; font-size:12pt;">'.$nom4.'. '.$data4['nama_barang_disita'].'</span><br />';
                        $nom4 = chr(ord($nom4) + $i);
                        $i++;
		}
                $nom4 = chr(ord($nom4) - 1);
                $tabel_penyitaan .= '<span style="font-family:Times New Roman; font-size:12pt;">'.$nom4.'. Dan barang-barang lain yang dianggap perlu.</span><br />';
        }else{
            $tabel_penyitaan = '<span style="font-family:Times New Roman; font-size:12pt;">-</span><br />';
        }
        
	$docx->replaceVariableByText(array('nama_kejaksaan'=>strtoupper($namaSatker)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nomor_print'=>$model['no_b4_umum']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('kejaksaan1'=>$kejaksaan), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('kejaksaan2'=> ucwords(strtolower($kejaksaan))), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tindak_pidana'=>$model['laporan_pidana']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('no_p8'=>$model['no_p8_umum']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_p8'=>tgl_indo($tgl_p8_umum)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByHTML('timJPN', 'block', $jaksa_negara, $arrDocnya);
        $docx->replaceVariableByHTML('tembusan', 'inline', $tembusan_surat, $arrDocnya);
        $docx->replaceVariableByHTML('tabel_geledah', 'inline', $tabel_geledah, $arrDocnya);
        $docx->replaceVariableByHTML('tabel_penyitaan', 'inline', $tabel_penyitaan, $arrDocnya);
        $docx->replaceVariableByText(array('ttd_jabatannya'=>$jabatan_ttd), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('lokasi_keluar'=>$lokSatker), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl_ttd'=>tgl_indo($tgl_p8_umum)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ttd_nama'=>$model['penandatangan_nama']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ttd_detil'=>$model['penandatangan_pangkat'].' NIP.'.$model['penandatangan_nip']), array('parseLineBreaks'=>true));
        
        
	$docx->createDocx('template/pidsus/B-4-Umum');
	$file = 'template/pidsus/B-4-Umum.docx';
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