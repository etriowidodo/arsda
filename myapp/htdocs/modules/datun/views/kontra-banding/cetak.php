<?php
	use app\modules\datun\models\KontraBanding;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../modules/datun/template/kontra-banding.docx');

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
	$tanggal_kontra_banding = date('d-m-Y',strtotime($model['tanggal_kontra_banding']));
	$tanggalSkk             = date('d-m-Y',strtotime($model['tanggal_skk']));
	$tanggalSkks            = date('d-m-Y',strtotime($model['tanggal_skks']));
	$tembusan_surat         = "";
	$jaksa_negara 	        = "";
	$amarPutusan 			= ($model['amar_putusan'])? '<div style=" line-height:30px; font-family:Trebuchet MS;"> '.$model['amar_putusan'].'</div>':'........................';
	$masterAmarPutusan 		= ($model['putusan_awal'])? '<div style=" line-height:30px; font-family:Trebuchet MS;"> '.$model['putusan_awal'].'</div>':'........................'; 
	$cdeskripsi_inst_wilayah=($model['tergugat']!=''?$model['tergugat']:'<p></p>');
	$cstatus_pemohon		=($model['status_pemohon']!=''?$model['status_pemohon']:'<p></p>');
	$cpimpinan_pemohon		=($model['pimpinan_pemohon']!=''?$model['pimpinan_pemohon']:'<p></p>');
	
	if($model['tanggal_kontra_banding']){
		$where = " and a.tanggal_kontra_banding = '".$model['tanggal_kontra_banding']."' ";
	} else {
		$where ="";
	}
	
	$sql2 = "select a.nip, a.nama, a.jabatan from datun.kontra_banding_anak a
			inner join datun.kontra_banding b on a.no_putusan=b.no_putusan and a.tanggal_putusan=b.tanggal_putusan 
			and a.no_register_skks=b.no_register_skks and a.tanggal_kontra_banding=b.tanggal_kontra_banding
			where a.no_register_skks='".$model['no_register_skks']."' and a.no_putusan = '".$model['no_putusan']."' 
			and a.tanggal_putusan = '".$model['tanggal_putusan']."' and a.tanggal_kontra_banding = NULLIF('".$model['tanggal_kontra_banding']."',' ')::date order by a.nip";
	$res2 = KontraBanding::findBySql($sql2)->asArray()->all();
	$kuasa_skk ="..................";	
	if(count($res2) > 0){
		$nom2 = 0;
		$kuasa_skk = '<table border="0" width="100%" style="border-collapse:collapse;"><tbody>';
		foreach($res2 as $data2){
			$nom2++;
			$kuasa_skk .= '
				<tr>
					<td style="font-family:Trebuchet MS; font-size:11pt;" width="3%">'.$nom2.'. </td>
					<td style="font-family:Trebuchet MS; font-size:11pt;" width="97%">'.$data2['nama'].'</td>
				</tr>';
		}
		$kuasa_skk .= '</tbody></table>';
	}
		
	
	$jaksa_negara1="<p> </p>";
	if(count($res2) > 0){
		$jaksa_negara1 = '<table border="0" width="100%" style="border-collapse:collapse;"><tbody>';
		$nom1 = 0;
		foreach($res2 as $data2){
			$nom1++;
			$kuasa = $data2['nama'];
			$jaksa_negara1 .= '
				<tr>
					<td style="font-family:Trebuchet MS; font-size:11pt;" width="5%"><br><br><br>'.$nom1.'. </td>
					<td style="font-family:Trebuchet MS; font-size:11pt;" width="95%"><br><br><br>'.$kuasa.'</td>
				</tr>';
		}
		$jaksa_negara1 .= '</tbody></table>'; 
	}
	
	$sqla = "select a.nip, a.nama_tergugat as nama, a.jabatan from datun.anak_tergugat a join datun.kontra_banding b
			on a.no_register_skks = b.no_register_skks and a.no_putusan = b.no_putusan and a.tanggal_putusan = b.tanggal_putusan
			and a.tanggal_kontra_banding = b.tanggal_kontra_banding
			where a.no_register_skks = '".$model['no_register_skks']."' and a.no_putusan = '".$model['no_putusan']."' and a.tanggal_putusan = '".$model['tanggal_putusan']."'
			and a.tanggal_kontra_banding = NULLIF ('".$model['tanggal_kontra_banding']."',' ')::date order by a.no_urut";
	$res1 = KontraBanding::findBySql($sqla)->asArray()->all();
	$jaksa_negara2	="<p> </p>";
	$terbanding	 	="................";
	if(count($res1) > 0){
		$jaksa_negara2 = '<table border="0" width="100%" style="border-collapse:collapse;"><tbody>';
		$nom1 = 0;
		foreach($res1 as $data1){
			$nom1++;
			$kuasa = $data1['nama'];
			$jaksa_negara2 .= '
				<tr>
					<td style="font-family:Trebuchet MS; font-size:11pt;" width="5%"><br><br><br>'.$nom1.'. </td>
					<td style="font-family:Trebuchet MS; font-size:11pt;" width="95%"><br><br><br>'.$kuasa.'</td>
				</tr>';
		}
		$jaksa_negara2 .= '</tbody></table>'; 
		
		//=================================================================
		
		$terbanding = '<table border="0" width="100%" style="border-collapse:collapse;"><tbody>';
		$nom3 = 0;
		foreach($res1 as $data1){
			$nom3++;
			$terbanding .= '
				<tr>
					<td style="font-family:Trebuchet MS; font-size:11pt;" width="3%">'.$nom3.'. </td>
					<td style="font-family:Trebuchet MS; font-size:11pt;" width="10%">Nama</td>
					<td style="font-family:Trebuchet MS; font-size:11pt;" width="2%">:</td>
					<td style="font-family:Trebuchet MS; font-size:11pt;" width="85%">'.$data1['nama'].'</td>
				</tr>
				<tr>
					<td style="font-family:Trebuchet MS; font-size:11pt;" width="3%"></td>
					<td style="font-family:Trebuchet MS; font-size:11pt;" width="10%">Jabatan</td>
					<td style="font-family:Trebuchet MS; font-size:11pt;" width="2%">:</td>
					<td style="font-family:Trebuchet MS; font-size:11pt;" width="85%">'.$data1['jabatan'].'</td>
				</tr>';
		}
		$terbanding .='</tbody></table>';
			
	}
	
	
	$docx->replaceVariableByText(array('alamat_kejaksaan'=>$almtSatker), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nama_kejaksaan'=>strtoupper($namaSatker)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('di_kejaksaan'=>ucwords($namaSatker)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('penggugat'=>strtoupper($model['penggugat'])), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tergugat'=>strtoupper($model['tergugat'])), array('parseLineBreaks'=>true)); 
	$docx->replaceVariableByText(array('nama_pemberi'=>strtoupper($model['nama_pemberi'])), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('noPutusan'=>strtoupper($model['no_putusan'])), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_putusan'=>tgl_indo($tanggal_putusan)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_banding'=>tgl_indo($tanggal_kontra_banding)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('lokasi_keluar'=>$lokSatker), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('yth'=>($model['kepada_yth'])?$model['kepada_yth']:' '), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('di'=>($model['di_kontrabanding'])?$model['di_kontrabanding']:' '), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('melalui'=>($model['melalui'])?$model['melalui']:' '), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('no_skk'=>$model['no_register_skk']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_skk'=>tgl_indo($tanggalSkk)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_skks'=>tgl_indo($tanggalSkks)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('no_skks'=>strtoupper($model['no_register_skks'])), array('parseLineBreaks'=>true));
	$docx->replaceVariableByHTML('kuasa', 'block', $kuasa_skk, $arrDocnya);
	$docx->replaceVariableByText(array('no_perdata'=>$model['no_register_perkara']), array('parseLineBreaks'=>true)); 
	$docx->replaceVariableByText(array('tanggal_perdata'=>tgl_indo($tgl_pengadilan)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByHTML('amarPutusan', 'block', $amarPutusan, $arrDocnya); 
	$docx->replaceVariableByHTML('MstrAmarPutusan', 'block', $masterAmarPutusan, $arrDocnya); 
	$docx->replaceVariableByText(array('jns_instansi'=>$model['jns_instansi']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByHTML('kuasa_jpn1', 'block', $jaksa_negara1, $arrDocnya); 	  
	$docx->replaceVariableByHTML('kuasa_jpn2', 'block', $jaksa_negara2, $arrDocnya);
	$docx->replaceVariableByText(array('sts_pemohon'=>$cstatus_pemohon), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('no_sts_pemohon'=>$model['no_status_pemohon']), array('parseLineBreaks'=>true));
	
	$docx->replaceVariableByText(array('deskripsi_inst_wilayah'=>$cdeskripsi_inst_wilayah),array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('diberikan_ke'=>$model['jabatan_pegawai']),array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('pemberi_kuasa'=>$model['pemberi_kuasa']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('penerima_kuasa'=>$model['penerima_kuasa']), array('parseLineBreaks'=>true));	
	$docx->replaceVariableByHTML('terbanding', 'block', $terbanding, $arrDocnya);
	$docx->replaceVariableByText(array('alamat_instansi'=>$model['alamat_instansi']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('pimpinan_pemohon'=>$cpimpinan_pemohon),array('parseLineBreaks'=>true));	
	
	$docx->createDocx('template/datun/kontra-banding');
	$file = 'template/datun/kontra-banding.docx';
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