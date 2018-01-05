<?php

    use app\modules\datun\models\Sp1;
    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pidum/P16A.docx');
    $satker = Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama;
    $lain   = "-";
    
    $jaksi1  = '';
    if (count($jaksiss) != 0){
        $jaksi1 = '<table border="0" width = "100%"><tbody>';
        foreach ($jaksiss as $rowjaksiss) {
            $jaksi1 .= '<tr><td width="8%" height="0%" style="font-family:Times New Roman; font-size:11pt;" >'.$rowjaksiss["no_urut"].'.</td>
                           <td width="20%" height="0%" style="font-family:Times New Roman; font-size:11pt;">Nama</td>
                           <td width="6%" height="0%" style="font-family:Times New Roman; font-size:11pt;">: </td>
                           <td width="120%" height="0%" style="font-family:Times New Roman; font-size:11pt;">'.$rowjaksiss["nama"].'</td></tr>
                       <tr><td style="font-family:Times New Roman; font-size:11pt;" ></td>
                           <td style="font-family:Times New Roman; font-size:11pt;">Pangkat / NIP</td>
                           <td style="font-family:Times New Roman; font-size:11pt;">: </td>
                           <td style="font-family:Times New Roman; font-size:11pt;">'.$rowjaksiss["pangkat"].'/'.$rowjaksiss["nip"].'</td></tr>
                       <tr><td style="font-family:Times New Roman; font-size:11pt;" ></td>
                           <td style="font-family:Times New Roman; font-size:11pt;">Jabatan</td>
                           <td style="font-family:Times New Roman; font-size:11pt;">: </td>
                           <td style="font-family:Times New Roman; font-size:11pt;">Jaksa Penuntut Umum</td></tr>
                           ';
        }
        $jaksi1 .= "</tbody></table>";
    }
    
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
    
    $tsk1  = '<br>';
    if (count($tersangka) != 0) {
        $tsk1 = '<table border="0" ><tbody>';
        foreach ($tersangka as $rowtersangka){
            $tsk1 .='<tr><td width="35%" height="0%" style="font-family:Times New Roman; font-size:11pt;">Nama</td>
                         <td width="5%" height="0%" style="font-family:Times New Roman; font-size:11pt;">: </td>
                         <td width="100%" height="0%" style="font-family:Times New Roman; font-size:11pt;">'.$rowtersangka["nama"].'</td></tr>
                     <tr><td style="font-family:Times New Roman; font-size:11pt;">Tempat Lahir</td>
                         <td style="font-family:Times New Roman; font-size:11pt;">: </td>
                         <td style="font-family:Times New Roman; font-size:11pt;">'.$rowtersangka["tmpt_lahir"].'</td></tr>
                     <tr><td style="font-family:Times New Roman; font-size:11pt;">Umur/tanggal lahir</td>
                         <td style="font-family:Times New Roman; font-size:11pt;">: </td>
                         <td style="font-family:Times New Roman; font-size:11pt;">'.$rowtersangka["umur"].' Tahun / '.Yii::$app->globalfunc->ViewIndonesianFormat($rowtersangka["tgl_lahir"]).'</td></tr>
                     <tr><td style="font-family:Times New Roman; font-size:11pt;">Jenis Kelamin</td>
                         <td style="font-family:Times New Roman; font-size:11pt;">: </td>
                         <td style="font-family:Times New Roman; font-size:11pt;">'.$rowtersangka["id_jkl"].'</td></tr>
                     <tr><td style="font-family:Times New Roman; font-size:11pt;">Kebangsaan/<br/>Kewarganegaraan</td>
                         <td style="font-family:Times New Roman; font-size:11pt;">: </td>
                         <td style="font-family:Times New Roman; font-size:11pt;">'.$rowtersangka["warganegara"].'</td></tr>
                     <tr><td style="font-family:Times New Roman; font-size:11pt;">Tempat Tinggal</td>
                         <td style="font-family:Times New Roman; font-size:11pt;">: </td>
                         <td style="font-family:Times New Roman; font-size:11pt;">'.$rowtersangka["alamat"].'</td></tr>
                     <tr><td style="font-family:Times New Roman; font-size:11pt;">Agama</td>
                         <td style="font-family:Times New Roman; font-size:11pt;">: </td>
                         <td style="font-family:Times New Roman; font-size:11pt;">'.$rowtersangka["id_agama"].'</td></tr>
                     <tr><td style="font-family:Times New Roman; font-size:11pt;">Pekerjaan</td>
                         <td style="font-family:Times New Roman; font-size:11pt;">: </td>
                         <td style="font-family:Times New Roman; font-size:11pt;">'.$rowtersangka["pekerjaan"].'</td></tr>
                     <tr><td style="font-family:Times New Roman; font-size:11pt;">Pendidikan</td>
                         <td style="font-family:Times New Roman; font-size:11pt;">: </td>
                         <td style="font-family:Times New Roman; font-size:11pt;">'.$rowtersangka["id_pendidikan"].'</td></tr>
                     <tr><td style="font-family:Times New Roman; font-size:11pt;">Lain-lain</td>
                         <td style="font-family:Times New Roman; font-size:11pt;">: </td>
                         <td style="font-family:Times New Roman; font-size:11pt;">-</td></tr>
                     <tr><td height="0%"> </td></tr>
                     ';
            //$tsk1 .= $rowtersangka['warganegara'].'<br>';
        }
        $tsk1 .= "</tbody></table>";
    }
    //echo '<pre>';print_r($tsk1);exit;

    $docx->replaceVariableByText(array('satker'=>$satker), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('no_surat_p16a'=>$p16a['no_surat_p16a']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('di'=>$p16a['dikeluarkan']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_dikeluarkan'=>Yii::$app->globalfunc->ViewIndonesianFormat($p16a['tgl_dikeluarkan'])), array('parseLineBreaks'=>true));
    
    $docx->replaceVariableByHTML('tembusan', 'block', $tembusan, $arrDocnya);
    $docx->replaceVariableByHTML('tsk1', 'block', $tsk1, $arrDocnya);
    $docx->replaceVariableByHTML('jaksi1', 'block', $jaksi1, $arrDocnya);
//    $docx->replaceVariableByText(array('jaksi1'=>$jaksiss['no_urut']), array('parseLineBreaks'=>true));
    
    $docx->replaceVariableByText(array('pasalSpdp'=>$spdp['undang_pasal']), array('parseLineBreaks'=>true));
    //$ww = Yii::$app->globalfunc->getInstansipelaksanapenyidik();
    //echo '<pre>';print_r($ww);exit;
    $docx->replaceVariableByText(array('penyidik'=> Yii::$app->globalfunc->getInstansipelaksanapenyidik() ), array('parseLineBreaks'=>true));
    
    $docx->replaceVariableByText(array('jabatan'=>$penandatangan['jabatan']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama_penandatangan'=>$penandatangan['nama']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat_penandatangan'=>$penandatangan['pangkat']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip_penandatangan'=>$penandatangan['id_penandatangan']), array('parseLineBreaks'=>true));
    
    
    
    $docx->createDocx('../web/template/pidum_surat/P16A');
    $file = '../web/template/pidum_surat/P16A.docx';
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
