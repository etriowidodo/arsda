<?php

    use app\modules\datun\models\Sp1;
    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pdsold/nota-pendapat-t4.docx');
    $satker = Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama;
    
    $docx->replaceVariableByText(array('satker'=>ucfirst(strtoupper($satker))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('id_perpanjangan'=>$nota_t4->id_perpanjangan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('no_surat_penahanan'=>$nota_t4->no_surat_penahanan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_nota'=>Yii::$app->globalfunc->ViewIndonesianFormat($nota_t4->tgl_nota)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tersangka'=>ucfirst(strtoupper($tersangka->nama))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('penyidik'=>ucfirst(strtoupper($penyidik->nama))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('hari'=>$nota_t4->persetujuan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kota'=>ucfirst(strtoupper($nota_t4->kota))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_awal'=>Yii::$app->globalfunc->ViewIndonesianFormat($nota_t4->tgl_awal_penahanan_oleh_penyidik)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_akhir'=>Yii::$app->globalfunc->ViewIndonesianFormat($nota_t4->tgl_akhir_penahanan_oleh_penyidik)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_awal_1'=>Yii::$app->globalfunc->ViewIndonesianFormat($nota_t4->tgl_awal_permintaan_perpanjangan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_akhir_1'=>Yii::$app->globalfunc->ViewIndonesianFormat($nota_t4->tgl_akhir_permintaan_perpanjangan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pasal'=>$spdp->undang_pasal), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('hari1'=>Yii::$app->globalfunc->GetNamaHari($nota_t4->tgl_nota)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl'=>Yii::$app->globalfunc->ViewIndonesianFormat($nota_t4->tgl_nota)), array('parseLineBreaks'=>true));
    $jaksa ='';
    if (count($nota_t4_jaksa) != 0) {
        $jaksa = '<table border="0" width="100%"><tbody>';
        foreach ($nota_t4_jaksa as $row_nota_t4_jaksa) {
           $jaksa .= '<tr><td width="9%" height="0%" style="font-family:Times New Roman; font-size:11pt;" >'.$row_nota_t4_jaksa["id_jaksa"].'.</td>
                           <td width="15%" height="0%" style="font-family:Times New Roman; font-size:11pt;">Nama</td>
                           <td width="3%" height="0%" style="font-family:Times New Roman; font-size:11pt;">: </td>
                           <td width="55%" height="0%" style="font-family:Times New Roman; font-weight: bold; font-size:11pt;">'.$row_nota_t4_jaksa["nama_jaksa_p16"].'</td></tr>
                       <tr><td style="font-family:Times New Roman; font-size:11pt;" ></td>
                           <td style="font-family:Times New Roman; font-size:11pt;">Pangkat / NIP</td>
                           <td style="font-family:Times New Roman; font-size:11pt;">: </td>
                           <td style="font-family:Times New Roman; font-size:11pt;">'.$row_nota_t4_jaksa["pangkat_jaksa_p16"].'/'.$row_nota_t4_jaksa["nip_jaksa_p16"].'</td></tr>
                       <tr><td style="font-family:Times New Roman; font-size:11pt;" ></td>
                           <td style="font-family:Times New Roman; font-size:11pt;">Jabatan</td>
                           <td style="font-family:Times New Roman; font-size:11pt;">: </td>
                           <td style="font-family:Times New Roman; font-size:11pt;">'.$row_nota_t4_jaksa["jabatan_jaksa_p16"].'</td></tr>
                           ';
        }
        $jaksa .= "</tbody></table>";
    }
    $docx->replaceVariableByHTML('jaksa', 'block', $jaksa, $arrDocnya);
    
    $hasil_jaksa ='';
    if (count($nota_t4_jaksa) != 0) {
        $hasil_jaksa = '<table border="0" width="100%"><tbody>';
        foreach ($nota_t4_jaksa as $row_nota_t4_jaksa) {
//           $hasil_jaksa .= '<tr><td width="9%" height="0%" style="font-family:Times New Roman; font-size:11pt;" >'.$row_nota_t4_jaksa["id_jaksa"].'.</td>
//                           <td width="15%" height="0%" style="font-family:Times New Roman; font-size:11pt;">Nama</td>
//                           <td width="3%" height="0%" style="font-family:Times New Roman; font-size:11pt;">: </td>
//                           <td width="55%" height="0%" style="font-family:Times New Roman; font-weight: bold; font-size:11pt;">'.$row_nota_t4_jaksa["nama_jaksa_p16"].'</td></tr>
//                       <tr><td style="font-family:Times New Roman; font-size:11pt;" ></td>
//                           <td style="font-family:Times New Roman; font-size:11pt;">Pangkat / NIP</td>
//                           <td style="font-family:Times New Roman; font-size:11pt;">: </td>
//                           <td style="font-family:Times New Roman; font-size:11pt;">'.$row_nota_t4_jaksa["pangkat_jaksa_p16"].'/'.$row_nota_t4_jaksa["nip_jaksa_p16"].'</td></tr>
//                       <tr><td style="font-family:Times New Roman; font-size:11pt;" ></td>
//                           <td style="font-family:Times New Roman; font-size:11pt;">Jabatan</td>
//                           <td style="font-family:Times New Roman; font-size:11pt;">: </td>
//                           <td style="font-family:Times New Roman; font-size:11pt;">'.$row_nota_t4_jaksa["jabatan_jaksa_p16"].'</td></tr>
//                           ';
           $hasil_jaksa .= '<tr><td width="90%" height="0%" style="font-family:Times New Roman; text-align: center; font-weight: bold; font-size:11pt;">Jaksa Penuntut Umum</td></tr>
                            <tr><td ></td></tr>
                            <tr><td ></td></tr>
                            <tr><td ></td></tr>
                            <tr><td width="90%" height="0%" style="font-family:Times New Roman; text-align: center; font-weight: bold; font-size:11pt;"><u>'.ucfirst(strtoupper($row_nota_t4_jaksa["nama_jaksa_p16"])).'</u></td></tr>
                            <tr><td style="font-family:Times New Roman; text-align: center; font-size:11pt;">'.$row_nota_t4_jaksa["pangkat_jaksa_p16"].'/'.$row_nota_t4_jaksa["nip_jaksa_p16"].'</td></tr>
                            <tr><td ></td></tr>
                           ';
        }
        $hasil_jaksa .= "</tbody></table>";
    }
    $docx->replaceVariableByHTML('hasil_jaksa', 'block', $hasil_jaksa, $arrDocnya);
    
    
    $docx->createDocx('../web/template/pdsold_surat/nota-pendapat-t4');
    $file = '../web/template/pdsold_surat/nota-pendapat-t4.docx';
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
