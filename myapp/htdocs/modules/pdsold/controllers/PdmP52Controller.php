<?php

namespace app\modules\pdsold\controllers;

use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\PdmP44;
use app\modules\pdsold\models\PdmP52;
use app\modules\pdsold\models\PdmP52Search;
use app\modules\pdsold\models\PdmPasal;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmSysMenu;
use app\modules\pdsold\models\PdmTembusan;
use app\modules\pdsold\models\VwTerdakwa;
use app\modules\pdsold\models\PdmPenandatangan;
use Odf;
use Yii;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;

/**
 * PdmP52Controller implements the CRUD actions for PdmP52 model.
 */
class PdmP52Controller extends Controller {

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
     * Lists all PdmP52 models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new PdmP52Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P52]);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'sysMenu' => $sysMenu
        ]);
    }

    /**
     * Displays a single PdmP52 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmP52 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $session = new Session();
        $id = $session->get('id_perkara');
        $model = new PdmP52();
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P52]);
        $modelSpdp = PdmSpdp::findOne($id);
        $model->dikeluarkan = Yii::$app->globalfunc->getNamaSatker($modelSpdp->wilayah_kerja)->inst_lokinst;
        $model->tgl_dikeluarkan = date('Y-m-d');
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_p52', 'id_p52', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                $model->id_perkara = $id;
                $model->id_p52 = $seq['generate_pk'];
                $model->save();
                //$NextProcces = array(ConstSysMenuComponent::BA9);
                //Yii::$app->globalfunc->getNextProcces($model->id_perkara, $NextProcces);
                Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara, GlobalConstMenuComponent::P52);
                if (!empty($_POST['new_tembusan'])) {
                    for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                        $modelNewTembusan = new PdmTembusan();
                        $modelNewTembusan->id_table = $model->id_p52;
                        $seqTembusan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tembusan', 'id_tembusan', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                        $modelNewTembusan->id_tembusan = $seqTembusan['generate_pk'];
                        $modelNewTembusan->id_table = $model->id_p52;
                        $modelNewTembusan->kode_table = GlobalConstMenuComponent::P52;
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
                return $this->redirect(['update', 'id' => $model->id_p52]);
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
            ]);
        }
    }

    /**
     * Updates an existing PdmP52 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $session = new Session();
        $session->destroySession('id_perkara');
        $session->set('id_perkara', $model->id_perkara);
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P52]);
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {

                $model->update();
                PdmTembusan::deleteAll(['id_perkara' => $model->id_perkara, 'id_table' => $model->id_p52, 'kode_table' => GlobalConstMenuComponent::P52]);
                if (!empty($_POST['new_tembusan'])) {
                    for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                        $modelNewTembusan = new PdmTembusan();
                        $modelNewTembusan->id_table = $model->id_p52;
                        $seqTembusan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tembusan', 'id_tembusan', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                        $modelNewTembusan->id_tembusan = $seqTembusan['generate_pk'];
                        $modelNewTembusan->id_table = $model->id_p52;
                        $modelNewTembusan->kode_table = GlobalConstMenuComponent::P52;
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
                return $this->redirect(['update', 'id' => $model->id_p52]);
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
                return $this->redirect(['update', 'id' => $model->id_p52]);
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'sysMenu' => $sysMenu
            ]);
        }
    }

    /**
     * Deletes an existing PdmP52 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete() {
        $id = $_POST['hapusIndex'];

        for ($i = 0; $i < count($id); $i++) {
            $model = PdmP52::findOne(['id_p52' => $id[$i]]);
            $model->flag = '3';
            $model->update();
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the PdmP52 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmP52 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PdmP52::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCetak($id) {
        $connection = \Yii::$app->db;
        $odf = new Odf(Yii::$app->params['report-path'] . "modules/pdsold/template/p52.odt");

        $p52 = PdmP52::findOne($id);
        $p44 = PdmP44::find()->where(['id_perkara' => $p52->id_perkara])->orderBy('tgl_dikeluarkan DESC')->One();
        $pasal = PdmPasal::findAll(['id_perkara' => $p52->id_perkara]);
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
		$pangkat = PdmPenandatangan::find()
->select ("a.jabatan as jabatan")
->from ("pidum.pdm_penandatangan a")
->join ('inner join','pidum.pdm_p52 b','a.peg_nik = b.id_penandatangan')
->where ("id_p52='".$id."'")
->one();
        $spdp = PdmSpdp::findOne(['id_perkara' => $p52->id_perkara]);
        $tersangka = VwTerdakwa::findOne(['id_tersangka' => $p52->id_tersangka]);
        $odf->setVars('Kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
        $odf->setVars('kejaksaan', $pangkat->jabatan);
        $odf->setVars('nama_lengkap', $tersangka->nama);
        $odf->setVars('tempat_lahir', $tersangka->tmpt_lahir);
        $odf->setVars('tgl_lahir', Yii::$app->globalfunc->ViewIndonesianFormat($tersangka->tgl_lahir));
        $umur = Yii::$app->globalfunc->datediff($tersangka->tgl_lahir, date("Y-m-d"));
        $odf->setVars('umur', $umur['years'] . ' tahun');
        $odf->setVars('jenis_kelamin', $tersangka->is_jkl);
        $odf->setVars('kebangsaan', $tersangka->warganegara);
        $odf->setVars('tempat_tinggal', $tersangka->alamat);
        $odf->setVars('agama', $tersangka->is_agama);
        $odf->setVars('pekerjaan', $tersangka->pekerjaan);
        $odf->setVars('pendidikan', $tersangka->is_pendidikan);
        $odf->setVars('suami_istri', $p52->stat_kawin);
        $odf->setVars('nm_orangtua', $p52->ortu);
        $odf->setVars('no_putusan', $p44->no_surat);
        $odf->setVars('tgl_putusan', Yii::$app->globalfunc->ViewIndonesianFormat($p44->tgl_putusan));
        $odf->setVars('amar_putusan', $pasal1);
        $odf->setVars('tgl_pidana', Yii::$app->globalfunc->ViewIndonesianFormat($p52->tgl_jth_pidana));
        $odf->setVars('no_keputusan', $p52->no_put_penjara);
        $odf->setVars('tgl_keputusan', Yii::$app->globalfunc->ViewIndonesianFormat($p52->tgl_put_penjara));
        $odf->setVars('syarat_pembina', $p52->syarat_bina);
        $odf->setVars('tgl_pelaksanaan_bersyarat', Yii::$app->globalfunc->ViewIndonesianFormat($p52->tgl_pelaksanaan));
        $odf->setVars('tgl_bersyarat', Yii::$app->globalfunc->ViewIndonesianFormat($p52->tgl_lepas_syarat));
        $odf->setVars('tgl_berakhir_percobaan', '-');
        $odf->setVars('kajari_mengawasi', $p52->kejari_pengawas);
        $odf->setVars('bapas_membimbing', $p52->balai_bapas);
        $odf->setVars('ket', strip_tags($p52->keterangan, '<b><i><u>'));
        $odf->setVars('tanggal', Yii::$app->globalfunc->ViewIndonesianFormat($p52->tgl_dikeluarkan));


#penanda tangan
        $sql = "SELECT a.nama,a.pangkat,a.jabatan,c.peg_nip_baru FROM "
                . " pidum.pdm_penandatangan a, pidum.pdm_p52 b , kepegawaian.kp_pegawai c "
                . "where a.peg_nik = b.id_penandatangan and b.id_penandatangan =c.peg_nik and b.id_p52='" . $id . "'";
        $model = $connection->createCommand($sql);
        $penandatangan = $model->queryOne();
        $odf->setVars('nama_penandatangan', $penandatangan['nama']);
        $odf->setVars('pangkat', $penandatangan['pangkat']);
        $odf->setVars('nip_penandatangan', $penandatangan['peg_nip_baru']);

        $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_tembusan')
                ->where("id_perkara='" . $p52->id_perkara . "' AND kode_table='" . GlobalConstMenuComponent::P52 . "'and id_table = '" . $p52->id_p52 . "' order by no_urut");
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
