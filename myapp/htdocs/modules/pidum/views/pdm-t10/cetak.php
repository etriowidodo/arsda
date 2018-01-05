<?php

    use app\modules\datun\models\Sp1;
    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pidum/T-10.docx');
    $satker = Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama;
    
    $docx->replaceVariableByText(array('kejaksaan1'=>ucfirst(strtolower($satker))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kejaksaan'=>ucfirst(strtoupper($satker))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nomor'=>$T10->no_surat_t10), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama_pengunjung'=>$T10->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('alamat_pengunjung'=>$T10->alamat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pekerjaan_pengunjung'=>$T10->pekerjaan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('hubungan'=>$T10->hubungan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('mengirim'=>$T10->keperluan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('jam_mulai'=>$T10->jam_mulai), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('jam_selesai'=>$T10->jam_selesai), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_berlaku'=>Yii::$app->globalfunc->ViewIndonesianFormat($T10->tgl_kunjungan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('dikeluarkan'=>$T10->dikeluarkan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_dikeluarkan'=>Yii::$app->globalfunc->ViewIndonesianFormat($T10->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    
    $docx->replaceVariableByText(array('nama_tahanan'=>$tersangka->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tmpt_tinggal'=>$tersangka->alamat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tmpt_lahir_tahanan'=>$tersangka->tmpt_lahir), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_lahir'=>Yii::$app->globalfunc->ViewIndonesianFormat($tersangka->tgl_lahir)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('jns_kelamin'=>$tersangka->is_jkl), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kewarganegaraan'=>$tersangka->warganegara1), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('agama'=>$tersangka->is_agama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pekerjaan'=>$tersangka->pekerjaan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pendidikan'=>$tersangka->is_pendidikan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('reg_tahanan'=>$tersangka->no_reg_tahanan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('umur'=>$tersangka->umur), array('parseLineBreaks'=>true));
    
    $docx->replaceVariableByText(array('kepala'=>ucfirst(strtoupper($pangkat->jabatan))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama_penandatangan'=>$pangkat->nama), array('parseLineBreaks'=>true));
    
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
    
    $docx->createDocx('../web/template/pidum_surat/T-10');
    $file = '../web/template/pidum_surat/T-10.docx';
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
