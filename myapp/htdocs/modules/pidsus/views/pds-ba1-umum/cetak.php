<?php   use app\modules\pidsus\models\PdsBa1Umum;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../modules/pidsus/template/BA-1-Umum.docx');

	$namaSatker     = Yii::$app->inspektur->getNamaSatker();
	$lokSatker 	= Yii::$app->inspektur->getLokasiSatker()->lokasi;
	$almtSatker     = Yii::$app->inspektur->getLokasiSatker()->alamat;
        $tgl_ba1_umum = ($model['tgl_ba1_umum'])?date('d-m-Y',strtotime($model['tgl_ba1_umum'])):'';
        $tgl_p8_umum = ($model['tgl_p8_umum'])?date('d-m-Y',strtotime($model['tgl_p8_umum'])):'';
        $tgl_lahir = ($model['tgl_lahir'])?date('d-m-Y',strtotime($model['tgl_lahir'])):'';
        
        $whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' 
						and no_p8_umum = '".$_SESSION["pidsus_no_p8_umum"]."'";
        
        $no_ba1_umum    = ($model['isDraft'] && $model['no_ba1_umum']=="")?'null':"'".$model['no_ba1_umum']."'";
        $sql = "select * from pidsus.pds_ba1_umum_pertanyaan where ".$whereDefault." and no_ba1_umum = ".$no_ba1_umum." order by no_urut";
	$res = PdsBa1Umum::findBySql($sql)->asArray()->all();
        
	$pertanyaan = '<table border="0" width="100%" style="border-collapse:collapse;"><tbody>';
	if(count($res) > 0){
		$nom1 = 0;
		foreach($res as $data1){
			$nom1++;
			$pertanyaan .= '
				<tr>
					<td class="text-center" width="5%">'.$nom1.'</td>
					<td>'.$data1['pertanyaan'].'</td>
				</tr>
                                <tr><td colspan="2">&nbsp;</td></tr>
                                <tr>
					<td class="text-center">&nbsp;</td>
					<td>'.$data1['jawaban'].'</td>
				</tr>
                                <tr><td colspan="2">&nbsp;</td></tr>
			';
		}
	} else{
		$pertanyaan .= '
			<tr>
                            <td class="text-center" width="5%">1.</td>
                            <td>..................................................................</td>
                        </tr>
                        <tr><td colspan="2">&nbsp;</td></tr>
                        <tr>
                            <td class="text-center">&nbsp;</td>
                            <td>..................................................................</td>
                        </tr>
                        <tr><td colspan="2">&nbsp;</td></tr>
		';
	}
	$pertanyaan .= '</tbody></table>';
        
        $status    = ($model['isDraft'] && $model['status']=="")?'........................................':$model['status'];
        $hari_ba1  = ($model['isDraft'] && $model['tgl_ba1_umum']=="")?'........................................':Yii::$app->globalfunc->GetNamaHari($model['tgl_ba1_umum']);
        $tgl_ba1_umum  = ($model['isDraft'] && $model['tgl_ba1_umum']=="")?'........................................':tgl_indo($tgl_ba1_umum);
        $tempat    = ($model['isDraft'] && $model['tempat']=="")?'........................................':$model['tempat'];
        $no_p8_umum    = ($model['isDraft'] && $model['no_p8_umum']=="")?'........................................':$model['no_p8_umum'];
        $tgl_p8_umum    = ($model['isDraft'] && $tgl_p8_umum=="")?'........................................':tgl_indo($tgl_p8_umum);
        
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
	$docx->replaceVariableByText(array('saksi_tsk'=>strtoupper($status)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('saksi_tsk1'=>strtolower($status)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('hari_ba1'=>$hari_ba1), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tanggal_ba1'=>$tgl_ba1_umum), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tempat_ba1'=>$tempat), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nama_jaksa'=>$nama_jaksa), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('pangkat_jaksa'=>$pangkat_jaksa), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nip_jaksa'=>$nip_jaksa), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nomor_p8'=>$no_p8_umum), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tanggal_p8'=>$tgl_p8_umum), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('nama'=>$nama), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tmp_lahir'=>$tmpt_lahir), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('umur'=>$umur), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_lahir'=>$tgl_lahir), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('jk'=>$id_jkl), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('bangsa'=>$kebangsaan), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tmp_tinggal'=>$alamat), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('agama'=> $agama), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('pekerjaan'=>$pekerjaan), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('pendidikan'=>$pendidikan), array('parseLineBreaks'=>true));
        $docx->replaceVariableByHTML('tabel_pertanyaan', 'block', $pertanyaan, $arrDocnya);
        
        $docx->createDocx('template/pidsus/BA-1-Umum');
	$file = 'template/pidsus/BA-1-Umum.docx';
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