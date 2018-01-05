<?php
require_once('/wordtest/classes/CreateDocx.inc');
        $docx = new CreateDocxFromTemplate('../modules/pengawasan/template/ba_was_6.docx');
         $kejaksaan=strtoupper($data_satker['inst_nama']);
        // echo $model['nama_terlapor'];
        // exit();
         $tempat=ucwords(strtolower($model['tempat']));

        $hari            =\Yii::$app->globalfunc->GetNamaHari($model['tgl_ba_was_6']);
        $tanggal_bawas6      =\Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_ba_was_6']);

        $penyampai_nama  =$model['nama_menerima'];
        $penyampai_pangkat  =$model['pangkat_menerima'];
        $penyampai_nip   =$model['nip_menerima'].($model['nrp_menerima']==''?'':'/'.$model['nrp_menerima']);
        $penyampai_jabatan  =$model['jabatan_menerima'];
        
        if($model['terima_tolak'] == '1'){
          $terimatolak  = 'Terima';
         // $judul        = 'SURAT PERNYATAAN TERIMA'."<br>".'DAN TIDAK AKAN MENGAJUKAN KEBERATAN'."<br>".'TERHADAP SURAT KEPUTUSAN PENJATUHAN HUKUMAN DISIPLIN'."</u>";
          $judul        = 'TERIMA'."<br>".'DAN TIDAK AKAN MENGAJUKAN';
        }else if($model['terima_tolak'] == '2'){
          $terimatolak  = 'Tolak';
         // $judul        = ' MENOLAK'."<br>".'AKAN MENGAJUKAN KEBERATAN'."<br><u>".'TERHADAP SURAT KEPUTUSAN PENJATUHAN HUKUMAN DISIPLIN'."</u>";
          $judul        = ' MENOLAK'."<br>".'DAN AKAN MENGAJUKAN';
        }
        
        $sk = $model['sk'];
        if($model['sk'] == 'SK-WAS3-A'){
            $isi_sk = 'Penundaan Kenaikan Gaji Berkala Selama 1 (satu) tahun';
        }else if($model['sk'] == 'SK-WAS3-B'){
            $isi_sk = 'Penundaan Kenaikan Pangkat Selama 1 (satu) Tahun';
        }
        $no_sk          =$model['no_sk'];
        $tanggal_sk     =\Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_sk']);
        $tanggal        =\Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_ba_was_6']);
        $hukdisnya      =$modelSk['isi_sk'];
        
      //    /*Terlapor*/
        $nama           =$model['nama_terlapor'];
        $pangkat        =$model['pangkat_terlapor'];
        $nip            =$model['nip_terlapor'].($model['nrp_terlapor']==''?'':'/'.$model['nrp_terlapor']);
        $jabatan        =$model['jabatan_terlapor'];
        
       // $tempat        =$model['tempat'];

        
 		
 		$docx->setDefaultFont('Arial'); 
       $docx->replaceVariableByHTML('kejaksaan', 'inline','<h2 style="text-align: center;"><b><p>'.$kejaksaan.'</p></b></h2>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
       $docx->replaceVariableByHTML('tempat', 'inline','<h2 style="text-align: center;"><b><p>'.$lokasi.'</p></b></h2>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
       $docx->replaceVariableByHTML('judul', 'inline','<style="font-size:12px;">'.$judul.'</style>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
       $docx->replaceVariableByText(array('nama'=>$nama), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('pangkat'=>$pangkat), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('nip'=>$nip), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('jabatan'=>$jabatan), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('sk'=>$sk), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('isi_sk'=>$isi_sk), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('no_sk'=>$no_sk), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('tgl_sk'=>$tanggal_sk), array('parseLineBreaks'=>true));
       
       $docx->replaceVariableByText(array('hari'=>$hari), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('tanggal'=>$tanggal_bawas6), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('terimatolak'=>$terimatolak), array('parseLineBreaks'=>true));
       
       $docx->replaceVariableByText(array('ttd_jabatan'=>$penyampai_jabatan), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('ttd_nama'=>$penyampai_nama), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('ttd_pangkat'=>$penyampai_pangkat), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('ttd_nip'=>$penyampai_nip), array('parseLineBreaks'=>true));
       
       $docx->replaceVariableByText(array('lokasi'=>$tempat), array('parseLineBreaks'=>true));
       
 		$docx->createDocx('template/pengawasan/ba_was_6');
		
        $file = 'template/pengawasan/ba_was_6.docx';

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