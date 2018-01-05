<?php
require_once('/wordtest/classes/CreateDocx.inc');

        $docx = new CreateDocxFromTemplate('../modules/pengawasan/template/was_18.docx');
        $kejaksaan=strtoupper($data_satker['inst_nama']);
        $lokasi=strtoupper($data_satker['inst_lokinst']);

        $tanggal		    =($model['tgl_was_18']!=''?\Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_was_18']):'-'); 
        $tanggal_disposisi	=($model['tgl_disposisi']!=''?\Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_disposisi']):'-'); 
        $no_was			    =($model['no_was_18']!=''?$model['no_was_18']:'-');   
        $lampiran		    =($model['lampiran']!=''?$model['lampiran']:'-');    
        $nama_terlapor		=($model['nama_pegawai_terlapor']!=''?$model['nama_pegawai_terlapor']:'-'); 
        $nip_terlapor		=($model['nip_pegawai_terlapor']!=''?$model['nip_pegawai_terlapor']:'-'); 
        $pangkat_terlapor	=($model['pangkat_pegawai_terlapor']!=''?$model['pangkat_pegawai_terlapor']:'-'); 
        $jabatan_terlapor	=($model['jabatan_pegawai_terlapor']!=''?$model['jabatan_pegawai_terlapor']:'-'); 
        $nama_ttd			=($model['nama_penandatangan']!=''?$model['nama_penandatangan']:'-'); 
        $nipttd	    		=($model['nip_penandatangan']!=''?$model['nip_penandatangan']:'-');   
        $sanksi	    		=($model['sanksi']!=''?$model['sanksi']:'-');    
        $pasal	    		=($model['pasal']!=''?$model['pasal']:'-');    
        $isi_laporan		=($model['isi_laporan']!=''?$model['isi_laporan']:'-');

        $nama_pemeriksa		=($pemeriksa['nama_pemeriksa']!=''?$pemeriksa['nama_pemeriksa']:'-');
        $pangkat_pemeriksa	=($pemeriksa['pangkat_pemeriksa']!=''?$pemeriksa['pangkat_pemeriksa']:'-');
        $jabatan_pemeriksa	=($pemeriksa['jabatan_pemeriksa']!=''?$pemeriksa['jabatan_pemeriksa']:'-');
        $nippemeriksa		=($pemeriksa['nip_pemeriksa']!=''?$pemeriksa['nip_pemeriksa']:'-');
        
        $nama_pelapor		=($pelapor['nama_pelapor']!=''?$pelapor['nama_pelapor']:'-');
        $alamat_pelapor		=($pelapor['alamat_pelapor']!=''?$pelapor['alamat_pelapor']:'-');

        $bentuk_pelanggaran	=($lwas2['bentuk_pelanggaran']!=''?$lwas2['bentuk_pelanggaran']:'-');

        $nip_ttd	        =substr($nipttd,0,8).' '.substr($nipttd,8,6).' '.substr($nipttd,14,1).' '.substr($nipttd,15,3);
        $nip_pemeriksa      =substr($nippemeriksa,0,8).' '.substr($nippemeriksa,8,6).' '.substr($nippemeriksa,14,1).' '.substr($nippemeriksa,15,3);
        $pangkat_penandatangan=$model['pangkat_penandatangan'];
         
		 $docx->replaceVariableByText(array('kejaksaan'=>strtoupper($kejaksaan)), array('parseLineBreaks'=>true));
		 $docx->replaceVariableByText(array('lokasi'=>$lokasi), array('parseLineBreaks'=>true)); 
		 $docx->replaceVariableByText(array('tanggal_was18'=>$tanggal), array('parseLineBreaks'=>true));
		 $docx->replaceVariableByText(array('tanggal_disposisi'=>$tanggal_disposisi), array('parseLineBreaks'=>true));
		 $docx->replaceVariableByText(array('nomor_surat'=>$no_was), array('parseLineBreaks'=>true));
		 $docx->replaceVariableByText(array('lampiran'=>$lampiran), array('parseLineBreaks'=>true));
		 $docx->replaceVariableByText(array('nama_terlapor'=>$nama_terlapor), array('parseLineBreaks'=>true));  
		 $docx->replaceVariableByText(array('nip_terlapor'=>$nip_terlapor), array('parseLineBreaks'=>true));  
		 $docx->replaceVariableByText(array('pangkat_terlapor'=>$pangkat_terlapor), array('parseLineBreaks'=>true));  
		 $docx->replaceVariableByText(array('jabatan_terlapor'=>$jabatan_terlapor), array('parseLineBreaks'=>true));  
		 $docx->replaceVariableByText(array('nama_penandatangan'=>$nama_ttd), array('parseLineBreaks'=>true));
         $docx->replaceVariableByText(array('nip_penandatangan'=>$nip_ttd), array('parseLineBreaks'=>true));
		 $docx->replaceVariableByText(array('pangkat_penandatangan'=>$pangkat_penandatangan), array('parseLineBreaks'=>true));
		 $docx->replaceVariableByText(array('sanksi'=>$sanksi), array('parseLineBreaks'=>true));
		 $docx->replaceVariableByText(array('pasal'=>$pasal), array('parseLineBreaks'=>true)); 
		 $docx->replaceVariableByText(array('nip_pemeriksa'=>$nip_pemeriksa), array('parseLineBreaks'=>true)); 
		 $docx->replaceVariableByText(array('nama_pemeriksa'=>$nama_pemeriksa), array('parseLineBreaks'=>true)); 
		 $docx->replaceVariableByText(array('pangkat_pemeriksa'=>$pangkat_pemeriksa), array('parseLineBreaks'=>true)); 
		 $docx->replaceVariableByText(array('jabatan_pemeriksa'=>$jabatan_pemeriksa), array('parseLineBreaks'=>true));
		 $docx->replaceVariableByText(array('nama_pelapor'=>$nama_pelapor), array('parseLineBreaks'=>true)); 
		 $docx->replaceVariableByText(array('alamat_pelapor'=>$alamat_pelapor), array('parseLineBreaks'=>true)); 
		 $docx->replaceVariableByText(array('bentuk_pelanggaran'=>$bentuk_pelanggaran), array('parseLineBreaks'=>true)); 
		 $docx->replaceVariableByHTML('isi_laporan', 'block','<p style="font-family:arial;">'.$isi_laporan.'</p>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
  
		// $no_register1 = str_replace("/","",$no_register);
        $docx->createDocx('template/pengawasan/was_18');
		
        $file = 'template/pengawasan/was_18.docx';

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