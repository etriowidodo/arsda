<?php

namespace app\modules\pdsold\controllers;

use app\modules\pdsold\models\PdmP34;
use app\modules\pdsold\models\PdmP34Search;
use app\modules\pdsold\models\MsTersangka;
use app\modules\pdsold\models\PdmJaksaSaksi;
use app\modules\pdsold\models\MsTersangkaSearch;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\KpPegawai;
use app\modules\pdsold\models\PdmTerdakwa;
use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\VwJaksaPenuntutSearch;
use app\modules\pdsold\models\PdmJaksaPenerima;
use app\modules\pdsold\models\VwTerdakwaT2;
use app\modules\pdsold\models\PdmBa5Jaksa;
use app\modules\pdsold\models\PdmSysMenu;
use app\modules\pdsold\models\PdmBa5;
use app\modules\pdsold\models\PdmBa5Barbuk;
use app\modules\pdsold\models\PdmPasal;
use app\modules\pdsold\models\PdmTrxPemrosesan;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
use yii\db\Query;
use yii\base\Model; 

/**
 * PdmP34Controller implements the CRUD actions for PdmP34 model.
 */
class PdmP34Controller extends Controller
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
     * Lists all PdmP34 models.
     * @return mixed
     */
     public function actionIndex()
     {
         /*$searchModel = new PdmP34Search();
         $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

         return $this->render('index', [
             'searchModel' => $searchModel,
             'dataProvider' => $dataProvider,
         ]);*/
         return $this->redirect('update');
     }

    /**
     * Displays a single PdmP34 model.
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
     * Creates a new PdmP34 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		
		return $this->redirect('update'); 
    }

    /**
     * Updates an existing PdmP34 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P34 ]);
        $session = new session();
        $id_perkara = $session->get('id_perkara');
        $no_register_perkara = $session->get('no_register_perkara');
        
        $searchJPU = new VwJaksaPenuntutSearch();
        $dataJPU = $searchJPU->searchjaksaba5(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;
        
        $model = $this->findModel($no_register_perkara);
        $modeljapen = PdmBa5Jaksa::findOne(['no_register_perkara'=> $no_register_perkara, 'nip'=>$model->nip_jaksa]);    
        if($model == null){
            $model = new PdmP34();
            $modeljapen = new PdmBa5Jaksa();
        }
        
        //$modelTersangka = VwTerdakwaT2::findAll(['no_register_perkara' => $no_register_perkara]);
        $modelSpdp = $this->findModelSpdp($id_perkara);
        //echo '<pre>';print_r($modeljapen);exit;
        //$modeljapen = new PdmJaksaPenerima();
       
        if ($model->load(Yii::$app->request->post())) {
            //echo '<pre>';print_r($_POST);exit;			
			
            $model->no_register_perkara = $no_register_perkara;
            $model->nip_jaksa   = $_POST['PdmBa5Jaksa']['nip'];
            $model->file_upload   = $_POST['PdmP34']['file_upload'];

            $model->created_time=date('Y-m-d H:i:s');
            $model->created_by=\Yii::$app->user->identity->peg_nip;
            $model->created_ip = \Yii::$app->getRequest()->getUserIP();
            
            $model->updated_by=\Yii::$app->user->identity->peg_nip;
            $model->updated_time=date('Y-m-d H:i:s');
            $model->updated_ip = \Yii::$app->getRequest()->getUserIP();
            
            $model->id_kejati = $session->get('kode_kejati');
            $model->id_kejari = $session->get('kode_kejari');
            $model->id_cabjari = $session->get('kode_cabjari');
            if($model->save()||$model->update()){
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
                 return $this->redirect('update');
                    
            }else{
                    var_dump($model->getErrors());exit;
            }				 
        } else {
            //echo '<pre>';print_r($modeljapen);exit;
            return $this->render('update', [
                        'model' => $model,
                        'searchJPU' => $searchJPU,
                        'dataJPU' => $dataJPU,
                        //'modelTersangka' => $modelTersangka,
                        //'id' => $id,
                        'modelSpdp' => $modelSpdp,
                        'modeljapen' => $modeljapen,
                        'no_register_perkara'=>$no_register_perkara,
            ]);
        }
    }

    /**
     * Deletes an existing PdmP34 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PdmP34 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmP34 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($no_surat)
    {
        if (($model = PdmP34::findOne(['no_register_perkara' => $no_surat])) !== null) {
            return $model;
        } 
    }
	
	protected function findModelTersangka($id)
    {
        if (($model = MsTersangka::findAll(['id_perkara' => $id])) !== null) {
            return $model;
        }else { 
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	protected function findModelSpdp($id)
    {
        if (($modelSpdp = PdmSpdp::findOne($id)) !== null) {
            return $modelSpdp;
        } 
    }
	
	protected function findModelJapen($id)
    {
        if (($modeljapen = PdmJaksaPenerima::findOne($id)) !== null) {
            return $modeljapen;
        } 
    }
	
	  public function actionCetak($no_surat)
	  { 
		$session = new session();
        $no_register_perkara = $session->get('no_register_perkara');  
        $tersangka = Yii::$app->globalfunc->getListTerdakwaBa4($no_register_perkara);
        $ba5 = PdmBa5::findOne(['no_register_perkara'=>$no_register_perkara]);
        $model = $this->findModel($no_surat);
        if($model==NULL){
            //ECHO 'lel';exit;
            return $this->render('cetak');
        }
        $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_uu_pasal_tahap2')
                ->where("no_register_perkara='" . $no_register_perkara . "'");
        $data = $query->createCommand();
        $listPasal = $data->queryAll();

        return $this->render('cetak',['session'=>$_SESSION, 'model'=>$model, 'tersangka'=>$tersangka, 'ba5'=>$ba5, 'listPasal'=>$listPasal ]);
	  }
}
