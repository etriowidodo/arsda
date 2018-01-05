<?php
require_once('/wordtest/classes/CreateDocx.inc');
        $docx = new CreateDocxFromTemplate('../modules/pengawasan/template/sk_was_2a.docx');
        $kejaksaan=strtoupper($data_satker['inst_nama']);
         
        $nmr_sk_was_2a    =$model['no_sk_was_2a'];
        $ditetapkan       =$model['di_tempat'];
        $nama_penerima		=$model['nama_pegawai_terlapor'];
        $pangkat_penerima =$model['pangkat_pegawai_terlapor'] .' ('.$model['golongan_pegawai_terlapor'].')';
        $nip_penerima     ='  NIP. '.substr($model['nip_pegawai_terlapor'],0,8).' '.substr($model['nip_pegawai_terlapor'],8,6).' '.substr($model['nip_pegawai_terlapor'],14,1).' '.substr($model['nip_pegawai_terlapor'],15,3);
        $jabatan_penetap  =$model['jabatan_penandatangan'];
        $nama_penetap     =$model['nama_penandatangan'];
        $pangkat_penetap  =$model['pangkat_penandatangan'] .' ('.$model['golongan_penandatangan'].')';
        $nip_penetap      ='  NIP. '.substr($model['nip_penandatangan'],0,8).' '.substr($model['nip_penandatangan'],8,6).' '.substr($model['nip_penandatangan'],14,1).' '.substr($model['nip_penandatangan'],15,3);
        // print_r($ditetapkan);
        // exit();
    //     $detail_uraian="";
    //     $no=1;
    //     foreach ($modelwas12a as $row_uraian) {
    //     	if(count($modelwas14)<=1){
				// $detail_uraian .=$row_uraian['isi_uraian'];
    //     	}else{
				// $detail_uraian .=$no.' '.$row_uraian['isi_uraian'].'<br>';
    //     	}
    //     	$no++;
	   //  }
	      // $membaca=$membaca;
       //  $membaca="";
       //  $no_membaca=1;
       // $membaca .="<table width='100%'>";
        foreach ($modelwasUraian1 as $rowmembaca) {
             $membaca .=$rowmembaca['isi_uraian'];
            // $membaca .="<tr>"
            //                 <td width='95%' style='text-align:justify;'>".$rowmembaca['isi_uraian']."</td>
            //             </tr>";
         //   $no_membaca++;
        }

        foreach ($modelwasUraian2 as $rowmenimbang) {
             $menimbang .=$rowmenimbang['isi_uraian'];
            // $membaca .="<tr>"
            //                 <td width='95%' style='text-align:justify;'>".$rowmembaca['isi_uraian']."</td>
            //             </tr>";
         //   $no_membaca++;
        }
      //  $membaca .="</table>";

         foreach ($modelwasUraian3 as $rowmengingat) {
             $mengingat .=$rowmengingat['isi_uraian'];
            // $membaca .="<tr>"
            //                 <td width='95%' style='text-align:justify;'>".$rowmembaca['isi_uraian']."</td>
            //             </tr>";
         //   $no_membaca++;
        } 

        // echo $mengingat; 
        // exit();

        foreach ($modelwasUraian4 as $rowmenetapkan) {
             $menetapkan .=$rowmenetapkan['isi_uraian'];
            // $membaca .="<tr>"
            //                 <td width='95%' style='text-align:justify;'>".$rowmembaca['isi_uraian']."</td>
            //             </tr>";
         //   $no_membaca++;
        } 



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
       $docx->replaceVariableByHTML('nm_kejaksaan', 'inline','<h2 style="text-align: center;"><b><p>'.$kejaksaan.'</p></b></h2>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
       // $docx->replaceVariableByHTML('lokasi', 'inline','<h2 style="text-align: center;"><b><p>'.$lokasi.'</p></b></h2>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
       $docx->replaceVariableByText(array('nmr_sk_was_2a'=>$nmr_sk_was_2a), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('ditetapkan'=>$ditetapkan), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('tgl_ditetapkan'=>$tgl_sk), array('parseLineBreaks'=>true));
    //   $docx->replaceVariableByText(array('diterima'=>$tgl_diterima), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('jabatan_penetap'=>$jabatan_penetap), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('nm_penetap'=>$nama_penetap), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('pangkat_penetap'=>$pangkat_penetap), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('nip_penetap'=>$nip_penetap), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('nm_penerima'=>$nama_penerima), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('pangkat_penerima'=>$pangkat_penerima), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('nip_penerima'=>$nip_penerima), array('parseLineBreaks'=>true));
       // $docx->replaceVariableByText(array('nama_terlapor'=>$nama_terlapor), array('parseLineBreaks'=>true));
       // $docx->replaceVariableByText(array('pangkat_terlapor'=>$pangkat_terlapor), array('parseLineBreaks'=>true));
       // $docx->replaceVariableByText(array('nip_terlapor'=>$nip_terlapor), array('parseLineBreaks'=>true));
       // $docx->replaceVariableByText(array('jabatan_terlapor'=>$jabatan_terlapor), array('parseLineBreaks'=>true));
       // $docx->replaceVariableByText(array('nomor_surat'=>$nomor_surat), array('parseLineBreaks'=>true));
       // $docx->replaceVariableByText(array('tanggal'=>$tanggalWas15), array('parseLineBreaks'=>true));
       // $docx->replaceVariableByText(array('ttd_dari'=>$jabtan_penandatangan), array('parseLineBreaks'=>true));
       // $docx->replaceVariableByText(array('ttd_peg_nama'=>$nama_penandatangan), array('parseLineBreaks'=>true));
       // $docx->replaceVariableByText(array('ttd_jabatan'=>$pangkat_penandatangan), array('parseLineBreaks'=>true));
       // $docx->replaceVariableByText(array('ttd_peg_nip'=>$nipTandatangan), array('parseLineBreaks'=>true));
       // // $docx->replaceVariableByText(array('nama_penandatangan'=>$nama_penandatangan), array('parseLineBreaks'=>true));
       // // $docx->replaceVariableByText(array('pangkat_penandatangan'=>$pangkat_penandatangan), array('parseLineBreaks'=>true));
       // // $docx->replaceVariableByText(array('nip_penandatangan'=>$nipTandatangan), array('parseLineBreaks'=>true));
       
        $docx->replaceVariableByHTML('membaca', 'block',$membaca, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('menimbang', 'block',$menimbang, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('mengingat', 'block',$mengingat, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('menetapkan', 'block',$menetapkan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('nama_tembusan', 'block',$tembusan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));

 		$docx->createDocx('template/pengawasan/sk_was_2a');
		
        $file = 'template/pengawasan/sk_was_2a.docx';

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