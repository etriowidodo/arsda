<?php
require_once('/wordtest/classes/CreateDocx.inc');

        $docx = new CreateDocxFromTemplate('../modules/pengawasan/template/ba_was_3_eks.docx');
        $kejaksaan=strtoupper($data_satker['inst_nama']);
//         $kejaksaan1=ucwords($data_satker['inst_nama']);
        $lokasi=strtoupper($data_satker['inst_lokinst']);
//         $lokasi_surat=ucwords($data_satker['inst_lokinst']);
//          /*permintaan kang putut lokasi harus ada spasi*/
        $x=strlen($lokasi);
        $lokasi_surat1='';
        for ($i=0; $i <$x ; $i++) { 
            $lokasi_surat1 .=$lokasi[$i].' ';
        }


        /*tempat Panggilan*/
        $tempat=$model['tempat'];

        /*Hari BAwas3*/
        $hari=$hari_bawas3;
    

        /*tanggal BAwas3*/
        $tanggal=$tgl_bawas3;

        /*-----------------------------------tandatangan----------------------------------*/

        /*nama terlapor*/
        $nama_terlapor=$modelyg_diperiksa['nama_saksi_eksternal'];


        /*nip pemeriksa ttd*/
        $nipttd=substr($modelyg_memeriksa['nip_pemeriksa'],0,8).' '.substr($modelyg_memeriksa['nip_pemeriksa'],8,6).' '.substr($modelyg_memeriksa['nip_pemeriksa'],14,1).' '.substr($modelyg_memeriksa['nip_pemeriksa'],15,3).($modelyg_memeriksa['nrp_pemeriksa']!=''?'/':' ').$modelyg_memeriksa['nrp_pemeriksa'];

        /*nama pemriksa ttd*/
        $namattd=$modelyg_memeriksa['nama_pemeriksa'];

        /*pangkat tpemeriksa ttd*/
        $pangkatttd=$modelyg_memeriksa['pangkat_pemeriksa'];
        /*-----------------------------end tandatangan-----------------------------------*/



        /*noSpWas1*/
        $no_sp_was_1=$modelSpWas1['nomor_sp_was1'];

        /*jabatan_penandatangan*/
        $pejabat_sp_was_1=$modelSpWas1['jabatan_penandatangan'];
        // print_r($tgl_sp_was);

        /*$tgl_sp_was*/
       $tgl_sp_was_1=$tgl_spwas1;
        

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
        $no_pemeriksa=1;
        $pemeriksa .="<table width='100%'>";
        foreach ($modelPemriksa as $rowPemeriksa) {
            $pemeriksa .="<tr>
                            <td width='30%'>Nip/NRP</td>
                            <td width='2%'>:</td>
                            <td>".$rowPemeriksa['nip_pemeriksa'].'/'.$rowPemeriksa['nrp_pemeriksa']."</td>
                          </tr>
                          <tr>
                            <td width='30%'>Nama Pemeriksa</td>
                            <td width='2%'>:</td>
                            <td>".$rowPemeriksa['nama_pemeriksa']."</td>
                          </tr>
                          <tr>
                            <td width='30%'>Golongan Pemeriksa</td>
                            <td width='2%'>:</td>
                            <td>".$rowPemeriksa['golongan_pemeriksa']."</td>
                          </tr>
                          <tr>
                            <td width='30%'>Pangkat Pemeriksa</td>
                            <td width='2%'>:</td>
                            <td>".$rowPemeriksa['pangkat_pemeriksa']."</td>
                          </tr>
                          <tr>
                            <td width='30%'>Jabatan Pemeriksa</td>
                            <td width='2%'>:</td>
                            <td>".$rowPemeriksa['jabatan_pemeriksa']."</td>
                          </tr>";
            $no_pemeriksa++;
        }
        $pemeriksa .="</table>";

        /*Terlapor*/
        $saksi_eks="";
        $no_saksi_eks=1;
        $saksi_eks .="<table width='100%'>";
        foreach ($modelSaksiek as $rowSaksiEks) {
            $saksi_eks .="<tr>
                            <td width='30%'>Nama Saksi</td>
                            <td width='2%'>:</td>
                            <td>".$rowSaksiEks['nama_saksi_eksternal']."</td>
                          </tr>
                          <tr>
                            <td width='30%'>Alamat Terlapor</td>
                            <td width='2%'>:</td>
                            <td>".$rowSaksiEks['alamat_saksi_eksternal']."</td>
                          </tr>
                          <tr>
                            <td width='30%'>Pangkat Terlapor</td>
                            <td width='2%'>:</td>
                            <td>".$rowSaksiEks['nama_kota_saksi_eksternal']."</td>
                          </tr>";
            $no_saksi_eks++;
        }
        $saksi_eks .="</table>";



         /*Peratanyaan*/
        $pertanyaan="";
        $no_pertanyaan=1;
        $pertanyaan .="<table width='100%'>";
        foreach ($modelPertanyaan as $rowPertanyaan) {
            $pertanyaan .="<tr>
                            <td>".$rowPertanyaan['pertanyaan'].'<p style="margin: 0px 0px 0px 20px;">'.$rowPertanyaan['jawaban']."</p></td>
                          </tr>";
            $no_pertanyaan++;
        }
        $pertanyaan .="</table>";
        
        // echo $pertanyaan;
        // exit();
        

        $docx->setDefaultFont('Arial');
        $docx->replaceVariableByText(array('kejaksaan'=>strtoupper($kejaksaan)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('lokasi'=>strtoupper($lokasi_surat1)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('hari'=>$hari), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tanggal_'=>$tanggal), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tempat'=>$tempat), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('nama_terlapor'=>$nama_terlapor), array('parseLineBreaks'=>true));
        // $docx->replaceVariableByText(array('nip_terlapor'=>$nip_terlapor), array('parseLineBreaks'=>true));
        
        $docx->replaceVariableByText(array('namattd'=>$namattd), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('pangkatttd'=>$pangkatttd), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('nipttd'=>$nipttd), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('pejabat_sp_was_1'=>$pejabat_sp_was_1), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('no_sp_was_1'=>$no_sp_was_1), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl_sp_was_1'=>$tgl_sp_was_1), array('parseLineBreaks'=>true));


        $docx->replaceVariableByHTML('pemeriksa', 'block', $pemeriksa, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('terlapor', 'block', $saksi_eks, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('pertanyaan', 'block', $pertanyaan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));

        $docx->createDocx('template/pengawasan/ba_was_3_eks');
		
        $file = 'template/pengawasan/ba_was_3_eks.docx';

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