<?php

namespace app\modules\pidsus\controllers;

use Yii;
use app\modules\pidsus\models\PdsDik;
use app\modules\pidsus\models\PdsDikTembusan;
use app\modules\pidsus\models\PdsDikSuratforPidsus16;
use app\modules\pidsus\models\PdsDikSurat;
use app\modules\pidsus\models\PdsDikSuratTargetPemanggilan;
use app\modules\pidsus\models\PdsDikSuratPenyitaan;
//use app\modules\pidsus\models\PdsDikSuratTersangka;
//use app\modules\pidsus\models\PdsDikTersangka;
use app\modules\pidsus\models\PdsDikSuratSearch;
use app\modules\pidsus\models\PdsDikSuratIsi;
use app\modules\pidsus\models\Pidsus2Search;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Pidsus18Controller implements the CRUD actions for PdsDikSurat model.
 */
class Pidsus16Controller extends Controller
{
	public $idJenisSurat='pidsus16';
	public $perihalSurat='Usul Tindakan Penggeledahan/Penyitaan';
	public $title='Pidsus 16 - Usul Tindakan Penggeledahan/Penyitaan';
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
$_SESSION['startDatePidsus16']=new \DateTime($this->getStartDate('p6'));
    	$_SESSION['startDatePidsus16']=$_SESSION['startDatePidsus16']->format('d m Y');
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
		$dataProvider = $searchModel->search2(Yii::$app->request->queryParams, $this->idJenisSurat,$idPdsDik);

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

public function getStartDate($jenisSurat){
    	$modelP2=PdsDikSurat::find()->where('id_jenis_surat=\''.$jenisSurat.'\' and id_pds_dik=\''.$_SESSION['idPdsDik'].'\'')->one();
    	return $modelP2->tgl_surat;
    }
	public function getIdSurat(){
		$model= new PdsDikSurat();
		$model->id_pds_dik=$_SESSION['idPdsDik'];
		$model->id_jenis_surat=$this->idJenisSurat;
		$model->perihal_lap=$this->perihalSurat;
		$model->create_by=(string)Yii::$app->user->identity->username;
		$model->create_ip=(string)$_SERVER['REMOTE_ADDR'];
		$model->save();

		//print_r($model->getErrors());
		$id=Yii::$app->db->createCommand("SELECT id_pds_dik_surat FROM pidsus.pds_dik_surat where id_jenis_surat='".$this->idJenisSurat."' and id_pds_dik='".$_SESSION['idPdsDik']."' and create_by='".(string)Yii::$app->user->identity->username."' order by create_date desc limit 1 ")->queryColumn();
	/*	$modelTersangka= new PdsDikTersangka;
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
		return $id[0];
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
		$modelPemanggilan=PdsDikSuratTargetPemanggilan::find()->where(['id_pds_dik_surat'=>$model->id_pds_dik_surat,'flag'=>'1'])->orderBy('no_urut')->all();
		$modelPenyitaan=PdsDikSuratPenyitaan::find()->where(['id_pds_dik_surat'=>$model->id_pds_dik_surat,'flag'=>'1'])->orderBy('no_urut')->all();
		
	//	$modelSuratTersangka=PdsDikSuratTersangka::find()->where(['id_pds_dik_surat'=>$id])->one();
	//	$modelTersangka=PdsDikTersangka::find()->where(['id_pds_dik_tersangka'=>$modelSuratTersangka->id_tersangka])->one();
		if(isset($_SESSION['cetak'])){
			$_SESSION['cetak']=null;
			$link = "<script>window.open(\"../default/viewreportdik?id=$model->id_pds_dik_surat\")</script>";
			echo $link;
		}

		if ($model->load(Yii::$app->request->post())) {
//if ($model->load(Yii::$app->request->post()) && $modelTersangka->load(Yii::$app->request->post())) {

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
			$model->update_by=(string)Yii::$app->user->identity->username;
			$model->update_date=date('Y-m-d H:i:s');$model->flag='1';

			$model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
			$model->save();
			if ($_POST['btnSubmit']=='simpan'){
				//return $this->redirect(['../pidsus/default/viewlaporandik','id'=>$idPdsDik]);
				return $this->redirect(['../pidsus/pidsus16']);
			}
			else {
				$_SESSION['cetak']=1; return $this->refresh();   //return $this->redirect(['../pidsus/default/viewreportdik', 'id'=>$model->id_pds_dik_surat]);
			}


		//	$modelTersangka->update_by=(string)Yii::$app->user->identity->username;
		//	$modelTersangka->update_date=date('Y-m-d H:i:s');
		//	$modelTersangka->save();
			return $this->redirect(['index']);
		} else {
			return $this->render('update', [
				'model' => $model,
				'modelSuratIsi' => $modelSuratIsi,
				'modelTembusan'	 =>$modelTembusan,
				'modelPemanggilan'	 =>$modelPemanggilan,
				'modelPenyitaan'	 =>$modelPenyitaan,
			//	'modelTersangka'=>$modelTersangka,
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
	protected function findModel($id)
	{
		if (($model = PdsDikSuratforPidsus16::find()->where(['id_pds_dik_surat'=>$id, 'id_jenis_surat'=>$this->idJenisSurat])->one()) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
	
	public function actionShowtargetpemanggilan()
	{
		$modelPemanggilan = new PdsDikSuratTargetPemanggilan();
	
		$modelPemanggilan->id_pds_dik_surat_target_pemanggilan = $idPdsDik=$_SESSION['id_pds_dik_surat_target_pemanggilan'];
			
		if ($modelPemanggilan->load(Yii::$app->request->post()) ) {
			$modelPemanggilan->id_pds_dik_surat = $idPdsDik=$_SESSION['idPdsDikSurat'];
			$modelPemanggilan->create_by=(string)Yii::$app->user->identity->username;
			$modelPemanggilan->create_date=date('Y-m-d H:i:s');
			$modelPemanggilan->flag='1';
			$modelPemanggilan->save();
			$data['id_pds_dik_surat_target_pemanggilan'] = $modelPemanggilan->id_pds_dik_surat_target_pemanggilan;
			echo json_encode($data);
			//print_r($model->getErrors());
		}
		else {
			return $this->renderAjax('_popTargetPemanggilan', [
					'modelPemanggilan' => $modelPemanggilan
			]);
		}
	
	}
	public function actionEdittargetpemanggilan($id)
	{
		$modelPemanggilan = PdsDikSuratTargetPemanggilan::find()->where(['id_pds_dik_surat_target_pemanggilan'=>$id])->one();
	
		if ($modelPemanggilan->load(Yii::$app->request->post()) ) {
			$modelPemanggilan->id_pds_dik_surat = $idPdsDik=$_SESSION['idPdsDikSurat'];
			$modelPemanggilan->create_by=(string)Yii::$app->user->identity->username;
			$modelPemanggilan->create_date=date('Y-m-d H:i:s');
	
			$modelPemanggilan->save();
			//echo json_encode($modelPemanggilan->id_pds_dik_tersangka);
			//print_r($model->getErrors());
		}
		else {
			return $this->renderAjax('_popTargetPemanggilanEdit', [
					'modelPemanggilan' => $modelPemanggilan
			]);
		}
	
	}
	
	public function actionDeletetargetpemanggilan($id){
		$modelPemanggilan = PdsDikSuratTargetPemanggilan::find()->where(['id_pds_dik_surat_target_pemanggilan'=>$id])->one();
		$modelPemanggilan->flag='3';
		$modelPemanggilan->update_by=(string)Yii::$app->user->identity->username;
		$modelPemanggilan->update_date=date('Y-m-d H:i:s');
		$modelPemanggilan->save();
			
		//print_r($modelPemanggilan->getErrors());
	}
	
	public function actionShowpenyitaan()
	{
		$modelPenyitaan = new PdsDikSuratPenyitaan();
	
		$modelPenyitaan->id_pds_dik_surat_penyitaan = $idPdsDik=$_SESSION['id_pds_dik_surat_penyitaan'];
			
		if ($modelPenyitaan->load(Yii::$app->request->post()) ) {
			$modelPenyitaan->id_pds_dik_surat = $_SESSION['idPdsDikSurat'];
			$modelPenyitaan->create_by=(string)Yii::$app->user->identity->username;
			$modelPenyitaan->create_date=date('Y-m-d H:i:s');
			$modelPenyitaan->flag='1';
			$modelPenyitaan->save();
			$data['id_pds_dik_surat_penyitaan'] = $modelPenyitaan->id_pds_dik_surat_penyitaan;
			echo json_encode($data);
			//print_r($modelPenyitaan->getErrors());
		}
		else {
			return $this->renderAjax('_popPenyitaan', [
					'modelPenyitaan' => $modelPenyitaan
			]);
		}
	
	}
	public function actionEditpenyitaan($id)
	{
		$modelPenyitaan = PdsDikSuratPenyitaan::find()->where(['id_pds_dik_surat_penyitaan'=>$id])->one();
	
		if ($modelPenyitaan->load(Yii::$app->request->post()) ) {
			$modelPenyitaan->id_pds_dik_surat = $idPdsDik=$_SESSION['idPdsDikSurat'];
			$modelPenyitaan->create_by=(string)Yii::$app->user->identity->username;
			$modelPenyitaan->create_date=date('Y-m-d H:i:s');
	
			$modelPenyitaan->save();
			//echo json_encode($modelPenyitaan->id_pds_dik_tersangka);
			//print_r($model->getErrors());
		}
		else {
			return $this->renderAjax('_popPenyitaanEdit', [
					'modelPenyitaan' => $modelPenyitaan
			]);
		}
	
	}
	
	public function actionDeletepenyitaan($id){
		$modelPenyitaan = PdsDikSuratPenyitaan::find()->where(['id_pds_dik_surat_penyitaan'=>$id])->one();
		$modelPenyitaan->flag='3';
		$modelPenyitaan->update_by=(string)Yii::$app->user->identity->username;
		$modelPenyitaan->update_date=date('Y-m-d H:i:s');
		$modelPenyitaan->save();
			
		//print_r($modelPenyitaan->getErrors());
	}
}
