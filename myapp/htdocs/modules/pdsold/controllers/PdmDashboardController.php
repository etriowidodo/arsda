<?php

namespace app\modules\pdsold\controllers;

use Yii;
use app\modules\pdsold\models\MsUUndang;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
/**
 * MsUUndangController implements the CRUD actions for MsUUndang model.
 */
class PdmDashboardController extends Controller
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
     * Lists all MsUUndang models.
     * @return mixed
     */
    public function actionIndex()
    {
		$session = new Session();
        $session->remove('id_perkara');
		$session->remove('nomor_perkara');
		$session->remove('tgl_perkara');
		$session->remove('tgl_terima');
		// $session = new Session();
  //       $session->remove('id_perkara');
		// $session->remove('nomor_perkara');
		// $session->remove('tgl_perkara');
		// $session->remove('tgl_terima');
		
  //       $searchModel = new MsUUndangSearch();
  //       $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index'//, [
            // 'searchModel' => $searchModel,
            // 'dataProvider' => $dataProvider,
       // ]
            );

        
    }


   
}
