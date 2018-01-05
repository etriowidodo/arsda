<?php

    use app\modules\datun\models\Sp1;
    use app\modules\pdsold\models\PdmPkTingRef;
    use app\modules\pdsold\models\PdmP41Terdakwa;
    use app\modules\pdsold\models\PdmUuPasalTahap2;
    use app\modules\pdsold\models\PdmMsRentut;
    use app\modules\pdsold\models\PdmMsBarbukEksekusi;
    use app\modules\pdsold\models\PdmBa5Barbuk;
    use app\modules\pdsold\models\VwTerdakwaT2;


    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pdsold/p42.docx');
    $satker = Yii::$app->globalfunc->getNamaSatker($_SESSION['inst_satkerkd'])->inst_nama;
    $no_register_perkara = $_SESSION['no_register_perkara'];
    $docx->replaceVariableByText(array('Kejaksaan'=>ucfirst(strtoupper($satker))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kejaksaan'=>ucfirst(strtolower($satker))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('no_perkara'=> $no_register_perkara), array('parseLineBreaks'=>true));


    $docx->replaceVariableByText(array('tgl_pen_hakim'=> Yii::$app->globalfunc->ViewIndonesianFormat($pen_hakim->tgl_penetapan_hakim)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('no_pen_hakim'=> $pen_hakim->no_penetapan_hakim), array('parseLineBreaks'=>true));
    
    
//    $ket_Saksi      = json_decode($p42->ket_saksi);
//    $ket_Ahli       = json_decode($p42->ket_ahli);
//    $ket_Surat      = json_decode($p42->ket_surat);
//    $ket_Petunjuk   = json_decode($p42->petunjuk);
//    $ket_Tersangka  = json_decode($p42->ket_tersangka);
//    $ket_Barbuk     = json_decode($p42->barbuk);
//    $ket_UnPas      = json_decode($p42->unsur_pasal);
//    $ket_Member     = json_decode($p42->memberatkan);
//    $ket_Mering     = json_decode($p42->meringankan);
    
//    $ket_saksi_ ='';
//    if (count($ket_Saksi) != 0) {
//        $ket_saksi_ = '<table border="0" width="100%"><tbody>';
////        $i=1;
//        for ($i = 0; $i < count($ket_Saksi); $i++){
//           $ket_saksi_ .= '<tr><td width="7%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px"> '.($i+1).'.</td>
//                             <td width="93%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 0px">'.$ket_Saksi[$i].'</td>
//                             </tr>';
//        }
//        $ket_saksi_ .= "</tbody></table>";
//    }
//    $docx->replaceVariableByHTML('ket_saksi', 'block', $ket_saksi_, $arrDocnya);
    
    
//    $ket_Ahli_ ='';
//    if (count($ket_Ahli) != 0) {
//        $ket_Ahli_ = '<table border="0" width="100%"><tbody>';
////        $i=1;
//        for ($i = 0; $i < count($ket_Ahli); $i++){
//           $ket_Ahli_ .= '<tr><td width="7%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px"> '.($i+1).'.</td>
//                             <td width="93%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 0px">'.$ket_Ahli[$i].'</td>
//                             </tr>';
//        }
//        $ket_Ahli_ .= "</tbody></table>";
//    }
//    $docx->replaceVariableByHTML('ket_ahli', 'block', $ket_Ahli_, $arrDocnya);
    
    $font = 'style="font-family:Times New Roman; font-size:12pt;"';
    
    //echo '<pre>';print_r($tersangka);exit;
    $tersangka1 ='<br>';
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

                            <tr><td></td>
                                <td></td>
                                <td></td>
                                <td></td></tr>';

           $i++;
        }
        $tersangka1 .= "</tbody></table>";
        
    }
    $docx->replaceVariableByHTML('tersangka', 'block', $tersangka1, $arrDocnya);
//    $surr = json_decode($p42->ket_surat);
//    $p_surat = '';
//    $urut = 1;
//    $p_surat .= '<table border="0" width="100%" '.$font.'><tbody>';
//    for ($i=0; $i < count($surr); $i++) {   
//        $p_surat .= '<tr><td>'.$urut.'. '.$surr[$i].'</td></tr>';
//        $urut++;
//    }
//    $p_surat .= '<tbody></table>';
//    //echo '<pre>';print_r($p_surat);exit;
//    $docx->replaceVariableByHTML('surat', 'block', $p_surat, $arrDocnya);

//    $petunjuk = json_decode($p42->petunjuk);
//    $p_petunjuk = '';
//    $urut = 1;
//    $p_petunjuk .= '<table border="0" width="100%" '.$font.'><tbody>';
//    for ($i=0; $i < count($petunjuk); $i++) {   
//        $p_petunjuk .= '<tr><td>'.$urut.'. '.$petunjuk[$i].'</td></tr>';
//        $p_petunjuk++;
//    }
//    $p_petunjuk .= '<tbody></table>';
//    $docx->replaceVariableByHTML('petunjuk', 'block', $p_petunjuk, $arrDocnya);
//
//    $ket_tersangka = json_decode($p42->ket_tersangka);
//    $p_ket = '';
//    $urut = 1;
//    $p_ket .= '<table border="0" width="100%" '.$font.'><tbody>';
//    for ($i=0; $i < count($ket_tersangka); $i++) {   
//        $p_ket .= '<tr><td>'.$urut.'. '.$ket_tersangka[$i].'</td></tr>';
//        $urut++;
//    }
//    $p_ket .= '<tbody></table>';
//    $docx->replaceVariableByHTML('ket_terdakwa', 'block', $p_ket, $arrDocnya);

    
    $barbuk = json_decode($p42->barbuk);
    $p_barbuk = '<br>';
    $urut = 1;
    $p_barbuk .= '<table border="0" width="100%" '.$font.'><tbody>';
    for ($i=0; $i < count($barbuk); $i++) {   
        $p_barbuk .= '<tr><td>'.$urut.'. '.$barbuk[$i].'</td></tr>';
        $urut++;
    }
    $p_barbuk .= '<tbody></table>';
    $docx->replaceVariableByHTML('barbuk', 'block', $p_barbuk, $arrDocnya);

    if ($ket == "BIASA"){
        $no_p29_30  = 'Surat Pelimpahan Perkara Acara Pemeriksaan Biasa'.' tanggal '.Yii::$app->globalfunc->ViewIndonesianFormat($p29->tgl_dikeluarkan).' Nomor '.$p29->no_register_perkara;
        $dakwaan_   = $p29->dakwaan;
    }else if ($ket == "SINGKAT"){
        $no_p29_30  = 'Surat Pelimpahan Perkara Acara Pemeriksaan Singkat'.' tanggal '.Yii::$app->globalfunc->ViewIndonesianFormat($p30->tgl_dikeluarkan).' Nomor '.$p30->no_register_perkara;
        $dakwaan_   = $p30->catatan;
    }
//    echo $no_p29_30;exit();
     
    $docx->replaceVariableByText(array('no_dakwaan'=>$no_p29_30), array('parseLineBreaks'=>true));
//    $docx->replaceVariableByHTML('dakwaan', 'block', $dakwaan_, $arrDocnya);

    $dakwaan = '<table border="0" width="100%"><tbody>';
    $dakwaan .= '<tr><td width="100%" height="0%" style="font-family:Times New Roman; font-size:12pt;" >'.$p42->unsur_dakwaan.'</td></tr>';
    $dakwaan .= "</tbody></table>";
    $docx->replaceVariableByHTML('dakwaan', 'block',$dakwaan , $arrDocnya);
//    echo '<pre>';print_r($dakwaan_);exit;
   
//    $docx->replaceVariableByText(array('unsur_dakwaan'=>$p42->unsur_dakwaan), array('parseLineBreaks'=>true));
//    $unsur_pasal = json_decode($p42->unsur_pasal);
//    $p_pasal = '';
//    $urut = 1;
//    $p_pasal .= '<table border="0" width="100%" '.$font.'><tbody>';
//    for ($i=0; $i < count($unsur_pasal); $i++) {   
//        $p_pasal .= '<tr><td>'.$urut.'. '.$unsur_pasal[$i].'</td></tr>';
//        $urut++;
//    }
//    $p_pasal .= '</tbody></table>';
//    $docx->replaceVariableByHTML('pasal', 'block', $p_pasal, $arrDocnya);

//    $docx->replaceVariableByText(array('uraian'=>$p42->uraian), array('parseLineBreaks'=>true));
//    echo '<pre>';print_r($p41);exit;
    
    /*$urut=1;
    $meringankan ="<br>";
    $meringankan = '<table border="0" width="100%"><tbody>';
    foreach ($p41 as $key ) {
//        echo '<pre>';print_r(json_decode($key['meringankan']));exit;
        $meringankan .= '<tr><td width="9%" height="0%" style="font-family:Times New Roman; font-size:12pt;" >'.$urut.'.</td>
                                <td width="30%" height="0%" style="font-family:Times New Roman; font-size:12pt;">'.Yii::$app->globalfunc->GetNamaTahananT2($no_register_perkara, $key['no_reg_tahanan']).' :</td></tr>';
        $isi_ringan = json_decode($key['meringankan'],True);
//        echo '<pre>';print_r($isi_ringan['isi']);exit;
        foreach ($isi_ringan['isi'] as $key1 => $value) {
//            echo '<pre>';print_r($value);exit;
            $meringankan .= '<tr><td width="9%" height="0%" style="font-family:Times New Roman; font-size:12pt;" ></td>
                                <td width="80%" height="0%" style="font-family:Times New Roman; font-size:12pt;" >'.$value.'.</td></tr>';
//            $meringankan .= '<p '.$font.'>'.$urut.'. '.Yii::$app->globalfunc->GetNamaTahananT2($no_register_perkara, $key['no_reg_tahanan']).' '.$ringan['isi'].'</p>';
        }
        
        

//        $memberatkan .= '<p '.$font.'>'.$urut.'. '.Yii::$app->globalfunc->GetNamaTahananT2($no_register_perkara, $key['no_reg_tahanan']).' '.$key['memberatkan'].'</p>';
        //echo '<pre>';print_r($me);
        $urut++;
    }
    $meringankan .= "</tbody></table>";

    $docx->replaceVariableByHTML('hal_meringankan', 'block', $meringankan, $arrDocnya);
    
    
    $urut=1;
    $memberatkan ="<br>";
    $memberatkan = '<table border="0" width="100%"><tbody>';
    foreach ($p41 as $key ) {
//        echo '<pre>';print_r(json_decode($key['meringankan']));exit;
        $memberatkan .= '<tr><td width="9%" height="0%" style="font-family:Times New Roman; font-size:12pt;" >'.$urut.'.</td>
                                <td width="30%" height="0%" style="font-family:Times New Roman; font-size:12pt;">'.Yii::$app->globalfunc->GetNamaTahananT2($no_register_perkara, $key['no_reg_tahanan']).' :</td></tr>';
        $isi_berat = json_decode($key['memberatkan'],True);
//        echo '<pre>';print_r($isi_ringan['isi']);exit;
        foreach ($isi_berat['isi'] as $key1 => $value) {
//            echo '<pre>';print_r($value);exit;
            $memberatkan .= '<tr><td width="9%" height="0%" style="font-family:Times New Roman; font-size:12pt;" ></td>
                                <td width="80%" height="0%" style="font-family:Times New Roman; font-size:12pt;" >'.$value.'.</td></tr>';
//            $meringankan .= '<p '.$font.'>'.$urut.'. '.Yii::$app->globalfunc->GetNamaTahananT2($no_register_perkara, $key['no_reg_tahanan']).' '.$ringan['isi'].'</p>';
        }
        
        $urut++;
    }
    $memberatkan .= "</tbody></table>";
    
    $docx->replaceVariableByHTML('hal_memberatkan', 'block', $memberatkan, $arrDocnya);*/


    $memberatkan ='<b></b>';
    $i=1;
    $p41_tsk = $p41;
    //echo '<pre>';print_r(count($p41_tsk));exit;
    if (count($p41_tsk) != 0) {
        
        foreach ($p41_tsk as $rowtsk => $valtsk){
            $nama = VwTerdakwaT2::findOne(['no_reg_tahanan'=>$valtsk['no_reg_tahanan']])->nama;
            //if($rowtsk==0){
                $memberatkan .= '<table border="0"  style="font-family:Times New Roman; font-size:12pt;" width="100%"><tr><td colspan="2"><strong>'.$nama.' :<br>Memberatkan</strong></tr>';
                $res = json_decode($valtsk['memberatkan']);    
            //}
            
            if(count($res->no_urut)>0){
                $nom = 1;
                for ($x=0; $x < count($res->no_urut); $x++) { 
                    $memberatkan .= '<tr><td width="9%" height="0%" >'.$nom.'.</td>
                                         <td width="91%" height="0%" >'.$res->isi[$x].'</td></tr>';
                    $nom++;
                }
                    
            }
            
            $memberatkan .= "</table>";
            

            
            
                $memberatkan .= '<table border="0" width="100%" style="font-family:Times New Roman; font-size:12pt;" width="100%"><tr><td colspan="2><tbody><tr><td colspan="2"><strong>Meringankan</strong></tr>';
                $res = json_decode($valtsk['meringankan']);    
            

            if(count($res->no_urut)>0){
                $nom = 1;
                for ($x=0; $x < count($res->no_urut); $x++) { 
                    $memberatkan .= '<tr><td width="9%" height="0%" >'.$nom.'.</td>
                                         <td width="91%" height="0%" >'.$res->isi[$x].'</td></tr>';
                    $nom++;
                }
                    
            }
            $memberatkan .= "</tbody></table><br>";       
        }
        
        
    } 

    //echo '<pre>';print_r($memberatkan);exit;
    //echo $memberatkan;exit;
    $docx->replaceVariableByHTML('hal_memberatkan', 'block', $memberatkan, $arrDocnya);


    $docx->replaceVariableByText(array('nama'=>Yii::$app->globalfunc->getListTerdakwaBa4($no_register_perkara)), array('parseLineBreaks'=>true));

    $pidana = PdmPkTingRef::findOne($spdp->id_pk_ting_ref)->nama;
    $docx->replaceVariableByText(array('pidana'=>$pidana), array('parseLineBreaks'=>true));
    //echo '<pre>';print_r($p41);exit;
    $no = 1;
    $idx = 0;
    $menuntut = "<br>";
    //echo '<pre>';print_r($tersangka[0]->nama);exit;
    if (count($tersangka) != 0) {
        $menuntut = '<table border="0" width="100%"'.$font.'><tbody>';
        //foreach ($tersangka as $rowqry_p29) {
        //for ($i=0; $i < count($tersangka); $i++) { 
           //$p41Terdakwa = PdmP41Terdakwa::findOne(['no_register_perkara'=>$no_register_perkara, 'no_reg_tahanan'=>$tersangka[$i]->no_reg_tahanan, 'status_rentut' =>3]);
            //$id_pasal = json_decode($p41Terdakwa->undang_undang);

            /*$pasal = PdmUuPasalTahap2::findAll(['no_register_perkara'=> $no_register_perkara, 'id_pasal'=>$id_pasal->undang[$i]]);
            foreach($pasal as $key){
                $dft_pasal .= $key['pasal'] . ' ' . $key['undang'] . ', ';
            }*/
            $no = '1. ';
            if($i<>0){$no= '- ';}
            $menuntut .= '<tr><td width="5%">1. </td><td width="95%"><p>Menyatakan Terdakwa '.Yii::$app->globalfunc->GetHlistTerdakwaT2($no_register_perkara).' bersalah melakukan tindak pidana '.$pidana.' sebagaimana diatur dan diancam pidana dalam pasal '.Yii::$app->globalfunc->getPasalH($no_register_perkara).' dalam surat dakwaan '.$no_register_perkara.'. </p></td></tr>';
        //}
        //echo '<pre>';print_r($p41Terdakwa);exit;
        for ($i=0; $i < count($tersangka); $i++) { 
            $no = '2.';
            if($i<>0){$no= '- ';}
            $p41Terdakwa = PdmP41Terdakwa::findOne(['no_register_perkara'=>$no_register_perkara, 'no_reg_tahanan'=>$tersangka[$i]->no_reg_tahanan, 'status_rentut' =>3]);
            $menuntut .= '<tr><td width="5%">'.$no.'</td><td width="95%"><p> Menjatuhkan pidana terhadap terdakwa '.$tersangka[$i]->nama.' berupa '.PdmMsRentut::findOne($p41Terdakwa->id_ms_rentut)->nama.' ';

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
            $menuntut .= '</p></td></tr>';
        }

        $menuntut .= '<tr><td width="5%">3. </td><td width="95%"><p>Menyatakan barang bukti berupa <ul>';

        foreach ($barbukList as $key=> $value ) {

            $menuntut .= '<li>'.Yii::$app->globalfunc->GetDetBarbuk(Yii::$app->session->get('no_register_perkara'),$value->no_urut_bb).' - '.PdmMsBarbukEksekusi::findOne($value->id_ms_barbuk_eksekusi)->nama.' </li>';
            
        }
        $menuntut .='</ul></p></td></tr>';

        for ($i=0; $i < count($tersangka); $i++) { 
            $no = '4.';
            if($i<>0){$no= '- ';}

            $p41Terdakwa = PdmP41Terdakwa::findOne(['no_register_perkara'=>$no_register_perkara, 'no_reg_tahanan'=>$tersangka[$i]->no_reg_tahanan, 'status_rentut' =>3]);

            $menuntut .= '<tr><td width="5%">'.$no.'</td><td width="95%"><p>Menetapkan agar terdakwa '.$tersangka[$i]->nama.' membayar biaya perkara sebesar Rp. '.number_format($p41Terdakwa->biaya_perkara,0,'.',',');
        }
        $idx++;
        $no++;

        //}

        $menuntut .= '</tbody></table>';
    }//exit;
    //echo '<pre>';print_r($menuntut);exit;
    $docx->replaceVariableByHTML('menuntut', 'block', $menuntut, $arrDocnya);

    $docx->replaceVariableByText(array('hari_w'=>Yii::$app->globalfunc->GetNamaHari($p42->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_keluar'=>Yii::$app->globalfunc->ViewIndonesianFormat($p42->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    
    $sql ="select * from kepegawaian.kp_pegawai where peg_nip_baru='".$p42->id_penandatangan."'";
    $model = Yii::$app->db->createCommand($sql);
    $ttd = $model->queryOne();
    
    //echo '<pre>';print_r($ttd);exit;
    $docx->replaceVariableByText(array('kepala'=>$ttd['jabatan']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat'=>$ttd['gol_pangkat']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip_penandatangan'=>$p42->id_penandatangan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama_penandatangan'=>$ttd['nama']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pengadilan'=>Yii::$app->globalfunc->GetConfSatker()->p_negeri), array('parseLineBreaks'=>true));


    $docx->createDocx('../web/template/pdsold_surat/p42');
    $file = '../web/template/pdsold_surat/p42.docx';
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
