<?php

namespace app\modules\datun\controllers;
use app\components\GlobalConstMenuComponent;
use Yii;
//use app\modules\datun\models\MsWilayah;
use app\modules\datun\models\MsWilayahkab;
use app\modules\datun\models\MsWilayahkabSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Jaspersoft\Client\Client;
use yii\filters\VerbFilter;
use app\components\ConstSysMenuComponent;
use yii\base\ErrorException;
use yii\helpers\ArrayHelper;
use yii\web\Session;
use yii\db\Query;

/**
 * WilayahKabController implements the CRUD actions for MsWilayah model.
 */
class WilayahkabController extends Controller
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
     * Lists all MsWilayah models.
     * @return mixed
     */
    public function actionIndex($id)
    {				
        $searchModel  = new MsWilayahkabSearch();
        $dataProvider = $searchModel->ambilkab($id);
		//$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'idprop'	   => $id
        ]);
    }

    /**
     * Displays a single MsWilayah model.
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
     * Creates a new MsWilayah model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new MsWilayahkab();
		//$kode  = ArrayHelper::map(\app\modules\datun\models\MsWilayahkab::find()->all(), 'id_prop','id_kabupaten_kota', 'deskripsi_kabupaten_kota');
		//$idprop= ArrayHelper::map(\app\modules\datun\models\MsWilayah::find()->one(), 'id_prop','id_kabupaten_kota', 'deskripsi_kabupaten_kota');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id_kabupaten_kota]);
        }else {
			return $this->render('create', [
                'model' 	=> $model,
				'kode'      => $id,//$kode,
				//'idp' 		=> $model->id_prop
				//'idprop'    => $idprop,
            ]);
        }
    }

    /**
     * Updates an existing MsWilayah model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		//$kode  = ArrayHelper::map(\app\modules\datun\models\MsWilayahkab::find()->all(), 'id_kabupaten_kota', 'deskripsi_kabupaten_kota');
		//$deskrip = new Query;
      /*   $connection = \Yii::$app->db;
        $query = "select * from datun.m_kabupaten where id_kabupaten_kota='".$id."'";
	    $command = $connection->createCommand($query);
		$m_kab = $command->execute(); */
		//$hasil = $model->ambilwilkab($id);

		$connection = Yii::$app->db;
		$command = $connection->createCommand("select deskripsi_kabupaten_kota from datun.m_kabupaten where id_kabupaten_kota='".$id."'");
		$artikel = $command->queryOne();
		
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id_kabupaten_kota]);
        } else {
            return $this->render('update', [
                'model' 	=> $model,
				'kode'      => $id,
				'deskrip'   => $artikel['deskripsi_kabupaten_kota'],
            ]);
        }
		
    }

    /**
     * Deletes an existing MsWilayah model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
/*     public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
 */
 
    public function actionDelete()
    {
       $query = MsWilayahkab::find();
       $kode     = $_POST['id_kabupaten_kota'];
       $countError  = 0;
       $countSuccess= 0;
       $result      = array(); 
       foreach($kode AS $key => $value)
       { 
            try 
            {
                $this->findModel($value)->delete();
                $result[] = $value;
                ++$countSuccess;
            } 
            catch (\yii\db\Exception $e) {
                ++$countError;
            }
       }
       $callBack= array(
                        'countSuccess'  => $countSuccess,
                        'countError'    => $countError,
                        'resultDelete'  => json_encode($result)
                        );
       echo json_encode($callBack);
    }
 
    /**
     * Finds the MsWilayah model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return MsWilayah the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MsWilayahkab::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	//faiz
	
	  public function actionSimpanwil()
    {
		//kd1:kd_prop,kd2:kd_kab,desk:desk
		$kdp   = Yii::$app->request->post('kd1');
		$model = new MsWilayahkab();
		$hasil = $model->msimpanwil(Yii::$app->request->post());
        $this->redirect(['index?id='.$kdp]);	
		
        /* if($hasil){
            $this->redirect(['index?id=99']);			
		}else{
            $this->redirect(['index?id=12']);			
			
		} */

		
		
		
		
		//$connection = Yii::$app->db;
	/* 	Yii::$app->request->post()
        $kd1  	= $this->input->post('kd1');
        $kd2  	= $this->input->post('kd2');
        $desk  	= $this->input->post('desk');
		
		$sql="insert into datun.m_kabupaten values('$kd1','$kd2','$desk')";
		$command = $connection->createCommand($sql);
		$m_kab = $command->execute();
		 */
	}
	
		  public function actionUbahwil()
    {
		//kd1:kd_prop,kd2:kd_kab,desk:desk
		$kdp   = Yii::$app->request->post('kd2');
		$model = new MsWilayahkab();
		$hasil = $model->mubahwil(Yii::$app->request->post());
        $this->redirect(['index?id='.substr($kdp,0,2)]);	

	}
	
}
