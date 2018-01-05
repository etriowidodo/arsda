<?php

    use app\modules\datun\models\Sp1;
    use app\modules\pidum\models\PdmPkTingRef;
    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pidum/bakonsultasi.docx');
    $satker = Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama;
    
    
    
    $docx->replaceVariableByText(array('KEJAKSAAN'=>strtoupper($satker)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kejaksaan'=>ucwords($satker)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tglba'=>Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_pelaksanaan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('hari'=>Yii::$app->globalfunc->GetNamaHari($model->tgl_pelaksanaan)), array('parseLineBreaks'=>true));

    if (strtoupper($satker) == 'KEJAKSAAN AGUNG REPUBLIK INDONESIA'){
        $docx->replaceVariableByText(array('kepala_kejaksaan'=> "JAKSA AGUNG MUDA TINDAK PIDANA UMUM"), array('parseLineBreaks'=>true));
    } else {
        $docx->replaceVariableByText(array('kepala_kejaksaan'=> "KEPALA ".ucwords($satker)), array('parseLineBreaks'=>true));
    }
    
    $docx->replaceVariableByText(array('nama_jaksa'=>$model->nama_jaksa), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat_jaksa'=>$model->pangkat_jaksa), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip_jaksa'=>$model->nip_jaksa), array('parseLineBreaks'=>true));

    $docx->replaceVariableByText(array('no_surat_p16'=>$jaksa_p16[no_surat]), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_p16'=>Yii::$app->globalfunc->ViewIndonesianFormat($jaksa_p16[tgl_dikeluarkan])), array('parseLineBreaks'=>true));

    $docx->replaceVariableByText(array('nama_sidik'=>$model->nama_penyidik), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip_sidik'=>$model->nip_penyidik), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('jabatan_sidik'=>$model->jabatan_penyidik), array('parseLineBreaks'=>true));

    $docx->replaceVariableByText(array('pidana'=>PdmPkTingRef::findOne($spdp->id_pk_ting_ref)->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pasal'=>$spdp->undang_pasal), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tersangka'=>Yii::$app->globalfunc->GetHlistTerdakwaSpdp($model->id_perkara)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('formil'=>$model->konsultasi_formil), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('materil'=>$model->konsultasi_materil), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kesimpulan'=>$model->kesimpulan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat_end'=>$model->pangkat_jaksa.' /NIP. '.$model->nip_jaksa), array('parseLineBreaks'=>true));

    $docx->createDocx('../web/template/pidum_surat/bakonsultasi');
    $file = '../web/template/pidum_surat/bakonsultasi.docx';
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
