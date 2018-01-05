<?php

    use app\modules\datun\models\Sp1;
    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pdsold/T-11.docx');
    $satker = Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama;
    
    $docx->replaceVariableByText(array('Kejaksaan'=>ucfirst(strtoupper($satker))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('Kejaksaan1'=>$satker), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('no_print'=>ucfirst(strtoupper($T11->no_surat_t11))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('dikeluarkan'=>ucfirst(strtoupper($T11->dikeluarkan))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_dikeluarkan'=>ucfirst(strtoupper($T11->tgl_dikeluarkan))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kepala'=>ucfirst(strtoupper($pangkat->jabatan))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama_penandatangan'=>$pangkat->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat'=>$pangkat->pangkat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip_penandatangan'=>$pangkat->peg_nip_baru), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama_jaksa'=>$modelpeg->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat_jaksa'=>$modelpeg->gol_pangkat2), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip_jaksa'=>$modelpeg->peg_nip_baru), array('parseLineBreaks'=>true));
    
    $dasar ='';
    if (count($dasar1) != 0) {
        $no = 1;
        $dasar = '<table border="0" width="100%" ><tbody>';
        foreach ($dasar1 as $rowdasar1) {
           $dasar .= '<tr><td width="3%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-top = 0px"> '.$no.'.</td>
                             <td width="40%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-top = 0px">'.$rowdasar1.'</td>
                             </tr>';
           $no++;
        }
        $dasar .= "</tbody></table>";
    }
    $docx->replaceVariableByHTML('dasar_1', 'block', $dasar, $arrDocnya);
    
    $pertimbangan ='';
    if (count($dasar1) != 0) {
        $no = "-";
        $pertimbangan = '<table border="0" width="100%" ><tbody>';
        foreach ($dasar2 as $rowdasar2) {
           $pertimbangan .= '<tr><td width="3%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-top = 0px"> '.$no.'</td>
                             <td width="40%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-top = 0px">'.$rowdasar2.'</td>
                             </tr>';
           $no++;
        }
        $pertimbangan .= "</tbody></table>";
    }
    $docx->replaceVariableByHTML('pertimbangan', 'block', $pertimbangan, $arrDocnya);
    
    $untuk ='';
    if (count($dasar1) != 0) {
        $no = 1;
        $untuk = '<table border="0" width="100%" ><tbody>';
        foreach ($dasar3 as $rowdasar3) {
           $untuk .= '<tr><td width="3%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-top = 0px"> '.$no.'.</td>
                             <td width="40%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-top = 0px">'.$rowdasar3.'</td>
                             </tr>';
           $no++;
        }
        $untuk .= "</tbody></table>";
    }
    $docx->replaceVariableByHTML('untuk', 'block', $untuk, $arrDocnya);
    
    
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
    
    $docx->createDocx('../web/template/pdsold_surat/T-11');
    $file = '../web/template/pdsold_surat/T-11.docx';
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
