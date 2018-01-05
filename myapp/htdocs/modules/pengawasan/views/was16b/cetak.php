<?php
require_once('/wordtest/classes/CreateDocx.inc');
        $docx = new CreateDocxFromTemplate('../modules/pengawasan/template/was16b.docx');
        $kejaksaan=strtoupper($data_satker['inst_nama']);
        // $kejaksaan1=ucwords($data_satker['inst_nama']);
        // $lokasi_surat=ucwords($data_satker['inst_lokinst']);
        // $lokasi=strtoupper($data_satker['inst_lokinst']);
        // permintaan kang putut lokasi harus ada spasi
        // $x=strlen($lokasi);
        // $lokasi1='';
        // for ($i=0; $i <$x ; $i++) { 
        //     $lokasi1 .=$lokasi[$i].' ';
        // }
        // $nomor         =($model['no_was14d']!=''?$model['no_was14d']:'<p></p>');

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
         
        $kepada               =$model['kpd_was_16b'];
        $dari                 =$model['dari_was_16b'];
        $nomor                ='ND- '.$model['no_was_16b'];
        // $sifat           		  =$model['sifat_surat'];
        $lampiran             =$model['lampiran'];
        $perihal              =$model['perihal'];
        $nama_terlapor        =$model['nama_pegawai_terlapor'];
        $pangkat_terlapor     =$model['pangkat_pegawai_terlapor'].'('.$model['golongan_pegawai_terlapor'].')';
        $nip_terlapor         =$model['nip_pegawai_terlapor'].($model['nrp_pegawai_terlapor']==''?'':'/'.$model['nrp_pegawai_terlapor']);
        $jabatan_terlapor     =$model['jabatan_pegawai_terlapor'];
        $nomor_surat          =$modelwas15['no_was15'];
        $dari_was15           =$modelwas15['dari_was15'];

        $jabtan_penandatangan	=$model['jabatan_penandatangan'];
		$jbtn_penandatangan =(substr($model['jabatan_penandatangan'],0,2)=='AN'?$model['jbtn_penandatangan']:'');
        $nama_penandatangan		=$model['nama_penandatangan'];
        $pangkat_penandatangan	=$model['pangkat_penandatangan'];
        $nipTandatangan= '  NIP. '.substr($model['nip_penandatangan'],0,8).' '.substr($model['nip_penandatangan'],8,6).' '.substr($model['nip_penandatangan'],14,1).' '.substr($model['nip_penandatangan'],15,3);

    //     $detail_uraian="";
    //     $no=1;
    //     foreach ($modelwas14d as $row_uraian) {
    //     	if(count($modelwas14)<=1){
				// $detail_uraian .=$row_uraian['isi_uraian'];
    //     	}else{
				// $detail_uraian .=$no.' '.$row_uraian['isi_uraian'].'<br>';
    //     	}
    //     	$no++;
	   //  }
	   //  $detail_uraian=$detail_uraian;
        $detail_uraian="";
        $no_uraian=1;
        $uraian_was16b .="<table width='100%' style='font-family:arial;'>";
        foreach ($modelwas16b as $rowUraian) {
            $uraian_was16b .="<tr>
                            <td width='5%' style='vertical-align:top;'>".(count($modelwas16b)>=2?$no_uraian:' ')."</td>
                            <td width='95%' style='text-align:justify;margin-top:0px;'>".$rowUraian['isi']."</td>
                        </tr>";
            $no_uraian++;
        }
        $uraian_was16b .="</table><style> table tr td p {
							margin-top:0px!important;
						}</style>";
		

        // <td width='1%'>".(count($modelTembusan)>=2?$no_tembusan:' ')."</td>
        $tembusan="";
        $no_tembusan=1;
        $tembusan .="<table width='100%' style='font-family:arial;'>";
        foreach ($modelTembusan as $rowTembusan) {
            $tembusan .="<tr>
                            <td>".$rowTembusan['tembusan']."</td>
                        </tr>";
            $no_tembusan++;
        }
        $tembusan .="</table>";

 		
 		$docx->setDefaultFont('Arial'); 
       $docx->replaceVariableByHTML('kejaksaan', 'inline','<h4 style="text-align: center; font-family:arial;"><b><p>'.$kejaksaan.'</p></b></h4>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
       // $docx->replaceVariableByHTML('lokasi', 'inline','<h2 style="text-align: center;"><b><p>'.$lokasi.'</p></b></h2>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
       $docx->replaceVariableByText(array('kepada'=>strtoupper($kepada)), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('dari'=>ucwords(strtolower($dari))), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('tgl_was_16b'=>$tanggal), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('no_was_16b'=>$nomor), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('sifat_surat'=>$sifat), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('jml_lampiran'=>$lampiran), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('perihal'=>$perihal), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('nama_terlapor'=>$nama_terlapor), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('pangkat_terlapor'=>$pangkat_terlapor), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('nip_terlapor'=>$nip_terlapor), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('jabatan_terlapor'=>ucwords(strtolower($jabatan_terlapor))), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('nomor_surat'=>$nomor_surat), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('dari_was15'=>$dari_was15), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('tanggal'=>$tanggalWas15), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('ttd_dari'=>strtoupper($jabtan_penandatangan)), array('parseLineBreaks'=>true));
	   $docx->replaceVariableByText(array('jbtn_penandatangan'=>$jbtn_penandatangan), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('ttd_peg_nama'=>$nama_penandatangan), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('ttd_jabatan'=>$pangkat_penandatangan), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('ttd_peg_nip'=>$nipTandatangan), array('parseLineBreaks'=>true));
       // $docx->replaceVariableByText(array('nama_penandatangan'=>$nama_penandatangan), array('parseLineBreaks'=>true));
       // $docx->replaceVariableByText(array('pangkat_penandatangan'=>$pangkat_penandatangan), array('parseLineBreaks'=>true));
       // $docx->replaceVariableByText(array('nip_penandatangan'=>$nipTandatangan), array('parseLineBreaks'=>true));
       
       $docx->replaceVariableByHTML('isi', 'block',$uraian_was16b, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false,'filter' => '//p[@class="heading2"]|//ul|//table'));

       $docx->replaceVariableByHTML('tembusan', 'block',$tembusan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));

 		$docx->createDocx('template/pengawasan/was16b');
		
        $file = 'template/pengawasan/was16b.docx';

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