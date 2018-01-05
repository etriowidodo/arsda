<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use Odf;
use app\modules\pengawasan\models\VLWas5;
use app\models\KpPegawai;
use app\modules\pengawasan\models\VLWas6;

/**
 * BaWas3Controller implements the CRUD actions for BaWas3 model.
 */
class DashboardController extends Controller
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
       \Yii::$app->layout = '@app/views/layouts/pengawasan/main_dashboard';
        $nip = \app\models\User::findOne(Yii::$app->user->id)->peg_nip;

$satker = (!empty(KpPegawai::find()->where('peg_nip = :pegNip',[":pegNip"=> $nip])->one()->peg_instakhir)? substr(KpPegawai::find()->where('peg_nip = :pegNip',[":pegNip"=> $nip])->one()->peg_instakhir, 0, 2) : '00');
        $model = VLWas5::find()->where('inst_satkerkd = :instSatker',[":instSatker"=>$satker])->asArray()->all();
        $model2 = VLWas6::find()->where('inst_satkerkd = :instSatker',[":instSatker"=>$satker])->asArray()->all();
        return $this->render('index',['model'=>$model,'model2'=>$model2]);
    }
    
    
      public function actionView()
    {
          
          $type = $_POST['type'];
          $view_pemberitahuan = "";
          if($type = "lwas5"){
            
        $model = VLWas5::find()->all();
          $view_pemberitahuan = $this->renderAjax('_bar1', [
            'model' => $model,
              ]);
          }else{
               $model = VLWas5::find()->all();
               $view_pemberitahuan = $this->renderAjax('_bar1', [
                'model' => $model,
                 
        ]);
          }
          $kejaksaan = array();
$total_proses = array();
$total_selesai = array();
$total_terbukti = array();
$total_tdkterbukti = array();
$total_sblmblnini = array();
$totalblnini = array();
$jmlsampaiblnini = array();
$i=0;



foreach ($model as $datamodel) {
     array_push($kejaksaan, $datamodel['inst_nama']);
     array_push($total_proses, $datamodel['total_proses']);
     array_push($total_selesai, $datamodel['total_selesai']);
     array_push($total_terbukti, $datamodel['total_terbukti']);
     array_push($total_tdkterbukti, $datamodel['total_tdkterbukti']);
     array_push($total_sblmblnini, $datamodel['total_sblmblnini']);
     array_push($totalblnini, $datamodel['total_blnini']);
     array_push($jmlsampaiblnini, $datamodel['jml_smpai_blninni']);
    /* if($i == 5){
         break;
     }*/
    $i++;
}
     //   $model2 = VLWas5::find()->asArray()->all();
             
      //   header('Content-Type: application/json; charset=utf-8');
    echo  \yii\helpers\Json::encode(['kejaksaan'=>$kejaksaan,'total_proses'=>$total_proses,'total_selesai'=>$total_selesai,'total_terbukti'=>$total_terbukti,'total_tdkterbukti'=>$total_tdkterbukti,'total_sblmblnini'=>$total_sblmblnini,'totalblnini'=>$totalblnini,'jmlsampaiblnini'=>$jmlsampaiblnini,'view_pemberitahuan'=>$view_pemberitahuan]);
     \Yii::$app->end();
        
    }
}

