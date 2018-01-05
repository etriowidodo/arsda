<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\BaWas3;
use app\modules\pengawasan\models\Was9;
use app\modules\pengawasan\models\SpWas1;
use app\modules\pengawasan\models\BaWas3Search;
use app\modules\pengawasan\models\PemeriksaSpWas1;
use app\modules\pengawasan\models\BaWas3Keterangan;
use app\modules\pengawasan\models\BaWas3DetailPemeriksa;
use app\modules\pengawasan\models\PemeriksaBawas3;
use app\modules\pengawasan\models\SaksiInternal;
use app\modules\pengawasan\models\SaksiEksternal;
use app\modules\pengawasan\models\DisposisiIrmud;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\components\ConstSysMenuComponent;
use app\modules\pengawasan\components\FungsiComponent;
use app\modules\pengawasan\models\WasTrxPemrosesan;

use app\models\KpInstSatker;
use app\models\KpInstSatkerSearch;

use app\modules\pengawasan\models\PegawaiTerlapor;

use Odf;
use yii\db\Query;
use yii\db\Command;


/**
 * BaWas3Controller implements the CRUD actions for BaWas3 model.
 */
class BaWas3Controller extends Controller
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
        
		
		$model = new BaWas3();
		    $session = Yii::$app->session;
        $searchModel = new BaWas3Search();
        $dataProvider = $searchModel->searchIndex(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 15;
		
        return $this->render('index', [
			     //'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

        ]);
    }

    public function actionViewpdf($id,$id_register,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari){

       $result_file_name=$this->findModel1($id,$id_register,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari);
        
        print_r($result_file_name['bawas3_file']);
        exit();
      
    }

    public function actionViewpdf2($id){

       $result_file_name=$this->findModel($id);
       
          $filepath = '../modules/pengawasan/upload_file/ba_was_3/'.$result_file_name['bawas3_file'];

        $extention=explode(".", $result_file_name['bawas3_file']);
           if($extention[1]=='jpg' || $extention[1]=='jpeg' || $extention[1]=='png' and file_exists($filepath)){
            return Yii::$app->response->sendFile($filepath);
           }else{
          if(file_exists($filepath))
          {
              // Set up PDF headers
              header('Content-type: application/pdf');
              header('Content-Disposition: inline; filename="' . $result_file_name['bawas3_file'] . '"');
              header('Content-Transfer-Encoding: binary');
              header('Content-Length: ' . filesize($filepath));
              header('Accept-Ranges: bytes');

              // Render the file
              readfile($filepath);
          }
          else
          {
            echo "File Tidak Ditemukan";
             // PDF doesn't exist so throw an error or something
          }
      }
      
    }
	
    /**
     * Displays a single BaWas3 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new BaWas3 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    	
      $model = new BaWas3();
	    $modelSpWas1 = SpWas1::findOne(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_kejati'=>$_SESSION['kode_kejati'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4'],'trx_akhir'=>1]);
	
		$modelPemeriksa = PemeriksaSpWas1::findAll(["id_sp_was1"=>$modelSpWas1->id_sp_was1,'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_kejati'=>$_SESSION['kode_kejati'],'id_cabjari'=>$_SESSION['kode_cabjari']]);
		
			
			$terlap=$_POST['BaWas3']['nip_dimintai_keterangan'];
			if ($model->load(Yii::$app->request->post()) ) {
			$connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
            	if($_POST['BaWas3']['sebagai']=='0'){
            		$model->peruntukan_ba='Terlapor';
            		$model->id_terlapor_saksi = $_POST['terlapor_id'];	
                $model->id_sp_was = $_POST['id_spwas_terlapor'];
            		
            	}else if($_POST['BaWas3']['sebagai']=='1'){
            		$model->peruntukan_ba='Saksi Internal';
            		$model->id_terlapor_saksi = $_POST['in_saksi_id'];
                $model->id_sp_was = $_POST['id_spwas_in'];	
            	
            	}else if($_POST['BaWas3']['sebagai']=='2'){
            		$model->peruntukan_ba='Saksi Eksternal';
            		$model->id_terlapor_saksi = $_POST['ek_saksi_id'];	
                $model->id_sp_was = $_POST['id_spwas_ek'];
            	}

			      $model->created_ip = $_SERVER['REMOTE_ADDR'];
            $model->created_time = date('Y-m-d H:i:s');
            $model->created_by = \Yii::$app->user->identity->id;
            $model->id_tingkat = $_SESSION['kode_tk'];
            $model->id_kejati = $_SESSION['kode_kejati'];
            $model->id_kejari = $_SESSION['kode_kejari'];
            $model->id_cabjari = $_SESSION['kode_cabjari'];
            $model->no_register = $_SESSION['was_register'];

            $model->id_pemeriksa = $_POST['id_pemeriksa'];
            $model->nama_pemeriksa = $_POST['nama_pemeriksa'];
            $model->pangkat_pemeriksa = $_POST['pangkat_pemeriksa'];
            $model->golongan_pemeriksa = $_POST['golongan_pemeriksa'];
            $model->jabatan_pemeriksa = $_POST['jabatan_pemeriksa'];
            $model->nip_pemeriksa = $_POST['nip_pemeriksa'];
            $model->nrp_pemeriksa = $_POST['nrp_pemeriksa'];


			if($model->save()){
			
    			$pertanyaan = $_POST['pertanyaan'];
    			for($k=0;$k<count($pertanyaan);$k++){
    				$modelBaWas3Pertanyaan = new BaWas3Keterangan();
    				$modelBaWas3Pertanyaan->id_tingkat = $_SESSION['kode_tk'];
            $modelBaWas3Pertanyaan->id_kejati = $_SESSION['kode_kejati'];
            $modelBaWas3Pertanyaan->id_kejari = $_SESSION['kode_kejari'];
            $modelBaWas3Pertanyaan->id_cabjari = $_SESSION['kode_cabjari'];
            $modelBaWas3Pertanyaan->no_register = $_SESSION['was_register'];
    				$modelBaWas3Pertanyaan->id_ba_was3 = $model->id_ba_was3;
    				$modelBaWas3Pertanyaan->pertanyaan =$_POST['pertanyaan'][$k];
    				$modelBaWas3Pertanyaan->jawaban = $_POST['jawaban'][$k];
    				$modelBaWas3Pertanyaan->created_ip = $_SERVER['REMOTE_ADDR'];
    				$modelBaWas3Pertanyaan->updated_ip = $_SERVER['REMOTE_ADDR'];
    				$modelBaWas3Pertanyaan->created_by = \Yii::$app->user->identity->id;
    				$modelBaWas3Pertanyaan->updated_by = \Yii::$app->user->identity->id;

					$modelBaWas3Pertanyaan->save();
				} 
				
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
    				$transaction->commit(); 
    				return $this->redirect(['index']);	

				}else{
    				Yii::$app->getSession()->setFlash('success', [
    				 'type' => 'success',
    				 'duration' => 3000,
    				 'icon' => 'fa fa-users',
    				 'message' => 'Data Gagal Disimpan',
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
				
        }	else {
            return $this->render('create', [
                'model' => $model,
        				'modelSpWas1' =>$modelSpWas1,
            ]);
        }
    }

    /**
     * Updates an existing BaWas3 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
    	$chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	    $res = "";
	    for ($i = 0; $i < 10; $i++) {
	        $res .= $chars[mt_rand(0, strlen($chars)-1)];
	    }	
        //$id = $_POST['update_id_ba_was_3'];
        $model = $this->findModel($id);
        $OldFile=$model['bawas3_file'];
		$no_reg=$_SESSION['was_register'];
		$modelSpWas1 = SpWas1::findOne(["no_register"=>$_SESSION['was_register'],"id_tingkat"=>$_SESSION['kode_tk'],"id_kejati"=>$_SESSION['kode_kejati'],"id_kejari"=>$_SESSION['kode_kejari'],"id_kejati"=>$_SESSION['kode_kejati'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);

    $fungsi=new FungsiComponent();
    $where=$fungsi->static_where_alias('a');
    $is_inspektur_irmud_riksa=$fungsi->gabung_where();

		$queryp = new Query;
    $connection = \Yii::$app->db;
  
    /*Ambil data  terlapor dari was10 yang terakhir*/
    $query_terlapor="select*from was.was10 a where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' 
          and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
          and a.id_cabjari='".$_SESSION['kode_cabjari']."' and a.trx_akhir=1 and a.id_pegawai_terlapor='".$model['id_terlapor_saksi']."' $where";
    $modelTerlapor = $connection->createCommand($query_terlapor)->queryAll();

    /*Ambil data  saksi Internal dari table saksi INTERNAL  yang terakhir*/
		$query_saksi_in = "select*from was.was9 a inner join was.saksi_internal b on 
                    a.id_saksi=b.id_saksi_internal and a.jenis_saksi='Internal' and
                    a.id_tingkat = b.id_tingkat and
                    a.id_kejati  = b.id_kejati and
                    a.id_kejari  = b.id_kejari and
                    a.id_cabjari = b.id_cabjari and
                    a.id_wilayah=b.id_wilayah and
                    a.id_level1=b.id_level1 and
                    a.id_level2=b.id_level2 and 
                    a.id_level3=b.id_level3 and
                    a.id_level4=b.id_level4
                where 
		 	              a.no_register='".$_SESSION['was_register']."'  
          	        and a.id_tingkat='".$_SESSION['kode_tk']."' 
          	        and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
          	        and a.id_cabjari='".$_SESSION['kode_cabjari']."' and  a.trx_akhir=1 and a.id_saksi='".$model->id_terlapor_saksi."' $where";
	 $modelSaksiInternal = $connection->createCommand($query_saksi_in)->queryAll();

    /*Ambil data  saksi Eketernal dari table saksi EKSERNAL  yang terakhir*/
    $query_saksi_ek = "select*from was.was9 a inner join was.saksi_eksternal b on 
                    a.id_saksi=b.id_saksi_eksternal and a.jenis_saksi='Eksternal' and
                    a.id_tingkat = b.id_tingkat and
                    a.id_kejati  = b.id_kejati and
                    a.id_kejari  = b.id_kejari and
                    a.id_cabjari = b.id_cabjari and
                    a.id_wilayah=b.id_wilayah and
                    a.id_level1=b.id_level1 and
                    a.id_level2=b.id_level2 and 
                    a.id_level3=b.id_level3 and
                    a.id_level4=b.id_level4
                where 
                    a.no_register='".$_SESSION['was_register']."'  
                    and a.id_tingkat='".$_SESSION['kode_tk']."' 
                    and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
                    and a.id_cabjari='".$_SESSION['kode_cabjari']."' and  a.trx_akhir=1 and a.id_saksi='".$model->id_terlapor_saksi."' $where";
   $modelSaksiEksternal = $connection->createCommand($query_saksi_ek)->queryAll();

   /*Ambil data  Pmeriksa Dari Bawas3*/
   $query_pemeriksa="select a.* from was.ba_was_3 a where 
      a.no_register='".$_SESSION['was_register']."'  
          and a.id_tingkat='".$_SESSION['kode_tk']."' 
          and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
          and a.id_cabjari='".$_SESSION['kode_cabjari']."' and id_ba_was3='".$id."' $where";
    $modelPemeriksa = $connection->createCommand($query_pemeriksa)->queryAll();

    /*Ambil data  Pertanyaan Dari ba_was_3_keterangan*/
    $query_pertanyaan="select a.* from was.ba_was_3_keterangan a where 
      a.no_register='".$_SESSION['was_register']."'  
          and a.id_tingkat='".$_SESSION['kode_tk']."' 
          and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
          and a.id_cabjari='".$_SESSION['kode_cabjari']."' and id_ba_was3='".$id."' $where";
    $modelPertanyaan = $connection->createCommand($query_pertanyaan)->queryAll();

		
        if ($model->load(Yii::$app->request->post()) ) {
        	$connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            $OldFile=$model->bawas3_file;    

            
            try {
			
			
          $file_name    = $_FILES['bawas3_file']['name'];
	        $file_size    = $_FILES['bawas3_file']['size'];
	        $file_tmp     = $_FILES['bawas3_file']['tmp_name'];
	        $file_type    = $_FILES['bawas3_file']['type'];
	        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
	        $tmp = explode('.', $_FILES['bawas3_file']['name']);
	        $file_exists = end($tmp);
	        $rename_file = $is_inspektur_irmud_riksa.'_'.$model->peruntukan_ba.'_'.$model->id_terlapor_saksi.'_'.$res.'.'.$ext;

			      $model->created_ip = $_SERVER['REMOTE_ADDR'];
            $model->created_time = date('Y-m-d H:i:s');
            $model->created_by = \Yii::$app->user->identity->id;
            $model->id_tingkat = $_SESSION['kode_tk'];
            $model->id_kejati = $_SESSION['kode_kejati'];
            $model->id_kejari = $_SESSION['kode_kejari'];
            $model->id_cabjari = $_SESSION['kode_cabjari'];
            $model->no_register = $_SESSION['was_register'];
            // $model->is_inspektur_irmud_riksa = $_SESSION['is_inspektur_irmud_riksa'];
            $model->id_terlapor_saksi = $_POST['terlapor_id'];	
            $model->bawas3_file = ($file_name==''?$OldFile:$rename_file);			

			
			
			if($model->save()){

			if($OldFile!='' && file_exists($file_tmp) && file_exists(\Yii::$app->params['uploadPath'].'ba_was_3/'.$OldFile)) {
                unlink(\Yii::$app->params['uploadPath'].'ba_was_3/'.$OldFile);
            } 	 	
         

				$pertanyaan = $_POST['pertanyaan'];
				BaWas3Keterangan::deleteAll("id_ba_was3 = '".$model->id_ba_was3."' ");
				if ($_POST['pertanyaan'] !='' || $_POST['pertanyaan'] !=null){
								$pertanyaan = $_POST['pertanyaan'];
        				for($k=0;$k<count($pertanyaan);$k++){
        					$modelBaWas3Pertanyaan = new BaWas3Keterangan();
        					$modelBaWas3Pertanyaan->id_tingkat = $_SESSION['kode_tk'];
  		            $modelBaWas3Pertanyaan->id_kejati = $_SESSION['kode_kejati'];
  		            $modelBaWas3Pertanyaan->id_kejari = $_SESSION['kode_kejari'];
  		            $modelBaWas3Pertanyaan->id_cabjari = $_SESSION['kode_cabjari'];
  		            $modelBaWas3Pertanyaan->no_register = $_SESSION['was_register'];
        					$modelBaWas3Pertanyaan->id_ba_was3 = $model->id_ba_was3;
        					$modelBaWas3Pertanyaan->pertanyaan =$_POST['pertanyaan'][$k];
        					$modelBaWas3Pertanyaan->jawaban = $_POST['jawaban'][$k];
        					$modelBaWas3Pertanyaan->created_ip = $_SERVER['REMOTE_ADDR'];
        					$modelBaWas3Pertanyaan->updated_ip = $_SERVER['REMOTE_ADDR'];
        					$modelBaWas3Pertanyaan->created_by = \Yii::$app->user->identity->id;
        					$modelBaWas3Pertanyaan->updated_by = \Yii::$app->user->identity->id;

        					$modelBaWas3Pertanyaan->save();
        				}
					}
				
			$arr = array(ConstSysMenuComponent::LWas);
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
        
			
				$transaction->commit();
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
                move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'ba_was_3/'.$rename_file);        

			
				
				return $this->redirect(['index']);	
				} catch(Exception $e) {
                    $transaction->rollback();
                    if(YII_DEBUG){throw $e; exit;} else{return false;}
				}
				
        }else {
            return $this->render('update', [
                'model' => $model,
        				'modelSpWas1' =>$modelSpWas1,
        				'modelPemeriksa'=>$modelPemeriksa,
        				'modelTerlapor' => $modelTerlapor,
        				'modelSaksiInternal'=>$modelSaksiInternal,
        				'modelSaksiEksternal'=>$modelSaksiEksternal,
        				'modelPertanyaan'=>$modelPertanyaan,
                    ]);
        }
    }

    /**
     * Deletes an existing BaWas3 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
      
    }

    public function actionCetak($id)
    {
        $model = $this->findModel($id);
        $data_satker = KpInstSatkerSearch::findOne(['inst_satkerkd'=>$_SESSION['inst_satkerkd']]);/*lokasi dan nama kejaksaan*/
        $fungsi=new FungsiComponent();
        $where=$fungsi->static_where_alias('a');
        $connection = \Yii::$app->db;
        $query_pemeriksa="select a.* from was.ba_was_3 a 
                    where a.no_register='".$_SESSION['was_register']."'  
                            and a.id_tingkat='".$_SESSION['kode_tk']."' 
                            and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
                            and a.id_cabjari='".$_SESSION['kode_cabjari']."' and a.id_ba_was3='".$id."' $where";
        $modelPemriksa = $connection->createCommand($query_pemeriksa)->queryAll();

        if($model['peruntukan_ba']=='Terlapor'){
        $query_terlapor="select a.* from was.was10 a where a.no_register='".$_SESSION['was_register']."' and 
          a.id_tingkat='".$_SESSION['kode_tk']."' 
          and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
          and a.id_cabjari='".$_SESSION['kode_cabjari']."' and a.trx_akhir=1 and a.id_pegawai_terlapor='".$model['id_terlapor_saksi']."' $where";
        $modelTerlapor = $connection->createCommand($query_terlapor)->queryAll();
        }else if($model['peruntukan_ba']=='Saksi Internal'){
        $query_terlapor="select id_saksi_internal as id_pegawai_terlapor,nip as nip_pegawai_terlapor,nama_saksi_internal as nama_pegawai_terlapor, pangkat_saksi_internal as pangkat_pegawai_terlapor,
          golongan_saksi_internal as golongan_pegawai_terlapor, jabatan_saksi_internal as jabatan_pegawai_terlapor from was.was9 a inner join was.saksi_internal b on 
                    a.id_saksi=b.id_saksi_internal and a.jenis_saksi='Internal' and
                    a.id_tingkat = b.id_tingkat and
                    a.id_kejati  = b.id_kejati and
                    a.id_kejari  = b.id_kejari and
                    a.id_cabjari = b.id_cabjari and
                    a.id_wilayah=b.id_wilayah and
                    a.id_level1=b.id_level1 and
                    a.id_level2=b.id_level2 and 
                    a.id_level3=b.id_level3 and
                    a.id_level4=b.id_level4
                where 
                    a.no_register='".$_SESSION['was_register']."'  
                    and a.id_tingkat='".$_SESSION['kode_tk']."' 
                    and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
                    and a.id_cabjari='".$_SESSION['kode_cabjari']."' and  a.trx_akhir=1 and a.id_saksi='".$model->id_terlapor_saksi."' $where";
        $modelTerlapor = $connection->createCommand($query_terlapor)->queryAll();
        }

        $query_spwas1="select a.* from was.sp_was_1 a where a.no_register='".$_SESSION['was_register']."' and 
          a.id_tingkat='".$_SESSION['kode_tk']."' 
          and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
          and a.id_cabjari='".$_SESSION['kode_cabjari']."' and a.id_sp_was1='".$model['id_sp_was']."' $where";
        $modelSpWas1 = $connection->createCommand($query_spwas1)->queryOne();


        $query_pertanyaan="select a.* from was.ba_was_3_keterangan a where a.no_register='".$_SESSION['was_register']."' and 
          a.id_tingkat='".$_SESSION['kode_tk']."' 
          and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
          and a.id_cabjari='".$_SESSION['kode_cabjari']."' and a.id_ba_was3='".$model['id_ba_was3']."' $where";
        $modelPertanyaan = $connection->createCommand($query_pertanyaan)->queryAll();


        /*khusus tandatangan*/
        if($model['peruntukan_ba']=='Terlapor'){
        $query_yg_diperiksa="select a.* from was.was10 a where a.no_register='".$_SESSION['was_register']."' and 
          a.id_tingkat='".$_SESSION['kode_tk']."' 
          and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
          and a.id_cabjari='".$_SESSION['kode_cabjari']."' and a.trx_akhir=1 and a.id_pegawai_terlapor='".$model['id_terlapor_saksi']."' $where";
        $modelyg_diperiksa = $connection->createCommand($query_yg_diperiksa)->queryOne();
        }else if($model['peruntukan_ba']=='Saksi Internal'){
        /*dialiaskan supaya bisa memakaitamplate yg sama dengan terlapor*/
        $query_yg_diperiksa="select id_saksi_internal as id_pegawai_terlapor,nip as nip_pegawai_terlapor,nama_saksi_internal as nama_pegawai_terlapor, pangkat_saksi_internal as pangkat_pegawai_terlapor,
          golongan_saksi_internal as golongan_pegawai_terlapor,jabatan_saksi_internal as jabatan_pegawai_terlapor from was.was9 a inner join was.saksi_internal b on 
                    a.id_saksi=b.id_saksi_internal and a.jenis_saksi='Internal' and
                    a.id_tingkat = b.id_tingkat and
                    a.id_kejati  = b.id_kejati and
                    a.id_kejari  = b.id_kejari and
                    a.id_cabjari = b.id_cabjari and
                    a.id_wilayah=b.id_wilayah and
                    a.id_level1=b.id_level1 and
                    a.id_level2=b.id_level2 and 
                    a.id_level3=b.id_level3 and
                    a.id_level4=b.id_level4
                where 
                    a.no_register='".$_SESSION['was_register']."'  
                    and a.id_tingkat='".$_SESSION['kode_tk']."' 
                    and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
                    and a.id_cabjari='".$_SESSION['kode_cabjari']."' and  a.trx_akhir=1 and a.id_saksi='".$model->id_terlapor_saksi."' $where";
        $modelyg_diperiksa = $connection->createCommand($query_yg_diperiksa)->queryOne(); 
        }

        $query_yg_memeriksa="select a.* from was.ba_was_3 a 
                    where a.no_register='".$_SESSION['was_register']."'  
                            and a.id_tingkat='".$_SESSION['kode_tk']."' 
                            and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
                            and a.id_cabjari='".$_SESSION['kode_cabjari']."' and a.id_ba_was3='".$id."' $where";
        $modelyg_memeriksa = $connection->createCommand($query_yg_memeriksa)->queryOne();
        /*khusu tandatagan*/

        $tgl_spwas1=\Yii::$app->globalfunc->ViewIndonesianFormat($modelSpWas1['tanggal_sp_was1']);
        $tgl_bawas3=\Yii::$app->globalfunc->ViewIndonesianFormat($model['tanggal_ba_was3']);
        $hari_bawas3=\Yii::$app->globalfunc->GetNamaHari($model['tanggal_ba_was3']);


          return $this->render('cetak',[
                    'model'=>$model,
                    'data_satker'=>$data_satker,
                    'modelPemriksa'=>$modelPemriksa,
                    'modelTerlapor'=>$modelTerlapor,
                    'modelSpWas1'=>$modelSpWas1,
                    'modelPertanyaan'=>$modelPertanyaan,
                    'modelyg_diperiksa'=>$modelyg_diperiksa,
                    'modelyg_memeriksa'=>$modelyg_memeriksa,
                    'tgl_spwas1'=>$tgl_spwas1,
                    'tgl_bawas3'=>$tgl_bawas3,
                    'hari_bawas3'=>$hari_bawas3,
                    ]);
    }


        public function actionCetakint($id)
    {
        $model = $this->findModel($id);
        $data_satker = KpInstSatkerSearch::findOne(['inst_satkerkd'=>$_SESSION['inst_satkerkd']]);/*lokasi dan nama kejaksaan*/
        $fungsi=new FungsiComponent();
        $where=$fungsi->static_where_alias('a');
        $connection = \Yii::$app->db;
        $query_pemeriksa="select a.* from was.ba_was_3 a 
                    where a.no_register='".$_SESSION['was_register']."'  
                            and a.id_tingkat='".$_SESSION['kode_tk']."' 
                            and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
                            and a.id_cabjari='".$_SESSION['kode_cabjari']."' and a.id_ba_was3='".$id."' $where";
        $modelPemriksa = $connection->createCommand($query_pemeriksa)->queryAll();
        
        $query_terlapor="select id_saksi_internal as id_pegawai_terlapor,nip as nip_pegawai_terlapor,nama_saksi_internal as nama_pegawai_terlapor, pangkat_saksi_internal as pangkat_pegawai_terlapor,
          golongan_saksi_internal as golongan_pegawai_terlapor, jabatan_saksi_internal as jabatan_pegawai_terlapor from was.was9 a inner join was.saksi_internal b on 
                    a.id_saksi=b.id_saksi_internal and a.jenis_saksi='Internal' and
                    a.id_tingkat = b.id_tingkat and
                    a.id_kejati  = b.id_kejati and
                    a.id_kejari  = b.id_kejari and
                    a.id_cabjari = b.id_cabjari and
                    a.id_wilayah=b.id_wilayah and
                    a.id_level1=b.id_level1 and
                    a.id_level2=b.id_level2 and 
                    a.id_level3=b.id_level3 and
                    a.id_level4=b.id_level4
                where 
                    a.no_register='".$_SESSION['was_register']."'  
                    and a.id_tingkat='".$_SESSION['kode_tk']."' 
                    and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
                    and a.id_cabjari='".$_SESSION['kode_cabjari']."' and  a.trx_akhir=1 and a.id_saksi='".$model->id_terlapor_saksi."' $where";
        $modelTerlapor = $connection->createCommand($query_terlapor)->queryAll();

        $query_spwas1="select a.* from was.sp_was_1 a where a.no_register='".$_SESSION['was_register']."' and 
          a.id_tingkat='".$_SESSION['kode_tk']."' 
          and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
          and a.id_cabjari='".$_SESSION['kode_cabjari']."' and a.id_sp_was1='".$model['id_sp_was']."' $where";
        $modelSpWas1 = $connection->createCommand($query_spwas1)->queryOne();


        $query_pertanyaan="select a.* from was.ba_was_3_keterangan a where a.no_register='".$_SESSION['was_register']."' and 
          a.id_tingkat='".$_SESSION['kode_tk']."' 
          and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
          and a.id_cabjari='".$_SESSION['kode_cabjari']."' and a.id_ba_was3='".$model['id_ba_was3']."' $where";
        $modelPertanyaan = $connection->createCommand($query_pertanyaan)->queryAll();


        /*khusus tandatangan*/
        /*dialiaskan supaya bisa memakaitamplate yg sama dengan terlapor*/
        $query_yg_diperiksa="select id_saksi_internal as id_pegawai_terlapor,nip as nip_pegawai_terlapor,nama_saksi_internal as nama_pegawai_terlapor, pangkat_saksi_internal as pangkat_pegawai_terlapor,
          golongan_saksi_internal as golongan_pegawai_terlapor,jabatan_saksi_internal as jabatan_pegawai_terlapor from was.was9 a inner join was.saksi_internal b on 
                    a.id_saksi=b.id_saksi_internal and a.jenis_saksi='Internal' and
                    a.id_tingkat = b.id_tingkat and
                    a.id_kejati  = b.id_kejati and
                    a.id_kejari  = b.id_kejari and
                    a.id_cabjari = b.id_cabjari and
                    a.id_wilayah=b.id_wilayah and
                    a.id_level1=b.id_level1 and
                    a.id_level2=b.id_level2 and 
                    a.id_level3=b.id_level3 and
                    a.id_level4=b.id_level4
                where 
                    a.no_register='".$_SESSION['was_register']."'  
                    and a.id_tingkat='".$_SESSION['kode_tk']."' 
                    and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
                    and a.id_cabjari='".$_SESSION['kode_cabjari']."' and  a.trx_akhir=1 and a.id_saksi='".$model->id_terlapor_saksi."' $where";
        $modelyg_diperiksa = $connection->createCommand($query_yg_diperiksa)->queryOne(); 

        $query_yg_memeriksa="select a.* from was.ba_was_3 a 
                    where a.no_register='".$_SESSION['was_register']."'  
                            and a.id_tingkat='".$_SESSION['kode_tk']."' 
                            and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
                            and a.id_cabjari='".$_SESSION['kode_cabjari']."' and a.id_ba_was3='".$id."' $where";
        $modelyg_memeriksa = $connection->createCommand($query_yg_memeriksa)->queryOne();
        /*khusu tandatagan*/

        $tgl_spwas1=\Yii::$app->globalfunc->ViewIndonesianFormat($modelSpWas1['tanggal_sp_was1']);
        $tgl_bawas3=\Yii::$app->globalfunc->ViewIndonesianFormat($model['tanggal_ba_was3']);
        $hari_bawas3=\Yii::$app->globalfunc->GetNamaHari($model['tanggal_ba_was3']);


          return $this->render('cetak_int',[
                    'model'=>$model,
                    'data_satker'=>$data_satker,
                    'modelPemriksa'=>$modelPemriksa,
                    'modelTerlapor'=>$modelTerlapor,
                    'modelSpWas1'=>$modelSpWas1,
                    'modelPertanyaan'=>$modelPertanyaan,
                    'modelyg_diperiksa'=>$modelyg_diperiksa,
                    'modelyg_memeriksa'=>$modelyg_memeriksa,
                    'tgl_spwas1'=>$tgl_spwas1,
                    'tgl_bawas3'=>$tgl_bawas3,
                    'hari_bawas3'=>$hari_bawas3,
                    ]);
    }


    public function actionCetakeks($id){
        $model = $this->findModel($id);
        $data_satker = KpInstSatkerSearch::findOne(['inst_satkerkd'=>$_SESSION['inst_satkerkd']]);/*lokasi dan nama kejaksaan*/
        $fungsi=new FungsiComponent();
        $where=$fungsi->static_where_alias('a');
        $connection = \Yii::$app->db;
        $query_pemeriksa="select a.* from was.ba_was_3 a 
                    where a.no_register='".$_SESSION['was_register']."'  
                            and a.id_tingkat='".$_SESSION['kode_tk']."' 
                            and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
                            and a.id_cabjari='".$_SESSION['kode_cabjari']."' and a.id_ba_was3='".$id."' $where";
        $modelPemriksa = $connection->createCommand($query_pemeriksa)->queryAll();

        $query_saksi_ek="select*from was.was9 a inner join was.saksi_eksternal b on 
                    a.id_saksi=b.id_saksi_eksternal and a.jenis_saksi='Eksternal' and
                    a.id_tingkat = b.id_tingkat and
                    a.id_kejati  = b.id_kejati and
                    a.id_kejari  = b.id_kejari and
                    a.id_cabjari = b.id_cabjari and
                    a.id_wilayah=b.id_wilayah and
                    a.id_level1=b.id_level1 and
                    a.id_level2=b.id_level2 and 
                    a.id_level3=b.id_level3 and
                    a.id_level4=b.id_level4
                where 
                    a.no_register='".$_SESSION['was_register']."'  
                    and a.id_tingkat='".$_SESSION['kode_tk']."' 
                    and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
                    and a.id_cabjari='".$_SESSION['kode_cabjari']."' and  a.trx_akhir=1 and a.id_saksi='".$model->id_terlapor_saksi."' $where";
        $modelSaksiek = $connection->createCommand($query_saksi_ek)->queryAll();
        
        $query_spwas1="select a.* from was.sp_was_1 a where a.no_register='".$_SESSION['was_register']."' and 
          a.id_tingkat='".$_SESSION['kode_tk']."' 
          and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
          and a.id_cabjari='".$_SESSION['kode_cabjari']."' and a.id_sp_was1='".$model['id_sp_was']."' $where";
        $modelSpWas1 = $connection->createCommand($query_spwas1)->queryOne();


        $query_pertanyaan="select a.* from was.ba_was_3_keterangan a where a.no_register='".$_SESSION['was_register']."' and 
          a.id_tingkat='".$_SESSION['kode_tk']."' 
          and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
          and a.id_cabjari='".$_SESSION['kode_cabjari']."' and a.id_ba_was3='".$model['id_ba_was3']."' $where";
        $modelPertanyaan = $connection->createCommand($query_pertanyaan)->queryAll();


        /*khusus tandatangan*/
        $query_yg_diperiksa="select*from was.was9 a inner join was.saksi_eksternal b on 
                    a.id_saksi=b.id_saksi_eksternal and a.jenis_saksi='Eksternal' and
                    a.id_tingkat = b.id_tingkat and
                    a.id_kejati  = b.id_kejati and
                    a.id_kejari  = b.id_kejari and
                    a.id_cabjari = b.id_cabjari and
                    a.id_wilayah=b.id_wilayah and
                    a.id_level1=b.id_level1 and
                    a.id_level2=b.id_level2 and 
                    a.id_level3=b.id_level3 and
                    a.id_level4=b.id_level4
                where 
                    a.no_register='".$_SESSION['was_register']."'  
                    and a.id_tingkat='".$_SESSION['kode_tk']."' 
                    and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
                    and a.id_cabjari='".$_SESSION['kode_cabjari']."' and  a.trx_akhir=1 and a.id_saksi='".$model->id_terlapor_saksi."' $where";
        $modelyg_diperiksa = $connection->createCommand($query_yg_diperiksa)->queryOne();

        $query_yg_memeriksa="select a.* from was.ba_was_3 a 
                    where a.no_register='".$_SESSION['was_register']."'  
                            and a.id_tingkat='".$_SESSION['kode_tk']."' 
                            and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
                            and a.id_cabjari='".$_SESSION['kode_cabjari']."' and a.id_ba_was3='".$id."' $where";
        $modelyg_memeriksa = $connection->createCommand($query_yg_memeriksa)->queryOne();
        /*khusu tandatagan*/

        $tgl_spwas1=\Yii::$app->globalfunc->ViewIndonesianFormat($modelSpWas1['tanggal_sp_was1']);
        $tgl_bawas3=\Yii::$app->globalfunc->ViewIndonesianFormat($model['tanggal_ba_was3']);
        $hari_bawas3=\Yii::$app->globalfunc->GetNamaHari($model['tanggal_ba_was3']);


          return $this->render('cetak_eks',[
                    'model'=>$model,
                    'data_satker'=>$data_satker,
                    'modelPemriksa'=>$modelPemriksa,
                    'modelSaksiek'=>$modelSaksiek,
                    'modelSpWas1'=>$modelSpWas1,
                    'modelPertanyaan'=>$modelPertanyaan,
                    'modelyg_diperiksa'=>$modelyg_diperiksa,
                    'modelyg_memeriksa'=>$modelyg_memeriksa,
                    'tgl_spwas1'=>$tgl_spwas1,
                    'tgl_bawas3'=>$tgl_bawas3,
                    'hari_bawas3'=>$hari_bawas3,
                    ]);
    }



   
    // hapus trx_permrosesan LWAS , tp harus cek BAWAS2 dulu jika BAWAS2 ada maka jangan di hapus
	public function actionHapus() {
	 $id_bawas3 = $_POST['id'];
	 $jumlah = $_POST['jml'];
   $pecah=explode(',', $id_bawas3);
	 
        for ($i=0; $i <$jumlah ; $i++) { 
           $this->findModel($pecah[$i])->delete();
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
     * Finds the BaWas3 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return BaWas3 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */

     protected function findModel1($id,$id_register,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari)
    {
    	 if (($model = BaWas3::findOne(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'] ,'id_ba_was3'=>$id])) !== null) {
       	
      //  if (($model = BaWas3::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModel($id)
    {
    	 if (($model = BaWas3::findOne(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_ba_was3'=>$id,'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']])) !== null) {
       	
      //  if (($model = BaWas3::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
