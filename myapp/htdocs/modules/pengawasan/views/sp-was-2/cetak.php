<?php
require_once('/wordtest/classes/CreateDocx.inc');

        $docx = new CreateDocxFromTemplate('../modules/pengawasan/template/sp_was_2.docx');
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
      $bulan=date('m');
      $tahun=date('Y');
      // $model->nomor_sp_was2 = 'PRIN-'.$_POST['SpWas2']['nomor_sp_was2'].'/H/Hjw/'.$bulan.'/'.$tahun;
      $no_sp_was_2=($spwas2['nomor_sp_was2']==''?'PRIN-            /H/Hjw/'.$bulan.'/'.$tahun:'PRIN-'.$spwas2['nomor_sp_was2'].'/H/Hjw/'.$bulan.'/'.$tahun);
      
      /*isi dasar surat*/
      $isi_surat="";
      foreach ($dasar as $key) {
         $isi_surat .=$key['isi_dasar_sp_was2'];
      }

      /*daftar Pemeriksa Spwas2*/
      $pemeriksa_sp_was2="";
      $no_pemeriksa=1;
      foreach ($pemeriksa as $rowpemeriksa) {
           $pemeriksa_sp_was2 .="<table>
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
                    <td>".substr($rowpemeriksa['nip_pemeriksa'],0,7).' '.substr($rowpemeriksa['nip_pemeriksa'],8,6).' '.substr($rowpemeriksa['nip_pemeriksa'],14,1).' '.substr($rowpemeriksa['nip_pemeriksa'],15,3). ($rowpemeriksa['nrp_pemeriksa']==''? '':'/').$rowpemeriksa['nrp_pemeriksa']."</td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td>:</td>
                    <td>".$rowpemeriksa['jabatan_pemeriksa']."</td>
                </tr>
                </table><br>";
                $no_pemeriksa++;
      }

    
      /*daftar terlapor Spwas2*/
      $terlapor_spwas2="";
      $no_terlapor=1;
      foreach ($terlapor as $rowterlapor) {
           $terlapor_spwas2 .="<table>
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
      $dikeluarkan_di= ucwords(strtolower($lokasi));

      /*penandatangan*/
       
        $jabatanPenandatangan=$spwas2['jabatan_penandatangan'];
        $jabatan=$spwas2['jbtn_penandatangan'];
		if(strtoupper($jabatanPenandatangan)==strtoupper($jabatan)){
			$jabatan='<p></p>';
		}else{
			$jabatan=$jabatan;
		}
        $namaTandatangan=$spwas2['nama_penandatangan'];
        $nipTandatangan= $spwas2['pangkat_penandatangan'].'  NIP. '.substr($spwas2['nip_penandatangan'],0,7).' '.substr($spwas2['nip_penandatangan'],8,6).' '.substr($spwas2['nip_penandatangan'],14,1).' '.substr($spwas2['nip_penandatangan'],15,3);

  // print_r($jabatanPenandatangan);
          // exit();

        /*tembusan spwas2*/
        $tembusan_was="";
        $no_tembusan=1;
        $tembusan_was .="<table>";
        foreach ($tembusan as $rowTembusan) {
            $tembusan_was .="<tr>
                            <td>".(count($tembusan)>=2?$no_tembusan:' ')."</td>
                            <td>".$rowTembusan['tembusan']."</td>
                        </tr>";
            $no_tembusan++;
        }
        $tembusan_was .="</table>";
        $nomor_dipa=$dipa['dipa'];


        $docx->setDefaultFont('Arial');
        $docx->replaceVariableByText(array('kejaksaan'=>strtoupper($kejaksaan)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('lokasi'=>strtoupper($lokasi1)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('pimpinan_inst'=>ucwords($pimpinan)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('no_sp_was_2'=>$no_sp_was_2), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('isi_surat'=>$isi_surat), array('parseLineBreaks'=>true));
        //$docx->replaceVariableByText(array('pemeriksa_sp_was2'=>strtoupper($pemeriksa_sp_was2)), array('parseLineBreaks'=>true));
        $docx->replaceVariableByHTML('pemeriksa_sp_was2', 'block', $pemeriksa_sp_was2, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('terlapor_spwas2', 'block', '<div margin-left:40px;>'.$terlapor_spwas2.'</div>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('tgl_berlaku_1', 'inline', '<b>'.$tgl_berlaku_1.'</b>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('tgl_berlaku_2', 'inline', '<b>'.$tgl_berlaku_2.'</b>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('dikeluarkan_di', 'inline', '<b>'.$dikeluarkan_di.'</b>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('tgl_sp_was_2', 'inline', $tgl_sp_was_2, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        
        $docx->replaceVariableByHTML('jabatanPenandatangan', 'inline', $jabatanPenandatangan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('jabatan', 'inline', $jabatan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('namaTandatangan', 'inline', '<u>'.$namaTandatangan.'</u>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('nipTandatangan', 'inline', $nipTandatangan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        
        $docx->replaceVariableByHTML('tembusan', 'block', $tembusan_was, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('nomor_dipa', 'inline', $nomor_dipa, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
       
        $docx->createDocx('template/pengawasan/sp_was_2');
        
        $file = 'template/pengawasan/sp_was_2.docx';

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