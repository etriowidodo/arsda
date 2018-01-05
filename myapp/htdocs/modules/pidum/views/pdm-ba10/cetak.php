<?php

    use app\modules\datun\models\Sp1;
    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pidum/ba10.docx');
    $connection = \Yii::$app->db;
    //echo '<pre>';print_r($tersangka);exit;
    
    //$session    = new session();
    //$no_register_perkara    = $session['no_register_perkara'];
    $satker     = ucwords(strtolower(Yii::$app->globalfunc->getNamaSatker($session['inst_satkerkd'])->inst_nama));
    
    $hari=Yii::$app->globalfunc->GetNamaHari($ba10->tgl_ba10);
        //$odf->setVars('Kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
    $docx->replaceVariableByText(array('kejaksaan'=>$satker), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('hari'=> $hari), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_pembuatan'=> Yii::$app->globalfunc->ViewIndonesianFormat($ba10->tgl_ba10)), array('parseLineBreaks'=>true));

     #penanda tangan
    $sql ="select * from pidum.pdm_jaksa_p16a where nip='".$ba10->nip_jaksa."'";
    $model = $connection->createCommand($sql);
    $jaksa = $model->queryOne();
    $docx->replaceVariableByText(array('nama_pegawai'=>$jaksa['nama']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip_pegawai'=>$ba10->nip_jaksa), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat_pegawai'=>$jaksa['gol_pangkatjaksa']), array('parseLineBreaks'=>true));

    $docx->replaceVariableByText(array('nama_lengkap'=>$tersangka->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tmpt_lahir'=>$tersangka->tmpt_lahir), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_lahir'=>Yii::$app->globalfunc->ViewIndonesianFormat($tersangka->tgl_lahir)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('jenis_kelamin'=>$tersangka->is_jkl), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('warganegara'=>$tersangka->warganegara), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tmpt_tinggal'=>$tersangka->alamat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('agama'=>$tersangka->is_agama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pekerjaan'=>$tersangka->pekerjaan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pendidikan'=>$tersangka->is_pendidikan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_penahanan'=>Yii::$app->globalfunc->ViewIndonesianFormat($tersangka->tgl_mulai)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('no_reg_tahanan'=>$tersangka->no_reg_tahanan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('no_reg_perkara'=>$session['no_register_perkara']), array('parseLineBreaks'=>true));
    
    $docx->replaceVariableByText(array('Kejaksaan'=>$satker), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nomor'=>$t8->no_surat_t8), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tanggal_permohonan'=>Yii::$app->globalfunc->IndonesianFormat($t8->tgl_permohonan)), array('parseLineBreaks'=>true));
    //$docx->replaceVariableByText(array('dari_tahanan'=>$t7->lokasi_tahanan), array('parseLineBreaks'=>true));
    foreach($listPasal as $key){
            $dft_pasal .= $key['pasal'] . ' ' . $key['undang'] . ', ';
    }
    $docx->replaceVariableByText(array('tindakan'=>$ba10->tindakan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('dari_tahanan'=>$lokasi->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pasal'=>empty($dft_pasal)? '-' : $dft_pasal), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_mulai'=>Yii::$app->globalfunc->IndonesianFormat($tersangka->tgl_mulai)), array('parseLineBreaks'=>true));

    $docx->replaceVariableByText(array('nama_lengkap'=>$tersangka->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama_penandatangan'=>$jaksa['nama']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat'=>$jaksa['gol_pangkatjaksa']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip_penandatangan'=>$ba10->nip_jaksa), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kepala_rutan'=>$t8->kepala_rutan), array('parseLineBreaks'=>true));

    
    
    
    $docx->createDocx('../web/template/pidum_surat/ba10');
    $file = '../web/template/pidum_surat/ba10.docx';
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
