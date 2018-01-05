<?php
require_once('/wordtest/classes/CreateDocx.inc');
        $docx = new CreateDocxFromTemplate('../modules/pengawasan/template/was14d_inspeksi.docx');
        $kejaksaan=strtoupper($data_satker['inst_nama']);
        // $kejaksaan1=ucwords($data_satker['inst_nama']);
        $lokasi_surat=ucwords($data_satker['inst_lokinst']);
        $lokasi=strtoupper($data_satker['inst_lokinst']);
        /*permintaan kang putut lokasi harus ada spasi*/
        $x=strlen($lokasi);
        $lokasi1='';
        for ($i=0; $i <$x ; $i++) { 
            $lokasi1 .=$lokasi[$i].' ';
        }
        $nomor         =($model['no_was14d']!=''?$model['no_was14d']:'<p></p>');

        if($model['sifat_was14d']=='0'){
            $sifat="Biasa";
            $akr="B";
         }else if($model['sifat_was14d']=='1'){
            $sifat="Segera";
            $akr="S";
         }else if($model['sifat_was14d']=='2'){
            $sifat="Rahasia";
            $akr="R";
         }
        $lampiran         		=$model['lampiran_was14d'];
        $perihal          		=$model['perihal_was14d'];
        $kepada           		=$model['kepada_was14d'];
        $tempat           		=$lokasi_surat;
        $tanggal_surat   	 	=\Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_was14d']);
        $di 			  		=$model['di_was14d'];
        
        $penandatanga_spwas2    =$modelSpwas2['jabatan_penandatangan'];
        $nomor_spwas2    		=$modelSpwas2['nomor_sp_was2'];
        $tanggal_spwas2   	 	=\Yii::$app->globalfunc->ViewIndonesianFormat($modelSpwas2['tanggal_sp_was2']);

        $nama_terlapor    		=$model['nama_terlapor'];
        $pangkat_terlapor  		=$model['pangkat_terlapor'];
        $nip_terlapor    		=$model['nip_terlapor'];
        $nrp_terlapor    		=$model['nrp_terlapor'];
        $pasal_pelanggaran    	=$model['pasal_pelanggaran'];
        $hukdisnya		    	=$model['hukdis'];

        $jabtan_penandatangan =$model['jabatan_penandatangan'];
        $jbtn_penandatangan	=(substr($model['jabatan_penandatangan'],0,2)=='AN'?$model['jbtn_penandatangan']:'');
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
        $uraian_was14d_inspeksi .="<table width='100%'>";
        foreach ($modelwas14d as $rowUraian) {
            $uraian_was14d_inspeksi .="<tr>
                            <td width='1%'>".(count($modelwas14d)>=2?$no_uraian:' ')."</td>
                            <td>".$rowUraian['isi_uraian']."</td>
                        </tr>";
            $no_uraian++;
        }
        $uraian_was14d_inspeksi .="</table>";



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
        $docx->replaceVariableByHTML('lokasi', 'inline','<h2 style="text-align: center;"><b><p>'.$lokasi.'</p></b></h2>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
       $docx->replaceVariableByText(array('nomor_surat'=>$akr.'-'.$nomor), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('sifat_surat'=>$sifat), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('lampiran'=>$lampiran), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('perihal'=>$perihal), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('kepada'=>$kepada), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('tempat'=>ucwords(strtolower($tempat))), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('tanggal_surat'=>$tanggal_surat), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('di'=>ucwords(strtolower($di))), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('penandatanga_spwas2'=>ucwords(strtolower($penandatanga_spwas2))), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('nomor_spwas2'=>$nomor_spwas2), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('tanggal_spwas2'=>$tanggal_spwas2), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('nama_terlapor'=>$nama_terlapor), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('pangkat_terlapor'=>$pangkat_terlapor), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('nip_terlapor'=>$nip_terlapor), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('nrp_terlapor'=>$nrp_terlapor), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('pasal_pelanggaran'=>$pasal_pelanggaran), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('hukdisnya'=>$hukdisnya), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('jabatan_penandatangan'=>$jabtan_penandatangan), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('jbtn_penandatangan'=>$jbtn_penandatangan), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('nama_penandatangan'=>$nama_penandatangan), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('pangkat_penandatangan'=>$pangkat_penandatangan), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('nip_penandatangan'=>$nipTandatangan), array('parseLineBreaks'=>true));
       
       $docx->replaceVariableByHTML('uraian_was14d_inspeksi', 'block',$uraian_was14d_inspeksi, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));

       $docx->replaceVariableByHTML('tembusan', 'block',$tembusan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));

 		$docx->createDocx('template/pengawasan/was14d_inspeksi');
		
        $file = 'template/pengawasan/was14d_inspeksi.docx';

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