<?php

    use app\modules\datun\models\Sp1;
    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pidum/P-27.docx');
    $satker = Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama;
    
    $docx->replaceVariableByText(array('Kejaksaan'=>ucfirst(strtoupper($satker))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kejaksaan'=>ucfirst(strtolower($satker))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nomor_print'=> $p27->no_surat_p27), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('ket_tsk'=> $p27->keterangan_tersangka), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('ket_saksi'=> $p27->keterangan_saksi), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('benda'=> $p27->dari_benda), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('petunjuk'=> $p27->dari_petunjuk), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('alasan_tdk_sah'=> $p27->alasan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_ba'=> Yii::$app->globalfunc->ViewIndonesianFormat($p27->tgl_ba)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('di'=> $p27->dikeluarkan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_di'=> Yii::$app->globalfunc->ViewIndonesianFormat($p27->tgl_surat)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_putusan'=> Yii::$app->globalfunc->ViewIndonesianFormat($p27->tgl_putusan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nomor_putusan'=> $p27->no_putusan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pengadilan'=> Yii::$app->globalfunc->GetConfSatker()->p_tinggi), array('parseLineBreaks'=>true));
    
    $melanggar_pasal ='';
    if (count($pasal) != 0) {
        $melanggar_pasal = '<table border="0" ><tbody>';
        foreach ($pasal as $rowpasal) {
           $melanggar_pasal .= '<tr><td width="2%" border="0" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px">'.$rowpasal[undang].' dan '.$rowpasal[pasal].'.</td>
                             </tr>';
        }
        $melanggar_pasal .= "</tbody></table>";
    }
    $docx->replaceVariableByHTML('melanggar_pasal', 'block', $melanggar_pasal, $arrDocnya);
    
    $docx->replaceVariableByText(array('nama'=> $tersangka->nama), array('parseLineBreaks'=>true));
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
    
    $docx->replaceVariableByText(array('nama_penandatangan'=>$pangkat->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat_penandatangan'=>$pangkat->pangkat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip_penandatangan'=>$pangkat->peg_nip_baru), array('parseLineBreaks'=>true));
    
    $docx->createDocx('../web/template/pidum_surat/P-27');
    $file = '../web/template/pidum_surat/P-27.docx';
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
