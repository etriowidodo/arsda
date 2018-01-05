<?php
require_once('/wordtest/classes/CreateDocx.inc');

        $docx = new CreateDocxFromTemplate('../modules/pengawasan/template/was-13-inspeksi.docx');
        $kejaksaan=strtoupper($data_satker['inst_nama']);
        $hari      =($hari!=''?$hari:'');
       // // $tgl_surat1 =($model['tanggal_surat']!=''?$tgl_surat:'');
       //  //$tgl_terima1=($model['tanggal_diterima']!=''?$tgl_terima:'');
        $no_surat  =($model['no_surat_was13']!=''?$model['no_surat_was13']:'');
        $pengirim  =($model['nama_pengirim']!=''?$model['nama_pengirim']:'');
        $kepada    =($model['kepada']!=''?$model['kepada']:'');
        $nama_penerima    =($model['nama_penerima']!=''?$model['nama_penerima']:'');
        $pangkat    =($model['pangkat_penerima']!=''?$model['pangkat_penerima']:'');
        $nip    =($model['nip_penerima']!=''?$model['nip_penerima']:'');
       // // print_r($tgl_terima);
       // // exit();

       //  $docx->setDefaultFont('Arial');
        $docx->replaceVariableByText(array('kejaksaan'=>strtoupper($kejaksaan)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('hari'=>$hari), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl_was13'=>$tgl_terima), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('pengirim'=>$pengirim), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('no_surat'=>$no_surat), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl_surat'=>$tgl_surat), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('kepada'=>$kepada), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('menerima_nama'=>$nama_penerima), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('pangkat'=>$pangkat), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('nip'=>$nip), array('parseLineBreaks'=>true));
        
        $docx->createDocx('template/pengawasan/was-13-inspeksi');
        
        $file = 'template/pengawasan/was-13-inspeksi.docx';

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