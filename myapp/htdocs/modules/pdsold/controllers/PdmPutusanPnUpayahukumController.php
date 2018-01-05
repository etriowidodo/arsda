<?php

namespace app\modules\pdsold\controllers;

use Yii;
use app\models\MsJkl;
use app\models\MsAgama;
use app\models\MsWarganegara;
use app\models\MsPendidikan;
use app\modules\pdsold\models\PdmP39;
use app\modules\pdsold\models\PdmPutusanPn;
use app\modules\pdsold\models\PdmP41;
use app\modules\pdsold\models\PdmPutusanPnTerdakwa;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\VwTerdakwaT2;
use app\modules\pdsold\models\PdmSysMenu;
use app\modules\pdsold\models\MsTersangka;
use app\modules\pdsold\models\PdmPenandatangan;
use app\modules\pdsold\models\PdmTembusan;
use app\modules\pdsold\models\PdmMsRentut;
use app\modules\pdsold\models\PdmPutusanPnSearch;
use app\modules\pdsold\models\PdmPasalDakwaan;
use app\modules\pdsold\models\PdmAmarPutusP29;
use app\modules\pdsold\models\PdmAmarPutusP41;
use app\modules\pdsold\models\PdmMsStatusP41;
use app\modules\pdsold\models\PdmUuPasalTahap2;
use app\modules\pdsold\models\PdmTembusanP41;
use app\modules\pdsold\models\PdmBa5Barbuk;
use app\modules\pdsold\models\PdmGridTahap2Search;
use app\modules\pdsold\models\PdmBa5;
use app\modules\pdsold\models\PdmTahapDua;
use app\modules\pdsold\models\PdmBerkasTahap1;
use app\models\MsSifatSurat;
use app\modules\pdsold\models\PdmRp11Search;
use app\modules\pdsold\models\PdmRp11;
use yii\db\Query;
use yii\db\Exception;
use yii\web\Session;
use yii\web\Response;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\components\ConstSysMenuComponent;
use app\components\GlobalConstMenuComponent;
use yii\helpers\ArrayHelper;
use yii\filters\VerbFilter;

/**
 * PdmP41Controller implements the CRUD actions for PdmP41 model.
 */
