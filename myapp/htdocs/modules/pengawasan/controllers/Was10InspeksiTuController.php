<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\Was10Inspeksi;
use app\modules\pengawasan\models\Was10InspeksiTuSearch;
use app\modules\pengawasan\models\LookupItem;
use app\models\KpInstSatker;
use app\models\KpInstSatkerSearch;
use app\modules\pengawasan\models\SpWas2;
use yii\grid\GridView;
use app\modules\pengawasan\models\Lapdu;
use app\modules\pengawasan\models\VSpWas2;
use app\modules\pengawasan\models\VPemeriksa;
use app\modules\pengawasan\models\VRiwayatJabatan;
use app\modules\pengawasan\models\VWas12Was10;
use app\components\GlobalFuncComponent; 
use app\modules\pengawasan\components\FungsiComponent; 
use app\models\KpPegawai;

use app\modules\pengawasan\models\PegawaiTerlaporSpWas2;
use app\modules\pengawasan\models\PegawaiTerlaporWas10Inspeksi;
use app\modules\pengawasan\models\PemeriksaSpWas2;
use app\modules\pengawasan\models\TembusanWas2;/*mengambil tembusan dari transaksi*/
use app\modules\pengawasan\models\TembusanWas;/*mengambil tembusan dari master*/
use app\components\ConstSysMenuComponent;
use app\modules\pengawasan\models\WasTrxPemrosesan;
use app\modules\pengawasan\models\DisposisiIrmud;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Odf;
use yii\db\Query;
use yii\db\Command;

/**
 * InspekturModelController implements the CRUD actions for InspekturModel model.
 */
class Was10InspeksiTuController extends Controller
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
    $session = Yii::$app->session;
        $searchModel = new Was10InspeksiTuSearch();
       // $session->remove('id_was10');
        $dataProvider = $searchModel->searchIndex(Yii::$app->request->queryParams);
        // $dataProvider->pagination->pageSize = 15;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDetail($no_register,$id_pegawai_terlapor,$nip)
    {
        $session = Yii::$app->session;
        $searchModelWas10 = new Was10InspeksiTuSearch();
        $dataProviderWas10 = $searchModelWas10->searchWas10TuGet($no_register,$id_pegawai_terlapor,$nip);

        return $this->render('detail', [
            'dataProvider' => $dataProviderWas10,
        ]);
    }

     public function actionInsertnomor()
    {
      $connection = \Yii::$app->db;
      $query1 = "update was.was10_inspeksi set no_surat='".$_POST['nomor']."'
        where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' 
        and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
        and id_cabjari='".$_SESSION['kode_cabjari']."'  and id_surat_was10='".$_POST['surat_was10_ins_tu']."' 
        and id_pegawai_terlapor='".$_POST['id_pegawai_terlapor']."' ";
      $updateinternal = $connection->createCommand($query1);
      // print_r($query1);
      // exit();
      $updateinternal->execute();
            Yii::$app->getSession()->setFlash('success', [
                    'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
                    'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                    'icon' => 'glyphicon glyphicon-ok-sign', //String
                    'message' => 'Data Berhasil Disimpan', // String
                    'title' => 'Save', //String
                    'positonY' => 'top', //String // defaults to top, allows top or bottom
                    'positonX' => 'center', //String // defaults to right, allows right, center, left
                    'showProgressbar' => true,
                ]);
      return $this->redirect(['index']);
    } 

      public function actionGetdata()
    {
      $no_register=$_POST['no_register'];
      $id_pegawai_terlapor=$_POST['id_pegawai_terlapor'];
      $nip=$_POST['nip'];
      $searchModelWas10 = new Was10InspeksiTuSearch();
      $dataProviderWas10 = $searchModelWas10->searchWas10TuGet($no_register,$id_pegawai_terlapor,$nip);
     // print_r($dataProvider);
          echo "<input type='hidden' name='Mnip' value='".$nip."' id='Mnip'>";
      echo GridView::widget([
                                'dataProvider'=> $dataProviderWas10,
                                'tableOptions' => ['class' => 'table table-striped table-bordered table-hover' , 'id' => 'nomor1'],
                                // 'filterModel' => $searchModel,
                                // 'layout' => "{items}\n{pager}",
                                'columns' => [
                                    ['header'=>'No',
                                    'headerOptions'=>['style'=>'text-align:center;'],
                                    'contentOptions'=>['style'=>'text-align:center;'],
                                    'class' => 'yii\grid\SerialColumn'],
                                    
                                    
                                    ['label'=>'No Surat',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'no_surat',
                                    ],

                                    ['label'=>'Tanggal Pemeriksaan',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'tanggal_pemeriksaan_was10',
                                    ],

                                    ['label'=>'Nama Terlapor',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nama_pegawai_terlapor',
                                    ],

                                    ['label'=>'Pemriksa',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nama_pemeriksa',
                                    ],

                                 [
                                 // 'class' => 'yii\grid\CheckboxColumn',
                                 'headerOptions'=>['style'=>'width:5%', 'class'=>'text-center'],
                                  'contentOptions'=>['class'=>'text-center '],
                                  'format'=>'raw',
                                  'header'=>'<input type="checkbox" name="Mselection_all" id="Mselection_all" />', 
                                        'value'=>function($data, $index){
                                          $result=json_encode($data);
                                            return "<input type='checkbox' name='Mselection[]' value='".$data['no_register']."' 
                                                panggilan='".$data['nip_pegawai_terlapor'].'#'.$data['id_surat_was10'].'#'.$data['no_register']."' class='Mselection_one' json='".$result."' />";
                                        },
                                    ],

                                 ],   

                            ]); 

    }
}
