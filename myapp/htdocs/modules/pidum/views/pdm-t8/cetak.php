<?php


    use app\modules\datun\models\Sp1;
    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pidum/T-8.docx');
    $satker = Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama;
    
    
    $docx->replaceVariableByText(array('Kejaksaan'=>$satker), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('hasil_perintah'=>$sts_t8->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('hasil_perintah1'=>ucfirst(strtolower($sts_t8->nama))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('no_print'=>$T8->no_surat_t8), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kepala'=>$pangkat->jabatan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('undang'=>$T7->undang), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('undang'=>$T7->undang), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tahun'=>$T7->tahun), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tentang'=>$T7->tentang), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nomorPenyidik'=>$brks_thp_1->no_berkas), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tanggalPenyidik'=>Yii::$app->globalfunc->ViewIndonesianFormat($brks_thp_1->tgl_berkas)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('penahanan'=>$T7->penahanan_dari), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nomorPenahanan'=>$T7->no_surat_t7), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tanggalPenahanan'=>Yii::$app->globalfunc->ViewIndonesianFormat($T7->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tglPermohonan'=>Yii::$app->globalfunc->ViewIndonesianFormat($T8->tgl_permohonan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('jaminan'=>$T8->jaminan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('namaJaksa'=>$jaksa->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkatJaksa'=>$jaksa->pangkat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nipJaksa'=>$jaksa->nip), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama_penandatangan'=>$pangkat->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat'=>$pangkat->pangkat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip_penandatangan'=>$pangkat->peg_nip_baru), array('parseLineBreaks'=>true));
    
    
    $docx->replaceVariableByText(array('nama_lengkap'=>$tersangka->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tmpt_tinggal'=>$tersangka->alamat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tmpt_lahir'=>$tersangka->tmpt_lahir), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_lahir'=>Yii::$app->globalfunc->ViewIndonesianFormat($tersangka->tgl_lahir)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('jns_kelamin'=>$tersangka->is_jkl), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('warganegara'=>$tersangka->warganegara1), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('agama'=>$tersangka->is_agama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pekerjaan'=>$tersangka->pekerjaan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pendidikan'=>$tersangka->is_pendidikan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('reg_tahanan'=>$tersangka->no_reg_tahanan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('reg_perkara'=>$tersangka->no_register_perkara), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('hari'=>$T8->hari_lapor), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('rutan'=>$T8->kepala_rutan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('dikeluarkan'=>ucfirst(strtolower($T8->dikeluarkan))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pd_tgl'=>Yii::$app->globalfunc->ViewIndonesianFormat($T8->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    
    
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
    
    $docx->createDocx('../web/template/pidum_surat/T-8');
    $file = '../web/template/pidum_surat/T-8.docx';
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
