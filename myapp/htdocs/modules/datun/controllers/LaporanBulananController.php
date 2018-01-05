<?php


namespace app\modules\datun\controllers;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\HtmlPurifier;
use app\modules\datun\models\searchs\Laporanbulanan as Search;

class LaporanBulananController extends Controller
{
    public function actionIndex(){
     return $this->render('index');
    }

    public function actionCetak(){
	
			return $this->render('cetak');
 
	} 
		
	public function actionGet_ttd(){				
		 
	$searchModel = new Search;
		$dataProvider = $searchModel->searchTtd(Yii::$app->request->get());
		return $this->renderAjax('_ttd', ['dataProvider' => $dataProvider]);
	
	} 
		
}


