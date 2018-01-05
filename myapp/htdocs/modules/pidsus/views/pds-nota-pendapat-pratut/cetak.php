<?php
	use app\modules\datun\models\Sp1;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../modules/pidsus/template/Nota-Pendapat-T4.docx');

	$namaSatker     = Yii::$app->inspektur->getNamaSatker();
	$lokSatker 	= Yii::$app->inspektur->getLokasiSatker()->lokasi;
	$almtSatker     = Yii::$app->inspektur->getLokasiSatker()->alamat;
	$tgl_nota       = date('d-m-Y',strtotime($model['tgl_nota']));
        $tgl_minta_perpanjang       = date('d-m-Y',strtotime($model['tgl_minta_perpanjang']));
	$tgl_awal_penahanan_oleh_penyidik       = date('d-m-Y',strtotime($model['tgl_awal_penahanan_oleh_penyidik']));
	$tgl_akhir_penahanan_oleh_penyidik       = date('d-m-Y',strtotime($model['tgl_akhir_penahanan_oleh_penyidik']));
	$tgl_awal_permintaan_perpanjangan       = date('d-m-Y',strtotime($model['tgl_awal_permintaan_perpanjangan']));
	$tgl_akhir_permintaan_perpanjangan       = date('d-m-Y',strtotime($model['tgl_akhir_permintaan_perpanjangan']));
        $whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' and no_spdp = '".$_SESSION["no_spdp"]."' and tgl_spdp = '".$_SESSION["tgl_spdp"]."'";
          
	$sql1 = "select nip_jaksa_p16, nama_jaksa_p16, jabatan_jaksa_p16, pangkat_jaksa_p16  
			from pidsus.pds_nota_pendapat_t4_jaksa where ".$whereDefault." and no_minta_perpanjang = '".$model['no_minta_perpanjang']."'";
	$res1 = Sp1::findBySql($sql1)->asArray()->all();
	$jaksa_negara = '<table border="0" width="100%" style="border-collapse:collapse;"><tbody>';
        $hasil_jaksa = '<table border="0" width="100%"><tbody>';
	if(count($res1) > 0){
		$nom1 = 0;
		foreach($res1 as $data1){
			$nom1++;
			$jaksa_negara .= '
			<tr>
                            <td width="9%" height="0%" style="font-family:Times New Roman; font-size:11pt;" >'.$nom1.'.</td>
                            <td width="15%" height="0%" style="font-family:Times New Roman; font-size:11pt;">Nama</td>
                            <td width="3%" height="0%" style="font-family:Times New Roman; font-size:11pt;">: </td>
                            <td width="55%" height="0%" style="font-family:Times New Roman; font-weight: bold; font-size:11pt;">'.$data1["nama_jaksa_p16"].'</td></tr>
                        <tr>
                            <td style="font-family:Times New Roman; font-size:11pt;" ></td>
                            <td style="font-family:Times New Roman; font-size:11pt;">Pangkat / NIP</td>
                            <td style="font-family:Times New Roman; font-size:11pt;">: </td>
                            <td style="font-family:Times New Roman; font-size:11pt;">'.$data1["pangkat_jaksa_p16"].'/'.$data1["nip_jaksa_p16"].'</td>
                        </tr>
                        <tr>
                            <td style="font-family:Times New Roman; font-size:11pt;" ></td>
                            <td style="font-family:Times New Roman; font-size:11pt;">Jabatan</td>
                            <td style="font-family:Times New Roman; font-size:11pt;">: </td>
                            <td style="font-family:Times New Roman; font-size:11pt;">'.$data1["jabatan_jaksa_p16"].'</td>
                        </tr>
			';
                         $hasil_jaksa .= '<tr><td width="90%" height="0%" style="font-family:Times New Roman; text-align: center; font-weight: bold; font-size:11pt;">'.ucfirst(strtoupper($data1["jabatan_jaksa_p16"])).'</td></tr>
                            <tr><td ></td></tr>
                            <tr><td ></td></tr>
                            <tr><td ></td></tr>
                            <tr><td width="90%" height="0%" style="font-family:Times New Roman; text-align: center; font-weight: bold; font-size:11pt;"><u>'.ucfirst(strtoupper($data1["nama_jaksa_p16"])).'</u></td></tr>
                            <tr><td style="font-family:Times New Roman; text-align: center; font-size:11pt;">'.$data1["pangkat_jaksa_p16"].'/'.$data1["nip_jaksa_p16"].'</td></tr>
                            <tr><td ></td></tr>
                           ';
		}
	} else{
		$jaksa_negara .= '
			<tr>
                            <td width="9%" height="0%" style="font-family:Times New Roman; font-size:11pt;" >.</td>
                            <td width="15%" height="0%" style="font-family:Times New Roman; font-size:11pt;">Nama</td>
                            <td width="3%" height="0%" style="font-family:Times New Roman; font-size:11pt;">: </td>
                            <td width="55%" height="0%" style="font-family:Times New Roman; font-weight: bold; font-size:11pt;"></td></tr>
                        <tr>
                            <td style="font-family:Times New Roman; font-size:11pt;" ></td>
                            <td style="font-family:Times New Roman; font-size:11pt;">Pangkat / NIP</td>
                            <td style="font-family:Times New Roman; font-size:11pt;">: </td>
                            <td style="font-family:Times New Roman; font-size:11pt;"></td>
                        </tr>
                        <tr>
                            <td style="font-family:Times New Roman; font-size:11pt;" ></td>
                            <td style="font-family:Times New Roman; font-size:11pt;">Jabatan</td>
                            <td style="font-family:Times New Roman; font-size:11pt;">: </td>
                            <td style="font-family:Times New Roman; font-size:11pt;"></td>
                        </tr>
		';
                $hasil_jaksa .= '<tr><td width="90%" height="0%" style="font-family:Times New Roman; text-align: center; font-weight: bold; font-size:11pt;"></td></tr>
                            <tr><td ></td></tr>
                            <tr><td ></td></tr>
                            <tr><td ></td></tr>
                            <tr><td width="90%" height="0%" style="font-family:Times New Roman; text-align: center; font-weight: bold; font-size:11pt;"><u></u></td></tr>
                            <tr><td style="font-family:Times New Roman; text-align: center; font-size:11pt;"></td></tr>
                            <tr><td ></td></tr>
                           ';
	}
	$jaksa_negara .= '</tbody></table>';
        $hasil_jaksa .= "</tbody></table>";

	$docx->replaceVariableByText(array('satker'=>strtoupper($namaSatker)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('hari1'=>Yii::$app->globalfunc->GetNamaHari($model['tgl_nota'])), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl'=>tgl_indo($tgl_nota)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByHTML('jaksa', 'block', $jaksa_negara, $arrDocnya);
        $docx->replaceVariableByText(array('id_perpanjangan'=>$model['no_minta_perpanjang']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl_nota'=>tgl_indo($tgl_minta_perpanjang)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('penyidik'=>$model['penyidik']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tersangka'=>$model['tersangka']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl_awal'=>tgl_indo($tgl_awal_penahanan_oleh_penyidik)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl_akhir'=>tgl_indo($tgl_akhir_penahanan_oleh_penyidik)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('pasal'=>$model['undang_pasal']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('hari'=>$model['persetujuan']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl_awal_1'=>tgl_indo($tgl_awal_permintaan_perpanjangan)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl_akhir_1'=>tgl_indo($tgl_akhir_permintaan_perpanjangan)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('kota'=>$model['kota']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByHTML('hasil_jaksa', 'block', $hasil_jaksa, $arrDocnya);
        
	$docx->createDocx('template/pidsus/Nota-Pendapat-T4');
	$file = 'template/pidsus/Nota-Pendapat-T4.docx';
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