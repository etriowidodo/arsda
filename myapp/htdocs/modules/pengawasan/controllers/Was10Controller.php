<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\Was10;
use app\modules\pengawasan\models\Was10Search;
use app\modules\pengawasan\models\LookupItem;
use app\models\KpInstSatker;
use app\models\KpInstSatkerSearch;
use app\modules\pengawasan\models\SpWas1;
use yii\grid\GridView;
use app\modules\pengawasan\models\Lapdu;
use app\modules\pengawasan\models\VSpWas2;
use app\modules\pengawasan\models\VPemeriksa;
use app\modules\pengawasan\models\VRiwayatJabatan;
use app\modules\pengawasan\models\VWas12Was10;
use app\components\GlobalFuncComponent; 
use app\modules\pengawasan\components\FungsiComponent; 
use app\models\KpPegawai;

use app\modules\pengawasan\models\PegawaiTerlapor;
use app\modules\pengawasan\models\PegawaiTerlaporWas10;
use app\modules\pengawasan\models\PemeriksaSpWas1;
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
 * Was10Controller implements the CRUD actions for Was10 model.
 */
class Was10Controller extends Controller
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
     * Lists all Was10 models.
     * @return mixed
     */
    public function actionIndex()
    {
    $session = Yii::$app->session;
        $searchModel = new Was10Search();
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
      $searchModelWas10 = new Was10Search();
      $dataProviderWas10 = $searchModelWas10->searchWas10Get($no_register,$id_pegawai_terlapor,$nip);
		  echo "<input type='hidden' name='Mnip' value='".$nip."' id='Mnip'>";
      echo GridView::widget([
                                'dataProvider'=> $dataProviderWas10,
                                'tableOptions'=>['class'=>'table table-striped table-bordered','id'=>'grid-undang-terlapor'],
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

                                    // ['label'=>'Tanggal Pemeriksaan',
                                    //     'headerOptions'=>['style'=>'text-align:center;'],
                                    //     'attribute'=>'tanggal_pemeriksaan_was10',
                                    // ],
                                    ['label'=>'Tanggal Pemeriksaan',
                                        'format'=>'raw',
                                        'headerOptions'=>['style'=>'text-align:center;'],
                                        'value' => function ($data) {
                                         return \Yii::$app->globalfunc->ViewIndonesianFormat($data['tanggal_pemeriksaan_was10']); 
                                      },
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
                                            return "<input type='checkbox' name='Mselection[]' value='".$data['no_register']."' class='Mselection_one' json='".$result."' />";
                                        },
                                    ],

                                 ],   

                            ]); 

    }


    /**
     * Displays a single Was10 model.
     * @param string $id
     * @return mixed
     */
    public function actionForm1()
    {
         $model = new PegawaiTerlaporWas10();

        if ($model->load(Yii::$app->request->post())){
        	$connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
            	$jml=$_POST['nip'];
        for ($i=0; $i < count($jml); $i++) { 
            $saveTerlapor = new PegawaiTerlaporWas10();
            // $saveTerlapor->for_tabel = 'Sp-Was-1';
            // $saveTerlapor->id_sp_was1 = 1;
            $saveTerlapor->nip = $_POST['nip'][$i];
            // $saveTerlapor->id_pegawai_terlapor = 1;
            $saveTerlapor->nrp_pegawai_terlapor = $_POST['nrp'][$i];
            $saveTerlapor->nama_pegawai_terlapor = $_POST['nama'][$i];
            $saveTerlapor->pangkat_pegawai_terlapor = $_POST['pangkat'][$i];
            $saveTerlapor->golongan_pegawai_terlapor = $_POST['golongan'][$i];
            $saveTerlapor->jabatan_pegawai_terlapor = $_POST['jabatan'][$i];
            $saveTerlapor->satker_pegawai_terlapor = $_POST['satker'][$i];
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
              $sql="UPDATE was.pegawai_terlapor_was10
                       SET nip='".$_POST['Mnip']."', nrp_pegawai_terlapor='".$_POST['Mnrp']."', 
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
   

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }



    /**
     * Creates a new Was10 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($nip)
    {
		$var=str_split($_SESSION['is_inspektur_irmud_riksa']);

      $model = new Was10();
      $fungsi=new FungsiComponent();
      $where=$fungsi->static_where();/*karena ada perubahan kode*/         
      
      $filter_0      =" no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and trx_akhir=1 $where";
      $spWas1         =$fungsi->FunctGetIdSpwas1All($filter_0);

      $Fungsi         =new GlobalFuncComponent();
      $table          ='sp_was_1';
      $filed          ='tanggal_akhir_sp_was1';
      $filter_1          =" no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and tanggal_akhir_sp_was1 is not null $where";
      $result_expire  =$Fungsi->CekExpire($table,$filed,$filter_1);

      // $FungsiWas      =new FungsiComponent();
      $filter_2         =" no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and trx_akhir=1 $where";
      $getId          =$fungsi->FunctGetIdSpwas1($filter_2);

      $modelTembusanMaster = TembusanWas::find()->where("for_tabel=:condition1 OR for_tabel=:condition2", [":condition1" => 'was_10','condition2'=>'master'])->all();
      
        if ($model->load(Yii::$app->request->post())) {
      $pegawai_terlapor=PegawaiTerlaporWas10::findOne(['nip'=>$model->nip_pegawai_terlapor]);
      $pegawai_pemeriksa=PemeriksaSpWas1::findOne(['nip'=>$model->nip_pemeriksa]);
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
                $model->id_kejati = $_SESSION['kode_kejati'];
                $model->id_kejari = $_SESSION['kode_kejari'];
                $model->id_cabjari = $_SESSION['kode_cabjari'];
                $model->no_register = $_SESSION['was_register'];
                $model->id_sp_was1 = $getId['id_sp_was1'];
                $model->created_ip = $_SERVER['REMOTE_ADDR'];
                $model->created_time = date('Y-m-d H:i:s');
                $model->created_by = \Yii::$app->user->identity->id;
                $model->id_pegawai_terlapor = $pegawai_terlapor['id_pegawai_terlapor'];
                $model->nama_pegawai_terlapor = $pegawai_terlapor['nama_pegawai_terlapor'];
                $model->pangkat_pegawai_terlapor = $pegawai_terlapor['pangkat_pegawai_terlapor'];
                $model->golongan_pegawai_terlapor = $pegawai_terlapor['golongan_pegawai_terlapor'];
                $model->jabatan_pegawai_terlapor = $pegawai_terlapor['jabatan_pegawai_terlapor'];
                $model->satker_pegawai_terlapor = $pegawai_terlapor['satker_pegawai_terlapor'];
                $model->id_pemeriksa = $pegawai_pemeriksa['id_pemeriksa_sp_was1'];
                $model->nrp_pemeriksa = $pegawai_pemeriksa['nrp'];
                $model->nama_pemeriksa = $pegawai_pemeriksa['nama_pemeriksa'];
                $model->pangkat_pemeriksa = $pegawai_pemeriksa['pangkat_pemeriksa'];
                $model->jabatan_pemeriksa = $pegawai_pemeriksa['jabatan_pemeriksa'];
                $model->golongan_pemeriksa = $pegawai_pemeriksa['golongan_pemeriksa'];
                $model->pangkat_penandatangan = $pegawai_penandatangan['gol_pangkat2'];
                $model->golongan_penandatangan = $pegawai_penandatangan['gol_kd'];
                $model->jbtn_penandatangan = $pegawai_penandatangan['jabatan'];
                $model->jam_pemeriksaan_was10 = $_POST['jam_pemeriksaan_was10'];
                
			if($model->save()){
			
			
			
			
			     $pejabat = $_POST['pejabat'];
    			 for($z=0;$z<count($pejabat);$z++){
                      $saveTembusan = new TembusanWas2;
                      $saveTembusan->from_table = 'Was-10';
                      $saveTembusan->pk_in_table = strrev($model->id_surat_was10);
                      $saveTembusan->tembusan = $_POST['pejabat'][$z];
                      $saveTembusan->created_ip = $_SERVER['REMOTE_ADDR'];
                      $saveTembusan->created_time = date('Y-m-d H:i:s');
                      $saveTembusan->created_by = \Yii::$app->user->identity->id;
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
			$arr = array(ConstSysMenuComponent::Was13, ConstSysMenuComponent::Bawas3, ConstSysMenuComponent::Was12);
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
                'spWas1' => $spWas1,
                'result_expire' => $result_expire,
                'modelTembusanMaster' => $modelTembusanMaster,
				
            ]);
        }
		
    }

    /**
     * Updates an existing Was10 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
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
    $modelTembusan=TembusanWas2::find()->where(['pk_in_table'=>$id_was10,'from_table'=>'Was-10','no_register'=>$id,'id_tingkat'=>$id_tingkat,'id_kejati'=>$id_kejati,'id_kejari'=>$id_kejari,'id_cabjari'=>$id_cabjari,'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']])->orderBy('is_order desc')->all();
      
      $fungsi   =new FungsiComponent();
      $where    =$fungsi->static_where();
      $Fungsi         =new GlobalFuncComponent();
      $table          ='sp_was_1';
      $filed          ='tanggal_akhir_sp_was1';
      $filter_1       ="no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and trx_akhir=1 $where";
      $result_expire  =$Fungsi->CekExpire($table,$filed,$filter_1);

      // $fungsi=new FungsiComponent();
          $is_inspektur_irmud_riksa=$fungsi->gabung_where();/*karena ada perubahan kode*/  
          $OldFile=$model->was10_file;
      $filter_0      =" no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and trx_akhir=1 $where";
      $spWas1         =$fungsi->FunctGetIdSpwas1All($filter_0);
     
    
        if ($model->load(Yii::$app->request->post())) {
              $pegawai_terlapor=PegawaiTerlaporWas10::findOne(['nip'=>$model->nip_pegawai_terlapor]);
              $pegawai_pemeriksa=PemeriksaSpWas1::findOne(['nip'=>$model->nip_pemeriksa]);
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


                $model->updated_ip = $_SERVER['REMOTE_ADDR'];
                $model->updated_time = date('Y-m-d H:i:s');
                $model->updated_by = \Yii::$app->user->identity->id;
                $model->id_pegawai_terlapor = $pegawai_terlapor['id_pegawai_terlapor'];
                $model->nama_pegawai_terlapor = $pegawai_terlapor['nama_pegawai_terlapor'];
                $model->pangkat_pegawai_terlapor = $pegawai_terlapor['pangkat_pegawai_terlapor'];
                $model->golongan_pegawai_terlapor = $pegawai_terlapor['golongan_pegawai_terlapor'];
                $model->jabatan_pegawai_terlapor = $pegawai_terlapor['jabatan_pegawai_terlapor'];
                $model->satker_pegawai_terlapor = $pegawai_terlapor['satker_pegawai_terlapor'];
                $model->id_pemeriksa = $pegawai_pemeriksa['id_pemeriksa_sp_was1'];
                $model->nrp_pemeriksa = $pegawai_pemeriksa['nrp'];
                $model->nama_pemeriksa = $pegawai_pemeriksa['nama_pemeriksa'];
                $model->pangkat_pemeriksa = $pegawai_pemeriksa['pangkat_pemeriksa'];
                $model->jabatan_pemeriksa = $pegawai_pemeriksa['jabatan_pemeriksa'];
                $model->golongan_pemeriksa = $pegawai_pemeriksa['golongan_pemeriksa'];
                $model->pangkat_penandatangan = $pegawai_penandatangan['gol_pangkat2'];
                $model->golongan_penandatangan = $pegawai_penandatangan['gol_kd'];
                $model->jbtn_penandatangan = $pegawai_penandatangan['jabatan'];
                $model->jam_pemeriksaan_was10 = $_POST['jam_pemeriksaan_was10'];
                $model->was10_file = ($file_name==''?$OldFile:$rename_file);
      if($model->save()){
      if($OldFile!='' && file_exists($file_tmp) && file_exists(\Yii::$app->params['uploadPath'].'was_10/'.$OldFile)) {
          unlink(\Yii::$app->params['uploadPath'].'was_10/'.$OldFile);
      } 
        
      
              TembusanWas2::deleteAll(['from_table'=>'Was-10','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'pk_in_table'=>$model->id_surat_was10,'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
                       $pejabat = $_POST['pejabat'];
                       for($z=0;$z<count($pejabat);$z++){
                      $saveTembusan = new TembusanWas2;
                      $saveTembusan->from_table = 'Was-10';
                      $saveTembusan->pk_in_table = strrev($model->id_surat_was10);
                      $saveTembusan->tembusan = $_POST['pejabat'][$z];
                      $saveTembusan->created_ip = $_SERVER['REMOTE_ADDR'];
                      $saveTembusan->created_time = date('Y-m-d H:i:s');
                      $saveTembusan->created_by = \Yii::$app->user->identity->id;
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


                    $arr = array(ConstSysMenuComponent::Was13, ConstSysMenuComponent::Bawas3, ConstSysMenuComponent::Was12);
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
      move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'was_10/'.$rename_file);
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
                'spWas1' => $spWas1,
        				'modelTembusan'=>$modelTembusan,
        				'result_expire' => $result_expire,
            ]);
        }
		
		
		
    }

    /**
     * Deletes an existing Was10 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
	
	
	public function actionDelete(){
  
  }

  public function actionHapusundangan(){
   $id_was10=$_POST['id'];
   $no_register=$_POST['no_register'];
  $model = $this->findModel($no_register,$id_was10);
  if($model->was10_file !='' && file_exists(\Yii::$app->params['uploadPath'].'was_10/'.$model->was10_file)){
  unlink(\Yii::$app->params['uploadPath'].'was_10/'.$model->was10_file);
  } 
  Was10::deleteAll(['no_register'=>$no_register,'id_tingkat'=>$_SESSION['kode_tk'],
    'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],
    'id_cabjari'=>$_SESSION['kode_cabjari'],'id_surat_was10'=>$id_was10,
    'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],
    'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],
    'id_level4'=>$_SESSION['was_id_level4']]);

    Yii::$app->getSession()->setFlash('success', [
             'type' => 'success',
             'duration' => 3000,
             'icon' => 'fa fa-users',
             'message' => 'Data Berhasil Dihapus',
             'title' => 'Hapus Data',
             'positonY' => 'top',
             'positonX' => 'center',
             'showProgressbar' => true,
          ]);
  // 
  return $this->redirect(['index']);
  }

	public function actionHapusterlapor(){
		$id= $_POST['id'];
		$pecah=explode(',', $id);
   // echo count($pecah);
   for ($i=0; $i < count($pecah); $i++) { 
      // echo $pecah[$i];
       $pecahLagi= explode('#', $pecah[$i]);
       if($pecahLagi[0]==''){
        echo "hapus ";
        PegawaiTerlaporWas10::deleteAll(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],
          'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],
          'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],
          'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],
          'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4'],
          'nip'=>$pecahLagi[1],'id_pegawai_terlapor'=>$pecahLagi[2]]);

          Yii::$app->getSession()->setFlash('success', [
             'type' => 'success',
             'duration' => 3000,
             'icon' => 'fa fa-users',
             'message' => 'Data Berhasil Dihapus',
             'title' => 'Hapus Data',
             'positonY' => 'top',
             'positonX' => 'center',
             'showProgressbar' => true,
          ]);
       }else{
        Yii::$app->getSession()->setFlash('danger', [
             'type' => 'success',
             'duration' => 3000,
             'icon' => 'fa fa-users',
             'message' => 'Data Gagal Dihapus',
             'title' => 'Hapus Data',
             'positonY' => 'top',
             'positonX' => 'center',
             'showProgressbar' => true,
          ]);
      }
   }

   return $this->redirect(['index']);

	}
	
	public function actionHapus() {
    $id_was10 = $_POST['id'];
    if (Was10::deleteAll("id_was10 ='" . $id_was10  . "'")) {
      TembusanWas2::deleteAll("pk_in_table=:del and from_table='Was-10'", [':del' =>$id_was10  ]);

       $model = was10::findAll(array("no_register" => $_SESSION['was_register'],'is_inspektur_irmud_riksa'=>$_SESSION['is_inspektur_irmud_riksa']));
     if(count($model)<=0){
        $var=str_split($_SESSION['is_inspektur_irmud_riksa']);
        $connection = \Yii::$app->db;
        $query1 = "select * from was.was_disposisi_irmud where no_register='".$_SESSION['was_register']."'";
        $disposisi_irmud = $connection->createCommand($query1)->queryAll(); 

        for ($i=0;$i<count($disposisi_irmud);$i++){
        
        $saveDisposisi = DisposisiIrmud::find()->where("no_register='".$_SESSION['was_register']."' and id_terlapor_awal='".$disposisi_irmud[$i]['id_terlapor_awal']."' and id_inspektur='".$var[0]."' and id_irmud='".$var[1]."'")->one();
        if($var[2]==1){
            $connection = \Yii::$app->db;
            $query1 = "update was.was_disposisi_irmud set status_pemeriksa1='WAS-11' where id_terlapor_awal='".$saveDisposisi['id_terlapor_awal']."'";
            $disposisi_irmud = $connection->createCommand($query1);
            $disposisi_irmud->execute();
        }
        if($var[2]==2){
            $connection = \Yii::$app->db;
            $query1 = "update was.was_disposisi_irmud set status_pemeriksa2='WAS-11' where id_terlapor_awal='".$saveDisposisi['id_terlapor_awal']."'";
            $disposisi_irmud = $connection->createCommand($query1);
            $disposisi_irmud->execute();
        // }    
        }   
		}
    
		$arr = array(ConstSysMenuComponent::Was12);
		    for ($i=0; $i < 1 ; $i++) { 
		            WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."' AND id_sys_menu='".$arr[$i]."' AND user_id='".$_SESSION['is_inspektur_irmud_riksa']."'");
		    }
		// hapus trx_permrosesan BAWAS3  dan WAS13, tp harus cek was9 dulu jika was9 ada maka jangan di hapus
	    $cek_was9 = "select count(*) as jumlah from was.was9 where no_register='".$_SESSION['was_register']."' AND is_inspektur_irmud_riksa='".$_SESSION['is_inspektur_irmud_riksa']."'";
	    $result_wa9 = $connection->createCommand($cek_was9)->queryOne(); 
	    
	    if($result_wa9['jumlah']<=0){
	      $arr = array(ConstSysMenuComponent::Was13, ConstSysMenuComponent::Bawas3);
	    for ($x=0; $x < 2 ; $x++) { 
	            WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."' AND id_sys_menu='".$arr[$x]."' AND user_id='".$_SESSION['is_inspektur_irmud_riksa']."'");
	    }
	    }
}
      Yii::$app->getSession()->setFlash('success', [
          'type' => 'success',
          'duration' => 3000,
          'icon' => 'fa fa-users',
          'message' => 'Data Berhasil Dihapus',
          'title' => 'Hapus Data',
          'positonY' => 'top',
          'positonX' => 'center',
          'showProgressbar' => true,
      ]);
    } else {
      Yii::$app->getSession()->setFlash('success', [
          'type' => 'danger',
          'duration' => 3000,
          'icon' => 'fa fa-users',
          'message' => 'Data Gagal Dihapus'.$id_was10 .'" ',
          'title' => 'Error',
          'positonY' => 'top',
          'positonX' => 'center',
          'showProgressbar' => true,
      ]);
    }
    return $this->redirect(['index']);
  }

 
	
	public function actionViewpdf($id,$id_was10){

       $file_upload=$this->findModel($id,$id_was10);
          $filepath = '../modules/pengawasan/upload_file/was_10/'.$file_upload['was10_file'];
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
     	$model = was10::findOne(['id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_surat_was10' => $id,'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
      // print_r($model);
      // exit();
     	
     	$tanggal_was_10=\Yii::$app->globalfunc->ViewIndonesianFormat($model['was10_tanggal']);
     	$tanggal=\Yii::$app->globalfunc->ViewIndonesianFormat($model['tanggal_pemeriksaan_was10']);

     	$connection = \Yii::$app->db;
     	$query="select a.* from kepegawaian.kp_pegawai a inner join was.was10 b on a.peg_nip_baru=b.nip_pemeriksa where peg_nip_baru='".$model['nip_pemeriksa']."'";;
     	$pemeriksa = $connection->createCommand($query)->queryOne();

	    $sp_was_1 = SpWas1::find()->where(['id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_sp_was1' => $model->id_sp_was1,'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4'],'trx_akhir'=>1])->One();

	    $query_sql="select string_agg(nama_pegawai_terlapor,', ') as nama_pegawai_terlapor from was.pegawai_terlapor where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' 
                    and id_kejati='".$_SESSION['kode_kejati']."' 
                    and id_kejari='".$_SESSION['kode_cabjari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'";
	    $terlapor = $connection->createCommand($query_sql)->queryOne();
    
     	$tgl_sp_was=\Yii::$app->globalfunc->ViewIndonesianFormat($sp_was_1['tanggal_sp_was1']);

      $query6 = "select a.* from was.tembusan_was a
                    where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' 
                    and a.id_kejati='".$_SESSION['kode_kejati']."' 
                    and a.id_kejari='".$_SESSION['kode_cabjari']."' and a.id_cabjari='".$_SESSION['kode_cabjari']."'
                    and a.pk_in_table='".$id."' and from_table='Was-10' and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'  order by is_order desc";
      $tembusan_was10 = $connection->createCommand($query6)->queryAll();


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


    public function actionGetttd(){
   $searchModelWas10 = new Was10Search();
   $dataProviderPenandatangan = $searchModelWas10->searchPenandatangan(Yii::$app->request->queryParams);
   // print_r($dataProviderPenandatangan);
   // exit();
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


    /**
     * Finds the Was10 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Was10 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id,$id_was10)
    {
        if (($model = Was10::findOne(['no_register'=>$id,'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_surat_was10'=>$id_was10,'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
