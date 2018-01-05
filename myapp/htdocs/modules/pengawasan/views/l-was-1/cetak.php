<?php
require_once('/wordtest/classes/CreateDocx.inc');

        $docx = new CreateDocxFromTemplate('../modules/pengawasan/template/LWas1.docx');
        
        $html=$modelSatker->inst_nama;
        
        $nopemeriksa=1;
        foreach ($modelPemeriksaSpWas1 as $key) {
        $pemeriksa .="<b><br>".$key->nama_pemeriksa."</b></br>";
        $pemeriksa .="<br>".$key->pangkat_pemeriksa."</br>";
        $pemeriksa .="<br>".$key->nip."</br>";
        $pemeriksa .="<br>".$key->jabatan_pemeriksa."</br><br></br>";
        $pem_nama.="<br>".$nopemeriksa.'.) '."			NAMA     :</br><br>					PANGKAT :</br><br>					NIP/NRP :</br><br>				JABATAN  :</br><br></br>";
        $nopemeriksa++;
        }

        if(count($SaksiInternal)>0){
          $nosaksiInt=1;
          foreach ($SaksiInternal as $key_saksiIn) {
            $saksiInt.="<br><b>".$key_saksiIn->nama_saksi_internal."</b></br>";
            $saksiInt.="<br>".$key_saksiIn->pangkat_saksi_internal."</br>";
            $saksiInt.="<br>".$key_saksiIn->nip."</br>";
            $saksiInt.="<br>".$key_saksiIn->jabatan_saksi_internal."</br><br></br>";
            $saksi_namaIn.="<br>".$nosaksiInt.'.) '."			NAMA     :</br><br>			PANGKAT :</br><br>			NIP/NRP :</br><br>			JABATAN  :</br><br></br>";
            $nosaksiInt++;
          }
        }else{
            $saksiInt.="<br>";
            $saksi_namaIn.="<br>";
        }

        if(count($SaksiEksternal)>0){
            $no_saksiEk=1;
          foreach ($SaksiEksternal as $key_saksiEk) {
            $saksiEk.="<br>".$no_saksiEk.'. '."NAMA :".$key_saksiEk->nama_saksi_eksternal."</br>";
            $saksi_namaEk.="<br>NAMA</br>";
            $no_saksiEk++;
          }
        }else{
            $saksiEk.="<br>";
            $saksi_namaEk.="<br>";
        }

        $no=1;
        foreach ($modelPemeriksaSpWas1 as $key) {
        $tim_pemeriksa .="<br>".$no.'. '.$key->nama_pemeriksa."</br>";
		$tim_pemeriksa .="<br>".$key->pangkat_pemeriksa.'. '."NIP. ".$key->nip."</br>";
		$tim_pemeriksa .="<br>";
		$tim_pemeriksa .="<br>";
        $no++;
        }
      // print_r($model->tanggal_lwas1);
      // print_r(count($SaksiEksternal));
      // exit();
// exit();
  
        $docx->replaceVariableByHTML('kejaksaan', 'block','<div style="text-align:center;"><b>'.strtoupper($html).'</b></div>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('di', 'inline','<div style="text-align:center;">'.$modelSatker->inst_lokinst .'</div>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
		$docx->replaceVariableByHTML('dix', 'inline','<div style="text-align:center;"><b>'.strtoupper($modelSatker->inst_lokinst).'</b></div>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('tgl_lwas1', 'inline','<div style="text-align:center;">'.date('d F Y', strtotime($model->tanggal_lwas1)) .'</div>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        
        $docx->replaceVariableByHTML('pemeriksa', 'inline',$pemeriksa, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('saksiinertnal', 'inline',$saksiInt, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('saksieksternal', 'inline',$saksiEk, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('permasalahan', 'block',$model->permasalahan_lwas1, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('data', 'block',$model->data_lwas1, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('analisa', 'block',$model->analis_lwas1, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('kesimpulanpendapat', 'inline',$model->pendapat, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        

        $docx->replaceVariableByHTML('pejabat_lwas1', 'inline',$modelSpWas1->nama_penandatangan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('no_sp_was_1', 'inline',$modelSpWas1->nomor_sp_was1, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('tgl_sp_was_1', 'inline',date('d F Y', strtotime($modelSpWas1->tanggal_sp_was1)), array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));


        $docx->replaceVariableByHTML('tim_pemeriksa', 'inline',$tim_pemeriksa, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        


        $docx->replaceVariableByHTML('pem_nama', 'inline',$pem_nama, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('saksi_namaEk', 'inline',$saksi_namaEk, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('saksi_namaIn', 'inline',$saksi_namaIn, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
  //       $docx->replaceVariableByHTML('irmud', 'inline','<b>'.$irmud.'<b>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        
  //       $docx->replaceVariableByHTML('nama_penandatangan', 'inline','<u><b>'.strtoupper($nama_penandatangan).'</b></u>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
  //       $docx->replaceVariableByHTML('golongan_penandatangan', 'inline',$golongan_penandatangan, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
		// $docx->replaceVariableByHTML('s', 'inline',$s, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
  //       $docx->replaceVariableByHTML('nip', 'inline',$nip, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
  //       $docx->replaceVariableByHTML('tempat', 'inline',$tempat, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
  //       $docx->replaceVariableByHTML('tglcetak', 'inline',date('d F Y', strtotime($tglcetak)), array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
  //       $docx->replaceVariableByHTML('status', 'inline','<b>'.$status.'</b>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
  //       $docx->replaceVariableByHTML('jabatan', 'inline','<b>'.$jabatan_alias.'</b>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
		// $docx->replaceVariableByHTML('ttd1', 'inline','<b>'.$jbtn.'</b>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
  //       // $docx->replaceVariableByHTML('irmud', 'inline','<b>'.$irmud.'<b>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
  //       // $docx->replaceVariableByHTML('CHUNK_1', 'block', 'http://www.2mdc.com/PHPDOCX/example.html', array('isFile' => true, 'parseDivsAsPs' => true,  'filter' => '#capa_bg_bottom', 'downloadImages' => true));
  //       // $docx->replaceVariableByHTML('CHUNK_2', 'block', 'http://www.2mdc.com/PHPDOCX/example.html', array('isFile' => true, 'parseDivsAsPs' => false,  'filter' => '#lateral', 'downloadImages' => true));
		// $no_register1 = str_replace("/","",$no_register);
        $docx->createDocx('template/pengawasan/LWas1');
		
        $file = 'template/pengawasan/LWas1.docx';

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