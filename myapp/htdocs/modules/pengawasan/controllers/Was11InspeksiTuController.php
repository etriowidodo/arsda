<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\Was11Inspeksi;
use app\modules\pengawasan\models\Was11InspeksiTuSearch;
use app\modules\pengawasan\models\Was9Inspeksi;
use app\modules\pengawasan\models\Was11InspeksiSaksiInt;
use app\modules\pengawasan\models\Was11InspeksiSaksiEks;
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
class Was11InspeksiTuController extends Controller
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

        // echo "string";
        // exit();
        $searchModel = new Was11InspeksiTuSearch();
        $dataProviderInt = $searchModel->searchInt(Yii::$app->request->queryParams);
        $dataProviderEks = $searchModel->searchEks(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProviderInt' => $dataProviderInt,
            'dataProviderEks' => $dataProviderEks,
        ]);
    }

     public function actionInsertnoint()
    {
      $connection = \Yii::$app->db;
      $query1 = "update was.was11_inspeksi set no_was_11='".$_POST['nomor']."'
        where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' 
        and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
        and id_cabjari='".$_SESSION['kode_cabjari']."'  and id_surat_was11='".$_POST['surat_was11']."' ";
      $updateinternal = $connection->createCommand($query1);
      // print_r($query1);
      // exit();
      $updateinternal->execute();
      return $this->redirect(['index']);
    } 

      public function actionInsertnoeks()
    {
      $connection = \Yii::$app->db;
      $query1 = "update was.was11_inspeksi set no_was_11='".$_POST['nomor_eks']."'
        where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' 
        and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
        and id_cabjari='".$_SESSION['kode_cabjari']."'  and id_surat_was11='".$_POST['surat_was11eks']."' ";
      $updateinternal = $connection->createCommand($query1);
      // print_r($query1);
      // exit();
      $updateinternal->execute();
      return $this->redirect(['index']);
    }

}
