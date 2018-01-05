<?php

namespace app\modules\pidum\controllers;


use Odf;
use Yii;
use yii\web\Controller;
use app\models\KpInstSatker;

class PdmLp14Controller extends Controller
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
        $odf = new \Odf(Yii::$app->params['report-path']."modules/pidum/template/lp14.odt");


        if($_POST['new_check'] != null){
          $wilayah = substr($_POST['wilayah_kerja'], 0,2);
          $wilayah_kerja =  "AND satker.inst_satkerkd LIKE '%".$wilayah."%'";
        }else{
          $wilayah_kerja = "AND satker.inst_satkerkd = '".$_POST['wilayah_kerja']."' ";
        }
        
        $query = Yii::$app->db->createCommand(
     "SELECT
	satker.inst_nama,
	'-' AS sisa_napi,
	'-' AS sisa_no_pn,
	'-' AS sisa_tgl_pn,
	'-' AS sisa_no_men_keh,
	'-' AS sisa_tgl_men_keh,
	'-' AS sisa_syarat_umum,
	'-' AS sisa_syarat_khusus,
	
	
	'-' AS msk_napi,
	'-' AS msk_no_pn,
	'-' AS msk_tgl_pn,
	'-' AS msk_no_men_keh,
	'-' AS msk_tgl_men_keh,
	'-' AS msk_syarat_umum,
	'-' AS msk_syarat_khusus,
	
	'-' AS tgl_penuh_syt_um,
	'-' AS tgl_langgar_syt_um,
	
	'-' AS tgl_penuh_syt_khs,
	'-' AS tgl_langgar_syt_khs,
	
	'-' AS sisa_bulan_lap
FROM
	kepegawaian.kp_inst_satker satker
LEFT JOIN (
	SELECT
		spdp.wilayah_kerja,
		COUNT (*) jml
	FROM
		pidum.pdm_spdp spdp
	RIGHT JOIN pidum.pdm_p52 p52 ON (
		spdp.id_perkara = p52.id_perkara
	)
	WHERE
		EXTRACT (YEAR FROM spdp.tgl_terima) = '2015' --'".$_POST[' tahun ']."'
	AND EXTRACT (MONTH FROM spdp.tgl_terima) = '08'--'".$_POST[' tahun ']."'
	AND spdp.wilayah_kerja LIKE '06.09%'-- '%".$_POST[' wilayah_kerja ']."%'
	GROUP BY
		spdp.wilayah_kerja
) jml_msk_p52 ON (
	jml_msk_p52.wilayah_kerja = satker.inst_satkerkd
)
WHERE
			satker.inst_satkerkd LIKE '06.09%'
ORDER BY
	satker.inst_satkerinduk"
          )->queryAll();               
              
    $odf->setVars('kejaksaan', Yii::$app->globalfunc->getNamaSatker($_POST['wilayah_kerja'])->inst_nama);   
    $listLaporan = $odf->setSegment('lp14');
    foreach ($query as $key => $value){
           $listLaporan->no($key+1);
           
           $listLaporan->sisa_napi($value['sisa_napi']);
           $listLaporan->sisa_no_pn($value['sisa_no_pn']);
           $listLaporan->sisa_no_men_keh($value['sisa_no_men_keh']);
           $listLaporan->sisa_umum($value['sisa_syarat_umum']);
           $listLaporan->sisa_khusus($value['sisa_syarat_khusus']);
           $listLaporan->msk_napi($value['msk_napi']);
           $listLaporan->msk_no_pn($value['msk_no_pn']);
           $listLaporan->masuk_keh($value['msk_tgl_men_keh']);
           $listLaporan->masuk_umum($value['msk_syarat_umum']);
           $listLaporan->masuk_khusus($value['msk_syarat_khusus']);
           $listLaporan->umum_dipenuhi($value['tgl_penuh_syt_um']);
           $listLaporan->umum_dilanggar($value['tgl_langgar_syt_um']);
           $listLaporan->khusus_dipenuhi($value['tgl_penuh_syt_khs']);
           $listLaporan->khusus_dilanggar($value['tgl_langgar_syt_khs']);
           $listLaporan->sisa_bulan_laporan($value['sisa_bulan_laporan']);
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
