<?php
require_once('/wordtest/classes/CreateDocx.inc');

        $docx = new CreateDocxFromTemplate('../modules/pengawasan/template/sp_was_1.docx');
        $kejaksaan=strtoupper($data_satker['inst_nama']);
        $lokasi=strtoupper($data_satker['inst_lokinst']);
        /*permintaan kang putut lokasi harus ada spasi*/
        $x=strlen($lokasi);
        $lokasi1='';
        for ($i=0; $i <$x ; $i++) { 
            $lokasi1 .=$lokasi[$i].' ';
        }

      

    /*ini untuk kepala pengawasan*/
      if($data_satker->kode_tk=='0'){
        $pimpinan="Jaksa Agung Muda Pengawasan";
      }else if($data_satker->kode_tk=='1'){
         $pimpinan="Kepala Kejaksaan Tinggi";
      }else if($data_satker->kode_tk=='2'){
         $pimpinan="Kepala Kejaksaan Negeri";
      }
      /*no spwas 1*/
      $no_sp_was_1=$spwas1['nomor_sp_was1'];
       
      
      /*isi dasar surat*/
      $isi_surat="";
      foreach ($dasar as $key) {
         $isi_surat .=$key['isi_dasar_sp_was1'];
      }

      /*daftar Pemeriksa Spwas1*/
      $pemeriksa_sp_was1="";
      $no_pemeriksa=1;
      foreach ($pemeriksa as $rowpemeriksa) {
           $pemeriksa_sp_was1 .="<table>
                <tr>
                <td rowspan='5' style='vertical-align:top;'>".(count($pemeriksa)>=2? $no_pemeriksa:' ')."</td>
                    <td style='vertical-align:top;>Nama</td>
                    <td style='vertical-align:top;>:</td>
                    <td><b>".$rowpemeriksa['nama_pemeriksa']."</b></td>
                </tr>
                <tr>
                    <td>Pangkat/Gol.</td>
                    <td>:</td>
                    <td>".$rowpemeriksa['pangkat_pemeriksa']."</td>
                </tr>
                <tr>
                    <td>NIP/NRP</td>
                    <td>:</td>
                    <td>".substr($rowpemeriksa['nip'],0,7).' '.substr($rowpemeriksa['nip'],8,6).' '.substr($rowpemeriksa['nip'],14,1).' '.substr($rowpemeriksa['nip'],15,3). ($rowpemeriksa['nrp']==''? '':'/').$rowpemeriksa['nrp']."</td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td>:</td>
                    <td>".$rowpemeriksa['jabatan_pemeriksa']."</td>
                </tr>
                </table><br>";
                $no_pemeriksa++;
      }

    
      /*daftar terlapor Spwas1*/
      $terlapor_spwas1="";
      $no_terlapor=1;
      foreach ($terlapor as $rowterlapor) {
           $terlapor_spwas1 .="<table>
                <tr>
                <td rowspan='5' style='vertical-align:top;'>".(count($terlapor)>=2? $no_terlapor:' ')."</td>
                    <td><b>Nama</b></td>
                    <td><b>:</b></td>
                    <td><b>".$rowterlapor['nama_pegawai_terlapor']."</b></td>
                </tr>
                <tr>
                    <td><b>Pangkat/Gol.</b></td>
                    <td><b>:</b></td>
                    <td><b>".$rowterlapor['pangkat_pegawai_terlapor']."</b></td>
                </tr>
                <tr>
                    <td><b>NIP/NRP</b></td>
                    <td><b>:</b></td>
                    <td><b>".substr($rowterlapor['nip'],0,7).' '.substr($rowterlapor['nip'],8,6).' '.substr($rowterlapor['nip'],14,1).' '.substr($rowterlapor['nip'],15,3).($rowterlapor['nrp_pegawai_terlapor']==''? '':'/').$rowterlapor['nrp_pegawai_terlapor']."</b></td>
                </tr>
                <tr>
                    <td><b>Jabatan</b></td>
                    <td><b>:</b></td>
                    <td><b>".$rowterlapor['jabatan_pegawai_terlapor']."</b></td>
                </tr>
                </table><br>";
                $no_terlapor++;

      }
      

      /*tanggal Di keluarkan*/
      $dikeluarkan_di= ucwords(strtolower($data_satker['inst_lokinst']));

      /*penandatangan*/
        $sts =(substr($spwas1['status_penandatangan'],0,1));

        if($sts=='0'){ //jabatansebenernya
            $jabatanPenandatangan='<p></p>';
            $jabatan=$spwas1['jbtn_penandatangan'];
            $namaTandatangan=$spwas1['nama_penandatangan'];
            $nipTandatangan='<p></p>';
        }elseif($sts=='1'){ //AN
            $jabatanPenandatangan=$spwas1['jabatan_penandatangan'];
            $jabatan=$spwas1['jbtn_penandatangan'];
            $nipTandatangan= $spwas1['pangkat_penandatangan'].'  NIP. '.substr($spwas1['nip_penandatangan'],0,7).' '.substr($spwas1['nip_penandatangan'],8,6).' '.substr($spwas1['nip_penandatangan'],14,1).' '.substr($spwas1['nip_penandatangan'],15,3);
            $namaTandatangan=$spwas1['nama_penandatangan'];
        }elseif($sts=='2'||$sts=='3'){ //Plt&Plh
            $jabatanPenandatangan=$spwas1['jabatan_penandatangan'];
            $jabatan='<p></p>';
            $namaTandatangan= $spwas1['nama_penandatangan'];
            $nipTandatangan= $spwas1['pangkat_penandatangan'].'  NIP. '.substr($spwas1['nip_penandatangan'],0,7).' '.substr($spwas1['nip_penandatangan'],8,6).' '.substr($spwas1['nip_penandatangan'],14,1).' '.substr($spwas1['nip_penandatangan'],15,3);
            }


        /*tembusan spwas1*/
        $tembusan="";
        $no_tembusan=1;
         $tembusan .="<table>";
        foreach ($tembusan_spwas1 as $rowTembusan) {
            $tembusan .="<tr>
                            <td>".(count($tembusan_spwas1)>=2?$no_tembusan:' ')."</td>
                            <td>".$rowTembusan['tembusan']."</td>
                        </tr>";
            $no_tembusan++;
        }
        $tembusan .="</table>";
        $nomor_dipa=$dipa['dipa'];
        // exit();

        
        $docx->setDefaultFont('Arial');
        $docx->replaceVariableByText(array('kejaksaan'=>strtoupper($kejaksaan)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('lokasi'=>strtoupper($lokasi1)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('pimpinan_inst'=>strtoupper($pimpinan)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('no_sp_was_1'=>$no_sp_was_1), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('isi_surat'=>$isi_surat), array('parseLineBreaks'=>true));
        // $docx->replaceVariableByText(array('pemeriksa_sp_was1'=>strtoupper($pemeriksa_sp_was1)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByHTML('pemeriksa_sp_was1', 'block', $pemeriksa_sp_was1, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('terlapor_spwas1', 'block', '<div margin-left:40px;>'.$terlapor_spwas1.'</div>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('tgl_berlaku_1', 'inline', '<b>'.$tgl_berlaku_1.'</b>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('tgl_berlaku_2', 'inline', '<b>'.$tgl_berlaku_2.'</b>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('dikeluarkan_di', 'inline', '<b>'.$dikeluarkan_di.'</b>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('tgl_sp_was_1', 'inline', $tgl_sp_was_1, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        
        $docx->replaceVariableByHTML('jabatanPenandatangan', 'inline', $jabatanPenandatangan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('jabatan', 'inline', $jabatan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('namaTandatangan', 'inline', '<u>'.$namaTandatangan.'</u>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('nipTandatangan', 'inline', $nipTandatangan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        
        $docx->replaceVariableByHTML('tembusan', 'block', $tembusan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('nomor_dipa', 'inline', $nomor_dipa, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
       
        $docx->createDocx('template/pengawasan/sp_was_1');
		
        $file = 'template/pengawasan/sp_was_1.docx';

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