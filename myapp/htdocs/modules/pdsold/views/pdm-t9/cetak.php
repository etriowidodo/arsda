<?php
    use app\modules\datun\models\Sp1;
    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pdsold/t9.docx');
    $satker = Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama;
    $connection = \Yii::$app->db;

    $docx->replaceVariableByText(array('Kejaksaan'=>$satker), array('parseLineBreaks'=>true));

    $tabel ='';
    $tabel .="<table  style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
    <thead>
        <tr>
            <td bgcolor=\"#CCCCCC\" rowspan=\"2\" align=\"center\" width=\"3%\" style=\"font-size:12px\">No Urut</td>
            <td bgcolor=\"#CCCCCC\" rowspan=\"2\" align=\"center\" width=\"22%\" style=\"font-size:12px\">Nama / Identitas Tersangka</td>
            <td bgcolor=\"#CCCCCC\" rowspan=\"2\" align=\"center\" width=\"22%\" style=\"font-size:12px\">No Register Tahanan</td>
            <td bgcolor=\"#CCCCCC\" colspan=\"2\" align=\"center\" width=\"30%\" style=\"font-size:12px\">Pemindahan</td>
            <td bgcolor=\"#CCCCCC\" rowspan=\"2\" align=\"center\" width=\"3%\" style=\"font-size:12px\">ket</td>          
        </tr> 
        <tr>
            <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"15%\" style=\"font-size:12px\">Tempat Baru</td>
            <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"15%\" style=\"font-size:12px\">Tempat Lama</td>         
        </tr>           
    </thead>
    <tfoot>
        </tfoot>            
        ";

        if (count($DetailT9) != 0){
            //echo '<pre>';print_r($DetailT9);exit;
        foreach ($DetailT9 as $detail) {
            $tabel .="<tr>
                <td valign=\"top\" align=\"center\" style=\"font-size:12px;border-bottom:none;border-top:none\">$detail->id_tersangka</td>
                <td valign=\"top\" align=\"center\" style=\"font-size:12px;border-bottom:none;border-top:none\">$detail->nama</td>
                <td valign=\"top\" align=\"center\" style=\"font-size:12px;border-bottom:none;border-top:none\">$detail->no_reg_tahanan_jaksa</td>
                <td valign=\"top\" align=\"center\" style=\"font-size:12px;border-bottom:none;border-top:none\">$detail->lokasi_tahanan</td> 
                <td valign=\"top\" align=\"center\" style=\"font-size:12px;border-bottom:none;border-top:none\">$detail->lokasi_pindah</td>
                <td valign=\"top\" align=\"center\" style=\"font-size:12px;border-bottom:none;border-top:none\"></td>  
                        </tr>";   
        }
    }
    $tabel .="</table>";

    //$docx->replaceVariableByText(array('tabel'=>$tabel), array('parseLineBreaks'=>true));
    $docx->replaceVariableByHTML('tabel', 'block', $tabel, $arrDocnya);

    $docx->replaceVariableByText(array('nomor'=>$model->no_surat_t9), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('sifat'=>$sifat->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('lampiran'=>$model->lampiran), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('dikeluarkan'=>$model->dikeluarkan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tanggal_dikeluarkan'=>Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kepada'=>$model->kepada), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('di_tempat'=>$model->di_kepada), array('parseLineBreaks'=>true));

    $sql ="select * from kepegawaian.kp_pegawai where peg_nip_baru='".$model->id_penandatangan."'";
    $lel = $connection->createCommand($sql);
    $ttd = $lel->queryOne();

    $docx->replaceVariableByText(array('kepala'=>$ttd['jabatan']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama_penandatangan'=>$ttd['nama']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat'=>$ttd['gol_pangkatjaksa']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip_penandatangan'=>$model->id_penandatangan), array('parseLineBreaks'=>true));

    $tembusanc ='';
    if (count($tembusan) != 0) {
        $tembusanc = '<table border="0" ><tbody>';
        foreach ($tembusan as $rowlistTembusan) {
           $tembusanc .= '<tr><td width="2%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px"> '.$rowlistTembusan[no_urut].'.</td>
                             <td width="40%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 0px">'.$rowlistTembusan[tembusan].'</td>
                             </tr>';
        }
        $tembusanc .= "</tbody></table>";
    }
    $docx->replaceVariableByHTML('tembusan', 'block', $tembusanc, $arrDocnya);
    //$docx->replaceVariableByText(array('tembusan'=>$tembusanc), array('parseLineBreaks'=>true));


    //echo $tabel;
    $docx->createDocx('../web/template/pdsold_surat/t9');
    $file = '../web/template/pdsold_surat/t9.docx';
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
