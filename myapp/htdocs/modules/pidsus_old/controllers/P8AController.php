<?php

namespace app\modules\pidsus\controllers;

use Yii;
use app\modules\pidsus\models\PdsDikRendik;
use app\modules\pidsus\models\PdsDikRendikforP8A;
use app\modules\pidsus\models\PdsDikSurat;
use app\modules\pidsus\models\PdsDikRendikSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * P8AController implements the CRUD actions for PdsDikRendik model.
 */
class P8aController extends Controller
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
     * Lists all PdsDikRendik models.
     * @return mixed
     */
    public function actionIndex()
    {	
    /*	if(isset($_POST['btnSubmit'])){
    		if($_POST['noLap']!==''){
    			$whereQuery=$whereQuery."lower(no_surat) like lower('%".$_POST['noLap']."%')";
    			//echo $whereQuery;
    		}
    		if($_POST['startDate']!=='' && $_POST['endDate']!==''){
    			if($whereQuery!=='') $whereQuery=$whereQuery.' AND ';
    			$whereQuery=$whereQuery."(tgl_surat between '".$_POST['startDate']."' and '".$_POST['endDate']."')";
    	
    		}
    		else if($_POST['startDate']=='' && $_POST['endDate']!==''){
    			if($whereQuery!=='') $whereQuery=$whereQuery.' AND ';
    			$whereQuery=$whereQuery."tgl_surat <= '".$_POST['endDate']."'";
    	
    		}
    		else if($_POST['startDate']!=='' && $_POST['endDate']==''){
    			if($whereQuery!=='') $whereQuery=$whereQuery.' AND ';
    			$whereQuery=$whereQuery."tgl_surat >= '".$_POST['startDate']."'";
    	
    		}
    		if($_POST['asalSurat']){
    			if($whereQuery!=='') $whereQuery=$whereQuery.' AND ';
    			$whereQuery=$whereQuery."lower(lokasi_surat) like lower('%".$_POST['asalSurat']."%')";
    	
    		}
    		if($whereQuery!=="") $whereQuery=' WHERE '.$whereQuery;
    		//print_r($_POST);
    		//echo $whereQuery;
    		//die;
    	}*/
       // $modelSurat=$this-> findModelSurat($_SESSION['idPdsDik']);
       if ($modelSurat->id_pds_dik_surat == null){
           $modelSurat=$this-> findModelSurat($_SESSION['idPdsDik']);

    }

        $modelSurat=$this-> findModelSurat($_SESSION['idPdsDik']);
		$_SESSION['idPdsDikSurat8A']=$modelSurat->id_pds_dik_surat;
        $searchModel = new PdsDikRendikSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$modelSurat->id_pds_dik_surat);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        	'modelSurat' =>$modelSurat,	
        ]);
    }

    /**
     * Displays a single PdsDikRendik model.
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
     * Creates a new PdsDikRendik model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(isset($_SESSION['idPdsLid'])){
            $idPdsLid=$_SESSION['idPdsLid'];
          //  $idPdsLid ="0901002015000010";
            $kasusPosisi = Yii::$app->db->createCommand("select pidsus.get_value_surat_isi2('".$idPdsLid."' ,'p5',cast(5 as smallint),'lid') as kasus")->queryOne();
            $kasusPosisi2 = $kasusPosisi['kasus'];
        } else {
            $kasusPosisi ="";
        }
        $model = new PdsDikRendikforP8A();

        if ($model->load(Yii::$app->request->post())) {
        	$model->id_pds_dik_surat=$_SESSION['idPdsDikSurat8A'];
        	$model->create_by=(string)Yii::$app->user->identity->username; 
        	$model->flag='1';
        	$model->save();

        	$modelSurat=$this-> findModelSurat($_SESSION['idPdsDik']);
        	$modelSurat->update_by=(string)Yii::$app->user->identity->username;
        	$modelSurat->update_date=date('Y-m-d H:i:s');
        	$modelSurat->flag='1';
            $modelSurat->update_ip=(string)$_SERVER['REMOTE_ADDR'];
        	$modelSurat->save();
        	//print_r($model->getErrors());die();
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                $model->kasus_posisi = $kasusPosisi2
            ]);
        }
    }

    /**
     * Updates an existing PdsDikRendik model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelSurat = PdsDikSurat::findOne($model->id_pds_dik_surat);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	$model->update_by=(string)Yii::$app->user->identity->username;
        	$model->update_date=date('Y-m-d H:i:s');$model->flag='1';
            $model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
            $model->save();
            $modelSurat->update_by=Yii::$app->user->identity->username;
            $modelSurat->update_date=date('Y-m-d H:i:s');$modelSurat->flag='1';
            $modelSurat->update_ip=(string)$_SERVER['REMOTE_ADDR'];
            $modelSurat->save();
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PdsDikRendik model.
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
     * Finds the PdsDikRendik model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdsDikRendik the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdsDikRendikforP8A::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    

    protected function findModelSurat($id)
    {
    	if (($model = PdsDikSurat::find()->where('id_jenis_surat=\'p8a\' and id_pds_dik=\''.$id.'\'')->one()) !== null) {
    		return $model;
    	} else {
    		$model = new PdsDikSurat();
    		$model->id_pds_dik=$id;
    		$model->id_jenis_surat='p8a';
    		$model->save();
    		$this->findModelSurat($id);
    	}
    }
    
    public function actionDeletebatchsurat(){
    	$id_pds_rendik=$_POST['hapusPds'];
    	for($i=0;$i<count($id_pds_rendik);$i++){
    		$model=PdsDikRendik::findOne($id_pds_rendik[$i]);
    		$model->flag='3';
    		$model->save();
    		//print_r($model->getErrors());die();
    
    	}
    	return $this->redirect('/pidsus/p8a');
    }
}
