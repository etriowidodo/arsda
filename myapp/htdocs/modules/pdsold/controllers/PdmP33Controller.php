<?php

namespace app\modules\pdsold\controllers;

use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\MsAsalsurat;
use app\modules\pdsold\models\MsTersangka;
use app\modules\pdsold\models\PdmBa5;
use app\modules\pdsold\models\PdmJaksaSaksi;
use app\modules\pdsold\models\PdmP29;
use app\modules\pdsold\models\PdmP30;
use app\modules\pdsold\models\PdmP31;
use app\modules\pdsold\models\PdmP32;
use app\modules\pdsold\models\PdmP33;
use app\modules\pdsold\models\pdmP33Search;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmSysMenu;
use app\modules\pdsold\models\PdmTembusan;
use app\modules\pdsold\models\VwJaksaPenuntutSearch;
use app\modules\pdsold\models\VwTerdakwaT2;
use app\modules\pdsold\models\KpPegawaiSearch;
use app\modules\pdsold\models\KpPegawai;
use app\modules\pdsold\models\PdmTahapDua;
use app\modules\pdsold\models\PdmBerkasTahap1;
use Odf;
use Yii;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;

/**
 * PdmP33Controller implements the CRUD actions for PdmP33 model.
 */
class PdmP33Controller extends Controller {
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

