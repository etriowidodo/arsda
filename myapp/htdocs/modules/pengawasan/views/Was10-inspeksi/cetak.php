<?php
require_once('/wordtest/classes/CreateDocx.inc');

        $docx = new CreateDocxFromTemplate('../modules/pengawasan/template/was-10-inspeksi.docx');
        $kejaksaan=strtoupper($data_satker['inst_nama']);
        $kejaksaan1=ucwords($data_satker['inst_nama']);
        $lokasi=strtoupper($data_satker['inst_lokinst']);
        $lokasi_surat=ucwords(strtolower($data_satker['inst_lokinst']));
         /*permintaan kang putut lokasi harus ada spasi*/
        $x=strlen($lokasi);
        $lokasi_surat1='';
        for ($i=0; $i <$x ; $i++) { 
            $lokasi_surat1 .=$lokasi[$i].' ';
        }


         /*nomor was-10*/
        $no_was_10=$model['no_surat'];

         /*sifat surat*/
        if($model['sifat_surat']==0){
        $sifat_surat="BIASA";
        }else if($model['sifat_surat']=='1'){
        $sifat_surat="SEGERA";
        }else if($model['sifat_surat']=='2'){
        $sifat_surat="RAHASIA";
        }
        
         /*berkas Surat*/
        $jml_lampiran=$model['was10_lampiran'];

         /*berkas Surat*/
        $perihal=$model['was10_perihal'];

         /*kepada*/
        $kepada=$model['nama_pegawai_terlapor'];

          /*tempat_surat*/
        $tempat_surat=$model['di_was10'];


        /*hari*/
        $hari=$model['hari_pemeriksaan_was10'];

//         /*jam*/
            if($model['zona_waktu']=='0'){
                $zona_waktu='WIB';
            }else if ($model['zona_waktu']=='1') {
                $zona_waktu='WITA';
            }else if($model['zona_waktu']=='2'){
                $zona_waktu='WTA';
            }
            
        $jam= substr($model['jam_pemeriksaan_was10'], 0,5).' '.$zona_waktu;

//         /*tempat Panggilan*/
        $tempatPanggilan=$model['tempat_pemeriksaan_was10'];

//         /*nama Pemeriksa*/
        $pemeriksa_nama=$model['nama_pemeriksa'];
        

//         /*pangkat Pemeriksa*/
        $pemeriksa_pangkat=$model['pangkat_pemeriksa'];


//         /*nip Pemeriksa*/
        $pemeriksa_nip=substr($model['nip_pemeriksa'],0,8).' '.substr($model['nip_pemeriksa'],8,6).' '.substr($model['nip_pemeriksa'],14,1).' '.substr($model['nip_pemeriksa'],15,3).($modelPemeriksa['nrp_pemeriksa']!=''?'/':' ').$modelPemeriksa['nrp_pemeriksa'];
        
            /*nrp Pemeriksa*/
        $pemeriksa_nrp=$pemeriksa['peg_nrp'];

//         /*jabatan Pemeriksa*/
        $pemeriksa_jabatan=$model['jabatan_pemeriksa'];

//         /*nama Terlapor*/
        // $terlapor_dugaan=$terlapor['nama_pegawai_terlapor'];
        $ter_dug=explode(',',$terlapor['nama_pegawai_terlapor']);
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

//         /*pejabatSpWas1*/
        $no_sp_was=$sp_was_1['nomor_sp_was2'];

//         /*jabatan_penandatangan*/
        $pejabat_sp_was=ucwords(strtolower($sp_was_1['jabatan_penandatangan']));
        // print_r($tgl_sp_was);

