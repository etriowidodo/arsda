<?php
require_once('/wordtest/classes/CreateDocx.inc');

        $docx = new CreateDocxFromTemplate('../modules/pengawasan/template/was-12.docx');
        $kejaksaan=strtoupper($data_satker['inst_nama']);
        // // $kejaksaan1=ucwords($data_satker['inst_nama']);
        $lokasi_surat=ucwords($data_satker['inst_lokinst']);
        $lokasi=strtoupper($data_satker['inst_lokinst']);
        // /*permintaan kang putut lokasi harus ada spasi*/
        $x=strlen($lokasi);
        $lokasi1='';
        for ($i=0; $i <$x ; $i++) { 
            $lokasi1 .=$lokasi[$i].' ';
        }

        if($was12['sifat_surat']=='1'){
            $sifat="Biasa";
            $akr="B";
         }else if($was12['sifat_surat']=='2'){
            $sifat="Segera";
            $akr="S";
         }else if($was12['sifat_surat']=='3'){
            $sifat="Rahasia";
            $akr="R";
         }

        // print_r($resultSpwas1);
        // print_r($tgl_sp_was);
        // exit();        
         $jml_lampiran=$was12['lampiran_was12'];
         $perihal=$was12['perihal_was12'];
         
         $kepada=$was12['kepada_was12'];

         $tempat_surat=$was12['di_was12'];

         
         


         $pejabat_sp_was=$resultSpwas1['jabatan_penandatangan'];
         $no_sp_was=$resultSpwas1['nomor_sp_was1'];


        //   if(count($modelterlapor[0]['nama_terlapor_awal'])>1){
        //     $nama_terlapor=$modelterlapor[0]['nama_terlapor_awal'];
        //  }else{
        //     $nama_terlapor=$modelterlapor[0]['nama_terlapor_awal'].' ,Dkk';
        //  }

        //  $pejabat_sp_was=$modelterlapor[0]['jabatan_penandatangan'];
        //  $no_sp_was=$modelterlapor[0]['nomor_sp_was1'];
         
         $no_surat=$was12['no_surat'];

         $sts =(substr($was12['status_penandatangan'],0,1));
         
         if($sts=='0'){ //jabatansebenernya
           $jabatanPenandatangan=$was12['jabatan_penandatangan'];
           $jabatan='<p></p>';
           $namaTandatangan= $was12['nama_penandatangan'];
           $nipTandatangan=$was12['pangkat_penandatangan']. '  NIP. '.substr($was12['nip_penandatangan'],0,8).' '.substr($was12['nip_penandatangan'],8,6).' '.substr($was12['nip_penandatangan'],14,1).' '.substr($was12['nip_penandatangan'],15,3);
        }elseif($sts=='1'){ //AN
           $jabatanPenandatangan=$was12['jabatan_penandatangan'];
           $jabatan=$was12['jbtn_penandatangan'];
           $nipTandatangan= $was12['pangkat_penandatangan']. '  NIP. '.substr($was12['nip_penandatangan'],0,8).' '.substr($was12['nip_penandatangan'],8,6).' '.substr($was12['nip_penandatangan'],14,1).' '.substr($was12['nip_penandatangan'],15,3);
           $namaTandatangan= $was12['nama_penandatangan'];
        }elseif($sts=='2'||$sts=='3'){ //Plt&Plh
           $jabatanPenandatangan=$was12['jabatan_penandatangan'];
           $jabatan='<p></p>';
           $namaTandatangan= $was12['nama_penandatangan'];
           $nipTandatangan=$was12['pangkat_penandatangan']. '  NIP. '.substr($was12['nip_penandatangan'],0,8).' '.substr($was12['nip_penandatangan'],8,6).' '.substr($was12['nip_penandatangan'],14,1).' '.substr($was12['nip_penandatangan'],15,3);
         }

 
        $terlapor="";
        $no_terlapor=1;
        $terlapor .="<table style='font-family: Arial'>";
        foreach ($terlapor_was12 as $rowterlapor) {
            $terlapor .="<tr>";
            if(count($terlapor_was12)>=2){
                $terlapor .="<td rowspan='4' style='vertical-align:top;'>".(count($terlapor_was12)>=2?$no_terlapor:' ')."</td>";
            }
               $terlapor .="<td>Nama</td>
                            <td>:</td>
                            <td><b>".$rowterlapor['nama_pegawai_terlapor']."</b></td>
                        </tr>
                        <tr>
                            <td>Pangkat/Gol.</td>
                            <td>:</td>
                            <td>".$rowterlapor['pangkat_pegawai_terlapor']."</td>
                        </tr>
                        <tr>
                            <td>NIP/NRP</td>
                            <td>:</td>
                            <td>".$rowterlapor['nip_pegawai_terlapor'].'/'.$rowterlapor['nrp_pegawai_terlapor']."</td>
                        </tr>
                        <tr>
                            <td>Jabatan</td>
                            <td>:</td>
                            <td>".ucwords(strtolower($rowterlapor['jabatan_pegawai_terlapor']))."</td>
                        </tr>
                        <br>
                        ";
            $no_terlapor++;
        }
        $terlapor .="</table>";
        // $pemeriksa_nama=($terlapor_was12['nama_pemeriksa']!=''?$terlapor_was12['nama_pemeriksa']:'<p></p>');
        // $pemeriksa_pangkat=($terlapor_was12['pangkat_pemeriksa'];!=''?$terlapor_was12['pangkat_pemeriksa'];:'<p></p>');
        // $pemeriksa_nip=$terlapor_was12['nip_pemeriksa'].'/'.$terlapor_was12['nrp_pemeriksa'];
        // $pemeriksa_jabatan=$terlapor_was12['jabatan_pemeriksa'];
        // $pemeriksa_jabatan=$terlapor_was12['jabatan_pemeriksa'];
        // $hari=$terlapor_was12['hari_pemeriksaan'];
        // $jam=substr($terlapor_was12['jam_pemeriksaan'], 0,5);
        // $tempat=$terlapor_was12['tempat_pemeriksaan'];
        // print_r($terlapor_was12[0]['nama_pemeriksa']);
        // exit();

        $pemeriksa1="";
        $no_pemeriksa=1;
        $pemeriksa1 .="<table style='font-family: Arial'>";
        foreach ($pemeriksa as $rowPemeriksa) {
            $pemeriksa1 .="<tr>";
            if(count($pemeriksa)>=2){
                $pemeriksa1 .="<td rowspan='8' style='vertical-align:top;'>".(count($pemeriksa)>=2?$no_pemeriksa:' ')."</td>";
            }
        // $pemeriksa .="<table style='font-family: Arial'>";
       
            $pemeriksa1 .="
                            <td>Nama</td>
                            <td>:</td>
                            <td><b>".$rowPemeriksa['nama_pemeriksa']."</b></td>
                        </tr>
                        <tr>
                            <td>Pangkat/Gol.</td>
                            <td>:</td>
                            <td>".$rowPemeriksa['pangkat_pemeriksa']."</td>
                        </tr>
                        <tr>
                            <td>NIP/NRP</td>
                            <td>:</td>
                            <td>".substr($rowPemeriksa['nip_pemeriksa'],0,8).' '.substr($rowPemeriksa['nip_pemeriksa'],8,6).' '.substr($rowPemeriksa['nip_pemeriksa'],14,1).' '.substr($rowPemeriksa['nip_pemeriksa'],15,3).'/'.$rowPemeriksa['nrp_pemeriksa']."</td>
                        </tr>
                        <tr>
                            <td>Jabatan</td>
                            <td>:</td>
                            <td>".ucwords(strtolower($rowPemeriksa['jabatan_pemeriksa']))."</td>
                        </tr>
                        <tr>
                            <td>Pada Hari</td>
                            <td>:</td>
                            <td>".$rowPemeriksa['hari_pemeriksaan']."</td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td>:</td>
                            <td>".\Yii::$app->globalfunc->ViewIndonesianFormat($rowPemeriksa['tanggal_pemeriksaan'])."</td>
                        </tr>
                        <tr>
                            <td>Jam </td>
                            <td>:</td>
                            <td>".substr($rowPemeriksa['jam_pemeriksaan'], 0,5)." </td>
                        </tr>
                        <tr>
                            <td>Tempat </td>
                            <td>:</td>
                            <td>".$rowPemeriksa['tempat_pemeriksaan']."</td>
                        </tr>
                        <br>
                        ";
            $no_pemeriksa++;
        }
        $pemeriksa1 .="</table>";
        
        $perihal_dugaan=$resultSpwas1['perihal_lapdu'];

        // /*tembusan waas12*/
        $tembusan="";
        $no_tembusan=1;
        $tembusan .="<table>";
        foreach ($tembusan_was12 as $rowTembusan) {
            $tembusan .="<tr>
                            <td>".(count($tembusan_was12)>=2?$no_tembusan:' ')."</td>
                            <td>".$rowTembusan['tembusan']."</td>
                        </tr>";
            $no_tembusan++;
        }
        $tembusan .="</table>";


        $docx->setDefaultFont('Arial');
        $docx->replaceVariableByText(array('kejaksaan'=>strtoupper($kejaksaan)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('lokasi_surat'=>ucwords(strtolower($lokasi_surat))), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('lokasi'=>strtoupper($lokasi1)), array('parseLineBreaks'=>true));
        // $docx->replaceVariableByText(array('akr'=>$akr), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('sifat_surat'=>$sifat), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('jml_lampiran'=>$jml_lampiran), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('perihal'=>$perihal), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl_was_12'=>$tgl_was_12), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('no_surat'=>$no_surat), array('parseLineBreaks'=>true));

        $docx->replaceVariableByText(array('kepada'=>$kepada), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tempat_surat'=>$tempat_surat), array('parseLineBreaks'=>true));

        // $docx->replaceVariableByText(array('terlapor_dugaan'=>$nama_terlapor), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('perihal_dugaan'=>$perihal_dugaan), array('parseLineBreaks'=>true));

        $docx->replaceVariableByText(array('pemeriksa_nama'=>$pemeriksa_nama), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('pemeriksa_pangkat'=>$pemeriksa_pangkat), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('pemeriksa_nip'=>$pemeriksa_nip), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('pemeriksa_jabatan'=>$pemeriksa_jabatan), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('hari'=>$hari), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tanggalpemeriksaan'=>$tanggal), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('jam'=>$jam), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tempat'=>$tempat), array('parseLineBreaks'=>true));
        

        $docx->replaceVariableByText(array('pejabat_sp_was'=>$pejabat_sp_was), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('no_sp_was'=>$no_sp_was), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl_sp_was'=>$tgl_sp_was), array('parseLineBreaks'=>true));

        // $docx->replaceVariableByText(array('tanggalPanggilan'=>$tanggalPanggilan), array('parseLineBreaks'=>true));
        // $docx->replaceVariableByText(array('pejabat_sp_was'=>$pejabat_sp_was), array('parseLineBreaks'=>true));
        // $docx->replaceVariableByText(array('no_sp_was'=>$no_sp_was), array('parseLineBreaks'=>true));
        // $docx->replaceVariableByText(array('tgl_sp_was'=>$tgl_sp_was), array('parseLineBreaks'=>true));
      

        $docx->replaceVariableByHTML('terlapor', 'block',$terlapor, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('pemeriksa', 'block',$pemeriksa1, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        // $docx->replaceVariableByHTML('saksiEk', 'block',$saksi_ek, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        
        $docx->replaceVariableByHTML('jabatanPenandatangan', 'inline', $jabatanPenandatangan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('jabatan', 'inline', $jabatan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('namaTandatangan', 'inline','<u>'. $namaTandatangan.'</u>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('nipTandatangan', 'inline', $nipTandatangan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
      
        $docx->replaceVariableByHTML('tembusan', 'block',$tembusan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));

        $docx->createDocx('template/pengawasan/was-12');
        
        $file = 'template/pengawasan/was-12.docx';

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