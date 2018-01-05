<?php
	use app\modules\datun\models\Sp1;
    use app\modules\pidum\models\PdmMsTindakanStatus;
    use app\modules\pidum\models\PdmNotaPendapat;
    use app\modules\pidum\models\PdmT7;

	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../web/template/pidum/T-7.docx');
	$satker = Yii::$app->globalfunc->getSatker()->inst_nama ;
	
	$tanya = '';
	/* if (count($tanyaJawab) != 0) {
	 		$tanya = '<table border="0" width="100%" style="border-collapse:collapse;"><tbody>';
           foreach ($tanyaJawab as $rowTanyaJawab) {
           			$tanya .=	'<tr>
		                            <td>'.$rowTanyaJawab["pertanyaan"].'</td>
		                            <td>Jawab : '.$rowTanyaJawab["jawaban"].'</td>
		                        </tr>';
           }
           $tanya .= "</tbody></table>";
       }*/
// echo count($tanyaJawab).$tanya;exit;
	// $docx->replaceVariableByText(array('no_register_perkara'=>$model['no_register_perkara']), array('parseLineBreaks'=>true));
	// $docx->replaceVariableByText(array('nama_ttd'=>$model['nama_ttd']), array('parseLineBreaks'=>true));
	// $docx->replaceVariableByText(array('nama'=>$model['nama']), array('parseLineBreaks'=>true));
	// $docx->replaceVariableByText(array('pangkat_ttd'=>$model['pangkat_ttd']), array('parseLineBreaks'=>true));
	// $docx->replaceVariableByText(array('jabatan_ttd'=>$model['jabatan_ttd']), array('parseLineBreaks'=>true));
	// $docx->replaceVariableByText(array('nip'=>$model['id_penandatangan']), array('parseLineBreaks'=>true));
	// $docx->replaceVariableByText(array('umur'=>$model['umur']), array('parseLineBreaks'=>true));
	// $docx->replaceVariableByText(array('jkl'=>$model['jkl']), array('parseLineBreaks'=>true));
	// $docx->replaceVariableByText(array('warganegara'=>$model['warganegara']), array('parseLineBreaks'=>true));
	// $docx->replaceVariableByText(array('agama'=>$model['agama']), array('parseLineBreaks'=>true));
	// $docx->replaceVariableByText(array('alamat'=>$model['alamat']), array('parseLineBreaks'=>true));
	// $docx->replaceVariableByText(array('pekerjaan'=>$model['pekerjaan']), array('parseLineBreaks'=>true));
	// $docx->replaceVariableByText(array('tmpt_lahir'=>$model['tmpt_lahir']), array('parseLineBreaks'=>true));
	// $docx->replaceVariableByText(array('tgl_lahir'=>Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_lahir'])), array('parseLineBreaks'=>true));
	// $docx->replaceVariableByText(array('alasan'=>$model['alasan']), array('parseLineBreaks'=>true));
	// $docx->replaceVariableByText(array('pendidikan'=>$model['pendidikan']), array('parseLineBreaks'=>true));
                
    $status_tindakan    = PdmMsTindakanStatus::findOne(['id'=>$model['tindakan_status']]);
