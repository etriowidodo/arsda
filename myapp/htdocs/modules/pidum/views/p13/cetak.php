<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

    use app\modules\datun\models\Sp1;
    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx       = new CreateDocxFromTemplate('../web/template/pidum/P-13.docx');
    $satker     = Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama;
    $kodewil    = Yii::$app->globalfunc->setKepalaReport($spdp->wilayah_kerja);
    
    $docx->replaceVariableByText(array('Kejaksaan'=>$satker), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pidana'=>Yii::$app->globalfunc->JenisPidana()), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kejaksaan'=>ucfirst(strtolower($satker))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kepala'=> ucfirst(strtolower($kodewil))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('no_surat'=>$p13->no_surat_p13), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tanggal'=> Yii::$app->globalfunc->ViewIndonesianFormat( $p13->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('lampiran'=> $p13->lampiran), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kepada'=> $p13->kepada), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tempat'=> $p13->di_kepada), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('no_sp'=> $p13->no_sp), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_sp'=> Yii::$app->globalfunc->ViewIndonesianFormat( $p13->tgl_sp)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pasalSpdp'=> Yii::$app->globalfunc->getPasalH($p13->no_register_perkara)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tersangka'=> $tersangka->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('ket_saksi'=> $p13->ket_saksi), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('ket_ahli'=> $p13->ket_ahli), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('surat-surat'=> $p13->ket_surat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('barang_bukti'=> $p13->petunjuk), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('ket_tersangka'=> $p13->ket_tersangka), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('fakta_hukum'=> $p13->hukum), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pem_yuridis'=> $p13->yuridis), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kesimpulan'=> $p13->kesimpulan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('saran'=> $p13->saran), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama_penandatangan'=> $penandatangan->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat_penandatangan'=> $penandatangan->pangkat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip_penandatangan'=> $penandatangan->peg_nip_baru), array('parseLineBreaks'=>true));
    
    
    
    $docx->createDocx('../web/template/pidum_surat/P-13');
    $file = '../web/template/pidum_surat/P-13.docx';
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
