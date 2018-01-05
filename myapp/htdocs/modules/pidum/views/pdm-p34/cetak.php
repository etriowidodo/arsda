<?php

    use app\modules\datun\models\Sp1;
    use app\modules\security\models\ConfigSatker;
    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pidum/p34.docx');
    $connection = \Yii::$app->db;
    $conf = Yii::$app->globalfunc->GetConfSatker($session['inst_satkerkd']);
    $satker     = ucwords(strtolower(Yii::$app->globalfunc->getNamaSatker($session['inst_satkerkd'])->inst_nama));
    $docx->replaceVariableByText(array('Kejaksaan'=>$satker), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('hari'=>Yii::$app->globalfunc->GetNamaHari($model->tgl_surat_p34)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('time'=>substr($model->jam,0,5).' '.$conf->time_format), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl'=>Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_surat_p34)), array('parseLineBreaks'=>true));

    //ISI
    $sql ="select * from kepegawaian.kp_pegawai where peg_nip_baru='".$model->nip_jaksa."'";
    $modelx= $connection->createCommand($sql);
    $petugas = $modelx->queryOne();

    $docx->replaceVariableByText(array('pangkat'=>$petugas['gol_pangkat2']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('jabatan'=>$petugas['jabatan']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama_pegawai'=> $petugas['nama']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip'=>$model->nip_jaksa), array('parseLineBreaks'=>true));
    $barang_bukti = '';
    $barang_bukti .='<table border="0" width="100%" ><tbody>';

        $sql = "select * from pidum.pdm_barbuk where no_register_perkara='".$model->no_register_perkara."' order by no_urut_bb";
        $modelx= $connection->createCommand($sql);
        $listBarbuk = $modelx->queryAll();

        if(count($listBarbuk)>0){
            foreach ($listBarbuk as $key => $value) {
                $barang_bukti .= '<tr><td width="100%"  style="font-family:Times New Roman; font-size:11pt; margin-left = 10px"> '.$value['no_urut_bb'].'. '.Yii::$app->globalfunc->GetDetBarbuk($model->no_register_perkara,$value['no_urut_bb']).'</td>
                                 </tr>';
            }
        }
    //echo '<pre>';print_r($barang_bukti);exit;
    $barang_bukti .= '</tabel>';
    $docx->replaceVariableByText(array('terdakwax'=>Yii::$app->globalfunc->getListTerdakwaBa4($model->no_register_perkara)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByHTML('barang_bukti', 'block', $barang_bukti, $arrDocnya);

    $docx->replaceVariableByText(array('reg_barbuk'=>$ba5->no_reg_bukti), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pengadilan'=>$conf->p_negeri), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('menerima'=>$model->penerima), array('parseLineBreaks'=>true));

    $dft_pasal='';
    if(count($listPasal)>0){
        foreach($listPasal as $key){
                $dft_pasal .= $key['pasal'] . ' ' . $key['undang'] . ', ';
        }
    }
    $docx->replaceVariableByText(array('pasalx'=>$dft_pasal), array('parseLineBreaks'=>true));



    $docx->createDocx('../web/template/pidum_surat/p34');
    $file = '../web/template/pidum_surat/p34.docx';
    if (file_exists($file)){
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
