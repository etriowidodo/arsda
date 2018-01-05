<?php

    use app\modules\datun\models\Sp1;
    use app\modules\pidum\models\PdmP41Terdakwa;
    use app\modules\pidum\models\PdmPutusanPnTerdakwa;
    use app\modules\pidum\models\PdmMsRentut;
    use app\modules\pidum\models\VwTerdakwaT2;
    use app\modules\pidum\models\PdmP42;

    $p42 = PdmP42::findOne(['no_register_perkara'=>$_SESSION['no_register_perkara']]);
    
    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pidum/P-45.docx');
    $satker = Yii::$app->globalfunc->getNamaSatker($_SESSION['inst_satkerkd'])->inst_nama;

    //echo '<pre>';print_r(ucwords(strtolower($satker)));exit;

    $docx->replaceVariableByText(array('kejaksaan'=>ucfirst(strtoupper($satker))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kejaksaanl'=>ucwords(strtolower($satker))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nomor'=> $p45->no_surat_p45), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('sifat'=> $sifat->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('lampiran'=> $p45->lampiran), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pengadilan'=> Yii::$app->globalfunc->GetConfSatker()->p_negeri), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('dikeluarkan'=>$p45->dikeluarkan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_dikeluarkan'=> Yii::$app->globalfunc->ViewIndonesianFormat($p45->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tanggal_tuntut'=> Yii::$app->globalfunc->ViewIndonesianFormat($p42->tgl_baca_rentut)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kepada'=> $p45->kepada), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('menyatakan_terdakwa'=> $p45->pernyataan_terdakwa), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pendapat_jaksa'=> $p45->pernyataan_jaksa), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('ditempat'=> $p45->di_kepada), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pidana'=> Yii::$app->globalfunc->JenisPidana()), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('terdakwa'=> Yii::$app->globalfunc->GetHlistTerdakwaT2($p45->no_register_perkara)), array('parseLineBreaks'=>true));
    
    $docx->replaceVariableByText(array('nama_penandatangan'=>$pangkat->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat'=>$pangkat->pangkat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip_penandatangan'=>$pangkat->peg_nip_baru), array('parseLineBreaks'=>true));
    
    $docx->replaceVariableByText(array('nomor_pn'=> $pn['no_surat']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tanggal_pn'=> Yii::$app->globalfunc->ViewIndonesianFormat($pn['tgl_baca'])), array('parseLineBreaks'=>true));
    
    $tembusan ='<br>';
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
    
    //echo '<pre>';print_r($p41_tsk);exit;

    
    

    $menuntut = '<table border="0" width="100%" style="font-family:Times New Roman; font-size:11pt;" ><tbody>';
//        $i=1;
    $tersangka      = VwTerdakwaT2::findAll(['no_register_perkara' => $p45->no_register_perkara]);
    for ($i=0; $i < count($tersangka); $i++) { 
        $p41Terdakwa = PdmPutusanPnTerdakwa::findOne(['no_register_perkara'=>$p45->no_register_perkara, 'no_reg_tahanan'=>$tersangka[$i]->no_reg_tahanan, 'status_rentut' =>3]);
        $menuntut .= '<tr><td width="5%" style="vertical-align: top;"> - </td><td width="95%" style="vertical-align: top;">Menjatuhkan pidana terhadap terdakwa '.$tersangka[$i]->nama.' berupa '.PdmMsRentut::findOne($p41Terdakwa->id_ms_rentut)->nama.' ';

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
        $menuntut .= '</td></tr>';

    }

    $docx->replaceVariableByHTML('menyatakan', 'block', $menuntut, $arrDocnya);


    $menuntut = '<table border="0" width="100%" style="font-family:Times New Roman; font-size:11pt;" ><tbody>';
//        $i=1;
    $tersangka      = VwTerdakwaT2::findAll(['no_register_perkara' => $p45->no_register_perkara]);
    for ($i=0; $i < count($tersangka); $i++) { 
        $p41Terdakwa = PdmP41Terdakwa::findOne(['no_register_perkara'=>$p45->no_register_perkara, 'no_reg_tahanan'=>$tersangka[$i]->no_reg_tahanan, 'status_rentut' =>3]);
        $menuntut .= '<tr><td width="5%" style="vertical-align: top;"> - </td><td width="95%" style="vertical-align: top;">Menjatuhkan pidana terhadap terdakwa '.$tersangka[$i]->nama.' berupa '.PdmMsRentut::findOne($p41Terdakwa->id_ms_rentut)->nama.' ';

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
        $menuntut .= '</td></tr>';

    }
    $menuntut .= '</table>';
    $docx->replaceVariableByHTML('usul_jpu', 'block', $menuntut, $arrDocnya);


    
    
    $i=1;
    $ket_pertimbangan = '<br>';
    if (!empty($p41_tsk)) {
        $ket_pertimbangan .= '<table border="0" width="100%"><tbody>';
        foreach ($pertimbangan1[0] as $key => $value){
            $ket_pertimbangan .='<tr><td colspan="2" width="100%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px">4.'.$i.'. Pertimbangan pada tersangka '.$key.' :</td></tr>';
            foreach ($value as $key1 => $value1){
                $ket_pertimbangan .='<tr><td width="5%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px"></td>
                                     <td width="95%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 0px">- '.$value1.'</td></tr>';
            }
            $i++;
        }
        $ket_pertimbangan .= "</tbody></table>";
    }
    $docx->replaceVariableByHTML('pertimbangan', 'block', $ket_pertimbangan, $arrDocnya);
    
    $docx->createDocx('../web/template/pidum_surat/P-45');
    $file = '../web/template/pidum_surat/P-45.docx';
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
