<?php
require_once('/wordtest/classes/CreateDocx.inc');

        $docx = new CreateDocxFromTemplate('../modules/pengawasan/template/lwas2.docx');
        $kejaksaan=strtoupper($data_satker['inst_nama']);
//         $kejaksaan1=ucwords($data_satker['inst_nama']);
 //       $lokasi=strtoupper($data_satker['inst_lokinst']);
//         $lokasi_surat=ucwords($data_satker['inst_lokinst']);
//          /*permintaan kang putut lokasi harus ada spasi*/
        // $x=strlen($lokasi);
        // $lokasi_surat1='';
        // for ($i=0; $i <$x ; $i++) { 
        //     $lokasi_surat1 .=$lokasi[$i].' ';
        // }


        /*tempat Panggilan*/
        $tempat=$model['tempat_l_was_2'];

        /*Isi Permasalahan*/
        $isiP=$model['isi_permasalahan'];
        /*Isi Data*/
        $isiD=$model['isi_data'];
        /*Isi Analisa*/
        $isiA=$model['isi_analisa'];
        /*Isi Kesimpulan*/
        $isiK=$model['isi_kesimpulan'];
        /*Isi Pertimbangan*/
        $isiPT=$model['isi_pertimbangan'];
     
        /*tanggal BAwas3*/
    //    $tanggal=$tgl_bawas3;

        /*-----------------------------------tandatangan----------------------------------*/
        // /*nip Terlapor*/
        // $nip_terlapor=substr($modelyg_diperiksa['nip_pegawai_terlapor'],0,8).' '.substr($modelyg_diperiksa['nip_pegawai_terlapor'],8,6).' '.substr($modelyg_diperiksa['nip_pegawai_terlapor'],14,1).' '.substr($modelyg_diperiksa['nip_pegawai_terlapor'],15,3).($modelyg_diperiksa['nrp_pegawai_terlapor']!=''?'/':' ').$modelyg_diperiksa['nrp_pegawai_terlapor'];


        // /*nama terlapor*/
        // $nama_terlapor=$modelyg_diperiksa['nama_pegawai_terlapor'];


        // /*nip pemeriksa ttd*/
        // $nipttd=substr($modelyg_memeriksa['nip_pemeriksa'],0,8).' '.substr($modelyg_memeriksa['nip_pemeriksa'],8,6).' '.substr($modelyg_memeriksa['nip_pemeriksa'],14,1).' '.substr($modelyg_memeriksa['nip_pemeriksa'],15,3).($modelyg_memeriksa['nrp_pemeriksa']!=''?'/':' ').$modelyg_memeriksa['nrp_pemeriksa'];

        // /*nama pemriksa ttd*/
        // $namattd=$modelyg_memeriksa['nama_pemeriksa'];

        // /*pangkat tpemeriksa ttd*/
        // $pangkatttd=$modelyg_memeriksa['pangkat_pemeriksa'];
        /*-----------------------------end tandatangan-----------------------------------*/



        /*noSpWas1*/
        $no_sp_was_2=$modelSpWas2['nomor_sp_was2'];

        /*jabatan_penandatangan*/
        $pejabat_sp_was_2=$modelSpWas2['jabatan_penandatangan'];
        // print_r($tgl_sp_was);

        /*$tgl_sp_was*/
       $tgl_sp_was_2=$tgl_spwas2;
        
       // echo $modelSpWas2;
       // exit();
