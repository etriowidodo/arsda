<?php
	use app\modules\pidsus\models\PdsPidsus16Umum;
	require_once('./function/tgl_indo.php');
	require_once('./wordtest/classes/CreateDocx.inc');
	$docx = new CreateDocxFromTemplate('../modules/pidsus/template/Pidsus-16-Umum.docx');

	$namaSatker     = Yii::$app->inspektur->getNamaSatker();
	$lokSatker 	= Yii::$app->inspektur->getLokasiSatker()->lokasi;
	$almtSatker     = Yii::$app->inspektur->getLokasiSatker()->alamat;
	$tgl_pidsus16_umum= date('d-m-Y',strtotime($model['tgl_pidsus16_umum']));
	$tgl_p8_umum 	= date('d-m-Y',strtotime($model['tgl_p8_umum']));
        $id_kejati	= $_SESSION['kode_kejati'];
        $id_kejari	= $_SESSION['kode_kejari'];
        $id_cabjari	= $_SESSION['kode_cabjari'];
        $whereDefault 	= "a.id_kejati = '".$id_kejati."' and a.id_kejari = '".$id_kejari."' and a.id_cabjari = '".$id_cabjari."' and a.no_p8_umum = '".$_SESSION["pidsus_no_p8_umum"]."'";
        
        $kejaksaan      = ($id_kejati.$id_kejari.$id_cabjari=="000000")?'Direktur Penyidikan Jaksa Agung Muda Tindak Pidana Khusus': 'Kepala '.ucwords(strtolower($namaSatker));
        
        if($model['tindak_pidana'] == 'Korupsi'){
            if($id_kejati == "00" && $id_kejari == "00" && $id_cabjari == "00"){
                $kepada = 'KASUBDIT PENYIDIKAN TPK';
            } else if($id_kejati != "00" && $id_kejari == "00" && $id_cabjari == "00"){
                $kepada = 'ASPIDSUS';
            } else if($id_kejati != "00" && $id_kejari != "00" && $id_cabjari == "00"){
                $kepada = 'KASI PIDSUS';
            } else if($id_kejati != "00" && $id_kejari != "00" && $id_cabjari != "00"){
                $kepada = 'KASUBSI TINDAK PIDANA DAN DATUN';
            }
        } else {
            $kepada = 'KASUBDIT PENYIDKAN DIT PERAN HAM';
        }
        
        if(strtoupper($model['penandatangan_status_ttd']) == 'ASLI')
		$jabatan_ttd = $model['penandatangan_jabatan_ttd'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'A.N')
		$jabatan_ttd = "An. ".$model['penandatangan_jabatan_ttd']."\n".$model['penandatangan_jabatan_pejabat'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'PLT')
		$jabatan_ttd = "Plt. ".$model['penandatangan_jabatan_ttd'];
	else if(strtoupper($model['penandatangan_status_ttd']) == 'PLH')
		$jabatan_ttd = "Plh. ".$model['penandatangan_jabatan_ttd'];
        
        $sqlGeledah = "
            with tbl_jaksa_geledah as(
                select id_kejati, id_kejari, id_cabjari, no_p8_umum, no_pidsus16_umum, no_urut_penggeledahan, 
                string_agg(concat(nip_jaksa, '|##|', nama_jaksa, '|##|', gol_jaksa, '|##|', pangkat_jaksa, '|##|', jabatan_jaksa), '|#|' order by no_urut) as jpu_geledah 
                from pidsus.pds_pidsus16_umum_pengeledahan_jaksa 
                group by id_kejati, id_kejari, id_cabjari, no_p8_umum, no_pidsus16_umum, no_urut_penggeledahan 
            )
            select a.no_urut_penggeledahan, a.penggeledahan_terhadap, a.nama, a.jabatan, a.tempat_penggeledahan, a.alamat_penggeledahan, a.nama_pemilik, 
                                a.pekerjaan_pemilik, a.alamat_pemilik, a.waktu_penggeledahan, a.keperluan, a.keterangan, b.jpu_geledah, a.jam_penggeledahan, a.tgl_penggeledahan 
            from pidsus.pds_pidsus16_umum_pengeledahan a 
            left join tbl_jaksa_geledah b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
                and a.no_p8_umum = b.no_p8_umum and a.no_pidsus16_umum = b.no_pidsus16_umum and a.no_urut_penggeledahan = b.no_urut_penggeledahan 
            where ".$whereDefault." and a.no_pidsus16_umum = '".$model['no_pidsus16_umum']."' order by no_urut_penggeledahan";
        $resGeledah = ($model['no_pidsus16_umum'])?PdsPidsus16Umum::findBySql($sqlGeledah)->asArray()->all():array();
	$tabel_pemanggilan = '<table border="1px; solid; black;" style="border-collapse: collapse;" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" width="5%">No</th>
                                <th class="text-center" width="25%">Subyek/Obyek</th>
                                <th class="text-center" width="30%">Jaksa yang Melaksanakan & Waktu Pelaksanaan</th>
                                <th class="text-center" width="20%">Keperluan</th>
                                <th class="text-center" width="20%">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>';
	if(count($resGeledah) > 0){
            foreach($resGeledah as $dtGeledah){
                $arrJaksaGeledah = explode("|#|", $dtGeledah['jpu_geledah']);
                $nomGeledah = $dtGeledah['no_urut_penggeledahan'];
                $tgl_penggeledahan = ($dtGeledah['tgl_penggeledahan'])?date('d-m-Y',strtotime($dtGeledah['tgl_penggeledahan'])):'';
                $tgl_penggeledahan_indo  = ($tgl_penggeledahan)?tgl_indo($tgl_penggeledahan):'';
                $tableJaksaGeledah = '';
                if(count($arrJaksaGeledah) > 0){
                    $tableJaksaGeledah = '<table width="100%" border="0">';
                    foreach($arrJaksaGeledah as $idxJS=>$valJS){
                        $nomx = $idxJS + 1;
                        list($nip_jaksa, $nama_jaksa, $gol_jaksa, $pangkat_jaksa, $jabatan_jaksa) = explode("|##|", $valJS);										
                        $tableJaksaGeledah .= '<tr><td style="border:0"  width="5" valign="top">'.$nomx.'.</td><td style="border:0">'.$nip_jaksa.'<br />'.$nama_jaksa.'</td></tr>';
                    }
                    $tableJaksaGeledah .= '</table>';
                }
                if($dtGeledah['penggeledahan_terhadap'] == 'Subyek'){
                        $ygDigeledah = '<a style="cursor:pointer" class="ubahPenggeledahan">'.$dtGeledah['nama'].'</a><br />'.$dtGeledah['jabatan'];
                } else if($dtGeledah['penggeledahan_terhadap'] == 'Obyek'){
                        $ygDigeledah = '<a style="cursor:pointer" class="ubahPenggeledahan">'.$dtGeledah['tempat_penggeledahan'].'</a>
                        <br />'.$dtGeledah['alamat_penggeledahan'];
                }

                $tabel_pemanggilan.= '
                <tr>
                    <td class="text-center">'.$nomGeledah.'</td>
                    <td class="text-left">'.$ygDigeledah.'</td>
                    <td class="text-left">Tanggal '.$tgl_penggeledahan_indo.' Jam '.$dtGeledah['jam_penggeledahan'].'<br />'.$tableJaksaGeledah.'</td>
                    <td class="text-left">'.$dtGeledah['keperluan'].'</td>
                    <td class="text-left">'.$dtGeledah['keterangan'].'</td>
                </tr>';
            }
	} else{
		$tabel_pemanggilan .= '
			<tr><td colspan="5">&nbsp;</td></tr>
		';
	}
	$tabel_pemanggilan .= '</tbody></table>';
        
         $sqlSita = "
            with tbl_jaksa_sita as(
                select id_kejati, id_kejari, id_cabjari, no_p8_umum, no_pidsus16_umum, no_urut_penyitaan, 
                string_agg(concat(nip_jaksa, '|##|', nama_jaksa, '|##|', gol_jaksa, '|##|', pangkat_jaksa, '|##|', jabatan_jaksa), '|#|' order by no_urut) as jpu_sita 
                from pidsus.pds_pidsus16_umum_penyitaan_jaksa 
                group by id_kejati, id_kejari, id_cabjari, no_p8_umum, no_pidsus16_umum, no_urut_penyitaan 
            )
            select a.no_urut_penyitaan, a.nama_barang_disita, a.jenis_barang_disita, a.jumlah_barang_disita, a.disita_dari, a.tempat_penyitaan, a.nama_pemilik, 
            a.pekerjaan_pemilik, a.alamat_pemilik, a.waktu_penyitaan, a.keperluan, a.keterangan, b.jpu_sita, a.jam_penyitaan, a.tgl_penyitaan 
            from pidsus.pds_pidsus16_umum_penyitaan a 
            left join tbl_jaksa_sita b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
                and a.no_p8_umum = b.no_p8_umum and a.no_pidsus16_umum = b.no_pidsus16_umum and a.no_urut_penyitaan = b.no_urut_penyitaan 
            where ".$whereDefault." and a.no_pidsus16_umum = '".$model['no_pidsus16_umum']."' order by no_urut_penyitaan"; 
        $resSita = ($model['no_pidsus16_umum'])?PdsPidsus16Umum::findBySql($sqlSita)->asArray()->all():array();
        $tabel_sita = '<table border="1px; solid; black;" style="border-collapse: collapse;" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" width="5%">No</th>
                                <th class="text-center" width="15%">Item</th>
                                <th class="text-center" width="25%">Disita Dari dan Tempat Penyitaan</th>
                                <th class="text-center" width="25%">Jaksa yang Melaksanakan & Waktu Pelaksanaan</th>
                                <th class="text-center" width="15%">Keperluan</th>
                                <th class="text-center" width="15%">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>';            
        if(count($resSita) == 0)
            echo '<tr><td colspan="6">&nbsp;</td></tr>';
        else{
            foreach($resSita as $dtSita){
                $arrJaksaSita = explode("|#|", $dtSita['jpu_sita']);
                $nomSita = $dtSita['no_urut_penyitaan'];
                $tgl_penyitaan  = ($dtSita['tgl_penyitaan'])?(date('d-m-Y',strtotime($dtSita['tgl_penyitaan']))):'';
                $tgl_penyitaan_indo  = ($tgl_penyitaan)?tgl_indo($tgl_penyitaan):'';
                $tableJaksaSita = '';
                if(count($arrJaksaSita) > 0){
                    $tableJaksaSita = '<table width="100%" border="0">';
                    foreach($arrJaksaSita as $idxJS=>$valJS){
                        $nomx = $idxJS + 1;
                        list($nip_jaksa, $nama_jaksa, $gol_jaksa, $pangkat_jaksa, $jabatan_jaksa) = explode("|##|", $valJS);											
                        $tableJaksaSita .= '<tr><td style="border:0" valign="top">'.$nomx.'.</td><td style="border:0">'.$nip_jaksa.'<br />'.$nama_jaksa.'</td></tr>';
                    }
                    $tableJaksaSita .= '</table>';
                }

                $tabel_sita .= '
                <tr>
                    <td class="text-center">'.$nomSita.'</td>
                    <td class="text-left">
                        '.$dtSita['nama_barang_disita'].'<br />
                        Jenis : '.$dtSita['jenis_barang_disita'].'<br />Jumlah : '.$dtSita['jumlah_barang_disita'].'
                    </td>
                    <td class="text-left">Dari : '.$dtSita['disita_dari'].'<br />Tempat : '.$dtSita['tempat_penyitaan'].'</td>
                    <td class="text-left">Tanggal '.$tgl_penyitaan_indo.' Jam '.$dtSita['jam_penyitaan'].'<br />'.$tableJaksaSita.'</td>
                    <td class="text-left">'.$dtSita['keperluan'].'</td>
                    <td class="text-left">'.$dtSita['keterangan'].'</td>
                </tr>';
            }
        }
        $tabel_sita .= '</tbody></table>';
        
	$docx->replaceVariableByText(array('Kejaksaan'=>strtoupper($namaSatker)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('kepada'=>$kepada), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('kejaksaan1'=>$kejaksaan), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_surat'=>tgl_indo($tgl_pidsus16_umum)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('lamp'=>$model['lampiran']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('no_p8'=>$model['no_p8_umum']), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('tgl_p8'=>tgl_indo($tgl_p8_umum)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tindak_pidana'=>$model['laporan_pidana']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByHTML('tabel_pemanggilan', 'block', $tabel_pemanggilan, $arrDocnya);
        $docx->replaceVariableByHTML('tabel_penyitaan', 'block', $tabel_sita, $arrDocnya);
        $docx->replaceVariableByText(array('ttd_nama'=>$model['nama_jaksa']), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ttd_detil'=>$model['pangkat_jaksa'].' NIP.'.$model['nip_jaksa']), array('parseLineBreaks'=>true));
        
        $docx->createDocx('template/pidsus/Pidsus-16-Umum');
	$file = 'template/pidsus/Pidsus-16-Umum.docx';
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