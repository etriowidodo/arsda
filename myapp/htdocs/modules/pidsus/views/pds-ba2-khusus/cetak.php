<?php   use app\modules\pidsus\models\PdsBa2Khusus;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../modules/pidsus/template/BA-2-Khusus.docx');

	$namaSatker     = Yii::$app->inspektur->getNamaSatker();
	$lokSatker 	= Yii::$app->inspektur->getLokasiSatker()->lokasi;
	$almtSatker     = Yii::$app->inspektur->getLokasiSatker()->alamat;
        $tgl_ba2_khusus = ($model['tgl_ba2_khusus'])?date('d-m-Y',strtotime($model['tgl_ba2_khusus'])):'';
        $tgl_p8_khusus = ($model['tgl_p8_khusus'])?date('d-m-Y',strtotime($model['tgl_p8_khusus'])):'';
        $tgl_lahir = ($model['tgl_lahir'])?date('d-m-Y',strtotime($model['tgl_lahir'])):'';
        $tgl_keterangan = ($model['tgl_keterangan'])?date('d-m-Y',strtotime($model['tgl_keterangan'])):'';
        
        $whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' 
						and no_pidsus18 = '".$_SESSION["pidsus_no_pidsus18"]."' and no_p8_khusus = '".$_SESSION["pidsus_no_p8_khusus"]."'";
        $no_ba2_khusus    = ($model['isDraft'] && $model['no_ba2_khusus']=="")?'null':"'".$model['no_ba2_khusus']."'";
        $sql = "select * from pidsus.pds_ba2_khusus_saksi where ".$whereDefault." and no_ba2_khusus = ".$no_ba2_khusus." order by no_urut_saksi";
	$res = PdsBa2Khusus::findBySql($sql)->asArray()->all();
        
	$saksi = '<table border="0" width="100%" style="border-collapse:collapse;"><tbody>';
        $ttdsaksi = '<table border="0" width="100%" style="border-collapse:collapse;"><tbody>'
                . ' <tr><td style="font-family:Times New Roman; font-size:12pt; text-align:center;">Saksi-saksi</td></tr>';
	if(count($res) > 0){
		$nom1 = 0;
		foreach($res as $data1){
			$nom1++;
			$saksi .= '
				<tr>
					<td style="font-family:Times New Roman; font-size:12pt;" width="5%">'.$nom1.'</td>
					<td style="font-family:Times New Roman; font-size:12pt;" width="23%">Nama</td>
					<td style="font-family:Times New Roman; font-size:12pt;" width="2%">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;" width="70%">'.$data1['nama'].'</td>
				</tr>
				<tr>
					<td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
					<td style="font-family:Times New Roman; font-size:12pt;">Pangkat</td>
					<td style="font-family:Times New Roman; font-size:12pt;">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;">'.$data1['pangkat'].'</td>
				</tr>
				<tr>
					<td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
					<td style="font-family:Times New Roman; font-size:12pt;">NIP</td>
					<td style="font-family:Times New Roman; font-size:12pt;">:</td>
					<td style="font-family:Times New Roman; font-size:12pt;">'.$data1['nip'].'</td>
				</tr>
				<tr><td colspan="3">&nbsp;</td></tr>
			';
                        $ttdsaksi .= '
                                <tr><td>&nbsp;</td></tr>
                                <tr><td>&nbsp;</td></tr>
                                <tr><td>&nbsp;</td></tr>
                                <tr><td>&nbsp;</td></tr>
				<tr>
                                        <td style="font-family:Times New Roman; font-size:12pt;text-align:center;">('.$data1['nama'].')</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
			';
		}
	} else{
		$saksi .= '
			<tr>
                            <td style="font-family:Times New Roman; font-size:12pt;" width="5%">1.</td>
                            <td style="font-family:Times New Roman; font-size:12pt;" width="23%">Nama</td>
                            <td style="font-family:Times New Roman; font-size:12pt;" width="2%">:</td>
                            <td style="font-family:Times New Roman; font-size:12pt;" width="70%">............................</td>
                        </tr>
                        <tr>
                            <td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
                            <td style="font-family:Times New Roman; font-size:12pt;">Pangkat</td>
                            <td style="font-family:Times New Roman; font-size:12pt;">:</td>
                            <td style="font-family:Times New Roman; font-size:12pt;">............................</td>
                        </tr>
                        <tr>
                            <td style="font-family:Times New Roman; font-size:12pt;">&nbsp;</td>
                            <td style="font-family:Times New Roman; font-size:12pt;">NIP</td>
                            <td style="font-family:Times New Roman; font-size:12pt;">:</td>
                            <td style="font-family:Times New Roman; font-size:12pt;">............................</td>
                        </tr>
                        <tr><td colspan="3">&nbsp;</td></tr>
		';
                $ttdsaksi .= '
			<tr><td>&nbsp;</td></tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr>
                                <td style="font-family:Times New Roman; font-size:12pt;text-align:center;">(............................)</td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>
		';
	}
	$saksi .= '</tbody></table>';
	$ttdsaksi .= '</tbody></table>';
        
        $hari_ba2       = ($model['isDraft'] && $model['tgl_ba2_khusus']=="")?'........................................':Yii::$app->globalfunc->GetNamaHari($model['tgl_ba2_khusus']);
        $tgl_ba2_khusus   = ($model['isDraft'] && $model['tgl_ba2_khusus']=="")?'........................................':tgl_indo($tgl_ba2_khusus);
        $jam_ba2_khusus   = ($model['isDraft'] && $model['jam_ba2_khusus']=="")?'........................................':$model['jam_ba2_khusus'];
        $tempat         = ($model['isDraft'] && $model['tempat']=="")?'........................................':$model['tempat'];
        
        $nama_jaksa    = ($model['isDraft'] && $model['nama_jaksa']=="")?'........................................':$model['nama_jaksa'];
        $pangkat_jaksa = ($model['isDraft'] && $model['pangkat_jaksa']=="")?'........................................':$model['pangkat_jaksa'];
        $nip_jaksa     = ($model['isDraft'] && $model['nip_jaksa']=="")?'........................................':$model['nip_jaksa'];
        
        $nama       = ($model['isDraft'] && $model['nama']=="")?'........................................':$model['nama'];
        $tmpt_lahir = ($model['isDraft'] && $model['tmpt_lahir']=="")?'........................................':$model['tmpt_lahir'];
        $umur       = ($model['isDraft'] && $model['umur']=="")?'........................................':$model['umur'];
        $tgl_lahir  = ($model['isDraft'] && $tgl_lahir=="")?'........................................':tgl_indo($tgl_lahir);
        $jk = [1=>'Laki-laki','Perempuan'];
        $id_jkl     = ($model['isDraft'] && $model['id_jkl']=="")?'........................................':$jk[$model['id_jkl']];
        $kebangsaan = ($model['isDraft'] && $model['kebangsaan']=="")?'........................................':$model['kebangsaan'];
        $alamat     = ($model['isDraft'] && $model['alamat']=="")?'........................................':$model['alamat'];
        $agama      = ($model['isDraft'] && $model['agama']=="")?'........................................':ucfirst(strtolower($model['agama']));
        $pekerjaan  = ($model['isDraft'] && $model['pekerjaan']=="")?'........................................':$model['pekerjaan'];
        $pendidikan = ($model['isDraft'] && $model['pendidikan']=="")?'........................................':$model['pendidikan'];
        
        
	$docx->replaceVariableByText(array('Kejaksaan'=>strtoupper($namaSatker)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('kejaksaan1'=>$namaSatker), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('saksi_tsk'=>'SAKSI'), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('saksi_tsk1'=>'saksi'), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('hari_ba2'=>$hari_ba2), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tanggal_ba2'=>$tgl_ba2_khusus), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('jam_ba2'=>$jam_ba2_khusus), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tempat_ba2'=>$tempat), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nama_jaksa'=>$nama_jaksa), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('pangkat_jaksa'=>$pangkat_jaksa), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nip_jaksa'=>$nip_jaksa), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('nama'=>$nama), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tmp_lahir'=>$tmpt_lahir), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('umur'=>$umur), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_lahir'=>$tgl_lahir), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('jk'=>$id_jkl), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('bangsa'=>$kebangsaan), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tmp_tinggal'=>$alamat), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('agama'=>$agama), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('pekerjaan'=>$pekerjaan), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('pendidikan'=>$pendidikan), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_ba1'=>tgl_indo($tgl_keterangan)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('jml_saksi'=>$nom1), array('parseLineBreaks'=>true));
        $docx->replaceVariableByHTML('tabel_menyaksikan', 'block', $saksi, $arrDocnya);
        $docx->replaceVariableByHTML('tabel_ttdsaksi', 'block', $ttdsaksi, $arrDocnya);
                
        $docx->createDocx('template/pidsus/BA-2-Khusus');
	$file = 'template/pidsus/BA-2-Khusus.docx';
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