<?php

namespace app\modules\pidsus\controllers;

use Yii;
use app\modules\pidsus\models\PdsDik;
use app\modules\pidsus\models\PdsDikSuratTersangka;
use app\modules\pidsus\models\PdsDikTersangka;
use app\modules\pidsus\models\PdsDikTembusan;
use app\modules\pidsus\models\KpPegawai;
use app\modules\pidsus\models\PdsDikSurat;
use app\modules\pidsus\models\PdsDikSuratKeterangan;
use app\modules\pidsus\models\PdsDikSuratJaksa;
use app\modules\pidsus\models\PdsDikSuratIsi;
use app\modules\pidsus\models\PdsDikSuratSearch;
use app\modules\pidsus\models\PdsDikPermintaanData;
use app\modules\pidsus\models\PdsDikUsulanPermintaanData;
use app\modules\pidsus\models\Status;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Ba15Controller implements the CRUD actions for PdsDikSurat model.
 */
class Ba15Controller extends Controller
{
    public $idJenisSurat='ba15';
    public $title='BA 15 - Berita Acara Penerimaan dan Penelitian Tersangka';
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
     * Lists all PdsDikSurat models.
     * @return mixed
     */
    public function actionIndex()
    {
    	$id=$_SESSION['idPdsDik'];
        $searchModel = new PdsDikSuratSearch();
        $dataProvider = $searchModel->search2(Yii::$app->request->queryParams,'ba15',$id);
		
        return $this->render('index', [
			'searchModel' => $searchModel,
			'idJenisSurat' => 'ba15',	
			'dataProvider' => $dataProvider,
			'titleMain'=>$this->title,
		]);
    }