//         // $sts =(substr($model['status_penandatangan'],0,1));
        
        
//         // if($sts=='0'){ //jabatansebenernya
//         //     $jabatanPenandatangan=$model['jabatan_penandatangan'];
//         //     $jabatan= '<p></p>';
//         //     $namaTandatangan= $model['nama_penandatangan'];
//         //     $nipTandatangan= $model['pangkat_penandatangan']. '  NIP. '.substr($model['nip_penandatangan'],0,7).' '.substr($model['nip_penandatangan'],8,6).' '.substr($model['nip_penandatangan'],14,1).' '.substr($model['nip_penandatangan'],15,3);
//         //     // $pimpinan=$model['jbtn_penandatangan'];
//         // }elseif($sts=='1'){ //AN
//         //     $jabatanPenandatangan= $model['jabatan_penandatangan'];
//         //     $jabatan=$model['jbtn_penandatangan'];
//         //     $nipTandatangan= $model['pangkat_penandatangan']. '  NIP. '.substr($model['nip_penandatangan'],0,7).' '.substr($model['nip_penandatangan'],8,6).' '.substr($model['nip_penandatangan'],14,1).' '.substr($model['nip_penandatangan'],15,3);
//         //     $namaTandatangan= $model['nama_penandatangan'];
//         //     // $pimpinan=$model['jbtn_penandatangan'];
//         // }elseif($sts=='2'||$sts=='3'){ //Plt&Plh
//         //     $jabatanPenandatangan= $model['jabatan_penandatangan'];
//         //     $jabatan= '<p></p>';
//         //     $namaTandatangan=  $model['nama_penandatangan'];
//         //     $nipTandatangan= $model['pangkat_penandatangan']. '  NIP. '.substr($model['nip_penandatangan'],0,7).' '.substr($model['nip_penandatangan'],8,6).' '.substr($model['nip_penandatangan'],14,1).' '.substr($model['nip_penandatangan'],15,3);
//         //     // $pimpinan= $model['jbtn_penandatangan'];
//         //     }

//         $jabatanPenandatangan=$model['jabatan_penandatangan'];
//             $jabatan= '<p></p>';
//             $namaTandatangan= $model['nama_penandatangan'];
//             $nipTandatangan= $model['pangkat_penandatangan']. '  NIP. '.substr($model['nip_penandatangan'],0,7).' '.substr($model['nip_penandatangan'],8,6).' '.substr($model['nip_penandatangan'],14,1).' '.substr($model['nip_penandatangan'],15,3);


