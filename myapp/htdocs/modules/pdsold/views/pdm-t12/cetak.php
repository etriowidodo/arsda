<?php
    use app\models\MsSifatSurat;
    use app\modules\datun\models\Sp1;
    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pdsold/t12.docx');

    $connection = \Yii::$app->db;

    //echo '<pre>';print_r($tersangka);exit;
    
    //$session    = new session();
    //$no_register_perkara    = $session['no_register_perkara'];
    $satker     = ucwords(strtolower(Yii::$app->globalfunc->getNamaSatker($session['inst_satkerkd'])->inst_nama));
    

    //HEADER
    $docx->replaceVariableByText(array('Kejaksaan'=>$satker), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nomor'=>$model->no_surat_t12), array('parseLineBreaks'=>true));
    
    $sifat = MsSifatSurat::findOne(['id'=>$model->sifat]);

    $docx->replaceVariableByText(array('sifat'=>$sifat->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('lampiran'=>$model->lampiran), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('dikeluarkan'=>$model->dikeluarkan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tanggal'=>Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kepada'=>$model->kepada), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('ditempat'=>$model->di_kepada), array('parseLineBreaks'=>true));
     
    //TERSANGKA
    $sql ="select * from kepegawaian.kp_pegawai where peg_nip_baru='".$model->nip_jaksa."'";
    $dafaq = $connection->createCommand($sql);
    $jaksa = $dafaq->queryOne();
    /*$docx->replaceVariableByText(array('nama_pegawai'=>$jaksa['nama']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip_pegawai'=>$ba9->nip_jaksa), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat_pegawai'=>$jaksa['gol_pangkatjaksa']), array('parseLineBreaks'=>true));*/

    $docx->replaceVariableByText(array('nama_lengkap'=>$tersangka->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tempat_lahir'=>$tersangka->tmpt_lahir), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_lahir'=>Yii::$app->globalfunc->ViewIndonesianFormat($tersangka->tgl_lahir)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('jns_kelamin'=>$tersangka->is_jkl), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('warganegara'=>$tersangka->warganegara1), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tmpt_tinggal'=>$tersangka->alamat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('agama'=>$tersangka->is_agama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pekerjaan'=>$tersangka->pekerjaan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pendidikan'=>$tersangka->is_pendidikan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('ditahan_sejak'=>Yii::$app->globalfunc->ViewIndonesianFormat($tersangka->tgl_mulai)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('reg_tahanan_no'=>$tersangka->no_reg_tahanan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('reg_perkara_no'=>$session['no_register_perkara']), array('parseLineBreaks'=>true));
    
    $docx->replaceVariableByText(array('dilaksanakan'=>$jaksa['nama']), array('parseLineBreaks'=>true));

    $sql ="select * from kepegawaian.kp_pegawai where peg_nip_baru='".$model->id_penandatangan."'";
    $lel = $connection->createCommand($sql);
    $ttd = $lel->queryOne();

    $docx->replaceVariableByText(array('kepala'=>$ttd['jabatan']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama_penandatangan'=>$ttd['nama']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat'=>$ttd['gol_pangkatjaksa']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip_penandatangan'=>$model->id_penandatangan), array('parseLineBreaks'=>true));

    //echo '<pre>';print_r($tembusan);exit;
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
    
    
    
    $docx->createDocx('../web/template/pdsold_surat/t12');
    $file = '../web/template/pdsold_surat/t12.docx';
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
