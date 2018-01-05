<?php
require_once('/wordtest/classes/CreateDocx.inc');

        $docx = new CreateDocxFromTemplate('../modules/pengawasan/template/was-15.docx');
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

        if($model['sifat_was15']=='1'){
            $sifat_was15="Biasa";
            $akr="B";
         }else if($model['sifat_was15']=='2'){
            $sifat_was15="Segera";
            $akr="S";
         }else if($model['sifat_was15']=='3'){
            $sifat_was15="Rahasia";
            $akr="R";
         }

        // print_r($model);
        // print_r($tgl_sp_was);
        // exit();        
         $lampiran_was15=$model['lampiran_was15'];
         $perihal_was15=$model['perihal_was15'];
         
         $kepada_was15=$model['kepada_was15'];
         $dari_was15=$model['dari_was15'];
         $tanggal_was15=\Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_was15']);
         $tanggal_spwas2=\Yii::$app->globalfunc->ViewIndonesianFormat($modelSpwas2['tanggal_sp_was2']);
         $penandatangan_spwas2=\Yii::$app->globalfunc->ViewIndonesianFormat($modelSpwas2['nama_penandatangan']);
         // $no_spwas2=\Yii::$app->globalfunc->ViewIndonesianFormat($modelSpwas2['nomor_sp_was2']);
         $no_spwas2=$modelSpwas2['nomor_sp_was2'];
         

         $pelapor_was15             ="<div style='margin-left:30px; font-family:Arial;'>".$model['isi_pelapor_was15']."<div>";
         $permasalahan_was15        ="<div style='margin-left:30px; font-family:Arial;'>".$model['isi_permasalahan_was15']."<div>";
         $data_analisa_was15        ="<div style='margin-left:30px; font-family:Arial;'>".$model['data_analisa_was15']."<div>";
         $kesimpulan                ="<div style='margin-left:30px; font-family:Arial;'>".$model['kesimpulan_was15']."<div>";
         $pertimbangan_berat_was15  ="<div style='margin-left:30px; font-family:Arial;'>".$model['pertimbangan_berat_was15']."<div>";
         $pertimbangan_ringan_was15 ="<div style='margin-left:30px; font-family:Arial;'>".$model['pertimbangan_ringan_was15']."<div>";
         $rencanaJamwas             ="<div style='margin-left:30px; font-family:Arial;'>".$model['saran_jamwas']."<div>";
         $putusan_was15             ="<div style='margin-left:30px; font-family:Arial;'>".$model['keputusan_was15']."<div>";
         
         $nama_penandatangan=$model['nama_penandatangan'];
         $pangkat_ttd=$model['pangkat_penandatangan'];
         $nip_ttd=substr($model['nip_penandatangan'],0,8).' '.substr($model['nip_penandatangan'],8,6).' '.substr($model['nip_penandatangan'],14,1).' '.substr($model['nip_penandatangan'],15,3);

        
         
         $nomor_was15=$model['no_was15'];
         // print_r($modelwas15rencana);
         $arr_az = range('a','z');
         $noP=0;
         $rencanaPemeriksa="<table style='margin-left:30px; font-family:Arial;'>";
         foreach ($modelwas15rencanaP as $keyTpemeriksa) {
            $rencanaPemeriksa.="<tr><td style='vertical-align:top;'>".$arr_az[$noP]."</td><td>Terlapor ".$keyTpemeriksa['nama_terlapor'].', Pangkat (Gol) '.$keyTpemeriksa['pangkat_terlapor'].'('.$keyTpemeriksa['golongan_terlapor'].')'.', NIP/NRP '.$keyTpemeriksa['nip_terlapor'].($keyTpemeriksa['nrp_terlapor']==''?'':'/'.$keyTpemeriksa['nrp_terlapor']).', Jabatan '.ucwords(strtolower($keyTpemeriksa['jabatan_terlapor'])).', dijatuhi hukuman disiplin '.($keyTpemeriksa['kategori_hukuman']=='1'?' Ringan ':($keyTpemeriksa['kategori_hukuman']=='2'?' Sedang ':' Berat ')).', Berupa '.$keyTpemeriksa['jenis_hukuman'].', sesuai pasal '.$keyTpemeriksa['pasal'] .'</td></tr><br>';
            $noP++;
         }
         $rencanaPemeriksa.="</table>";

         $noI=0;
         $rencanaInspekstur="<table style='margin-left:30px; font-family:Arial;'>";
         foreach ($modelwas15rencanaI as $keyTinspekstur) {
            $rencanaInspekstur.="<tr><td style='vertical-align:top;'>".$arr_az[$noI]."</td><td>Terlapor ".$keyTinspekstur['nama_terlapor'].', Pangkat(Gol) '.$keyTinspekstur['pangkat_terlapor'].'('.$keyTinspekstur['golongan_terlapor'].')'.', NIP/NRP '.$keyTinspekstur['nip_terlapor'].($keyTinspekstur['nrp_terlapor']==''?'':'/'.$keyTinspekstur['nrp_terlapor']).', Jabatan '.ucwords(strtolower($keyTinspekstur['jabatan_terlapor'])).', dijatuhi hukuman disiplin '.($keyTinspekstur['kategori_hukuman']=='1'?' Ringan ':($keyTinspekstur['kategori_hukuman']=='2'?' Sedang ':' Berat ')).', Berupa '.$keyTinspekstur['jenis_hukuman'].', sesuai pasal '.$keyTinspekstur['pasal'] .'</td></tr><br>';
         $noI++;
         }
         $rencanaInspekstur.="</table>";

         $jabatan_penandatangan=$model['jabatan_penandatangan'];
		 $jbtn_penandatangan =(substr($model['jabatan_penandatangan'],0,2)=='AN'?$model['jbtn_penandatangan']:'');

         // $noJ=0;
         // $rencanaJamwas="<table style='margin-left:30px;'>";
         // foreach ($modelwas15rencanaJ as $keyTjamwas) {
         //    $rencanaJamwas.="<tr><td style='vertical-align:top;'>".$arr_az[$noJ]."</td><td> Terlapor ".$keyTjamwas['nama_terlapor'].', Pangkat (Gol) '.$keyTjamwas['golongan_terlapor'].', NIP/NRP '.$keyTjamwas['nip_terlapor'].($keyTjamwas['nrp_terlapor']==''?'':'/'.$keyTjamwas['nrp_terlapor']).', Jabatan '.$keyTjamwas['jabatan_terlapor'].', dijatuhi hukuman disiplin '.($keyTjamwas['kategori_hukuman']=='1'?' Ringan ':($keyTjamwas['kategori_hukuman']=='2'?' Sedang ':' Berat ')).', Berupa '.$keyTjamwas['jenis_hukuman'].', sesuai pasal '.$keyTjamwas['pasal'] .'</td></tr><br>';
         //    $noJ++;
         // }
         // $rencanaJamwas.="</table>";
         // $rencanaPemeriksa.=$rencanaPemeriksa;
         // echo $rencanaPemeriksa.'<br>';
         // echo $rencanaInspekstur.'<br>';
         // echo $rencanaJamwas.'<br>';

