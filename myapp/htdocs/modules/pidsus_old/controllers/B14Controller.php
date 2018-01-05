<?php

namespace app\modules\pidsus\controllers;

use Yii;
use app\modules\pidsus\models\PdsDik;
use app\modules\pidsus\models\PdsDikTembusan;
use app\modules\pidsus\models\PdsDikSuratforB14;
use app\modules\pidsus\models\PdsDikSurat;
use app\modules\pidsus\models\PdsDikSuratDetail;
use app\modules\pidsus\models\PdsDikSuratJaksa;
use app\modules\pidsus\models\PdsDikSuratIsi;
use app\modules\pidsus\models\PdsDikSuratTersangka;
use app\modules\pidsus\models\PdsDikTersangka;
use app\modules\pidsus\models\PdsDikSuratSearch;
use app\modules\pidsus\models\Pidsus2Search;
use app\modules\pidsus\models\KpPegawai;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * P2Controller implements the CRUD actions for PdsLid model.
 */
class B14Controller extends Controller
{
	public $idJenisSurat='b14';
	public $perihalSurat='Surat Perintah Lelang Sitaan/Barang Bukti';
	public $title='B14 - Surat Perintah Lelang Sitaan/Barang Bukti';



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


/* Lists all PdsDikSurat models.
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
		$dataProvider = $searchModel->search2(Yii::$app->request->queryParams, $this->idJenisSurat,$idPdsDik);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'idJenisSurat' => $this->idJenisSurat,	
			'dataProvider' => $dataProvider,
			'titleMain'=>$this->title,
		]);
	}

    /**
     * Creates a new PdsLid model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
	public function actionCreate()
	{
		/* $model = new PdsDik();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id_pds_lid]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }*/
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

