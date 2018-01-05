<?php

namespace app\modules\pdsold\controllers;

use app\components\ConstSysMenuComponent;
use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\PdmB21;
use app\modules\pdsold\models\PdmB21Search;
use app\modules\pdsold\models\PdmJaksaPenerima;
use app\modules\pdsold\models\PdmPenandatangan;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmSysMenu;
use app\modules\pdsold\models\PdmTembusan;
use app\modules\pdsold\models\VwJaksaPenuntutSearch;
use Odf;
use Yii;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;

/**
 * PdmB21Controller implements the CRUD actions for PdmB21 model.
 */
class PdmB21Controller extends Controller {

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
     * Lists all PdmB21 models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new PdmB21Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::B21]);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'sysMenu' => $sysMenu,
        ]);
    }

    /**
     * Displays a single PdmB21 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmB21 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new PdmB21();
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::B21]);
        $modelJaksa = new PdmJaksaPenerima();
        $session = new Session();
        $id = $session->get('id_perkara');
        $spdp = PdmSpdp::findOne(['id_perkara' => $id]);
        $model->wilayah = Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama;
        $model->dikeluarkan = Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_lokinst;
        $searchJPU = new VwJaksaPenuntutSearch();
        $dataJPU = $searchJPU->search2(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;
        $model->pertimbangan = '- Kepentingan Dinas Kejaksaan....................</br>- Bantuan Korban Bencana Alam....................</br>- Badan Sosial....................</br>- Instansi....................';
        $model->untuk = '- Memusnahkan barang berupa....................</br>- Memanfaatkan barang-barang berupa....................</br>  Dengan menyerahkan (sebutkan nama barangnya)</br>  kepada....................</br>- Kepala Kejaksaan Negeri....................</br>  bagi kepentingan Kejaksaan Negeri....................</br>- Ketua Panitia Korban Bencana Alam di....................</br>  bagi keperluan korban bencana alam....................</br>- Ketua Badan Sosial....................</br>  Keperluan instansi....................</br>-Menyerahkan barang terlarang kepada instansi....................';
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_b21', 'id_b21', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                $model->id_perkara = $id;
                $model->id_b21 = $seq['generate_pk'];
                $model->save();
                $model->save();
                $NextProcces = array(ConstSysMenuComponent::BA22, ConstSysMenuComponent::BA19);
                Yii::$app->globalfunc->getNextProcces($model->id_perkara, $NextProcces);
                Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara, GlobalConstMenuComponent::B21);
                PdmTembusan::deleteAll(['id_perkara' => $model->id_perkara, 'id_table' => $model->id_b21, 'kode_table' => GlobalConstMenuComponent::B21]);
                $modelJaksa->load(Yii::$app->request->post());
                $seqjpp = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_jaksa_penerima', 'id_jpp', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                $modelJaksa->id_jpp = $seqjpp['generate_pk'];
                $modelJaksa->id_perkara = $model->id_perkara;
                $modelJaksa->code_table = GlobalConstMenuComponent::B21;
                $modelJaksa->id_table = $model->id_b21;
                $modelJaksa->flag = '1';
                $modelJaksa->save();
                PdmTembusan::deleteAll(['id_perkara' => $model->id_perkara, 'id_table' => $model->id_b21, 'kode_table' => GlobalConstMenuComponent::B21]);
                if (!empty($_POST['new_tembusan'])) {
                    for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                        $modelNewTembusan = new PdmTembusan();
                        $seqTembusan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tembusan', 'id_tembusan', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                        $modelNewTembusan->id_tembusan = $seqTembusan['generate_pk'];
                        $modelNewTembusan->id_table = $model->id_b21;
                        $modelNewTembusan->kode_table = GlobalConstMenuComponent::B21;
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
                return $this->redirect(['update2', 'id' => $model->id_b21]);
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
                        'sysMenu' => $sysMenu,
                        'modelJaksa' => $modelJaksa,
                        'searchJPU' => $searchJPU,
                        'dataJPU' => $dataJPU,
            ]);
        }
    }

    /**
     * Updates an existing PdmB21 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate() {
        $session = new Session();
        $id = $session->get('id_perkara');
        $model = PdmB21::findOne(['id_perkara' => $id]);
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::B21]);
        if ($model == null) {
            $model = new PdmB21();
        }
        $spdp = PdmSpdp::findOne(['id_perkara' => $id]);
        $model->wilayah = Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama;
        $model->dikeluarkan = Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_lokinst;
        $modelJaksa = PdmJaksaPenerima::findOne(['id_perkara' => $model->id_perkara, 'code_table' => GlobalConstMenuComponent::B21, 'id_table' => $model->id_b21]);
        if ($modelJaksa == null) {
            $modelJaksa = new PdmJaksaPenerima();
        }
        $searchJPU = new VwJaksaPenuntutSearch();
        $dataJPU = $searchJPU->search2(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($model->id_perkara == null) {
                    $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_b21', 'id_b21', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                    $model->id_perkara = $id;
                    $model->id_b21 = $seq['generate_pk'];
                    $model->save();
                    Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara, GlobalConstMenuComponent::B21);
                } else {
                    $model->update();
                }
                $modelJaksa->load(Yii::$app->request->post());
                if ($modelJaksa->id_perkara == null) {
                    $seqjpp = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_jaksa_penerima', 'id_jpp', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                    $modelJaksa->id_jpp = $seqjpp['generate_pk'];
                    $modelJaksa->id_perkara = $model->id_perkara;
                    $modelJaksa->code_table = GlobalConstMenuComponent::B21;
                    $modelJaksa->id_table = $model->id_b21;
                    $modelJaksa->flag = '1';
                    $modelJaksa->save();
                } else {
                    $modelJaksa->update();
                }
                PdmTembusan::deleteAll(['id_perkara' => $model->id_perkara, 'id_table' => $model->id_b21, 'kode_table' => GlobalConstMenuComponent::B21]);
                if (!empty($_POST['new_tembusan'])) {
                    for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                        $modelNewTembusan = new PdmTembusan();
                        $seqTembusan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tembusan', 'id_tembusan', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                        $modelNewTembusan->id_tembusan = $seqTembusan['generate_pk'];
                        $modelNewTembusan->id_table = $model->id_b21;
                        $modelNewTembusan->kode_table = GlobalConstMenuComponent::B21;
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
                        'sysMenu' => $sysMenu,
                        'modelJaksa' => $modelJaksa,
                        'searchJPU' => $searchJPU,
                        'dataJPU' => $dataJPU,
            ]);
        }
    }

    public function actionUpdate2($id) {
        $model = PdmB21::findOne(['id_b21' => $id]);
        $session = new Session();
        $session->destroySession('id_perkara');
        $session->set('id_perkara', $model->id_perkara);
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::B21]);
        $spdp = PdmSpdp::findOne(['id_perkara' => $model->id_perkara]);
        $model->wilayah = Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama;
        $model->dikeluarkan = Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_lokinst;
        $modelJaksa = PdmJaksaPenerima::findOne(['id_perkara' => $model->id_perkara, 'code_table' => GlobalConstMenuComponent::B21, 'id_table' => $model->id_b21]);
        if ($modelJaksa == null) {
            $modelJaksa = new PdmJaksaPenerima();
        }
        $searchJPU = new VwJaksaPenuntutSearch();
        $dataJPU = $searchJPU->search2(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->update();
                $modelJaksa->load(Yii::$app->request->post());
                $modelJaksa->update();
                PdmTembusan::deleteAll(['id_perkara' => $model->id_perkara, 'id_table' => $model->id_b21, 'kode_table' => GlobalConstMenuComponent::B21]);
                if (!empty($_POST['new_tembusan'])) {
                    for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                        $modelNewTembusan = new PdmTembusan();
                        $seqTembusan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tembusan', 'id_tembusan', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                        $modelNewTembusan->id_tembusan = $seqTembusan['generate_pk'];
                        $modelNewTembusan->id_table = $model->id_b21;
                        $modelNewTembusan->kode_table = GlobalConstMenuComponent::B21;
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
                return $this->redirect(['update2', 'id' => $model->id_b21]);
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
                return $this->redirect(['update2', 'id' => $model->id_b21]);
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'sysMenu' => $sysMenu,
                        'modelJaksa' => $modelJaksa,
                        'searchJPU' => $searchJPU,
                        'dataJPU' => $dataJPU,
            ]);
        }
    }

    /**
     * Deletes an existing PdmB21 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete() {
        $id = $_POST['hapusIndex'];

        for ($i = 0; $i < count($id); $i++) {
            $model = PdmB21::findOne(['id_b21' => $id[$i]]);
            $model->flag = '3';
            $model->update();
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the PdmB21 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmB21 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PdmB21::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCetak($id) {
        $connection = \Yii::$app->db;
        $odf = new Odf(Yii::$app->params['report-path'] . "modules/pdsold/template/b21.odt");
 $pangkat = PdmPenandatangan::find()
->select ("a.jabatan as jabatan")
->from ("pidum.pdm_penandatangan a")
->join ('inner join','pidum.pdm_b21 b','a.peg_nik = b.id_penandatangan')
->where ("id_b21='".$id."'")
->one(); 
        $b21 = PdmB21::findOne($id);
        $spdp = PdmSpdp::findOne(['id_perkara' => $b21->id_perkara]);
        $jaksapenerima = "select b.nama, a.peg_nip_baru, b.pangkat, b.jabatan, a.peg_nrp from kepegawaian.kp_pegawai a inner join 
            pidum.pdm_jaksa_penerima b on (b.nip = a.peg_nik) inner join pidum.pdm_b21 c on (c.id_b21 = b.id_table and c.id_perkara = b.id_perkara)
            where b.code_table='" . GlobalConstMenuComponent::B21 . "' and c.id_b21='$id'";
        $jaksapenerima1 = $connection->createCommand($jaksapenerima);
        $jaksapenerima2 = $jaksapenerima1->queryOne();
        $odf->setVars('Kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
        $odf->setVars('kejaksaan', $pangkat->jabatan);
        $odf->setVars('no_surat', $b21->no_surat);
        $odf->setVars('pertimbangan', strip_tags($b21->pertimbangan, '<b><i><u>'));
        $odf->setVars('untuk', strip_tags($b21->untuk, '<b><i><u>'));
        $odf->setVars('nama', $jaksapenerima2['nama']);
        $odf->setVars('pangkat', $jaksapenerima2['pangkat']);
        $odf->setVars('nip', $jaksapenerima2['peg_nip_baru']);
        $odf->setVars('nrp', $jaksapenerima2['peg_nrp']);
        $odf->setVars('pertimbangan', $b21->pertimbangan);
        $odf->setVars('dikeluarkan', $b21->dikeluarkan);
        $odf->setVars('nomor_surat_jaksa', '-');
        $odf->setVars('tanggal_surat_jaksa', '-');
        $odf->setVars('tgl_dikeluarkan', Yii::$app->globalfunc->ViewIndonesianFormat($b21->tgl_dikeluarkan));

#penanda tangan
        $sql = "SELECT a.nama,a.pangkat,a.jabatan,c.peg_nip_baru FROM "
                . " pidum.pdm_penandatangan a, pidum.pdm_b21 b , kepegawaian.kp_pegawai c "
                . "where a.peg_nik = b.id_penandatangan and b.id_penandatangan =c.peg_nik and b.id_b21='" . $id . "'";
        $model = $connection->createCommand($sql);
        $penandatangan = $model->queryOne();
        $odf->setVars('nama_penandatangan', $penandatangan['nama']);
        $pangkat = explode('/', $penandatangan['pangkat']);
        $odf->setVars('pangkat', $pangkat[0]);
        $odf->setVars('nip_penandatangan', $penandatangan['peg_nip_baru']);

        $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_tembusan')
                ->where("id_perkara='" . $b21->id_perkara . "' AND kode_table='" . GlobalConstMenuComponent::B21 . "'and id_table = '" . $b21->id_b21 . "' order by no_urut");
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
