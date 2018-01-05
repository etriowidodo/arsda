<?php

namespace app\modules\pidsus\controllers;

use Yii;
use app\modules\pidsus\models\PdsLid;
use app\modules\pidsus\models\PdsLidTembusan;
use app\modules\pidsus\models\PdsLidSuratforPidsus4;
use app\modules\pidsus\models\PdsLidSurat;
use app\modules\pidsus\models\PdsLidSuratIsi;
use app\modules\pidsus\models\PdsLidSuratDetail;
use app\modules\pidsus\models\PdsLidSuratSearch;
use app\modules\pidsus\models\PdsLidJaksa;
use app\modules\pidsus\models\PdsLidSuratJaksa;
use app\modules\pidsus\models\PdsLidPermintaanData;
use app\modules\pidsus\models\PdsLidUsulanPermintaanData;
use app\modules\pidsus\models\KpPegawai;
use app\modules\pidsus\models\Status;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * P2Controller implements the CRUD actions for PdsLid model.
 */
class Pidsus4Controller extends Controller
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
     */

    public function actionIndex()
    {	
    	if(empty($_SESSION['idPdsLid'])){
    		if (!empty($_SESSION['idPdsDik'])){
    			$modelPdsDik=PdsDik::find()->where(['id_pds_dik'=>$_SESSION['idPdsDik']])->one();
    			$_SESSION['idPdsLid']=$modelPdsDik->id_pds_lid_parent;
    		}
    		if (!empty($_SESSION['idPdsTut'])){
    			$modelPdsDik=PdsTut::find()->where(['id_pds_tut'=>$_SESSION['idPdsTut']])->one();
    			$_SESSION['idPdsLid']=$modelPdsTut->id_pds_lid_parent;
    		}
    		else{
    			return $this->redirect(['../pidsus/default/index']);
    		}
    	}
    	$_SESSION['startDatePidsus4']=new \DateTime($this->getStartDate('p2'));
    	$_SESSION['startDatePidsus4']=$_SESSION['startDatePidsus4']->format('d m Y');
		$id=$_SESSION['idPdsLid'];
    	//$modelLid =PdsLid::findOne($id);
    	//$modelStatus=Status::findOne($modelLid->id_status);
        $searchModel = new PdsLidSuratSearch();
        $idJenisSurat='pidsus4';        
        $modelLid = $this->findModelLid($id);
        //$modelStatus=Status::findOne($modelLid->id_status);
       // $model = $this->findModel($id,$modelLid,$idJenisSurat);
        $model = $this->findModel($id,$modelLid,$idJenisSurat);
        $_SESSION['idPdsLidSurat']=$model->id_pds_lid_surat;
        //$modelJaksa=Yii::$app->db->createCommand("select peg_nik,peg_nama from pidsus.pds_lid_jaksa plj left join kepegawaian.kp_pegawai kp on kp.peg_nik=plj.id_jaksa")->queryAll();
		$modelJaksa=Yii::$app->db->createCommand('select * from pidsus.get_jaksa_p2(\''.$model->id_pds_lid_surat.'\')')->queryAll();
        $modelPermintaanData=PdsLidUsulanPermintaanData::find()->where(['id_pds_lid_surat'=>$model->id_pds_lid_surat,'flag'=>'1'])->all();
        $modelTembusan= PdsLidTembusan::findBySql('select * from pidsus.select_surat_tembusan(\''.$model->id_pds_lid_surat.'\',\''.Yii::$app->user->id.'\') order by id_pds_lid_tembusan')->orderby('no_urut')->all();        
		$modelSuratIsi= PdsLidSuratIsi::findBySql('select * from pidsus.select_surat_isi(\''.$model->id_pds_lid_surat.'\',\''.Yii::$app->user->id.'\') order by no_urut')->all();
		//$modelKpPegawai= KpPegawai::findBySql('select * from kepegawaian.kp_pegawai')->all();
		if(isset($_SESSION['cetak'])){
			$_SESSION['cetak']=null;
			$link = "<script>window.open(\"../pidsus/default/viewreport?id=$model->id_pds_lid_surat\")</script>";
			echo $link;
		}
		if ($model->load(Yii::$app->request->post())) {
			$model->update_by=Yii::$app->user->identity->username;
			$model->update_date=date('Y-m-d H:i:s');$model->flag='1';
			$model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
			$model->save();
			
			if(PdsLidSuratIsi::loadMultiple($modelSuratIsi, Yii::$app->request->post()) ){
				foreach($modelSuratIsi as $row){
					$row->update_by=Yii::$app->user->identity->username;
					$row->update_date=date('Y-m-d H:i:s');
					$row->save();

					//print_r($row->getErrors());
				}
			}

			if(PdsLidPermintaanData::loadMultiple($modelPermintaanData, Yii::$app->request->post()) && PdsLidPermintaanData::validateMultiple($modelPermintaanData)){
				foreach($modelPermintaanData as $row){
					$row->update_by=Yii::$app->user->identity->username;
					$row->update_date=date('Y-m-d H:i:s');
					$row->save();
				}
			}
			
			if(isset($_POST['nama_pd_insert'])){
				$namaPd=$_POST['nama_pd_insert'];
				$jabatanPd=$_POST['jabatan_pd_insert'];
				$namaInstansiPd=$_POST['nama_instansi_pd_insert'];
				$waktuPd=$_POST['waktu_pd_insert'];
				$jaksaPd=$_POST['jaksa_pd_insert'];
				$keperluanPd=$_POST['keperluan_pd_insert'];
				}
			else {
				$namaPd=null;
				$jabatanPd=null;
				$namaInstansiPd=null;
				$waktuPd=null;
				$jaksaPd=null;
				$keperluanPd=null;
			}
			if($namaPd!=null){
				for($i = 0; $i < count($namaPd); $i++){
					$modelPd= new PdsLidUsulanPermintaanData();
					$modelPd->id_pds_lid_surat=$model->id_pds_lid_surat;
					$modelPd->nama=$namaPd[$i];
					$modelPd->jabatan=$jabatanPd[$i];
					$modelPd->nama_instansi=$namaInstansiPd[$i];
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
					pdsLidUsulanPermintaanData::deleteAll(['id_pds_lid_usulan_permintaan_data' => $hapus_pd[$i]]);
				}
			}
			
			
			
			//$this->generatePidsus5($model);	
		if ($_POST['btnSubmit']=='simpan'){
        		return $this->redirect(['../pidsus/default/viewlaporan','id'=>$id]);
        	}
        	else {
        	//	echo CHtml::link('Link Text','http://google.com', array('target'=>'_blank'));
        		$_SESSION['cetak']=1; return $this->refresh();   //return $this->redirect(['../pidsus/default/viewreport', 'id'=>$model->id_pds_lid_surat]);
        	}
		}

		else {
			return $this->render('index', [
                'model' => $model,
                'modelLid' => $modelLid,
            	'modelSuratIsi' => $modelSuratIsi,
            	'modelTembusan' => $modelTembusan,
				//'modelKpPegawai' =>$modelKpPegawai,
				'modelPermintaanData'=>$modelPermintaanData,
				'modelJaksa' =>$modelJaksa,
            	'titleForm' => "",
            	'readOnly' => false,
            ]);
		}
		
    }
