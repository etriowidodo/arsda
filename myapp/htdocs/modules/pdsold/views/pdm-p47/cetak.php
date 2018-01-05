<?php

    use app\modules\datun\models\Sp1;
    use app\modules\pdsold\models\PdmPkTingRef;
    use app\modules\pdsold\models\PdmP41Terdakwa;
    use app\modules\pdsold\models\PdmUuPasalTahap2;
    use app\modules\pdsold\models\PdmMsRentut;
    use app\modules\pdsold\models\PdmMsBarbukEksekusi;
    use app\modules\pdsold\models\PdmP42;



    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pdsold/p47.docx');
    // /echo '<pre>';print_r($tersangka);exit;
    
    //echo '<pre>';print_r($nominal);exit;
    $pengadilan = 'Pengadilan Negeri';
    if($model->pengadilan==1){
        $pengadilan = 'Pengadilan Tinggi';
    }

    $pidana = PdmMsRentut::findOne($putusan_pn_terdakwa->id_ms_rentut)->nama;
    if($putusan_pn_terdakwa->denda>0){
        $pidana .= ' Ditambah denda Rp.'.number_format($putusan_pn_terdakwa->denda,0,'.',',');
    }

    $satker = Yii::$app->globalfunc->getNamaSatker($session['inst_satkerkd'])->inst_nama;
    $lokasi = Yii::$app->globalfunc->getNamaSatker($session['inst_satkerkd'])->inst_lokinst;
    //echo '<pre>';print_r($lokasi);exit;
    $docx->replaceVariableByText(array('kejaksaan'=>ucfirst(strtoupper($satker))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('dikeluarkan'=>$model->dikeluarkan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_dikeluarkan'=>Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kepada'=>$model->kepada), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('ditempat'=>$model->di_kepada), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('PENGADILANU'=>strtoupper($pengadilan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('ket_pengadilan'=>ucfirst($model->pengadilan_negeri)), array('parseLineBreaks'=>true));    


    $docx->replaceVariableByText(array('nomor'=> $putusan_pn->no_surat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tanggal'=> Yii::$app->globalfunc->ViewIndonesianFormat($putusan_pn->tgl_dikeluarkan)), array('parseLineBreaks'=>true));

    $docx->replaceVariableByText(array('nama_lengkap'=>$tersangka->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tmpt_lahir'=>$tersangka->tmpt_lahir), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_lahir'=>Yii::$app->globalfunc->ViewIndonesianFormat($tersangka->tgl_lahir)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('umur'=>$tersangka->umur), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('jns_kelamin'=>$tersangka->is_jkl), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('warganegara'=>$tersangka->warganegara), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tempat_tinggal'=>$tersangka->alamat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('agama'=>$tersangka->is_agama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pekerjaan'=>$tersangka->pekerjaan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pendidikan'=>$tersangka->is_pendidikan), array('parseLineBreaks'=>true));

    foreach ($amar as $key => $value) {
        $amarx .=  '- '.$value.'<br>';
    }
    $docx->replaceVariableByHTML('amar_putusan', 'block', $amarx, $arrDocnya);

    $docx->replaceVariableByText(array('dakwaan'=>$model->dakwaan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pengadilan'=>$pengadilan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('alasan'=>$alasan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('di'=>$model->lokasi), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tindak_pidana'=>$pidana), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('np42'=>$p42->no_surat_p42.' Tanggal '.Yii::$app->globalfunc->ViewIndonesianFormat($p42->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    //$docx->replaceVariableByText(array('tgp42'=>Yii::$app->globalfunc->ViewIndonesianFormat($p42->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('sebesar'=>number_format($model->biaya_perkara,0,'.',',')), array('parseLineBreaks'=>true));
    $pertimbangan = json_decode($model->pertimbangan);
    //echo '<pre>';print_r(count($pertimbangan));exit;
    
    $gugatan='<ol>';
    for ($i=0; $i < count($pertimbangan); $i++) { 
        $gugatan .= '<li type="a">'.$pertimbangan[$i].'</li>';
    }
    $gugatan .='</ol>';
    //echo '<pre>';print_r($gugatan);exit;
    $docx->replaceVariableByHTML('gugatan', 'block', $gugatan, $arrDocnya);
/*    $docx->replaceVariableByText(array('tgl_banding'=>Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByHTML('putusan', 'block', $model->alasan, $arrDocnya);
    $docx->replaceVariableByText(array('pengadilan'=>$model->pengadilan_tinggi), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pidana'=>$spdp->pkTingRef->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pasal'=>$listPasal), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('sebesar'=>number_format($model->biaya_perkara,0,'.',',')), array('parseLineBreaks'=>true));
    $nominal = Yii::$app->globalfunc->terbilang($model->biaya_perkara);
    $docx->replaceVariableByText(array('nominal'=>$nominal), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_tut'=>Yii::$app->globalfunc->ViewIndonesianFormat(PdmP42::findOne(['no_register_perkara'=>$model->no_register_perkara])->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
*/   
    $tembusanc ='';
    if (count($tembusan) != 0) {
        $tembusanc = '<table border="0" ><tbody>';
        foreach ($tembusan as $rowlistTembusan) {
           $tembusanc .= '<tr><td width="2%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px"> '.$rowlistTembusan[no_urut].'.</td>
                             <td width="40%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 0px">'.$rowlistTembusan[tembusan].'</td>
                             </tr>';
        }
        $tembusanc .= "</tbody></table>";
    }
    $docx->replaceVariableByHTML('tembusan', 'block', $tembusanc, $arrDocnya);

    $docx->replaceVariableByText(array('nama_penandatangan'=>$model->nama_ttd), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat'=>$model->pangkat_ttd), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip_penandatangan'=>$model->nip_ttd), array('parseLineBreaks'=>true));


    $docx->createDocx('../web/template/pdsold_surat/p47');
    $file = '../web/template/pdsold_surat/p47.docx';
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
