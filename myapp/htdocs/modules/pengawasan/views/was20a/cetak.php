<?php
require_once('/wordtest/classes/CreateDocx.inc');
        $docx = new CreateDocxFromTemplate('../modules/pengawasan/template/was20a.docx');
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

        // print_r($modelSk['sk']);
        // exit();

        $nomor                =$model['no_was_20a'];
      //  $dari                 =$model['dari_was_20a'];
        // $sifat                 =$model['sifat_surat'];
        $lampiran             =$model['lampiran'];
        $perihal              =$model['perihal'];
        $kepada               =$model['kpd_was_20a'];
        $diKpd                =$model['tempat'];
        $nama_terlapor        =$model['nama_pegawai_terlapor'];
        $pangkat_terlapor     =$model['pangkat_pegawai_terlapor'] .' ('.$model['golongan_pegawai_terlapor'].')';
        $nip_terlapor         =substr($model['nip_pegawai_terlapor'],0,8).' '.substr($model['nip_pegawai_terlapor'],8,6).' '.substr($model['nip_pegawai_terlapor'],14,1).' '.substr($model['nip_pegawai_terlapor'],15,3).($model['nrp_pegawai_terlapor']!=''?'/':' ').$model['nrp_pegawai_terlapor'];
        $jabatan_terlapor     =$model['jabatan_pegawai_terlapor'];
        $nomor_surat          =$modelwas15['no_was15'];

        $jabtan_penandatangan =$model['jabatan_penandatangan'];
        $nama_penandatangan   =$model['nama_penandatangan'];
        $pangkat_penandatangan=$model['pangkat_penandatangan'] .' ('.$model['golongan_penandatangan'].')';
        $nipTandatangan       = '  NIP. '.substr($model['nip_penandatangan'],0,8).' '.substr($model['nip_penandatangan'],8,6).' '.substr($model['nip_penandatangan'],14,1).' '.substr($model['nip_penandatangan'],15,3);

        $isiSk                =$modelIsiSk['isi_sk'];
        $sk                   =$modelSk['sk'];
        $noSk                 =$modelSk['no_sk'];
        //$tglSk                =$modelSk['tgl_sk'];

        $keberatan="";
        $arr_z    = range('a','z');
        $no_uraian1=0;
        $keberatan .="<table width='100%'>";
        foreach ($modelwas20a as $rowUraian) {
            $keberatan .="<tr>
                            <td width='5%' style='valign:top;'>".$arr_z[$no_uraian1].'.'."</td>
                            <td width='95%' style='text-align:justify;'>".$rowUraian['keberatan']."</td>
                        </tr>";
            $no_uraian1++;
        }
        $keberatan .="</table>"; 

        $tanggapan="";
        $arr_z    = range('a','z');
        $no_uraian2=0;
        $tanggapan .="<table width='100%'>";
        foreach ($modelwas20a as $rowUraian) {
            $tanggapan .="<tr>
                            <td width='5%' style='valign:top;'>".$arr_z[$no_uraian2].'.'."</td>
                            <td width='95%' style='text-align:justify;'>".$rowUraian['tanggapan']."</td>
                        </tr>";
            $no_uraian2++;
        }
        $tanggapan .="</table>";


        $tembusan="";
        $no_tembusan=1;
        $tembusan .="<table width='100%'>";
        foreach ($modelTembusan as $rowTembusan) {
            $tembusan .="<tr>
                            <td width='1%'>".(count($modelTembusan)>=2?$no_tembusan:' ')."</td>
                            <td>".$rowTembusan['tembusan']."</td>
                        </tr>";
            $no_tembusan++;
        }
        $tembusan .="</table>";

 		
 		$docx->setDefaultFont('Arial'); 
       $docx->replaceVariableByHTML('kejaksaan', 'inline','<h2 style="text-align: center;"><b><p>'.$kejaksaan.'</p></b></h2>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
       // $docx->replaceVariableByHTML('lokasi', 'inline','<h2 style="text-align: center;"><b><p>'.$lokasi.'</p></b></h2>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
       $docx->replaceVariableByText(array('nomor'=>$nomor), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('sifat'=>$sifat), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('lampiran'=>$lampiran), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('perihal'=>$perihal), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('tanggal1'=>$tanggal), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('kepada'=>$kepada), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('diKpd'=>$diKpd), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('namaTerlapor'=>$nama_terlapor), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('pangkatTerlapor'=>$pangkat_terlapor), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('nipTerlapor'=>$nip_terlapor), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('jabatanTerlapor'=>$jabatan_terlapor), array('parseLineBreaks'=>true));
       
       $docx->replaceVariableByText(array('sk'=>$sk), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('noSk'=>$noSk), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('tglSk'=>$tglSk), array('parseLineBreaks'=>true));
       
       $docx->replaceVariableByText(array('isiSk'=>$isiSk), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('tglDisampaikan'=>$tgl_disampaikan_ba), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('tglKeberatan'=>$tgl_keberatan_ba), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('ttd_dari'=>$jabtan_penandatangan), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('ttd_peg_nama'=>$nama_penandatangan), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('ttd_jabatan'=>$pangkat_penandatangan), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('ttd_peg_nip'=>$nipTandatangan), array('parseLineBreaks'=>true));
       // $docx->replaceVariableByText(array('nama_penandatangan'=>$nama_penandatangan), array('parseLineBreaks'=>true));
       // $docx->replaceVariableByText(array('pangkat_penandatangan'=>$pangkat_penandatangan), array('parseLineBreaks'=>true));
       // $docx->replaceVariableByText(array('nip_penandatangan'=>$nipTandatangan), array('parseLineBreaks'=>true));
       
       $docx->replaceVariableByHTML('isiKeberatan', 'block',$keberatan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
       $docx->replaceVariableByHTML('isiTanggapan', 'block',$tanggapan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));

       $docx->replaceVariableByHTML('tembusan', 'block',$tembusan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));

 		$docx->createDocx('template/pengawasan/was20a');
		
        $file = 'template/pengawasan/was20a.docx';

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