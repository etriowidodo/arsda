<?php
	use app\modules\pidsus\models\PdsBa16Umum;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../modules/pidsus/template/BA-16-Umum.docx');

	$namaSatker     = Yii::$app->inspektur->getNamaSatker();
	$lokSatker 	= Yii::$app->inspektur->getLokasiSatker()->lokasi;
	$almtSatker     = Yii::$app->inspektur->getLokasiSatker()->alamat;
	$tgl_p8_umum 	= date('d-m-Y',strtotime($model['tgl_p8_umum']));
	$tgl_dikeluarkan= date('d-m-Y',strtotime($model['tgl_dikeluarkan']));
	$tgl_ba16_umum  = date('d-m-Y',strtotime($model['tgl_ba16_umum']));
	$tgl_surat_pn   = date('d-m-Y',strtotime($model['tgl_surat_pn']));
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
	$res1 = PdsBa16Umum::findBySql($sql1)->asArray()->all();
	$jaksa_negara = '<table border="0" width="100%" style="border-collapse:collapse;"><tbody>';
	if(count($res1) > 0){
		$nom1 = 0;
		foreach($res1 as $data1){
			$nom1++;
			$jaksa_negara .= '
				<tr>
					<td style="font-family:Times New Roman; font-size:12pt;" width="4%">'.$nom1.'.</td>
					<td style="font-family:Times New Roman; font-size:12pt;" width="48%">'.$data1['nama_jaksa'].'</td>
					<td style="font-family:Times New Roman; font-size:12pt;" width="48%">'.$data1['pangkatgol'].'</td>
				</tr>
				<tr>
					<td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
					<td style="font-family:Times New Roman; font-size:12pt;">NIP. '.$data1['nip_jaksa'].'</td>
					<td style="font-family:Times New Roman; font-size:12pt;">'.$data1['jabatan_jaksa'].'</td>
				</tr>
				<tr><td colspan="3">&nbsp;</td></tr>
			';
		}
	} else{
		$jaksa_negara .= '
			<tr>
				<td width="18.9%" style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
				<td width="3.1%" style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
				<td width="78%" style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
			</tr>
			<tr><td colspan="3">&nbsp;</td></tr>
		';
	}
	$jaksa_negara .= '</tbody></table>';
        
        $sql2 = "select nama, umur, pekerjaan from pidsus.pds_ba16_umum_saksi 
			where ".$whereDefault." and no_ba16_umum = '".$model['no_ba16_umum']."' and tgl_ba16_umum = '".$model['tgl_ba16_umum']."' order by no_urut_saksi";
	$res2 = PdsBa16Umum::findBySql($sql2)->asArray()->all();
	if(count($res2) > 0){
		$nom2 = 0;
		foreach($res2 as $data2){
			$nom2++;
			$tabel_saksi .= '<span style="font-family:Times New Roman; font-size:12pt;">'.$nom2.'. Nama '.$data2['nama'].' Umur '.$data2['umur'].' Pekerjaan '.$data2['pekerjaan'].'</span><br />';
		}
        }else{
            $tabel_saksi = '<span style="font-family:Times New Roman; font-size:12pt;">-</span><br />';
        }
        
        $sql3 = "select penggeledahan_terhadap,nama,jabatan,tempat_penggeledahan,alamat_penggeledahan from pidsus.pds_b4_umum_pengeledahan 
			where ".$whereDefault." and no_b4_umum = '".$model['no_b4_umum']."' order by no_urut_penggeledahan";
	$res3 = PdsBa16Umum::findBySql($sql3)->asArray()->all();
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
			$tabel_geledah .= '<span style="font-family:Times New Roman; font-size:12pt;">- '.$ygDigeledah.'</span><br />';
                        $nom3 = chr(ord($nom3) + $i);
		}
        }else{
            $tabel_geledah = '<span style="font-family:Times New Roman; font-size:12pt;">-</span><br />';
        }
        
        $sql4 = "select nama_barang_disita from pidsus.pds_b4_umum_penyitaan 
			where ".$whereDefault." and no_b4_umum = '".$model['no_b4_umum']."' order by no_urut_penyitaan";
	$res4 = PdsBa16Umum::findBySql($sql4)->asArray()->all();
	if(count($res4) > 0){
		$i = 1;
                $nom4 = 0;
		foreach($res4 as $data4){
                    $nom4++;
                    $tabel_penyitaan .= '<span style="font-family:Times New Roman; font-size:12pt;">2.'.$nom4.'. '.$data4['nama_barang_disita'].'</span><br />';
                }
        }else{
            $tabel_penyitaan = '<span style="font-family:Times New Roman; font-size:12pt;">-</span><br />';
        }
        
        $sql5 = "(select nama_pemilik from pidsus.pds_b4_umum_penyitaan 
			where ".$whereDefault." and no_b4_umum = '".$model['no_b4_umum']."' order by no_urut_penyitaan)".' union '.
                "(select nama_pemilik from pidsus.pds_b4_umum_pengeledahan 
			where ".$whereDefault." and no_b4_umum = '".$model['no_b4_umum']."' order by no_urut_penggeledahan)";;
	$res5 = PdsBa16Umum::findBySql($sql5)->asArray()->all();
	if(count($res5) > 0){
		$i = 1;
                $nom5 = 0;
		foreach($res5 as $data5){
                    $nom5++;
                    $tabel_pemilik .= '<span style="font-family:Times New Roman; font-size:12pt;">'.$nom5.'. '.$data5['nama_pemilik'].'</span><br />';
                }
        }else{
            $tabel_pemilik = '<span style="font-family:Times New Roman; font-size:12pt;">-</span><br />';
        }
        
        $terbilang=[1=>'satu','dua','tiga','empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan'];
	$docx->replaceVariableByText(array('Kejaksaan'=>strtoupper($namaSatker)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('Hari'=>Yii::$app->globalfunc->GetNamaHari($model['tgl_ba16_umum'])), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_ba16'=>tgl_indo($tgl_ba16_umum)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByHTML('tabel_jaksa', 'block', $jaksa_negara, $arrDocnya);
        $docx->replaceVariableByText(array('kejaksaan1'=> ucwords(strtolower($kejaksaan))), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('no_p8'=>$model['no_p8_umum']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl_p8'=>tgl_indo($tgl_p8_umum)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('surat_pn'=>$model['kepada_b1']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('no_surat_pn'=>$model['no_surat_pn']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl_surat_pn'=>tgl_indo($tgl_surat_pn)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('jml_saksi'=>$nom2.' ('.$terbilang[$nom2].')'), array('parseLineBreaks'=>true));
        $docx->replaceVariableByHTML('tabel_saksi', 'inline', $tabel_saksi, $arrDocnya);
        $docx->replaceVariableByHTML('tabel_penggeledahan', 'inline', $tabel_geledah, $arrDocnya);
        $docx->replaceVariableByHTML('tabel_penyitaan', 'inline', $tabel_penyitaan, $arrDocnya);
        $docx->replaceVariableByHTML('tabel_pemilik', 'inline', $tabel_pemilik, $arrDocnya);
        $docx->replaceVariableByText(array('ttd_nama'=>$model['penandatangan_nama']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ttd_detil'=>$model['penandatangan_pangkat'].' NIP.'.$model['penandatangan_nip']), array('parseLineBreaks'=>true));
        
	$docx->createDocx('template/pidsus/BA-16-Umum');
	$file = 'template/pidsus/BA-16-Umum.docx';
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