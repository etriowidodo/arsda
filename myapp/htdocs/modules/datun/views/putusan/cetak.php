<?php
	use app\modules\datun\models\Sp1;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../modules/datun/template/SP-1.docx');

	$namaSatker = Yii::$app->inspektur->getNamaSatker();
	$lokSatker 	= Yii::$app->inspektur->getLokasiSatker()->lokasi;
	$almtSatker = Yii::$app->inspektur->getLokasiSatker()->alamat;
	$arrDocnya 	= array('isFile'=>false, 'parseDivsAsPs'=>true, 'downloadImages'=>false);
	$kode_tk 	= $_SESSION['kode_tk'];
	$arrBidang 	= array('JAKSA AGUNG MUDA PERDATA DAN TATA USAHA NEGARA', 'KAJATI', 'KAJARI', 'KACABJARI');
	$tgl_permohonan = date('d-m-Y',strtotime($model['tanggal_permohonan']));
	$tgl_diterima 	= date('d-m-Y',strtotime($model['tanggal_diterima']));
	$tgl_pengadilan = date('d-m-Y',strtotime($model['tanggal_panggilan_pengadilan']));
	$tgl_ttd 		= date('d-m-Y',strtotime($model['tanggal_ttd']));
	$tembusan_surat = "";
	$jaksa_negara 	= "";

	if(strtoupper($model['penandatangan_status']) == 'ASLI')
		$jabatan_ttd = $model['penandatangan_ttdjabat'];
	else if(strtoupper($model['penandatangan_status']) == 'A.N')
		$jabatan_ttd = "An. ".$model['penandatangan_ttdjabat']."\n".$model['penandatangan_jabatan'];
	else if(strtoupper($model['penandatangan_status']) == 'PLT')
		$jabatan_ttd = "Plt. ".$model['penandatangan_ttdjabat'];
	else if(strtoupper($model['penandatangan_status']) == 'PLH')
		$jabatan_ttd = "Plh. ".$model['penandatangan_ttdjabat'];
		
	$sql1 = "select nip, nama, gol_jpn, pangkat_jpn, jabatan_jpn, pangkat_jpn||' ('||gol_jpn||')' as pangkatgol   
			from datun.sp1_timjpn where no_register_perkara = '".$model['no_register_perkara']."' and no_surat = '".$model['no_surat']."'";
	$res1 = Sp1::findBySql($sql1)->asArray()->all();
	$jaksa_negara = '<table border="0" width="100%" style="border-collapse:collapse;"><tbody>';
	if(count($res1) > 0){
		$nom1 = 0;
		foreach($res1 as $data1){
			$nom1++;
			$jaksa_negara .= '
				<tr>
					<td style="font-family:Trebuchet MS; font-size:11pt;" width="18.9%">'.($nom1 == 1?'Kepada':'&nbsp;').'</td>
					<td style="font-family:Trebuchet MS; font-size:11pt;" width="3.1%">'.($nom1 == 1?':':'&nbsp;').'</td>
					<td style="font-family:Trebuchet MS; font-size:11pt;" width="5.9%">'.$nom1.'.</td>
					<td style="font-family:Trebuchet MS; font-size:11pt;" width="11.9%">Nama</td>
					<td style="font-family:Trebuchet MS; font-size:11pt;" width="2.9%">:</td>
					<td style="font-family:Trebuchet MS; font-size:11pt;" width="57.3%">'.$data1['nama'].'</td>
				</tr>
				<tr>
					<td style="font-family:Trebuchet MS; font-size:11pt;">&nbsp;</td>
					<td style="font-family:Trebuchet MS; font-size:11pt;">&nbsp;</td>
					<td style="font-family:Trebuchet MS; font-size:11pt;">&nbsp;</td>
					<td style="font-family:Trebuchet MS; font-size:11pt;">Pangkat</td>
					<td style="font-family:Trebuchet MS; font-size:11pt;">:</td>
					<td style="font-family:Trebuchet MS; font-size:11pt;">'.$data1['pangkatgol'].'</td>
				</tr>
				<tr>
					<td style="font-family:Trebuchet MS; font-size:11pt;">&nbsp;</td>
					<td style="font-family:Trebuchet MS; font-size:11pt;">&nbsp;</td>
					<td style="font-family:Trebuchet MS; font-size:11pt;">&nbsp;</td>
					<td style="font-family:Trebuchet MS; font-size:11pt;">Jabatan</td>
					<td style="font-family:Trebuchet MS; font-size:11pt;">:</td>
					<td style="font-family:Trebuchet MS; font-size:11pt;">Kantor Pengacara Negara</td>
				</tr>
				<tr><td colspan="6">&nbsp;</td></tr>
			';
		}
	} else{
		$jaksa_negara .= '
			<tr>
				<td width="18.9%" style="font-family:Trebuchet MS; font-size:11pt;">Kepada</td>
				<td width="3.1%" style="font-family:Trebuchet MS; font-size:11pt;">:</td>
				<td width="78%" style="font-family:Trebuchet MS; font-size:11pt;">&nbsp;</td>
			</tr>
			<tr><td colspan="3">&nbsp;</td></tr>
		';
	}
	$jaksa_negara .= '</tbody></table>';

	$sql2 = "select no_temb_sp1 as no_urut, deskripsi_tembusan_su as tembusan from datun.sp1_tembusan 
			where no_register_perkara = '".$model['no_register_perkara']."' and no_surat = '".$model['no_surat']."' order by no_temb_sp1";
	$res2 = Sp1::findBySql($sql2)->asArray()->all();
	if(count($res2) > 0){
		$nom2 = 0;
		foreach($res2 as $data2){
			$nom2++;
			$tembusan_surat .= '<span style="font-family:Trebuchet MS; font-size:11pt;">'.$nom2.'. '.$data2['tembusan'].'</span><br />';
		}
	}

	$docx->replaceVariableByText(array('alamat_kejaksaan'=>$almtSatker), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nama_kejaksaan'=>strtoupper($namaSatker)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('no_sp1'=>$model['no_sp1']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('bidang_kejaksaan'=>$arrBidang[$kode_tk]), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('bidang_kejaksaan_initcap'=>ucwords(strtolower($arrBidang[$kode_tk]))), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('instansi_wilayah'=>$model['deskripsi_inst_wilayah']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('no_permohonan'=>$model['no_surat']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_permohonan'=>tgl_indo($tgl_permohonan)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('permasalahan'=>$model['permasalahan_pemohon']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('lokasi_keluar'=>$lokSatker), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_ttd'=>tgl_indo($tgl_ttd)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('ttd_jabatannya'=>$jabatan_ttd), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('ttd_nama'=>$model['penandatangan_nama']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('ttd_detil'=>$model['penandatangan_pangkat'].' NIP.'.$model['penandatangan_nip']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByHTML('timJPN', 'block', $jaksa_negara, $arrDocnya);
	$docx->replaceVariableByHTML('tembusan', 'inline', $tembusan_surat, $arrDocnya);

	$docx->createDocx('template/datun/sp-1');
	$file = 'template/datun/sp-1.docx';
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