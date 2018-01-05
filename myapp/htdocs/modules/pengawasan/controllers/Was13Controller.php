<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\Was13;
use app\modules\pengawasan\models\Was13Search;
use app\modules\pengawasan\models\TembusanWas13;
use app\modules\pengawasan\models\Was9;
use app\modules\pengawasan\models\Was10;
use app\modules\pengawasan\models\Was11;
use app\modules\pengawasan\models\Was12;
use app\modules\pengawasan\models\KpInstSatker;
use app\modules\pengawasan\models\DisposisiIrmud;
use app\modules\pengawasan\components\FungsiComponent;

use yii\web\UploadedFile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Odf;
use app\models\KpInstSatkerSearch;
use app\components\GlobalFuncComponent;

/**
 * Was13Controller implements the CRUD actions for Was13 model.
 */
class Was13Controller extends Controller {

  public function behaviors() {
    return [
        'verbs' => [
            'class' => VerbFilter::className(),
            'actions' => [
            //'delete' => ['post'],
            //['cetakWas'] => ['get'],
            ],
        ],
    ];
  }

  /**
   * Lists all Was13 models.
   * @return mixed
   */
  public function actionIndex() {
    $searchModel = new Was13Search();
    $dataProvider = $searchModel->searchIndex();

    // print_r(count($dataProvider));
    return $this->render('index', [
                'searchModel' => $searchModel,
                //'dataProvider' => $dataProvider,
    ]);
  }

  /**
   * Displays a single Was13 model.
   * @param string $id
   * @return mixed
   */
  public function actionView($id) {
    return $this->render('view', [
                'model' => $this->findModel($id),
    ]);
  }

