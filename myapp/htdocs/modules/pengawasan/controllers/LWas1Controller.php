<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\LWas1;
use app\modules\pengawasan\models\PegawaiTerlaporWas10;
use app\modules\pengawasan\models\LWas1Search;
use app\modules\pengawasan\models\KpInstSatker;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pengawasan\models\SpWas1;
use app\modules\pengawasan\models\PemeriksaSpWas1;
use app\modules\pengawasan\models\SaksiEksternal;
use app\modules\pengawasan\models\SaksiInternal;
use app\modules\pengawasan\models\DasarSpWas1;
use app\modules\pengawasan\models\LWas1Saran;
use app\modules\pengawasan\models\LWas1Pendapat;
use app\modules\pengawasan\models\VLWas1;
use app\modules\pengawasan\models\VPemeriksa;
use app\modules\pengawasan\models\VSaranLWas1;
use app\modules\pengawasan\models\VSaksiEksternal;
use app\modules\pengawasan\models\VSaksiInternal;
use app\modules\pengawasan\models\VDataLWas1;
use app\modules\pengawasan\models\DugaanPelanggaran;
use app\modules\pengawasan\models\DisposisiIrmud;

use app\modules\pengawasan\models\WasTrxPemrosesan;
use app\components\ConstSysMenuComponent;
use Odf;
use app\components\GlobalFuncComponent; 
use yii\db\Query;
use yii\db\Command;
/**
 * LWas1Controller implements the CRUD actions for LWas1 model.
 */
class LWas1Controller extends Controller {

  public function behaviors() {
    return [
        'verbs' => [
            'class' => VerbFilter::className(),
            'actions' => [
                'delete' => ['post'],
            ],
        ],
    ];
  }

  public function actionPopupSaksiEksternal() {

    $no_register = $_POST['no_register'];
    $alamat = $_POST['alamat'];
    $nama = $_POST['nama'];


    $view_pemberitahuan = $this->renderAjax('_saksiEksternal', [
        'no_register' => $no_register,
        'nama' => $nama,
        'alamat' => $alamat,
    ]);
    //   header('Content-Type: application/json; charset=utf-8');
    echo \yii\helpers\Json::encode(['view_' => $view_pemberitahuan]);
  }

