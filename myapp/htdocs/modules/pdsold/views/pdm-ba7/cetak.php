<?php
	use app\modules\datun\models\Sp1;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../web/template/pdsold/BA-7.docx');
	$satker = Yii::$app->globalfunc->getSatker()->inst_nama ;
	
		$tanya = '';
	 if (count($tanyaJawab) != 0) {
	 		$tanya = '<table border="0" width="100%" style="border-collapse:collapse;"><tbody>';
           foreach ($tanyaJawab as $rowTanyaJawab) {
           			$tanya .=	'<tr>
		                            <td>'.$rowTanyaJawab["pertanyaan"].'</td>
		                            <td>Jawab : '.$rowTanyaJawab["jawaban"].'</td>
		                        </tr>';
           }
           $tanya .= "</tbody></table>";
       }

	$docx->replaceVariableByText(array('no_surat_t7'=>$model['no_surat_t7']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('satker'=>$satker), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('jabatan'=>$model['jabatan']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('noUUD'=>$model['undang']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tahunUUd'=>$model['tahun']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tentang'=>$model['tentang']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nomorBerkas'=>$model['no_berkas']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tanggalBerkas'=>$model['tgl_berkas']), array('parseLineBreaks'=>true));
	$dasar6 = "";
	$dasar7 = "";
	$nodasar6 = "";
	$nodasar7 = "";

	if($model['no_surat_perintah']==''&&$model['tgl_srt_perintah']=='')
	{
		$dasar6 = 'Saran pendapat dari '.$model["nama_jaksa"].', dengan pangkat '.$model["pangkat_jaksa"].', dan NIP '.$model["nip_jaksa"].' Jaksa Penuntut Umum pada '.$satker;
		$nodasar6 = "6";
	}
	else
	{
		$dasar6 = 'Surat perintah penahanan dari '.$model['penahanan_dari'].' no '.$model['no_surat_perintah'].' tanggal '.$model['tgl_srt_perintah'];
		$nodasar6 = "6";
		$dasar7 = 'Saran pendapat dari '.$model["nama_jaksa"].', dengan pangkat '.$model["pangkat_jaksa"].', dan NIP '.$model["nip_jaksa"].' Jaksa Penuntut Umum pada '.$satker;
		$nodasar7 = "7";
	}

	$docx->replaceVariableByText(array('dasar6'			=> $dasar6), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('dasar7'			=> $dasar7), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nodasar6'		=> $nodasar6), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nodasar7'		=> $nodasar7), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('kasus_posisi'	=> $model["kasus_posisi"]), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('namaJaksa'		=> $model["nama_jaksa"]), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('pangkatJaksa'	=> $model["pangkat_jaksa"]), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nipJaksa'		=> $model["nip_jaksa"]), array('parseLineBreaks'=>true));

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


	$docx->replaceVariableByText(array('tgl_srt_perintah'=>Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_srt_perintah'])), array('parseLineBreaks'=>true));

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

	$docx->replaceVariableByText(array('kepala_rutan'			=> $modelba7['kepala_rutan']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('hari'=>Yii::$app->globalfunc->GetNamaHari($model['tgl_ba4'])), array('parseLineBreaks'=>true));
	$split = explode("-",$modelba7['tgl_ba7']);
	$docx->replaceVariableByText(array('tgl_ba4'=>Yii::$app->globalfunc->ViewIndonesianFormat($modelba7['tgl_ba7'])), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tanggal_text'=>Yii::$app->globalfunc->getTerbilang($split[2])), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('bulan_text'=>Yii::$app->globalfunc->getNamaBulan(str_replace("0","", $split[1]))), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tahun_text'=>Yii::$app->globalfunc->getTerbilang($split[0])), array('parseLineBreaks'=>true));

	$docx->replaceVariableByText(array('tindakan_status'=>$model['ur_tindakan_status']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('lama'=>$modelba7['lama']), array('parseLineBreaks'=>true));
	//echo '<pre>';print_r($varUU);exit;
	$docx->replaceVariableByText(array('pslx'=>$varUU), array('parseLineBreaks'=>true));
	// 	$no=0;
	// 	$tembusan_surat = "";
	// 	foreach($tembusan as $_tembusan){
	// 		$no++;
	// 		$tembusan_surat .= '<span style="font-family:Trebuchet MS; font-size:11pt;">'.$no.'. '.$_tembusan['tembusan'].'</span><br />';
	// 	}
	// $docx->replaceVariableByHTML('tembusan', 'inline', $tembusan_surat, $arrDocnya);
	// $docx->replaceVariableByText(array('no_register_tahanan'=>$model['no_reg_tahanan']), array('parseLineBreaks'=>true));
	// $docx->replaceVariableByText(array('hari'=>Yii::$app->globalfunc->GetNamaHari($model['tgl_ba4'])), array('parseLineBreaks'=>true));
	// $split = explode("-",$model['tgl_ba4']);
	// $docx->replaceVariableByText(array('tgl_ba4'=>Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_ba4'])), array('parseLineBreaks'=>true));
	// $docx->replaceVariableByText(array('tanggal_text'=>Yii::$app->globalfunc->getTerbilang($split[2])), array('parseLineBreaks'=>true));
	// $docx->replaceVariableByText(array('bulan_text'=>Yii::$app->globalfunc->getNamaBulan(str_replace("0","", $split[1]))), array('parseLineBreaks'=>true));
	// $docx->replaceVariableByText(array('tahun_text'=>Yii::$app->globalfunc->getTerbilang($split[0])), array('parseLineBreaks'=>true));
	// $docx->replaceVariableByHTML('tanya', 'block', $tanya, $arrDocnya);

	$docx->createDocx('../web/template/pdsold_surat/BA-7');
	$file = '../web/template/pdsold_surat/BA-7.docx';
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