<?php
    use app\models\MsSifatSurat;
    use app\models\MsWarganegara;
    use app\models\MsPendidikan;
    use app\models\MsAgama;
    use app\models\MsJkl;
    use app\modules\pidum\models\PdmPkTingRef;
    use app\modules\datun\models\Sp1;
    use app\modules\pidum\models\PdmMsStatusData;

    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pidum/p37.docx');

    $connection = \Yii::$app->db;

    

    $satker     = ucwords(strtolower(Yii::$app->globalfunc->getNamaSatker($session['inst_satkerkd'])->inst_nama));
    //HEADER
    $docx->replaceVariableByText(array('Kejaksaan'=>$satker), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nomor'=>$model->no_surat_p37), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('sebagai'=>strtoupper(PdmMsStatusData::findOne(['id'=>$model->id_msstatusdata, 'is_group'=>'P-37'])->nama)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('sebagai_lower'=>Yii::$app->globalfunc->GetHlistTerdakwaT2($model->no_register_perkara)), array('parseLineBreaks'=>true));


    //ISI
    $docx->replaceVariableByText(array('nama_lengkap'=>$model->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tmpt_lahir'=>$model->tmpt_lahir), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_lahir'=>Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_lahir)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('umur'=>$model->umur), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('jns_kelamin'=>MsJkl::findOne($model->id_jkl)->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('warganegara'=>MsWarganegara::findOne($model->warganegara)->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('alamat'=>$model->alamat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('agama'=>MsPendidikan::findOne($model->id_agama)->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pekerjaan'=>$model->pekerjaan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pendidikan'=>MsPendidikan::findOne($model->id_pendidikan)->nama), array('parseLineBreaks'=>true));
    
    //END TERSANGKA

    $docx->replaceVariableByText(array('nama_jaksa'=>$model->nama_hadap), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat_jaksa'=>$model->pangkat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('jabatan_jaksa'=>$model->jabatan), array('parseLineBreaks'=>true));
    //$docx->replaceVariableByText(array(''=>$), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('alamat_jaksa'=>$model->alamat_hadap), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('hari'=>Yii::$app->globalfunc->GetNamaHari($model->tgl_hadap)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tanggal'=>Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_hadap)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('jam'=>$model->jam), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('untuk_keperluan'=>$model->keperluan), array('parseLineBreaks'=>true));
    //echo '<pre>';print_r($ttd);exit;
    
    $docx->replaceVariableByText(array('dikeluarkan'=>$model->dikeluarkan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kepala'=>$model->jabatan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_dikeluarkan'=>Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_dikeluarkan)), array('parseLineBreaks'=>true));

    $docx->replaceVariableByText(array('jabatan_ttd'=>$model->jabatan_ttd), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat_ttd'=>$model->pangkat_ttd), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama_ttd'=>$model->nama_ttd), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip_ttd'=>$model->nip), array('parseLineBreaks'=>true));
    
    $docx->createDocx('../web/template/pidum_surat/p37');
    $file = '../web/template/pidum_surat/p37.docx';
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

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
