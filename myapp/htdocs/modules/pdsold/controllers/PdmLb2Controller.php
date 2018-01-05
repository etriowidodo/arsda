<?php

namespace app\modules\pdsold\controllers;

use Odf;
use Yii;
use yii\web\Controller;
use app\models\KpInstSatker;

class PdmLb2Controller extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    public function actionCetak()
    {
        if($_POST['bulan'] == null){
        echo "<script>alert('harap pilih bulan');window.history.back();</script>";
      }elseif ($_POST['tahun'] == null) {
          echo "<script>alert('harap pilih tahun');window.history.back();</script>";
      }else{
        $odf = new \Odf(Yii::$app->params['report-path']."modules/pdsold/template/lb2.odt");


        if($_POST['new_check'] != null){
          $wilayah = substr($_POST['wilayah_kerja'], 0,2);
          $wilayah_kerja =  "AND satker.inst_satkerkd LIKE '%".$wilayah."%'";
        }else{
          $wilayah_kerja = "AND satker.inst_satkerkd = '".$_POST['wilayah_kerja']."' ";
        }
        
        $query = Yii::$app->db->createCommand(
                "SELECT
                        satker.inst_nama,
                        0 AS sisa_bln_lalu,
                        0 AS msk_bln_laporan,
                        0 AS instansi_lain,
                        0 AS demi_umum,
                        0 AS dihentikan_tut,
                        0 AS dikembalikan,
                        0 AS dilelang,
                        0 AS dilelang_negara,
                        0 AS dimanfaatkan_negara,
                        0 AS dimusnahkan
                        from
                kepegawaian.kp_inst_satker satker
        LEFT JOIN (
                SELECT
                        spdp.wilayah_kerja,
                        COUNT (*) jml
                FROM
                        pidum.pdm_spdp spdp
                RIGHT JOIN pidum.pdm_p51 p51 ON (
                        spdp.id_perkara = p51.id_perkara
                )
                WHERE
	EXTRACT (YEAR FROM spdp.tgl_terima) = '2015' --'".$_POST[' tahun ']."'
	AND EXTRACT (MONTH FROM spdp.tgl_terima) = '08'--'".$_POST[' tahun ']."'
	AND spdp.wilayah_kerja LIKE '06.09%'-- '%".$_POST[' wilayah_kerja ']."%'
	GROUP BY
                            spdp.wilayah_kerja
            ) jml_msk_p51 ON (
                    jml_msk_p51.wilayah_kerja = satker.inst_satkerkd
            )
            WHERE
                satker.inst_satkerkd LIKE '06.09%'
            ORDER BY
                    satker.inst_satkerinduk"
    )->queryAll();        
        
    $odf->setVars('kejaksaan', Yii::$app->globalfunc->getNamaSatker($_POST['wilayah_kerja'])->inst_nama);   
    $listLaporan = $odf->setSegment('lb2');
    foreach ($query as $key => $value){
           $listLaporan->no($key+1);
           
             $listLaporan->nama($value['inst_nama']);
             $listLaporan->sisa_bln_lalu($value['sisa_bln_lalu']);
             $listLaporan->msk_bln_lap($value['msk_bln_laporan']);
             $listLaporan->jml_bln_laporan($value['sisa_bulan_lalu'] + $value['masuk_bulan_lalu']);
             $listLaporan->instansi_lain($value['instansi_lain']);
             $listLaporan->demi_umum($value['demi_umum']);
             $listLaporan->dihentikan_tut($value['dihentikan_tut']);
             $listLaporan->dikembalikan($value['dikembalikan']);
             $listLaporan->dilelang($value['dilelang']);
             $listLaporan->dilelang_negara($value['dilelang_negara']);
             $listLaporan->dimanfaatkan_negara($value['dimanfaatkan_negara']);        
             
             $listLaporan->dimusnahkan($value['dimusnahkan']);
             $listLaporan->merge();
        }   
        $odf->mergeSegment($listLaporan);
      
        $odf->exportAsAttachedFile();      
                
      }
    }
    
    public function getSatker() {
        $satker = KpInstSatker::find()
                ->select("inst_satkerkd as id, inst_nama as text")
                ->asArray()
                ->all();

        return $satker;
    }
 }
