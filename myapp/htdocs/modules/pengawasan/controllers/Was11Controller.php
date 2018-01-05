<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\Was11;
use app\modules\pengawasan\models\Was11Search;
use app\modules\pengawasan\models\Was9;
use app\modules\pengawasan\models\Was11DetailInt;
use app\modules\pengawasan\models\Was11DetailEks;
use app\modules\pengawasan\models\TembusanWas11;
use app\modules\pengawasan\models\KpInstSatker;
use app\modules\pengawasan\models\TembusanWas2;/*mengambil tembusan dari transaksi*/
use app\modules\pengawasan\models\TembusanWas;/*mengambil tembusan dari master*/
use app\modules\pengawasan\models\SaksiInternal;/*mengambil saksi internal*/
use app\modules\pengawasan\models\SaksiEksternal;/*mengambil saksi external*/
use app\modules\pengawasan\models\Lapdu;/*mengambil Lapdu untuk report*/
use app\modules\pengawasan\models\SpWas1;
use app\modules\pengawasan\models\DisposisiIrmud;
use app\modules\pengawasan\components\FungsiComponent; 
use app\models\KpInstSatkerSearch;
use app\models\KpPegawai;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use Odf;
use yii\grid\GridView;
use yii\widgets\Pjax;

use app\components\GlobalFuncComponent; 

/**
 * Was11Controller implements the CRUD actions for Was11 model.
 */
