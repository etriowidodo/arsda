<?php
    use app\models\MsSifatSurat;
    use app\modules\pidum\models\PdmPkTingRef;
    use app\modules\datun\models\Sp1;
    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pidum/p35.docx');

    $connection = \Yii::$app->db;

    

    $satker     = ucwords(strtolower(Yii::$app->globalfunc->getNamaSatker($session['inst_satkerkd'])->inst_nama));
    //HEADER
    $docx->replaceVariableByText(array('kejaksaan'=>$satker), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nomor'=>$model->no_surat_p35), array('parseLineBreaks'=>true));
    
    $sifat = MsSifatSurat::findOne(['id'=>$model->sifat]);
    $perkara = PdmPkTingRef::findOne(['id'=>$spdp->id_pk_ting_ref]);

    $docx->replaceVariableByText(array('sifat'=>$sifat->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('lampiran'=>$model->lampiran), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kepada'=>$model->kepada), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('ditempat'=>$model->di_kepada), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama_lengkap'=>$tersangka->nama), array('parseLineBreaks'=>true));
    $dft_pasal='';
    foreach($listPasal as $key){
            $dft_pasal .= $key['pasal'] . ' ' . $key['undang'] . ', ';
    }
    $docx->replaceVariableByText(array('pasal'=>$dft_pasal), array('parseLineBreaks'=>true));
     
    //ISI
    $docx->replaceVariableByText(array('pidana'=>$perkara->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('no_p16a'=>substr($p16a->no_surat_p16a,7,100)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_p16a'=>Yii::$app->globalfunc->ViewIndonesianFormat($p16a->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pidana'=>$spdp->ket_kasus), array('parseLineBreaks'=>true));
    //TERSANGKA
    /*$sql ="select * from kepegawaian.kp_pegawai where peg_nip_baru='".$model->nip_jaksa."'";
    $dafaq = $connection->createCommand($sql);
    $jaksa = $dafaq->queryOne();*/
    /*$docx->replaceVariableByText(array('nama_pegawai'=>$jaksa['nama']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip_pegawai'=>$ba9->nip_jaksa), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat_pegawai'=>$jaksa['gol_pangkatjaksa']), array('parseLineBreaks'=>true));*/

    
    $docx->replaceVariableByText(array('tmpt_lahir'=>$tersangka->tmpt_lahir), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_lahir'=>Yii::$app->globalfunc->ViewIndonesianFormat($tersangka->tgl_lahir)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('umur'=>$tersangka->umur), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('jns_kelamin'=>$tersangka->is_jkl), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('warganegara'=>$tersangka->warganegara1), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('alamat'=>$tersangka->alamat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('agama'=>$tersangka->is_agama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pekerjaan'=>$tersangka->pekerjaan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pendidikan'=>$tersangka->is_pendidikan), array('parseLineBreaks'=>true));
    
    //END TERSANGKA
    $docx->replaceVariableByText(array('kasus_posisi'=>$tahap2->kasus_posisi), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tanggal_pelimpahan'=>Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_limpah)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pengadilan'=>$model->dilimpahkan), array('parseLineBreaks'=>true));
    //$listdakwaan = json_decode($model->dakwaan);
    //echo '<pre>';print_r($listdakwaan);exit;
    $dakwaan ='<br>'.$model->dakwaan;
    /*$dakwaan = '<table border="0" width="100%"><tbody>';
    for ($i=0; $i < count($listdakwaan->judul); $i++) { 
           $dakwaan .= '<tr><td width="30%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px"> '.$listdakwaan->judul[$i].'.</td>
                             <td width="70%" style="font-family:Times New Roman; font-size:11pt; margin-left = 0px">'.$listdakwaan->isi[$i].'</td>
                             </tr>';
    }
    $dakwaan .= "</tbody></table>";*/
    //echo '<pre>';print_r($dakwaan);exit;
    $docx->replaceVariableByHTML('dakwaan', 'block', $dakwaan, $arrDocnya);
    $sql ="select * from kepegawaian.kp_pegawai where peg_nip_baru='".$model->id_penandatangan."'";
    $lel = $connection->createCommand($sql);
    $ttd = $lel->queryOne();

    $docx->replaceVariableByText(array('kepala'=>$model['jabatan_ttd']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama_penandatangan'=>$model['nama_ttd']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat'=>$model['pangkat_ttd']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip_penandatangan'=>$model->id_penandatangan), array('parseLineBreaks'=>true));

    //echo '<pre>';print_r($ttd);exit;
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

    $docx->createDocx('../web/template/pidum_surat/p35');
    $file = '../web/template/pidum_surat/p35.docx';
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
