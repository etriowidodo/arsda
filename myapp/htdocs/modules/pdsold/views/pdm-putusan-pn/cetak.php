<?php

    use app\modules\datun\models\Sp1;
use app\modules\pdsold\models\PdmUuPasalTahap2;
    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pdsold/P-41.docx');
    $satker = Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama;
    $docx->replaceVariableByText(array('Kejaksaan'=>ucfirst(strtoupper($satker))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pidana'=>$spdp->pkTingRef->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('sidang_ke'=>$agenda['sidang_ke']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nomor_p39'=>$agenda['no_regiter_perkara']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tanggal_p39'=>Yii::$app->globalfunc->ViewIndonesianFormat($agenda['tgl_acara_sidang'])), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nomor'=>$p41->no_surat_p41), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('sifat'=>$sifat->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('lampiran'=>$p41->lampiran), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kepada'=>$p41->kepada), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('di'=>$p41->di_kepada), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('dikeluarkan'=>$p41->dikeluarkan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama_terdakwa'=>Yii::$app->globalfunc->getListTerdakwaBa4($p41->no_register_perkara)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_dikeluarkan'=>Yii::$app->globalfunc->ViewIndonesianFormat($p41->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kerugian'=>$p41->kerugian_negara), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('mati'=>$p41->mati), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('luka'=>$p41->luka), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('lain_lain'=>$p41->akibat_lain), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pendapat_kajari'=>$p41->usul), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kasus_posisi'=>$thp_2->kasus_posisi), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama_penandatangan'=>$pangkat->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat'=>$pangkat->pangkat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip_penandatangan'=>$pangkat->peg_nip_baru), array('parseLineBreaks'=>true));
    
    
    
    $usul_jpu ='';
    $i=1;
