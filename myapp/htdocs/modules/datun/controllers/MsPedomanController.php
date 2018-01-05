<?php

namespace app\modules\pidum\controllers;

use Yii;
use app\modules\pidum\models\MsPedoman;
use app\modules\pidum\models\MsPedomanSearch;
use app\modules\pidum\models\MsUUndangSearch;
use app\modules\pidum\models\MsPasalSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MsPedomanController implements the CRUD actions for MsPedoman model.
 */
class MsPedomanController extends Controller
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
     * Lists all MsPedoman models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MsPedomanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MsPedoman model.
     * @param string $uu
     * @param string $pasal
     * @param integer $kategori
     * @return mixed
     */
    public function actionView($uu, $pasal, $kategori)
    {
        return $this->render('view', [
            'model' => $this->findModel($uu, $pasal, $kategori),
        ]);
    }

    /**
     * Creates a new MsPedoman model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MsPedoman();
		$searchUU = new MsUUndangSearch();
        $dataUU = $searchUU->search(Yii::$app->request->queryParams);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'uu' => $model->uu, 'pasal' => $model->pasal, 'kategori' => $model->kategori]);
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
     * Updates an existing MsPedoman model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $uu
     * @param string $pasal
     * @param integer $kategori
     * @return mixed
     */
    public function actionUpdate($uu, $pasal, $kategori)
    {
        $model = $this->findModel($uu, $pasal, $kategori);
		$searchUU = new MsUUndangSearch();
        $dataUU = $searchUU->search(Yii::$app->request->queryParams);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'uu' => $model->uu, 'pasal' => $model->pasal, 'kategori' => $model->kategori]);
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
     * Deletes an existing MsPedoman model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $uu
     * @param string $pasal
     * @param integer $kategori
     * @return mixed
     */
    public function actionDelete()
    {
		$id = $_POST['hapusIndex'];
		if($id=='all'){
			MsPedoman::deleteAll();
			return $this->redirect(['index']);
		}
		for($i=0;$i<count($id);$i++){
			$exp = explode("#",$id[$i]);
			$uu = $exp[0];
			$pasal = $exp[1];
			$kategori = $exp[2];
			$this->findModel($uu, $pasal, $kategori)->delete();
		}

        return $this->redirect(['index']);
    }

    /**
     * Finds the MsPedoman model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $uu
     * @param string $pasal
     * @param integer $kategori
     * @return MsPedoman the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($uu, $pasal, $kategori)
    {
        if (($model = MsPedoman::findOne(['uu' => $uu, 'pasal' => $pasal, 'kategori' => $kategori])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	public function actionShowPasal(){
		
		$uu = $_GET['uu'];
		
		$queryParams = array_merge(array(),Yii::$app->request->queryParams);
        $queryParams["MsPasal"]["uu"] = $uu ;
		
		$searchPasal = new MsPasalSearch();
        $dataPasal = $searchPasal->search($queryParams);

        return $this->renderAjax('_pasal', [
            'searchPasal' => $searchPasal,
            'dataPasal' => $dataPasal,
        ]);
	}
}
