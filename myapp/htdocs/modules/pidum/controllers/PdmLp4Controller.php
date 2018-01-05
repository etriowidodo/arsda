<?php

namespace app\modules\pidum\controllers;

use Odf;
use Yii;
use app\modules\pidum\models\VLaporanP4;
use app\modules\pidum\models\VLaporanP4Search;
use yii\db\Query;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\KpInstSatker;

/**
 * VLaporanP4Controller implements the CRUD actions for VLaporanP4 model.
 */
class PdmLp4Controller extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all VLaporanP4 models.
     * @return mixed
     */
    public function actionIndex() {
        /* $searchModel = new VLaporanP4Search();
          $dataProvider = $searchModel->search(Yii::$app->request->queryParams); */

        $model = new VLaporanP4();

        return $this->render('index', [
                    'model' => $model,
                        /* 'searchModel' => $searchModel,
                          'dataProvider' => $dataProvider, */
        ]);
    }

    /**
     * Displays a single VLaporanP4 model.
     * @param  $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new VLaporanP4 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new VLaporanP4();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->w]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing VLaporanP4 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param  $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->w]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing VLaporanP4 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param  $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionCetak() {

        $bulan = Yii::$app->request->post('bulan');
        $tahun = Yii::$app->request->post('tahun');


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
        #query utama
        $query = new Query();
        /*$laporan = $query->select('*')
                        ->from('pidum.v_laporan_p6')
                        ->where("" .$wilayah_kerja . " AND EXTRACT(YEAR FROM pidum.v_laporan_p6.tgl_terima) <= '" . $_POST['tahun'] . "' AND EXTRACT(MONTH FROM pidum.v_laporan_p6.tgl_terima)<= '" . $_POST['bulan'] . "'")->all();
						print_r ($idSatker);*/
						
