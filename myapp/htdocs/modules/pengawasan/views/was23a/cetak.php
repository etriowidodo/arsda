<?php
require_once('/wordtest/classes/CreateDocx.inc');
        $docx = new CreateDocxFromTemplate('../modules/pengawasan/template/was23a.docx');
        $kejaksaan=strtoupper($data_satker['inst_nama']);

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

        // print_r($tglSk);
        // exit();

        $nomor                =$model['no_was_23a'];
        $dari                 =$model['di'];
        // $sifat                 =$model['sifat_surat'];
        $lampiran             =$model['lampiran'];
        $perihal              =$model['perihal'];
        $kepada               =$model['kpd_was_23a'];
        $tempat               =$model['tempat'];
        $nama_terlapor        =$model['nama_pegawai_terlapor'];
        $pangkat_terlapor     =$model['pangkat_pegawai_terlapor'] .' ('.$model['golongan_pegawai_terlapor'].')';
        $nip_terlapor         =substr($model['nip_pegawai_terlapor'],0,8).' '.substr($model['nip_pegawai_terlapor'],8,6).' '.substr($model['nip_pegawai_terlapor'],14,1).' '.substr($model['nip_pegawai_terlapor'],15,3).($model['nrp_pegawai_terlapor']!=''?'/':' ').$model['nrp_pegawai_terlapor'];
        $jabatan_terlapor     =$model['jabatan_pegawai_terlapor'];
        $nomor_surat          =$modelwas15['no_was15'];

        $jabtan_penandatangan =$model['jabatan_penandatangan'];
        $nama_penandatangan   =$model['nama_penandatangan'];
        $pangkat_penandatangan=$model['pangkat_penandatangan'] .' ('.$model['golongan_penandatangan'].')';
        $nipTandatangan       = '  NIP. '.substr($model['nip_penandatangan'],0,8).' '.substr($model['nip_penandatangan'],8,6).' '.substr($model['nip_penandatangan'],14,1).' '.substr($model['nip_penandatangan'],15,3);


        // function test_odd($var)
        // {
        // return($var);
        // }

        // $a1=array("a","b",2,3,4);
        // print_r(array_filter($a1,"test_odd"));
        // exit();

        $tembusan="";
        $no_tembusan=1;
        $tembusan .="<table width='100%'>";
        foreach ($modelTembusan as $rowTembusan) {
            $test = strlen($rowTembusan['tembusan']);

          //  print_r(array_filter($a1,"test_odd"));
            echo $test[1];
            $tembusan .="<tr>
                            <td width='1%'>".(count($modelTembusan)>=2?$no_tembusan:' ')."</td>
                            <td>".$rowTembusan['tembusan']."</td>
                        </tr>";
            $no_tembusan++;
        }
        $tembusan .="</table>";
     //   exit();

 		
 		$docx->setDefaultFont('Arial'); 
       $docx->replaceVariableByHTML('kejaksaan', 'inline','<h2 style="text-align: center;"><b><p>'.$kejaksaan.'</p></b></h2>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
       // $docx->replaceVariableByHTML('lokasi', 'inline','<h2 style="text-align: center;"><b><p>'.$lokasi.'</p></b></h2>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
       $docx->replaceVariableByText(array('kepada'=>$kepada), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('di1'=>$dari), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('tanggal1'=>$tanggal), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('nomor'=>$nomor), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('sifat'=>$sifat), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('lampiran'=>$lampiran), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('perihal'=>$perihal), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('tempat1'=>$tempat), array('parseLineBreaks'=>true));
       
       $docx->replaceVariableByText(array('tglNodis'=>$tglNodis), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('namaTerlapor'=>$nama_terlapor), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('pangkatTerlapor'=>$pangkat_terlapor), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('nipTerlapor'=>$nip_terlapor), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('jabatanTerlapor'=>$jabatan_terlapor), array('parseLineBreaks'=>true));
       
       
       $docx->replaceVariableByText(array('isiSk'=>$isiSk), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('tglDisampaikan'=>$tgl_disampaikan_ba), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('tglKeberatan'=>$tgl_keberatan_ba), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('ttd_dari'=>$jabtan_penandatangan), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('ttd_peg_nama'=>$nama_penandatangan), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('ttd_jabatan'=>$pangkat_penandatangan), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('ttd_peg_nip'=>$nipTandatangan), array('parseLineBreaks'=>true));
     
       $docx->replaceVariableByHTML('tembusan', 'block',$tembusan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));

 		$docx->createDocx('template/pengawasan/was23a');
		
        $file = 'template/pengawasan/was23a.docx';

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