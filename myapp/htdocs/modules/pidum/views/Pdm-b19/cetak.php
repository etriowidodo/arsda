<?php

    use app\modules\datun\models\Sp1;
    use app\modules\pidum\models\PdmUuPasalTahap2;
    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pidum/B-19.docx');
    $satker = Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama;
    $docx->replaceVariableByText(array('Kejaksaan'=>ucfirst(strtoupper($satker))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nomor'=> $b19->no_surat_b19), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('lampiran'=> $b19->lampiran), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('sifat'=> $sifat->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('keterangan'=> $status->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('dikeluarkan'=> $b19->dikeluarkan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pada_tanggal'=> Yii::$app->globalfunc->ViewIndonesianFormat($b19->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('melalui'=> $b19->kepada), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kejaksaan'=> $pangkat->jabatan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama_penandatangan'=>$pangkat->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat'=>$pangkat->pangkat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip_penandatangan'=>$pangkat->peg_nip_baru), array('parseLineBreaks'=>true));
    
    
    $docx->replaceVariableByText(array('ditempat'=> $b19->di_kepada), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kepada'=> $b19->dikembalikan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('harga'=> $b19->harga), array('parseLineBreaks'=>true));
    
    $docx->replaceVariableByText(array('nomor_pn'=> $putusan_pn->no_surat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tanggal_pn'=> Yii::$app->globalfunc->ViewIndonesianFormat($putusan_pn->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    
    foreach ($barbuk as $rowbarbuk ) {
        $barang  .= $rowbarbuk[nama].", ";
    } 
    $barang= substr($barang, 0,-2);
    $docx->replaceVariableByText(array('terdiri_dari'=> $barang), array('parseLineBreaks'=>true));
    
    
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
    
    
    $docx->createDocx('../web/template/pidum_surat/B-19');
    $file = '../web/template/pidum_surat/B-19.docx';
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
