<?php
	use app\modules\datun\models\HarianSidang as Search;
	require_once('./wordtest/classes/CreateDocx.inc');

	$docx = new CreateDocx();
	$docx->modifyPageLayout('A3-landscape', array('numberCols' => '1'));
	
//public function addHeader($headers)

/* 	$cRetxx = new WordFragment($docx, 'defaultHeader');
	$cRetxx->addtext($cRet1);
	$docx->addHeader(array('default' => $cRetxx)); */

	 function  tanggal_indonesia($tgl)
    {
        $tanggal  = explode('-',$tgl); 
        $bulan  = getBulan($tanggal[1]);
        $tahun  = $tanggal[2];
        $lctgl = $tanggal[0];
        
        return  $lctgl.' '.$bulan.' '.$tahun;
        
    }
	
	function  getBulan($bln){
		switch  ($bln){
			case  1:
				return  "Januari";
				break;
			case  2:
				return  "Februari";
				break;
			case  3:
				return  "Maret";
				break;
			case  4:
				return  "April";
				break;
			case  5:
				return  "Mei";
				break;
			case  6:
				return  "Juni";
				break;
			case  7:
				return  "Juli";
				break;
			case  8:
				return  "Agustus";
				break;
			case  9:
				return  "September";
				break;
			case  10:
				return  "Oktober";
				break;
			case  11:
				return  "November";
				break;
			case  12:
				return  "Desember";
				break;
		}
	}
	
		$title			= Yii::$app->inspektur->getNamaSatker();				
		$post 			= Yii::$app->getRequest()->post();
		$tahun			= Yii::$app->request->post('thn');
		$b				= Yii::$app->request->post('bln');
		$bulan			= $b+1;		
		$title			= Yii::$app->inspektur->getNamaSatker();
		$clokasi		= Yii::$app->inspektur->getLokasiSatker()->lokasi;		
		$ctanggal 		= tanggal_indonesia(date('d-m-Y'));
		$cnama_bulan 	= getBulan($bulan);				
		$cnamattd 		= $post['penandatangan_nama']; 
		$cjabat 		= $post['ttdJabatan']; 						
		$ctk			= $_SESSION['kode_tk']; 		

	
		$csql = "select  c.inst_nama as nm_satker,d.kode_tahap_bankum,e.deskripsi_tahap_bankum,a.no_register_perkara,a.no_surat,
				a.tanggal_permohonan,b.deskripsi_inst_wilayah,a.permasalahan_pemohon,a.status,d.no_register_skk,d.tanggal_skk,f.no_register_skks
				from datun.permohonan a
				inner join datun.instansi_wilayah b on a.kode_jenis_instansi=b.kode_jenis_instansi and a.kode_instansi=b.kode_instansi and a.kode_provinsi=b.kode_provinsi and a.kode_kabupaten=b.kode_kabupaten and a.kode_tk=b.kode_tk and a.no_urut_wil=b.no_urut
				inner join kepegawaian.kp_inst_satker c on c.kode_tk=a.kode_tk and c.kode_kejati=a.kode_kejati and c.kode_kejari=a.kode_kejari and c.kode_cabjari=a.kode_cabjari			   
				inner join datun.skk d on a.no_register_perkara=d.no_register_perkara and a.no_surat=d.no_surat and a.kode_tk=d.kode_tk and a.kode_kejati=d.kode_kejati and a.kode_kejari=d.kode_kejari and a.kode_cabjari=d.kode_cabjari
				inner join datun.tr_tahap_bankum e on e.kode_tahap_bankum=d.kode_tahap_bankum
				left join datun.skks f on f.no_register_skk=d.no_register_skk and f.tanggal_skk=d.tanggal_skk and f.no_register_perkara=d.no_register_perkara and f.no_surat=d.no_surat and  f.is_active='1'
				where date_part('month', a.tanggal_permohonan)='$bulan' and date_part('year', a.tanggal_permohonan)='$tahun' ";		
		$model = Search::findBySql($csql)->asArray()->all();
	
		$cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">";
		$cRet .= "	<tr>							
						<td style=\"vertical-align:top;border-top: solid 0px black;border-bottom: none; font-size:20px;border: solid 0px;\" width=\"100%\" align=\"left\"><b>$title</b></td>	
					</tr>";								
					
		$cRet .= "</table>";
				
		$cRet .= "	<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
		$cRet .= "		<tr>
							<td width=\"37%\" align=\"right\" ></td>
							<td width=\"13%\" align=\"left\" ><b>LAPORAN BULANAN</b></td>
							<td width=\"2%\" align=\"center\" ><b>:</b></td>
							<td width=\"48%\" align=\"left\" ><b>BANTUAN HUKUM</b></td>

						</tr>";
		$cRet .= "	<tr>
						<td width=\"37%\" align=\"right\" ></td>
						<td width=\"13%\" align=\"left\" ><b>BULAN</b></td>
						<td width=\"2%\" align=\"center\" ><b>:</b></td>
						<td width=\"48%\" align=\"left\" ><b>$cnama_bulan</b></td>

					</tr>";					
		$cRet .= "	<tr>
						<td width=\"37%\" align=\"right\" ></td>
						<td width=\"13%\" align=\"left\" ><b>TAHUN</b></td>
						<td width=\"2%\" align=\"center\" ><b>:</b></td>
						<td width=\"48%\" align=\"left\"><b>$tahun</b></td>

					</tr>";					
		$cRet .= " </table>";						
				
			$cRet .= "	<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"4\">	";
			$cRet .= " 	<tr>
							<td rowspan=\"2\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"3%\" align=\"center\"><b>No</b></td>								
							<td rowspan=\"2\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"6%\" align=\"center\"><b>Kejaksaan</b></td>
							<td rowspan=\"2\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"7%\" align=\"center\"><b>Tingkat Penanganan Perkara (Tingkat Pertama/ Banding/ Kasasi/ PK</b></td>
							<td colspan=\"2\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"13%\" align=\"center\"><b>Identitas Perkara</b></td>
							<td rowspan=\"2\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"6%\" align=\"center\"><b>Jenis Perkara PDT/ TUN/ PPH</b></td>
							<td colspan=\"2\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"12%\" align=\"center\"><b>Pihak-Pihak dalam Perkara</b></td>
							<td rowspan=\"2\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"8%\" align=\"center\"><b>Masalah</b></td>
							<td rowspan=\"2\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"6%\" align=\"center\"><b>Kasus Posisi</b></td>
							<td rowspan=\"2\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"6%\" align=\"center\"><b>Tuntutan Penggugat/ Pemohon/ Pelawan</b></td>
							<td rowspan=\"2\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"7%\" align=\"center\"><b>JPN yang Ditugaskan</b></td>
							<td rowspan=\"2\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"6%\" align=\"center\"><b>Tahap & Kegiatan Penanganan Perkara</b></td>
							<td colspan=\"2\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"12%\" align=\"center\"><b>Ringkasan Hasil Kegiatan</b></td>
							<td rowspan=\"2\" style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"7%\" align=\"center\"><b>Ket.</b></td>							
						</tr>";

			$cRet .= " 	<tr>
							<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"17%\" align=\"center\"><b>No. Reg.</b></td>								
							<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"16%\" align=\"center\"><b>Tanggal Reg.</b></td>
							<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"16%\" align=\"center\"><b>Penggugat/ Pemohon/ Pelawan</b></td>
							<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"16%\" align=\"center\"><b>Tergugat/ Termohon/ Terlawan</b></td>
							<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"16%\" align=\"center\"><b>Di Luar Pengadilan</b></td>
							<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"16%\" align=\"center\"><b>Penetapan/ Pengadilan</b></td>
													
						</tr>";
					
			$cRet .= " 	<tr>
							<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"2%\" align=\"center\"><b>1</b></td>								
							<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"7%\" align=\"center\"><b>2</b></td>
							<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"7%\" align=\"center\"><b>3</b></td>
							<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"7%\" align=\"center\"><b>4</b></td>
							<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"6%\" align=\"center\"><b>5</b></td>
							<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"6%\" align=\"center\"><b>6</b></td>
							<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"6%\" align=\"center\"><b>7</b></td>
							<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"6%\" align=\"center\"><b>8</b></td>
							<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"8%\" align=\"center\"><b>9</b></td>
							<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"6%\" align=\"center\"><b>10</b></td>
							<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"6%\" align=\"center\"><b>11</b></td>
							<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"7%\" align=\"center\"><b>12</b></td>
							<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"6%\" align=\"center\"><b>13</b></td>
							<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"6%\" align=\"center\"><b>14</b></td>
							<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"6%\" align=\"center\"><b>15</b></td>
							<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"7%\" align=\"center\"><b>16</b></td>
													
						</tr>";						

			$cno=1;
			$xpenggugat='';
			foreach ($model as $header ) {
				
				$cjenis					='PERDATA';
				$cnm_satker				=($header['nm_satker']!=''?$header['nm_satker']:'');
				$cdeskripsi_tahap_bankum=($header['deskripsi_tahap_bankum']!=''?$header['deskripsi_tahap_bankum']:'');
				$cno_register_perkara	=$header['no_register_perkara'];
				$cno_surat				=($header['no_surat']!=''?$header['no_surat']:'');
				$cno_register_skks		=($header['no_register_skks']!=''?$header['no_register_skks']:'');			
				$cno_register_skk		=($header['no_register_skk']!=''?$header['no_register_skk']:'');		
				$ctanggal_skk			=date('d-m-Y', strtotime($header['tanggal_skk'])); 				
				$ctanggal_permohonan	=date('d-m-Y', strtotime($header['tanggal_permohonan'])); 
				$cdeskripsi_inst_wilayah=($header['deskripsi_inst_wilayah']!=''?$header['deskripsi_inst_wilayah']:'');
				$cpermasalahan_pemohon	=($header['permasalahan_pemohon']!=''?$header['permasalahan_pemohon']:'');
				$cstatus				=($header['status']!=''?$header['status']:'');							
				$csql2 					= "select nama_instansi from datun.lawan_pemohon where no_register_perkara='$cno_register_perkara' and no_surat='$cno_surat'";
				$mlawan = Search::findBySql($csql2)->asArray()->all();
						$cpenggugat		='';
						
						foreach ($mlawan as $xlawan ) {
								$cpenggugat .=$xlawan['nama_instansi'].",";
						}
				
				if($header['no_register_skks']!=''){ 	
			
					$csql = "select nip_pegawai,nama_pegawai from datun.skks_anak
							where no_register_skks='$cno_register_skks' and no_register_perkara='$cno_register_perkara' and no_surat='$cno_surat' and  no_register_skk='$cno_register_skk'  order by nip_pegawai";
					
					$model_jpn = Search::findBySql($csql)->asArray()->all();	
						$cjpn='';
						foreach ($model_jpn as $jpn ) {
							$cjpn .=$jpn['nama_pegawai'].",";
						}	

				}else{
						
					$csql = "select nip_pegawai,nama_pegawai from datun.skk_anak where  no_register_perkara='$cno_register_perkara' 
							and no_surat='$cno_surat' and  no_register_skk='$cno_register_skk' order by nip_pegawai";	
					
					$model_jpn = Search::findBySql($csql)->asArray()->all();	
						$cjpn='';
						foreach ($model_jpn as $jpn ) {
							$cjpn .=$jpn['nama_pegawai'].",";
						}					
				}
									
				
				$cRet .= " <tr>
				
						<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"2%\" align=\"left\">$cno</td>								
						<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"7%\" align=\"left\">$cnm_satker</td>
						<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"7%\" align=\"left\">$cdeskripsi_tahap_bankum</td>
						<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"7%\" align=\"left\">$cno_register_perkara</td>
						
						<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"6%\" align=\"left\">$ctanggal_permohonan</td>
						<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"6%\" align=\"left\">$cjenis</td>
						<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"6%\" align=\"left\">$cdeskripsi_inst_wilayah</td>
						<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"6%\" align=\"left\">$cpenggugat</td>
						<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"8%\"  align=\"left\">$cpermasalahan_pemohon</td>
						<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"6%\"align=\"left\">$cstatus</td>
						<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"6%\" align=\"left\"></td>
						<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"7%\" align=\"left\">$cjpn</td>
						<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"6%\" align=\"left\">$cstatus</td>
						<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"6%\" align=\"left\"></td>
						<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"6%\" align=\"left\"></td>
						<td style=\"vertical-align:top;border-top: solid 1px black;border-bottom: none; font-size:11px;border: solid 1px;\" width=\"7%\" align=\"left\"></td>
													
					</tr>";					
				
				$cno++;			
			}

		$cRet .= " </table>";
		
		$cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">";
		$cRet .= " <tr>							
						<td style=\"vertical-align:top;border-top: solid 0px black;border-bottom: none; font-size:14px;border: solid 0px;\" width=\"70%\" align=\"left\">Keterangan:</td>	
					</tr>
					<tr>							
						<td style=\"vertical-align:top;border-top: solid 0px black;border-bottom: none; font-size:13px;border: solid 0px;\" width=\"70%\" align=\"left\">Laporan bulanan ini untuk PPH, Perdata, dan TUN</td>	
						<td style=\"vertical-align:top;border-top: solid 0px black;border-bottom: none; font-size:13px;border: solid 0px;\" width=\"30%\" align=\"center\">$clokasi,$ctanggal</td>	
												
					</tr>	
					
					<tr>							
						<td style=\"vertical-align:top;border-top: solid 0px black;border-bottom: none; font-size:14px;border: solid 0px;\" width=\"70%\" align=\"left\"></td>	
						<td style=\"vertical-align:top;border-top: solid 0px black;border-bottom: none; font-size:14px;border: solid 0px;\" width=\"30%\" align=\"center\"><b>$cjabat</b><br><br></td>
												
					</tr>	
					
				 	<tr>							
						<td style=\"vertical-align:top;border-top: solid 0px black;border-bottom: none; font-size:14px;border: solid 0px;\" width=\"70%\" align=\"left\"></td>
						<td style=\"vertical-align:top;border-top: solid 0px black;border-bottom: none; font-size:14px;border: solid 0px;\" width=\"30%\" align=\"center\"><b>$cnamattd</b></td>	
												
					</tr>";				
			
		$cRet .= " </table>";	
		
	$docx->embedHTML($cRet);
	$docx->createDocx('template/datun/L-Datun.2');
	$file = 'template/datun/L-Datun.2.docx';

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