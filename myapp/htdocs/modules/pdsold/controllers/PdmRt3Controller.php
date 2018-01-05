<?php

namespace app\modules\pdsold\controllers;

use app\components\GlobalConstMenuComponent;
use Odf;
use Yii;
use app\modules\pdsold\models\VwTerdakwaT2;
use app\modules\pdsold\models\PdmRt3;
use yii\base\Exception;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;

class PdmRt3Controller extends Controller
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
    
    public function actionIndex()
    {
        $session        = new Session();
        $id_perkara     = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        
        $searchModel    = new PdmRt3();
        $dataProvider   = $searchModel->searchPer($no_register, Yii::$app->request->get());
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'no_register' => $no_register,
        ]);
    }
    
    public function actionRiwayat($id){
//        echo $id;exit();
        $session            = new Session();
        $id_perkara         = $session->get('id_perkara');
        $no_register        = $session->get('no_register_perkara');
        if (Yii::$app->request->isAjax){
            $searchModel = new PdmRt3;
            $dataProvider = $searchModel->getriwayat($id, $no_register);
            return $this->renderAjax('m_riwayat', ['dataProvider' => $dataProvider]);
        }
        
    }
    
}
