<?php

namespace app\modules\pidsus\controllers;

use Yii;
use app\modules\pidsus\models\PdsLid;
use app\modules\pidsus\models\PdsLidTembusan;
use app\modules\pidsus\models\PdsLidSuratforPidsus2;
use app\modules\pidsus\models\PdsLidSurat;
use app\modules\pidsus\models\PdsLidSuratIsi;
use app\modules\pidsus\models\Pidsus2Search;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * P2Controller implements the CRUD actions for PdsLid model.
 */
class Pidsus2Controller extends Controller
{
	public $titleSurat='Pidsus 2 - Pemberitahuan Tindak Lanjut atas Laporan/Pengaduan';
	//public $subTitleSurat='Pemberitahuan Tindak Lanjut atas Laporan/Pengaduan';
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
    public function actionCreate()
    {
        $model = new PdsLid();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_pds_lid]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PdsLid model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
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
    	$_SESSION['startDatePidsus2']=new \DateTime($this->getStartDate('pidsus1'));
    	$_SESSION['startDatePidsus2']=$_SESSION['startDatePidsus2']->format('d m Y');
		$idPdsLid=$_SESSION['idPdsLid'];
        $modelLid = $this->findModelLid($idPdsLid);
        $model = $this->findModel($idPdsLid,$modelLid,'pidsus2');
		$modelTembusan= PdsLidTembusan::findBySql('select * from pidsus.select_surat_tembusan(\''.$model->id_pds_lid_surat.'\',\''.Yii::$app->user->id.'\')')->orderby('no_urut')->all();
		$modelSuratIsi= PdsLidSuratIsi::findBySql('select * from pidsus.select_surat_isi(\''.$model->id_pds_lid_surat.'\',\''.Yii::$app->user->id.'\')')->all();
        if(isset($_SESSION['cetak'])){
            $_SESSION['cetak']=null;
            $link = "<script>window.open(\"../pidsus/default/viewreport?id=$model->id_pds_lid_surat\")</script>";
            echo $link;
        }
        if ($model->load(Yii::$app->request->post()) ) {

        	if(PdsLidSuratIsi::loadMultiple($modelSuratIsi, Yii::$app->request->post()) ){
        		foreach($modelSuratIsi as $row){
        			$row->update_by=Yii::$app->user->identity->username;
        			$row->update_date=date('Y-m-d H:i:s');
        			$row->save();
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
        	//echo $model->id_status;
        	$modelLid = $this->findModelLid($idPdsLid);
        	$modelLid->update_by=(string)Yii::$app->user->identity->username;
			$modelLid->update_ip=(string)$_SERVER['REMOTE_ADDR'];
        	$modelLid->update_date=date('Y-m-d H:i:s');
        	$modelLid->id_status=$model->id_status;
        	$modelLid->save();
        	if ($_POST['btnSubmit']=='simpan'){
        		return $this->redirect(['../pidsus/default/viewlaporan','id'=>$idPdsLid]);
        	}
        	else {
        		$_SESSION['cetak']=1; return $this->refresh();   //return $this->redirect(['../pidsus/default/viewreport', 'id'=>$model->id_pds_lid_surat]);
        	}

        } else {
            return $this->render('update', [
                'model' => $model,
                'modelLid' => $modelLid,
            	'modelSuratIsi' => $modelSuratIsi,
            	'modelTembusan'	 =>$modelTembusan,
            	'titleSurat' => $this->titleSurat,

            	'readOnly' => false,
            ]);
        }
    }

	public function getStartDate($jenisSurat){
    	$modelPidsus2=PdsLidSurat::find()->where('id_jenis_surat=\''.$jenisSurat.'\' and id_pds_lid=\''.$_SESSION['idPdsLid'].'\'')->one();
    	return $modelPidsus2->tgl_diterima;
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
    protected function findModel($id,$modelLid,$jenisSurat)
    {
        if (($model = PdsLidSuratforPidsus2::find()->where('id_jenis_surat=\''.$jenisSurat.'\' and id_pds_lid=\''.$id.'\'')->one()) !== null) {
            return $model;
        } else {
            $model= new PdsLidSurat();
			$model->id_pds_lid=$id;
			$model->id_jenis_surat=$jenisSurat;
			$model->id_status=$modelLid->id_status;
			$model->create_by=(string)Yii::$app->user->identity->username;
			$model->create_ip=(string)$_SERVER['REMOTE_ADDR'];
			$model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
		//	$model->perihal_lap='Pemberitahuan tindak lanjut atas laporan/pengaduan .....';
			$model->save();
			return $this->findModel($id,$modelLid,$jenisSurat);
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
