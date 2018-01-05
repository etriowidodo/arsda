<?php

namespace app\modules\pidsus\controllers;

use Yii;
use app\modules\pidsus\models\PdsDik;
use app\modules\pidsus\models\PdsDikTembusan;
use app\modules\pidsus\models\PdsDikSurat;
use app\modules\pidsus\models\PdsDikSuratTersangka;
use app\modules\pidsus\models\PdsDikTersangka;
use app\modules\pidsus\models\PdsDikTersangkaSearch;
use app\modules\pidsus\models\PdsDikSuratSearch;
use app\modules\pidsus\models\PdsDikSuratIsi;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Pidsus18Controller implements the CRUD actions for PdsDikSurat model.
 */
class Pidsus18Controller extends Controller
{
	public $idJenisSurat='pidsus18';
	public $perihalSurat='Surat Penetapan Tersangka';
	public $title='Pidsus 18- Surat Penetapan Tersangka';
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
     * Lists all PdsDikSurat models.
     * @return mixed
     */
    public function actionIndex()
    {	
    
    	if(isset($_SESSION['idPdsDik'])){
    		$idPdsDik=$_SESSION['idPdsDik'];
    	}
    	else if (isset($_SESSION['idPdsLid'])){
    		$modelPdsDik=PdsDik::find()->where(['id_pds_lid_parent'=>$_SESSION['idPdsLid']])->one();
    		$idPdsDik=$modelPdsDik->id_pds_dik;
    	}
    	else{
    		return $this->redirect(['../pidsus/default/index']);
    	}
    		
        $searchModel = new PdsDikSuratSearch();
       $dataProvider = $searchModel->search2(Yii::$app->request->queryParams,$this->idJenisSurat,$idPdsDik);

		//$dataProvider = $searchModel->search2(Yii::$app->request->queryParams, $this->idJenisSurat,$this->$idPdsDik);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        		'titleMain'=>$this->title,
        ]);
    }

    

    /**
     * Creates a new PdsDikSurat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    	$idSurat=$this->getIdSurat();	
        return $this->redirect(['update','id'=>$idSurat]);
    }
	

	public function getIdSurat(){
	    	$model= new PdsDikSurat();
	    	$model->id_pds_dik=$_SESSION['idPdsDik'];
	    	$model->id_jenis_surat=$this->idJenisSurat;	    	
	    	$model->perihal_lap=$this->perihalSurat;	    	
	    	$model->create_by=(string)Yii::$app->user->identity->username;
	    	$model->create_ip=(string)$_SERVER['REMOTE_ADDR'];
	    	$model->save();

		/*	edit nando tersangka dibuat di popup
            //print_r($model->getErrors());
             $id=Yii::$app->db->createCommand("SELECT id_pds_dik_surat FROM pidsus.pds_dik_surat where id_jenis_surat='".$this->idJenisSurat."' and id_pds_dik='".$_SESSION['idPdsDik']."' and create_by='".(string)Yii::$app->user->identity->username."' order by create_date desc limit 1 ")->queryColumn();
            $modelTersangka= new PdsDikTersangka;
            $modelTersangka->id_pds_dik=$_SESSION['idPdsDik'];
            $modelTersangka->create_by=(string)Yii::$app->user->identity->username;
            $modelTersangka->save();

            $modelTersangka=PdsDikTersangka::find()->where(['id_pds_dik'=>$_SESSION['idPdsDik'],'create_by'=>(string)Yii::$app->user->identity->username])->orderBy(['create_date'=>SORT_DESC])->limit(1)->one();
            //print_r($modelTersangka);
            $modelSuratTersangka= new PdsDikSuratTersangka;
            $modelSuratTersangka->id_pds_dik_surat=$id[0];
            $modelSuratTersangka->create_by=(string)Yii::$app->user->identity->username;
            $modelSuratTersangka->id_tersangka=$modelTersangka->id_pds_dik_tersangka;
            $modelSuratTersangka->save();
*/
	    	return $model->id_pds_dik_surat;
	    }
    /**
     * Updates an existing PdsDikSurat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
		if(isset($_SESSION['idPdsDik'])){
			$idPdsDik=$_SESSION['idPdsDik'];
		}
		else if (isset($_SESSION['idPdsLid'])){
			$modelPdsDik=PdsDik::find()->where(['id_pds_lid_parent'=>$_SESSION['idPdsLid']])->one();
			$idPdsDik=$modelPdsDik->id_pds_dik;
		}
		else{
			return $this->redirect(['../pidsus/default/index']);
		}
		$_SESSION['idPdsDikSurat']=$id;

    	$model = $this->findModel($id);
		$modelTembusan= PdsDikTembusan::findBySql('select * from pidsus.select_surat_tembusan_dik(\''.$model->id_pds_dik_surat.'\',\''.Yii::$app->user->id.'\')')->orderby('no_urut')->all();
		$modelSuratIsi= PdsDikSuratIsi::findBySql('select * from pidsus.select_surat_isi_dik(\''.$model->id_pds_dik_surat.'\',\''.Yii::$app->user->id.'\')')->all();
		$modelTersangkaUpdate=PdsDikTersangka::findBySql('select * from pidsus.pds_dik_tersangka where id_pds_dik_tersangka in (select id_tersangka from pidsus.pds_dik_surat_tersangka where id_pds_dik_surat =\''.$model->id_pds_dik_surat.'\') and flag=\'1\'')->orderby('update_date')->all();
		$modelSuratTersangka=PdsDikSuratTersangka::find()->where(['id_pds_dik_surat'=>$id,'flag'=>'1'])->all();
		//$modelSuratTersangkaUpdate =
		if(isset($_SESSION['cetak'])){
			$_SESSION['cetak']=null;
			$link = "<script>window.open(\"../../pidsus/default/viewreportdik?id=$model->id_pds_dik_surat\")</script>";
			echo $link;
		}
       if ($model->load(Yii::$app->request->post()) ) { 
        	
        	if(PdsDikTembusan::loadMultiple($modelTembusan, Yii::$app->request->post()) && PdsDiktembusan::validateMultiple($modelTembusan)){
        		$noUrutTembusan=1;foreach($modelTembusan as $row){$row->no_urut=$noUrutTembusan;$noUrutTembusan++;
        			$row->update_by=Yii::$app->user->identity->username;
        			$row->update_date=date('Y-m-d H:i:s');
        			$row->save();        	
        		}
        	}
        	if(isset($_POST['new_tembusan'])){
        		for($i = 0; $i < count($_POST['new_tembusan']); $i++){
	        		$modelNewTembusan= new PdsDiktembusan();
	        		$modelNewTembusan->id_pds_dik_surat=$model->id_pds_dik_surat;
	        		$modelNewTembusan->no_urut=$noUrutTembusan;$noUrutTembusan++;
	        		$modelNewTembusan->tembusan=$_POST['new_tembusan'][$i];
					$modelNewTembusan->create_by=(string)Yii::$app->user->identity->username;
					$modelNewTembusan->save();
        		}
        	}
        	if(PdsDikSuratIsi::loadMultiple($modelSuratIsi, Yii::$app->request->post()) ){
        		foreach($modelSuratIsi as $row){
        			$row->update_by=Yii::$app->user->identity->username;
        			$row->update_date=date('Y-m-d H:i:s');
        			$row->save();        	
        		}
        	}
        	if(isset($_POST['hapus_tembusan'])){
        		for($i=0; $i<count($_POST['hapus_tembusan']);$i++){
        			PdsDiktembusan::deleteAll(['id_pds_dik_tembusan' => $_POST['hapus_tembusan'][$i]]);
        		}
        	}
        	/*if(isset($_POST['id_tersangka_remove'])){
        		for($i=0; $i<count($_POST['id_tersangka_remove']);$i++){
        			PdsDikSuratTersangka::deleteAll(['id_tersangka' => $_POST['id_tersangka_remove'][$i],'id_pds_dik_surat'=>$model->id_pds_dik_surat]);
        			//PdsDikTersangka::deleteAll(['id_pds_dik_tersangka'=> $_POST['id_tersangka_remove'][$i]]);
        		}
        	}
        	if(isset($_POST['id_pds_dik_tersangka'])){
	        	for($i=0; $i<count($_POST['id_pds_dik_tersangka']); $i++){
	        		/*$modelTersangka1 = new PdsDikTersangka();
	        			
	        		$modelTersangka1->id_pds_dik = $model->id_pds_dik;
	        		$modelTersangka1->tempat_lahir = $modelTersangkaList->tempat_lahir[$i];
	        		$modelTersangka1->tgl_lahir = $modelTersangkaList->tgl_lahir[$i];
	        		$modelTersangka1->alamat = $modelTersangkaList->alamat[$i];
	        		$modelTersangka1->nomor_id = $modelTersangkaList->nomor_id[$i];
	        		$modelTersangka1->kewarganegaraan = $modelTersangkaList->kewarganegaraan[$i];
	        		$modelTersangka1->pekerjaan = $modelTersangkaList->pekerjaan[$i];
	        		$modelTersangka1->suku = $modelTersangkaList->suku[$i];
	        		$modelTersangka1->nama_tersangka = $modelTersangkaList->nama_tersangka[$i];
	        		$modelTersangka1->jenis_kelamin = $modelTersangkaList->jenis_kelamin[$i];
	        		$modelTersangka1->jenis_id = $modelTersangkaList->jenis_id[$i];
	        		$modelTersangka1->agama = $modelTersangkaList->agama[$i];
	        		$modelTersangka1->pendidikan = $modelTersangkaList->pendidikan[$i];
		        	$modelTersangka1->create_by=(string)Yii::$app->user->identity->username;
		        	$modelTersangka1->create_date=date('Y-m-d H:i:s');
		        	//print_r($modelTersangka1);
	        		$modelTersangka1->save();
	        		$modelSuratTersangka1 = new PdsDikSuratTersangka();
	        		$modelSuratTersangka1->id_pds_dik_surat=$model->id_pds_dik_surat;
	        		$modelSuratTersangka1->id_tersangka = $_POST['id_pds_dik_tersangka'][$i];
	        		$modelSuratTersangka1->create_by=(string)Yii::$app->user->identity->username;
	        		$modelSuratTersangka1->create_date=date('Y-m-d H:i:s');
	        		$modelSuratTersangka1->save();
	        	}
        	}*/
        	//print_r($modelTersangkaList);
        	//print_r(Yii::$app->request->post('PdsDikTersangka'));
        	//print_r($model);
        	$model->update_by=(string)Yii::$app->user->identity->username;
        	$model->update_date=date('Y-m-d H:i:s');$model->flag='1';
			$model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
        	$model->save();
			if ($_POST['btnSubmit']=='simpan'){
        		//return $this->redirect(['../pidsus/default/viewlaporandik','id'=>$idPdsDik]);
				return $this->redirect(['../pidsus/pidsus18']);
        	}
        	else {
        		$_SESSION['cetak']=1; return $this->refresh();   //return $this->redirect(['../pidsus/default/viewreportdik', 'id'=>$model->id_pds_dik_surat]);
        	}
        	

        	
        	//return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            	'modelSuratIsi' => $modelSuratIsi,
            	'modelTembusan'	 =>$modelTembusan,
    			'modelTersangkaUpdate'=>$modelTersangkaUpdate,
            	'readOnly' => false,
            	'titleMain'=>$this->title,	
            ]);
        }
    }

    /**
     * Deletes an existing PdsDikSurat model.
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
     * Finds the PdsDikSurat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdsDikSurat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */


	public function actionShowTersangka()
	{
		$modelTersangka = new PdsDikTersangka();
		
		if ($modelTersangka->load(Yii::$app->request->post()) ) {
			$modelTersangka->id_pds_dik = $idPdsDik=$_SESSION['idPdsDik'];
			$modelTersangka->create_by=(string)Yii::$app->user->identity->username;
		    $modelTersangka->create_date=date('Y-m-d H:i:s');
		        	
			$modelTersangka->save();
			$modelSuratTersangka1 = new PdsDikSuratTersangka();
			$modelSuratTersangka1->id_pds_dik_surat=$_SESSION['idPdsDikSurat'];
			$modelSuratTersangka1->id_tersangka = $modelTersangka->id_pds_dik_tersangka;
			$modelSuratTersangka1->create_by=(string)Yii::$app->user->identity->username;
			$modelSuratTersangka1->create_date=date('Y-m-d H:i:s');
			$modelSuratTersangka1->save();
			$data['id_pds_dik_tersangka'] = $modelTersangka->id_pds_dik_tersangka;
			echo json_encode($data);
			//print_r($model->getErrors());
		}
		else {
			return $this->renderAjax('_popTersangka', [
					'modelTersangka' => $modelTersangka
			]);
		}
		/*$searchModel = new PdsDikTersangkaSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams,$_SESSION['idPdsDik']);
		$dataProvider->pagination->pageSize=10;
		return $this->renderAjax('_listtersangkadik', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
		]);*/
	}
	public function actionEditTersangka($id)
	{
		$modelTersangka = PdsDikTersangka::find()->where(['id_pds_dik_tersangka'=>$id])->one();
	
		if ($modelTersangka->load(Yii::$app->request->post()) ) {
			$modelTersangka->id_pds_dik = $idPdsDik=$_SESSION['idPdsDik'];
			$modelTersangka->create_by=(string)Yii::$app->user->identity->username;
			$modelTersangka->create_date=date('Y-m-d H:i:s');
			 
			$modelTersangka->save();
			//echo json_encode($modelTersangka->id_pds_dik_tersangka);
			//print_r($model->getErrors());
		}
		else {
			return $this->renderAjax('_popTersangkaEdit', [
					'modelTersangka' => $modelTersangka
			]);
		}
		/*$searchModel = new PdsDikTersangkaSearch();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams,$_SESSION['idPdsDik']);
			$dataProvider->pagination->pageSize=10;
			return $this->renderAjax('_listtersangkadik', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			]);*/
	}
	
	public function actionDeleteTersangka($id){
		$modelTersangka = PdsDikTersangka::find()->where(['id_pds_dik_tersangka'=>$id])->one();
		$modelTersangka->flag='3';
		$modelTersangka->update_by=(string)Yii::$app->user->identity->username;
		$modelTersangka->update_date=date('Y-m-d H:i:s');		
		$modelTersangka->save();
		$modelSuratTersangka=PdsDikSuratTersangka::find()->where(['id_tersangka'=>$id])->one();
		$modelSuratTersangka->flag='3';
		$modelSuratTersangka->update_by=(string)Yii::$app->user->identity->username;
		$modelSuratTersangka->update_date=date('Y-m-d H:i:s');
		$modelSuratTersangka->save();
		
		//print_r($modelTersangka->getErrors());
	}
	
    protected function findModel($id)
    {
        if (($model = PdsDikSurat::find()->where(['id_pds_dik_surat'=>$id, 'id_jenis_surat'=>$this->idJenisSurat])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
