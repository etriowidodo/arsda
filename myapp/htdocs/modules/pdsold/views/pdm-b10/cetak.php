<?php

    use app\modules\datun\models\Sp1;
    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pdsold/b10.docx');
    $connection = \Yii::$app->db;
    $satker     = ucwords(strtolower(Yii::$app->globalfunc->getNamaSatker($session['inst_satkerkd'])->inst_nama));
    $docx->replaceVariableByText(array('kejaksaan'=>$satker), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tanggal'=>Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_b10)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama'=>$tersangka), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('reg_perkara_nomor'=>$model->no_register_perkara), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('reg_bensit'=>$ba5->no_reg_bukti), array('parseLineBreaks'=>true));
    $tabel = '';
    $tabel .="<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
    <thead>
        <tr>
            <td bgcolor=\"#CCCCCC\" rowspan=\"2\" align=\"center\" width=\"10%\" style=\"font-size:12px\">Jenis Barang Bukti</td>
            <td bgcolor=\"#CCCCCC\" colspan=\"2\" align=\"center\" width=\"20%\" style=\"font-size:12px\">Tanggung Jawab Diterima di Kejaksaan</td>
            <td bgcolor=\"#CCCCCC\" rowspan=\"2\" align=\"center\" width=\"9%\" style=\"font-size:12px\">Tanggal Pelimpahan Ke PN</td>
            <td bgcolor=\"#CCCCCC\" rowspan=\"2\" align=\"center\" width=\"9%\" style=\"font-size:12px\">Diktum Tuntutan Pidana</td>
            <td bgcolor=\"#CCCCCC\" rowspan=\"2\" align=\"center\" width=\"9%\" style=\"font-size:12px\">Tanggal dan Nomor Putusan Pengadilan</td>
            <td bgcolor=\"#CCCCCC\" rowspan=\"2\" align=\"center\" width=\"9%\" style=\"font-size:12px\">Amar Putusan PN/PT/MA</td>
            <td bgcolor=\"#CCCCCC\" rowspan=\"2\" align=\"center\" width=\"9%\" style=\"font-size:12px\">Pelaksanaan Putusan Tunggal</td>
            <td bgcolor=\"#CCCCCC\" rowspan=\"2\" align=\"center\" width=\"5%\" style=\"font-size:12px\">ket</td>          
        </tr> 
        <tr>
            <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"10%\" style=\"font-size:12px\">Tanggal</td>
            <td bgcolor=\"#CCCCCC\" align=\"center\" width=\"10%\" style=\"font-size:12px\">Tanda Tangan Petugas Bukti</td>         
        </tr>           
        <tr>";
    for ($i=1; $i < 10; $i++) { 
      $tabel .= "<td bgcolor=\"#CCCCCC\" align=\"center\" style=\"font-size:12px\">$i</td>";
    }
    $tabel .="</tr> 
    </thead>";
    $modelBarbuk = json_decode($model->barbuk);
    foreach ($modelBarbuk as $key => $value) {
      if($key<>0){
        $lel .= ','.$value;
      }else{
        $lel = $value;
      }
    } //echo '<pre>';print_r($lel);exit;

    //echo '<pre>';print_r($modelBarbuk);exit;
    $query = "SELECT a.no_register_perkara,b.tgl_ba5, b.nama, b.no_urut_bb, (select c.nama from pidum.pdm_ba5_jaksa c where c.no_register_perkara=a.no_register_perkara limit 1) as jaksa,  '' as tgl_limpah
      from pidum.pdm_ba5 a left join pidum.pdm_barbuk b on a.no_register_perkara=b.no_register_perkara
      where a.no_register_perkara= '".$model->no_register_perkara."' and b.no_urut_bb in ($lel) ";
      //echo '<pre>';print_r($query);exit;
    $detail = $connection->createCommand($query)->queryAll();
    foreach ($detail as $key => $value) {
      $tgl_ba5 = date('d-m-Y', strtotime($value[tgl_ba5]));
      $detbarbuk = Yii::$app->globalfunc->GetDetBarbuk($model->no_register_perkara,$value['no_urut_bb']);
      //$tgl_limpah = date('d-m-Y', strtotime($value[tgl_ba5]));
      $tabel .= "<tr><td align=\"center\" style=\"font-size:12px\">$detbarbuk</td>";
      $tabel .= "<td align=\"center\" style=\"font-size:12px\">$tgl_ba5</td>";
      $tabel .= "<td align=\"center\" style=\"font-size:12px\">$value[jaksa]</td>";
      $tabel .= "<td align=\"center\" style=\"font-size:12px\">$value[tgl_limpah]</td>";

      $tabel .= "<td align=\"center\" style=\"font-size:12px\"></td>";
      $tabel .= "<td align=\"center\" style=\"font-size:12px\"></td>";
      $tabel .= "<td align=\"center\" style=\"font-size:12px\"></td>";
      $tabel .= "<td align=\"center\" style=\"font-size:12px\"></td>";
      $tabel .= "<td align=\"center\" style=\"font-size:12px\"></td> </tr>";
    }    
    $docx->replaceVariableByHTML('tabel', 'block', $tabel, $arrDocnya);
    //echo $tabel;
    $docx->createDocx('../web/template/pdsold_surat/b10');
    $file = '../web/template/pdsold_surat/b10.docx';
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
