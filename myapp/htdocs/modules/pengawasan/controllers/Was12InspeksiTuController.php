<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\Was12Inspeksi;
use app\modules\pengawasan\models\Was12InspeksiTuSearch;
use app\modules\pengawasan\models\Was9Inspeksi;
use app\modules\pengawasan\models\Was12InspeksiSaksiInt;
use app\modules\pengawasan\models\Was12InspeksiSaksiEks;
use app\modules\pengawasan\models\TembusanWas11Inspeksi;
use app\modules\pengawasan\models\KpInstSatker;
use app\modules\pengawasan\models\TembusanWas2;/*mengambil tembusan dari transaksi*/
use app\modules\pengawasan\models\TembusanWas;/*mengambil tembusan dari master*/
use app\modules\pengawasan\models\SaksiInternalInspeksi;/*mengambil saksi internal*/
use app\modules\pengawasan\models\SaksiEksternalInspeksi;/*mengambil saksi external*/
use app\modules\pengawasan\models\Lapdu;/*mengambil Lapdu untuk report*/
use app\modules\pengawasan\models\SpWas2;
use app\modules\pengawasan\models\DisposisiIrmud;
use app\modules\pengawasan\components\FungsiComponent; 
use app\models\KpInstSatkerSearch;
use app\models\KpPegawai;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use Odf;

use app\components\GlobalFuncComponent; 

/**
 * InspekturModelController implements the CRUD actions for InspekturModel model.
 */
class Was12InspeksiTuController extends Controller
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
     * Lists all InspekturModel models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new Was12InspeksiTuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // print_r($searchModel);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    

    public function actionInsertnomor(){
      
      $connection = \Yii::$app->db;
      $query1 = "update was.was12_inspeksi set no_surat_was12='".$_POST['nomor']."'
        where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' 
        and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
        and id_cabjari='".$_SESSION['kode_cabjari']."'  and id_was_12=".$_POST['surat_was12_ins_tu']." ";
      $updateinternal = $connection->createCommand($query1);
      print_r($query1);
      // print_r($_POST['nomor']);
      // exit();
      $updateinternal->execute();
      return $this->redirect(['index']);
    }


}
