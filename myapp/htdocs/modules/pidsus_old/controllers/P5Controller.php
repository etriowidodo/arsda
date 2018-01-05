<?php

namespace app\modules\pidsus\controllers;

use Yii;
use app\modules\pidsus\models\PdsLid;
use app\modules\pidsus\models\PdsLidSuratSaksi;
use app\modules\pidsus\models\PdsLidSaksi;
use app\modules\pidsus\models\PdsLidTembusan;
use app\modules\pidsus\models\KpPegawai;
use app\modules\pidsus\models\PdsLidSuratforP5;
use app\modules\pidsus\models\PdsLidSurat;
use app\modules\pidsus\models\PdsLidSuratKeterangan;
use app\modules\pidsus\models\PdsLidSuratJaksa;
use app\modules\pidsus\models\PdsLidSuratIsi;
use app\modules\pidsus\models\PdsLidSuratSearch;
use app\modules\pidsus\models\PdsLidPermintaanData;
use app\modules\pidsus\models\PdsLidUsulanPermintaanData;
use app\modules\pidsus\models\Status;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Pidsus10Controller implements the CRUD actions for PdsLidSurat model.
 */
class P5Controller extends Controller
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
     * Lists all PdsLidSurat models.
     * @return mixed
     */
    public function actionIndex()
    {
       	$id=$_SESSION['idPdsLid'];
    	$model= PdsLidSuratforP5::findBySql("select * from pidsus.pds_lid_surat where id_pds_lid='".$id."' and id_jenis_surat='p5' and create_by='".(string)Yii::$app->user->identity->username."' order by create_date desc limit 1")->one();
    	if($model==null){
    		$model = new PdsLidSurat();
	        $model->id_jenis_surat='p5';
	        $model->id_pds_lid=$id;
	        $model->create_by=(string)Yii::$app->user->identity->username;
	        $model->create_ip=(string)$_SERVER['REMOTE_ADDR'];
	        $model->save();
	        //get latest idpdslidsurat
	        $model= PdsLidSuratforP5::findBySql("select * from pidsus.pds_lid_surat where id_pds_lid='".$id."' and id_jenis_surat='p5' and create_by='".(string)Yii::$app->user->identity->username."' order by create_date desc limit 1")->one();	        
    	}
       	
        return $this->redirect(['update?id='.$model->id_pds_lid_surat]);
    }

    /**
     * Displays a single PdsLidSurat model.
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
     * Updates an existing PdsLidSurat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
       $model = PdsLidSuratforP5::findOne($id);
       $modelLid = $this->findModelLid($model->id_pds_lid);
       //$modelStatus=Status::findOne($modelLid->id_status);
	   $_SESSION['startDateP5']=new \DateTime($this->getStartDate('pidsus7'));
       $_SESSION['startDateP5']=$_SESSION['startDateP5']->format('d m Y');
       $modelTembusan= PdsLidTembusan::findBySql('select * from pidsus.select_surat_tembusan(\''.$model->id_pds_lid_surat.'\',\''.Yii::$app->user->id.'\')')->orderby('no_urut')->all();              
       $modelSuratIsi= PdsLidSuratIsi::findBySql('select * from pidsus.select_surat_isi(\''.$model->id_pds_lid_surat.'\',\''.Yii::$app->user->id.'\')')->all();
		if(isset($_SESSION['cetak'])){
			$_SESSION['cetak']=null;
			$link = "<script>window.open(\"../default/viewreport?id=$model->id_pds_lid_surat\")</script>";
			echo $link;
		}

		if ($model->load(Yii::$app->request->post()))  {
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
       	
       	if ($nip_jpu!=null){
       		for($i = 0; $i < count($nip_jpu); $i++){
       			$modelJaksaSurat= new PdsLidSuratJaksa();
       			$modelJaksaSurat->create_by=(string)Yii::$app->user->identity->username;
       			$modelJaksaSurat->id_pds_lid_surat=$model->id_pds_lid_surat;
       			$modelJaksaSurat->id_jaksa=$nip_jpu[$i];
       			$modelJaksaSurat->save();
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
	       	$model->update_by=(string)Yii::$app->user->identity->username;
			$model->update_date=date('Y-m-d H:i:s');$model->flag='1';
			$model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
	       	$model->save();
	       	//print_r($model);
	       	if(PdsLidSuratIsi::loadMultiple($modelSuratIsi, Yii::$app->request->post()) ){
	       		foreach($modelSuratIsi as $row){
	       			$row->update_by=Yii::$app->user->identity->username;
	       			$row->update_date=date('Y-m-d H:i:s');
	       			$row->save();//print_r($row->getErrors());
	       		}
	       	}
	       	
	       	if ($_POST['btnSubmit']=='simpan'){
	       		return $this->redirect(['../pidsus/default/viewlaporan?id='.$modelLid->id_pds_lid]);
	       	}
	       	else {
	       		$_SESSION['cetak']=1; return $this->refresh();   //return $this->redirect(['../pidsus/default/viewreport', 'id'=>$model->id_pds_lid_surat]);
	       	}
       } else {
       	return $this->render('update', [
       			'model' => $model,
       			'modelLid' => $modelLid,
       			'modelSuratIsi' => $modelSuratIsi,
       			'modelTembusan' => $modelTembusan,
       			'titleForm' => "",
       			'readOnly' => false,
       	]);
       }
    }

    /**
     * Deletes an existing PdsLidSurat model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
	  public function getStartDate($jenisSurat){
    	$modelPidsus2=PdsLidSurat::find()->where(['id_jenis_surat'=>$jenisSurat,'id_pds_lid'=>$_SESSION['idPdsLid']])->	orderBy(['tgl_surat'=>SORT_DESC])->one();
    	return $modelPidsus2->tgl_surat;
    }
	
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PdsLidSurat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdsLidSurat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdsLidSuratforP5::findOne($id)) !== null) {
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
}
