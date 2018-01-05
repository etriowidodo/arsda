<?php

namespace app\modules\pidsus\controllers;

use Yii;
use app\modules\pidsus\models\PdsLid;
use app\modules\pidsus\models\PdsLidSuratSaksi;
use app\modules\pidsus\models\PdsLidSaksi;
use app\modules\pidsus\models\PdsLidTembusan;
use app\modules\pidsus\models\KpPegawai;
use app\modules\pidsus\models\PdsLidSuratforPidsus7Lid;
use app\modules\pidsus\models\PdsLidSurat;
use app\modules\pidsus\models\PdsLidSuratDetail;
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
 * Pidsus9Controller implements the CRUD actions for PdsLidSurat model.
 */
class Pidsus7lidController extends Controller
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
    	if(isset($_SESSION['idPdsLid'])){
    		$idPdsLid=$_SESSION['idPdsLid'];
    	}

    	else{
    		return $this->redirect(['../pidsus/default/index']);
    	}
        //$modelLid = $this->findModelLid($idPdsLid);
        $model = $this->findModel($idPdsLid,'pidsus7lid');
		$modelTembusan= PdsLidTembusan::findBySql('select * from pidsus.select_surat_tembusan(\''.$model->id_pds_lid_surat.'\',\''.Yii::$app->user->id.'\')')->orderby('no_urut')->all();
		$modelSuratIsi= PdsLidSuratIsi::findBySql('select * from pidsus.select_surat_isi(\''.$model->id_pds_lid_surat.'\',\''.Yii::$app->user->id.'\')')->orderby('no_urut')->all();
		$countSuratDetailSaran= Yii::$app->db->createCommand('select count(*) from pidsus.select_surat_detail(\''.$model->id_pds_lid_surat.'\',\''.Yii::$app->user->id.'\') Where tipe_surat_detail=\'Saran\'')->queryScalar();
		$modelSuratDetail=PdsLidSuratDetail::findBySql('select * from pidsus.select_surat_detail(\''.$model->id_pds_lid_surat.'\',\''.Yii::$app->user->id.'\')  order by no_urut,sub_no_urut')->all();

		if(isset($_SESSION['cetak'])){
			$_SESSION['cetak']=null;
			$link = "<script>window.open(\"../pidsus/default/viewreport?id=$model->id_pds_lid_surat\")</script>";
			echo $link;
		}
        if ($model->load(Yii::$app->request->post()) ) {

			if(PdsLidSuratDetail::loadMultiple($modelSuratDetail, Yii::$app->request->post()) && PdsLidSuratDetail::validateMultiple($modelSuratDetail)){
				foreach($modelSuratDetail as $suratDetailRow){
					$suratDetailRow->save();
				}
			}

			if(isset($_POST['modelDetailSaran'])){
				$modelDetailSaran= $_POST['modelDetailSaran'];
			}
			else $modelDetailSaran=null;

			if($modelDetailSaran!=null){
				for ($i = 0; $i < count($modelDetailSaran); $i++) {
					$countSuratDetailSaran++;
					$modelDetailNew= new PdsLidSuratDetail();
					$modelDetailNew->id_pds_lid_surat=$model->id_pds_lid_surat;
					$modelDetailNew->no_urut=1;
					$modelDetailNew->sub_no_urut=$countSuratDetailSaran;
					$modelDetailNew->tipe_surat_detail='Saran';
					$modelDetailNew->isi_surat_detail=$modelDetailSaran[$i];
					$modelDetailNew->save();

				}
			}
			if(isset($_POST['hapus_detail'])){
				for($i = 0; $i < count($_POST['hapus_detail']); $i++){
					PdslidSuratDetail::deleteAll(['id_pds_lid_surat_detail' => $_POST['hapus_detail'][$i]]);
				}
			}

			if(PdsLidTembusan::loadMultiple($modelTembusan, Yii::$app->request->post()) && PdsLidtembusan::validateMultiple($modelTembusan)){
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
        	if(PdsLidSuratIsi::loadMultiple($modelSuratIsi, Yii::$app->request->post()) ){
        		foreach($modelSuratIsi as $row){
        			$row->update_by=Yii::$app->user->identity->username;
        			$row->update_date=date('Y-m-d H:i:s');
        			$row->save();        	
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
        	if ($_POST['btnSubmit']=='simpan'){
        		return $this->redirect(['../pidsus/default/viewlaporan','id'=>$idPdsLid]);
        	}
        	else {
        		$_SESSION['cetak']=1; return $this->refresh();   //return $this->redirect(['../pidsus/default/viewreportlid', 'id'=>$model->id_pds_lid_surat]);
        	}

        } else {
            return $this->render('update', [
                'model' => $model,
            	'modelSuratIsi' => $modelSuratIsi,
				'modelSuratDetail'=>$modelSuratDetail,
            	'modelTembusan'	 =>$modelTembusan,
				'typeSurat' => $model->id_jenis_surat,
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
    protected function findModel($id,$jenisSurat)
    {
        if (($model = PdsLidSuratforPidsus7Lid::find()->where('id_jenis_surat=\''.$jenisSurat.'\' and id_pds_lid=\''.$id.'\'')->one()) !== null) {
            return $model;
        } else {
            $model= new PdsLidSurat();
			$model->id_pds_lid=$id;
			$model->id_jenis_surat=$jenisSurat;
			$model->create_by=(string)Yii::$app->user->identity->username;
			$model->create_ip=(string)$_SERVER['REMOTE_ADDR'];
			$model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
			$model->lampiran_surat='Satu Berkas';
			$model->perihal_lap='Laporan Hasil Ekspose';
			$model->save();
			return $this->findModel($id,$jenisSurat);
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
    	return $model = PdsLidtembusan::find()->where('id_pds_lid_surat=\''.$id.'\'')->orderBy('no_urut')->all();
    }
}