class Was11Controller extends Controller
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
     * Lists all Was11 models.
     * @return mixed
     */
    public function actionIndex()
    {
        $session = Yii::$app->session;
        $searchModel = new Was11Search();
        $dataProviderInt = $searchModel->searchInt($session->get('was_register'));
        $dataProviderEks = $searchModel->searchEks($session->get('was_register'));
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            // 'dataProviderInt' => $dataProviderInt,
            'dataProviderEks' => $dataProviderEks,
        ]);
    }
	
	
	public function actionGetsaksiinternal(){
	
	$id_register = $_POST['id_register'];
	$id_jabatan = $_POST['id_jabatan'];
	
	if(empty($id_jabatan)){
	$id_jabatan=0;
	}
	$query = new Query;
                        $query->select('*')
                                ->from('was.v_was_11_was_9')
                                ->where("id_register=:id and id_jabatan_pejabat=:id_jabatan_pejabat", [':id' => $id_register, ':id_jabatan_pejabat' => $id_jabatan]);

						
                        $data = $query->all();
						
						return \yii\helpers\Json::encode($data);
	}
	
	
	
	
    /**
     * Displays a single Was11 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionViewpdf($id){
      // echo  \Yii::$app->params['uploadPath'].'lapdu/230017577_116481.pdf';
        // echo 'cms_simkari/modules/pengawasan/upload_file/lapdu/230017577_116481.pdf';
      // $filename = $_GET['filename'] . '.pdf';
        $file_upload=$this->findModel($id);
       //$file_upload=Was11::findOne(["id_was_11"=>$id]);
        // print_r($file_upload['file_lapdu']);
          $filepath = '../modules/pengawasan/upload_file/was_11/'.$file_upload['upload_file'];
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

    
	
	 public function actionCreate($jns)
    {
	$var=str_split($_SESSION['is_inspektur_irmud_riksa']);
	$model=new was11();
      
		$modelTembusanMaster = TembusanWas::find()->where("for_tabel=:condition1 OR for_tabel=:condition2", [":condition1" => 'was_11','condition2'=>'master'])->all();
		
		$fungsi      =new FungsiComponent();
		$where 			=$fungsi->static_where();
	    $filter         ="no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' $where";
	    $getId          =$fungsi->FunctGetIdSpwas1($filter);

	    $where2 			=$fungsi->static_where_alias('a');
	    // $filter_1=""
	    $modelSpwas1=$fungsi->FunctGetIdSpwas1All($filter);
	   

        if ($model->load(Yii::$app->request->post())) {

			$connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
            	
            	$model->no_register=$_SESSION['was_register'];
	            $model->id_tingkat=$_SESSION['kode_tk'];
	            $model->id_kejati=$_SESSION['kode_kejati'];
	            $model->id_kejari=$_SESSION['kode_kejari'];
	            $model->id_cabjari=$_SESSION['kode_cabjari'];
            	$model->id_sp_was=$getId['id_sp_was1'];
				$model->created_ip = $_SERVER['REMOTE_ADDR'];
	            $model->created_time = date('Y-m-d H:i:s');
	            $model->created_by = \Yii::$app->user->identity->id;
			if($model->save()){
				
			$tmp_jns = $_POST['Was11']['jenis_saksi'];
			if($tmp_jns=='Internal'){
			$saksi_int = $_POST['nip'];
				for($i=0;$i<count($saksi_int);$i++){
					$query="select a.id_surat_was9,a.id_sp_was,b.nip,b.nama_saksi_internal,b.pangkat_saksi_internal,b.nrp,a.nip_pemeriksa,golongan_saksi_internal,b.jabatan_saksi_internal,a.nrp_pemeriksa,a.nama_pemeriksa,a.golongan_pemeriksa,a.pangkat_pemeriksa,a.jabatan_pemeriksa,a.tanggal_pemeriksaan_was9,a.hari_pemeriksaan_was9,a.jam_pemeriksaan_was9,a.tempat_pemeriksaan_was9 
						from was.was9 a inner join was.saksi_internal b 
								on a.id_saksi=b.id_saksi_internal
								and a.id_tingkat=b.id_tingkat
								and a.id_kejati=b.id_kejati
								AND a.id_kejari = b.id_kejari
								AND a.id_cabjari = b.id_cabjari
								AND a.no_register = b.no_register
								AND b.id_wilayah=a.id_wilayah
				                AND b.id_level1=a.id_level1
				                AND b.id_level2=a.id_level2
				                AND b.id_level3=a.id_level3
				                AND b.id_level4=a.id_level4
								 where  a.id_surat_was9='".$_POST['nip'][$i]."' and a.trx_akhir=1 and a.jenis_saksi='Internal' and
								 a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' and a.id_cabjari='".$_SESSION['kode_cabjari']."' and a.id_level1='".$_SESSION['was_id_level1']."' and a.id_level2='".$_SESSION['was_id_level2']."' and a.id_level3='".$_SESSION['was_id_level3']."' and a.id_level4='".$_SESSION['was_id_level4']."'";
								 
					$saksiIN = $connection->createCommand($query)->queryOne(); 
                    $Was11Detail = new Was11Detailint;
                    $Was11Detail->no_register=$_SESSION['was_register'];
		            $Was11Detail->id_tingkat=$_SESSION['kode_tk'];
		            $Was11Detail->id_kejati=$_SESSION['kode_kejati'];
		            $Was11Detail->id_kejari=$_SESSION['kode_kejari'];
		            $Was11Detail->id_cabjari=$_SESSION['kode_cabjari'];
		            // $Was11Detail->id_was_11_detail_int=1;
		            $Was11Detail->id_was_11=$model->id_surat_was11;
		            $Was11Detail->id_was_9=$saksiIN['id_surat_was9'];
		            $Was11Detail->nip_saksi_internal=$saksiIN['nip'];
		            $Was11Detail->nrp_saksi_internal=$saksiIN['nrp'];
		            $Was11Detail->nama_saksi_internal=$saksiIN['nama_saksi_internal'];
		            $Was11Detail->pangkat_saksi_internal=$saksiIN['pangkat_saksi_internal'];
		            $Was11Detail->golongan_saksi_internal=$saksiIN['golongan_saksi_internal'];
		            $Was11Detail->jabatan_saksi_internal=$saksiIN['jabatan_saksi_internal'];

		            $Was11Detail->nip_pemeriksa=$saksiIN['nip_pemeriksa'];
		            $Was11Detail->nrp_pemeriksa=$saksiIN['nrp_pemeriksa'];
		            $Was11Detail->nama_pemeriksa=$saksiIN['nama_pemeriksa'];
		            $Was11Detail->golongan_pemeriksa=$saksiIN['golongan_pemeriksa'];
		            $Was11Detail->pangkat_pemeriksa=$saksiIN['pangkat_pemeriksa'];
		            $Was11Detail->jabatan_pemeriksa=$saksiIN['jabatan_pemeriksa'];

		            $Was11Detail->tanggal_pemeriksaan=$saksiIN['tanggal_pemeriksaan_was9'];
		            $Was11Detail->hari_pemeriksaan=$saksiIN['hari_pemeriksaan_was9'];
		            $Was11Detail->jam_pemeriksaan=$saksiIN['jam_pemeriksaan_was9'];
		            $Was11Detail->tempat_pemeriksaan=$saksiIN['tempat_pemeriksaan_was9'];
					$Was11Detail->created_ip = $_SERVER['REMOTE_ADDR'];
		            $Was11Detail->created_time = date('Y-m-d H:i:s');
		            $Was11Detail->created_by = \Yii::$app->user->identity->id;
		            $Was11Detail->save();
                }			
            }else{
            	$saksi_eks = $_POST['Mid_saksi_eksternal'];
            	echo $_POST['Mid_saksi_ekternal'];
            	// exit();
            	for($i=0;$i<count($saksi_eks);$i++){
            		$query="select a.id_surat_was9,a.id_sp_was,b.id_saksi_eksternal,b.nama_saksi_eksternal,b.nama_kota_saksi_eksternal,b.alamat_saksi_eksternal,a.nip_pemeriksa,a.nrp_pemeriksa,a.nama_pemeriksa,a.golongan_pemeriksa,a.pangkat_pemeriksa,a.jabatan_pemeriksa,a.tanggal_pemeriksaan_was9,a.hari_pemeriksaan_was9,a.jam_pemeriksaan_was9,a.tempat_pemeriksaan_was9 
						from was.was9 a inner join was.saksi_eksternal b 
								on a.id_saksi=b.id_saksi_eksternal
								and a.id_tingkat=b.id_tingkat
								and a.id_kejati=b.id_kejati
								AND a.id_kejari = b.id_kejari
								AND a.id_cabjari = b.id_cabjari
								AND a.no_register = b.no_register
								AND b.id_wilayah=a.id_wilayah
				                AND b.id_level1=a.id_level1
				                AND b.id_level2=a.id_level2
				                AND b.id_level3=a.id_level3
				                AND b.id_level4=a.id_level4 
				                where a.id_surat_was9='".$_POST['Mid_saksi_eksternal'][$i]."' and a.trx_akhir=1 and a.jenis_saksi='Eksternal' and
								 a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' and a.id_cabjari='".$_SESSION['kode_cabjari']."' and a.id_level1='".$_SESSION['was_id_level1']."' and a.id_level2='".$_SESSION['was_id_level2']."' and a.id_level3='".$_SESSION['was_id_level3']."' and a.id_level4='".$_SESSION['was_id_level4']."'";
					$saksiEk = $connection->createCommand($query)->queryOne(); 

                    $Was11Detail_ek = new Was11DetailEks;
                    $Was11Detail_ek->no_register=$_SESSION['was_register'];
		            $Was11Detail_ek->id_tingkat=$_SESSION['kode_tk'];
		            $Was11Detail_ek->id_kejati=$_SESSION['kode_kejati'];
		            $Was11Detail_ek->id_kejari=$_SESSION['kode_kejari'];
		            $Was11Detail_ek->id_cabjari=$_SESSION['kode_cabjari'];
		            $Was11Detail_ek->id_was_11=$model->id_surat_was11;
		            $Was11Detail_ek->id_was_9=$saksiEk['id_surat_was9'];
		            $Was11Detail_ek->nama_saksi_eksternal=$saksiEk['nama_saksi_eksternal'];
		            $Was11Detail_ek->alamat_saksi_eksternal=$saksiEk['alamat_saksi_eksternal'];

		            $Was11Detail_ek->nip_pemeriksa=$saksiEk['nip_pemeriksa'];
		            $Was11Detail_ek->nrp_pemeriksa=$saksiEk['nrp_pemeriksa'];
		            $Was11Detail_ek->nama_pemeriksa=$saksiEk['nama_pemeriksa'];
		            $Was11Detail_ek->golongan_pemeriksa=$saksiEk['golongan_pemeriksa'];
		            $Was11Detail_ek->pangkat_pemeriksa=$saksiEk['pangkat_pemeriksa'];
		            $Was11Detail_ek->jabatan_pemeriksa=$saksiEk['jabatan_pemeriksa'];

		            $Was11Detail_ek->tanggal_pemeriksaan=$saksiEk['tanggal_pemeriksaan_was9'];
		            $Was11Detail_ek->hari_pemeriksaan=$saksiEk['hari_pemeriksaan_was9'];
		            $Was11Detail_ek->jam_pemeriksaan=$saksiEk['jam_pemeriksaan_was9'];
		            $Was11Detail_ek->tempat_pemeriksaan=$saksiEk['tempat_pemeriksaan_was9'];
					$Was11Detail_ek->created_ip = $_SERVER['REMOTE_ADDR'];
		            $Was11Detail_ek->created_time = date('Y-m-d H:i:s');
		            $Was11Detail_ek->created_by = \Yii::$app->user->identity->id;
		            $Was11Detail_ek->save();
                }
            }

			$pejabat = $_POST['pejabat'];
          	TembusanWas2::deleteAll(['from_table'=>'Was-12','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'pk_in_table'=>strrev($model->id_surat_was11),'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
               for($z=0;$z<count($pejabat);$z++){
                            $saveTembusan = new TembusanWas2;
                            $saveTembusan->from_table = 'Was-11';
                            $saveTembusan->pk_in_table = strrev($model->id_surat_was11);
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


            // move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'was_11/'.$rename_file);
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
             return $this->redirect(['index']);
			}
			
            } catch(Exception $e) {
                    $transaction->rollback();
			}
			
			
        } else {
            return $this->render('create', [
                'model' => $model,
				// 'searchSatker' => $searchSatker,
				// 'dataProviderSatker' => $dataProviderSatker,
				'modelTembusanMaster' => $modelTembusanMaster,
				'modelSaksiIn' => $modelSaksiIn,
				'modelSaksiEk' => $modelSaksiEk,
				// 'modelSaksiIn_trans' => $modelSaksiIn_trans,
				// 'modelSaksiEk_trans' => $modelSaksiEk_trans,
				'modelSpwas1' => $modelSpwas1,
            ]);
        }
		
		
    }

    /**
     * Updates an existing Was11 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id,$jns)
    {
	$var=str_split($_SESSION['is_inspektur_irmud_riksa']);
	/*random kode*/
    $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $res = "";
    for ($i = 0; $i < 10; $i++) {
        $res .= $chars[mt_rand(0, strlen($chars)-1)];
    }

        $model = $this->findModel($id);
        $fungsi=new FungsiComponent();
        $where=$fungsi->static_where();
        $modelTembusan=TembusanWas2::findAll(['pk_in_table'=>$model->id_surat_was11,'from_table'=>'Was-11','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
		
		$connection = \Yii::$app->db;
		$filter="no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' $where";
		$modelSpwas1=$fungsi->FunctGetIdSpwas1All($filter);
	  

		if($jns=='Internal'){
        $sql="select*from was.was_11_detail_int where id_was_11='".$model->id_surat_was11."' and no_register='".$model->no_register."' and id_tingkat='".$model->id_tingkat."' and id_kejati='".$model->id_kejati."' and id_kejari='".$model->id_kejari."' and id_cabjari='".$model->id_cabjari."' $where";
        $modelSaksiIn_trans = $connection->createCommand($sql)->queryAll(); 
		}else if($jns=='Eksternal'){
		$sql="select*from was.was_11_detail_eks where id_was_11='".$model->id_surat_was11."' and no_register='".$model->no_register."' and id_tingkat='".$model->id_tingkat."' and id_kejati='".$model->id_kejati."' and id_kejari='".$model->id_kejari."' and id_cabjari='".$model->id_cabjari."' $where";
      //  print_r($sql);
        $modelSaksiIn_trans = $connection->createCommand($sql)->queryAll(); 
		}

		$is_inspektur_irmud_riksa=$fungsi->gabung_where();
        $OldFile=$model->upload_file;
       			
        if ($model->load(Yii::$app->request->post())) {
			
				  $errors       = array();
			      $file_name    = $_FILES['upload_file']['name'];
			      $file_size    =$_FILES['upload_file']['size'];
			      $file_tmp     =$_FILES['upload_file']['tmp_name'];
			      $file_type    =$_FILES['upload_file']['type'];
			      $ext = pathinfo($file_name, PATHINFO_EXTENSION);
			      $tmp = explode('.', $_FILES['upload_file']['name']);
			      $file_exists 	= end($tmp);
			      $rename_file  =$is_inspektur_irmud_riksa.'_'.$_SESSION['inst_satkerkd'].$res.'.'.$ext;

			$connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
				// print_r($model);
				// $model->kepada_was11='hallo word';
				$model->upload_file=($file_name==''?$OldFile:$rename_file);
				$model->updated_ip = $_SERVER['REMOTE_ADDR'];
                $model->updated_time = date('Y-m-d H:i:s');
                $model->updated_by = \Yii::$app->user->identity->id;	
			if($model->save()){
				if($OldFile!='' && file_exists($file_tmp) && file_exists(\Yii::$app->params['uploadPath'].'was_11/'.$OldFile)) {
			          unlink(\Yii::$app->params['uploadPath'].'was_11/'.$OldFile);
			      } 

			    $tmp_jns = $_POST['Was11']['jenis_saksi'];
			if($tmp_jns=='Internal'){
				$saksi_int = $_POST['nip'];
						Was11Detailint::deleteAll(['id_was_11'=>$model['id_surat_was11'],'id_tingkat'=>$model['id_tingkat'],'id_kejati'=>$model['id_kejati'],'id_kejari'=>$model['id_kejari'],'id_cabjari'=>$model['id_cabjari'],'id_wilayah'=>$model['id_wilayah'],'id_level1'=>$model['id_level1'],'id_level2'=>$model['id_level2'],'id_level3'=>$model['id_level3'],'id_level4'=>$model['id_level4']]);	
						for($i=0;$i<count($saksi_int);$i++){
        					$query="select a.id_surat_was9,a.id_sp_was,b.nip,b.nama_saksi_internal,b.pangkat_saksi_internal,b.nrp,a.nip_pemeriksa,golongan_saksi_internal,b.jabatan_saksi_internal,a.nrp_pemeriksa,a.nama_pemeriksa,a.golongan_pemeriksa,a.pangkat_pemeriksa,a.jabatan_pemeriksa,a.tanggal_pemeriksaan_was9,a.hari_pemeriksaan_was9,a.jam_pemeriksaan_was9,a.tempat_pemeriksaan_was9
        						from was.was9 a inner join was.saksi_internal b 
										on a.id_saksi=b.id_saksi_internal
										and a.id_tingkat=b.id_tingkat
										and a.id_kejati=b.id_kejati
										AND a.id_kejari = b.id_kejari
										AND a.id_cabjari = b.id_cabjari
										AND a.no_register = b.no_register
										AND a.id_wilayah=b.id_wilayah
										AND a.id_level1=b.id_level1
										AND a.id_level2=b.id_level2
										AND a.id_level3=b.id_level3
										AND a.id_level4=b.id_level4
										AND b.no_register=b.no_register
										where a.id_surat_was9='".$_POST['nip'][$i]."' and a.jenis_saksi='Internal' and
								 a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' and a.id_cabjari='".$_SESSION['kode_cabjari']."' and a.id_level1='".$_SESSION['was_id_level1']."' and a.id_level2='".$_SESSION['was_id_level2']."' and a.id_level3='".$_SESSION['was_id_level3']."' and a.id_level4='".$_SESSION['was_id_level4']."'";
							$saksiIN = $connection->createCommand($query)->queryOne(); 

		                    $Was11Detail = new Was11Detailint;
		                    $Was11Detail->no_register=$_SESSION['was_register'];
				            $Was11Detail->id_tingkat=$_SESSION['kode_tk'];
				            $Was11Detail->id_kejati=$_SESSION['kode_kejati'];
				            $Was11Detail->id_kejari=$_SESSION['kode_kejari'];
				            $Was11Detail->id_cabjari=$_SESSION['kode_cabjari'];
				            // $Was11Detail->id_was_11_detail_int=1;
				            $Was11Detail->id_was_11=$model->id_surat_was11;
				            $Was11Detail->id_was_9=1;
				            $Was11Detail->nip_saksi_internal=$saksiIN['nip'];
				            $Was11Detail->nrp_saksi_internal=$saksiIN['nrp'];
				            $Was11Detail->nama_saksi_internal=$saksiIN['nama_saksi_internal'];
				            $Was11Detail->pangkat_saksi_internal=$saksiIN['pangkat_saksi_internal'];
				            $Was11Detail->golongan_saksi_internal=$saksiIN['golongan_saksi_internal'];
				            $Was11Detail->jabatan_saksi_internal=$saksiIN['jabatan_saksi_internal'];

				            $Was11Detail->nip_pemeriksa=$saksiIN['nip_pemeriksa'];
				            $Was11Detail->nrp_pemeriksa=$saksiIN['nrp_pemeriksa'];
				            $Was11Detail->nama_pemeriksa=$saksiIN['nama_pemeriksa'];
				            $Was11Detail->golongan_pemeriksa=$saksiIN['golongan_pemeriksa'];
				            $Was11Detail->pangkat_pemeriksa=$saksiIN['pangkat_pemeriksa'];
				            $Was11Detail->jabatan_pemeriksa=$saksiIN['jabatan_pemeriksa'];

				            $Was11Detail->tanggal_pemeriksaan=$saksiIN['tanggal_pemeriksaan_was9'];
				            $Was11Detail->hari_pemeriksaan=$saksiIN['hari_pemeriksaan_was9'];
				            $Was11Detail->jam_pemeriksaan=$saksiIN['jam_pemeriksaan_was9'];
				            $Was11Detail->tempat_pemeriksaan=$saksiIN['tempat_pemeriksaan_was9'];
							$Was11Detail->created_ip = $_SERVER['REMOTE_ADDR'];
				            $Was11Detail->created_time = date('Y-m-d H:i:s');
				            $Was11Detail->created_by = \Yii::$app->user->identity->id;
				            $Was11Detail->save();
		                }
		        }else{
            	$saksi_eks = $_POST['Mid_saksi_eksternal'];
						Was11DetailEks::deleteAll(['id_was_11'=>$model['id_surat_was11'],'id_tingkat'=>$model['id_tingkat'],'id_kejati'=>$model['id_kejati'],'id_kejari'=>$model['id_kejari'],'id_cabjari'=>$model['id_cabjari'],'id_wilayah'=>$model['id_wilayah'],'id_level1'=>$model['id_level1'],'id_level2'=>$model['id_level2'],'id_level3'=>$model['id_level3'],'id_level4'=>$model['id_level4']]);	
            	for($i=0;$i<count($saksi_eks);$i++){
            		$query="select a.id_surat_was9,a.id_sp_was,b.id_saksi_eksternal,
            		b.nama_saksi_eksternal,b.nama_kota_saksi_eksternal,b.alamat_saksi_eksternal,
            		a.nip_pemeriksa,a.nrp_pemeriksa,a.nama_pemeriksa,a.golongan_pemeriksa,
            		a.pangkat_pemeriksa,a.jabatan_pemeriksa,a.tanggal_pemeriksaan_was9,
            		a.hari_pemeriksaan_was9,a.jam_pemeriksaan_was9,a.tempat_pemeriksaan_was9
						from was.was9 a inner join was.saksi_eksternal b 
								on a.id_saksi=b.id_saksi_eksternal
								and a.id_tingkat=b.id_tingkat
								and a.id_kejati=b.id_kejati
								AND a.id_kejari = b.id_kejari
								AND a.id_cabjari = b.id_cabjari
								AND a.no_register = b.no_register
								AND b.id_wilayah=a.id_wilayah
				                AND b.id_level1=a.id_level1
				                AND b.id_level2=a.id_level2
				                AND b.id_level3=a.id_level3
				                AND b.id_level4=a.id_level4 
				                AND b.no_register=b.no_register
				                where a.id_surat_was9='".$_POST['Mid_saksi_eksternal'][$i]."' and a.jenis_saksi='Eksternal' and
								 a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' and a.id_cabjari='".$_SESSION['kode_cabjari']."' and a.id_level1='".$_SESSION['was_id_level1']."' and a.id_level2='".$_SESSION['was_id_level2']."' and a.id_level3='".$_SESSION['was_id_level3']."' and a.id_level4='".$_SESSION['was_id_level4']."'";
					
					$saksiEk = $connection->createCommand($query)->queryOne(); 

                    $Was11Detail_ek = new Was11DetailEks;
                    $Was11Detail_ek->no_register=$_SESSION['was_register'];
		            $Was11Detail_ek->id_tingkat=$_SESSION['kode_tk'];
		            $Was11Detail_ek->id_kejati=$_SESSION['kode_kejati'];
		            $Was11Detail_ek->id_kejari=$_SESSION['kode_kejari'];
		            $Was11Detail_ek->id_cabjari=$_SESSION['kode_cabjari'];
		            $Was11Detail_ek->id_was_11=$model->id_surat_was11;
		            $Was11Detail_ek->id_was_9=$saksiEk['id_surat_was9'];
		            $Was11Detail_ek->nama_saksi_eksternal=$saksiEk['nama_saksi_eksternal'];
		            $Was11Detail_ek->alamat_saksi_eksternal=$saksiEk['alamat_saksi_eksternal'];

		            $Was11Detail_ek->nip_pemeriksa=$saksiEk['nip_pemeriksa'];
		            $Was11Detail_ek->nrp_pemeriksa=$saksiEk['nrp_pemeriksa'];
		            $Was11Detail_ek->nama_pemeriksa=$saksiEk['nama_pemeriksa'];
		            $Was11Detail_ek->golongan_pemeriksa=$saksiEk['golongan_pemeriksa'];
		            $Was11Detail_ek->pangkat_pemeriksa=$saksiEk['pangkat_pemeriksa'];
		            $Was11Detail_ek->jabatan_pemeriksa=$saksiEk['jabatan_pemeriksa'];

		            $Was11Detail_ek->tanggal_pemeriksaan=$saksiEk['tanggal_pemeriksaan_was9'];
		            $Was11Detail_ek->hari_pemeriksaan=$saksiEk['hari_pemeriksaan_was9'];
		            $Was11Detail_ek->jam_pemeriksaan=$saksiEk['jam_pemeriksaan_was9'];
		            $Was11Detail_ek->tempat_pemeriksaan=$saksiEk['tempat_pemeriksaan_was9'];

					$Was11Detail_ek->created_ip = $_SERVER['REMOTE_ADDR'];
		            $Was11Detail_ek->created_time = date('Y-m-d H:i:s');
		            $Was11Detail_ek->created_by = \Yii::$app->user->identity->id;
		            $Was11Detail_ek->save();
                }
            }
		
				$pejabat = $_POST['pejabat'];
		          TembusanWas2::deleteAll(['from_table'=>'Was-11','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'pk_in_table'=>strrev($model->id_surat_was11),'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
		               for($z=0;$z<count($pejabat);$z++){
		                    $saveTembusan = new TembusanWas2;
		                    $saveTembusan->from_table = 'Was-11';
		                    $saveTembusan->pk_in_table = strrev($model->id_surat_was11);
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

           
           	move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'was_11/'.$rename_file);
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
               // return $this->redirect(['index']);
			}
			
			} catch(Exception $e) {
                    $transaction->rollback();
                    if(YII_DEBUG){throw $e; exit;} else{return false;}
			}
		
        } else {
            return $this->render('update', [
                'model' => $model,
				// 'tembusan'=>$tembusan,
				'searchSatker' => $searchSatker,
				'dataProviderSatker' => $dataProviderSatker,
				'modelTembusan' => $modelTembusan,
				'modelSaksiIn' => $modelSaksiIn,
				'modelSaksiEk' => $modelSaksiEk,
				'modelSaksiIn_trans' => $modelSaksiIn_trans,
				'modelSaksiEk_trans' => $modelSaksiEk_trans,
				'modelSpwas1' => $modelSpwas1,
            ]);
        }
		
		
    }

    /**
     * Deletes an existing Was11 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete(){
	$id = $_POST['id'];
	$jml = $_POST['jml'];
	$check = explode(',',$id);
	for ($i=0; $i < $jml; $i++) { 
		$this->findModel($check[$i])->delete();
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

	public function actionGetttd(){
       
   $searchModelWas12 = new Was11Search();
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

	
    public function actionCetakdocx($no_register,$id,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari){
    	$data_satker = KpInstSatkerSearch::findOne(['inst_satkerkd'=>$_SESSION['inst_satkerkd']]);/*lokasi dan nama kejaksaan*/
    	$connection = \Yii::$app->db;
		$fungsi=new FungsiComponent();
		$where=$fungsi->static_where_alias('a');
		$query="select * FROM was.was11 a	where  
					a.no_register='".$no_register."' and a.id_tingkat='".$id_tingkat."' 
                    and a.id_kejati='".$id_kejati."' 
                    and a.id_kejari='".$id_kejari."' and a.id_cabjari='".$id_cabjari."'
                    and a.id_surat_was11='".$id."' $where";
		$model = $connection->createCommand($query)->queryOne();
		$tgl_was_11=\Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_was_11']);

		
	     $query3 = "select a.*,b.* from was.pegawai_terlapor a
                    inner join was.sp_was_1 b
                    on a.id_sp_was1=b.id_sp_was1
                    and a.id_tingkat=b.id_tingkat
                    and a.id_kejati=b.id_kejati
                    and a.id_kejari=b.id_kejari
                    and a.id_cabjari=b.id_cabjari
                    AND b.id_wilayah=a.id_wilayah
	                AND b.id_level1=a.id_level1
	                AND b.id_level2=a.id_level2
	                AND b.id_level3=a.id_level3
	                AND b.id_level4=a.id_level4 
	                AND b.no_register=a.no_register
                    where a.no_register='".$no_register."' and a.id_tingkat='".$id_tingkat."' 
                    and a.id_kejati='".$id_kejati."' 
                    and a.id_kejari='".$id_kejari."' and a.id_cabjari='".$id_cabjari."'
                    $where";
        $modelterlapor1 = $connection->createCommand($query3)->queryOne();

	     $tgl_sp_was= \Yii::$app->globalfunc->ViewIndonesianFormat($modelterlapor1['tanggal_sp_was1']);
	     
	     $sql="select a.* from was.was_11_detail_int a where a.id_was_11='".$id."' and a.no_register='".$no_register."' and a.id_tingkat='".$id_tingkat."' and a.id_kejati='".$id_kejati."' 
                    and a.id_kejari='".$id_kejari."' and a.id_cabjari='".$id_cabjari."'
                    $where";
	     $saksiIN=$connection->createCommand($sql)->queryAll();

	     $sql2="select a.* from was.was_11_detail_eks a where a.id_was_11='".$id."' and a.no_register='".$no_register."' and a.id_tingkat='".$id_tingkat."' and a.id_kejati='".$id_kejati."' 
                    and a.id_kejari='".$id_kejari."' and a.id_cabjari='".$id_cabjari."'
                    $where";
	     $saksiEK=$connection->createCommand($sql2)->queryAll();
	     
	     $query4 = "select a.* from was.lapdu a
                    where a.no_register='".$no_register."' and a.id_tingkat='".$id_tingkat."' 
                    and a.id_kejati='".$id_kejati."' 
                    and a.id_kejari='".$id_kejari."' and a.id_cabjari='".$id_cabjari."'
                   ";
        $modelLapdu = $connection->createCommand($query4)->queryOne();

        $query5 = "select string_agg(a.nama_pegawai_terlapor,', ') as nama_pegawai_terlapor from was.pegawai_terlapor a
                    inner join was.sp_was_1 b
                    on a.id_sp_was1=b.id_sp_was1
                    and a.id_tingkat=b.id_tingkat
                    and a.id_kejati=b.id_kejati
                    and a.id_kejari=b.id_kejari
                    and a.id_cabjari=b.id_cabjari
                    AND b.id_wilayah=a.id_wilayah
	                AND b.id_level1=a.id_level1
	                AND b.id_level2=a.id_level2
	                AND b.id_level3=a.id_level3
	                AND b.id_level4=a.id_level4 
	                AND b.no_register=a.no_register
                    where a.no_register='".$no_register."' and a.id_tingkat='".$id_tingkat."' 
                    and a.id_kejati='".$id_kejati."' 
                    and a.id_kejari='".$id_kejari."' and a.id_cabjari='".$id_cabjari."'
                    and a.id_sp_was1='".$model['id_sp_was']."' $where";
        $modelterlapor = $connection->createCommand($query5)->queryOne();

        $query6 = "select a.* from was.tembusan_was a
                    where a.no_register='".$no_register."' and a.id_tingkat='".$id_tingkat."' 
                    and a.id_kejati='".$id_kejati."' 
                    and a.id_kejari='".$id_kejari."' and a.id_cabjari='".$id_cabjari."'
                    and a.pk_in_table='".$model['id_surat_was11']."' and from_table='Was-11' $where order by is_order desc";
        $tembusan_was11 = $connection->createCommand($query6)->queryAll();
	  
	  	 
    	 return $this->render('cetak',[
    	 	'data_satker'=>$data_satker,
    	 	'model'=>$model,
    	 	'tgl_was_11'=>$tgl_was_11,
    	 	'modelterlapor'=>$modelterlapor,
    	 	'tgl_sp_was'=>$tgl_sp_was,
    	 	'modelterlapor1'=>$modelterlapor1,
    	 	'saksiIN'=>$saksiIN,
    	 	'saksiEK'=>$saksiEK,
    	 	'modelLapdu'=>$modelLapdu,
    	 	'tembusan_was11'=>$tembusan_was11,
    	 	]);
    }
    protected function findModel($id)
    {
        if (($model = Was11::findOne(['id_surat_was11'=>$id,'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
