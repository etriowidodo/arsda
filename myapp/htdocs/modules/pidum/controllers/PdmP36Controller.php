<?php

namespace app\modules\pidum\controllers;

use Yii;
use app\modules\pidum\models\PdmP36;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\VwTerdakwa;
use app\modules\pidum\models\PdmSysMenu;
use app\modules\pidum\models\PdmTembusan;
use app\modules\pidum\models\PdmP36Search;
use app\modules\pidum\models\PdmPenandatangan;
use app\modules\pidum\models\PdmTahapDua;
use app\modules\pidum\models\PdmBerkasTahap1;
use app\modules\pidum\models\VwTerdakwaT2;
use app\modules\pidum\models\PdmTembusanP36;
use app\models\MsSifatSurat;
use yii\db\Query;
use yii\web\Session;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\ConstSysMenuComponent;
use app\components\GlobalConstMenuComponent;

/**
 * PdmP36Controller implements the CRUD actions for PdmP36 model.
 */
class PdmP36Controller extends Controller
{
	public $sysMenu;
	
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }
    
    public function init(){
    	$this->sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P36]);
    }

    /**
     * Lists all PdmP36 models.
     * @return mixed
     */
    public function actionIndex()
    {
        $session        = new Session();
        $id_perkara     = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        
        $searchModel = new PdmP36Search();
        $dataProvider = $searchModel->search($no_register, Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'   => $searchModel,
            'dataProvider'  => $dataProvider,
            'sysMenu'       => $this->sysMenu
        ]);
    }

    /**
     * Displays a single PdmP36 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmP36 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $sysMenu                = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P36 ]);
	$session                = new Session();
        $id_perkara             = $session->get("id_perkara");
        $no_register_perkara    = $session->get("no_register_perkara");
        $kode_kejati            = $session->get('kode_kejati');
        $kode_kejari            = $session->get('kode_kejari');
        $kode_cabjari           = $session->get('kode_cabjari');
        $model                  = new PdmP36();

        if ($model->load(Yii::$app->request->post())) {
            try{
                $model->id_kejati           = $kode_kejati;
                $model->id_kejari           = $kode_kejari;
                $model->id_cabjari          = $kode_cabjari;
                $model->updated_by          = $session->get("nik_user"); 
                $model->updated_ip          = $_SERVER['REMOTE_ADDR'];
                $model->created_ip          = $_SERVER['REMOTE_ADDR'];
                $model->created_by          = $session->get("nik_user");
                $model->no_register_perkara = $no_register_perkara;

                $model->nama_ttd = $_POST['hdn_nama_penandatangan'];
                $model->pangkat_ttd = $_POST['hdn_pangkat_penandatangan'];
                $model->jabatan_ttd = $_POST['hdn_jabatan_penandatangan'];


//                echo '<pre>';print_r($model);exit();
                if($model->save()){
                    Yii::$app->globalfunc->getSetStatusProcces($id_perkara,GlobalConstMenuComponent::P36);
                    $NextProcces = array(ConstSysMenuComponent::P37,ConstSysMenuComponent::P40);
                    Yii::$app->globalfunc->getNextProcces2($id_perkara,$no_register_perkara,$NextProcces);
                    
                    if (isset($_POST['new_tembusan'])) {
                        PdmTembusanP36::deleteAll(['no_surat_p36' => $model->no_surat_p36]);
                        for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                            $modelNewTembusan                       = new PdmTembusanP36();
                            $modelNewTembusan->no_surat_p36         = $model->no_surat_p36;
                            $modelNewTembusan->no_register_perkara  = $no_register_perkara;
                            $modelNewTembusan->tembusan             = $_POST['new_tembusan'][$i];
                            $modelNewTembusan->no_urut              = ($i+1);
                            if(!$modelNewTembusan->save()){
                                echo "Tembusan".var_dump($modelNewTembusan->getErrors());exit;
                            }
                        }
                    }

                    //simpan
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
                        'duration' => 3000, //Integer //3000 default. time for growl to fade out.
                        'icon' => 'glyphicon glyphicon-ok-sign', //String
                        'message' => 'Data Berhasil di Simpan',
                        'title' => 'Simpan Data',
                        'positonY' => 'top', //String // defaults to top, allows top or bottom
                        'positonX' => 'center', //String // defaults to right, allows right, center, left
                        'showProgressbar' => true,
                    ]);
                    
                    return $this->redirect(['index']);
                }
                else{
                    $transaction->rollBack();
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'danger',
                        'duration' => 3000,
                        'icon' => 'glyphicon glyphicon-ok-sign', //String
                        'message' => 'Data Gagal di Simpan',
                        'title' => 'Simpan Data',
                        'positonY' => 'top',
                        'positonX' => 'center',
                        'showProgressbar' => true,
                    ]);
                    return $this->redirect('create', [
                        'model'     => $model,
                        'sysMenu'   => $sysMenu,
                    ]);
                }
            }catch (Exception $e){
                $transaction->rollBack();
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'danger',
                    'duration' => 3000,
                    'icon' => 'glyphicon glyphicon-ok-sign', //String
                    'message' => 'Terjadi Kesalahan',
                    'title' => 'Error',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
                return $this->redirect('create', [
                    'model'     => $model,
                    'sysMenu'   => $sysMenu,
                ]);
            }
            
        } else {
            return $this->render('create', [
                'model'     => $model,
                'sysMenu'   => $sysMenu,
            ]);
        }
    }

    /**
     * Updates an existing PdmP36 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($no_surat_p36)
    {
        $sysMenu                = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P36 ]);
	$session                = new Session();
        $id_perkara             = $session->get("id_perkara");
        $no_register_perkara    = $session->get("no_register_perkara");
        $kode_kejati            = $session->get('kode_kejati');
        $kode_kejari            = $session->get('kode_kejari');
        $kode_cabjari           = $session->get('kode_cabjari');
        $model                  = PdmP36::findOne(['no_surat_p36'=>$no_surat_p36]);
        
        if ($model->load(Yii::$app->request->post())) {
            try{
                $model->nama_ttd = $_POST['hdn_nama_penandatangan'];
                $model->pangkat_ttd = $_POST['hdn_pangkat_penandatangan'];
                $model->jabatan_ttd = $_POST['hdn_jabatan_penandatangan'];
                //echo '<pre>';print_r($_POST);exit;
                if($model->save()){    
                    if (isset($_POST['new_tembusan'])) {
                        PdmTembusanP36::deleteAll(['no_surat_p36' => $model->no_surat_p36]);
                        for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                            $modelNewTembusan                       = new PdmTembusanP36();
                            $modelNewTembusan->no_surat_p36         = $model->no_surat_p36;
                            $modelNewTembusan->no_register_perkara  = $no_register_perkara;
                            $modelNewTembusan->tembusan             = $_POST['new_tembusan'][$i];
                            $modelNewTembusan->no_urut              = ($i+1);
                            if(!$modelNewTembusan->save()){
                                echo "Tembusan".var_dump($modelNewTembusan->getErrors());exit;
                            }
                        }
                    }
                    
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
                        'duration' => 3000, //Integer //3000 default. time for growl to fade out.
                        'icon' => 'glyphicon glyphicon-ok-sign', //String
                        'message' => 'Data Berhasil di Ubah',
                        'title' => 'Ubah Data',
                        'positonY' => 'top', //String // defaults to top, allows top or bottom
                        'positonX' => 'center', //String // defaults to right, allows right, center, left
                        'showProgressbar' => true,
                    ]);
                    
                    return $this->redirect(['index']);
                }else{
                    $transaction->rollBack();
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'danger',
                        'duration' => 3000,
                        'icon' => 'glyphicon glyphicon-ok-sign', //String
                        'message' => 'Data Gagal di Ubah',
                        'title' => 'Error',
                        'positonY' => 'top',
                        'positonX' => 'center',
                        'showProgressbar' => true,
                    ]);
                    return $this->redirect('update', [
                        'model'     => $model,
                        'sysMenu'   => $sysMenu,
                    ]);
                }
            }catch (Exception $e){
                $transaction->rollBack();
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'danger',
                    'duration' => 3000,
                    'icon' => 'glyphicon glyphicon-ok-sign', //String
                    'message' => 'Terjadi Kesalahan',
                    'title' => 'Error',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
                return $this->redirect('update', [
                    'model'     => $model,
                    'sysMenu'   => $sysMenu,
                ]);
            }
        } else {
            return $this->render('update', [
                'model'     => $model,
                'sysMenu'   => $sysMenu,
            ]);
        }
    }

    /**
     * Deletes an existing PdmP36 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
        $id             = $_POST['hapusIndex'];
        $total          = count($id);
        $session        = new Session();
        $id_perkara     = $session->get("id_perkara");
        $no_register    = $session->get('no_register_perkara');
        try {
            if(count($id) <= 1){
                PdmP36::deleteAll(['no_surat_p36' => $id[0]]);
                
            }else{
                for ($i = 0; $i < count($id); $i++) {
                   PdmP36::deleteAll(['no_surat_p36' => $id[$i]]);
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


    public function actionCetak($id){
        $no_surat_p36   = rawurldecode($id);
        $connection     = \Yii::$app->db;
        $session        = new Session();
        $id_perkara     = $session->get("id_perkara");
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $inst_satkerkd  = $session->get('inst_satkerkd');
        $p36            = PdmP36::findOne(['no_surat_p36'=>$no_surat_p36]);
        $thp_2          = PdmTahapDua::findOne(['no_register_perkara' => $p36->no_register_perkara]);
        $brks_thp_1     = PdmBerkasTahap1::findOne(['id_berkas' => $thp_2->id_berkas]);
        $spdp           = PdmSpdp::findOne(['id_perkara' => $brks_thp_1->id_perkara]);
        $pangkat        = PdmPenandatangan::findOne(['peg_nip_baru' => $p36->id_penandatangan]);
        $tersangka      = VwTerdakwaT2::findAll(['no_register_perkara' => $p36->no_register_perkara]);
        $listTembusan   = PdmTembusanP36::findAll(['no_surat_p36' => $p36->no_surat_p36]);
        $sifat          = MsSifatSurat::findOne(['id'=>$p36->sifat]);
        
        return $this->render('cetak', ['spdp'=>$spdp,'tersangka'=>$tersangka,'pangkat'=>$pangkat,'p36'=>$p36,'listTembusan'=>$listTembusan,'sifat'=>$sifat]);
    }
   

    /**
     * Finds the PdmP36 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmP36 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmP36::findOne(['id_p36' => $id])) !== null) {
            return $model;
        } 
    }
}
