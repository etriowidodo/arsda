<?php

namespace app\modules\pidum\controllers;

use Odf;
use Yii;
use yii\web\Controller;
use app\models\KpInstSatker;

class PdmLp4aController extends Controller
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
        $odf = new \Odf(Yii::$app->params['report-path']."modules/pidum/template/lp4a.odt");



      if ($_POST['new_check'] != null) {
				//$wilayah = Yii::$app->db->createCommand("select satker.inst_satkerkd from kepegawaian.kp_inst_satker satker")->queryall();
              // $wilayah = substr($_POST['wilayah_kerja'], 0, 2);

				   $wilayah_kerja = "AND satker.inst_satkerkd like '%%'";
					$wilayah_kerja2 = "AND spdp.wilayah_kerja like '%%'";
			  
               				  // print_r($wilayah_kerja);exit;
            } else {
                $wilayah_kerja = "AND satker.inst_satkerinduk like '%" . $_POST['wilayah_kerja'] . "%' or satker.inst_satkerkd = '".$_POST['wilayah_kerja']."' ";
				$wilayah_kerja2 = "AND spdp.wilayah_kerja like '%" . $_POST['wilayah_kerja'] . "%' ";
            }



        $query = Yii::$app->db->createCommand(
                "SELECT
                        satker.inst_nama,
                        (
						SELECT count(*)
FROM
   pidum.pdm_spdp AS spdp
INNER JOIN pidum.pdm_p21 AS p21 ON spdp.id_perkara = p21.id_perkara
WHERE
   EXTRACT (MONTH FROM p21.tgl_dikeluarkan) < '" . $_POST['bulan'] . "'
AND EXTRACT (YEAR FROM p21.tgl_dikeluarkan) <= '" . $_POST['tahun'] . "'

".$wilayah_kerja2."
and spdp.wilayah_kerja = satker.inst_satkerkd
) AS jml_sisa_p21,

                        (SELECT
   count(*)
FROM
   pidum.pdm_spdp AS spdp

INNER JOIN pidum.pdm_p22 AS p22 ON spdp.id_perkara = p22.id_perkara
WHERE
   EXTRACT (MONTH FROM p22.tgl_dikeluarkan) < '" . $_POST['bulan'] . "'
AND EXTRACT (YEAR FROM p22.tgl_dikeluarkan) <= '" . $_POST['tahun'] . "'

".$wilayah_kerja2."
and spdp.wilayah_kerja = satker.inst_satkerkd) AS jml_sisa_p22,
                  
              (SELECT
   count(*)
FROM
   pidum.pdm_spdp AS spdp

INNER JOIN pidum.pdm_p21 AS p21 ON spdp.id_perkara = p21.id_perkara
WHERE
   EXTRACT (MONTH FROM p21.tgl_dikeluarkan) >= '" . $_POST['bulan'] . "' BETWEEN  EXTRACT (MONTH FROM p21.tgl_dikeluarkan) < '" . $_POST['bulan'] . "' + 01
AND EXTRACT (YEAR FROM p21.tgl_dikeluarkan) <= '" . $_POST['tahun'] . "'

".$wilayah_kerja2."
and spdp.wilayah_kerja = satker.inst_satkerkd) as jml_msk_p21_t2,

                (SELECT
   count(*)
FROM
   pidum.pdm_spdp AS spdp

INNER JOIN pidum.pdm_p22 AS p22 ON spdp.id_perkara = p22.id_perkara
WHERE
   EXTRACT (MONTH FROM p22.tgl_dikeluarkan) >= '" . $_POST['bulan'] . "' BETWEEN  EXTRACT (MONTH FROM p22.tgl_dikeluarkan) < '" . $_POST['bulan'] . "' + 01
AND EXTRACT (YEAR FROM p22.tgl_dikeluarkan) <= '" . $_POST['tahun'] . "'

".$wilayah_kerja2."
and spdp.wilayah_kerja = satker.inst_satkerkd) as jml_msk_p22_t2,

                       (SELECT
   count(*)
FROM
  pidum.pdm_spdp AS spdp
INNER JOIN pidum.pdm_tahap_dua AS thpdua ON spdp.id_perkara = thpdua.id_perkara
INNER JOIN pidum.pdm_p21 AS p21 ON spdp.id_perkara = p21.id_perkara
WHERE
   EXTRACT (MONTH FROM p21.tgl_dikeluarkan) < '" . $_POST['bulan'] . "'
   and EXTRACT (MONTH FROM p21.tgl_dikeluarkan) >= '" . $_POST['bulan'] . "' BETWEEN  EXTRACT (MONTH FROM p21.tgl_dikeluarkan) < '" . $_POST['bulan'] . "' + 01
AND EXTRACT (YEAR FROM p21.tgl_dikeluarkan) <= '" . $_POST['tahun'] . "'

".$wilayah_kerja2."
AND thpdua.tgl_terima IS NOT NULL
and spdp.wilayah_kerja = satker.inst_satkerkd) as jml_serah_p21,

                 (SELECT
   count(*)
FROM
   pidum.pdm_spdp AS spdp
INNER JOIN pidum.pdm_tahap_dua AS thpdua ON spdp.id_perkara = thpdua.id_perkara
INNER JOIN pidum.pdm_p22 AS p22 ON spdp.id_perkara = p22.id_perkara
WHERE
EXTRACT (MONTH FROM p22.tgl_dikeluarkan) < '" . $_POST['bulan'] . "'
   
   and EXTRACT (MONTH FROM p22.tgl_dikeluarkan) >= '" . $_POST['bulan'] . "' BETWEEN  EXTRACT (MONTH FROM p22.tgl_dikeluarkan) < '" . $_POST['bulan'] . "' + 01
AND EXTRACT (YEAR FROM p22.tgl_dikeluarkan) <= '" . $_POST['tahun'] . "'

".$wilayah_kerja2."
AND thpdua.tgl_terima IS NOT NULL
and spdp.wilayah_kerja = satker.inst_satkerkd) as jml_serah_p22,
				
                    (SELECT
   count(*)
FROM
   pidum.pdm_spdp AS spdp
INNER JOIN pidum.pdm_tahap_dua AS thpdua ON spdp.id_perkara = thpdua.id_perkara
INNER JOIN pidum.pdm_p21 AS p21 ON spdp.id_perkara = p21.id_perkara
WHERE
 EXTRACT (MONTH FROM p21.tgl_dikeluarkan) < '" . $_POST['bulan'] . "'  
   and  EXTRACT (MONTH FROM p21.tgl_dikeluarkan) >= '" . $_POST['bulan'] . "' BETWEEN  EXTRACT (MONTH FROM p21.tgl_dikeluarkan) < '" . $_POST['bulan'] . "' + 01
AND EXTRACT (YEAR FROM p21.tgl_dikeluarkan) <= '" . $_POST['tahun'] . "'

".$wilayah_kerja2."
AND thpdua.tgl_terima IS NULL
and spdp.wilayah_kerja = satker.inst_satkerkd) as jml_sisa_bln_p21,

                (SELECT
   count(*)
FROM
   pidum.pdm_spdp AS spdp
INNER JOIN pidum.pdm_tahap_dua AS thpdua ON spdp.id_perkara = thpdua.id_perkara
INNER JOIN pidum.pdm_p22 AS p22 ON spdp.id_perkara = p22.id_perkara
WHERE
 EXTRACT (MONTH FROM p22.tgl_dikeluarkan) < '" . $_POST['bulan'] . "'
   
   and EXTRACT (MONTH FROM p22.tgl_dikeluarkan) >= '" . $_POST['bulan'] . "' BETWEEN  EXTRACT (MONTH FROM p22.tgl_dikeluarkan) < '" . $_POST['bulan'] . "' + 01
AND EXTRACT (YEAR FROM p22.tgl_dikeluarkan) <= '" . $_POST['tahun'] . "'

".$wilayah_kerja2."
AND thpdua.tgl_terima IS NULL
and spdp.wilayah_kerja = satker.inst_satkerkd)as jml_sisa_bln_p22
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
                                EXTRACT (YEAR FROM spdp.tgl_terima) = '".$_POST['tahun']."'  AND EXTRACT (MONTH FROM spdp.tgl_terima) = '".$_POST['tahun']."' AND spdp.wilayah_kerja LIKE '%".$_POST['wilayah_kerja']."%'
                        GROUP BY
                                spdp.wilayah_kerja
                ) jml_msk_p21 ON (
                        jml_msk_p21.wilayah_kerja = satker.inst_satkerkd
                )
                LEFT JOIN (
                        SELECT
                                spdp.wilayah_kerja,
                                COUNT (*) jml
                        FROM
                                pidum.pdm_spdp spdp
                        RIGHT JOIN pidum.pdm_p22 p22 ON (
                                spdp.id_perkara = p22.id_perkara
                        )
                        WHERE
                                EXTRACT (YEAR FROM spdp.tgl_terima) = '".$_POST['tahun']."'  AND EXTRACT (MONTH FROM spdp.tgl_terima) = '".$_POST['bulan']."' AND spdp.wilayah_kerja LIKE '%".$_POST['wilayah_kerja']."%'
                        GROUP BY
                                spdp.wilayah_kerja
                ) jml_msk_p22 ON (
                        jml_msk_p22.wilayah_kerja = satker.inst_satkerkd
                )
                WHERE
                        1 = 1
                ".$wilayah_kerja."
                ORDER BY
                        satker.inst_satkerinduk"
        )->queryAll();
		//print_r($_POST['new_check'] );exit;
		//print_r($wilayah_kerja);exit;
