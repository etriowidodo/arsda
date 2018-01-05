<?php
require_once('/wordtest/classes/CreateDocx.inc');
        $docx = new CreateDocxFromTemplate('../modules/pengawasan/template/ba-was5.docx');
        $kejaksaan=strtoupper($data_satker['inst_nama']);
        $tempat=ucwords(strtolower($model['tempat']));

        // if($model['sifat_was14d']=='0'){
        //     $sifat="Biasa";
        //     $akr="B";
        //  }else if($model['sifat_was14d']=='1'){
        //     $sifat="Segera";
        //     $akr="S";
        //  }else if($model['sifat_was14d']=='2'){
        //     $sifat="Rahasia";
        //     $akr="R";
        //  }

        $hari            =\Yii::$app->globalfunc->GetNamaHari($model['tgl_ba_was_5']);
        $tanggal_bawas5      =\Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_ba_was_5']);

        $penyampai_nama  =$model['nama_penyampai'];
        $penyampai_pangkat  =$model['pangkat_penyampai'];
        $penyampai_nip   =$model['nip_penyampai'].($model['nrp_penyampai']==''?'':'/'.$model['nrp_penyampai']);
        $penyampai_jabatan  =$model['jabatan_penyampai'];
        
        $sk             =$model['sk'];
        $no_sk          =$model['no_sk'];
        $tanggal_sk     =\Yii::$app->globalfunc->ViewIndonesianFormat($model['tanggal_sk']);
        $kategori       =$modelSk['category_sk'];
        $hukdisnya      =$modelSk['isi_sk'];
        
      //    /*Terlapor*/
        $nama           =$model['nama_penerima'];
        $pangkat        =$model['pangkat_penerima'];
        $nip            =$model['nip_penerima'].($model['nrp_penerima']==''?'':'/'.$model['nrp_penerima']);
        $jabatan        =$model['jabatan_penerima'];

        $nama_saksi1    =$model['nama_saksi1'];
        $pangkat_saksi1 =$model['pangkat_saksi1'];
        $nip_saksi1     =$model['nip_saksi1'];
        $jabatan_saksi1 =$model['jabatan_saksi1'];

        $nama_saksi2    =$model['nama_saksi2'];
        $pangkat_saksi2 =$model['pangkat_saksi2'];
        $nip_saksi2     =$model['nip_saksi2'];
        $jabatan_saksi2 =$model['jabatan_saksi2'];
      //   //$nip_terlapor     =$model['nip_terlapor'] .' / '. $model['nrp_terlapor'];
      //   $nip_terlapor     =substr($model['nip_terlapor'],0,8).' '.substr($model['nip_terlapor'],8,6).' '.substr($model['nip_terlapor'],14,1).' '.substr($model['nip_terlapor'],15,3).($model['nrp_terlapor']!=''?'/':' ').$model['nrp_terlapor'];
      //   $pangkat_terlapor =$model['pangkat_terlapor'];
      //   $golongan_terlapor=$model['golongan_terlapor'];
      //   $jabatan_terlapor =$model['jabatan_terlapor'];
      //    /*Penyampai*/
      //   $nama_penyampai    =$model['nama_penyampai'];
      //   //$nip_penyampai     =$model['nip_penyampai'] .' / '. $model['nrp_penyampai'];
      //   $nip_penyampai     =substr($model['nip_penyampai'],0,8).' '.substr($model['nip_penyampai'],8,6).' '.substr($model['nip_penyampai'],14,1).' '.substr($model['nip_penyampai'],15,3).($model['nrp_penyampai']!=''?'/':' ').$model['nrp_penyampai'];
      //   $pangkat_penyampai =$model['pangkat_penyampai'];
      //   $golongan_penyampai=$model['golongan_penyampai'];
      //   $jabatan_penyampai =$model['jabatan_penyampai'];
      //   /*Saksi 1*/
      //   $nama_saksi1       =$model['nama_saksi1'];
      //  // $nip_saksi1        =$model['nip_saksi1'] .' / '. $model['nrp_saksi1'];
      //   $nip_saksi1        =substr($model['nip_saksi1'],0,8).' '.substr($model['nip_saksi1'],8,6).' '.substr($model['nip_saksi1'],14,1).' '.substr($model['nip_saksi1'],15,3).($model['nrp_saksi1']!=''?'/':' ').$model['nrp_saksi1'];
      //   $pangkat_saksi1    =$model['pangkat_saksi1'];
      //   $golongan_saksi1   =$model['golongan_saksi1'];
      //   $jabatan_saksi1    =$model['jabatan_saksi1'];
      //   /*Saksi2*/
      //   $nama_saksi2       =$model['nama_saksi2'];
      // //  $nip_saksi2        =$model['nip_saksi2'] .' / '. $model['nrp_saksi2'];
      //   $nip_saksi2        =substr($model['nip_saksi2'],0,8).' '.substr($model['nip_saksi2'],8,6).' '.substr($model['nip_saksi2'],14,1).' '.substr($model['nip_saksi2'],15,3).($model['nrp_saksi2']!=''?'/':' ').$model['nrp_saksi2'];
      //   $pangkat_saksi2    =$model['pangkat_saksi2'];
      //   $golongan_saksi2   =$model['golongan_saksi2'];
      //   $jabatan_saksi2    =$model['jabatan_saksi2'];

      //   $pejabat_sp_was_2  =$modelwas2['jabatan_penandatangan'];
      //   $no_sp_was_2       =$modelwas2['nomor_sp_was2'];
      //   $perihal           =$modelLapdu['perihal_lapdu'];
      //   $isi_sk            =$modelSk['isi_sk'];

        // print_r($pejabat_sp_was_2);
        // print_r($no_sp_was_2);
        // exit();