public function getStartDate($jenisSurat){
    	$modelPidsus2=PdsLidSurat::find()->where('id_jenis_surat=\''.$jenisSurat.'\' and id_pds_lid=\''.$_SESSION['idPdsLid'].'\'')->one();
    	return $modelPidsus2->tgl_surat;
    }
	public function generatePidsus5($modelPidsus4){
		//$modelExistingPermintaanData=pdsLidPermintaanData::findBySql('select * from pidsus.get_existing_permintaan_data_lid(\''.$modelPidsus4->id_pds_lid.'\')')->all();
		$modelUsulanPermintaanData=pdsLidUsulanPermintaanData::find()->where(['id_pds_lid_surat'=>$modelPidsus4->id_pds_lid_surat])->all();
		foreach ($modelUsulanPermintaanData as $rowData){
			$modelPermintaanData=pdsLidPermintaanData::findBySql('select * from pidsus.get_existing_permintaan_data_lid(\''.$modelPidsus4->id_pds_lid.'\',\''.$rowData->nama.'\',\''.$rowData->nama_instansi.'\','.$rowData->keperluan.'::smallint)')->all();
			if(count($modelPermintaanData)==0){
				echo 'insert';
			}
			else {
				echo 'pass';
			}
			
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
    protected function findModel($id,$modelLid,$type)
    {
        if (($model = PdsLidSuratforPidsus4::find()->where('id_jenis_surat=\''.$type.'\' and id_pds_lid=\''.$id.'\'')->one()) !== null) {

			if ($model->kepada==''){
				$model->kepada ='KASUBDIT PENYIDIKAN TPK/ ASPIDSUS/ KASI PIDSUS/ KASUBSI TINDAK PIDANA';
			}
			if ($model->perihal_lap==''){
				$model->perihal_lap ='Usul untuk pemanggilan, permintaan data, dan tindakan lain';
			}
			$model->save();
			return $model;
        } else {
            $model= new PdsLidSurat();
			$model->id_pds_lid=$id;
			$model->id_jenis_surat=$type;
			$model->id_status=$modelLid->id_status;
			$model->create_by=(string)Yii::$app->user->identity->username;
			$model->create_ip=(string)$_SERVER['REMOTE_ADDR'];
			$model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
			$model->kepada ='KASUBDIT PENYIDIKAN TPK/ ASPIDSUS/ KASI PIDSUS/ KASUBSI TINDAK PIDANA';
			$model->perihal_lap='Usul untuk pemanggilan, permintaan data, dan tindakan lain';
			$model->save();
			$model = $this->findModel($id,$modelLid,$type);
			return $model;
        }
    }
    protected function findModelLid($id)
    {
    	if (($modelLid = PdsLid::findOne($id)) !== null) {
    		return $modelLid;
    	} else {
    		throw new NotFoundHttpException('The requested page does not exist.');
    	}
    }
    protected function findModelTembusan($id)
    {
    	return $model = PdsLidTembusan::find()->where('id_pds_lid_surat=\''.$id.'\'')->orderBy('no_urut')->all();
    }
    
    public function actionShowpermintaandata($tgl='')
    {
    	$modelPermintaanData = new PdsLidUsulanPermintaanData();
		$modelPermintaanData->nama='-';
		$modelPermintaanData->nama_instansi='-';
		$modelPermintaanData->jabatan='-';
		$modelPermintaanData->keperluan='-';
    	$modelPermintaanData->id_pds_lid_surat = $idPdsDik=$_SESSION['idPdsLidSurat'];
    	
    	if ($modelPermintaanData->load(Yii::$app->request->post()) ) {
    		$modelPermintaanData->create_by=(string)Yii::$app->user->identity->username;
    		$modelPermintaanData->create_date=date('Y-m-d H:i:s');
    		$modelPermintaanData->flag='1'; 
    		$modelPermintaanData->save();
    		$data['id_pds_lid_usulan_permintaan_data'] = $modelPermintaanData->id_pds_lid_usulan_permintaan_data;
    		echo json_encode($data);
    		//print_r($model->getErrors());
    	}
    	else {
    		return $this->renderAjax('_popPd', [
    				'modelPermintaanData' => $modelPermintaanData,
    				'startDate'=>$tgl
    		]);
    	}
    	/*$searchModel = new PdsLidPermintaanDataSearch();
    	 $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$_SESSION['idPdsDik']);
    	 $dataProvider->pagination->pageSize=10;
    	 return $this->renderAjax('_listtersangkadik', [
    	 'searchModel' => $searchModel,
    	 'dataProvider' => $dataProvider,
    	 ]);*/
    }
    public function actionEditpermintaandata($id)
    {
    	$modelPermintaanData = PdsLidUsulanPermintaanData::find()->where(['id_pds_lid_usulan_permintaan_data'=>$id])->one();
    
    	if ($modelPermintaanData->load(Yii::$app->request->post()) ) {
    		$modelPermintaanData->id_pds_lid_surat = $idPdsDik=$_SESSION['idPdsLidSurat'];
    		$modelPermintaanData->create_by=(string)Yii::$app->user->identity->username;
    		$modelPermintaanData->create_date=date('Y-m-d H:i:s');
    
    		$modelPermintaanData->save();
    		//echo json_encode($modelPermintaanData->id_pds_dik_tersangka);
    		//print_r($model->getErrors());
    	}
    	else {
    		return $this->renderAjax('_popPdEdit', [
    				'modelPermintaanData' => $modelPermintaanData
    		]);
    	}
    	/*$searchModel = new PdsLidPermintaanDataSearch();
    	 $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$_SESSION['idPdsDik']);
    	 $dataProvider->pagination->pageSize=10;
    	 return $this->renderAjax('_listtersangkadik', [
    	 'searchModel' => $searchModel,
    	 'dataProvider' => $dataProvider,
    	 ]);*/
    }
    
    public function actionDeletepermintaandata($id){
    	$modelPermintaanData = PdsLidUsulanPermintaanData::find()->where(['id_pds_lid_usulan_permintaan_data'=>$id])->one();
    	$modelPermintaanData->flag='3';
    	$modelPermintaanData->update_by=(string)Yii::$app->user->identity->username;
    	$modelPermintaanData->update_date=date('Y-m-d H:i:s');
    	$modelPermintaanData->save();
    	
    	//print_r($modelPermintaanData->getErrors());
    }
}
