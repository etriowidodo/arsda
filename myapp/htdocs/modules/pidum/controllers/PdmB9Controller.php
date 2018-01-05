<?php

namespace app\modules\pidum\controllers;

use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\KpPegawai;
use app\modules\pidum\models\KpPegawaiSearch;
use app\modules\pidum\models\PdmB9;
use app\modules\pidum\models\PdmB9Search;
use app\modules\pidum\models\PdmBa5;
use app\modules\pidum\models\PdmBa5Jaksa;
use app\modules\pidum\models\PdmBa5Barbuk;
use app\modules\pidum\models\PdmJaksaSaksi;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmSysMenu;
use app\modules\pidum\models\PdmTembusan;
use app\modules\pidum\models\VwJaksaPenuntutSearch;
use app\modules\pidum\models\VwTerdakwaT2;
use yii\web\Session;
use Odf;
use Yii;
use yii\db\Exception;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * PdmB9Controller implements the CRUD actions for PdmB9 model.
 */
class PdmB9Controller extends Controller {

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
        $this->sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::B9]);
    }

    /**
     * Lists all PdmB9 models.
     * @return mixed
     */
    public function actionIndex() {
        $session = new session();
        $no_register_perkara = $session->get('no_register_perkara');
        $searchModel = new PdmB9Search();
        $dataProvider = $searchModel->search($no_register_perkara,Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'sysMenu' => $this->sysMenu
        ]);
    }

    /**
     * Displays a single PdmB9 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmB9 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model                  = new PdmB9();
        $session                = new session();
        $no_register_perkara    = $session->get('no_register_perkara');
        $kode                   = $session->get('inst_satkerkd');

        $searchPetugas          = new KpPegawaiSearch();
        $dataPetugas            = $searchPetugas->searchSaksi(Yii::$app->request->queryParams,$kode);
        $dataPetugas->pagination->pageSize = 5;

        $modeljaksi             = PdmBa5Jaksa::findAll(['no_register_perkara' => $no_register_perkara]);
        $modelBarbuk            = PdmBa5Barbuk::find()->where(['no_register_perkara'=>$no_register_perkara])
                                                      ->orderBy('no_urut_bb')->all();

        if ($model->load(Yii::$app->request->post())) {
            //echo '<pre>';print_r($_POST);exit;
            $model->no_register_perkara = $no_register_perkara;
            $model->tgl_b9              = $_POST['PdmB9']['tgl_b9'];
            $model->nip_jaksa           = $_POST['PdmB9']['nip_jaksa'];
            $model->nip_petugas         = $_POST['PdmB9']['nip_petugas'];
            $model->created_time        = date('Y-m-d H:i:s');
            $model->created_by          = \Yii::$app->user->identity->peg_nip;
            $model->created_ip          = \Yii::$app->getRequest()->getUserIP();
            $model->barbuk              = json_encode($_POST['barbuk']);
            $model->updated_by          =\Yii::$app->user->identity->peg_nip;
            $model->updated_time        = date('Y-m-d H:i:s');
            $model->updated_ip          = \Yii::$app->getRequest()->getUserIP();
            
            $model->id_kejati           = $session->get('kode_kejati');
            $model->id_kejari           = $session->get('kode_kejari');
            $model->id_cabjari          = $session->get('kode_cabjari');
//            echo '<pre>';print_r($model);exit;

            if($model->save()){
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
            }else{

                        var_dump($model->getErrors());exit;
                       
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
            }
            $this->redirect('index');
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'searchPetugas' => $searchPetugas,
                        'dataPetugas' => $dataPetugas,
                        'modeljaksi' => $modeljaksi,
                        'sysMenu' => $this->sysMenu,
                        'modelBarbuk' => $modelBarbuk,
            ]);
        }
    }

    /**
     * Updates an existing PdmB9 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $session = new session();
        $no_register_perkara = $session->get('no_register_perkara');
        $kode  = $session->get('inst_satkerkd');

        $model = $this->findModel($id);
        /*
        if($model == null){
            $model = new PdmB9();
        }*/

        $searchPetugas = new KpPegawaiSearch();
        $dataPetugas = $searchPetugas->searchSaksi(Yii::$app->request->queryParams,$kode);
        $dataPetugas->pagination->pageSize=5;
        $modeljaksi = PdmBa5Jaksa::findAll(['no_register_perkara' => $no_register_perkara]);
        $modelBarbuk = PdmBa5Barbuk::find()->where(['no_register_perkara'=>$no_register_perkara])
                                            ->orderBy('no_urut_bb')->all();


        if ($model->load(Yii::$app->request->post())) {
            //echo '<pre>';print_r($_POST);exit;
            $transaction = Yii::$app->db->beginTransaction();
            try {

                $model->no_register_perkara = $no_register_perkara;
                $model->tgl_b9 =$_POST['PdmB9']['tgl_b9'];
                $model->nip_jaksa = $_POST['PdmB9']['nip_jaksa'];
                $model->nip_petugas = $_POST['PdmB9']['nip_petugas'];
                $model->barbuk = json_encode($_POST['barbuk']);
                $model->updated_by=\Yii::$app->user->identity->peg_nip;
                $model->updated_time=date('Y-m-d H:i:s');
                $model->updated_ip = \Yii::$app->getRequest()->getUserIP();
                
                $model->id_kejati = $session->get('kode_kejati');
                $model->id_kejari = $session->get('kode_kejari');
                $model->id_cabjari = $session->get('kode_cabjari');

                if(!$model->save()){
                        var_dump($model->getErrors());exit;
                       }
                //Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara, GlobalConstMenuComponent::B9);
                //echo '<pre>';print_r($_POST);exit;




                $transaction->commit();

                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'success',
                        'duration' => 3000,
                        'icon' => 'fa fa-users',
                        'message' => 'Data Berhasil di Ubah',
                        'title' => 'Ubah Data',
                        'positonY' => 'top',
                        'positonX' => 'center',
                        'showProgressbar' => true,
                    ]);
                    return $this->redirect(['update', 'id' => $model->tgl_b9]);
