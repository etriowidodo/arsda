<?php

namespace app\modules\pidsus\controllers;

use Yii;
use app\modules\pidsus\models\PdsDik;
use app\modules\pidsus\models\PdsDikSuratSaksi;
use app\modules\pidsus\models\PdsDikSaksi;
use app\modules\pidsus\models\PdsDikTembusan;
use app\modules\pidsus\models\KpPegawai;
use app\modules\pidsus\models\PdsDikSuratforPidsus6Dik;
use app\modules\pidsus\models\PdsDikSurat;
use app\modules\pidsus\models\PdsDikSuratKeterangan;
use app\modules\pidsus\models\PdsDikSuratJaksa;
use app\modules\pidsus\models\PdsDikSuratIsi;
use app\modules\pidsus\models\PdsDikSuratSearch;
use app\modules\pidsus\models\PdsDikPermintaanData;
use app\modules\pidsus\models\PdsDikUsulanPermintaanData;
use app\modules\pidsus\models\Status;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Pidsus10Controller implements the CRUD actions for PdsDikSurat model.
 */
class Pidsus6dikController extends Controller
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
     * Lists all PdsDikSurat models.
     * @return mixed
     */
    public function actionIndex()
    {
    	$id=$_SESSION['idPdsDik'];
    	$model= PdsDikSuratforPidsus6Dik::findBySql("select * from pidsus.pds_dik_surat where id_pds_dik='".$id."' and id_jenis_surat='pidsus6dik' and create_by='".(string)Yii::$app->user->identity->username."' order by create_date desc limit 1")->one();
    	if($model==null){
    		$model = new PdsDikSurat();
	        $model->id_jenis_surat='pidsus6dik';
	        $model->id_pds_dik=$id;
	        $model->create_by=(string)Yii::$app->user->identity->username;
	        $model->save();
	        //get latest idpdsdiksurat
	        $model= PdsDikSuratforPidsus6Dik::findBySql("select * from pidsus.pds_dik_surat where id_pds_dik='".$id."' and id_jenis_surat='pidsus6dik' and create_by='".(string)Yii::$app->user->identity->username."' order by create_date desc limit 1")->one();
    	}
       	
        return $this->redirect(['update?id='.$model->id_pds_dik_surat]);
    }

    /**
     * Displays a single PdsDikSurat model.
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
     * Creates a new PdsDikSurat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    //Create new pdsdiksurat
		$id=$_SESSION['idPdsDik'];
    	$model = new PdsDikSurat();
        $model->id_jenis_surat='pidsus6dik';
        $model->id_pds_dik=$id;
        $model->create_by=(string)Yii::$app->user->identity->username;
        $model->save();
        //get latest idpdsdiksurat
        $model= PdsDikSuratforPidsus6Dik::findBySql("select * from pidsus.pds_dik_surat where id_pds_dik='".$id."' and id_jenis_surat='pidsus6dik' and create_by='".(string)Yii::$app->user->identity->username."' order by create_date desc limit 1")->one();
        
        return $this->redirect(['update?id='.$model->id_pds_dik_surat]);
    }

    /**
     * Updates an existing PdsDikSurat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
       $model = PdsDikSuratforPidsus6Dik::findOne($id);
       $modelDik = $this->findModelDik($model->id_pds_dik);
       //$modelStatus=Status::findOne($modelDik->id_status);
       $modelSuratIsi= PdsDikSuratIsi::findBySql('select * from pidsus.select_surat_isi_dik(\''.$model->id_pds_dik_surat.'\',\''.Yii::$app->user->id.'\')')->all();
       $modelTembusan= PdsDikTembusan::findBySql('select * from pidsus.select_surat_tembusan_dik(\''.$model->id_pds_dik_surat.'\',\''.Yii::$app->user->id.'\')')->orderby('no_urut')->all();
       $modelSuratJaksa=PdsDikSuratJaksa::find()->where(['id_pds_dik_surat'=>$id])->all();
       $modelJaksa=Yii::$app->db->createCommand('select * from pidsus.get_jaksa_fungsional_grid(\''.$_SESSION['idSatkerUser'].'\')')->queryAll();
		if(isset($_SESSION['cetak'])){
			$_SESSION['cetak']=null;
			$link = "<script>window.open(\"../../pidsus/default/viewreportdik?id=$model->id_pds_dik_surat\")</script>";
			echo $link;
		}


		if ($model->load(Yii::$app->request->post()))  {
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
       			$modelJaksaSurat->create_by=(string)Yii::$app->user->identity->username;
       			$modelJaksaSurat->id_pds_dik_surat=$model->id_pds_dik_surat;
       			$modelJaksaSurat->id_jaksa=$nip_jpu[$i];
       			$modelJaksaSurat->save();
       			}
       	}

	       	$model->update_by=(string)Yii::$app->user->identity->username;
	       	$model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
	       	$model->update_date=date('Y-m-d H:i:s');$model->flag='1';
	       	$model->update_by=(string)Yii::$app->user->identity->username;
	       	$model->update_date=date('Y-m-d H:i:s');$model->flag='1';
	       	$model->save();
	       	//print_r($model);
			if ($_POST['btnSubmit']=='simpan'){
				return $this->redirect(['../pidsus/default/viewlaporandik','id'=>$idPdsDik]);
			}
			else {
				$_SESSION['cetak']=1; return $this->refresh();   //return $this->redirect(['../pidsus/default/viewreportdik', 'id'=>$model->id_pds_dik_surat]);
			}

			if(PdsDikSuratIsi::loadMultiple($modelSuratIsi, Yii::$app->request->post()) ){
	       		foreach($modelSuratIsi as $row){
	       			$row->update_by=Yii::$app->user->identity->username;
	       			$row->update_date=date('Y-m-d H:i:s');
	       			$row->save();//print_r($row->getErrors());
	       		}
	       	}
	     //  	return $this->redirect(['../pidsus/default/viewlaporan?id='.$modelDik->id_pds_dik]);
       } else {
       	return $this->render('update', [
       			'model' => $model,
       			'modelDik' => $modelDik,
       			'modelSuratIsi' => $modelSuratIsi,
       			'modelTembusan' => $modelTembusan,
       			'modelJaksa' => $modelJaksa,
       			'modelSuratJaksa' => $modelSuratJaksa,
       			'titleForm' => "",
       			'readOnly' => false,
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
        if (($model = PdsDikSuratforPidsus6Dik::findOne($id)) !== null) {
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
}
