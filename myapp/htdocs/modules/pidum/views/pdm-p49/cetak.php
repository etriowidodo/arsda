<?php

    use app\modules\datun\models\Sp1;
    use app\modules\pidum\models\PdmUuPasalTahap2;
    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pidum/P-49.docx');
    $satker = Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama;
    $docx->replaceVariableByText(array('kejaksaan'=>ucfirst(strtoupper($satker))), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nomor_p49'=> $p49->no_surat_p49), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('suket'=> $p49->surat_kematian), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('ditetapkan'=> $p49->dikeluarkan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tanggal1'=> Yii::$app->globalfunc->ViewIndonesianFormat($p49->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('Kejaksaan'=>$pangkat->jabatan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nama_penandatangan'=>$pangkat->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat'=>$pangkat->pangkat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip_penandatangan'=>$pangkat->peg_nip_baru), array('parseLineBreaks'=>true));
    
    $docx->replaceVariableByText(array('nama'=> $tersangka->nama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tempat_lahir'=> $tersangka->tmpt_lahir), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_lahir'=> Yii::$app->globalfunc->ViewIndonesianFormat($tersangka->tgl_lahir)), array('parseLineBreaks'=>true));
    $umur = Yii::$app->globalfunc->datediff($tersangka->tgl_lahir, date("Y-m-d"));
    $docx->replaceVariableByText(array('umur'=> $umur['years'] . ' tahun'), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('jenis_kelamin'=> $tersangka->is_jkl), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('kebangsaan'=> $tersangka->warganegara1), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tempat_tinggal'=> $tersangka->alamat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('agama'=> $tersangka->is_agama), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pekerjaan'=> $tersangka->pekerjaan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pendidikan'=> $tersangka->is_pendidikan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('reg_perkara'=> $brks_thp_1->id_perkara), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nomor_bukti'=> $no_barbuk->no_reg_bukti), array('parseLineBreaks'=>true));
    
    $docx->replaceVariableByText(array('pengadilan'=> $putusan_pn->pengadilan), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('1nomor_pn'=> $putusan_pn->no_surat), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('1tanggal_pn'=> Yii::$app->globalfunc->ViewIndonesianFormat($putusan_pn->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('sejak1'=> Yii::$app->globalfunc->ViewIndonesianFormat($putusan_pn->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    
    $th_pdn         = $put_pn_tsk->pidana_badan_tahun==''?'':$put_pn_tsk->pidana_badan_tahun.' Tahun';
    $bln_pdn        = $put_pn_tsk->pidana_badan_bulan==''?'':$put_pn_tsk->pidana_badan_bulan.' Bulan';
    $hr_pdn         = $put_pn_tsk->pidana_badan_hari==''?'':$put_pn_tsk->pidana_badan_hari.' Hari';
    $hasil1         = $th_pdn.' '.$bln_pdn.' '.$hr_pdn;
    $docx->replaceVariableByText(array('pidana'=> $hasil1), array('parseLineBreaks'=>true));
    
//    $pasal  = json_decode($put_pn_tsk->undang_undang);
//    print_r($pasal);exit();
//    $hasil_pasal ='';
//    foreach ($pasal as $rowpasal) {
//        $hasil_pasal .= $rowpasal.' ';
//    }
//    echo $hasil_pasal;exit();
//    $docx->replaceVariableByText(array('pasal'=> $hasil_pasal), array('parseLineBreaks'=>true));
//    
    
    $dibuktikan ='';
    $i=1;
    $udg=[];
    if (count($put_pn_tsk) != 0) {
//        $dibuktikan = '<table border="0" width="100%"><tbody>';
            $udg    = json_decode($put_pn_tsk->undang_undang);
//            print_r($udg);exit();
            $n = 1;
            For ($i=0;$i<count($udg->undang);$i++) {
//               $udg1 .= $udg->undang[$i];
                
               $qry   = PdmUuPasalTahap2::findOne(['id_pasal' => $udg->undang[$i]]);
//               $hasil_undang    .= $rowbukti['nama'].' '.$qry->undang.', ';
               $dibuktikan .= $qry->pasal.' ';
               $n++;
            }
           
//        print_r($hasil_undang);exit();
//        echo $hasil_undang;exit();
//        print_r($udg->undang[0]);exit();
//        $dibuktikan .= "</tbody></table>";
    }
//    $docx->replaceVariableByHTML('pasal', 'block', $dibuktikan, $arrDocnya);
    $docx->replaceVariableByText(array('pasal1'=> $dibuktikan), array('parseLineBreaks'=>true));
    
//    print_r($barbuk[0][nama]);exit();
    $barbuk_ ='';
    if (count($barbuk) != 0) {
        $barbuk_ = '<table border="0" width="100%"><tbody>';
//        $i=1;
        for ($i = 0; $i < count($barbuk); $i++){
           $barbuk_ .= '<tr><td width="11%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px">- Benda sitaan/barang bukti '.$barbuk[$i][nama].' '.$barbuk[$i][sts_eksekusi].'</td>
                             </tr>';
        }
        $barbuk_ .= "</tbody></table>";
    }
    $docx->replaceVariableByHTML('barbuk', 'block', $barbuk_, $arrDocnya);
    
    
    $alasan_ ='';
    if (count($alasan) != 0) {
        $alasan_ = '<table border="0" width="100%"><tbody>';
//        $i=1;
        for ($i = 0; $i < count($alasan); $i++){
           $alasan_ .= '<tr><td width="11%" height="0%" style="font-family:Times New Roman; font-size:11pt; margin-left = 10px">'.($i+1).'. '.$alasan[$i].'</td>
                             </tr>';
        }
        $alasan_ .= "</tbody></table>";
    }
    $docx->replaceVariableByHTML('mengingat', 'block', $alasan_, $arrDocnya);
    
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
    $docx->replaceVariableByHTML('tembusan', 'block', $tembusan, $arrDocnya);
    
    
    
    $docx->createDocx('../web/template/pidum_surat/P-49');
    $file = '../web/template/pidum_surat/P-49.docx';
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
