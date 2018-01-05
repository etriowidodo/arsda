<?php

    use app\modules\datun\models\Sp1;
    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pidum/BA-20.docx');
    $satker = Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama;
    
    $docx->replaceVariableByText(array('kejaksaan'=>ucfirst(strtoupper($satker))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_ba20'=>Yii::$app->globalfunc->ViewIndonesianFormat($ba20->tgl_ba20)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('harix'=>Yii::$app->globalfunc->GetNamaHari($ba20->tgl_ba20)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('lokasi'=>$ba20->lokasi), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('surat_perintah'=>$ba20->surat_perintah), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nomor'=>$ba20->no_surat_perintah), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tanggal'=>Yii::$app->globalfunc->ViewIndonesianFormat($ba20->tgl_surat_perintah)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tanggal1'=>Yii::$app->globalfunc->ViewIndonesianFormat($ba20->tgl_putusan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nomor'=>$ba20->no_putusan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('barbuk'=>$barbuk), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tersangka'=>Yii::$app->globalfunc->getListTerdakwaBa4($ba20->no_register_perkara)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama'=>$ba20->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pekerjaan'=>$ba20->pekerjaan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('alamat'=>$ba20->alamat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama_penandatangan'=>$pangkat->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat'=>$pangkat->pangkat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip_penandatangan'=>$pangkat->nip), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('jabatan'=>$pangkat->jabatan), array('parseLineBreaks'=>true));
    
    $melanggar_pasal ='';
    if (count($pasal) != 0) {
//        $melanggar_pasal = '<table border="0" ><tbody>';
        foreach ($pasal as $rowpasal) {
           $melanggar_pasal .= $rowpasal[undang].', '.$rowpasal[pasal].' ';
        }
//        $melanggar_pasal .= "</tbody></table>";
    }
//    $docx->replaceVariableByHTML('pasal', 'block', $melanggar_pasal, $arrDocnya);
    $docx->replaceVariableByText(array('pasal'=>$melanggar_pasal), array('parseLineBreaks'=>true));
    
    $dekot1 ='';
    if (count($dekot) != 0) {
        $no = 1;
        $dekot1 = '<table border="0" width="100%" ><tbody>';
        foreach ($dekot as $rowdasar1) {
           $dekot1 .= '<tr><td width="5%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-top = 0px"> '.$no.'.</td>
                             <td width="40%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-top = 0px">'.$rowdasar1.'</td>
                             </tr>';
           $no++;
        }
        $dekot1 .= "</tbody></table>";
    }
    $docx->replaceVariableByHTML('saksi', 'block', $dekot1, $arrDocnya);
    
    $docx->createDocx('../web/template/pidum_surat/BA-20');
    $file = '../web/template/pidum_surat/BA-20.docx';
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
