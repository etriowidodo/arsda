<?php

    use app\modules\datun\models\Sp1;
    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pdsold/P-39.docx');

    //echo '<pre>';print_r($_SESSION['inst_satkerkd']);exit;
    $satker = Yii::$app->globalfunc->getNamaSatker($_SESSION['inst_satkerkd'])->inst_nama;
    $docx->replaceVariableByText(array('Kejaksaan'=>ucfirst(strtoupper($satker))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nomor'=> $p39->no_surat_p39), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('sifat'=> $sifat->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('lampiran'=> $p39->lampiran), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('dikeluarkan'=> $p39->dikeluarkan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_dikeluarkan'=> Yii::$app->globalfunc->ViewIndonesianFormat($p39->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kepada'=> $p39->kepada), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('ditempat'=> $p39->di_kepada), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pidana'=> $pidana->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('terdakwa'=> Yii::$app->globalfunc->getListTerdakwaBa4($p39->no_register_perkara)), array('parseLineBreaks'=>true));
    $acara      = app\modules\pidum\models\PdmMsStatusData::findOne(['is_group'=> 'P-39 ', 'id'=> $agenda->no_agenda]);
    $docx->replaceVariableByText(array('tahap'=> "tahap ke ".$agenda->no_agenda." Tanggal ". Yii::$app->globalfunc->ViewIndonesianFormat($agenda->tgl_acara_sidang)." Acara Sidang ". $acara->nama), array('parseLineBreaks'=>true));
    
    $hakim ='';
    if (count($majelis1) != 0) {
        $hakim = '<table border="0" width="100%"><tbody>';
//        $i=1;
        for ($i = 0; $i < count($majelis1); $i++){
           $hakim .= '<tr><td width="7%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px"> '.($i+1).'. '.$majelis1[$i].' : '.$majelis2[$i].'</td>
                             </tr>';
        }
        $hakim .= "</tbody></table>";
    }
    $docx->replaceVariableByHTML('hakim', 'block', $hakim, $arrDocnya);
    
//    $docx->replaceVariableByText(array('hakim'=> $p39->hakim), array('parseLineBreaks'=>true));
    
    $panitera ='';
    if (count($panitera1) != 0) {
        $panitera = '<table border="0" width="100%"><tbody>';
//        $i=1;
        for ($i = 0; $i < count($panitera1); $i++){
           $panitera .= '<tr><td width="7%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px"> '.($i+1).'. '.$panitera1[$i].' : '.$panitera2[$i].'</td>
                             </tr>';
        }
        $panitera .= "</tbody></table>";
    }
    $docx->replaceVariableByHTML('panitera', 'block', $panitera, $arrDocnya);
    
//    $docx->replaceVariableByText(array('panitera'=> $p39->panitera), array('parseLineBreaks'=>true));
    
    $penuntut_umum ='';
    if (count($jaksap16a) != 0) {
        $penuntut_umum = '<table border="0" width="100%"><tbody>';
//        $i=1;
        for ($i = 0; $i < count($jaksap16a); $i++){
           $penuntut_umum .= '<tr><td width="100%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px"> '.($i+1).'. '.$jaksap16a[$i]['nama'].'</td>
                             </tr>';
        }
        $penuntut_umum .= "</tbody></table>";
    }
    $docx->replaceVariableByHTML('penuntut_umum', 'block', $penuntut_umum, $arrDocnya);
    
//    $docx->replaceVariableByText(array('penuntut_umum'=> $p39->penuntut_umum), array('parseLineBreaks'=>true));
    
    $penasihat_hukum ='';
    if (count($penasehat1) != 0) {
        $penasihat_hukum = '<table border="0" width="100%"><tbody>';
//        $i=1;
        for ($i = 0; $i < count($penasehat1); $i++){
           $penasihat_hukum .= '<tr><td width="100%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px"> '.$penasehat1[$i].' '.$penasehat2[$i].'</td>
                             </tr>';
        }
        $penasihat_hukum .= "</tbody></table>";
    }
    $docx->replaceVariableByHTML('penasihat_hukum', 'block', $penasihat_hukum, $arrDocnya);
    
//    $docx->replaceVariableByText(array('penasihat_hukum'=> $p39->penasihat_hukum), array('parseLineBreaks'=>true));
    $uraian_sidang = '<table border="0" width="100%"><tbody>';
    $uraian_sidang .= '<tr><td width="70%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px"> '.$p39->uraian_sidang.'</td>
                             </tr>';
    $uraian_sidang .= "</tbody></table>";
    $docx->replaceVariableByHTML('uraian_sidang', 'block', $uraian_sidang, $arrDocnya);
//    $docx->replaceVariableByText(array('uraian_sidang'=> $p39->uraian_sidang), array('parseLineBreaks'=>true));
    
    $pengunjung = '<table border="0" width="100%"><tbody>';
    $pengunjung .= '<tr><td width="70%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px"> '.$p39->pengunjung.'</td>
                             </tr>';
    $pengunjung .= "</tbody></table>";
    $docx->replaceVariableByHTML('pengunjung', 'block', $pengunjung, $arrDocnya);
//    $docx->replaceVariableByText(array('pengunjung'=> $p39->pengunjung), array('parseLineBreaks'=>true));
    
    $kesimpulan = '<table border="0" width="100%"><tbody>';
    $kesimpulan .= '<tr><td width="70%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px"> '.$p39->kesimpulan.'</td>
                             </tr>';
    $kesimpulan .= "</tbody></table>";
    $docx->replaceVariableByHTML('kesimpulan', 'block', $kesimpulan, $arrDocnya);
//    $docx->replaceVariableByText(array('kesimpulan'=> $p39->kesimpulan), array('parseLineBreaks'=>true));
    
    $pendapat = '<table border="0" width="100%"><tbody>';
    $pendapat .= '<tr><td width="70%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px"> '.$p39->pendapat.'</td>
                             </tr>';
    $pendapat .= "</tbody></table>";
    $docx->replaceVariableByHTML('pendapat', 'block', $pendapat, $arrDocnya);
//    $docx->replaceVariableByText(array('pendapat'=> $p39->pendapat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama_penandatangan'=>$pangkat->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat'=>$pangkat->pangkat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip_penandatangan'=>$pangkat->nip), array('parseLineBreaks'=>true));
    
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
    
    $docx->createDocx('../web/template/pdsold_surat/P-39');
    $file = '../web/template/pdsold_surat/P-39.docx';
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
