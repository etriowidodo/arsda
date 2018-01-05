<?php

    use app\modules\datun\models\Sp1;
    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $connection = \Yii::$app->db;

    $docx   = new CreateDocxFromTemplate('../web/template/pidum/t6.docx');
    $satker     = ucwords(strtolower(Yii::$app->globalfunc->getNamaSatker($session['inst_satkerkd'])->inst_nama));
    
    $docx->replaceVariableByText(array('kejaksaan'=>$satker), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('dikeluarkan'=>$t6->dikeluarkan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_dikeluarkan'=>Yii::$app->globalfunc->ViewIndonesianFormat($t6->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nomor'=>$t6->no_surat_t6), array('parseLineBreaks'=>true));
    $sifat = \app\models\MsSifatSurat::findOne(['id' => $t6->sifat]);
    $docx->replaceVariableByText(array('sifat'=>$sifat->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('lampiran'=>$t6->lampiran), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kepada'=>$t6->kepada), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('ditempat'=>$t6->di_kepada), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('surat_dari'=>$spdp->idPenyidik->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nomor_penahanan'=>$t7->no_surat_perintah), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tanggal_penahanan'=>Yii::$app->globalfunc->ViewIndonesianFormat($t7->tgl_srt_perintah)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kejaksaan_perpanjangan'=>$t7->dikeluarkan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nomor_perpanjangan'=>$t6->no_surat_t6), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tanggal_perpanjangan'=>Yii::$app->globalfunc->getTanggalAngka($t6->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    $terdakwa = \app\modules\pidum\models\PdmBa4::findOne(['no_register_perkara'=>$session['no_register_perkara'] ,'no_reg_tahanan'=>$t6->id_tersangka]);
    $docx->replaceVariableByText(array('nama_perpanjangan'=>$terdakwa->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('berakhir_pada_perpanjangan'=>Yii::$app->globalfunc->GetNamaHari($t6->tgl_selesai)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tanggal_berakhir'=>Yii::$app->globalfunc->getTanggalAngka($t6->tgl_selesai)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('alasan'=>$t6->alasan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tanggal_mulai'=>Yii::$app->globalfunc->ViewIndonesianFormat($t6->tgl_mulai)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tanggal_selesai'=>Yii::$app->globalfunc->ViewIndonesianFormat($t6->tgl_selesai)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('karena'=>$t6->karena), array('parseLineBreaks'=>true));

    foreach($listPasal as $key){
            $dft_pasal .= $key['pasal'] . ' ' . $key['undang'] . ', ';
    }

    $docx->replaceVariableByText(array('pasal'=>empty($dft_pasal)? '-' : $dft_pasal), array('parseLineBreaks'=>true));

    #penanda tangan
    $sql ="select * from pidum.pdm_penandatangan where peg_nip_baru='".$t6->id_penandatangan."'";
    $model = $connection->createCommand($sql);
    $penandatangan = $model->queryOne();
    $docx->replaceVariableByText(array('kepala'=>$penandatangan['jabatan']), array('parseLineBreaks'=>true));
    //echo '<pre>';print_r($penandatangan);exit;
    $docx->replaceVariableByText(array('nama_penandatangan'=>$penandatangan['nama']), array('parseLineBreaks'=>true));
    $pangkat =explode('/',$penandatangan['pangkat']);

    $docx->replaceVariableByText(array('pangkat'=>$pangkat[0]), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip_penandatangan'=>$penandatangan['peg_nip_baru']), array('parseLineBreaks'=>true));

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
    //echo '<pre>';print_r($tembusan);exit;


    /*
    $odf->setVars('nama_penandatangan', $penandatangan['nama']);   
    $pangkat =explode('/',$penandatangan['pangkat']);
    $odf->setVars('pangkat', $pangkat[0]);       
    $odf->setVars('nip_penandatangan', $penandatangan['peg_nip_baru']);*/
    /*$pangkat = PdmPenandatangan::find()
->select ("a.jabatan as jabatan")
->from ("pidum.pdm_penandatangan a")
->join ('inner join','pidum.pdm_t6 b','a.peg_nik = b.id_penandatangan')
->where ("id_t6='".$id."'")
->one();
        $odf->setVars('kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
        $odf->setVars('kepala', $pangkat->jabatan);
        $odf->setVars('dikeluarkan', $pdmT6->dikeluarkan);
        $odf->setVars('tgl_dikeluarkan', Yii::$app->globalfunc->ViewIndonesianFormat($pdmT6->tgl_dikeluarkan));
        $odf->setVars('nomor', $pdmT6->no_surat);
        $sifat = \app\models\MsSifatSurat::findOne(['id' => $pdmT6->sifat]);
        $odf->setVars('sifat', $sifat->nama);
        $odf->setVars('lampiran', $pdmT6->lampiran);
        $odf->setVars('kepada', $pdmT6->kepada);
        $odf->setVars('ditempat', $pdmT6->di_kepada);
        $odf->setVars('surat_dari', $spdp->idPenyidik->nama);
               
        $odf->setVars('nomor_penahanan', is_null($perpanjanganTahanan['no_surat'])?'-':$perpanjanganTahanan['no_surat']);
        $odf->setVars('tanggal_penahanan', Yii::$app->globalfunc->ViewIndonesianFormat($perpanjanganTahanan['tgl_surat']));
        $odf->setVars('kejaksaan_perpanjangan', $pdmT4->dikeluarkan);
        $odf->setVars('nomor_perpanjangan', is_null($pdmT4->no_surat)?'-':$pdmT4->no_surat );
        $odf->setVars('tanggal_perpanjangan', is_null($pdmT4->tgl_dikeluarkan)?'-':$pdmT4->tgl_dikeluarkan);
        $Terdakwa = \app\modules\pidum\models\VwTerdakwa::findOne(['id_tersangka'=>$pdmT6->id_tersangka]);
        $odf->setVars('nama_perpanjangan', ucfirst(strtolower($Terdakwa->nama)));
        $hariSelesai = Yii::$app->globalfunc->GetNamaHari($pdmT4->tgl_selesai);
        $odf->setVars('berakhir_pada_perpanjangan', is_null($hariSelesai)?'-':$hariSelesai);
        $tgl_selesai = Yii::$app->globalfunc->ViewIndonesianFormat($pdmT4->tgl_selesai);
        $odf->setVars('tanggal_berakhir', $tgl_selesai);
        $odf->setVars('alasan', $pdmT6->alasan);
        
        
        $odf->setVars('tanggal_mulai', Yii::$app->globalfunc->ViewIndonesianFormat($pdmT6->tgl_mulai));
        $odf->setVars('tanggal_selesai', Yii::$app->globalfunc->ViewIndonesianFormat($pdmT6->tgl_selesai));
        $odf->setVars('karena', $pdmT6->karena);
        $pasal = Yii::$app->globalfunc->getDaftarPasal($pdmT6->id_perkara);
        $odf->setVars('pasal', $pasal);
        //tembusan
        $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_tembusan')
                ->where("id_perkara='".$pdmT6->id_perkara."' AND kode_table='".GlobalConstMenuComponent::T6."'")
        ->orderby('no_urut');
        $dt_tembusan = $query->createCommand();
        $listTembusan = $dt_tembusan->queryAll();
        $dft_tembusan = $odf->setSegment('tembusan');
        foreach($listTembusan as $element){
                $dft_tembusan->urutan_tembusan($element['no_urut']);
                $dft_tembusan->nama_tembusan($element['tembusan']);
                $dft_tembusan->merge();
        }
        $odf->mergeSegment($dft_tembusan);
        
        #penanda tangan
        $sql ="SELECT a.nama,a.pangkat,a.jabatan,c.peg_nip_baru FROM "
                . " pidum.pdm_penandatangan a, pidum.pdm_t6 b , kepegawaian.kp_pegawai c "
                . "where a.peg_nik = b.id_penandatangan and b.id_penandatangan =c.peg_nik and b.id_perkara='".$pdmT6->id_perkara."'";
        $model = $connection->createCommand($sql);
    $penandatangan = $model->queryOne();
        $odf->setVars('nama_penandatangan', $penandatangan['nama']);   
    $pangkat =explode('/',$penandatangan['pangkat']);
        $odf->setVars('pangkat', $pangkat[0]);       
        $odf->setVars('nip_penandatangan', $penandatangan['peg_nip_baru']);      





    
    //$session    = new session();
    //$no_register_perkara    = $session['no_register_perkara'];
    $satker     = ucwords(strtolower(Yii::$app->globalfunc->getNamaSatker($satker)->inst_nama));
    

        //$odf->setVars('Kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
    $docx->replaceVariableByText(array('Kejaksaan'=>$satker), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_pembuatan'=> Yii::$app->globalfunc->getTanggalAngka($ba4->tgl_ba4)), 
        array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('hari'=> Yii::$app->globalfunc->GetNamaHari($ba4->tgl_ba4)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nomor'=>$p16a['no_surat_p16a']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_dikeluarkan'=>Yii::$app->globalfunc->ViewIndonesianFormat($p16a['tgl_dikeluarkan'])), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('no_reg_bukti'=>$ba5->no_reg_bukti), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tempat'=>$ba5->lokasi), array('parseLineBreaks'=>true));

    //JAKSA
    $jaksa  = '';
    $noj=1;
    if (count($list_jpu_penerima) != 0){
        $jaksa = '<table border="0" ><tbody>';
        foreach ($list_jpu_penerima as $rowjaksa) {
            $jaksa .= '<tr><td width="8%" height="0%" style="font-family:Times New Roman; font-size:10pt;" >'.$noj.'.</td>
                           <td width="20%" height="0%" style="font-family:Times New Roman; font-size:10pt;">Nama</td>
                           <td width="6%" height="0%" style="font-family:Times New Roman; font-size:10pt;">: </td>
                           <td width="120%" height="0%" style="font-family:Times New Roman; font-size:10pt;">'.$rowjaksa["nama"].'</td></tr>
                       <tr><td style="font-family:Times New Roman; font-size:10pt;" ></td>
                           <td style="font-family:Times New Roman; font-size:10pt;">Pangkat / NIP</td>
                           <td style="font-family:Times New Roman; font-size:10pt;">: </td>
                           <td style="font-family:Times New Roman; font-size:10pt;">'.$rowjaksa["pangkat"].' / '.$rowjaksa["nip"].'</td></tr>
                       <tr><td style="font-family:Times New Roman; font-size:10pt;" ></td>
                           <td style="font-family:Times New Roman; font-size:10pt;">Jabatan</td>
                           <td style="font-family:Times New Roman; font-size:10pt;">: </td>
                           <td style="font-family:Times New Roman; font-size:10pt;">'.$rowjaksa["jabatan"].'</td></tr>
                           ';
                           $noj++;
        }
        $jaksa .= "</tbody></table>";
    }
    
    $docx->replaceVariableByHTML('jaksa', 'block', $jaksa, $arrDocnya);

    //SAKSI
    $saksi  = '';
    $noj=1;
    if (count($list_jpu_saksi) != 0){
        $saksi = '<table border="0" ><tbody>';
        foreach ($list_jpu_saksi as $rowsaksi) {
            $saksi .= '<tr><td width="8%" height="0%" style="font-family:Times New Roman; font-size:10pt;" >'.$noj.'.</td>
                           <td width="20%" height="0%" style="font-family:Times New Roman; font-size:10pt;">Nama</td>
                           <td width="6%" height="0%" style="font-family:Times New Roman; font-size:10pt;">: </td>
                           <td width="120%" height="0%" style="font-family:Times New Roman; font-size:10pt;">'.$rowsaksi["nama"].'</td></tr>
                       <tr><td style="font-family:Times New Roman; font-size:10pt;" ></td>
                           <td style="font-family:Times New Roman; font-size:10pt;">Pangkat / NIP</td>
                           <td style="font-family:Times New Roman; font-size:10pt;">: </td>
                           <td style="font-family:Times New Roman; font-size:10pt;">'.$rowsaksi["pangkat"].' / '.$rowsaksi["nip"].'</td></tr>
                       <tr><td style="font-family:Times New Roman; font-size:10pt;" ></td>
                           <td style="font-family:Times New Roman; font-size:10pt;">Jabatan</td>
                           <td style="font-family:Times New Roman; font-size:10pt;">: </td>
                           <td style="font-family:Times New Roman; font-size:10pt;">'.$rowsaksi["jabatan"].'</td></tr>
                           ';
                           $noj++;
        }
        $saksi .= "</tbody></table>";
    }
    
    $docx->replaceVariableByHTML('saksi', 'block', $saksi, $arrDocnya);
    $docx->replaceVariableByText(array('nomor'=>$p16a['no_surat_p16a']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_dikeluarkan'=>Yii::$app->globalfunc->getTanggalAngka($p16a->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tersangka'=>Yii::$app->globalfunc->getListTerdakwa($ba4->nama)), array('parseLineBreaks'=>true));
    
    $dft_pasal='';
    foreach($listPasal as $key){
            $dft_pasal .= $key['pasal'] . ' ' . $key['undang'] . ', ';
    }

    //echo '<pre>';print_r($listPasal);exit;
    //$odf->setVars('pasal', empty($dft_pasal)? '-' : preg_replace("/, $/", "", $dft_pasal));
    $docx->replaceVariableByText(array('pasal'=>empty($dft_pasal)? '-' : $dft_pasal), array('parseLineBreaks'=>true));

    $dft_barbuk='';
    $dft_tindakan='';
    foreach ($listBarbuk as $value) {
            $dft_barbuk .= $value['nama'] . ', ';
            $dft_tindakan .= $value['tindakan'] . ', ';
    }
    $docx->replaceVariableByText(array('berupa'=>preg_replace("/, $/", "", $dft_barbuk)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('disimpan_di'=>preg_replace("/, $/", "", $dft_tindakan)), array('parseLineBreaks'=>true));
    
    $docx->replaceVariableByText(array('penuntut_umum1'=>empty($list_jpu_penerima[0]['nama'])?'-':$list_jpu_saksi[0]['nama']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('penuntut_umum2'=>empty($list_jpu_penerima[1]['nama'])?'-':$list_jpu_saksi[1]['nama']), array('parseLineBreaks'=>true));

    $docx->replaceVariableByText(array('nama1'=>empty($list_jpu_saksi[0]['nama'])?'-':$list_jpu_saksi[0]['nama']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama2'=>empty($list_jpu_saksi[1]['nama'])?'-':$list_jpu_saksi[1]['nama']), array('parseLineBreaks'=>true));*/
        
    
    
    
    $docx->createDocx('../web/template/pidum_surat/t6');
    $file = '../web/template/pidum_surat/t6.docx';
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

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