  /**
   * Creates a new Was13 model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate() {
  $connection = \Yii::$app->db;
  $model = new Was13();
  $fungsi=new FungsiComponent();
  $where=$fungsi->static_where_alias('a');
  $sqlwas9="select a.id_surat_was9,a.nomor_surat_was9,b.nama_saksi_internal as nama_saksi,a.nama_pemeriksa,a.jenis_saksi,a.tanggal_was9,a.nama_penandatangan from was.was9 a inner join was.saksi_internal b on a.id_saksi=b.id_saksi_internal and a.jenis_saksi='Internal' and a.no_register=b.no_register and a.id_tingkat=b.id_tingkat and a.id_kejati=b.id_kejati and a.id_kejari=b.id_kejari
 and a.id_cabjari=b.id_cabjari and a.id_wilayah=b.id_wilayah and a.id_level1=b.id_level1 and a.id_level2=b.id_level2 and a.id_level3=b.id_level3 and a.id_level4=b.id_level4 where a.trx_akhir=1 and a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' and a.id_cabjari='".$_SESSION['kode_cabjari']."' $where
union
select a.id_surat_was9,a.nomor_surat_was9,b.nama_saksi_eksternal as nama_saksi,a.nama_pemeriksa,a.jenis_saksi,a.tanggal_was9,a.nama_penandatangan from was.was9 a inner join was.saksi_eksternal b on a.id_saksi=b.id_saksi_eksternal and a.jenis_saksi='Eksternal' and a.no_register=b.no_register and a.id_tingkat=b.id_tingkat and a.id_kejati=b.id_kejati and a.id_kejari=b.id_kejari
 and a.id_cabjari=b.id_cabjari and a.id_wilayah=b.id_wilayah and a.id_level1=b.id_level1 and a.id_level2=b.id_level2 and a.id_level3=b.id_level3 and a.id_level4=b.id_level4 where a.trx_akhir=1 and a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' and a.id_cabjari='".$_SESSION['kode_cabjari']."' $where";
	$modelWas9=$connection->createCommand($sqlwas9)->queryAll();	
	
        $modelWas10=Was10::findAll(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4'],'trx_akhir'=>1]);
  
  $sqlwas11="select a.*,(select string_agg(b.nama_saksi_eksternal,'#')  from was.was_11_detail_eks b where a.jenis_saksi='Ekternal' and a.id_surat_was11=b.id_was_11 and a.no_register=b.no_register and a.id_tingkat=b.id_tingkat and a.id_kejati=b.id_kejati and a.id_kejari=b.id_kejari
 and a.id_cabjari=b.id_cabjari and a.id_wilayah=b.id_wilayah and a.id_level1=b.id_level1 and a.id_level2=b.id_level2 and a.id_level3=b.id_level3 and a.id_level4=b.id_level4) as nama_saksi from was.was11 a inner join was.was_11_detail_eks b on a.id_surat_was11=b.id_was_11 and a.no_register=b.no_register and a.id_tingkat=b.id_tingkat and a.id_kejati=b.id_kejati and a.id_kejari=b.id_kejari
 and a.id_cabjari=b.id_cabjari and a.id_wilayah=b.id_wilayah and a.id_level1=b.id_level1 and a.id_level2=b.id_level2 and a.id_level3=b.id_level3 and a.id_level4=b.id_level4 where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' and a.id_cabjari='".$_SESSION['kode_cabjari']."' $where
  union
  select a.*,(select string_agg(b.nama_saksi_internal,'#') from was.was_11_detail_int b where a.jenis_saksi='Internal' and a.id_surat_was11=b.id_was_11 and a.no_register=b.no_register and a.id_tingkat=b.id_tingkat and a.id_kejati=b.id_kejati and a.id_kejari=b.id_kejari
 and a.id_cabjari=b.id_cabjari and a.id_wilayah=b.id_wilayah and a.id_level1=b.id_level1 and a.id_level2=b.id_level2 and a.id_level3=b.id_level3 and a.id_level4=b.id_level4) as nama_saksi from was.was11 a inner join was.was_11_detail_int b on a.id_surat_was11=b.id_was_11 and a.no_register=b.no_register and a.id_tingkat=b.id_tingkat and a.id_kejati=b.id_kejati and a.id_kejari=b.id_kejari
 and a.id_cabjari=b.id_cabjari and a.id_wilayah=b.id_wilayah and a.id_level1=b.id_level1 and a.id_level2=b.id_level2 and a.id_level3=b.id_level3 and a.id_level4=b.id_level4 where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' and a.id_cabjari='".$_SESSION['kode_cabjari']."' $where";

  $modelWas11=$connection->createCommand($sqlwas11)->queryAll();
  
  //$modelWas11=Was11::findAll(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);

  $sqlWas12="select a.id_was_12,a.no_surat,a.tanggal_was12,a.no_surat,a.nama_penandatangan,a.kepada_was12,
(select string_agg(nama_pegawai_terlapor,'#') as nama_pegawai_terlapor from was.was_12_detail where id_was_12=a.id_was_12 and no_register=a.no_register and id_tingkat=a.id_tingkat and id_kejati=a.id_kejati and id_kejari=a.id_kejari and id_cabjari=a.id_cabjari ) from was.was_12 a
									where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' and a.id_cabjari='".$_SESSION['kode_cabjari']."' $where";
  $modelWas12=$connection->createCommand($sqlWas12)->queryAll();  
  
   
    if ($model->load(Yii::$app->request->post())) {
      $connection = \Yii::$app->db;
      $transaction = $connection->beginTransaction();
   
      try {
     $model->no_register=$_SESSION['was_register']; 
     $model->created_by=\Yii::$app->user->identity->id;
     $model->created_ip=$_SERVER['REMOTE_ADDR'];
     $model->created_time=date('Y-m-d H:i:s');
     $model->tanggal_dikirim=date('Y-m-d', strtotime($_POST['Was13']['tanggal_dikirim']));
     $model->tanggal_diterima=date('Y-m-d', strtotime($_POST['Was13']['tanggal_diterima']));
	   $model->id_tingkat=$_SESSION['kode_tk']; 
	   $model->id_kejati=$_SESSION['kode_kejati']; 
	   $model->id_kejari=$_SESSION['kode_kejari']; 
	   $model->id_cabjari=$_SESSION['kode_cabjari']; 
     $model->save();
			
         
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
        return $this->redirect(['index']);
      } catch (Exception $e) {
        $transaction->rollback();
        if(YII_DEBUG){throw $e; exit;} else{return false;}
      }
    } else {
      return $this->render('create', [
                  'model' => $model,
                  'modelWas9' => $modelWas9,
                  'modelWas10' => $modelWas10,
                  'modelWas11' => $modelWas11,
                  'modelWas12' => $modelWas12,
      ]);
    }

    // echo "string";
  }
 
  /**
   * Updates an existing Was13 model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param string $id
   * @return mixed
   */
  public function actionUpdate($id,$id_surat) {
    $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $res = "";
    for ($i = 0; $i < 10; $i++) {
        $res .= $chars[mt_rand(0, strlen($chars)-1)];
    }

    $connection = \Yii::$app->db;
	  $model=$this->findModel($id,$id_surat);
    $fungsi=new FungsiComponent();
    $where=$fungsi->static_where_alias('a');
		$sqlwas9="select a.id_surat_was9,a.nomor_surat_was9,b.nama_saksi_internal as nama_saksi,a.nama_pemeriksa,a.jenis_saksi,a.tanggal_was9,a.nama_penandatangan from was.was9 a inner join was.saksi_internal b on a.id_saksi=b.id_saksi_internal and a.jenis_saksi='Internal'and a.no_register=b.no_register and a.id_tingkat=b.id_tingkat and a.id_kejati=b.id_kejati and a.id_kejari=b.id_kejari
 and a.id_cabjari=b.id_cabjari and a.id_wilayah=b.id_wilayah and a.id_level1=b.id_level1 and a.id_level2=b.id_level2 and a.id_level3=b.id_level3 and a.id_level4=b.id_level4 where a.trx_akhir=1 and a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' and a.id_cabjari='".$_SESSION['kode_cabjari']."' $where
union
select a.id_surat_was9,a.nomor_surat_was9,b.nama_saksi_eksternal as nama_saksi,a.nama_pemeriksa,a.jenis_saksi,a.tanggal_was9,a.nama_penandatangan from was.was9 a inner join was.saksi_eksternal b on a.id_saksi=b.id_saksi_eksternal and a.jenis_saksi='Eksternal' and a.no_register=b.no_register and a.id_tingkat=b.id_tingkat and a.id_kejati=b.id_kejati and a.id_kejari=b.id_kejari
 and a.id_cabjari=b.id_cabjari and a.id_wilayah=b.id_wilayah and a.id_level1=b.id_level1 and a.id_level2=b.id_level2 and a.id_level3=b.id_level3 and a.id_level4=b.id_level4 where a.trx_akhir=1 and a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' and a.id_cabjari='".$_SESSION['kode_cabjari']."' $where";
	$modelWas9=$connection->createCommand($sqlwas9)->queryAll();	

  $modelWas10=Was10::findAll(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4'],'trx_akhir'=>1]);
    
  $modelWas11=Was11::findAll(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
  
  $sqlWas12="select a.id_was_12,a.no_surat,a.tanggal_was12,a.no_surat,a.nama_penandatangan,a.kepada_was12,
(select string_agg(nama_pegawai_terlapor,'#') as nama_pegawai_terlapor from was.was_12_detail where id_was_12=a.id_was_12) from was.was_12 a
                  where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' and a.id_cabjari='".$_SESSION['kode_cabjari']."' $where";
  $modelWas12=$connection->createCommand($sqlWas12)->queryAll(); 
		
		$is_inspektur_irmud_riksa=$fungsi->gabung_where();/*karena ada perubahan kode*/         
    $OldFile=$model->was13_file;

      if ($model->load(Yii::$app->request->post())) {
          $connection = \Yii::$app->db;
          $transaction = $connection->beginTransaction();
       
      try {
			
       $file_name    = $_FILES['was13_file']['name'];
       $file_size    = $_FILES['was13_file']['size'];
       $file_tmp     = $_FILES['was13_file']['tmp_name'];
       $file_type    = $_FILES['was13_file']['type'];
       $ext = pathinfo($file_name, PATHINFO_EXTENSION);
       $tmp = explode('.', $_FILES['was13_file']['name']);
       $file_exists = end($tmp);
       $rename_file = $is_inspektur_irmud_riksa.'_'.$_SESSION[inst_satkerkd].'_'.$res.'.'.$ext;
       
	
	   
       $model->no_register=$_SESSION['was_register']; 
       $model->updated_ip=$_SERVER['REMOTE_ADDR'];
       $model->updated_by=\Yii::$app->user->identity->id;
       $model->updated_time=date('Y-m-d H:i:s');
       $model->tanggal_dikirim=date('Y-m-d', strtotime($_POST['Was13']['tanggal_dikirim']));
       $model->tanggal_diterima=date('Y-m-d', strtotime($_POST['Was13']['tanggal_diterima']));
       $model->was13_file = ($file_name==''?$OldFile:$rename_file);
       if($model->save()) {
           
            if($OldFile!='' && file_exists($file_tmp) && file_exists(\Yii::$app->params['uploadPath'].'was_13/'.$OldFile)) {
                unlink(\Yii::$app->params['uploadPath'].'was_13/'.$OldFile);
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
        move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'was_13/'.$rename_file);   
        return $this->redirect(['index']);
      } catch (Exception $e) {
        $transaction->rollback();
        if(YII_DEBUG){throw $e; exit;} else{return false;}
      } 
	  
    } else {

     return $this->render('update', [
                  'model' => $model,
                  'modelWas9' => $modelWas9,
                  'modelWas10' => $modelWas10,
				          'modelWas11' => $modelWas11,
                  'modelWas12' => $modelWas12,
      ]);
   }

  }

  public function actionUpdate2($id,$id_surat) {
    $model = Was13::findOne(array("id_was_13" => $id, "flag" => '1'));
    $model2 = Was13::findOne(array("id_was_13" => $id, "flag" => '1'));
    $model->persuratan = \app\modules\pengawasan\models\VDropWas13::findOne(['id_surat' => $model->id_surat])->persuratan;
    $model->updated_ip = Yii::$app->getRequest()->getUserIP();
    $model->inst_satkerkd = $_POST['inst_satkerkd'];
    $files = \yii\web\UploadedFile::getInstance($model, 'upload_file');

    if (empty($files)) {
      $model->upload_file = $model2->upload_file;
    } else {
      $model->upload_file = date('Y-m-d').$files->name;
    }

    $connection = \Yii::$app->db;
    $transaction = $connection->beginTransaction();
    try {
      if ($model->load(Yii::$app->request->post())) {
        if ($model->save()) {
          if ($files != false) {
            $path = \Yii::$app->params['uploadPath'] . 'was_13/' . date('Y-m-d').$files->name;
            $files->saveAs($path);
          }

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
        }
      }
      $transaction->commit();

      return $this->redirect(['create']);
    } catch (Exception $e) {
      $transaction->rollback();
    }
  }

  /**
   * Deletes an existing Was13 model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param string $id
   * @return mixed
   */
   
      
  public function actionDelete() {
	    $id  = explode(',', $_POST['id']);
        $jml=$_POST['jml'];
       
        
        for ($z=0; $z <$jml ; $z++) { 
        
			WAS13::deleteAll([
								  'id_was13'=>$id[$z],
								  'id_tingkat'=>$_SESSION['kode_tk'],
								  'id_kejati'=>$_SESSION['kode_kejati'],
								  'id_kejari'=>$_SESSION['kode_kejari'],
								  'id_cabjari'=>$_SESSION['kode_cabjari'],
								  'no_register'=>$_SESSION['was_register']
								  ]);
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
   * Finds the Was13 model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param string $id
   * @return Was13 the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id,$id_surat) {
	// $kode =explode(".",$id);
	if (($model = Was13::findOne(['id_surat'=>$id_surat,
								  'id_was13'=>$id,
								  'id_tingkat'=>$_SESSION['kode_tk'],
								  'id_kejati'=>$_SESSION['kode_kejati'],
								  'id_kejari'=>$_SESSION['kode_kejari'],
								  'id_cabjari'=>$_SESSION['kode_cabjari'],
								  'no_register'=>$_SESSION['was_register']
								  ])) !== null) {  // kalau cma satu-> findOne($id)
	//if (($model = Was13::findOne(['id_surat'=>$id])) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('The requested page does not exist.');
    }
  }

  public function actionCetakwas($id,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari,$no_register) {
     $data_satker = KpInstSatkerSearch::findOne(['inst_satkerkd'=>$_SESSION['inst_satkerkd']]);/*lokasi dan nama kejaksaan*/
     $fungsi=new FungsiComponent();
     $where=$fungsi->static_where_alias('a');
      $connection = \Yii::$app->db;
      $query="select * FROM was.was13 a where  
              a.no_register='".$no_register."' and a.id_tingkat='".$id_tingkat."' 
              and a.id_kejati='".$id_kejati."' 
              and a.id_kejari='".$id_kejari."' and a.id_cabjari='".$id_cabjari."'
              and a.id_was13='".$id."' $where";
      $was13 = $connection->createCommand($query)->queryOne();
      $tgl_terima=GlobalFuncComponent::tglToWord(date('Y-m-d', strtotime(date('d-m-Y', strtotime($was13['tanggal_diterima'])))));
      $tgl_surat =GlobalFuncComponent::tglToWord(date('Y-m-d', strtotime(date('d-m-Y', strtotime($was13['tanggal_surat'])))));
      $hari=GlobalFuncComponent::getNamaHari($was13['tanggal_diterima']);

      // print_r($tgl_terima);
      //  exit();
       
        return $this->render('cetak',[
                      'data_satker'=>$data_satker,
                      'was13'=>$was13,
                      'hari'=>$hari,
                      'tgl_surat'=>$tgl_surat,
                      'tgl_terima'=>$tgl_terima
                      ]);
  }

  
  protected function Cetak($id) {
    $odf = new Odf(Yii::$app->params['reportPengawasan']."was13.odt");
    $was13=$this->findModel($id);
    $modelSatker=KpInstSatker::find(['inst_satkerkd'=>$_SESSION['inst_satkerkd']])->one();
    // $was13 = \app\modules\pengawasan\models\VWas13::findOne(['id_was13' => $id]);
    // print_r($was13); exit();

    $odf->setVars('kejaksaan', $modelSatker->inst_nama);
    $odf->setVars('hari', GlobalFuncComponent::getNamaHari($was13->tanggal_diterima));
    $odf->setVars('tgl_was13', date('d F Y', strtotime($was13->tanggal_diterima)));
    $odf->setVars('pengirim', $was13->nama_pengirim);
    $odf->setVars('no_surat', $was13->no_surat);
    $odf->setVars('tgl_surat', date('d F Y', strtotime($was13->tanggal_surat)));
    $odf->setVars('kepada', $was13->kepada);
    // $odf->setVars('dar', $was13->kepada);
    $odf->setVars('menerima_nama', $was13->nama_penerima);

    //$odf->exportAsAttachedFile("WAS13-TandaTerima.odt");
    $odf->exportAsAttachedFile("WAS13.odt");
  }

  public function actionViewpdf($id_was13,$id_surat){
    
       $file_upload=$this->findModel($id_was13,$id_surat);
          $filepath = '../modules/pengawasan/upload_file/was_13/'.$file_upload['was13_file'];
        $extention=explode(".", $file_upload['was13_file']);
           if($extention[1]=='jpg' || $extention[1]=='jpeg' || $extention[1]=='png'){
            return Yii::$app->response->sendFile($filepath);
           }else{
          if(file_exists($filepath))
          {
              // Set up PDF headers
              header('Content-type: application/pdf');
              header('Content-Disposition: inline; filename="' . $file_upload['was13_file'] . '"');
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

}
