<?php

    use app\modules\datun\models\Sp1;
    use app\modules\pidum\models\PdmP41Terdakwa;
    use app\modules\pidum\models\PdmMsRentut;
    use app\modules\pidum\models\PdmPkTingRef ;
    use app\modules\pidum\models\PdmMsBarbukEksekusi;
    use app\modules\pidum\models\PdmMsSatuan;


    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pidum/d4.docx');
    $satker = Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama;
    $docx->replaceVariableByText(array('Kejaksaan'=>strtoupper($satker)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kejaksaan'=>ucwords($satker)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nomor_print'=>$model->no_surat), array('parseLineBreaks'=>true));
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
    $docx->replaceVariableByText(array('noputus'=>$putusan->no_surat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tglputus'=>Yii::$app->globalfunc->ViewIndonesianFormat($putusan->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pidana'=>PdmPkTingRef::findOne($modelSpdp->id_pk_ting_ref)->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tersangka'=>$tersangka->nama), array('parseLineBreaks'=>true));

    if($model->id_msstatusdata==1){
        $status = 'Uang Denda';
    }else{
        $status = 'Biaya Perkara';
    }

    $docx->replaceVariableByText(array('status'=>$status), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('sebesar'=>'Rp. '.number_format($model->nilai,0,',','.')), array('parseLineBreaks'=>true));

    $docx->replaceVariableByText(array('nama_jaksa'=>$model->nama_jaksa), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat_jaksa'=>$model->pangkat_jaksa), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip_jaksa'=>$model->nip_jaksa), array('parseLineBreaks'=>true));

    $docx->replaceVariableByText(array('dikeluarkan'=>$model->dikeluarkan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pada_tanggal'=>Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_dikeluarkan)), array('parseLineBreaks'=>true));

    $docx->replaceVariableByText(array('jabatan_ttd'=>$model->jabatan_ttd), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama_ttd'=>$model->nama_ttd), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat'=>$model->pangkat_ttd.'/NIP .'.$model->id_penandatangan), array('parseLineBreaks'=>true));


    $docx->createDocx('../web/template/pidum_surat/d4');
    $file = '../web/template/pidum_surat/d4.docx';
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