  public function actionDetail($no_register, $peg_nip_baru, $peg_nama) {
    $searchModel = new VDataLWas1();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('detail', [  // ubah ini
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
    ]);
  }

  
  /**
   * Lists all LWas1 models.
   * @return mixed
   */
  public function actionIndex() {
   
    $query=LWas1::findOne(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
       
        if(count($query)>0){
          $this->redirect(\Yii::$app->urlManager->createUrl("pengawasan/l-was-1/update?id=".$query->id_l_was_1));
        }else{
          $this->redirect(\Yii::$app->urlManager->createUrl("pengawasan/l-was-1/create"));
        }
		 //$this->render('create');
  }

  /**
   * Displays a single LWas1 model.
   * @param string $id
   * @return mixed
   */
  public function actionView($id) {
    return $this->render('view', [
                'model' => $this->findModel($id),
    ]);

    
  }

  /**
   * Creates a new LWas1 model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate() {
   
        $query=LWas1::findOne(['no_register'=>$_SESSION['was_register']]);
        if(count($query)>0){
          $this->redirect(\Yii::$app->urlManager->createUrl("pengawasan/l-was-1/update?id=".$query->id_l_was_1));
        }else{
        $model = new LWas1();
        $searchModel = new LWas1Search();
        $dataProvider = $searchModel->searchTerlaorWas10($_SESSION['was_register']);
       
        if ($model->load(Yii::$app->request->post())) {
          // $model->id_l_was_1 = '1';
         
          // $pendapat = $_POST['pendapat'];

          $connection = \Yii::$app->db;
          $transaction = $connection->beginTransaction();
          try {
                  $model->no_register = $_SESSION['was_register'];
                  $model->id_tingkat  = $_SESSION['kode_tk'];
                  $model->id_kejati   = $_SESSION['kode_kejati'];
                  $model->id_kejari   = $_SESSION['kode_kejari'];
                  $model->id_cabjari  = $_SESSION['kode_cabjari'];
                  $model->created_ip=$_SERVER['REMOTE_ADDR'];
                  $model->created_by=\Yii::$app->user->identity->id;
                  $model->created_time=date('Y-m-d H:i:s');

            if ($model->save()) {
			
		
              
              $saran=$_POST['keputusan'];
              for ($i=0; $i <count($saran); $i++) { 
                $terlapor=PegawaiTerlaporWas10::findOne(['nip'=>$_POST['nip'][$i]]);
                  $modelLWas1Saran=new LWas1Saran();
                  $modelLWas1Saran->no_register = $_SESSION['was_register'];
                  $modelLWas1Saran->id_tingkat  = $_SESSION['kode_tk'];
                  $modelLWas1Saran->id_kejati   = $_SESSION['kode_kejati'];
                  $modelLWas1Saran->id_kejari   = $_SESSION['kode_kejari'];
                  $modelLWas1Saran->id_cabjari  = $_SESSION['kode_cabjari'];
                  $modelLWas1Saran->id_l_was_1=$model->id_l_was_1;
                  $modelLWas1Saran->nip_terlapor=$terlapor['nip'];
                  $modelLWas1Saran->nrp_terlapor=$terlapor['nrp_pegawai_terlapor'];
                  $modelLWas1Saran->nama_terlapor=$terlapor['nama_pegawai_terlapor'];
                  $modelLWas1Saran->pangkat_terlapor=$terlapor['pangkat_pegawai_terlapor'];
                  $modelLWas1Saran->golongan_terlapor=$terlapor['golongan_pegawai_terlapor'];
                  $modelLWas1Saran->jabatan_terlapor=$terlapor['jabatan_pegawai_terlapor'];
                  $modelLWas1Saran->satker_terlapor=$terlapor['satker_pegawai_terlapor'];
                  $modelLWas1Saran->saran_lwas1=$_POST['keputusan'][$i];
                  $modelLWas1Saran->created_ip=$_SERVER['REMOTE_ADDR'];
                  $modelLWas1Saran->created_by=\Yii::$app->user->identity->id;
                  $modelLWas1Saran->created_time=date('Y-m-d H:i:s');
                 
                  $modelLWas1Saran->save();
              }

              WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."' AND id_sys_menu='2013' AND user_id='".$_SESSION['is_inspektur_irmud_riksa']."'"); //was-2
                $arr = array(ConstSysMenuComponent::Was27Klari);
                $modelTrxPemrosesan=new WasTrxPemrosesan();
                $modelTrxPemrosesan->id_sys_menu=$arr[0];/*masuk was27*/
                $modelTrxPemrosesan->no_register=$_SESSION['was_register'];
                $modelTrxPemrosesan->id_user_login=$_SESSION['username'];
                $modelTrxPemrosesan->durasi=date('Y-m-d H:i:s');
                $modelTrxPemrosesan->created_by=\Yii::$app->user->identity->id;
                $modelTrxPemrosesan->created_ip=$_SERVER['REMOTE_ADDR'];
                $modelTrxPemrosesan->created_time=date('Y-m-d H:i:s');
                $modelTrxPemrosesan->updated_ip=$_SERVER['REMOTE_ADDR'];
                $modelTrxPemrosesan->updated_by=\Yii::$app->user->identity->id;
                $modelTrxPemrosesan->updated_time=date('Y-m-d H:i:s');
                $modelTrxPemrosesan->id_wilayah=$_SESSION['was_id_wilayah'];
                $modelTrxPemrosesan->id_level1=$_SESSION['was_id_level1'];
                $modelTrxPemrosesan->id_level2=$_SESSION['was_id_level2'];
                $modelTrxPemrosesan->id_level3=$_SESSION['was_id_level3'];
                $modelTrxPemrosesan->id_level4=$_SESSION['was_id_level4'];
                $modelTrxPemrosesan->save();
             
            }
            $transaction->commit();
           //  if($_POST['print']=='1'){
           // //   unset($_POST['action']);
           // // $this->redirect('lapdu/view?id=r001');
           //  $this->cetak($id);

