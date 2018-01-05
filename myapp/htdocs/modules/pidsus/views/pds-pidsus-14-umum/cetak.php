<?php
	use app\modules\pidsus\models\PdsPidsus14Umum;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../modules/pidsus/template/Pidsus-14-Umum.docx');

	$namaSatker     = Yii::$app->inspektur->getNamaSatker();
	$lokSatker 	= Yii::$app->inspektur->getLokasiSatker()->lokasi;
	$almtSatker     = Yii::$app->inspektur->getLokasiSatker()->alamat;
	$tgl_pidsus14_umum= date('d-m-Y',strtotime($model['tgl_pidsus14_umum']));
	$tgl_p8_umum 	= date('d-m-Y',strtotime($model['tgl_p8_umum']));
        $id_kejati	= $_SESSION['kode_kejati'];
        $id_kejari	= $_SESSION['kode_kejari'];
        $id_cabjari	= $_SESSION['kode_cabjari'];
        $whereDefault 	= "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_p8_umum = '".$_SESSION["pidsus_no_p8_umum"]."'";
        
        $kejaksaan      = ($id_kejati.$id_kejari.$id_cabjari=="000000")?'Direktur Penyidikan Jaksa Agung Muda Tindak Pidana Khusus': ucwords(strtolower($namaSatker));
        
        if($model['tindak_pidana']=='Korupsi'){
            if($id_kejati == "00" && $id_kejari == "00" && $id_cabjari == "00"){
                $kepada = 'KASUBDIT';
            } else if($id_kejati != "00" && $id_kejari == "00" && $id_cabjari == "00"){
                $kepada = 'ASPIDSUS';
            } else if($id_kejati != "00" && $id_kejari != "00" && $id_cabjari == "00"){
                $kepada = 'KASI PIDSUS';
            } else if($id_kejati != "00" && $id_kejari != "00" && $id_cabjari != "00"){
                $kepada = 'KASUBSI';
            }
        }else{
            $kepada = 'KASUBDIT PENYIDIKAN DIT PERAN HAM';
        }
        
        
        if(strtoupper($model['penandatangan_status_ttd']) == 'ASLI')
		$jabatan_ttd = $model['penandatangan_jabatan_ttd'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'A.N')
		$jabatan_ttd = "An. ".$model['penandatangan_jabatan_ttd']."\n".$model['penandatangan_jabatan_pejabat'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'PLT')
		$jabatan_ttd = "Plt. ".$model['penandatangan_jabatan_ttd'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'PLH')
		$jabatan_ttd = "Plh. ".$model['penandatangan_jabatan_ttd'];
        
        $nom14u = ($model['no_urut_pidsus14_umum'])?$model['no_urut_pidsus14_umum']:0;
        $sql1 = "select * from pidsus.pds_pidsus14_umum_saksi where ".$whereDefault." and no_urut_pidsus14_umum = '".$nom14u."' order by no_urut_saksi";
	$res1 = PdsPidsus14Umum::findBySql($sql1)->asArray()->all();
	$tabel_pemanggilan = '<table border="1px; solid; black;" style="border-collapse: collapse;" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" width="5%">No</th>
                                <th class="text-center" width="25%">Nama</th>
                                <th class="text-center" width="15%">Waktu Pelaksanaan</th>
                                <th class="text-center" width="25%">Jaksa yang Melaksanakan</th>
                                <th class="text-center" width="25%">Keperluan</th>
                            </tr>
                        </thead>
                        <tbody>';
	if(count($res1) > 0){
            $nom = 0;
            foreach($res1 as $data){
                $nom++;
                $tabel_pemanggilan .= 
                        '<tr> '
                        . '<td class="text-center"><span>'.$nom.'</span></td>'
                        . '<td>'.$data['nama'].'</td>'
                        . '<td>'.tgl_indo(date("d-m-Y", strtotime($data['waktu_pelaksanaan']))).'</td>'
                        . '<td>'.$data['nama_jaksa'].'</td>'
                        . '<td>'.$data['keperluan'].'</td>'
                        . '</tr>';
                $status_keperluan = $data['status_keperluan'];
                    
            }
	} else{
		$tabel_pemanggilan .= '
			<tr><td colspan="5">&nbsp;</td></tr>
		';
	}
	$tabel_pemanggilan .= '</tbody></table>';
        
	$docx->replaceVariableByText(array('Kejaksaan'=>strtoupper($namaSatker)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('kejaksaan1'=>$kejaksaan), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_surat'=>tgl_indo($tgl_pidsus14_umum)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('kepada'=>$kepada), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('status_keperluan'=>$status_keperluan), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('lamp'=>$model['lampiran']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('no_p8'=>$model['no_p8_umum']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_p8'=>tgl_indo($tgl_p8_umum)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tindak_pidana'=>$model['laporan_pidana']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByHTML('tabel_pemanggilan', 'block', $tabel_pemanggilan, $arrDocnya);
        $docx->replaceVariableByText(array('ttd_nama'=>$model['penandatangan_nama']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ttd_detil'=>$model['penandatangan_pangkat'].' NIP.'.$model['penandatangan_nip']), array('parseLineBreaks'=>true));
        
        $docx->createDocx('template/pidsus/Pidsus-14-Umum');
	$file = 'template/pidsus/Pidsus-14-Umum.docx';
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