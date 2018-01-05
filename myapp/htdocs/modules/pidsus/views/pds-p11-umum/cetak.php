<?php   use app\modules\pidsus\models\PdsP11Umum;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../modules/pidsus/template/P-11-Umum.docx');

	$namaSatker     = Yii::$app->inspektur->getNamaSatker();
	$lokSatker 	= Yii::$app->inspektur->getLokasiSatker()->lokasi;
	$almtSatker     = Yii::$app->inspektur->getLokasiSatker()->alamat;
        $tgl_p11_umum = ($model['tgl_p11_umum'])?date('d-m-Y',strtotime($model['tgl_p11_umum'])):'';
        $tgl_p8_umum = ($model['tgl_p8_umum'])?date('d-m-Y',strtotime($model['tgl_p8_umum'])):'';
        $id_kejati	= $_SESSION['kode_kejati'];
        $id_kejari	= $_SESSION['kode_kejari'];
        $id_cabjari	= $_SESSION['kode_cabjari'];
        $whereDefault 	= "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_p8_umum = '".$_SESSION["pidsus_no_p8_umum"]."'";
        
        $kejaksaan      = ($id_kejati.$id_kejari.$id_cabjari=="000000")?'Direktur Penyidikan Jaksa Agung Muda Tindak Pidana Khusus': 'Kepala '.ucwords(strtolower($namaSatker));
        
        if(strtoupper($model['penandatangan_status_ttd']) == 'ASLI')
		$jabatan_ttd = $model['penandatangan_jabatan_ttd'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'A.N')
		$jabatan_ttd = "An. ".$model['penandatangan_jabatan_ttd']."\n".$model['penandatangan_jabatan_pejabat'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'PLT')
		$jabatan_ttd = "Plt. ".$model['penandatangan_jabatan_ttd'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'PLH')
		$jabatan_ttd = "Plh. ".$model['penandatangan_jabatan_ttd'];
        
        $sifat=[1=>'Biasa','Rahasia','Segera','Sangat Segera'];
        $whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' 
						and no_p8_umum = '".$_SESSION["pidsus_no_p8_umum"]."'";
        
        
        $sql1 = "select * from pidsus.pds_p11_umum_saksi where ".$whereDefault." and no_p11_umum = '".$model['no_p11_umum']."' order by no_urut_saksi";
	$res1 = PdsP11Umum::findBySql($sql1)->asArray()->all();
        $saksi_ahli = ($model['perihal']=="Bantuan Pemanggilan Saksi")?'Saksi':'Ahli';
	$tabel_pemanggilan = '<table border="1px; solid; black;" style="border-collapse: collapse;" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" width="5%">No</th>
                                <th class="text-center" width="30%">Nama Lengkap '.$saksi_ahli.' Yang Dipanggil</th>
                                <th class="text-center" width="40%">Alamat</th>
                                <th class="text-center" width="25%">Keterangan</th>
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
                        . '<td>'.$data['alamat'].'</td>'
                        . '<td>'.$data['keterangan'].'</td>'
                        . '</tr>';
                    
            }
	} else{
		$tabel_pemanggilan .= '
			<tr><td colspan="4">celek&nbsp;</td></tr>
		';
	}
	$tabel_pemanggilan .= '</tbody></table>';
        
	$docx->replaceVariableByText(array('Kejaksaan'=>strtoupper($namaSatker)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('dikeluarkan'=>$lokSatker), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tanggal_dikeluarkan'=>tgl_indo($tgl_p11_umum)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('nomor_p11'=>$model['no_p11_umum']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('sifat'=>$sifat[$model['sifat']]), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('lampiran'=>$model['lampiran']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('kepada'=>$model['kepada_nama']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('di_tempat'=>$model['di_tempat']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('perihal'=>$model['perihal']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tindak_pidana'=>$model['laporan_pidana']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('Kejaksaan1'=>$kejaksaan), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('nomor_p8'=>$model['no_p8_umum']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl_p8'=>tgl_indo($tgl_p8_umum)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByHTML('tabel_pemanggilan', 'block', $tabel_pemanggilan, $arrDocnya);
        $docx->replaceVariableByText(array('ttd_jabatannya'=>$jabatan_ttd), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ttd_nama'=>$model['penandatangan_nama']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ttd_detil'=>$model['penandatangan_pangkat'].' NIP.'.$model['penandatangan_nip']), array('parseLineBreaks'=>true));
        
        $docx->createDocx('template/pidsus/P-11-Umum');
	$file = 'template/pidsus/P-11-Umum.docx';
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