<?php

namespace app\modules\pidum\controllers;

use app\components\GlobalConstMenuComponent;
use app\models\MsSifatSurat;
use app\modules\pidum\models\PdmB2;
use app\modules\pidum\models\PdmB2Search;
use app\modules\pidum\models\PdmPkTingRef;
use app\modules\pidum\models\PdmPenandatangan;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmSysMenu;
use app\modules\pidum\models\PdmTembusan;
use app\modules\pidum\models\VwTerdakwa;
use Odf;
use Yii;
use yii\db\Exception;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * PdmB2Controller implements the CRUD actions for PdmB2 model.
 */
class PdmB2Controller extends Controller {

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
        $this->sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::B2]);
    }

    /**
     * Lists all PdmB2 models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new PdmB2Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'sysMenu' => $this->sysMenu
        ]);
    }

    /**
     * Displays a single PdmB2 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmB2 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new PdmB2();

        $id = \Yii::$app->session->get('id_perkara');

        $modelSpdp = PdmSpdp::findOne(['id_perkara' => $id]);

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();

            try {
                $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_b2', 'id_b2', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();

                $model->id_perkara = $id;
                $model->id_b2 = $seq['generate_pk'];
                $model->save();

                //PdmTembusan::deleteAll(['id_perkara' => $model->id_perkara,'kode_table'=>GlobalConstMenuComponent::B2]);
                if (!empty($_POST['new_tembusan'])) {
                    for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                        $modelNewTembusan = new PdmTembusan();
                        $modelNewTembusan->id_table = $model->id_b2;
                        $seqTembusan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tembusan', 'id_tembusan', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                        $modelNewTembusan->id_tembusan = $seqTembusan['generate_pk'];
                        $modelNewTembusan->kode_table = GlobalConstMenuComponent::B2;
                        $modelNewTembusan->keterangan = $_POST['new_tembusan'][$i];
                        $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                        $modelNewTembusan->no_urut = $_POST['new_no_urut'][$i];
                        $modelNewTembusan->id_perkara = $model->id_perkara;
                        $modelNewTembusan->nip = null;
                        $modelNewTembusan->save();
                    }
                }

                Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara, GlobalConstMenuComponent::B2);
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
     * Updates an existing PdmB2 model.
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

                PdmTembusan::deleteAll(['id_perkara' => $model->id_perkara, 'kode_table' => GlobalConstMenuComponent::B2]);
                if (!empty($_POST['new_tembusan'])) {
                    for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                        $modelNewTembusan = new PdmTembusan();
                        $modelNewTembusan->id_table = $model->id_b2;
                        $seqTembusan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tembusan', 'id_tembusan', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                        $modelNewTembusan->id_tembusan = $seqTembusan['generate_pk'];
                        $modelNewTembusan->kode_table = GlobalConstMenuComponent::B2;
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
     * Deletes an existing PdmB2 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id) {
        $id_tersangka = $_POST['hapusIndex'];

        for ($i = 0; $i < count($id_tersangka); $i++) {
            $spdp = $this->findModel($id_tersangka[$i]);
            $spdp->flag = '3';
            $spdp->update();
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the PdmB2 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmB2 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PdmB2::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCetak($id_b2) {
        $connection = \Yii::$app->db;
        $odf = new Odf(Yii::$app->params['report-path'] . "modules/pidum/template/b2.odt");

        $b2 = PdmB2::findOne(['id_b2' => $id_b2]);
        $spdp = PdmSpdp::findOne(['id_perkara' => $id_b2]);
        $tersangka = VwTerdakwa::findOne(['id_tersangka' => $b2->id_tersangka]);
        $pidana = PdmPkTingRef::findOne(['id' => $spdp->id_pk_ting_ref]);
	                $pangkat = PdmPenandatangan::find()
->select ("a.jabatan as jabatan")
->from ("pidum.pdm_penandatangan a")
->join ('inner join','pidum.pdm_b2 b','a.peg_nik = b.id_penandatangan')
->where ("id_b2='".$id_b2."'")
->one(); 
        $odf->setVars('kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
        $odf->setVars('Kepala', $pangkat->jabatan);
        $odf->setVars('kepada', strtoupper($b2->kepada));

        $odf->setVars('nomor', $b2->no_surat);
        $odf->setVars('sifat', MsSifatSurat::findOne((int) $b2->sifat)->nama);
        $odf->setVars('lampiran', $b2->lampiran);
        $odf->setVars('ditempat', $b2->di_kepada);
        $odf->setVars('uraian', strip_tags($b2->uraian, '<b><i><u>'));
        $odf->setVars('no_berkas_perkara', $b2->no_surat);
        $odf->setVars('tanggal_berkas_perkara', Yii::$app->globalfunc->ViewIndonesianFormat($b2->tgl_dikeluarkan));
        $odf->setVars('dari_kepala', ucfirst(strtolower($b2->dikeluarkan)));
        $odf->setVars('tindak_pidana', $pidana->nama);
//		
//		# tersangka
//        $sql ="SELECT tersangka.* FROM "
//                . " pidum.pdm_b2 b2 LEFT OUTER JOIN pidum.vw_tersangka tersangka ON (b2.id_perkara = tersangka.id_perkara ) "
//                . "WHERE b2.id_perkara='".$b2->id_perkara."' "
//                . "ORDER BY id_tersangka "
//                . "LIMIT 1 ";
//        $model = $connection->createCommand($sql);
//        $tersangka = $model->queryOne();
        if ($tersangka['tgl_lahir']) {
            $umur = Yii::$app->globalfunc->datediff($tersangka->tgl_lahir, date("Y-m-d"));
            $tgl_lahir = $umur['years'] . ' tahun / ' . Yii::$app->globalfunc->ViewIndonesianFormat($tersangka->tgl_lahir);
        } else {
            $tgl_lahir = '-';
        }
        $odf->setVars('nama', ucfirst(strtolower($tersangka->nama)));
        $odf->setVars('tmpt_lahir', ucfirst(strtolower($tersangka->tmpt_lahir)));
        $odf->setVars('tgl_lahir', $tgl_lahir);
        $odf->setVars('jenis_kelamin', ucfirst(strtolower($tersangka->is_jkl)));
        $odf->setVars('kebangsaan', ucfirst(strtolower($tersangka->warganegara)));
        $odf->setVars('tmp_tinggal', ucfirst(strtolower($tersangka->alamat)));
        $odf->setVars('agama', ucfirst(strtolower($tersangka->is_agama)));
        $odf->setVars('pekerjaan', ucfirst(strtolower($tersangka->pekerjaan)));
        $odf->setVars('pendidikan', ucfirst(strtolower($tersangka->is_pendidikan)));


        #penanda tangan
        $sql = "SELECT a.nama,a.pangkat,a.jabatan,c.peg_nip_baru FROM "
                . " pidum.pdm_penandatangan a, pidum.pdm_b2 b , kepegawaian.kp_pegawai c "
                . "where a.peg_nik = b.id_penandatangan and b.id_penandatangan =c.peg_nik and b.id_b2='" . $id_b2 . "'";
        $model = $connection->createCommand($sql);
        $penandatangan = $model->queryOne();
        $odf->setVars('nama_penandatangan', $penandatangan['nama']);
        $pangkat = explode('/', $penandatangan['pangkat']);
        $odf->setVars('pangkat', $pangkat[0]);
        $odf->setVars('nip_penandatangan', $penandatangan['peg_nip_baru']);

        #tembusan
        $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_tembusan')
                ->where("id_perkara='" . $b2->id_perkara . "' AND kode_table='" . GlobalConstMenuComponent::B2 . "'and id_table = '" . $b2->id_b2 . "' order by no_urut");
        $dt_tembusan = $query->createCommand();
        $listTembusan = $dt_tembusan->queryAll();
        $dft_tembusan = $odf->setSegment('tembusan');
        foreach ($listTembusan as $element) {
            $dft_tembusan->urutan_tembusan($element['no_urut']);
            $dft_tembusan->nama_tembusan($element['tembusan']);
            $dft_tembusan->merge();
        }
        $odf->mergeSegment($dft_tembusan);



        #pasal
        $dft_pasal = '';
        $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_pasal')
                ->where("id_perkara  ='" . $id_b2 . "'");
        $data = $query->createCommand();
        $listpasal = $data->queryAll();
        foreach ($listpasal as $key) {
            $dft_pasal .= $key[pasal] . ',';
        }
        $odf->setVars('melanggar_pasal', $dft_pasal);




        $odf->exportAsAttachedFile();
    }

}