//        echo $status_tindakan;exit();
	$docx->replaceVariableByText(array('status'=>ucfirst(strtoupper($model['tindakan_status']=='1' ? 'Penahanan' : 'Pengalihan Jenis Penahanan'))), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('status1'=>$model['tindakan_status']=='1' ? 'Penahanan' : 'Pengalihan Jenis Penahanan'), array('parseLineBreaks'=>true));

	$docx->replaceVariableByText(array('status2'=>ucfirst(strtolower($model['tindakan_status']=='1' ? 'Menahan' : 'Pengalihan Jenis Penahanan'))), array('parseLineBreaks'=>true));


	$val='';
    if(substr($model['no_surat_t7'],(strlen($model['no_surat_t7'])-1),1)!=='^'){
        $val = $model['no_surat_t7'];
    }

    //echo '<pre>';print_r($model['no_surat_t7']);exit;

    //echo '<pre>';print_r($model);exit;
    $nota_pendapat = PdmNotaPendapat::findOne(['no_register_perkara'=>$model['no_register_perkara'], 'id_nota_pendapat'=>$model['id_nota_pendapat']]);


    //echo '<pre>';print_r($nota_pendapat);exit;
	$docx->replaceVariableByText(array('no_surat_t7'=>$val), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('satker'=>$satker), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('jabatan'=>$model['jabatan']), array('parseLineBreaks'=>true));

	$docx->replaceVariableByText(array('modelUndang'=>$model['undang']), array('parseLineBreaks'=>true));

	$docx->replaceVariableByText(array('nomorBerkas'=>$model['no_berkas']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tanggalBerkas'=>Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_berkas'])), array('parseLineBreaks'=>true));
	$dasar6 = "";
	$dasar7 = "";
	$nodasar6 = "";
	$nodasar7 = "";

	//echo '<pre>';print_r($model['tindakan_status']);exit;
	//$pertimbangan = '<table border="0" width="100%">';
	
	if($model['tindakan_status']=='1'){
		$dasar6 = 'Saran pendapat dari '.$nota_pendapat["dari_nama_jaksa_p16a"].', dengan pangkat '.$nota_pendapat["dari_pangkat_jaksa_p16a"].', dan NIP '.$nota_pendapat["dari_nip_jaksa_p16a"].' Jaksa Penuntut Umum pada '.ucwords(strtolower($satker));
		$nodasar6 = "6";

		$timb = 'Berdasarkan hasil pemeriksaan berkas dari Penyidik, diperoleh bukti yang cukup, terdakwa diduga keras melakukan tindak pidana yang dapat dikenakan penahanan, dan dikhawatirkan akan melarikan diri, merusak dan menghilangkan barang bukti dan atau mengulangi tindak';
	}else{
		$prevT7 = PdmT7::find()->where(['no_register_perkara'=>$model['no_register_perkara'], 'no_urut_tersangka'=>$model['no_urut_tersangka']])
			->andWhere(['<', 'tgl_dikeluarkan', $model['tgl_dikeluarkan']])
			->orderBy('tgl_dikeluarkan asc')->limit(1)->One();

		$dasar6 = 'Surat perintah penahanan dari '.ucwords(strtolower($satker)).' no '.$prevT7['no_surat_t7'].' tanggal '.Yii::$app->globalfunc->ViewIndonesianFormat($prevT7['tgl_dikeluarkan']);
		$nodasar6 = "6";
		$dasar7 = 'Saran pendapat dari '.$nota_pendapat["dari_nama_jaksa_p16a"].', dengan pangkat '.$nota_pendapat["dari_pangkat_jaksa_p16a"].', dan NIP '.$nota_pendapat["dari_nip_jaksa_p16a"].' Jaksa Penuntut Umum pada '.ucwords(strtolower($satker));
		$nodasar7 = "7";

		$timb = 'Bahwa syarat-syarat yang telah ditentukan Undang-undang, tingkat penyelesaian perkara, keadaan terdakwa, situasi masyarakat setempat telah terpenuhi, sehingga dipandang perlu untuk mengalihkan jenis penahanan';
	}

	//echo '<pre>';print_r($pertimbangan);exit;

	$docx->replaceVariableByText(array('timb'=>$timb), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('dasar6'			=> $dasar6), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('dasar7'			=> $dasar7), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nodasar6'		=> $nodasar6), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nodasar7'		=> $nodasar7), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('KasusPosisi'	=> $model["kasus_posisi"]), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('namaJaksa'		=> $model["nama_jaksa"]), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('pangkatJaksa'	=> $model["pangkat"]), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nipJaksa'		=> $model["id_penandatangan"]), array('parseLineBreaks'=>true));

	$docx->replaceVariableByText(array('nama'=>$model['nama_tersangka_ba4']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('umur'=>$model['umur']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('jkl'=>$model['jkl']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('warganegara'=>$model['warganegara']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('agama'=>$model['agama']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('alamat'=>$model['alamat']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('pekerjaan'=>$model['pekerjaan']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tmpt_lahir'=>$model['tmpt_lahir']), array('parseLineBreaks'=>true));	
	$docx->replaceVariableByText(array('pendidikan'=>$model['pendidikan']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_lahir'=>Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_lahir'])), array('parseLineBreaks'=>true));


	$docx->replaceVariableByText(array('no_reg_tahanan'=>$model['no_reg_tahanan_jaksa']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('no_register_perkara'=>$model['no_register_perkara']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('rutan'=>$model['lokasi_tahanan']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('lokasi'=>$model['loktahanan']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('selama'=>$model['lama']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_mulai'=>Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_mulai'])), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_selesai'=>Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_selesai'])), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('dikeluarkan'=>$model['dikeluarkan']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_dikeluarkan'=>Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_dikeluarkan'])), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nama_penandatangan'=>$model['nama_ttd_t7']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('pangkat_penandatangan'=>$model['pangkat_ttd_t7']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nip_penandatangan'=>$model['nip_ttd_t7']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nip_penandatangan'=>$model['nip_ttd_t7']), array('parseLineBreaks'=>true));
		$no=0;
		$tembusan_surat = "";
		foreach($tembusan as $_tembusan){
			$no++;
			$tembusan_surat .= '<span style="font-family:Trebuchet MS; font-size:11pt;">'.$no.'. '.$_tembusan['tembusan'].'</span><br />';
		}
	$docx->replaceVariableByHTML('tembusan', 'inline', $tembusan_surat, $arrDocnya);


	$jpu = json_decode($model['json_jpu']);
	$jaks = '<table border="0" width="100%" ><tbody>';
	//echo '<pre>';print_r($jpu);exit;
	for ($i=0; $i < count($jpu->no_urut); $i++) { 
		//$jaks .= 'Nama : '.$jpu->nama_jpu[$i].'<br>'.'Pangkat / NIP : ';

		$jaks .= '<tr><td width="5%" height="0%" style="font-family:Times New Roman; font-size:11pt;" >'.$jpu->no_urut[$i].'.</td>
		               <td width="31%" height="0%" style="font-family:Times New Roman; font-size:11pt;">Nama</td>
		               <td width="6%" height="0%" style="font-family:Times New Roman; font-size:11pt;">: </td>
		               <td width="48%" height="0%" style="font-family:Times New Roman; font-size:11pt;">'.$jpu->nama_jpu[$i].'</td></tr>
		           <tr><td style="font-family:Times New Roman; font-size:11pt;" ></td>
		               <td style="font-family:Times New Roman; font-size:11pt;">Pangkat / NIP</td>
		               <td style="font-family:Times New Roman; font-size:11pt;">: </td>
		               <td style="font-family:Times New Roman; font-size:11pt;">'.$jpu->gol_jpu[$i].' / '.$jpu->nip_baru[$i].'</td></tr>
		            <tr><td></td>
		            	<td></td>
		            	<td></td>
		            	<td></td>
		            </tr>';

	}
	$jaks .= '<tr><td style="font-family:Times New Roman; font-size:11pt;" ></td>
		               <td style="font-family:Times New Roman; font-size:11pt;">Pada Kejaksaan Negeri</td>
		               <td style="font-family:Times New Roman; font-size:11pt;">: </td>
		               <td style="font-family:Times New Roman; font-size:11pt;">'.$satker.'</td></tr>';
	$jaks .= '</table>';
	$docx->replaceVariableByHTML('jpu', 'block', $jaks, $arrDocnya);
	

	$pertimbangan = '';

	$docx->createDocx('../web/template/pidum_surat/t-7');
	$file = '../web/template/pidum_surat/t-7.docx';
	// echo $file;exit;
	// echo $file_exists($file);exit;
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