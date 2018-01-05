<?php

namespace app\modules\pdsold\controllers;

use app\components\ConstSysMenuComponent;
use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\PdmDetailB10;
use app\modules\pdsold\models\PdmRb2;
use app\modules\pdsold\models\PdmBa5;
use app\modules\pdsold\models\PdmBa5Barbuk;
use app\modules\pdsold\models\PdmRp9;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmSysMenu;
use Yii;
use app\modules\pdsold\models\PdmB10;
use app\modules\pdsold\models\PdmB10Search;
use yii\web\Controller;
use yii\web\Session;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PdmB10Controller implements the CRUD actions for PdmB10 model.
 */
class PdmB10Controller extends Controller
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
        $this->sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::B10 ]);
    }

    /**
     * Lists all PdmB10 models.
     * @return mixed
     */
    public function actionIndex()
    {
        $session = new session();
        $no_register_perkara = $session->get('no_register_perkara');
        $searchModel = new PdmB10Search();
        $dataProvider = $searchModel->search($no_register_perkara,Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sysMenu' => $this->sysMenu,
        ]);
    }

    /**
     * Displays a single PdmB10 model.
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
     * Creates a new PdmB10 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PdmB10();
        $session = new session();
        $no_register_perkara = $session->get('no_register_perkara');
        $listTersangka = Yii::$app->globalfunc->getListTerdakwaBa4($no_register_perkara);
        $ba5 = PdmBa5::findOne(['no_register_perkara'=>$no_register_perkara]);
        $listBarbuk = PdmBa5Barbuk::findAll(['no_register_perkara'=>$no_register_perkara]);
        $modelBarbuk = PdmBa5Barbuk::find()->where(['no_register_perkara'=>$no_register_perkara])
                                            ->orderBy('no_urut_bb')->all();

        if ($model->load(Yii::$app->request->post())) {
            $model->no_register_perkara = $no_register_perkara;
            $model->barbuk = json_encode($_POST['barbuk']);
            $model->created_time=date('Y-m-d H:i:s');
            $model->created_by=\Yii::$app->user->identity->peg_nip;
            $model->created_ip = \Yii::$app->getRequest()->getUserIP();
            
            $model->updated_by=\Yii::$app->user->identity->peg_nip;
            $model->updated_time=date('Y-m-d H:i:s');
            $model->updated_ip = \Yii::$app->getRequest()->getUserIP();
            
            $model->id_kejati = $session->get('kode_kejati');
            $model->id_kejari = $session->get('kode_kejari');
            $model->id_cabjari = $session->get('kode_cabjari');
            if(!$model->save()){
                    var_dump($model->getErrors());exit;
                   }else{
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
                   }
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'no_register_perkara'=> $no_register_perkara,
                'listTersangka' => $listTersangka,
                'ba5' => $ba5,
                'listBarbuk' => $listBarbuk,
                'modelBarbuk' => $modelBarbuk,
                'sysMenu' => $this->sysMenu,
            ]);
        }
    }

    /**
     * Updates an existing PdmB10 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $session = new session();
        $no_register_perkara = $session->get('no_register_perkara');        
        $listTersangka = Yii::$app->globalfunc->getListTerdakwaBa4($no_register_perkara);
        $ba5 = PdmBa5::findOne(['no_register_perkara'=>$no_register_perkara]);
        $listBarbuk = PdmBa5Barbuk::findAll(['no_register_perkara'=>$no_register_perkara]);

        $model = $this->findModel($id,$no_register_perkara);
        $modelBarbuk = PdmBa5Barbuk::find()->where(['no_register_perkara'=>$no_register_perkara])
                                            ->orderBy('no_urut_bb')->all();

        if($model == null)
            $model = new PdmB10();

        if ($model->load(Yii::$app->request->post())) {
            $model->barbuk = json_encode($_POST['barbuk']);
            $model->no_register_perkara = $no_register_perkara;
            $model->updated_by=\Yii::$app->user->identity->peg_nip;
            $model->updated_time=date('Y-m-d H:i:s');
            $model->updated_ip = \Yii::$app->getRequest()->getUserIP();
            if(!$model->save()||$model->update()){
                    var_dump($model->getErrors());exit;
                   }else{
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
                   }
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'no_register_perkara'=> $no_register_perkara,
                'listTersangka' => $listTersangka,
                'ba5' => $ba5,
                'listBarbuk' => $listBarbuk,
                'sysMenu' => $this->sysMenu,
                'modelBarbuk' => $modelBarbuk,
            ]);
        }
    }

    /**
     * Deletes an existing PdmB10 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
        $session = new session();
        $no_register_perkara = $session->get('no_register_perkara');
        $arr= array();
        $id_tahap = $_POST['hapusIndex'][0];
        
            if($id_tahap=='all'){
                    $id_tahapx=PdmB10::find()->select("tgl_b10")->where(['no_register_perkara'=>$no_register_perkara])->asArray()->all();
                    foreach ($id_tahapx as $key => $value) {
                        $arr[] = $value['tgl_b10'];
                        
                    }
                    $id_tahap=$arr;
            }else{
                $id_tahap = $_POST['hapusIndex'];
            }

        $count = 0;
           foreach($id_tahap AS $key_delete => $delete){
             try{
                    PdmB10::deleteAll(['no_register_perkara' => $no_register_perkara, 'tgl_b10'=>$delete]);
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

    /**
     * Finds the PdmB10 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmB10 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $no_register_perkara)
    {
        if (($model = PdmB10::findOne(['no_register_perkara'=>$no_register_perkara, 'tgl_b10' => $id])) !== null) {
            return $model;
        }
    }

    public function actionCetak($id)
    {
        $session = new session();
        $no_register_perkara = $session->get('no_register_perkara');        
        $tersangka = Yii::$app->globalfunc->getListTerdakwaBa4($no_register_perkara);
        $ba5 = PdmBa5::findOne(['no_register_perkara'=>$no_register_perkara]);
        $listBarbuk = PdmBa5Barbuk::findAll(['no_register_perkara'=>$no_register_perkara]);
        $model = $this->findModel($id,$no_register_perkara);
        return $this->render('cetak',['session'=>$_SESSION, 'model'=>$model, 'tersangka'=>$tersangka, 'listBarbuk'=>$listBarbuk, 'ba5'=>$ba5]);
    }
}
