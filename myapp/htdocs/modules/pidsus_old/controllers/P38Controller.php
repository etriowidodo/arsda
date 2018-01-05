<?php

namespace app\modules\pidsus\controllers;

use Yii;
use app\modules\pidsus\models\PdsTut;
use app\modules\pidsus\models\PdsTutTembusan;
use app\modules\pidsus\models\PdsTutSuratforP38;
use app\modules\pidsus\models\PdsTutSurat;
use app\modules\pidsus\models\PdsTutSuratPanggilan;
use app\modules\pidsus\models\PdsTutSuratIsi;
use app\modules\pidsus\models\Pidsus2Search;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pidsus\models\app\modules\pidsus\models;

/**
 * P2Controller implements the CRUD actions for PdsLid model.
 */
class P38Controller extends Controller
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
        $model = new PdsTut();
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_pds_tut]);
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
    	if(isset($_SESSION['idPdsTut'])){
    		$idPdsTut=$_SESSION['idPdsTut'];
    	}
    	else if (isset($_SESSION['idPdsDik'])){
    		$modelPdsTut=PdsTut::find()->where(['id_pds_dik_parent'=>$_SESSION['idPdsDik']])->one();
    		$idPdsTut=$modelPdsTut->id_pds_tut;
    	}
    	else{
    		return $this->redirect(['../pidsus/default/index']);
    	}
        //$modelLid = $this->findModelLid($idPdsDik);
        $model = $this->findModel($idPdsTut,'p38');
        $_SESSION['idPdsTutSurat'] =$model->id_pds_tut_surat;
		$modelTembusan= PdsTutTembusan::findBySql('select * from pidsus.select_surat_tembusan_tut(\''.$model->id_pds_tut_surat.'\',\''.Yii::$app->user->id.'\')')->orderby('no_urut')->all();
		$modelSuratIsi= PdsTutSuratIsi::findBySql('select * from pidsus.select_surat_isi_tut(\''.$model->id_pds_tut_surat.'\',\''.Yii::$app->user->id.'\')')->all();
        $modelPanggilan = PdsTutSuratPanggilan::find()->where(['id_pds_tut_surat'=>$model->id_pds_tut_surat,flag=>"1"])->all();
        if(isset($_SESSION['cetak'])){
            $_SESSION['cetak']=null;
            $link = "<script>window.open(\"../pidsus/tut/viewreporttut?id=$model->id_pds_tut_surat\")</script>";
            echo $link;
        }

        if ($model->load(Yii::$app->request->post()) ) { 

        	if(PdsTutTembusan::loadMultiple($modelTembusan, Yii::$app->request->post()) && PdsTuttembusan::validateMultiple($modelTembusan)){
        		$noUrutTembusan=1;foreach($modelTembusan as $row){$row->no_urut=$noUrutTembusan;$noUrutTembusan++;
        			$row->update_by=Yii::$app->user->identity->username;
        			$row->update_date=date('Y-m-d H:i:s');
        			$row->save();        	
        		}
        	}
        	if(isset($_POST['new_tembusan'])){
        		for($i = 0; $i < count($_POST['new_tembusan']); $i++){
	        		$modelNewTembusan= new PdsTuttembusan();
	        		$modelNewTembusan->id_pds_tut_surat=$model->id_pds_tut_surat;
	        		$modelNewTembusan->no_urut=$noUrutTembusan;$noUrutTembusan++;
	        		$modelNewTembusan->tembusan=$_POST['new_tembusan'][$i];
					$modelNewTembusan->create_by=(string)Yii::$app->user->identity->username;
					$modelNewTembusan->save();
        		}
        	}
        	if(PdsTutSuratIsi::loadMultiple($modelSuratIsi, Yii::$app->request->post()) ){
        		foreach($modelSuratIsi as $row){
        			$row->update_by=Yii::$app->user->identity->username;
        			$row->update_date=date('Y-m-d H:i:s');
        			$row->save();        	
        		}
        	}
        	if(isset($_POST['hapus_tembusan'])){
        		for($i=0; $i<count($_POST['hapus_tembusan']);$i++){
        			PdsTuttembusan::deleteAll(['id_pds_tut_tembusan' => $_POST['hapus_tembusan'][$i]]);
        		}
        	}
        	$model->update_by=(string)Yii::$app->user->identity->username;
        	$model->update_date=date('Y-m-d H:i:s');$model->flag='1';
			$model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
        	$model->save();

            if ($_POST['btnSubmit']=='simpan'){
                return $this->redirect(['../pidsus/tut/viewlaporantut','id'=>$idPdsTut]);
            }
            else {
                $_SESSION['cetak']=1; return $this->refresh();   //return $this->redirect(['../pidsus/default/viewreportdik', 'id'=>$model->id_pds_dik_surat]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            	'modelSuratIsi' => $modelSuratIsi,
            	'modelTembusan'	 =>$modelTembusan,
            	'modelPanggilan' =>$modelPanggilan,	
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
        if (($model = PdsTutSuratforP38::find()->where('id_jenis_surat=\''.$jenisSurat.'\' and id_pds_tut=\''.$id.'\'')->one()) !== null) {
            return $model;
        } else {
            $model= new PdsTutSurat();
			$model->id_pds_tut=$id;
			$model->id_jenis_surat=$jenisSurat;
			$model->create_by=(string)Yii::$app->user->identity->username;
			$model->create_ip=(string)$_SERVER['REMOTE_ADDR'];
			$model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
			$model->perihal_lap='Bantuan Pemanggilan Saksi Ahli/Terdakwa/Terpidana';
			$model->save();
			return $this->findModel($id,$jenisSurat);
        }
    }
    protected function findModelTut($id)
    {
    	if (($modelLid = PdsTut::findOne($id)) !== null) {
    		return $modelLid;
    	} else {
    		throw new NotFoundHttpException('The requested page does not exist.');
    	}
    }
    protected function findModelTembusan($id)
    {
    	return $model = PdsTuttembusan::find()->where('id_pds_tut_surat=\''.$id.'\'')->orderBy('no_urut')->all();
    }
    
    public function actionShowTerpanggil()
    {
    	$modelSuratPanggilan = new PdsTutSuratPanggilan();
    
    	if ($modelSuratPanggilan->load(Yii::$app->request->post()) ) {
    		$modelSuratPanggilan->id_pds_tut_surat = $idPdsDik=$_SESSION['idPdsTutSurat'];
    		$modelSuratPanggilan->create_by=(string)Yii::$app->user->identity->username;
    		$modelSuratPanggilan->create_date=date('Y-m-d H:i:s');
    		$modelSuratPanggilan->flag="1"; 
    		$selectedTerpanggil=Yii::$app->db->createCommand("select * from pidsus.get_list_terdakwa_saksi_tut_ddl('".$_SESSION["idPdsTutSurat"]."') WHERE id_pds_tut_tersangka =	'".$modelSuratPanggilan->id_terpanggil."'")->queryOne();
    		$modelSuratPanggilan->nama_terpanggil=$selectedTerpanggil["nama_tersangka"];
    		$modelSuratPanggilan->save();
    		$data['id_pds_tut_surat_panggilan'] = $modelSuratPanggilan->id_pds_tut_surat_panggilan;
    		$data['nama_terpanggil']=$modelSuratPanggilan->nama_terpanggil;
    		echo json_encode($data);
    		//print_r($model->getErrors());
    	}
    	else {
    		return $this->renderAjax('_popTerpanggil', [
    				'modelSuratPanggilan' => $modelSuratPanggilan
    		]);
    	}
    	/*$searchModel = new PdsDikSuratPanggilanSearch();
    	 $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$_SESSION['idPdsDik']);
    	 $dataProvider->pagination->pageSize=10;
    	 return $this->renderAjax('_listSuratPanggilandik', [
    	 'searchModel' => $searchModel,
    	 'dataProvider' => $dataProvider,
    	 ]);*/
    }
    public function actionEditTerpanggil($id)
    {
    	$modelSuratPanggilan = PdsTutSuratPanggilan::find()->where(['id_pds_tut_surat_panggilan'=>$id])->one();
    
    	if ($modelSuratPanggilan->load(Yii::$app->request->post()) ) {
    		$modelSuratPanggilan->id_pds_tut_surat = $idPdsDik=$_SESSION['idPdsTutSurat'];
    		$modelSuratPanggilan->create_by=(string)Yii::$app->user->identity->username;
    		$modelSuratPanggilan->create_date=date('Y-m-d H:i:s');
    		$modelSuratPanggilan->flag="1"; 
    		$selectedTerpanggil=Yii::$app->db->createCommand("select * from pidsus.get_list_terdakwa_saksi_tut_ddl('".$_SESSION["idPdsTutSurat"]."') WHERE id_pds_tut_tersangka =	'".$modelSuratPanggilan->id_terpanggil."'")->queryOne();
    		$modelSuratPanggilan->nama_terpanggil=$selectedTerpanggil["nama_tersangka"];
    		$modelSuratPanggilan->save();
    		//echo json_encode($modelSuratPanggilan->id_pds_dik_SuratPanggilan);
    		//print_r($model->getErrors());
    	}
    	else {
    		return $this->renderAjax('_popTerpanggilEdit', [
    				'modelSuratPanggilan' => $modelSuratPanggilan
    		]);
    	}
    	/*$searchModel = new PdsDikSuratPanggilanSearch();
    	 $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$_SESSION['idPdsDik']);
    	 $dataProvider->pagination->pageSize=10;
    	 return $this->renderAjax('_listSuratPanggilandik', [
    	 'searchModel' => $searchModel,
    	 'dataProvider' => $dataProvider,
    	 ]);*/
    }
    
    public function actionDeleteTerpanggil($id){
    	$modelSuratPanggilan = PdsTutSuratPanggilan::find()->where(['id_pds_tut_surat_panggilan'=>$id])->one();
    	$modelSuratPanggilan->flag='3';
    	$modelSuratPanggilan->update_by=(string)Yii::$app->user->identity->username;
    	$modelSuratPanggilan->update_date=date('Y-m-d H:i:s');
    	$modelSuratPanggilan->save();
    
    	//print_r($modelSuratPanggilan->getErrors());
    }
}