//                }else{
//                    Yii::$app->getSession()->setFlash('success', [
//                        'type' => 'danger',
//                        'duration' => 3000,
//                        'icon' => 'fa fa-users',
//                        'message' => 'Data Gagal di Ubah',
//                        'title' => 'Error',
//                        'positonY' => 'top',
//                        'positonX' => 'center',
//                        'showProgressbar' => true,
//                    ]);
//                    return $this->redirect(['update', 'id_b9' => $model->id_b9]);
//                }
            }catch (Exception $e) {
                $transaction->rollback();
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'danger',
                    'duration' => 3000,
                    'icon' => 'fa fa-users',
                    'message' => 'Terjadi Kesalahan',
                    'title' => 'Error',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
                return $this->redirect(['update', 'id' => $model->tgl_b9]);
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'searchPetugas' => $searchPetugas,
                        'dataPetugas' => $dataPetugas,
                        'modeljaksi' => $modeljaksi,
                        'sysMenu' => $this->sysMenu,
                        'modelBarbuk' => $modelBarbuk,
            ]);
        }
    }

    /**
     * Deletes an existing PdmB9 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete() {
        $session = new session();
        $no_register_perkara = $session->get('no_register_perkara');
        $arr= array();
        $id_tahap = $_POST['hapusIndex'][0];
        
            if($id_tahap=='all'){
                    $id_tahapx=PdmB9::find()->select("tgl_b9")->where(['no_register_perkara'=>$no_register_perkara])->asArray()->all();
                    foreach ($id_tahapx as $key => $value) {
                        $arr[] = $value['tgl_b9'];
                        
                    }
                    $id_tahap=$arr;
            }else{
                $id_tahap = $_POST['hapusIndex'];
            }

        $count = 0;
           foreach($id_tahap AS $key_delete => $delete){
             try{
                    PdmB9::deleteAll(['no_register_perkara' => $no_register_perkara, 'tgl_b9'=>$delete]);
                }catch (\yii\db\Exception $e) {
                  $count++;
                }
            }
            if($count>0){
                Yii::$app->getSession()->setFlash('success', [
                     'type' => 'danger',
                     'duration' => 5000,
                     'icon' => 'fa fa-users',
                     'message' =>  $count.' Data Berkas Tidak Dapat Dihapus Karena Sudah Digunakan Di Persuratan Lainnya',
                     'title' => 'Error',
                     'positonY' => 'top',
                     'positonX' => 'center',
                     'showProgressbar' => true,
                 ]);
                 return $this->redirect(['index']);
            }

            return $this->redirect(['index']);
    }


    public function actionGetPetugas()
    {
        $session  = new session();
        $kode  = $session->get('inst_satkerkd');

        $searchPetugas = new KpPegawaiSearch();
        $dataPetugas = $searchPetugas->searchSaksi(Yii::$app->request->queryParams,$kode);
        $dataPetugas->pagination->pageSize=5;
        //echo '<pre>';print_r($dataPetugas);exit;
        return $this->renderAjax('_m_petugas', [
                'searchPetugas' => $searchPetugas,
                'dataPetugas' => $dataPetugas,
        ]);
    }

    /**
     * Finds the PdmB9 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmB9 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        $session = new session();
        $no_register_perkara = $session->get('no_register_perkara');

        if (($model = PdmB9::findOne(['no_register_perkara'=>$no_register_perkara, 'tgl_b9'=>$id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        } 
    }

    protected function findModelSpdp($id) {
        if (($modelSpdp = PdmSpdp::findOne(['id_perkara' => $id])) !== null) {
            return $modelSpdp;
        }
    }

    public function actionCetak($id){
        $session                = new session();
        $no_register_perkara    = $session->get('no_register_perkara');
        $model                  = PdmB9::findOne(['no_register_perkara'=> $no_register_perkara, 'tgl_b9' => $id]);
        $ba5                    = PdmBa5::findOne(['no_register_perkara' => $no_register_perkara]);
        $in                     = json_decode($model->barbuk);
        $modelBarbuk            = PdmBa5Barbuk::find()->where(['no_register_perkara'=>$no_register_perkara])
                                                        ->andWhere(['in','no_urut_bb', $in])->orderBy('no_urut_bb')->all();

        $dft_barbuk = '';
        $tnda = ', ';
        foreach ($modelBarbuk as $key) {
            $dft_barbuk .= Yii::$app->globalfunc->GetDetBarbuk($model->no_register_perkara,$key['no_urut_bb']) . $tnda;
        }

        //echo '<pre>';print_r($dft_barbuk);exit;
        $tersangka      = VwTerdakwaT2::findOne(['no_register_perkara' => $no_register_perkara]);
        $modelpeg       = KpPegawai::findOne(['peg_nip_baru'=>$T11->peg_nip]);
        return $this->render('cetak', ['model'=>$model, 'ba5'=>$ba5, 'tersangka'=>$tersangka, 'session'=>$_SESSION, 'barbuk'=>$dft_barbuk]);
    }

}
