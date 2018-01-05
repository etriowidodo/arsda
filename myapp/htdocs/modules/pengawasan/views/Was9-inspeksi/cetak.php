<?php
require_once('/wordtest/classes/CreateDocx.inc');

        $docx = new CreateDocxFromTemplate('../modules/pengawasan/template/was-9inspeksi.docx');
        $low_kejaksaan = strtolower($data_satker['inst_nama']);
        $low_lokasi = strtolower($data_satker['inst_lokinst']);
        $kejaksaan=strtoupper($low_kejaksaan);
        $kejaksaan_uc=ucwords($low_kejaksaan);
        //$lokasi=ucwords($low_lokasi);
        $lokasi=strtoupper($low_lokasi);


         if($model['zona_waktu']=='0'){
            $zona_waktu="WIB"; 
         }else if($model['zona_waktu']=='1'){
            $zona_waktu="WITA"; 
         }else if($model['zona_waktu']=='2'){
            $zona_waktu="WIT"; 
         }

         $jamm = substr($model['jam_pemeriksaan_was9'],0,5);
        

        $nomor         =($model['nomor_surat_was9']!=''?$model['nomor_surat_was9']:'<p></p>');
        // $sifat         =($model['sifat_was9']!=''?$model['sifat_was9']:'<p></p>');
        $lampiran      =($model['lampiran_was9']!=''?$model['lampiran_was9']:'<p></p>');
        $perihal       =($model['perihal_was9']!=''?$model['perihal_was9']:'<p></p>');
        $nama          =($model['nama_pemeriksa']!=''?$model['nama_pemeriksa']:'<p></p>');
        $pangkat       =($model['pangkat_pemeriksa']!=''?$model['pangkat_pemeriksa']:'<p></p>');
        $jabatan       =($model['jabatan_pemeriksa']!=''?$model['jabatan_pemeriksa']:'<p></p>');
        $nip           =($model['nip_pemeriksa']!=''?$model['nip_pemeriksa']:'<p></p>');
        $hari          =($model['hari_pemeriksaan_was9']!=''?$model['hari_pemeriksaan_was9']:'<p></p>');
        $tgl_periksa   =($model['tanggal_pemeriksaan_was9']!=''?$tgl_periksa:'<p></p>');
        $tgl_was9      =($model['tanggal_was9']!=''?$tgl_was9:'<p></p>');
        $jam           =($jamm!=''?$jamm.' '.$zona_waktu:'<p></p>');
    //    $jam           =($model['jam_pemeriksaan_was9']!=''?$model['jam_pemeriksaan_was9']:'<p></p>');
        $tempat        =($model['tempat_pemeriksaan_was9']!=''?$model['tempat_pemeriksaan_was9']:'<p></p>');
        $nama_pemeriksaan     =($model['nama_pemeriksa']!=''?$model['nama_pemeriksa']:'<p></p>');
        $pangkat_pemeriksaan  =($model['pangkat_pemeriksa']!=''?$model['pangkat_pemeriksa']:'<p></p>');
        $golongan_pemeriksaan =($model['golongan_pemeriksa']!=''?$model['golongan_pemeriksa']:'<p></p>');
        $nip_pemeriksaan      =($model['nip_pemeriksa']!=''?$model['nip_pemeriksa'].($model['nrp_pemeriksa']==''?'':'/'.$model['nrp_pemeriksa']):'<p></p>');
        $jabatan_pemeriksaan  =($model['jabatan_pemeriksa']!=''?$model['jabatan_pemeriksa']:'<p></p>');
        $gol_pgkt      =$pangkat_pemeriksaan."/".$golongan_pemeriksaan;
        $nip_pnd       =($model['nip_penandatangan']!=''?$model['nip_penandatangan']:'<p></p>');
        $nama_pnd      =($model['nama_penandatangan']!=''?$model['nama_penandatangan']:'<p></p>');
        // $jabatan_pnd   =($model['jabatan_penandatangan']!=''?$model['jabatan_penandatangan']:'<p></p>');
        $jabatan_asli              =(substr($model['jabatan_penandatangan'],0,3)=='AN '?$model['jbtn_penandatangan']:'');
        $jbtn_pnd      =($model['jbtn_penandatangan']!=''?$model['jbtn_penandatangan']:'<p></p>');
        $pangkat_penandatangan   =$model['pangkat_penandatangan'];

    
    if($model['jenis_saksi']=='Internal'){
        $nama_saksi    =($model['nama_saksi_internal']!=''?$model['nama_saksi_internal']:'<p></p>');
        $lok_saksi     =($model['di_was9']!=''?$model['di_was9']:'<p></p>');
    }else{
        $nama_saksi    =($model['nama_saksi_eksternal']!=''?$model['nama_saksi_eksternal']:'<p></p>');
        $lok_saksi     =($model['di_was9']!=''?$model['di_was9']:'<p></p>');
    }
        $uraian_permasalahan =($model4['ringkasan_lapdu']!=''?$model4['ringkasan_lapdu']:'<p></p>');
        $nomor_sp_was2 =($model3['nomor_sp_was2']!=''?$model3['nomor_sp_was2']:'<p></p>');
        $tglSpWas      =($model3['tanggal_sp_was2']!=''? \Yii::$app->globalfunc->ViewIndonesianFormat($model3['tanggal_sp_was2']):'<p></p>');
        $pejabatSpWas2 =($model3['jabatan_penandatangan']!=''?$model3['jabatan_penandatangan']:'<p></p>');


        $no             =1;
        $tmb            ='';
         // if($model2['id_tembusan_was']==''){
         //        $tmb .="";
         //    }else{
            if(count($model2<=0)){
                $tmb .="<p></p>";    
            }else{
                foreach ($model2 as $tembusan) {
                        $tmb .=$no.".".$tembusan['tembusan']."<br>";
                        $no++;
                        
                    }
             }
        if($model['sifat_was9']=='1'){
            $sifat="Biasa";
            $akr="B";
         }else if($model['sifat_was9']=='2'){
            $sifat="Segera";
            $akr="S";
         }else if($model['sifat_was9']=='3'){
            $sifat="Rahasia";
            $akr="R";
         }

  
        $no             =1;
        $terlapor       =explode('#',$model5['nama_pegawai_terlapor']);
        $terlapor_1     =' ';

        if(count($terlapor)==1){
            for ($i=0; $i <1 ; $i++) { 
                $terlapor_1  .= $terlapor[$i]; 
            }
        }

        if(count($terlapor)==2){
            for ($i=0; $i <2 ; $i++) { 
                $terlapor_1  .= $terlapor[$i]." Dan "; 
            }
        }
        
        if(count($terlapor)>2){
            for ($i=0; $i<1 ; $i++) { 
                $terlapor_1  .= $terlapor[$i].",dkk "; 
            }
        }

        // for ($i=0; $i <count($terlapor) ; $i++) { 
        //     $terlapor_1  .=$no.".".$terlapor[$i].",";
        //     $no++;
        // }

        $tembusan="";
        $no_tembusan=1;
        $tembusan .="<table width='100%' style='font-family:arial;'>";
        foreach ($model2 as $rowTembusan) {
            $tembusan .="<tr>
                            <td width='1%'>".(count($model2)>=2?$no_tembusan:' ')."</td>
                            <td>".$rowTembusan['tembusan']."</td>
                        </tr>";
            $no_tembusan++;
        }
        $tembusan .="</table>";
         
            $docx->setDefaultFont('Arial'); 
            $docx->replaceVariableByHTML('kejaksaan', 'inline','<h2 style="text-align: center; font-family:arial;"><b><p>'.$kejaksaan.'</p></b></h2>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            // $docx->replaceVariableByHTML('kejaksaan_uc', 'inline','<p>'.$kejaksaan_uc.'</p>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByText(array('kejaksaan_uc'=>$kejaksaan_uc), array('parseLineBreaks'=>true));
            $docx->replaceVariableByHTML('lokasi', 'inline','<h2 style="text-align: center; font-family:arial;"><b><p>'.$lokasi.'</p></b></h2>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            // $docx->replaceVariableByHTML('tempat', 'inline',$lokasi, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByText(array('tempat'=> ucwords(strtolower($lokasi))), array('parseLineBreaks'=>true));
            // $docx->replaceVariableByHTML('kejaksaan1', 'inline',ucfirst($kejaksaan), array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByText(array('kejaksaan1'=> ucwords(strtolower($data_satker['inst_nama']))), array('parseLineBreaks'=>true));
            $docx->replaceVariableByHTML('nomor', 'inline',$nomor, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            // $docx->replaceVariableByHTML('sifat', 'inline',$sifat, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByText(array('sifat'=>$sifat), array('parseLineBreaks'=>true));
            $docx->replaceVariableByHTML('perihal', 'inline',$perihal, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByHTML('hari', 'inline',$hari, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByHTML('jam', 'inline',$jam, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByHTML('tempatPanggilan', 'inline',$tempat, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByHTML('tanggalPanggilan', 'inline',$tgl_periksa, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByHTML('namaPemeriksa', 'inline',$nama_pemeriksaan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByHTML('pangkatPemeriksa', 'inline',$gol_pgkt, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByHTML('nipPemeriksa', 'inline',$nip_pemeriksaan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            // $docx->replaceVariableByHTML('jabatanPemeriksa', 'inline',$jabatan_pemeriksaan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByText(array('jabatanPemeriksa'=> ucwords(strtolower($jabatan_pemeriksaan))), array('parseLineBreaks'=>true));
            // $docx->replaceVariableByHTML('jabatanPenandatangan', 'inline',$jabatan_pnd, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByText(array('jabatanPenandatangan'=>ucwords(strtolower($jabatan_pnd))), array('parseLineBreaks'=>true));
            $docx->replaceVariableByText(array('jabatan'=>ucwords(strtolower($jbtn_pnd))), array('parseLineBreaks'=>true));
            // $docx->replaceVariableByHTML('jabatan', 'inline',$jbtn_pnd, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            // $docx->replaceVariableByHTML('namaTandatangan', 'inline',$nama_pnd, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByText(array('namaTandatangan'=> $nama_pnd), array('parseLineBreaks'=>true));
            $docx->replaceVariableByHTML('nipTandatangan', 'inline',$nip_pnd, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByHTML('tembusan', 'block',$tembusan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByHTML('namaSaksi', 'block',$nama_saksi, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByHTML('lokasi_saksi', 'block','<u>'.$lok_saksi.'</u>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            // $docx->replaceVariableByText(array('lokasi_saksi'=>$lok_saksi), array('parseLineBreaks'=>true));
            $docx->replaceVariableByHTML('namaTerlapor', 'inline',$terlapor_1, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByHTML('uraianPermasalahan', 'inline',$uraian_permasalahan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByHTML('noSpWas', 'inline',$nomor_sp_was2, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByHTML('tglSpWas', 'inline',$tglSpWas, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByHTML('tanggal', 'inline',$tgl_was9, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            // $docx->replaceVariableByHTML('pejabatSpWas1', 'inline',$pejabatSpWas2, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByText(array('pejabatSpWas1'=> ucwords(strtolower($pejabatSpWas2))), array('parseLineBreaks'=>true));
            $docx->replaceVariableByHTML('berkas', 'inline',$lampiran, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByText(array('pangkat_ttd'=>$pangkat_penandatangan), array('parseLineBreaks'=>true));

		// $no_register1 = str_replace("/","",$no_register);
        $docx->createDocx('template/pengawasan/was-9inspeksi');
		
        $file = 'template/pengawasan/was-9inspeksi.docx';

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