<?php

    use app\modules\datun\models\Sp1;
    use app\modules\pdsold\models\PdmP41Terdakwa;
    use app\modules\pdsold\models\PdmMsRentut;
    use app\modules\pdsold\models\PdmPkTingRef ;
    use app\modules\pdsold\models\PdmMsBarbukEksekusi;
    use app\modules\pdsold\models\PdmMsSatuan;


    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pdsold/d3.docx');
    $satker = Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama;
    $docx->replaceVariableByText(array('kejaksaan'=>ucfirst(strtoupper($satker))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('terima_dari'=>$tersangka->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('alamat'=>$tersangka->alamat), array('parseLineBreaks'=>true));
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
    $docx->replaceVariableByText(array('no'=>$putusan->no_surat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl'=>Yii::$app->globalfunc->ViewIndonesianFormat($putusan->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('biaya_perkara'=>number_format($putusan_terdakwa->biaya_perkara,0,',','.')), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('jumlah_denda'=>number_format($putusan_terdakwa->denda,0,',','.')), array('parseLineBreaks'=>true));
    $det = json_decode($model->det_angsuran);
    $nil_angsuran = $det->nilai[$no_urut];
    $sisa = intval($putusan_terdakwa->denda) - intval($nil_angsuran);
    //echo '<pre>';print_r($sisa);exit;
    $docx->replaceVariableByText(array('angsuran_denda'=>$nil_angsuran), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('sisa_denda'=>number_format($sisa,0,',','.')), array('parseLineBreaks'=>true));

    $docx->replaceVariableByText(array('diangsur'=>$model->kali_angsur), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_angsur'=>Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_limit_angsuran)), array('parseLineBreaks'=>true));

    $exhari = explode('-', $det->tgl_angsuran[$no_urut]);
    $IntHari = date("N", mktime(0, 0, 0, $exhari[1], $exhari[0], $exhari[2]));
    switch ($IntHari) {
        case 1 :
            $Hari = "Senin";
            break;
        case 2 :
            $Hari = "Selasa";
            break;
        case 3 :
            $Hari = "Rabu";
            break;
        case 4 :
            $Hari = "Kamis";
            break;
        case 5 :
            $Hari = "Jum'at";
            break;
        case 6 :
            $Hari = "Sabtu";
            break;
        case 7 :
            $Hari = "Minggu";
            break;
    }
    //echo '<pre>';print_r( $det->tgl_angsuran[$no_urut].'----'.$Hari);exit;
    $docx->replaceVariableByText(array('hari'=>$Hari), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('dikeluarkan'=>$model->dikeluarkan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_dikeluarkan'=>$det->tgl_angsuran[$no_urut]), array('parseLineBreaks'=>true));

    $docx->replaceVariableByText(array('jabatan'=>$det->jabatan_ttd[$no_urut]), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama_ttd'=>$det->nama_ttd[$no_urut]), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat'=>$det->pangkat_ttd[$no_urut].'/NIP .'.$det->nip_ttd[$no_urut]), array('parseLineBreaks'=>true));
    $docx->createDocx('../web/template/pdsold_surat/d3');
    $file = '../web/template/pdsold_surat/d3.docx';
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
