<?php
require_once('/wordtest/classes/CreateDocx.inc');

        $docx = new CreateDocxFromTemplate('../modules/pengawasan/template/lapdu template.docx');
        $kejaksaan=strtoupper($data_satker['inst_nama']);
        $lokasi=strtoupper($data_satker['inst_lokinst']);
        $perihal=($resultQuery['perihal_lapdu']!=''?$resultQuery['perihal_lapdu']:'<p></p>');
        $no_register=($resultQuery['no_register']!=''?$resultQuery['no_register']:'<p></p>');
        $tanggal_surat=($lapdu_tgl_surat!=''?$lapdu_tgl_surat:'<p></p>');
        $nomor_surat=($resultQuery['nomor_surat_lapdu']!=''?$resultQuery['nomor_surat_lapdu']:'<p></p>');
        $ringkasan=($resultQuery['ringkasan_lapdu']!=''?$resultQuery['ringkasan_lapdu']:'<p></p>');
        $asal_laporan='';
        foreach ($media_pelaporan as $key_asal) {
          $asal_laporan .=$key_asal['nama_media_pelaporan'];
        }

     
        $daftar_terlapor="";
        $no=1;
        foreach ($modelTerlapor as $key_terlapor) {
        $daftar_terlapor .=$no.'. '.$key_terlapor['nama_terlapor_awal'].'  ';
        $no++;
        }
        $docx->setDefaultFont('Arial');
        $checked=chr(82);/*di ceklis*/
        $unceked=chr(42);/*tidak diceklis*/
        /*print_r($terlaporForCek['insp1']);
        exit();*/

        if($terlaporForCek['insp1']==''){
           $docx->replaceVariableByHTML('insp1', 'inline','<p style="text-align: center; font-family: wingdings  2; font-size: 18px"><b>'.$unceked.'</b></p>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        }else{
           $docx->replaceVariableByHTML('insp1', 'inline','<p style="text-align: center; font-family: wingdings 2; font-size: 14px"><b>'.$checked.'</b></p>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        }/*untuk inspektur1*/

        if($terlaporForCek['insp2']==''){
           $docx->replaceVariableByHTML('insp2', 'inline','<p style="text-align: center; font-family: wingdings  2; font-size: 18px"><b>'.$unceked.'</b></p>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        }else{
           $docx->replaceVariableByHTML('insp2', 'inline','<p style="text-align: center; font-family: wingdings 2; font-size: 14px"><b>'.$checked.'</b></p>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        }/*inspektur2*/

        if($terlaporForCek['insp3']==''){
           $docx->replaceVariableByHTML('insp3', 'inline','<p style="text-align: center; font-family: wingdings  2; font-size: 18px"><b>'.$unceked.'</b></p>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        }else{
           $docx->replaceVariableByHTML('insp3', 'inline','<p style="text-align: center; font-family: wingdings 2; font-size: 14px"><b>'.$checked.'</b></p>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        }/*inspektur3*/

        if($terlaporForCek['insp4']==''){
           $docx->replaceVariableByHTML('insp4', 'inline','<p style="text-align: center; font-family: wingdings  2; font-size: 18px"><b>'.$unceked.'</b></p>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        }else{
           $docx->replaceVariableByHTML('insp4', 'inline','<p style="text-align: center; font-family: wingdings 2; font-size: 14px"><b>'.$checked.'</b></p>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        }/*inspektur4*/

        if($terlaporForCek['insp5']==''){
           $docx->replaceVariableByHTML('insp5', 'inline','<p style="text-align: center; font-family: wingdings  2; font-size: 18px"><b>'.$unceked.'</b></p>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        }else{
           $docx->replaceVariableByHTML('insp5', 'inline','<p style="text-align: center; font-family: wingdings 2; font-size: 14px"><b>'.$checked.'</b></p>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        }/*inspektur5*/
        
        // $docx->setDefaultFont('Arial');
        $docx->replaceVariableByHTML('kejaksaan', 'inline','<p style="text-align: justify; margin-left: 20px; font-size: 10px;">'.$kejaksaan.'</p>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByText(array('no_reg'=>$no_register), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('perihal'=>$perihal), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tanggal_surat'=>$tanggal_surat), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('nomor_surat'=>$nomor_surat), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('asal_laporan'=>$asal_laporan), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('terlapor'=>$daftar_terlapor), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ringkasan'=>$ringkasan), array('parseLineBreaks'=>true));
        
        $docx->createDocx('template/pengawasan/Was_lapdu_');
		
        $file = 'template/pengawasan/Was_lapdu_.docx';

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