// //         /*noSpWas1*/
// //         $noSpWas=$sp_was_1[0]['nomor_sp_was1'];


        /*Pemriksa*/
        $pemeriksa="";
        $noP=1;
        $pemeriksa .="<table width='100%' style='font-family:Arial;'>";
        // echo count($modelPemriksa);
        // exit();
        if(count($modelPemriksa) >1){
                $no_pemeriksa = $noP;
            }else{
                $no_pemeriksa = ' ';
            }
        foreach ($modelPemriksa as $rowPemeriksa) {
            $pemeriksa .="<tr>
                            <td width='5%'>".$no_pemeriksa."</td>
                            <td width='30%'>Nama</td>
                            <td width='2%'>:</td>
                            <td>".$rowPemeriksa['nama_pemeriksa']."</td>
                          </tr>
                           <tr>
                            <td width='5%'></td>
                            <td width='30%'>Pangkat</td>
                            <td width='2%'>:</td>
                            <td>".$rowPemeriksa['pangkat_pemeriksa'].' ('.$rowPemeriksa['golongan_pemeriksa'].')'."</td>
                          </tr>
                          <tr>
                            <td width='5%'></td>
                            <td width='30%'>NIP/NRP</td>
                            <td width='2%'>:</td>
                            <td>".$rowPemeriksa['nip_pemeriksa'].($rowPemeriksa['nrp_pemeriksa']==''?'':'/'.$rowPemeriksa['nrp_pemeriksa'])."</td>
                          </tr>
                          <tr>
                            <td width='5%'></td>
                            <td width='30%'>Jabatan</td>
                            <td width='2%'>:</td>
                            <td>".ucwords(strtolower($rowPemeriksa['jabatan_pemeriksa']))."</td>
                          </tr>
                          <tr>
                            <td width='5%'></td>
                            <td width='30%'></td>
                            <td width='2%'></td>
                            <td></td>
                          </tr>";
            $no_pemeriksa++;
        }
        $pemeriksa .="</table>";
        /*
                          <tr>
                            <td width='5%'></td>
                            <td width='30%'>Golongan Pemeriksa</td>
                            <td width='2%'>:</td>
                            <td></td>
                          </tr>
                         */

        /*Terlapor*/
        $terlapor="";
        $noT=1;
        $terlapor .="<table width='100%' style='font-family:Arial;'>";
         if(count($modelTerlapor) >1){
                $no_terlapor = $noT;
            }else{
                $no_terlapor = ' ';
            }
        foreach ($modelTerlapor as $rowTerlapor) {
            $terlapor .="<tr>
                            <td width='5%'>".$no_terlapor."</td>
                            <td width='30%'>Nama</td>
                            <td width='2%'>:</td>
                            <td>".$rowTerlapor['nama_pegawai_terlapor']."</td>
                          </tr>
                          <tr>
                            <td width='5%'></td>
                            <td width='30%'>Pangkat</td>
                            <td width='2%'>:</td>
                            <td>".$rowTerlapor['pangkat_pegawai_terlapor'].' ('.$rowTerlapor['golongan_pegawai_terlapor'].')'."</td>
                          </tr>
                          <tr>
                            <td width='5%'></td>
                            <td width='30%'>NIP/NRP</td>
                            <td width='2%'>:</td>
                            <td>".$rowTerlapor['nip_pegawai_terlapor'].($rowTerlapor['nrp_pegawai_terlapor']==''?'':'/'.$rowTerlapor['nrp_pegawai_terlapor'])."</td>
                          </tr>
                          <tr>
                            <td width='5%'></td>
                            <td width='30%'>Jabatan</td>
                            <td width='2%'>:</td>
                            <td>".ucwords(strtolower($rowTerlapor['jabatan_pegawai_terlapor']))."</td>
                          </tr>
                          <tr>
                            <td width='5%'></td>
                            <td width='30%'></td>
                            <td width='2%'></td>
                            <td></td>
                          </tr>";

            $no_terlapor++;
        }
        $terlapor .="</table>";



        $pendapat="";
        $noPd=1;
        $pendapat .="<table width='100%' style='font-family:Arial;'>";
            if(count($modelDetilP) >1){
                $no_pendapat = $noPd;
            }else{
                $no_pendapat = ' ';
            }
        foreach ($modelDetilP as $rowDetil) {
            if($rowDetil['pendapat_l_was_2'] <> 1){
                $pendapat .="<tr>
                                <td width='5%' style='vertical-align:top'>".$no_pendapat."</td>
                                <td width='95%' align='justify'> terlapor ".$rowDetil['nama_terlapor']."
                                    pangkat (Gol) ".$rowDetil['pangkat_terlapor']." (".$rowDetil['golongan_terlapor'].")
                                    NIP/NRP. ".$rowDetil['nip_terlapor'].($rowDetil['nrp_terlapor']==''?'':'/'.$rowDetil['nrp_terlapor'])."
                                    jabatan ".ucwords(strtolower($rowDetil['jabatan_terlapor'])).", tidak terbukti melakukan pelanggaran disiplin.
                                </td>
                            </tr>
                            ";    
            }else{
            $pendapat .="<tr>
                                <td width='5%' style='vertical-align:top'>".$no_pendapat."</td>
                                <td width='95%' align='justify'>terlapor ".$rowDetil['nama_terlapor']."
                                    pangkat (Gol) ".$rowDetil['pangkat_terlapor']." (".$rowDetil['golongan_terlapor'].")
                                    NIP/NRP. ".$rowDetil['nip_terlapor'].($rowDetil['nrp_terlapor']==''?'':'/'.$rowDetil['nrp_terlapor'])."
                                    jabatan ".ucwords(strtolower($rowDetil['jabatan_terlapor'])).", 
                                    terbukti melakukan pelanggaran disiplin yaitu ".$rowDetil['isi_sk']." 
                                    melanggar pasal ".$rowDetil['pasal'].".
                                </td>
                            </tr>
                        ";
           }
            $no_pendapat++;
        }
        $pendapat .="</table>";


        $saran="";
        $noSr=1;
        $saran .="<table width='100%' style='font-family:Arial;'>";
            if(count($modelDetilP) >1){
                $no_saran = $noSr;
            }else{
                $no_saran = ' ';
            }
        foreach ($modelDetilP as $rowDetil) {
            if($rowDetil['saran_l_was_2'] <> 1){
                $saran .="<tr>
                                <td width='5%' style='vertical-align:top'>".$no_saran."</td>
                                <td width='95%' align='justify'>Terhadap terlapor ".$rowDetil['nama_terlapor']."
                                    pangkat (Gol) ".$rowDetil['pangkat_terlapor']." (".$rowDetil['golongan_terlapor'].")
                                    NIP/NRP. ".$rowDetil['nip_terlapor'].($rowDetil['nrp_terlapor']==''?'':'/'.$rowDetil['nrp_terlapor'])."
                                    jabatan ".ucwords(strtolower($rowDetil['jabatan_terlapor']))." , tidak terbukti melakukan pelanggaran disiplin.
                                </td>
                            </tr>
                            ";    
            }else{
                $saran .="<tr>
                                <td width='5%' style='vertical-align:top'>".$no_saran."</td>
                                <td width='95%' align='justify'>Terhadap terlapor ".$rowDetil['nama_terlapor']."
                                    pangkat (Gol) ".$rowDetil['pangkat_terlapor']." (".$rowDetil['golongan_terlapor'].")
                                    NIP/NRP. ".$rowDetil['nip_terlapor'].($rowDetil['nrp_terlapor']==''?'':'/'.$rowDetil['nrp_terlapor'])." 
                                    jabatan ".ucwords(strtolower($rowDetil['jabatan_terlapor'])).", 
                                    terbukti melakukan pelanggaran disiplin yaitu ".$rowDetil['isi_sk']." 
                                    melanggar pasal ".$rowDetil['pasal'].".
                                </td>
                            </tr>
                        ";
           }
            $no_saran++;
        }
        $saran .="</table>";

         /*Peratanyaan*/
        $penandatangan="";
        $no_penandatangan=1;
        $penandatangan .="<table width='100%' style='font-family:Arial;'>";
        foreach ($modelPenandatangan as $rowPenandatangan) {
            $penandatangan .="<tr>
                            <td width='50%'>".$no_penandatangan.'. '.$rowPenandatangan['nama_penandatangan']."</td>
                          </tr>";
            $no_penandatangan++;
        }
        $penandatangan .="</table>";
        // <td>".$rowPertanyaan['pertanyaan'].'<p style="margin: 0px 0px 0px 20px;">'.$rowPertanyaan['jawaban']."</p></td>
       
        

        //$docx->setDefaultFont('Arial');
        $docx->replaceVariableByText(array('kejaksaan'=>strtoupper($kejaksaan)), array('parseLineBreaks'=>true));
         $docx->replaceVariableByText(array('tempat'=>$tempat), array('parseLineBreaks'=>true));
         $docx->replaceVariableByText(array('tglLWas2'=>$tglLwas2), array('parseLineBreaks'=>true));
        //$docx->replaceVariableByText(array('lokasi'=>strtoupper($lokasi_surat1)), array('parseLineBreaks'=>true));
        // $docx->replaceVariableByText(array('hari'=>$hari), array('parseLineBreaks'=>true));
        // $docx->replaceVariableByText(array('nama_terlapor'=>$nama_terlapor), array('parseLineBreaks'=>true));
        // $docx->replaceVariableByText(array('nip_terlapor'=>$nip_terlapor), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('sprint'=>$pejabat_sp_was_2), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('noSprint'=>$no_sp_was_2), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tanggalSprint'=>$tgl_sp_was_2), array('parseLineBreaks'=>true));


        $docx->replaceVariableByHTML('IsiPemeriksa', 'block', $pemeriksa, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('IsiTerlapor', 'block', $terlapor, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('IsiPermasalahan', 'block', $isiP, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('IsiData', 'block', $isiD, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('IsiAnalisa', 'block', $isiA, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('IsiKesimpulan', 'block', $isiK, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('IsiPertimbangan', 'block', $isiPT, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('IsiSaran', 'block', $saran, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('IsiPendapat', 'block', $pendapat, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('isiPemeriksa2', 'block', $penandatangan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));

        $docx->createDocx('template/pengawasan/lwas2');
		
        $file = 'template/pengawasan/lwas2.docx';

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