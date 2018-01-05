<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

    use app\modules\datun\models\Sp1;
    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pidum/P-7.docx');
    $satker = Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama;
    
    $nama1 ='';
    $no = 1;
    if (count($namatsk) != 0) {
        $nama1 = '<table border="0" ><tbody>';
        foreach ($namatsk as $rownamatsk) {
//            $nama1 .= $no."&nbsp; ".". ".$rownamatsk['nama']."<br/>";
            
           $nama1 .= '<tr><td width="10%" height="0%" style="font-family:Times New Roman; font-size:9pt; margin-left = 0px">'.$no.'</td>
                      <td width="70%" height="0%" style="font-family:Times New Roman; font-size:9pt; margin-left = 0px">'.$rownamatsk['nama'].'</td>
                      </tr>';
           $no++;
        }
//        $nama1;
        $nama1 .= "</tbody></table>";
    }
    
    $namauu ='';
    $no1 = 1;
    if (count($uu) != 0) {
        $namauu = '<table border="0" ><tbody>';
        foreach ($uu as $rowuu) {
//            $nama1 .= $no."&nbsp; ".". ".$rownamatsk['nama']."<br/>";
            
           $namauu .= '<tr><td width="10%" height="0%" style="font-family:Times New Roman; font-size:9pt; margin-left = 0px">'.$no1.'</td>
                      <td width="70%" height="0%" style="font-family:Times New Roman; font-size:9pt; margin-left = 0px">'.$rowuu['undang'].' '.$rowuu['pasal'].'</td>
                      </tr>';
           $no1++;
        }
//        $nama1;
        $namauu .= "</tbody></table>";
    }
    
    $namabb1 ='';
    $no2 = 1;
    if (count($uu) != 0) {
        $namabb1 = '<table border="0" ><tbody>';
        foreach ($namabb as $rownamabb) {
//            $nama1 .= $no."&nbsp; ".". ".$rownamatsk['nama']."<br/>";
            
           $namabb1 .= '<tr><td width="10%" height="0%" style="font-family:Times New Roman; font-size:9pt; margin-left = 0px">'.$no2.'</td>
                      <td width="70%" height="0%" style="font-family:Times New Roman; font-size:9pt; margin-left = 0px">'.$rownamabb['nama'].'</td>
                      </tr>';
           $no2++;
        }
//        $nama1;
        $namabb1 .= "</tbody></table>";
    }
    
    $docx->replaceVariableByText(array('kasus_posisi'=>$tahap2[0]['kasus_posisi']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('uraian'=>$cetakp7[0]['uraian']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('satker'=>$satker), array('parseLineBreaks'=>true));
    $docx->replaceVariableByHTML('nama1', 'block', $nama1, $arrDocnya);
    $docx->replaceVariableByHTML('namauu', 'block', $namauu, $arrDocnya);
    $docx->replaceVariableByHTML('namabb1', 'block', $namabb1, $arrDocnya);
    
    
    
    $docx->createDocx('../web/template/pidum_surat/P-7');
    $file = '../web/template/pidum_surat/P-7.docx';
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
