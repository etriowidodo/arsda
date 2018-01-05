<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\Was12;
use app\modules\pengawasan\models\Was12Search;
use app\modules\pengawasan\models\terlaporWas12;
use app\modules\pengawasan\models\PemeriksaWas12;
use app\modules\pengawasan\models\Was10;
use app\modules\pengawasan\models\Was12Detail;
use app\modules\pengawasan\models\SpWas1;
use app\modules\pengawasan\models\TembusanWas2;/*mengambil dari transaksi ketika update*/
use app\modules\pengawasan\models\TembusanWas;/*mengambil dari master ketika create*/
use app\modules\pengawasan\models\DisposisiIrmud;

use app\models\KpInstSatker;
use app\models\KpInstSatkerSearch;
use app\components\GlobalFuncComponent; 
use app\modules\pengawasan\components\FungsiComponent; 

use Odf;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\grid\GridView;
use yii\widgets\Pjax;

/**
 * Was12Controller implements the CRUD actions for Was12 model.
 */
class Was12Controller extends Controller
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
     * Lists all Was12 models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Was12Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		//print_r($dataProvider);
		//exit();
		
        return $this->render('index', [
            //'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
		
    }

    /**
     * Displays a single Was12 model.
     * @param string $id_was10
     * @param string $id_was_12
     * @return mixed
     */
    public function actionView($id_was10, $id_was_12)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_was10, $id_was_12),
        ]);
    }

    /**
     * Creates a new Was12 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
	   $var=str_split($_SESSION['is_inspektur_irmud_riksa']);

    $model = new Was12();
    $modelTembusanMaster = TembusanWas::find()->where("for_tabel=:condition1 OR for_tabel=:condition2", [":condition1" => 'was_10','condition2'=>'master'])->all();
        if ($model->load(Yii::$app->request->post())) {
		 $connection = \Yii::$app->db;
		try {

            $errors       = array();
            $file_name    = $_FILES['was12_file']['name'];
            $file_size    =$_FILES['was12_file']['size'];
            $file_tmp     =$_FILES['was12_file']['tmp_name'];
            $file_type    =$_FILES['was12_file']['type'];
            $ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $tmp = explode('.', $_FILES['was12_file']['name']);
            $file_exists = end($tmp);
            $rename_file  =$_SESSION['is_inspektur_irmud_riksa'].'_'.$_SESSION['inst_satkerkd'].$res.'.'.$ext;

      $transaction = $connection->beginTransaction();
   
            /*save ke table was12*/
            $model->no_register=$_SESSION['was_register'];
            $model->id_tingkat=$_SESSION['kode_tk'];
            $model->id_kejati=$_SESSION['kode_kejati'];
            $model->id_kejari=$_SESSION['kode_kejari'];
            $model->id_cabjari=$_SESSION['kode_cabjari'];
            $model->created_ip = $_SERVER['REMOTE_ADDR'];
            $model->created_by = \Yii::$app->user->identity->id;
            $model->created_time = date('Y-m-d H:i:s');
      			$model->tanggal_was12 = date('Y-m-d',strtotime($_POST['Was12']['tanggal_was12']));
            $model->save();
			
			/*simpan Ke dalam was 12 detail*/
			
			 $nip =  $_POST['id_was10'];	
			for($g=0;$g<count($nip);$g++){
          $query="select*from was.v_was10 where no_register='".$_SESSION['was_register']."'and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and id_surat_was10='".$_POST['id_was10'][$g]."' and trx_akhir=1";
          $dataWas10 = $connection->createCommand($query)->queryOne();
         
					            $saveDetail = new Was12Detail();
                      $saveDetail->no_register=$_SESSION['was_register'];
                      $saveDetail->id_tingkat=$_SESSION['kode_tk'];
                      $saveDetail->id_kejati=$_SESSION['kode_kejati'];
                      $saveDetail->id_kejari=$_SESSION['kode_kejari'];
                      $saveDetail->id_cabjari=$_SESSION['kode_cabjari'];
                      $saveDetail->id_was_12_detail=$g;
                      $saveDetail->id_was_12=$model->id_was_12;
					            $saveDetail->id_was_10=$dataWas10['id_surat_was10'];
                      $saveDetail->nip_pegawai_terlapor=$dataWas10['nip'];
                      $saveDetail->nrp_pegawai_terlapor=$dataWas10['nrp_pegawai_terlapor'];
                      $saveDetail->nama_pegawai_terlapor=$dataWas10['nama_pegawai_terlapor'];
                      $saveDetail->golongan_pegawai_terlapor=$dataWas10['golongan_pegawai_terlapor'];
                      $saveDetail->pangkat_pegawai_terlapor=$dataWas10['pangkat_pegawai_terlapor'];
                      $saveDetail->jabatan_pegawai_terlapor=$dataWas10['jabatan_pegawai_terlapor'];
                      $saveDetail->nip_pemeriksa=$dataWas10['nip_pemeriksa'];
                      $saveDetail->nrp_pemeriksa=$dataWas10['nrp_pemeriksa'];
                      $saveDetail->nama_pemeriksa=$dataWas10['nama_pemeriksa'];
                      $saveDetail->pangkat_pemeriksa=$dataWas10['pangkat_pemeriksa']; 
                      $saveDetail->jabatan_pemeriksa= $dataWas10['jabatan_pemeriksa']; 
                      $saveDetail->golongan_pemeriksa=$dataWas10['jabatan_pemeriksa']; 
                      $saveDetail->hari_pemeriksaan=$dataWas10['hari_pemeriksaan_was10']; 
                      $saveDetail->tanggal_pemeriksaan=$dataWas10['tanggal_pemeriksaan_was10']; 
                      $saveDetail->jam_pemeriksaan=$dataWas10['jam_pemeriksaan_was10']; 
					            $saveDetail->tempat_pemeriksaan=$dataWas10['tempat_pemeriksaan_was10']; 
                      $saveDetail->created_ip = $_SERVER['REMOTE_ADDR'];
                      $saveDetail->created_time = date('Y-m-d H:i:s');
                      $saveDetail->created_by = \Yii::$app->user->identity->id;					  
                      $saveDetail->save(); 
                }
			
			$pejabat = $_POST['pejabat'];
           for($z=0;$z<count($pejabat);$z++){
                        $saveTembusan = new TembusanWas2;
                        $saveTembusan->from_table = 'Was-12';
                        $saveTembusan->pk_in_table = strrev($model->id_was_12);
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
			
      			$transaction->commit();
            // move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'was_12/'.$rename_file);
            Yii::$app->getSession()->setFlash('success', [
             'type' => 'success',
             'duration' => 3000,
             'icon' => 'fa fa-users',
             'message' => 'Data Berhasil Disimpan',
             'title' => 'Simpan Data',
             'positonY' => 'top',
             'positonX' => 'center',
             'showProgressbar' => true,
            ]);
              return $this->redirect(['index']);
            } catch(Exception $e) {
                $transaction->rollback();
                if(YII_DEBUG){throw $e; exit;} else{return false;}
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
            }
            
        } else {
            return $this->render('create', [
                'model' => $model,
        				'modelTembusanMaster' => $modelTembusanMaster,
        				'modelTembusan' => $modelTembusan,
                'pemeriksaWas12' => $pemeriksaWas12,
				        'modelWas10' => $modelWas10,
            ]);
        }
		
    }

    /**
     * Updates an existing Was12 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id_was10
     * @param string $id_was_12
     * @return mixed
     */
    public function actionUpdate($id)
    {
	$var=str_split($_SESSION['is_inspektur_irmud_riksa']);
  /*random kode*/
  $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  $res = "";
  for ($i = 0; $i < 10; $i++) {
      $res .= $chars[mt_rand(0, strlen($chars)-1)];
  }
  $fungsi=new FungsiComponent();
  $where=$fungsi->static_where();
        $model = $this->findModel($id);
        $modelTembusan=TembusanWas2::find()->where(['pk_in_table'=>$model->id_was_12,'from_table'=>'Was-12','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']])->orderBy('is_order desc')->all();
		
    $connection = \Yii::$app->db;
		$sql = "select*from was.was_12_detail where id_was_12='".$model->id_was_12."' and no_register='".$_SESSION['was_register']."'and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='". $_SESSION['kode_cabjari']."' $where";
    $modelTerlapor = $connection->createCommand($sql)->queryAll(); 
    
    $is_inspektur_irmud_riksa=$fungsi->gabung_where();/*karena ada perubahan kode*/  
    $OldFile=$model->was12_file;
		
    if ($model->load(Yii::$app->request->post())) {
            $connection = \Yii::$app->db;
           try {

                  $errors       = array();
                  $file_name    = $_FILES['was12_file']['name'];
                  $file_size    =$_FILES['was12_file']['size'];
                  $file_tmp     =$_FILES['was12_file']['tmp_name'];
                  $file_type    =$_FILES['was12_file']['type'];
                  $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                  $tmp = explode('.', $_FILES['was12_file']['name']);
                  $file_exists = end($tmp);
                  $rename_file  =$is_inspektur_irmud_riksa.'_'.$_SESSION['inst_satkerkd'].$res.'.'.$ext;

            $transaction = $connection->beginTransaction();
            
                $model->updated_ip = $_SERVER['REMOTE_ADDR'];
                $model->updated_by = \Yii::$app->user->identity->id;
                $model->updated_time = date('Y-m-d H:i:s');
                $model->tanggal_was12 = date('Y-m-d',strtotime($_POST['Was12']['tanggal_was12']));
                $model->was12_file = ($file_name==''?$OldFile:$rename_file);
                
            if($model->save()){
             if($OldFile!='' && file_exists($file_tmp) && file_exists(\Yii::$app->params['uploadPath'].'was_12/'.$OldFile)) {
                  unlink(\Yii::$app->params['uploadPath'].'was_12/'.$OldFile);
              }  
             
          $nip =  $_POST['id_was10'];  
          Was12Detail::deleteAll(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_was_12'=>$model->id_was_12,'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
          for($g=0;$g<count($nip);$g++){
              $query="select*from was.v_was10 where no_register='".$_SESSION['was_register']."'and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and id_surat_was10='".$_POST['id_was10'][$g]."' and trx_akhir=1 ";
              $dataWas10 = $connection->createCommand($query)->queryOne();


                          $saveDetail = new Was12Detail();
                          $saveDetail->no_register=$_SESSION['was_register'];
                          $saveDetail->id_tingkat=$_SESSION['kode_tk'];
                          $saveDetail->id_kejati=$_SESSION['kode_kejati'];
                          $saveDetail->id_kejari=$_SESSION['kode_kejari'];
                          $saveDetail->id_cabjari=$_SESSION['kode_cabjari'];
                          // $saveDetail->id_was_12_detail=$g;
                          $saveDetail->id_was_12=$model->id_was_12;
                          $saveDetail->id_was_10=$dataWas10['id_surat_was10'];
                          $saveDetail->nip_pegawai_terlapor=$dataWas10['nip'];
                          $saveDetail->nrp_pegawai_terlapor=$dataWas10['nrp_pegawai_terlapor'];
                          $saveDetail->nama_pegawai_terlapor=$dataWas10['nama_pegawai_terlapor'];
                          $saveDetail->golongan_pegawai_terlapor=$dataWas10['golongan_pegawai_terlapor'];
                          $saveDetail->pangkat_pegawai_terlapor=$dataWas10['pangkat_pegawai_terlapor'];
                          $saveDetail->jabatan_pegawai_terlapor=$dataWas10['jabatan_pegawai_terlapor'];
                          $saveDetail->nip_pemeriksa=$dataWas10['nip_pemeriksa'];
                          $saveDetail->nrp_pemeriksa=$dataWas10['nrp_pemeriksa'];
                          $saveDetail->nama_pemeriksa=$dataWas10['nama_pemeriksa'];
                          $saveDetail->pangkat_pemeriksa=$dataWas10['pangkat_pemeriksa']; 
                          $saveDetail->jabatan_pemeriksa= $dataWas10['jabatan_pemeriksa']; 
                          $saveDetail->golongan_pemeriksa=$dataWas10['jabatan_pemeriksa']; 
                          $saveDetail->hari_pemeriksaan=$dataWas10['hari_pemeriksaan_was10']; 
                          $saveDetail->tanggal_pemeriksaan=$dataWas10['tanggal_pemeriksaan_was10']; 
                          $saveDetail->jam_pemeriksaan=$dataWas10['jam_pemeriksaan_was10']; 
                          // $saveDetail->tempat_pemeriksaan=$dataWas10['tempat_pemeriksaan_was10'];             
                          $saveDetail->tempat_pemeriksaan='jakarta';             
                          $saveDetail->created_ip = $_SERVER['REMOTE_ADDR'];
                          $saveDetail->created_time = date('Y-m-d H:i:s');
                          $saveDetail->created_by = \Yii::$app->user->identity->id; 
                          
                          $saveDetail->save(); 
                    }
          
          $pejabat = $_POST['pejabat'];
          TembusanWas2::deleteAll(['from_table'=>'Was-12','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'pk_in_table'=>strrev($model->id_was_12),'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
               for($z=0;$z<count($pejabat);$z++){
                            $saveTembusan = new TembusanWas2;
                            $saveTembusan->from_table = 'Was-12';
                            $saveTembusan->pk_in_table = strrev($model->id_was_12);
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
      
        
             move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'was_12/'.$rename_file);
             $transaction->commit();
             Yii::$app->getSession()->setFlash('success', [
             'type' => 'success',
             'duration' => 3000,
             'icon' => 'fa fa-users',
             'message' => 'Data Berhasil Disimpan',
             'title' => 'Simpan Data',
             'positonY' => 'top',
             'positonX' => 'center',
             'showProgressbar' => true,
            ]);
              return $this->redirect(['index']);
        }

           } catch(Exception $e) {
                    $transaction->rollback();
                    if(YII_DEBUG){throw $e; exit;} else{return false;}
            }
        } else {
            return $this->render('update', [
          					'model' => $model,
          					'modelTembusanMaster' => $modelTembusanMaster,
          					'modelTembusan' => $modelTembusan,
          					'modelPemeriksa' => $modelPemeriksa,
                    'modelTerlapor' => $modelTerlapor,
          					'modelWas10' => $modelWas10,
				]);
        }	
    }

    /**
     * Deletes an existing Was12 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id_was10
     * @param string $id_was_12
     * @return mixed
     */
    public function actionHapus()
    {
      $id=$_POST['id_was12'];
      $jml=$_POST['jml'];
      for ($i=0; $i < $jml; $i++) { 
        $pecah=explode(',', $id);
        was12::deleteAll(['id_was_12'=>$pecah[$i],'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
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
      return $this->redirect(['index']);

    }
    
	
    /**
     * Finds the Was12 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id_was10
     * @param string $id_was_12
     * @return Was12 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */


    public function actionCetakdocx($no_register,$id,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari){
      $data_satker = KpInstSatkerSearch::findOne(['inst_satkerkd'=>$_SESSION['inst_satkerkd']]);/*lokasi dan nama kejaksaan*/
      $fungsi=new FungsiComponent();
      $where=$fungsi->static_where_alias('a');
      $connection = \Yii::$app->db;
      $query="select * FROM was.was_12 a where  
              a.no_register='".$no_register."' and a.id_tingkat='".$id_tingkat."' 
              and a.id_kejati='".$id_kejati."' 
              and a.id_kejari='".$id_kejari."' and a.id_cabjari='".$id_cabjari."'
              and a.id_was_12='".$id."' $where";
      $was12 = $connection->createCommand($query)->queryOne();
      
      $tgl_was_12=GlobalFuncComponent::tglToWord(date('Y-m-d', strtotime(date('d-m-Y', strtotime($was12['tanggal_was12'])))));
      $connection = \Yii::$app->db;
      $querySpwas1="select a.perihal_lapdu, b.jabatan_penandatangan,b.jbtn_penandatangan,b.nomor_sp_was1,b.tanggal_sp_was1 
                    from was.lapdu a inner join was.sp_was_1 b on a.no_register=b.no_register
                    where a.no_register='".$no_register."' and a.id_tingkat='".$id_tingkat."' 
                    and a.id_kejati='".$id_kejati."' 
                    and a.id_kejari='".$id_kejari."' and a.id_cabjari='".$id_cabjari."'";
      $resultSpwas1 = $connection->createCommand($querySpwas1)->queryOne();
      
      $query3 = "select a.*,b.* from was.pegawai_terlapor a
                    inner join was.sp_was_1 b
                    on a.id_sp_was1=b.id_sp_was1
                    and a.id_tingkat=b.id_tingkat
                    and a.id_kejati=b.id_kejati
                    and a.id_kejari=b.id_kejari
                    and a.id_cabjari=b.id_cabjari
                    where a.no_register='".$no_register."' and a.id_tingkat='".$id_tingkat."' 
                    and a.id_kejati='".$id_kejati."' 
                    and a.id_kejari='".$id_kejari."' and a.id_cabjari='".$id_cabjari."'
                    and a.id_sp_was1='".$id."' $where";
        $modelterlapor1 = $connection->createCommand($query3)->queryOne();
      //print_r($modelterlapor1);
      // exit();

      $sql="select a.* from was.was_12_detail a where a.no_register='".$no_register."' and a.id_tingkat='".$id_tingkat."' 
                    and a.id_kejati='".$id_kejati."' 
                    and a.id_kejari='".$id_kejari."' and a.id_cabjari='".$id_cabjari."' and a.id_was_12='".$id."' $where";
      $terlapor_was12 = $connection->createCommand($sql)->queryAll();

      $sql1="select a.nip_pemeriksa,a.nrp_pemeriksa,a.nama_pemeriksa,a.pangkat_pemeriksa,a.jabatan_pemeriksa,
            a.hari_pemeriksaan,a.jam_pemeriksaan,a.tempat_pemeriksaan,a.tanggal_pemeriksaan from was.was_12_detail a where a.no_register='".$no_register."' and a.id_tingkat='".$id_tingkat."' 
                    and a.id_kejati='".$id_kejati."' 
                    and a.id_kejari='".$id_kejari."' and a.id_cabjari='".$id_cabjari."' and a.id_was_12='".$id."' $where";
      $pemeriksa = $connection->createCommand($sql1)->queryAll();
     
      $tanggal=GlobalFuncComponent::tglToWord(date('Y-m-d', strtotime(date('d-m-Y', strtotime($pemeriksa->tanggal_pemeriksaan)))));
      $tgl_sp_was=GlobalFuncComponent::tglToWord(date('Y-m-d', strtotime(date('d-m-Y', strtotime($resultSpwas1['tanggal_sp_was1'])))));
      $query6 = "select a.* from was.tembusan_was a
                    where a.no_register='".$no_register."' and a.id_tingkat='".$id_tingkat."' 
                    and a.id_kejati='".$id_kejati."' 
                    and a.id_kejari='".$id_kejari."' and a.id_cabjari='".$id_cabjari."'
                    and a.pk_in_table='".$was12['id_was_12']."' and from_table='Was-12'  $where order by is_order desc";
      $tembusan_was12 = $connection->createCommand($query6)->queryAll();
    
        return $this->render('cetak',[
                      'data_satker'=>$data_satker,
                      'resultSpwas1'=>$resultSpwas1,
                      'modelterlapor'=>$modelterlapor,
                      'pemeriksa'=>$pemeriksa,
                      'was12'=>$was12,
                      'tgl_was_12'=>$tgl_was_12,
                      'tanggal'=>$tanggal,
                      'tgl_sp_was'=>$tgl_sp_was,
                      'tembusan_was12'=>$tembusan_was12,
                      'terlapor_was12'=>$terlapor_was12,
                      'terlapor_was12b'=>$terlapor_was12b
                      ]);
    }
	  public function actionViewpdf($id){
     
       $file_upload=$this->findModel($id);
        // print_r($file_upload['file_lapdu']);
          $filepath = '../modules/pengawasan/upload_file/was_12/'.$file_upload['was12_file'];
        $extention=explode(".", $file_upload['was12_file']);
           if($extention[1]=='jpg' || $extention[1]=='jpeg' || $extention[1]=='png'){
            return Yii::$app->response->sendFile($filepath);
           }else{
          if(file_exists($filepath))
          {
              // Set up PDF headers
              header('Content-type: application/pdf');
              header('Content-Disposition: inline; filename="' . $file_upload['was12_file'] . '"');
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


    public function actionGetttd(){
       
   $searchModelWas12 = new Was12Search();
   $dataProviderPenandatangan = $searchModelWas12->searchPenandatangan(Yii::$app->request->queryParams);
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
                                    return ['value' => $data['id_surat'],'class'=>'MPenandatangan_selection_one','json'=>$result];
                                    },
                            ],
                            
                         ],   

                    ]);
          Pjax::end();
          echo '<div class="modal-loading-new"></div>';
    }

   protected function findModel($id)
    {
        if (($model = Was12::findOne(['id_was_12'=>$id,'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
