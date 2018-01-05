<?php

    use app\modules\datun\models\Sp1;
    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pdsold/BA-17.docx');
    $satker = Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama;
    $docx->replaceVariableByText(array('kejaksaan'=>ucfirst(strtoupper($satker))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kejaksaan1'=>$satker), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nomor'=> $ba17->no_surat_ba17), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_surat'=> Yii::$app->globalfunc->ViewIndonesianFormat($ba17->tgl_surat)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('hari1'=> Yii::$app->globalfunc->GetNamaHari($ba17->tgl_surat)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama_pegawai'=> $ba17->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat'=> $ba17->pangkat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip'=> $ba17->id_penandatangan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('jabatan'=> $ba17->jabatan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('rutan'=> $ba17->nama_rutan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('terdakwa'=> $modeltsk->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('rutan'=> $ba17->nama_rutan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kepala_rutan'=> $ba17->nama_kepala_rutan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pengadilan'=> $pn->pengadilan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tanggal1'=> Yii::$app->globalfunc->ViewIndonesianFormat($pn->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nomor1'=> $pn->no_surat), array('parseLineBreaks'=>true));
    
    $usul_jpu ='<b></b>';
    $i=1;
    if (count($amar_put) != 0) {
        $usul_jpu = '<table border="0" width="100%"><tbody>';
        foreach ($amar_put as $rowtsk) {
            $th             = $rowtsk[masa_percobaan_tahun]==''?'':$rowtsk[masa_percobaan_tahun].' Tahun';
            $bln            = $rowtsk[masa_percobaan_bulan]==''?'':$rowtsk[masa_percobaan_bulan].' Bulan';
            $hr             = $rowtsk[masa_percobaan_hari]==''?'':$rowtsk[masa_percobaan_hari].' Hari';
            $ms_percobaan   = ($rowtsk[masa_percobaan_tahun]!="" || $rowtsk[masa_percobaan_bulan]!="" || $rowtsk[masa_percobaan_hari]!="")?'<tr>
                             <td width="95%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 0px">- Masa Percobaan '.$th.' '.$bln.' '.$hr.' </td></tr>':"";
           
            $th_pdn         = $rowtsk[pidana_badan_tahun]==''?'':$rowtsk[pidana_badan_tahun].' Tahun';
            $bln_pdn        = $rowtsk[pidana_badan_bulan]==''?'':$rowtsk[pidana_badan_bulan].' Bulan';
            $hr_pdn         = $rowtsk[pidana_badan_hari]==''?'':$rowtsk[pidana_badan_hari].' Hari';
            $pdn            = ($rowtsk[pidana_badan_tahun]!="" || $rowtsk[pidana_badan_bulan]!="" || $rowtsk[pidana_badan_hari]!="")?'<tr>
                             <td width="95%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 0px">- Pidana Badan '.$th_pdn.' '.$bln_pdn.' '.$hr_pdn.'</td></tr>':"";
            
            $denda          = ($rowtsk[denda]!="")?'<tr>
                             <td width="95%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 0px">- Denda Rp. '.$rowtsk[denda].'</td></tr>':"";
            
            $th_sdr         = $rowtsk[subsidair_tahun]==''?'':$rowtsk[subsidair_tahun].' Tahun';
            $bln_sdr        = $rowtsk[subsidair_bulan]==''?'':$rowtsk[subsidair_bulan].' Bulan';
            $hr_sdr         = $rowtsk[subsidair_hari]==''?'':$rowtsk[subsidair_hari].' Hari';
            $sdr            = ($rowtsk[subsidair_tahun]!="" || $rowtsk[subsidair_bulan]!="" || $rowtsk[subsidair_hari]!="")?'<tr>
                             <td width="95%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 0px">- SubSidair '.$th_sdr.' '.$bln_sdr.' '.$hr_sdr.'</td></tr>':"";
            
            $biaya_pkr      = ($rowtsk[biaya_perkara]!="")?'<tr>
                             <td width="95%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 0px">- Biaya Perkara Rp.'.$rowtsk[biaya_perkara].'</td></tr>':"";
            
            $pdn_tmbh       = ($rowtsk[pidana_tambahan]!="")?'<tr>
                             <td width="95%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 0px">- Pidana Tambahan '.$rowtsk[pidana_tambahan].'</td></tr>':"";
            
           $usul_jpu .=     $ms_percobaan.'
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
    $docx->replaceVariableByHTML('amar_putusan1', 'block', $usul_jpu, $arrDocnya);
    
//    echo $th_pdn;exit();
    $th_pdn         = $sts_rentut->pidana_badan_tahun==''?'':$sts_rentut->pidana_badan_tahun.' Tahun';
    $bln_pdn        = $sts_rentut->pidana_badan_bulan==''?'':$sts_rentut->pidana_badan_bulan.' Bulan';
    $hr_pdn         = $sts_rentut->pidana_badan_hari==''?'':$sts_rentut->pidana_badan_hari.' Hari';
    if($sts_rentut->id_ms_rentut == 5){
        $hasil1     = 'membebaskan/mengeluarkan terdakwa/terpidana dari tahanan.';
    }else{
//        echo $th_pdn;exit();
        $hasil1     = 'menjalani tahanan/pidana penjara/kurungan selama '.$th_pdn.' '.$bln_pdn.' '.$hr_pdn.'.';
    }
    $docx->replaceVariableByText(array('kurungan_selama'=> $hasil1), array('parseLineBreaks'=>true));
    
    
    $tembusan ='<b></b>';
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
    
    $docx->createDocx('../web/template/pdsold_surat/BA-17');
    $file = '../web/template/pdsold_surat/BA-17.docx';
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
