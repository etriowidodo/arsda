<?php
    use app\models\MsSifatSurat;
    use app\modules\datun\models\Sp1;
    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pidum/t14.docx');

    $connection = \Yii::$app->db;

    //$image ='<br>';
    if(!empty($tersangka->foto)){
        $data = $tersangka->foto;
        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);
        $data = base64_decode($data);
        //echo '<pre>';print_r($data);exit;
        file_put_contents('t14.jpg', $data);

        //if(strlen($tersangka->foto)>0){
            $image = new WordFragment($docx, 'document');
            $image->addImage(array('src' => 't14.jpg' , 'scaling' => 75, 'float' => 'left', 'textWrap' => 1));
            $docx->replaceVariableByWordFragment(array('foto' => $image), array('type' => 'block'));        
            
    }else{
        $docx->replaceVariableByText(array('foto'=>''), array('parseLineBreaks'=>true));
    }
    
    
    /*}else{
        $frame = "<table border="1" ></table";

    }*/
    



    $satker     = ucwords(strtolower(Yii::$app->globalfunc->getNamaSatker($session['inst_satkerkd'])->inst_nama));
    //HEADER
    $docx->replaceVariableByText(array('Kejaksaan'=>$satker), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nomor'=>$model->no_surat_t14), array('parseLineBreaks'=>true));
    
    $sifat = MsSifatSurat::findOne(['id'=>$model->sifat]);

    $docx->replaceVariableByText(array('sifat'=>$sifat->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('lampiran'=>$model->lampiran), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kepada'=>$model->kepada), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('ditempat'=>$model->di_kepada), array('parseLineBreaks'=>true));
     
    //ISI
    $docx->replaceVariableByText(array('no_pengadilan'=>$model->no_pengadilan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_pengadilan'=>Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_pengadilan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pidana'=>$spdp->ket_kasus), array('parseLineBreaks'=>true));
    //TERSANGKA
    $sql ="select * from kepegawaian.kp_pegawai where peg_nip_baru='".$model->nip_jaksa."'";
    $dafaq = $connection->createCommand($sql);
    $jaksa = $dafaq->queryOne();
    /*$docx->replaceVariableByText(array('nama_pegawai'=>$jaksa['nama']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip_pegawai'=>$ba9->nip_jaksa), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat_pegawai'=>$jaksa['gol_pangkatjaksa']), array('parseLineBreaks'=>true));*/

    $docx->replaceVariableByText(array('nm_tersangka'=>$tersangka->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tmpt_lahir'=>$tersangka->tmpt_lahir), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_lahir'=>Yii::$app->globalfunc->ViewIndonesianFormat($tersangka->tgl_lahir)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('jns_kelamin'=>$tersangka->is_jkl), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('warganegara'=>$tersangka->warganegara1), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('alamat'=>$tersangka->alamat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('agama'=>$tersangka->is_agama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pekerjaan'=>$tersangka->pekerjaan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pendidikan'=>$tersangka->is_pendidikan), array('parseLineBreaks'=>true));
    
    
    $docx->replaceVariableByText(array('kepada_jaksa'=>$jaksa['nama']), array('parseLineBreaks'=>true));

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
    
    $ciri2 = json_decode($model->ciriciri);

    $ciri='<ol type="a">';
    if (!empty($ciri2->ciri)){
        for ($i=0; $i < count($ciri2->ciri); $i++) { 
                $ciri .= '<li>'.$ciri2->ciri[$i].' : '.$ciri2->isi[$i].'</li>';                
            }
            $ciri .= '</ol>';
        }
        //echo '<pre>';print_r($ciri2);exit;
        $docx->replaceVariableByHTML('ciri', 'block', $ciri, $arrDocnya);
    
    $docx->createDocx('../web/template/pidum_surat/t14');
    $file = '../web/template/pidum_surat/t14.docx';
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