// $arr_az = range('a','z');
// foreach($arr_az as $chr) {
//   echo $chr;
// }

         // exit();

        //  $sts =(substr($model['status_penandatangan'],0,1));
         
        //  if($sts=='0'){ //jabatansebenernya
        //    $jabatanPenandatangan=$was12['jabatan_penandatangan'];
        //    $jabatan='<p></p>';
        //    $namaTandatangan= $was12['nama_penandatangan'];
        //    $nipTandatangan=$was12['pangkat_penandatangan']. '  NIP. '.substr($was12['nip_penandatangan'],0,8).' '.substr($was12['nip_penandatangan'],8,6).' '.substr($was12['nip_penandatangan'],14,1).' '.substr($was12['nip_penandatangan'],15,3);
        // }elseif($sts=='1'){ //AN
        //    $jabatanPenandatangan=$was12['jabatan_penandatangan'];
        //    $jabatan=$was12['jbtn_penandatangan'];
        //    $nipTandatangan= $was12['pangkat_penandatangan']. '  NIP. '.substr($was12['nip_penandatangan'],0,8).' '.substr($was12['nip_penandatangan'],8,6).' '.substr($was12['nip_penandatangan'],14,1).' '.substr($was12['nip_penandatangan'],15,3);
        //    $namaTandatangan= $was12['nama_penandatangan'];
        // }elseif($sts=='2'||$sts=='3'){ //Plt&Plh
        //    $jabatanPenandatangan=$was12['jabatan_penandatangan'];
        //    $jabatan='<p></p>';
        //    $namaTandatangan= $was12['nama_penandatangan'];
        //    $nipTandatangan=$was12['pangkat_penandatangan']. '  NIP. '.substr($was12['nip_penandatangan'],0,8).' '.substr($was12['nip_penandatangan'],8,6).' '.substr($was12['nip_penandatangan'],14,1).' '.substr($was12['nip_penandatangan'],15,3);
        //  }

 
        $terlapor="";
        $no_terlapor=1;
        $terlapor .="<table style='font-family: Arial; margin-left:30px;'>";
        foreach ($modelTerlapor as $rowterlapor) {
            $terlapor .="<tr>";
            if(count($modelTerlapor)>=2){
                $terlapor .="<td rowspan='4' style='vertical-align:top;'>".(count($modelTerlapor)>=2?$no_terlapor:' ')."</td>";
            }
               $terlapor .="<td>Nama</td>
                            <td>:</td>
                            <td><b>".$rowterlapor['nama_terlapor']."</b></td>
                        </tr>
                        <tr>
                            <td>Pangkat/Gol.</td>
                            <td>:</td>
                            <td>".$rowterlapor['pangkat_terlapor'].'('.$rowterlapor['golongan_terlapor'].')'."</td>
                        </tr>
                        <tr>
                            <td>NIP/NRP</td>
                            <td>:</td>
                            <td>".$rowterlapor['nip_terlapor'].'/'.$rowterlapor['nrp_terlapor']."</td>
                        </tr>
                        <tr>
                            <td>Jabatan</td>
                            <td>:</td>
                            <td>".ucwords(strtolower($rowterlapor['jabatan_terlapor']))."</td>
                        </tr>
                        ";
            $no_terlapor++;
        }
        $terlapor .="</table>";
        
        // // /*tembusan waas12*/
        $tembusan="";
        $no_tembusan=1;
        $tembusan .="<table style='font-family:Arial;'>";
        foreach ($modelTembusan as $rowTembusan) {
            $tembusan .="<tr>
                            <td>".(count($modelTembusan)>=2?$no_tembusan:' ')."</td>
                            <td>".$rowTembusan['tembusan']."</td>
                        </tr>";
            $no_tembusan++;
        }
        $tembusan .="</table>";


        $docx->setDefaultFont('Arial');
        $docx->replaceVariableByText(array('kejaksaan'=>strtoupper($kejaksaan)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('lokasi_surat'=>ucwords($lokasi_surat)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('sifat_was15'=>$sifat_was15), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('lampiran_was15'=>$lampiran_was15), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('perihal_was15'=>$perihal_was15), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('nomor_was15'=>$nomor_was15), array('parseLineBreaks'=>true));

        $docx->replaceVariableByText(array('kepada_was15'=>$kepada_was15), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('dari_was15'=>$dari_was15), array('parseLineBreaks'=>true));
        
        $docx->replaceVariableByText(array('tanggal_was15'=>$tanggal_was15), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tanggal_spwas2'=>$tanggal_spwas2), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('penandatangan_spwas2'=>'Jaksa Agung Muda Pengawasan'), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('no_spwas2'=>$no_spwas2), array('parseLineBreaks'=>true));
        

        $docx->replaceVariableByText(array('jabatan_penandatangan'=>$jabatan_penandatangan), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('jbtn_penandatangan'=>$jbtn_penandatangan), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('nama_penandatangan'=>$nama_penandatangan), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('pangkat_ttd'=>$pangkat_ttd), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('nip_ttd'=>$nip_ttd), array('parseLineBreaks'=>true));
        
        // $docx->replaceVariableByHTML('nama_penandatangan', 'inline','<u>'. $nama_penandatangan.'</u>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        // $docx->replaceVariableByHTML('pangkat_ttd', 'inline', $pangkat_ttd, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        // $docx->replaceVariableByHTML('nip_ttd', 'inline', $nip_ttd, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));

      
      

        $docx->replaceVariableByHTML('terlapor_was15', 'block',$terlapor, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('pelapor_was15', 'block',$pelapor_was15, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('permasalahan_was15', 'block',$permasalahan_was15, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('data_analisa_was15', 'block',$data_analisa_was15, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('pertimbangan_berat_was15', 'block',$pertimbangan_berat_was15, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('pertimbangan_ringan_was15', 'block',$pertimbangan_ringan_was15, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));

        $docx->replaceVariableByHTML('kesimpulan', 'block',$kesimpulan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('putusan_was15', 'block',$putusan_was15, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));

        /*rencana*/
        $docx->replaceVariableByHTML('rencana_p', 'block',$rencanaPemeriksa, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('rencana_i', 'block',$rencanaInspekstur, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('rencana_j', 'block',$rencanaJamwas, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        
        
      
        $docx->replaceVariableByHTML('tembusan', 'block',$tembusan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));

        $docx->createDocx('template/pengawasan/was-15');
        
        $file = 'template/pengawasan/was-15.docx';

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