<?php

    use app\modules\datun\models\Sp1;
    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pidum/P-33-draf.docx');
    $satker = Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama;
    
    //echo '<pre>';print_r($p33);exit;

    $docx->replaceVariableByText(array('kejaksaan'=>ucfirst(strtoupper($satker))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('hasil'=>$ket), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('hari'=>Yii::$app->globalfunc->GetNamaHari($p33->tgl_p33)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tanggal_lengkap'=>Yii::$app->globalfunc->ViewIndonesianFormat($p33->tgl_p33)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('jam'=>$p33->jam), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama'=>$p33->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('alamat'=>$p33->alamat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pekerjaan'=>$p33->pekerjaan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama_menyerahkan'=>$p33->nama_pegawai), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat'=>$p33->pangkat_pegawai), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip'=>$p33->nip_pegawai), array('parseLineBreaks'=>true));

    if ($ket == "BIASA"){
        $no_p31_32  = $p31->no_surat_p31.' tanggal '.Yii::$app->globalfunc->ViewIndonesianFormat($p31->tgl_dikeluarkan);
    }else if ($ket == "SINGKAT"){
        $no_p31_32  = $p32->no_surat_p32.' tanggal '.Yii::$app->globalfunc->ViewIndonesianFormat($p32->tgl_dikeluarkan);
    }
    
    if ($ket == "BIASA"){
        $no_p29_30  = $p30->no_register_perkara.' tanggal '.Yii::$app->globalfunc->ViewIndonesianFormat($p30->dikeluarkan);
    }else if ($ket == "SINGKAT"){
        $no_p29_30  = $p29->no_register_perkara.' tanggal '.Yii::$app->globalfunc->ViewIndonesianFormat($p29->tgl_dikeluarkan);
    }
    
    $berkas_perkara     = $brks_thp_1->no_berkas.' tanggal '.Yii::$app->globalfunc->ViewIndonesianFormat($brks_thp_1->tgl_berkas);
    $docx->replaceVariableByText(array('surat_pelimpahan'=>$no_p31_32), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('surat_dakwaan'=>$no_p29_30), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('berkas_perkara'=>$berkas_perkara), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('terdakwa'=>Yii::$app->globalfunc->getListTerdakwaBa4($p33->no_register_perkara)), array('parseLineBreaks'=>true));
    
    $docx->createDocx('../web/template/pidum_surat/P-33-draf');
    $file = '../web/template/pidum_surat/P-33-draf.docx';
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
