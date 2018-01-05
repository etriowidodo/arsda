<?php

    use app\modules\datun\models\Sp1;
    use app\modules\pidum\models\PdmBerkasTahap1;
    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pidum/p31.docx');

    $no_berkas = PdmBerkasTahap1::findOne(['id_berkas'=>$tahap2->id_berkas])->no_berkas;

    $connection = \Yii::$app->db;
    $satker     = ucwords(strtolower(Yii::$app->globalfunc->getNamaSatker($session['inst_satkerkd'])->inst_nama));
    $docx->replaceVariableByText(array('kejaksaan'=>$satker), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('no_print'=>$model->no_surat_p31), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kepala'=>'Kepala '.$satker), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nomor'=>$no_berkas), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('no_regbukti'=>$ba5->no_reg_bukti), array('parseLineBreaks'=>true));
    $regTahanan = Yii::$app->globalfunc->CtkNoRegTahananT7($model->no_register_perkara);
    $docx->replaceVariableByText(array('no_regtahanan'=>$regTahanan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('no_regperkara'=>$model->no_register_perkara), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tanggal'=>Yii::$app->globalfunc->ViewIndonesianFormat($tahap2->tgl_terima)), array('parseLineBreaks'=>true));

    $tabel = '';
    $tabel .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
    <thead>
        <tr>
            <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"7%\" style=\"font-size:12px\">No</td>
            <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"25%\" style=\"font-size:12px\">Nama Terdakwa </td>
            <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"25%\" style=\"font-size:12px\">Ditahan Penyidik/Penuntut Umum</td>
            <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"25%\" style=\"font-size:12px\">Jenis Tahanan <br> a.Rutan Tgl <br> b.Rumah Tgl <br> c.Kota Tgl</td>
            <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"13%\" style=\"font-size:12px\">Keterangan</td>
        </tr> 
        <tr>";
    for ($i=1; $i < 6; $i++) { 
      $tabel .= "<td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\">$i</td>";
    }
    $tabel .="</tr> 
    </thead>";

    $query = "SELECT a.nama_tersangka_ba4 as tersangka, a.nama_jaksa as jaksa , a.lama, a.tgl_mulai,
    COALESCE((select concat(c.lama, '^', c.tgl_mulai) from pidum.pdm_t7 c where a.no_register_perkara=c.no_register_perkara and c.tindakan_status='2' and a.no_reg_tahanan_jaksa=c.no_reg_tahanan_jaksa),'-') as perpanjangan,
    COALESCE((select concat(c.lama, '^', c.tgl_mulai) from pidum.pdm_t7 c where a.no_register_perkara=c.no_register_perkara and c.tindakan_status='3' and a.no_reg_tahanan_jaksa=c.no_reg_tahanan_jaksa),'-') as pengalihan
    from pidum.pdm_t7 a 
    where a.no_register_perkara= '".$model->no_register_perkara."' and a.tindakan_status='1' ";
    $detail = $connection->createCommand($query)->queryAll();
    //echo '<pre>';print_r($detail);exit;
    $no=1;
    foreach ($detail as $key => $value) {
      $nexta = $value[lama];
      $tgla = date('d-m-Y', strtotime($value[tgl_mulai]));
      $sda  = date("d-m-Y",strtotime($value[tgl_mulai] ." +".$nexta." day"));
      $la  = $tgla." S.d ".$sda; 

      $lb = $value[perpanjangan];
      if($value[perpanjangan]<>'-'){
        $b = explode('^', $value[perpanjangan]);
        $nextb = $b[0];
        $tglb = date('d-m-Y', strtotime($b[1]));
        $sdb  = date("d-m-Y",strtotime($b[1] ." +".$nextb." day"));
        $lb   = $tglb." S.d ".$sdb;    
      }
      
      $lc = $value[pengalihan];
      if($value[pengalihan]<>'-'){
        $c = explode('^', $value[pengalihan]);
        $nextc = $c[0];
        $tglc = date('d-m-Y', strtotime($c[1]));
        $sdc  = date("d-m-Y",strtotime($c[1] ." +".$nextc." day"));
        $lc   = $tglc." S.d ".$sdc; 
      }

      $tabel .= "<tr><td align=\"center\" style=\"font-size:12px\">$no</td>";
      $tabel .= "<td align=\"center\" style=\"font-size:12px\">".strtoupper($value[tersangka])."</td>";
      $tabel .= "<td align=\"center\" style=\"font-size:12px\">$value[jaksa]</td>";
      $tabel .= "<td align=\"left\" style=\"font-size:12px\">a.$la <br> b.$lb <br> c.$lc</td>";
      $tabel .= "<td align=\"center\" style=\"font-size:12px\"></td> </tr>";
      $no++;
    }    
    //echo $tabel;exit;
    $docx->replaceVariableByHTML('tabel', 'block', $tabel, $arrDocnya);
    $dft_pasal='';
    foreach($listPasal as $key){
            $dft_pasal .= $key['pasal']. ' ' .$key['tentang']. ' ' .$key['undang']. ', ';
    }
    $docx->replaceVariableByText(array('pasal'=>$dft_pasal), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('melimpahkan'=>$model->lokasi_pengadilan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nm'=>Yii::$app->globalfunc->getListTerdakwaBa4($model->no_register_perkara)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('di'=>ucwords($model->dikeluarkan)), array('parseLineBreaks'=>true));

    $docx->replaceVariableByText(array('dikeluarkan'=>ucwords($model->dikeluarkan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_dikeluarkan'=>Yii::$app->globalfunc->ViewIndonesianFormat($tahap2->tgl_terima)), array('parseLineBreaks'=>true));

    /*$sql ="select * from kepegawaian.kp_pegawai where peg_nip_baru='".$model->id_penandatangan."'";
    $modelx= $connection->createCommand($sql);
    $petugas = $modelx->queryOne();*/
    //echo '<pre>';print_r($petugas);exit;

    $docx->replaceVariableByText(array('pangkat'=>$model['pangkat_ttd']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('jabatan'=>$model['jabatan_ttd']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama_penandatangan'=> $model['nama_ttd']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip_penandatangan'=>$model->id_penandatangan), array('parseLineBreaks'=>true));

    $tembusan ='';
    if (count($listTembusan) != 0) {
        $tembusan = '<table border="0" ><tbody>';
        foreach ($listTembusan as $rowlistTembusan) {
           $tembusan .= '<tr><td width="2%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px"> '.$rowlistTembusan[no_urut].'.</td>
                             <td width="40%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 0px">'.$rowlistTembusan[tembusan].'</td>
                             </tr>';
        }
        $tembusan .= "</tbody></table>";
    }
    //echo $tabel;
    $docx->replaceVariableByHTML('tembusan', 'block', $tembusan, $arrDocnya);

    $docx->createDocx('../web/template/pidum_surat/p31');
    $file = '../web/template/pidum_surat/p31.docx';
    if (file_exists($file)){
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

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>