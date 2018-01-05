<?php

namespace app\modules\pidsus\controllers;

use Yii;
use app\modules\pidsus\models\PdsDik;
use app\modules\pidsus\models\PdsDikTembusan;
use app\modules\pidsus\models\PdsDikSuratforPidsus14;
use app\modules\pidsus\models\PdsDikSurat;
use app\modules\pidsus\models\PdsDikSuratSearch;
use app\modules\pidsus\models\PdsDikUsulanPermintaanData;
use app\modules\pidsus\models\PdsDikSuratIsi;
use app\modules\pidsus\models\Pidsus2Search;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * P2Controller implements the CRUD actions for PdsLid model.
 */
class Pidsus14Controller extends Controller
{
	public $idJenisSurat='pidsus14';
	public $perihalSurat='Usul untuk pemanggilan ';
	public $title='Pidsus14 - Usul untuk pemanggilan Saksi/Ahli/Tersangka';
	
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
    	$dataProviderAhli = $searchModel->search3(Yii::$app->request->queryParams, $this->idJenisSurat,$idPdsDik,433);
    	$dataProviderTersangka = $searchModel->search3(Yii::$app->request->queryParams, $this->idJenisSurat,$idPdsDik,431);
    	$dataProviderSaksi = $searchModel->search3(Yii::$app->request->queryParams, $this->idJenisSurat,$idPdsDik,432);
    
    	return $this->render('index', [
    			'searchModel' => $searchModel,
    			'idJenisSurat' => $this->idJenisSurat,
    			'dataProviderAhli' => $dataProviderAhli,
    			'dataProviderTersangka'=> $dataProviderTersangka,
    			'dataProviderSaksi'=> $dataProviderSaksi,
    			'titleMain'=>$this->title,
    	]);
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
    public function actionCreate($idStatus)
    {
       		$model= new PdsDikSurat();
			$model->id_pds_dik=$_SESSION['idPdsDik'];
			$model->id_jenis_surat=$this->idJenisSurat;
			$model->id_status=$idStatus;
			$model->create_by=(string)Yii::$app->user->identity->username;
			$model->create_ip=(string)$_SERVER['REMOTE_ADDR'];
			$model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
			if($idStatus==432)
			$model->perihal_lap='Usul untuk pemanggilan Saksi';
			elseif($idStatus==433)
			$model->perihal_lap='Usul untuk pemanggilan Ahli';
			elseif($idStatus==431)
			$model->perihal_lap='Usul untuk pemanggilan Tersangka';
			$model->save();
			//print_r($model->getErrors());die();
			return $this->redirect(['update','id'=>$model->id_pds_dik_surat]);
    }

