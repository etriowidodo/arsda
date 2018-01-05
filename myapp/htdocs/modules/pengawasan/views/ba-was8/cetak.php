<?php
require_once('/wordtest/classes/CreateDocx.inc');

        $docx = new CreateDocxFromTemplate('../modules/pengawasan/template/ba_was_8.docx');
        $kejaksaan=strtoupper($data_satker['inst_nama']);
        $lokasi=strtoupper($data_satker['inst_lokinst']);
		$tertol	= $model['terima_tolak'];
		if($tertol==1){
			$terima_tolak 	= 'Menerima';
			$terima_tolak2 	= 'MENERIMA';
			$pengajuan		= 'tidak akan mengajukan';
			$pengajuan2		= 'TIDAK AKAN MENGAJUKAN';
		}else{
			$terima_tolak 	= 'Menolak';
			$terima_tolak2 	= 'MENOLAK';
			$pengajuan		= 'akan mengajukan';
			$pengajuan2		= 'AKAN MENGAJUKAN';
		}
		
		$kategori	= $ba_was_7['kategori_hukuman'];
		if($kategori==1){
			$kategori_hukuman = 'Ringan';
		}else if($kategori==2){
			$kategori_hukuman = 'Sedang';
		}else{
			$kategori_hukuman = 'Berat';
		}
         
        $nipmenerima   	  	=($model['nip_terlapor']!=''?$model['nip_terlapor']:'-');
        $nama_menerima      =($model['nama_terlapor']!=''?$model['nama_terlapor']:'-');
        $pangkat_menerima   =($model['pangkat_terlapor']!=''?$model['pangkat_terlapor']:'-');
        $jabatan_menerima   =($model['jabatan_terlapor']!=''?$model['jabatan_terlapor']:'-');  
        $pasal			    =($ba_was_7['pasal']!=''?$ba_was_7['pasal']:'-');  
        $tanggal		    =($model['tgl_ba_was_8']!=''?\Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_ba_was_8']):'-'); 
        $tempat			    =($model['tempat']!=''?$model['tempat']:'<p></p>');   
        $nama_penerima	    =($model['nama_menerima']!=''?$model['nama_menerima']:'-'); 
        $nippenerima	    =($model['nip_menerima']!=''?$model['nip_menerima']:'-'); 
        $nip_menerima       =substr($nipmenerima,0,8).' '.substr($nipmenerima,8,6).' '.substr($nipmenerima,14,1).' '.substr($nipmenerima,15,3);
        $nip_penerima       =substr($nippenerima,0,8).' '.substr($nippenerima,8,6).' '.substr($nippenerima,14,1).' '.substr($nippenerima,15,3);
		
		
         
		$docx->replaceVariableByText(array('kejaksaan'=>strtoupper($kejaksaan)), array('parseLineBreaks'=>true));
		$docx->replaceVariableByText(array('lokasi'=>$lokasi), array('parseLineBreaks'=>true)); 
		$docx->replaceVariableByText(array('terima_tolak'=>$terima_tolak), array('parseLineBreaks'=>true));
		$docx->replaceVariableByText(array('terima_tolak2'=>$terima_tolak2), array('parseLineBreaks'=>true));
		$docx->replaceVariableByText(array('pengajuan'=>$pengajuan), array('parseLineBreaks'=>true));
		$docx->replaceVariableByText(array('pengajuan2'=>$pengajuan2), array('parseLineBreaks'=>true));
		$docx->replaceVariableByText(array('nama'=>$nama_menerima), array('parseLineBreaks'=>true));
		$docx->replaceVariableByText(array('pangkat'=>$pangkat_menerima), array('parseLineBreaks'=>true));
		$docx->replaceVariableByText(array('nip'=>$nip_menerima), array('parseLineBreaks'=>true));
		$docx->replaceVariableByText(array('jabatan'=>$jabatan_menerima), array('parseLineBreaks'=>true)); 
		$docx->replaceVariableByText(array('tanggal'=>$tanggal), array('parseLineBreaks'=>true)); 
		$docx->replaceVariableByText(array('tempat'=>$tempat), array('parseLineBreaks'=>true)); 
		$docx->replaceVariableByText(array('nip_penerima'=>$nip_penerima), array('parseLineBreaks'=>true)); 
		$docx->replaceVariableByText(array('nama_penerima'=>$nama_penerima), array('parseLineBreaks'=>true)); 
		$docx->replaceVariableByText(array('pasal_8'=>$pasal), array('parseLineBreaks'=>true)); 
		$docx->replaceVariableByText(array('berupa_8'=>$kategori_hukuman), array('parseLineBreaks'=>true)); 

            
		// $no_register1 = str_replace("/","",$no_register);
        $docx->createDocx('template/pengawasan/ba_was_8');
		
        $file = 'template/pengawasan/ba_was_8.docx';

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