<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\BaWas4;
use app\modules\pengawasan\models\BaWas4Search;
use app\modules\pengawasan\models\BaWas4Detail;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\modules\pengawasan\models\SpWas1;
use app\modules\pengawasan\models\SaksiEksternal;
use app\models\KpInstSatker;
use app\models\KpInstSatkerSearch;

use app\components\ConstSysMenuComponent;
use app\modules\pengawasan\models\WasTrxPemrosesan;

use app\modules\pengawasan\models\DisposisiIrmud;

use Odf;
use yii\db\Query;

/**
 * BaWas3Controller implements the CRUD actions for BaWas3 model.
 */
class BaWas4Controller extends Controller
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
     * Lists all BaWas3 models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new BaWas4();
		$session = Yii::$app->session;
        $searchModel = new BaWas4Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 15;
		
        return $this->render('index', [
			//'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

        ]);
    }
	
	
    public function actionCreate()
    {
        $model = new BaWas4();
		$modelPernyataan= new BaWas4Detail();

        if ($model->load(Yii::$app->request->post()) ) {
			
			$connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
            	$model->id_tingkat = $_SESSION['kode_tk'];
		        $model->id_kejati = $_SESSION['kode_kejati'];
		        $model->id_kejari = $_SESSION['kode_kejari'];
		        $model->id_cabjari = $_SESSION['kode_cabjari'];
		        $model->no_register = $_SESSION['was_register'];
		        $model->is_inspektur_irmud_riksa = $_SESSION['is_inspektur_irmud_riksa'];
		        // $model->id_ba_was4 = 1;
		        $model->id_saksi_eksternal = 1;
				$model->created_ip = $_SERVER['REMOTE_ADDR'];
				$model->created_by = \Yii::$app->user->identity->id;
				$model->created_time = date('Y-m-d H:i:s');
				
				
			if($model->save()){
				
				$pernyataan = $_POST['pertanyaan'];
				
				//if ($_POST['pertanyaan'] !='' || $_POST['pertanyaan'] !=null){
				// for($k=0;$k<count($pernyataan);$k++){
				// $modelBaWas4Pernyataan = new BaWas4Detail();
				// $modelBaWas4Pernyataan->id_ba_was_4 = $model->id_ba_was_4;
				// $modelBaWas4Pernyataan->pernyataan =$_POST['pertanyaan'][$k];
				// $modelBaWas4Pernyataan->save();
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
				
				$transaction->commit(); 
				return $this->redirect(['index']);	
				}
				else{
				Yii::$app->getSession()->setFlash('success', [
				 'type' => 'success',
				 'duration' => 3000,
				 'icon' => 'fa fa-users',
				 'message' => 'Data Gagal di Simpan',
				 'title' => 'Simpan Data',
				 'positonY' => 'top',
				 'positonX' => 'center',
				 'showProgressbar' => true,
				 ]);
				return $this->render('create', [
                'model' => $model,
				'modelSpWas1' => $modelSpWas1,
				'modelSaksiEksternal' => $modelSaksiEksternal,
				'modelPernyataan' => $modelPernyataan,
            ]);
				}
				} catch(Exception $e) {
                    $transaction->rollback();
				}
				
        }
			else {
            return $this->render('create', [
                 'model' => $model,
				
            ]);
        }
    }

    /**
     * Updates an existing BaWas4 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
	 
	  public function actionViewpdf($id){

     

       $result_file_name=$this->findModel($id);
       //print_r($result_file_name);

        
          $filepath = '../modules/pengawasan/upload_file/ba_was_4/'.$result_file_name['upload_file'];
        $extention=explode(".", $result_file_name['upload_file']);
           if($extention[1]=='jpg' || $extention[1]=='jpeg' || $extention[1]=='png'){
            return Yii::$app->response->sendFile($filepath);
           }else{
          if(file_exists($filepath))
          {
              // Set up PDF headers
              header('Content-type: application/pdf');
              header('Content-Disposition: inline; filename="' . $result_file_name['upload_file'] . '"');
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
	 
    public function actionUpdate($id)
    {
		$no_reg=$_SESSION['was_register'];
		$modelSpWas1 = SpWas1::findOne(["no_register"=>$no_reg]);
		$model = $this->findModel($id);
		$OldFile=$model->upload_file;
		//$modelPernyataan= new BaWas4Detail();
		//$modelPernyataan = BaWas4Detail::findOne(["id_ba_was_4"=>$model->id_ba_was_4]);
		//$modelPernyataan = BaWas4Detail::find()->where("id_ba_was_4 =:id", [":id" => $model->id_ba_was_4])->all();
		
		$connection = \Yii::$app->db;
		$xx ="select * from was.ba_was_4_detail where id_ba_was_4='".$model->id_ba_was4."'";
		$modelPernyataan = $connection->createCommand($xx)->queryAll();
		//print_r($modelPernyataan);exit();
		$querySaksiEksternal ="select a.*,b.nama as warga,c.nama as agama,d.nama as pendidikan from was.saksi_eksternal a
		inner join public.ms_warganegara b on a.id_negara_saksi_eksternal=b.id
		inner join public.ms_agama  c on a.id_agama_saksi_eksternal=c.id_agama
		inner join public.ms_pendidikan  d on a.pendidikan=d.id_pendidikan where a.no_register='".$_SESSION['was_register']."' "; //and a.from_table='WAS-9'
		$modelSaksiEksternal = $connection->createCommand($querySaksiEksternal)->queryAll();
		$query1 = "select * from was.sp_was_1 where no_register='".$_SESSION['was_register']."'";
		$spwas1 = $connection->createCommand($query1)->queryAll();
		
		$var=str_split($_SESSION['is_inspektur_irmud_riksa']);
		$connection = \Yii::$app->db;
		$query1 = "select * from was.was_disposisi_irmud where no_register='".$_SESSION['was_register']."'";
		$disposisi_irmud = $connection->createCommand($query1)->queryAll();	
		
         if ($model->load(Yii::$app->request->post()) ) {
            
                         
			$model->updated_by = \Yii::$app->user->identity->id;
			$model->updated_ip = $_SERVER['REMOTE_ADDR'];
			$model->updated_time = date('Y-m-d H:i:s');	 
						 
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
           try {
			   
			   $files = \yii\web\UploadedFile::getInstance($model,'upload_file');
            if ($files != false) {
                $model->upload_file = date('Y-m-d').$files->name;
            }else{
                $model->upload_file = $OldFile;
            }
			   
            if($model->save()){
				
				for ($i=0;$i<count($disposisi_irmud);$i++){
					//echo $disposisi_irmud[$i]['id_terlapor_awal'];
					
					$saveDisposisi = DisposisiIrmud::find()->where("no_register='".$_SESSION['was_register']."' and id_terlapor_awal='".$disposisi_irmud[$i]['id_terlapor_awal']."' and id_inspektur='".$var[0]."' and id_irmud='".$var[1]."'")->one();
				//print_r($saveDisposisi['pemeriksa_1']);exit();
					if($saveDisposisi['pemeriksa_1']==TRUE){
						$connection = \Yii::$app->db;
						$query1 = "update was.was_disposisi_irmud set status_pemeriksa1='BA.WAS-4' where id_terlapor_awal='".$saveDisposisi['id_terlapor_awal']."'";
						$disposisi_irmud = $connection->createCommand($query1);
						$disposisi_irmud->execute();
					}
					if($saveDisposisi['pemeriksa_2']==TRUE){
						$connection = \Yii::$app->db;
						$query1 = "update was.was_disposisi_irmud set status_pemeriksa2='BA.WAS-4' where id_terlapor_awal='".$saveDisposisi['id_terlapor_awal']."'";
						$disposisi_irmud = $connection->createCommand($query1);
						$disposisi_irmud->execute();
					}		

				}
					
				$pernyataan = $_POST['pertanyaan'];
				//print_r($pernyataan); exit();
				BaWas4Detail::deleteAll("id_ba_was_4 = '".$model->id_ba_was4."' ");
				for($g=0;$g<count($pernyataan);$g++){
				$modelBaWas4Pernyataan = new BaWas4Detail();
				$modelBaWas4Pernyataan->id_ba_was_4 = $model->id_ba_was4;
				$modelBaWas4Pernyataan->pernyataan =$_POST['pertanyaan'][$g];
				/* $modelBaWas4Pernyataan->created_ip = $_SERVER['REMOTE_ADDR'];
				$modelBaWas4Pernyataan->updated_ip = $_SERVER['REMOTE_ADDR'];
				$modelBaWas4Pernyataan->created_by = \Yii::$app->user->identity->id;
				$modelBaWas4Pernyataan->updated_by = \Yii::$app->user->identity->id; */
				$modelBaWas4Pernyataan->save();
				} 
					
			  	$arr = array(ConstSysMenuComponent::Bawas4);
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
                      $modelTrxPemrosesan->save();
                      // }
                    }

					if ($files != false) {
                    $path = \Yii::$app->params['uploadPath'].'ba_was_4/'.date('Y-m-d').$files->name;
                    $files->saveAs($path);
					}
				
             $transaction->commit();
             if ($files != false) { // delete old and overwrite
                    // unlink($oldFile);
                    $path = \Yii::$app->params['uploadPath'].'ba-was4/'.$files->name;
                    $files->saveAs($path);
                }
                 if($_POST['print']=='1'){
                    $this->cetak($model->id_was_4);
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
                        return $this->redirect(['index']);
                         }else{
                             $transaction->rollback();
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
              return $this->redirect(['index']);
            }
           } catch(Exception $e) {

                    $transaction->rollback();
            }
        } else {
            return $this->render('update', [
					'model' => $model,
					'modelSpWas1' => $modelSpWas1,
					'modelSaksiEksternal' => $modelSaksiEksternal,
					'modelPernyataan' => $modelPernyataan,
				]);
        }	
    }
	
	 public function actionCetak() {
	 $no_reg=$_SESSION['was_register'];
	 $id_ba_was_4 = $_REQUEST['id_ba_was_4'];
	 $modelSpWas1 = SpWas1::findOne(["no_register"=>$no_reg]);
     $odf = new Odf(Yii::$app->params['reportPengawasan']."ba_was_4.odt");
     $bawas4 = BaWas4::findOne(['id_ba_was_4' => $id_ba_was_4]);
		
		//header bawas4
	   $connection = \Yii::$app->db;
			$query = "SELECT * from was.ba_was_4 where id_ba_was_4='".$id_ba_was_4."'";
			$bawas4 = $connection->createCommand($query)->queryAll();
			$tgl = \Yii::$app->globalfunc->tglToWord($bawas4[0]['tgl']);
			$tgllahir = \Yii::$app->globalfunc->tglToWord($bawas4[0]['tgl_lahir']);
		//end header bawas4

		//detail bawas4	
		
		$connection = \Yii::$app->db;
			$query = "SELECT * from was.ba_was_4_detail where id_ba_was_4='".$bawas4[0]['id_ba_was_4']."'";
			$pernyataan = $connection->createCommand($query)->queryAll();			
     	//end detail bawas4
		
		 /* print_r($bawas4[0]['nama_saksi']);
		 exit(); */
		 
       //$odf->setVars('kejaksaan', 'Kejaksaan Agung Republik Indonesia');
	   $odf->setVars('tanggal', $tgl);
	   $odf->setVars('nama', $bawas4[0]['nama_saksi']);
	   $odf->setVars('lokasi_surat', $bawas4[0]['kota']);
	   $odf->setVars('ttl', $tgllahir);
	   $odf->setVars('kewarganegaraan', $bawas4[0]['warga']);
	   $odf->setVars('alamat', $bawas4[0]['alamat']);
	   $odf->setVars('agama', $bawas4[0]['agama']);
	   $odf->setVars('pekerjaan', $bawas4[0]['pekerjaan']);
	   $odf->setVars('pendidikan', $bawas4[0]['pendidikan']);
	 
	   
	
	#Pemeriksa
        $dft_hasil_pernyataan= $odf->setSegment('pernyataan');
          $g=1;
            foreach ($pernyataan as $keys) {
          $dft_hasil_pernyataan->urutan_hasil($g);
          $dft_hasil_pernyataan->hasilWawancara($keys['pernyataan']);
          $dft_hasil_pernyataan->merge();
          $g++;
            }
        $odf->mergeSegment($dft_hasil_pernyataan);
	   
	   
      
    $odf->exportAsAttachedFile("BaWas4-.odt");
  }

    /**
     * Deletes an existing BaWas4 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
    
    $id_ba_was4 = $_POST['id'];
		$jumlah = $_POST['jml'];
		$pecah=explode(',', $id_ba_was4);
		
        for ($i=0; $i <$jumlah ; $i++) { 
            // SpWas2::deleteAll("id_sp_was4 = '".$check[$i]."'");
           $this->findModel($pecah[$i])->delete();
            
    }
    //      return $this->redirect(['index']);
		 
    // if (Was12::deleteAll("id_ba_was_4 ='" . $id_ba_was4  . "'")) {
      
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
    // } else {
    //   Yii::$app->getSession()->setFlash('success', [
    //       'type' => 'danger',
    //       'duration' => 3000,
    //       'icon' => 'fa fa-users',
    //       'message' => 'Data Gagal Dihapus'.$id_ba_was4 .'" ',
    //       'title' => 'Error',
    //       'positonY' => 'top',
    //       'positonX' => 'center',
    //       'showProgressbar' => true,
    //   ]);
    // }
    return $this->redirect(['index']);
    }

    /**
     * Finds the BaWas3 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return BaWas3 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
     protected function findModel($id)
    {
        if (($model = BaWas4::findOne(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_ba_was4'=>$id,'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
