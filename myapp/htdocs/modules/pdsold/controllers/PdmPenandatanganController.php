<?php

namespace app\modules\pdsold\controllers;

use Yii;
use app\modules\pdsold\models\PdmPenandatangan;
use app\modules\pdsold\models\PdmPenandatanganSearch;
use app\modules\pdsold\models\VwJaksaPenuntutSearch;
use app\modules\pdsold\models\PdmJaksaPenerima;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;

/**
 * PdmPenandatanganController implements the CRUD actions for PdmPenandatangan model.
 */
class PdmPenandatanganController extends Controller
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
     * Lists all PdmPenandatangan models.
     * @return mixed
     */
    public function actionIndex()
    {
		$session = new Session();
        $session->remove('id_perkara');
		$session->remove('nomor_perkara');
		$session->remove('tgl_perkara');
		$session->remove('tgl_terima');
        $searchModel = new PdmPenandatanganSearch();
        $id_ttd = Yii::$app->session->get('id_perkara');
        $dataProvider = $searchModel->search($id_ttd, Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PdmPenandatangan model.
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
     * Creates a new PdmPenandatangan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $session = new Session();
        $id = $session->get('id_ttd');
        $model = new PdmPenandatangan();
   
        $searchJPU = new VwJaksaPenuntutSearch();
        $dataJPU = $searchJPU->search2(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;
        
        if ($model->load(Yii::$app->request->post())) {
            $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_penandatangan', 'id_ttd', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
            $model->id_ttd = $seq['generate_pk'];
            $model->keterangan = '-';
            $model->save();

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
	    return $this->redirect('index');                 
        
        } else {
            return $this->render('create', [
                'model' => $model,
                'searchJPU' => $searchJPU,
                'dataJPU' => $dataJPU,
               ]);
        }
    }
    

    /**
     * Updates an existing PdmPenandatangan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id_ttd)
    {   
        $session = new Session();
        $id = $session->get('id_ttd');
        $model = PdmPenandatangan::findOne(['id_ttd' => $id_ttd]);
        if ($model == null) {
            $model = new PdmPenandatangan();
        }
        $searchJPU = new VwJaksaPenuntutSearch();
        $dataJPU = $searchJPU->search2(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5; 

        if ($model->load(Yii::$app->request->post())) {
            if ($model->id_ttd == null) {
                  $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_penandatangan', 'id_ttd', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                    $model->id_ttd = $id;
                    $model->id_ttd = $seq['generate_pk'];
                    $model->save();
              } else {
                $model->update();
                $model->load(Yii::$app->request->post());
                $model->update();
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
                    return $this->redirect(['index']);
            //    return $this->redirect(['update', 'id_ttd' => $model->id_ttd]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'searchJPU' => $searchJPU,
                'dataJPU' => $dataJPU,
            ]);
        }
    }

    /**
     * Deletes an existing PdmPenandatangan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
  {  try{
            $id = $_POST['hapusIndex'];

            if($id == "all"){
                $session = new Session();
                $id_ttd = $session->get('id_ttd');

                PdmPenandatangan::updateAll(['flag' => '3'], "id_ttd = '" . $id_ttd . "'");
            }else{
                for($i=0;$i<count($id);$i++){
                    PdmPenandatangan::updateAll(['flag' => '3'], "id_ttd = '" . $id[$i] . "'");
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
     * Finds the PdmPenandatangan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmPenandatangan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmPenandatangan::findOne($id)) !== null) {
            return $model;
       }
       
    }
    
    public function actionJpu()
    {
    	$searchModel = new VwJaksaPenuntutSearch();
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    	$dataProvider->pagination->pageSize=10;
    	return $this->renderAjax('_m_jpu2', [
    			'searchModel' => $searchModel,
    			'dataProvider' => $dataProvider,
    	]);
    }
}
