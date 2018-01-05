<?php

    use app\modules\datun\models\Sp1;
    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pdsold/ba6.docx');
    $connection = \Yii::$app->db;
    //echo '<pre>';print_r($tersangka);exit;
    
    //$session    = new session();
    //$no_register_perkara    = $session['no_register_perkara'];
    $satker     = ucwords(strtolower(Yii::$app->globalfunc->getNamaSatker($session['inst_satkerkd'])->inst_nama));
    

        //$odf->setVars('Kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
    $docx->replaceVariableByText(array('Kejaksaan'=>$satker), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('hari'=> Yii::$app->globalfunc->GetNamaHari($model->tgl_ba6)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tglx'=> Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_ba6)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tempat'=>$model->lokasi), array('parseLineBreaks'=>true));
     //SAKSI
    $saksi  = '';    
    $modelJpu = json_decode($model->jaksa_saksi);
    
    $jumlah = count($modelJpu->nip);
//    if($jumlah>2){
//        $len = 2;
//    }else{
//        $len = $jumlah;
//    }
    $no=1;
    $saksi = '<table border="0" width="100%"><tbody>';
    for ($i=0; $i < $jumlah; $i++){
            $saksi .= '<tr><td width="8%" height="0%" style="font-family:Times New Roman; font-size:10pt;" >'.$no.'.</td>
                           <td width="20%" height="0%" style="font-family:Times New Roman; font-size:10pt;">Nama</td>
                           <td width="6%" height="0%" style="font-family:Times New Roman; font-size:10pt;">: </td>
                           <td width="120%" height="0%" style="font-family:Times New Roman; font-size:10pt;">'.$modelJpu->nama[$i].'</td></tr>
                       <tr><td style="font-family:Times New Roman; font-size:10pt;" ></td>
                           <td style="font-family:Times New Roman; font-size:10pt;">Pangkat / NIP</td>
                           <td style="font-family:Times New Roman; font-size:10pt;">: </td>
                           <td style="font-family:Times New Roman; font-size:10pt;">'.$modelJpu->gol[$i].' / '.$modelJpu->nip[$i].'</td></tr>
                       <tr><td style="font-family:Times New Roman; font-size:10pt;" ></td>
                           <td style="font-family:Times New Roman; font-size:10pt;">Jabatan</td>
                           <td style="font-family:Times New Roman; font-size:10pt;">: </td>
                           <td style="font-family:Times New Roman; font-size:10pt;">'.$modelJpu->jabatan[$i].'</td></tr>';
                           $no++;
        }
        $saksi .= "</tbody></table>";
    $docx->replaceVariableByHTML('saksi', 'block', $saksi, $arrDocnya);

    //JAKSA
    $jaksa  = '';    
    $no=1;
    $modelPenerima = json_decode($model->jaksa_penerima);
    $jumlah = count($modelPenerima->nip);
//    if($jumlah>2){
//        $len = 2;
//    }else{
//        $len = $jumlah;
//    }
    $jaksa = '<table border="0" width="100%" ><tbody>';
    for ($i=0; $i < $jumlah; $i++) {
            $jaksa .= '<tr><td width="8%" height="0%" style="font-family:Times New Roman; font-size:10pt;" >'.$no.'.</td>
                           <td width="20%" height="0%" style="font-family:Times New Roman; font-size:10pt;">Nama</td>
                           <td width="6%" height="0%" style="font-family:Times New Roman; font-size:10pt;">: </td>
                           <td width="120%" height="0%" style="font-family:Times New Roman; font-size:10pt;">'.$modelPenerima->nama[$i].'</td></tr>
                       <tr><td style="font-family:Times New Roman; font-size:10pt;" ></td>
                           <td style="font-family:Times New Roman; font-size:10pt;">Pangkat / NIP</td>
                           <td style="font-family:Times New Roman; font-size:10pt;">: </td>
                           <td style="font-family:Times New Roman; font-size:10pt;">'.$modelPenerima->gol[$i].' / '.$modelPenerima->nip[$i].'</td></tr>
                       <tr><td style="font-family:Times New Roman; font-size:10pt;" ></td>
                           <td style="font-family:Times New Roman; font-size:10pt;">Jabatan</td>
                           <td style="font-family:Times New Roman; font-size:10pt;">: </td>
                           <td style="font-family:Times New Roman; font-size:10pt;">'.$modelPenerima->jabatan[$i].'</td></tr>
                           ';
                           $no++;
        }
        $jaksa .= "</tbody></table>";
    
    $docx->replaceVariableByHTML('jaksa', 'block', $jaksa, $arrDocnya);

    $docx->replaceVariableByText(array('nama'=>$model->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('alamat'=>$model->alamat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pekerjaan'=>$model->pekerjaan), array('parseLineBreaks'=>true));
    $sts = \app\modules\pidum\models\PdmMsStatusData::findOne(['id'=>$model->id_sts]);
    echo '<pre>';print_r($sts);exit;
    $docx->replaceVariableByText(array('sts_penyimpanan'=>$sts->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kejaksaan_lower'=>$satker), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nomor16'=>substr($p16a->no_surat_p16a,6,99)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl16'=>Yii::$app->globalfunc->ViewIndonesianFormat($p16a->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nomor'=>$model->no_register_perkara), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('terdakwa'=>Yii::$app->globalfunc->getListTerdakwaBa4($model->no_register_perkara)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nomorba5'=>$ba5->no_reg_bukti), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('berupa'=>$dft_barbuk), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('menitipkan'=>$p16a->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('menerima'=>$modelPenerima->nama[0]), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('disimpan'=>' '), array('parseLineBreaks'=>true));
    
    $docx->createDocx('../web/template/pdsold_surat/ba6');
    $file = '../web/template/pdsold_surat/ba6.docx';
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
