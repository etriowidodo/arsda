<?php

namespace app\modules\pidum\controllers;

use app\components\GlobalConstMenuComponent;
use app\models\MsSifatSurat;
use app\modules\pidum\models\PdmP37;
use app\modules\pidum\models\PdmP38;
use app\modules\pidum\models\PdmMsSaksi;
use app\modules\pidum\models\PdmP38Search;
use app\modules\pidum\models\PdmPenandatangan;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmSysMenu;
use app\modules\pidum\models\PdmTahapDua;
use app\modules\pidum\models\PdmBerkasTahap1;
use app\modules\pidum\models\VwTerdakwaT2;
use app\modules\pidum\models\PdmMsStatusData;
use app\modules\pidum\models\PdmUuPasalTahap2;
use Odf;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;

/**
 * PdmP38Controller implements the CRUD actions for PdmP38 model.
 */
class PdmP38Controller extends Controller {

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
        $this->sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P38]);
    }

    /**
     * Lists all PdmP38 models.
     * @return mixed
     */
    public function actionIndex() {
        
        $session        = new Session();
        $id_perkara     = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $searchModel    = new PdmP38Search();
        $dataProvider   = $searchModel->search($no_register,Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'   => $searchModel,
            'dataProvider'  => $dataProvider,
            'sysMenu'       => $this->sysMenu
        ]);
    }

    /**
     * Displays a single PdmP38 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmP38 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $sysMenu        = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P38 ]);
        $session        = new Session();
        $id_perkara     = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $model          = new PdmP38();
        $vw_saksi       = PdmMsSaksi::findAll(['no_register_perkara'=>$no_register, 'jenis'=>1]);
        $vw_ahli        = PdmMsSaksi::findAll(['no_register_perkara'=>$no_register, 'jenis'=>2]);
        $vw_terdakwa    = VwTerdakwaT2::findAll(['no_register_perkara'=>$no_register]);

        if ($model->load(Yii::$app->request->post())) {
            try {
                $model->id_kejati           = $kode_kejati;
                $model->id_kejari           = $kode_kejari;
                $model->id_cabjari          = $kode_cabjari;
                $model->updated_by          = $session->get("nik_user"); 
                $model->updated_ip          = $_SERVER['REMOTE_ADDR'];
                $model->created_ip          = $_SERVER['REMOTE_ADDR'];
                $model->created_by          = $session->get("nik_user");
                $model->no_register_perkara = $no_register;
//                echo '<pre>';print_r($model);exit();
                $model->save();
                
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
                return $this->redirect(['index']);
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
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
                return $this->redirect('create', [
                    'model'         => $model,
                    'sysMenu'       => $sysMenu,
                    'no_register'   => $no_register,
                    'vw_saksi'      => $vw_saksi,
                    'vw_ahli'       => $vw_ahli,
                    'vw_terdakwa'   => $vw_terdakwa,
                ]);
            }
        } else {
            return $this->render('create', [
                'model'         => $model,
                'sysMenu'       => $sysMenu,
                'no_register'   => $no_register,
                'vw_saksi'      => $vw_saksi,
                'vw_ahli'       => $vw_ahli,
                'vw_terdakwa'   => $vw_terdakwa,
            ]);
        }
    }

    /**
     * Updates an existing PdmP38 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($no_surat_p38) {
        $sysMenu        = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P38 ]);
        $session        = new Session();
        $id_perkara     = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $model          = PdmP38::findOne(['no_surat_p38'=>$no_surat_p38]);
        $vw_saksi       = PdmMsSaksi::findAll(['no_register_perkara'=>$no_register, 'jenis'=>1]);
        $vw_ahli        = PdmMsSaksi::findAll(['no_register_perkara'=>$no_register, 'jenis'=>2]);
        $vw_terdakwa    = VwTerdakwaT2::findAll(['no_register_perkara'=>$no_register]);

        if ($model->load(Yii::$app->request->post())) {
            try {
//                $model->id_kejati           = $kode_kejati;
//                $model->id_kejari           = $kode_kejari;
//                $model->id_cabjari          = $kode_cabjari;
//                $model->updated_by          = $session->get("nik_user"); 
//                $model->updated_ip          = $_SERVER['REMOTE_ADDR'];
//                $model->created_ip          = $_SERVER['REMOTE_ADDR'];
//                $model->created_by          = $session->get("nik_user");
                $model->no_register_perkara = $no_register;
//                echo '<pre>';print_r($model);exit();
                $model->save();
                
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
                return $this->redirect(['index']);
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
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
                return $this->redirect('update', [
                    'model'         => $model,
                    'sysMenu'       => $sysMenu,
                    'no_register'   => $no_register,
                    'vw_saksi'      => $vw_saksi,
                    'vw_ahli'       => $vw_ahli,
                    'vw_terdakwa'   => $vw_terdakwa,
                ]);
            }
        } else {
            return $this->render('update', [
                'model'         => $model,
                'sysMenu'       => $sysMenu,
                'no_register'   => $no_register,
                'vw_saksi'      => $vw_saksi,
                'vw_ahli'       => $vw_ahli,
                'vw_terdakwa'   => $vw_terdakwa,
            ]);
        }
    }

    /**
     * Deletes an existing PdmP38 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete() {
        $id             = $_POST['hapusIndex'];
        $total          = count($id);
        $session        = new Session();
        $id_perkara     = $session->get("id_perkara");
        $no_register    = $session->get('no_register_perkara');
        try {
            if(count($id) <= 1){
                PdmP38::deleteAll(['no_surat_p38' => $id[0]]);
                
            }else{
                for ($i = 0; $i < count($id); $i++) {
                   PdmP38::deleteAll(['no_surat_p38' => $id[$i]]);
                }
            }
            Yii::$app->getSession()->setFlash('success', [
                'type' => 'success',
                'duration' => 3000,
                'icon' => 'fa fa-users',
                'message' => 'Data Berhasil di Hapus',
                'title' => 'Hapus Data',
                'positonY' => 'top',
                'positonX' => 'center',
                'showProgressbar' => true,
            ]);
            return $this->redirect(['index']);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            Yii::$app->getSession()->setFlash('success', [
                'type' => 'success',
                'duration' => 3000,
                'icon' => 'fa fa-users',
                'message' => 'Data Gagal di Hapus',
                'title' => 'Hapus Data',
                'positonY' => 'top',
                'positonX' => 'center',
                'showProgressbar' => true,
            ]);
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the PdmP38 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmP38 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PdmP38::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionCetak($id) {
        $no_surat_p38   = rawurldecode($id);
        $connection     = \Yii::$app->db;
        $session        = new Session();
        $id_perkara     = $session->get("id_perkara");
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $inst_satkerkd  = $session->get('inst_satkerkd');
        $p38            = PdmP38::findOne(['no_surat_p38'=>$no_surat_p38]);
        $thp_2          = PdmTahapDua::findOne(['no_register_perkara' => $p38->no_register_perkara]);
        $brks_thp_1     = PdmBerkasTahap1::findOne(['id_berkas' => $thp_2->id_berkas]);
        $spdp           = PdmSpdp::findOne(['id_perkara' => $brks_thp_1->id_perkara]);
        $pangkat        = PdmPenandatangan::findOne(['peg_nip_baru' => $p38->id_penandatangan]);
        $sifat          = MsSifatSurat::findOne(['id'=>$p38->sifat]);
        $panggil        = PdmMsStatusData::findOne(['id'=>$p38->id_msstatusdata,'is_group'=>'P-37 ']);
        $keperluan      = PdmMsStatusData::findOne(['id'=>$p38->id_ms_sts_data,'is_group'=>'P-38 ']);
//        echo $keperluan->keterangan;exit();
        
        if ($panggil->id == 1){
            $p37    = PdmMsSaksi::findAll(['no_register_perkara'=>$no_register, 'jenis'=>1]);
        }elseif ($panggil->id == 2) {
            $p37    = PdmMsSaksi::findAll(['no_register_perkara'=>$no_register, 'jenis'=>2]);
        }elseif ($panggil->id == 3) {
            $p37    = VwTerdakwaT2::findAll(['no_register_perkara'=>$no_register]);
        }elseif ($panggil->id == 4) {
            $p37    = PdmP37::findAll(['no_register_perkara'=>$no_register,'id_msstatusdata'=> '4']);
        }
        
        $pasal          = PdmUuPasalTahap2::findAll(['no_register_perkara'=>$no_register]);
        
        return $this->render('cetak', ['spdp'=>$spdp,'p37'=>$p37 ,'pangkat'=>$pangkat,'p38'=>$p38,'sifat'=>$sifat,'panggil'=>$panggil,'keperluan'=>$keperluan,'pasal'=>$pasal]);
    }


}
