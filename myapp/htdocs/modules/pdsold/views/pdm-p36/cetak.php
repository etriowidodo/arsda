<?php

    use app\modules\datun\models\Sp1;
    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pdsold/P-36.docx');
    $satker = Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama;
    $docx->replaceVariableByText(array('kejaksaan'=>ucfirst(strtoupper($satker))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nomor'=> $p36->no_surat_p36), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('sifat'=> $sifat->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('lampiran'=> $p36->lampiran), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('dikeluarkan'=> $p36->dikeluarkan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_dikeluarkan'=> Yii::$app->globalfunc->ViewIndonesianFormat($p36->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kepada'=> $p36->kepada), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('di1'=> $p36->di_kepada), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pn'=> $p36->pengadilan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('alamat'=> $p36->alamat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('hari'=> Yii::$app->globalfunc->GetNamaHari($p36->tgl_sidang)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tanggal'=> Yii::$app->globalfunc->ViewIndonesianFormat($p36->tgl_sidang)), array('parseLineBreaks'=>true));
    //echo '<pre>';print_r($p36->nama_ttd);exit;
    $docx->replaceVariableByText(array('nama_penandatangan'=>$p36->nama_ttd), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat'=>$p36->pangkat_ttd), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('jabatan'=>$p36->jabatan_ttd), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip_penandatangan'=>$p36->id_penandatangan), array('parseLineBreaks'=>true));
    
    //echo '<pre>';print_r($p36->tersangka);exit;
    $docx->replaceVariableByText(array('tersangka'=>$p36->tersangka), array('parseLineBreaks'=>true));
    
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
    
    $docx->createDocx('../web/template/pdsold_surat/P-36');
    $file = '../web/template/pdsold_surat/P-36.docx';
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