class PdmPutusanPnUpayahukumController extends Controller
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
     * Lists all PdmP41 models.
     * @return mixed
     */
    public function actionIndex()
    {
        $session        = new Session();
        $no_akta     = $session->get('no_akta');

        $no_register    = $session->get('no_register_perkara');
        /*
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
*/
        $searchModel    = new PdmPutusanPnSearch();
        $dataProvider   = $searchModel->searchUpayahukum($no_register, Yii::$app->request->queryParams);

        $searchModelAkta = new PdmRp11Search();
        $dataProviderAkta = $searchModelAkta->searchPutusan($no_register,Yii::$app->request->queryParams);
        //echo '<pre>';print_r($dataProvider->getTotalCount());exit;

        return $this->render('index', [
            'searchModel'   => $searchModel,
            'dataProvider'  => $dataProvider,
            'searchModelAkta' => $searchModelAkta,
            'dataProviderAkta' => $dataProviderAkta,
        ]);
        /*$session = new Session();
        $no_register_perkara = $session->get("no_register_perkara");
        
        $searchModel = new PdmP41Search();
        $dataProvider = $searchModel->search($no_register_perkara, Yii::$app->request->queryParams);

        return $this->render('index', [
            'sysMenu' => $sysMenu,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);*/
        //return $this->redirect(['update']);
    }

    /**
     * Displays a single PdmP41 model.
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
     * Creates a new PdmP41 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($no_akta){
        //echo '<pre>';print_r($no_akta);exit;
        $session = new session();
        $session->destroySession('no_akta');
        $session->set('no_akta',$no_akta);
        $no_register_perkara = $session->get('no_register_perkara');

        $model                  = PdmP41::findOne(['no_register_perkara'=>$no_register_perkara]);
        $model_pn               = new PdmPutusanPn();
        $modelTerdakwa          = new PdmPutusanPnTerdakwa();
        $tersangka              = VwTerdakwaT2::findAll(['no_register_perkara'=>$no_register_perkara]);

        if($no_akta!==''){
            $model = PdmPutusanPn::findOne(['no_register_perkara'=>$no_register_perkara]);
            $rp11 = PdmRp11::findOne(['no_register_perkara'=>$no_register_perkara, 'no_akta'=>$no_akta]);
            $tersangka = VwTerdakwaT2::findAll(['no_register_perkara'=>$no_register_perkara, 'no_reg_tahanan'=>$rp11->no_reg_tahanan]);
        }

        $modelAmarPutusan       = new PdmAmarPutusP41();
        $statp41                = PdmMsStatusP41::find()->where(['id'=> 3])->all();
        //$modelSpdp              = $this->findModelSpdp($id_perkara);
        $pasal                  = PdmUuPasalTahap2::findAll(['no_register_perkara'=>$no_register_perkara]);

        $searchModelBerkas      = new PdmGridTahap2Search();
        $dataProviderBerkas     = $searchModelBerkas->search(Yii::$app->request->queryParams);
        $modelBarbuk            = PdmBa5Barbuk::findAll(['no_register_perkara'=>$no_register_perkara]);
        $modelBarbukOld         = PdmBa5::findOne(['no_register_perkara'=>$no_register_perkara]);

        
        //echo '<pre>';print_r($statp41);exit;
                if ($model->load(Yii::$app->request->post())) {
                    //echo '<pre>';print_r($_POST);exit;
        //            $transaction = Yii::$app->db->beginTransaction();
                    try{
                            $model_pn->no_surat             = $_POST['PdmPutusanPn']['no_surat'];
                            $model_pn->sifat                = $_POST['PdmPutusanPn']['sifat'];
                            $model_pn->no_register_perkara  = $no_register_perkara;
                            $model_pn->lampiran             = $_POST['PdmPutusanPn']['lampiran'];
                            $model_pn->kepada               = $_POST['PdmPutusanPn']['kepada'];
                            $model_pn->di_kepada            = $_POST['PdmPutusanPn']['di_kepada'];
                            $model_pn->dikeluarkan          = $_POST['PdmPutusanPn']['dikeluarkan'];
                            $model_pn->tgl_dikeluarkan      = $_POST['PdmPutusanPn']['tgl_dikeluarkan'];
                            $model_pn->no_persidangan       = $_POST['PdmPutusanPn']['no_persidangan'];
                            $model_pn->tgl_persidangan      = $_POST['PdmPutusanPn']['tgl_persidangan'];
                            $model_pn->pasal_bukti          = $_POST['PdmPutusanPn']['pasal_bukti'];
                            $model_pn->kasus_posisi         = $_POST['PdmPutusanPn']['kasus_posisi'];
                            $model_pn->kerugian_negara      = $_POST['PdmPutusanPn']['kerugian_negara'];
                            $model_pn->mati                 = $_POST['PdmPutusanPn']['mati'];
                            $model_pn->luka                 = $_POST['PdmPutusanPn']['luka'];
                            $model_pn->akibat_lain          = $_POST['PdmPutusanPn']['akibat_lain'];
                            $model_pn->usul                 = $_POST['PdmPutusanPn']['usul'];
                            $model_pn->pengadilan           = $_POST['PdmPutusanPn']['pengadilan'];
                            $model_pn->status_yakum         = $_POST['status_yakum'];
                            $model_pn->created_time         = date('Y-m-d H:i:s');
                            $model_pn->created_by           = \Yii::$app->user->identity->peg_nip;
                            $model_pn->created_ip           = \Yii::$app->getRequest()->getUserIP();
                            
                            $model_pn->updated_by           =\Yii::$app->user->identity->peg_nip;
                            $model_pn->updated_time         = date('Y-m-d H:i:s');
                            $model_pn->updated_ip           = \Yii::$app->getRequest()->getUserIP();
                            
                            $model_pn->id_kejati            = $session->get('kode_kejati');
                            $model_pn->id_kejari            = $session->get('kode_kejari');
                            $model_pn->id_cabjari           = $session->get('kode_cabjari');
                            $model_pn->no_akta              = $no_akta;
//                            echo '<pre>';print_r($model_pn);exit();
                            if($model_pn->save()){
                                $terdakwa  = $_POST['PdmP41Terdakwa'][3];
                                $pasal     = $_POST['UuTahap2'][3];
        //                        echo '<pre>';print_r($pasal);exit();
                                
                                
                                foreach ($terdakwa as $key => $value2) {
                                   //foreach($terdakwa[$key] AS $key2 => $value2)
                                   //{
                                        $keystatusrentut  += 1;

                                        $modelTerdakwa = new PdmPutusanPnTerdakwa();
                                        if(isset($_POST['status_yakum'])){
                                            $modelTerdakwa->status_yakum = $_POST['status_yakum'];
                                        }
                                        $modelTerdakwa->no_register_perkara = $no_register_perkara;                    
                                        $modelTerdakwa->no_surat = $_POST['PdmPutusanPn']['no_surat'];
                                        $modelTerdakwa->no_reg_tahanan = trim($key) ;
                                        $modelTerdakwa->status_rentut  = 3;

                                        $data['undang'] = $pasal[$key]['pasal'];
                                        $modelTerdakwa->undang_undang =  json_encode($data);

                                     foreach($value2 AS $key3 => $value3)
                                     {
                                        foreach ($value3 as $key4 => $value4) {
                                            $modelTerdakwa->$key3 = $value4;
                                            if(!$modelTerdakwa->save()){
                                                    var_dump($modelTerdakwa->getErrors());exit;
                                                   }
                                        }
                                     }

                                   //}
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
                        }else{
        //                    $transaction->rollBack();
                            echo '<pre>';print_r($model_pn->getErrors());exit;
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
                            return $this->redirect(['create']);
                        }
                    }catch (Exception $e){
                        echo '<pre>';print_r($e);exit;
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
                        return $this->redirect(['create']);
                    }
                } else {
                    return $this->render('create', [
                        'model' => $model,
                        'model_pn' => $model_pn,
                        'statp41' => $statp41,
                        'modelSpdp' => $modelSpdp,
                        'tersangka' => $tersangka,
                        'modelTerdakwa' => $modelTerdakwa,
                        'modelAmarPutusan' => $modelAmarPutusan,
                        'no_register_perkara' => $no_register_perkara,
        //                'sysMenu' => $sysMenu,
                        'pasal' =>$pasal,
                        'modelBarbuk' => $modelBarbuk,
                        'searchModelBerkas' => $searchModelBerkas,
                        'dataProviderBerkas' => $dataProviderBerkas,
                        'rp11' => $rp11,
                        'no_akta' => $no_akta,
                    ]);
                }

    }
###################################### OLD CREATE #############################
    /*public function actionCreate()
    {
        $session                = new session();
        $no_register_perkara    = $session->get('no_register_perkara');

        $model                  = PdmP41::findOne(['no_register_perkara'=>$no_register_perkara]);
        $model_pn               = new PdmPutusanPn();
        $modelTerdakwa          = new PdmPutusanPnTerdakwa();
        $tersangka              = VwTerdakwaT2::findAll(['no_register_perkara'=>$no_register_perkara]);
        $modelAmarPutusan       = new PdmAmarPutusP41();
        $statp41                = PdmMsStatusP41::find()->where(['id'=> 3])->all();
        $modelSpdp              = $this->findModelSpdp($id_perkara);
        $pasal                  = PdmUuPasalTahap2::findAll(['no_register_perkara'=>$no_register_perkara]);

        $searchModelBerkas      = new PdmGridTahap2Search();
        $dataProviderBerkas     = $searchModelBerkas->search(Yii::$app->request->queryParams);
        $modelBarbuk            = PdmBa5Barbuk::findAll(['no_register_perkara'=>$no_register_perkara]);
        $modelBarbukOld         = PdmBa5::findOne(['no_register_perkara'=>$no_register_perkara]);

        //echo '<pre>';print_r($tersangka);exit;

        if ($model->load(Yii::$app->request->post())) {
                // /echo '<pre>';print_r($_POST);exit;
//            $transaction = Yii::$app->db->beginTransaction();
            try{
                    $model_pn->no_surat             = $_POST['PdmP41']['no_surat_p41'];
                    $model_pn->sifat                = $_POST['PdmP41']['sifat'];
                    $model_pn->no_register_perkara  = $no_register_perkara;
                    $model_pn->lampiran             = $_POST['PdmP41']['lampiran'];
                    $model_pn->kepada               = $_POST['PdmP41']['kepada'];
                    $model_pn->di_kepada            = $_POST['PdmP41']['di_kepada'];
                    $model_pn->dikeluarkan          = $_POST['PdmP41']['dikeluarkan'];
                    $model_pn->tgl_dikeluarkan      = $_POST['PdmP41']['tgl_dikeluarkan'];
                    $model_pn->no_persidangan       = $_POST['PdmP41']['no_persidangan'];
                    $model_pn->tgl_persidangan      = $_POST['PdmP41']['tgl_persidangan'];
                    $model_pn->pasal_bukti          = $_POST['PdmP41']['pasal_bukti'];
                    $model_pn->kasus_posisi         = $_POST['PdmP41']['kasus_posisi'];
                    $model_pn->kerugian_negara      = $_POST['PdmP41']['kerugian_negara'];
                    $model_pn->mati                 = $_POST['PdmP41']['mati'];
                    $model_pn->luka                 = $_POST['PdmP41']['luka'];
                    $model_pn->akibat_lain          = $_POST['PdmP41']['akibat_lain'];
                    $model_pn->usul                 = $_POST['PdmP41']['usul'];
                    $model_pn->pengadilan           = $_POST['PdmPutusanPn']['pengadilan'];
                    $model_pn->created_time         = date('Y-m-d H:i:s');
                    $model_pn->created_by           = \Yii::$app->user->identity->peg_nip;
                    $model_pn->created_ip           = \Yii::$app->getRequest()->getUserIP();
                    
                    $model_pn->updated_by           =\Yii::$app->user->identity->peg_nip;
                    $model_pn->updated_time         = date('Y-m-d H:i:s');
                    $model_pn->updated_ip           = \Yii::$app->getRequest()->getUserIP();
                    
                    $model_pn->id_kejati            = $session->get('kode_kejati');
                    $model_pn->id_kejari            = $session->get('kode_kejari');
                    $model_pn->id_cabjari           = $session->get('kode_cabjari');
//                    echo '<pre>';print_r($model_pn);exit();
                    if($model_pn->save()){
                        $terdakwa  = $_POST['PdmP41Terdakwa'][3];
                        $pasal     = $_POST['UuTahap2'][3];
//                        echo '<pre>';print_r($pasal);exit();
                        
                        
                        foreach ($terdakwa as $key => $value2) {
                           //foreach($terdakwa[$key] AS $key2 => $value2)
                           //{
                                $keystatusrentut  += 1;
                                $modelTerdakwa = new PdmPutusanPnTerdakwa();
                                $modelTerdakwa->no_register_perkara = $no_register_perkara;                    
                                $modelTerdakwa->no_surat = $_POST['PdmP41']['no_surat_p41'];
                                $modelTerdakwa->no_reg_tahanan = trim($key) ;
                                $modelTerdakwa->status_rentut  = 3;

                                $data['undang'] = $pasal[$key]['pasal'];
                                $modelTerdakwa->undang_undang =  json_encode($data);

                             foreach($value2 AS $key3 => $value3)
                             {
                                foreach ($value3 as $key4 => $value4) {
                                    $modelTerdakwa->$key3 = $value4;
                                    if(!$modelTerdakwa->save()){
                                            var_dump($modelTerdakwa->getErrors());exit;
                                           }
                                }
                             }

                           //}
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
                }else{
//                    $transaction->rollBack();
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
                    return $this->redirect(['create']);
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
                return $this->redirect(['create']);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'model_pn' => $model_pn,
                'statp41' => $statp41,
                'modelSpdp' => $modelSpdp,
                'tersangka' => $tersangka,
                'modelTerdakwa' => $modelTerdakwa,
                'modelAmarPutusan' => $modelAmarPutusan,
                'no_register_perkara' => $no_register_perkara,
//                'sysMenu' => $sysMenu,
                'pasal' =>$pasal,
                'modelBarbuk' => $modelBarbuk,
                'searchModelBerkas' => $searchModelBerkas,
                'dataProviderBerkas' => $dataProviderBerkas,

            ]);
        }
    }
*/
    /**
     * Updates an existing PdmP41 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $sysMenu                = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P41]);
        $session                = new session();
        $id_perkara             = $session->get('id_perkara');
        $no_register_perkara    = $session->get('no_register_perkara');
        $id_p41                 = PdmP41::findOne(['no_register_perkara'=>$no_register_perkara])->no_surat_p41;
        $model = PdmPutusanPn::findOne(['no_register_perkara'=>$no_register_perkara]);
        if($model == NULL){
            $model = new PdmPutusanPn();
        }
        //echo '<pre>';print_r($model);exit;
        $model_pn = $model;
        $searchModelBerkas      = new PdmGridTahap2Search();
        $dataProviderBerkas     = $searchModelBerkas->search(Yii::$app->request->queryParams);
        $tersangka              = VwTerdakwaT2::findAll(['no_register_perkara'=>$no_register_perkara]);

        /*if($model->status_yakum <>''){
            $rp11 = PdmRp11::findOne(['no_register_perkara'=>$no_register_perkara, 'no_akta'=>$model->no_akta]);
            $tersangka = VwTerdakwaT2::findAll(['no_register_perkara'=>$no_register_perkara, 'no_reg_tahanan'=>$rp11->no_reg_tahanan]);
        }*/
        //echo '<pre>';print_r($tersangka);exit;
        //$modelTerdakwa          = PdmPutusanPnTerdakwa::findAll(['no_register_perkara'=>$no_register_perkara, 'no_surat'=>$no_surat]);
        //echo '<pre>';print_r($tersangka);exit;
        $modelAmarPutusan       = new PdmAmarPutusP41();
        $statp41                = PdmMsStatusP41::find()->where(['id'=> 3])->all();
        $modelSpdp              = $this->findModelSpdp($id_perkara);
        $pasal                  = PdmUuPasalTahap2::findAll(['no_register_perkara'=>$no_register_perkara]);
        $modelBarbuk            = PdmBa5Barbuk::findAll(['no_register_perkara'=>$no_register_perkara]);
        $modelBarbukOld         = PdmBa5::findOne(['no_register_perkara'=>$no_register_perkara]);
        //echo '<pre>';print_r($modelBarbukOld->tgl_ba5);exit;

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            //echo '<pre>';print_r($_POST);exit;
            try{    
                    if($model->isNewRecord){
                        $nos = $_POST['PdmPutusanPn']['no_surat_p41'];   
                    }else{
                        $nos = $_POST['PdmPutusanPn']['no_surat'];   
                    }
                    $model->no_surat             = $nos;
                    $model->tgl_baca             = $_POST['PdmPutusanPn']['tgl_baca'];
                    $model->sifat                = $_POST['PdmPutusanPn']['sifat'];
                    $model->no_register_perkara  = $no_register_perkara;
                    $model->file_upload          = $_POST['PdmPutusanPn']['file_upload'];
                    /*$model->lampiran             = $_POST['PdmPutusanPn']['lampiran'];
                    $model->kepada               = $_POST['PdmPutusanPn']['kepada'];
                    $model->di_kepada            = $_POST['PdmPutusanPn']['di_kepada'];
                    $model->dikeluarkan          = $_POST['PdmPutusanPn']['dikeluarkan'];
                    $model->tgl_dikeluarkan      = $_POST['PdmPutusanPn']['tgl_dikeluarkan'];*/
                    $model->no_persidangan       = $_POST['PdmP41']['no_persidangan'];
                    $model->tgl_persidangan      = $_POST['PdmP41']['tgl_persidangan'];
                    $model->pasal_bukti          = $_POST['PdmP41']['pasal_bukti'];
                    $model->kasus_posisi         = $_POST['PdmP41']['kasus_posisi'];
                    $model->kerugian_negara      = $_POST['PdmP41']['kerugian_negara'];
                    $model->mati                 = $_POST['PdmP41']['mati'];
                    $model->luka                 = $_POST['PdmP41']['luka'];
                    $model->akibat_lain          = $_POST['PdmP41']['akibat_lain'];
                    $model->usul                 = $_POST['PdmP41']['usul'];
                    $model->pengadilan           = $_POST['PdmPutusanPn']['pengadilan'];
                    $model->created_time         = date('Y-m-d H:i:s');
                    $model->created_by           = \Yii::$app->user->identity->peg_nip;
                    $model->created_ip           = \Yii::$app->getRequest()->getUserIP();

                    
                    $model->updated_by           =\Yii::$app->user->identity->peg_nip;
                    $model->updated_time         = date('Y-m-d H:i:s');
                    $model->updated_ip           = \Yii::$app->getRequest()->getUserIP();
                    
                    $model->id_kejati            = $session->get('kode_kejati');
                    $model->id_kejari            = $session->get('kode_kejari');
                    $model->id_cabjari           = $session->get('kode_cabjari');
                    $model->no_akta              = $id_p41;
//                    echo '<pre>';print_r($model);exit();
                    if($model->save()){
                        $no_surat = $_POST['PdmPutusanPn']['no_surat'];

//                        
                        $terdakwa  = $_POST['PdmP41Terdakwa'][3];
                        $pasal     = $_POST['UuTahap2'][3];
//                        echo '<pre>';print_r($pasal);exit();
                        
                        PdmPutusanPnTerdakwa::deleteAll(['no_register_perkara' => $no_register_perkara,'no_surat'=>$no_surat]);
                        foreach ($terdakwa as $key => $value2) {
                            //echo '<pre>';print_r($key);exit;
                           //foreach($terdakwa[$key] AS $key2 => $value2)
                           //{
                                //$keystatusrentut  += 1;
                                $modelTerdakwa = new PdmPutusanPnTerdakwa();
                                $modelTerdakwa->no_register_perkara = $no_register_perkara;                    
                                $modelTerdakwa->no_surat = $nos;
                                $modelTerdakwa->no_reg_tahanan = trim($key) ;
                                $modelTerdakwa->status_rentut  = 3;

                                $data['undang'] = $pasal[$key]['pasal'];
                                $modelTerdakwa->undang_undang =  json_encode($data);

                             foreach($value2 AS $key3 => $value3)
                             {
                                foreach ($value3 as $key4 => $value4) {
                                    $modelTerdakwa->$key3 = $value4;
                                    if(!$modelTerdakwa->save()){
                                            var_dump($modelTerdakwa->getErrors());exit;
                                           }
                                }
                             }

                          
                        }


                        if(!empty($_POST['pdmBarbukNo'])){
                            $temp_no_pindah = '';
                            for ($i=0; $i < count($_POST['pdmBarbukNo']); $i++) { 
                                $id_ms_barbuk = $_POST['PdmMsBarbukEksekusi'][$i];
                                $no_pindah    = $_POST['pdmBarbukPindah'][$i];
                                $no_urut      = $_POST['pdmBarbukNo'][$i];

                                if($id_ms_barbuk==4){
                                        $modelBarbukNew = PdmBa5::findOne(['no_register_perkara'=>$no_pindah]);


                                        //CARI NO URUT_TERAKHIR dari Pdm yang baru + 1
                                        $sqlMax = "SELECT  max(no_urut_bb) from pidum.pdm_barbuk where no_register_perkara='$no_pindah'";
                                        $no_urut_new = empty(Yii::$app->db->createCommand($sqlMax)->queryScalar()) ? 1 : Yii::$app->db->createCommand($sqlMax)->queryScalar() + 1 ;

                                        //CEK PERNAH BUAT BA 5 APA BLUM
                                        if($modelBarbukNew == NULL){
                                            $no_urut = 1;
                                            //echo 'cuakakak';exit;
                                            $modelBarbukNew = new PdmBa5();
                                            $modelBarbukNew->no_register_perkara = $no_pindah;
                                            $modelBarbukNew->tgl_ba5 = $modelBarbukOld->tgl_ba5;
                                            $modelBarbukNew->lokasi  = $modelBarbukOld->lokasi;
                                            $modelBarbukNew->asal_satker  = $modelBarbukOld->asal_satker;
                                            $modelBarbukNew->no_reg_bukti = $modelBarbukOld->no_reg_bukti;

                                            $modelBarbukNew->created_time=date('Y-m-d H:i:s');
                                            $modelBarbukNew->created_by=\Yii::$app->user->identity->peg_nip;
                                            $modelBarbukNew->created_ip = \Yii::$app->getRequest()->getUserIP();

                                            $modelBarbukNew->updated_by=\Yii::$app->user->identity->peg_nip;
                                            $modelBarbukNew->updated_time=date('Y-m-d H:i:s');
                                            $modelBarbukNew->updated_ip = \Yii::$app->getRequest()->getUserIP();

                                            if(!$modelBarbukNew->save()){
                                                    var_dump($modelBarbukNew->getErrors());echo "header barbuk";exit;
                                                   }
                                        }
                                    

                                        
                                     $modelBarbukNewDetail = PdmBa5Barbuk::findOne(['no_register_perkara'=>$no_pindah,
                                                                                    'nama'=>$_POST['pdmBarbukNama'][$i],
                                                                                    'jumlah'=>$_POST['pdmBarbukJumlah'][$i],
                                                                                    'id_satuan'=>$_POST['pdmBarbukSatuan'][$i],
                                                                                    'sita_dari'=>$_POST['pdmBarbukSitaDari'][$i],
                                                                                    'tindakan'=>$_POST['pdmBarbukTindakan'][$i] 
                                                                                    ]);    
                                     //echo '<pre>';print_r($modelBarbukNewDetail);exit;
                                    if($modelBarbukNewDetail== NULL){
                                        $modelBarbukNewDetail = new PdmBa5Barbuk();
                                        
                                        $modelBarbukNewDetail->no_register_perkara = $no_pindah;
                                        $modelBarbukNewDetail->tgl_ba5   = $modelBarbukNew->tgl_ba5;
                                        $modelBarbukNewDetail->no_urut_bb   = $no_urut_new;
                                        $modelBarbukNewDetail->nama  = $_POST['pdmBarbukNama'][$i];
                                        $modelBarbukNewDetail->jumlah = $_POST['pdmBarbukJumlah'][$i];
                                        $modelBarbukNewDetail->id_satuan = $_POST['pdmBarbukSatuan'][$i];
                                        $modelBarbukNewDetail->sita_dari = $_POST['pdmBarbukSitaDari'][$i];
                                        $modelBarbukNewDetail->tindakan  = $_POST['pdmBarbukTindakan'][$i];
                                        $modelBarbukNewDetail->pindah_dari  = $no_register_perkara;
                                        $modelBarbukNewDetail->id_stat_kondisi   = $_POST['pdmBarbukKondisi'][$i];
                                        $modelBarbukNewDetail->created_by    = \Yii::$app->user->identity->peg_nip;
                                        $modelBarbukNewDetail->updated_by    = \Yii::$app->user->identity->peg_nip;
                                        $modelBarbukNewDetail->created_time  = date('Y-m-d H:i:s');
                                        $modelBarbukNewDetail->updated_time  = date('Y-m-d H:i:s');
                                        $modelBarbukNewDetail->id_kejati = $session->get('kode_kejati');
                                        $modelBarbukNewDetail->id_kejari = $session->get('kode_kejari');
                                        $modelBarbukNewDetail->id_cabjari = $session->get('kode_cabjari');
                                        //echo '<pre>';print_r($modelBarbukNewDetail);exit;
                                        if(!$modelBarbukNewDetail->save()){
                                                var_dump($modelBarbukNewDetail->getErrors());echo "detail barbuk";exit;
                                            }
                                    }

                                    $sqlOld = "UPDATE pidum.pdm_barbuk set id_ms_barbuk_eksekusi=$id_ms_barbuk, pindah='$no_pindah' where no_register_perkara='$no_register_perkara' and no_urut_bb=$no_urut ";
                                    Yii::$app->db->createCommand($sqlOld)->execute();

                                }else{//ELSE ID==4

                                    if(!empty($no_pindah)){//ID SEBELUMNYA 4, LALU DIRUBAH KE ID LAIN, HAPUS BARBUK YG UDH PINDAH
                                       PdmBa5Barbuk::deleteAll(['no_register_perkara'=>$no_pindah, 
                                                                'pindah_dari'=>$no_register_perkara,
                                                                'nama'=>$_POST['pdmBarbukNama'][$i],
                                                                'jumlah'=>$_POST['pdmBarbukJumlah'][$i],
                                                                'id_satuan'=>$_POST['pdmBarbukSatuan'][$i],
                                                                'sita_dari'=>$_POST['pdmBarbukSitaDari'][$i],
                                                                'tindakan'=>$_POST['pdmBarbukTindakan'][$i] 
                                                                ]);
                                       $sqlOld = "UPDATE pidum.pdm_barbuk set pindah = NULL where no_register_perkara='$no_register_perkara' and no_urut_bb=$no_urut ";
                                       Yii::$app->db->createCommand($sqlOld)->execute(); 
                                    }
                                }//END IF ID_MS_BARBUK==4
                                $sqlNew = "UPDATE pidum.pdm_barbuk set id_ms_barbuk_eksekusi=$id_ms_barbuk where no_register_perkara='$no_register_perkara' and no_urut_bb=$no_urut ";
                                Yii::$app->db->createCommand($sqlNew)->execute();
                                
                            }// END PERULANGAN BARBUK
                        }//END IF EMPTY BARBUK

                        
                    //simpan
                    $transaction->commit();
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
                    
                    return $this->redirect(['update']);
                }else{
                    var_dump($model->getErrors());exit;                  
                    $transaction->rollBack();
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'danger',
                        'duration' => 3000,
                        'icon' => 'glyphicon glyphicon-ok-sign', //String
                        'message' => 'Data Gagal di Ubah',
                        'title' => 'Ubah Data',
                        'positonY' => 'top',
                        'positonX' => 'center',
                        'showProgressbar' => true,
                    ]);
                    return $this->redirect(['update']);
                }
            }catch (Exception $e){
                echo '<pre>';print_r($e);exit;
//                echo $e;exit();
//                $transaction->rollBack();
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
                return $this->redirect('update',[
                    'model' => $model,
                    'statp41' => $statp41,
                    'model_pn' =>$model_pn,
                    'modelSpdp' => $modelSpdp,
                    'tersangka' => $tersangka,
                    'modelTerdakwa' => $modelTerdakwa,
                    'modelAmarPutusan' => $modelAmarPutusan,
                    'sysMenu' => $sysMenu,
                    'pasal' =>$pasal,
                    'modelBarbuk' => $modelBarbuk,
                    'no_register_perkara' => $no_register_perkara,
                    'searchModelBerkas' => $searchModelBerkas,
                    'dataProviderBerkas' => $dataProviderBerkas,
                    'rp11' => $rp11,
                    'no_akta' => $no_akta,
                ]);
                
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'model_pn' =>$model_pn,
                'statp41' => $statp41,
                'modelSpdp' => $modelSpdp,
                'tersangka' => $tersangka,
                'modelTerdakwa' => $modelTerdakwa,
                'modelAmarPutusan' => $modelAmarPutusan,
                'sysMenu' => $sysMenu,
                'pasal' =>$pasal,
                'modelBarbuk' => $modelBarbuk,
                'no_register_perkara' => $no_register_perkara,
                'searchModelBerkas' => $searchModelBerkas,
                'dataProviderBerkas' => $dataProviderBerkas,
                'rp11' => $rp11,
                'no_akta' => $no_akta,
            ]);
        }
    }

    /**
     * Deletes an existing PdmP41 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete(){
        $id             = $_POST['hapusIndex'];
        $total          = count($id);
        $session        = new Session();
        $id_perkara     = $session->get("id_perkara");
        $no_register    = $session->get('no_register_perkara');
        try {
            if(count($id) <= 1){
                PdmPutusanPn::deleteAll(['no_surat' => $id[0]]);
                
            }else{
                for ($i = 0; $i < count($id); $i++) {
                   PdmPutusanPn::deleteAll(['no_surat' => $id[$i]]);
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
        $connection     = \Yii::$app->db;
        $session        = new Session();
        $id_perkara     = $session->get("id_perkara");
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $inst_satkerkd  = $session->get('inst_satkerkd');
        $p41            = PdmP41::findOne(['no_surat_p41'=>$id]);
        $p41_terdakwa   = PdmP41Terdakwa::findAll(['no_surat_p41'=>$id, 'status_rentut => 3']);
        $thp_2          = PdmTahapDua::findOne(['no_register_perkara' => $p41->no_register_perkara]);
        $brks_thp_1     = PdmBerkasTahap1::findOne(['id_berkas' => $thp_2->id_berkas]);
        $spdp           = PdmSpdp::findOne(['id_perkara' => $brks_thp_1->id_perkara]);
        $sifat          = MsSifatSurat::findOne(['id'=>$p41->sifat]);
        $listTembusan   = PdmTembusanP41::findAll(['no_surat_p41' => $p41->no_surat_p41]);
        $qry_tsk        =   "select a.*, b.*
                            from pidum.pdm_p41_terdakwa as a
                            left join pidum.vw_terdakwat2 as b on a.no_reg_tahanan = b.no_reg_tahanan
                            where a.no_register_perkara = '".$no_register."' and a.no_surat_p41 = '".$id."' and a.status_rentut = '3'";
        $tersangka      = PdmP41::findBySql($qry_tsk)->asArray()->all();
        
        $qry_41_tsk     =   "select a.*, b.*
                            from pidum.pdm_p41_terdakwa as a
                            left join pidum.vw_terdakwat2 as b on a.no_reg_tahanan = b.no_reg_tahanan
                            where a.no_register_perkara = '".$no_register."' and a.no_surat_p41 = '".$id."' and a.status_rentut = '3'";
        $p41_tsk        = PdmP41::findBySql($qry_41_tsk)->asArray()->all();
        
        $qry_agenda     =   "select * from pidum.pdm_agenda_persidangan where no_register_perkara = '".$no_register."' order by tgl_acara_sidang desc limit 1";
        $agenda         = \app\modules\pidum\models\PdmAgendaPersidangan::findBySql($qry_agenda)->asArray()->one();
        $uu_psl         = PdmUuPasalTahap2::findAll(['no_register_perkara' => $p41->no_register_perkara]);
        $barbuk         = \app\modules\pidum\models\PdmBarbuk::findAll(['no_register_perkara'=>$no_register]);
        
        $pangkat        = PdmPenandatangan::findOne(['peg_nip_baru' => $p41->id_penandatangan]);
        
        for ($i = 0; $i < count($p41_tsk); $i++) {
            $und[$i] = $p41_tsk[$i]["undang_undang"];
//            $j_undang[$i]      = json_decode($und[$i]);
//            $undang     = $j_undang[$i];
        }
//        echo '<pre>';print_r($und);exit();
        
        
        return $this->render('cetak', ['spdp'=>$spdp, 'p41'=>$p41, 'sifat'=>$sifat, 'listTembusan'=>$listTembusan, 'tersangka'=>$tersangka, 'thp_2'=>$thp_2, 'p41_tsk'=>$p41_tsk, 'agenda'=>$agenda, 'uu_psl'=>$uu_psl, 'p41_terdakwa'=>$p41_terdakwa, 'barbuk'=>$barbuk, 'pangkat'=>$pangkat]);
    }
    

    /**
     * Finds the PdmP41 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmP41 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($no_register_perkara,$id)
    {
        if (($model = PdmP41::findOne(['no_register_perkara'=>$no_register_perkara, 'no_surat_p41'=>$id])) !== null) {
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

    public function actionDetailTerdakwa()
    {
        $terdakwa = VwTerdakwa::find()
            ->where(['id_tersangka' => $_POST['id_tersangka']])
            ->one();

        $session = new Session();
        $id_perkara = $session->get('id_perkara');

        $model = PdmP41::findOne(['id_perkara' => $id_perkara]);

        $modelPasalDakwaan = PdmPasalDakwaan::find()
                        ->where('id_perkara = :id_perkara AND id_tersangka = :id_tersangka AND flag <> :flag', 
                            [':id_perkara' => $id_perkara, ':id_tersangka' => $_POST['id_tersangka'], ':flag' => '3'])
                        ->all();

        $tabelPasalDakwaan = $this->renderAjax('_view_undang_pasal', [
            'model' => $model,
            'modelPasalDakwaan' => $modelPasalDakwaan
        ]);
        $modelAmarPutusanDefault = PdmAmarPutusP29::findOne(['id_perkara' => $id_perkara, 'id_tersangka' => $_POST['id_tersangka']]);

        \Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'tmpt_lahir' => $terdakwa->tmpt_lahir,
            'tgl_lahir' => ($terdakwa->tgl_lahir != null) ? date('d-m-Y', strtotime($terdakwa->tgl_lahir)) : '',
            'jns_kelamin' => $terdakwa->is_jkl,
            'alamat' => $terdakwa->alamat,
            'agama' => $terdakwa->is_agama,
            'pekerjaan' => $terdakwa->pekerjaan,
            'pendidikan' => $terdakwa->is_pendidikan,
            'tabelPasalDakwaan' => $tabelPasalDakwaan,
            'rentut' => $modelAmarPutusanDefault->id_ms_rentut,
            'bulan_kurung' => $modelAmarPutusanDefault->bulan_kurung,
            'hari_kurung' => $modelAmarPutusanDefault->hari_kurung,
            'tahun_coba' => $modelAmarPutusanDefault->tahun_coba,
            'bulan_coba' => $modelAmarPutusanDefault->bulan_coba,
            'hari_coba' => $modelAmarPutusanDefault->hari_coba,
            'tahun_badan' => $modelAmarPutusanDefault->tahun_badan,
            'bulan_badan' => $modelAmarPutusanDefault->bulan_badan,
            'hari_badan' => $modelAmarPutusanDefault->hari_badan,
            'denda' => $modelAmarPutusanDefault->denda,
            'biaya_perkara' => $modelAmarPutusanDefault->biaya_perkara,
            'tahun_sidair' => $modelAmarPutusanDefault->tahun_sidair,
            'bulan_sidair' => $modelAmarPutusanDefault->bulan_sidair,
            'hari_sidair' => $modelAmarPutusanDefault->hari_sidair,
            'pidana_tambahan' => $modelAmarPutusanDefault->pidana_tambahan,
            'pidana_pengawasan' => $modelAmarPutusanDefault->id_ms_pidanapengawasan
        ];
    }

    public function getTerdakwa($form, $model, $modelSpdp, $readonly) {
        if($readonly){
            $terdakwa = $form->field($model, 'id_tersangka')->dropDownList(
                            ArrayHelper::map(
                                VwTerdakwa::find()
                                    ->where(['=', 'id_perkara', $model->id_perkara])
                                    ->all(), 
                                'id_tersangka',
                                'nama'
                            ),
                            ['prompt' => 'Pilih Terdakwa', 'class' => 'cmb_terdakwa', 'disabled' => true]
                    )->label(false);
        }else{
            $tersangkaP41 = '';
            $listTersangkaP41 = PdmP41::find()
                                ->select('id_tersangka')
                                ->where(['id_perkara' => $modelSpdp->id_perkara])
                                ->andWhere(['<>', 'flag', '3'])
                                ->all();
            for($i = 0; $i < count($listTersangkaP41); $i++){
                $tersangkaP41 .= $listTersangkaP41[$i]->id_tersangka . ', ';
            }
            $tersangkaP41 = preg_replace('/, $/', '', $tersangkaP41);
            $terdakwa = $form->field($model, 'id_tersangka')->dropDownList(
                        ArrayHelper::map(
                            VwTerdakwa::find()
                                ->where(['=', 'id_perkara', $modelSpdp->id_perkara])
                                ->andWhere(['not in', 'id_tersangka', [$tersangkaP41]])
                                ->all(), 
                            'id_tersangka',
                            'nama'
                        ),
                        ['prompt' => 'Pilih Terdakwa', 'class' => 'cmb_terdakwa']
                )->label(false);
        }

        $js = <<< JS
            $('.cmb_terdakwa').change(function(){

            $.ajax({
                type: "POST",
                url: '/pdsold/pdm-p41/detail-terdakwa',
                data: 'id_tersangka='+$('.cmb_terdakwa').val(),
                success:function(data){
                    console.log(data);
                    $('#data-terdakwa').html(
                        '<div class="form-group">'+
                            '<label class="control-label col-sm-2">Tempat Lahir</label>'+
                            '<div class="col-sm-4">'+data.tmpt_lahir+'</div>'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<label class="control-label col-sm-2">Tanggal Lahir</label>'+
                            '<div class="col-sm-4">'+data.tgl_lahir+'</div>'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<label class="control-label col-sm-2">Jenis Kelamin</label>'+
                            '<div class="col-sm-4">'+data.jns_kelamin+'</div>'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<label class="control-label col-sm-2">Tempat Tinggal</label>'+
                            '<div class="col-sm-4">'+data.alamat+'</div>'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<label class="control-label col-sm-2">Agama</label>'+
                            '<div class="col-sm-4">'+data.agama+'</div>'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<label class="control-label col-sm-2">Pekerjaan</label>'+
                            '<div class="col-sm-4">'+data.pekerjaan+'</div>'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<label class="control-label col-sm-2">Pendidikan</label>'+
                            '<div class="col-sm-4">'+data.pendidikan+'</div>'+
                        '</div>'
                    );
                    $('.no_reg_tahanan').val(data.reg_tahanan);
                    $('.ditahan_sejak').val(data.ditahan_sejak);
                    $('#undang_pasal').html(data.tabelPasalDakwaan);
                    $('#input_rentut').val(data.rentut);
                    $('#pdmamarputusp41-bulan_kurung').val(data.bulan_kurung);
                    $('#pdmamarputusp41-hari_kurung').val(data.hari_kurung);
                    $('#pdmamarputusp41-tahun_coba').val(data.tahun_coba);
                    $('#pdmamarputusp41-bulan_coba').val(data.bulan_coba);
                    $('#pdmamarputusp41-hari_coba').val(data.hari_coba);
                    $('#pdmamarputusp41-tahun_badan').val(data.tahun_badan);
                    $('#pdmamarputusp41-bulan_badan').val(data.bulan_badan);
                    $('#pdmamarputusp41-hari_badan').val(data.hari_badan);
                    $('#pdmamarputusp41-tahun_sidair').val(data.tahun_sidair);
                    $('#pdmamarputusp41-bulan_sidair').val(data.bulan_sidair);
                    $('#pdmamarputusp41-hari_sidair').val(data.hari_sidair);
                    $('input[name="PdmAmarPutusP41[denda]"]').val(data.denda);
                    $('input[name="PdmAmarPutusP41[biaya_perkara]"]').val(data.biaya_perkara);
                    $('#pdmamarputusp41-pidana_tambahan').val(data.pidana_tambahan);
                    $('#input_pidanapengawasan').val(data.pidana_pengawasan);
                    if (data.rentut == 4) { // pidana kurungan denda
                        $('.pidana_penjara').hide();
                        $('#pidana_tambahan').hide();
                        $('#pidana_kurungan_denda').show();
                        $('#denda').show();
                    }else if (data.rentut == 3){
                        $('.pidana_penjara').show();
                        $('#pidana_tambahan').show();
                        $('#pidana_kurungan_denda').hide();
                        $('#denda').show();
                    }else if (data.rentut == "") {
                        $('.pidana_penjara').hide();
                        $('#pidana_tambahan').hide();
                        $('#pidana_kurungan_denda').hide();
                        $('#denda').hide();
                    }
                    else {
                        $('.pidana_penjara').hide();
                        $('#pidana_tambahan').show();
                        $('#pidana_kurungan_denda').hide();
                        $('#denda').hide();
                    }

                }
            });
        });
JS;

        $this->view->registerJs($js);
        return $terdakwa;
    }
}
