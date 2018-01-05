<?php
require_once('/wordtest/classes/CreateDocx.inc');

        $docx = new CreateDocxFromTemplate('../modules/pengawasan/template/was-12-inspeksi.docx');
        $kejaksaan=strtoupper($data_satker['inst_nama']);
        $kejaksaan1=ucwords($data_satker['inst_nama']);
        $lokasi=strtoupper($data_satker['inst_lokinst']);
        /*permintaan kang putut lokasi harus ada spasi*/
        $x=strlen($lokasi);
        $lokasi1='';
        for ($i=0; $i <$x ; $i++) { 
            $lokasi1 .=$lokasi[$i].' ';
        }

        

        $lokasi_surat=ucwords($data_satker['inst_lokinst']);
        /*nomor was-9*/
        $nomor=$was12['no_surat_was12'];

        /*sifat surat*/
        if($was12['sifat_surat']=='0'){
            $sifat="Biasa";
            $akr="B";
         }else if($was12['sifat_surat']=='1'){
            $sifat="Segera";
            $akr="S";
         }else if($was12['sifat_surat']=='2'){
            $sifat="Rahasia";
            $akr="R";
         }

        $jml_lampiran=$was12['lampiran_was12'];
        
        /*berkas Surat*/
        $berkas=$was12['perihal_was12'];
        
        $kepada=$was12['kepada_was12'];

        $tempat_surat=$data_satker['inst_lokinst'];

        /*tempat*/
        $tempat=$model['inst_lokinst'];


        /*nama saksi*/
        $namaSaksi=$modelSaksi['nama_saksi'];
        
        /*lokasi*/
        $lokasi_saksi=$modelSaksi['lokasi_saksi'];

