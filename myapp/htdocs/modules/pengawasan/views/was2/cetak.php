<?php
require_once('/wordtest/classes/CreateDocx.inc');

        $docx = new CreateDocxFromTemplate('../modules/pengawasan/template/was-2.docx');
        $kejaksaan=strtoupper($data_satker['inst_nama']);
       
        $kepada         =($model['kepada']!=''?$model['kepada']:'<p></p>');
        $dari           =($model['dari']!=''?$model['dari']:'<p></p>');
        $no_register    =($model['no_register']!=''?$model['no_register']:'<p></p>');
        $lampiran       =($model['was2_lampiran']!=''?$model['was2_lampiran']:'<p></p>');
        $was2_tanggal   =($model['was2_tanggal']!=''?$tgl:'<p></p>');
        $was2_no_surat  =($model['was2_no_surat']!=''?$model['was2_no_surat']:'<p></p>');
        $perihal_lapdu  =($model['perihal_lapdu']!=''?$model['perihal_lapdu']:'<p></p>');
        $ringkasan_lapdu=($model['ringkasan_lapdu']!=''?$model['ringkasan_lapdu']:'<p></p>');
        $jabatan_alias  =($model['jbtn_penandatangan']!=''?$model['jbtn_penandatangan']:'<p></p>');
        $jabatan        =($model['jabatan_penandatangan']!=''?$model['jabatan_penandatangan']:'<p></p>');
        $nama           =($model['nama_penandatangan']!=''?$model['nama_penandatangan']:'<p></p>');
        $nip            =($model['peg_nip']!=''?$model['peg_nip']:'<p></p>');
        $pelapor        =($model3['nama']!=''?$model3['nama']:'<p></p>');
        $tembusan       =($model2['tembusan']!=''?$model2['tembusan']:'<p></p>');

        $no             =1;
        $tmb            =explode(',',$model2['tembusan']);
        $x              =' ';

        for ($i=0; $i <count($tmb) ; $i++) { 
            $x  .= $no.".".$tmb[$i]."<br>";
            $no++;
        }
        
        /*$tmb            ='';
        foreach ($model2 as $tembusan) {
            $tmb .=$no.".".$tembusan['tembusan']."<br>";
            $no++;

        }*/
        
           
        $docx->setDefaultFont('Arial');
        $docx->replaceVariableByHTML('kejaksaan', 'inline','<h2 style="text-align: center;"><b><p>'.$kejaksaan.'</p></b></h2>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('kepada1', 'inline','<p>'.$kepada.'</p></h2>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('dari', 'inline','<p>'.$dari.'</p></h2>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByText(array('berkas'=>$lampiran), array('parseLineBreaks'=>true));
        $docx->replaceVariableByHTML('tanggalWas2', 'inline',$was2_tanggal, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('tanggal1', 'inline',$was2_tanggal, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('nomor', 'inline',$was2_no_surat, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByText(array('perihal1'=>$perihal_lapdu), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ringkasan'=>$ringkasan_lapdu), array('parseLineBreaks'=>true));
        $docx->replaceVariableByHTML('jabatanalias', 'inline','<b>'.strtoupper($jabatan_alias).'</b>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('jabatan', 'inline','<b>'.strtoupper($jabatan).'</b>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('namaTandatangan', 'inline','<b>'.strtoupper($nama).'</b>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('nipTandatangan', 'inline','<b>'.strtoupper($nip).'</b>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('tembusan', 'inline',$x, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByText(array('pelapor'=>$pelapor), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tembusan1'=>$tembusan), array('parseLineBreaks'=>true));

		$no_register1 = str_replace("/","",$no_register);
        $docx->createDocx('template/pengawasan/was-2_'.$no_register1);
		
        $file = 'template/pengawasan/was-2_'.$no_register1.'.docx';

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