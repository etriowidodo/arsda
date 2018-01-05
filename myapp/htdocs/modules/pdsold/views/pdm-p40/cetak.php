<?php

    use app\modules\datun\models\Sp1;
    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pdsold/p40.docx');
    $satker     = ucwords(strtolower(Yii::$app->globalfunc->getNamaSatker($session['inst_satkerkd'])->inst_nama));
    //HEADER
    $docx->replaceVariableByText(array('kejaksaan'=>$satker), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nomor'=> $model->no_surat_p40), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('sifat'=> $sifat->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('lampiran'=> $model->lampiran), array('parseLineBreaks'=>true));
    //$docx->replaceVariableByText(array('dikeluarkan'=> $model->dikeluarkan), array('parseLineBreaks'=>true));
    //$docx->replaceVariableByText(array('tgl_dikeluarkan'=> Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kepada'=> $model->kepada), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('dix'=> $model->di_kepada), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama'=>$model->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kejaksaan'=>$satker), array('parseLineBreaks'=>true));
    $hasil = $model->id_msstatusdata;
    if($hasil=='1'){
        $isi = "penetapan";
    }else{
        $isi = "keputusan";
    }
    $docx->replaceVariableByText(array('isi'=>$isi), array('parseLineBreaks'=>true));

    $bunyi = 'Diktum '.$model->diktum.'<br>'.'Alasan '.$model->alasan;
    $docx->replaceVariableByHTML('berbunyi', 'block', $bunyi, $arrDocnya);
    $docx->replaceVariableByText(array('ptx'=>$model->ptinggi), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('lok_ptx'=>$model->alamat), array('parseLineBreaks'=>true));
    //$docx->replaceVariableByText(array('pn'=> $model->ptinggi), array('parseLineBreaks'=>true));

    $docx->replaceVariableByText(array('tanggal'=>Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tersangka'=>Yii::$app->globalfunc->getListTerdakwaBa4($model->no_register_perkara)), array('parseLineBreaks'=>true));


    $dft_pasal='';
    foreach($listPasal as $key){
            $dft_pasal .= $key['pasal'] . ' ' . $key['undang'] . ', ';
    }
    $docx->replaceVariableByText(array('pasal'=>$dft_pasal), array('parseLineBreaks'=>true));
    
    $tembusan ='';
    //echo '<pre>';print_r($listTembusan);exit;
   /* if (count($listTembusan) != 0) {
        $tembusan = '<table border="0" ><tbody>';
        foreach ($listTembusan as $rowlistTembusan) {
           $tembusan .= '<tr><td width="2%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px"> '.$rowlistTembusan[no_urut].'.</td>
                             <td width="40%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 0px">'.$rowlistTembusan[tembusan].'</td>
                             </tr>';
        }
        $tembusan .= "</tbody></table>";
    }*/
    //$docx->replaceVariableByHTML('tembusan', 'block', $tembusan, $arrDocnya);

    $docx->replaceVariableByText(array('nip'=>$model->nip), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat'=>$model->pangkat), array('parseLineBreaks'=>true));

    $docx->createDocx('../web/template/pdsold_surat/p40');
    $file = '../web/template/pdsold_surat/p40.docx';
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
