<?php

namespace app\modules\pdsold\controllers;

use Odf;
use Yii;
use yii\web\Controller;
use app\models\KpInstSatker;
use app\modules\pdsold\models\PdmPkTingRef;
use yii\web\Session;

class PdmLp3Controller extends Controller {

    public function actionIndex() {
		$session = new Session();
        $session->remove('id_perkara');
		$session->remove('nomor_perkara');
		$session->remove('tgl_perkara');
		$session->remove('tgl_terima');
        //return $this->render('index');
		$query = PdmPkTingRef::find()
		->select ('*') 
		->from ('pidum.pdm_pk_ting_ref')
		->All();

	 //print_r($query);exit;
		   return $this->render('index', [
            'query' => $query,
			
        ]); 
    }

    public function actionCetak() {
		  $bulan = Yii::$app->request->post('bulan');
        $tahun = Yii::$app->request->post('tahun');

        if ($_POST['bulan'] == null) {
            echo "<script>alert('harap pilih bulan');window.history.back();</script>";
        } elseif ($_POST['tahun'] == null) {
            echo "<script>alert('harap pilih tahun');window.history.back();</script>";
        } else {
            $odf = new \Odf(Yii::$app->params['report-path'] . "modules/pdsold/template/lp3.odt");



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
			
$a=$_POST['tndpdn'];
$query2 = Yii::$app->db->createCommand(
"select nama from pidum.pdm_pk_ting_ref where id='".$a."'"
)->queryone();
//print_r($query2);exit;
            $query = Yii::$app->db->createCommand(
                            "SELECT
                        satker.inst_nama,
						
						
                        (select count(*) from pidum.pdm_spdp spdp
INNER JOIN pidum.pdm_berkas berkas on spdp.id_perkara=berkas.id_perkara
INNER JOIN pidum.pdm_pratut_putusan pratut on spdp.id_perkara=pratut.id_perkara
INNER JOIN kepegawaian.kp_inst_satker kp on spdp.wilayah_kerja=kp.inst_satkerkd
 WHERE
EXTRACT (MONTH FROM berkas.tgl_terima) <= '" . $_POST['bulan'] . "'
  AND EXTRACT (YEAR FROM berkas.tgl_terima) <= '" . $_POST['tahun'] . "'
  AND berkas.tgl_terima is not null
and pratut.tgl_surat is null
".$wilayah_kerja2."
  AND spdp.id_pk_ting_ref = '".$a."'
  and spdp.wilayah_kerja = satker.inst_satkerkd
 ) AS sisa_bulan_lalu,

                       (select count(*) from pidum.pdm_berkas berkas
INNER JOIN pidum.pdm_spdp spdp on berkas.id_perkara=spdp.id_perkara
INNER JOIN kepegawaian.kp_inst_satker kp on spdp.wilayah_kerja=kp.inst_satkerkd
 WHERE
EXTRACT (MONTH FROM berkas.tgl_terima) >= " . $_POST['bulan']. "
BETWEEN  EXTRACT (MONTH FROM berkas.tgl_terima) < " . $_POST['bulan']. "+01
  AND EXTRACT (YEAR FROM berkas.tgl_terima) <= '" . $_POST['tahun'] . "'
  ".$wilayah_kerja2."
    AND spdp.id_pk_ting_ref = '".$a."'
	and spdp.wilayah_kerja = satker.inst_satkerkd)  AS masuk_bulan_laporan,
  
                        (select count(*) from pidum.pdm_berkas berkas
INNER JOIN pidum.pdm_spdp spdp on berkas.id_perkara=spdp.id_perkara
INNER JOIN pidum.pdm_pratut_putusan pratut on spdp.id_perkara=pratut.id_perkara
INNER JOIN kepegawaian.kp_inst_satker kp on spdp.wilayah_kerja=kp.inst_satkerkd
 WHERE
 EXTRACT (MONTH FROM berkas.tgl_terima) <= '" . $_POST['bulan'] . "'
and EXTRACT (MONTH FROM berkas.tgl_terima) >= " . $_POST['bulan']. "
BETWEEN  EXTRACT (MONTH FROM berkas.tgl_terima) < " . $_POST['bulan']. "+01

  AND EXTRACT (YEAR FROM berkas.tgl_terima) <= '" . $_POST['tahun'] . "'
AND EXTRACT (MONTH FROM pratut.tgl_surat) < " . $_POST['bulan']. "+01
  AND EXTRACT (YEAR FROM pratut.tgl_surat) <= '" . $_POST['tahun'] . "'
    ".$wilayah_kerja2."
	  AND spdp.id_pk_ting_ref = '".$a."'
	  and spdp.wilayah_kerja = satker.inst_satkerkd) AS dihentikan,
						
						(select count(*) from pidum.pdm_berkas berkas
INNER JOIN pidum.pdm_spdp spdp on berkas.id_perkara=spdp.id_perkara
INNER JOIN kepegawaian.kp_inst_satker kp on spdp.wilayah_kerja=kp.inst_satkerkd
 WHERE

 EXTRACT (MONTH FROM berkas.tgl_terima) <= '" . $_POST['bulan'] . "'
and EXTRACT (MONTH FROM berkas.tgl_terima) >= " . $_POST['bulan']. "
BETWEEN  EXTRACT (MONTH FROM berkas.tgl_terima) < " . $_POST['bulan']. "+01
  AND EXTRACT (YEAR FROM berkas.tgl_terima) <= '" . $_POST['tahun'] . "'
    ".$wilayah_kerja2."
	  AND spdp.id_pk_ting_ref = '".$a."'
	  and spdp.wilayah_kerja = satker.inst_satkerkd) AS jadi_berkas,

						
						(select count(*) from pidum.pdm_berkas berkas
INNER JOIN pidum.pdm_spdp spdp on berkas.id_perkara=spdp.id_perkara
INNER JOIN pidum.pdm_pratut_putusan pratut on spdp.id_perkara=pratut.id_perkara
INNER JOIN kepegawaian.kp_inst_satker kp on spdp.wilayah_kerja=kp.inst_satkerkd
 WHERE
pratut.tgl_surat is null 
and EXTRACT (MONTH FROM berkas.tgl_terima) <= '" . $_POST['bulan'] . "'
and EXTRACT (MONTH FROM berkas.tgl_terima) >= " . $_POST['bulan']. "
BETWEEN  EXTRACT (MONTH FROM berkas.tgl_terima) < " . $_POST['bulan']. "+01

  AND EXTRACT (YEAR FROM berkas.tgl_terima) <= '" . $_POST['tahun'] . "'
AND EXTRACT (MONTH FROM pratut.tgl_surat) < " . $_POST['bulan']. "+01
  AND EXTRACT (YEAR FROM pratut.tgl_surat) <= '" . $_POST['tahun'] . "'
    ".$wilayah_kerja2."
	  AND spdp.id_pk_ting_ref = '".$a."'
	  and spdp.wilayah_kerja = satker.inst_satkerkd) AS sp3_tepat,
						
			  (select count(*) from pidum.pdm_berkas berkas
      INNER JOIN pidum.pdm_spdp spdp ON berkas.id_perkara = spdp.id_perkara
      INNER JOIN pidum.pdm_pratut_putusan pratut ON spdp.id_perkara = pratut.id_perkara
INNER JOIN kepegawaian.kp_inst_satker kp on spdp.wilayah_kerja=kp.inst_satkerkd
      WHERE
pratut.tgl_surat is not null and pratut.is_proses=3
and 
  EXTRACT (MONTH FROM berkas.tgl_terima) <= '" . $_POST['bulan'] . "'
and EXTRACT (MONTH FROM berkas.tgl_terima) >= " . $_POST['bulan']. "
BETWEEN  EXTRACT (MONTH FROM berkas.tgl_terima) < " . $_POST['bulan']. "+01

  AND EXTRACT (YEAR FROM berkas.tgl_terima) <= '" . $_POST['tahun'] . "'
AND EXTRACT (MONTH FROM pratut.tgl_surat) < " . $_POST['bulan']. "+01
  AND EXTRACT (YEAR FROM pratut.tgl_surat) <= '" . $_POST['tahun'] . "'
    ".$wilayah_kerja2."
	  AND spdp.id_pk_ting_ref = '".$a."'
	   and spdp.wilayah_kerja = satker.inst_satkerkd) AS sp3_tdk_tepat,
						
						
						( SELECT
         COUNT (*)
      FROM
         pidum.pdm_berkas berkas
      INNER JOIN pidum.pdm_spdp spdp ON berkas.id_perkara = spdp.id_perkara
	   INNER JOIN pidum.pdm_pratut_putusan pratut ON spdp.id_perkara = pratut.id_perkara
INNER JOIN kepegawaian.kp_inst_satker kp on spdp.wilayah_kerja=kp.inst_satkerkd
      WHERE
 EXTRACT (MONTH FROM berkas.tgl_terima) <= '" . $_POST['bulan'] . "'
and EXTRACT (MONTH FROM berkas.tgl_terima) >= " . $_POST['bulan']. "
BETWEEN  EXTRACT (MONTH FROM berkas.tgl_terima) < " . $_POST['bulan']. "+01
  AND EXTRACT (YEAR FROM berkas.tgl_terima) <= '" . $_POST['tahun'] . "'
    ".$wilayah_kerja2."
	  AND spdp.id_pk_ting_ref = '".$a."'
	  and pratut.tgl_surat < berkas.tgl_terima
and spdp.wilayah_kerja = satker.inst_satkerkd) AS spdp,

(SELECT
         COUNT (*)
     FROM
         pidum.pdm_berkas berkas
      INNER JOIN pidum.pdm_spdp spdp ON berkas.id_perkara = spdp.id_perkara
INNER JOIN kepegawaian.kp_inst_satker kp on spdp.wilayah_kerja=kp.inst_satkerkd
      WHERE
       berkas.tgl_terima = spdp.tgl_terima
and spdp.wilayah_kerja = satker.inst_satkerkd	   
and EXTRACT (MONTH FROM berkas.tgl_terima) <= '" . $_POST['bulan'] . "'
and EXTRACT (MONTH FROM berkas.tgl_terima) >= " . $_POST['bulan']. "
BETWEEN  EXTRACT (MONTH FROM berkas.tgl_terima) < " . $_POST['bulan']. "+01
  AND EXTRACT (YEAR FROM berkas.tgl_terima) <= '" . $_POST['tahun'] . "'
    ".$wilayah_kerja2."
	  AND spdp.id_pk_ting_ref = '".$a."'
   AND spdp.id_pk_ting_ref = '".$a."')  AS berkas
                FROM
                          kepegawaian.kp_inst_satker satker
LEFT JOIN (
   SELECT
      spdp.wilayah_kerja,
      COUNT (*) jml
   FROM
      pidum.pdm_spdp spdp
   RIGHT JOIN pidum.pdm_pk_ting_ref pk ON (
      spdp.id_pk_ting_ref = pk.id
   )
   WHERE
      EXTRACT (YEAR FROM spdp.tgl_terima) = " . $_POST['bulan']. "
   AND EXTRACT (MONTH FROM spdp.tgl_terima) = '" . $_POST['tahun'] . "'
   AND spdp.wilayah_kerja LIKE '%" . $_POST['wilayah_kerja'] . "%'
   AND spdp.id_pk_ting_ref = '".$a."'
   GROUP BY
      spdp.wilayah_kerja
) spdp ON (
   spdp.wilayah_kerja = satker.inst_satkerkd
)
                 where   1 = 1
									
                 ".$wilayah_kerja."
				
                ORDER BY
                        satker.inst_satkerinduk,satker.inst_satkerkd"
                    )->queryAll();

//print_r($query);exit;
//print_r($a);exit;
       $odf->setVars('kejaksaan', Yii::$app->globalfunc->getNamaSatker($_POST['wilayah_kerja'])->inst_nama);
         $odf->setVars('tahun', $tahun);
        $odf->setVars('bulan', strtoupper($this->getNamaBulan($bulan)));
		$odf->setVars('pidana',$query2['nama']);
            $listLaporanlp3 = $odf->setSegment('lp3');
            foreach ($query as $key => $value) {
                $listLaporanlp3->no($key + 1);
                $listLaporanlp3->nama($value['inst_nama']);
                $listLaporanlp3->sisa_bulan_lalu($value['sisa_bulan_lalu']);
                $listLaporanlp3->masuk_bulan_lap($value['masuk_bulan_laporan']);
                $listLaporanlp3->jml_bln_lap($value['sisa_bulan_lalu'] + $value['masuk_bulan_laporan']);
                $listLaporanlp3->dihentikan_penyidikan($value['dihentikan']);
                $listLaporanlp3->tahap_pertama($value['jadi_berkas']);
                $listLaporanlp3->sisa_bln_lap(($value['sisa_bulan_lalu'] + $value['masuk_bulan_laporan'])-($value['dihentikan']+$value['jadi_berkas']));
                $listLaporanlp3->praperadilan($value['sp3_tepat']);
                $listLaporanlp3->praperadilan_tgl($value['sp3_tdk_tepat']);
                $listLaporanlp3->didahului_spdp($value['spdp']);
                $listLaporanlp3->spdp_bersama_berkas($value['berkas']);
				
                $listLaporanlp3->merge();
            }
			//print_r($listLaporanlp3);exit;
            $odf->mergeSegment($listLaporanlp3);

//print_r($query);exit;
$odf->exportAsAttachedFile();
			return true;
            
			exit;
        }
    }
 protected function getNamaBulan($bln) {
        switch ($bln) {
            case 1 : $bln = 'Januari';
                break;
            case 2 : $bln = 'Februari';
                break;
            case 3 : $bln = 'Maret';
                break;
            case 4 : $bln = 'April';
                break;
            case 5 : $bln = 'Mei';
                break;
            case 6 : $bln = 'Juni';
                break;
            case 7 : $bln = 'Juli';
                break;
            case 8 : $bln = 'Agustus';
                break;
            case 9 : $bln = 'September';
                break;
            case 10 : $bln = 'Oktober';
                break;
            case 11 : $bln = 'November';
                break;
            case 12 : $bln = 'Desember';
                break;
        }
        return $bln;
    }
    public function getSatker() {
        $satker = KpInstSatker::find()
                ->select("inst_satkerkd as id, inst_nama as text")
                ->asArray()
                ->all();

        return $satker;
    }

}
