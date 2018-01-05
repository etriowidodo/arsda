<?php
require_once('/wordtest/classes/CreateDocx.inc');
        $docx = new CreateDocxFromTemplate('../modules/pengawasan/template/was-17.docx');
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
         
        $kepada               =$model['kpd_was_17'];
        $dari                 =$model['dari_was_17'];
        $nomor                =$model['no_was_17'];
        $lampiran             =$model['lampiran'];
        $perihal              =$model['perihal'];
        $nama_terlapor        =$model['nama_pegawai_terlapor'];
        $nip_terlapor         =substr($model['nip_pegawai_terlapor'],0,8).' '.substr($model['nip_pegawai_terlapor'],8,6).' '.substr($model['nip_pegawai_terlapor'],14,1).' '.substr($model['nip_pegawai_terlapor'],15,3).($model['nrp_pegawai_terlapor']!=''?'/':' ').$model['nrp_pegawai_terlapor'];
        $pangkat_terlapor	    =$model['pangkat_pegawai_terlapor'] .' ('.$model['golongan_pegawai_terlapor'].')';
        $jabatan_terlapor     =$model['jabatan_pegawai_terlapor'];

        $jabtan_penandatangan =$model['jabatan_penandatangan'];
        $nama_penandatangan   =$model['nama_penandatangan'];
        $pangkat_penandatangan=$model['pangkat_penandatangan'] .' ('.$model['golongan_penandatangan'].')';
        $nipTandatangan       ='  NIP. '.substr($model['nip_penandatangan'],0,8).' '.substr($model['nip_penandatangan'],8,6).' '.substr($model['nip_penandatangan'],14,1).' '.substr($model['nip_penandatangan'],15,3);
        $bentuk_hukuman       =$modelSk['isi_sk'];
        $bentuk_pelanggaran   =$modelLwas2['bentuk_pelanggaran'];
        $jabatan_mkj          =$model['jabatan_mkj'];
   
        $tembusan="";
        $no_tembusan=1;
        $tembusan .="<table width='100%' style='font-family:Arial;'>";
        foreach ($modelTembusan as $rowTembusan) {
            $tembusan .="<tr>
                            <td width='1%'>".(count($modelTembusan)>=2?$no_tembusan:' ')."</td>
                            <td>".$rowTembusan['tembusan']."</td>
                        </tr>";
            $no_tembusan++;
        }
        $tembusan .="</table>";

 		
 		$docx->setDefaultFont('Arial'); 
       $docx->replaceVariableByHTML('kejaksaan', 'inline','<h2 style="text-align: center;font-family:Arial;"><b><p>'.$kejaksaan.'</p></b></h2>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
    
       $docx->replaceVariableByText(array('kpd_was_17'=>$kepada), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('dari_was_17'=>$dari), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('tgl_was_17'=>$tanggal), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('no_was_17'=>$nomor), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('sifat'=>$sifat), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('lampiran'=>$lampiran), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('perihal'=>$perihal), array('parseLineBreaks'=>true));

       $docx->replaceVariableByText(array('nama_terlapor'=>$nama_terlapor), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('pangkat_terlapor'=>$pangkat_terlapor), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('nip_terlapor'=>$nip_terlapor), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('jabatan_terlapor'=>$jabatan_terlapor), array('parseLineBreaks'=>true));
       
       $docx->replaceVariableByText(array('bentuk_hukuman'=>$bentuk_hukuman), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('pelanggaran_disiplin'=>$bentuk_pelanggaran), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('jabatan_mkj'=>$jabatan_mkj), array('parseLineBreaks'=>true));
       
       $docx->replaceVariableByText(array('ttd_dari'=>$jabtan_penandatangan), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('ttd_nama'=>$nama_penandatangan), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('ttd_jabatan'=>$pangkat_penandatangan), array('parseLineBreaks'=>true));
       $docx->replaceVariableByText(array('ttd_nip'=>$nipTandatangan), array('parseLineBreaks'=>true));

       $docx->replaceVariableByHTML('tembusan1', 'block',$tembusan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));

 		$docx->createDocx('template/pengawasan/was-17');
		
        $file = 'template/pengawasan/was-17.docx';

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