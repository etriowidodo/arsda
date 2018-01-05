<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\Was10Inspeksi;
use app\modules\pengawasan\models\Was10InspeksiSearch;
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
use yii\widgets\Pjax;

/**
 * InspekturModelController implements the CRUD actions for InspekturModel model.
 */
class Was10InspeksiController extends Controller
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
        $searchModel = new Was10InspeksiSearch();
       // $session->remove('id_was10');
        $dataProvider = $searchModel->searchIndex(Yii::$app->request->queryParams);
        // $dataProvider->pagination->pageSize = 15;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

     public function actionGetdata()
    {
      $no_register=$_POST['no_register'];
      $id_pegawai_terlapor=$_POST['id_pegawai_terlapor'];
      $nip=$_POST['nip'];
      $searchModelWas10 = new Was10InspeksiSearch();
      $dataProviderWas10 = $searchModelWas10->searchWas10Get($no_register,$id_pegawai_terlapor,$nip);
     // print_r($dataProvider);
          echo "<input type='hidden' name='Mnip' value='".$nip."' id='Mnip'>";
      echo GridView::widget([
                                'dataProvider'=> $dataProviderWas10,
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

    public function actionGetttd(){
       
   $searchModelWas10 = new Was10InspeksiSearch;
   $dataProviderPenandatangan = $searchModelWas10->searchPenandatangan(Yii::$app->request->queryParams);
   Pjax::begin(['id' => 'Mpenandatangan-tambah-grid', 'timeout' => false,'formSelector' => '#searchFormPenandatangan','enablePushState' => false]); 
   echo GridView::widget([
                                'dataProvider'=> $dataProviderPenandatangan,
                                // 'filterModel' => $searchModel,
                                // 'layout' => "{items}\n{pager}",
                                'columns' => [
                                    ['header'=>'No',
                                    'headerOptions'=>['style'=>'text-align:center;'],
                                    'contentOptions'=>['style'=>'text-align:center;'],
                                    'class' => 'yii\grid\SerialColumn'],
                                    
                                    
                                    // ['label'=>'No Surat',
                                    //     'headerOptions'=>['style'=>'text-align:center;'],
                                    //     'attribute'=>'id_surat',
                                    // ],

                                    ['label'=>'Nip',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nip',
                                    ],


                                    ['label'=>'Nama Penandatangan',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nama',
                                    ],

                                    ['label'=>'Jabatan Alias',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'nama_jabatan',
                                    ],

                                    ['label'=>'Jabatan Sebenarnya',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'attribute'=>'jabtan_asli',
                                    ],

                                 ['class' => 'yii\grid\CheckboxColumn',
                                 'headerOptions'=>['style'=>'text-align:center'],
                                 'contentOptions'=>['style'=>'text-align:center; width:5%'],
                                           'checkboxOptions' => function ($data) {
                                            $result=json_encode($data);
                                            return ['value' => $data['id_surat'],'class'=>'selection_one','json'=>$result];
                                            },
                                    ],
                                    
                                 ],   

                            ]);
          Pjax::end();
          echo '<div class="modal-loading-new"></div>';
    }

     public function actionForm1()
    {
         $model = new PegawaiTerlaporWas10Inspeksi();
         $fungsi=new FungsiComponent();
         $where=$fungsi->static_where();/*karena ada perubahan kode*/         
      
         $filter_0 =" no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' 
                   and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
                   and id_cabjari='".$_SESSION['kode_cabjari']."' and trx_akhir=1 $where";
         
         $GetIdSpwas2=$fungsi->FunctGetIdSpwas2All($filter_0); 
         // print_r($GetIdSpwas2);
         // exit();   
        if ($model->load(Yii::$app->request->post())){
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
                $jml=$_POST['nip'];
        for ($i=0; $i < count($jml); $i++) { 
            $saveTerlapor = new PegawaiTerlaporWas10Inspeksi();
            // $saveTerlapor->for_tabel = 'Sp-Was-1';
            // $saveTerlapor->id_sp_was1 = 1;
            $saveTerlapor->nip_pegawai_terlapor = $_POST['nip'][$i];
            // $saveTerlapor->id_pegawai_terlapor = 1;
            $saveTerlapor->nrp_pegawai_terlapor = $_POST['nrp'][$i];
            $saveTerlapor->nama_pegawai_terlapor = $_POST['nama'][$i];
            $saveTerlapor->pangkat_pegawai_terlapor = $_POST['pangkat'][$i];
            $saveTerlapor->golongan_pegawai_terlapor = $_POST['golongan'][$i];
            $saveTerlapor->jabatan_pegawai_terlapor = $_POST['jabatan'][$i];
            $saveTerlapor->satker_pegawai_terlapor = $_POST['satker'][$i];
            $saveTerlapor->id_sp_was2 = $GetIdSpwas2['id_sp_was2'];
            $saveTerlapor->id_tingkat = $_SESSION['kode_tk'];
            $saveTerlapor->id_kejati = $_SESSION['kode_kejati'];
            $saveTerlapor->id_kejari = $_SESSION['kode_kejari'];
            $saveTerlapor->id_cabjari = $_SESSION['kode_cabjari'];
            $saveTerlapor->no_register = $_SESSION['was_register'];
            $saveTerlapor->created_ip = $_SERVER['REMOTE_ADDR'];
            $saveTerlapor->created_time = date('Y-m-d H:i:s');
            $saveTerlapor->created_by = \Yii::$app->user->identity->id;
            $saveTerlapor->id_wilayah=$_SESSION['was_id_wilayah'];
            $saveTerlapor->id_level1=$_SESSION['was_id_level1'];
            $saveTerlapor->id_level2=$_SESSION['was_id_level2'];
            $saveTerlapor->id_level3=$_SESSION['was_id_level3'];
            $saveTerlapor->id_level4=$_SESSION['was_id_level4'];
            $saveTerlapor->save();
          }
            $transaction->commit();
            return $this->redirect(['index']);
            } catch (Exception $e) {
              $transaction->rollback();
                if(YII_DEBUG){throw $e; exit;} else{return false;}
            }
        }   else {
            return $this->render('form1', [
                'model' => $model,
            ]);
        }
    }

       public function actionUpdateterlapor()
    {


        // if ($model->load(Yii::$app->request->post())){
          $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
              $jml=$_POST['Mid'];
              $sql="UPDATE was.pegawai_terlapor_was10_inspeksi
                       SET nip_pegawai_terlapor='".$_POST['Mnip']."', nrp_pegawai_terlapor='".$_POST['Mnrp']."', 
                           nama_pegawai_terlapor='".$_POST['Mnama']."', pangkat_pegawai_terlapor='".$_POST['Mpangkat']."', golongan_pegawai_terlapor='".$_POST['Mgolongan']."', 
                           jabatan_pegawai_terlapor='".$_POST['Mjabatan']."', satker_pegawai_terlapor='".$_POST['Msatker']."'
                    WHERE  id_pegawai_terlapor=".$_POST['Mid']."";
              $result_terlapor=$connection->createCommand($sql)->execute(); 
            $transaction->commit();
            return $this->redirect(['index']);
            } catch (Exception $e) {
              $transaction->rollback();
              if(YII_DEBUG){throw $e; exit;} else{return false;}
              
            }
      
    }
   

    /**
     * Displays a single InspekturModel model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new InspekturModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($nip)
    {
        $var=str_split($_SESSION['is_inspektur_irmud_riksa']);

      $model = new Was10Inspeksi();
      $fungsi=new FungsiComponent();
      $where=$fungsi->static_where();/*karena ada perubahan kode*/         
      
      $filter_0 =" no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' 
                   and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
                   and id_cabjari='".$_SESSION['kode_cabjari']."' and trx_akhir=1 $where";
      $spWas2   =$fungsi->FunctGetIdSpwas2All($filter_0);

      $Fungsi   =new GlobalFuncComponent();
      $table    ='sp_was_2';
      $filed    ='tanggal_akhir_sp_was2';
      $filter_1 =" no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' 
                   and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
                   and id_cabjari='".$_SESSION['kode_cabjari']."' and tanggal_akhir_sp_was2 is not null $where";
      $result_expire  =$Fungsi->CekExpire($table,$filed,$filter_1);

      // $FungsiWas      =new FungsiComponent();
      $filter_2  =" no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' 
                    and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
                    and id_cabjari='".$_SESSION['kode_cabjari']."' and trx_akhir=1 $where";
      $getId     =$fungsi->FunctGetIdSpwas2($filter_2);

      $modelTembusanMaster = TembusanWas::find()->where("for_tabel=:condition1 OR for_tabel=:condition2", [":condition1" => 'was_10_inspeksi','condition2'=>'master'])->all();
      
        if ($model->load(Yii::$app->request->post())) {
      $pegawai_terlapor=PegawaiTerlaporWas10Inspeksi::findOne(['nip_pegawai_terlapor'=>$model->nip_pegawai_terlapor]);
      $pegawai_pemeriksa=PemeriksaSpWas2::findOne(['nip_pemeriksa'=>$model->nip_pemeriksa]);
      $pegawai_penandatangan=KpPegawai::findOne(['peg_nip_baru'=>$model->nip_penandatangan]);

      $errors       = array();
      $file_name    = $_FILES['was10_file']['name'];
      $file_size    =$_FILES['was10_file']['size'];
      $file_tmp     =$_FILES['was10_file']['tmp_name'];
      $file_type    =$_FILES['was10_file']['type'];
      $ext = pathinfo($file_name, PATHINFO_EXTENSION);
      $tmp = explode('.', $_FILES['was10_file']['name']);
      $file_exists = end($tmp);
      $rename_file  =$_SESSION['is_inspektur_irmud_riksa'].'_'.$_SESSION['inst_satkerkd'].$res.'.'.$ext;
      
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
                $model->id_tingkat = $_SESSION['kode_tk'];
                $model->id_kejati  = $_SESSION['kode_kejati'];
                $model->id_kejari  = $_SESSION['kode_kejari'];
                $model->id_cabjari = $_SESSION['kode_cabjari'];
                $model->no_register= $_SESSION['was_register'];
                $model->id_sp_was2 = $getId['id_sp_was2'];
                $model->created_ip = $_SERVER['REMOTE_ADDR'];
                $model->created_time = date('Y-m-d H:i:s');
                $model->created_by = \Yii::$app->user->identity->id;
                $model->id_pegawai_terlapor   = $pegawai_terlapor['id_pegawai_terlapor'];
                $model->nama_pegawai_terlapor = $pegawai_terlapor['nama_pegawai_terlapor'];
                $model->pangkat_pegawai_terlapor  = $pegawai_terlapor['pangkat_pegawai_terlapor'];
                $model->golongan_pegawai_terlapor = $pegawai_terlapor['golongan_pegawai_terlapor'];
                $model->jabatan_pegawai_terlapor  = $pegawai_terlapor['jabatan_pegawai_terlapor'];
                $model->satker_pegawai_terlapor   = $pegawai_terlapor['satker_pegawai_terlapor'];
                $model->id_pemeriksa    = $pegawai_pemeriksa['id_pemeriksa_sp_was2'];
                $model->nrp_pemeriksa   = $pegawai_pemeriksa['nrp_pemeriksa'];
                $model->nama_pemeriksa  = $pegawai_pemeriksa['nama_pemeriksa'];
                $model->satker_pemeriksaan = $pegawai_pemeriksa['nama_pemeriksa'];
                $model->pangkat_pemeriksa  = $pegawai_pemeriksa['pangkat_pemeriksa'];
                $model->jabatan_pemeriksa  = $pegawai_pemeriksa['jabatan_pemeriksa'];
                $model->golongan_pemeriksa = $pegawai_pemeriksa['golongan_pemeriksa'];
                $model->pangkat_penandatangan = $pegawai_penandatangan['gol_pangkat2'];
                $model->golongan_penandatangan = $pegawai_penandatangan['gol_kd'];
                $model->jbtn_penandatangan = $pegawai_penandatangan['jabatan'];
                $model->jam_pemeriksaan_was10 = $_POST['jam_pemeriksaan_was10'];
                
            if($model->save()){
            
                 $pejabat = $_POST['pejabat'];
                 for($z=0;$z<count($pejabat);$z++){
                        $saveTembusan = new TembusanWas2;
                        $saveTembusan->from_table = 'Was-10-inspeksi';
                        $saveTembusan->pk_in_table = strrev($model->id_surat_was10);
                        $saveTembusan->tembusan = $_POST['pejabat'][$z];
                        $saveTembusan->created_ip = $_SERVER['REMOTE_ADDR'];
                        $saveTembusan->created_time = date('Y-m-d H:i:s');
                        $saveTembusan->created_by = \Yii::$app->user->identity->id;
                        // $saveTembusan->inst_satkerkd = $_SESSION['inst_satkerkd'];s
                        $saveTembusan->no_register = $_SESSION['was_register'];
                        $saveTembusan->id_tingkat = $_SESSION['kode_tk'];
                        $saveTembusan->id_kejati = $_SESSION['kode_kejati'];
                        $saveTembusan->id_kejari = $_SESSION['kode_kejari'];
                        $saveTembusan->id_cabjari = $_SESSION['kode_cabjari'];
                        $saveTembusan->is_inspektur_irmud_riksa = $_SESSION['is_inspektur_irmud_riksa'];
                        $saveTembusan->id_wilayah=$_SESSION['was_id_wilayah'];
                        $saveTembusan->id_level1=$_SESSION['was_id_level1'];
                        $saveTembusan->id_level2=$_SESSION['was_id_level2'];
                        $saveTembusan->id_level3=$_SESSION['was_id_level3'];
                        $saveTembusan->id_level4=$_SESSION['was_id_level4'];
                        $saveTembusan->save();
                    }
          $arr = array(ConstSysMenuComponent::Was13inspek, ConstSysMenuComponent::Bawas3inspek, ConstSysMenuComponent::Was12inspek);
                  
                          // WasTrxPemrosesan::deleteAll(["no_register='".$_SESSION['was_register']."'
                          //    AND id_sys_menu='3545' and id_wilayah=1 and id_level1 =6 
                          //    and id_level2 =1 and id_level3 =2 and id_level4 =0"]);

               // $sql="delete from was.was_trx_pemrosesan where no_register='".$_SESSION['was_register']."'
               //               AND id_sys_menu='3545' and id_wilayah=1 and id_level1 =6 
               //               and id_level2 =1 and id_level3 =2 and id_level4 =0";           
                          
                          // WasTrxPemrosesan::deleteAll(["no_register='".$_SESSION['was_register']."'
                          //    AND id_sys_menu='3545' and id_wilayah=1 and id_level1 =6 
                          //    and id_level2 =1 and id_level3 =0 and id_level4 =0"]);

          if($model->jbtn_penandatangan == 'Jaksa Agung Muda PENGAWASAN'){    
                            $modelTrxPemrosesan1=new WasTrxPemrosesan();
                            $modelTrxPemrosesan1->no_register=$_SESSION['was_register'];
                            $modelTrxPemrosesan1->id_sys_menu='3545';
                            $modelTrxPemrosesan1->id_user_login=$_SESSION['username'];
                            $modelTrxPemrosesan1->durasi=date('Y-m-d H:i:s');
                            $modelTrxPemrosesan1->created_by=\Yii::$app->user->identity->id;
                            $modelTrxPemrosesan1->created_ip=$_SERVER['REMOTE_ADDR'];
                            $modelTrxPemrosesan1->created_time=date('Y-m-d H:i:s');
                            $modelTrxPemrosesan1->updated_ip=$_SERVER['REMOTE_ADDR'];
                            $modelTrxPemrosesan1->updated_by=\Yii::$app->user->identity->id;
                            $modelTrxPemrosesan1->updated_time=date('Y-m-d H:i:s');
                            $modelTrxPemrosesan1->user_id=$_SESSION['is_inspektur_irmud_riksa'];
                            $modelTrxPemrosesan1->id_wilayah='1';
                            $modelTrxPemrosesan1->id_level1 ='6';
                            $modelTrxPemrosesan1->id_level2 ='1';
                            $modelTrxPemrosesan1->id_level3 ='2';
                            $modelTrxPemrosesan1->id_level4 ='0';
                            $modelTrxPemrosesan1->save();
                       }else if($model->jbtn_penandatangan == 'Sekretaris JAM PENGAWASAN'){
                            $modelTrxPemrosesan2=new WasTrxPemrosesan();
                            $modelTrxPemrosesan2->no_register=$_SESSION['was_register'];
                            $modelTrxPemrosesan2->id_sys_menu='3545';
                            $modelTrxPemrosesan2->id_user_login=$_SESSION['username'];
                            $modelTrxPemrosesan2->durasi=date('Y-m-d H:i:s');
                            $modelTrxPemrosesan2->created_by=\Yii::$app->user->identity->id;
                            $modelTrxPemrosesan2->created_ip=$_SERVER['REMOTE_ADDR'];
                            $modelTrxPemrosesan2->created_time=date('Y-m-d H:i:s');
                            $modelTrxPemrosesan2->updated_ip=$_SERVER['REMOTE_ADDR'];
                            $modelTrxPemrosesan2->updated_by=\Yii::$app->user->identity->id;
                            $modelTrxPemrosesan2->updated_time=date('Y-m-d H:i:s');
                            $modelTrxPemrosesan2->user_id=$_SESSION['is_inspektur_irmud_riksa'];
                            $modelTrxPemrosesan2->id_wilayah='1';
                            $modelTrxPemrosesan2->id_level1 ='6';
                            $modelTrxPemrosesan2->id_level2 ='1';
                            $modelTrxPemrosesan2->id_level3 ='0';
                            $modelTrxPemrosesan2->id_level4 ='0';
                            $modelTrxPemrosesan2->save();
                       }else if($model->jbtn_penandatangan == 'Inspektur I '){
                         // WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
                           // AND id_sys_menu='3545' and id_wilayah='1' and id_level1 ='6' 
                           // and id_level2 ='1' and id_level3 ='0' and id_level4 ='0'");
                          $modelTrxPemrosesan1=new WasTrxPemrosesan();
                          $modelTrxPemrosesan1->no_register=$_SESSION['was_register'];
                          $modelTrxPemrosesan1->id_sys_menu='3543';
                          $modelTrxPemrosesan1->id_user_login=$_SESSION['username'];
                          $modelTrxPemrosesan1->durasi=date('Y-m-d H:i:s');
                          $modelTrxPemrosesan1->created_by=\Yii::$app->user->identity->id;
                          $modelTrxPemrosesan1->created_ip=$_SERVER['REMOTE_ADDR'];
                          $modelTrxPemrosesan1->created_time=date('Y-m-d H:i:s');
                          $modelTrxPemrosesan1->updated_ip=$_SERVER['REMOTE_ADDR'];
                          $modelTrxPemrosesan1->updated_by=\Yii::$app->user->identity->id;
                          $modelTrxPemrosesan1->updated_time=date('Y-m-d H:i:s');
                          $modelTrxPemrosesan1->user_id=$_SESSION['is_inspektur_irmud_riksa'];
                          $modelTrxPemrosesan1->id_wilayah='1';
                          $modelTrxPemrosesan1->id_level1 ='6';
                          $modelTrxPemrosesan1->id_level2 ='8';
                          $modelTrxPemrosesan1->id_level3 ='0';
                          $modelTrxPemrosesan1->id_level4 ='0';
                          $modelTrxPemrosesan1->save();
                         }else if($model->jbtn_penandatangan == 'Inspektur II'){
                           // WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
                           // AND id_sys_menu='3545' and id_wilayah='1' and id_level1 ='6' 
                           // and id_level2 ='1' and id_level3 ='0' and id_level4 ='0'");
                          $modelTrxPemrosesan1=new WasTrxPemrosesan();
                          $modelTrxPemrosesan1->no_register=$_SESSION['was_register'];
                          $modelTrxPemrosesan1->id_sys_menu='3543';
                          $modelTrxPemrosesan1->id_user_login=$_SESSION['username'];
                          $modelTrxPemrosesan1->durasi=date('Y-m-d H:i:s');
                          $modelTrxPemrosesan1->created_by=\Yii::$app->user->identity->id;
                          $modelTrxPemrosesan1->created_ip=$_SERVER['REMOTE_ADDR'];
                          $modelTrxPemrosesan1->created_time=date('Y-m-d H:i:s');
                          $modelTrxPemrosesan1->updated_ip=$_SERVER['REMOTE_ADDR'];
                          $modelTrxPemrosesan1->updated_by=\Yii::$app->user->identity->id;
                          $modelTrxPemrosesan1->updated_time=date('Y-m-d H:i:s');
                          $modelTrxPemrosesan1->user_id=$_SESSION['is_inspektur_irmud_riksa'];
                          $modelTrxPemrosesan1->id_wilayah='1';
                          $modelTrxPemrosesan1->id_level1 ='6';
                          $modelTrxPemrosesan1->id_level2 ='9';
                          $modelTrxPemrosesan1->id_level3 ='0';
                          $modelTrxPemrosesan1->id_level4 ='0';
                          $modelTrxPemrosesan1->save();
                         }else if($model->jbtn_penandatangan == 'Inspektur III'){
                           // WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
                           // AND id_sys_menu='3545' and id_wilayah='1' and id_level1 ='6' 
                           // and id_level2 ='1' and id_level3 ='0' and id_level4 ='0'");
                          $modelTrxPemrosesan1=new WasTrxPemrosesan();
                          $modelTrxPemrosesan1->no_register=$_SESSION['was_register'];
                          $modelTrxPemrosesan1->id_sys_menu='3543';
                          $modelTrxPemrosesan1->id_user_login=$_SESSION['username'];
                          $modelTrxPemrosesan1->durasi=date('Y-m-d H:i:s');
                          $modelTrxPemrosesan1->created_by=\Yii::$app->user->identity->id;
                          $modelTrxPemrosesan1->created_ip=$_SERVER['REMOTE_ADDR'];
                          $modelTrxPemrosesan1->created_time=date('Y-m-d H:i:s');
                          $modelTrxPemrosesan1->updated_ip=$_SERVER['REMOTE_ADDR'];
                          $modelTrxPemrosesan1->updated_by=\Yii::$app->user->identity->id;
                          $modelTrxPemrosesan1->updated_time=date('Y-m-d H:i:s');
                          $modelTrxPemrosesan1->user_id=$_SESSION['is_inspektur_irmud_riksa'];
                          $modelTrxPemrosesan1->id_wilayah='1';
                          $modelTrxPemrosesan1->id_level1 ='6';
                          $modelTrxPemrosesan1->id_level2 ='10';
                          $modelTrxPemrosesan1->id_level3 ='0';
                          $modelTrxPemrosesan1->id_level4 ='0';
                          $modelTrxPemrosesan1->save();
                         }else if($model->jbtn_penandatangan == 'Inspektur IV'){
                           // WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
                           // AND id_sys_menu='3545' and id_wilayah='1' and id_level1 ='6' 
                           // and id_level2 ='1' and id_level3 ='0' and id_level4 ='0'");
                          $modelTrxPemrosesan1=new WasTrxPemrosesan();
                          $modelTrxPemrosesan1->no_register=$_SESSION['was_register'];
                          $modelTrxPemrosesan1->id_sys_menu='3543';
                          $modelTrxPemrosesan1->id_user_login=$_SESSION['username'];
                          $modelTrxPemrosesan1->durasi=date('Y-m-d H:i:s');
                          $modelTrxPemrosesan1->created_by=\Yii::$app->user->identity->id;
                          $modelTrxPemrosesan1->created_ip=$_SERVER['REMOTE_ADDR'];
                          $modelTrxPemrosesan1->created_time=date('Y-m-d H:i:s');
                          $modelTrxPemrosesan1->updated_ip=$_SERVER['REMOTE_ADDR'];
                          $modelTrxPemrosesan1->updated_by=\Yii::$app->user->identity->id;
                          $modelTrxPemrosesan1->updated_time=date('Y-m-d H:i:s');
                          $modelTrxPemrosesan1->user_id=$_SESSION['is_inspektur_irmud_riksa'];
                          $modelTrxPemrosesan1->id_wilayah='1';
                          $modelTrxPemrosesan1->id_level1 ='6';
                          $modelTrxPemrosesan1->id_level2 ='11';
                          $modelTrxPemrosesan1->id_level3 ='0';
                          $modelTrxPemrosesan1->id_level4 ='0';
                          $modelTrxPemrosesan1->save();
                         }else if($model->jbtn_penandatangan == 'Inspektur V'){
                           // WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
                           // AND id_sys_menu='3545' and id_wilayah='1' and id_level1 ='6' 
                           // and id_level2 ='1' and id_level3 ='0' and id_level4 ='0'");
                          $modelTrxPemrosesan1=new WasTrxPemrosesan();
                          $modelTrxPemrosesan1->no_register=$_SESSION['was_register'];
                          $modelTrxPemrosesan1->id_sys_menu='3543';
                          $modelTrxPemrosesan1->id_user_login=$_SESSION['username'];
                          $modelTrxPemrosesan1->durasi=date('Y-m-d H:i:s');
                          $modelTrxPemrosesan1->created_by=\Yii::$app->user->identity->id;
                          $modelTrxPemrosesan1->created_ip=$_SERVER['REMOTE_ADDR'];
                          $modelTrxPemrosesan1->created_time=date('Y-m-d H:i:s');
                          $modelTrxPemrosesan1->updated_ip=$_SERVER['REMOTE_ADDR'];
                          $modelTrxPemrosesan1->updated_by=\Yii::$app->user->identity->id;
                          $modelTrxPemrosesan1->updated_time=date('Y-m-d H:i:s');
                          $modelTrxPemrosesan1->user_id=$_SESSION['is_inspektur_irmud_riksa'];
                          $modelTrxPemrosesan1->id_wilayah='1';
                          $modelTrxPemrosesan1->id_level1 ='6';
                          $modelTrxPemrosesan1->id_level2 ='12';
                          $modelTrxPemrosesan1->id_level3 ='0';
                          $modelTrxPemrosesan1->id_level4 ='0';
                          $modelTrxPemrosesan1->save();
                         }



                    for ($i=0; $i < 3 ; $i++) { 
                      WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."' AND id_sys_menu='".$arr[$i]."' AND user_id='".$_SESSION['is_inspektur_irmud_riksa']."'");
                      $modelTrxPemrosesan=new WasTrxPemrosesan();
                      $modelTrxPemrosesan->no_register=$_SESSION['was_register'];
                      $modelTrxPemrosesan->id_sys_menu=$arr[$i];
                      $modelTrxPemrosesan->id_user_login=$_SESSION['username'];
                      $modelTrxPemrosesan->durasi=date('Y-m-d H:i:s');
                      $modelTrxPemrosesan->created_by=\Yii::$app->user->identity->id;
                      $modelTrxPemrosesan->created_ip=$_SERVER['REMOTE_ADDR'];
                      $modelTrxPemrosesan->created_time=date('Y-m-d H:i:s');
                      $modelTrxPemrosesan->updated_ip=$_SERVER['REMOTE_ADDR'];
                      $modelTrxPemrosesan->updated_by=\Yii::$app->user->identity->id;
                      $modelTrxPemrosesan->updated_time=date('Y-m-d H:i:s');
                      $modelTrxPemrosesan->user_id=$_SESSION['is_inspektur_irmud_riksa'];
                      $modelTrxPemrosesan->id_wilayah=$_SESSION['was_id_wilayah'];
                      $modelTrxPemrosesan->id_level1=$_SESSION['was_id_level1'];
                      $modelTrxPemrosesan->id_level2=$_SESSION['was_id_level2'];
                      $modelTrxPemrosesan->id_level3=$_SESSION['was_id_level3'];
                      $modelTrxPemrosesan->id_level4=$_SESSION['was_id_level4'];
                      $modelTrxPemrosesan->save();
                      // }
                    }
                    
            $transaction->commit();
            
            
            Yii::$app->getSession()->setFlash('success', [
             'type' => 'success',
             'duration' => 3000,
             'icon' => 'fa fa-users',
             'message' => 'Data Berhasil di Simpan',
             'title' => 'Simpan Data',
             'positonY' => 'top',
             'positonX' => 'center',
             'showProgressbar' => true,
             ]);
             return $this->redirect(['index']);
             
            }
            
            else{
             Yii::$app->getSession()->setFlash('success', [
             'type' => 'danger',
             'duration' => 3000,
             'icon' => 'fa fa-users',
             'message' => 'Data Gagal di Simpan',
             'title' => 'Error',
             'positonY' => 'top',
             'positonX' => 'center',
             'showProgressbar' => true,
             ]);
               return $this->redirect(['create']);
            }
            
            
            } catch(Exception $e) {
                    $transaction->rollback();
                    if(YII_DEBUG){throw $e; exit;} else{return false;}
            }
            
        } else {
            return $this->render('create', [
                'model' => $model,
                'spWas2' => $spWas2,
                'result_expire' => $result_expire,
                'modelTembusanMaster' => $modelTembusanMaster,
                
            ]);
        }
        
    }

    /**
     * Updates an existing InspekturModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
   public function actionUpdate($id,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari,$id_was10)
    {
        $var=str_split($_SESSION['is_inspektur_irmud_riksa']);
    /*random kode*/
    $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $res = "";
    for ($i = 0; $i < 10; $i++) {
        $res .= $chars[mt_rand(0, strlen($chars)-1)];
    }

    $model = $this->findModel($id,$id_was10);
    $modelTembusan=TembusanWas2::find()->where(['pk_in_table'=>$id_was10,'from_table'=>'Was-10-inspeksi','no_register'=>$id,'id_tingkat'=>$id_tingkat,'id_kejati'=>$id_kejati,'id_kejari'=>$id_kejari,'id_cabjari'=>$id_cabjari,'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']])->orderBy('is_order desc')->all();
      
      $fungsi   =new FungsiComponent();
      $where    =$fungsi->static_where();
      $Fungsi         =new GlobalFuncComponent();
      $table          ='sp_was_2';
      $filed          ='tanggal_akhir_sp_was2';
      $filter_1       ="no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and trx_akhir=1 $where";
      $result_expire  =$Fungsi->CekExpire($table,$filed,$filter_1);

      // $fungsi=new FungsiComponent();
          $is_inspektur_irmud_riksa=$fungsi->gabung_where();/*karena ada perubahan kode*/  
          $OldFile=$model->was10_file;
      $filter_0      =" no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and trx_akhir=1 $where";
      $spWas2         =$fungsi->FunctGetIdSpwas2All($filter_0);
     
    
        if ($model->load(Yii::$app->request->post())) {
              $pegawai_terlapor=PegawaiTerlaporWas10Inspeksi::findOne(['nip_pegawai_terlapor'=>$model->nip_pegawai_terlapor]);
              $pegawai_pemeriksa=PemeriksaSpWas2::findOne(['nip_pemeriksa'=>$model->nip_pemeriksa]);
              $pegawai_penandatangan=KpPegawai::findOne(['peg_nip_baru'=>$model->nip_penandatangan]);

              $errors       = array();
              $file_name    = $_FILES['was10_file']['name'];
              $file_size    =$_FILES['was10_file']['size'];
              $file_tmp     =$_FILES['was10_file']['tmp_name'];
              $file_type    =$_FILES['was10_file']['type'];
              $ext = pathinfo($file_name, PATHINFO_EXTENSION);
              $tmp = explode('.', $_FILES['was10_file']['name']);
              $file_exists = end($tmp);
              $rename_file  =$is_inspektur_irmud_riksa.'_'.$_SESSION['inst_satkerkd'].'_'.$res.'.'.$ext;

                  $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {


                $model->updated_ip   = $_SERVER['REMOTE_ADDR'];
                $model->updated_time = date('Y-m-d H:i:s');
                $model->updated_by   = \Yii::$app->user->identity->id;
              //  $model->id_pegawai_terlapor = $pegawai_terlapor['id_pegawai_terlapor'];
                $model->nama_pegawai_terlapor     = $pegawai_terlapor['nama_pegawai_terlapor'];
                $model->pangkat_pegawai_terlapor  = $pegawai_terlapor['pangkat_pegawai_terlapor'];
                $model->golongan_pegawai_terlapor = $pegawai_terlapor['golongan_pegawai_terlapor'];
                $model->jabatan_pegawai_terlapor  = $pegawai_terlapor['jabatan_pegawai_terlapor'];
                $model->satker_pegawai_terlapor   = $pegawai_terlapor['satker_pegawai_terlapor'];
                $model->id_pemeriksa    = $pegawai_pemeriksa['id_pemeriksa_sp_was2'];
                $model->nrp_pemeriksa   = $pegawai_pemeriksa['nrp_pemeriksa'];
                $model->nama_pemeriksa  = $pegawai_pemeriksa['nama_pemeriksa'];
                $model->pangkat_pemeriksa = $pegawai_pemeriksa['pangkat_pemeriksa'];
                $model->jabatan_pemeriksa = $pegawai_pemeriksa['jabatan_pemeriksa'];
                $model->golongan_pemeriksa= $pegawai_pemeriksa['golongan_pemeriksa'];
                $model->pangkat_penandatangan  = $pegawai_penandatangan['gol_pangkat2'];
                $model->golongan_penandatangan = $pegawai_penandatangan['gol_kd'];
                $model->jbtn_penandatangan     = $pegawai_penandatangan['jabatan'];
                $model->jam_pemeriksaan_was10  = $_POST['jam_pemeriksaan_was10'];
                $model->was10_file = ($file_name==''?$OldFile:$rename_file);
      if($model->save()){
      if($OldFile!='' && file_exists($file_tmp) && file_exists(\Yii::$app->params['uploadPath'].'was_10_inspeksi/'.$OldFile)) {
          unlink(\Yii::$app->params['uploadPath'].'was_10_inspeksi/'.$OldFile);
      } 
        
      
              TembusanWas2::deleteAll(['from_table'=>'Was-10-inspeksi','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'pk_in_table'=>$model->id_surat_was10,'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
                       $pejabat = $_POST['pejabat'];
                       for($z=0;$z<count($pejabat);$z++){
                      $saveTembusan = new TembusanWas2;
                      $saveTembusan->from_table = 'Was-10-inspeksi';
                      $saveTembusan->pk_in_table = strrev($model->id_surat_was10);
                      $saveTembusan->tembusan = $_POST['pejabat'][$z];
                      $saveTembusan->created_ip = $_SERVER['REMOTE_ADDR'];
                      $saveTembusan->created_time = date('Y-m-d H:i:s');
                      $saveTembusan->created_by = \Yii::$app->user->identity->id;
                      // $saveTembusan->inst_satkerkd = $_SESSION['inst_satkerkd'];s
                      $saveTembusan->no_register = $_SESSION['was_register'];
                      $saveTembusan->id_tingkat = $_SESSION['kode_tk'];
                      $saveTembusan->id_kejati = $_SESSION['kode_kejati'];
                      $saveTembusan->id_kejari = $_SESSION['kode_kejari'];
                      $saveTembusan->id_cabjari = $_SESSION['kode_cabjari'];
                      $saveTembusan->is_inspektur_irmud_riksa = $_SESSION['is_inspektur_irmud_riksa'];
                      $saveTembusan->id_wilayah=$_SESSION['was_id_wilayah'];
                      $saveTembusan->id_level1=$_SESSION['was_id_level1'];
                      $saveTembusan->id_level2=$_SESSION['was_id_level2'];
                      $saveTembusan->id_level3=$_SESSION['was_id_level3'];
                      $saveTembusan->id_level4=$_SESSION['was_id_level4'];
                      $saveTembusan->save();
                  }


                    $arr = array(ConstSysMenuComponent::Was13inspek, ConstSysMenuComponent::Bawas3inspek, ConstSysMenuComponent::Was12inspek);
                    for ($i=0; $i < 3 ; $i++) { 
                      WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."' AND id_sys_menu='".$arr[$i]."' AND user_id='".$_SESSION['is_inspektur_irmud_riksa']."'");
                      $modelTrxPemrosesan=new WasTrxPemrosesan();
                      $modelTrxPemrosesan->no_register=$_SESSION['was_register'];
                      $modelTrxPemrosesan->id_sys_menu=$arr[$i];
                      $modelTrxPemrosesan->id_user_login=$_SESSION['username'];
                      $modelTrxPemrosesan->durasi=date('Y-m-d H:i:s');
                      $modelTrxPemrosesan->created_by=\Yii::$app->user->identity->id;
                      $modelTrxPemrosesan->created_ip=$_SERVER['REMOTE_ADDR'];
                      $modelTrxPemrosesan->created_time=date('Y-m-d H:i:s');
                      $modelTrxPemrosesan->updated_ip=$_SERVER['REMOTE_ADDR'];
                      $modelTrxPemrosesan->updated_by=\Yii::$app->user->identity->id;
                      $modelTrxPemrosesan->updated_time=date('Y-m-d H:i:s');
                      $modelTrxPemrosesan->user_id=$_SESSION['is_inspektur_irmud_riksa'];
                      $modelTrxPemrosesan->id_wilayah=$_SESSION['was_id_wilayah'];
                      $modelTrxPemrosesan->id_level1=$_SESSION['was_id_level1'];
                      $modelTrxPemrosesan->id_level2=$_SESSION['was_id_level2'];
                      $modelTrxPemrosesan->id_level3=$_SESSION['was_id_level3'];
                      $modelTrxPemrosesan->id_level4=$_SESSION['was_id_level4'];
                      $modelTrxPemrosesan->save();
                      // }
                    }

               // $sql="delete from was.was_trx_pemrosesan where no_register='".$_SESSION['was_register']."'
               //               AND id_sys_menu='3545' and id_wilayah=1 and id_level1 =6 
               //               and id_level2 =1 and id_level3 =2 and id_level4 =0";           
                          
                     WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
                             AND id_sys_menu='3545' and id_wilayah='1' and id_level1 ='6' 
                             and id_level2 ='1' and id_level3 ='2' and id_level4 ='0'");
                          
                      WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
                             AND id_sys_menu='3545' and id_wilayah='1' and id_level1 ='6' 
                             and id_level2 ='1' and id_level3 ='0' and id_level4 ='0'");

                      WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
                             AND id_sys_menu='3545' and id_wilayah='1' and id_level1 ='6' 
                             and id_level2 ='8' and id_level3 ='0' and id_level4 ='0'");

                      WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
                             AND id_sys_menu='3545' and id_wilayah='1' and id_level1 ='6' 
                             and id_level2 ='9' and id_level3 ='0' and id_level4 ='0'");

                      WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
                             AND id_sys_menu='3545' and id_wilayah='1' and id_level1 ='6' 
                             and id_level2 ='10' and id_level3 ='0' and id_level4 ='0'");

                      WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
                             AND id_sys_menu='3545' and id_wilayah='1' and id_level1 ='6' 
                             and id_level2 ='11' and id_level3 ='0' and id_level4 ='0'");

                      WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
                             AND id_sys_menu='3545' and id_wilayah='1' and id_level1 ='6' 
                             and id_level2 ='12' and id_level3 ='0' and id_level4 ='0'");

                  if($model->jbtn_penandatangan == 'Jaksa Agung Muda PENGAWASAN'){    
                          // WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
                          //    AND id_sys_menu='3545' and id_wilayah='1' and id_level1 ='6' 
                          //    and id_level2 ='1' and id_level3 ='2' and id_level4 ='0'");
                            $modelTrxPemrosesan1=new WasTrxPemrosesan();
                            $modelTrxPemrosesan1->no_register=$_SESSION['was_register'];
                            $modelTrxPemrosesan1->id_sys_menu='3545';
                            $modelTrxPemrosesan1->id_user_login=$_SESSION['username'];
                            $modelTrxPemrosesan1->durasi=date('Y-m-d H:i:s');
                            $modelTrxPemrosesan1->created_by=\Yii::$app->user->identity->id;
                            $modelTrxPemrosesan1->created_ip=$_SERVER['REMOTE_ADDR'];
                            $modelTrxPemrosesan1->created_time=date('Y-m-d H:i:s');
                            $modelTrxPemrosesan1->updated_ip=$_SERVER['REMOTE_ADDR'];
                            $modelTrxPemrosesan1->updated_by=\Yii::$app->user->identity->id;
                            $modelTrxPemrosesan1->updated_time=date('Y-m-d H:i:s');
                            $modelTrxPemrosesan1->user_id=$_SESSION['is_inspektur_irmud_riksa'];
                            $modelTrxPemrosesan1->id_wilayah='1';
                            $modelTrxPemrosesan1->id_level1 ='6';
                            $modelTrxPemrosesan1->id_level2 ='1';
                            $modelTrxPemrosesan1->id_level3 ='2';
                            $modelTrxPemrosesan1->id_level4 ='0';
                            $modelTrxPemrosesan1->save();
                       }else if($model->jbtn_penandatangan == 'Sekretaris JAM PENGAWASAN'){
                             // WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
                             // AND id_sys_menu='3545' and id_wilayah='1' and id_level1 ='6' 
                             // and id_level2 ='1' and id_level3 ='0' and id_level4 ='0'");
                            $modelTrxPemrosesan1=new WasTrxPemrosesan();
                            $modelTrxPemrosesan1->no_register=$_SESSION['was_register'];
                            $modelTrxPemrosesan1->id_sys_menu='3545';
                            $modelTrxPemrosesan1->id_user_login=$_SESSION['username'];
                            $modelTrxPemrosesan1->durasi=date('Y-m-d H:i:s');
                            $modelTrxPemrosesan1->created_by=\Yii::$app->user->identity->id;
                            $modelTrxPemrosesan1->created_ip=$_SERVER['REMOTE_ADDR'];
                            $modelTrxPemrosesan1->created_time=date('Y-m-d H:i:s');
                            $modelTrxPemrosesan1->updated_ip=$_SERVER['REMOTE_ADDR'];
                            $modelTrxPemrosesan1->updated_by=\Yii::$app->user->identity->id;
                            $modelTrxPemrosesan1->updated_time=date('Y-m-d H:i:s');
                            $modelTrxPemrosesan1->user_id=$_SESSION['is_inspektur_irmud_riksa'];
                            $modelTrxPemrosesan1->id_wilayah='1';
                            $modelTrxPemrosesan1->id_level1 ='6';
                            $modelTrxPemrosesan1->id_level2 ='1';
                            $modelTrxPemrosesan1->id_level3 ='0';
                            $modelTrxPemrosesan1->id_level4 ='0';
                            $modelTrxPemrosesan1->save();
                       }else if($model->jbtn_penandatangan == 'Inspektur I '){
                             // WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
                             // AND id_sys_menu='3545' and id_wilayah='1' and id_level1 ='6' 
                             // and id_level2 ='1' and id_level3 ='0' and id_level4 ='0'");
                            $modelTrxPemrosesan1=new WasTrxPemrosesan();
                            $modelTrxPemrosesan1->no_register=$_SESSION['was_register'];
                            $modelTrxPemrosesan1->id_sys_menu='3545';
                            $modelTrxPemrosesan1->id_user_login=$_SESSION['username'];
                            $modelTrxPemrosesan1->durasi=date('Y-m-d H:i:s');
                            $modelTrxPemrosesan1->created_by=\Yii::$app->user->identity->id;
                            $modelTrxPemrosesan1->created_ip=$_SERVER['REMOTE_ADDR'];
                            $modelTrxPemrosesan1->created_time=date('Y-m-d H:i:s');
                            $modelTrxPemrosesan1->updated_ip=$_SERVER['REMOTE_ADDR'];
                            $modelTrxPemrosesan1->updated_by=\Yii::$app->user->identity->id;
                            $modelTrxPemrosesan1->updated_time=date('Y-m-d H:i:s');
                            $modelTrxPemrosesan1->user_id=$_SESSION['is_inspektur_irmud_riksa'];
                            $modelTrxPemrosesan1->id_wilayah='1';
                            $modelTrxPemrosesan1->id_level1 ='6';
                            $modelTrxPemrosesan1->id_level2 ='8';
                            $modelTrxPemrosesan1->id_level3 ='0';
                            $modelTrxPemrosesan1->id_level4 ='0';
                            $modelTrxPemrosesan1->save();
                       }else if($model->jbtn_penandatangan == 'Inspektur II'){
                             // WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
                             // AND id_sys_menu='3545' and id_wilayah='1' and id_level1 ='6' 
                             // and id_level2 ='1' and id_level3 ='0' and id_level4 ='0'");
                            $modelTrxPemrosesan1=new WasTrxPemrosesan();
                            $modelTrxPemrosesan1->no_register=$_SESSION['was_register'];
                            $modelTrxPemrosesan1->id_sys_menu='3545';
                            $modelTrxPemrosesan1->id_user_login=$_SESSION['username'];
                            $modelTrxPemrosesan1->durasi=date('Y-m-d H:i:s');
                            $modelTrxPemrosesan1->created_by=\Yii::$app->user->identity->id;
                            $modelTrxPemrosesan1->created_ip=$_SERVER['REMOTE_ADDR'];
                            $modelTrxPemrosesan1->created_time=date('Y-m-d H:i:s');
                            $modelTrxPemrosesan1->updated_ip=$_SERVER['REMOTE_ADDR'];
                            $modelTrxPemrosesan1->updated_by=\Yii::$app->user->identity->id;
                            $modelTrxPemrosesan1->updated_time=date('Y-m-d H:i:s');
                            $modelTrxPemrosesan1->user_id=$_SESSION['is_inspektur_irmud_riksa'];
                            $modelTrxPemrosesan1->id_wilayah='1';
                            $modelTrxPemrosesan1->id_level1 ='6';
                            $modelTrxPemrosesan1->id_level2 ='9';
                            $modelTrxPemrosesan1->id_level3 ='0';
                            $modelTrxPemrosesan1->id_level4 ='0';
                            $modelTrxPemrosesan1->save();
                       }else if($model->jbtn_penandatangan == 'Inspektur III'){
                             // WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
                             // AND id_sys_menu='3545' and id_wilayah='1' and id_level1 ='6' 
                             // and id_level2 ='1' and id_level3 ='0' and id_level4 ='0'");
                            $modelTrxPemrosesan1=new WasTrxPemrosesan();
                            $modelTrxPemrosesan1->no_register=$_SESSION['was_register'];
                            $modelTrxPemrosesan1->id_sys_menu='3545';
                            $modelTrxPemrosesan1->id_user_login=$_SESSION['username'];
                            $modelTrxPemrosesan1->durasi=date('Y-m-d H:i:s');
                            $modelTrxPemrosesan1->created_by=\Yii::$app->user->identity->id;
                            $modelTrxPemrosesan1->created_ip=$_SERVER['REMOTE_ADDR'];
                            $modelTrxPemrosesan1->created_time=date('Y-m-d H:i:s');
                            $modelTrxPemrosesan1->updated_ip=$_SERVER['REMOTE_ADDR'];
                            $modelTrxPemrosesan1->updated_by=\Yii::$app->user->identity->id;
                            $modelTrxPemrosesan1->updated_time=date('Y-m-d H:i:s');
                            $modelTrxPemrosesan1->user_id=$_SESSION['is_inspektur_irmud_riksa'];
                            $modelTrxPemrosesan1->id_wilayah='1';
                            $modelTrxPemrosesan1->id_level1 ='6';
                            $modelTrxPemrosesan1->id_level2 ='10';
                            $modelTrxPemrosesan1->id_level3 ='0';
                            $modelTrxPemrosesan1->id_level4 ='0';
                            $modelTrxPemrosesan1->save();
                       }else if($model->jbtn_penandatangan == 'Inspektur IV'){
                             // WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
                             // AND id_sys_menu='3545' and id_wilayah='1' and id_level1 ='6' 
                             // and id_level2 ='1' and id_level3 ='0' and id_level4 ='0'");
                            $modelTrxPemrosesan1=new WasTrxPemrosesan();
                            $modelTrxPemrosesan1->no_register=$_SESSION['was_register'];
                            $modelTrxPemrosesan1->id_sys_menu='3545';
                            $modelTrxPemrosesan1->id_user_login=$_SESSION['username'];
                            $modelTrxPemrosesan1->durasi=date('Y-m-d H:i:s');
                            $modelTrxPemrosesan1->created_by=\Yii::$app->user->identity->id;
                            $modelTrxPemrosesan1->created_ip=$_SERVER['REMOTE_ADDR'];
                            $modelTrxPemrosesan1->created_time=date('Y-m-d H:i:s');
                            $modelTrxPemrosesan1->updated_ip=$_SERVER['REMOTE_ADDR'];
                            $modelTrxPemrosesan1->updated_by=\Yii::$app->user->identity->id;
                            $modelTrxPemrosesan1->updated_time=date('Y-m-d H:i:s');
                            $modelTrxPemrosesan1->user_id=$_SESSION['is_inspektur_irmud_riksa'];
                            $modelTrxPemrosesan1->id_wilayah='1';
                            $modelTrxPemrosesan1->id_level1 ='6';
                            $modelTrxPemrosesan1->id_level2 ='11';
                            $modelTrxPemrosesan1->id_level3 ='0';
                            $modelTrxPemrosesan1->id_level4 ='0';
                            $modelTrxPemrosesan1->save();
                       }else if($model->jbtn_penandatangan == 'Inspektur V'){
                             // WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
                             // AND id_sys_menu='3545' and id_wilayah='1' and id_level1 ='6' 
                             // and id_level2 ='1' and id_level3 ='0' and id_level4 ='0'");
                            $modelTrxPemrosesan1=new WasTrxPemrosesan();
                            $modelTrxPemrosesan1->no_register=$_SESSION['was_register'];
                            $modelTrxPemrosesan1->id_sys_menu='3545';
                            $modelTrxPemrosesan1->id_user_login=$_SESSION['username'];
                            $modelTrxPemrosesan1->durasi=date('Y-m-d H:i:s');
                            $modelTrxPemrosesan1->created_by=\Yii::$app->user->identity->id;
                            $modelTrxPemrosesan1->created_ip=$_SERVER['REMOTE_ADDR'];
                            $modelTrxPemrosesan1->created_time=date('Y-m-d H:i:s');
                            $modelTrxPemrosesan1->updated_ip=$_SERVER['REMOTE_ADDR'];
                            $modelTrxPemrosesan1->updated_by=\Yii::$app->user->identity->id;
                            $modelTrxPemrosesan1->updated_time=date('Y-m-d H:i:s');
                            $modelTrxPemrosesan1->user_id=$_SESSION['is_inspektur_irmud_riksa'];
                            $modelTrxPemrosesan1->id_wilayah='1';
                            $modelTrxPemrosesan1->id_level1 ='6';
                            $modelTrxPemrosesan1->id_level2 ='12';
                            $modelTrxPemrosesan1->id_level3 ='0';
                            $modelTrxPemrosesan1->id_level4 ='0';
                            $modelTrxPemrosesan1->save();
                       }

      move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'was_10_inspeksi/'.$rename_file);
      $transaction->commit();
            
            
            Yii::$app->getSession()->setFlash('success', [
             'type' => 'success',
             'duration' => 3000,
             'icon' => 'fa fa-users',
             'message' => 'Data Berhasil di Simpan',
             'title' => 'Simpan Data',
             'positonY' => 'top',
             'positonX' => 'center',
             'showProgressbar' => true,
             ]);
             return $this->redirect(['index']);
             
            }
            
            else{
             Yii::$app->getSession()->setFlash('success', [
             'type' => 'danger',
             'duration' => 3000,
             'icon' => 'fa fa-users',
             'message' => 'Data Gagal di Simpan',
             'title' => 'Error',
             'positonY' => 'top',
             'positonX' => 'center',
             'showProgressbar' => true,
             ]);
               return $this->redirect(['update']);
            }
            
            
            } catch(Exception $e) {
           $transaction->rollback();
           if(YII_DEBUG){throw $e; exit;} else{return false;}
            }
            
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'spWas2' => $spWas2,
                        'modelTembusan'=>$modelTembusan,
                        'result_expire' => $result_expire,
            ]);
        }
        
        
        
    }

    /**
     * Deletes an existing InspekturModel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {
        //Yii::$app->controller->enableCsrfValidation = false;
        //print_r($_POST);
        if($_POST['selection_all']==1){
            DipaMaster::deleteAll();
            return $this->redirect(['index']);
        } else {
            foreach ($_POST['selection'] as $key => $value) {
                $this->findModel($value)->delete();
            }
            return $this->redirect(['index']);
        }
        // $this->findModel($id)->delete();

        // return $this->redirect(['index']);
    }

    public function actionHapusundangan(){
        $id=$_POST['id'];
        $pecah=explode(',', $id);

       // echo count($pecah);
       for ($i=0; $i < count($pecah); $i++) { 
            $pecahLagi= explode('#', $pecah[$i]);
            $no_register = $pecahLagi[2];
            $id_was10    = $pecahLagi[1];

            // echo $no_register.'#'.$id_was10;
            $model = $this->findModel($no_register,$id_was10);
            if($model->was10_file !='' && file_exists(\Yii::$app->params['uploadPath'].'was_10_inspeksi/'.$model->was10_file)){
              unlink(\Yii::$app->params['uploadPath'].'was_10_inspeksi/'.$model->was10_file);
            } 
            Was10Inspeksi::deleteAll(['id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4'],'no_register'=>$no_register,'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_surat_was10'=>$id_was10]);
            
       //      // PegawaiTerlaporWas10Inspeksi::deleteAll([
       //      //   'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],
       //      //   'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],
       //      //   'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],
       //      //   'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],
       //      //   'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4'],
       //      //   'id_pegawai_terlapor'=>$pecahLagi[2]]);
          
        }
          // 
          return $this->redirect(['index']);
    }

     public function actionDeleteterlapor(){
          $id=$_POST['id'];
          $pecah=explode(',', $id);

       for ($i=0; $i < count($pecah); $i++) { 
            $pecahLagi= explode('#', $pecah[$i]);
            
            PegawaiTerlaporWas10Inspeksi::deleteAll([
              'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],
              'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],
              'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],
              'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],
              'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4'],
              'id_pegawai_terlapor'=>$pecahLagi[2]]);
          
       }
          return $this->redirect(['index']);
    }

    public function actionViewpdf($id,$id_was10){

       $file_upload=$this->findModel($id,$id_was10);
          $filepath = '../modules/pengawasan/upload_file/was_10_inspeksi/'.$file_upload['was10_file'];
          $nama_file=$file_upload['was10_file'];
    
       
        $extention=explode(".", $nama_file);
           if($extention[1]=='jpg' || $extention[1]=='jpeg' || $extention[1]=='png'){
            return Yii::$app->response->sendFile($filepath);
           }else{
          if(file_exists($filepath))
          {
              // Set up PDF headers
              header('Content-type: application/pdf');
              header('Content-Disposition: inline; filename="' . $nama_file . '"');
              header('Content-Transfer-Encoding: binary');
              header('Content-Length: ' . filesize($filepath));
              header('Accept-Ranges: bytes');

              // Render the file
              readfile($filepath);
          }
          else
          {
             // PDF doesn't exist so throw an error or something
          }
      }
      
    }

    public function actionCetakdocx($id) {
      $data_satker = KpInstSatkerSearch::findOne(['inst_satkerkd'=>$_SESSION['inst_satkerkd']]);/*lokasi dan nama kejaksaan*/
      $model = Was10Inspeksi::findOne(['id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],
        'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_surat_was10' => $id,
        'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],
        'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],
        'id_level4'=>$_SESSION['was_id_level4']]);
      // print_r($model);
      // exit();
      
      $tanggal_was_10=\Yii::$app->globalfunc->ViewIndonesianFormat($model['was10_tanggal']);
      $tanggal=\Yii::$app->globalfunc->ViewIndonesianFormat($model['tanggal_pemeriksaan_was10']);

      $connection = \Yii::$app->db;
      $query="select a.* from kepegawaian.kp_pegawai a inner join was.was10_inspeksi b on a.peg_nip_baru=b.nip_pemeriksa 
              where peg_nip_baru='".$model['nip_pemeriksa']."'";;
      $pemeriksa = $connection->createCommand($query)->queryOne();

      $sp_was_1 = SpWas2::find()->where(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],
                                         'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],
                                         'id_sp_was2' => $model->id_sp_was2,'id_wilayah'=>$_SESSION['was_id_wilayah'],
                                         'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],
                                         'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4'],
                                         'trx_akhir'=>1])->One();

      $query_sql="select string_agg(nama_pegawai_terlapor,', ') as nama_pegawai_terlapor from was.pegawai_terlapor_was10_inspeksi 
                  where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' 
                    and id_kejati='".$_SESSION['kode_kejati']."' 
                    and id_kejari='".$_SESSION['kode_cabjari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' 
                    and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' 
                    and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' 
                    and id_level4='".$_SESSION['was_id_level4']."'";
      $terlapor = $connection->createCommand($query_sql)->queryOne();
    
      $tgl_sp_was=\Yii::$app->globalfunc->ViewIndonesianFormat($sp_was_1['tanggal_sp_was2']);

      //$tembusan_was10 = TembusanWas2::find()->where("pk_in_table='".$id."' and from_table='Was-10-inspeksi'")->all();
      $query6 = "select a.* from was.tembusan_was a
                    where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' 
                    and id_kejati='".$_SESSION['kode_kejati']."' 
                    and id_kejari='".$_SESSION['kode_cabjari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' 
                    and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' 
                    and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' 
                    and id_level4='".$_SESSION['was_id_level4']."'
                    and a.pk_in_table='".$id."' and from_table='Was-10-inspeksi'  $where order by is_order desc";
      $tembusan_was10 = $connection->createCommand($query6)->queryAll();
      // print_r($tembusan_was10);
      // exit();


      $sql="select*from was.lapdu where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' 
                    and id_kejati='".$_SESSION['kode_kejati']."' 
                    and id_kejari='".$_SESSION['kode_cabjari']."' and id_cabjari='".$_SESSION['kode_cabjari']."'";
      $lapdu = $connection->createCommand($sql)->queryOne();
      


       return $this->render('cetak',[
        'data_satker'=>$data_satker,
        'model'=>$model,
        'tanggal_was_10'=>$tanggal_was_10,
        'tanggal'=>$tanggal,
        'pemeriksa'=>$pemeriksa,
        'sp_was_1'=>$sp_was_1,
        'terlapor'=>$terlapor,
        'tgl_sp_was'=>$tgl_sp_was,
        'tembusan_was10'=>$tembusan_was10,
        'lapdu'=>$lapdu,
        ]);
     }

    /**
     * Finds the InspekturModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InspekturModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
     protected function findModel($id,$id_was10)
    {
        if (($model = Was10Inspeksi::findOne(['no_register'=>$id,'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_surat_was10'=>$id_was10,'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
