<?php
require_once('/wordtest/classes/CreateDocx.inc');

        $docx = new CreateDocxFromTemplate('../modules/pengawasan/template/was1_irmud_inspektur.docx');
        $kejaksaan='KEJAKSAAN AGUNG REPUBLIK INDONESIA';
        $no_register=($model['no_register']!=''?$model['no_register']:'<p></p>');
        $permasalahan=($model['was1_permasalahan']!=''?$model['was1_permasalahan']:'<p></p>');
        $data=($model['data']!=''?$model['data']:'<p></p>');
        $analisa=($model['was1_analisa']!=''?$model['was1_analisa']:'<p></p>');
        $saran=($model['isi_saran_was1']!=''?$model['isi_saran_was1']:'<p></p>');
        $kesimpulan=($model['was1_kesimpulan']!=''?$model['was1_kesimpulan']:'<p></p>');
        $var=str_split($_SESSION['is_inspektur_irmud_riksa']);
        
		$sts =(substr($model['jabatan'],0,1));
		/* print_r($sts);
		exit(); */
		
		if($sts=='0'){ //jabatansebenernya
			$nip=(''?:'<p></p>');
			$nama_penandatangan=($model['nama_penandatangan']!=''?$model['nama_penandatangan']:'<p></p>');
			$jabatan_alias=='';
			$s=(''?:'<p></p>');
			$golongan_penandatangan=(''?:'<p></p>');
			$jbtn=($model['jbtn_penandatangan']!=''?$model['jbtn_penandatangan']:'<p></p>');
		}elseif($sts=='1'){ //AN.
			$nip=($model['nip_1']!=''?$model['nip_1']:'<p></p>');
			$nama_penandatangan=($model['nama_penandatangan']!=''?$model['nama_penandatangan']:'<p></p>');
			$jabatan_alias=($model['jabatan_penandatangan']!=''?$model['jabatan_penandatangan']:'<p></p>');
			$golongan_penandatangan=($model['pangkat_penandatangan']!=''?$model['pangkat_penandatangan']:'<p></p>');
			$s=('/ NIP.'?:'<p></p>');
			$jbtn=($model['jbtn_penandatangan']!=''?$model['jbtn_penandatangan']:'<p></p>');
		}elseif($sts=='2'||$sts=='3'){ //Plt. & Plh.
			$nip=($model['nip_1']!=''?$model['nip_1']:'<p></p>');
			$nama_penandatangan=($model['nama_penandatangan']!=''?$model['nama_penandatangan']:'<p></p>');
			$jabatan_alias=($model['jabatan_penandatangan']!=''?$model['jabatan_penandatangan']:'<p></p>');
			$golongan_penandatangan=($model['pangkat_penandatangan']!=''?$model['pangkat_penandatangan']:'<p></p>');
			$s=('/ NIP.'?:'<p></p>');
			$jbtn=(''?:'<p></p>');
			}
		
		
		
        //$golongan_penandatangan=($model['pangkat_penandatangan']!=''?$model['pangkat_penandatangan']:'<p></p>');
       
        $kepada=($model['was1_kepada']!=''?$model['was1_kepada']:'<p></p>');
        $dari=($model['was1_dari']!=''?$model['was1_dari']:'<p></p>');
		//$jabatan_alias=($model['jabatan_penandatangan']!=''?$model['jabatan_penandatangan']:'<p></p>');
		
        $nomor=($model['no_surat']!=''?$model['no_surat']:'<p></p>');
        $tglsurat=($model['was1_tgl_surat']!=''?date('d F Y', strtotime($model['was1_tgl_surat'])):'<p></p>');
        $perihal=($model['was1_perihal']!=''?$model['was1_perihal']:'<p></p>');
        $lampiran=($model['was1_lampiran']!=''?$model['was1_lampiran']:'<p></p>');
        if($model['id_level_was1']=='2'){
              if($var[0]=='1'){
                $inspektur_jamwas='PENDAPAT / PERSETUJUAN INSPKEKTUR I';
                }else if($var[0]=='2'){
                $inspektur_jamwas='PENDAPAT / PERSETUJUAN INSPKEKTUR II';       
                }else if($var[0]=='3'){
                $inspektur_jamwas='PENDAPAT / PERSETUJUAN INSPKEKTUR III';       
                }else if($var[0]=='4'){
                $inspektur_jamwas='PENDAPAT / PERSETUJUAN INSPKEKTUR IV';       
                }else if($var[0]=='5'){
                $inspektur_jamwas='PENDAPAT / PERSETUJUAN INSPKEKTUR V';       
                }    
               
               // if($var[1]=='1'){
               //     $ttd='IRMUD PEGASUM DAN KEPBANG';     
               //  }elseif($var[1]=='2'){
               //     $ttd='PIDUM DAN DATUN';    
               //  }if($var[1]=='3'){
               //     $ttd='INTEl DAN PIDSUS';     
               //  }
        }elseif($model['id_level_was1']=='3'){
                $inspektur_jamwas='KEPUTUSAN JAKSA AGUNG MUDA PENGAWASAN<br>SETUJU/TIDAK SETUJU/PENDAPAT LAIN:';   
                //  if($var[0]=='1'){
                //    $ttd='Inspektur 1';     
                // }elseif($var[0]=='2'){
                //    $ttd='Inspektur 2';   
                // }if($var[0]=='3'){
                //    $ttd='Inspektur 3';     
                // }if($var[0]=='4'){
                //    $ttd='Inspektur 4';     
                // }if($var[0]=='5'){
                //    $ttd='Inspektur 5';     
                // }
        }
			