//print_r($query);exit;


        $odf->setVars('kejaksaan', Yii::$app->globalfunc->getNamaSatker($_POST['wilayah_kerja'])->inst_nama);
        $odf->setVars('nama', 'sdsd');

        $listLaporan = $odf->setSegment('lp4a');
        foreach ($query as $key => $value){
           $listLaporan->no($key+1);
           $listLaporan->nama($value['inst_nama']);
           $listLaporan->jml_sisa_p21($value['jml_sisa_p21']);
           $listLaporan->jml_sisa_p22($value['jml_sisa_p22']);
           $listLaporan->jumlah_sisa($value['jml_sisa_p21'] + $value['jml_sisa_p22']);
           $listLaporan->jml_masuk_p21($value['jml_msk_p21_t2']);
           $listLaporan->jml_masuk_p22($value['jml_msk_p22_t2']);
           $listLaporan->jumlah_masuk($value['jml_msk_p21_t2'] + $value['jml_msk_p22_t2']);
           $listLaporan->jml_msk_p21_t2($value['jml_sisa_p21'] + $value['jml_msk_p21_t2']);
           $listLaporan->jml_msk_p22_t2($value['jml_sisa_p22'] + $value['jml_msk_p22_t2']);
           $listLaporan->jumlah_t2($value['jml_msk_p21_t2'] + $value['jml_msk_p22_t2'] + $value['jml_sisa_p22'] + $value['jml_msk_p22_t2']);
           $listLaporan->jml_serah_p21($value['jml_serah_p21']);
           $listLaporan->jml_serah_p22($value['jml_serah_p22']);
           $listLaporan->jumlah_serah($value['jml_serah_p21']+$value['jml_serah_p22']);
           $listLaporan->jml_sisa_bln_p21($value['jml_sisa_bln_p21']);
           $listLaporan->jml_sisa_bln_p22($value['jml_sisa_bln_p22']);
           $listLaporan->jumlah_bulan_laporan($value['jml_sisa_bln_p21'] + $value['jml_sisa_bln_p22']);
           $listLaporan->merge();
        }
				 //  print_r($listLaporan);exit;
        $odf->mergeSegment($listLaporan);
  //print_r($odf);exit;
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
