<?php

namespace app\modules\pidsus\controllers;

use Yii;
use app\modules\pidsus\models\PdsDik;
use app\modules\pidsus\models\PdsDikTembusan;
use app\modules\pidsus\models\PdsDikSuratforPidsus7Dik;
use app\modules\pidsus\models\PdsDikSurat;
use app\modules\pidsus\models\PdsDikSuratIsi;
use app\modules\pidsus\models\PdsDikSuratDetail;
use app\modules\pidsus\models\Pidsus2Search;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Pidsus9Controller implements the CRUD actions for PdsLidSurat model.
 */
class Pidsus7dikController extends Controller
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
        $model = new PdsDik();
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_pds_dik]);
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
        $model = $this->findModel($idPdsDik,'pidsus7dik');
		$modelTembusan= PdsDikTembusan::findBySql('select * from pidsus.select_surat_tembusan_dik(\''.$model->id_pds_dik_surat.'\',\''.Yii::$app->user->id.'\')')->orderby('no_urut')->all();
		$modelSuratIsi= PdsDikSuratIsi::findBySql('select * from pidsus.select_surat_isi_dik(\''.$model->id_pds_dik_surat.'\',\''.Yii::$app->user->id.'\')')->all();
		$countSuratDetailSaran= Yii::$app->db->createCommand('select count(*) from pidsus.select_surat_detail_dik(\''.$model->id_pds_dik_surat.'\',\''.Yii::$app->user->id.'\') Where tipe_surat_detail=\'Saran\'')->queryScalar();
		$modelSuratDetail=PdsdikSuratDetail::findBySql('select * from pidsus.select_surat_detail_dik(\''.$model->id_pds_dik_surat.'\',\''.Yii::$app->user->id.'\')  order by no_urut,sub_no_urut')->all();

		if(isset($_SESSION['cetak'])){
			$_SESSION['cetak']=null;
			$link = "<script>window.open(\"../pidsus/default/viewreportdik?id=$model->id_pds_dik_surat\")</script>";
			echo $link;
		}
        if ($model->load(Yii::$app->request->post()) ) {

			if(PdsDikSuratDetail::loadMultiple($modelSuratDetail, Yii::$app->request->post()) && PdsDikSuratDetail::validateMultiple($modelSuratDetail)){
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
					$modelDetailNew= new PdsDikSuratDetail();
					$modelDetailNew->id_pds_dik_surat=$model->id_pds_dik_surat;
					$modelDetailNew->no_urut=1;
					$modelDetailNew->sub_no_urut=$countSuratDetailSaran;
					$modelDetailNew->tipe_surat_detail='Saran';
					$modelDetailNew->isi_surat_detail=$modelDetailSaran[$i];
					$modelDetailNew->save();

				}
			}
			if(isset($_POST['hapus_detail'])){
				for($i = 0; $i < count($_POST['hapus_detail']); $i++){
					PdsdikSuratDetail::deleteAll(['id_pds_dik_surat_detail' => $_POST['hapus_detail'][$i]]);
				}
			}

			if(PdsDikTembusan::loadMultiple($modelTembusan, Yii::$app->request->post()) && PdsDiktembusan::validateMultiple($modelTembusan)){
        		foreach($modelTembusan as $row){
        			$row->update_by=Yii::$app->user->identity->username;
        			$row->update_date=date('Y-m-d H:i:s');
        			$row->save();        	
        		}
        	}
        	if(isset($_POST['new_tembusan'])){
        		for($i = 0; $i < count($_POST['new_tembusan']); $i++){
	        		$modelNewTembusan= new PdsDiktembusan();
	        		$modelNewTembusan->id_pds_dik_surat=$model->id_pds_dik_surat;
	        		$modelNewTembusan->no_urut=$_POST['new_no_urut'][$i];
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
				'modelSuratDetail'=>$modelSuratDetail,
            	'modelTembusan'	 =>$modelTembusan,
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
        if (($model = PdsDikSuratforPidsus7Dik::find()->where('id_jenis_surat=\''.$jenisSurat.'\' and id_pds_dik=\''.$id.'\'')->one()) !== null) {
            return $model;
        } else {
            $model= new PdsDikSurat();
			$model->id_pds_dik=$id;
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
    	return $model = PdsDiktembusan::find()->where('id_pds_dik_surat=\''.$id.'\'')->orderBy('no_urut')->all();
    }
}