/* 		print_r(explode(' ',$model['jabatan_penandatangan']));
		exit(); */
		
		
		/* 
        if($model['status_penandatangan']=='0' OR $model['status_penandatangan']==''){
            $status='<p></p>';
        }else  if($model['status_penandatangan']=='1'){
            $status='<p>AN.</p>';
        }else  if($model['status_penandatangan']=='2'){
            $status='<p>PLH.</p>';
        }else  if($model['status_penandatangan']=='3'){
            $status='<p>PLT.</p>';
        }else{
             $status='<p></p>';
        } */

        // if($model['id_level_was1']=='2'){
                
        // }else if($model['id_level_was1']=='3'){
               
        // }
        
        $docx->replaceVariableByHTML('kejaksaan', 'inline','<h1 style="text-align: center;"><b><p>'.$kejaksaan.'</p></b></h1>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('permasalahan', 'inline','<p style="text-align: justify; margin-left: 20px;">'.$permasalahan.'</p>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('data', 'inline','<p style="text-align: justify; margin-left: 20px;">'.$data.'</p>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('analisa', 'block',$analisa, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('saran', 'inline','<p style="text-align: justify; margin-left: 20px;">'.$saran.'</p>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('kesimpulan', 'block','<p style="text-align: justify; margin-left: 20px;">'.$kesimpulan.'</p>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('inspektur_jamwas', 'inline','<b>'.$inspektur_jamwas.'</b>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('nama_penandatangan', 'inline','<u><b>'.strtoupper($nama_penandatangan).'</b></u>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('golongan_penandatangan', 'inline',$golongan_penandatangan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('nip', 'inline',$nip, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
		$docx->replaceVariableByHTML('s', 'inline',$s, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('ttd', 'inline','<b>'.strtoupper($jabatan_alias).'</b>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
		$docx->replaceVariableByHTML('ttd1', 'inline','<b>'.strtoupper($jbtn).'</b>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        // header nota dinas
        $docx->replaceVariableByHTML('kepada', 'inline','<b>'.strtoupper($kepada).'</b>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('dari', 'inline',$dari, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('nomor', 'inline',$nomor, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('tglsurat', 'inline',$tglsurat, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('perihal', 'inline',$perihal, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        //$docx->replaceVariableByHTML('status', 'inline','<b>'.$status.'</b>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('lampiran', 'inline',$lampiran, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        // $docx->replaceVariableByHTML('CHUNK_1', 'block', 'http://www.2mdc.com/PHPDOCX/example.html', array('isFile' => true, 'parseDivsAsPs' => true,  'filter' => '#capa_bg_bottom', 'downloadImages' => true));
        // $docx->replaceVariableByHTML('CHUNK_2', 'block', 'http://www.2mdc.com/PHPDOCX/example.html', array('isFile' => true, 'parseDivsAsPs' => false,  'filter' => '#lateral', 'downloadImages' => true));
		$no_register1 = str_replace("/","",$no_register);
        $docx->createDocx('template/pengawasan/Was1_Disposisi_'.$no_register1);

        $file = 'template/pengawasan/Was1_Disposisi_'.$no_register1.'.docx';

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
