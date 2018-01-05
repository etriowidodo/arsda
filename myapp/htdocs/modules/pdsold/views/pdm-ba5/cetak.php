<?php

    use app\modules\datun\models\Sp1;
    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pdsold/BA5.docx');
    

    
    //$session    = new session();
    //$no_register_perkara    = $session['no_register_perkara'];
    $satker     = ucwords(strtolower(Yii::$app->globalfunc->getNamaSatker($satker)->inst_nama));
    
    //echo '<pre>';print_r($p16a);exit;
        //$odf->setVars('Kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
    $docx->replaceVariableByText(array('Kejaksaan'=>$satker), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_pembuatan'=> Yii::$app->globalfunc->getTanggalAngka($ba4->tgl_ba4)), 
        array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('hari'=> Yii::$app->globalfunc->GetNamaHari($ba4->tgl_ba4)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nomor'=>!isset($p16a['no_surat_p16a']) ? $p16a['no_surat'] : $p16a['no_surat_p16a']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_dikeluarkan'=>Yii::$app->globalfunc->ViewIndonesianFormat($p16a['tgl_dikeluarkan'])), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('no_reg_bukti'=>$ba5->no_reg_bukti), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tempat'=>$ba5->lokasi), array('parseLineBreaks'=>true));

    //JAKSA
    $jaksa  = '<p>';
    $noj=1;
    if (count($list_jpu_penerima)> 0){
        $jaksa = '<table border="0" width="100%"><tbody>';
        foreach ($list_jpu_penerima as $rowjaksa) {
            $jaksa .= '<tr><td width="8%" height="0%" style="font-family:Times New Roman; font-size:10pt;" >'.$noj.'.</td>
                           <td width="20%" height="0%" style="font-family:Times New Roman; font-size:10pt;">Nama</td>
                           <td width="6%" height="0%" style="font-family:Times New Roman; font-size:10pt;">: </td>
                           <td width="66%" height="0%" style="font-family:Times New Roman; font-size:10pt;">'.$rowjaksa["nama"].'</td></tr>
                       <tr><td style="font-family:Times New Roman; font-size:10pt;" ></td>
                           <td style="font-family:Times New Roman; font-size:10pt;">Pangkat / NIP</td>
                           <td style="font-family:Times New Roman; font-size:10pt;">: </td>
                           <td width="66%" style="font-family:Times New Roman; font-size:10pt;">'.$rowjaksa["pangkat"].' / '.$rowjaksa["nip"].'</td></tr>
                       <tr><td style="font-family:Times New Roman; font-size:10pt;" ></td>
                           <td style="font-family:Times New Roman; font-size:10pt;">Jabatan</td>
                           <td style="font-family:Times New Roman; font-size:10pt;">: </td>
                           <td width="66%" style="font-family:Times New Roman; font-size:10pt;">'.$rowjaksa["jabatan"].'</td></tr>
                           ';
                           $noj++;
        }
        $jaksa .= "</tbody></table>";
        
    }else{
      $jaksa='<p></p>';
    }
    $docx->replaceVariableByHTML('jaksa', 'block', $jaksa, $arrDocnya);

    

    //SAKSI
    $saksi  = '<p>';
    $noj=1;
    if (count($list_jpu_saksi)> 0){
        $saksi = '<table border="0" width="100%" ><tbody>';
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
    }else{
      $saksi='<p></p>';
    }
    
    $docx->replaceVariableByHTML('saksi', 'block', $saksi, $arrDocnya);
    $docx->replaceVariableByText(array('nomor'=>!isset($p16a['no_surat_p16a']) ? $p16a['no_surat'] : $p16a['no_surat_p16a']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_dikeluarkan'=>Yii::$app->globalfunc->getTanggalAngka($p16a->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tersangka'=>Yii::$app->globalfunc->GetHlistTerdakwaT2($ba4->no_register_perkara)), array('parseLineBreaks'=>true));
    
    /*$dft_pasal='';
    foreach($listPasal as $key){
            $dft_pasal .= $key['pasal'] . ' ' . $key['undang'] . ', ';
    }*/

    //echo '<pre>';print_r($listPasal);exit;
    //$odf->setVars('pasal', empty($dft_pasal)? '-' : preg_replace("/, $/", "", $dft_pasal));
    $docx->replaceVariableByText(array('pasal'=>Yii::$app->globalfunc->getPasalH($ba4->no_register_perkara)), array('parseLineBreaks'=>true));

    $dft_barbuk='';
    $dft_tindakan='';
    $xbarbuk = '';
    $jum = count($listBarbuk);
    //echo '<pre>';print_r($jum);exit;
    if($jum<=10){
      foreach ($listBarbuk as $value) {
        $xbarbuk .= $value['no_urut_bb'].' .'.Yii::$app->globalfunc->GetDetBarbuk($ba5->no_register_perkara,$value['no_urut_bb']).'<br>';
      }  
    }else{
      $xbarbuk = 'Terlampir';
    }
    
    //$xbarbuk .= '</ol>';

    $docx->replaceVariableByHTML('berupa', 'block', $xbarbuk, $arrDocnya);


    //$docx->replaceVariableByText(array('berupa'=>preg_replace("/, $/", "", $dft_barbuk)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('disimpan_di'=>preg_replace("/, $/", "", $ba5->lokasi)), array('parseLineBreaks'=>true));
    
    $docx->replaceVariableByText(array('jabat2'=>empty($list_jpu_penerima[1]['nama'])?'': '2    Jaksa Penuntut Umum'), array('parseLineBreaks'=>true));


    $docx->replaceVariableByText(array('penuntut_umum1'=>empty($list_jpu_penerima[0]['nama'])?'-':$list_jpu_penerima[0]['nama']), array('parseLineBreaks'=>true));
    if(empty($list_jpu_penerima[1]['nama'])){
      $jaksa2 = '';
    }else{
      $jaksa2 = $list_jpu_penerima[1]['nama'];
    }
    $docx->replaceVariableByText(array('jaksa2'=>$jaksa2), array('parseLineBreaks'=>true));

    $docx->replaceVariableByText(array('nama1'=>empty($list_jpu_saksi[0]['nama'])?'-':$list_jpu_saksi[0]['nama']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama2'=>empty($list_jpu_saksi[1]['nama'])?'-':$list_jpu_saksi[1]['nama']), array('parseLineBreaks'=>true));


    $lampiran = '<p>';
    if(count($listBarbuk)>0){
      $lampiran .= '<h3 align="center"><strong> Lampiran Barang Bukti</strong> </h3><br>
      <table style="border-collapse: collapse;"" border="1" width="100%">
                    <thead>
                      <tr>
                        <th width ="5%">No</th>
                        <th>Barang Bukti</th>
                      </tr>
                    </thead>
                    <tbody>';
      foreach ($listBarbuk as $key => $value) {
        $lampiran .='<tr style="border-left:1pt;"><td align="center">'.$value['no_urut_bb'].'</td>';
        $lampiran .=    '<td align="left" style="border:none">'.Yii::$app->globalfunc->GetDetBarbuk($ba5->no_register_perkara,$value['no_urut_bb']).'</td></tr>';
      }
      $lampiran .='</tbody></table>';
    }

    //echo '<pre>';print_r($lampiran);exit;
    $docx->replaceVariableByHTML('lampiran', 'block', $lampiran, $arrDocnya);

    
        //$odf->setVars('berupa', preg_replace("/, $/", "", $dft_barbuk));
        //$odf->setVars('disimpan_di', preg_replace("/, $/", "", $dft_tindakan));


    //echo $saksi;exit;
    //echo '<pre>';print_r($saksi);exit;
/*
    $docx->replaceVariableByText(array('satker'=>$satker), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kejaksaan'=>$pangkat['jabatan']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('no_surat_p16a'=>$p16a['no_surat_p16a']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('di'=>$p16a['dikeluarkan']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_dikeluarkan'=>Yii::$app->globalfunc->ViewIndonesianFormat($p16a['tgl_dikeluarkan'])), array('parseLineBreaks'=>true));
    $jaksi1  = '';
    if (count($jaksiss) != 0){
        $jaksi1 = '<table border="0" ><tbody>';
        foreach ($jaksiss as $rowjaksiss) {
            $jaksi1 .= '<tr><td width="8%" height="0%" style="font-family:Times New Roman; font-size:10pt;" >'.$rowjaksiss["no_urut"].'.</td>
                           <td width="20%" height="0%" style="font-family:Times New Roman; font-size:10pt;">Nama</td>
                           <td width="6%" height="0%" style="font-family:Times New Roman; font-size:10pt;">: </td>
                           <td width="120%" height="0%" style="font-family:Times New Roman; font-size:10pt;">'.$rowjaksiss["nama"].'</td></tr>
                       <tr><td style="font-family:Times New Roman; font-size:10pt;" ></td>
                           <td style="font-family:Times New Roman; font-size:10pt;">Pangkat / NIP</td>
                           <td style="font-family:Times New Roman; font-size:10pt;">: </td>
                           <td style="font-family:Times New Roman; font-size:10pt;">'.$rowjaksiss["pangkat"].'/'.$rowjaksiss["nip"].'</td></tr>
                       <tr><td style="font-family:Times New Roman; font-size:10pt;" ></td>
                           <td style="font-family:Times New Roman; font-size:10pt;">Jabatan</td>
                           <td style="font-family:Times New Roman; font-size:10pt;">: </td>
                           <td style="font-family:Times New Roman; font-size:10pt;">'.$rowjaksiss["jabatan"].'</td></tr>
                           ';
        }
        $jaksi1 .= "</tbody></table>";
    }
    
    $tembusan ='';
    if (count($listTembusan) != 0) {
        $tembusan = '<table border="0" ><tbody>';
        foreach ($listTembusan as $rowlistTembusan) {
           $tembusan .= '<tr><td width="2%" height="0%" style="font-family:Times New Roman; font-size:10pt; margin-left = 10px"> '.$rowlistTembusan[no_urut].'.</td>
                             <td width="40%" height="0%" style="font-family:Times New Roman; font-size:10pt; margin-left = 0px">'.$rowlistTembusan[tembusan].'</td>
                             </tr>';
        }
        $tembusan .= "</tbody></table>";
    }
    
    $tsk1  = '';
    if (count($tersangka) != 0) {
        $tsk1 = '<table border="0" ><tbody>';
        foreach ($tersangka as $rowtersangka){
            $tsk1 .='<tr><td width="35%" height="0%" style="font-family:Times New Roman; font-size:10pt;">Nama</td>
                         <td width="5%" height="0%" style="font-family:Times New Roman; font-size:10pt;">: </td>
                         <td width="100%" height="0%" style="font-family:Times New Roman; font-size:10pt;">'.$rowtersangka["nama"].'</td></tr>
                     <tr><td style="font-family:Times New Roman; font-size:10pt;">Tempat Lahir</td>
                         <td style="font-family:Times New Roman; font-size:10pt;">: </td>
                         <td style="font-family:Times New Roman; font-size:10pt;">'.$rowtersangka["tmpt_lahir"].'</td></tr>
                     <tr><td style="font-family:Times New Roman; font-size:10pt;">Umur/tanggal lahir</td>
                         <td style="font-family:Times New Roman; font-size:10pt;">: </td>
                         <td style="font-family:Times New Roman; font-size:10pt;">'.Yii::$app->globalfunc->ViewIndonesianFormat($rowtersangka["tgl_lahir"]).'</td></tr>
                     <tr><td style="font-family:Times New Roman; font-size:10pt;">Jenis Kelamin</td>
                         <td style="font-family:Times New Roman; font-size:10pt;">: </td>
                         <td style="font-family:Times New Roman; font-size:10pt;">'.$rowtersangka["is_jkl"].'</td></tr>
                     <tr><td style="font-family:Times New Roman; font-size:10pt;">Kebangsaan/<br/>Kewarganegaraan</td>
                         <td style="font-family:Times New Roman; font-size:10pt;">: </td>
                         <td style="font-family:Times New Roman; font-size:10pt;">'.$rowtersangka["warganegara"].'</td></tr>
                     <tr><td style="font-family:Times New Roman; font-size:10pt;">Tempat Tinggal</td>
                         <td style="font-family:Times New Roman; font-size:10pt;">: </td>
                         <td style="font-family:Times New Roman; font-size:10pt;">'.$rowtersangka["alamat"].'</td></tr>
                     <tr><td style="font-family:Times New Roman; font-size:10pt;">Agama</td>
                         <td style="font-family:Times New Roman; font-size:10pt;">: </td>
                         <td style="font-family:Times New Roman; font-size:10pt;">'.$rowtersangka["is_agama"].'</td></tr>
                     <tr><td style="font-family:Times New Roman; font-size:10pt;">Pekerjaan</td>
                         <td style="font-family:Times New Roman; font-size:10pt;">: </td>
                         <td style="font-family:Times New Roman; font-size:10pt;">'.$rowtersangka["pekerjaan"].'</td></tr>
                     <tr><td style="font-family:Times New Roman; font-size:10pt;">Pendidikan</td>
                         <td style="font-family:Times New Roman; font-size:10pt;">: </td>
                         <td style="font-family:Times New Roman; font-size:10pt;">'.$rowtersangka["is_pendidikan"].'</td></tr>
                     <tr><td style="font-family:Times New Roman; font-size:10pt;">Lain-lain</td>
                         <td style="font-family:Times New Roman; font-size:10pt;">: </td>
                         <td style="font-family:Times New Roman; font-size:10pt;">-</td></tr>
                     <tr><td height="0%"> </td></tr>
                     ';
        }
        $tsk1 .= "</tbody></table>";
    }

    $docx->replaceVariableByText(array('satker'=>$satker), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kejaksaan'=>$pangkat['jabatan']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('no_surat_p16a'=>$p16a['no_surat_p16a']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('di'=>$p16a['dikeluarkan']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_dikeluarkan'=>Yii::$app->globalfunc->ViewIndonesianFormat($p16a['tgl_dikeluarkan'])), array('parseLineBreaks'=>true));
    
    $docx->replaceVariableByHTML('tembusan', 'block', $tembusan, $arrDocnya);
    $docx->replaceVariableByHTML('tsk1', 'block', $tsk1, $arrDocnya);
    $docx->replaceVariableByHTML('jaksi1', 'block', $jaksi1, $arrDocnya);
//    $docx->replaceVariableByText(array('jaksi1'=>$jaksiss['no_urut']), array('parseLineBreaks'=>true));
    
    $docx->replaceVariableByText(array('pasalSpdp'=>$spdp['undang_pasal']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('penyidik'=>$MsPenyidik['nama']), array('parseLineBreaks'=>true));
    
    $docx->replaceVariableByText(array('nama_penandatangan'=>$penandatangan['nama']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat_penandatangan'=>$penandatangan['pangkat']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip_penandatangan'=>$penandatangan['peg_nip_baru']), array('parseLineBreaks'=>true));*/
    ?>

    
    <?php
    $docx->createDocx('../web/template/pdsold_surat/BA5');
    $file = '../web/template/pdsold_surat/BA5.docx';
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
