<?php

    use app\modules\datun\models\Sp1;
    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pdsold/P-50.docx');
    $satker = Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama;
    $docx->replaceVariableByText(array('Kejaksaan'=>ucfirst(strtoupper($satker))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nomor'=> $p50->no_surat_p50), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('sifat'=> $sifat->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('lampiran'=> $p50->lampiran), array('parseLineBreaks'=>true));
//    $docx->replaceVariableByText(array('kepentingan'=> $p50->no_surat_p50), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('dikeluarkan'=> $p50->dikeluarkan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kepada'=> $p50->kepada), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('ditempat'=> $p50->di_kepada), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_dikeluarkan'=> Yii::$app->globalfunc->ViewIndonesianFormat($p50->tgl_dikeluarkan)), array('parseLineBreaks'=>true));

    $docx->replaceVariableByText(array('nama_lengkap'=> $tersangka->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tempat_lahir'=> $tersangka->tmpt_lahir), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_lahir'=> Yii::$app->globalfunc->ViewIndonesianFormat($tersangka->tgl_lahir)), array('parseLineBreaks'=>true));
    $umur = Yii::$app->globalfunc->datediff($tersangka->tgl_lahir, date("Y-m-d"));
    $docx->replaceVariableByText(array('umur'=> $umur['years'] . ' tahun'), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('jenis_kelamin'=> $tersangka->is_jkl), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kebangsaan'=> $tersangka->warganegara1), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tempat_tinggal'=> $tersangka->alamat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('agama'=> $tersangka->is_agama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pekerjaan'=> $tersangka->pekerjaan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pendidikan'=> $tersangka->is_pendidikan), array('parseLineBreaks'=>true));
    
    $docx->replaceVariableByText(array('kejaksaan1'=>$pangkat->jabatan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama_penandatangan'=>$pangkat->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat'=>$pangkat->pangkat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip_penandatangan'=>$pangkat->peg_nip_baru), array('parseLineBreaks'=>true));
    
    $docx->replaceVariableByText(array('pengadilan'=>$putusan_pn->pengadilan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('no_berkas_perkara'=>$putusan_pn->no_surat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tanggal_berkas_perkara'=> Yii::$app->globalfunc->ViewIndonesianFormat($putusan_pn->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    
    $alasan_ ='';
    if (count($alasan) != 0) {
        $alasan_ = '<table border="0" width="100%"><tbody>';
//        $i=1;
        for ($i = 0; $i < count($alasan); $i++){
           $alasan_ .= '<tr><td width="11%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px"> -  '.$alasan[$i].'</td>
                             </tr>';
        }
        $alasan_ .= "</tbody></table>";
    }
    $docx->replaceVariableByHTML('alasan', 'block', $alasan_, $arrDocnya);
    
    $tembusan ='';
    if (count($listTembusan) != 0) {
        $tembusan = '<table border="0" ><tbody>';
        foreach ($listTembusan as $rowlistTembusan) {
           $tembusan .= '<tr><td width="2%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px"> '.$rowlistTembusan[no_urut].'.</td>
                             <td width="40%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 0px">'.$rowlistTembusan[tembusan].'</td>
                             </tr>';
        }
        $tembusan .= "</tbody></table>";
    }
    $docx->replaceVariableByHTML('tembusan', 'block', $tembusan, $arrDocnya);
    
    
    $i=1;
    if (count($p41_tsk) != 0) {
        $usul_jpu = '<table border="0" width="100%"><tbody>';
        foreach ($p41_tsk as $rowtsk) {
            $th             = $rowtsk[masa_percobaan_tahun]==''?'':$rowtsk[masa_percobaan_tahun].' Tahun';
            $bln            = $rowtsk[masa_percobaan_bulan]==''?'':$rowtsk[masa_percobaan_bulan].' Bulan';
            $hr             = $rowtsk[masa_percobaan_hari]==''?'':$rowtsk[masa_percobaan_hari].' Hari';
            $ms_percobaan   = ($rowtsk[masa_percobaan_tahun]!="" || $rowtsk[masa_percobaan_bulan]!="" || $rowtsk[masa_percobaan_hari]!="")?'<tr><td width="5%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px">-</td>
                             <td width="95%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 0px">Masa Percobaan '.$th.' '.$bln.' '.$hr.' </td></tr>':"";
           
            $th_pdn         = $rowtsk[pidana_badan_tahun]==''?'':$rowtsk[pidana_badan_tahun].' Tahun';
            $bln_pdn        = $rowtsk[pidana_badan_bulan]==''?'':$rowtsk[pidana_badan_bulan].' Bulan';
            $hr_pdn         = $rowtsk[pidana_badan_hari]==''?'':$rowtsk[pidana_badan_hari].' Hari';
            $pdn            = ($rowtsk[pidana_badan_tahun]!="" || $rowtsk[pidana_badan_bulan]!="" || $rowtsk[pidana_badan_hari]!="")?'<tr><td width="5%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px">-</td>
                             <td width="95%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 0px">Pidana Badan '.$th_pdn.' '.$bln_pdn.' '.$hr_pdn.'</td></tr>':"";
            
            $denda          = ($rowtsk[denda]!="")?'<tr><td width="5%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px">-</td>
                             <td width="95%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 0px">Denda Rp. '.$rowtsk[denda].'</td></tr>':"";
            
            $th_sdr         = $rowtsk[subsidair_tahun]==''?'':$rowtsk[subsidair_tahun].' Tahun';
            $bln_sdr        = $rowtsk[subsidair_bulan]==''?'':$rowtsk[subsidair_bulan].' Bulan';
            $hr_sdr         = $rowtsk[subsidair_hari]==''?'':$rowtsk[subsidair_hari].' Hari';
            $sdr            = ($rowtsk[subsidair_tahun]!="" || $rowtsk[subsidair_bulan]!="" || $rowtsk[subsidair_hari]!="")?'<tr><td width="5%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px">-</td>
                             <td width="95%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 0px">SubSidair '.$th_sdr.' '.$bln_sdr.' '.$hr_sdr.'</td></tr>':"";
            
            $biaya_pkr      = ($rowtsk[biaya_perkara]!="")?'<tr><td width="5%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px">-</td>
                             <td width="95%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 0px">Biaya Perkara Rp.'.$rowtsk[biaya_perkara].'</td></tr>':"";
            
            $pdn_tmbh       = ($rowtsk[pidana_tambahan]!="")?'<tr><td width="5%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px">-</td>
                             <td width="95%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 0px">Pidana Tambahan '.$rowtsk[pidana_tambahan].'</td></tr>':"";
            
           $usul_jpu .= ''.$ms_percobaan.'
                            '.$pdn.'
                            '.$denda.'
                            '.$sdr.'
                            '.$biaya_pkr.'
                            '.$pdn_tmbh.'
                        ';
           $i++;
        }
        $usul_jpu .= "</tbody></table>";
    }
    $docx->replaceVariableByHTML('amar_putusan', 'block', $usul_jpu, $arrDocnya);
    
    
    $docx->createDocx('../web/template/pdsold_surat/P-50');
    $file = '../web/template/pdsold_surat/P-50.docx';
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
