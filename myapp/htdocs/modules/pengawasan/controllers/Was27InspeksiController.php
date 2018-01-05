<?php

namespace app\modules\pengawasan\controllers;

use Yii;

use yii\web\Controller;
use app\modules\pengawasan\models\TembusanWas;/*mengambil tembusan dari master*/
use app\modules\pengawasan\models\TembusanWasx;/*mengambil tembusan */
use yii\web\NotFoundHttpException;
use app\modules\pengawasan\models\LWas2Terlapor; 
use app\modules\pengawasan\models\Was27InspeksiDetailTerlapor;
use app\modules\pengawasan\models\Was27InspeksiSearch;
use app\modules\pengawasan\models\Pelapor;
use app\modules\pengawasan\models\PelaporSearch;
use yii\filters\VerbFilter;
use app\modules\pengawasan\models\Was27Inspeksi; 
use app\modules\pengawasan\models\lwas2inspeksi; 
use app\modules\pengawasan\models\SpWas2; 
use app\modules\pengawasan\components\FungsiComponent;
use app\models\KpInstSatkerSearch;
use app\models\KpPegawai;
use app\modules\pengawasan\models\Lapdu; 
use app\modules\pengawasan\models\TembusanWas2;/*mengambil tembusan dari transaksi*/
use yii\grid\GridView;
use yii\widgets\Pjax;
//use app\modules\pengawasan\models\l_was_2_terlapor;

/**
 * InspekturModelController implements the CRUD actions for InspekturModel model.
 */
