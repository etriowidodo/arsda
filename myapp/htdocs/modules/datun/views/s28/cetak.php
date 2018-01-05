<?php
	use app\modules\datun\models\S28;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../modules/datun/template/S28.docx');

	$namaSatker             = Yii::$app->inspektur->getNamaSatker();
	$lokSatker 	            = Yii::$app->inspektur->getLokasiSatker()->lokasi;
	$almtSatker             = Yii::$app->inspektur->getLokasiSatker()->alamat;
	$arrDocnya 	            = array('isFile'=>false, 'parseDivsAsPs'=>true, 'downloadImages'=>false);
	$kode_tk 	            = $_SESSION['kode_tk'];
	$arrBidang 	            = array('JAKSA AGUNG MUDA PERDATA DAN TATA USAHA NEGARA', 'KAJATI', 'KAJARI', 'KACABJARI');
	$tgl_permohonan         = date('d-m-Y',strtotime($model['tanggal_permohonan']));
	$tgl_diterima 	        = date('d-m-Y',strtotime($model['tanggal_diterima']));
	$tgl_pengadilan         = date('d-m-Y',strtotime($model['tanggal_panggilan_pengadilan']));
	$tanggal_putusan        = date('d-m-Y',strtotime($model['tanggal_putusan']));
	$tanggalS28             = date('d-m-Y',strtotime($model['tanggal_s28']));
	$tanggalSkk             = date('d-m-Y',strtotime($model['tanggal_skk']));
	$tanggalSkks            = date('d-m-Y',strtotime($model['tanggal_skks']));
	$tgl_per_pk		        = date('d-m-Y',strtotime($model['tgl_permohonan_pk']));  
	$tembusan_surat         = "";
	$jaksa_negara 	        = "";
	$amarPutusan 			= ($model['amar_putusan'])? '<div style=" line-height:30px; font-family:Trebuchet MS;"> '.$model['amar_putusan'].'</div>':'........................';
	$alasan		 			= ($model['alasan'])? '<div style=" line-height:30px; font-family:Trebuchet MS;"> '.$model['alasan'].'</div>':'........................';
	$petitum_pri 			= ($model['isi_petitum_primer'])? '<div style=" line-height:30px; font-family:Trebuchet MS;"> '.$model['isi_petitum_primer'].'</div>':'........................';
	$petitum_sub 			= ($model['isi_petitum_subsider'])? '<div style=" line-height:30px; font-family:Trebuchet MS;"> '.$model['isi_petitum_subsider'].'</div>':'........................';
	$cpimpinan_pemohon		= ($model['pimpinan_pemohon']!=''?strtoupper($model['pimpinan_pemohon']):'<p></p>');
	$cjab_skks				= ($model['jab_skks']!=''?strtoupper($model['jab_skks']):'<p></p>');
	$jaksa_negara1			="<p> </p>";
	$jaksa_negara2			="<p> </p>";
	
	if($model['tanggal_s28']){
		$where = " and a.tanggal_s28 = '".$model['tanggal_s28']."' ";
	} else {
		$where ="";
	}
	$sql2 = "select a.nip, a.nama, a.jabatan from datun.s28_anak a
			inner join datun.s28 b on a.no_putusan=b.no_putusan and a.tanggal_putusan=b.tanggal_putusan 
			and a.no_register_skks=b.no_register_skks and a.tanggal_s28=b.tanggal_s28
			where a.no_register_skks='".$model['no_register_skks']."' and a.no_putusan = '".$model['no_putusan']."' 
			and a.tanggal_putusan = '".$model['tanggal_putusan']."'".$where." order by a.nip";
	$res2 = S28::findBySql($sql2)->asArray()->all();
	$kuasa_skk =".............";
	
	if(count($res2) > 0){
		$kuasa_skk = '<table border="0" width="100%" style="border-collapse:collapse;"><tbody>';
		$nom2 = 0;
		foreach($res2 as $data2){
			$nom2++;
			$kuasa_skk .= '
				<tr>
					<td style="font-family:Trebuchet MS; font-size:11pt;" width="2%">'.$nom2.'. </td>
					<td style="font-family:Trebuchet MS; font-size:11pt;" width="98%">'.$data2['nama'].'</td>
				</tr>';
		}
		//Start TTD========================================
		$jaksa_negara1 = '<table border="0" width="100%" style="border-collapse:collapse;"><tbody>';
		$jaksa_negara2 = '<table border="0" width="100%" style="border-collapse:collapse;"><tbody>';
		$nom1 = 0;
		foreach($res2 as $data1){
			$nom1++;
			$kuasa = $data1['nama'];
			if ($nom1 % 2 !=0){
			$jaksa_negara1 .= '
				<tr>
					<td style="font-family:Trebuchet MS; font-size:11pt;" width="2%"><br><br><br><br>'.$nom1.'. </td>
					<td style="font-family:Trebuchet MS; font-size:11pt;" width="98%"><br><br><br><br>'.$kuasa.'</td>
				</tr>';
			} else {
				$jaksa_negara2 .= '
				<tr>
					<td style="font-family:Trebuchet MS; font-size:11pt;" width="2%"><br><br><br><br>'.$nom1.'. </td>
					<td style="font-family:Trebuchet MS; font-size:11pt;" width="98%"><br><br><br><br>'.$kuasa.'</td>
				</tr>';		
			}
		}
		$jaksa_negara1 .= '</tbody></table>'; 
		$jaksa_negara2 .= '</tbody></table>';
		//End TTD==========================================================
		$kuasa_skk .= '</tbody></table>';
	}
	
		
	$sql3 = "select tanggal_s11, waktu_sidang from datun.s11 
			where no_register_skk='".$model['no_register_skk']."' and no_register_perkara = '".$model['no_register_perkara']."' and no_surat = '".$model['no_surat']."'";
	$res3 = S28::findBySql($sql3)->asArray()->all();
	$tgl_sidang="";
	if(count($res3) > 0){
		$nom2 = 0;
		foreach($res3 as $data3){
			$nom2++;
			$tgl_sidang = date('d-m-Y',strtotime($data3['tanggal_s11']));
		}
	}
	
	
	$docx->replaceVariableByText(array('alamat_kejaksaan'=>$almtSatker), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nama_kejaksaan'=>strtoupper($namaSatker)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('di_kejaksaan'=>ucwords($namaSatker)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('penggugat'=>strtoupper($model['penggugat'])), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tergugat'=>strtoupper($model['tergugat'])), array('parseLineBreaks'=>true)); 
	$docx->replaceVariableByText(array('nama_pemberi'=>strtoupper($model['deskripsi_inst_wilayah'])), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('noPutusan'=>strtoupper($model['no_putusan'])), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_putusan'=>tgl_indo($tanggal_putusan)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_s28'=>tgl_indo($tanggalS28)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('lokasi_keluar'=>$lokSatker), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('yth'=>($model['kepada_yth_s28'])?$model['kepada_yth_s28']:' '), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('diS28'=>($model['di_s28'])?$model['di_s28']:' '), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('melalui'=>($model['melalui'])?$model['melalui']:' '), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('jabatan'=>$model['jabatan_pegawai']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('no_skk'=>$model['no_register_skk']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_skk'=>tgl_indo($tanggalSkk)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('no_skks'=>$model['no_register_skks']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_skks'=>tgl_indo($tanggalSkks)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByHTML('kuasa', 'block', $kuasa_skk, $arrDocnya);
	$docx->replaceVariableByText(array('no_perdata'=>$model['no_register_perkara']), array('parseLineBreaks'=>true)); 
	$docx->replaceVariableByText(array('tanggal_perdata'=>($tgl_pengadilan)?tgl_indo($tgl_pengadilan):' '), array('parseLineBreaks'=>true));
	$docx->replaceVariableByHTML('amarPutusan', 'block', $amarPutusan, $arrDocnya); 
	$docx->replaceVariableByText(array('tgl_sidang'=>($tgl_sidang)?tgl_indo($tgl_sidang):' '), array('parseLineBreaks'=>true)); 
	$docx->replaceVariableByText(array('tgl_per_pk'=>($tgl_per_pk)?tgl_indo($tgl_per_pk):' '), array('parseLineBreaks'=>true)); 
	$docx->replaceVariableByText(array('noPermohonanBanding'=>($model['no_permohonan_banding'])?$model['no_permohonan_banding']:' '), array('parseLineBreaks'=>true));
	$docx->replaceVariableByHTML('alasan', 'block', $alasan, $arrDocnya); 
	$docx->replaceVariableByText(array('namaPengadilan'=>($model['nama_pengadilan'])?$model['nama_pengadilan']:' '), array('parseLineBreaks'=>true));
	$docx->replaceVariableByHTML('petitumPrimer', 'block', $petitum_pri, $arrDocnya);  
	$docx->replaceVariableByHTML('petitumSubsider', 'block', $petitum_sub, $arrDocnya);
	$docx->replaceVariableByText(array('jns_instansi'=>$model['jns_instansi']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByHTML('kuasa_jpn1', 'block', $jaksa_negara1, $arrDocnya); 	
	$docx->replaceVariableByHTML('kuasa_jpn2', 'block', $jaksa_negara2, $arrDocnya);
	$docx->replaceVariableByText(array('sts_pemohon'=>$model['status_pemohon']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('no_sts_pemohon'=>$model['no_status_pemohon']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('pimpinan_pemohon'=>$cpimpinan_pemohon),array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('jabatan_skks'=>$cjab_skks),array('parseLineBreaks'=>true));
	
	$docx->createDocx('template/datun/S28');
	$file = 'template/datun/S28.docx';
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