// print_r($lokasi_saksi);
// exit();
        /*hari*/
        $hari=$modelSaksi['hari_pemeriksaan_was9'];

        /*jam*/
        if($model['zona']=='0'){
            $zona_waktu='WIB';
        }else if ($model['zona']=='1') {
            $zona_waktu='WITA';
        }else if($model['zona']=='2'){
            $zona_waktu='WTA';
        }
        
        // $jam= substr($model['jam_pemeriksaan_was9'], 0,5).' '.$zona_waktu;

        /*tempat Panggilan*/
        // $tempatPanggilan=$model['tempat_pemeriksaan_was9'];

        /*nama Pemeriksa*/
        // $namaPemeriksa=$modelPemeriksa['nama_pemeriksa'];

        // /*pangkat Pemeriksa*/
        // $pangkatPemeriksa=$modelPemeriksa['pangkat_pemeriksa'];

        /*pangkat Pemeriksa*/
        // $nipPemeriksa=substr($modelPemeriksa['nip'],0,8).' '.substr($modelPemeriksa['nip'],8,6).' '.substr($modelPemeriksa['nip'],14,1).' '.substr($modelPemeriksa['nip'],15,3).($modelPemeriksa['nrp']!=''?'/':' ').$modelPemeriksa['nrp'];

        /*pangkat Pemeriksa*/
        $jabatanPemeriksa=ucwords(strtolower($modelPemeriksa['jabatan_pemeriksa']));

        /*nama Terlapor*/
        $no_terlapr=1;
        $terlapor .="<table style='font-family:Arial;'>";
            foreach ($terlapor_was12 as $rowTerlapor) {
                $terlapor .="<tr style='height: 30px; vertical-align:bottom; '>
                                <td style='vertical-align:bottom;'>".(count($terlapor_was12)>=2?$no_terlapr:' ')."</td> 
                                <td>Nama Terlapor</td>
                                <td>:</td>
                                <td>".$rowTerlapor['nama_pegawai_terlapor']."</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Pangkat</td>
                                <td>:</td>
                                <td>".$rowTerlapor['pangkat_pegawai_terlapor']."</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>NIP/NRP</td>
                                <td>:</td>
                                <td><b>".$rowTerlapor['nip_pegawai_terlapor'].($rowTerlapor['nip_pegawai_terlapor']!=''?'/'.$rowTerlapor['nrp_pegawai_terlapor']:'')."</b></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Golongan</td>
                                <td>:</td>
                                <td>".$rowTerlapor['golongan_pegawai_terlapor']."</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Jabatan</td>
                                <td>:</td>
                                <td>".ucwords(strtolower($rowTerlapor['jabatan_pegawai_terlapor']))."</td>
                            </tr>";
                $no_terlapr++;
            }
        $terlapor .="</table>";

        $no_pemeriksa=1;
        $pemeriksa .="<table style='font-family:Arial;'>";
            foreach ($pemeriksa_was12 as $rowPemeriksa) {
                $pemeriksa .="<tr style='height: 30px; vertical-align:bottom; '>
                                <td style='vertical-align:bottom;'>".(count($pemeriksa_was12)>=2?$no_pemeriksa:' ')."</td>
                                <td>Nama Terlapor</td>
                                <td>:</td>
                                <td>".$rowPemeriksa['nama_pemeriksa']."</td>
                            </tr>
                            <tr>
                                <td></td> 
                                <td>NIP/NRP</td>
                                <td>:</td>
                                <td><b>".$rowPemeriksa['nip_pemeriksa'].($rowPemeriksa['nip_pemeriksa']!=''?'/'.$rowPemeriksa['nrp_pemeriksa']:'')."</b></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Pangkat</td>
                                <td>:</td>
                                <td>".$rowPemeriksa['pangkat_pemeriksa']."</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Golongan</td>
                                <td>:</td>
                                <td>".$rowPemeriksa['golongan_pemeriksa']."</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Jabatan</td>
                                <td>:</td>
                                <td>".ucwords(strtolower($rowPemeriksa['jabatan_pemeriksa']))."</td>
                            </tr>";
                $no_pemeriksa++;
            }
        $pemeriksa .="</table>";
        // echo $terlapor;
        // print_r($resultSpwas1);
        // exit();

        /*pejabatSpWas1*/
        $perihal_dugaan=$resultSpwas1['perihal_lapdu'];

        /*Pejabat*/
        $pejabat_sp_was=ucwords(strtolower($resultSpwas1['jabatan_penandatangan']));

        /*nomor spwas1*/
        $no_sp_was=$resultSpwas1['nomor_sp_was2'];

        /*pimpinan*/
        // $pimpinan=$model['jabatan_penandatangan'];

        $jabatanPenandatangan=$was12['jabatan_penandatangan'].',';
        $jabatan=(substr($was12['jbtn_penandatangan'],0,2)=='An'?$was12['jbtn_penandatangan']:'');
        $namaTandatangan=$was12['nama_penandatangan'];
        $nipTandatangan=$was12['pangkat_penandatangan']. '  NIP. '.substr($was12['nip_penandatangan'],0,7).' '.substr($was12['nip_penandatangan'],8,6).' '.substr($was12['nip_penandatangan'],14,1).' '.substr($was12['nip_penandatangan'],15,3);




        /*tembusan spwas1*/
        $tembusan="";
        $no_tembusan=1;
        $tembusan .="<table style='font-family:Arial;'>";
        foreach ($tembusan_was12 as $rowTembusan) {
            $tembusan .="<tr>
                            <td>".(count($tembusan_was12)>=2?$no_tembusan:' ')."</td>
                            <td>".$rowTembusan['tembusan']."</td>
                        </tr>";
            $no_tembusan++;
        }
        $tembusan .="</table>";

        // print_r($tembusan);
        // exit();
        
        $docx->setDefaultFont('Arial');
        $docx->replaceVariableByText(array('kejaksaan'=>strtoupper($kejaksaan)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('kejaksaan1'=>ucwords($kejaksaan1)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('lokasi'=>strtoupper($lokasi1)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('lokasi_surat'=>ucwords(strtolower($lokasi_surat))), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('akr'=>$akr), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('no_surat'=>$nomor), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('sifat_surat'=>$sifat), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('perihal'=>$berkas), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tempat'=>$tempat), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl_was_12'=>$tanggal), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('namaSaksi'=>$namaSaksi), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('hari'=>$hari), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tanggalPanggilan'=>$tanggalPanggilan), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('jam'=>$jam), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tempatPanggilan'=>$tempatPanggilan), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('jml_lampiran'=>$jml_lampiran), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('kepada'=>$kepada), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tempat_surat'=>$tempat_surat), array('parseLineBreaks'=>true));

        $docx->replaceVariableByText(array('namaPemeriksa'=>$namaPemeriksa), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('pangkatPemeriksa'=>$pangkatPemeriksa), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('nipPemeriksa'=>$nipPemeriksa), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('jabatanPemeriksa'=>$jabatanPemeriksa), array('parseLineBreaks'=>true));
        
        $docx->replaceVariableByText(array('no_sp_was'=>$no_sp_was), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('perihal_dugaan'=>$perihal_dugaan), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('pejabat_sp_was'=>$pejabat_sp_was), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl_sp_was'=>$tgl_sp_was), array('parseLineBreaks'=>true));
        
        $docx->replaceVariableByText(array('jabatanPenandatangan'=>$jabatanPenandatangan), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('jabatan'=>$jabatan), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('namaTandatangan'=>$namaTandatangan), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('nipTandatangan'=>$nipTandatangan), array('parseLineBreaks'=>true));

        $docx->replaceVariableByHTML('terlapor', 'block', $terlapor, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));

        $docx->replaceVariableByHTML('pemeriksa', 'block', $pemeriksa, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));

        $docx->replaceVariableByHTML('lokasi_saksi', 'inline', '<b>'.$lokasi_saksi.'</b>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        
        // $docx->replaceVariableByText(array('lokasi_saksi'=>$lokasi_saksi, array('parseLineBreaks'=>true));


        // $docx->replaceVariableByText(array('noSpWas'=>$noSpWas), array('parseLineBreaks'=>true));
        // $docx->replaceVariableByText(array('tglSpWas'=>$tglSpWas), array('parseLineBreaks'=>true));
        

        // $docx->replaceVariableByHTML('jabatanPenandatangan', 'inline', $jabatanPenandatangan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        // $docx->replaceVariableByHTML('jabatan', 'inline', $jabatan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        // $docx->replaceVariableByHTML('namaTandatangan', 'inline','<u>'. $namaTandatangan.'</u>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        // $docx->replaceVariableByHTML('nipTandatangan', 'inline', $nipTandatangan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
      
        $docx->replaceVariableByHTML('tembusan', 'block',$tembusan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));

        $docx->createDocx('template/pengawasan/was-12-inspeksi');
		
        $file = 'template/pengawasan/was-12-inspeksi.docx';

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