<?php

namespace app\modules\security\controllers;

use app\modules\security\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

/**
 * AuthItemController implements the CRUD actions for AuthItem model.
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class UserController extends Controller
{

	public function beforeAction($action){
		Yii::$app->log->targets[0]->enabled = false;
        return parent::beforeAction($action);
    }

    /**
     * @inheritdoc
     */
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
     * Lists all AuthItem models.
     * @return mixed
     */
    public function actionIndex(){
        $searchModel = new User;
        $dataProvider = $searchModel->searchCustom(Yii::$app->request->get());
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionCreate(){
        $model = new User;
		return $this->render('create', ['model' => $model]);
    }

    public function actionGetrole(){
		if (Yii::$app->request->isAjax) {
        	$searchModel = new User;
			$dataProvider = $searchModel->searchRole(Yii::$app->request->get());
			return $this->renderAjax('_getRole', ['dataProvider' => $dataProvider]);
		}    
	}

    public function actionGetrolemenu(){
		if (Yii::$app->request->isAjax){
        	$searchModel = new User;
			$dataProvider = $searchModel->searchRoleMenu(Yii::$app->request->post());
			return $this->renderAjax('_getRoleMenu', ['dataProvider' => $dataProvider]);
		}    
	}

    public function actionGetpegawai(){
		if (Yii::$app->request->isAjax){
        	$searchModel = new User;
			$dataProvider = $searchModel->searchPegawai(Yii::$app->request->get());
			return $this->renderAjax('_getPegawai', ['dataProvider' => $dataProvider]);
		}    
	}

    public function actionCekrole(){
		if (Yii::$app->request->isAjax) {
			$model = new RoleSearch;
			$hasil = $model->cekRole(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}    
	}

    public function actionSimpan(){
        $model 	= new User;
		$param 	= Yii::$app->request->post();
		if($param['act']){
			$sukses = $model->simpanData($param);
			if($sukses){
				Yii::$app->session->setFlash('success', ['type'=>'success', 'message'=>'Data berhasil disimpan']);
				return $this->redirect(['index']);
			} else{
				Yii::$app->session->setFlash('success', ['type'=>'danger', 'message'=>'Maaf, data gagal disimpan']);
				return $this->redirect(['create']);
			}
		} else{
			$sukses = $model->simpanData($param);
			if($sukses){
				Yii::$app->session->setFlash('success', ['type'=>'success', 'message'=>'Data berhasil diubah']);
				return $this->redirect(['index']);
			} else{
				Yii::$app->session->setFlash('success', ['type'=>'danger', 'message'=>'Maaf, data gagal diubah']);
				return $this->redirect(['update', 'id' => $param['idr']]);
			}
		}
    }

    public function actionUpdate($id){
		$model 	= User::findBySql("select * from mdm_user where id = '".$id."'")->asArray()->one();
        return $this->render('create', ['model' => $model]);
    }

    public function actionHapusdata(){
		if (Yii::$app->request->isAjax) {
			$model = new User;
			$hasil = $model->hapusData(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}
    }

    public function actionCekusername(){
		if (Yii::$app->request->isAjax) {
			$model = new User;
			$hasil = $model->cekUsername(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}    
	}

}