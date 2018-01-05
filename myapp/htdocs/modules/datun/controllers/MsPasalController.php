<?php

namespace app\modules\pidum\controllers;

use Yii;
use app\modules\pidum\models\MsPasal;
use app\modules\pidum\models\MsPasalSearch;
use app\modules\pidum\models\MsUUndangSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
/**
 * MsPasalController implements the CRUD actions for MsPasal model.
 */
class MsPasalController extends Controller
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
     * Lists all MsPasal models.
     * @return mixed
     */
    public function actionIndex()
    {
		$session = new Session();
        $session->remove('id_perkara');
		$session->remove('nomor_perkara');
		$session->remove('tgl_perkara');
		$session->remove('tgl_terima');
		
        $searchModel = new MsPasalSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MsPasal model.
     * @param string $uu
     * @param string $pasal
     * @return mixed
     */
    public function actionView($uu, $pasal)
    {
        return $this->render('view', [
            'model' => $this->findModel($uu, $pasal),
        ]);
    }

    /**
     * Creates a new MsPasal model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MsPasal();
		$searchUU = new MsUUndangSearch();
        $dataUU = $searchUU->search(Yii::$app->request->queryParams);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'searchUU' => $searchUU,
                'dataUU' => $dataUU,
            ]);
        }
    }

    /**
     * Updates an existing MsPasal model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $uu
     * @param string $pasal
     * @return mixed
     */
    public function actionUpdate($uu, $pasal)
    {
        $model = $this->findModel($uu, $pasal);
		$searchUU = new MsUUndangSearch();
        $dataUU = $searchUU->search(Yii::$app->request->queryParams);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
				'searchUU' => $searchUU,
                'dataUU' => $dataUU,
            ]);
        }
    }

    /**
     * Deletes an existing MsPasal model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $uu
     * @param string $pasal
     * @return mixed
     */
    public function actionDelete()
    {
		$id = $_POST['hapusIndex'];
		if($id=='all'){
			MsPasal::deleteAll();
			return $this->redirect(['index']);
		}
		for($i=0;$i<count($id);$i++){
			$exp = explode("#",$id[$i]);
			$uu = $exp[0];
			$pasal = $exp[1];
			$this->findModel($uu, $pasal)->delete();
		}


        return $this->redirect(['index']);
    }

    /**
     * Finds the MsPasal model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $uu
     * @param string $pasal
     * @return MsPasal the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($uu, $pasal)
    {
        if (($model = MsPasal::findOne(['uu' => $uu, 'pasal' => $pasal])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
