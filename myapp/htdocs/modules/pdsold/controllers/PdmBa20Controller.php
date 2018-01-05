<?php

namespace app\modules\pdsold\controllers;

use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\PdmBa20;
use app\modules\pdsold\models\PdmBa20Search;
use Jaspersoft\Client\Client;
use Yii;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;
use app\modules\pdsold\models\PdmSysMenu;
use app\modules\pdsold\models\PdmTembusan;
use app\modules\pdsold\models\PdmBarbukTambahan;
use app\modules\pdsold\models\PdmB4;
use app\modules\pdsold\models\PdmBa20Jaksa;
use app\modules\pdsold\models\PdmTahapDua;
use app\modules\pdsold\models\PdmBerkasTahap1;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmBa5Barbuk;
use app\modules\pdsold\models\VwTerdakwaT2;
use app\modules\pdsold\models\PdmJaksaP16a;
use app\modules\pdsold\models\PdmJaksaP16aSearch;
use app\modules\pdsold\models\PdmUuPasalTahap2;

/**
 * PdmBa20Controller implements the CRUD actions for PdmBa20 model.
 */
class PdmBa20Controller extends Controller
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
        $session        = new Session();
        $id_perkara     = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
		
        $searchModel    = new PdmBa20Search();
        $dataProvider   = $searchModel->search($no_register,Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
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
        $modelBarbuk = PdmBa5Barbuk::find()->where(['no_register_perkara'=>$no_register])->andWhere(['<>','id_ms_barbuk_eksekusi', '4'])->orWhere(['is', 'id_ms_barbuk_eksekusi', NULL])->orderBy('no_urut_bb')->all();

        //echo '<pre>';print_r($modelBarbuk);exit;

        if ($model->load(Yii::$app->request->post())) {
            try {
                $data_ba20      = PdmBa20::findOne(['no_register_perkara'=>$no_register,'tgl_ba20'=>$model->tgl_ba20]);
                if($data_ba20->tgl_ba20 == '' && $data_ba20->no_register_perkara == ''){
                    //echo '<pre>';print_r($_POST);exit;
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
                    $model->barbuk = json_encode($_POST['barbuk']);
                    //                echo '<pre>'; print_r($model);exit();
                    if(!$model->save()){
                            var_dump($model->getErrors());exit;
                           }
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
                echo '<pre>';print_r($e);exit;
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
                'modelBarbuk'   => $modelBarbuk,
            ]);
        }
    }

    /**
     * Updates an existing PdmBa20 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id,$id2)
    {
        $sysMenu        = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA20 ]);
	   $session        = new Session();
        $id_perkara     = $session->get("id_perkara");
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $inst_satkerkd  = $session->get('inst_satkerkd');
        $model          = PdmBa20::findOne(['no_register_perkara'=>$id,'tgl_ba20'=>$id2]);
        $dekot          = json_decode($model->saksi);
        $modelJpu       = PdmJaksaP16a::findAll(['no_register_perkara' => $no_register]);
        $modeljaksi     = PdmJaksaP16a::findOne(['no_register_perkara' => $no_register,'no_surat_p16a'=>$model->no_surat_p16a,'no_urut'=>$model->no_urut_jaksa_p16a]);
        $searchJPU      = new PdmJaksaP16aSearch();
        $dataJPU        = $searchJPU->search2($no_register,Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;
		
        $modelBarbuk = PdmBa5Barbuk::find()->where(['no_register_perkara'=>$no_register])->andWhere(['<>','id_ms_barbuk_eksekusi', '4'])->orWhere(['is', 'id_ms_barbuk_eksekusi', NULL])->orderBy('no_urut_bb')->all();


        if ($model->load(Yii::$app->request->post())) {
            try {
                $enkot                      = json_encode($_POST['txt_nama_surat']);
                $model->no_register_perkara = $no_register;
                $model->saksi               = $enkot;
                $model->no_surat_p16a       = $_POST['PdmJaksaSaksi']['no_surat_p16a'];
                $model->no_urut_jaksa_p16a  = $_POST['PdmJaksaSaksi']['no_urut'];
                $model->barbuk = json_encode($_POST['barbuk']);
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
                return $this->redirect('update',[
                    'model'         => $model,
                    'sysMenu'       => $sysMenu,
                    'no_register'   => $no_register,
                    'modelJpu'      => $modelJpu,
                    'modeljaksi'    => $modeljaksi,
                    'searchJPU'     => $searchJPU,
                    'dataJPU'       => $dataJPU,
                    'dekot'         => $dekot,
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
                'modelBarbuk' => $modelBarbuk,
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
	
    public function actionCetak($id,$id2){
        
        $ba20           = PdmBa20::findOne(['no_register_perkara'=>$id,'tgl_ba20'=>$id2]);
        $thp_2          = PdmTahapDua::findOne(['no_register_perkara' => $ba20->no_register_perkara]);
        $brks_thp_1     = PdmBerkasTahap1::findOne(['id_berkas' => $thp_2->id_berkas]);
        $spdp           = PdmSpdp::findOne(['id_perkara' => $brks_thp_1->id_perkara]);
        //$tsk            = VwTerdakwaT2::findOne(['no_register_perkara'=>$ba20->no_register_perkara, 'no_urut_tersangka'=>$ba20->id_tersangka]);
        $pangkat        = PdmJaksaP16a::findOne(['no_register_perkara' => $ba20->no_register_perkara,'no_surat_p16a'=>$ba20->no_surat_p16a,'no_urut'=>$ba20->no_urut_jaksa_p16a]);


        $in         = json_decode($ba20->barbuk);
        $modelBarbuk = PdmBa5Barbuk::find()->where(['no_register_perkara'=>$ba20->no_register_perkara])
                   ->andWhere(['in','no_urut_bb', $in])->orderBy('no_urut_bb')->all();

        $dft_barbuk = '';
        $tnda = ', ';
        foreach ($modelBarbuk as $key) {
            $dft_barbuk .= Yii::$app->globalfunc->GetDetBarbuk($ba20->no_register_perkara,$key['no_urut_bb']) . $tnda;
        }
        //echo '<pre>';print_r($dft_barbuk);exit;

//        $modelpeg       = KpPegawai::findOne(['peg_nip_baru'=>$T11->peg_nip]);
//        $listTembusan   = PdmTembusanT11::findAll(['no_surat_t11' => $T11->no_surat_t11]);
        $pasal          = PdmUuPasalTahap2::findAll(['no_register_perkara'=>$ba20->no_register_perkara]);
        $dekot          = json_decode($ba20->saksi);
        
        return $this->render('cetak', ['spdp'=>$spdp,'ba20'=>$ba20,'dekot'=>$dekot,'pasal'=>$pasal,'pangkat'=>$pangkat, 'barbuk'=>$dft_barbuk]);
    }
    
}
