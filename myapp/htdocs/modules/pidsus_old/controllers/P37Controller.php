<?php

namespace app\modules\pidsus\controllers;

use Yii;
use app\modules\pidsus\models\PdsTut;
use app\modules\pidsus\models\PdsTutSuratSaksi;
use app\modules\pidsus\models\PdsTutSuratTersangka;
use app\modules\pidsus\models\PdsTutSaksi;
use app\modules\pidsus\models\PdsTutTembusan;
use app\modules\pidsus\models\KpPegawai;
use app\modules\pidsus\models\PdsTutSuratforP37;
use app\modules\pidsus\models\PdsTutSurat;
use app\modules\pidsus\models\PdsTutSuratKeterangan;
use app\modules\pidsus\models\PdsTutSuratJaksa;
use app\modules\pidsus\models\PdsTutSuratIsi;
use app\modules\pidsus\models\PdsTutSuratSearch;
use app\modules\pidsus\models\PdsTutPermintaanData;
use app\modules\pidsus\models\PdsTutUsulanPermintaanData;
use app\modules\pidsus\models\Status;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Ba1Controller implements the CRUD actions for PdsTutSurat model.
 */
class P37Controller extends Controller
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
     * Lists all PdsTutSurat models.
     * @return mixed
     */
    public function actionIndex()
    {
    	$id=$_SESSION['idPdsTut'];
        $searchModel = new PdsTutSuratSearch();
        $dataProvidersks = $searchModel->search2(Yii::$app->request->queryParams,'p37sks',$id);
        $dataProvidertdw = $searchModel->search2(Yii::$app->request->queryParams,'p37tdw',$id);
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvidersks' => $dataProvidersks,
            'dataProvidertdw' => $dataProvidertdw,
        	'id' => $id,	
        ]);
    }

    /**
     * Displays a single PdsTutSurat model.
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
     * Creates a new PdsTutSurat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id,$type)
    {
        //Create new pdslidsurat
    	$model = new PdsTutSurat();
        $model->id_jenis_surat="p37$type";
        $model->id_pds_tut=$id;
        $model->create_by=(string)Yii::$app->user->identity->username;
		$model->create_ip=(string)$_SERVER['REMOTE_ADDR'];
        $model->save();
        //get latest idpdslidsurat
        $model= PdsTutSuratforP37::findBySql("select * from pidsus.pds_tut_surat where id_pds_tut='".$id."' and id_jenis_surat='p37$type' and create_by='".(string)Yii::$app->user->identity->username."' order by create_date desc limit 1")->one();
        //insert default pertanyaan
       	if($type=='sks'){
	        //create saksi for pidsus 8
	        $modelSaksi=new PdsTutSaksi();
	        $modelSaksi->id_pds_tut=$id;
	        $modelSaksi->create_by=(string)Yii::$app->user->identity->username;
	        $modelSaksi->save();    
	        //print_r($modelSaksi->getErrors());
	            
	        $modelSaksi= PdsTutSaksi::findBySql("select * from pidsus.pds_tut_saksi where id_pds_tut='".$id."' and create_by='".(string)Yii::$app->user->identity->username."' order by create_date desc limit 1")->one();
	         
	        $modelSuratSaksi= new PdsTutSuratSaksi();
	        $modelSuratSaksi->id_pds_tut_surat=$model->id_pds_tut_surat;
	        $modelSuratSaksi->no_urut=1;
	        $modelSuratSaksi->id_saksi=$modelSaksi->id_pds_tut_saksi;
	        $modelSuratSaksi->create_by=(string)Yii::$app->user->identity->username;
	        $modelSuratSaksi->save();
       	}
       	else if($type=='tdw'){
       		$modelSuratTersangka=new PdsTutSuratTersangka();
       		$modelSuratTersangka->id_pds_tut_surat=$model->id_pds_tut_surat;
       		$modelSuratTersangka->create_by=(string)Yii::$app->user->identity->username;
       		$modelSuratTersangka->save();
        //print_r($modelSuratTersangka->getErrors());
        //die();
       		 
       	}
        //print_r($modelSuratSaksi->getErrors());
       // die();
        return $this->redirect(['update?id='.$model->id_pds_tut_surat]);
    }

    /**
     * Updates an existing PdsTutSurat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
    	$model = PdsTutSuratforP37::findOne($id);
    	if($model->id_jenis_surat=='p37sks'){
    		$modelSuratSaksi=PdsTutSuratSaksi::find()->where(['id_pds_tut_surat'=>$id])->one();
    		$modelSaksiTersangka=PdsTutSaksi::findOne($modelSuratSaksi->id_saksi);    		 
    	}
    	else if($model->id_jenis_surat=='p37tdw'){
    		$modelSaksiTersangka=PdsTutSuratTersangka::find()->where(['id_pds_tut_surat'=>$id])->one();    	
			//print_r($modelSaksiTersangka);die();
    	}
    	$modelTut = $this->findModelTut($model->id_pds_tut);
    	//$modelStatus=Status::findOne($modelTut->id_status);
    //	$modelKpPegawai= null;
    //	$modelJaksa=PdsTutSuratJaksa::find()->where('id_pds_tut_surat=\''.$model->id_pds_tut_surat.'\' order by no_urut')->all();
    //	$modelPermintaanData=PdsTutPermintaanData::find()->where(['id_pds_tut_surat'=>$model->id_pds_tut_surat])->all();
        $modelSuratIsi= PdsTutSuratIsi::findBySql('select * from pidsus.select_surat_isi_tut(\''.$model->id_pds_tut_surat.'\',\''.Yii::$app->user->id.'\')')->all();
	//	$modelPermintaanData4=PdsTutUsulanPermintaanData::findBySql('select * from pidsus.pds_tut_usulan_permintaan_data where id_pds_tut_surat in (select id_pds_tut_surat from pidsus.pds_tut_surat where id_jenis_surat=\'pidsus4\' and id_pds_tut=\''.$model->id_pds_tut.'\' )')->all();
		$modelSuratJaksa=PdsTutSuratJaksa::find()->where(['id_pds_tut_surat'=>$id])->all();
		$modelJaksa=KpPegawai::findBySql('select * from kepegawaian.kp_pegawai where peg_nik in (select id_jaksa from pidsus.pds_tut_jaksa where id_pds_tut= \''.$_SESSION['idPdsTut'].'\')')->all();
		if(isset($_SESSION['cetak'])){
			$_SESSION['cetak']=null;
			$link = "<script>window.open(\"../../pidsus/tut/viewreporttut?id=$model->id_pds_tut_surat\")</script>";
			echo $link;
		}

        if ($model->load(Yii::$app->request->post())&&$modelSaksiTersangka->load(Yii::$app->request->post()) ) {

			if(isset($_POST['nip_jpu'])){
				$nip_jpu=$_POST['nip_jpu'];
			}
			else $nip_jpu=null;
			
			if(isset($_POST['hapus_jpu'])){
				$hapus_jpu=$_POST['hapus_jpu'];
			}
			else $hapus_jpu=null;

			if ($hapus_jpu!=null){
				for($i = 0; $i < count($hapus_jpu); $i++){
					PdsTutSuratJaksa::deleteAll(['id_jaksa' => $hapus_jpu[$i], 'id_pds_tut_surat'=>$model->id_pds_tut_surat]);
				}
			}

			if ($nip_jpu!=null){
				for($i = 0; $i < count($nip_jpu); $i++){
					$modelJaksaSurat= new PdsTutSuratJaksa();
					$modelJaksaSurat->create_by=(string)Yii::$app->user->identity->username;
					$modelJaksaSurat->id_pds_tut_surat=$model->id_pds_tut_surat;
					$modelJaksaSurat->id_jaksa=$nip_jpu[$i];

					$modelJaksaSurat->save();
					}
			}
			
			
        	$model->update_by=(string)Yii::$app->user->identity->username;
        	$model->update_date=date('Y-m-d H:i:s');$model->flag='1';
			$model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
        	$model->save();
        	if($model->id_jenis_surat=='p37sks'){
        		$modelSaksiTersangka->update_by=(string)Yii::$app->user->identity->username;
	        	$modelSaksiTersangka->update_date=date('Y-m-d H:i:s');
	        	$modelSaksiTersangka->save();
        	}
        	else if($model->id_jenis_surat=='p37tdw'){
        		$modelSaksiTersangka->update_by=(string)Yii::$app->user->identity->username;
        		$modelSaksiTersangka->update_date=date('Y-m-d H:i:s');
        		$modelSaksiTersangka->save();
        	}
        	
        	//print_r($modelSaksi);
        	if(PdsTutSuratIsi::loadMultiple($modelSuratIsi, Yii::$app->request->post()) ){
        		foreach($modelSuratIsi as $row){
        			$row->update_by=Yii::$app->user->identity->username;
        			$row->update_date=date('Y-m-d H:i:s');
        			$row->save();//print_r($row->getErrors());
        		}
        	}
        	

        	
        	if ($_POST['btnSubmit']=='simpan'){
        		return $this->redirect(['index?id='.$modelTut->id_pds_tut]);
        	}
        	else {
        		$_SESSION['cetak']=1; return $this->refresh();   //return $this->redirect(['../pidsus/default/viewreport', 'id'=>$model->id_pds_tut_surat]);
        	}
        } else {
        	//print_r($modelSaksiTersangka);die();
        	
            return $this->render('update', [
                'model' => $model,
                'modelTut' => $modelTut,
            	'modelSuratIsi' => $modelSuratIsi,
            //	'modelKpPegawai' =>$modelKpPegawai,
				'modelJaksa' =>$modelJaksa,
				//'modelKeterangan' =>$modelKeterangan,
          //  	'modelPermintaanData' => $modelPermintaanData,
           // 	'modelPermintaanData4' => $modelPermintaanData4,
				'modelSuratJaksa'=>$modelSuratJaksa,

            	'modelSaksiTersangka'=>$modelSaksiTersangka,		
            	'titleForm' => "",	
            	'readOnly' => false,
            ]);
        }
    }

    /**
     * Deletes an existing PdsTutSurat model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PdsTutSurat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdsTutSurat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdsTutSuratforP37::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function findModelTut($id)
    {
    	if (($modelTut = PdsTut::findOne($id)) !== null) {
    		return $modelTut;
    	} else {
    		throw new NotFoundHttpException('The requested page does not exist.');
    	}
    }
    
    public function actionDeletebatch()
    {
    	$id_pds = $_POST['hapusPds'];
    
    	for($i=0;$i<count($id_pds);$i++){
    		$pds = PdsTutSuratforP37::findOne($id_pds[$i]);
    		$pds->flag = '3';
    		$pds->save();
    	}
    	return $this->redirect('index');
    }
}
