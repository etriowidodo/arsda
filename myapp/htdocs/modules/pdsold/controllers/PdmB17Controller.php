<?php

namespace app\modules\pdsold\controllers;

use app\components\ConstSysMenuComponent;
use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\MsTersangka;
use app\modules\pdsold\models\PdmB17;
use app\modules\pdsold\models\pdmb17Search;
use app\modules\pdsold\models\PdmB4;
use app\modules\pdsold\models\PdmBa10;
use app\modules\pdsold\models\PdmBarbukTambahan;
use app\modules\pdsold\models\PdmPenandatangan;
use app\modules\pdsold\models\PdmRb2;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmSysMenu;
use Odf;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;

/**
 * PdmB17Controller implements the CRUD actions for PdmB17 model.
 */
class PdmB17Controller extends Controller {

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
     * Lists all PdmB17 models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new pdmb17Search();
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::B17]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'sysMenu' => $sysMenu
        ]);
    }

    /**
     * Displays a single PdmB17 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmB17 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::B17]);
        $session = new Session();
        $id = $session->get('id_perkara');
        $model = new PdmB17();
        $modelB4 = PdmB4::find()->where(['id_perkara' => $id])->orderBy('tgl_sprint DESC')->one();
        $modelbarbuk = PdmBarbukTambahan::find()->where('id_b4=:id_b4 AND flag<>:flag', [':id_b4' => $modelB4->id_b4, ':flag' => '3'])->all();
        $modelba10 = PdmBa10::find()->where(['id_perkara' => $id])->orderBy('tgl_surat DESC')->one();
        $modelrb2 = PdmRb2::find()->where(['id_perkara' => $id])->one();

        $model->no_reg_bukti = $modelrb2->no_urut;

        $modelSpdp = $this->findModelSpdp($id);

        if ($model->load(Yii::$app->request->post())) {

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_b17', 'id_b17', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                $model->id_perkara = $id;
                $model->id_b17 = $seq['generate_pk'];
                /* 	print_r($modelTersangka); 
                  exit(); */
                $model->save();
                $NextProcces = array(ConstSysMenuComponent::BA20);
                Yii::$app->globalfunc->getNextProcces($model->id_perkara, $NextProcces);
                Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara, GlobalConstMenuComponent::B17);
                $transaction->commit();
                //notifikasi simpan
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'success',
                    'duration' => 3000,
                    'icon' => 'fa fa-users',
                    'message' => 'Data Berhasil di Simpan',
                    'title' => 'Simpan Data',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
                return $this->redirect(['update', 'id' => $model->id_b17]);
            } catch (Exception $ex) {
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'success',
                    'duration' => 3000,
                    'icon' => 'fa fa-users',
                    'message' => 'Data Gagal di Simpan',
                    'title' => 'Simpan Data',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
            }
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'modelSpdp' => $modelSpdp,
                        'id' => $id,
                        'sysMenu' => $sysMenu,
                        'modelbarbuk' => $modelbarbuk
            ]);
        }
    }

    /**
     * Updates an existing PdmB17 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::B17]);

        $model = $this->findModel($id);
        $modelB4 = PdmB4::findOne(['id_perkara' => $model->id_perkara]);
        $modelbarbuk = PdmBarbukTambahan::findAll(['id_b4' => $modelB4->id_b4]);
        $session = new Session();
        $session->destroySession('id_perkara');
        $session->set('id_perkara', $model->id_perkara);
        if ($model == null) {
            $model = new PdmB17();
        }

        $modelSpdp = $this->findModelSpdp($model->id_perkara);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->update()) {
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
                    'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                    'icon' => 'glyphicon glyphicon-ok-sign', //String
                    'message' => 'Data Berhasil Disimpan', // String
                    'title' => 'Save', //String
                    'positonY' => 'top', //String // defaults to top, allows top or bottom
                    'positonX' => 'center', //String // defaults to right, allows right, center, left
                    'showProgressbar' => true,
                ]);
                return $this->redirect(['update', 'id' => $id]);
            } else {
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'danger',
                    'duration' => 3000,
                    'icon' => 'fa fa-users',
                    'message' => 'Data Gagal di Simpan',
                    'title' => 'Error',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
                return $this->redirect(['update', 'id' => $id]);
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'modelSpdp' => $modelSpdp,
                        'id' => $id,
                        'sysMenu' => $sysMenu,
                        'modelbarbuk' => $modelbarbuk
            ]);
        }
    }

    /**
     * Deletes an existing PdmB17 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete() {
        //$this->findModel($id)->delete();
        $id = $_POST['hapusIndex'];

        for ($i = 0; $i < count($id); $i++) {
            $model = PdmB17::findOne(['id_b17' => $id[$i]]);
            $model->flag = '3';
            $model->update();
        }
        return $this->redirect(['index']);
    }

    public function actionCetak($id) {
        $connection = \Yii::$app->db;
        $odf = new Odf(Yii::$app->params['report-path'] . "modules/pdsold/template/b17.odt");

        $b17 = Pdmb17::findOne($id);
        $spdp = PdmSpdp::findOne(['id_perkara' => $b17->id_perkara]);
        $tersangka = MsTersangka::findone($b17->id_tersangka);

   $pangkat = PdmPenandatangan::find()
->select ("a.jabatan as jabatan")
->from ("pidum.pdm_penandatangan a")
->join ('inner join','pidum.pdm_b17 b','a.peg_nik = b.id_penandatangan')
->where ("id_b17='".$id."'")
->one(); 

        $odf->setVars('Kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
		        $odf->setVars('kejaksaan', $pangkat->jabatan);
        $odf->setVars('nomor', $b17->no_surat);
        $odf->setVars('no_reg', $b17->no_reg_bukti);
        $odf->setVars('barbuk', Yii::$app->globalfunc->getBarbuk($b17->id_perkara));
        $odf->setVars('ditetapkan', $b17->dikeluarkan);
        $odf->setVars('tgl_dikeluarkan', Yii::$app->globalfunc->ViewIndonesianFormat($b17->tgl_dikeluarkan));
        $odf->setVars('tersangka', $this->getTerdakwabaris($b17->id_perkara));

#penanda tangan
        $sql = "SELECT a.nama,a.pangkat,a.jabatan,c.peg_nip_baru FROM "
                . " pidum.pdm_penandatangan a, pidum.pdm_b17 b , kepegawaian.kp_pegawai c "
                . "where a.peg_nik = b.id_penandatangan and b.id_penandatangan =c.peg_nik and b.id_b17='" . $id . "'";
        $model = $connection->createCommand($sql);
        $penandatangan = $model->queryOne();
        $odf->setVars('nama_penandatangan', $penandatangan['nama']);
        $pangkat = explode('/', $penandatangan['pangkat']);
        $odf->setVars('pangkat', $pangkat[0]);
        $odf->setVars('nip_penandatangan', $penandatangan['peg_nip_baru']);

        $odf->exportAsAttachedFile();
    }

    /**
     * Finds the PdmB17 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmB17 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PdmB17::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Halaman Yang Anda Cari Tidak Ada.');
        }
    }

    protected function findModelSpdp($id) {
        if (($modelSpdp = PdmSpdp::findOne(['id_perkara' => $id])) !== null) {
            return $modelSpdp;
        } else {
            throw new NotFoundHttpException('Anda belum memilih Perkara.');
        }
    }

    protected function findModelTersangka($id) {
        if (($modelTersangka = MsTersangka::findOne(['id_perkara' => $id])) !== null) {
            return $modelTersangka;
//        } else {
//            throw new NotFoundHttpException('Tidak Ada tersangka di Perkara ini.');
        }
    }

    public function getTerdakwabaris($id_perkara) {

        $modelMsTersangka = MsTersangka::findAll(['id_perkara' => $id_perkara]);
        $tersangka = '';
        if (count($modelMsTersangka) == 1) {
            $tersangka = $modelMsTersangka[0]->nama;
        } else if (count($modelMsTersangka) == 2) {
            $i = 0;
            foreach ($modelMsTersangka as $key) {
                if ($i == 0) {
                    $tersangka .= ucfirst(strtolower($key->nama));
                    $i = 1;
                } else {
                    $tersangka .= ' dan ' . ucfirst(strtolower($key->nama));
                }
            }
        } else if (count($modelMsTersangka) > 2) {
            $i = 1;
            foreach ($modelMsTersangka as $key) {
                if ($i == count($modelMsTersangka)) {
                    $tersangka .= 'dan ' . ucfirst(strtolower($key->nama));
                } else {
                    $tersangka .= ucfirst(strtolower($key->nama)) . ', ';
                    $i++;
                }
            }
        }
        return $tersangka;
    }

}
