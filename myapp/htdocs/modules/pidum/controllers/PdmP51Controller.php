<?php

namespace app\modules\pidum\controllers;

use app\components\ConstSysMenuComponent;
use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\PdmAmarPutusP29;
use app\modules\pidum\models\PdmP45;
use app\modules\pidum\models\PdmP51;
use app\modules\pidum\models\PdmP51Search;
use app\modules\pidum\models\PdmPasal;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmSysMenu;
use app\modules\pidum\models\PdmTembusan;
use app\modules\pidum\models\VwTerdakwa;
use app\modules\pidum\models\PdmPenandatangan;
use Odf;
use Yii;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;

/**
 * PdmP51Controller implements the CRUD actions for PdmP51 model.
 */
class PdmP51Controller extends Controller {

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
     * Lists all PdmP51 models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new PdmP51Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P51]);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'sysMenu' => $sysMenu
        ]);
    }

    /**
     * Displays a single PdmP51 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmP51 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $session = new Session();
        $id = $session->get('id_perkara');
        $model = new PdmP51();
        $modelSpdp = PdmSpdp::findOne($id);
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P51]);
        $model->dikeluarkan = Yii::$app->globalfunc->getNamaSatker($modelSpdp->wilayah_kerja)->inst_lokinst;
        $amar29 = PdmAmarPutusP29::find()->where(['id_perkara' => $id])->orderBy('id_amar desc')->One();
        if ($amar29->hari_coba != null || $amar29->bulan_coba != null)
        $model->percobaan = $amar29->hari_coba . ' hari ' . $amar29->bulan_coba . 'bulan ' . $amar29->tahun_coba . 'tahun';
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_p51', 'id_p51', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                $model->id_perkara = $id;
                $model->id_p51 = $seq['generate_pk'];
                $model->save();
                $NextProcces = array(ConstSysMenuComponent::P52);
                Yii::$app->globalfunc->getNextProcces($model->id_perkara, $NextProcces);
                Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara, GlobalConstMenuComponent::P51);
                if (!empty($_POST['new_tembusan'])) {
                    for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                        $modelNewTembusan = new PdmTembusan();
                        $modelNewTembusan->id_table = $model->id_p51;
                        $seqTembusan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tembusan', 'id_tembusan', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                        $modelNewTembusan->id_tembusan = $seqTembusan['generate_pk'];
                        $modelNewTembusan->id_table = $model->id_p51;
                        $modelNewTembusan->kode_table = GlobalConstMenuComponent::P51;
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
                return $this->redirect(['update', 'id' => $model->id_p51]);
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
     * Updates an existing PdmP51 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $session = new Session();
        $session->destroySession('id_perkara');
        $session->set('id_perkara', $model->id_perkara);
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P51]);
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {

                $model->update();
                PdmTembusan::deleteAll(['id_perkara' => $model->id_perkara, 'id_table' => $model->id_p51, 'kode_table' => GlobalConstMenuComponent::P51]);
                if (!empty($_POST['new_tembusan'])) {
                    for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                        $modelNewTembusan = new PdmTembusan();
                        $modelNewTembusan->id_table = $model->id_p51;
                        $seqTembusan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tembusan', 'id_tembusan', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                        $modelNewTembusan->id_tembusan = $seqTembusan['generate_pk'];
                        $modelNewTembusan->id_table = $model->id_p51;
                        $modelNewTembusan->kode_table = GlobalConstMenuComponent::P51;
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
                return $this->redirect(['update', 'id' => $model->id_p51]);
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
                return $this->redirect(['update', 'id' => $model->id_p51]);
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'sysMenu' => $sysMenu,
            ]);
        }
    }

    /**
     * Deletes an existing PdmP51 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete() {
        $id = $_POST['hapusIndex'];

        for ($i = 0; $i < count($id); $i++) {
            $model = PdmP51::findOne(['id_p51' => $id[$i]]);
            $model->flag = '3';
            $model->update();
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the PdmP51 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmP51 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PdmP51::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCetak($id) {
        $connection = \Yii::$app->db;
        $odf = new Odf(Yii::$app->params['report-path'] . "modules/pidum/template/p51.odt");
 $pangkat = PdmPenandatangan::find()
->select ("a.jabatan as jabatan")
->from ("pidum.pdm_penandatangan a")
->join ('inner join','pidum.pdm_p51 b','a.peg_nik = b.id_penandatangan')
->where ("id_p51='".$id."'")
->one(); 
        $p51 = PdmP51::findOne($id);
        $p45 = PdmP45::find()->where(['id_perkara' => $p51->id_perkara])->orderBy('tgl_dikeluarkan DESC')->One();
        $spdp = PdmSpdp::findOne(['id_perkara' => $p51->id_perkara]);
        $tersangka = VwTerdakwa::findOne(['id_tersangka' => $p51->id_tersangka]);
        $pasal = PdmPasal::findAll(['id_perkara' => $p51->id_perkara]);
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
        $odf->setVars('suami_istri', $p51->stat_kawin);
        $odf->setVars('nm_orangtua', $p51->ortu);
        $odf->setVars('tgl_pidana', Yii::$app->globalfunc->ViewIndonesianFormat($p51->tgl_jth_pidana));
        $odf->setVars('jenis_perbuatan', $p45->put_pengadilan);
        $odf->setVars('pasal_amar_putusan', $pasal1);
        $odf->setVars('pidana_pengganti', '-');
        $odf->setVars('dng_perjanjian', '-');
        $odf->setVars('dalam_perjanjian', '-');
        $odf->setVars('masa_percobaan', $p51->percobaan);
        $odf->setVars('mulai_masapercobaan', Yii::$app->globalfunc->ViewIndonesianFormat($p51->tgl_awal_coba));
        $odf->setVars('habisnya_masa_percobaan', Yii::$app->globalfunc->ViewIndonesianFormat($p51->tgl_akhir_coba));
        $odf->setVars('dalam_putusan_hakim', $p51->syarat);
        $odf->setVars('tanggal', Yii::$app->globalfunc->ViewIndonesianFormat($p51->tgl_dikeluarkan));
//        if ($modelTersangka->foto != null) {
//            //$path = '/image/upload_file/MsTersangka/' . $modelTersangka->foto;
//            $path = 'C:/xampp/htdocs/simkari_cms/web/image/upload_file/MsTersangka/a.png'; 
//            //echo($path);exit;
//            $odf->setImage('photo', $path, null, 20, 30, null, null);
//        } else {
        $odf->setVars('photo', '');
//        }
#penanda tangan
        $sql = "SELECT a.nama,a.pangkat,a.jabatan,c.peg_nip_baru FROM "
                . " pidum.pdm_penandatangan a, pidum.pdm_p51 b , kepegawaian.kp_pegawai c "
                . "where a.peg_nik = b.id_penandatangan and b.id_penandatangan =c.peg_nik and b.id_p51='" . $id . "'";
        $model = $connection->createCommand($sql);
        $penandatangan = $model->queryOne();
        $odf->setVars('nama_penandatangan', $penandatangan['nama']);
        $odf->setVars('pangkat', $penandatangan['pangkat']);
        $odf->setVars('nip_penandatangan', $penandatangan['peg_nip_baru']);

        $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_tembusan')
                ->where("id_perkara='" . $p51->id_perkara . "' AND kode_table='" . GlobalConstMenuComponent::P51 . "'and id_table = '" . $p51->id_p51 . "' order by no_urut");
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
