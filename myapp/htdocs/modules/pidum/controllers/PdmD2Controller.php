<?php

namespace app\modules\pidum\controllers;

use Yii;
use yii\web\Session;
use app\modules\pidum\models\PdmD1;
use app\modules\pidum\models\PdmD2;
use app\modules\pidum\models\PdmD2Search;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmMsStatusData;
use app\modules\pidum\models\VwJaksaPenuntutSearch;
use app\modules\pidum\models\VwJaksaPenuntut;
use app\modules\pidum\models\PdmJaksaPenerima;
use app\modules\pidum\models\VwTerdakwaT2;
use app\modules\pidum\models\PdmPutusanPn;
use app\modules\pidum\models\PdmPutusanPnTerdakwa;
use app\modules\pidum\models\PdmP48;

use yii\web\Controller;
use yii\db\Query;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\GlobalConstMenuComponent;
use app\components\ConstSysMenuComponent;
use Nasution\Terbilang;

/**
 * PdmD2Controller implements the CRUD actions for PdmD2 model.
 */
class PdmD2Controller extends Controller
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
     * Lists all PdmD2 models.
     * @return mixed
     */
    public function actionIndex()
    {
      $session = new session();
      $no_eksekusi = $session->get('no_eksekusi');
      return $this->redirect(['update', 'no_eksekusi' => $no_eksekusi]);
        /*$searchModel = new PdmD2Search();
		$id_perkara = Yii::$app->session->get('id_perkara');
			// var_dump($id_perkara);
		// exit();
        $dataProvider = $searchModel->search($id_perkara, Yii::$app->request->queryParams);
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);*/
    }

    /**
     * Displays a single PdmD2 model.
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
     * Creates a new PdmD2 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		$session = new session();
        $id_perkara = $session->get('id_perkara');
        $no_register_perkara = $session->get('no_register_perkara');
        $no_akta = $session->get('no_akta');
        $no_reg_tahanan = $session->get('no_reg_tahanan');
        $no_eksekusi = $session->get('no_eksekusi');
        $no_putusan = PdmP48::findOne(['no_surat'=>$no_eksekusi])->no_putusan;
	    $putusan = PdmPutusanPnTerdakwa::findOne(['no_reg_tahanan'=>$no_reg_tahanan,'no_surat'=>$no_putusan]);
  		$model = new PdmD2();
		$d1 = PdmD1::findOne(['no_eksekusi'=>$no_eksekusi]);
		$terdakwa = VwTerdakwaT2::findOne(['no_register_perkara' => $no_register_perkara, 'no_reg_tahanan' => $no_reg_tahanan]);

		
		$searchJPU = new VwJaksaPenuntutSearch();
		$dataJPU = $searchJPU->search16a_new(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {

                //echo '<pre>';print_r($_POST);exit;
                $model->no_reg_tahanan = $no_reg_tahanan;
                $model->no_eksekusi = $no_eksekusi;
                $model->no_register_perkara = $no_register_perkara;

                $model->created_time=date('Y-m-d H:i:s');
                $model->created_by=\Yii::$app->user->identity->peg_nip;
                $model->created_ip = \Yii::$app->getRequest()->getUserIP();
                
                $model->updated_by=\Yii::$app->user->identity->peg_nip;
                $model->updated_time=date('Y-m-d H:i:s');
                $model->updated_ip = \Yii::$app->getRequest()->getUserIP();
                
                $denda = str_replace('.', '', $_POST['PdmPutusanPnTerdakwa']['denda']);
    			$model->nilai = $denda;
    			 
    			 if(!$model->save()){
                    var_dump($model->getErrors());exit;
                 }

                $transaction->commit();
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
                return $this->redirect(['update', 'no_eksekusi' => $no_eksekusi]);         
            } catch (Exception $ex) {
                $transaction->rollback();
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
            }
        return $this->redirect(['index']);
            //return $this->redirect(['view', 'id' => $model->id_d2]);
        } else {
            return $this->render('create', [
                'model' => $model,
			    'searchJPU' => $searchJPU,
			    'dataJPU' => $dataJPU,
				'modelpenerima'=> $modelpenerima,
                'terdakwa' => $terdakwa,
                'd1' => $d1,
                'putusan' => $putusan,
            ]);
        }
    }

    /**
     * Updates an existing PdmD2 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($no_eksekusi){
		    $session = new session();
        $id_perkara = $session->get('id_perkara');
        $no_register_perkara = $session->get('no_register_perkara');
        $no_akta = $session->get('no_akta');
        $no_reg_tahanan = $session->get('no_reg_tahanan');
        $no_eksekusi = $session->get('no_eksekusi');
        $no_putusan = PdmP48::findOne(['no_surat'=>$no_eksekusi])->no_putusan;
        $putusan = PdmPutusanPnTerdakwa::findOne(['no_reg_tahanan'=>$no_reg_tahanan,'no_surat'=>$no_putusan]);
//        echo '<pre>';print_r($putusan);exit;

        $model = $this->findModel($no_eksekusi);
        if($model==NULL){
          $model = new PdmD2();
        }
        $d1 = PdmD1::findOne(['no_eksekusi'=>$no_eksekusi]);
        //echo '<pre>';print_r($d1);exit;
        $terdakwa = VwTerdakwaT2::findOne(['no_register_perkara' => $no_register_perkara, 'no_reg_tahanan' => $no_reg_tahanan]);

        
        $searchJPU = new VwJaksaPenuntutSearch();
        $dataJPU = $searchJPU->search16a_new(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;
		
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                //echo '<pre>';print_r($_POST);exit;
                $model->no_reg_tahanan = $no_reg_tahanan;
                $model->no_eksekusi = $no_eksekusi;
                $model->no_register_perkara = $no_register_perkara;
                
                $model->updated_by=\Yii::$app->user->identity->peg_nip;
                $model->updated_time=date('Y-m-d H:i:s');
                $model->updated_ip = \Yii::$app->getRequest()->getUserIP();
                //$model->nilai = 'asdasd';
                //echo '<pre>';print_r($deenda);exit;
                /*$denda = str_replace('.', '', $_POST['PdmPutusanPnTerdakwa']['denda']);

                $model->nilai = $denda=='' ? 0 : $denda;*/
                 //echo '<pre>';print_r($model);exit;
                 if(!$model->save()){
                    var_dump($model->getErrors().'cuakakak');exit;
                 }

                $transaction->commit();
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
                return $this->redirect(['update', 'no_eksekusi' => $no_eksekusi]);         
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'danger',
                    'duration' => 3000,
                    'icon' => 'fa fa-users',
                    'message' => 'Data Gagal di Ubah',
                    'title' => 'Error',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
            }
        return $this->redirect(['index']);  
        }else {
            return $this->render('update', [
                'model' => $model,
				'id'=>$id,
				'searchJPU' => $searchJPU,
				'dataJPU' => $dataJPU,
				'modelpenerima'=>$modelpenerima,
                'terdakwa' => $terdakwa,
                'd1' => $d1,
                'putusan' => $putusan,
            ]);
        }
    }

    /**
     * Deletes an existing PdmD2 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete(){
        $session = new session();
        $no_eksekusi = $session->get('no_eksekusi');
        PdmD2::deleteAll(['no_eksekusi' => $no_eksekusi]);
        return $this->redirect(['index']);
    }
	
	public function actionCetak($no_eksekusi){
	   $session = new session();
       $id_perkara = $session->get('id_perkara');
       $no_register_perkara = $session->get('no_register_perkara');
       $no_akta = $session->get('no_akta');
       $no_reg_tahanan = $session->get('no_reg_tahanan');
       $no_eksekusi = $session->get('no_eksekusi');
       $spdp = PdmSpdp::findOne(['id_perkara'=>$id_perkara]);
       
       $model = $this->findModel($no_eksekusi);
       //echo '<pre>';print_r($model);exit;
       $d1 = PdmD1::findOne(['no_eksekusi'=>$no_eksekusi]);
       $p48 = PdmP48::findOne(['no_surat'=>$no_eksekusi]);
       $putusan = PdmPutusanPn::findOne(['no_surat'=>$p48->no_putusan]);
       $tersangka = VwTerdakwaT2::findOne(['no_register_perkara'=>$no_register_perkara, 'no_reg_tahanan'=>$model->no_reg_tahanan]);
       
       //echo '<pre>';print_r($p48);exit;
       return $this->render('cetak', ['tersangka'=>$tersangka, 'p48'=>$p48 ,'model'=>$model, 'spdp'=>$spdp, 'putusan'=>$putusan, 'd1'=>$d1]);
	}

	public function actionJpu()
    {
    	$searchModel = new VwJaksaPenuntutSearch();
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    	$dataProvider->pagination->pageSize=10;
    	return $this->renderAjax('_jpu', [
    			'searchModel' => $searchModel,
    			'dataProvider' => $dataProvider,
    	]);
    }
    /**
     * Finds the PdmD2 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmD2 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($no_eksekusi)
    {
        if (($model = PdmD2::findOne($no_eksekusi)) !== null) {
            return $model;
        } 
    }
}
