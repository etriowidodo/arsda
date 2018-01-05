<?php

    use app\modules\datun\models\Sp1;
    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pdsold/P-45-UpayaHukum.docx');
    $satker = Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama;
    $docx->replaceVariableByText(array('kejaksaan'=>ucfirst(strtoupper($satker))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kejaksaan1'=>$satker), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nomor'=> $p45->no_surat_p45), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('sifat'=> $sifat->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('lampiran'=> $p45->lampiran), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('dikeluarkan'=> $p45->dikeluarkan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_dikeluarkan'=> Yii::$app->globalfunc->ViewIndonesianFormat($p45->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tanggal_tuntut'=> Yii::$app->globalfunc->ViewIndonesianFormat($p45->tgl_tuntutan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kepada'=> $p45->kepada), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('menyatakan_terdakwa'=> $p45->pernyataan_terdakwa), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pendapat_jaksa'=> $p45->pernyataan_jaksa), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('ditempat'=> $p45->di_kepada), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pidana'=> $pidana->nama), array('parseLineBreaks'=>true));
//    $docx->replaceVariableByText(array('terdakwa'=> Yii::$app->globalfunc->getListTerdakwaBa4($p45->no_register_perkara)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('terdakwa'=> $modeltsk->nama), array('parseLineBreaks'=>true));
    
    $docx->replaceVariableByText(array('nama_penandatangan'=>$pangkat->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat'=>$pangkat->pangkat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip_penandatangan'=>$pangkat->peg_nip_baru), array('parseLineBreaks'=>true));
    
    $docx->replaceVariableByText(array('nomor_pn'=> $pn[no_surat]), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tanggal_pn'=> Yii::$app->globalfunc->ViewIndonesianFormat($pn[tgl_dikeluarkan])), array('parseLineBreaks'=>true));
    
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
            $ms_percobaan   = ($rowtsk[masa_percobaan_tahun]!="" || $rowtsk[masa_percobaan_bulan]!="" || $rowtsk[masa_percobaan_hari]!="")?'<tr><td width="5%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px"></td>
                             <td width="95%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 0px">- Masa Percobaan '.$th.' '.$bln.' '.$hr.' </td></tr>':"";
           
            $th_pdn         = $rowtsk[pidana_badan_tahun]==''?'':$rowtsk[pidana_badan_tahun].' Tahun';
            $bln_pdn        = $rowtsk[pidana_badan_bulan]==''?'':$rowtsk[pidana_badan_bulan].' Bulan';
            $hr_pdn         = $rowtsk[pidana_badan_hari]==''?'':$rowtsk[pidana_badan_hari].' Hari';
            $pdn            = ($rowtsk[pidana_badan_tahun]!="" || $rowtsk[pidana_badan_bulan]!="" || $rowtsk[pidana_badan_hari]!="")?'<tr><td width="5%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px"></td>
                             <td width="95%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 0px">- Pidana Badan '.$th_pdn.' '.$bln_pdn.' '.$hr_pdn.'</td></tr>':"";
            
            $denda          = ($rowtsk[denda]!="")?'<tr><td width="5%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px"></td>
                             <td width="95%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 0px">- Denda Rp. '.$rowtsk[denda].'</td></tr>':"";
            
            $th_sdr         = $rowtsk[subsidair_tahun]==''?'':$rowtsk[subsidair_tahun].' Tahun';
            $bln_sdr        = $rowtsk[subsidair_bulan]==''?'':$rowtsk[subsidair_bulan].' Bulan';
            $hr_sdr         = $rowtsk[subsidair_hari]==''?'':$rowtsk[subsidair_hari].' Hari';
            $sdr            = ($rowtsk[subsidair_tahun]!="" || $rowtsk[subsidair_bulan]!="" || $rowtsk[subsidair_hari]!="")?'<tr><td width="5%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px"></td>
                             <td width="95%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 0px">- SubSidair '.$th_sdr.' '.$bln_sdr.' '.$hr_sdr.'</td></tr>':"";
            
            $biaya_pkr      = ($rowtsk[biaya_perkara]!="")?'<tr><td width="5%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px"></td>
                             <td width="95%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 0px">- Biaya Perkara Rp.'.$rowtsk[biaya_perkara].'</td></tr>':"";
            
            $pdn_tmbh       = ($rowtsk[pidana_tambahan]!="")?'<tr><td width="5%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px"></td>
                             <td width="95%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 0px">- Pidana Tambahan '.$rowtsk[pidana_tambahan].'</td></tr>':"";
            
           $usul_jpu .= '<tr><td colspan="8" width="100%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px">2.'.$i.'. Usul Jaksa PU pada tersangka '.$rowtsk[nama].' :</td></tr>
                            '.$ms_percobaan.'
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
    $docx->replaceVariableByHTML('usul_jpu', 'block', $usul_jpu, $arrDocnya);
    
    
    $ket_amar      = json_decode($p45->menyatakan);
    $ket_amar_ ='';
    if (count($ket_amar) != 0) {
        $ket_amar_ = '<table border="0" width="100%"><tbody>';
//        $i=1;
        for ($i = 0; $i < count($ket_amar); $i++){
           $ket_amar_ .= '<tr><td width="11%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px"> 1.'.($i+1).'. '.$ket_amar[$i].'</td>
                             
                             </tr>';
        }
        $ket_amar_ .= "</tbody></table>";
    }
    $docx->replaceVariableByHTML('menyatakan', 'block', $ket_amar_, $arrDocnya);
    
    $i=1;
    if (count($p41_tsk) != 0) {
        $ket_pertimbangan = '<table border="0" width="100%"><tbody>';
        foreach ($pertimbangan1[0] as $key => $value){
            $ket_pertimbangan .='<tr><td colspan="2" width="100%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px">4.'.$i.'. Pertimbangan pada tersangka '.$key.' :</td></tr>';
            foreach ($value as $key1 => $value1){
                $ket_pertimbangan .='<tr><td width="5%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px"></td>
                                     <td width="95%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 0px">- '.$value1.'</td></tr>';
            }
            $i++;
        }
        $ket_pertimbangan .= "</tbody></table>";
    }
    $docx->replaceVariableByHTML('pertimbangan', 'block', $ket_pertimbangan, $arrDocnya);
    
    $docx->createDocx('../web/template/pdsold_surat/P-45-UpayaHukum');
    $file = '../web/template/pdsold_surat/P-45-UpayaHukum.docx';
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
