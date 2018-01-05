<?php
	use app\modules\datun\models\Sp1;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../modules/datun/template/SKKS.permasalahan.docx');

	$namaSatker = Yii::$app->inspektur->getNamaSatker();
	$lokSatker 	= Yii::$app->inspektur->getLokasiSatker()->lokasi;
	$almtSatker = Yii::$app->inspektur->getLokasiSatker()->alamat;
	$arrDocnya 	= array('isFile'=>false, 'parseDivsAsPs'=>true, 'downloadImages'=>false);
	$kode_tk 	= $_SESSION['kode_tk'];
	$arrSKK 	= array("JA"=>"Jaksa Agung Republik Indonesia", "JAMDATUN"=>"Jaksa Agung Muda Perdata dan Tata Usaha Negara", "KAJATI"=>"Kajati", "KAJARI"=>"Kajari", 
					"KACABJARI"=>"Kacabjari", "JPN"=>"Jaksa Pengacara Negara");
	$arrBidang 	= array('JAKSA AGUNG MUDA PERDATA DAN TATA USAHA NEGARA', 'KAJATI', 'KAJARI', 'KACABJARI');
	$tgl_ttd 	= date('d-m-Y',strtotime($model['tanggal_ttd']));

	$berdasarkan_skk 	= "";
	$penerima_kuasa 	= "";
	$ttd_penerima_kuasa = "";

	
