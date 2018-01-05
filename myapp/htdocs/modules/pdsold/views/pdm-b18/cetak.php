<?php

    use app\modules\datun\models\Sp1;
    use app\modules\pdsold\models\PdmP41Terdakwa;
    use app\modules\pdsold\models\PdmMsRentut;
    use app\modules\pdsold\models\PdmPkTingRef ;
    use app\modules\pdsold\models\PdmMsBarbukEksekusi;
    use app\modules\pdsold\models\PdmMsSatuan;


    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pdsold/b18.docx');
    $satker = Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama;
    $docx->replaceVariableByText(array('kejaksaan'=>ucfirst(strtoupper($satker))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nomor'=>$model->no_surat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('dikeluarkan'=>$model->dikeluarkan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_dikeluarkan'=>Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    //$docx->replaceVariableByHTML('ttd_sak', 'block', $ttd_saksi, $arrDocnya);

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
    $docx->replaceVariableByText(array('tglputus'=>Yii::$app->globalfunc->ViewIndonesianFormat($p48->tgl_putusan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('noputus'=>$p48->no_putusan), array('parseLineBreaks'=>true));
    $pidana = PdmPkTingRef::findOne($spdp->id_pk_ting_ref)->nama;
    $docx->replaceVariableByText(array('pidana'=>$pidana), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('terdakwa'=>$tersangka->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('noregbarbuk'=>$ba5->no_reg_bukti), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('barbuk'=>Yii::$app->globalfunc->getDaftarBarbukEksekusi($p48->no_register_perkara)), array('parseLineBreaks'=>true));

    $pelaksana = json_decode($model->pelaksana);
    $docx->replaceVariableByText(array('kasipidum'=>$pelaksana->kasipidum->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkatkasipidum'=>$pelaksana->kasipidum->pangkat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nipkasipidum'=>$pelaksana->kasipidum->nip), array('parseLineBreaks'=>true));

    $docx->replaceVariableByText(array('kasubag'=>$pelaksana->kasubag->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkatkasubag'=>$pelaksana->kasubag->pangkat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nipkasubag'=>$pelaksana->kasubag->nip), array('parseLineBreaks'=>true));

    $docx->replaceVariableByText(array('jabatan_ttd'=>$model->jabatan_ttd), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama_ttd'=>$model->nama_ttd), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat_ttd'=>$model->pangkat_ttd), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip_ttd'=>$model->id_penandatangan), array('parseLineBreaks'=>true));

    $docx->createDocx('../web/template/pdsold_surat/b18');
    $file = '../web/template/pdsold_surat/b18.docx';
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
