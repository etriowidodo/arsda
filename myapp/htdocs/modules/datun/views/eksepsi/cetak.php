<?php
	use app\modules\datun\models\Sp1;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');

	$docx 		= new CreateDocxFromTemplate('../modules/datun/template/S-14.docx');
	$title		= Yii::$app->inspektur->getNamaSatker();	
	$alamat		= Yii::$app->inspektur->getLokasiSatker()->alamat;
	$lokasi		= Yii::$app->inspektur->getLokasiSatker()->lokasi;
	$arrDocnya 	= array('isFile'=>false, 'parseDivsAsPs'=>true, 'downloadImages'=>false);

	function integerToRoman($n){
		$n = intval($n);
		$result = '';
		$lookup = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
		foreach($lookup as $roman => $value){
			$matches = intval($n/$value);			 
			$result .= str_repeat($roman,$matches);	 
			$n = $n % $value;
		}
		return $result;
	}	


		
	$convert 	= ($model['kepada_yth'])?$model['kepada_yth']:'............';		
	$cpimpinan_pemohon	=($model['pimpinan_pemohon']!=''?$model['pimpinan_pemohon']:'............');
	$tgl_s14 	= ($model['tanggal_diterima_s14'])?date("d-m-Y", strtotime($model['tanggal_diterima_s14'])):"";

	$tmp_pggt 	= explode("#", $model['penggugat']);
	$penggugat 	= (count($tmp_pggt) > 1)?$tmp_pggt[0].', Dkk':$tmp_pggt[0];
		
					
	if($model['no_register_skks'] != ''){
		$sqlx = "
		select nip_pegawai, nama_pegawai from datun.skks_anak
		where no_register_perkara = '".$model['no_register_perkara']."' and no_surat = '".$model['no_surat']."' and no_register_skk = '".$model['no_register_skk']."' 
			and tanggal_skk = '".$model['tanggal_skk']."' and no_register_skks = '".$model['no_register_skks']."' 
		order by no_urut";
	} else if($model['no_register_skk']!=''){		
		$sqlx = "
		select nip_pegawai, nama_pegawai from datun.skk_anak 
		where no_register_perkara = '".$model['no_register_perkara']."' and no_surat = '".$model['no_surat']."' and no_register_skk = '".$model['no_register_skk']."' 
			and tanggal_skk = '".$model['tanggal_skk']."' 
		order by no_urut";
	} 
	$model_jpn = Sp1::findBySql($sqlx)->asArray()->all();			
	if(count($model_jpn) > 0){
		$jaksa_negara = '<table border="0" width="100%" style="border-collapse:collapse;"><tbody>';
		$nom1 = 0;
		$css1 = 'style="font-family:Trebuchet MS; font-size:11pt; font-weight:bold;" width="50%" align="left"';
		$css2 = '<br /><br /><br /><br />';
		foreach($model_jpn as $data1){
			$nom1++;
			$jaksa_negara .= (($nom1 % 2) != 0)?'<tr><td '.$css1.'>'.$css2.$data1['nama_pegawai'].'</td>':'<td '.$css1.'>'.$css2.$data1['nama_pegawai'].'</td></tr>';
		}
		$jaksa_negara .= ((count($model_jpn) % 2) != 0)?'<td '.$css1.'>&nbsp;</td></tr>':'';
		$jaksa_negara .= '</tbody></table>';
	} else{
		$jaksa_negara = '<p>&nbsp;</p>';
	}
		
	$docx->replaceVariableByText(array('kejaksaan'=>strtoupper($title)), array('parseLineBreaks'=>true));
	
	$docx->replaceVariableByText(array('tergugat'=>strtoupper($model['status_pemohon']).' '.integerToRoman($model['no_status_pemohon'])), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('penggugat'=>strtoupper($penggugat)), array('parseLineBreaks'=>true));	
	$docx->replaceVariableByText(array('noreg'=>strtoupper($model['no_register_perkara'])), array('parseLineBreaks'=>true));	
	$docx->replaceVariableByText(array('pengadilan'=>strtoupper($model['nama_pengadilan'])), array('parseLineBreaks'=>true));	
	$docx->replaceVariableByText(array('pimpinan_pemohon'=>$model['deskripsi_inst_wilayah']),array('parseLineBreaks'=>true));	
	
	$docx->replaceVariableByText(array('dikeluarkan'=>$lokasi), array('parseLineBreaks'=>true));	
	$docx->replaceVariableByText(array('tgl_s14'=>tgl_indo($tgl_s14)), array('parseLineBreaks'=>true));	
	$docx->replaceVariableByText(array('yth'=>$convert),array('parseLineBreaks'=>true));	
	$docx->replaceVariableByText(array('di'=>($model['tempat'])?$model['tempat']:'............'), array('parseLineBreaks'=>true));	
		
	$docx->replaceVariableByHTML('alasan','block','<div style="margin-left:18px;line-height:30px;font-family:Trebuchet MS;">'.$model['alasan'].'</div>', $arrDocnya);	
	$docx->replaceVariableByHTML('primair','inline','<div style="margin-left:18px;line-height:30px;font-family:Trebuchet MS;">'.($model['primair']?$model['primair']:'............').'</div>', $arrDocnya);	
	$docx->replaceVariableByHTML('subsidair','block','<div style="margin-left:18px;line-height:30px;font-family:Trebuchet MS;">'.$model['subsidair'].'</div>', $arrDocnya);			
	
	$docx->replaceVariableByHTML('timJpn', 'block', $jaksa_negara, $arrDocnya);	


	$docx->createDocx('template/datun/S-14_EKSEPSI');	
	$file = 'template/datun/S-14_EKSEPSI.docx';
	
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