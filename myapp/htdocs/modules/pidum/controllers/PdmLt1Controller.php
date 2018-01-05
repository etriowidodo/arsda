<?php

namespace app\modules\pidum\controllers;

use Odf;
use Yii;
use yii\web\Controller;
use app\models\KpInstSatker;


class PdmLt1Controller extends Controller
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
        $odf = new \Odf(Yii::$app->params['report-path']."modules/pidum/template/lt1.odt");


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
	0 AS kdh,
	0 AS alihkan,
	0 AS tuntutan,
	0 AS instansi_lain,
	0 AS sisa_bulan_laporan
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
		EXTRACT (YEAR FROM spdp.tgl_terima) = '2015' --'".$_POST[' tahun ']."'
	AND EXTRACT (MONTH FROM spdp.tgl_terima) = '08'--'".$_POST[' tahun ']."'
	AND spdp.wilayah_kerja LIKE '06.09%'-- '%".$_POST[' wilayah_kerja ']."%'
	GROUP BY
		spdp.wilayah_kerja
) jml_msk_p21 ON (
	jml_msk_p21.wilayah_kerja = satker.inst_satkerkd
)
WHERE
			satker.inst_satkerkd LIKE '06.09%'
ORDER BY
	satker.inst_satkerinduk"
     )->queryAll();                      
            $odf->setVars('kejaksaan', Yii::$app->globalfunc->getNamaSatker($_POST['wilayah_kerja'])->inst_nama);   
    $listLaporan = $odf->setSegment('lt1');
    foreach ($query as $key => $value){
           $listLaporan->no($key+1);
             
           $listLaporan->sisa_bulan_lalu($value['sisa_bulan_lalu']);
           $listLaporan->masuk_bulan_laporan($value['masuk_bulan_laporan']);  
           $listLaporan->jml($value['sisa_bln_lalu'] + $value['masuk_bulan_laporan']);
           
           $listLaporan->demi_hukum($value['kdh']);
           $listLaporan->alihkan($value['alihkan']);
           $listLaporan->dilimpahkan($value['tuntutan']);
           $listLaporan->dikirim_ke($value['instansi_lain']);
           $listLaporan->jml_selesai($value['kdh'])+ ($value['alihkan'])+($value['tuntutan']) + ($value['instansi_lain']);
           
           $listLaporan->sisa_bulan_lap($value['sisa_bulan_laporan']);
          
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
