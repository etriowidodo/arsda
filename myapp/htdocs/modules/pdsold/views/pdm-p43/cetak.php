<?php

    use app\modules\datun\models\Sp1;
    use app\modules\pdsold\models\MsJenisPerkara;
    use app\modules\pdsold\models\VwTerdakwaT2;
    use app\modules\pdsold\models\PdmP41Terdakwa;
    use app\modules\pdsold\models\PdmMsRentut;
    use app\modules\pdsold\models\PdmP42;
    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pdsold/P-43.docx');
    $satker = Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama;
    $docx->replaceVariableByText(array('kejaksaan'=>ucfirst(strtoupper($satker))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nomor'=> $p43->no_surat_p43), array('parseLineBreaks'=>true));
    $pidana = MsJenisPerkara::findOne(['kode_pidana'=>$spdp->kode_pidana,'jenis_perkara'=>$spdp->id_pk_ting_ref])->nama;
    $docx->replaceVariableByText(array('tindak_pidana'=>$pidana), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('sifat'=> $sifat->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('lampiran'=> $p43->lampiran), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('dikeluarkan'=> $p43->dikeluarkan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tanggal1'=> Yii::$app->globalfunc->ViewIndonesianFormat($p43->tgl_notel)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tanggal2'=> Yii::$app->globalfunc->ViewIndonesianFormat($sifat1['tgl_baca_rentut'])), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('hari'=> Yii::$app->globalfunc->GetNamaHari($sifat1['tgl_baca_rentut'])), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kepada'=> $p43->kepada), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('di_kepada'=> $p43->di_kepada), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('notel'=> $p43->notel), array('parseLineBreaks'=>true));
    
    $pet    = \app\modules\pidum\models\PdmMsStatusData::findOne(['id'=>$p43->petunjuk, 'is_group' => 'P-43 ']);
//    echo '<pre>';print_r($pet);exit();
    $docx->replaceVariableByText(array('petunjuk1'=> $pet->nama), array('parseLineBreaks'=>true));
    
    $docx->replaceVariableByText(array('terdakwa'=>Yii::$app->globalfunc->getListTerdakwaBa4($p43->no_register_perkara)), array('parseLineBreaks'=>true));
    
    $docx->replaceVariableByText(array('kepala'=>$pangkat->jabatan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama_penandatangan'=>$pangkat->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat'=>$pangkat->pangkat), array('parseLineBreaks'=>true));
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
    }else{
        $tembusan = '<table border="0" ><tbody>';
        $tembusan .= '<tr><td width="2%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px"> - </td>
                             <td width="40%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 0px"></td>
                             </tr>';
        $tembusan .= "</tbody></table>";
    }
    $docx->replaceVariableByHTML('tembusan', 'block', $tembusan, $arrDocnya);
    

    $ket_amar_ ='<br>';
    $tersangka = VwTerdakwaT2::findAll(['no_register_perkara'=>$p43->no_register_perkara]);
    for ($i=0; $i < count($tersangka); $i++) { 
        $p41Terdakwa = PdmP41Terdakwa::findOne(['no_register_perkara'=>$p43->no_register_perkara, 'no_reg_tahanan'=>$tersangka[$i]->no_reg_tahanan, 'status_rentut' =>3]);
        $menuntut .= '<p style="font-family:Times New Roman; font-size:11pt;">- Menjatuhkan pidana terhadap terdakwa '.$tersangka[$i]->nama.' berupa '.PdmMsRentut::findOne($p41Terdakwa->id_ms_rentut)->nama.' ';

        switch ($p41Terdakwa->id_ms_rentut) {
            case 3:
                $tahun_coba = !empty($p41Terdakwa->masa_percobaan_tahun) ? $p41Terdakwa->masa_percobaan_tahun : 0; 
                $tahun_badan= !empty($p41Terdakwa->pidana_badan_tahun) ? $p41Terdakwa->pidana_badan_tahun : 0;
                $tahun = $tahun_coba+$tahun_badan;

                $bulan_coba = !empty($p41Terdakwa->masa_percobaan_bulan) ? $p41Terdakwa->masa_percobaan_bulan : 0;
                $bulan_badan = !empty($p41Terdakwa->pidana_badan_bulan) ? $p41Terdakwa->pidana_badan_bulan : 0;
                $bulan = $bulan_coba+$bulan_badan;

                $hari_coba = !empty($p41Terdakwa->masa_percobaan_hari) ? $p41Terdakwa->masa_percobaan_hari : 0;
                $hari_badan = !empty($p41Terdakwa->pidana_badan_hari) ? $p41Terdakwa->pidana_badan_hari : 0;
                $hari = $hari_coba + $hari_badan;

                    if($hari>30){
                        $bulan++;
                        $hari = $hari%30;
                    }

                    if($bulan>12){
                        $tahun++;
                        $bulan = $bulan%12;
                    }
                $menuntut .= $tahun.' Tahun '.$bulan. ' Bulan '.$hari.' hari dengan dikurangi selama terdakwa berada dalam tahanan sementara ditambah dengan denda sebesar Rp. '.number_format($p41Terdakwa->denda,0,'.',',').' Subsidair selama ';
                
                $tahun_sub = !empty($p41Terdakwa->subsidair_tahun) ? $p41Terdakwa->subsidair_tahun : 0; 
                $bulan_sub = !empty($p41Terdakwa->subsidair_bulan) ? $p41Terdakwa->subsidair_bulan : 0;
                $hari_sub = !empty($p41Terdakwa->subsidair_hari) ? $p41Terdakwa->subsidair_hari : 0;
                $menuntut .= $tahun_sub.' Tahun '.$bulan_sub. ' Bulan '.$hari_sub.' hari kurungan';


                break;
            
            case 4:
                $bulan_denda = !empty($p41Terdakwa->kurungan_bulan) ? $p41Terdakwa->kurungan_bulan : 0;
                $hari_denda = !empty($p41Terdakwa->kurungan_hari) ? $p41Terdakwa->kurungan_hari : 0;

                $menuntut .= ' Sebesar Rp. '.number_format($p41Terdakwa->denda,0,'.',',').' dan dengan pengurangan masa tahanan '.$bulan_dendan.' Bulan '.$hari_denda.' Hari.';
                break;

            case 6:
                $menuntut .= ' Sebesar Rp. '.number_format($p41Terdakwa->denda,0,'.',',');
                break;
        }
        $menuntut .= '</p>';
    }

    //echo '<pre>';print_r($menuntut);exit;
    /*if (count($amar_tut) != 0) {
        $ket_amar_ = '<table border="0" width="100%"><tbody>';
//        $i=1;
        for ($i = 0; $i < count($amar_tut); $i++){
           $ket_amar_ .= '<tr><td width="11%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px"> 2.'.($i+1).'. '.$amar_tut[$i].'</td>
                             
                             </tr>';
        }
        $ket_amar_ .= "</tbody></table>";
    }*/
    $docx->replaceVariableByHTML('amar_tut', 'block', $menuntut, $arrDocnya);
    
    $docx->createDocx('../web/template/pdsold_surat/P-43');
    $file = '../web/template/pdsold_surat/P-43.docx';
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
