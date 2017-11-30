<?php
	use app\modules\datun\models\Sp1;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	use app\modules\pidum\models\MsInstPelakPenyidikan;
	use app\modules\pidum\models\PdmBerkasTahap1;

		
	$docx = new CreateDocxFromTemplate('../web/template/pidum/BA-4.docx');
	$satker = Yii::$app->globalfunc->getSatker()->inst_nama ;

	$tanya = '<br>';
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
// echo count($tanyaJawab).$tanya;exit;
    $berkas = PdmBerkasTahap1::findOne(['id_berkas'=>$tahapDua['id_berkas']])->no_berkas;
    //echo '<pre>';print_r($berkas);exit;
	$docx->replaceVariableByText(array('no_berkas'=>$berkas), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nama_ttd'=>$model['nama_ttd']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nama'=>$model['nama']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('pangkat_ttd'=>$model['pangkat_ttd']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('jabatan_ttd'=>$model['jabatan_ttd']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nip'=>$model['id_penandatangan']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('umur'=>$model['umur'].' Tahun'), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('jkl'=>$model['jkl']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('warganegara'=>$model['warganegara']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('agama'=>$model['agama']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('alamat'=>$model['alamat']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('pekerjaan'=>$model['pekerjaan']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tmpt_lahir'=>$model['tmpt_lahir']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_lahir'=>Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_lahir'])), array('parseLineBreaks'=>true));

	if($model['alasan']!="")
	{
		$docx->replaceVariableByText(array('sesuai'=>' Tidak Sesuai '), array('parseLineBreaks'=>true));
		$docx->replaceVariableByText(array('alasan'=>' dengan alasan :  '.$model['alasan']."."), array('parseLineBreaks'=>true));
	}
	else
	{
		$docx->replaceVariableByText(array('alasan'=>'.'), array('parseLineBreaks'=>true));
		$docx->replaceVariableByText(array('sesuai'=>' Sesuai '), array('parseLineBreaks'=>true));
	}
	
	if($model['jns_penahanan_penyidik']==1){
		$awal = Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_awal_penyidik']);
		$akhir = Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_akhir_penyidik']);
		if($model['jns_penahanan_jaksa']==1){
			$akhir = Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_akhir_jaksa']);
		}elseif($model['jns_penahanan_pn']==1){
			$akhir = Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_akhir_pn']);
		}

		$sejak = $awal.' s/d '.$akhir;
	}else{
		$sejak = '-';
	}

	$docx->replaceVariableByText(array('sejak'=>$sejak), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('pendidikan'=>$model['pendidikan']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('satker'=>$satker), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('no_register_tahanan'=>$model['no_reg_tahanan']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('hari'=>Yii::$app->globalfunc->GetNamaHari($model['tgl_ba4'])), array('parseLineBreaks'=>true));
	$split = explode("-",$model['tgl_ba4']);
	$docx->replaceVariableByText(array('tgl_ba4'=>Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_ba4'])), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('inst_sidik'=>MsInstPelakPenyidikan::findOne(['kode_ipp'=>$spdp->id_penyidik])->nama), array('parseLineBreaks'=>true));
	//$docx->replaceVariableByText(array('tanggal_text'=>Yii::$app->globalfunc->getTerbilang($split[2])), array('parseLineBreaks'=>true));
	//$docx->replaceVariableByText(array('bulan_text'=>Yii::$app->globalfunc->getNamaBulan(str_replace("0","", $split[1]))), array('parseLineBreaks'=>true));
	//$docx->replaceVariableByText(array('tahun_text'=>Yii::$app->globalfunc->getTerbilang($split[0])), array('parseLineBreaks'=>true));
	$docx->replaceVariableByHTML('tanya', 'block', $tanya, $arrDocnya);
	// $docx->replaceVariableByText(array('nama_kejaksaan'=>strtoupper($namaSatker)), array('parseLineBreaks'=>true));
	// $docx->replaceVariableByText(array('no_sp1'=>$model['no_sp1']), array('parseLineBreaks'=>true));
	// $docx->replaceVariableByText(array('bidang_kejaksaan'=>$arrBidang[$kode_tk]), array('parseLineBreaks'=>true));
	// $docx->replaceVariableByText(array('bidang_kejaksaan_initcap'=>ucwords(strtolower($arrBidang[$kode_tk]))), array('parseLineBreaks'=>true));
	// $docx->replaceVariableByText(array('instansi_wilayah'=>$model['deskripsi_inst_wilayah']), array('parseLineBreaks'=>true));
	// $docx->replaceVariableByText(array('no_permohonan'=>$model['no_surat']), array('parseLineBreaks'=>true));
	// $docx->replaceVariableByText(array('tgl_permohonan'=>tgl_indo($tgl_permohonan)), array('parseLineBreaks'=>true));
	// $docx->replaceVariableByText(array('permasalahan'=>$model['permasalahan_pemohon']), array('parseLineBreaks'=>true));
	// $docx->replaceVariableByText(array('lokasi_keluar'=>$lokSatker), array('parseLineBreaks'=>true));
	// $docx->replaceVariableByText(array('tgl_ttd'=>tgl_indo($tgl_ttd)), array('parseLineBreaks'=>true));
	// $docx->replaceVariableByText(array('ttd_jabatannya'=>$jabatan_ttd), array('parseLineBreaks'=>true));
	// $docx->replaceVariableByText(array('ttd_nama'=>$model['penandatangan_nama']), array('parseLineBreaks'=>true));
	// $docx->replaceVariableByText(array('ttd_detil'=>$model['penandatangan_pangkat'].' NIP.'.$model['penandatangan_nip']), array('parseLineBreaks'=>true));
	// $docx->replaceVariableByHTML('timJPN', 'block', $jaksa_negara, $arrDocnya);
	// $docx->replaceVariableByHTML('tembusan', 'inline', $tembusan_surat, $arrDocnya);

	$docx->createDocx('../web/template/pidum_surat/ba-4');
	$file = '../web/template/pidum_surat/ba-4.docx';

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
	
	}
//}
exit;
?>