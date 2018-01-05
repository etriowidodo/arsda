<?php
	use app\modules\datun\models\Sp1;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../modules/pidsus/template/P-24.docx');

	$namaSatker     = Yii::$app->inspektur->getNamaSatker();
	$lokSatker 	= Yii::$app->inspektur->getLokasiSatker()->lokasi;
	$almtSatker     = Yii::$app->inspektur->getLokasiSatker()->alamat;
	$tgl_ba       = date('d-m-Y',strtotime($model['tgl_ba']));
	$tgl_ba1       = date('Y-m-d',strtotime($model['tgl_ba']));
	$tgl_p16       = date('d-m-Y',strtotime($model['tgl_p16']));
	$tgl_ttd 	= date('d-m-Y',strtotime($model['tgl_dikeluarkan']));
        $whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' and no_spdp = '".$_SESSION["no_spdp"]."' and tgl_spdp = '".$_SESSION["tgl_spdp"]."'";
        
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
					<td style="font-family:Times New Roman; font-size:12pt;" width="5.9%">'.$nom1.'.</td>
					<td style="font-family:Times New Roman; font-size:12pt;" width="11.9%">Nama</td>
					<td style="font-family:Times New Roman; font-size:12pt;" width="2.9%">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;" width="57.3%">'.$data1['nama'].'</td>
				</tr>
				<tr>
					<td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
					<td style="font-family:Times New Roman; font-size:12pt;">Pangkat</td>
					<td style="font-family:Times New Roman; font-size:12pt;">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;">'.$data1['pangkatgol'].'</td>
				</tr>
				<tr>
					<td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
					<td style="font-family:Times New Roman; font-size:12pt;">NIP</td>
					<td style="font-family:Times New Roman; font-size:12pt;">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;">'.$data1['nip'].'</td>
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
        
        $sql = "select distinct a.id_kejati, a.id_kejari, a.id_cabjari, a.no_spdp, a.tgl_spdp, a.no_berkas, a.no_urut, a.nama, a.tmpt_lahir, 
                to_char(a.tgl_lahir, 'DD-MM-YYYY') as tgl_lahir, a.umur, a.id_jkl from pidsus.pds_terima_berkas_tersangka a where ".$whereDefault." 
                and a.no_berkas = '".$model['no_berkas']."' and a.no_pengantar = '".$model['no_pengantar']."' order by a.no_urut";
	$res = Sp1::findBySql($sql)->asArray()->all();
        if(count($res)==1)$nama_tersangka =$res[0]['nama'];
        else if(count($res)==2)$nama_tersangka =$res[0]['nama'].' dan '.$res[1]['nama'];
        else if(count($res)>2)$nama_tersangka =$res[0]['nama'].' dkk';
        
        $pendapat=[1=>'Berkas perkara telah memenuhi persyaratan untuk dilimpahkan ke Pengadilan.',
            ' Masih perlu melengkapi berkas perkara atas nama '.$nama_tersangka.' dengan melakukan pemeriksaan tambahan.'];
        $pendapat_draft = '<table border="0" width="100%" style="border-collapse:collapse;"><tbody>
				<tr>
                                        <td style="font-family:Times New Roman; font-size:12pt;" width="5.9%"></td>
					<td style="font-family:Times New Roman; font-size:12pt;" width="5%" valign="top">a.</td>
					<td style="font-family:Times New Roman; font-size:12pt;" width="89.1%">'.$pendapat[2].'</td>
				</tr>
				<tr>
                                        <td style="font-family:Times New Roman; font-size:12pt;"></td>
					<td style="font-family:Times New Roman; font-size:12pt;" valign="top">b.</td>
					<td style="font-family:Times New Roman; font-size:12pt;">'.$pendapat[1].'</td>
				</tr></tbody></table>
			';
	$docx->replaceVariableByText(array('kejaksaan'=>strtoupper($namaSatker)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('harii'=>Yii::$app->globalfunc->GetNamahari($tgl_ba1)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_surat'=>tgl_indo($tgl_ba)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByHTML('jaksa_p16', 'block', $jaksa_negara, $arrDocnya);
        $docx->replaceVariableByText(array('kejaksaan1'=> ucfirst(strtolower($namaSatker))), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('no_p16'=> $model['no_p16']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl_p16'=> tgl_indo($tgl_p16)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tersangka'=> $nama_tersangka), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('reg_no'=> ''), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('undang'=> ''), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('pasal'=> ''), array('parseLineBreaks'=>true));
        
        if($model['isDraft']){
            $docx->replaceVariableByText(array('ket_saksi'=> ''), array('parseLineBreaks'=>true));
            $docx->replaceVariableByText(array('ket_ahli'=> ''), array('parseLineBreaks'=>true));
            $docx->replaceVariableByText(array('alat_bukti'=> ''), array('parseLineBreaks'=>true));
            $docx->replaceVariableByText(array('benda_sitaan'=> ''), array('parseLineBreaks'=>true));
            $docx->replaceVariableByText(array('ket_tersangka'=> ''), array('parseLineBreaks'=>true));
            $docx->replaceVariableByText(array('fakta_hukum'=> ''), array('parseLineBreaks'=>true));
            $docx->replaceVariableByText(array('yuridis'=> ''), array('parseLineBreaks'=>true));
            $docx->replaceVariableByText(array('kesimpulan'=> ''), array('parseLineBreaks'=>true));
            $docx->replaceVariableByHTML('pendapat', 'block', $pendapat_draft, $arrDocnya);
            $docx->replaceVariableByText(array('saran'=> ''), array('parseLineBreaks'=>true));
            $docx->replaceVariableByText(array('petunjuk'=> ''), array('parseLineBreaks'=>true));
        }else{
            $docx->replaceVariableByText(array('ket_saksi'=> $model['ket_saksi']), array('parseLineBreaks'=>true));
            $docx->replaceVariableByText(array('ket_ahli'=> $model['ket_ahli']), array('parseLineBreaks'=>true));
            $docx->replaceVariableByText(array('alat_bukti'=> $model['alat_bukti']), array('parseLineBreaks'=>true));
            $docx->replaceVariableByText(array('benda_sitaan'=> $model['benda_sitaan']), array('parseLineBreaks'=>true));
            $docx->replaceVariableByText(array('ket_tersangka'=> $model['ket_tersangka']), array('parseLineBreaks'=>true));
            $docx->replaceVariableByText(array('fakta_hukum'=> $model['fakta_hukum']), array('parseLineBreaks'=>true));
            $docx->replaceVariableByText(array('yuridis'=> $model['yuridis']), array('parseLineBreaks'=>true));
            $docx->replaceVariableByText(array('kesimpulan'=> $model['kesimpulan']), array('parseLineBreaks'=>true));
            $docx->replaceVariableByText(array('pendapat'=> $pendapat[$model['id_pendapat']]), array('parseLineBreaks'=>true));
            $docx->replaceVariableByText(array('saran'=> $model['saran']), array('parseLineBreaks'=>true));
            $docx->replaceVariableByText(array('petunjuk'=> $model['petunjuk']), array('parseLineBreaks'=>true));
        }
        
        
        $docx->replaceVariableByText(array('nama_penandatangan'=> $model['nama_ttd']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('pangkat_penandatangan'=> $model['pangkat_ttd']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('nip_penandatangan'=> $model['nip_ttd']), array('parseLineBreaks'=>true));
        
	$docx->createDocx('template/pidsus/P-24');
	$file = 'template/pidsus/P-24.docx';
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