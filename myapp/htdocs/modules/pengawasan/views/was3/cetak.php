<?php
require_once('/wordtest/classes/CreateDocx.inc');

        $docx = new CreateDocxFromTemplate('../modules/pengawasan/template/was-3.docx');
        $kejaksaan=strtoupper($data_satker['inst_nama']);
       
        $kepada         =($model['was3_kepada']!=''?$model['was3_kepada']:'<p></p>');
        $no_register    =($model['no_register']!=''?$model['no_register']:'<p></p>');
        $lampiran       =($model['was3_lampiran']!=''?$model['was3_lampiran']:'<p></p>');
        $was3_tanggal   =($model['was3_tanggal']!=''?$tgl:'<p></p>');
        $tanggal_lapdu  =($model['tanggal_lapdu']!=''?$tglLapdu:'<p></p>');
        $was3_no_surat  =($model['no_surat']!=''?$model['no_surat']:'<p></p>');
        $was3_perihal   =($model['was3_perihal']!=''?$model['was3_perihal']:'<p></p>');
        $ringkasan_lapdu=($model['ringkasan_lapdu']!=''?$model['ringkasan_lapdu']:'<p></p>');
        $jabatan_alias  =($model['jbtn_penandatangan']!=''?$model['jbtn_penandatangan']:'<p></p>');
        $jabatan        =($model['jabatan_penandatangan']!=''?$model['jabatan_penandatangan']:'<p></p>');
        $nama           =($model['nama_penandatangan']!=''?$model['nama_penandatangan']:'<p></p>');
       // $gol            =($model['golongan_penandatangan']!=''?$model['golongan_penandatangan']:'<p></p>');
        $pangkat        =($model['pangkat_penandatangan']!=''?$model['pangkat_penandatangan']:'<p></p>');
        $tembusan_lapdu =($model['tembusan_lapdu']!=''?$model['tembusan_lapdu']:'<p></p>');
        $nip            =($model['peg_nip']!=''?$model['peg_nip']:'<p></p>');
        $tempat         ='Jakarta';
        $kepada_lapdu   =($model['kepada_lapdu']!=''?$model['kepada_lapdu']:'<p></p>');
        $plp            =($model4['nama_pelapor']!=''?$model4['nama_pelapor']:'<p></p>');
        $trl            =($model3['nama_terlapor_awal']!=''?$model3['nama_terlapor_awal']:'<p></p>');
        //kepada_lapdu1
        $no             =1;
        $tmb            ='';
        foreach ($model2 as $tembusan) {
            $tmb .=$no.".".$tembusan['tembusan']."<br>";
            $no++;
        }
        
        $no             =1;
        $terlapor       =explode(',',$model3['nama_terlapor_awal']);
        $terlapor_1     =' ';

        for ($i=0; $i <count($terlapor) ; $i++) { 
            $terlapor_1  .=$no.".".$terlapor[$i]."<br>";
            $no++;
        }

        /*$nok             =1;
        $trl            ='';
        foreach ($model3 as $terlapor) {
            $trl .=$nok.".".$terlapor['nama_terlapor_awal']."<br>";
            $nok++;
        }*/

       /* $no             =1;
        $plp            ='';
        foreach ($model4 as $pelapor) {
            $plp .=$no.".".$pelapor['nama_pelapor'].",";
            $no++;
        }*/
        
           
        $docx->setDefaultFont('Arial');
        $docx->replaceVariableByHTML('kejaksaan', 'inline','<h2 style="text-align: center;"><b><p>'.$kejaksaan.'</p></b></h2>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('kepada', 'inline','<p>'.$kepada.'</p></h2>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByText(array('lampiran'=>$lampiran), array('parseLineBreaks'=>true));
        $docx->replaceVariableByHTML('tanggal1', 'inline',$was3_tanggal, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('tanggalLapdu', 'inline',$tanggal_lapdu, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('nomor', 'inline',$was3_no_surat, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByText(array('perihal'=>$was3_perihal), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('ringkasan'=>$ringkasan_lapdu), array('parseLineBreaks'=>true));
        //$docx->replaceVariableByText(array('namaTerlapor'=>$terlapor), array('parseLineBreaks'=>true));
        //$docx->replaceVariableByText(array('ringkasan'=>$ringkasan_lapdu), array('parseLineBreaks'=>true));
         $docx->replaceVariableByHTML('namaTerlapor1', 'inline',$terlapor_1, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('namaTerlapor', 'inline',$terlapor_1, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        //$docx->replaceVariableByHTML('namaTerlapor', 'inline',$trl, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('pelapor1', 'inline',$plp, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('jabatanPenandatangan', 'inline','<b>'.strtoupper($jabatan_alias).'</b>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('jabatan', 'inline','<b>'.strtoupper($jabatan).'</b>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('namaTandatangan', 'inline','<b>'.strtoupper($nama).'</b>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('nipTandatangan', 'inline','<b>'.strtoupper($nip).'</b>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        // $docx->replaceVariableByHTML('tembusan', 'inline',$tmb, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('tempat', 'inline',$tempat, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByText(array('kepada_lapdu1'=>$kepada_lapdu), array('parseLineBreaks'=>true));
         $docx->replaceVariableByText(array('tembusan_lapdu'=>$tembusan_lapdu), array('parseLineBreaks'=>true));
         //$docx->replaceVariableByText(array('tembusan'=>$tmb), array('parseLineBreaks'=>true));
         $docx->replaceVariableByHTML('tembusan', 'inline',$tmb, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));

		$no_register1 = str_replace("/","",$no_register);
        $docx->createDocx('template/pengawasan/was-3_'.$no_register1);
		
        $file = 'template/pengawasan/was-3_'.$no_register1.'.docx';

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