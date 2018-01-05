<?php

    use app\modules\datun\models\Sp1;
    use app\modules\pidum\models\PdmUuPasalTahap2;
    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pidum/d2.docx');
    //echo '<pre>';print_r($putusan);exit;
    $docx->replaceVariableByText(array('nama'=>$tersangka->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_lahir'=>Yii::$app->globalfunc->ViewIndonesianFormat($tersangka->tgl_lahir)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('alamat'=>$tersangka->alamat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pekerjaan'=>$tersangka->pekerjaan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('sebesar'=>number_format($model->nilai,0,',','.')), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('terbilang'=> Yii::$app->globalfunc->terbilang($model->nilai)), array('parseLineBreaks'=>true));
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
    $docx->replaceVariableByText(array('deadline'=>Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_setor)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('hari'=>Yii::$app->globalfunc->GetNamaHari($model->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_dikeluarkan'=>Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('jaksa'=>$model->nama_ttd), array('parseLineBreaks'=>true));

    /*switch ($model->id_msstatusdata) {
        case 1:
            $status = 'Uang Denda';
            break;
        case 2:
            $status = 'Uang Pengganti';
            break;
        default:
            $status = 'Biaya Perkara';
            break;
    }*/

    
    
    $docx->createDocx('../web/template/pidum_surat/d2');
    $file = '../web/template/pidum_surat/d2.docx';
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

