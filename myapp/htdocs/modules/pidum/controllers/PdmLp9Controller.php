<?php

namespace app\modules\pidum\controllers;

use Odf;
use Yii;
use yii\web\Controller;
use app\models\KpInstSatker;

class PdmLp9Controller extends Controller
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
        $odf = new \Odf(Yii::$app->params['report-path']."modules/pidum/template/lp9.odt");


        if($_POST['new_check'] != null){
          $wilayah = substr($_POST['wilayah_kerja'], 0,2);
          $wilayah_kerja =  "AND satker.inst_satkerkd LIKE '%".$wilayah."%'";
        }else{
          $wilayah_kerja = "AND satker.inst_satkerkd = '".$_POST['wilayah_kerja']."' ";
        }
        
        $query = Yii::$app->db->createCommand(
                    "SELECT
                     satker.inst_nama,
                     0 AS usul_tdk_bukti,
                     0 AS usul_tndk_pidana,
                     0 AS usul_dm_hukum,
                     0 AS usul_ttp_hukum,
                     0 AS stjui_tdk_bukti,
                     0 AS stjui_tndk_pidana,
                     0 AS stjui_dm_hukum,
                     0 AS stjui_ttp_hukum,

                     0 AS sisa_tdk_bukti,
                     0 AS sisa_tndk_pidana,
                     0 AS sisa_dm_hukum,
                     0 AS sisa_ttp_hukum
             FROM
	kepegawaian.kp_inst_satker satker
            LEFT JOIN (
                SELECT
                        spdp.wilayah_kerja,
                        COUNT (*) jml
                FROM
                        pidum.pdm_spdp spdp
                RIGHT JOIN pidum.pdm_p21 p21 ON (
                        spdp.id_perkara = p21.id_perkara
                )
                WHERE
                        EXTRACT (YEAR FROM spdp.tgl_terima) = '2015'
                AND EXTRACT (MONTH FROM spdp.tgl_terima) = '07'
                AND spdp.wilayah_kerja LIKE '%06.09%'
                GROUP BY
                                spdp.wilayah_kerja
                ) jml_msk_p21 ON (
                        jml_msk_p21.wilayah_kerja = satker.inst_satkerkd
                )
                WHERE
                        1 = 1
                AND satker.inst_satkerkd = '06.09'
                ORDER BY
                satker.inst_satkerinduk"
               )->queryAll();  
        
    $odf->setVars('kejaksaan', Yii::$app->globalfunc->getNamaSatker($_POST['wilayah_kerja'])->inst_nama);   
    $listLaporan = $odf->setSegment('lp9');
    foreach ($query as $key => $value){
           $listLaporan->no($key+1);
           $listLaporan->nama($value['inst_nama']);
           $listLaporan->usul_tidak_cukup_bkt($value['usul_tdk_bkt']);
           $listLaporan->usul_pidana($value['usul_tindak_pidana']);
           $listLaporan->usul_penyampingan($value['-']);
           $listLaporan->usul_hukum($value['usul_dm_hukum']);
           
           $listLaporan->setuju_tidak_cukup_bkt($value['stjui_tdk_bukti']);
           $listLaporan->pidana_setuju($value['stjui_tindak_pidana']);
           $listLaporan->setuju_penyampingan($value['-']);
           $listLaporan->hukum_setuju($value['stjui_dm_hukum']);
                
           $listLaporan->sisa_tidak_cukup_bkt($value['stjui_tdk_bukti']);
           $listLaporan->sisa_pidana($value['stjui_tindak_pidana']);
           $listLaporan->sisa_penyampingan($value['-']);
           $listLaporan->sisa_hukum($value['stjui_dm_hukum']);
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
