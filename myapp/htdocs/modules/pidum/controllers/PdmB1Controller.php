<?php

namespace app\modules\pidum\controllers;

use app\components\GlobalConstMenuComponent;
use app\models\MsSifatSurat;
use app\modules\pidum\models\PdmB1;
use app\modules\pidum\models\PdmB1Search;
use app\modules\pidum\models\PdmPasal;
use app\modules\pidum\models\PdmPkTingRef;
use app\modules\pidum\models\PdmPenandatangan;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmSysMenu;
use app\modules\pidum\models\PdmTembusan;
use app\modules\pidum\models\VwTerdakwa;
use Odf;
use Yii;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * PdmB1Controller implements the CRUD actions for PdmB1 model.
 */
class PdmB1Controller extends Controller {

    public $sysMenu;

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

    public function init() {
        $this->sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::B1]);
    }

    /**
     * Lists all PdmB1 models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new PdmB1Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'sysMenu' => $this->sysMenu
        ]);
    }

    /**
     * Displays a single PdmB1 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmB1 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new PdmB1();

        $id = \Yii::$app->session->get('id_perkara');

        $modelSpdp = PdmSpdp::findOne(['id_perkara' => $id]);

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();

            try {
                $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_b1', 'id_b1', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();

                $model->id_perkara = $id;
                $model->id_b1 = $seq['generate_pk'];
                $model->save();

                PdmTembusan::deleteAll(['id_perkara' => $model->id_perkara, 'kode_table' => GlobalConstMenuComponent::B1]);
                if (!empty($_POST['new_tembusan'])) {
                    for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                        $modelNewTembusan = new PdmTembusan();
                        $modelNewTembusan->id_table = $model->id_b1;
                        $seqTembusan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tembusan', 'id_tembusan', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                        $modelNewTembusan->id_tembusan = $seqTembusan['generate_pk'];
                        $modelNewTembusan->kode_table = GlobalConstMenuComponent::B1;
                        $modelNewTembusan->keterangan = $_POST['new_tembusan'][$i];
                        $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                        $modelNewTembusan->no_urut = $_POST['new_no_urut'][$i];
                        $modelNewTembusan->id_perkara = $model->id_perkara;
                        $modelNewTembusan->nip = null;
                        $modelNewTembusan->save();
                    }
                }

                Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara, GlobalConstMenuComponent::B1);
                $transaction->commit();

                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'success',
                    'duration' => 3000,
                    'icon' => 'fa fa-users',
                    'message' => 'Data Berhasil di Simpan',
                    'title' => 'Ubah Data',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
                return $this->redirect('index');
            } catch (Exception $e) {
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
                $transaction->rollback();
            }
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'modelSpdp' => $modelSpdp,
                        'sysMenu' => $this->sysMenu
            ]);
        }
    }

    /**
     * Updates an existing PdmB1 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        $id_perkara = \Yii::$app->session->get('id_perkara');

        $modelSpdp = PdmSpdp::findOne(['id_perkara' => $id_perkara]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $transaction = Yii::$app->db->beginTransaction();

            try {

                PdmTembusan::deleteAll(['id_perkara' => $model->id_perkara, 'kode_table' => GlobalConstMenuComponent::B1]);
                if (!empty($_POST['new_tembusan'])) {
                    for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                        $modelNewTembusan = new PdmTembusan();
                        $modelNewTembusan->id_table = $model->id_b1;
                        $seqTembusan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tembusan', 'id_tembusan', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                        $modelNewTembusan->id_tembusan = $seqTembusan['generate_pk'];
                        $modelNewTembusan->kode_table = GlobalConstMenuComponent::B1;
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
                    'title' => 'Ubah Data',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
                return $this->redirect('index');
            } catch (Exception $e) {
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
                $transaction->rollback();
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'modelSpdp' => $modelSpdp,
                        'sysMenu' => $this->sysMenu
            ]);
        }
    }

    /**
     * Deletes an existing PdmB1 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete() {
        $id_tersangka = $_POST['hapusIndex'];

        for ($i = 0; $i < count($id_tersangka); $i++) {
            $spdp = $this->findModel($id_tersangka[$i]);
            $spdp->flag = '3';
            $spdp->update();
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the PdmB1 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmB1 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PdmB1::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCetak($id) {
        $connection = \Yii::$app->db;
        $odf = new Odf(Yii::$app->params['report-path'] . "modules/pidum/template/b1.odt");

        $b1 = PdmB1::findOne($id);
	                $pangkat = PdmPenandatangan::find()
->select ("a.jabatan as jabatan")
->from ("pidum.pdm_penandatangan a")
->join ('inner join','pidum.pdm_b1 b','a.peg_nik = b.id_penandatangan')
->where ("id_b1='".$id."'")
->one(); 
        $spdp = PdmSpdp::findOne(['id_perkara' => $b1->id_perkara]);
        $tersangka = VwTerdakwa::findOne(['id_tersangka' => $b1->id_tersangka]);
        $sifat = MsSifatSurat::findOne((int) $b1->sifat)->nama;
        $pasal = PdmPasal::findAll(['id_perkara' => $b1->id_perkara]);
        $pidana = PdmPkTingRef::findOne(['id' => $spdp->id_pk_ting_ref]);
        $pasal1 = "";
        if (count($pasal) == 1) {
            $pasal1 = $pasal[0]->pasal;
        } else if (count($pasal) == 2) {
            $i = 0;
            foreach ($pasal as $key) {
                if ($i == 0) {
                    $pasal1 .= $key->pasal;
                    $i = 1;
                } else {
                    $pasal1 .= ' dan ' . $key->pasal;
                }
            }
        } else if (count($pasal) > 2) {
            $i = 1;
            foreach ($pasal as $key) {
                if ($i == count($pasal)) {
                    $pasal1 .= 'dan ' . $key->pasal;
                } else {
                    $pasal1 .= $key->pasal . ', ';
                    $i++;
                }
            }
        }

        $odf->setVars('Kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
        $odf->setVars('kejaksaan', $pangkat->jabatan);
        $odf->setVars('kejaksaan1', ucfirst(strtolower(Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_lokinst)));
        $odf->setVars('nomor', $b1->no_surat);
        $odf->setVars('sifat', $sifat);
        $odf->setVars('ditempat', $b1->di_kepada);
        $odf->setVars('nama_lengkap', ucfirst(strtolower($tersangka->nama)));
        $odf->setVars('tempat_lahir', ucfirst(strtolower($tersangka->tmpt_lahir)));
        $odf->setVars('tgl_lahir', Yii::$app->globalfunc->ViewIndonesianFormat($tersangka->tgl_lahir));
        $umur = Yii::$app->globalfunc->datediff($tersangka->tgl_lahir, date("Y-m-d"));
        $odf->setVars('umur', $umur['years'] . ' Tahun');
        $odf->setVars('jenis_kelamin', ucfirst(strtolower($tersangka->is_jkl)));
        $odf->setVars('kebangsaan', ucfirst(strtolower($tersangka->warganegara)));
        $odf->setVars('tempat_tinggal', ucfirst(strtolower($tersangka->alamat)));
        $odf->setVars('agama', ucfirst(strtolower($tersangka->is_agama)));
        $odf->setVars('pekerjaan', ucfirst(strtolower($tersangka->pekerjaan)));
        $odf->setVars('pendidikan', ucfirst(strtolower($tersangka->is_pendidikan)));
        $odf->setVars('barbuk', ucfirst(strtolower($b1->barbuk)));
        $odf->setVars('disimpan_di', $b1->simpan_di);
        $odf->setVars('dikuasai', '-');
        $odf->setVars('barang_diduga', '-');
        $odf->setVars('terhadap', '-');
        $odf->setVars('nomor_prin', $b1->no_surat);
        $odf->setVars('tanggal_prin', Yii::$app->globalfunc->ViewIndonesianFormat($b1->tgl_dikeluarkan));
        $odf->setVars('pasal', $pasal1);
        $odf->setVars('no_berkas_perkara', $spdp->no_surat);
        $odf->setVars('tanggal_berkas_perkara', Yii::$app->globalfunc->ViewIndonesianFormat($spdp->tgl_surat));
        $odf->setVars('tindak_pidana', $pidana->nama);
        $odf->setVars('lampiran', $b1->lampiran);
        $odf->setVars('kepada', strtoupper($b1->kepada));

        $sql = "SELECT a.nama,a.pangkat,a.jabatan,c.peg_nip_baru FROM "
                . " pidum.pdm_penandatangan a, pidum.pdm_b1 b , kepegawaian.kp_pegawai c "
                . "where a.peg_nik = b.id_penandatangan and b.id_penandatangan =c.peg_nik and b.id_b1='" . $id . "'";
        $model = $connection->createCommand($sql);
        $penandatangan = $model->queryOne();
        $odf->setVars('nama_penandatangan', $penandatangan['nama']);
        $pangkat = explode('/', $penandatangan['pangkat']);
        $odf->setVars('pangkat', $pangkat[0]);
        $odf->setVars('nip_penandatangan', $penandatangan['peg_nip_baru']);

        $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_tembusan')
                ->where("id_perkara='" . $b1->id_perkara . "' AND kode_table='" . GlobalConstMenuComponent::B1 . "'and id_table = '" . $b1->id_b1 . "' order by no_urut");
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
