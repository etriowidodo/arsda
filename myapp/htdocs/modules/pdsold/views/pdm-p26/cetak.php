<?php

    use app\modules\datun\models\Sp1;
    use app\modules\pdsold\models\PdmBa5Barbuk;
    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pdsold/P-26.docx');
    $satker = Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama;
    
    $docx->replaceVariableByText(array('Kejaksaan'=>ucfirst(strtoupper($satker))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nomor_print'=> $p26->no_surat_p26), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('penyidik'=> $penyidik->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tanggal_surat'=> Yii::$app->globalfunc->ViewIndonesianFormat($p26->tgl_ba)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('namajaksa'=> ucfirst(strtolower($jaksa->nama))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkatjaksa'=> ucfirst(strtolower($jaksa->pangkat))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip_jaksa'=> $jaksa->nip), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('jabatan_jaksa'=> ucfirst(strtolower($jaksa->jabatan))), array('parseLineBreaks'=>true));

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
    $docx->replaceVariableByText(array('melanggar_pasal'=> Yii::$app->globalfunc->getPasalH($p26->no_register_perkara)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tanggal_persetujuan'=> Yii::$app->globalfunc->ViewIndonesianFormat($p26->tgl_persetujuan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('no_persetujuan'=> $p26->no_persetujuan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kasus_posisi'=> $p26->kasus_posisi), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pasal_disangkakan'=> Yii::$app->globalfunc->getPasalH($p26->no_register_perkara)), array('parseLineBreaks'=>true));

    $listBarbuk = PdmBa5Barbuk::find(['no_register_perkara'=>$p26->no_register_perkara])->asArray()->all();
    //echo '<pre>';print_r($listBarbuk);exit;
    $xbarbuk = '';
    $jum = count($listBarbuk);
    //echo '<pre>';print_r($jum);exit;
    if($jum<=10){
      foreach ($listBarbuk as $value) {
        $xbarbuk .= $value['no_urut_bb'].' .'.Yii::$app->globalfunc->GetDetBarbuk($p26->no_register_perkara,$value['no_urut_bb']).'<br>';
      }  
    }else{
      $xbarbuk = 'Terlampir';
    }
    
    //$xbarbuk .= '</ol>';

    $docx->replaceVariableByHTML('barbuk', 'block', $xbarbuk, $arrDocnya);


    //$docx->replaceVariableByText(array('barbuk'=> $p26->barbuk), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('alasan'=> $alasan->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nomor_bukti'=> '-'), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('di'=>ucfirst(strtolower($p26->dikeluarkan))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_di'=>Yii::$app->globalfunc->ViewIndonesianFormat($p26->tgl_surat)), array('parseLineBreaks'=>true));

    $docx->replaceVariableByText(array('kejaksaan'=>$pangkat->jabatan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama_penandatangan'=>$pangkat->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat_penandatangan'=>$pangkat->pangkat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip_penandatangan'=>$pangkat->peg_nip_baru), array('parseLineBreaks'=>true));
    
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
//    $docx->replaceVariableByHTML('tembusan', 'block', $tembusan, $arrDocnya);
    
    $docx->createDocx('../web/template/pdsold_surat/P-26');
    $file = '../web/template/pdsold_surat/P-26.docx';
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