           // }
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
            return $this->redirect(['update', 'id' => $model->id_l_was_1]);
          } catch (Exception $e) {
            $transaction->rollback();
          }
          //return $this->redirect(['view', 'id' => $model->id_l_was_1]);
        } else {
          return $this->render('create', [
                      'model' => $model,
                      'dataProvider' => $dataProvider,
                      // 'modelPegawaiterlapor' => $modelPegawaiterlapor,
                      // 'spwas1' => $spwas1,
          ]);
        }
      }
    }
    

  /**
   * Updates an existing LWas1 model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param string $id
   * @return mixed
   */
  public function actionUpdate($id) {
    /*random kode*/
    $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $res = "";
    for ($i = 0; $i < 10; $i++) {
        $res .= $chars[mt_rand(0, strlen($chars)-1)];
    }

    $query=LWas1::findOne(['no_register'=>$_SESSION['was_register']]);
        if(count($query)>0){

    $model = $this->findModel($id);
    $searchModel = new LWas1Search();
    $dataProvider = $searchModel->searchLwas1Saran($_SESSION['was_register']);
    if($dataProvider->getCount()<=0){
    $dataProvider = $searchModel->searchTerlaorWas10($_SESSION['was_register']);
    }
    $OldFile=$model->file_lwas1;
    if ($model->load(Yii::$app->request->post())) {

       $errors       = array();
       $file_name    = $_FILES['file_lwas1']['name'];
       $file_size    =$_FILES['file_lwas1']['size'];
       $file_tmp     =$_FILES['file_lwas1']['tmp_name'];
       $file_type    =$_FILES['file_lwas1']['type'];
       $ext = pathinfo($file_name, PATHINFO_EXTENSION);
       $tmp = explode('.', $_FILES['file_lwas1']['name']);
       $file_exists = end($tmp);
       $rename_file  =$_SESSION['is_inspektur_irmud_riksa'].'_'.$_SESSION['inst_satkerkd'].$res.'.'.$ext;


       $model->file_lwas1 = ($file_name==''?$OldFile:$rename_file);
       $model->updated_ip=$_SERVER['REMOTE_ADDR'];
       $model->updated_by=\Yii::$app->user->identity->id;
       $model->updated_time=date('Y-m-d H:i:s');
	   
      if ($model->save()) {
        if($OldFile!='' && file_exists($file_tmp) && file_exists(\Yii::$app->params['uploadPath'].'l_was_1/'.$OldFile)) {
          unlink(\Yii::$app->params['uploadPath'].'l_was_1/'.$OldFile);
      }
	  
        $saran=$_POST['keputusan'];
        if(count($saran)>=1){
         LWas1Saran::deleteAll(['id_l_was_1'=>$id,'no_register' => $_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
        }
              for ($i=0; $i <count($saran); $i++) { 
                $terlapor=PegawaiTerlaporWas10::findOne(['nip'=>$_POST['nip'][$i]]);
                  $modelLWas1Saran=new LWas1Saran();
                  $modelLWas1Saran->no_register = $_SESSION['was_register'];
                  $modelLWas1Saran->id_tingkat  = $_SESSION['kode_tk'];
                  $modelLWas1Saran->id_kejati   = $_SESSION['kode_kejati'];
                  $modelLWas1Saran->id_kejari   = $_SESSION['kode_kejari'];
                  $modelLWas1Saran->id_cabjari  = $_SESSION['kode_cabjari'];
                  $modelLWas1Saran->id_l_was_1=$model->id_l_was_1;
                  $modelLWas1Saran->nip_terlapor=$terlapor['nip'];
                  $modelLWas1Saran->nrp_terlapor=$terlapor['nrp_pegawai_terlapor'];
                  $modelLWas1Saran->nama_terlapor=$terlapor['nama_pegawai_terlapor'];
                  $modelLWas1Saran->pangkat_terlapor=$terlapor['pangkat_pegawai_terlapor'];
                  $modelLWas1Saran->golongan_terlapor=$terlapor['golongan_pegawai_terlapor'];
                  $modelLWas1Saran->jabatan_terlapor=$terlapor['jabatan_pegawai_terlapor'];
                  $modelLWas1Saran->satker_terlapor=$terlapor['satker_pegawai_terlapor'];
                  $modelLWas1Saran->saran_lwas1=$_POST['keputusan'][$i];
                  $modelLWas1Saran->created_ip=$_SERVER['REMOTE_ADDR'];
                  $modelLWas1Saran->created_by=\Yii::$app->user->identity->id;
                  $modelLWas1Saran->created_time=date('Y-m-d H:i:s');
                 
                  $modelLWas1Saran->save();
              }
                $arr = array(ConstSysMenuComponent::Was27Klari);

                WasTrxPemrosesan::deleteAll(['id_sys_menu'=>$arr[0],'no_register' => $_SESSION['was_register'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]); //was-2
                $modelTrxPemrosesan=new WasTrxPemrosesan();
                $modelTrxPemrosesan->id_sys_menu=$arr[0];/*masuk was27*/
                $modelTrxPemrosesan->no_register=$_SESSION['was_register'];
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

            // if($_POST['print']=='1'){
           //   unset($_POST['action']);
           // $this->redirect('lapdu/view?id=r001');
            // $this->printlwas($id);

          // }
        move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'l_was_1/'.$rename_file);
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
      }
      return $this->redirect(['update', 'id' => $model->id_l_was_1]);
    } else {
      return $this->render('update', [
                  'model' => $model,
                  'dataProvider' => $dataProvider,
      ]);
    }
  }else{
    $this->redirect(\Yii::$app->urlManager->createUrl("pengawasan/l-was-1/create"));
  }
  }

  /**
   * Deletes an existing LWas1 model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param string $id
   * @return mixed
   */
  public function actionDelete($id) {
    $this->findModel($id)->delete();
    /*dalam bisnis proses tidak ada delete jika ada maka aktifkan kode di bawah*/
    //         $var=str_split($_SESSION['is_inspektur_irmud_riksa']);
    //     $connection = \Yii::$app->db;
    //     $query1 = "select * from was.was_disposisi_irmud where no_register='".$_SESSION['was_register']."'";
    //     $disposisi_irmud = $connection->createCommand($query1)->queryAll(); 

    //     for ($i=0;$i<count($disposisi_irmud);$i++){
        
    //     $saveDisposisi = DisposisiIrmud::find()->where("no_register='".$_SESSION['was_register']."' and id_terlapor_awal='".$disposisi_irmud[$i]['id_terlapor_awal']."' and id_inspektur='".$var[0]."' and id_irmud='".$var[1]."'")->one();
    //     if($var[2]==1){
    //         $connection = \Yii::$app->db;
    //         $query1 = "update was.was_disposisi_irmud set status_pemeriksa1='BA.WAS-3' where id_terlapor_awal='".$saveDisposisi['id_terlapor_awal']."'";
    //         $disposisi_irmud = $connection->createCommand($query1);
    //         $disposisi_irmud->execute();
    //     }
    //     if($var[2]==2){
    //         $connection = \Yii::$app->db;
    //         $query1 = "update was.was_disposisi_irmud set status_pemeriksa2='BA.WAS-3' where id_terlapor_awal='".$saveDisposisi['id_terlapor_awal']."'";
    //         $disposisi_irmud = $connection->createCommand($query1);
    //         $disposisi_irmud->execute();
    //     // }    
    //     }  
    //     $arr = array(ConstSysMenuComponent::Was27Klari);
    // for ($i=0; $i < 1 ; $i++) { 
    //         WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."' AND id_sys_menu='".$arr[$i]."' AND user_id='".$_SESSION['is_inspektur_irmud_riksa']."'");
    
    // } 

    // }

    return $this->redirect(['index']);
  }
  
  public function actionHapus() {
    $id_l_was_1 = $_GET['id'];
    if (LWas1::updateAll(["flag" => '3'], "id_l_was_1 ='" . $id_l_was_1 . "'")) {
      \app\modules\pengawasan\models\TembusanLWas1::updateAll(["flag" => '3'], "id_l_was_1 ='" . $id_l_was_1 . "'");
      LWas1Pendapat::updateAll(["flag" => '3'], "id_l_was_1 ='" . $id_l_was_1 . "'");
      LWas1Saran::updateAll(["flag" => '3'], "id_l_was_1 ='" . $id_l_was_1 . "'");
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
          'message' => 'Data Gagal Dihapus',
          'title' => 'Error',
          'positonY' => 'top',
          'positonX' => 'center',
          'showProgressbar' => true,
      ]);
    }
    return $this->redirect(['create']);
  }

  /**
   * Finds the LWas1 model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param string $id
   * @return LWas1 the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id) {
    if (($model = LWas1::findOne(['id_l_was_1'=>$id,'no_register' => $_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']])) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('The requested page does not exist.');
    }
  }


  public function actionViewpdf($id){
      // echo  \Yii::$app->params['uploadPath'].'lapdu/230017577_116481.pdf';
        // echo 'cms_simkari/modules/pengawasan/upload_file/lapdu/230017577_116481.pdf';
      // $filename = $_GET['filename'] . '.pdf';
       $file_upload=$this->findModel($id);
        // print_r($file_upload['file_lwas1']);
          $filepath = '../modules/pengawasan/upload_file/l_was_1/'.$file_upload['file_lwas1'];
        $extention=explode(".", $file_upload['file_lwas1']);
           if($extention[1]=='jpg' || $extention[1]=='jpeg' || $extention[1]=='png'){
            return Yii::$app->response->sendFile($filepath);
           }else{
          if(file_exists($filepath))
          {
              // Set up PDF headers
              header('Content-type: application/pdf');
              header('Content-Disposition: inline; filename="' . $file_upload['file_lwas1'] . '"');
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

   public function actionPrintlwas($id_l_was_1){
       $model=$this->findModel($id_l_was_1);
       $modelSpWas1=SpWas1::findOne(['no_register' => $model->no_register,'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
       $modelPemeriksaSpWas1=PemeriksaSpWas1::findAll(['id_sp_was1' => $modelSpWas1->id_sp_was1,'no_register' => $model->no_register,'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
       // $SaksiEksternal=SaksiEksternal::findAll(['no_register'=>$model->no_register,'from_table'=>'WAS-9']);
       // $SaksiInternal=SaksiInternal::findAll(['no_register'=>$model->no_register,'from_table'=>'WAS-9']);
       /*dalam contoh adalah terlapor*/
       $connection = \Yii::$app->db;
       $sqlterlapor = "select b.peg_nip_baru as nip_pegawai_terlapor,
                              b.nama as nama_pegawai_terlapor,
                              b.nip_nrp as nrp_pegawai_terlapor,
                              b.gol_pangkat2 as pangkat_pegawai_terlapor,
                              b.gol_kd as golongan_pegawai_terlapor,
                              b.jabatan as jabatan_pegawai_terlapor

        from was.l_was_1_saran a 
                        left join kepegawaian.kp_pegawai b on a.nip_terlapor=b.peg_nip_baru
                        where a.no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'";

       $modelTerlapor = $connection->createCommand($sqlterlapor)->queryAll();
       $DasarSpwas1=DasarSpWas1::findAll(['id_sp_was1' => $modelSpWas1->id_sp_was1]);
       $modelSatker=KpInstSatker::findOne(['inst_satkerkd' => $_SESSION['inst_satkerkd']]);

      return $this->render('cetak2',[
            'model'=>$model,
            'modelSpWas1'=>$modelSpWas1,
            'modelPemeriksaSpWas1'=>$modelPemeriksaSpWas1,
            // 'SaksiEksternal'=>$SaksiEksternal,
            // 'SaksiInternal'=>$SaksiInternal,
            'modelTerlapor'=>$modelTerlapor,
            'modelSatker'=>$modelSatker,
        ]);
    }

   

}
