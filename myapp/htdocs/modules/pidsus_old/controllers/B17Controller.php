<?php

namespace app\modules\pidsus\controllers;

use Yii;
use app\modules\pidsus\models\PdsDik;
use app\modules\pidsus\models\PdsDikTembusan;
use app\modules\pidsus\models\PdsDikSuratforB17;
use app\modules\pidsus\models\PdsDikSurat;
use app\modules\pidsus\models\PdsDikSuratSearch;
use app\modules\pidsus\models\PdsDikSuratIsi;
use app\modules\pidsus\models\PdsDikSuratDetail;
use app\modules\pidsus\models\Pidsus2Search;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * P2Controller implements the CRUD actions for PdsDik model.
 */
class B17Controller extends Controller
{
	public $idJenisSurat='b17';
	public $perihalSurat=' ';
	public $title='B17 -  Surat Ketetapan Pengembalian Barang';
	
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
     * Displays a single PdsDik model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
	
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
    		return $this->redirect(['../pidsus/default/index?type=dik']);
    	}
    
    	$searchModel = new PdsDikSuratSearch();
    	$dataProvider = $searchModel->search2(Yii::$app->request->queryParams, $this->idJenisSurat,$idPdsDik);
    
    	return $this->render('index', [
    			'searchModel' => $searchModel,
    			'idJenisSurat' => $this->idJenisSurat,
    			'dataProvider' => $dataProvider,
    			'titleMain'=>$this->title,
    	]);
    }
    /**
     * Creates a new PdsDik model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
       if(empty($_POST['select_b4'])){
    			return $this->redirect(['index']);
    		}
            $model= new PdsDikSurat();
			$model->id_pds_dik=$_SESSION['idPdsDik'];
			$model->id_jenis_surat=$this->idJenisSurat;
        	$model->id_pds_dik_surat_parent=$_POST['select_b4'];
			$model->create_by=(string)Yii::$app->user->identity->username;
			$model->create_ip=(string)$_SERVER['REMOTE_ADDR'];
			$model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
			$model->perihal_lap=$this->perihalSurat;
			$model->save();
			
			return $this->redirect(['update','id'=>$model->id_pds_dik_surat]);  
    }

    /**
     * Updates an existing PdsDik model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {	
    	$idPdsDik=$_SESSION['idPdsDik'];
        $modelDik = $this->findModelDik($idPdsDik);
        $model = $this->findModel($id);
		$_SESSION['startDateB17']= date('d m Y', strtotime('-3 months'));
    	 $_SESSION['endDateB17']=date('d m Y');
		$modelTembusan= PdsDikTembusan::findBySql('select * from pidsus.select_surat_tembusan_dik(\''.$model->id_pds_dik_surat.'\',\''.Yii::$app->user->id.'\')')->orderby('no_urut')->all();
		$modelSuratIsi= PdsDikSuratIsi::findBySql('select * from pidsus.select_surat_isi_dik(\''.$model->id_pds_dik_surat.'\',\''.Yii::$app->user->id.'\')')->all();
        $countSuratDetailMembaca= Yii::$app->db->createCommand('select count(*) from pidsus.select_surat_detail_dik(\''.$model->id_pds_dik_surat.'\',\''.Yii::$app->user->id.'\') Where tipe_surat_detail=\'Membaca\'')->queryScalar();
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

            if(isset($_POST['modelDetailMembaca'])){
                $modelDetailMembaca= $_POST['modelDetailMembaca'];
            }
            else $modelDetailMembaca=null;

            if($modelDetailMembaca!=null){
                for ($i = 0; $i < count($modelDetailMembaca); $i++) {
                    $countSuratDetailMembaca++;
                    $modelDetailNew= new PdsDikSuratDetail();
                    $modelDetailNew->id_pds_dik_surat=$model->id_pds_dik_surat;
                    $modelDetailNew->no_urut=1;
                    $modelDetailNew->sub_no_urut=$countSuratDetailMembaca;
                    $modelDetailNew->tipe_surat_detail='Membaca';
                    $modelDetailNew->isi_surat_detail=$modelDetailMembaca[$i];
                    $modelDetailNew->save();

                }
            }

            if(isset($_POST['hapus_detail'])){
                for($i = 0; $i < count($_POST['hapus_detail']); $i++){
                    PdsdikSuratDetail::deleteAll(['id_pds_dik_surat_detail' => $_POST['hapus_detail'][$i]]);
                }
            }


            if(PdsDikTembusan::loadMultiple($modelTembusan, Yii::$app->request->post()) && PdsDikTembusan::validateMultiple($modelTembusan)){
        		$noUrutTembusan=1;foreach($modelTembusan as $row){$row->no_urut=$noUrutTembusan;$noUrutTembusan++;
        			$row->update_by=Yii::$app->user->identity->username;
        			$row->update_date=date('Y-m-d H:i:s');
        			$row->save();        	
        		}
        	}
        	if(PdsDikSuratIsi::loadMultiple($modelSuratIsi, Yii::$app->request->post()) ){
        		foreach($modelSuratIsi as $row){
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
        	$model->update_by=(string)Yii::$app->user->identity->username;
        	$model->update_date=date('Y-m-d H:i:s');$model->flag='1';
			$model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
        	$model->save();
        	//echo $model->id_status;
        	$modelDik = $this->findModelDik($idPdsDik);
        	$modelDik->update_by=(string)Yii::$app->user->identity->username;
			$modelDik->update_ip=(string)$_SERVER['REMOTE_ADDR'];
        	$modelDik->update_date=date('Y-m-d H:i:s');$modelDik->flag='1';
        	$modelDik->id_status=$model->id_status;
        	$modelDik->save();
        	if ($_POST['btnSubmit']=='simpan'){
        		return $this->redirect(['../pidsus/default/viewlaporandik','id'=>$idPdsDik]);
        	}
        	else {
        		$_SESSION['cetak']=1; return $this->refresh();   //return $this->redirect(['../pidsus/default/viewreportdik', 'id'=>$model->id_pds_dik_surat]);
        	}

        } else {
            return $this->render('update', [
                'model' => $model,
                'modelDik' => $modelDik,
            	'modelSuratIsi' => $modelSuratIsi,
                'modelSuratDetail' => $modelSuratDetail,
            	'modelTembusan'	 =>$modelTembusan,
            	'readOnly' => false,
            ]);
        }
    }

    /**
     * Deletes an existing PdsDik model.
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
     * Finds the PdsDik model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdsDik the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdsDikSuratforB17::find()->where(['id_pds_dik_surat'=>$id])->one()) !== null) {
            return $model;
        } else {
        	return $this->redirect(['index']);
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
