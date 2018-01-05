<?php

namespace app\modules\pidum\controllers;


use Odf;
use Yii;
use yii\web\Controller;
use app\models\KpInstSatker;

class PdmLp15Controller extends Controller
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
        $odf = new \Odf(Yii::$app->params['report-path']."modules/pidum/template/lp15.odt");


        if($_POST['new_check'] != null){
          $wilayah = substr($_POST['wilayah_kerja'], 0,2);
          $wilayah_kerja =  "AND satker.inst_satkerkd LIKE '%".$wilayah."%'";
        }else{
          $wilayah_kerja = "AND satker.inst_satkerkd = '".$_POST['wilayah_kerja']."' ";
        }
        
        $query = Yii::$app->db->createCommand(
                "
SELECT
	pkting. ID,
	pkting.nama,
	CASE
WHEN sisa_bulan.jml_sisa_bulan ISNULL THEN
	0
ELSE
	sisa_bulan.jml_sisa_bulan
END AS sisa_bulan_lalu,
 CASE
WHEN bulan_masuk.jml_masuk ISNULL THEN
	0
ELSE
	bulan_masuk.jml_masuk
END AS masuk_bulan_lap,
 CASE
WHEN diselesaikan.jml ISNULL THEN
	0
ELSE
	diselesaikan.jml
END AS diselesaikan,
 0 AS sisa_bulan_laporan,
 '-' AS keterangan
FROM
	pidum.pdm_pk_ting_ref pkting
LEFT JOIN (
	SELECT
		spdp.id_pk_ting_ref,
		COUNT (spdp.id_pk_ting_ref) jml_sisa_bulan
	FROM
		pidum.pdm_berkas brks
	RIGHT JOIN pidum.pdm_spdp spdp ON (
		brks.id_perkara = spdp.id_perkara
	)
	LEFT JOIN pidum.pdm_pratut_putusan pratut ON (
		pratut.id_perkara = spdp.id_perkara
	)
	WHERE
		spdp.wilayah_kerja = '06.09'
	AND pidum.get_tahun_bulan (spdp.tgl_terima) < pidum.get_tahun_bulan (CURRENT_DATE)
	AND (
		brks.tgl_terima ISNULL
		AND pratut.tgl_terima ISNULL
	)
	GROUP BY
		spdp.id_pk_ting_ref
) sisa_bulan ON (
	sisa_bulan.id_pk_ting_ref = pkting. ID
)
LEFT JOIN (
	SELECT
		spdp.id_pk_ting_ref,
		COUNT (spdp.id_pk_ting_ref) jml_masuk
	FROM
		pidum.pdm_spdp spdp
	WHERE
		spdp.wilayah_kerja = '06.09'
	AND pidum.get_tahun_bulan (spdp.tgl_terima) = pidum.get_tahun_bulan (CURRENT_DATE)
	GROUP BY
		spdp.id_pk_ting_ref
) bulan_masuk ON (
	bulan_masuk.id_pk_ting_ref = pkting.ID
)
LEFT JOIN (
	SELECT
		x.id_pk_ting_ref,
		SUM (x.jml) jml
	FROM
		(
			SELECT
				spdp.id_pk_ting_ref,
				COUNT (spdp.id_pk_ting_ref) jml
			FROM
				pidum.pdm_spdp spdp
			INNER JOIN pidum.pdm_p21 p21 ON (
				p21.id_perkara = spdp.id_perkara
			)
			WHERE
				spdp.wilayah_kerja = '06.09'
			AND pidum.get_tahun_bulan (p21.tgl_dikeluarkan) = pidum.get_tahun_bulan (CURRENT_DATE)
			GROUP BY
				spdp.id_pk_ting_ref
			UNION
				SELECT
					spdp.id_pk_ting_ref,
					COUNT (spdp.id_pk_ting_ref) jml
				FROM
					pidum.pdm_spdp spdp
				INNER JOIN pidum.pdm_p22 p22 ON (
					p22.id_perkara = spdp.id_perkara
				)
				WHERE
					spdp.wilayah_kerja = '06.09'
				AND pidum.get_tahun_bulan (p22.tgl_dikeluarkan) = pidum.get_tahun_bulan (CURRENT_DATE)
				GROUP BY
					spdp.id_pk_ting_ref
		) x
	GROUP BY
		x.id_pk_ting_ref
) diselesaikan ON (
	diselesaikan.id_pk_ting_ref = pkting.ID
)"
  )->queryAll();    
        
    $odf->setVars('kejaksaan', Yii::$app->globalfunc->getNamaSatker($_POST['wilayah_kerja'])->inst_nama);   
    $listLaporan = $odf->setSegment('lp15');
    foreach ($query as $key => $value){
           $listLaporan->no($key+1);
             
           $listLaporan->sisa_bulan_lalu($value['sisa_bulan_lalu']);
           $listLaporan->masuk_bln_lap($value['masuk_bulan_lalu']);  
           $listLaporan->jumlah($value['inst_nama']);
           $listLaporan->diselesaikan($value['diselesaikan']);
           $listLaporan->sisa_bln_lap($value['sisa_bulan_laporan']);
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
                
               
  
