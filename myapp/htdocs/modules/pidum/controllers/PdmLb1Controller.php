<?php

namespace app\modules\pidum\controllers;

use Odf;
use Yii;
use yii\web\Controller;
use app\models\KpInstSatker;

class PdmLb1Controller extends Controller
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
        $odf = new \Odf(Yii::$app->params['report-path']."modules/pidum/template/lb1.odt");


        if($_POST['new_check'] != null){
          $wilayah = substr($_POST['wilayah_kerja'], 0,2);
          $wilayah_kerja =  "AND satker.inst_satkerkd LIKE '%".$wilayah."%'";
        }else{
          $wilayah_kerja = "AND satker.inst_satkerkd = '".$_POST['wilayah_kerja']."' ";
        }
        
        $query = Yii::$app->db->createCommand(
                "select
                    0 AS reg_barbuk,
                    0 AS dik_reg_perkara,
                    0 AS tut_reg_perkara,
                    '-' AS detail_barbuk,
                    '-' AS tmpt_simpan,
                    '-' AS tersangaka,
                    '-' AS pasal_dakwa,
                    '-' AS sel_psl,
                    '-' AS pidana,
                    '-' AS instansi_lain,
                    '-' AS hentikan,
                    '-' AS limpahkan,
                    '-' AS no_tgl_pengadilan,
                    '-' AS tgl_putusan,
                    '-' AS keterangan
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
    $listLaporan = $odf->setSegment('lb1');
    foreach ($query as $key => $value){
           $listLaporan->no($key+1);
             
           $listLaporan->reg_barbuk($value['reg_barbuk']);
           $listLaporan->dik_reg_perkara($value['dik_reg_perkara']);  
           $listLaporan->tut_reg_perkara($value['tut_reg_perkara']);
           $listLaporan->detail_barbuk($value['detail_barbuk']);
           $listLaporan->tmpt_simpan($value['tmpt_simpan']);
           $listLaporan->tersangka($value['tersangaka']);
           $listLaporan->psl_dakwa($value['psl_dakwa']);
           $listLaporan->sel_psl($value['sel_psl']);
           $listLaporan->pidana($value['pidana']);
           $listLaporan->instansi_lain($value['instansi_lain']);
           $listLaporan->hentikan($value['hentikan']);
           $listLaporan->limpahkan($value['limpahkan']);
           $listLaporan->no_tgl_pengadilan($value['no_tgl_pengadilan']);
           $listLaporan->tgl_putusan($value['tgl_putusan']);
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
