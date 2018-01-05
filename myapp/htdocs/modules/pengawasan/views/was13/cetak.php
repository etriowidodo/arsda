<?php
require_once('/wordtest/classes/CreateDocx.inc');

        $docx = new CreateDocxFromTemplate('../modules/pengawasan/template/was-13.docx');
        $kejaksaan=strtoupper($data_satker['inst_nama']);
        $hari      =($hari!=''?$hari:'');
       // $tgl_surat1 =($model['tanggal_surat']!=''?$tgl_surat:'');
        //$tgl_terima1=($model['tanggal_diterima']!=''?$tgl_terima:'');
        $no_surat  =($was13['no_surat_was13']!=''?$was13['no_surat_was13']:'');
        $pengirim  =($was13['nama_pengirim']!=''?$was13['nama_pengirim']:'');
        $kepada    =($was13['kepada']!=''?$was13['kepada']:'');
        $nama_penerima    =($was13['nama_penerima']!=''?$was13['nama_penerima']:'');
       // print_r($tgl_terima);
       // exit();

        $docx->setDefaultFont('Arial');
        $docx->replaceVariableByText(array('kejaksaan'=>strtoupper($kejaksaan)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('hari'=>$hari), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl_was13'=>$tgl_terima), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('pengirim'=>$pengirim), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('no_surat'=>$no_surat), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl_surat'=>$tgl_surat), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('kepada'=>$kepada), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('menerima_nama'=>$nama_penerima), array('parseLineBreaks'=>true));
        
        $docx->createDocx('template/pengawasan/was-13');
        
        $file = 'template/pengawasan/was-13.docx';

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