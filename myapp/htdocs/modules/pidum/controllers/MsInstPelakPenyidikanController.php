<?php

namespace app\modules\pidum\controllers;
use app\components\GlobalConstMenuComponent;
use Yii;
use app\modules\pidum\models\MsInstPelakPenyidikan;
use app\modules\pidum\models\MsInstPelakPenyidikanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Jaspersoft\Client\Client;
use yii\filters\VerbFilter;
use app\components\ConstSysMenuComponent;
use yii\base\ErrorException;
use yii\helpers\ArrayHelper;
use yii\web\Session;


/**
 * MsInstPelakPenyidikanController implements the CRUD actions for MsInstPelakPenyidikan model.
 */
class MsInstPelakPenyidikanController extends Controller
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
     * Lists all MsInstPelakPenyidikan models.
     * @return mixed
     */
    public function actionIndex()
    {
		$session = new Session();
        $session->remove('id_perkara');
		$session->remove('nomor_perkara');
		$session->remove('tgl_perkara');
		$session->remove('tgl_terima');
		
        $searchModel = new MsInstPelakPenyidikanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MsInstPelakPenyidikan model.
     * @param string $kode_ip
     * @param string $kode_ipp
     * @return mixed
     */
    public function actionView($kode_ip, $kode_ipp)
    {
        return $this->render('view', [
            'model' => $this->findModel($kode_ip, $kode_ipp),
        ]);
    }

    /**
     * Creates a new MsInstPelakPenyidikan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model      = new MsInstPelakPenyidikan();
        $kode       = ArrayHelper::map(\app\modules\pidum\models\MsInstPenyidik::find()->all(), 'kode_ip', 'nama');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model'    => $model,
                'kode'     => $kode,
            ]);
        }
    }

    /**
     * Updates an existing MsInstPelakPenyidikan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $kode_ip
     * @param string $kode_ipp
     * @return mixed
     */
    public function actionUpdate($kode_ip, $kode_ipp)
    {
        $model = $this->findModel($kode_ip, $kode_ipp);
        $kode  = ArrayHelper::map(\app\modules\pidum\models\MsInstPenyidik::find()->all(), 'kode_ip', 'nama');
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model'     => $model,
                'kode'      => $kode
            ]);
        }
    }
    public function actionCekNoKodeIpp()
    {
        $kode_ipp   = str_replace(" ","",$_POST['kode_ipp']);
        $kode_ip    = str_replace(" ","",$_POST['kode_ip']);  
        $query      = MsInstPelakPenyidikan::find()
        ->where(['REPLACE(kode_ipp,\' \',\'\')' => $kode_ipp,'kode_ip'=>$kode_ip])
        ->all();
        echo count($query);
    }
    /**
     * Deletes an existing MsInstPelakPenyidikan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $kode_ip
     * @param string $kode_ipp
     * @return mixed
     */
    public function actionDelete()
    {
           $kode_ipp     = $_POST['kode_ipp'];
           $kode_ip      = $_POST['kode_ip'];
           $countError   = 0;
           $countSuccess = 0;
           $result       = array();
           $i            = 0; 
           foreach($kode_ipp AS $key => $value)
           { 
                try 
                {
                    $this->findModel( $kode_ip[$i],$value)->delete();
                    $result[] = $value;
                    ++$countSuccess;
                } 
                catch (\yii\db\Exception $e) {
                    ++$countError;
                }
            $i++;
           }
           $callBack= array(
                            'countSuccess'  => $countSuccess,
                            'countError'    => $countError,
                            'resultDelete'  => json_encode($result)
                            );
           echo json_encode($callBack);
    }

    /**
     * Finds the MsInstPelakPenyidikan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $kode_ip
     * @param string $kode_ipp
     * @return MsInstPelakPenyidikan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($kode_ip, $kode_ipp)
    {
        if (($model = MsInstPelakPenyidikan::findOne(['kode_ip' => $kode_ip, 'kode_ipp' => $kode_ipp])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
