<?php
require_once('/wordtest/classes/CreateDocx.inc');

        $docx = new CreateDocxFromTemplate('../modules/pengawasan/template/was-11inspeksi.docx');
        $kejaksaan=strtoupper($data_satker['inst_nama']);
        // $kejaksaan1=ucwords($data_satker['inst_nama']);
        $lokasi_surat=ucwords(strtolower($data_satker['inst_lokinst']));
        $lokasi=strtoupper($data_satker['inst_lokinst']);
        /*permintaan kang putut lokasi harus ada spasi*/
        $x=strlen($lokasi);
        $lokasi1='';
        for ($i=0; $i <$x ; $i++) { 
            $lokasi1 .=$lokasi[$i].' ';
        }

        if($model['sifat_surat']=='0'){
            $sifat="Biasa";
            $akr="B";
         }else if($model['sifat_surat']=='1'){
            $sifat="Segera";
            $akr="S";
         }else if($model['sifat_surat']=='2'){
            $sifat="Rahasia";
            $akr="R";
         }

         $jml_lampiran=$model['lampiran_was11'];
         $perihal=$model['perihal'];
         
         $kepada=$model['kepada_was11'];

         $tempat_surat=$model['di_was11'];

        // $nm = explode(',', $modelterlapor['nama_pegawai_terlapor']);
        // $nama='';  
        // $nomor = 1;
        // for ($i=0; $i < count($nm) ; $i++) { 
        //    if(count($nm) <= 1){
        //       $terlapor_dugaan .= $nm[$i];
        //    }else{
        //       $terlapor_dugaan .= $nm[$i];
        //    }
        //  $nomor++;
        //  } 

        //  str_replace("#", ",");
         
         // if(count($modelterlapor['nama_pegawai_terlapor'])>1){
         //    $terlapor_dugaan=$modelterlapor['nama_pegawai_terlapor'];
         // }else{
         //    $terlapor_dugaan=$modelterlapor['nama_pegawai_terlapor'].' ,Dkk';
         // }

        $ter_dug=explode(',',$modelterlapor['nama_pegawai_terlapor']);
        $terlapor_dugaan = ' ';
        
        if(count($ter_dug)==1){
            for($i=0; $i<1; $i++){
                $terlapor_dugaan .= $ter_dug[$i];
            }
        }

        if(count($ter_dug)==2){
            for($i=0; $i<2; $i++){
                $terlapor_dugaan .= $ter_dug[$i].' dan';
            }
        }

        if(count($ter_dug)>2){
            for($i=0; $i<1; $i++){
                $terlapor_dugaan .=$ter_dug[$i].', dkk';
            }
        }
 
         $pejabat_sp_was=ucwords(strtolower($modelterlapor['jabatan_penandatangan']));
         $no_sp_was=$modelterlapor['nomor_sp_was2'];
         
         $no_was_11=$model['no_was_11'];

         $sts =(substr($model['status_penandatangan'],0,1));
         
         if($sts=='0'){ //jabatansebenernya
           $jabatanPenandatangan=$model['jabatan_penandatangan'].',';
           $jabatan='<p></p>';
           $namaTandatangan= $model['nama_penandatangan'];
           $nipTandatangan=$model['pangkat_penandatangan']. '  NIP. '.substr($model['nip_penandatangan'],0,8).' '.substr($model['nip_penandatangan'],8,6).' '.substr($model['nip_penandatangan'],14,1).' '.substr($model['nip_penandatangan'],15,3);
        }elseif($sts=='1'){ //AN
           $jabatanPenandatangan=$model['jabatan_penandatangan'].',';
           $jabatan=$model['jbtn_penandatangan'];
           $nipTandatangan= $model['pangkat_penandatangan']. '  NIP. '.substr($model['nip_penandatangan'],0,8).' '.substr($model['nip_penandatangan'],8,6).' '.substr($model['nip_penandatangan'],14,1).' '.substr($model['nip_penandatangan'],15,3);
           $namaTandatangan= $model['nama_penandatangan'];
        }elseif($sts=='2'||$sts=='3'){ //Plt&Plh
           $jabatanPenandatangan=$model['jabatan_penandatangan'].',';
           $jabatan='<p></p>';
           $namaTandatangan= $model['nama_penandatangan'];
           $nipTandatangan = $model['pangkat_penandatangan']. '  NIP. '.substr($model['nip_penandatangan'],0,8).' '.substr($model['nip_penandatangan'],8,6).' '.substr($model['nip_penandatangan'],14,1).' '.substr($model['nip_penandatangan'],15,3);
         }



        if($_GET['jns']=='Internal'){
        $saksi_in="";
        $no_saksi=1;
        $saksi_in .="<table style='font-family:arial;'>";
        foreach ($saksiIN as $rowsaksi) {
            $saksi_in .="<tr>
                        <td rowspan='4' style='vertical-align:top;'>".(count($saksiIN)>=2?$no_saksi:' ')."</td>
                            <td>Nama</td>
                            <td>:</td>
                            <td><b>".$rowsaksi['nama_saksi_internal']."</b></td>
                        </tr>
                        <tr>
                            <td>Pangkat/Gol.</td>
                            <td>:</td>
                            <td>".$rowsaksi['pangkat_saksi_internal']."</td>
                        </tr>
                        <tr>
                            <td>NIP/NRP</td>
                            <td>:</td>
                            <td>".substr($rowsaksi['nip_saksi_internal'],0,8).' '.substr($rowsaksi['nip_saksi_internal'],8,6).' '.substr($rowsaksi['nip_saksi_internal'],14,1).' '.substr($rowsaksi['nip_saksi_internal'],15,3).'/'.$rowsaksi['nrp_saksi_internal']."</td>
                        </tr>
                        <tr>
                            <td>Jabatan</td>
                            <td>:</td>
                            <td>".ucwords(strtolower($rowsaksi['jabatan_saksi_internal']))."</td>
                        </tr>
                        ";
            $no_saksi++;
        }
        $saksi_in .="</table>";
        }else{
            $saksi_in="<p></p>";
        }

        // print_r($saksi_in);
        // exit();

        if($_GET['jns']=='Eksternal'){
        $saksi_ek="";
        $no_saksi_ek=1;
        $saksi_ek .="<table style='font-family:arial;'>";
        foreach ($saksiEK as $rowsaksi_ek) {
            $saksi_ek .="<tr>
                            <td rowspan='2' style='vertical-align:top;'>".(count($saksiEK)>=2?$no_saksi_ek:' ')."</td>
                            <td>Nama</td>
                            <td>:</td>
                            <td><b>".$rowsaksi_ek['nama_saksi_eksternal']."</b></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td>".$rowsaksi_ek['alamat_saksi_eksternal']."</td>
                        </tr>
                        ";
            $no_saksi_ek++;
        }
        $saksi_ek .="</table>";
        }else{
            $saksi_ek="<p></p>";
        }
        // print_r($saksi_ek);
        // exit();
        $perihal_dugaan=$modelLapdu['perihal_lapdu'];






        /*tembusan waas11*/
        $tembusan="";
        $no_tembusan=1;
        $tembusan .="<table style='font-family:arial;'>";
        foreach ($tembusan_was11 as $rowTembusan) {
            $tembusan .="<tr>
                            <td>".(count($tembusan_was11)>=2?$no_tembusan:' ')."</td>
                            <td>".$rowTembusan['tembusan']."</td>
                        </tr>";
            $no_tembusan++;
        }
        $tembusan .="</table>";

        // print_r($tembusan);
        // exit();

        //$docx->setDefaultFont('Arial');
        $docx->replaceVariableByText(array('kejaksaan'=>strtoupper($kejaksaan)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('lokasi_surat'=>ucwords($lokasi_surat)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('lokasi'=>strtoupper($lokasi1)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('akr'=>$akr), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('sifat_surat'=>$sifat), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('jml_lampiran'=>$jml_lampiran), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('perihal'=>$perihal), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl_was_11'=>$tgl_was_11), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('no_was_11'=>$no_was_11), array('parseLineBreaks'=>true));

        $docx->replaceVariableByText(array('kepada'=>$kepada), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tempat_surat'=>$tempat_surat), array('parseLineBreaks'=>true));

        //$docx->replaceVariableByText(array('terlapor_dugaan'=>$terlapor_dugaan), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('perihal_dugaan'=>$perihal_dugaan), array('parseLineBreaks'=>true));

        $docx->replaceVariableByText(array('tanggalPanggilan'=>$tanggalPanggilan), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('pejabat_sp_was'=>$pejabat_sp_was), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('no_sp_was'=>$no_sp_was), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl_sp_was'=>$tgl_sp_was), array('parseLineBreaks'=>true));
      

        $docx->replaceVariableByHTML('saksiIn', 'block',$saksi_in, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('saksiEk', 'block',$saksi_ek, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('terlapor_dugaan', 'inline',$terlapor_dugaan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        
        // $docx->replaceVariableByHTML('jabatanPenandatangan', 'inline', $jabatanPenandatangan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByText(array('jabatanPenandatangan'=>$jabatanPenandatangan), array('parseLineBreaks'=>true));
        $docx->replaceVariableByHTML('jabatan', 'inline', $jabatan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('namaTandatangan', 'inline','<p style="font-family:arial;"><u>'. $namaTandatangan.'</u></p>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('nipTandatangan', 'inline','<p style="font-family:arial;">'. $nipTandatangan.'</p>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
      
        $docx->replaceVariableByHTML('tembusan', 'block',$tembusan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));

        $docx->createDocx('template/pengawasan/was-11inspeksi');
        
        $file = 'template/pengawasan/was-11inspeksi.docx';

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