//    
//    $pasal = json_decode($p41_terdakwa->undang_undang);
//    echo '<pre>';print_r($pasal);exit();
    if (count($p41_tsk) != 0) {
        $usul_jpu = '<table border="0" width="100%"><tbody>';
        foreach ($p41_tsk as $rowtsk) {
            $th             = $rowtsk[masa_percobaan_tahun]==''?'':$rowtsk[masa_percobaan_tahun].' Tahun';
            $bln            = $rowtsk[masa_percobaan_bulan]==''?'':$rowtsk[masa_percobaan_bulan].' Bulan';
            $hr             = $rowtsk[masa_percobaan_hari]==''?'':$rowtsk[masa_percobaan_hari].' Hari';
            $ms_percobaan   = ($rowtsk[masa_percobaan_tahun]!="" || $rowtsk[masa_percobaan_bulan]!="" || $rowtsk[masa_percobaan_hari]!="")?'<tr><td width="8%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px"> - </td>
                             <td width="92%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 0px">Masa Percobaan '.$th.' '.$bln.' '.$hr.' </td></tr>':"";
           
            $th_pdn         = $rowtsk[pidana_badan_tahun]==''?'':$rowtsk[pidana_badan_tahun].' Tahun';
            $bln_pdn        = $rowtsk[pidana_badan_bulan]==''?'':$rowtsk[pidana_badan_bulan].' Bulan';
            $hr_pdn         = $rowtsk[pidana_badan_hari]==''?'':$rowtsk[pidana_badan_hari].' Hari';
            $pdn            = ($rowtsk[pidana_badan_tahun]!="" || $rowtsk[pidana_badan_bulan]!="" || $rowtsk[pidana_badan_hari]!="")?'<tr><td width="8%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px"> - </td>
                             <td width="92%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 0px">Pidana Badan '.$th_pdn.' '.$bln_pdn.' '.$hr_pdn.'</td></tr>':"";
            
            $denda          = ($rowtsk[denda]!="")?'<tr><td width="8%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px"> - </td>
                             <td width="92%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 0px">Denda Rp. '.$rowtsk[denda].'</td></tr>':"";
            
            $th_sdr         = $rowtsk[subsidair_tahun]==''?'':$rowtsk[subsidair_tahun].' Tahun';
            $bln_sdr        = $rowtsk[subsidair_bulan]==''?'':$rowtsk[subsidair_bulan].' Bulan';
            $hr_sdr         = $rowtsk[subsidair_hari]==''?'':$rowtsk[subsidair_hari].' Hari';
            $sdr            = ($rowtsk[subsidair_tahun]!="" || $rowtsk[subsidair_bulan]!="" || $rowtsk[subsidair_hari]!="")?'<tr><td width="8%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px"> - </td>
                             <td width="92%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 0px">SubSidair '.$th_sdr.' '.$bln_sdr.' '.$hr_sdr.'</td></tr>':"";
            
            $biaya_pkr      = ($rowtsk[biaya_perkara]!="")?'<tr><td width="8%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px"> - </td>
                             <td width="92%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 0px">Biaya Perkara Rp.'.$rowtsk[biaya_perkara].'</td></tr>':"";
            
            $pdn_tmbh       = ($rowtsk[pidana_tambahan]!="")?'<tr><td width="8%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px"> - </td>
                             <td width="92%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 0px">Pidana Tambahan '.$rowtsk[pidana_tambahan].'</td></tr>':"";
            
           $usul_jpu .= '<tr><td colspan="8" width="100%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px">Usul Jaksa PU pada tersangka '.$rowtsk[nama].' :</td></tr>
                            '.$ms_percobaan.'
                            '.$pdn.'
                            '.$denda.'
                            '.$sdr.'
                            '.$biaya_pkr.'
                            '.$pdn_tmbh.'
                        ';
           $i++;
        }
        $usul_jpu .= "</tbody></table>";
    }
    $docx->replaceVariableByHTML('usul_jpu', 'block', $usul_jpu, $arrDocnya);
    
    
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

    $tersangka1 ='';
    $i=1;
    if (count($tersangka) != 0) {
        $tersangka1 = '<table border="0" width="100%"><tbody>';
        foreach ($tersangka as $rowqry_p29) {
           $tersangka1 .= '<tr><td width="9%" height="0%" style="font-family:Times New Roman; font-size:12pt;" >'.$i.'.</td>
                                <td width="30%" height="0%" style="font-family:Times New Roman; font-size:12pt;">Nama lengkap</td>
                                <td width="6%" height="0%" style="font-family:Times New Roman; font-size:12pt;">: </td>
                                <td width="55%" height="0%" style="font-family:Times New Roman; font-size:12pt;">'.$rowqry_p29["nama"].'</td></tr>
                            <tr><td style="font-family:Times New Roman; font-size:12pt;" ></td>
                                <td style="font-family:Times New Roman; font-size:12pt;">Tempat lahir</td>
                                <td style="font-family:Times New Roman; font-size:12pt;">: </td>
                                <td style="font-family:Times New Roman; font-size:12pt;">'.$rowqry_p29["tmpt_lahir"].'</td></tr>
                            <tr><td style="font-family:Times New Roman; font-size:12pt;" ></td>
                                <td style="font-family:Times New Roman; font-size:12pt;">Umur/tanggal lahir</td>
                                <td style="font-family:Times New Roman; font-size:12pt;">: </td>
                                <td style="font-family:Times New Roman; font-size:12pt;">'.$rowqry_p29["umur"].'/'.Yii::$app->globalfunc->ViewIndonesianFormat($rowqry_p29["tgl_lahir"]).'</td></tr>
                            <tr><td style="font-family:Times New Roman; font-size:12pt;" ></td>
                                <td style="font-family:Times New Roman; font-size:12pt;">Jenis kelamin</td>
                                <td style="font-family:Times New Roman; font-size:12pt;">: </td>
                                <td style="font-family:Times New Roman; font-size:12pt;">'.$rowqry_p29["is_jkl"].'</td></tr>
                            <tr><td style="font-family:Times New Roman; font-size:12pt;" ></td>
                                <td style="font-family:Times New Roman; font-size:12pt;">Kebangsaan/ Kewarganegaraan</td>
                                <td style="font-family:Times New Roman; font-size:12pt;">: </td>
                                <td style="font-family:Times New Roman; font-size:12pt;">'.$rowqry_p29["warganegara"].'</td></tr>
                            <tr><td style="font-family:Times New Roman; font-size:12pt;" ></td>
                                <td style="font-family:Times New Roman; font-size:12pt;">Tempat tinggal</td>
                                <td style="font-family:Times New Roman; font-size:12pt;">: </td>
                                <td style="font-family:Times New Roman; font-size:12pt;">'.$rowqry_p29["alamat"].'</td></tr>
                            <tr><td style="font-family:Times New Roman; font-size:12pt;" ></td>
                                <td style="font-family:Times New Roman; font-size:12pt;">Agama</td>
                                <td style="font-family:Times New Roman; font-size:12pt;">: </td>
                                <td style="font-family:Times New Roman; font-size:12pt;">'.$rowqry_p29["is_agama"].'</td></tr>
                            <tr><td style="font-family:Times New Roman; font-size:12pt;" ></td>
                                <td style="font-family:Times New Roman; font-size:12pt;">Pekerjaan</td>
                                <td style="font-family:Times New Roman; font-size:12pt;">: </td>
                                <td style="font-family:Times New Roman; font-size:12pt;">'.$rowqry_p29["pekerjaan"].'</td></tr>
                            <tr><td style="font-family:Times New Roman; font-size:12pt;" ></td>
                                <td style="font-family:Times New Roman; font-size:12pt;">Pendidikan</td>
                                <td style="font-family:Times New Roman; font-size:12pt;">: </td>
                                <td style="font-family:Times New Roman; font-size:12pt;">'.$rowqry_p29["is_pendidikan"].'</td></tr>
                                    <tr><td></td></tr>
                            <tr><td style="font-family:Times New Roman; font-size:12pt;" ></td>
                                <td colspan="3" style="font-family:Times New Roman; font-size:12pt;" >Telah sampai pada tahap tuntutan pidana (Requisitoir) yang akan dibacakan oleh jaksa penuntut umum pada : hari '.Yii::$app->globalfunc->GetNamaHari($rowqry_p29["tgl_baca_rentut"]).' tanggal '.Yii::$app->globalfunc->ViewIndonesianFormat($rowqry_p29["tgl_baca_rentut"]).'</td></tr>
                                    <tr><td></td></tr>
                                   ';
           $i++;
        }
        $tersangka1 .= "</tbody></table>";
        
    }
    $docx->replaceVariableByHTML('tersangka', 'block', $tersangka1, $arrDocnya);
    
    
    $barbuk1 ='';
    $i=1;
    if (count($barbuk) != 0) {
        $barbuk1 = '<table border="0" width="100%"><tbody>';
        foreach ($barbuk as $rowbarbuk) {
           $barbuk1 .= '<tr><td width="9%" height="0%" style="font-family:Times New Roman; font-size:12pt;" >'.$i.'. </td>
                                <td width="91%" height="0%" style="font-family:Times New Roman; font-size:12pt;">'.$rowbarbuk["nama"].'</td></tr>
                                   ';
           $i++;
        }
        $barbuk1 .= "</tbody></table>";
        
    }
    $docx->replaceVariableByHTML('barang_bukti', 'block', $barbuk1, $arrDocnya);
    
    $tolok_ukur ='';
    $i=1;
    if (count($p41_tsk) != 0) {
        $tolok_ukur = '<table border="0" width="100%"><tbody>';
        foreach ($p41_tsk as $rowtolok) {
           $tolok_ukur .= '<tr><td width="9%" height="0%" style="font-family:Times New Roman; font-size:12pt;" >'.$i.'.</td>
                                <td width="91%" height="0%" style="font-family:Times New Roman; font-size:12pt;">Tolok Ukur pada Tersangka '.$rowtolok["nama"].' yaitu '.$rowtolok["tolak_ukur"].'</td></tr>
                                   ';
           $i++;
        }
        $tolok_ukur .= "</tbody></table>";
        
    }
    $docx->replaceVariableByHTML('tolok_ukur', 'block', $tolok_ukur, $arrDocnya);
    
    $memberatkan ='';
    $i=1;
    if (count($p41_tsk) != 0) {
        $memberatkan = '<table border="0" width="100%"><tbody>';
        foreach ($p41_tsk as $rowberat) {
           $memberatkan .= '<tr><td width="9%" height="0%" style="font-family:Times New Roman; font-size:12pt;" >'.$i.'.</td>
                                <td width="91%" height="0%" style="font-family:Times New Roman; font-size:12pt;">Yang Memberatkan pada Tersangka '.$rowberat["nama"].' yaitu '.$rowberat["memberatkan"].'</td></tr>
                                   ';
           $i++;
        }
        $memberatkan .= "</tbody></table>";
        
    }
    $docx->replaceVariableByHTML('yang_memberatkan', 'block', $memberatkan, $arrDocnya);
    
    $meringankan ='';
    $i=1;
    if (count($p41_tsk) != 0) {
        $meringankan = '<table border="0" width="100%"><tbody>';
        foreach ($p41_tsk as $rowringan) {
           $meringankan .= '<tr><td width="9%" height="0%" style="font-family:Times New Roman; font-size:12pt;" >'.$i.'.</td>
                                <td width="91%" height="0%" style="font-family:Times New Roman; font-size:12pt;">Yang Meringankan pada Tersangka '.$rowringan["nama"].' yaitu '.$rowringan["meringankan"].'</td></tr>
                                   ';
           $i++;
        }
        $meringankan .= "</tbody></table>";
        
    }
    $docx->replaceVariableByHTML('yang_meringankan', 'block', $meringankan, $arrDocnya);
    
    $pasal ='';
    $i=1;
    if (count($uu_psl) != 0) {
        $pasal = '<table border="0" width="100%"><tbody>';
        foreach ($uu_psl as $rowpsl) {
           $pasal .= '<tr><td width="9%" height="0%" style="font-family:Times New Roman; font-size:12pt;" >'.$i.'.</td>
                                <td width="91%" height="0%" style="font-family:Times New Roman; font-size:12pt;">Undang-undang '.$rowpsl->undang.' '.$rowpsl->pasal.'</td></tr>
                                   ';
           $i++;
        }
        $pasal .= "</tbody></table>";
    }
    $docx->replaceVariableByHTML('pasal_didakwakan', 'block', $pasal, $arrDocnya);
    
    
    $dibuktikan ='';
    $i=1;
    $udg=[];
    if (count($p41_tsk) != 0) {
        $dibuktikan = '<table border="0" width="100%"><tbody>';
        foreach ($p41_tsk as $rowbukti) {
            $udg    = json_decode($rowbukti['undang_undang']);
            $dibuktikan .= '<tr><td colspan="2" width="100%" height="0%" style="font-family:Times New Roman; font-size:12pt;">Pasal Dakwaan yang dapat dibuktikan pada tersangka '.$rowbukti['nama'].'</td></tr>';
            $n = 1;
            For ($i=0;$i<count($udg->undang);$i++) {
//               $udg1 .= $udg->undang[$i];
                
               $qry   = PdmUuPasalTahap2::findOne(['id_pasal' => $udg->undang[$i]]);
//               $hasil_undang    .= $rowbukti['nama'].' '.$qry->undang.', ';
               $dibuktikan .= '<tr><td width="9%" height="0%" style="font-family:Times New Roman; font-size:12pt;" >'.$n.'.</td>
                                <td width="91%" height="0%" style="font-family:Times New Roman; font-size:12pt;">'.$qry->undang.' pasal '.$qry->pasal.'</td></tr>
                           ';
               $n++;
            }
           
           $i++;
        }
//        print_r($hasil_undang);exit();
//        echo $hasil_undang;exit();
//        print_r($udg->undang[0]);exit();
        $dibuktikan .= "</tbody></table>";
    }
    $docx->replaceVariableByHTML('pasal_dibuktikan', 'block', $dibuktikan, $arrDocnya);
    
    
    $docx->createDocx('../web/template/pdsold_surat/P-41');
    $file = '../web/template/pdsold_surat/P-41.docx';
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
