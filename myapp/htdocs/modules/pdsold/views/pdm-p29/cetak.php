<?php

    use app\modules\datun\models\Sp1;
    use app\modules\pdsold\models\VwTerdakwaT2;
    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pdsold/P-29.docx');
    $satker = Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama;
    
    $docx->replaceVariableByText(array('Kejaksaan'=>ucfirst(strtoupper($satker))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('no_reg_perkara'=>$id), array('parseLineBreaks'=>true));
    
    $tersangka ='<br>';
    $i=1;
    if (count($terdakwa) != 0) {
        $tersangka = '<table border="0" width="100%"><tbody>';
        foreach ($terdakwa as $rowqry_p29) {
           $tersangka .= '<tr><td width="5%" height="0%" style="font-family:Times New Roman; font-size:12pt;" >'.$i.'.</td>
                                <td width="30%" height="0%" style="font-family:Times New Roman; font-size:12pt;">Nama lengkap</td>
                                <td width="6%" height="0%" style="font-family:Times New Roman; font-size:12pt;">: </td>
                                <td width="120%" height="0%" style="font-family:Times New Roman; font-size:12pt;">'.$rowqry_p29["nama"].'</td></tr>
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
                                <td style="font-family:Times New Roman; font-size:12pt;">'.$rowqry_p29["warganegara1"].'</td></tr>
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
                                   ';
           $i++;
        }
        $tersangka .= "</tbody></table>";
        
    }
    $docx->replaceVariableByHTML('tersangka', 'block', $tersangka, $arrDocnya);
    
    $penahanan1 ='<br>';
    $i=1;

    //echo '<pre>';print_r($qry_p29);exit;
    if (count($qry_p29) != 0) {
        $penahanan1 = '<table border="0" width="100%"><tbody>';
        foreach ($riwayat[0] as $key => $values){
            $nama = VwTerdakwaT2::findOne(['no_register_perkara'=>$p29->no_register_perkara, 'no_reg_tahanan'=>$key])->nama;
            $penahanan1 .= '<tr><td colspan="5" width="100%" height="0%" style="font-family:Times New Roman; font-size:12pt;" >'.$i.'. Riwayat Penahanan Terdakwa '.$nama.'</td></tr>';
            
            $judul = ['Ditahan Oleh Penyidik Sejak','Diperpanjang Oleh Kejaksaan Sejak','Diperpanjang Oleh PN Sejak','Penahanan Oleh JPU Sejak','Diperpanjang Oleh Majelis Hakim Sejak','Diperpanjang Oleh Ketua PN Sejak'];
            $n=0;
            $h=1;
            //foreach ($values as $key1 => $values1) {
            $penahanan1 .= '<tr><td width="5%" height="0%" style="font-family:Times New Roman; font-size:12pt;" ></td>
                                <td width="5%" height="0%" style="font-family:Times New Roman; font-size:12pt;" > 1. </td>
                                <td width="30%" height="0%" style="font-family:Times New Roman; font-size:12pt;"> Ditahan Oleh Penyidik Sejak </td>
                                <td width="6%" height="0%" style="font-family:Times New Roman; font-size:12pt;">: </td>
                                <td width="120%" height="0%" style="font-family:Times New Roman; font-size:12pt;">'.Yii::$app->globalfunc->ViewIndonesianFormat($values->tgl_awal_penyidik).' s/d '.Yii::$app->globalfunc->ViewIndonesianFormat($values->tgl_akhir_penyidik).'</td></tr>';

            $penahanan1 .= '<tr><td width="5%" height="0%" style="font-family:Times New Roman; font-size:12pt;" ></td>
                                <td width="5%" height="0%" style="font-family:Times New Roman; font-size:12pt;" > 2. </td>
                                <td width="30%" height="0%" style="font-family:Times New Roman; font-size:12pt;">Diperpanjang Oleh Kejaksaan Sejak</td>
                                <td width="6%" height="0%" style="font-family:Times New Roman; font-size:12pt;">: </td>
                                <td width="120%" height="0%" style="font-family:Times New Roman; font-size:12pt;">'.Yii::$app->globalfunc->ViewIndonesianFormat($values->tgl_awal_kejaksaan).' s/d '.Yii::$app->globalfunc->ViewIndonesianFormat($values->tgl_akhir_kejaksaan).'</td></tr>';

            $penahanan1 .= '<tr><td width="5%" height="0%" style="font-family:Times New Roman; font-size:12pt;" ></td>
                                <td width="5%" height="0%" style="font-family:Times New Roman; font-size:12pt;" > 3. </td>
                                <td width="30%" height="0%" style="font-family:Times New Roman; font-size:12pt;">Diperpanjang Oleh PN Sejak</td>
                                <td width="6%" height="0%" style="font-family:Times New Roman; font-size:12pt;">: </td>
                                <td width="120%" height="0%" style="font-family:Times New Roman; font-size:12pt;">'.Yii::$app->globalfunc->ViewIndonesianFormat($values->tgl_awal_pn).' s/d '.Yii::$app->globalfunc->ViewIndonesianFormat($values->tgl_akhir_pn).'</td></tr>';

            $penahanan1 .= '<tr><td width="5%" height="0%" style="font-family:Times New Roman; font-size:12pt;" ></td>
                                <td width="5%" height="0%" style="font-family:Times New Roman; font-size:12pt;" > 4. </td>
                                <td width="30%" height="0%" style="font-family:Times New Roman; font-size:12pt;">Penahanan Oleh JPU Sejak</td>
                                <td width="6%" height="0%" style="font-family:Times New Roman; font-size:12pt;">: </td>
                                <td width="120%" height="0%" style="font-family:Times New Roman; font-size:12pt;">'.Yii::$app->globalfunc->ViewIndonesianFormat($values->tgl_mulai).' s/d '.Yii::$app->globalfunc->ViewIndonesianFormat($values->tgl_selesai).'</td></tr>';

            $penahanan1 .= '<tr><td width="5%" height="0%" style="font-family:Times New Roman; font-size:12pt;" ></td>
                                <td width="5%" height="0%" style="font-family:Times New Roman; font-size:12pt;" > 5. </td>
                                <td width="30%" height="0%" style="font-family:Times New Roman; font-size:12pt;">Diperpanjang Oleh Majelis Hakim</td>
                                <td width="6%" height="0%" style="font-family:Times New Roman; font-size:12pt;">: </td>
                                <td width="120%" height="0%" style="font-family:Times New Roman; font-size:12pt;">'.Yii::$app->globalfunc->ViewIndonesianFormat($values->tgl_awal_mh).' s/d '.Yii::$app->globalfunc->ViewIndonesianFormat($values->tgl_akhir_mh).'</td></tr>';

            $penahanan1 .= '<tr><td width="5%" height="0%" style="font-family:Times New Roman; font-size:12pt;" ></td>
                                <td width="5%" height="0%" style="font-family:Times New Roman; font-size:12pt;" > 5. </td>
                                <td width="30%" height="0%" style="font-family:Times New Roman; font-size:12pt;">Diperpanjang Oleh Majelis Hakim</td>
                                <td width="6%" height="0%" style="font-family:Times New Roman; font-size:12pt;">: </td>
                                <td width="120%" height="0%" style="font-family:Times New Roman; font-size:12pt;">'.Yii::$app->globalfunc->ViewIndonesianFormat($values->tgl_awal_ket_pn).' s/d '.Yii::$app->globalfunc->ViewIndonesianFormat($values->tgl_akhir_ket_pn).'</td></tr>';

            $penahanan1 .= '<tr><td width="5%" height="0%" style="font-family:Times New Roman; font-size:12pt;" ></td>
                                <td width="5%" height="0%" style="font-family:Times New Roman; font-size:12pt;" ></td>
                                <td width="30%" height="0%" style="font-family:Times New Roman; font-size:12pt;"></td>
                                <td width="6%" height="0%" style="font-family:Times New Roman; font-size:12pt;"></td>
                                <td width="120%" height="0%" style="font-family:Times New Roman; font-size:12pt;"></td></tr>';

              /*  $n++;
                $h++;
            }*/
                            
            $i++;
        }
    $penahanan1 .= "</tbody></table>"; 
    }


    //echo '<pre>';print_r($penahanan1);exit;
    $docx->replaceVariableByHTML('penahanan1', 'block', $penahanan1, $arrDocnya);
    
    
//    
//    $penahanan1 ='';
//    $i=1;
//    if (count($qry_p29) != 0) {
//        $penahanan1 = '<table border="0" width="100%"><tbody>';
//        foreach ($qry_p29 as $rowqry_p29) {
//           $tgl_mulai           = ($rowqry_p29["tgl_mulai_perpanjangan"]=="")?".......................":Yii::$app->globalfunc->ViewIndonesianFormat($rowqry_p29["tgl_mulai_perpanjangan"]).' s/d '.Yii::$app->globalfunc->ViewIndonesianFormat($rowqry_p29["tgl_selesai_perpanjangan"]);
//           $tgl_pengalihan      = ($rowqry_p29["tgl_mulai_pengalihan"]=="" && $rowqry_p29["tgl_selesai_pengalihan"]=="")?"..............................":Yii::$app->globalfunc->ViewIndonesianFormat($rowqry_p29["tgl_mulai_pengalihan"]).' s/d '.Yii::$app->globalfunc->ViewIndonesianFormat($rowqry_p29["tgl_selesai_pengalihan"]);
//           $tgl_penangguhan     = ($rowqry_p29["tgl_penangguhan"]=="")?"..............................":Yii::$app->globalfunc->ViewIndonesianFormat($rowqry_p29["tgl_penangguhan"]);
//           $tgl_pencabutan      = ($rowqry_p29["tgl_pencabutan"]=="")?"..............................":Yii::$app->globalfunc->ViewIndonesianFormat($rowqry_p29["tgl_pencabutan"]);
//           $tgl_pengeluaran     = ($rowqry_p29["tgl_pengeluaran"]=="")?"..............................":Yii::$app->globalfunc->ViewIndonesianFormat($rowqry_p29["tgl_pengeluaran"]);
//           $tgl_rutan           = ($rowqry_p29["lokasi_tahanan"]=="Rutan")?Yii::$app->globalfunc->ViewIndonesianFormat($rowqry_p29["tgl_mulai"]).' s/d '.Yii::$app->globalfunc->ViewIndonesianFormat($rowqry_p29["tgl_selesai"]):"............... s/d ................";
//           $tgl_rumah           = ($rowqry_p29["lokasi_tahanan"]=="Rumah")?Yii::$app->globalfunc->ViewIndonesianFormat($rowqry_p29["tgl_mulai"]).' s/d '.Yii::$app->globalfunc->ViewIndonesianFormat($rowqry_p29["tgl_selesai"]):"............... s/d ................";
//           $tgl_kota           = ($rowqry_p29["lokasi_tahanan"]=="Kota")?Yii::$app->globalfunc->ViewIndonesianFormat($rowqry_p29["tgl_mulai"]).' s/d '.Yii::$app->globalfunc->ViewIndonesianFormat($rowqry_p29["tgl_selesai"]):"............... s/d ................";
//           $penahanan1 .= '<tr><td width="5%" height="0%" style="font-family:Times New Roman; font-size:12pt;" >'.$i.'.</td>
//                                <td width="5%" height="0%" style="font-family:Times New Roman; font-size:12pt;" >1.</td>
//                                <td width="30%" height="0%" style="font-family:Times New Roman; font-size:12pt;">Rutan sejak</td>
//                                <td width="6%" height="0%" style="font-family:Times New Roman; font-size:12pt;">: </td>
//                                <td width="120%" height="0%" style="font-family:Times New Roman; font-size:12pt;">'.$tgl_rutan.'</td></tr>
//                            <tr><td width="5%" height="0%" style="font-family:Times New Roman; font-size:12pt;" ></td>
//                                <td width="5%" height="0%" style="font-family:Times New Roman; font-size:12pt;" >2.</td>
//                                <td width="30%" height="0%" style="font-family:Times New Roman; font-size:12pt;">Rumah sejak</td>
//                                <td width="6%" height="0%" style="font-family:Times New Roman; font-size:12pt;">: </td>
//                                <td width="120%" height="0%" style="font-family:Times New Roman; font-size:12pt;">'.$tgl_rumah.'</td></tr>
//                            <tr><td width="5%" height="0%" style="font-family:Times New Roman; font-size:12pt;" ></td>
//                                <td width="5%" height="0%" style="font-family:Times New Roman; font-size:12pt;" >3.</td>
//                                <td width="30%" height="0%" style="font-family:Times New Roman; font-size:12pt;">Kota</td>
//                                <td width="6%" height="0%" style="font-family:Times New Roman; font-size:12pt;">: </td>
//                                <td width="120%" height="0%" style="font-family:Times New Roman; font-size:12pt;">'.$tgl_kota.'</td></tr>
//                            <tr><td width="5%" height="0%" style="font-family:Times New Roman; font-size:12pt;" ></td>
//                                <td width="5%" height="0%" style="font-family:Times New Roman; font-size:12pt;" >4.</td>
//                                <td colspan="3" style="font-family:Times New Roman; font-size:12pt;">Perpanjangan penahanan oleh/tanggal '.$tgl_mulai.'</td>
//                                </tr>
//                            <tr><td width="5%" height="0%" style="font-family:Times New Roman; font-size:12pt;" ></td>
//                                <td width="5%" height="0%" style="font-family:Times New Roman; font-size:12pt;" >5.</td>
//                                <td colspan="3" style="font-family:Times New Roman; font-size:12pt;">Pengalihan jenis penahanan oleh/tanggal '.$tgl_pengalihan.'</td>
//                                </tr>
//                            <tr><td width="5%" height="0%" style="font-family:Times New Roman; font-size:12pt;" ></td>
//                                <td width="5%" height="0%" style="font-family:Times New Roman; font-size:12pt;" >6.</td>
//                                <td colspan="3" style="font-family:Times New Roman; font-size:12pt;">Penangguhan penahanan tanggal '.$tgl_penangguhan.'</td>
//                                </tr>
//                            <tr><td width="5%" height="0%" style="font-family:Times New Roman; font-size:12pt;" ></td>
//                                <td width="5%" height="0%" style="font-family:Times New Roman; font-size:12pt;" >7.</td>
//                                <td colspan="3" style="font-family:Times New Roman; font-size:12pt;">Pencabutan penangguhan penahanan oleh/tanggal '.$tgl_pencabutan.'</td>
//                                </tr>
//                            <tr><td width="5%" height="0%" style="font-family:Times New Roman; font-size:12pt;" ></td>
//                                <td width="5%" height="0%" style="font-family:Times New Roman; font-size:12pt;" >8.</td>
//                                <td colspan="3" style="font-family:Times New Roman; font-size:12pt;">Dikeluarkan dari tahanan oleh/tanggal '.$tgl_pengeluaran.'</td>
//                                </tr>
//                                   ';
//           $i++;
//        }
//        $penahanan1 .= "</tbody></table>";
//        
//    }
//    $docx->replaceVariableByHTML('penahanan1', 'block', $penahanan1, $arrDocnya);

    $dakwaan = '<table border="0" width="100%"><tbody>';
    $dakwaan .= '<tr><td width="100%" height="0%" style="font-family:Times New Roman; font-size:12pt;" >'.$p29->dakwaan.'</td></tr>';
    $dakwaan .= "</tbody></table>";
    $docx->replaceVariableByHTML('dakwaan', 'block',$dakwaan , $arrDocnya);
    
    $docx->replaceVariableByText(array('dikeluarkan'=>$p29->dikeluarkan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_dikeluarkan'=>Yii::$app->globalfunc->ViewIndonesianFormat($p29->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama_jpu'=>$p29->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat_jpu'=>$p29->pangkat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip_jpu'=>$p29->id_penandatangan), array('parseLineBreaks'=>true));
    
    foreach ($uupasal as $rowuupasal ) {
        $pasal  .= $rowuupasal[undang].' '.$rowuupasal[tentang].' '.$rowuupasal[pasal].", ";
    } 
    $pasal= substr($pasal, 0,-2);
    //echo '<pre>';print_r($pasal);exit;
    $docx->replaceVariableByText(array('pasal'=> $pasal), array('parseLineBreaks'=>true));
    
    
    
    $docx->createDocx('../web/template/pdsold_surat/P-29');
    $file = '../web/template/pdsold_surat/P-29.docx';
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
