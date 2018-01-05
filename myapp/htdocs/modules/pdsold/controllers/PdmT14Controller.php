<?php

namespace app\modules\pdsold\controllers;

use Yii;
use app\components\GlobalConstMenuComponent;
use app\models\MsWarganegara;
use app\modules\pdsold\models\PdmPenandatangan;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmSysMenu;
use app\modules\pdsold\models\PdmT14;
use app\modules\pdsold\models\PdmT14Search;
use app\modules\pdsold\models\PdmTembusanT14;
use app\modules\pdsold\models\PdmJaksaP16a;
use app\modules\pdsold\models\VwTerdakwaT2;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;

/**
 * PdmT14Controller implements the CRUD actions for PdmT14 model.
 */
class PdmT14Controller extends Controller
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
     * Lists all PdmT14 models.
     * @return mixed
     */
    public function actionIndex()
    {
		$sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::T14]);
        $session = new session();
        $no_register_perkara = $session->get('no_register_perkara');
        $searchModel = new PdmT14Search();
        $dataProvider = $searchModel->search($no_register_perkara,Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'sysMenu'=>$sysMenu,
        ]);
    }

    /**
     * Displays a single PdmT14 model.
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
     * Creates a new PdmT14 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::T14]);
        $session = new session();
        $no_register_perkara = $session->get('no_register_perkara');
        $model = new PdmT14();
        $modeljaksi = PdmJaksaP16a::findAll(['no_register_perkara' => $no_register_perkara]);
        $modelTerdakwa = VwTerdakwaT2::findAll(['no_register_perkara' => $no_register_perkara]);
        
        
		if ($model->load(Yii::$app->request->post())) {
            //echo '<pre>';print_r($_POST);exit;
            
            $model->no_reg_tahanan_jaksa = $_POST['PdmT14']['no_reg_tahanan_jaksa'];
            $model->no_register_perkara = $no_register_perkara;
            $model->id_tersangka = $_POST['PdmT14']['id_tersangka'];
            $model->nama = $_POST['PdmT14']['no_reg_tahanan_jaksa'];
            $model->nip_jaksa = $_POST['PdmT14']['nip_jaksa'];
            $data = array();
            $data['ciri'] = $_POST['ciri'];
            $data['isi'] = $_POST['isi'];
            $model->ciriciri =  json_encode($data);

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
                   }
            
            if (isset($_POST['new_tembusan'])) {
                for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                    $modelNewTembusan = new PdmTembusanT14();
                    $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                    $modelNewTembusan->no_urut = $i+1;
                    $modelNewTembusan->no_register_perkara = $no_register_perkara;
                    $modelNewTembusan->no_surat_t14 = $_POST['PdmT14']['no_surat_t14'];
                    $modelNewTembusan->save();
                }
            }
			
			//notifkasi simpan
            Yii::$app->getSession()->setFlash('success', [
                'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
                'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                'icon' => 'glyphicon glyphicon-ok-sign', //String
                'message' => 'Data Berhasil Disimpan', // String
                'title' => 'Save', //String
                'positonY' => 'top', //String // defaults to top, allows top or bottom
                'positonX' => 'center', //String // defaults to right, allows right, center, left
                'showProgressbar' => true,
            ]);

            return $this->redirect(['index', 'no_surat_t14' => $model->no_surat_t14]);
        } else {
            return $this->render('create', [
                        'model' => $model,
						'modelTerdakwa' => $modelTerdakwa,
                        'modeljaksi' => $modeljaksi,
                        'sysMenu' => $sysMenu
            ]);
        }
    }

    /**
     * Updates an existing PdmT14 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id_t14)
    {
		$session = new session();
        $no_register_perkara = $session->get('no_register_perkara');
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::T14 ]);
        $model = PdmT14::findOne(['no_register_perkara'=>$no_register_perkara, 'no_surat_t14'=>$id_t14]);
        //echo '<pre>';print_r($model);exit;
        $modeljaksi = PdmJaksaP16a::findAll(['no_register_perkara' => $no_register_perkara]);
		$modelTerdakwa = VwTerdakwaT2::findAll(['no_register_perkara' => $no_register_perkara]);
        $ciri2 = json_decode($model->ciriciri);
        //echo '<pre>';print_r($ciri);exit;

        /*if ($model->load(Yii::$app->request->post())) {
            $data = array();
            $data['ciri'] = $_POST['ciri'];
            $data['isi'] = $_POST['isi'];

            $model->ciriciri =  json_encode($data);
            $model->no_reg_tahanan_jaksa = $_POST['PdmT14']['no_reg_tahanan_jaksa'];
            $model->nip_jaksa = $_POST['PdmT14']['nip_jaksa'];
            $model->no_register_perkara = $no_register_perkara;
            $model->id_tersangka = $_POST['PdmT14']['id_tersangka'];

            $model->updated_by=\Yii::$app->user->identity->peg_nip;
            $model->updated_time=date('Y-m-d H:i:s');
            $model->updated_ip = \Yii::$app->getRequest()->getUserIP();

            if($model->update()){
            PdmTembusanT14::deleteAll(['no_register_perkara' => $model->no_register_perkara,'no_surat_t14'=>$model->no_surat_t14]);
                    if(!empty($_POST['new_tembusan'])){
                        for($i = 0; $i < count($_POST['new_tembusan']); $i++){
                            $modelNewTembusan= new PdmTembusanT14();
                            $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                            $modelNewTembusan->no_urut=$i+1;                   
                            $modelNewTembusan->no_register_perkara = $model->no_register_perkara;
                            $modelNewTembusan->no_surat_t14 = $_POST['PdmT14']['no_surat_t14'];
                            $modelNewTembusan->save();
                        }
                    }
            }
					
			
            
			//notifikasi simpan
            //if($model->save()){
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
                //}
            
            
            return $this->redirect(['index']);
        } else {*/
            return $this->render('update', [
                        'model' => $model,
                        'sysMenu' => $sysMenu,
                        'modeljaksi' => $modeljaksi,
						'modelTerdakwa' => $modelTerdakwa,
                        'ciri2'=>$ciri2,
            ]);
        //}
    }

    /**
     * Deletes an existing PdmT14 model.
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
                    $id_tahapx=PdmT14::find()->select("no_surat_t14")->where(['no_register_perkara'=>$no_register_perkara])->asArray()->all();
                    foreach ($id_tahapx as $key => $value) {
                        $arr[] = $value['no_surat_t12'];
                        
                    }
                    $id_tahap=$arr;
            }else{
                $id_tahap = $_POST['hapusIndex'];
            }

        

        $count = 0;
           foreach($id_tahap AS $key_delete => $delete){
             try{
                    PdmT14::deleteAll(['no_register_perkara' => $no_register_perkara, 'no_surat_t14'=>$delete]);
                }catch (\yii\db\Exception $e) {
                    $count++;
                }
            }
            if($count>0){
                Yii::$app->getSession()->setFlash('success', [
                     'type' => 'danger',
                     'duration' => 5000,
                     'icon' => 'fa fa-users',
                     'message' =>  $count.' Data Tidak Dapat Dihapus Karena Sudah Digunakan Di Persuratan Lainnya',
                     'title' => 'Error',
                     'positonY' => 'top',
                     'positonX' => 'center',
                     'showProgressbar' => true,
                 ]);
                 return $this->redirect(['index']);
            }

            return $this->redirect(['index']);
    }
	
	
	
	public function actionCetak ($id_t14) {     
        $connection = \Yii::$app->db;
        $session = new session();
        $no_register_perkara = $session->get('no_register_perkara');
        $id_perkara = $session->get('id_perkara');
        $spdp = $this->findModelSpdp($id_perkara);

        $model = $this->findModel($id_t14,$no_register_perkara);
        $tersangka = VwTerdakwaT2::findOne(['no_register_perkara'=>$no_register_perkara, 'no_urut_tersangka'=>$model->id_tersangka]);
        $tembusan = PdmTembusanT14::findAll(['no_register_perkara' => $no_register_perkara, 'no_surat_t14'=>$id_t14]);
        //echo '<pre>';print_r($model);exit;
        return $this->render('cetak',['session'=>$_SESSION, 'model'=>$model, 'tersangka'=>$tersangka, 'tembusan'=>$tembusan, 'spdp'=>$spdp]);        
    }

    /**
     * Finds the PdmT14 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmT14 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_t14,$no_register_perkara)
    {
        if (($model = PdmT14::findOne(['no_surat_t14' => $id_t14, 'no_register_perkara'=>$no_register_perkara])) !== null) {
            return $model;
      } 
//        else {
//            throw new NotFoundHttpException('The requested page does not exist.');
//        }
    }
	
	protected function findModelSpdp($id) {
        if (($modelSpdp = PdmSpdp::findOne($id)) !== null) {
            return $modelSpdp;
        } 
		//else {
          //  throw new NotFoundHttpException('The requested page does not exist.');
        //}
    }
    }