/*"id_tingkat":"0","id_kejati":"00","id_kejari":"00","id_cabjari":"00","no_register":"Reg00190",
"id_sp_was2":1,"id_ba_was2":1,"id_l_was2":1,"id_was15":2,"id_was_16b":2,"id_wilayah":1,"id_level1":6,
"id_level2":8,"id_level3":2,"id_level4":1,"id_ba_was_7":null,"id_ba_was_8":null,"kpd_was_16b":"test kepada 2",
"dari_was_16b":"An. Inspektur II","tgl_was_16b":"2017-09-14","no_was_16b":"456","sifat_surat":0,
"lampiran":"test lampiran 2","perihal":"wer","id_terlapor":null,"nip_pegawai_terlapor":"198712252009122002",
"nrp_pegawai_terlapor":"5108789","nama_pegawai_terlapor":"ZIDNI ILMA, S.Kom.","pangkat_pegawai_terlapor":"II\/d",
"golongan_pegawai_terlapor":"Sena Darma TU","jabatan_pegawai_terlapor":"Operator Komputer KEPEGAWAIAN",
"satker_pegawai_terlapor":"KEJAGUNG RI","nip_penandatangan":"196409291989101001",
"nama_penandatangan":"MARTONO, S.H., M.H.","pangkat_penandatangan":"Jaksa Utama Madya",
"golongan_penandatangan":"IV\/d","jabatan_penandatangan":"An. Inspektur II","upload_file":null,
"created_by":6,"created_ip":"127.0.0.1","created_time":"2017-09-08 05:45:01","updated_ip":"127.0.0.1",
"updated_by":6,"updated_time":"2017-09-08 05:56:37*/
 		
 		$docx->setDefaultFont('Arial'); 
       $docx->replaceVariableByHTML('kejaksaan', 'inline','<h2 style="text-align: center; font-family:Arial;"><b><p>'.$kejaksaan.'</p></b></h2>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
       // $docx->replaceVariableByHTML('tempat', 'inline','<h2 style="text-align: center;"><b><p>'.$lokasi.'</p></b></h2>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
       $docx->replaceVariableByText(array('hari'=>$hari), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('tanggal_bawas5'=>$tanggal_bawas5), array('parseLineBreaks'=>true));
   //     $docx->replaceVariableByText(array('tgl_sp_was_2'=>$tanggalSpwas2), array('parseLineBreaks'=>true));
   //     $docx->replaceVariableByText(array('no_sp_was_2'=>$no_sp_was_2), array('parseLineBreaks'=>true));
   //     $docx->replaceVariableByText(array('pejabat_sp_was_2'=>$pejabat_sp_was_2), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('tempat'=>$tempat), array('parseLineBreaks'=>true));
       
       $docx->replaceVariableByText(array('penyampai_nama'=>$penyampai_nama), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('penyampai_pangkat'=>$penyampai_pangkat), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('penyampai_nip'=>$penyampai_nip), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('penyampai_jabatan'=>$penyampai_jabatan), array('parseLineBreaks'=>true));
       
       $docx->replaceVariableByText(array('sk'=>$sk), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('no_sk'=>$no_sk), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('tanggal_sk'=>$tanggal_sk), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('kategori'=>$kategori), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('hukdisnya'=>$hukdisnya), array('parseLineBreaks'=>true));
       
       $docx->replaceVariableByText(array('nama'=>$nama), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('pangkat'=>$pangkat), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('nip'=>$nip), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('jabatan'=>$jabatan), array('parseLineBreaks'=>true));
       
       $docx->replaceVariableByText(array('nama_saksi1'=>$nama_saksi1), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('pangkat_saksi1'=>$pangkat_saksi1), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('nip_saksi1'=>$nip_saksi1), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('jabatan_saksi1'=>$jabatan_saksi1), array('parseLineBreaks'=>true));

       $docx->replaceVariableByText(array('nama_saksi2'=>$nama_saksi2), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('pangkat_saksi2'=>$pangkat_saksi2), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('nip_saksi2'=>$nip_saksi2), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('jabatan_saksi2'=>$jabatan_saksi2), array('parseLineBreaks'=>true));

   //     $docx->replaceVariableByText(array('penyampai_pangkat'=>$pangkat_penyampai), array('parseLineBreaks'=>true));
   //     $docx->replaceVariableByText(array('penyampai_nip'=>$nip_penyampai), array('parseLineBreaks'=>true));
   //     $docx->replaceVariableByText(array('penyampai_jabatan'=>$jabatan_penyampai), array('parseLineBreaks'=>true));
   //     $docx->replaceVariableByText(array('nama_saksi1'=>$nama_saksi1), array('parseLineBreaks'=>true));
   //     $docx->replaceVariableByText(array('pangkat_saksi1'=>$pangkat_saksi1), array('parseLineBreaks'=>true));
   //     $docx->replaceVariableByText(array('nip_saksi1'=>$nip_saksi1), array('parseLineBreaks'=>true));
   //     $docx->replaceVariableByText(array('jabatan_saksi1'=>$jabatan_saksi1), array('parseLineBreaks'=>true));
   //     $docx->replaceVariableByText(array('nama_saksi2'=>$nama_saksi2), array('parseLineBreaks'=>true));
   //     $docx->replaceVariableByText(array('pangkat_saksi2'=>$pangkat_saksi2), array('parseLineBreaks'=>true));
   //     $docx->replaceVariableByText(array('nip_saksi2'=>$nip_saksi2), array('parseLineBreaks'=>true));
   //     $docx->replaceVariableByText(array('jabatan_saksi2'=>$jabatan_saksi2), array('parseLineBreaks'=>true));
   //     $docx->replaceVariableByText(array('perihal_dugaan'=>$perihal), array('parseLineBreaks'=>true));
   //     $docx->replaceVariableByText(array('isi_sk'=>$isi_sk), array('parseLineBreaks'=>true));
       // $docx->replaceVariableByText(array('nama_penandatangan'=>$nama_penandatangan), array('parseLineBreaks'=>true));
       // $docx->replaceVariableByText(array('pangkat_penandatangan'=>$pangkat_penandatangan), array('parseLineBreaks'=>true));
       // $docx->replaceVariableByText(array('nip_penandatangan'=>$nipTandatangan), array('parseLineBreaks'=>true));
       
       // $docx->replaceVariableByHTML('isi', 'block',$uraian_was16b, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));

       // $docx->replaceVariableByHTML('tembusan', 'block',$tembusan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));

 		$docx->createDocx('template/pengawasan/ba-was5');
		
        $file = 'template/pengawasan/ba-was5.docx';

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