//permohonan
/* 	$sql1 = "
		(
			select a.no_register_perkara, a.no_surat, a.no_register_skk, a.tanggal_skk, a.no_register_skk as no_register_skks, 
			a.tanggal_skk as tanggal_skks, f.deskripsi_inst_wilayah as pemberi_kuasa, 
			case when a.penerima_kuasa = 'JPN' then '' else b.jabatan_pegawai end as penerima_kuasa, 'Surat Kuasa Khusus dengan hak substitusi' as tipenya, a.created_date 
			from datun.skk a
			join datun.skk_anak b on a.no_register_perkara = b.no_register_perkara and a.no_surat = b.no_surat 
				and a.no_register_skk = b.no_register_skk and a.tanggal_skk = b.tanggal_skk 
			join datun.permohonan c on a.no_register_perkara = c.no_register_perkara and a.no_surat = c.no_surat 
			join datun.jenis_instansi d on c.kode_jenis_instansi = d.kode_jenis_instansi
			join datun.instansi e on c.kode_jenis_instansi = e.kode_jenis_instansi and c.kode_instansi = e.kode_instansi and c.kode_tk = e.kode_tk
			join datun.instansi_wilayah f on c.kode_jenis_instansi = f.kode_jenis_instansi and c.kode_instansi = f.kode_instansi 
				and c.kode_provinsi = f.kode_provinsi and c.kode_kabupaten = f.kode_kabupaten and c.no_urut_wil = f.no_urut
			where a.no_register_perkara = '".$model['no_register_perkara']."' and a.no_surat = '".$model['no_surat']."' 
				and a.no_register_skk = '".$model['no_register_skk']."' and a.tanggal_skk = '".$model['tanggal_skk']."' 
			limit 1
		)
		union all 
		select a.no_register_perkara, a.no_surat, a.no_register_skk, a.tanggal_skk, a.no_register_skks, a.tanggal_ttd as tanggal_skks, 
		coalesce(d.jabatan_pegawai, f.jabatan_pegawai) as pemberi_kuasa, b.jabatan_pegawai as penerima_kuasa, 'Surat Kuasa Khusus Substitusi' as tipenya, a.created_date 
		from datun.skks a
		join datun.skks_anak b on a.no_register_perkara = b.no_register_perkara and a.no_surat = b.no_surat 
			and a.no_register_skk = b.no_register_skk and a.tanggal_skk = b.tanggal_skk and a.no_register_skks = b.no_register_skks
		left join datun.skks c on a.no_register_perkara = c.no_register_perkara and a.no_surat = c.no_surat 
			and a.no_register_skk = c.no_register_skk and a.tanggal_skk = c.tanggal_skk and a.pemberi_kuasa = c.no_register_skks
		left join datun.skks_anak d on c.no_register_perkara = d.no_register_perkara and c.no_surat = d.no_surat 
			and c.no_register_skk = d.no_register_skk and c.tanggal_skk = d.tanggal_skk and c.no_register_skks = d.no_register_skks
		left join datun.skk e on a.no_register_perkara = e.no_register_perkara and a.no_surat = e.no_surat 
			and a.pemberi_kuasa = e.no_register_skk and a.tanggal_skk = e.tanggal_skk 
		left join datun.skk_anak f on f.no_register_perkara = e.no_register_perkara and f.no_surat = e.no_surat 
			and f.no_register_skk = e.no_register_skk and f.tanggal_skk = e.tanggal_skk 
		where a.no_register_perkara = '".$model['no_register_perkara']."' and a.no_surat = '".$model['no_surat']."' 
			and a.no_register_skk = '".$model['no_register_skk']."' and a.tanggal_skk = '".$model['tanggal_skk']."' and a.penerima_kuasa != 'JPN' 
		union all 
		(
			select a.no_register_perkara, a.no_surat, a.no_register_skk, a.tanggal_skk, a.no_register_skks, a.tanggal_ttd as tanggal_skks, 
			coalesce(d.jabatan_pegawai, f.jabatan_pegawai) as pemberi_kuasa, 'JPN' as penerima_kuasa, 'Surat Kuasa Khusus Substitusi' as tipenya, a.created_date 
			from datun.skks a
			join datun.skks_anak b on a.no_register_perkara = b.no_register_perkara and a.no_surat = b.no_surat 
				and a.no_register_skk = b.no_register_skk and a.tanggal_skk = b.tanggal_skk and a.no_register_skks = b.no_register_skks
			left join datun.skks c on a.no_register_perkara = c.no_register_perkara and a.no_surat = c.no_surat 
				and a.no_register_skk = c.no_register_skk and a.tanggal_skk = c.tanggal_skk and a.pemberi_kuasa = c.no_register_skks
			left join datun.skks_anak d on c.no_register_perkara = d.no_register_perkara and c.no_surat = d.no_surat 
				and c.no_register_skk = d.no_register_skk and c.tanggal_skk = d.tanggal_skk and c.no_register_skks = d.no_register_skks
			left join datun.skk e on a.no_register_perkara = e.no_register_perkara and a.no_surat = e.no_surat 
				and a.pemberi_kuasa = e.no_register_skk and a.tanggal_skk = e.tanggal_skk 
			left join datun.skk_anak f on f.no_register_perkara = e.no_register_perkara and f.no_surat = e.no_surat 
				and f.no_register_skk = e.no_register_skk and f.tanggal_skk = e.tanggal_skk 
			where a.no_register_perkara = '".$model['no_register_perkara']."' and a.no_surat = '".$model['no_surat']."' 
				and a.no_register_skk = '".$model['no_register_skk']."' and a.tanggal_skk = '".$model['tanggal_skk']."' and a.penerima_kuasa = 'JPN' and a.is_active = 1
			limit 1
		)
		order by tanggal_skks, created_date";
	$res1 = Sp1::findBySql($sql1)->asArray()->all();
	if(count($res1) > 0){
		$berdasarkan_skk .= 'berdasarkan ';
		$jumlah = 0;
		foreach($res1 as $data1){
			$jumlah++;
			if($jumlah == 1){
				$berdasarkan_skk .= $data1['tipenya'].' Nomor : '.$data1['no_register_skks'].' tanggal '.tgl_indo(date('d/m/Y', strtotime($data1['tanggal_skks'])));
				$berdasarkan_skk .= ' dari '.$data1['pemberi_kuasa'].' Kepada '.$data1['penerima_kuasa'];
			} else if($data1['no_register_skks'] == $model['no_register_skks']){
				break;
			} else{
				$berdasarkan_skk .= '#'.$data1['tipenya'].' Nomor : '.$data1['no_register_skks'].' tanggal '.tgl_indo(date('d/m/Y', strtotime($data1['tanggal_skks'])));
				$berdasarkan_skk .= ' dari '.$data1['pemberi_kuasa'].' Kepada '.$data1['penerima_kuasa'];
			}
		}
	}
	$arrBerdasarkan  = explode("#", $berdasarkan_skk);
	$berdasarkan_skk = "";
	$jumBerdasarkan  = 0; 
	foreach($arrBerdasarkan as $datax){
		$jumBerdasarkan++;
		$separator = ($jumBerdasarkan == count($arrBerdasarkan) - 1)?' dan ':', ';
		$berdasarkan_skk .= $datax.$separator;
	}
	$berdasarkan_skk = substr($berdasarkan_skk,0,-2);
	 */
	/* $sql2 = "select * from datun.skks_anak where no_register_perkara = '".$model['no_register_perkara']."' and no_surat = '".$model['no_surat']."' 
			 and no_register_skk = '".$model['no_register_skk']."' and tanggal_skk = '".$model['tanggal_skk']."' and no_register_skks = '".$model['no_register_skks']."'";
	$res2 = Sp1::findBySql($sql2)->asArray()->all();
	$css1 = 'style="font-family:Trebuchet MS; font-size:11pt;"';
	$css2 = '<br /><br /><br /><br /><br />';
	if($model['penerima_kuasa'] != 'JPN'){
		$ttd_penerima_kuasa = '<span '.$css1.'>'.$res2[0]['nama_pegawai'].'</span>';
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
				<tr><td colspan="3">&nbsp;</td></tr>
			</tbody>
		</table>';
	} else{
		$penerima_kuasa = '<table border="0" width="100%" style="border-collapse:collapse;"><tbody>';
		foreach($res2 as $idx2=>$data2){
			$ttd_penerima_kuasa .= (($idx2+1) == 1)?'<span '.$css1.'>'.$data2['nama_pegawai'].'</span>':$css2.'<span '.$css1.'>'.$data2['nama_pegawai'].'</span>';
			$penerima_kuasa .= '
				<tr>
					<td '.$css1.' valign="top" width="5%">'.($idx2+1).'.</td>
					<td '.$css1.' valign="top" width="15%">Nama</td>
					<td '.$css1.' valign="top" width="4%" align="center">:</td>
					<td '.$css1.' valign="top" width="76%">'.$data2['nama_pegawai'].'</td>
				</tr>
				<tr>
					<td '.$css1.' valign="top">&nbsp;</td>
					<td '.$css1.' valign="top">Jabatan</td>
					<td '.$css1.' valign="top" align="center">:</td>
					<td '.$css1.' valign="top">Jaksa Pengacara Negara</td>
				</tr>
				<tr>
					<td '.$css1.' valign="top">&nbsp;</td>
					<td '.$css1.' valign="top">Alamat</td>
					<td '.$css1.' valign="top" align="center">:</td>
					<td '.$css1.' valign="top">Kantor Pengacara Negara<br />'.$almtSatker.'</td>
				</tr>
				<tr><td colspan="4">&nbsp;</td></tr>';
		}
		$penerima_kuasa .= '</tbody></table>';
	} */

	$docx->replaceVariableByText(array('nama_satker'=>$namaSatker), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('alamat_satker'=>$almtSatker), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('no_skks'=>$model['no_register_skks']), array('parseLineBreaks'=>true));
	/* $docx->replaceVariableByText(array('nama_pemberi'=>$model['nama_pemberi']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('jabatan_pemberi'=>$model['jabatan_pemberi']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('alamat_pemberi'=>$model['alamat_pemberi']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('instansi_wilayah'=>$model['wil_instansi']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('berdasarkan_skk'=>$berdasarkan_skk), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('status_pemohon'=>$model['status_pemohon']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('no_perkara'=>$model['no_register_perkara']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nama_pengadilan'=>$model['nama_pengadilan']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('lokasi_satker'=>$lokSatker), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_ttd'=>tgl_indo($tgl_ttd)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByHTML('penerima_kuasa', 'block', $penerima_kuasa, $arrDocnya);
	$docx->replaceVariableByHTML('ttd_penerima_kuasa', 'inline', $ttd_penerima_kuasa, $arrDocnya); */
	
	$docx->replaceVariableByText(array('permasalahan'=>$model['permasalahan_pemohon']), array('parseLineBreaks'=>true));

	$docx->createDocx('template/datun/SKKS.permasalahan');
	$file = 'template/datun/SKKS.permasalahan.docx';
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