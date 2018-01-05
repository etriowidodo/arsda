<?php
	use app\modules\datun\models\Sp1;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../modules/datun/template/S-2.A.docx');

	$namaSatker = Yii::$app->inspektur->getNamaSatker();
	$lokSatker 	= Yii::$app->inspektur->getLokasiSatker()->lokasi;
	$almtSatker = Yii::$app->inspektur->getLokasiSatker()->alamat;
	$arrDocnya 	= array('isFile'=>false, 'parseDivsAsPs'=>true, 'downloadImages'=>false);
	$kode_tk 	= $_SESSION['kode_tk'];
	$arrBidang 	= array('JAKSA AGUNG MUDA PERDATA DAN TATA USAHA NEGARA', 'KAJATI', 'KAJARI', 'KACABJARI');
	$tgl_ttd 	= date('d-m-Y',strtotime($model['tanggal_ttd']));
	$no_perkara = $model['no_register_perkara'];
	$no_surat 	= $model['no_surat'];

	$lawan_pemohon 		= "";
	$ttd_penerima_kuasa = "";
	$penerima_kuasa 	= "";
		
	$sql1 = "select string_agg(nama_instansi, '#') as lawan_pemohon from datun.lawan_pemohon where no_register_perkara = '".$no_perkara."' and no_surat = '".$no_surat."'";
	$res1 = Sp1::findBySql($sql1)->scalar();
	$tmp1 = explode("#", $res1);
	if(count($tmp1) > 1){
		$lawan_pemohon = $tmp1[0].", Dkk";
	} else{
		$lawan_pemohon = $tmp1[0];
	}
	
	$sql2 = "select * from datun.skk_anak where no_register_perkara = '".$no_perkara."' and no_surat = '".$no_surat."' 
			 and no_register_skk = '".$model['no_register_skk']."' and tanggal_skk = '".$model['tanggal_skk']."' order by no_urut";
	$res2 = Sp1::findBySql($sql2)->asArray()->all();
	$css1 = 'style="font-family:Trebuchet MS; font-size:11pt;"';
	$css2 = '<br /><br /><br /><br /><br />';
	if($model['penerima_kuasa'] != 'JPN'){
		$ttd_penerima_kuasa = '<div align="center"><span '.$css1.'>'.$res2[0]['nama_pegawai'].'</span></div>';
		$penerima_kuasa 	= '
		<table border="0" width="100%" style="border-collapse:collapse;">
			<tbody>
				<tr>
					<td '.$css1.' width="15%">Nama</td>
					<td '.$css1.' width="4%" align="center">:</td>
					<td '.$css1.' width="81%">'.$res2[0]['nama_pegawai'].'</td>
				</tr>
				<tr>
					<td '.$css1.'>Jabatan</td>
					<td '.$css1.' align="center">:</td>
					<td '.$css1.'>'.$res2[0]['jabatan_pegawai'].'</td>
				</tr>
				<tr>
					<td '.$css1.'>Alamat</td>
					<td '.$css1.' align="center">:</td>
					<td '.$css1.'>'.$res2[0]['alamat_instansi'].'</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
			</tbody>
		</table>';
	} else{
		$penerima_kuasa = '<table border="0" width="100%" style="border-collapse:collapse;"><tbody>';
		foreach($res2 as $idx2=>$data2){
			$ttd_penerima_kuasa .= (($idx2+1) == 1)?'<span '.$css1.'>'.($idx2+1).'. '.$data2['nama_pegawai'].'</span>':$css2.'<span '.$css1.'>'.($idx2+1).'. '.$data2['nama_pegawai'].'</span>';
			$penerima_kuasa .= '
				<tr>
					<td '.$css1.' valign="top" width="5%">'.($idx2+1).'.</td>
					<td '.$css1.' valign="top" width="15%">Nama</td>
					<td '.$css1.' valign="top" width="4%" align="center">:</td>
					<td '.$css1.'valign="top" width="76%">'.$data2['nama_pegawai'].'</td>
				</tr>
				<tr>
					<td '.$css1.'valign="top">&nbsp;</td>
					<td '.$css1.'valign="top">Jabatan</td>
					<td '.$css1.'valign="top" align="center">:</td>
					<td '.$css1.'valign="top">Jaksa Pengacara Negara</td>
				</tr>
				<tr>
					<td '.$css1.'valign="top">&nbsp;</td>
					<td '.$css1.'valign="top">Alamat</td>
					<td '.$css1.'valign="top" align="center">:</td>
					<td '.$css1.'valign="top">Kantor Pengacara Negara<br />'.$almtSatker.'</td>
				</tr>
				<tr>
					<td colspan="4">&nbsp;</td>
				</tr>';
		}
		$penerima_kuasa .= '</tbody></table>';
	}

	$docx->replaceVariableByText(array('no_skk'=>$model['no_register_skk']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('pimpinan_pemohon'=>$model['pimpinan_pemohon']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('instansi_wilayah'=>$model['wil_instansi']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('alamat_instansi'=>$model['alamat_instansi']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('status_pemohon'=>$model['status_pemohon']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('no_perkara'=>$model['no_register_perkara']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nama_pengadilan'=>$model['nama_pengadilan']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('lokasi_satker'=>$lokSatker), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_ttd'=>tgl_indo($tgl_ttd)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('lawan_pemohon'=>$lawan_pemohon), array('parseLineBreaks'=>true));
	$docx->replaceVariableByHTML('penerima_kuasa', 'block', $penerima_kuasa, $arrDocnya);
	$docx->replaceVariableByHTML('ttd_penerima_kuasa', 'block', $ttd_penerima_kuasa, $arrDocnya);

	$docx->createDocx('template/datun/S-2.A');
	$file = 'template/datun/S-2.A.docx';
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