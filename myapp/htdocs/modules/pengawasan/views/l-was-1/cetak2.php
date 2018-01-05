<?php
require_once('/wordtest/classes/CreateDocx.inc');

        $docx = new CreateDocxFromTemplate('../modules/pengawasan/template/LWas1rev.docx');
        
        $html=$modelSatker->inst_nama;
        
        $nopemeriksa=1;
        foreach ($modelPemeriksaSpWas1 as $key) {
        $pemeriksa .="<br>: <b>".$key->nama_pemeriksa."</b></br>";
        $pemeriksa .="<br>: ".$key->pangkat_pemeriksa."</br>";
        $pemeriksa .="<br>: ".substr($key->nip,0,7).' '.substr($key->nip,8,6).' '.substr($key->nip,14,1).' '.substr($key->nip,15,3)."</br>";
		
        $pemeriksa .="<br>: ".$key->jabatan_pemeriksa."</br><br></br>";
        $pem_nama.="<br>".$nopemeriksa.'.) '."      NAMA      </br><br>         PANGKAT </br><br>          NIP/NRP  </br><br>        JABATAN  </br><br></br>";
        $nopemeriksa++;
        }
        
        if(count($modelTerlapor)>0){
            $no_peg_terlapor=1;
          foreach ($modelTerlapor as $peg_terlapor) {
            $pegawai_terlapor .="<br>: <b>".$peg_terlapor['nama_pegawai_terlapor']."</b></br>";
            $pegawai_terlapor .="<br>: ".$peg_terlapor['pangkat_pegawai_terlapor']."</br>";
            if($peg_terlapor['nrp_pegawai_terlapor']!='' and $peg_terlapor['nip']==''){
            $pegawai_terlapor .="<br>: ".$peg_terlapor['nrp_pegawai_terlapor']."</br>";
            }else if($peg_terlapor['nrp_pegawai_terlapor']=='' and $peg_terlapor['nip']!=''){
            $pegawai_terlapor .="<br>: ".$peg_terlapor['nip']."</br>";
            }else if($peg_terlapor['nrp_pegawai_terlapor']!='' and $peg_terlapor['nip']!=''){
            $pegawai_terlapor .="<br>: ".$peg_terlapor['nip'].'/'.$peg_terlapor['nrp_pegawai_terlapor']."</br>";
            }else{
            $pegawai_terlapor .="<br>: </br>";
            }
            $pegawai_terlapor .="<br>: ".$peg_terlapor['jabatan_pegawai_terlapor']."</br><br></br>";
            $nama_pegawai_terlapor.="<br>".$no_peg_terlapor.'.) '."      NAMA      </br><br>         PANGKAT </br><br>          NIP/NRP  </br><br>        JABATAN  </br><br></br>";
            $no_peg_terlapor++;
          }
        }else{
            $pegawai_terlapor.="<br>";
            $nama_pegawai_terlapor.="<br>";
        }

        $no=1;
        foreach ($modelPemeriksaSpWas1 as $key) {
        $tim_pemeriksa .="<br>".$no.'. '.$key->nama_pemeriksa."</br>";
		$tim_pemeriksa .="<br>".$key->pangkat_pemeriksa.'. '."NIP. ".substr($key->nip,0,7).' '.substr($key->nip,8,6).' '.substr($key->nip,14,1).' '.substr($key->nip,15,3)."</br>";
		$tim_pemeriksa .="<br>";
		$tim_pemeriksa .="<br>";
        $no++;
        }
      // print_r($model->tanggal_lwas1);
      // print_r(count($SaksiEksternal));
      // exit();
// exit();
        $docx->setDefaultFont('Arial');
        $docx->replaceVariableByHTML('kejaksaan', 'block','<h2 style="text-align:center;">'.strtoupper($html).'</h2>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('di', 'inline','<div style="text-align:center;">'.$modelSatker->inst_lokinst .'</div>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
		    $docx->replaceVariableByHTML('dix', 'inline','<h2 style="text-align:center;">'.strtoupper($modelSatker->inst_lokinst).'</h2>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
       
       $docx->replaceVariableByText(array('tgl_lwas1'=>\Yii::$app->globalfunc->ViewIndonesianFormat($model->tanggal_lwas1)), array('parseLineBreaks'=>true));
       
        // $docx->replaceVariableByHTML('tgl_lwas1', 'inline','<div style="text-align:center;">'.\Yii::$app->globalfunc->ViewIndonesianFormat($model->tanggal_lwas1) .'</div>', array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        
        $docx->replaceVariableByHTML('pemeriksa', 'inline',$pemeriksa, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('pegawai_terlapor', 'inline',$pegawai_terlapor, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        // $docx->replaceVariableByHTML('saksieksternal', 'inline',$saksiEk, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('permasalahan', 'block',$model->permasalahan_lwas1, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('data', 'block',$model->data_lwas1, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('analisa', 'block',$model->analis_lwas1, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('kesimpulanpendapat', 'inline',$model->pendapat, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        

       
        $docx->replaceVariableByText(array('pejabat_lwas1'=>$modelSpWas1->jabatan_penandatangan), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('no_sp_was_1'=>$modelSpWas1->nomor_sp_was1), array('parseLineBreaks'=>true));
        $docx->replaceVariableByText(array('tgl_sp_was_1'=>\Yii::$app->globalfunc->ViewIndonesianFormat($modelSpWas1->tanggal_sp_was1)), array('parseLineBreaks'=>true));

        // $docx->replaceVariableByHTML('no_sp_was_1', 'inline',$modelSpWas1->nomor_sp_was1, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));

        // $docx->replaceVariableByHTML('tgl_sp_was_1', 'inline',\Yii::$app->globalfunc->ViewIndonesianFormat($modelSpWas1->tanggal_sp_was1), array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));


        $docx->replaceVariableByHTML('tim_pemeriksa', 'inline',$tim_pemeriksa, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        


        $docx->replaceVariableByHTML('pem_nama', 'inline',$pem_nama, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        $docx->replaceVariableByHTML('nama_pegawai_terlapor', 'inline',$nama_pegawai_terlapor, array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
        
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