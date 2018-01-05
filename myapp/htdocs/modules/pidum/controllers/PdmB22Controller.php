<?php

namespace app\modules\pidum\controllers;

use app\components\ConstDataComponent;
use app\components\GlobalConstMenuComponent;
use app\models\MsSifatSurat;
use app\modules\pidum\models\PdmB22;
use app\modules\pidum\models\PdmB22Search;
use app\modules\pidum\models\PdmMsStatusData;
use app\modules\pidum\models\PdmPenandatangan;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmSysMenu;
use app\modules\pidum\models\PdmTembusan;
use Odf;
use Yii;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;

/**
 * PdmB22Controller implements the CRUD actions for PdmB22 model.
 */
class PdmB22Controller extends Controller {

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
     * Lists all PdmB22 models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new PdmB22Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::B22]);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'sysMenu' => $sysMenu,
        ]);
    }

    /**
     * Displays a single PdmB22 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmB22 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $session = new Session();
        $id = $session->get('id_perkara');
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::B22]);
        $model = new PdmB22();
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_b22', 'id_b22', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                $model->id_perkara = $id;
                $model->id_b22 = $seq['generate_pk'];
                $model->save();
                Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara, GlobalConstMenuComponent::B22);
                PdmTembusan::deleteAll(['id_perkara' => $model->id_perkara, 'id_table' => $model->id_b22, 'kode_table' => GlobalConstMenuComponent::B22]);
                if (!empty($_POST['new_tembusan'])) {
                    for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                        $modelNewTembusan = new PdmTembusan();
                        $seqTembusan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tembusan', 'id_tembusan', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                        $modelNewTembusan->id_tembusan = $seqTembusan['generate_pk'];
                        $modelNewTembusan->id_table = $model->id_b22;
                        $modelNewTembusan->kode_table = GlobalConstMenuComponent::B22;
                        $modelNewTembusan->keterangan = $_POST['new_tembusan'][$i];
                        $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                        $modelNewTembusan->no_urut = $_POST['new_no_urut'][$i];
                        $modelNewTembusan->id_perkara = $model->id_perkara;
                        $modelNewTembusan->nip = null;
                        $modelNewTembusan->save();
                    }
                }
                $transaction->commit();
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
                return $this->redirect(['update2', 'id' => $model->id_b22]);
            } catch (Exception $ex) {
                $transaction->rollback();
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
                return $this->redirect('create');
            }
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'sysMenu' => $sysMenu
            ]);
        }
    }

    /**
     * Updates an existing PdmB22 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate() {
        $session = new Session();
        $id = $session->get('id_perkara');
        $model = PdmB22::findOne(['id_perkara' => $id]);
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::B22]);
        if ($model == null) {
            $model = new PdmB22();
        }
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($model->id_perkara == null) {
                    $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_b22', 'id_b22', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                    $model->id_perkara = $id;
                    $model->id_b22 = $seq['generate_pk'];
                    $model->save();
                    Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara, GlobalConstMenuComponent::B22);
                } else {
                    $model->update();
                }
                PdmTembusan::deleteAll(['id_perkara' => $model->id_perkara, 'id_table' => $model->id_b22, 'kode_table' => GlobalConstMenuComponent::B22]);
                if (!empty($_POST['new_tembusan'])) {
                    for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                        $modelNewTembusan = new PdmTembusan();
                        $seqTembusan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tembusan', 'id_tembusan', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                        $modelNewTembusan->id_tembusan = $seqTembusan['generate_pk'];
                        $modelNewTembusan->id_table = $model->id_b22;
                        $modelNewTembusan->kode_table = GlobalConstMenuComponent::B22;
                        $modelNewTembusan->keterangan = $_POST['new_tembusan'][$i];
                        $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                        $modelNewTembusan->no_urut = $_POST['new_no_urut'][$i];
                        $modelNewTembusan->id_perkara = $model->id_perkara;
                        $modelNewTembusan->nip = null;
                        $modelNewTembusan->save();
                    }
                }
                $transaction->commit();
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
                return $this->redirect('update');
            } catch (Exception $ex) {
                $transaction->rollback();
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
                return $this->redirect('update');
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'sysMenu' => $sysMenu
            ]);
        }
    }

    public function actionUpdate2($id) {
        $model = PdmB22::findOne(['id_b22' => $id]);
        $session = new Session();
        $session->destroySession('id_perkara');
        $session->set('id_perkara', $model->id_perkara);
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::B22]);
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->update();
                PdmTembusan::deleteAll(['id_perkara' => $model->id_perkara, 'id_table' => $model->id_b22, 'kode_table' => GlobalConstMenuComponent::B22]);
                if (!empty($_POST['new_tembusan'])) {
                    for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                        $modelNewTembusan = new PdmTembusan();
                        $seqTembusan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tembusan', 'id_tembusan', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                        $modelNewTembusan->id_tembusan = $seqTembusan['generate_pk'];
                        $modelNewTembusan->id_table = $model->id_b22;
                        $modelNewTembusan->kode_table = GlobalConstMenuComponent::B22;
                        $modelNewTembusan->keterangan = $_POST['new_tembusan'][$i];
                        $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                        $modelNewTembusan->no_urut = $_POST['new_no_urut'][$i];
                        $modelNewTembusan->id_perkara = $model->id_perkara;
                        $modelNewTembusan->nip = null;
                        $modelNewTembusan->save();
                    }
                }
                $transaction->commit();
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
                return $this->redirect(['update2', 'id' => $model->id_b22]);
            } catch (Exception $ex) {
                $transaction->rollback();
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
                return $this->redirect(['update2', 'id' => $model->id_b22]);
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'sysMenu' => $sysMenu
            ]);
        }
    }

    /**
     * Deletes an existing PdmB22 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete() {
        $id = $_POST['hapusIndex'];

        for ($i = 0; $i < count($id); $i++) {
            $model = PdmB22::findOne(['id_b22' => $id[$i]]);
            $model->flag = '3';
            $model->update();
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the PdmB22 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmB22 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PdmB22::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCetak($id) {
        $connection = \Yii::$app->db;
        $odf = new Odf(Yii::$app->params['report-path'] . "modules/pidum/template/b22.odt");
 $pangkat = PdmPenandatangan::find()
->select ("a.jabatan as jabatan")
->from ("pidum.pdm_penandatangan a")
->join ('inner join','pidum.pdm_b22 b','a.peg_nik = b.id_penandatangan')
->where ("id_b22='".$id."'")
->one(); 
        $b22 = PdmB22::findOne($id);
        $spdp = PdmSpdp::findOne(['id_perkara' => $b22->id_perkara]);
        //$statusbarang = PdmMsStatusData::findOne($b22->id_msstatusdata);
        $sifat = MsSifatSurat::findOne((int)$b22->sifat)->nama;
        $tindakan = PdmMsStatusData::findOne(['id' => $b22->id_tindakan, 'is_group' => ConstDataComponent::TindakanB22]);
        $status = PdmMsStatusData::findOne(['id' => $b22->id_jnsbarang, 'is_group' => ConstDataComponent::JenisB22]);

        $odf->setVars('Kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
        $odf->setVars('kejaksaan', $pangkat->jabatan);
        $odf->setVars('nomor', $b22->no_surat);
        $odf->setVars('sifat', $sifat);
        $odf->setVars('tindakan', $tindakan->keterangan);
        $odf->setVars('statusbarang', $status->keterangan);
        $odf->setVars('dikeluarkan', $b22->dikeluarkan);
        $odf->setVars('pada_tanggal', Yii::$app->globalfunc->ViewIndonesianFormat($b22->tgl_dikeluarkan));
        $odf->setVars('ditempat', $b22->di_kepada);
        $odf->setVars('kepada', $b22->kepada);

#penanda tangan
        $sql = "SELECT a.nama,a.pangkat,a.jabatan,c.peg_nip_baru FROM "
                . " pidum.pdm_penandatangan a, pidum.pdm_b22 b , kepegawaian.kp_pegawai c "
                . "where a.peg_nik = b.id_penandatangan and b.id_penandatangan =c.peg_nik and b.id_b22='" . $id . "'";
        $model = $connection->createCommand($sql);
        $penandatangan = $model->queryOne();
        $odf->setVars('nama_penandatangan', $penandatangan['nama']);
        $pangkat = explode('/', $penandatangan['pangkat']);
        $odf->setVars('pangkat', $pangkat[0]);
        $odf->setVars('nip_penandatangan', $penandatangan['peg_nip_baru']);

        $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_tembusan')
                ->where("id_perkara='" . $b22->id_perkara . "' AND kode_table='" . GlobalConstMenuComponent::B22 . "'and id_table = '" . $b22->id_b22 . "' order by no_urut");
        $dt_tembusan = $query->createCommand();
        $listTembusan = $dt_tembusan->queryAll();
        $dft_tembusan = $odf->setSegment('tembusan');
        foreach ($listTembusan as $element) {
            $dft_tembusan->urutan_tembusan($element['no_urut']);
            $dft_tembusan->nama_tembusan($element['tembusan']);
            $dft_tembusan->merge();
        }
        $odf->mergeSegment($dft_tembusan);

        $odf->exportAsAttachedFile();
    }

}
