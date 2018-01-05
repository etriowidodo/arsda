<?php

    use app\modules\datun\models\Sp1;
    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pdsold/nota-pendapat.docx');
    $satker = Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama;
    if($spdp->wilayah_kerja >= 5){
        $hasil_saran    = "SARAN KASI PIDUM";
    }
    else if ($spdp->wilayah_kerja == 2 && $spdp->wilayah_kerja != '00') {
        $hasil_saran    = "SARAN ASPIDUM";
    }
    else if ($spdp->wilayah_kerja == '00') {
        $hasil_saran    = "SARAN DIREKTUR";
    }else{}
    
    if($spdp->wilayah_kerja >= 5){
        $hasil_petunjuk    = "PETUNJUK KAJARI";
    }
    else if ($spdp->wilayah_kerja == 2 && $spdp->wilayah_kerja != '00') {
        $hasil_petunjuk    = "PETUNJUK KAJATI";
    }
    else if ($spdp->wilayah_kerja == '00') {
        $hasil_petunjuk    = "PETUNJUK JAMPIDUM";
    }else{

    }
        
    
    $docx->replaceVariableByText(array('saran_1'=>ucfirst(strtoupper($hasil_saran))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('petunjuk_1'=>ucfirst(strtoupper($hasil_petunjuk))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('Kejaksaan'=>ucfirst(strtoupper($satker))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kepada'=>$nota_pend->kepada), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('jabatan'=>$nota_pend->dari_jabatan_jaksa_p16a), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat'=>$nota_pend->dari_pangkat_jaksa_p16a), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip'=>$nota_pend->dari_nip_jaksa_p16a), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama'=>$nota_pend->dari_nama_jaksa_p16a), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_nota'=>Yii::$app->globalfunc->ViewIndonesianFormat($nota_pend->tgl_nota)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('perihal'=>$nota_pend->perihal_nota), array('parseLineBreaks'=>true));
    
    $docx->replaceVariableByHTML('dasar', 'block', empty($nota_pend->dasar_nota) ? '<p>' : $nota_pend->dasar_nota, $arrDocnya);
    $docx->replaceVariableByHTML('pendapat', 'block', empty($nota_pend->pendapat_nota) ? '<p>' : $nota_pend->pendapat_nota, $arrDocnya);
    $docx->replaceVariableByHTML('saran', 'block', empty($nota_pend->saran_nota) ? '<p>' : $nota_pend->saran_nota, $arrDocnya);
    $docx->replaceVariableByHTML('petunjuk2', 'block', empty($nota_pend->petunjuk_nota) ? '<p>' : $nota_pend->petunjuk_nota , $arrDocnya);
//    $docx->replaceVariableByText(array('dasar'=>$nota_pend->dasar_nota), array('parseLineBreaks'=>true));
//    $docx->replaceVariableByText(array('pendapat'=>$nota_pend->pendapat_nota), array('parseLineBreaks'=>true));
//    $docx->replaceVariableByText(array('saran'=>$nota_pend->saran_nota), array('parseLineBreaks'=>true));
//    $docx->replaceVariableByText(array('petunjuk'=>$nota_pend->petunjuk_nota), array('parseLineBreaks'=>true));
    
    
    $docx->createDocx('../web/template/pdsold_surat/nota-pendapat');
    $file = '../web/template/pdsold_surat/nota-pendapat.docx';
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
