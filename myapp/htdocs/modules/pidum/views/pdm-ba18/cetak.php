<?php

    use app\modules\datun\models\Sp1;
    use app\modules\pidum\models\PdmPkTingRef;
    use app\modules\pidum\models\PdmP41Terdakwa;
    use app\modules\pidum\models\PdmMsRentut;
    use app\modules\pidum\models\PdmMsBarbukEksekusi;


    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pidum/ba18.docx');
    $satker = Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama;
    $docx->replaceVariableByText(array('Kejaksaan'=>ucfirst(strtoupper($satker))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('hari'=>Yii::$app->globalfunc->GetNamahari($model->tgl_pembuatan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_pembuatan'=>Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_pembuatan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('no_putus'=>$p48->no_putusan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_putus'=>Yii::$app->globalfunc->ViewIndonesianFormat($p48->tgl_putusan)), array('parseLineBreaks'=>true));

    $docx->replaceVariableByText(array('nama_jaksa'=>$model->nama_ttd), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat_jaksa'=>$model->pangkat_ttd), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('jabatan_jaksa'=>$model->jabatan_ttd), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip_jaksa'=>$model->id_penandatangan), array('parseLineBreaks'=>true));

    $saksi = json_decode($model->saksi);
    //echo '<pre>';print_r($saksi);exit;
    $listJaksa='<table border="0"  >';
    
    for ($i=0; $i < count($saksi->no_urut); $i++) { 
        $listJaksa .='<tr><td width="2%">'.$saksi->no_urut[$i].'. </td>
                            <td width="5%"> Nama</td>
                            <td width="2%"> :</td>
                            <td width="25%">'.$saksi->nama[$i].'</td>
                        </tr>
                        <tr><td></td>
                            <td width="5%"> Pangkat</td>
                            <td width="2%"> :</td>
                            <td width="25%">'.$saksi->pangkat[$i].'</td>
                        </tr>
                        <tr><td></td>
                            <td width="5%"> NIP</td>
                            <td width="2%"> :</td>
                            <td width="25%">'.$saksi->nip[$i].'</td>
                        </tr>
                        <tr><td></td>
                            <td width="5%"> Jabatan</td>
                            <td width="2%"> :</td>
                            <td width="25%">'.$saksi->jabatan[$i].'</td>
                        </tr>';
    }
    $listJaksa .='</table>'; 
    $docx->replaceVariableByHTML('saksi', 'block', $listJaksa, $arrDocnya);


    $ttd_saksi='<table border="0"  >';
    for ($i=0; $i < count($saksi->no_urut); $i++) { 
        $ttd_saksi .='<tr><td width="2%">'.$saksi->no_urut[$i].'. </td>
                            <td width="25%">'.$saksi->nama[$i].'</td>
                    </tr>';
            for ($x=0; $x < 10; $x++) { 
                $ttd_saksi .='<tr><td width="2%"></td>
                                <td width="25%"></td>
                                </tr>';
            }
    }
    $ttd_saksi .='</table>'; 
    //echo '<pre>';print_r($ttd_saksi);exit;
    $docx->replaceVariableByHTML('ttd_sak', 'block', $ttd_saksi, $arrDocnya);

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

    
    $docx->replaceVariableByText(array('namaTersangka'=>$tersangka->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tmpt_lahir'=>$tersangka->tmpt_lahir), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_lahir'=>Yii::$app->globalfunc->ViewIndonesianFormat($tersangka->tgl_lahir)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('jenis_kelamin'=>$tersangka->is_jkl), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('warganegara'=>$tersangka->warganegara1), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tmpt_tinggal'=>$tersangka->alamat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('agama'=>$tersangka->is_agama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pekerjaan'=>$tersangka->pekerjaan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pendidikan'=>$tersangka->is_pendidikan), array('parseLineBreaks'=>true));

    $docx->replaceVariableByText(array('pengadilan'=>$pengadilan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_sp'=>$tgl_sp), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('no_sp'=>$no_sp), array('parseLineBreaks'=>true));

    $docx->replaceVariableByText(array('tgl_menteri'=>Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_menteri)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('no_menteri'=>$model->no_menteri), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('lokasi'=>$model->lokasi), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_putusan'=>Yii::$app->globalfunc->ViewIndonesianFormat($p48->tgl_putusan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('no_putusan'=>$p48->no_putusan), array('parseLineBreaks'=>true));

    $docx->replaceVariableByText(array('tgl_visum'=>Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_visum)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('no_visum'=>$model->no_visum), array('parseLineBreaks'=>true));

    $docx->createDocx('../web/template/pidum_surat/ba18');
    $file = '../web/template/pidum_surat/ba18.docx';
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
