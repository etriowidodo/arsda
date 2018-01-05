<?php

namespace app\modules\pidum\controllers;

use app\components\ConstDataComponent;
use app\components\GlobalConstMenuComponent;
use app\models\MsSifatSurat;
use app\modules\pidum\models\PdmB20;
use app\modules\pidum\models\PdmB20Search;
use app\modules\pidum\models\PdmB4;
use app\modules\pidum\models\PdmBa18;
use app\modules\pidum\models\PdmBarbukTambahan;
use app\modules\pidum\models\PdmMsStatusData;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmSysMenu;
use app\modules\pidum\models\PdmTembusan;
use app\modules\pidum\models\PdmPenandatangan;
use Odf;
use Yii;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;

/**
 * PdmB20Controller implements the CRUD actions for PdmB20 model.
 */
class PdmB20Controller extends Controller {

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
     * Lists all PdmB20 models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new PdmB20Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::B20]);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                        'sysMenu' => $sysMenu,
        ]);
    }

    /**
     * Displays a single PdmB20 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmB20 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new PdmB20();
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::B20]);
        $session = new Session();
        $id = $session->get('id_perkara');
        $modelB4 = PdmB4::findOne(['id_perkara' => $id]);
        $modelbarbuk = PdmBarbukTambahan::find()->where('id_b4=:id_b4 AND flag<>:flag', [':id_b4' => $modelB4->id_b4, ':flag' => '3'])->all();
        $model->dimanfaatkan = 'a. Kepentingan Kejaksaan....................</br>b. Bantuan korban bencana alam....................</br>c. Badan sosial....................</br>d. Instansi....................';
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_b20', 'id_b20', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                $model->id_perkara = $id;
                $model->id_b20 = $seq['generate_pk'];
                $model->save();
                //\kartik\form\ActiveForm::validate($model);die;
                //$NextProcces = array(ConstSysMenuComponent::B21);
                //Yii::$app->globalfunc->getNextProcces($model->id_perkara, $NextProcces);
                Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara, GlobalConstMenuComponent::B21);
                PdmTembusan::deleteAll(['id_perkara' => $model->id_perkara, 'id_table' => $model->id_b20, 'kode_table' => GlobalConstMenuComponent::B20]);
                if (!empty($_POST['new_tembusan'])) {
                    for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                        $modelNewTembusan = new PdmTembusan();
                        $seqTembusan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tembusan', 'id_tembusan', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                        $modelNewTembusan->id_tembusan = $seqTembusan['generate_pk'];
                        $modelNewTembusan->id_table = $model->id_b20;
                        $modelNewTembusan->kode_table = GlobalConstMenuComponent::B20;
                        $modelNewTembusan->keterangan = $_POST['new_tembusan'][$i];
                        $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                        $modelNewTembusan->no_urut = $_POST['new_no_urut'][$i];
                        $modelNewTembusan->id_perkara = $model->id_perkara;
                        $modelNewTembusan->nip = null;
                        $modelNewTembusan->save();
                        //\kartik\form\ActiveForm::validate($modelNewTembusan);die;
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
                return $this->redirect(['update2', 'id' => $model->id_b20]);
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
                return $this->redirect(['update2', 'id' => $model->id_b20]);
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'sysMenu' => $sysMenu,
                        'modelbarbuk' => $modelbarbuk
            ]);
        }
    }

    /**
     * Updates an existing PdmB20 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate() {
        $session = new Session();
        $id = $session->get('id_perkara');
        $model = $this->findModel($id);
        if ($model == null) {
            $model = new PdmB20();
        }
        $modelBa18 = PdmBa18::findOne(['id_perkara' => $id]);
        $model->barbuk = $modelBa18->barbuk;
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::B20]);
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($model->id_perkara == null) {
                    $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_b20', 'id_b20', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                    $model->id_perkara = $id;
                    $model->id_b20 = $seq['generate_pk'];
                    $model->save();
                    Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara, GlobalConstMenuComponent::B20);
                } else {
                    $model->update();
                }
                PdmTembusan::deleteAll(['id_perkara' => $model->id_perkara, 'id_table' => $model->id_b20, 'kode_table' => GlobalConstMenuComponent::B20]);
                if (!empty($_POST['new_tembusan'])) {
                    for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                        $modelNewTembusan = new PdmTembusan();
                        $seqTembusan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tembusan', 'id_tembusan', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                        $modelNewTembusan->id_tembusan = $seqTembusan['generate_pk'];
                        $modelNewTembusan->id_table = $model->id_b20;
                        $modelNewTembusan->kode_table = GlobalConstMenuComponent::B20;
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
        $model = PdmB20::findOne(['id_b20' => $id]);
        if ($model == null) {
            $model = new PdmB20();
        }
        $session = new Session();
        $session->destroySession('id_perkara');
        $session->set('id_perkara', $model->id_perkara);
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::B20]);
        $modelB4 = PdmB4::findOne(['id_perkara' => $model->id_perkara]);
        $modelbarbuk = PdmBarbukTambahan::findAll(['id_b4' => $modelB4->id_b4]);
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {

                $model->update();
                PdmTembusan::deleteAll(['id_perkara' => $model->id_perkara, 'id_table' => $model->id_b20, 'kode_table' => GlobalConstMenuComponent::B20]);
                if (!empty($_POST['new_tembusan'])) {
                    for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                        $modelNewTembusan = new PdmTembusan();
                        $seqTembusan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tembusan', 'id_tembusan', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                        $modelNewTembusan->id_tembusan = $seqTembusan['generate_pk'];
                        $modelNewTembusan->id_table = $model->id_b20;
                        $modelNewTembusan->kode_table = GlobalConstMenuComponent::B20;
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
                return $this->redirect(['update2', 'id' => $model->id_b20]);
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
                return $this->redirect(['update2', 'id' => $model->id_b20]);
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'sysMenu' => $sysMenu,
                        'modelbarbuk' => $modelbarbuk
            ]);
        }
    }

    /**
     * Deletes an existing PdmB20 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete() {
        $id = $_POST['hapusIndex'];

        for ($i = 0; $i < count($id); $i++) {
            $model = PdmB20::findOne(['id_b20' => $id[$i]]);
            $model->flag = '3';
            $model->update();
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the PdmB20 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmB20 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PdmB20::findOne(['id_perkara' => $id])) !== null) {
            return $model;
//        } else {
//            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCetak($id) {
        $connection = \Yii::$app->db;
        $odf = new Odf(Yii::$app->params['report-path'] . "modules/pidum/template/b20.odt");
$pangkat = PdmPenandatangan::find()
->select ("a.jabatan as jabatan")
->from ("pidum.pdm_penandatangan a")
->join ('inner join','pidum.pdm_p52 b','a.peg_nik = b.id_penandatangan')
->where ("id_p52='".$id."'")
->one();
        $b20 = PdmB20::findOne($id);
        $spdp = PdmSpdp::findOne(['id_perkara' => $b20->id_perkara]);
        $statusbarang = PdmMsStatusData::findOne(['id' => $b20->id_statusbrng, 'is_group' => ConstDataComponent::PerihalB20]);
        $sifat = MsSifatSurat::findOne((int) $b20->sifat)->nama;

        $odf->setVars('Kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
        $odf->setVars('kejaksaan', $pangkat->jabatan);
        $odf->setVars('nomor', $b20->no_surat);
        $odf->setVars('sifat', $sifat);
        $odf->setVars('lampiran', $b20->lampiran);
        $odf->setVars('perihal', $statusbarang->keterangan);
        $odf->setVars('isiperihal', $statusbarang->keterangan);
        $odf->setVars('dikeluarkan', $b20->dikeluarkan);
        $odf->setVars('pada_tanggal', Yii::$app->globalfunc->ViewIndonesianFormat($b20->tgl_dikeluarkan));
        $odf->setVars('melalui', $b20->kepada);
        $odf->setVars('ditempat', $b20->di_kepada);
        $odf->setVars('barbuk', Yii::$app->globalfunc->getBarbuk($b20->id_perkara));
        $odf->setVars('alasan', strip_tags($b20->alasan, '<b><i><u>'));
        $odf->setVars('dimanfaatkan', strip_tags($b20->dimanfaatkan, '<b><i><u>'));

#penanda tangan
        $sql = "SELECT a.nama,a.pangkat,a.jabatan,c.peg_nip_baru FROM "
                . " pidum.pdm_penandatangan a, pidum.pdm_b20 b , kepegawaian.kp_pegawai c "
                . "where a.peg_nik = b.id_penandatangan and b.id_penandatangan =c.peg_nik and b.id_b20='" . $id . "'";
        $model = $connection->createCommand($sql);
        $penandatangan = $model->queryOne();
        $odf->setVars('nama_penandatangan', $penandatangan['nama']);
        $odf->setVars('pangkat', $penandatangan['pangkat']);
        $odf->setVars('nip_penandatangan', $penandatangan['peg_nip_baru']);

        $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_tembusan')
                ->where("id_perkara='" . $b20->id_perkara . "' AND kode_table='" . GlobalConstMenuComponent::B20 . "'and id_table = '" . $b20->id_b20 . "' order by no_urut");
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