class Was27InspeksiController extends Controller
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
		$query=Was27Inspeksi::findOne(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);

        if(count($query)>0){
          $this->redirect(\Yii::$app->urlManager->createUrl("pengawasan/was27-inspeksi/update?id=".$query->id_was_27_inspeksi));
        }else{
          $this->redirect(\Yii::$app->urlManager->createUrl("pengawasan/was27-inspeksi/create"));
        }
        /* echo "string";
        exit();
        $searchModel = new DipaMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]); */
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
    public function actionCreate()
    { 
		$query=Was27Inspeksi::findOne(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
        if(count($query)>0){
			$this->redirect(\Yii::$app->urlManager->createUrl("pengawasan/was27-inspeksi/update?id=".$query->id_was_27_inspeksi));
        }else{
			$model 			= new Was27Inspeksi();
			$modelTembusanMaster = TembusanWas::findBySql("select * from was.was_tembusan_master where for_tabel='was_27_inspeksi' or for_tabel='master'")->all();	
			$modelTerlapor 	= LWas2Terlapor::findAll(['saran_l_was_2'=>'2','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
			$modelPelapor	= Pelapor::findAll(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari']]);
			$FungsiWas      = new FungsiComponent();
			$filter         = "no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and trx_akhir=1 and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'";
			$getId          = $FungsiWas->FunctGetIdSpwas2($filter);
			$modelLapdu     = Lapdu::findOne(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari']]);
			$idbawas2		= Lwas2Inspeksi::findOne(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
			
			if ($model->load(Yii::$app->request->post())){
				$connection = \Yii::$app->db;
				$transaction = $connection->beginTransaction();
				try { 
					$model->id_tingkat 	= $_SESSION['kode_tk'];
					$model->id_kejati 	= $_SESSION['kode_kejati'];
					$model->id_kejari 	= $_SESSION['kode_kejari'];
					$model->id_cabjari 	= $_SESSION['kode_cabjari'];
					$model->no_register	= $_SESSION['was_register'];
					$model->id_sp_was2 	= $idbawas2['id_sp_was2'];
					$model->id_ba_was2	= $idbawas2['id_ba_was2'];
					$model->id_l_was2	= $idbawas2['id_l_was2'];
					$model->created_ip 	= $_SERVER['REMOTE_ADDR'];
					$model->created_time =date('Y-m-d h:i:sa');
					$model->created_by 	= \Yii::$app->user->identity->id;
					 
				if($model->save()) {
					for($i=0;$i<count($_POST['nip_terlapor']);$i++){ 
						$saveModel27terlapor=new Was27InspeksiDetailTerlapor();
						$saveModel27terlapor->id_tingkat 	= $_SESSION['kode_tk'];
						$saveModel27terlapor->id_kejati 	= $_SESSION['kode_kejati'];
						$saveModel27terlapor->id_kejari 	= $_SESSION['kode_kejari'];
						$saveModel27terlapor->id_cabjari 	= $_SESSION['kode_cabjari'];
						$saveModel27terlapor->no_register	= $_SESSION['was_register'];
						$saveModel27terlapor->id_sp_was2 	= $model->id_sp_was2;
						$saveModel27terlapor->id_ba_was2	= $model->id_ba_was2;
						$saveModel27terlapor->id_l_was2		= $model->id_l_was2;
						$saveModel27terlapor->id_was_27_inspeksi		= $model->id_was_27_inspeksi;
						$saveModel27terlapor->nip_pegawai_terlapor	= $_POST['nip_terlapor'][$i];
						$saveModel27terlapor->created_ip 	= $_SERVER['REMOTE_ADDR'];
						$saveModel27terlapor->created_time 	= date('Y-m-d h:i:sa');
						$saveModel27terlapor->created_by 	= \Yii::$app->user->identity->id;
						
						$saveModel27terlapor->save();
					}
					
					$pejabat = $_POST['pejabat'];
					for($z=0;$z<count($pejabat);$z++){
						$saveTembusan = new TembusanWas2;
						$saveTembusan->from_table = 'Was-27-inspeksi';
						$saveTembusan->pk_in_table = strrev($model->id_was_27_inspeksi);
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
				return $this->redirect(['index']);
				 } catch(Exception $e) {

                    $transaction->rollback();
            }
			}   else {
				return $this->render('create', [
					'model' => $model,
					'modelTerlapor' => $modelTerlapor,
					'modelTembusanMaster' => $modelTembusanMaster,
					'modelPelapor' => $modelPelapor,
					'modelLapdu' => $modelLapdu,
				]);
			}
		}
    }

    /**
     * Updates an existing InspekturModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) { 
		$chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $res = "";
        for ($i = 0; $i < 10; $i++) {
            $res .= $chars[mt_rand(0, strlen($chars)-1)];
        } 
        $model 				= $this->findModel($id);
		$modelTerlapor		= LWas2Terlapor::findAll(['saran_l_was_2'=>'2','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
		$modelWas27Detail	= Was27InspeksiDetailTerlapor::findAll(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
		$modelPelapor 		= Pelapor::findAll(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari']]);
		
		$modelTembusan		= TembusanWas2::find()->where(['pk_in_table'=>$model->id_was_27_inspeksi,'from_table'=>'Was-27-inspeksi','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']])->orderBy('is_order desc')->all();		
		$modelLapdu          =Lapdu::findOne(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari']]);
		
		$fungsi = new FungsiComponent();
        $is_inspektur_irmud_riksa=$fungsi->gabung_where();
        $OldFile=$model->file_was_27;
			 // $OldFile=$model->upload_file_data;
		//print_r ($modelLapdu);
		//exit(); 
        if ($model->load(Yii::$app->request->post()) ){ 
			$connection = \Yii::$app->db;
			$transaction = $connection->beginTransaction();
			try {
			$errors       = array();
			$file_name    = $_FILES['file_was_27']['name'];
			$file_size    =$_FILES['file_was_27']['size'];
			$file_tmp     =$_FILES['file_was_27']['tmp_name'];
			$file_type    =$_FILES['file_was_27']['type'];
			$ext = pathinfo($file_name, PATHINFO_EXTENSION);
			$tmp = explode('.', $_FILES['file_was_27']['name']);
			$file_exists = end($tmp);
			$rename_file  =$is_inspektur_irmud_riksa.'_'.$_SESSION['inst_satkerkd'].$res.'.'.$ext;
			$model->updated_ip 	= $_SERVER['REMOTE_ADDR'];
			$model->updated_time =date('Y-m-d h:i:sa');
			$model->updated_by 	= \Yii::$app->user->identity->id;
			$model->file_was_27 = ($file_name==''?$OldFile:$rename_file);
		if($model->save()){
				Was27InspeksiDetailTerlapor::deleteAll(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_was_27_inspeksi'=>$model->id_was_27_inspeksi]);
					for($i=0;$i<count($_POST['nip_terlapor']);$i++){ 
						$modelKpPegawai = KpPegawai::findOne(['peg_nip_baru'=>$_POST['nip_terlapor'][$i]]);
						$saveModel27terlapor=new Was27InspeksiDetailTerlapor();
						$saveModel27terlapor->id_tingkat 	= $_SESSION['kode_tk'];
						$saveModel27terlapor->id_kejati 	= $_SESSION['kode_kejati'];
						$saveModel27terlapor->id_kejari 	= $_SESSION['kode_kejari'];
						$saveModel27terlapor->id_cabjari 	= $_SESSION['kode_cabjari'];
						$saveModel27terlapor->no_register	= $_SESSION['was_register'];
						$saveModel27terlapor->id_sp_was2 	= $model->id_sp_was2;
						$saveModel27terlapor->id_ba_was2	= $model->id_ba_was2;
						$saveModel27terlapor->id_l_was2		= $model->id_l_was2;
						$saveModel27terlapor->id_was_27_inspeksi	= $model->id_was_27_inspeksi;
						$saveModel27terlapor->nip_pegawai_terlapor	= $_POST['nip_terlapor'][$i];
						$saveModel27terlapor->nama_pegawai_terlapor	= $modelKpPegawai['nama'];
						$saveModel27terlapor->nrp_pegawai_terlapor	= $modelKpPegawai['peg_nrp'];
						$saveModel27terlapor->pangkat_pegawai_terlapor	= $modelKpPegawai['gol_pangkat2'];
						$saveModel27terlapor->golongan_pegawai_terlapor	= $modelKpPegawai['gol_kd'];
						$saveModel27terlapor->jabatan_pegawai_terlapor	= $modelKpPegawai['jabatan'];
						$saveModel27terlapor->satker_pegawai_terlapor	= $modelKpPegawai['instansi'];
						$saveModel27terlapor->created_ip 	= $_SERVER['REMOTE_ADDR'];
						$saveModel27terlapor->created_time 	= date('Y-m-d h:i:sa');
						$saveModel27terlapor->created_by 	= \Yii::$app->user->identity->id;
						
						$saveModel27terlapor->save();
					}
			TembusanWas2::deleteAll(['from_table'=>'Was-27-inspeksi','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'pk_in_table'=>$model->id_was_27_inspeksi]);
			$pejabat = $_POST['pejabat'];
							
			
					for($z=0;$z<count($pejabat);$z++){
						$saveTembusan = new TembusanWas2;
						$saveTembusan->from_table = 'Was-27-inspeksi';
						$saveTembusan->pk_in_table = strrev($model->id_was_27_inspeksi);
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
						/* print_r ($saveTembusan->save());
						exit(); */
						$saveTembusan->save();
					}
			move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'was_27_inspek/'.$rename_file);
		}
            // return $this->redirect(['view', 'id' => $model->id_inspektur]);
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
			} catch(Exception $e) {

                    $transaction->rollback();
            }
        } else {
            return $this->render('update', [
                'model' => $model,
				'modelTembusan' => $modelTembusan,
                'modelTerlapor' => $modelTerlapor,
                'modelPelapor' => $modelPelapor,
				'modelWas27Detail' => $modelWas27Detail,
				'modelLapdu' => $modelLapdu,
            ]);
        }
    }
	
	public function actionCetak($id){
		$noreg			= $_SESSION['was_register'];
		$model			= $this->findModel($id);
		$data_satker 	= KpInstSatkerSearch::findOne(['inst_satkerkd'=>$_SESSION['inst_satkerkd']]);/*lokasi dan nama kejaksaan*/
	   	$lwas2 			= lwas2inspeksi::findOne(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
	   	$SpWas2 		= SpWas2::findOne(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
		$modelTerlapor	= LWas2Terlapor::findAll(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
		$modelPelapor 	= Pelapor::findAll(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari']]);
		$modelLapdu     = Lapdu::findOne(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari']]);
		$modelTembusanMaster = TembusanWasx::find()->where(['pk_in_table'=>$model->id_was_27_inspeksi,'from_table'=>'Was-27-inspeksi','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']])->orderBy('is_order desc')->all();	
 
		return $this->render('cetak',[
				'model'=>$model,
				'data_satker'=>$data_satker, 
				'lwas2'=>$lwas2, 
				'SpWas2'=>$SpWas2, 
				'modelTerlapor'=>$modelTerlapor, 
				'modelPelapor'=>$modelPelapor, 
				'modelLapdu'=>$modelLapdu,  
				'modelTembusanMaster'=>$modelTembusanMaster,  
		]);
     
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
	
    public function actionViewpdf($id)
    {
        
       $file_upload=$this->findModel($id);
	    
        // print_r($file_upload['file_lapdu']);
          $filepath = '../modules/pengawasan/upload_file/was_27_inspek/'.$file_upload['file_was_27'];
        $extention=explode(".", $file_upload['file_was_27']);
           if($extention[1]=='jpg' || $extention[1]=='jpeg' || $extention[1]=='png'){
            return Yii::$app->response->sendFile($filepath);
           }else{
          if(file_exists($filepath))
          {
              // Set up PDF headers
              header('Content-type: application/pdf');
              header('Content-Disposition: inline; filename="' . $file_upload['file_was_27'] . '"');
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
  
   $searchModelWas27 = new Was27InspeksiSearch();
   $dataProviderPenandatangan = $searchModelWas27->searchPenandatangan(Yii::$app->request->queryParams);
   Pjax::begin(['id' => 'Mpenandatangan-tambah-grid', 'timeout' => false,'formSelector' => '#searchFormPenandatangan','enablePushState' => false]);
   echo GridView::widget([
                        'dataProvider'=> $dataProviderPenandatangan,
                        // 'filterModel' => $searchModel,
                        // 'layout' => "{items}\n{pager}",
                        'columns' => [
                            ['header'=>'No',
                            'headerOptions'=>['style'=>'text-align:center;'],
                            'contentOptions'=>['style'=>'text-align:center;'],
                            'header'=>'No',
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
     * Finds the InspekturModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InspekturModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Was27Inspeksi::findOne(['id_was_27_inspeksi'=>$id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
}
