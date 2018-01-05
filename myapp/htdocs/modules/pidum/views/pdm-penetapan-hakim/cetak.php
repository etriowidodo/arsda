<?php

    use app\modules\datun\models\Sp1;
    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pidum/P-38.docx');
    $satker = Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama;
    $docx->replaceVariableByText(array('Kejaksaan'=>ucfirst(strtoupper($satker))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('sifat'=> $sifat->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nomor'=> $p38->no_surat_p38), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('lampiran'=> $p38->lampiran), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('dikeluarkan'=> $p38->dikeluarkan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_dikeluarkan'=> Yii::$app->globalfunc->ViewIndonesianFormat($p38->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kepada'=> $p38->kepada), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('ditempat'=> $p38->di_kepada), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('panggil'=> $panggil->keterangan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('keperluan'=> $keperluan->keterangan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama_lengkap'=>Yii::$app->globalfunc->getListTerdakwaBa4($p38->no_register_perkara)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama_jaksa'=>$pangkat->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat'=>$pangkat->pangkat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kejaksaan'=>$pangkat->jabatan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip'=>$pangkat->peg_nip_baru), array('parseLineBreaks'=>true));
    
    if ($p38->id_msstatusdata == 1){
        $stsket = 'Keterangan';
    }else if ($p38->id_msstatusdata == 2){
        $stsket = 'Keterangan';
    }else if ($p38->id_msstatusdata == 3){
        $stsket = 'Psl.';
    }else if ($p38->id_msstatusdata == 4){
        $stsket = 'Psl.';
    }
    else{}
    
    if ($p38->id_msstatusdata == 1){
        if (count($p37) > 1){
            foreach ($p37 as $rowlistp37) {
                $ket .= $rowlistp37["keperluan"].', ';
            }
        }else{
            foreach ($p37 as $rowlistp37) {
                $ket .= $rowlistp37["keperluan"].'';
            }
        }
    }else if ($p38->id_msstatusdata == 2){
        if (count($p37) > 1){
            foreach ($p37 as $rowlistp37) {
                $ket .= $rowlistp37["keperluan"].', ';
            }
        }else{
            foreach ($p37 as $rowlistp37) {
                $ket .= $rowlistp37["keperluan"].'';
            }
        }
    }else if ($p38->id_msstatusdata == 3){
        foreach ($pasal as $rowpasal) {
            $ket .= $rowpasal['undang'].' '.$rowpasal['pasal'].' ';
        }
        
    }else if ($p38->id_msstatusdata == 4){
        foreach ($pasal as $rowpasal) {
            $ket .= $rowpasal['undang'].' '.$rowpasal['pasal'].' ';
        }
    }
    else{}
    
    $tsk ='';
    $i=1;
    if (count($p37) != 0) {
        $tsk = '<table border="0.4" style="border-collapse:collapse;"><thead>';
        $tsk .= '<tr><th width="5%" style="font-family:Times New Roman; font-size:12pt;>No</th> <th width="35%" style="font-family:Times New Roman; font-size:12pt;>Nama Lengkap '.$panggil->keterangan.'<br/>yang dipanggil</th> <th width="40%" style="font-family:Times New Roman; font-size:12pt;>Alamat</th> <th width="20%" style="font-family:Times New Roman; font-size:12pt;>'.$stsket.' yang dilanggar</th></tr>';
        $tsk .= '</thead>';
        $tsk .= '<tbody>';
        foreach ($p37 as $rowlistp37) {
            $tsk .= '<tr><td>'.$i.'.</td>
                        <td>'.$rowlistp37["nama"].'</td>
                        <td>'.$rowlistp37["alamat"].'</td>
                            
                        <td>'.$ket.'</td></tr>';
            $i++;
        }
        $tsk .= "</tbody></table>";
    }
    $docx->replaceVariableByHTML('tabel', 'block', $tsk, $arrDocnya);
    
    $docx->createDocx('../web/template/pidum_surat/P-38');
    $file = '../web/template/pidum_surat/P-38.docx';
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
