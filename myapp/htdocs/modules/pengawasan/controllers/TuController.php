<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\Was1;
use app\modules\pengawasan\models\Was1Search;

use app\modules\pengawasan\models\Lapdu;
use app\modules\pengawasan\models\LapduSearch;

use app\modules\pengawasan\models\Terlapor;
use app\modules\pengawasan\models\TerlaporSearch;

use app\modules\pengawasan\models\Pelapor;
use app\modules\pengawasan\models\PelaporSearch;

use app\modules\pengawasan\models\Was1Pemeriksa;
use app\modules\pengawasan\models\Was1PemeriksaSearch;

use app\components\ConstSysMenuComponent;
use app\modules\pengawasan\models\WasTrxPemrosesan;
use app\modules\pengawasan\models\SpWas2;
use app\modules\pengawasan\models\SpWas2Search;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\GlobalFuncComponent; 
use yii\web\UploadedFile;
use yii\db\Query;
use yii\db\Command;
use Odf;
use yii\web\Session;

/**
 * Was1Controller implements the CRUD actions for Was1 model.
 */
class TuController extends Controller
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
     * Lists all Was1 models.
     * @return mixed
     */
    public function actionIndex()
    {
         
         $searchModel = new SpWas2Search();
         $dataProvider = $searchModel->searchTu(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
	

    /**
     * Displays a single Was1 model.
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
     * Creates a new Was1 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    //  print_r($_SESSION);  
     // exit();
        return $this->render('create');
    }

    public function actionIndex1($id,$wil,$lv1,$lv2,$lv3,$lv4)
    {

           $session = Yii::$app->session;
           $key  = $id;
           $key1 = $wil;
           $key2 = $lv1;
           $key3 = $lv2;
           $key4 = $lv3;
           $key5 = $lv4;
           $session->set('was_register', $key);
           $session->set('id_wil', $key1);
           $session->set('id_level_1', $key2);
           $session->set('id_level_2', $key3);
           $session->set('id_level_3', $key4);
           $session->set('id_level_4', $key5);
           $this->redirect(\Yii::$app->urlManager->createUrl("pengawasan/tu/create"));
    }
    // public function actionSimpan()
    // {
    //     $model = new Was1();
    //     if ($model->load(Yii::$app->request->post())){
          
    //         if($model->save()){

    //                             Yii::$app->getSession()->setFlash('success', [
    //                  'type' => 'success',
    //                  'duration' => 3000,
    //                  'icon' => 'fa fa-users',
    //                  'message' => 'Data Berhasil di Simpan',
    //                  'title' => 'Update Data',
    //                  'positonY' => 'top',
    //                  'positonX' => 'center',
    //                   'showProgressbar' => true,
    //              ]);
    //                         return $this->redirect(['update', 'id' => $model->no_register,'option'=>$model->id_level_was1]);
    //                         }else{
    //                              Yii::$app->getSession()->setFlash('success', [
    //                  'type' => 'danger',
    //                  'duration' => 3000,
    //                  'icon' => 'fa fa-users',
    //                  'message' => 'Data Gagal di Update',
    //                  'title' => 'Error',
    //                  'positonY' => 'top',
    //                  'positonX' => 'center',
    //                  'showProgressbar' => true,
    //              ]);
    //                         return $this->redirect(['update', 'id' => $model->no_register,'option'=>$model->id_level_was1]);
    //         }

    //         }
    // }

    /**
     * Updates an existing Was1 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id,$option)
    {   
        if($option=='0'){
        $view='_form';
        }else if($option=='1'){
        $view='_form_pemeriksa';
        }else if($option=='2'){
        $view='_form_irmud';
        }else if($option=='3'){
        $view='_form_inspektur';
        }
        // $session = Yii::$app->session; 
        // $session->remove('was_register');
        // $session->set('was_register', $noreg);
        // $tglcetak=$_POST['Was1']['tgl_cetak'];

        // $tempat='Jakarta';
        // $tglcetak='2016-09-20';
        //  $modelWas1= Was1::findBysql("SELECT max(id_level_was1) as id_level_was1 FROM was.was1 where no_register='".$id."'")
        //            // ->where(['no_register'=>$_SESSION['was_register']])
        //            ->all();
        // if($modelWas1[0]['id_level_was1']=='1'){
        //     $modelLoad = $this->findModelByNoreg($id,$modelWas1[0]['id_level_was1']);
        //     // print_r($modelLoad['was1_perihal']);
        //     // exit();
        //     $loadWas1=$modelLoad;
        // }else if($modelWas1[0]['id_level_was1']=='2'){
        //      $modelLoad = $this->findModelByNoreg($id,'1');
        //     // print_r($modelLoad['was1_perihal']);
        //     // exit();
        //     $loadWas1=$modelLoad;
        // }

        $tempat=$_POST['Was1']['tempat'];
        if($_POST['Was1']['tgl_cetak']=='' OR empty($_POST['Was1']['tgl_cetak'])){
            $tglcetak=date('Y-m-d');
        }else{
            $tglcetak=$_POST['Was1']['tgl_cetak'];
        }
        $model= $this->findModelByNoreg($id,$option);
        // $model = Was1::findBysql("SELECT a.*, b.isi_saran_was1 as isi_saran_was1 FROM was.was1 a inner join was.saran_was1 b ON a.id_saran = b.id_saran_was1 WHERE a.no_register='".$id."' AND a.id_level_was1='".$option."'")->one();
        $query= new Query;
        $query->select("a.*,b.isi_saran_was1")
              ->from('was.was1 a')
              ->join("inner join","was.saran_was1 b","a.id_saran = b.id_saran_was1")
                // ->join("left join", "was.terlapor_awal b" , "a.no_register=b.no_register")
                   ->where(['a.no_register'=>$id])
                   ->andWhere(['a.id_level_was1'=>$option]);
        $modelSaran = $query->one();
        // $model=new query();
        $modelLapdu= Lapdu::find()
                   ->where(['no_register'=>$id])
                   ->all();

        


        $Terlpaor = new Query;
        $Terlpaor2 = new Query;
        $Terlpaor->select("a.nama_terlapor_awal,b.nama_kejagung_bidang as wilayah_pelanggaran")
                ->from("was.terlapor_awal a")
                ->join("inner join","was.kejagung_bidang b","a.id_bidang_kejati = b.id_kejagung_bidang")
                // ->join("left join", "was.terlapor_awal b" , "a.no_register=b.no_register")
                   ->where(['a.no_register'=>$id])
                   ->andWhere(['a.id_wilayah'=>'0']);

        $Terlpaor2->select("a.nama_terlapor_awal,b.nama_kejati as wilayah_pelanggaran")
                ->from("was.terlapor_awal a")
                ->join("inner join","was.kejati b","a.id_bidang_kejati = b.id_kejati")
                // ->join("left join", "was.terlapor_awal b" , "a.no_register=b.no_register")
                   ->where(['a.no_register'=>$id])
                   ->andWhere('a.id_wilayah != :del', ['del'=>'0']);
         $modelTerlapor=$Terlpaor->union($Terlpaor2)->all();
       
        $oldFileName = $model->file_disposisi_irmud;
        $oldFileName2 = $model->file_disposisi_inspektur;
        $oldFileName3 = $model->file_disposisi_jamwas;
        //$oldFile = (isset($model->file_disposisi_irmud) ? Yii::$app->params['uploadPath'] .'was_1/'. $model->file_disposisi_irmud : null);
        

        // $tmp_id='2';
        // $model_1 = $this->findModel($tmp_id);
        if ($model->load(Yii::$app->request->post())){
             $files = \yii\web\UploadedFile::getInstance($model,'file_disposisi_irmud');
             $files1 = \yii\web\UploadedFile::getInstance($model,'file_disposisi_inspektur');
             $files2 = \yii\web\UploadedFile::getInstance($model,'file_disposisi_jamwas');
           
               
            // print_r($model);
            // exit();
             if ($files == false) {
                $model->file_disposisi_irmud = $oldFileName;
            }else{
                $model->file_disposisi_irmud = $files->name;
            }

             if ($files1 == false) {
                $model->file_disposisi_inspektur = $oldFileName2;
            }else{
                $model->file_disposisi_inspektur = $files1->name;
            }

             if ($files2 == false) {
                $model->file_disposisi_jamwas = $oldFileName3;
            }else{
                $model->file_disposisi_jamwas = $files2->name;
            }

             if($model->id_level_was1=='1'){
                $model->was1_tgl_surat=$_POST['Was1']['tgl_cetak'];
                $model->no_surat='-';
             }
             // print_r($model->id_level_was1);
             // exit();

            $model->updated_time = date('Y-m-d H:i:s');
            $model->updated_ip = $_SERVER['REMOTE_ADDR'];
            $model->updated_by = \Yii::$app->user->identity->id;
			$model->inst_satkerkd = $_SESSION['inst_satkerkd'];
            if($model->save(false)) {
            // if ($files != false && !empty($oldFileName)) { // delete old and overwrite
            if ($files != false) { // delete old and overwrite
                // unlink($oldFile);
                $path = \Yii::$app->params['uploadPath'].'was_1/irmud/'.$files->name;
                $files->saveAs($path);
            }

            if ($files1 != false) { // delete old and overwrite
                // unlink($oldFile);
                $path = \Yii::$app->params['uploadPath'].'was_1/inspektur/'.$files1->name;
                $files1->saveAs($path);

            }

            if ($files2 != false) { // delete old and overwrite
                // unlink($oldFile);
                $path = \Yii::$app->params['uploadPath'].'was_1/jamwas/'.$files2->name;
                $files2->saveAs($path);

            }
                if($model->id_level_was1=='3' AND $model->tgl_disposisi_jamwas!=null){
                    if($model->id_saran=='2'){
                        WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."' AND id_sys_menu='2004' AND user_id='".$_SESSION['is_inspektur_irmud_riksa']."'");
                    }else if($model->id_saran=='3'){
                        WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."' AND id_sys_menu='2005' AND user_id='".$_SESSION['is_inspektur_irmud_riksa']."'");
                    }else if($model->id_saran=='5'){
                        WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."' AND id_sys_menu='2007' AND user_id='".$_SESSION['is_inspektur_irmud_riksa']."'");
                    }else if($model->id_saran=='6'){
                        WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."' AND id_sys_menu='2015' AND user_id='".$_SESSION['is_inspektur_irmud_riksa']."'");
                    }
                $arr = array(ConstSysMenuComponent::Was2, ConstSysMenuComponent::Was3, ConstSysMenuComponent::Spwas1, ConstSysMenuComponent::Spwas2);
                $modelTrxPemrosesan=new WasTrxPemrosesan();
                $modelTrxPemrosesan->no_register=$_SESSION['was_register'];
                if($model->id_saran=='2'){
                $modelTrxPemrosesan->id_sys_menu=$arr[0];/*masuk was2*/
                }else if($model->id_saran=='3'){
                $modelTrxPemrosesan->id_sys_menu=$arr[1];/*masuk was3*/
                }else if($model->id_saran=='5'){
                $modelTrxPemrosesan->id_sys_menu=$arr[3];/*masuk Sp-was1*/
                }else if($model->id_saran=='6'){
                $modelTrxPemrosesan->id_sys_menu=$arr[4];/*masuk Sp-was2*/
                }
                $modelTrxPemrosesan->id_user_login=$_SESSION['username'];
                $modelTrxPemrosesan->durasi=date('Y-m-d H:i:s');
                $modelTrxPemrosesan->created_by=\Yii::$app->user->identity->id;
                $modelTrxPemrosesan->created_ip=$_SERVER['REMOTE_ADDR'];
                $modelTrxPemrosesan->created_time=date('Y-m-d H:i:s');
                $modelTrxPemrosesan->updated_ip=$_SERVER['REMOTE_ADDR'];
                $modelTrxPemrosesan->updated_by=\Yii::$app->user->identity->id;
                $modelTrxPemrosesan->updated_time=date('Y-m-d H:i:s');
                $modelTrxPemrosesan->user_id=$_SESSION['is_inspektur_irmud_riksa'];
                $modelTrxPemrosesan->save();
                }

            // print_r($modelTrxPemrosesan->save());
            // print_r(\Yii::$app->user->identity->id);
            // exit();
            if($_POST['print']=='1'){
           //   unset($_POST['action']);
           // $this->redirect('lapdu/view?id=r001');
            $this->cetak($id,$option,$tempat,$tglcetak);
            // exit();
           }
           // else 
           if($_POST['print_1']=='3'){
             $this->cetak2($id,$option);

           }
        
              Yii::$app->getSession()->setFlash('success', [
     'type' => 'success',
     'duration' => 3000,
     'icon' => 'fa fa-users',
     'message' => 'Data Berhasil di Simpan',
     'title' => 'Update Data',
     'positonY' => 'top',
     'positonX' => 'center',
      'showProgressbar' => true,
 ]);
            return $this->redirect('index1?id='.$model->no_register);


            }else{
                 Yii::$app->getSession()->setFlash('success', [
     'type' => 'danger',
     'duration' => 3000,
     'icon' => 'fa fa-users',
     'message' => 'Data Gagal di Update',
     'title' => 'Error',
     'positonY' => 'top',
     'positonX' => 'center',
     'showProgressbar' => true,
 ]);
              return $this->redirect(['update', 'id' => $model->no_register,'option'=>$model->id_level_was1]);
            }
             
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelLapdu' => $modelLapdu,
                'modelTerlapor' => $modelTerlapor,
                'view' => $view,
                // 'modelWas1' => $modelWas1,
                // 'loadWas1' => $loadWas1,
            ]);
        }
    }

     /**
     * Deletes an existing Was1 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {
 //        $id = $_POST['id'];
 //         $transaction = Yii::$app->db->beginTransaction();
 //        try {
 //        $updateData = $this->findModel($id);
 //        $updateData->flag = 3;
 //        $updateData->save();
 //         $transaction->commit();
      
 //         Yii::$app->getSession()->setFlash('success', [
 //     'type' => 'success',
 //     'duration' => 3000,
 //     'icon' => 'fa fa-users',
 //     'message' => 'Data Berhasil di Hapus',
 //     'title' => 'Hapus Data',
 //     'positonY' => 'top',
 //     'positonX' => 'center',
 //     'showProgressbar' => true,
 // ]);
 //        return $this->redirect('create');
 //          } catch(Exception $e) {
 //            $transaction->rollBack();

 //            Yii::$app->getSession()->setFlash('success', [
 //                'type' => 'danger', //String, can only be set to danger, success, warning, info, and growl
 //                'duration' => 5000, //Integer //3000 default. time for growl to fade out.
 //                'icon' => 'glyphicon glyphicon-ok-sign', //String
 //                'message' => 'Data Gagal Dihapus', // String
 //                'title' => 'Delete', //String
 //                'positonY' => 'top', //String // defaults to top, allows top or bottom
 //                'positonX' => 'center', //String // defaults to right, allows right, center, left
 //                'showProgressbar' => true,
 //            ]);

 //            return $this->redirect('create');
 //        }
        $id=$_POST['id'];
        $jml=$_POST['jml'];
        $check=explode(",",$id);
        // $modelPelapor = new Pelapor();
        // $modelTerlapor = new Terlapor();
        for ($i=0; $i <$jml ; $i++) { 
        
            // Pelapor::deleteAll("no_register = '".$check[$i]."'");
            // Terlapor::deleteAll("no_register = '".$check[$i]."'");
            Was1::deleteAll("id_was1 = '".$check[$i]."'");
    }
         // return $this->redirect(['index1?id='.$_SESSION['was_register']]);
        $this->redirect(\Yii::$app->urlManager->createUrl("pengawasan/was1/index1?id=".$_SESSION['was_register']));
    }
    
    
    protected function Cetak($id,$option,$tempat,$tglcetak){

        // $model= $this->findModelByNoreg($id,$option);

        $model = Was1::findBysql("SELECT a.*,left(a.nip_penandatangan,8)||' '||substring(a.nip_penandatangan,9,6)||''||substring(a.nip_penandatangan,15,1)||''||substring(a.nip_penandatangan,16,3) as nip_1,b.isi_saran_was1,c.id_jabatan as jabatan FROM was.was1 a inner join was.saran_was1 b ON a.id_saran = b.id_saran_was1 inner join was.penandatangan_surat c on a.nip_penandatangan=c.nip WHERE a.no_register='".$id."' AND a.id_level_was1='".$option."'")->one();
        // $model=
		
        return $this->render('cetak',['model'=>$model,'tempat'=>$tempat,'tglcetak'=>$tglcetak]);

    }

    protected function Cetak2($id,$option){

        // $model= $this->findModelByNoreg($id,$option);
        // $modelLoadSaran=Was1::findOne($id)
        $model = Was1::findBysql("SELECT a.*, b.isi_saran_was1 FROM was.was1 a inner join was.saran_was1 b ON a.id_saran = b.id_saran_was1 WHERE a.no_register='".$id."' AND a.id_level_was1='".$option."'")->one();
        // print_r($model);
        // exit();
        return $this->render('cetak2',['model'=>$model]);

    }

    public function actionViewpdf($id,$option){
      // echo  \Yii::$app->params['uploadPath'].'lapdu/230017577_116481.pdf';
        // echo 'cms_simkari/modules/pengawasan/upload_file/lapdu/230017577_116481.pdf';
      // $filename = $_GET['filename'] . '.pdf';
       $file_upload=$this->findModelByNoreg($id,$option);
        // print_r($file_upload['file_lapdu']);
       if($option=='1'){
          $filepath = '../modules/pengawasan/upload_file/was_1/irmud/'.$file_upload['file_disposisi_irmud'];
          $nama_file=$file_upload['file_disposisi_irmud'];
       }else if($option=='2'){
          $filepath = '../modules/pengawasan/upload_file/was_1/inspektur/'.$file_upload['file_disposisi_inspektur'];
          $nama_file=$file_upload['file_disposisi_inspektur'];
       }else if($option=='3'){
          $filepath = '../modules/pengawasan/upload_file/was_1/jamwas/'.$file_upload['file_disposisi_jamwas'];
          $nama_file=$file_upload['file_disposisi_jamwas'];
       }
       
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

    /**
     * Finds the Was1 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Was1 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Was1::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelByNoreg($id,$option)
    {
        if (($model = Was1::findOne(['no_register'=>$id,'id_level_was1'=>$option])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Belum ada inputan Pada Halaman Ini');
            // return ;
        }
    }


}
