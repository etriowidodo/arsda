<?php

namespace app\modules\pidum\controllers;

use app\components\ConstDataComponent;
use app\components\ConstSysMenuComponent;
use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\PdmBa22;
use app\modules\pidum\models\PdmBa22Search;
use app\modules\pidum\models\PdmJaksaSaksi;
use app\modules\pidum\models\PdmMsStatusData;
use app\modules\pidum\models\PdmP16a;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmSysMenu;
use app\modules\pidum\models\VwJaksaPenuntutSearch;
use Odf;
use Yii;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;

/**
 * PdmBa22Controller implements the CRUD actions for PdmBa22 model.
 */
class PdmBa22Controller extends Controller {

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
     * Lists all PdmBa22 models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new PdmBa22Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA22]);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'sysMenu' => $sysMenu
        ]);
    }

    /**
     * Displays a single PdmBa22 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmBa22 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $session = new Session();
        $id = $session->get('id_perkara');
        $model = new PdmBa22();
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA22]);
        $modelSpdp = PdmSpdp::findOne($id);
        $model->wilayah = Yii::$app->globalfunc->getNamaSatker($modelSpdp->wilayah_kerja)->inst_nama;
        $model->lokasi = Yii::$app->globalfunc->getNamaSatker($modelSpdp->wilayah_kerja)->inst_lokinst;
        $searchJPU = new VwJaksaPenuntutSearch();
        $dataJPU = $searchJPU->search2(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;
        $modelP16A = PdmP16a::find()->where(['id_perkara' => $id])->orderBy('tgl_dikeluarkan desc')->one();
        $modeljaksi = PdmJaksaSaksi::find()->where(['id_perkara' => $id, 'code_table' => GlobalConstMenuComponent::P16A, 'id_table' => $modelP16A->id_p16a])->orderBy('no_urut')->All();
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_ba22', 'id_ba22', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                $model->id_perkara = $id;
                $model->id_ba22 = $seq['generate_pk'];
                $model->save();
                Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara, GlobalConstMenuComponent::BA22);
                $NextProcces = array(ConstSysMenuComponent::B22);
                Yii::$app->globalfunc->getNextProcces($model->id_perkara, $NextProcces);
                $no_urut = $_POST["no_urut"];
                if (!empty($_POST['txtnip'])) { //peg_nip_baru
                    $count = 0;
                    foreach ($_POST['txtnip'] as $key) {
                        $query = new Query;
                        $query->select('*')
                                ->from('pidum.vw_jaksa_penuntut')
                                ->where("peg_instakhir='" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "' and peg_nip_baru='" . $key . "'");
                        $command = $query->createCommand();
                        $data = $command->queryAll();
                        $seqjpp = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_jaksa_saksi', 'id_jpp', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                        $modeljaksi2 = new PdmJaksaSaksi();
                        $modeljaksi2->id_jpp = $seqjpp['generate_pk'];
                        $modeljaksi2->id_perkara = $model->id_perkara;
                        $modeljaksi2->code_table = GlobalConstMenuComponent::BA22;
                        $modeljaksi2->id_table = $model->id_ba22;
                        $modeljaksi2->flag = '1';
                        $modeljaksi2->nama = $data[0]['peg_nama'];
                        $modeljaksi2->nip = $data[0]['peg_nip'];
                        $modeljaksi2->peg_nip_baru = $data[0]['peg_nip_baru'];
                        $modeljaksi2->jabatan = $data[0]['jabatan'];
                        $modeljaksi2->pangkat = $data[0]['pangkat'];
                        $modeljaksi2->no_urut = $no_urut[$count];
                        $modeljaksi2->save();
                        $count++;
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
                return $this->redirect(['update', 'id' => $model->id_ba22]);
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
                        'modelSpdp' => $modelSpdp,
                        'searchJPU' => $searchJPU,
                        'dataJPU' => $dataJPU,
                        'modeljaksi' => $modeljaksi,
            ]);
        }
    }

    /**
     * Updates an existing PdmBa22 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $modelSpdp = PdmSpdp::findOne($model->id_perkara);
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA22]);
        $model->wilayah = Yii::$app->globalfunc->getNamaSatker($modelSpdp->wilayah_kerja)->inst_nama;
        $modeljaksi = PdmJaksaSaksi::findAll(['id_perkara' => $model->id_perkara, 'code_table' => GlobalConstMenuComponent::BA22, 'id_table' => $model->id_ba22]);
        $searchJPU = new VwJaksaPenuntutSearch();
        $dataJPU = $searchJPU->search2(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->update();
                PdmJaksaSaksi::deleteAll(['id_perkara' => $model->id_perkara, 'code_table' => GlobalConstMenuComponent::BA22, 'id_table' => $model->id_ba22]);
                $no_urut = $_POST["no_urut"];
                if (!empty($_POST['txtnip'])) { //peg_nip_baru
                    $count = 0;
                    foreach ($_POST['txtnip'] as $key) {
                        $query = new Query;
                        $query->select('*')
                                ->from('pidum.vw_jaksa_penuntut')
                                ->where("peg_instakhir='" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "' and peg_nip_baru='" . $key . "'");
                        $command = $query->createCommand();
                        $data = $command->queryAll();
                        $seqjpp = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_jaksa_saksi', 'id_jpp', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                        $modeljaksi2 = new PdmJaksaSaksi();
                        $modeljaksi2->id_jpp = $seqjpp['generate_pk'];
                        $modeljaksi2->id_perkara = $model->id_perkara;
                        $modeljaksi2->code_table = GlobalConstMenuComponent::BA22;
                        $modeljaksi2->id_table = $model->id_ba22;
                        $modeljaksi2->flag = '1';
                        $modeljaksi2->nama = $data[0]['peg_nama'];
                        $modeljaksi2->nip = $data[0]['peg_nip'];
                        $modeljaksi2->peg_nip_baru = $data[0]['peg_nip_baru'];
                        $modeljaksi2->jabatan = $data[0]['jabatan'];
                        $modeljaksi2->pangkat = $data[0]['pangkat'];
                        $modeljaksi2->no_urut = $no_urut[$count];
                        $modeljaksi2->save();
                        $count++;
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
                return $this->redirect(['update', 'id' => $model->id_ba22]);
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
                return $this->redirect(['update', 'id' => $model->id_ba22]);
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'modelSpdp' => $modelSpdp,
                        'searchJPU' => $searchJPU,
                        'dataJPU' => $dataJPU,
                        'modeljaksi' => $modeljaksi,
                        'sysMenu' => $sysMenu,
            ]);
        }
    }

    /**
     * Deletes an existing PdmBa22 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete() {
        $id = $_POST['hapusIndex'];

        for ($i = 0; $i < count($id); $i++) {
            $model = PdmBa22::findOne(['id_ba22' => $id[$i]]);
            $model->flag = '3';
            $model->update();
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the PdmBa22 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmBa22 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PdmBa22::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCetak($id) {
        $connection = \Yii::$app->db;
        $odf = new Odf(Yii::$app->params['report-path'] . "modules/pidum/template/ba22.odt");

        $ba22 = PdmBa22::findOne($id);
        $MsData = PdmMsStatusData::findOne(['id' => $ba22->id_msstatdata, 'is_group' => ConstDataComponent::PenyerahanBrg]);
        $odf->setVars('msdata', $MsData->keterangan);
        $odf->setVars('hari', Yii::$app->globalfunc->GetNamaHari($ba22->tgl_surat));
        $odf->setVars('tgl_surat', Yii::$app->globalfunc->ViewIndonesianFormat($ba22->tgl_surat));
        $odf->setVars('lokasi', $ba22->lokasi);
        $odf->setVars('nama1', $ba22->nama1);
        $odf->setVars('pangkat1', $ba22->pangkat1);
        $odf->setVars('nip1', $ba22->nip1);
        $odf->setVars('jabatan1', $ba22->jabatan1);
        $odf->setVars('nama2', $ba22->nama2);
        $odf->setVars('pangkat2', $ba22->pangkat2);
        $odf->setVars('nip2', $ba22->nip2);
        $odf->setVars('jabatan2', $ba22->jabatan2);
        $odf->setVars('surat_perintah', '-');
        $odf->setVars('nomor', '-');
        $odf->setVars('tanggal', '-');
        $modeljaksi = PdmJaksaSaksi::findAll(['id_perkara' => $ba22->id_perkara, 'code_table' => GlobalConstMenuComponent::BA22, 'id_table' => $ba22->id_ba22]);
        $jaksi = $odf->setSegment('jaksaSaksi');
        $x = 1;
        foreach ($modeljaksi as $key) {
            $jaksi->nama_jaksi($key['nama']);
            $jaksi->pangkat_jaksi($key['pangkat']);
            $jaksi->nip_jaksi($key['peg_nip_baru']);
            $jaksi->no($x);
            $x++;
            $jaksi->merge();
        }
        $odf->mergeSegment($jaksi);
        $odf->setVars('keperluan', $ba22->keperluan);
        $odf->setVars('cara', $ba22->dimusnahkan);
        $odf->setVars('barbuk', Yii::$app->globalfunc->getBarbuk($ba22->id_perkara));
        $jaksi2 = $odf->setSegment('jaksasaksi2');
        $xx = 1;
        foreach ($modeljaksi as $key) {
            $jaksi2->nama_jaksi2($key['nama']);
            $jaksi2->pangkat($key['pangkat']);
            $jaksi2->nip($key['peg_nip_baru']);
            $jaksi2->no($xx);
            $xx++;
            $jaksi2->merge();
        }
        $odf->mergeSegment($jaksi2);


        $odf->exportAsAttachedFile();
    }

}
