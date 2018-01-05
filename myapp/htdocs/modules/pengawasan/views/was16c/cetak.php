<?php
require_once('/wordtest/classes/CreateDocx.inc');
        $docx = new CreateDocxFromTemplate('../modules/pengawasan/template/was_16c.docx');
        $kejaksaan=strtoupper($data_satker['inst_nama']);
        // // $kejaksaan1=ucwords($data_satker['inst_nama']);
        $lokasi_surat=ucwords($data_satker['inst_lokinst']);
        // // $lokasi=strtoupper($data_satker['inst_lokinst']);
        // // permintaan kang putut lokasi harus ada spasi
        // // $x=strlen($lokasi);
        // // $lokasi1='';
        // // for ($i=0; $i <$x ; $i++) { 
        // //     $lokasi1 .=$lokasi[$i].' ';
        // // }
        // // $nomor         =($model['no_was14d']!=''?$model['no_was14d']:'<p></p>');

        if($model['sifat_surat']=='1'){
            $sifat="Biasa";
            $akr="B";
         }else if($model['sifat_surat']=='2'){
            $sifat="Segera";
            $akr="S";
         }else if($model['sifat_surat']=='3'){
            $sifat="Rahasia";
            $akr="R";
         }
         
        $kepada                  =$model['kpd_was_16c'];
        // $dari                 =$model['dari_was_16b'];
        $nomor                   =$model['no_was_16c'];
        $di           	         =ucwords($model['di']);
        $lampiran                =$model['lampiran'];
        $perihal                 =$model['perihal'];
        $kepada                  =strtoupper($model['kpd_was_16c']);
        $tanggal                 =\Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_was_16c']);
        
        $tanggal_ba              =\Yii::$app->globalfunc->ViewIndonesianFormat($model['tanggal_ba']);

        $nip_terlapor            =$model['nip_pegawai_terlapor'];
        $nama_terlapor           =$model['nama_pegawai_terlapor'];
        $pangkat_terlapor        =$model['pangkat_pegawai_terlapor'].' ('.$model['golongan_pegawai_terlapor'].')';
        $golongan_terlapor       =$model['golongan_pegawai_terlapor'];
        $jabatan_terlapor        =$model['jabatan_pegawai_terlapor'];
      
        $jabatan_alias           =$model['jabatan_penandatangan'];
        $jabatan_asli	           =(substr($model['jabatan_penandatangan'],0,3)=='AN '?$model['jbtn_penandatangan']:'');
        $nama_penandatangan		   =$model['nama_penandatangan'];
        $pangkat_penandatangan	 =$model['pangkat_penandatangan'];
        $nipTandatangan          = '  NIP. '.substr($model['nip_penandatangan'],0,8).' '.substr($model['nip_penandatangan'],8,6).' '.substr($model['nip_penandatangan'],14,1).' '.substr($model['nip_penandatangan'],15,3);

        $bentuk_hukuman=$modelSk['isi_sk'];
        // $detail_uraian="";
        // $no_uraian=1;
        // $uraian_was16b .="<table width='100%'>";
        // foreach ($modelwas16b as $rowUraian) {
        //     $uraian_was16b .="<tr>
        //                     <td width='5%' style='valign:top;'>".(count($modelwas16b)>=2?$no_uraian:' ')."</td>
        //                     <td width='95%' style='text-align:justify;'>".$rowUraian['isi']."</td>
        //                 </tr>";
        //     $no_uraian++;
        // }
        // $uraian_was16b .="</table>";


        $tembusan="";
        $no_tembusan=1;
        $tembusan .="<table width='100%'>";
        foreach ($tembusan_was16c as $rowTembusan) {
            $tembusan .="<tr>
                            <td width='1%'>".(count($tembusan_was16c)>=2?$no_tembusan:' ')."</td>
                            <td>".$rowTembusan['tembusan']."</td>
                        </tr>";
            $no_tembusan++;
        }
        $tembusan .="</table>";

 		
 		$docx->setDefaultFont('Arial'); 
       $docx->replaceVariableByHTML('kejaksaan', 'inline','<h2 style="text-align: center;"><b><p>'.$kejaksaan.'</p></b></h2>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
       $docx->replaceVariableByHTML('lokasi', 'inline',$lokasi_surat, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
       $docx->replaceVariableByText(array('kepada_was16c'=>$kepada), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('di'=>$di), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('tanggal_was16c'=>$tanggal), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('nomor_was16c'=>$nomor), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('sifat_was16c'=>$akr.'-'.$sifat), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('lampiran_was16c'=>$lampiran), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('perihal_was16c'=>$perihal), array('parseLineBreaks'=>true));

       $docx->replaceVariableByText(array('nip_terlapor'=>$nip_terlapor), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('nama_terlapor'=>$nama_terlapor), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('pangkat_terlapor'=>$pangkat_terlapor), array('parseLineBreaks'=>true));
       // $docx->replaceVariableByText(array('golongan_terlapor'=>$jabatan_terlapor), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('jabatan_terlapor'=>$jabatan_terlapor), array('parseLineBreaks'=>true));
       
       $docx->replaceVariableByText(array('bentuk_hukuman'=>$bentuk_hukuman), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('tanggal_bawas7'=>$tanggal_ba), array('parseLineBreaks'=>true));

       $docx->replaceVariableByText(array('ttd_jabatan_alias'=>$jabatan_alias), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('ttd_jabatan'=>$jabatan_asli), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('ttd_nama'=>$nama_penandatangan), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('ttd_pangkat'=>$pangkat_penandatangan), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('ttd_nip'=>$nipTandatangan), array('parseLineBreaks'=>true));
       
       // $docx->replaceVariableByHTML('isi', 'block',$uraian_was16b, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));

       $docx->replaceVariableByHTML('tembusan', 'block',$tembusan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));

 		$docx->createDocx('template/pengawasan/was_16c');
		
        $file = 'template/pengawasan/was_16c.docx';

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