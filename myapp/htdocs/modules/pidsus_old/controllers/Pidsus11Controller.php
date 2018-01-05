<?php

namespace app\modules\pidsus\controllers;

use Yii;
use app\modules\pidsus\models\PdsLid;
use app\modules\pidsus\models\PdsLidSuratSaksi;
use app\modules\pidsus\models\PdsLidSaksi;
use app\modules\pidsus\models\PdsLidTembusan;
use app\modules\pidsus\models\KpPegawai;
use app\modules\pidsus\models\PdsLidSuratforPidsus11;
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
class Pidsus11Controller extends Controller
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
        $searchModel = new PdsLidSuratSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,'pidsus11',$id);
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'idJenisSurat' => 'pidsus11',
        	'id' => $id,	
        ]);
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
     * Creates a new PdsLidSurat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    //Create new pdslidsurat
    	$model = new PdsLidSurat();
        $model->id_jenis_surat='pidsus11';
        $model->id_pds_lid=$_SESSION['idPdsLid'];
        $model->flag='3';
        $model->create_by=(string)Yii::$app->user->identity->username;
        $model->save();
        //get latest idpdslidsurat
        $model= PdsLidSuratforPidsus11::findBySql("select * from pidsus.pds_lid_surat where id_pds_lid='".$_SESSION['idPdsLid']."' and id_jenis_surat='pidsus11' and create_by='".(string)Yii::$app->user->identity->username."' order by create_date desc limit 1")->one();
        
        return $this->redirect(['update?id='.$model->id_pds_lid_surat]);
    }

    /**
     * Updates an existing PdsLidSurat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
       $model = PdsLidSuratforPidsus11::findOne($id);
       $modelLid = $this->findModelLid($model->id_pds_lid);
       //$modelStatus=Status::findOne($modelLid->id_status);
       $_SESSION['startDatePidsus5c']=new \DateTime($this->getStartDate('pidsus5c'));
       $_SESSION['startDatePidsus5c']=$_SESSION['startDatePidsus5c']->format('d m Y');
       
       $modelSuratIsi= PdsLidSuratIsi::findBySql('select * from pidsus.select_surat_isi(\''.$model->id_pds_lid_surat.'\',\''.Yii::$app->user->id.'\')')->all();
       $modelSuratJaksa=PdsLidSuratJaksa::find()->where(['id_pds_lid_surat'=>$id])->all();
       //$modelJaksa=KpPegawai::findBySql('select * from kepegawaian.kp_pegawai where peg_nik in (select id_jaksa from pidsus.pds_lid_jaksa where id_pds_lid= \''.$_SESSION['idPdsLid'].'\')')->all();
          $modelJaksa=Yii::$app->db->createCommand('select * from pidsus.get_jaksa_p2_grid(\''.$model->id_pds_lid_surat.'\')')->queryAll();
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
       	
	       	$model->update_by=(string)Yii::$app->user->identity->username;
	       	$model->update_date=date('Y-m-d H:i:s');$model->flag='1';
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
	       		return $this->redirect(['index?id='.$modelLid->id_pds_lid]);
	       	}
	       	else {
	       		$_SESSION['cetak']=1; return $this->refresh();   //return $this->redirect(['../pidsus/default/viewreport', 'id'=>$model->id_pds_lid_surat]);
	       	}
       } else {
       	return $this->render('update', [
       			'model' => $model,
       			'modelLid' => $modelLid,
       			'modelSuratIsi' => $modelSuratIsi,
       			'modelJaksa' => $modelJaksa,
       			'modelSuratJaksa' => $modelSuratJaksa,
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
        if (($model = PdsLidSuratforPidsus11::findOne($id)) !== null) {
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
    


    public function getStartDate($jenisSurat){
    	$modelPidsus2=PdsLidSurat::find()->where(['id_jenis_surat'=>$jenisSurat,'id_pds_lid'=>$_SESSION['idPdsLid']])->	orderBy(['tgl_surat'=>SORT_DESC])->one();
    	return $modelPidsus2->tgl_surat;
    }
}
