<?php

namespace app\modules\pdsold\controllers;

use Yii;
use app\models\KpInstSatker;
use app\components\ConstDataComponent;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmMsStatusData;
use app\modules\pdsold\models\PdmPratutPutusan;
use app\modules\pdsold\models\PdmPratutPutusanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
use yii\data\SqlDataProvider;
/**
 * PdmPratutPutusanController implements the CRUD actions for PdmPratutPutusan model.
 */
class PdmPratutPutusanController extends Controller
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
     * Lists all PdmPratutPutusan models.
     * @return mixed
     */
    public function actionIndex()
    {
		
		   $id_perkara = Yii::$app->session->get('id_perkara');

        // no need index page so redirect to update
       // return $this->redirect(['update']);
        // $searchModel = new PdmPratutPutusanSearch();
       // $id_perkara = Yii::$app->session->get('id_perkara');
        // $dataProvider = $searchModel->search($id_perkara, Yii::$app->request->queryParams);
$query = "SELECT
  a.no_pengiriman as no,
   string_agg (C .nama, ', ') as nama,
		d.is_proses as proses,
		a.tgl_pengiriman as tgl,
		 d.tgl_surat as surat,
		 d.id_pratut as pratut,
a.id_berkas as berkas
FROM
   pidum.pdm_berkas a

left join pidum.pdm_tahanan_penyidik b on a.id_berkas = b.id_berkas
left join pidum.ms_tersangka c on b.id_tersangka = c.id_tersangka
left JOIN pidum.pdm_pratut_putusan d ON d.id_berkas = a.id_berkas
where b.id_berkas is not null and b.flag <> '3' and a.flag <> '3' and a.id_perkara = '".$id_perkara."'
GROUP BY a.id_berkas,d.is_proses,d.tgl_surat,d.id_pratut
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
     * Displays a single PdmPratutPutusan model.
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
     * Creates a new PdmPratutPutusan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        
        $session = new Session();
        $id_perkara = $session->get('id_perkara');
        $model = new PdmPratutPutusan();
         $pengadilan = PdmMsStatusData::find()
                        ->where(['is_group' => 'PRATT'])
                        ->asArray()
                        ->all();
			//			print_r($pengadilan);exit;
        $modelSpdp = $this->findModelSpdp($id_perkara);

$satker =\Yii::$app->globalfunc->getSatker()->inst_satkerkd;
//echo $satker;exit;
        if ($model->load(Yii::$app->request->post())) {
             $id_berkas2=$_POST['idberkas2'];
            $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_pratut_putusan', 'id_pratut', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();
			//print_r($id_berkas2);exit;
			 $id_satker_tujuan = $_POST['PdmSpdp']['id_satker_tujuan'];
			//print_r($id_satker_tujuan);exit;
			$tglselesai =$_POST['tgl_penyelesaian-disp'];
		if($model->id_perkara != null){
			$model->flag='1';	
			$model->id_berkas=$id_berkas2;
			$model->save();
		}else if ($model->id_perkara == null and !empty($id_satker_tujuan)){
			$model->id_perkara = $id_perkara;
			$model->id_pratut = $seq['generate_pk'];
			$model->id_berkas=$id_berkas2;
			//$model->no_surat = NULL;
          //  $model->tgl_surat = NULL;
			print_r($model);exit;
			$model->save();
			$modelSpdp1 = $modelSpdp;
                $modelSpdp1->id_satker_tujuan = $id_satker_tujuan;
			 
			//print_r($modelSpdp1);exit;
                if(!$modelSpdp1->update()){
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'danger', //String, can only be set to danger, success, warning, info, and growl
                        'duration' => 3000, //Integer //3000 default. time for growl to fade out.
                        'icon' => 'glyphicon glyphicon-ok-sign', //String
                        'message' => 'Data Gagal Disimpan', // String
                        'title' => 'Save', //String
                        'positonY' => 'top', //String // defaults to top, allows top or bottom
                        'positonX' => 'center', //String // defaults to right, allows right, center, left
                        'showProgressbar' => true,
                    ]);
                    return $this->redirect(['index']);   
			}
		}else 
		{
			$model->id_perkara = $id_perkara;
			$model->id_pratut = $seq['generate_pk'];
			$model->id_berkas=$id_berkas2;
		
		//print_r($model);exit;
			$model->save();
			  $modelSpdp1 = $modelSpdp;
                $modelSpdp1->id_satker_tujuan = NULL;

                if(!$modelSpdp1->update()){
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'danger', //String, can only be set to danger, success, warning, info, and growl
                        'duration' => 3000, //Integer //3000 default. time for growl to fade out.
                        'icon' => 'glyphicon glyphicon-ok-sign', //String
                        'message' => 'Data Gagal Disimpan', // String
                        'title' => 'Save', //String
                        'positonY' => 'top', //String // defaults to top, allows top or bottom
                        'positonX' => 'center', //String // defaults to right, allows right, center, left
                        'showProgressbar' => true,
                    ]);
                    return $this->redirect(['index']);   
                }
		}
            
                   
           
         /*   if (!empty($id_satker_tujuan)) {
                $model->no_surat = NULL;
                $model->tgl_surat = NULL;
				$model->id_berkas=$id_berkas2;
				//print_r($model);exit;
                $model->save();

                $modelSpdp1 = $modelSpdp;
                $modelSpdp1->id_satker_tujuan = $id_satker_tujuan;
			//	print_r($modelSpdp1);exit;
                if(!$modelSpdp1->update()){
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'danger', //String, can only be set to danger, success, warning, info, and growl
                        'duration' => 3000, //Integer //3000 default. time for growl to fade out.
                        'icon' => 'glyphicon glyphicon-ok-sign', //String
                        'message' => 'Data Gagal Disimpan', // String
                        'title' => 'Save', //String
                        'positonY' => 'top', //String // defaults to top, allows top or bottom
                        'positonX' => 'center', //String // defaults to right, allows right, center, left
                        'showProgressbar' => true,
                    ]);
                    return $this->redirect(['index']);   
                }
            }else{
                $modelSpdp1 = $modelSpdp;
                $modelSpdp1->id_satker_tujuan = NULL;

                if(!$modelSpdp1->update()){
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'danger', //String, can only be set to danger, success, warning, info, and growl
                        'duration' => 3000, //Integer //3000 default. time for growl to fade out.
                        'icon' => 'glyphicon glyphicon-ok-sign', //String
                        'message' => 'Data Gagal Disimpan', // String
                        'title' => 'Save', //String
                        'positonY' => 'top', //String // defaults to top, allows top or bottom
                        'positonX' => 'center', //String // defaults to right, allows right, center, left
                        'showProgressbar' => true,
                    ]);
                    return $this->redirect(['index']);   
                }
            }*/        
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

            return $this->redirect(['index']);   
            //return $this->redirect(['view', 'id' => $model->id_pratut]);
        } else {
            return $this->render('create', [
                'model' => $model,
				'satker'=> $satker,
                'modelSpdp'=>$modelSpdp,
				'pengadilan'=>$pengadilan,
				'id_berkas'=>$id_berkas
            ]);
        }
    }

    /**
     * Updates an existing PdmPratutPutusan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id_pratut,$id_berkas)
    {
		if($_GET['id_pratut']=="undefined"){
			//$this->actionCreate($id_berkas);
			$this->redirect(['create','id_berkas'=>$id_berkas]);
		}else {
        $session = new Session();
        $id_perkara = $session->get('id_perkara');
$satker =\Yii::$app->globalfunc->getSatker()->inst_satkerkd;
	    $model = PdmPratutPutusan::findOne(['id_pratut'=>$id_pratut]);
        $modelSpdp = $this->findModelSpdp($id_perkara);
			//print_r($modelSpdp);exit;
	   //$modelSpdp =  PdmSpdp::find()
	   //->select("a.id_perkara as id_perkara,a.id_satker_tujuan as id_satker_tujuan,b.inst_nama as nama")
	   //->from("pidum.pdm_spdp a ")
	   //->join('INNER JOIN', 'kepegawaian.kp_inst_satker b' , 'a.id_satker_tujuan = b.inst_satkerkd')
	   //->where("a.id_perkara='". $id_perkara."'")
	   //->all();
//print_r($modelSpdp->id_satker_tujuan);exit;
        $pengadilan = PdmMsStatusData::find()
                        ->where(['is_group' => ConstDataComponent::Pratut])
                        ->asArray()
                        ->all();
				$satkerPelimpahan2=kpinstsatker::find()
					->where("inst_satkerkd like '".$modelSpdp->id_satker_tujuan."%' or inst_satkerinduk = '".$modelSpdp->id_satker_tujuan."' ORDER BY inst_satkerinduk")->all();
					//print_r ($satkerPelimpahan2);exit;
//("select inst_nama from kepegawaian.kp_inst_satker where inst_satkerkd like '".$modelSpdp->id_satker_tujuan."%'")
	//		->queryone();
			
			//print_r ($satkerPelimpahan2);exit;
        if($model == null){
            $model = new PdmPratutPutusan();
        }
   $id_berkas=$_POST['idberkas'];
        if ($model->load(Yii::$app->request->post())) {
                     $id_satker_tujuan = $_POST['PdmSpdp']['id_satker_tujuan'];
            $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_pratut_putusan', 'id_pratut', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();
            
            if($model->id_perkara != null and $id_satker_tujuan == null){
                $model->flag='2'; 
				$model->id_berkas = $id_berkas;	
			//print_r($model);exit;	
                $model->update();
            }elseif (!empty($id_satker_tujuan) and $model->id_perkara != null) {

			  $model->no_surat = NULL;
                $model->tgl_surat = NULL;
				$model->id_berkas = $id_berkas;	
		
                $model->update();

                $modelSpdp1 = $modelSpdp;
                	$modelSpdp1->id_satker_tujuan = $id_satker_tujuan;
				//		print_r($model);
				 //  print_r($id_satker_tujuan);       
				//print_r($model->id_perkara);
		//	print_r($modelSpdp1->id_satker_tujuan);exit;
                if(!$modelSpdp1->update()){
					//$modelSpdp1->getErrors();exit;
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'danger', //String, can only be set to danger, success, warning, info, and growl
                        'duration' => 3000, //Integer //3000 default. time for growl to fade out.
                        'icon' => 'glyphicon glyphicon-ok-sign', //String
                        'message' => 'Data Gagal Disimpan', // String
                        'title' => 'Save', //String
                        'positonY' => 'top', //String // defaults to top, allows top or bottom
                        'positonX' => 'center', //String // defaults to right, allows right, center, left
                        'showProgressbar' => true,
                    ]);
                    return $this->redirect(['index']);   
                }
            }else{
                $modelSpdp1 = $modelSpdp;
                $modelSpdp1->id_satker_tujuan = NULL;

                if(!$modelSpdp1->update()){
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'danger', //String, can only be set to danger, success, warning, info, and growl
                        'duration' => 3000, //Integer //3000 default. time for growl to fade out.
                        'icon' => 'glyphicon glyphicon-ok-sign', //String
                        'message' => 'Data Gagal Disimpan', // String
                        'title' => 'Save', //String
                        'positonY' => 'top', //String // defaults to top, allows top or bottom
                        'positonX' => 'center', //String // defaults to right, allows right, center, left
                        'showProgressbar' => true,
                    ]);
                    return $this->redirect(['index']);   
                }
            }

            //notifikasi simpan
            Yii::$app->getSession()->setFlash('success', [
                'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
                'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                'icon' => 'glyphicon glyphicon-ok-sign', //String
                'message' => 'Data Berhasil Disimpan', // String
                'title' => 'Save', //String
                'positonY' => 'top', //String // defaults to top, allows top or bottom
                'positonX' => 'center', //String // defaults to right, allows right, center, left
                'showProgressbar' => true,
            ]);
            return $this->redirect(['index']);   
           // return $this->redirect(['update', 'id_pratut' => $model->id_pratut]);
        } else {
            return $this->render('update', [
                'model' => $model,
				'satker'=>$satker,
                'modelSpdp'=>$modelSpdp,
                'pengadilan' => $pengadilan,
				'satkerPelimpahan2'=>$satkerPelimpahan2
            ]);
        }
		}
    }

  /*  public function actionUpdate2($id_pratut)
    {
		if($_GET['id_pratut']=="undefined"){
			//$this->actionCreate($id_berkas);
			$this->redirect(['create','id_berkas'=>$id_berkas]);
		}else {
        $session = new Session();
        $id_perkara = $session->get('id_perkara');

	    $model = PdmPratutPutusan::findOne(['id_pratut'=>$id_pratut]);
        $modelSpdp = $this->findModelSpdp($id_perkara);
//print_r($model);exit;
        $pengadilan = PdmMsStatusData::find()
                        ->where(['is_group' => ConstDataComponent::Pratut])
                        ->asArray()
                        ->all();

        if($model == null){
            $model = new PdmPratutPutusan();
        }
   $id_berkas=$_POST['idberkas'];
        if ($model->load(Yii::$app->request->post())) {
                 
            $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_pratut_putusan', 'id_pratut', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();
            
            if($model->id_perkara != null){
                $model->flag='2'; 
				$model->id_berkas = $id_berkas;	
//print_r($model);exit;				
                $model->update();
            }else{
                $model->id_perkara = $id_perkara;
                $model->id_pratut = $seq['generate_pk'];
				$model->id_berkas = $id_berkas;
                $model->save();
            }
            
            $id_satker_tujuan = $_POST['PdmSpdp']['id_satker_tujuan'];
            if (!empty($id_satker_tujuan)) {
                $model->no_surat = NULL;
                $model->tgl_surat = NULL;
                $model->save();

                $modelSpdp1 = $modelSpdp;
                $modelSpdp1->id_satker_tujuan = $id_satker_tujuan;
				print_r($modelSpdp1);exit;
                if(!$modelSpdp1->update()){
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'danger', //String, can only be set to danger, success, warning, info, and growl
                        'duration' => 3000, //Integer //3000 default. time for growl to fade out.
                        'icon' => 'glyphicon glyphicon-ok-sign', //String
                        'message' => 'Data Gagal Disimpan', // String
                        'title' => 'Save', //String
                        'positonY' => 'top', //String // defaults to top, allows top or bottom
                        'positonX' => 'center', //String // defaults to right, allows right, center, left
                        'showProgressbar' => true,
                    ]);
                    return $this->redirect(['index']);   
                }
            }else{
                $modelSpdp1 = $modelSpdp;
                $modelSpdp1->id_satker_tujuan = NULL;

                if(!$modelSpdp1->update()){
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'danger', //String, can only be set to danger, success, warning, info, and growl
                        'duration' => 3000, //Integer //3000 default. time for growl to fade out.
                        'icon' => 'glyphicon glyphicon-ok-sign', //String
                        'message' => 'Data Gagal Disimpan', // String
                        'title' => 'Save', //String
                        'positonY' => 'top', //String // defaults to top, allows top or bottom
                        'positonX' => 'center', //String // defaults to right, allows right, center, left
                        'showProgressbar' => true,
                    ]);
                    return $this->redirect(['index']);   
                }
            }

            //notifikasi simpan
            Yii::$app->getSession()->setFlash('success', [
                'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
                'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                'icon' => 'glyphicon glyphicon-ok-sign', //String
                'message' => 'Data Berhasil Disimpan', // String
                'title' => 'Save', //String
                'positonY' => 'top', //String // defaults to top, allows top or bottom
                'positonX' => 'center', //String // defaults to right, allows right, center, left
                'showProgressbar' => true,
            ]);
            return $this->redirect(['index']);   
           // return $this->redirect(['update', 'id_pratut' => $model->id_pratut]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelSpdp'=>$modelSpdp,
                'pengadilan' => $pengadilan
            ]);
        }
		}
    }*/

    /**
     * Deletes an existing PdmPratutPutusan model.
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

                PdmPratutPutusan::updateAll(['flag' => '3'], "id_perkara = '" . $id_perkara . "'");
            }else{
                for($i=0;$i<count($id);$i++){
                PdmPratutPutusan::updateAll(['flag' => '3'], "id_pratut = '" . $id[$i] . "'");
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
     * Finds the PdmPratutPutusan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmPratutPutusan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmPratutPutusan::findOne($id)) !== null) {
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
