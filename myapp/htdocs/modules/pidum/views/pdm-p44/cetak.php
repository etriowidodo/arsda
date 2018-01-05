<?php

    use app\modules\datun\models\Sp1;
    use app\modules\pidum\models\PdmP41Terdakwa;
    use app\modules\pidum\models\PdmPutusanPn;
    use app\modules\pidum\models\PdmP42;
    use app\modules\pidum\models\PdmUuPasalTahap2;
    use app\modules\pidum\models\PdmMsRentut;
    use app\modules\pidum\models\PdmMsBarbukEksekusi;
    use app\modules\pidum\models\PdmBa5Barbuk;
    use app\modules\pidum\models\PdmJaksaP16a;
    use app\modules\pidum\models\PdmMsSatuan;
    use app\modules\pidum\models\PdmSpdp;


    require_once('./function/tgl_indo.php');
    require_once('./wordtest/classes/CreateDocx.inc');
    $docx   = new CreateDocxFromTemplate('../web/template/pidum/p44.docx');
    //$spdp   = PdmSpdp::findOne($session['id_perkara']);
    $satker = Yii::$app->globalfunc->getNamaSatker($session['inst_satkerkd'])->inst_nama;
    $docx->replaceVariableByText(array('kejaksaan'=>ucfirst(strtoupper($satker))), array('parseLineBreaks'=>true));
    //echo '<pre>';print_r($session);exit;

    $nop16a = Yii::$app->globalfunc->GetLastP16a()->no_surat_p16a;
    $jaksa = PdmJaksaP16a::findAll(['no_surat_p16a'=>$nop16a]);
    $nama_jaksa = '';
    foreach ($jaksa as $keyJaksa ) {
      $nama_jaksa .= $keyJaksa['nama'].', ';
    }
    //echo '<pre>';print_r($jaksa[0]['nama']);exit;
    $docx->replaceVariableByText(array('nama_penandatangan'=>$jaksa[0]['nama']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat'=>$jaksa[0]['pangkat']), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip_penandatangan'=>$jaksa[0]['nip']), array('parseLineBreaks'=>true));
    //echo $nama_jaksa;exit;
    $docx->replaceVariableByText(array('nama_jaksa_pu'=>$nama_jaksa), array('parseLineBreaks'=>true));
    //echo '<pre>';print_r($jaksa);exit;
    $pasal = PdmUuPasalTahap2::findAll(['no_register_perkara'=>$session['no_register_perkara']]);
    foreach($pasal as $key){
                $dft_pasal .= '- '.$key['pasal'] . ' ' . $key['undang'] . '<br>';
            }
    $barbuk = PdmBa5Barbuk::findAll(['no_register_perkara'=>$session['no_register_perkara']]);
    foreach($barbuk as $key){

                $dft_barbuk .= '- '.number_format($key['jumlah'],0,'.',',').' '.PdmMsSatuan::findOne($key['id_satuan'])->nama.' '.$key['nama']. '<br>';
            }

    //echo '<pre>';print_r($dft_barbuk);exit;

    //echo '<pre>';print_r($dft_pasal);exit;

    $tabel = '<table style="border-collapse:collapse;font-size:10px" width="100%" align="center" border="1" cellspacing="0" cellpadding="4">
            <thead>
                <tr style="font-weight:bold" align="center">
                    <td rowspan="2" width="2%" >No.</td>
                    <td rowspan="2" width="5%" >No Register Perkara</td>
                    <td rowspan="2" width="5%" >Identitas Lengkap Terdakwa</td>
                    <td rowspan="2" width="7%" >Pasal Dakwaan</td>
                    <td rowspan="2" width="7%" >Dakwaan Yang Dapat Dibuktikan</td>
                    <td colspan="4" width="32%" >Tuntutan Jaksa PU</td>
                    <td colspan="5" width="34%" >Putusan Hakim P.N</td>
                    <td rowspan="2" width="5%" >Sikap JPU / Terdakwa</td>
                    <td rowspan="2" width="3%" >Ket</td>
                </tr>
                    <tr style="font-weight:bold" align="center">
                       <td width="8%" >Pidana Badan</td>
                       <td width="5%" >Denda </td>
                       <td width="14%" >Barang Bukti</td>
                       <td width="5%" >Biaya perkara</td>
                       <td width="7%" >Dakwaan Yang Terbukti</td>
                       <td width="7%" >Pidana Badan</td>
                       <td width="7%" >Denda</td>
                       <td width="6%" >Barang Bukti</td>
                       <td width="7%" >Biaya Perkara</td>
                    </tr>
                </tr>
            </thead>';
    $urut = 1;

    foreach ($tersangka as $key => $value) {
        $id_pasal = json_decode($value['undang_undang']);
        
        if(!empty($id_pasal->undang)){
          foreach ($id_pasal->undang as $key2 => $value2) { 
            $pasal = PdmUuPasalTahap2::findOne(['no_register_perkara'=> $value['no_register_perkara'], 'id_pasal'=>$value2]);
            $bukti .= '- '.$pasal->undang.' '.$pasal->tentang.' '.$pasal->pasal.'<br>';
          }  
        }


        
                    $tahun = $value['y_badan']+ $value['y_coba'];
                    $bulan = $value['m_badan']+ $value['m_coba'];
                    $hari  = $value['d_badan']+ $value['d_coba'];

                    $tahun = $tahun > 0 ? $tahun. ' Tahun' : ''; 
                        if($hari>30){
                            $bulan++;
                            $hari = $hari%30;
                        }
                    $hari = $hari > 0 ? $hari. ' Hari' : ''; 

                        if($bulan>12){
                            $tahun++;
                            $bulan = $bulan%12;
                        }
                    $bulan = $bulan > 0 ? $bulan. ' Bulan' : ''; 
                    $pidana = $tahun.' '.$bulan.' '.$hari;


        $tabel .= '<tr align="left">
                       <td>'.$urut.'</td>';
        $tabel .= $key==0 ? '<td rowspan="'.count($tersangka).'" valign="top" align="left">'.$value['no_register_perkara'].'</td>' :'';
        $tabel .= '<td>'.$value['tersangka'].'</td>';
        $tabel .= $key==0 ? '<td rowspan="'.count($tersangka).'" valign="top" align="left">'.$dft_pasal.'</td>' :'';
        $tabel .=     '<td valign="top" >'.$bukti.'</td>
                       <td>'.$pidana.'</td>
                       <td align="right">'.number_format($value['denda'],0,'.',',').'</td>';
        $tabel .= $key==0 ? '<td rowspan="'.count($tersangka).'" valign="top" align="left">'.$dft_barbuk.'</td>' :'';
        $tabel .=     '<td align="right">'.number_format($value['biaya'],0,'.',',').'</td>';
        #tabel putusan PN

        
        $id_pasal_pn = json_decode($value['undang_undang_pn']);
        if(!empty($id_pasal_pn->undang)){
          ///echo '<pre>';print_r($id_pasal_pn->undang);exit;
              foreach ($id_pasal_pn->undang as $key_pn => $value_pn) { 
                $pasal_pn = PdmUuPasalTahap2::findOne(['no_register_perkara'=> $value['no_register_perkara'], 'id_pasal'=>$value_pn]);
                $bukti_pn .= '- '.$pasal_pn->undang.' '.$pasal_pn->tentang.' '.$pasal_pn->pasal.'<br>';
              }
        }
                          $tahun_pn = $value['y_badan_pn']+ $value['y_coba_pn'];
                          $bulan_pn = $value['m_badan_pn']+ $value['m_coba_pn'];
                          $hari_pn  = $value['d_badan_pn']+ $value['d_coba_pn'];

                          $tahun_pn = $tahun_pn > 0 ? $tahun_pn. ' Tahun' : ''; 
                              if($hari>30){
                                  $bulan_pn++;
                                  $hari_pn = $hari_pn%30;
                              }
                          $hari_pn = $hari_pn > 0 ? $hari_pn. ' Hari' : ''; 

                              if($bulan_pn>12){
                                  $tahun_pn++;
                                  $bulan_pn = $bulan_pn%12;
                              }
                          $bulan_pn = $bulan_pn > 0 ? $bulan_pn. ' Bulan' : ''; 
                          $pidana_pn = $tahun_pn.' '.$bulan_pn.' '.$hari_pn;

              $tabel .= '<td valign="top">'.$bukti_pn.'</td>
                         <td>'.$pidana_pn.'</td>
                         <td align="right">'.number_format($value['denda_pn'],0,'.',',').'</td>';
              $tabel .= $key==0 ? '<td rowspan="'.count($tersangka).'" valign="top" align="left">'.$dft_barbuk.'</td>' :'';
              $tabel .= '<td align="right">'.number_format($value['biaya_pn'],0,'.',',').'</td>';
              $tabel .= '<td>'.$value['usuljpu'].' / '.$value['usulterdakwa'].'</td>
                        <td></td>
                          </tr>';
                          $urut++;
            $bukti='';
            $bukti_pn='';    
        /*}else{*/
            //$tabel .='<td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
        //}
        
    }//exit;

    $tabel .='</table>';
    //echo $tabel;exit;
    $docx->replaceVariableByHTML('tabel', 'block', $tabel, $arrDocnya);
    $docx->replaceVariableByText(array('nama_kasi'=>''), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('pangkat_kasi'=>''), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('nip_kasi'=>''), array('parseLineBreaks'=>true));
    $p42 = PdmP42::findOne(['no_register_perkara'=>$session['no_register_perkara']]);
    $putusan = PdmPutusanPn::findOne(['no_register_perkara'=>$session['no_register_perkara']])->tgl_baca;
    $docx->replaceVariableByText(array('tgl_tut'=>Yii::$app->globalfunc->ViewIndonesianFormat($p42->tgl_dikeluarkan)), array('parseLineBreaks'=>true));
    $docx->replaceVariableByText(array('tgl_putus'=>Yii::$app->globalfunc->ViewIndonesianFormat($putusan)), array('parseLineBreaks'=>true));


    $docx->createDocx('../web/template/pidum_surat/p44');
    $file = '../web/template/pidum_surat/p44.docx';
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
