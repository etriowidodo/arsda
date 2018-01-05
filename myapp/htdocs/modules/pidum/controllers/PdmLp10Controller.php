<?php

namespace app\modules\pidum\controllers;


use Odf;
use Yii;
use yii\web\Controller;
use app\models\KpInstSatker;

class PdmLp10Controller extends Controller
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
        $odf = new \Odf(Yii::$app->params['report-path']."modules/pidum/template/lp10.odt");


        if($_POST['new_check'] != null){
          $wilayah = substr($_POST['wilayah_kerja'], 0,2);
          $wilayah_kerja =  "AND satker.inst_satkerkd LIKE '%".$wilayah."%'";
        }else{
          $wilayah_kerja = "AND satker.inst_satkerkd = '".$_POST['wilayah_kerja']."' ";
        }
        
        $query = Yii::$app->db->createCommand(
          "SELECT
	satker.inst_nama,
	0 AS nama_terdakwa,
	0 AS reg_perkara_tahan_bukti,
	'-' AS tgl_banding,
	'-' AS tgl_kdkh,
	'-' AS tgl_pk,
	'-' AS tgl_grasi,
	'-' AS tgl_pidana_badan,
	0 AS denda_uang,
	0 AS denda_kurungan,
	0 AS pidana_tambahan
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
    $listLaporan = $odf->setSegment('lp10');
    foreach ($query as $key => $value){
           $listLaporan->no($key+1);
           $listLaporan->nama($value['inst_nama']); 
           $listLaporan->nama_terdakwa($value['nama_terdakwa']);
           $listLaporan->reg_perkara($value['reg_perkara_tahan_bukti']);
           $listLaporan->tgl_banding($value['tgl_banding']);
            $listLaporan->tgl_kmk($value['-']);
           $listLaporan->tgl_kdkh($value['tgl_kdkh']);
           $listLaporan->tgl_pk($value['tgl_pk']);
           $listLaporan->tgl_grasi($value['tgl_grasi']);
           $listLaporan->pidana_badan($value['tgl_pidana_badan']);
           $listLaporan->uang($value['denda_uang']);
           $listLaporan->kurungan($value['denda_kurungan']);
           $listLaporan->pidana_tmbahan($value['pidana_tambahan']);
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
           
     
   
