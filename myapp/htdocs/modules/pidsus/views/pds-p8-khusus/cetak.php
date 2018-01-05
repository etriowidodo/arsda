<?php
	use app\modules\pidsus\models\PdsP8Khusus;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../modules/pidsus/template/P-8-Khusus.docx');

	$namaSatker     = Yii::$app->inspektur->getNamaSatker();
	$lokSatker 	= Yii::$app->inspektur->getLokasiSatker()->lokasi;
	$almtSatker     = Yii::$app->inspektur->getLokasiSatker()->alamat;
	$tgl_p8_umum 	= date('d-m-Y',strtotime($model['tgl_p8_umum']));
	$tgl_p8_khusus 	= date('d-m-Y',strtotime($model['tgl_p8_khusus']));
        $id_kejati	= $_SESSION['kode_kejati'];
        $id_kejari	= $_SESSION['kode_kejari'];
        $id_cabjari	= $_SESSION['kode_cabjari'];
        
        $kejaksaan      = ($id_kejati.$id_kejari.$id_cabjari=="000000")?'DIREKTUR PENYIDIKAN JAKSA AGUNG MUDA TINDAK PIDANA KHUSUS':'KEPALA '.strtoupper($namaSatker);
        
        $whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' and no_pidsus18 = '".$_SESSION["pidsus_no_pidsus18"]."' and no_p8_khusus = '".$model["no_p8_khusus"]."'";
        
        if(strtoupper($model['penandatangan_status_ttd']) == 'ASLI')
		$jabatan_ttd = $model['penandatangan_jabatan_ttd'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'A.N')
		$jabatan_ttd = "An. ".$model['penandatangan_jabatan_ttd']."\n".$model['penandatangan_jabatan_pejabat'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'PLT')
		$jabatan_ttd = "Plt. ".$model['penandatangan_jabatan_ttd'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'PLH')
		$jabatan_ttd = "Plh. ".$model['penandatangan_jabatan_ttd'];
        
        $sql1 = "select jabatan_p8,nip_jaksa, nama_jaksa, gol_jaksa, pangkat_jaksa, jabatan_jaksa, pangkat_jaksa||' ('||gol_jaksa||')' as pangkatgol   
			from pidsus.pds_p8_khusus_jaksa where ".$whereDefault.' order by jabatan_p8';
	$res1 = PdsP8Khusus::findBySql($sql1)->asArray()->all();
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
        
        $sql2 = "select no_urut, tembusan as tembusan from pidsus.pds_p8_khusus_tembusan 
			where ".$whereDefault;
	$res2 = PdsP8Khusus::findBySql($sql2)->asArray()->all();
	if(count($res2) > 0){
		$nom2 = 0;
		foreach($res2 as $data2){
			$nom2++;
			$tembusan_surat .= '<span style="font-family:Times New Roman; font-size:12pt;">'.$nom2.'. '.$data2['tembusan'].'</span><br />';
		}
        }else{
            $tembusan_surat = '<span style="font-family:Times New Roman; font-size:12pt;">-</span><br />';
        }
        
        $sql = "select a.*,b.nama as jkl,c.nama as kwr,d.nama as agama from pidsus.pds_pidsus18_tersangka a "
                . "left join public.ms_jkl b on a.id_jkl=b.id_jkl "
                . "left join public.ms_warganegara c on a.warganegara=c.id "
                . "left join public.ms_agama d on a.id_agama=d.id_agama "
                . " where id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' and no_pidsus18 = '".$_SESSION["pidsus_no_pidsus18"]."'";
	$res = PdsP8Khusus::findBySql($sql)->asArray()->all();
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
					<td style="font-family:Times New Roman; font-size:12pt;" width="10%">Nama Lengkap</td>
					<td style="font-family:Times New Roman; font-size:12pt;" width="2%">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;" width="88%">'.$data1['nama'].'</td>
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
					<td style="font-family:Times New Roman; font-size:12pt;">Kebangsaan/Kewarganegaraan</td>
					<td style="font-family:Times New Roman; font-size:12pt;">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;">'.$data1['kwr'].' '.$suku.'</td>
				</tr>
                                <tr>
					<td style="font-family:Times New Roman; font-size:12pt;">Tempat Tinggal</td>
					<td style="font-family:Times New Roman; font-size:12pt;">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;">'.$data1['alamat'].'</td>
				</tr>
                                <tr>>
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
		}
	} else{
		$tersangka .= '
			<tr>
				<td width="18.9%" style="font-family:Times New Roman; font-size:12pt;">Tersangka</td>
				<td width="3.1%" style="font-family:Times New Roman; font-size:12pt;">:</td>
				<td width="78%" style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
			</tr>
			<tr><td colspan="3">&nbsp;</td></tr>
		';
	}
	$tersangka .= '</tbody></table>';
        
	$docx->replaceVariableByText(array('nama_kejaksaan'=>strtoupper($namaSatker)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('kejaksaan1'=>$kejaksaan), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('kejaksaan2'=> ucwords(strtolower($kejaksaan))), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('no_p8u'=>$model['no_p8_umum']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl_p8u'=>tgl_indo($tgl_p8_umum)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nomor_print'=>$model['no_p8_khusus']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tindak_pidana'=>strtolower($model['tindak_pidana'])), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('laporan_pidana'=>$model['laporan_pidana']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByHTML('timJPN', 'block', $jaksa_negara, $arrDocnya);
        $docx->replaceVariableByText(array('tersangka'=>$nama_tersangka), array('parseLineBreaks'=>true));
        $docx->replaceVariableByHTML('tabel_tersangka', 'block', $tersangka, $arrDocnya);
        $docx->replaceVariableByText(array('tahun'=>date('Y')), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ttd_jabatannya'=>$jabatan_ttd), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('lokasi_keluar'=>$lokSatker), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl_ttd'=>tgl_indo($tgl_p8_umum)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ttd_nama'=>$model['penandatangan_nama']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ttd_detil'=>$model['penandatangan_pangkat'].' NIP.'.$model['penandatangan_nip']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByHTML('tembusan', 'inline', $tembusan_surat, $arrDocnya);
        
	$docx->createDocx('template/pidsus/P-8-Khusus');
	$file = 'template/pidsus/P-8-Khusus.docx';
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