//         /*$tgl_sp_was*/
        $perihal_dugaan=$lapdu['perihal_lapdu'];
        

        // $sts =(substr($model['status_penandatangan'],0,1));
        
        
        // if($sts=='0'){ //jabatansebenernya
        //     $jabatanPenandatangan=$model['jabatan_penandatangan'];
        //     $jabatan= '<p></p>';
        //     $namaTandatangan= $model['nama_penandatangan'];
        //     $nipTandatangan= $model['pangkat_penandatangan']. '  NIP. '.substr($model['nip_penandatangan'],0,7).' '.substr($model['nip_penandatangan'],8,6).' '.substr($model['nip_penandatangan'],14,1).' '.substr($model['nip_penandatangan'],15,3);
        //     // $pimpinan=$model['jbtn_penandatangan'];
        // }elseif($sts=='1'){ //AN
        //     $jabatanPenandatangan= $model['jabatan_penandatangan'];
        //     $jabatan=$model['jbtn_penandatangan'];
        //     $nipTandatangan= $model['pangkat_penandatangan']. '  NIP. '.substr($model['nip_penandatangan'],0,7).' '.substr($model['nip_penandatangan'],8,6).' '.substr($model['nip_penandatangan'],14,1).' '.substr($model['nip_penandatangan'],15,3);
        //     $namaTandatangan= $model['nama_penandatangan'];
        //     // $pimpinan=$model['jbtn_penandatangan'];
        // }elseif($sts=='2'||$sts=='3'){ //Plt&Plh
        //     $jabatanPenandatangan= $model['jabatan_penandatangan'];
        //     $jabatan= '<p></p>';
        //     $namaTandatangan=  $model['nama_penandatangan'];
        //     $nipTandatangan= $model['pangkat_penandatangan']. '  NIP. '.substr($model['nip_penandatangan'],0,7).' '.substr($model['nip_penandatangan'],8,6).' '.substr($model['nip_penandatangan'],14,1).' '.substr($model['nip_penandatangan'],15,3);
        //     // $pimpinan= $model['jbtn_penandatangan'];
        //     }

        $jabatanPenandatangan=$model['jabatan_penandatangan'];
        

            $jabatan= '<p></p>';
            $namaTandatangan= $model['nama_penandatangan'];
            $nipTandatangan= $model['pangkat_penandatangan']. '  NIP. '.substr($model['nip_penandatangan'],0,7).' '.substr($model['nip_penandatangan'],8,6).' '.substr($model['nip_penandatangan'],14,1).' '.substr($model['nip_penandatangan'],15,3);


//         /*noSpWas1*/
//         $noSpWas=$sp_was_1[0]['nomor_sp_was1'];



//         /*tembusan spwas1*/
        $tembusan="";
        $no_tembusan=1;
        $tembusan .="<table style='font-family:arial;'>";
        foreach ($tembusan_was10 as $rowTembusan) {
            $tembusan .="<tr>
                            <td>".(count($tembusan_was10)>=2?$no_tembusan:' ')."</td>
                            <td>".$rowTembusan['tembusan']."</td>
                        </tr>";
            $no_tembusan++;
        }
        $tembusan .="</table>";
        

        $docx->setDefaultFont('Arial');
        $docx->replaceVariableByText(array('kejaksaan'=>strtoupper($kejaksaan)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('kejaksaan1'=>ucwords(strtolower($kejaksaan1))), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('lokasi_surat'=>$lokasi_surat), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('lokasi_surat1'=>strtoupper($lokasi_surat1)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('no_was_10'=>$no_was_10), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('sifat_surat'=>$sifat_surat), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('jml_lampiran'=>$jml_lampiran), array('parseLineBreaks'=>true));
        // $docx->replaceVariableByText(array('tempat'=>$tempat), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('perihal'=>$perihal), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tanggal_was_10'=>$tanggal_was_10), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('kepada'=>$kepada), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tempat_surat'=>$tempat_surat), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('hari'=>$hari), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tanggalpemeriksaan'=>$tanggal), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('jam'=>$jam), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tempat'=>$tempatPanggilan), array('parseLineBreaks'=>true));

        $docx->replaceVariableByText(array('pemeriksa_nama'=>$pemeriksa_nama), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('pemeriksa_pangkat'=>$pemeriksa_pangkat), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('pemeriksa_nip'=>$pemeriksa_nip), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('pemeriksa_nrp'=>$pemeriksa_nrp), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('pemeriksa_jabatan'=>ucwords(strtolower($pemeriksa_jabatan))), array('parseLineBreaks'=>true));
        
        $docx->replaceVariableByText(array('terlapor_dugaan'=>$terlapor_dugaan), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('perihal_dugaan'=>$perihal_dugaan), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('pejabat_sp_was'=>$pejabat_sp_was), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('no_sp_was'=>$no_sp_was), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl_sp_was'=>$tgl_sp_was), array('parseLineBreaks'=>true));


        $docx->replaceVariableByText(array('jabatanPenandatangan'=>$jabatanPenandatangan), array('parseLineBreaks'=>true));
        // $docx->replaceVariableByHTML('jabatanPenandatangan', 'inline', ucwords(strtolower($jabatanPenandatangan))), array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('jabatan', 'inline', $jabatan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('namaTandatangan', 'inline','<u style="font-family:arial;">'. $namaTandatangan.'</u>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('nipTandatangan', 'inline','<p style="font-family:arial;">'. $nipTandatangan.'</p>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
      
        $docx->replaceVariableByHTML('tembusan', 'block',$tembusan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));

        $docx->createDocx('template/pengawasan/was-10-inspeksi');
		
        $file = 'template/pengawasan/was-10-inspeksi.docx';

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