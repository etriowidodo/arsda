<?php

namespace app\modules\pdsold\controllers;
use app\components\GlobalConstMenuComponent;
use Yii;
use app\modules\pdsold\models\MsInstPenyidik;
use app\modules\pdsold\models\MsInstPenyidikSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Jaspersoft\Client\Client;
use app\components\ConstSysMenuComponent;
use yii\base\ErrorException;
use yii\filters\VerbFilter;
use yii\web\Session;
/**
 * MsInstPenyidikController implements the CRUD actions for MsInstPenyidik model.
 */
class MsInstPenyidikController extends Controller
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
     * Lists all MsInstPenyidik models.
     * @return mixed
     */
    public function actionIndex()
    {
		$session = new Session();
        $session->remove('id_perkara');
		$session->remove('nomor_perkara');
		$session->remove('tgl_perkara');
		$session->remove('tgl_terima');
		
        $searchModel = new MsInstPenyidikSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MsInstPenyidik model.
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
     * Creates a new MsInstPenyidik model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MsInstPenyidik();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MsInstPenyidik model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->kode_ip]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

     public function actionCekNoKodeIp()
    {
        $kode_ip = str_replace(" ","",$_POST['kode_ip']); 
        $query = MsInstPenyidik::find()
        ->where(['REPLACE(kode_ip,\' \',\'\')' => $kode_ip])
        ->all();
        echo count($query);
    }
    /**
     * Deletes an existing MsInstPenyidik model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
       
       $kode_ip     = $_POST['kode_ip'];
       $countError  = 0;
       $countSuccess= 0;
       $result      = array(); 
       foreach($kode_ip AS $key => $value)
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
     * Finds the MsInstPenyidik model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return MsInstPenyidik the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MsInstPenyidik::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
