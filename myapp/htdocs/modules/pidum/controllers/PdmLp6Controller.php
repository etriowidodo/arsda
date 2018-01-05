<?php

namespace app\modules\pidum\controllers;

use Odf;
use Yii;
use app\modules\pidum\models\VLaporanP6;
use app\modules\pidum\models\VLaporanP6Search;
use yii\db\Query;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\KpInstSatker;

/**
 * VLaporanP6Controller implements the CRUD actions for VLaporanP6 model.
 */
class PdmLp6Controller extends Controller {

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
     * Lists all VLaporanP6 models.
     * @return mixed
     */
    public function actionIndex() {
        /* $searchModel = new VLaporanP6Search();
          $dataProvider = $searchModel->search(Yii::$app->request->queryParams); */

        $model = new VLaporanP6();

        return $this->render('index', [
                    'model' => $model,
                        /* 'searchModel' => $searchModel,
                          'dataProvider' => $dataProvider, */
        ]);
    }

    /**
     * Displays a single VLaporanP6 model.
     * @param  $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new VLaporanP6 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new VLaporanP6();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->w]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing VLaporanP6 model.
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
     * Deletes an existing VLaporanP6 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param  $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionCetak() {
        $idSatker = Yii::$app->request->post('VLaporanP6');
        $bulan = Yii::$app->request->post('bulan');
        $tahun = Yii::$app->request->post('tahun');

        #query utama
        $query = new Query();
        $laporan = $query->select('*')
                        ->from('pidum.v_laporan_p6')
                        ->where('wilayah_kerja=:wilayah_kerja AND EXTRACT(YEAR FROM pidum.v_laporan_p6.tgl_terima)=:tahun AND EXTRACT(MONTH FROM pidum.v_laporan_p6.tgl_terima)=:bulan', [
                            ':wilayah_kerja' => $idSatker['wilayah_kerja'],
                            ':tahun' => $tahun,
                            ':bulan' => $bulan,
                        ])->all();

        $odf = new Odf(Yii::$app->params['report-path'] . "modules/pidum/template/lp6.odt");
        $odf->setVars('kejaksaan', Yii::$app->globalfunc->getNamaSatker($idSatker['wilayah_kerja'])->inst_nama);
        $odf->setVars('tahun', $tahun);
        $odf->setVars('bulan', strtoupper($this->getNamaBulan($bulan)));
        $listLaporan = $odf->setSegment('lp6');
        $i = '1';
        foreach ($laporan as $lp6):
            $listLaporan->no($i);
            $listLaporan->nama($lp6['nama_lengkap']);
            $listLaporan->disangkakan($lp6['kasus_posisi']);
            if ($lp6['asal_perkara'] == 'POLRI') {
                $listLaporan->penyidik_polri($lp6['asal_perkara']);
                $listLaporan->kejaksaan_perkara('-');
                $listLaporan->ppns('-');
                $listLaporan->perwira_tni('-');
            } elseif ($lp6['asal_perkara'] == 'KEJAKSAAN') {
                $listLaporan->kejaksaan_perkara($lp6['asal_perkara']);
                $listLaporan->penyidik_polri('-');
                $listLaporan->ppns('-');
                $listLaporan->perwira_tni('-');
            } elseif ($lp6['asal_perkara'] == 'PPNS') {
                $listLaporan->ppns($lp6['asal_perkara']);
                $listLaporan->kejaksaan_perkara('-');
                $listLaporan->penyidik_polri('-');
                $listLaporan->perwira_tni('-');
            }
            $listLaporan->dihentikan_tgl(Yii::$app->globalfunc->indonesianFormat($lp6['tgl_dihentikan']));
            $listLaporan->dikesampingkan_tgl(Yii::$app->globalfunc->indonesianFormat($lp6['tgl_dikesampingkan']));
            $listLaporan->tgl(Yii::$app->globalfunc->indonesianFormat($lp6['tgl_dikirim_ke']));
            $listLaporan->no_denda($lp6['no_denda_ganti']);
            $listLaporan->tgl_denda(Yii::$app->globalfunc->indonesianFormat($lp6['tgl_denda_ganti']));
            $listLaporan->dilimpahkan_tgl(Yii::$app->globalfunc->indonesianFormat($lp6['tgl_dilimpahkan']));
            $listLaporan->ket($lp6['keterangan']);
            $listLaporan->merge();
            $i++;
        endforeach;
        $odf->mergeSegment($listLaporan);

        $odf->exportAsAttachedFile();
    }

    /**
     * Finds the VLaporanP6 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param  $id
     * @return VLaporanP6 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = VLaporanP6::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
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
