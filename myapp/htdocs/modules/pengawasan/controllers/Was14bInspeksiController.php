<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\was14b;
use app\modules\pengawasan\models\was14bSearch;
use app\modules\pengawasan\models\Was14bUraian;
use app\modules\pengawasan\models\TembusanWas;/*mengambil tembusan dari master*/
use app\modules\pengawasan\models\TembusanWas2;/*mengambil tembusan dari transaksi*/
use app\modules\pengawasan\models\LWas2Terlapor;/*mengambil data dari lwas2 terlapor yang di lanjutkan*/
use app\modules\pengawasan\models\WasTrxPemrosesan;/*mengambil data dari lwas2 terlapor yang di lanjutkan*/
use app\modules\pengawasan\components\FungsiComponent; 
use app\components\ConstSysMenuComponent; 
use app\modules\pengawasan\models\KpInstSatker;
use app\models\KpInstSatkerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\grid\GridView;
use yii\widgets\Pjax;

/**
 * InspekturModelController implements the CRUD actions for InspekturModel model.
 */
class Was14bInspeksiController extends Controller
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
	// $this->redirect(\Yii::$app->urlManager->createUrl("pengawasan/was14a-inspeksi/create"));
       
        $searchModel = new was14bSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]); 
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

    public function actionGetttd(){
       
   $searchModelWas14b = new was14bSearch();
   $dataProviderPenandatangan = $searchModelWas14b->searchPenandatangan(Yii::$app->request->queryParams);
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
     * Creates a new InspekturModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new was14b();
        $modelTembusanMaster = TembusanWas::find()->where("for_tabel=:condition1 OR for_tabel=:condition2", [":condition1" => 'was_14b','condition2'=>'master'])->orderBy('id_tembusan desc')->all();
        $modelLwas2terlapor=LWas2Terlapor::findOne(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4'],'saran_l_was_2'=>1]);

        if ($model->load(Yii::$app->request->post())){
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
                $model->no_register = $_SESSION['was_register'];
                $model->id_tingkat  = $_SESSION['kode_tk'];
                $model->id_kejati   = $_SESSION['kode_kejati'];
                $model->id_kejari   = $_SESSION['kode_kejari'];
                $model->id_cabjari  = $_SESSION['kode_cabjari'];
                $model->created_by=\Yii::$app->user->identity->id;
                $model->created_ip=$_SERVER['REMOTE_ADDR'];
                $model->created_time=date('Y-m-d H:i:s');
                $model->id_sp_was2=$modelLwas2terlapor['id_sp_was2'];
                $model->id_ba_was2=$modelLwas2terlapor['id_ba_was2'];
                $model->id_l_was2=$modelLwas2terlapor['id_l_was2'];

                if($model->save()) {
                    $jml=count($_POST['uraian']);
                    for ($i=0; $i < $jml; $i++) { 
                        $model14uaraian=new Was14bUraian();
                        $model14uaraian->no_register = $_SESSION['was_register'];
                        $model14uaraian->id_tingkat  = $_SESSION['kode_tk'];
                        $model14uaraian->id_kejati   = $_SESSION['kode_kejati'];
                        $model14uaraian->id_kejari   = $_SESSION['kode_kejari'];
                        $model14uaraian->id_cabjari  = $_SESSION['kode_cabjari'];
                        $model14uaraian->id_sp_was2  = $model->id_sp_was2;
                        $model14uaraian->id_ba_was2  = $model->id_ba_was2;
                        $model14uaraian->id_l_was2   = $model->id_l_was2;
                        $model14uaraian->id_was14b   = $model->id_was14b;
                        $model14uaraian->isi_uraian   = $_POST['uraian'][$i];
                        $model14uaraian->created_by=\Yii::$app->user->identity->id;
                        $model14uaraian->created_ip=$_SERVER['REMOTE_ADDR'];
                        $model14uaraian->created_time=date('Y-m-d H:i:s');
                        $model14uaraian->save();
                    }

                    $pejabat = $_POST['pejabat'];
                    
                   for($z=0;$z<count($pejabat);$z++){
                                $saveTembusan = new TembusanWas2;
                                $saveTembusan->from_table = 'Was-14b';
                                $saveTembusan->pk_in_table = strrev($model->id_was14b);
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
                     $arr = array(ConstSysMenuComponent::Was15Inspek);
                    for ($i=0; $i < 1 ; $i++) { 
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


                }
                Yii::$app->getSession()->setFlash('success', [
                 'type' => 'success',
                 'duration' => 3000,
                 'icon' => 'fa fa-users',
                 'message' => 'Data Ba-Was9 Berhasil Disimpan',
                 'title' => 'Simpan Data',
                 'positonY' => 'top',
                 'positonX' => 'center',
                 'showProgressbar' => true,
                 ]);
                $transaction->commit();
                // $model->validate();
                // $model->save();
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
            } catch (Exception $e) {
                  Yii::$app->getSession()->setFlash('danger', [
                    'type' => 'danger', //String, can only be set to danger, success, warning, info, and growl
                    'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                    'icon' => 'glyphicon glyphicon-ok-sign', //String
                    'message' => 'Data Gagal Disimpan', // String
                    'title' => 'Save', //String
                    'positonY' => 'top', //String // defaults to top, allows top or bottom
                    'positonX' => 'center', //String // defaults to right, allows right, center, left
                    'showProgressbar' => true,
                ]); 
                $transaction->rollback();
                    if(YII_DEBUG){throw $e; exit;} else{return false;}
            }
            return $this->redirect(['index']);
        }   else {
            return $this->render('create', [
                'model' => $model,
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
    public function actionUpdate($id)
    {
        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $res = "";
        for ($i = 0; $i < 10; $i++) {
            $res .= $chars[mt_rand(0, strlen($chars)-1)];
        }
        // print_r($_SESSION);
        // exit();
        $model = $this->findModel($id);
        $fungsi=new FungsiComponent();
        $modelTembusan=TembusanWas2::find()->where(['pk_in_table'=>$model->id_was14b,'from_table'=>'Was-14b','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']])->orderBy('is_order DESC')->all();
        $modelwas14b=Was14bUraian::findAll(['id_was14b'=>$model->id_was14b,'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);

         $is_inspektur_irmud_riksa=$fungsi->gabung_where();
         $OldFile=$model->upload_file;

        if ($model->load(Yii::$app->request->post())){

              $errors       = array();
              $file_name    = $_FILES['upload_file']['name'];
              $file_size    =$_FILES['upload_file']['size'];
              $file_tmp     =$_FILES['upload_file']['tmp_name'];
              $file_type    =$_FILES['upload_file']['type'];
              $ext = pathinfo($file_name, PATHINFO_EXTENSION);
              $tmp = explode('.', $_FILES['upload_file']['name']);
              $file_exists  = end($tmp);
              $rename_file  =$is_inspektur_irmud_riksa.'_'.$_SESSION['inst_satkerkd'].$res.'.'.$ext;
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
                $model->upload_file=($file_name==''?$OldFile:$rename_file);
                $model->updated_ip = $_SERVER['REMOTE_ADDR'];
                $model->updated_time = date('Y-m-d H:i:s');
                $model->updated_by = \Yii::$app->user->identity->id;
            if($model->save()){
                if($OldFile!='' && file_exists($file_tmp) && file_exists(\Yii::$app->params['uploadPath'].'was_14b/'.$OldFile)) {
                      unlink(\Yii::$app->params['uploadPath'].'was_14b/'.$OldFile);
                  }

                $jml=count($_POST['uraian']);
                Was14bUraian::deleteAll(['id_was14b'=>$model->id_was14b,'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
                    for ($i=0; $i < $jml; $i++) { 
                        $model14uaraian=new Was14bUraian();
                        $model14uaraian->no_register = $_SESSION['was_register'];
                        $model14uaraian->id_tingkat  = $_SESSION['kode_tk'];
                        $model14uaraian->id_kejati   = $_SESSION['kode_kejati'];
                        $model14uaraian->id_kejari   = $_SESSION['kode_kejari'];
                        $model14uaraian->id_cabjari  = $_SESSION['kode_cabjari'];
                        $model14uaraian->id_sp_was2  = $model->id_sp_was2;
                        $model14uaraian->id_ba_was2  = $model->id_ba_was2;
                        $model14uaraian->id_l_was2   = $model->id_l_was2;
                        $model14uaraian->id_was14b   = $model->id_was14b;
                        $model14uaraian->isi_uraian   = $_POST['uraian'][$i];
                        $model14uaraian->created_by=\Yii::$app->user->identity->id;
                        $model14uaraian->created_ip=$_SERVER['REMOTE_ADDR'];
                        $model14uaraian->created_time=date('Y-m-d H:i:s');
                        $model14uaraian->save();
                    }
                    
                    $pejabat = $_POST['pejabat'];
                    TembusanWas2::deleteAll(['from_table'=>'Was-14b','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'pk_in_table'=>strrev($model->id_was14b),'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
                        for($z=0;$z<count($pejabat);$z++){
                            $saveTembusan = new TembusanWas2;
                            $saveTembusan->from_table = 'Was-14b';
                            $saveTembusan->pk_in_table = strrev($model->id_was14b);
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

                    $arr = array(ConstSysMenuComponent::Was15Inspek);
                    for ($i=0; $i < 1 ; $i++) { 
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

            }
            move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'was_14b/'.$rename_file);
            Yii::$app->getSession()->setFlash('success', [
             'type' => 'success',
             'duration' => 3000,
             'icon' => 'fa fa-users',
             'message' => 'Data Ba-Was9 Berhasil Disimpan',
             'title' => 'Simpan Data',
             'positonY' => 'top',
             'positonX' => 'center',
             'showProgressbar' => true,
             ]);
            $transaction->commit();
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
            } catch (Exception $e) {
              Yii::$app->getSession()->setFlash('danger', [
                    'type' => 'danger', //String, can only be set to danger, success, warning, info, and growl
                    'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                    'icon' => 'glyphicon glyphicon-ok-sign', //String
                    'message' => 'Data Gagal Disimpan', // String
                    'title' => 'Save', //String
                    'positonY' => 'top', //String // defaults to top, allows top or bottom
                    'positonX' => 'center', //String // defaults to right, allows right, center, left
                    'showProgressbar' => true,
                ]);
                $transaction->rollback();
                    if(YII_DEBUG){throw $e; exit;} else{return false;}
            }
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelTembusan' => $modelTembusan,
                'modelwas14b' => $modelwas14b,
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
        // for ($i=0; $i < $_POST['id']; $i++) { 

         was14b::deleteAll(['no_register'=>$_SESSION['was_register'],'id_was14b'=>$_POST['id'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);

        // }
        // echo $_POST['id'];
        // echo $_POST['jml'];
        // $this->findModel($id)->delete();

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
         
        return $this->redirect(['index']);
    }

    public function actionViewpdf($id){
        $file_upload=$this->findModel($id);

          $filepath = '../modules/pengawasan/upload_file/was_14b/'.$file_upload['upload_file'];
        $extention=explode(".", $file_upload['upload_file']);
           if($extention[1]=='jpg' || $extention[1]=='jpeg' || $extention[1]=='png'){
            return Yii::$app->response->sendFile($filepath);
           }else{
          if(file_exists($filepath))
          {
              // Set up PDF headers
              header('Content-type: application/pdf');
              header('Content-Disposition: inline; filename="' . $file_upload['upload_file'] . '"');
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

    public function actionCetak($id){
        $data_satker = KpInstSatkerSearch::findOne(['inst_satkerkd'=>$_SESSION['inst_satkerkd']]);/*lokasi dan nama kejaksaan*/
        $model=$this->findModel($id);
        // print_r($model);
        // exit();
        $modelwas14b=Was14bUraian::findAll(['id_was14b'=>$model->id_was14b,'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);

        $modelTembusan=TembusanWas2::find()->where(['pk_in_table'=>$model->id_was14b,'from_table'=>'Was-14b','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']])->orderBy('is_order DESC')->all();


        $connection = \Yii::$app->db;
        $fungsi=new FungsiComponent();
        $where=$fungsi->static_where_alias('a');
        $query="select * FROM was.sp_was_2 a   where  
                    a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' 
                    and a.id_kejati='".$_SESSION['kode_kejati']."' 
                    and a.id_kejari='".$_SESSION['kode_kejari']."' and a.id_cabjari='".$_SESSION['kode_cabjari']."'
                    and a.trx_akhir=1 $where";
        $modelSpwas2 = $connection->createCommand($query)->queryOne();
   
      
         
         return $this->render('cetak',[
                                'data_satker'=>$data_satker,
                                'model'=>$model,
                                'modelSpwas2'=>$modelSpwas2,
                                'modelwas14b'=>$modelwas14b,
                                'modelTembusan'=>$modelTembusan,
                                ]);
      
    }

    /**
     * Finds the InspekturModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InspekturModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = was14b::findOne(['id_was14b'=>$id,'no_register'=>$_SESSION['was_register'],
                                        'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],
                                        'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],
                                        'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],
                                        'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],
                                        'id_level4'=>$_SESSION['was_id_level4']])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    } 

    
}
