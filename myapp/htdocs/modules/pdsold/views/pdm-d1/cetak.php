<?php

    use app\modules\datun\models\Sp1;
use app\modules\pdsold\models\PdmUuPasalTahap2;
    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pdsold/d1.docx');
    $satker = Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama;
    $docx->replaceVariableByText(array('kejaksaan'=>ucfirst(strtoupper($satker))), array('parseLineBreaks'=>true));
    
    $docx->replaceVariableByText(array('nomor'=>$model->no_surat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('sifat'=>$sifat->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('lampiran'=>$model->lampiran), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kepada'=>$model->kepada), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('di'=>$model->di_kepada), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('dikeluarkan'=>$model->dikeluarkan), array('parseLineBreaks'=>true));
    switch ($model->id_msstatusdata) {
        case 1:
            $status = 'Uang Denda';
            break;
        case 2:
            $status = 'Uang Pengganti';
            break;
        default:
            $status = 'Biaya Perkara';
            break;
    }
    $docx->replaceVariableByText(array('status'=>$status), array('parseLineBreaks'=>true));
    
    $docx->replaceVariableByText(array('nama_tsk'=>$tersangka->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('alamat_tsk'=>$tersangka->alamat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pekerjaan_tsk'=>$tersangka->pekerjaan), array('parseLineBreaks'=>true));

    $docx->replaceVariableByText(array('hari_hdp'=>Yii::$app->globalfunc->GetNamaHari($model->tgl_panggil)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tanggal_hdp'=>Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_panggil)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('jam_hdp'=>substr($model->jam_panggil,0,5)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('menghadap_hdp'=>$model->menghadap), array('parseLineBreaks'=>true));

    switch ($putusan->status_yakum){
        case 1:
            $pengadilan = 'Pengadilan Tinggi';
            break;
        case 2:
            $pengadilan = 'Mahkamah Agung RI';
            break;
        default:
            $pengadilan = 'Pengadilan Negeri';
            break;
    }
    $docx->replaceVariableByText(array('pengadilan'=>$pengadilan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nomorput'=>$p48->no_putusan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tanggalput'=>Yii::$app->globalfunc->ViewIndonesianFormat($p48->tgl_putusan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama_ttd'=>$model->nama_ttd), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('hari_relasi'=>Yii::$app->globalfunc->GetNamaHari($model->tgl_relas)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tanggal_relasi'=>Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_relas)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('jam_relasi'=>substr($model->jam_relas,0,5)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama_relas'=>$model->nama_relas), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat_relas'=>$model->pangkat_relas), array('parseLineBreaks'=>true));

    //$docx->replaceVariableByText(array('pengadilan'=>$), array('parseLineBreaks'=>true));
    //$docx->replaceVariableByHTML('pasal_dibuktikan', 'block', $dibuktikan, $arrDocnya);
    
    
    $docx->createDocx('../web/template/pdsold_surat/d1');
    $file = '../web/template/pdsold_surat/d1.docx';
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