    /**
     * Displays a single PdsDikSurat model.
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
     * Creates a new PdsDikSurat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        //Create new pdslidsurat
		$id=$_SESSION['idPdsDik'];
    	$model = new PdsDikSurat();
        $model->id_jenis_surat='ba15';
        $model->id_pds_dik=$id;
        $model->create_by=(string)Yii::$app->user->identity->username;
		$model->create_ip=(string)$_SERVER['REMOTE_ADDR'];
        $model->save();
        //get latest idpdslidsurat
        $model= PdsDikSurat::findBySql("select * from pidsus.pds_dik_surat where id_pds_dik='".$id."' and id_jenis_surat='ba15' and create_by='".(string)Yii::$app->user->identity->username."' order by create_date desc limit 1")->one();
        //insert default pertanyaan
        $aPertanyaan[0]='Apa sebab Saudara dihadapkan di Kejaksaan?';
        $aPertanyaan[1]='Apakah untuk perkara ini Saudara ditahan?';
        $aPertanyaan[2]='Kalau Ditahan, sejak kapan?';
        $aPertanyaan[3]='Benarkah sangkaan terhadap saudara sepert tersebut dalam berkas perkara ini?';
        $aPertanyaan[4]='Apakah Saudara pernah dihukum?';
        $aPertanyaan[5]='Apakah ada hal-hal lain yang akan Saudara jelaskan?';
        
        for($n=0;$n< count($aPertanyaan);$n++){
        	$modelKeterangan= new PdsDikSuratKeterangan();
        	$modelKeterangan->id_pds_dik_surat=$model->id_pds_dik_surat;
        	$modelKeterangan->no_urut=$n+1;
        	$modelKeterangan->pertanyaan=$aPertanyaan[$n];
        	$modelKeterangan->create_by=(string)Yii::$app->user->identity->username;
        	$modelKeterangan->save();
        }
        
        //create tersangka for pidsus 8
        $modelTersangka=new PdsDikTersangka();
        $modelTersangka->id_pds_dik=$id;
        $modelTersangka->create_by=(string)Yii::$app->user->identity->username;
        $modelTersangka->save();    
        //print_r($modelTersangka->getErrors());
            
        $modelTersangka= PdsDikTersangka::findBySql("select * from pidsus.pds_dik_tersangka where id_pds_dik='".$id."' and create_by='".(string)Yii::$app->user->identity->username."' order by create_date desc limit 1")->one();
         
        $modelSuratTersangka= new PdsDikSuratTersangka();
        $modelSuratTersangka->id_pds_dik_surat=$model->id_pds_dik_surat;
        $modelSuratTersangka->no_urut=1;
        $modelSuratTersangka->id_tersangka=$modelTersangka->id_pds_dik_tersangka;
        $modelSuratTersangka->create_by=(string)Yii::$app->user->identity->username;
        $modelSuratTersangka->save();
        //print_r($modelSuratTersangka->getErrors());
       // die();
        return $this->redirect(['update?id='.$model->id_pds_dik_surat]);
    }

    /**
     * Updates an existing PdsDikSurat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
    	$model = PdsDikSurat::findOne($id);
    	$modelSuratTersangka=PdsDikSuratTersangka::find()->where(['id_pds_dik_surat'=>$id])->one();
    	$modelTersangka=PdsDikTersangka::findOne($modelSuratTersangka->id_tersangka);
    	$modelDik = $this->findModelDik($model->id_pds_dik);
    	//$modelStatus=Status::findOne($modelDik->id_status);
    	$modelKeterangan=PdsDikSuratKeterangan::find()->where(['id_pds_dik_surat'=>$id])->orderby('no_urut')->all();
    //	$modelKpPegawai= null;
    //	$modelJaksa=PdsDikSuratJaksa::find()->where('id_pds_dik_surat=\''.$model->id_pds_dik_surat.'\' order by no_urut')->all();
    //	$modelPermintaanData=PdsDikPermintaanData::find()->where(['id_pds_dik_surat'=>$model->id_pds_dik_surat])->all();
        $modelSuratIsi= PdsDikSuratIsi::findBySql('select * from pidsus.select_surat_isi_dik(\''.$model->id_pds_dik_surat.'\',\''.Yii::$app->user->id.'\')')->all();
	//	$modelPermintaanData4=PdsDikUsulanPermintaanData::findBySql('select * from pidsus.pds_dik_usulan_permintaan_data where id_pds_dik_surat in (select id_pds_dik_surat from pidsus.pds_dik_surat where id_jenis_surat=\'pidsus4\' and id_pds_dik=\''.$model->id_pds_dik.'\' )')->all();
		$modelSuratJaksa=PdsDikSuratJaksa::find()->where(['id_pds_dik_surat'=>$id])->all();
		$modelJaksa=KpPegawai::findBySql('select * from kepegawaian.kp_pegawai where peg_nik in (select id_jaksa from pidsus.pds_dik_jaksa where id_pds_dik= \''.$_SESSION['idPdsDik'].'\')')->all();
		if(isset($_SESSION['cetak'])){
			$_SESSION['cetak']=null;
			$link = "<script>window.open(\"../../pidsus/default/viewreport?id=$model->id_pds_dik_surat\")</script>";
			echo $link;
		}

        if ($model->load(Yii::$app->request->post())&&$modelTersangka->load(Yii::$app->request->post()) ) {

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
					PdsDikSuratJaksa::deleteAll(['id_jaksa' => $hapus_jpu[$i], 'id_pds_dik_surat'=>$model->id_pds_dik_surat]);
				}
			}

			if ($nip_jpu!=null){
				for($i = 0; $i < count($nip_jpu); $i++){
					$modelJaksaSurat= new PdsDikSuratJaksa();
					$modelJaksaSurat->create_by=(string)Yii::$app->user->identity->username;
					$modelJaksaSurat->id_pds_dik_surat=$model->id_pds_dik_surat;
					$modelJaksaSurat->id_jaksa=$nip_jpu[$i];

					$modelJaksaSurat->save();
					}
			}
			
			if(isset($_POST['pertanyaan'])){
				for($i = 0; $i < count($_POST['pertanyaan']); $i++){
					$modelInsertKeterangan= new PdsDikSuratKeterangan();
					$modelInsertKeterangan->create_by=(string)Yii::$app->user->identity->username;
					$modelInsertKeterangan->id_pds_dik_surat=$model->id_pds_dik_surat;
					$modelInsertKeterangan->no_urut=$_POST['no_urut'][$i];
					$modelInsertKeterangan->pertanyaan=$_POST['pertanyaan'][$i];
					$modelInsertKeterangan->jawaban=$_POST['jawaban'][$i];
					$modelInsertKeterangan->save();
				}
			}
			

			if(isset($_POST['hapus_ket'])){
				for($i = 0; $i < count($_POST['hapus_ket']); $i++){
					PdsDikSuratKeterangan::deleteAll(['id_pds_dik_surat_keterangan' => $_POST['hapus_ket'][$i]]);
				}
			}
        	$model->update_by=(string)Yii::$app->user->identity->username;
        	$model->update_date=date('Y-m-d H:i:s');$model->flag='1';
			$model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
        	$model->save();
        	$modelTersangka->update_by=(string)Yii::$app->user->identity->username;
        	$modelTersangka->update_date=date('Y-m-d H:i:s');
        	$modelTersangka->save();
        	//print_r($modelTersangka);
        	if(PdsDikSuratIsi::loadMultiple($modelSuratIsi, Yii::$app->request->post()) ){
        		foreach($modelSuratIsi as $row){
        			$row->update_by=Yii::$app->user->identity->username;
        			$row->update_date=date('Y-m-d H:i:s');
        			$row->save();//print_r($row->getErrors());
        		}
        	}
        	

        	if(PdsDikSuratKeterangan::loadMultiple($modelKeterangan, Yii::$app->request->post()) && PdsDikSuratIsi::validateMultiple($modelKeterangan)){
        		foreach($modelKeterangan as $row){
        			$row->update_by=Yii::$app->user->identity->username;
        			$row->update_date=date('Y-m-d H:i:s');
        			$row->save();//print_r($row->getErrors());
        		}
        	}
        	if ($_POST['btnSubmit']=='simpan'){
        		return $this->redirect(['index?id='.$modelDik->id_pds_dik]);
        	}
        	else {
        		$_SESSION['cetak']=1; return $this->refresh();   //return $this->redirect(['../pidsus/default/viewreport', 'id'=>$model->id_pds_dik_surat]);
        	}
        } else {
        	//print_r($modelSuratIsi);
        	//die();
        	
            return $this->render('update', [
                'model' => $model,
                'modelDik' => $modelDik,
            	'modelSuratIsi' => $modelSuratIsi,
            //	'modelKpPegawai' =>$modelKpPegawai,
				'modelJaksa' =>$modelJaksa,
				'modelKeterangan' =>$modelKeterangan,
          //  	'modelPermintaanData' => $modelPermintaanData,
           // 	'modelPermintaanData4' => $modelPermintaanData4,
				'modelSuratJaksa'=>$modelSuratJaksa,

            	'modelTersangka'=>$modelTersangka,		
            	'titleForm' => "",	
            	'readOnly' => false,
            ]);
        }
    }

    /**
     * Deletes an existing PdsDikSurat model.
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
     * Finds the PdsDikSurat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdsDikSurat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdsDikSurat::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
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
    

    public function actionDeletebatch()
    {
    	$id_pds = $_POST['hapusPds'];
    
    	for($i=0;$i<count($id_pds);$i++){
    		$pds = PdsDikSurat::findOne($id_pds[$i]);
    		$pds->flag = '3';
    		$pds->save();
    	}
    	return $this->redirect('index');
    }
}
