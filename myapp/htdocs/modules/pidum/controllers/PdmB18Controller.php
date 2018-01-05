<?php

namespace app\modules\pidum\controllers;

use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\PdmB18;
use app\modules\pidum\models\PdmBa5;
use app\modules\pidum\models\PdmBa5Barbuk;
use app\modules\pidum\models\PdmB18Search;
use app\modules\pidum\models\PdmJaksaSaksi;
use app\modules\pidum\models\PdmP16a;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmSysMenu;
use app\modules\pidum\models\PdmP48;
use app\modules\pidum\models\VwTerdakwaT2;
use app\modules\pidum\models\PdmPkTingRef;
use app\modules\pidum\models\PdmPutusanPnTerdakwa;
use app\modules\pidum\models\MsTersangka;
use app\modules\pidum\models\VwJaksaPenuntutSearch;
use app\modules\pidum\models\PdmPenandatangan;
use Yii;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;

/**
 * PdmB18Controller implements the CRUD actions for PdmB18 model.
 */
class PdmB18Controller extends Controller {

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
     * Lists all PdmB18 models.
     * @return mixed
     */
    public function actionIndex() {
        /*$searchModel = new PdmB18Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::B18]);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'sysMenu' => $sysMenu
        ]);*/
         return $this->redirect('update');
    }

    /**
     * Displays a single PdmB18 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmB18 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        /*$model = new PdmB18();
        $session = new Session();
        $id = $session->get('id_perkara');
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::B18]);
        $modelSpdp = PdmSpdp::findOne($id);
        //$model->wilayah = Yii::$app->globalfunc->getNamaSatker($modelSpdp->wilayah_kerja)->inst_nama;
        $searchJPU = new VwJaksaPenuntutSearch();
        $dataJPU = $searchJPU->search2(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;
        $modelP16A = PdmP16a::find()->where(['id_perkara' => $id])->orderBy('tgl_dikeluarkan desc')->one();
        $modeljaksi = PdmJaksaSaksi::find()->where(['id_perkara' => $id, 'code_table' => GlobalConstMenuComponent::P16A, 'id_table' => $modelP16A->id_p16a])->orderBy('no_urut')->All();
        $model->dikeluarkan = Yii::$app->globalfunc->getNamaSatker($modelSpdp->wilayah_kerja)->inst_lokinst;*/
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                /*$seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_b18', 'id_b18', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                $model->id_perkara = $id;
                $model->id_b18 = $seq['generate_pk'];
                $model->save();
                Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara, GlobalConstMenuComponent::B18);
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
                        $modeljaksi2->code_table = GlobalConstMenuComponent::B18;
                        $modeljaksi2->id_table = $model->id_b18;
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
                }*/
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
                return $this->redirect(['update', 'id' => $model->id_b18]);
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
     * Updates an existing PdmB18 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate() {
        $session = new session();
        $id_perkara = $session->get('id_perkara');
        $no_register_perkara = $session->get('no_register_perkara');
        $no_akta = $session->get('no_akta');
        $no_reg_tahanan = $session->get('no_reg_tahanan');
        $no_eksekusi = $session->get('no_eksekusi');

        $model = $this->findModel($no_eksekusi);
        if ($model == null) {
            $model = new PdmB18();
        }

        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::B18]);
        $modelSpdp = PdmSpdp::findOne($id_perkara);
        //$model->wilayah = Yii::$app->globalfunc->getNamaSatker($modelSpdp->wilayah_kerja)->inst_nama;
        $searchJPU = new VwJaksaPenuntutSearch();
        $dataJPU = $searchJPU->searchPegawaiSatker(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;
        //$modeljaksi = PdmJaksaSaksi::findAll(['id_perkara' => $model->id_perkara, 'code_table' => GlobalConstMenuComponent::B18, 'id_table' => $model->id_b18]);

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {

                //echo '<pre>';print_r($_POST);exit;
                $model->pelaksana = json_encode($_POST['pelaksana']);
                $model->no_eksekusi = $no_eksekusi;
                $model->no_reg_tahanan = $no_reg_tahanan;
                if($model->isNewRecord){
                    $model->created_time=date('Y-m-d H:i:s');
                    $model->created_by=\Yii::$app->user->identity->peg_nip;
                    $model->created_ip = \Yii::$app->getRequest()->getUserIP();    
                }
                $model->updated_by=\Yii::$app->user->identity->peg_nip;
                $model->updated_time=date('Y-m-d H:i:s');
                $model->updated_ip = \Yii::$app->getRequest()->getUserIP();    
                $model->nama_ttd = $_POST['hdn_nama_penandatangan'];
                $model->pangkat_ttd = $_POST['hdn_pangkat_penandatangan'];
                $model->jabatan_ttd = $_POST['hdn_jabatan_penandatangan'];

                if(!$model->save()){
                    var_dump($model->getErrors());exit;
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
                return $this->redirect(['update', 'no_surat' => $model->no_surat]);
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
                return $this->redirect(['update', 'no_surat' => $model->no_surat]);
            }
        } else {
            return $this->render('update', [
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
     * Deletes an existing PdmB18 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($no_eksekusi) {
        PdmB18::deleteAll(['no_eksekusi'=>$no_eksekusi]);
        return $this->redirect(['update']);
    }

    /**
     * Finds the PdmB18 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmB18 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($no_eksekusi) {
        if (($model = PdmB18::findOne(['no_eksekusi'=>$no_eksekusi])) !== null) {
            return $model;
        }
    }

    public function actionCetak($no_eksekusi) {
        $session = new session();
        $id_perkara = $session->get('id_perkara');
        $no_register_perkara = $session->get('no_register_perkara');
        $no_akta = $session->get('no_akta');
        $no_reg_tahanan = $session->get('no_reg_tahanan');
        $p48 = PdmP48::findOne(['no_surat'=>$no_eksekusi]);
        $model = $this->findModel($no_eksekusi);
        $spdp = PdmSpdp::findOne($id_perkara);
        $tersangka = VwTerdakwaT2::findOne(['no_register_perkara'=>$no_register_perkara, 'no_reg_tahanan'=>$model->no_reg_tahanan]);
        $putusan = PdmPutusanPnTerdakwa::findOne(['no_surat'=>trim($p48->no_putusan)]);
        $ba5 = PdmBa5::findOne(['no_register_perkara'=>$no_register_perkara]);
        $barbuk = PdmBa5Barbuk::findAll(['no_register_perkara'=>$no_register_perkara, 'id_ms_barbuk_eksekusi'=>2]);
        //echo '<pre>';print_r($barbuk);exit;
        //$jaksa = PdmJaksaP16a::findAll(['no_register_perkara'=>$no_register_perkara]);
        //echo '<pre>';print_r(count($jaksa));exit;
        //$listTembusan = PdmTembusanP48::findAll(['no_surat'=>$model->no_surat]);

        return $this->render('cetak', ['model'=>$model,'spdp'=>$spdp,'tersangka'=>$tersangka, 'listPasal'=>$listPasal, 'putusan'=>$putusan ,'p48'=>$p48, 'ba5'=>$ba5, 'barbuk'=>$barbuk]);
    }
    
}
