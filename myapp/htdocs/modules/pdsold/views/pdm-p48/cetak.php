<?php

    use app\modules\datun\models\Sp1;
    use app\modules\pdsold\models\PdmPkTingRef;
    use app\modules\pdsold\models\PdmP41Terdakwa;
    use app\modules\pdsold\models\PdmMsRentut;
    use app\modules\pdsold\models\PdmMsBarbukEksekusi;


    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pdsold/p48.docx');
    $satker = Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama;
    $docx->replaceVariableByText(array('Kejaksaan'=>ucfirst(strtoupper($satker))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('no_print'=>$model->no_surat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('no_putus'=>$model->no_putusan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_putus'=>Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_putusan)), array('parseLineBreaks'=>true));
    
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

    $dasar = '<ol type="1">';
    $dasar .='<li>Putusan '.$pengadilan.' No. '.$model->no_putusan.' Tanggal '. Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_putusan).'.</li>';    
        if($putusan->id_ms_rentut==1){
            $dasar .='<li>UU No.5 Tahun 2010 tentang perubahan atas UU Nomor 22 Tahun 2002 tentang Grasi / Pasal 3 dan 14 UU No 2/PNPS/1964 tentang pelaksanaan pidana mati.</li>';
        }
    $dasar .='<li>Pasal 46 (2), 191, 192, 193, 194, 1 butir 6a jo 197 jo 270, 273 KUHAP.</li>';
    $dasar .='<li>Pasal 30 ayat(1) Huruf b UU No. 16 Tahun 2004 tentang Kejaksaan Republik Indonesia.</li>';    
    $dasar .='</ol>';

    //echo '<pre>';print_r($dasar);exit;
    $docx->replaceVariableByHTML('berd', 'block', $dasar, $arrDocnya);
    //$docx->replaceVariableByText(array('berd'=>$dasar), array('parseLineBreaks'=>true));


    $terpidana = '1. '.$tersangka->nama. ' Melanggar Pasal '. $listPasal;

    //echo '<pre>';print_r($terpidana);exit;
    $docx->replaceVariableByHTML('terpidana', 'block', $terpidana, $arrDocnya);

    $docx->replaceVariableByText(array('dikeluarkan'=>$model->dikeluarkan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pd_tgl'=>Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('jabatan'=>ucwords($model->jabatan_ttd)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat'=>ucwords($model->pangkat_ttd)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama_penandatangan'=>ucwords($model->nama_ttd)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip_penandatangan'=>$model->id_penandatangan), array('parseLineBreaks'=>true));

    $listJaksa='<table border="0"  >';
    foreach ($jaksa as $key => $value) {
        $no = $key+1;
            $listJaksa .='<tr><td width="2%">'.$no.'. </td>
                            <td width="5%"> Nama</td>
                            <td width="2%"> :</td>
                            <td width="25%">'.$value->nama.'</td>
                        </tr>
                        <tr><td></td>
                            <td width="5%"> Pangkat</td>
                            <td width="2%"> :</td>
                            <td width="25%">'.$value->pangkat.'</td>
                        </tr>
                        <tr><td></td>
                            <td width="5%"> Jabatan</td>
                            <td width="2%"> :</td>
                            <td width="25%">'.$value->jabatan.'</td>
                        </tr>';
    }
    $listJaksa .='</table>';
    //echo '<pre>';print_r($listJaksa);exit;
    $docx->replaceVariableByHTML('jaksa', 'block', $listJaksa, $arrDocnya);



    $tembusan ='';
    if (count($listTembusan) != 0) {
        $tembusan = '<table border="0" ><tbody>';
        foreach ($listTembusan as $rowlistTembusan) {
           $tembusan .= '<tr><td width="2%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px"> '.$rowlistTembusan[no_urut].'.</td>
                             <td width="40%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 0px">'.$rowlistTembusan[tembusan].'</td>
                             </tr>';
        }
        $tembusan .= "</tbody></table>";
    }
    //echo $tabel;
    $docx->replaceVariableByHTML('tembusan', 'block', $tembusan, $arrDocnya);

    $docx->createDocx('../web/template/pdsold_surat/p48');
    $file = '../web/template/pdsold_surat/p48.docx';
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
