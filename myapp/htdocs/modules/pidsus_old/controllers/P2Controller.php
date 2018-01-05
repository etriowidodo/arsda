<?php

namespace app\modules\pidsus\controllers;

use Yii;
use app\modules\pidsus\models\PdsLid;
use app\modules\pidsus\models\PdsLidTembusan;
use app\modules\pidsus\models\PdsLidSuratforP2;
use app\modules\pidsus\models\PdsLidSurat;
use app\modules\pidsus\models\PdsLidSuratIsi;
use app\modules\pidsus\models\PdsLidSuratDetail;
use app\modules\pidsus\models\PdsLidSuratSearch;
use app\modules\pidsus\models\PdsLidJaksa;
use app\modules\pidsus\models\PdsLidSuratJaksa;
use app\modules\pidsus\models\KpPegawai;
use app\modules\pidsus\models\KpPegawaiSearch2;
use app\modules\pidsus\models\Status;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * P2Controller implements the CRUD actions for PdsLid model.
 */
class P2Controller extends Controller
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
	//	Yii::$app->language = 'id';
    	$_SESSION['startDateP2']=new \DateTime($this->getStartDate('pidsus3alit'));
    	$_SESSION['startDateP2']=$_SESSION['startDateP2']->format('d m Y');
		$id=$_SESSION['idPdsLid'];
    	
    	$idJenisSurat='p2';        
        $modelLid = $this->findModelLid($id);
        $sql = "SELECT COUNT(*) FROM pidsus.pds_lid_surat where id_jenis_surat='".$idJenisSurat."' and id_pds_lid='".$id."'";
		$numClients = Yii::$app->db->createCommand($sql)->queryScalar();
		//echo $numClients;die();
		if($numClients== 0){
            $model= new PdsLidSurat();
			$model->id_pds_lid=$id;
			$model->id_jenis_surat=$idJenisSurat;
			$model->create_by=(string)Yii::$app->user->identity->username;
			$model->create_ip=(string)$_SERVER['REMOTE_ADDR'];
			$model->save();
			$model = $this->findModel($id,$modelLid,$idJenisSurat);
		}
		$model = $this->findModel($id,$modelLid,$idJenisSurat);
		

		$modelTembusan= PdsLidTembusan::findBySql('select * from pidsus.select_surat_tembusan(\''.$model->id_pds_lid_surat.'\',\''.Yii::$app->user->id.'\')')->orderby('no_urut')->all(); 
		$modelSuratIsi= PdsLidSuratIsi::findBySql('select * from pidsus.select_surat_isi(\''.$model->id_pds_lid_surat.'\',\''.Yii::$app->user->id.'\')')->all();
		//$modelKpPegawai= KpPegawai::findBySql('select distinct from kepegawaian.kp_pegawai')->all();
		$modelJaksa=PdsLidSuratJaksa::find()->where('id_pds_lid_surat=\''.$model->id_pds_lid_surat.'\' order by no_urut')->all();
		//print_r($modelJaksa);die();
		$countSuratDetailDasar= Yii::$app->db->createCommand('select count(*) from pidsus.select_surat_detail(\''.$model->id_pds_lid_surat.'\',\''.Yii::$app->user->id.'\') Where tipe_surat_detail=\'Dasar\'')->queryScalar();
		$countSuratDetailPertimbangan= Yii::$app->db->createCommand('select count(*) from pidsus.select_surat_detail(\''.$model->id_pds_lid_surat.'\',\''.Yii::$app->user->id.'\') Where tipe_surat_detail=\'Pertimbangan\'' )->queryScalar();
		$countSuratDetailUntuk= Yii::$app->db->createCommand('select count(*) from pidsus.select_surat_detail(\''.$model->id_pds_lid_surat.'\',\''.Yii::$app->user->id.'\') Where tipe_surat_detail=\'Untuk\'')->queryScalar();
		$modelSuratDetail=PdsLidSuratDetail::findBySql('select * from pidsus.select_surat_detail(\''.$model->id_pds_lid_surat.'\',\''.Yii::$app->user->id.'\')  order by no_urut,sub_no_urut')->all();
		if(isset($_SESSION['cetak'])){
			$_SESSION['cetak']=null;
			$link = "<script>window.open(\"../pidsus/default/viewreport?id=$model->id_pds_lid_surat\")</script>";
			echo $link;
		}
		if ($model->load(Yii::$app->request->post())) {

			$model->update_by=(string)Yii::$app->user->identity->username;
			$model->update_date=date('Y-m-d H:i:s');$model->flag='1';
			$model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
			$model->save();
			if(PdsLidSuratDetail::loadMultiple($modelSuratDetail, Yii::$app->request->post()) && PdsLidSuratDetail::validateMultiple($modelSuratDetail)){
				foreach($modelSuratDetail as $suratDetailRow){
					$suratDetailRow->save();
				}
			}
			if(PdsLidSuratIsi::loadMultiple($modelSuratIsi, Yii::$app->request->post()) && PdsLidSuratDetail::validateMultiple($modelSuratIsi)){
				foreach($modelSuratIsi as $row){
					$row->save();
				}
			}
			if(isset($_POST['modelDetailDasar'])){
				$modelDetailDasar= $_POST['modelDetailDasar'];
				$newNoUrutDasar= $_POST['new_no_urutDasar'];
			}
			else $modelDetailDasar=null;
			
			if(isset($_POST['modelDetailPertimbangan'])){
				$modelDetailPertimbangan=$_POST['modelDetailPertimbangan'];
				$newNoUrutPertimbangan= $_POST['new_no_urutPertimbangan'];
			}
			else $modelDetailPertimbangan=null;
			
			if(isset($_POST['modelDetailUntuk'])){
				$modelDetailUntuk=$_POST['modelDetailUntuk'];
				$newNoUrutUntuk= $_POST['new_no_urutUntuk'];
			}
			else $modelDetailUntuk=null;
			

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
					PdsLidJaksa::deleteAll(['id_jaksa' => $hapus_jpu[$i], 'id_pds_lid'=>$id]);
					PdsLidSuratJaksa::deleteAll(['id_jaksa' => $hapus_jpu[$i], 'id_pds_lid_surat'=>$model->id_pds_lid_surat]);
				}
			}

			if(isset($_POST['hapus_detail'])){
				for($i = 0; $i < count($_POST['hapus_detail']); $i++){
					PdsLidSuratDetail::deleteAll(['id_pds_lid_surat_detail' => $_POST['hapus_detail'][$i]]);
				}
			}
			
			if ($nip_jpu!=null){
				for($i = 0; $i < count($nip_jpu); $i++){
					$modelJaksaSurat= new PdsLidSuratJaksa();
					$modelJaksaMain = new PdsLidJaksa();
					$modelJaksaSurat->create_by=(string)Yii::$app->user->identity->username;
					$modelJaksaMain->create_by=(string)Yii::$app->user->identity->username;
					$modelJaksaSurat->id_pds_lid_surat=$model->id_pds_lid_surat;
					$modelJaksaMain->id_pds_lid=$id;
					$modelJaksaSurat->id_jaksa=$nip_jpu[$i];
					$modelJaksaMain->id_jaksa=$nip_jpu[$i];
					$modelJaksaSurat->save();
					$modelJaksaMain->save();
				}
			}
			
			if($modelDetailDasar!=null){
				for ($i = 0; $i < count($modelDetailDasar); $i++) {
					$countSuratDetailDasar++;
					$modelDetailNew= new PdsLidSuratDetail();
					$modelDetailNew->id_pds_lid_surat=$model->id_pds_lid_surat;
					$modelDetailNew->no_urut=1;
					$modelDetailNew->sub_no_urut=$newNoUrutDasar[$i];
					$modelDetailNew->tipe_surat_detail='Dasar';
					$modelDetailNew->isi_surat_detail=$modelDetailDasar[$i];
					$modelDetailNew->save();
				}
			}

			if($modelDetailPertimbangan!=null){
				for ($i = 0; $i < count($modelDetailPertimbangan); $i++) {
					$countSuratDetailPertimbangan++;
					$modelDetailNew= new PdsLidSuratDetail();
					$modelDetailNew->id_pds_lid_surat=$model->id_pds_lid_surat;
					$modelDetailNew->no_urut=2;
					$modelDetailNew->sub_no_urut=$newNoUrutPertimbangan[$i];
					$modelDetailNew->tipe_surat_detail='Pertimbangan';
					$modelDetailNew->isi_surat_detail=$modelDetailPertimbangan[$i];
					$modelDetailNew->save();
				}
			}

			if($modelDetailUntuk!=null){
				for ($i = 0; $i < count($modelDetailUntuk); $i++) {
					$countSuratDetailUntuk++;
					$modelDetailNew= new PdsLidSuratDetail();
					$modelDetailNew->id_pds_lid_surat=$model->id_pds_lid_surat;
					$modelDetailNew->no_urut=3;
					$modelDetailNew->sub_no_urut=$newNoUrutUntuk[$i];
					$modelDetailNew->tipe_surat_detail='Untuk';
					$modelDetailNew->isi_surat_detail=$modelDetailUntuk[$i];
					$modelDetailNew->save();
				}
			}
			if(PdsLidTembusan::loadMultiple($modelTembusan, Yii::$app->request->post()) && PdsLidTembusan::validateMultiple($modelTembusan)){
        		$noUrutTembusan=1;foreach($modelTembusan as $row){$row->no_urut=$noUrutTembusan;$noUrutTembusan++;
        			$row->update_by=Yii::$app->user->identity->username;
        			$row->update_date=date('Y-m-d H:i:s');
        			$row->save();        	
        		}
        	}
        	if(isset($_POST['new_tembusan'])){
        		for($i = 0; $i < count($_POST['new_tembusan']); $i++){
	        		$modelNewTembusan= new PdsLidtembusan();
	        		$modelNewTembusan->id_pds_lid_surat=$model->id_pds_lid_surat;
	        		$modelNewTembusan->no_urut=$noUrutTembusan;$noUrutTembusan++;
	        		$modelNewTembusan->tembusan=$_POST['new_tembusan'][$i];
					$modelNewTembusan->create_by=(string)Yii::$app->user->identity->username;
					$modelNewTembusan->save();
        		}
        	}
        	if(isset($_POST['hapus_tembusan'])){
        		for($i=0; $i<count($_POST['hapus_tembusan']);$i++){
        			PdsLidtembusan::deleteAll(['id_pds_lid_tembusan' => $_POST['hapus_tembusan'][$i]]);
        		}
        	}
		if ($_POST['btnSubmit']=='simpan'){
        		return $this->redirect(['../pidsus/default/viewlaporan','id'=>$model->id_pds_lid]);
        	}
        	else {
        		$_SESSION['cetak']=1; return $this->refresh();   //return $this->redirect(['../pidsus/default/viewreport', 'id'=>$model->id_pds_lid_surat]);
        	}
		}

		else {
			return $this->render('index', [
                'model' => $model,
                'modelLid' => $modelLid,
            	'modelSuratIsi' => $modelSuratIsi,
            	'modelSuratDetail' => $modelSuratDetail,
            	'modelTembusan'	 =>$modelTembusan,
				'modelKpPegawai' =>null,
				'modelJaksa' =>$modelJaksa,
            	'readOnly' => false,
            ]);
		}
		
    }

    public function getStartDate($jenisSurat){
    	$modelP2=PdsLidSurat::find()->where('id_jenis_surat=\''.$jenisSurat.'\' and id_pds_lid=\''.$_SESSION['idPdsLid'].'\'')->one();
    	return $modelP2->tgl_surat;
    }
    public function actionJpu()
    {  // $model->id_satker=$_SESSION['idSatkerUser'];
    	$searchModel = new KpPegawaiSearch2();
    	$dataProvider = $searchModel->searchBySatker(Yii::$app->request->queryParams,$_SESSION['idSatkerUser']);
    	$dataProvider->pagination->pageSize=10;
    	return $this->renderAjax('_jpu', [
    			'searchModel' => $searchModel,
    			'dataProvider' => $dataProvider,
    	]);
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
        if (($model = PdsLidSuratforP2::find()->where('id_jenis_surat=\''.$type.'\' and id_pds_lid=\''.$id.'\'')->one()) !== null) {
            return $model;
        } else {
    		throw new NotFoundHttpException('The requested page does not exist.');
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
    
}
