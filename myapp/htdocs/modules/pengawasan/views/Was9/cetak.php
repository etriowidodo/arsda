<?php
require_once('/wordtest/classes/CreateDocx.inc');

        $docx = new CreateDocxFromTemplate('../modules/pengawasan/template/was-9.docx');
        $low_kejaksaan=strtolower($data_satker['inst_nama']);
        $kejaksaan=strtoupper($low_kejaksaan);
        $kejaksaan_uc=ucwords($low_kejaksaan);
        $lokasi=strtoupper($data_satker['inst_lokinst']);
        $lokasi_uc=ucwords(strtolower($data_satker['inst_lokinst']));
 
        if($model['sifat_was9']=='1'){
            $sifat="Biasa";
        //    $akr="B";
         }else if($model['sifat_was9']=='2'){
            $sifat="Segera";
         //   $akr="S";
         }else if($model['sifat_was9']=='3'){
            $sifat="Rahasia";
         //   $akr="R";
         }
         
        if($model['zona']=='0'){
            $zona="WIB"; 
         }else if($model['zona']=='1'){
            $zona="WITA"; 
         }else if($model['zona']=='2'){
            $zona="WIT"; 
         }

         $jamm = substr($model['jam_pemeriksaan_was9'],0,5);
 

         // print_r($model['sifat_was9']);
         // exit();

        $nomor         =($model['nomor_surat_was9']!=''?$model['nomor_surat_was9']:'<p></p>');
        //$sifat         =($model['sifat_was9']!=''?$model['sifat_was9']:'<p></p>');
        $lampiran      =($model['lampiran_was9']!=''?$model['lampiran_was9']:'<p></p>');
        $perihal       =($model['perihal_was9']!=''?$model['perihal_was9']:'<p></p>');
        $nama          =($model['nama_pemeriksa']!=''?$model['nama_pemeriksa']:'<p></p>');
        $pangkat       =($model['pangkat_pemeriksa']!=''?$model['pangkat_pemeriksa']:'<p></p>');
        $jabatan       =($model['jabatan_pemeriksa']!=''?$model['jabatan_pemeriksa']:'<p></p>');
        $nip           =($model['nip_pemeriksa']!=''?$model['nip_pemeriksa']:'<p></p>');
        $hari          =($model['hari_pemeriksaan_was9']!=''?$model['hari_pemeriksaan_was9']:'<p></p>');
        $tgl_periksa   =($model['tanggal_pemeriksaan_was9']!=''?$tgl_periksa:'<p></p>');
        $tgl_was9      =($model['tanggal_was9']!=''?$tgl_was9:'<p></p>');
        $jam           =($jamm!=''?$jamm.' '.$zona:'<p></p>');
        // $zona          =($model['zona_waktu']!=''?$model['zona_waktu']:'<p></p>');
        $tempat        =($model['tempat_pemeriksaan_was9']!=''?$model['tempat_pemeriksaan_was9']:'<p></p>');
        $nama_pemeriksaan     =($model['nama_pemeriksa']!=''?$model['nama_pemeriksa']:'<p></p>');
        $pangkat_pemeriksaan  =($model['pangkat_pemeriksa']!=''?$model['pangkat_pemeriksa']:'<p></p>');
        $golongan_pemeriksaan =($model['golongan_pemeriksa']!=''?$model['golongan_pemeriksa']:'<p></p>');
        $nip_pemeriksaan      =($model['nip_pemeriksa']!=''?$model['nip_pemeriksa']:'<p></p>');
        $jabatan_pemeriksaan  =($model['jabatan_pemeriksa']!=''?$model['jabatan_pemeriksa']:'<p></p>');
        $gol_pgkt      =$pangkat_pemeriksaan."/".$golongan_pemeriksaan;
        $nip_pnd       =($model['nip_penandatangan']!=''?' NIP.'.$model['nip_penandatangan']:'<p></p>');
        $pangkat_pnd       =($model['pangkat_penandatangan']!=''?$model['pangkat_penandatangan']:'<p></p>');
        $nama_pnd      =($model['nama_penandatangan']!=''?$model['nama_penandatangan']:'<p></p>');
        $jabatan_pnd   =($model['jabatan_penandatangan']!=''?$model['jabatan_penandatangan']:'<p></p>');
        $jbtn_pnd      =($model['jbtn_penandatangan']!=''?$model['jbtn_penandatangan']:'<p></p>');
		if($jbtn_pnd==$jabatan_pnd){
			$jbtn_pnd='<p></p>';
		}else{
			$jbtn_pnd=$jbtn_pnd;
		}

    
    if($model['jenis_saksi']=='Internal'){
        $nama_saksi    =($model['nama_saksi_internal']!=''?$model['nama_saksi_internal']:'<p></p>');
        $lok_saksi     ='<u>'.($model['di_was9']!=''?$model['di_was9'].'</u>':'<p></p>');
    }else{
        $nama_saksi    =($model['nama_saksi_eksternal']!=''?$model['nama_saksi_eksternal']:'<p></p>');
        $lok_saksi     ='<u>'.($model['di_was9']!=''?$model['di_was9'].'</u>':'<p></p>');
    }
        $uraian_permasalahan =($model4['ringkasan_lapdu']!=''?$model4['ringkasan_lapdu']:'<p></p>');
        $nomor_sp_was1 =($model3['nomor_sp_was1']!=''?$model3['nomor_sp_was1']:'<p></p>');
        $tglSpWas      =($model3['tanggal_sp_was1']!=''?$tglSpWas:'<p></p>');
      //  $pejabatSpWas1 =($model3['nama_penandatangan']!=''?$model3['nama_penandatangan']:'<p></p>');
        $pejabatSpWas1 =($model3['jabatan_penandatangan']!=''?$model3['jabatan_penandatangan']:'<p></p>');

        $no             =1;
        $tmb            ='';
         // if($model2['id_tembusan_was']==''){
         //        $tmb .="";
         //    }else{
        foreach ($model2 as $tembusan) {
            $tmb .=$no.".".$tembusan['tembusan']."<br>";
            $no++;
         }
            // }
           
        
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
           
            $docx->setDefaultFont('Arial'); 
            $docx->replaceVariableByHTML('kejaksaan', 'inline','<h2 style="text-align: center;"><b><p>'.$kejaksaan.'</p></b></h2>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByHTML('lokasi', 'inline','<h2 style="text-align: center;"><b><p>'.$lokasi.'</p></b></h2>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByHTML('tempat', 'inline',$lokasi_uc, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByHTML('kejaksaan1', 'inline',$kejaksaan_uc, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByHTML('nomor', 'inline',$nomor, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByHTML('sifat', 'inline',$sifat, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByHTML('perihal', 'inline',$perihal, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByHTML('hari', 'inline',$hari, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByHTML('jam', 'inline',$jam, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false)); 
            // $docx->replaceVariableByHTML('zona', 'inline',$zona, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByHTML('tempatPanggilan', 'inline',$tempat, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByHTML('tanggalPanggilan', 'inline',$tgl_periksa, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByHTML('namaPemeriksa', 'inline',$nama_pemeriksaan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByHTML('pangkatPemeriksa', 'inline',$gol_pgkt, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByHTML('nipPemeriksa', 'inline',$nip_pemeriksaan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByHTML('jabatanPemeriksa', 'inline',$jabatan_pemeriksaan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByHTML('jabatanPenandatangan', 'inline',$jabatan_pnd, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByHTML('jabatan', 'inline',$jbtn_pnd, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByHTML('namaTandatangan', 'inline',$nama_pnd, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByHTML('nipTandatangan', 'inline',$nip_pnd, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByHTML('pangkat_ttd', 'inline',$pangkat_pnd, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByHTML('tembusan', 'block',$tmb, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByHTML('namaSaksi', 'block',$nama_saksi, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByHTML('lokasi_saksi', 'block',$lok_saksi, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByHTML('namaTerlapor', 'inline',$terlapor_1, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByHTML('uraianPermasalahan', 'inline',$uraian_permasalahan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByHTML('noSpWas', 'inline',$nomor_sp_was1, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByHTML('tglSpWas', 'inline',$tglSpWas, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByHTML('tanggal', 'inline',$tgl_was9, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByHTML('pejabatSpWas1', 'inline',$pejabatSpWas1, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
            $docx->replaceVariableByHTML('berkas', 'inline',$lampiran, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));

		// $no_register1 = str_replace("/","",$no_register);
        $docx->createDocx('template/pengawasan/was-9');
		
        $file = 'template/pengawasan/was-9.docx';

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