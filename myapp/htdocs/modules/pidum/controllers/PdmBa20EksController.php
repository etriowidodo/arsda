<?php

namespace app\modules\pidum\controllers;

use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\PdmBa20;
use app\modules\pidum\models\PdmBa20Eks;
use app\modules\pidum\models\PdmBa20Search;
use app\modules\pidum\models\PdmBa20EksSearch;
use Jaspersoft\Client\Client;
use Yii;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;
use app\modules\pidum\models\PdmSysMenu;
use app\modules\pidum\models\PdmTembusan;
use app\modules\pidum\models\PdmBarbukTambahan;
use app\modules\pidum\models\PdmB4;
use app\modules\pidum\models\PdmBa20Jaksa;
use app\modules\pidum\models\PdmTahapDua;
use app\modules\pidum\models\PdmBerkasTahap1;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\VwTerdakwaT2;
use app\modules\pidum\models\PdmJaksaP16a;
use app\modules\pidum\models\PdmJaksaP16aSearch;
use app\modules\pidum\models\PdmUuPasalTahap2;
use app\modules\pidum\models\PdmP48;
use app\modules\pidum\models\PdmPutusanPn;
use app\modules\pidum\models\PdmBarbuk;

/**
 * PdmBa20Controller implements the CRUD actions for PdmBa20 model.
 */
class PdmBa20EksController extends Controller
{
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

    /**
     * Lists all PdmBa20 models.
     * @return mixed
     */
    public function actionIndex()
    {
//        $session        = new Session();
//        $id_perkara     = $session->get('id_perkara');
//        $no_register    = $session->get('no_register_perkara');
//        $kode_kejati    = $session->get('kode_kejati');
//        $kode_kejari    = $session->get('kode_kejari');
//        $kode_cabjari   = $session->get('kode_cabjari');
//		
//        $searchModel    = new PdmBa20Search();
//        $dataProvider   = $searchModel->search($no_register,Yii::$app->request->queryParams);
//
//        return $this->render('index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
        return $this->redirect('update');
    }