    /**
     * Updates an existing PdsLid model.
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
        //$modelLid = $this->findModelLid($idPdsDik);
        $model = $this->findModel($id);
		$modelTembusan= PdsDikTembusan::findBySql('select * from pidsus.select_surat_tembusan_dik(\''.$model->id_pds_dik_surat.'\',\''.Yii::$app->user->id.'\')')->orderby('no_urut')->all();
		$modelSuratIsi= PdsDikSuratIsi::findBySql('select * from pidsus.select_surat_isi_dik(\''.$model->id_pds_dik_surat.'\',\''.Yii::$app->user->id.'\')')->all();
		$modelPermintaanData=PdsDikUsulanPermintaanData::find()->where(['id_pds_dik_surat'=>$model->id_pds_dik_surat])->all();
		//$modelJaksa=Yii::$app->db->createCommand("select peg_nik,peg_nama from kepegawaian.kp_pegawai limit 100")->queryAll();
		$modelJaksa=Yii::$app->db->createCommand("select peg_nik,peg_nama,id_nip_jaksa from pidsus.get_jaksa_p8dik('".$model->id_pds_dik_surat."')")->queryAll();
		if(isset($_SESSION['cetak'])){
			$_SESSION['cetak']=null;
			$link = "<script>window.open(\"../default/viewreportdik?id=$model->id_pds_dik_surat\")</script>";
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
        	
        	if(PdsDikUsulanPermintaanData::loadMultiple($modelPermintaanData, Yii::$app->request->post()) && PdsDikUsulanPermintaanData::validateMultiple($modelPermintaanData)){
        		foreach($modelPermintaanData as $row){
        			$row->update_by=Yii::$app->user->identity->username;
        			$row->update_date=date('Y-m-d H:i:s');
        			$row->save();
        		}
        	}
        		
        	if(isset($_POST['nama_pd_insert'])){
        		$namaPd=$_POST['nama_pd_insert'];
        		$jabatanPd=$_POST['jabatan_pd_insert'];
        		$waktuPd=$_POST['waktu_pd_insert'];
        		$jaksaPd=$_POST['jaksa_pd_insert'];
        		$keperluanPd=$_POST['keperluan_pd_insert'];
        	}
        	else {
        		$namaPd=null;
        		$waktuPd=null;
        		$jaksaPd=null;
        		$keperluanPd=null;
        	}
        	if($namaPd!=null){
        		for($i = 0; $i < count($namaPd); $i++){
        			$modelPd= new PdsDikUsulanPermintaanData();
        			if($model->id_status==433)
        				$modelPd->is_ahli=1;
        			elseif($model->id_status==432)
        				$modelPd->is_ahli=2;
        			$modelPd->id_pds_dik_surat=$model->id_pds_dik_surat;
        			$modelPd->nama=$namaPd[$i];
        			$modelPd->jabatan_nama=$jabatanPd[$i];
        			$modelPd->jaksa_pelaksanaan=$jaksaPd[$i];
        			$modelPd->waktu_pelaksanaan=$waktuPd[$i];
        			$modelPd->keperluan=$keperluanPd[$i];
        			$modelPd->create_by=(string)Yii::$app->user->identity->username;
        			$modelPd->update_by=Yii::$app->user->identity->username;
        			$modelPd->update_date=date('Y-m-d H:i:s');
        			$modelPd->save();
        			//print_r($modelPd->getErrors());
        			//echo '</br>';
        		}
        	}
        	if(isset($_POST['hapus_pd'])){
        		$hapus_pd=$_POST['hapus_pd'];
        	}
        	else $hapus_pd=null;
        	
        	if ($hapus_pd!=null){
        		for($i = 0; $i < count($hapus_pd); $i++){
        			pdsDikUsulanPermintaanData::deleteAll(['id_pds_dik_usulan_permintaan_data' => $hapus_pd[$i]]);
        		}
        	}
        	$model->update_by=(string)Yii::$app->user->identity->username;
        	$model->update_date=date('Y-m-d H:i:s');$model->flag='1';
			$model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
        	$model->save();
        	//print_r($model->getErrors());die();
        	if ($_POST['btnSubmit']=='simpan'){
        		return $this->redirect(['index']);
        	}
        	else {
        		$_SESSION['cetak']=1; return $this->refresh();   //return $this->redirect(['../pidsus/default/viewreportdik', 'id'=>$model->id_pds_dik_surat]);
        	}

        } else {
            return $this->render('update', [
                'model' => $model,
            	'modelSuratIsi' => $modelSuratIsi,
            	'modelTembusan'	 =>$modelTembusan,
            	'modelJaksa'	 =>$modelJaksa,
            	'modelPermintaanData' =>$modelPermintaanData,	
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
    protected function findModel($id)
    {
        if (($model = PdsDikSuratforPidsus14::find()->where(['id_pds_dik_surat'=>$id])->one()) !== null) {
            return $model;
        } else {
            
			return $this->findModel($id,$jenisSurat);
        }
    }
    protected function findModelDik($id)
    {
    	if (($modelLid = PdsDik::findOne($id)) !== null) {
    		return $modelLid;
    	} else {
    		throw new NotFoundHttpException('The requested page does not exist.');
    	}
    }
    protected function findModelTembusan($id)
    {
    	return $model = PdsDiktembusan::find()->where('id_pds_dik_surat=\''.$id.'\'')->orderBy('no_urut')->all();
    }
}