$laporan =  $query = Yii::$app->db->createCommand(
                            "SELECT
                        satker.inst_nama,
						
						
                        (select count(*) from pidum.pdm_spdp spdp
INNER JOIN pidum.pdm_berkas berkas on spdp.id_perkara=berkas.id_perkara

 WHERE
EXTRACT (MONTH FROM berkas.tgl_terima) <= '" . $_POST['bulan'] . "'
  AND EXTRACT (YEAR FROM berkas.tgl_terima) <= '" . $_POST['tahun'] . "'
  AND berkas.tgl_terima is not null

".$wilayah_kerja2."
  and spdp.wilayah_kerja = satker.inst_satkerkd
 ) AS sisa_bulan_lalu,

                       (select count(*) from pidum.pdm_berkas berkas
INNER JOIN pidum.pdm_spdp spdp on berkas.id_perkara=spdp.id_perkara

 WHERE
EXTRACT (MONTH FROM berkas.tgl_terima) >= " . $_POST['bulan']. "
BETWEEN  EXTRACT (MONTH FROM berkas.tgl_terima) < " . $_POST['bulan']. "+01
  AND EXTRACT (YEAR FROM berkas.tgl_terima) <= '" . $_POST['tahun'] . "'
  ".$wilayah_kerja2."
	and spdp.wilayah_kerja = satker.inst_satkerkd)  AS masuk_bulan_laporan,
  
                        (select count(*) from pidum.pdm_berkas berkas
INNER JOIN pidum.pdm_spdp spdp on berkas.id_perkara=spdp.id_perkara
INNER JOIN pidum.pdm_p21 p21 on spdp.id_perkara=p21.id_perkara

 WHERE
EXTRACT (MONTH FROM berkas.tgl_terima) < " . $_POST['bulan']. "+01
and EXTRACT (MONTH FROM berkas.tgl_terima) >= " . $_POST['bulan']. "
BETWEEN  EXTRACT (MONTH FROM berkas.tgl_terima) < " . $_POST['bulan']. "+01
  AND EXTRACT (YEAR FROM berkas.tgl_terima) <= '" . $_POST['tahun'] . "'
  AND berkas.tgl_terima is not null

AND EXTRACT (MONTH FROM p21.tgl_dikeluarkan) < " . $_POST['bulan']. "+01
  AND EXTRACT (YEAR FROM p21.tgl_dikeluarkan) <= '" . $_POST['tahun'] . "'
    ".$wilayah_kerja2."
	  and spdp.wilayah_kerja = satker.inst_satkerkd) AS berkas_lengkap,
						
	(select count(*) from pidum.pdm_berkas berkas
INNER JOIN pidum.pdm_spdp spdp on berkas.id_perkara=spdp.id_perkara
INNER JOIN pidum.pdm_p19 p19 on spdp.id_perkara=p19.id_perkara

 WHERE
EXTRACT (MONTH FROM berkas.tgl_terima) < " . $_POST['bulan']. "+01
and EXTRACT (MONTH FROM berkas.tgl_terima) >= " . $_POST['bulan']. "
BETWEEN  EXTRACT (MONTH FROM berkas.tgl_terima) < " . $_POST['bulan']. "+01
 
  AND EXTRACT (YEAR FROM berkas.tgl_terima) <= '" . $_POST['tahun'] . "'
  AND berkas.tgl_terima is not null

AND EXTRACT (MONTH FROM p19.tgl_dikeluarkan) < " . $_POST['bulan']. "+01
  AND EXTRACT (YEAR FROM p19.tgl_dikeluarkan) <= '" . $_POST['tahun'] . "'
    ".$wilayah_kerja2."
	  and spdp.wilayah_kerja = satker.inst_satkerkd) AS berkas_kembali,

						
	(select count(*) from pidum.pdm_berkas berkas
INNER JOIN pidum.pdm_spdp spdp on berkas.id_perkara=spdp.id_perkara
INNER JOIN pidum.pdm_p19 p19 on spdp.id_perkara=p19.id_perkara
INNER JOIN pidum.pdm_p21 p21 on spdp.id_perkara=p21.id_perkara

 WHERE
EXTRACT (MONTH FROM berkas.tgl_terima) < " . $_POST['bulan']. "+01
and EXTRACT (MONTH FROM berkas.tgl_terima) >= " . $_POST['bulan']. "
BETWEEN  EXTRACT (MONTH FROM berkas.tgl_terima) < " . $_POST['bulan']. "+01
 
  AND EXTRACT (YEAR FROM berkas.tgl_terima) <= '" . $_POST['tahun'] . "'
  AND berkas.tgl_terima is not null

AND EXTRACT (MONTH FROM p19.tgl_dikeluarkan) < " . $_POST['bulan']. "+01
  AND EXTRACT (YEAR FROM p19.tgl_dikeluarkan) <= '" . $_POST['tahun'] . "'
  AND EXTRACT (MONTH FROM p21.tgl_dikeluarkan) < " . $_POST['bulan']. "+01
  AND EXTRACT (YEAR FROM p21.tgl_dikeluarkan) <= '" . $_POST['tahun'] . "'
    ".$wilayah_kerja2."
	  and spdp.wilayah_kerja = satker.inst_satkerkd) AS dapat_dilengkapi,
						
			  (select count(*) from pidum.pdm_berkas berkas
INNER JOIN pidum.pdm_spdp spdp on berkas.id_perkara=spdp.id_perkara
INNER JOIN pidum.pdm_p19 p19 on spdp.id_perkara=p19.id_perkara
INNER JOIN pidum.pdm_p21 p21 on spdp.id_perkara=p21.id_perkara

 WHERE
EXTRACT (MONTH FROM berkas.tgl_terima) < " . $_POST['bulan']. "+01
and EXTRACT (MONTH FROM berkas.tgl_terima) >= " . $_POST['bulan']. "
BETWEEN  EXTRACT (MONTH FROM berkas.tgl_terima) < " . $_POST['bulan']. "+01
 
  AND EXTRACT (YEAR FROM berkas.tgl_terima) <= '" . $_POST['tahun'] . "'
  AND berkas.tgl_terima is not null

AND EXTRACT (MONTH FROM berkas.tgl_terima) > EXTRACT (MONTH FROM p19.tgl_dikeluarkan)
  AND EXTRACT (YEAR FROM p19.tgl_dikeluarkan) <= '" . $_POST['tahun'] . "'
AND p21.tgl_dikeluarkan is null
    ".$wilayah_kerja2."
	  and spdp.wilayah_kerja = satker.inst_satkerkd) AS berkas_tdk_dpt_dilengkapi,
						
						
						( select count(*) from pidum.pdm_berkas berkas
INNER JOIN pidum.pdm_spdp spdp on berkas.id_perkara=spdp.id_perkara
INNER JOIN pidum.pdm_p19 p19 on spdp.id_perkara=p19.id_perkara
INNER JOIN pidum.pdm_p21 p21 on spdp.id_perkara=p21.id_perkara

 WHERE
EXTRACT (MONTH FROM berkas.tgl_terima) < " . $_POST['bulan']. "+01
and EXTRACT (MONTH FROM berkas.tgl_terima) >= " . $_POST['bulan']. "
BETWEEN  EXTRACT (MONTH FROM berkas.tgl_terima) < " . $_POST['bulan']. "+01
 
  AND EXTRACT (YEAR FROM berkas.tgl_terima) <= '" . $_POST['tahun'] . "'
  AND berkas.tgl_terima is not null

AND EXTRACT (MONTH FROM p19.tgl_dikeluarkan) < " . $_POST['bulan']. "+01
  AND EXTRACT (YEAR FROM p19.tgl_dikeluarkan) <= '" . $_POST['tahun'] . "'
and  berkas.tgl_terima is null
    ".$wilayah_kerja2."
	 and spdp.wilayah_kerja = satker.inst_satkerkd) AS berkas_tidak_dikembalikan

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
//print_r ($bulan);
//print_r ($tahun);
//print_r ($laporan);exit;

        $odf = new Odf(Yii::$app->params['report-path'] . "modules/pidum/template/lp4.odt");
        $odf->setVars('kejaksaan', Yii::$app->globalfunc->getNamaSatker($idSatker['wilayah_kerja'])->inst_nama);
        $odf->setVars('tahun', $tahun);
        $odf->setVars('bulan', strtoupper($this->getNamaBulan($bulan)));
        $listLaporan = $odf->setSegment('lp4');
        $i = '1';
       foreach ($laporan as $key => $value) {
                $listLaporan->no($key + 1);
                $listLaporan->nama($value['inst_nama']);
                $listLaporan->sisa_bulan_lalu($value['sisa_bulan_lalu']);
                $listLaporan->masuk_bulan_lap($value['masuk_bulan_laporan']);
                $listLaporan->jml_lap($value['sisa_bulan_lalu'] + $value['masuk_bulan_laporan']);
                $listLaporan->berkas_lengkap($value['berkas_lengkap']);
                $listLaporan->berkas_kembali($value['berkas_kembali']);
                $listLaporan->dapat_dilengkapi($value['dapat_dilengkapi']);
                $listLaporan->berkas_tdk_dpt_dilengkapi($value['berkas_tdk_dpt_dilengkapi']);
                $listLaporan->berkas_tidak_dikembalikan($value['berkas_tidak_dikembalikan']);
                $listLaporan->jml_diselesaikan($value['berkas_kembali'] + $value['dapat_dilengkapi'] + $value['berkas_tdk_dpt_dilengkapi'] + $value['berkas_tidak_dikembalikan']);
                $listLaporan->spdp_bersama_berkas(($value['sisa_bulan_lalu'] + $value['masuk_bulan_laporan'])-($value['berkas_kembali'] + $value['dapat_dilengkapi'] + $value['berkas_tdk_dpt_dilengkapi'] + $value['berkas_tidak_dikembalikan']));
				//print_r($listLaporan);exit;
                $listLaporan->merge();
            }
        $odf->mergeSegment($listLaporan);
        //exit();

        $odf->exportAsAttachedFile();
    }
	
    /**
     * Finds the VLaporanP4 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param  $id
     * @return VLaporanP4 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
 /*   protected function findModel($id) {
        if (($model = VLaporanP4::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }*/

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
