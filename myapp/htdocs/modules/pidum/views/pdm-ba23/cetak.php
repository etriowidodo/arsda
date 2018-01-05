<?php

    use app\modules\datun\models\Sp1;
    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pidum/BA-23.docx');
    $satker = Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama;
    $docx->replaceVariableByText(array('Kejaksaan'=>ucfirst(strtoupper($satker))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('surat_kejaksaan'=>$satker), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('lokasi'=> $ba23->dikeluarkan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_surat'=> Yii::$app->globalfunc->ViewIndonesianFormat($ba23->tgl_ba23)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('hari1'=> Yii::$app->globalfunc->GetNamaHari($ba23->tgl_ba23)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama1'=> $ba23->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat1'=> $ba23->dikeluarkan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip1'=> $ba23->pangkat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('jabatan1'=> $ba23->jabatan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('cara1'=> $ba23->pemusnahan), array('parseLineBreaks'=>true));
    
    $docx->replaceVariableByText(array('no_kejaksaan'=> $p48->no_surat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_kejaksaan'=> Yii::$app->globalfunc->ViewIndonesianFormat($p48->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pengadilan'=> $pn->pengadilan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nomor_putusan'=> $pn->no_surat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tanggal_putusan'=> Yii::$app->globalfunc->ViewIndonesianFormat($pn->tgl_dikeluarkan)), array('parseLineBreaks'=>true));

    foreach ($barbuk as $rowbarbuk ) {
        $barang  .= $rowbarbuk[nama].", ";
    } 
    $barang= substr($barang, 0,-2);
    $docx->replaceVariableByText(array('barbuk'=> $barang), array('parseLineBreaks'=>true));
    
    $saksi = json_decode($ba23->saksi);
    //echo '<pre>';print_r($saksi);exit;
    $listJaksa='<table border="0"  >';
    
    for ($i=0; $i < count($saksi->no_urut); $i++) { 
        $listJaksa .='<tr><td width="2%" style="font-family:Times New Roman; font-size:11pt;">'.$saksi->no_urut[$i].'. </td>
                            <td width="5%" style="font-family:Times New Roman; font-size:11pt;"> Nama</td>
                            <td width="2%"> :</td>
                            <td width="25%" style="font-family:Times New Roman; font-size:11pt;">'.$saksi->nama[$i].'</td>
                        </tr>
                        <tr><td></td>
                            <td width="5%" style="font-family:Times New Roman; font-size:11pt;"> Pangkat</td>
                            <td width="2%" style="font-family:Times New Roman; font-size:11pt;"> :</td>
                            <td width="25%" style="font-family:Times New Roman; font-size:11pt;">'.$saksi->pangkat[$i].'</td>
                        </tr>
                        <tr><td></td>
                            <td width="5%" style="font-family:Times New Roman; font-size:11pt;"> NIP</td>
                            <td width="2%" style="font-family:Times New Roman; font-size:11pt;"> :</td>
                            <td width="25%" style="font-family:Times New Roman; font-size:11pt;">'.$saksi->nip[$i].'</td>
                        </tr>
                        <tr><td></td>
                            <td width="5%" style="font-family:Times New Roman; font-size:11pt;"> Jabatan</td>
                            <td width="2%" style="font-family:Times New Roman; font-size:11pt;"> :</td>
                            <td width="25%" style="font-family:Times New Roman; font-size:11pt;">'.$saksi->jabatan[$i].'</td>
                        </tr>';
    }
    $listJaksa .='</table>'; 
    $docx->replaceVariableByHTML('saksi', 'block', $listJaksa, $arrDocnya);
    
    
    $saksi2 = json_decode($ba23->saksi);
    //echo '<pre>';print_r($saksi);exit;
    $listJaksa1='<table border="0" width="100%" >';
    
    for ($i=0; $i < count($saksi2->no_urut); $i++) { 
        $listJaksa1 .='<tr><td width="4%" style="font-family:Times New Roman; font-size:11pt;">'.$saksi2->no_urut[$i].'. </td>
                            <td width="50%" style="font-family:Times New Roman; font-size:11pt;">'.$saksi2->nama[$i].'</td>
                        </tr>';
    }
    $listJaksa1 .='</table>'; 
    $docx->replaceVariableByHTML('saksi2', 'block', $listJaksa1, $arrDocnya);
    
//    $usul_jpu = '<table border="0" width="100%"><tbody>';
//    $usul_jpu .= $ba23->pemusnahan;
//    $usul_jpu .= "</tbody></table>";
//    $docx->replaceVariableByHTML('cara', 'block', $usul_jpu, $arrDocnya);
    
    $docx->createDocx('../web/template/pidum_surat/BA-23');
    $file = '../web/template/pidum_surat/BA-23.docx';
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
