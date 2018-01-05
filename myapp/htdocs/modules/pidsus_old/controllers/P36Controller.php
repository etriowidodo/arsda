<?php

namespace app\modules\pidsus\controllers;

use Yii;
use app\modules\pidsus\models\PdsTut;
use app\modules\pidsus\models\PdsTutTembusan;
use app\modules\pidsus\models\PdsTutSuratforP36;
use app\modules\pidsus\models\PdsTutSurat;
use app\modules\pidsus\models\PdsTutSuratJaksa;
use app\modules\pidsus\models\PdsTutSuratTersangka;
use app\modules\pidsus\models\PdsTutJaksa;
use app\modules\pidsus\models\PdsTutTersangka;
use app\modules\pidsus\models\PdsTutSuratIsi;
use app\modules\pidsus\models\Pidsus2Search;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pidsus\models\app\modules\pidsus\models;
use yii\data\ArrayDataProvider;

/**
 * P2Controller implements the CRUD actions for PdsLid model.
 */
class P36Controller extends Controller
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
     * Lists all PdsLid models.
     * @return mixed
     
    public function actionIndex()
    {
        $searchModel = new Pidsus2Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	*/
    /**
     * Displays a single PdsLid model.
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
     * Creates a new PdsLid model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PdsTut();
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_pds_tut]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PdsLid model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionIndex()
    {	
    	if(isset($_SESSION['idPdsTut'])){
    		$idPdsTut=$_SESSION['idPdsTut'];
    	}
    	else if (isset($_SESSION['idPdsDik'])){
    		$modelPdsTut=PdsTut::find()->where(['id_pds_dik_parent'=>$_SESSION['idPdsDik']])->one();
    		$idPdsTut=$modelPdsTut->id_pds_tut;
    	}
    	else{
    		return $this->redirect(['../pidsus/default/index']);
    	}
        //$modelLid = $this->findModelLid($idPdsDik);
        $model = $this->findModel($idPdsTut,'p36');
        $_SESSION['idPdsTutSurat'] =$model->id_pds_tut_surat;
		$modelTembusan= PdsTutTembusan::findBySql('select * from pidsus.select_surat_tembusan_tut(\''.$model->id_pds_tut_surat.'\',\''.Yii::$app->user->id.'\')')->orderby('no_urut')->all();
		$modelSuratIsi= PdsTutSuratIsi::findBySql('select * from pidsus.select_surat_isi_tut(\''.$model->id_pds_tut_surat.'\',\''.Yii::$app->user->id.'\')')->all();
        $modelSuratJaksa= PdsTutSuratJaksa::find()->where (['id_pds_tut_surat'=>$model->id_pds_tut_surat, 'flag'=>"1"])->all();
		$modelSuratTersangka = PdsTutSuratTersangka::find()->where(['id_pds_tut_surat'=>$model->id_pds_tut_surat,flag=>"1"])->all();
        if(isset($_SESSION['cetak'])){
            $_SESSION['cetak']=null;
            $link = "<script>window.open(\"../pidsus/tut/viewreporttut?id=$model->id_pds_tut_surat\")</script>";
            echo $link;
        }

        if ($model->load(Yii::$app->request->post()) ) { 

        	
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
        			$modelJaksaSurat->flag="1";
        			$modelJaksaSurat->save();
        		}
        	}
        	
        	if(isset($_POST['id_tersangka'])){
        		$id_tersangka=$_POST['id_tersangka'];
        	}
        	else $id_tersangka=null;
        	
        	if(isset($_POST['hapus_tersangka'])){
        		$hapus_tersangka=$_POST['hapus_tersangka'];
        	}
        	else $hapus_tersangka=null;
        	
        	if ($hapus_tersangka!=null){
        		for($i = 0; $i < count($hapus_tersangka); $i++){
        			PdsTutSuratTersangka::deleteAll(['id_tersangka' => $hapus_tersangka[$i], 'id_pds_tut_surat'=>$model->id_pds_tut_surat]);
        		}
        	}
        	 
        	if ($id_tersangka!=null){
        		for($i = 0; $i < count($id_tersangka); $i++){
        			$modelTersangkaSurat= new PdsTutSuratTersangka();
        			$modelTersangkaSurat->create_by=(string)Yii::$app->user->identity->username;
        			$modelTersangkaSurat->id_pds_tut_surat=$model->id_pds_tut_surat;
        			$modelTersangkaSurat->id_tersangka=$id_tersangka[$i];
        			$modelTersangkaSurat->flag="1";
        			$modelTersangkaSurat->save();
        		}
        	}
        	 
        	 
        	if(PdsTutSuratIsi::loadMultiple($modelSuratIsi, Yii::$app->request->post()) ){
        		foreach($modelSuratIsi as $row){
        			$row->update_by=Yii::$app->user->identity->username;
        			$row->update_date=date('Y-m-d H:i:s');
        			$row->save();        	
        		}
        	}
        	$model->update_by=(string)Yii::$app->user->identity->username;
        	$model->update_date=date('Y-m-d H:i:s');$model->flag='1';
			$model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
        	$model->save();

            if ($_POST['btnSubmit']=='simpan'){
                return $this->redirect(['../pidsus/tut/viewlaporantut','id'=>$idPdsTut]);
            }
            else {
                $_SESSION['cetak']=1; return $this->refresh();   //return $this->redirect(['../pidsus/default/viewreportdik', 'id'=>$model->id_pds_dik_surat]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            	'modelSuratIsi' => $modelSuratIsi,
            	'modelTembusan'	 =>$modelTembusan,
            	'modelSuratJaksa' =>$modelSuratJaksa,
            	'modelSuratTersangka' =>$modelSuratTersangka,	
            	'readOnly' => false,
            ]);
        }
    }

    /**
     * Deletes an existing PdsLid model.
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
     * Finds the PdsLid model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdsLid the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id,$jenisSurat)
    {
        if (($model = PdsTutSuratforP36::find()->where('id_jenis_surat=\''.$jenisSurat.'\' and id_pds_tut=\''.$id.'\'')->one()) !== null) {
            return $model;
        } else {
            $model= new PdsTutSurat();
			$model->id_pds_tut=$id;
			$model->id_jenis_surat=$jenisSurat;
			$model->create_by=(string)Yii::$app->user->identity->username;
			$model->create_ip=(string)$_SERVER['REMOTE_ADDR'];
			$model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
			$model->perihal_lap='Berita Acara Pendapat Bersama';
			$model->save();
			return $this->findModel($id,$jenisSurat);
        }
    }
    protected function findModelTut($id)
    {
    	if (($modelLid = PdsTut::findOne($id)) !== null) {
    		return $modelLid;
    	} else {
    		throw new NotFoundHttpException('The requested page does not exist.');
    	}
    }
    protected function findModelTembusan($id)
    {
    	return $model = PdsTuttembusan::find()->where('id_pds_tut_surat=\''.$id.'\'')->orderBy('no_urut')->all();
    }
    

    public function actionShowJaksa()
    {  // $model->id_satker=$_SESSION['idSatkerUser'];
    	$rawData=Yii::$app->db->createCommand("select * from pidsus.get_jaksa_all_tut('".$_SESSION['idPdsTutSurat']."' ) ")->queryAll();  //idsatker
    	
    	$dataProvider=new ArrayDataProvider([
    			'allModels' =>$rawData, 'key' => 'peg_nik',
    	
    			'pagination'=>[
    					'pageSize'=>10,         //records display
    					],
    			]);
    	return $this->renderAjax('_jpu', [
    			'searchModel' => $searchModel,
    			'dataProvider' => $dataProvider,
    	]);
    }
    public function actionShowTersangka()
    {  // $model->id_satker=$_SESSION['idSatkerUser'];
    $rawData=Yii::$app->db->createCommand("select * from pidsus.get_list_tersangka_tut_ddl('".$_SESSION['idPdsTutSurat']."' ) ")->queryAll();  //idsatker
     
    $dataProvider=new ArrayDataProvider([
    		'allModels' =>$rawData, 'key' => 'id_pds_tut_tersangka',
    		 
    		'pagination'=>[
    				'pageSize'=>10,         //records display
    				],
    ]);
    return $this->renderAjax('_tersangka', [
    		'searchModel' => $searchModel,
    		'dataProvider' => $dataProvider,
    	]);
    }
    
}
