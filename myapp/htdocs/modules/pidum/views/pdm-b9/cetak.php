<?php

    use app\modules\datun\models\Sp1;
    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $connection = \Yii::$app->db;
    //getListTerdakwaBa4
    $docx   = new CreateDocxFromTemplate('../web/template/pidum/b9.docx');
    $satker     = ucwords(strtolower(Yii::$app->globalfunc->getNamaSatker($session['inst_satkerkd'])->inst_nama));
    $besar = strtoupper($satker);
    $docx->replaceVariableByText(array('Kejaksaan'=>$satker), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('Kejaksaan_B'=>$besar), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('reg_bukti'=>$ba5->no_reg_bukti), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tanggal'=>Yii::$app->globalfunc->ViewIndonesianFormat($ba5->tgl_ba5)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama_tersangka'=>Yii::$app->globalfunc->getListTerdakwaBa4($model->no_register_perkara)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('berita_tgl'=>Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_b9)), array('parseLineBreaks'=>true));  
	$docx->replaceVariableByText(array('tgl_ba18'=>Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_b9)), array('parseLineBreaks'=>true));
	$docx->replaceVariableByText(array('barbuk'=>$barbuk), array('parseLineBreaks'=>true));
	$sql ="select * from kepegawaian.kp_pegawai where peg_nip_baru='".$model->nip_jaksa."'";
    $modelx = $connection->createCommand($sql);
    $jaksa = $modelx->queryOne();

    $docx->replaceVariableByText(array('nama_jaksa'=>$jaksa['nama']), array('parseLineBreaks'=>true));

    $sql ="select * from kepegawaian.kp_pegawai where peg_nip_baru='".$model->nip_petugas."'";
    $modelx= $connection->createCommand($sql);
    $petugas = $modelx->queryOne();

    $docx->replaceVariableByText(array('petugas_penyitaan'=>$petugas['nama']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('reg_perkara'=>$model->no_register_perkara), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama_tersangka'=>Yii::$app->globalfunc->getListTerdakwaBa4($model->no_register_perkara)), array('parseLineBreaks'=>true));
    $docx->createDocx('../web/template/pidum_surat/b9');
    $file = '../web/template/pidum_surat/b9.docx';
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