    /**
     * Displays a single PdmBa20 model.
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
     * Creates a new PdmBa20 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $sysMenu        = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA20 ]);
	$session        = new Session();
        $id_perkara     = $session->get("id_perkara");
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $inst_satkerkd  = $session->get('inst_satkerkd');
        $model          = new PdmBa20();
        $modelJpu       = PdmJaksaP16a::findAll(['no_register_perkara' => $no_register]);
        $modeljaksi     = PdmJaksaP16a::findOne(['no_register_perkara' => $no_register]);
        $searchJPU      = new PdmJaksaP16aSearch();
        $dataJPU        = $searchJPU->search2($no_register,Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;
        
        if ($model->load(Yii::$app->request->post())) {
            try {
                $data_ba20      = PdmBa20::findOne(['no_register_perkara'=>$no_register,'tgl_ba20'=>$model->tgl_ba20]);
                if($data_ba20->tgl_ba20 == '' && $data_ba20->no_register_perkara == ''){
                    $enkot          = json_encode($_POST['txt_nama_surat']);
                    $model->id_kejati           = $kode_kejati;
                    $model->id_kejari           = $kode_kejari;
                    $model->id_cabjari          = $kode_cabjari;
                    $model->no_register_perkara = $no_register;
                    $model->saksi               = $enkot;
                    $model->no_surat_p16a       = $_POST['PdmJaksaSaksi']['no_surat_p16a'];
                    $model->no_urut_jaksa_p16a  = $_POST['PdmJaksaSaksi']['no_urut'];
                    $model->updated_by          = $session->get("nik_user"); 
                    $model->updated_ip          = $_SERVER['REMOTE_ADDR'];
                    $model->created_ip          = $_SERVER['REMOTE_ADDR'];
                    $model->created_by          = $session->get("nik_user");
                    //                echo '<pre>'; print_r($model);exit();
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
                        'model'         => $model,
                        'sysMenu'       => $sysMenu,
                        'no_register'   => $no_register,
                        'modelJpu'      => $modelJpu,
                        'modeljaksi'    => $modeljaksi,
                        'searchJPU'     => $searchJPU,
                        'dataJPU'       => $dataJPU,
                    ]);
                }
            }catch (Exception $e) {
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
                    'model'         => $model,
                    'sysMenu'       => $sysMenu,
                    'no_register'   => $no_register,
                    'modelJpu'      => $modelJpu,
                    'modeljaksi'    => $modeljaksi,
                    'searchJPU'     => $searchJPU,
                    'dataJPU'       => $dataJPU,
                ]);
            }
        } else {
            return $this->render('create', [
                'model'         => $model,
                'sysMenu'       => $sysMenu,
                'no_register'   => $no_register,
                'modelJpu'      => $modelJpu,
                'modeljaksi'    => $modeljaksi,
                'searchJPU'     => $searchJPU,
                'dataJPU'       => $dataJPU,
            ]);
        }
    }

    /**
     * Updates an existing PdmBa20 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $session        = new Session();
        $id_perkara     = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $inst_satkerkd  = $session->get('inst_satkerkd');
        $no_akta        = $session->get('no_akta');
        $no_reg_tahanan = $session->get('no_reg_tahanan');
        $no_eksekusi    = $session->get('no_eksekusi');
        
        $model = PdmBa20Eks::findOne(['no_eksekusi'=>$no_eksekusi]);
        if ($model == null) {
            $model = new PdmBa20Eks();
        }
        
//        $model          = PdmBa20::findOne(['no_register_perkara'=>$id,'tgl_ba20'=>$id2]);
        $dekot          = json_decode($model->saksi);
        $modelJpu       = PdmJaksaP16a::findAll(['no_register_perkara' => $no_register]);
        $modeljaksi     = PdmJaksaP16a::findOne(['no_register_perkara' => $no_register,'no_surat_p16a'=>$model->no_surat_p16a,'no_urut'=>$model->no_urut_jaksa_p16a]);
        $searchJPU      = new PdmJaksaP16aSearch();
        $dataJPU        = $searchJPU->search2($no_register,Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;
			
        if ($model->load(Yii::$app->request->post())) {
            try {
                $enkot                      = json_encode($_POST['txt_nama_surat']);
                $model->saksi               = $enkot;
                $model->no_surat_p16a       = $_POST['PdmJaksaSaksi']['no_surat_p16a'];
                $model->no_urut_jaksa_p16a  = $_POST['PdmJaksaSaksi']['no_urut'];
                $model->updated_by          = $session->get("nik_user"); 
                $model->updated_ip          = $_SERVER['REMOTE_ADDR'];
                $model->created_ip          = $_SERVER['REMOTE_ADDR'];
                $model->created_by          = $session->get("nik_user");
                $model->no_register_perkara = $no_register;
                $model->no_akta             = $no_akta;
                $model->no_reg_tahanan      = $no_reg_tahanan;
                $model->no_eksekusi         = $no_eksekusi;
                $model->id_kejati           = $kode_kejati;
                $model->id_kejari           = $kode_kejari;
                $model->id_cabjari          = $kode_cabjari;
//                echo '<pre>'; print_r($model);exit();
                
                if($model->save()){
                    
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
                    return $this->redirect('update', [
                        'model'         => $model,
                        'sysMenu'       => $sysMenu,
                        'no_register'   => $no_register,
                        'modelJpu'      => $modelJpu,
                        'modeljaksi'    => $modeljaksi,
                        'searchJPU'     => $searchJPU,
                        'dataJPU'       => $dataJPU,
                        'dekot'         => $dekot,
                        'no_reg_tahanan'    => $no_reg_tahanan,
                        'no_eksekusi'       => $no_eksekusi,
                    ]);
                } else {
//                    var_dump($model->getErrors());exit;
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
                    return $this->redirect(['update','no_eksekusi'=>$no_eksekusi]);
                }
            }catch (Exception $e) {
                echo $e;exit();
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
                return $this->redirect('update',[
                    'model'         => $model,
                    'sysMenu'       => $sysMenu,
                    'no_register'   => $no_register,
                    'modelJpu'      => $modelJpu,
                    'modeljaksi'    => $modeljaksi,
                    'searchJPU'     => $searchJPU,
                    'dataJPU'       => $dataJPU,
                    'dekot'         => $dekot,
                    'no_reg_tahanan'         => $no_reg_tahanan,
                    'no_eksekusi'       => $no_eksekusi,
                ]);
            }
        } else {
            return $this->render('update', [
                'model'         => $model,
                'sysMenu'       => $sysMenu,
                'no_register'   => $no_register,
                'modelJpu'      => $modelJpu,
                'modeljaksi'    => $modeljaksi,
                'searchJPU'     => $searchJPU,
                'dataJPU'       => $dataJPU,
                'dekot'         => $dekot,
                'no_reg_tahanan'         => $no_reg_tahanan,
                'no_eksekusi'       => $no_eksekusi,
            ]);
        }
    }

    /**
     * Deletes an existing PdmBa20 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
        $connection             = \Yii::$app->db;
        try{
            $id                     = $_POST['hapusIndex'];
//            $ids                    = explode("#",$id);
//            $one                    = $ids[0];
//            $two                    = $ids[1];
//            print_r($one);exit();
            $total                  = count($id);
            $session                = new Session();
            $id_perkara             = $session->get('id_perkara');
            $no_register_perkara    = $session->get('no_register_perkara');

            if($total == 1){
                $ids    = explode("#",$id[0]);
//                print_r($ids);exit();
//                echo $ids[1];exit();
                PdmBa20::deleteAll(['no_register_perkara' => $ids[0],'tgl_ba20'=>$ids[1]]);
            }else{
                for($i=0;$i<count($id);$i++){
                    $ids    = explode("#",$id[$i]);
                    PdmBa20::deleteAll(['no_register_perkara' => $ids[0],'tgl_ba20'=>$ids[1]]);
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
        }catch (Exception $e){
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
     * Finds the PdmBa20 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmBa20 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmBa20::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
    public function actionCetak($id){
        $session        = new Session();
        $id_perkara     = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $inst_satkerkd  = $session->get('inst_satkerkd');
        $no_akta        = $session->get('no_akta');
        $no_reg_tahanan = $session->get('no_reg_tahanan');
        $no_eksekusi    = $session->get('no_eksekusi');
        
        $ba20           = PdmBa20Eks::findOne(['no_eksekusi'=>$no_eksekusi]);
        $thp_2          = PdmTahapDua::findOne(['no_register_perkara' => $ba20->no_register_perkara]);
        $brks_thp_1     = PdmBerkasTahap1::findOne(['id_berkas' => $thp_2->id_berkas]);
        $spdp           = PdmSpdp::findOne(['id_perkara' => $brks_thp_1->id_perkara]);
        $tsk            = VwTerdakwaT2::findOne(['no_reg_tahanan'=>$no_reg_tahanan]);
        $pangkat        = PdmJaksaP16a::findOne(['no_register_perkara' => $ba20->no_register_perkara,'no_surat_p16a'=>$ba20->no_surat_p16a,'no_urut'=>$ba20->no_urut_jaksa_p16a]);
        $p48            = PdmP48::findOne(['no_surat'=>$no_eksekusi]);
        $pn             = PdmPutusanPn::findOne(['no_surat'=>$p48->no_putusan]);
        $pasal          = PdmUuPasalTahap2::findAll(['no_register_perkara'=>$ba20->no_register_perkara]);
        $dekot          = json_decode($ba20->saksi);
        $barbuk         = PdmBarbuk::findAll(['no_register_perkara'=>$no_register, 'id_ms_barbuk_eksekusi' => 1]);
        return $this->render('cetak', ['barbuk'=>$barbuk,'pn'=>$pn,'p48'=>$p48,'spdp'=>$spdp,'ba20'=>$ba20,'dekot'=>$dekot,'tsk'=>$tsk,'pasal'=>$pasal,'pangkat'=>$pangkat]);
    }
    
}