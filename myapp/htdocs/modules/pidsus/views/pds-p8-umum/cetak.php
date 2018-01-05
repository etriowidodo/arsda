<?php
	use app\modules\pidsus\models\PdsP8Umum;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../modules/pidsus/template/P-8-Umum.docx');

	$namaSatker     = Yii::$app->inspektur->getNamaSatker();
	$lokSatker 	= Yii::$app->inspektur->getLokasiSatker()->lokasi;
	$almtSatker     = Yii::$app->inspektur->getLokasiSatker()->alamat;
	$tgl_p6 	= date('d-m-Y',strtotime($model['tgl_p6']));
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
        
        $sql1 = "select jabatan_p8,nip_jaksa, nama_jaksa, gol_jaksa, pangkat_jaksa, jabatan_jaksa, pangkat_jaksa||' ('||gol_jaksa||')' as pangkatgol   
			from pidsus.pds_p8_umum_jaksa where ".$whereDefault.' order by jabatan_p8';
	$res1 = PdsP8Umum::findBySql($sql1)->asArray()->all();
	$jaksa_negara = '<table border="0" width="100%" style="border-collapse:collapse;"><tbody>';
        $jaksa_negara .='<tr>
					<td style="font-family:Times New Roman; font-size:12pt;" width="18%">Kepada</td>
					<td style="font-family:Times New Roman; font-size:12pt;" >:</td>
					<td style="font-family:Times New Roman; font-size:12pt;" colspan="3">Jaksa Penyidik</td>
					<td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
					<td style="font-family:Times New Roman; font-size:12pt;"></td>
				</tr>';
        $jabatanp8 = array(1=>'Koordinator', 'Ketua Tim', 'Wakil Ketua', 'Sekretaris', 'Anggota');
        $romawi = array(1=>'I','II','III','IV','V','VI','VII','VIII','IX','X');
	if(count($res1) > 0){
		$nom1 = 0;
                $nom2 = 0;
		foreach($res1 as $data1){
			$nom1++;
                        if($data1['jabatan_p8']<5){
                            $jaksa_negara .= '
                                    <tr>
                                            <td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
                                            <td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
                                            <td style="font-family:Times New Roman; font-size:12pt;">'.$romawi[$nom1].'.</td>
                                            <td style="font-family:Times New Roman; font-size:12pt;" width="20%"colspan="2">'.$jabatanp8[$data1['jabatan_p8']].'</td>
                                            <td style="font-family:Times New Roman; font-size:12pt;" width="1%">:</td>
                                            <td style="font-family:Times New Roman; font-size:12pt;" colspan="2"></td>
                                    </tr>
                                    <tr>
                                            <td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
                                            <td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
                                            <td style="font-family:Times New Roman; font-size:12pt;"></td>
                                            <td style="font-family:Times New Roman; font-size:12pt;"colspan="2">Nama</td>
                                            <td style="font-family:Times New Roman; font-size:12pt;">:</td>
                                            <td style="font-family:Times New Roman; font-size:12pt;" colspan="2">'.$data1['nama_jaksa'].'</td>
                                    </tr>
                                    <tr>
                                            <td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
                                            <td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
                                            <td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
                                            <td style="font-family:Times New Roman; font-size:12pt;"colspan="2">Pangkat/Nip.</td>
                                            <td style="font-family:Times New Roman; font-size:12pt;">:</td>
                                            <td style="font-family:Times New Roman; font-size:12pt;" colspan="2">'.$data1['pangkatgol'].' / '.$data1['nip_jaksa'].'</td>
                                    </tr>
                                    <tr>
                                            <td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
                                            <td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
                                            <td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
                                            <td style="font-family:Times New Roman; font-size:12pt;"colspan="2">Jabatan</td>
                                            <td style="font-family:Times New Roman; font-size:12pt;">:</td>
                                            <td style="font-family:Times New Roman; font-size:12pt;" colspan="2">'. ucwords(strtolower($data1['jabatan_jaksa'])).'</td>
                                    </tr>
                            ';
                        }else{
                            $nom2++;
                            $jaksa_negara .=
                                    ($nom2 == 1?'<tr>
                                            <td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
                                            <td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
                                            <td style="font-family:Times New Roman; font-size:12pt;">'.$romawi[$nom1].'.</td>
                                            <td style="font-family:Times New Roman; font-size:12pt;" width="20%"colspan="2">'.$jabatanp8[$data1['jabatan_p8']].'</td>
                                            <td style="font-family:Times New Roman; font-size:12pt;" width="1%">:</td>
                                            <td style="font-family:Times New Roman; font-size:12pt;" colspan="2"></td>
                                    </tr>':'').'
                                    <tr>
                                            <td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
                                            <td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
                                            <td style="font-family:Times New Roman; font-size:12pt;"></td>
                                            <td style="font-family:Times New Roman; font-size:12pt;" width="1%">'.$nom2.'.</td>
                                            <td style="font-family:Times New Roman; font-size:12pt;">Nama</td>
                                            <td style="font-family:Times New Roman; font-size:12pt;" width="1%">:</td>
                                            <td style="font-family:Times New Roman; font-size:12pt;">'.$data1['nama_jaksa'].'</td>
                                    </tr>
                                    <tr>
                                            <td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
                                            <td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
                                            <td style="font-family:Times New Roman; font-size:12pt;"></td>
                                            <td style="font-family:Times New Roman; font-size:12pt;" width="1%"></td>
                                            <td style="font-family:Times New Roman; font-size:12pt;">Pangkat/Nip.</td>
                                            <td style="font-family:Times New Roman; font-size:12pt;" width="1%">:</td>
                                            <td style="font-family:Times New Roman; font-size:12pt;">'.$data1['pangkatgol'].' / '.$data1['nip_jaksa'].'</td>
                                    </tr>
                                    <tr>
                                            <td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
                                            <td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
                                            <td style="font-family:Times New Roman; font-size:12pt;"></td>
                                            <td style="font-family:Times New Roman; font-size:12pt;" width="1%"></td>
                                            <td style="font-family:Times New Roman; font-size:12pt;">Jabatan</td>
                                            <td style="font-family:Times New Roman; font-size:12pt;" width="1%">:</td>
                                            <td style="font-family:Times New Roman; font-size:12pt;">'. ucwords(strtolower($data1['jabatan_jaksa'])).'</td>
                                    </tr>
                                   ';
                        }
			
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
        
        $sql2 = "select no_urut, tembusan as tembusan from pidsus.pds_p8_umum_tembusan 
			where ".$whereDefault;
	$res2 = PdsP8Umum::findBySql($sql2)->asArray()->all();
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
        $docx->replaceVariableByText(array('pertimbangan1'=>$pertimbangan1), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl_p6'=>tgl_indo($tgl_p6)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nomor_print'=>$model['no_p8_umum']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tindak_pidana'=>$model['laporan_pidana']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByHTML('timJPN', 'block', $jaksa_negara, $arrDocnya);
        $docx->replaceVariableByText(array('tersangka'=>''), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tabel_tersangka'=>''), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tahun'=>date('Y')), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ttd_jabatannya'=>$jabatan_ttd), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('lokasi_keluar'=>$lokSatker), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl_ttd'=>tgl_indo($tgl_p8_umum)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ttd_nama'=>$model['penandatangan_nama']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ttd_detil'=>$model['penandatangan_pangkat'].' NIP.'.$model['penandatangan_nip']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByHTML('tembusan', 'inline', $tembusan_surat, $arrDocnya);
        
	$docx->createDocx('template/pidsus/P-8-Umum');
	$file = 'template/pidsus/P-8-Umum.docx';
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