    public function init(){
        $this->sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P33 ]);
    }

    /**
     * Lists all PdmP33 models.
     * @return mixed
     */
    public function actionIndex() {
        return $this->redirect(['update']);
//        $session        = new Session();
//        $id_perkara     = $session->get('id_perkara');
//        $no_register    = $session->get('no_register_perkara');
//        $kode_kejati    = $session->get('kode_kejati');
//        $kode_kejari    = $session->get('kode_kejari');
//        $kode_cabjari   = $session->get('kode_cabjari');
//        $searchModel    = new pdmP33Search();
//        $dataProvider   = $searchModel->search($no_register,Yii::$app->request->queryParams);
//
//         return $this->render('index', [
//             'searchModel' => $searchModel,
//             'dataProvider' => $dataProvider,
//             'sysMenu' => $this->sysMenu
//         ]);
    }

    /**
     * Displays a single PdmP33 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmP33 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
//        return $this->redirect(['update']);
        $sysMenu                = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P33 ]);
	$session                = new Session();
        $id_perkara             = $session->get("id_perkara");
        $no_register_perkara    = $session->get("no_register_perkara");
        $kode_kejati            = $session->get('kode_kejati');
        $kode_kejari            = $session->get('kode_kejari');
        $kode_cabjari           = $session->get('kode_cabjari');
        $model                  = new PdmP33();
        $modeltsk               = VwTerdakwaT2::findAll(['no_register_perkara'=>$no_register_perkara]);
        $searchJPU              = new KpPegawaiSearch();
        $dataJPU                = $searchJPU->searchPeg($kode_kejati,Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;
        
        if ($model->load(Yii::$app->request->post())) {
            try {
                $data_p33      = PdmP33::findOne(['no_register_perkara'=>$no_register_perkara,'tgl_p33'=>$model->tgl_p33]);
                if($data_p33->tgl_p33 == '' && $data_p33->no_register_perkara == ''){
                    $model->no_register_perkara = $no_register_perkara;
                    $model->nip_pegawai         = $_POST['PdmJaksaSaksi']['nip'];
                    $model->nama_pegawai        = $_POST['PdmJaksaSaksi']['nama'];
                    $model->pangkat_pegawai     = $_POST['PdmJaksaSaksi']['pangkat'];
                    $model->id_kejati           = $kode_kejati;
                    $model->id_kejari           = $kode_kejari;
                    $model->id_cabjari          = $kode_cabjari;
                    $model->updated_by          = $session->get("nik_user"); 
                    $model->updated_ip          = $_SERVER['REMOTE_ADDR'];
                    $model->created_ip          = $_SERVER['REMOTE_ADDR'];
                    $model->created_by          = $session->get("nik_user");
                    $model->file_upload         = $_POST['PdmP33']['file_upload'];
//                    echo '<pre>';print_r($model);exit();
                    $model->save();
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
                    return $this->redirect('index');
                }else{
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'danger',
                        'duration' => 3000,
                        'icon' => 'fa fa-users',
                        'message' => 'Data sudah ada disistem',
                        'title' => 'Error',
                        'positonY' => 'top',
                        'positonX' => 'center',
                        'showProgressbar' => true,
                    ]);
                    return $this->redirect('create',[
                        'model'                 => $model,
                        'sysMenu'               => $sysMenu,
                        'no_register_perkara'   => $no_register_perkara,
                        'dataJPU'               => $dataJPU,
                        'searchJPU'             => $searchJPU,
                        'modeltsk'              => $modeltsk,
                    ]);
                }
                
                
            } catch (Exception $exc) {
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
                return $this->redirect('create',[
                    'model'                 => $model,
                    'sysMenu'               => $sysMenu,
                    'no_register_perkara'   => $no_register_perkara,
                    'dataJPU'               => $dataJPU,
                    'searchJPU'             => $searchJPU,
                    'modeltsk'              => $modeltsk,
                ]);
            }
                    
        } else {
            return $this->render('create', [
                'model'                 => $model,
                'sysMenu'               => $sysMenu,
                'no_register_perkara'   => $no_register_perkara,
                'dataJPU'               => $dataJPU,
                'searchJPU'             => $searchJPU,
                'modeltsk'              => $modeltsk,
            ]);
        }
    }

    /**
     * Updates an existing PdmP33 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate() {
        $sysMenu                = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P33 ]);
	$session                = new Session();
        $id_perkara             = $session->get("id_perkara");
        $no_register_perkara    = $session->get("no_register_perkara");
        $kode_kejati            = $session->get('kode_kejati');
        $kode_kejari            = $session->get('kode_kejari');
        $kode_cabjari           = $session->get('kode_cabjari');
        
        $model = PdmP33::findOne(['no_register_perkara'=>$no_register_perkara]);
        if ($model == null) {
            $model = new PdmP33();
        }
        
        $modelpeg               = KpPegawai::findOne(['peg_nip_baru'=>$model->nip_pegawai]);
//        echo '<pre>';print_r($modelpeg);exit();
        $searchJPU              = new KpPegawaiSearch();
        $dataJPU                = $searchJPU->searchPeg($kode_kejati,Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;

        if ($model->load(Yii::$app->request->post())) {
            try {
                $model->no_register_perkara = $no_register_perkara;
                $model->nip_pegawai         = $_POST['PdmJaksaSaksi']['nip'];
                $model->nama_pegawai        = $_POST['PdmJaksaSaksi']['nama'];
                $model->pangkat_pegawai     = $_POST['PdmJaksaSaksi']['pangkat'];
                $model->id_kejati           = $kode_kejati;
                $model->id_kejari           = $kode_kejari;
                $model->id_cabjari          = $kode_cabjari;
                $model->updated_by          = $session->get("nik_user"); 
                $model->updated_ip          = $_SERVER['REMOTE_ADDR'];
                $model->created_ip          = $_SERVER['REMOTE_ADDR'];
                $model->created_by          = $session->get("nik_user");
                $model->file_upload         = $_POST['PdmP33']['file_upload'];
//                echo '<pre>';print_r($model);exit();
                $model->save();
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
                return $this->redirect('index');
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'success',
                    'duration' => 3000,
                    'icon' => 'fa fa-users',
                    'message' => 'Data Gagal disimpan',
                    'title' => 'Simpan Data',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
               return $this->redirect('update', [
                    'model'                 => $model,
                    'sysMenu'               => $sysMenu,
                    'no_register_perkara'   => $no_register_perkara,
                    'dataJPU'               => $dataJPU,
                    'searchJPU'             => $searchJPU,
                    'modelpeg'              => $modelpeg,
                ]);
            }
        } else {
            return $this->render('update', [
                'model'                 => $model,
                'sysMenu'               => $sysMenu,
                'no_register_perkara'   => $no_register_perkara,
                'dataJPU'               => $dataJPU,
                'searchJPU'             => $searchJPU,
                'modelpeg'              => $modelpeg,
            ]);
        }
    }

    /**
     * Updates an existing PdmP33 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    

    /**
     * Deletes an existing PdmP33 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete() {
        $connection     = \Yii::$app->db;
        try {
            $id                     = $_POST['hapusIndex'];
            $total                  = count($id);
            $session                = new Session();
            $id_perkara             = $session->get('id_perkara');
            $no_register_perkara    = $session->get('no_register_perkara');
            if($total == 1){
                $ids    = explode("#",$id[0]);
//                print_r($ids);exit();
//                echo $ids[1];exit();
                PdmP33::deleteAll(['no_register_perkara' => $ids[0],'tgl_p33'=>$ids[1]]);
            }else{
                for($i=0;$i<count($id);$i++){
                    $ids    = explode("#",$id[$i]);
                    PdmP33::deleteAll(['no_register_perkara' => $ids[0],'tgl_p33'=>$ids[1]]);
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
     * Finds the PdmP33 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmP33 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PdmP33::findOne($id)) !== null) {
            return $model;
//        } else {
//            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCetak($id) {
        $p31            = PdmP31::findOne(['no_register_perkara'=>$id]);
        $p32            = PdmP32::findOne(['no_register_perkara'=>$id]);
        $p30            = PdmP30::findOne(['no_register_perkara'=>$id]);
        $p29            = PdmP29::findOne(['no_register_perkara'=>$id]);
        if ($p31->no_register_perkara != '' && $p32->no_register_perkara == ''){
            $ket    = 'BIASA';
        }else if($p31->no_register_perkara == '' && $p32->no_register_perkara != ''){
            $ket    = 'SINGKAT';
        }
        $p33            = PdmP33::findOne(['no_register_perkara'=>$id]);
        $thp_2          = PdmTahapDua::findOne(['no_register_perkara' => $p33->no_register_perkara]);
        $brks_thp_1     = PdmBerkasTahap1::findOne(['id_berkas' => $thp_2->id_berkas]);
        $spdp           = PdmSpdp::findOne(['id_perkara' => $brks_thp_1->id_perkara]);
        
        return $this->render('cetak', ['spdp'=>$spdp,'p33'=>$p33,'p31'=>$p31,'p32'=>$p32,'p30'=>$p30,'p29'=>$p29,'ket'=>$ket,'brks_thp_1'=>$brks_thp_1]);
    }

    public function actionCetak_draft($id) {
        $p31            = PdmP31::findOne(['no_register_perkara'=>$id]);
        $p32            = PdmP32::findOne(['no_register_perkara'=>$id]);
        $p30            = PdmP30::findOne(['no_register_perkara'=>$id]);
        $p29            = PdmP29::findOne(['no_register_perkara'=>$id]);
        if ($p31->no_register_perkara != '' && $p32->no_register_perkara == ''){
            $ket    = 'BIASA';
        }else if($p31->no_register_perkara == '' && $p32->no_register_perkara != ''){
            $ket    = 'SINGKAT';
        }
        $p33            = PdmP33::findOne(['no_register_perkara'=>$id]);
        $thp_2          = PdmTahapDua::findOne(['no_register_perkara' => $p33->no_register_perkara]);
        $brks_thp_1     = PdmBerkasTahap1::findOne(['id_berkas' => $thp_2->id_berkas]);
        $spdp           = PdmSpdp::findOne(['id_perkara' => $brks_thp_1->id_perkara]);
        
        return $this->render('cetak_draft', ['spdp'=>$spdp,'p33'=>$p33,'p31'=>$p31,'p32'=>$p32,'p30'=>$p30,'p29'=>$p29,'ket'=>$ket,'brks_thp_1'=>$brks_thp_1]);
    }

    protected function findModelSpdp($id) {
        if (($modelSpdp = PdmSpdp::findOne($id)) !== null) {
            return $modelSpdp;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function findModelP33($id)
    {
        if (($model = PdmP33::findOne(['id_p33'=>$id])) !== null) {
            return $model;
        } /*else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }*/
    }

}
