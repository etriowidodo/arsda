<?php

namespace app\modules\pidsus\controllers;

use Yii;
use yii\data\ArrayDataProvider;
use app\modules\pidsus\models\PdsDik;
use app\modules\pidsus\models\PdsDikTembusan;
use app\modules\pidsus\models\PdsDikSuratforP15;
use app\modules\pidsus\models\PdsDikSurat;
use app\modules\pidsus\models\PdsDikSuratIsi;
use app\modules\pidsus\models\PdsDikSuratDetail;
use app\modules\pidsus\models\PdsDikSuratSearch;
use app\modules\pidsus\models\PdsDikJaksa;
use app\modules\pidsus\models\PdsDikSuratJaksa;
use app\modules\pidsus\models\KpPegawai;
use app\modules\pidsus\models\KpPegawaiSearch;
use app\modules\pidsus\models\Status;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * P2Controller implements the CRUD actions for PdsDik model.
 */
class P15Controller extends Controller
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
     * Lists all PdsDik models.
     * @return mixed
     */
    public function actionIndex()
    {
    	$id=$_SESSION['idPdsDik'];
    	
    	$idJenisSurat='p15';        
        $modelDik = $this->findModelDik($id);
        $sql = "SELECT COUNT(*) FROM pidsus.pds_dik_surat where id_jenis_surat='".$idJenisSurat."' and id_pds_dik='".$id."'";
		$numClients = Yii::$app->db->createCommand($sql)->queryScalar();
		if($numClients== 0){
            $model= new PdsDikSurat();
			$model->id_pds_dik=$id;
			$model->id_jenis_surat=$idJenisSurat;
			$model->create_by=(string)Yii::$app->user->identity->username;
			$model->create_ip=(string)$_SERVER['REMOTE_ADDR'];
			$model->save();
			$model = $this->findModel($id,$modelDik,$idJenisSurat);
		}
		$model = $this->findModel($id,$modelDik,$idJenisSurat);
		

		$modelTembusan= PdsDikTembusan::findBySql('select * from pidsus.select_surat_tembusan_dik(\''.$model->id_pds_dik_surat.'\',\''.Yii::$app->user->id.'\')')->orderby('no_urut')->all(); 
		$modelSuratIsi= PdsDikSuratIsi::findBySql('select * from pidsus.select_surat_isi_dik(\''.$model->id_pds_dik_surat.'\',\''.Yii::$app->user->id.'\')')->all();
		//$modelKpPegawai= KpPegawai::findBySql('select distinct from kepegawaian.kp_pegawai')->all();
		$modelJaksa=PdsDikSuratJaksa::find()->where('id_pds_dik_surat=\''.$model->id_pds_dik_surat.'\' order by no_urut')->all();
		$countSuratDetailDasar= Yii::$app->db->createCommand('select count(*) from pidsus.select_surat_detail(\''.$model->id_pds_dik_surat.'\',\''.Yii::$app->user->id.'\') Where tipe_surat_detail=\'Dasar\'')->queryScalar();
		$countSuratDetailPertimbangan= Yii::$app->db->createCommand('select count(*) from pidsus.select_surat_detail(\''.$model->id_pds_dik_surat.'\',\''.Yii::$app->user->id.'\') Where tipe_surat_detail=\'Pertimbangan\'' )->queryScalar();
		$countSuratDetailUntuk= Yii::$app->db->createCommand('select count(*) from pidsus.select_surat_detail(\''.$model->id_pds_dik_surat.'\',\''.Yii::$app->user->id.'\') Where tipe_surat_detail=\'Untuk\'')->queryScalar();
		$modelSuratDetail=PdsDikSuratDetail::findBySql('select * from pidsus.select_surat_detail_dik(\''.$model->id_pds_dik_surat.'\',\''.Yii::$app->user->id.'\')  order by no_urut,sub_no_urut')->all();
		if(isset($_SESSION['cetak'])){
			$_SESSION['cetak']=null;
			$link = "<script>window.open(\"../pidsus/default/viewreportdik?id=$model->id_pds_dik_surat\")</script>";
			echo $link;
		}
		if ($model->load(Yii::$app->request->post())) {

			$model->update_by=(string)Yii::$app->user->identity->username;
			$model->update_date=date('Y-m-d H:i:s');$model->flag='1';
			$model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
			$model->save();
			if(PdsDikSuratDetail::loadMultiple($modelSuratDetail, Yii::$app->request->post()) && PdsDikSuratDetail::validateMultiple($modelSuratDetail)){
				foreach($modelSuratDetail as $suratDetailRow){
					$suratDetailRow->save();
				}
			}
			if(PdsDikSuratIsi::loadMultiple($modelSuratIsi, Yii::$app->request->post()) && PdsDikSuratDetail::validateMultiple($modelSuratIsi)){
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
					PdsDikJaksa::deleteAll(['id_jaksa' => $hapus_jpu[$i], 'id_pds_dik'=>$id]);
					PdsDikSuratJaksa::deleteAll(['id_jaksa' => $hapus_jpu[$i], 'id_pds_dik_surat'=>$model->id_pds_dik_surat]);
				}
			}

			if(isset($_POST['hapus_detail'])){
				for($i = 0; $i < count($_POST['hapus_detail']); $i++){
					PdsDikSuratDetail::deleteAll(['id_pds_dik_surat_detail' => $_POST['hapus_detail'][$i]]);
				}
			}
			
			if ($nip_jpu!=null){
				for($i = 0; $i < count($nip_jpu); $i++){
					$modelJaksaSurat= new PdsDikSuratJaksa();
					$modelJaksaMain = new PdsDikJaksa();
					$modelJaksaSurat->create_by=(string)Yii::$app->user->identity->username;
					$modelJaksaMain->create_by=(string)Yii::$app->user->identity->username;
					$modelJaksaSurat->id_pds_dik_surat=$model->id_pds_dik_surat;
					$modelJaksaMain->id_pds_dik=$id;
					$modelJaksaSurat->id_jaksa=$nip_jpu[$i];
					$modelJaksaMain->id_jaksa=$nip_jpu[$i];
					$modelJaksaSurat->save();
					$modelJaksaMain->save();
				}
			}
			
			if($modelDetailDasar!=null){
				for ($i = 0; $i < count($modelDetailDasar); $i++) {
					$countSuratDetailDasar++;
					$modelDetailNew= new PdsDikSuratDetail();
					$modelDetailNew->id_pds_dik_surat=$model->id_pds_dik_surat;
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
					$modelDetailNew= new PdsDikSuratDetail();
					$modelDetailNew->id_pds_dik_surat=$model->id_pds_dik_surat;
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
					$modelDetailNew= new PdsDikSuratDetail();
					$modelDetailNew->id_pds_dik_surat=$model->id_pds_dik_surat;
					$modelDetailNew->no_urut=3;
					$modelDetailNew->sub_no_urut=$newNoUrutUntuk[$i];
					$modelDetailNew->tipe_surat_detail='Untuk';
					$modelDetailNew->isi_surat_detail=$modelDetailUntuk[$i];
					$modelDetailNew->save();
				}
			}
			if(PdsDikTembusan::loadMultiple($modelTembusan, Yii::$app->request->post()) && PdsDikTembusan::validateMultiple($modelTembusan)){
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
        	if(isset($_POST['hapus_tembusan'])){
        		for($i=0; $i<count($_POST['hapus_tembusan']);$i++){
        			PdsDiktembusan::deleteAll(['id_pds_dik_tembusan' => $_POST['hapus_tembusan'][$i]]);
        		}
        	}

       	if($_POST['PdsDik']['is_final']==1 && isset($_POST['lokasi_penuntutan'])&& $_POST['lokasi_penuntutan']!==''){
        		$rawData=Yii::$app->db->createCommand("select * from pidsus.kirim_dik_ke_tut('".$modelDik->id_satker."','".$_POST['lokasi_penuntutan']."','".$model->id_pds_dik."','".(string)Yii::$app->user->identity->username."','localhost')")->queryAll();
        			
        	}
		if ($_POST['btnSubmit']=='simpan'){
        		return $this->redirect(['../pidsus/default/viewlaporandik','id'=>$model->id_pds_dik]);
        	}
        	else {
        		$_SESSION['cetak']=1; return $this->refresh();   //return $this->redirect(['../pidsus/default/viewreport', 'id'=>$model->id_pds_dik_surat]);
        	}
		}

		else {
			$_SESSION['idPdsDikSurat']=$model->id_pds_dik_surat;
			return $this->render('index', [
                'model' => $model,
                'modelDik' => $modelDik,
            	'modelSuratIsi' => $modelSuratIsi,
            	'modelSuratDetail' => $modelSuratDetail,
            	'modelTembusan'	 =>$modelTembusan,
				'modelKpPegawai' =>null,
				'modelJaksa' =>$modelJaksa,
            	'readOnly' => false,
            ]);
		}
		
    }

    
    public function actionJpu()
    {  // $model->id_satker=$_SESSION['idSatkerUser'];
    	$rawData=Yii::$app->db->createCommand("select * from pidsus.get_jaksa_p8dik('".$_SESSION['idPdsDikSurat']."')")->queryAll();  //idsatker
    	
    	$dataProvider=new ArrayDataProvider([
    			'allModels' =>$rawData, 'key' => 'peg_nik',
    	
    			'pagination'=>[
    					'pageSize'=>10,         //records display
    					],
    			]);
    	return $this->renderAjax('_jpu', [
    			'dataProvider' => $dataProvider,
    	]);
    }
    
    /**
     * Finds the PdsDik model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdsDik the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id,$modelDik,$type)
    {
        if (($model = PdsDikSuratforP15::find()->where('id_jenis_surat=\''.$type.'\' and id_pds_dik=\''.$id.'\'')->one()) !== null) {
            return $model;
        } else {
    		throw new NotFoundHttpException('The requested page does not exist.');
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
