<?php

    use app\modules\datun\models\Sp1;
    use app\modules\pdsold\models\PdmUuPasalTahap2;
    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pdsold/checklist.docx');
    $satker = Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama;
    $docx->replaceVariableByText(array('Kejaksaan'=>ucfirst(strtoupper($satker))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama_tsk'=>$nama_tersangka), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('disangkakan'=>$spdp->undang_pasal), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('no_berkas'=>$pdm_berkas['no_berkas']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_berkas'=>Yii::$app->globalfunc->ViewIndonesianFormat($pdm_berkas['tgl_berkas'])), array('parseLineBreaks'=>true));
    
    $docx->createDocx('../web/template/pdsold_surat/checklist');
    $file = '../web/template/pdsold_surat/checklist.docx';
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
