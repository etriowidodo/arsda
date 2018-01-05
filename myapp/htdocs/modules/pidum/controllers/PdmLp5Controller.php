<?php

namespace app\modules\pidum\controllers;

use Odf;
use Yii;
use yii\web\Controller;
use app\models\KpInstSatker;


class PdmLp5Controller extends Controller
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
        $odf = new \Odf(Yii::$app->params['report-path']."modules/pidum/template/lp5.odt");



        if($_POST['new_check'] != null){
          $wilayah = substr($_POST['wilayah_kerja'], 0,2);
          $wilayah_kerja =  "AND satker.inst_satkerkd LIKE '%".$wilayah."%'";
        }else{
          $wilayah_kerja = "AND satker.inst_satkerkd = '".$_POST['wilayah_kerja']."' ";
        }
        
   $query = Yii::$app->db->createCommand(
                 
        "SELECT
	satker.inst_nama,
	0 AS sisa_bulan_lalu,
	0 AS masuk_bulan_laporan,
	0 AS limpah_pn,
	0 AS henti_tut,
	0 AS kirim_ke,
	0 AS sisa_bulan_lap,
	0 AS pasal_langgar
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
//    $odf->setVars('tahun', $tahun);
//    $odf->setVars('bulan', strtoupper($this->getNamaBulan($bulan)));
    $listLaporan = $odf->setSegment('lp5');
    foreach ($query as $key => $value){
           $listLaporan->no($key+1);
           $listLaporan->nama($value['inst_nama']);
           $listLaporan->sisa_bln_lalu($value['sisa_bln_lalu']);
           $listLaporan->masuk_bln_lap($value['masuk_bulan_laporan']);
           $listLaporan->jml_bln_lap($value['sisa_bln_lalu'] + $value['masuk_bulan_laporan']);
           $listLaporan->dpt_dilimpahkan($value['limpah_pn']);
           $listLaporan->dihentikan_penuntut($value['henti_tut']);
           $listLaporan->dikirim_ke($value['kirim_ke']);
           $listLaporan->jml($value['']);    
           $listLaporan->sisa_bln_lap($value['sisa_bln_lap']);   
           $listLaporan->pasal_yg_dilanggar($value['pasal_langgar']);
           $listLaporan->merge();
        }   
        $odf->mergeSegment($listLaporan);
      
        $odf->exportAsAttachedFile();
      }
        
      }
       public function getSatker(){
        $satker = KpInstSatker::find()
                    ->select("inst_satkerkd as id, inst_nama as text")
                    ->asArray()
                    ->all();
        
        return $satker;
    } 
}
