<?php

namespace app\modules\pidsus\controllers;

use Yii;
use app\modules\pidsus\models\PdsDik;

use app\modules\pidsus\models\PdsDikSuratforP11;
use app\modules\pidsus\models\PdsDikSurat;
use app\modules\pidsus\models\PdsDikSuratIsi;

use app\modules\pidsus\models\PdsDikSuratSearch;

use app\modules\pidsus\models\PdsDikSuratPanggilan;


use app\modules\pidsus\models\Status;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * P2Controller implements the CRUD actions for PdsDik model.
 */
class P11Controller extends Controller
{
	
	public $idJenisSurat='p11';
	public $perihalSurat='Bantuan Pemanggilan';
	public $title='P11 - Bantuan Pemanggilan Saksi/Ahli';
	
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
     * Lists all PdsDik models.
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
    	$dataProviderAhli = $searchModel->search3(Yii::$app->request->queryParams, $this->idJenisSurat,$idPdsDik,435);
    	$dataProviderSaksi = $searchModel->search3(Yii::$app->request->queryParams, $this->idJenisSurat,$idPdsDik,434);
    
    	return $this->render('index', [
    			'searchModel' => $searchModel,
    			'idJenisSurat' => $this->idJenisSurat,
    			'dataProviderAhli' => $dataProviderAhli,
    			'dataProviderSaksi'=> $dataProviderSaksi,
    			'titleMain'=>$this->title,
    	]);
    }
    
    public function actionCreate($idStatus)
    {
    	$model= new PdsDikSurat();
    	$model->id_pds_dik=$_SESSION['idPdsDik'];
    	$model->id_jenis_surat=$this->idJenisSurat;
    	$model->id_status=$idStatus;
    	$model->create_by=(string)Yii::$app->user->identity->username;
    	$model->create_ip=(string)$_SERVER['REMOTE_ADDR'];
    	$model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
    	if($idStatus==434)
    		$model->perihal_lap='Bantuan Pemanggilan Saksi';
    	elseif($idStatus==435)
    	$model->perihal_lap='Bantuan Pemanggilan Ahli';
    	$model->save();
    	//print_r($model->getErrors());die();
    	return $this->redirect(['update','id'=>$model->id_pds_dik_surat]);
    }
    
    public function actionUpdate($id)
    {	
    	$searchModel = new PdsDikSuratSearch();
        $idJenisSurat=$this->idJenisSurat;
        $modelDik = $this->findModelDik($_SESSION['idPdsDik']);
        //$modelStatus=Status::findOne($modelDik->id_status);
       // $model = $this->findModel($id,$modelDik,$idJenisSurat);
       if($model->id_pds_dik_surat==null){
		   $model = $this->findModel($_SESSION['idPdsDik'],$modelDik,$idJenisSurat);
	   }
        $model = $this->findModel($id);
        //$modelJaksa=Yii::$app->db->createCommand("select peg_nik,peg_nama from pidsus.pds_Dik_jaksa plj left join kepegawaian.kp_pegawai kp on kp.peg_nik=plj.id_jaksa")->queryAll();

        $modelSuratPanggilan=PdsDikSuratPanggilan::find()->where(['id_pds_dik_surat'=>$model->id_pds_dik_surat])->all();
       	$modelSuratIsi= PdsDikSuratIsi::findBySql('select * from pidsus.select_surat_isi_dik(\''.$model->id_pds_dik_surat.'\',\''.Yii::$app->user->id.'\') ')->all();
		//$modelKpPegawai= KpPegawai::findBySql('select * from kepegawaian.kp_pegawai')->all();
		if(isset($_SESSION['cetak'])){
			$_SESSION['cetak']=null;
			$link = "<script>window.open(\"../default/viewreportdik?id=$model->id_pds_dik_surat\")</script>";
			echo $link;
		}
		if ($model->load(Yii::$app->request->post())) {
			$model->update_by=Yii::$app->user->identity->username;
			$model->update_date=date('Y-m-d H:i:s');$model->flag='1';
			$model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
			$model->save();
			
			if(PdsDikSuratIsi::loadMultiple($modelSuratIsi, Yii::$app->request->post()) ){
				foreach($modelSuratIsi as $row){
					$row->update_by=Yii::$app->user->identity->username;
					$row->update_date=date('Y-m-d H:i:s');
					$row->save();
					$row->save();

					//print_r($row->getErrors());
				}
			}

			if(PdsDikSuratPanggilan::loadMultiple($modelSuratPanggilan, Yii::$app->request->post()) && PdsDikSuratPanggilan::validateMultiple($modelSuratPanggilan)){
				foreach($modelSuratPanggilan as $row){
					$row->update_by=Yii::$app->user->identity->username;
					$row->update_date=date('Y-m-d H:i:s');
					$row->save();
				}
			}
			
			if(isset($_POST['nama_lengkap_sp_insert'])){
				$nama_lengkapSP=$_POST['nama_lengkap_sp_insert'];
				$alamatSP=$_POST['alamat_sp_insert'];
				$keteranganSP=$_POST['keterangan_sp_insert'];
				}
			else {
				$nama_lengkapSP=null;
				$alamatSP=null;
				$keteranganSP=null;

			}
			if($nama_lengkapSP!=null){
				for($i = 0; $i < count($nama_lengkapSP); $i++){
					$modelPd= new PdsDikSuratPanggilan();
					$modelPd->id_pds_dik_surat=$model->id_pds_dik_surat;
					$modelPd->nama_lengkap=$nama_lengkapSP[$i];
					$modelPd->alamat=$alamatSP[$i];
					$modelPd->keterangan=$keteranganSP[$i];
					$modelPd->create_by=(string)Yii::$app->user->identity->username;
		        	$modelPd->update_by=Yii::$app->user->identity->username;
		        	$modelPd->update_date=date('Y-m-d H:i:s');
					$modelPd->save();
					//print_r($modelPd->getErrors());
					//echo '</br>';
				}
			}
			if(isset($_POST['hapus_sp'])){
				$hapus_sp=$_POST['hapus_sp'];
			}
			else $hapus_sp=null;

			if ($hapus_sp!=null){
				for($i = 0; $i < count($hapus_sp); $i++){
					PdsDikSuratPanggilan::deleteAll(['id_pds_dik_surat_panggilan' => $hapus_sp[$i]]);
				}
			}
			
			
			
			//$this->generatePidsus5($model);	
		if ($_POST['btnSubmit']=='simpan'){
        		return $this->redirect(['index']);
        	}
        	else {
        	//	echo CHtml::link('Link Text','http://google.com', array('target'=>'_blank'));
        		$_SESSION['cetak']=1; return $this->refresh();   //return $this->redirect(['../pidsus/default/viewreport', 'id'=>$model->id_pds_dik_surat]);
        	}
		}

		else {
			return $this->render('update', [
                'model' => $model,
                'modelDik' => $modelDik,
            	'modelSuratIsi' => $modelSuratIsi,
            	//'modelTembusan' => $modelTembusan,
				//'modelKpPegawai' =>$modelKpPegawai,
				'modelSuratPanggilan'=>$modelSuratPanggilan,
				//'modelJaksa' =>$modelJaksa,
            	'titleForm' => "",
            	'readOnly' => false,
            ]);
		}
		
    }


    /**
     * Deletes an existing PdsDik model.
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
     * Finds the PdsDik model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdsDik the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdsDikSuratforP11::find()->where(['id_pds_dik_surat'=>$id])->one()) !== null) {

			return $model;
        } else {
        	return $this->redirect(['index']);
        }
    }
    protected function findModelDik($id)
    {
    	if (($modelDik = PdsDik::findOne($id)) !== null) {
    		return $modelDik;
    	} else {
    		throw new NotFoundHttpException('The requested page does not exist.');
    	}
    }
    protected function findModelTembusan($id)
    {
    	return $model = PdsDikTembusan::find()->where('id_pds_dik_surat=\''.$id.'\'')->orderBy('no_urut')->all();
    }
    
}
