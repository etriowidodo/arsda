<?php

    use app\modules\datun\models\Sp1;
    use app\modules\pidum\models\PdmPkTingRef;
    use app\modules\pidum\models\PdmP41Terdakwa;
    use app\modules\pidum\models\PdmUuPasalTahap2;
    use app\modules\pidum\models\PdmMsRentut;
    use app\modules\pidum\models\PdmMsBarbukEksekusi;
    use app\modules\pidum\models\PdmP42;


    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pidum/p46.docx');
    // /echo '<pre>';print_r($tersangka);exit;
    
    //echo '<pre>';print_r($nominal);exit;
    
    $satker = Yii::$app->globalfunc->getNamaSatker($session['inst_satkerkd'])->inst_nama;
    $lokasi = Yii::$app->globalfunc->getNamaSatker($session['inst_satkerkd'])->inst_lokinst;
    //echo '<pre>';print_r($lokasi);exit;
    $docx->replaceVariableByText(array('Kejaksaan'=>ucfirst(strtoupper($satker))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('dikeluarkan'=>$model->dikeluarkan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_dikeluarkan'=>Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kepada'=>$model->kepada), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('ditempat'=>$model->di_kepada), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kejaksaan1'=>ucfirst($lokasi)), array('parseLineBreaks'=>true));    


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

    /*$amarx = '<br>';
    if(!empty($amar)){
        foreach ($amar as $key => $value) {
            $amarx .=  '- '.$value.'<br>';
        }    
    }*/
    $p41Terdakwa = $putusan_pn_terdakwa;
    $menuntut = '';
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


    //echo '<pre>';print_r($menuntut);exit;


    $alesan = '<br>';
    if(!empty($model->alasan)){
        $alesan = $model->alasan;
    }
    
    $docx->replaceVariableByText(array('amar_putusan'=>$menuntut), array('parseLineBreaks'=>true));

    $docx->replaceVariableByText(array('tgl_banding'=>Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByHTML('putusan', 'block', $alesan, $arrDocnya);
    $docx->replaceVariableByText(array('pengadilan'=>$model->pengadilan_tinggi), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pidana'=>$spdp->pkTingRef->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pasal'=>$listPasal), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('sebesar'=>number_format($model->biaya_perkara,0,'.',',')), array('parseLineBreaks'=>true));
    $nominal = Yii::$app->globalfunc->terbilang($model->biaya_perkara);
    $docx->replaceVariableByText(array('nominal'=>$nominal), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_tut'=>Yii::$app->globalfunc->ViewIndonesianFormat(PdmP42::findOne(['no_register_perkara'=>$model->no_register_perkara])->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    
    $docx->replaceVariableByText(array('nama_penandatangan'=>$model->nama_ttd), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat'=>$model->pangkat_ttd), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip_penandatangan'=>$model->nip_ttd), array('parseLineBreaks'=>true));


    $docx->createDocx('../web/template/pidum_surat/p46');
    $file = '../web/template/pidum_surat/p46.docx';
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
