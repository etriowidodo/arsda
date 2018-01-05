<?php

    use app\modules\datun\models\Sp1;
    use app\modules\pdsold\models\VwTerdakwaT2;
    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pdsold/ba15.docx');
    $satker     = ucwords(strtolower(Yii::$app->globalfunc->getNamaSatker($session['inst_satkerkd'])->inst_nama));
    //HEADER

    $p16 = Yii::$app->globalfunc->GetLastP16a();
    //echo '<pre>';print_r($p16);exit;
    $docx->replaceVariableByText(array('kejaksaan'=>$satker), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('no_sp'=> substr($p16->no_surat_p16a,6,20)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_sp'=> Yii::$app->globalfunc->ViewIndonesianFormat($p16->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_pembuatan'=>Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_ba15)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('hari'=>Yii::$app->globalfunc->GetNamaHari($model->tgl_ba15)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pdm_penetapan'=>$model->penetapan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tanggal_penetapan'=>Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_penetapan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nomor'=> $model->no_penetapan), array('parseLineBreaks'=>true));
    $tersangka = VwTerdakwaT2::findOne(['no_register_perkara'=>$model->no_register_perkara, 'no_reg_tahanan'=>$model->no_reg_tahanan]);
    //echo '<pre>';print_r($tersangka);exit;
    $docx->replaceVariableByText(array('nama_terdakwa'=>$tersangka->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('alamat'=>$tersangka->alamat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama_memerintahkan'=>$model->memerintahkan), array('parseLineBreaks'=>true));
    $cara = (new \yii\db\Query())
                                ->select('*')
                                ->from('pidum.pdm_ms_isi_penetapan')
                                ->where(['id' => $model->id_isipenetapan])
                                ->one();
    $docx->replaceVariableByText(array('dgn_cara'=>$cara[nama]), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama_penandatangan'=>$model->nama_jaksa), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat_penandatangan'=>$model->pangkat_jaksa), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('jabatan_penandatangan'=>$model->jabatan_jaksa), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip_penandatangan'=>$model->nip_jaksa), array('parseLineBreaks'=>true));

    $docx->createDocx('../web/template/pdsold_surat/ba15');
    $file = '../web/template/pdsold_surat/ba15.docx';
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