		//print_r($model->getErrors());
		$id=Yii::$app->db->createCommand("SELECT id_pds_dik_surat FROM pidsus.pds_dik_surat where id_jenis_surat='".$this->idJenisSurat."' and id_pds_dik='".$_SESSION['idPdsDik']."' and create_by='".(string)Yii::$app->user->identity->username."' order by create_date desc limit 1 ")->queryColumn();
		/*$modelTersangka= new PdsDikTersangka;
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
		$modelDik=$this->findModelDik($idPdsDik);
		$model = $this->findModel($id);
		$modelTembusan= PdsDikTembusan::findBySql('select * from pidsus.select_surat_tembusan_dik(\''.$model->id_pds_dik_surat.'\',\''.Yii::$app->user->id.'\')')->orderby('no_urut')->all();
		$modelSuratTersangka=PdsDikSuratTersangka::find()->where(['id_pds_dik_surat'=>$id])->one();
		$modelTersangka=PdsDikTersangka::find()->where(['id_pds_dik_tersangka'=>$modelSuratTersangka->id_tersangka])->one();
		//$countSuratDetailDasar= Yii::$app->db->createCommand('select count(*) from pidsus.select_surat_detail_dik(\''.$model->id_pds_dik_surat.'\',\''.Yii::$app->user->id.'\') Where tipe_surat_detail=\'Dasar\'')->queryScalar();
		$countSuratDetailPertimbangan= Yii::$app->db->createCommand('select count(*) from pidsus.select_surat_detail_dik(\''.$model->id_pds_dik_surat.'\',\''.Yii::$app->user->id.'\') Where tipe_surat_detail=\'Pertimbangan\'' )->queryScalar();
		//$countSuratDetailUntuk= Yii::$app->db->createCommand('select count(*) from pidsus.select_surat_detail_dik(\''.$model->id_pds_dik_surat.'\',\''.Yii::$app->user->id.'\') Where tipe_surat_detail=\'Untuk\'')->queryScalar();
		$modelSuratDetail=PdsdikSuratDetail::findBySql('select * from pidsus.select_surat_detail_dik(\''.$model->id_pds_dik_surat.'\',\''.Yii::$app->user->id.'\')  order by no_urut')->all();
		$modelSuratIsi= PdsDikSuratIsi::findBySql('select * from pidsus.select_surat_isi_dik(\''.$model->id_pds_dik_surat.'\',\''.Yii::$app->user->id.'\')')->all();
		//print_r($modelSuratDetail);die();
		$modelSuratJaksa=PdsDikSuratJaksa::find()->where('id_pds_dik_surat=\''.$model->id_pds_dik_surat.'\' order by no_urut')->all();
		$modelJaksa=KpPegawai::findBySql("select * from pidsus.get_jaksa_satker('".$_SESSION['idSatkerUser']."') order by peg_nama")->all();
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
			/*if(isset($_POST['modelDetailDasar'])){
				$modelDetailDasar= $_POST['modelDetailDasar'];
				$newNoUrutDasar= $_POST['new_no_urutDasar'];
			}
			else $modelDetailDasar=null;
				*/
			if(isset($_POST['modelDetailPertimbangan'])){
				$modelDetailPertimbangan=$_POST['modelDetailPertimbangan'];
				$newNoUrutPertimbangan= $_POST['new_no_urutPertimbangan'];
			}
			else $modelDetailPertimbangan=null;
			/*
			if(isset($_POST['modelDetailUntuk'])){
				$modelDetailUntuk=$_POST['modelDetailUntuk'];
				$newNoUrutUntuk= $_POST['new_no_urutUntuk'];
			}
			else $modelDetailUntuk=null;

			if($modelDetailDasar!=null){
				for ($i = 0; $i < count($modelDetailDasar); $i++) {
					$countSuratDetailDasar++;
					$modelDetailNew= new PdsLidSuratDetail();
					$modelDetailNew->id_pds_dik_surat=$model->id_pds_dik_surat;
					$modelDetailNew->no_urut=1;
					$modelDetailNew->sub_no_urut=$newNoUrutDasar[$i];
					$modelDetailNew->tipe_surat_detail='Dasar';
					$modelDetailNew->isi_surat_detail=$modelDetailDasar[$i];
					$modelDetailNew->save();
				}
			}
			*/
			if($modelDetailPertimbangan!=null){
				for ($i = 0; $i < count($modelDetailPertimbangan); $i++) {
					$countSuratDetailPertimbangan++;
					$modelDetailNew= new PdsLidSuratDetail();
					$modelDetailNew->id_pds_dik_surat=$model->id_pds_dik_surat;
					$modelDetailNew->no_urut=2;
					$modelDetailNew->sub_no_urut=$newNoUrutPertimbangan[$i];
					$modelDetailNew->tipe_surat_detail='Pertimbangan';
					$modelDetailNew->isi_surat_detail=$modelDetailPertimbangan[$i];
					$modelDetailNew->save();
				}
			}
			/*
			if($modelDetailUntuk!=null){
				for ($i = 0; $i < count($modelDetailUntuk); $i++) {
					$countSuratDetailUntuk++;
					$modelDetailNew= new PdsLidSuratDetail();
					$modelDetailNew->id_pds_dik_surat=$model->id_pds_dik_surat;
					$modelDetailNew->no_urut=3;
					$modelDetailNew->sub_no_urut=$newNoUrutUntuk[$i];
					$modelDetailNew->tipe_surat_detail='Untuk';
					$modelDetailNew->isi_surat_detail=$modelDetailUntuk[$i];
					$modelDetailNew->save();
				}
			}
			*/
			if(isset($_POST['hapus_detail'])){
				for($i = 0; $i < count($_POST['hapus_detail']); $i++){
					PdsdikSuratDetail::deleteAll(['id_pds_dik_surat_detail' => $_POST['hapus_detail'][$i]]);
				}
			}
			if(isset($_POST['hapus_tembusan'])){
				for($i=0; $i<count($_POST['hapus_tembusan']);$i++){
					PdsDiktembusan::deleteAll(['id_pds_dik_tembusan' => $_POST['hapus_tembusan'][$i]]);
				}
			}
			echo $_POST['nip_jpu'];
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
					PdsDikSuratJaksa::deleteAll(['id_jaksa' => $hapus_jpu[$i], 'id_pds_dik_surat'=>$model->id_pds_dik_surat]);
				}
			}
			
			if ($nip_jpu!=null){
				for($i = 0; $i < count($nip_jpu); $i++){
			
					$modelJaksaSurat= new PdsDikSuratJaksa();
					echo $modelJaksaSurat->id_pds_dik_surat_jaksa;
					$modelJaksaSurat->create_by=(string)Yii::$app->user->identity->username;
					$modelJaksaSurat->id_pds_dik_surat=$model->id_pds_dik_surat;
					$modelJaksaSurat->id_jaksa=$nip_jpu[$i];
					$modelJaksaSurat->save();
				}
			}
				
			$model->update_by=(string)Yii::$app->user->identity->username;
			$model->update_date=date('Y-m-d H:i:s');$model->flag='1';
			$model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
			$model->flag = '1';
			$model->save();
			if ($_POST['btnSubmit']=='simpan'){
			//	return $this->redirect(['../pidsus/default/viewlaporandik','id'=>$idPdsDik]);
				return $this->redirect(['../pidsus/b14']);
			}
			else {
				$_SESSION['cetak']=1; return $this->refresh();
			}



			return $this->redirect(['index']);
		} else {
			return $this->render('update', [
				'model' => $model,
                'modelDik' => $modelDik,
                'modelSuratDetail' => $modelSuratDetail,
				'modelSuratIsi' => $modelSuratIsi,
				'modelSuratJaksa' => $modelSuratJaksa,
				'modelJaksa' => $modelJaksa,
				'modelTembusan'	 =>$modelTembusan,

				'readOnly' => false,
				'titleMain'=>$this->title,
			]);
		}
	}


    /**
     * Updates an existing PdsLid model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
  /*  public function actionIndex()
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
        $model = $this->findModel($idPdsDik,'p9');
		$modelTembusan= PdsDikTembusan::findBySql('select * from pidsus.select_surat_tembusan_dik(\''.$model->id_pds_dik_surat.'\',\''.Yii::$app->user->id.'\')')->orderby('no_urut')->all();
		$modelSuratIsi= PdsDikSuratIsi::findBySql('select * from pidsus.select_surat_isi_dik(\''.$model->id_pds_dik_surat.'\',\''.Yii::$app->user->id.'\')')->all();
		
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
        	$model->update_by=(string)Yii::$app->user->identity->username;
        	$model->update_date=date('Y-m-d H:i:s');$model->flag='1';
			$model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
        	$model->save();
        	if ($_POST['btnSubmit']=='simpan'){
        		return $this->redirect(['../pidsus/default/viewlaporandik','id'=>$idPdsDik]);
        	}
        	else {
        		$_SESSION['cetak']=1; return $this->refresh();   //return $this->redirect(['../pidsus/default/viewreportdik', 'id'=>$model->id_pds_dik_surat]);
        	}

        } else {
            return $this->render('update', [
                'model' => $model,
            	'modelSuratIsi' => $modelSuratIsi,
            	'modelTembusan'	 =>$modelTembusan,
            	'readOnly' => false,
            ]);
        }
    }
*/
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
   /* protected function findModel($id,$jenisSurat)
    {
        if (($model = PdsDikSurat::find()->where('id_jenis_surat=\''.$jenisSurat.'\' and id_pds_dik=\''.$id.'\'')->one()) !== null) {
            return $model;
        } else {
            $model= new PdsDikSurat();
			$model->id_pds_dik=$id;
			$model->id_jenis_surat=$jenisSurat;
			$model->create_by=(string)Yii::$app->user->identity->username;
			$model->create_ip=(string)$_SERVER['REMOTE_ADDR'];
			$model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
			$model->perihal_lap='Pemberitahuan Dimulainya Penyidikan Perkara Tindak Pidana Korupsi/ Pelanggaran HAM yang berat';
			$model->save();
			return $this->findModel($id,$jenisSurat);
        }
    }
   */
	protected function findModel($id)
	{
		if (($model = PdsDikSuratforB14::find()->where(['id_pds_dik_surat'=>$id, 'id_jenis_surat'=>$this->idJenisSurat])->one()) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
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
   /* protected function findModelTembusan($id)
    {
    	return $model = PdsDiktembusan::find()->where('id_pds_dik_surat=\''.$id.'\'')->orderBy('no_urut')->all();
    }
   */
}