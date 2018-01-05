<?php

namespace app\modules\pdsold\controllers;

use Yii;
use app\models\KpInstSatker;
use app\components\ConstDataComponent;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmMsStatusData;
use app\modules\pdsold\models\PdmLokasiTtd;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
use yii\data\SqlDataProvider;
/**
 * PdmLokasiTtdController implements the CRUD actions for PdmLokasiTtd model.
 */
class PdmLokasiTtdController extends Controller
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
     * Lists all PdmLokasiTtd models.
     * @return mixed
     */
    public function actionIndex()
    {
		$session = new Session();
        $session->remove('id_perkara');
		$session->remove('nomor_perkara');
		$session->remove('tgl_perkara');
		$session->remove('tgl_terima');
$query = "SELECT
  * from pidum.
";
 $jml = Yii::$app->db->createCommand(" select count(*) from (".$query.")a ")->queryScalar();
 $dataProvider =	new SqlDataProvider([
      'sql' => $query,
	  'totalCount' => (int)$jml,
      'sort' => [
          'attributes' => [
		  'pratut',
		  'berkas',
              'no',
              'nama',
              'proses',
              'tgl',
              'surat',
         ],
     ],
      'pagination' => [
          'pageSize' => 10,
      ]
]);
	$models = $dataProvider->getModels();
         return $this->render('index', [
             'searchModel' => $searchModel,
             'dataProvider' => $dataProvider,
         ]);
    }

    /**
     * Displays a single PdmLokasiTtd model.
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
     * Creates a new PdmLokasiTtd model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        
        $session = new Session();
        $id_perkara = $session->get('id_perkara');
        $model = new PdmLokasiTtd();
      // print_r($model);exit;
        if ($model->load(Yii::$app->request->post())) {
             $lokasi=$_POST['PdmLokasiTtd'];
            
		if($model->id == null){
			$model->id='1';	
			$model->lokasi=$lokasi;
			$model->flag='1';
			$model->save();
		//	print_r($model);exit;
		}else 
		{
		$model->lokasi=$lokasi;
		$model->flag='2';
			$model->update();
		print_r($model);exit;
			
              
		}
            
                   
         
             Yii::$app->getSession()->setFlash('success', [
                'type' => 'success',
                'duration' => 3000,
                'icon' => 'fa fa-users',
                'message' => 'Data Berhasil di Simpan',
                'title' => 'Simpan Data',
                'positonY' => 'top',
                'positonX' => 'center',
                'showProgressbar' => true,
            ]);         

            return $this->redirect(['update']);   
            //return $this->redirect(['view', 'id' => $model->id_pratut]);
        } else {
            return $this->render('create', [
                'model' => $model
            ]);
        }
    }

    /**
     * Updates an existing PdmLokasiTtd model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate()
    { 
		$session = new Session();
        $session->remove('id_perkara');
		$session->remove('nomor_perkara');
		$session->remove('tgl_perkara');
		$session->remove('tgl_terima');
		
        
		
        $model = PdmLokasiTtd::find()
		->select("*")
		->from("pidum.lokasi_ttd")
		->one();
		if($model->id == null){
		 $model = new PdmLokasiTtd();
		}
      // print_r($model);exit;
        if ($model->load(Yii::$app->request->post())) {
             $lokasi=$_POST['PdmLokasiTtd'];
            
	
		if($model->id == null){
			
			$model->id='1';	
			$model->lokasi=$lokasi;
			$model->flag='1';
			$model->save();
		//	print_r($model);exit;
		}else 
		{
		$model->lokasi=$lokasi;
		$model->flag='2';
			$model->update();
		//print_r($model);exit;
		}
			
		
			
             
		
            
                   
         
             Yii::$app->getSession()->setFlash('success', [
                'type' => 'success',
                'duration' => 3000,
                'icon' => 'fa fa-users',
                'message' => 'Data Berhasil di Simpan',
                'title' => 'Simpan Data',
                'positonY' => 'top',
                'positonX' => 'center',
                'showProgressbar' => true,
            ]);         

            return $this->redirect(['update']);   
            //return $this->redirect(['view', 'id' => $model->id_pratut]);
        } else {
            return $this->render('create', [
                'model' => $model
            ]);
        }
    }


    /**
     * Deletes an existing PdmLokasiTtd model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
         try{
            $id = $_POST['hapusIndex'];

            if($id == "all"){
                $session = new Session();
                $id_perkara = $session->get('id_perkara');

                PdmLokasiTtd::updateAll(['flag' => '3'], "id_perkara = '" . $id_perkara . "'");
            }else{
                for($i=0;$i<count($id);$i++){
                PdmLokasiTtd::updateAll(['flag' => '3'], "id_pratut = '" . $id[$i] . "'");
                }
            }
            Yii::$app->getSession()->setFlash('success', [
                'type' => 'success',
                'duration' => 3000,
                'icon' => 'fa fa-users',
                'message' => 'Data Berhasil di Hapus',
                'title' => 'Hapus Data',
                'positonY' => 'top',
                'positonX' => 'center',
                'showProgressbar' => true,
            ]);
            return $this->redirect(['index']);
        }catch (Exception $e){
            Yii::$app->getSession()->setFlash('success', [
                        'type' => 'success',
                        'duration' => 3000,
                        'icon' => 'fa fa-users',
                        'message' => 'Data Gagal di Hapus',
                        'title' => 'Hapus Data',
                        'positonY' => 'top',
                        'positonX' => 'center',
                        'showProgressbar' => true,
                    ]);
            return $this->redirect(['index']);
        }
    }

    public function getSatker(){
        $satker = KpInstSatker::find()
                    ->select('inst_satkerkd as id, inst_nama as text')
                   ->where("inst_satkerkd like '".$modelSpdp->id_satker_tujuan."%' or inst_satkerinduk = '".$modelSpdp->id_satker_tujuan."' ORDER BY inst_satkerinduk")
                    ->asArray()
                    ->all();
        if(empty($satker)){ // if satker induk kosong, ganti dengan satker sesuai login
            $satker = KpInstSatker::find()
                        ->select('inst_satkerkd as id, inst_nama as text')
                        ->where(['inst_satkerkd' => Yii::$app->globalfunc->getSatker()->inst_satkerkd])
                        ->asArray()
                        ->all();
        }
        return $satker;
    } 

    /**
     * Finds the PdmLokasiTtd model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmLokasiTtd the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmLokasiTtd::findOne($id)) !== null) {
            return $model;
        } 
    }
    
    
    protected function findModelSpdp($id_perkara)
    { 
        if (($modelSpdp = PdmSpdp::findOne($id_perkara)) !== null) {
			
            return $modelSpdp;
		
        } 
    }
}
