<?php

namespace app\modules\pidsus\controllers;

use Yii;
use app\modules\pidsus\models\PdsDik;
use app\modules\pidsus\models\PdsDikSuratSaksi;
use app\modules\pidsus\models\PdsDikSaksi;
use app\modules\pidsus\models\PdsDikTembusan;
use app\modules\pidsus\models\KpPegawai;
use app\modules\pidsus\models\PdsDikSuratforBA1;
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
 * Ba1Controller implements the CRUD actions for PdsDikSurat model.
 */
class Ba1Controller extends Controller
{
	public $idJenisSurat='ba1';
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
        $dataProvider = $searchModel->search2(Yii::$app->request->queryParams,'ba1tsk',$id);
        $dataProvider2 = $searchModel->search2(Yii::$app->request->queryParams,'ba1sks',$id);
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dataProvider2' => $dataProvider2,
        	'id' => $id,	
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
    public function actionCreate($type,$id)
    {
        //Create new pdslidsurat
		$id=$_SESSION['idPdsDik'];
    	$model = new PdsDikSurat();
        $model->id_jenis_surat='ba1'.$type;
        $model->id_pds_dik=$id;
        $model->create_by=(string)Yii::$app->user->identity->username;
		$model->create_ip=(string)$_SERVER['REMOTE_ADDR'];
        $model->save();
        //get latest idpdslidsurat
        //$model= PdsDikSuratforBA1::findBySql("select * from pidsus.pds_dik_surat where id_pds_dik='".$id."' and id_jenis_surat='ba1' and create_by='".(string)Yii::$app->user->identity->username."' order by create_date desc limit 1")->one();
        //insert default pertanyaan
        $aPertanyaan[0]='Apakah sekarang Saudara dalam keadaan sehat jasmani dan rohani serta bersediakah Saudara memberikan keterangan pada pemeriksaan ini?';
        $aPertanyaan[1]='Apakah saudara telah menunjuk Penasehat HUkum yang akan mendampingi Saudara dalam pemeriksaan ini?';
        $aPertanyaan[2]='Mengapa Saudara berkeberatan didampingi Penasehat Hukum **)?';
        $aPertanyaan[3]='(Pengembangannya diteruskan pertanyaan-pertanyaan sesuai dengan keterangan yang dikehendaki untuk membuat peristiwa Tindak Pidana Tersebut menjadi terang)';
        $aPertanyaan[4]='Apakah masih ada keterangan lain yang ingin Saudara tambahkan dalam pemberian keterangan ini?';
        $aPertanyaan[5]='Apakah semua keterangan yang Saudara berikan seperti diatas tersebut benar dan diberikan tanpa ada tekanan atau paksaan dalam memberikan keterangan tersebut diatas?';
        
        for($n=0;$n< count($aPertanyaan);$n++){
        	$modelKeterangan= new PdsDikSuratKeterangan();
        	$modelKeterangan->id_pds_dik_surat=$model->id_pds_dik_surat;
        	$modelKeterangan->no_urut=$n+1;
        	$modelKeterangan->pertanyaan=$aPertanyaan[$n];
        	$modelKeterangan->create_by=(string)Yii::$app->user->identity->username;
        	$modelKeterangan->save();
        }
        
         
        $modelSuratSaksi= new PdsDikSuratSaksi();
        $modelSuratSaksi->id_pds_dik_surat=$model->id_pds_dik_surat;
        $modelSuratSaksi->no_urut=1;
        $modelSuratSaksi->create_by=(string)Yii::$app->user->identity->username;
        $modelSuratSaksi->save();
        //print_r($modelSuratSaksi);        die();
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
    	$model = PdsDikSuratforBA1::findOne($id);
    	$modelSuratSaksi=PdsDikSuratSaksi::find()->where(['id_pds_dik_surat'=>$id])->one();
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
			$link = "<script>window.open(\"../../pidsus/default/viewreportdik?id=$model->id_pds_dik_surat\")</script>";
			echo $link;
		}

        if ($model->load(Yii::$app->request->post())) {

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
        	if($model->id_jenis_surat=='ba1sks' && $modelSuratSaksi->load(Yii::$app->request->post()) ){
	        	$modelSuratSaksi->update_by=(string)Yii::$app->user->identity->username;
	        	$modelSuratSaksi->update_date=date('Y-m-d H:i:s');
	        	$modelSuratSaksi->save();
        	}
        	//print_r($modelSaksi);
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
        	//print_r($modelSuratSaksi);
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

            	'modelSuratSaksi'=>$modelSuratSaksi,		
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
        if (($model = PdsDikSuratforBA1::findOne($id)) !== null) {
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
    
    public function actionEditsaksi($id)
    {
    	$modelSaksi= PdsDikSaksi::find()->where(['id_pds_dik_saksi'=>$id])->one();
    
    	if ($modelSaksi->load(Yii::$app->request->post()) ) {
    		$modelSaksi->update_by=(string)Yii::$app->user->identity->username;
    		$modelSaksi->update_date=date('Y-m-d H:i:s');
    
    		$modelSaksi->save();
    		//echo json_encode($modelPermintaanData->id_pds_dik_tersangka);
    		//print_r($model->getErrors());
    	}
    	else {
    		return $this->renderAjax('_popSaksi', [
    				'modelSaksi' => $modelSaksi
    		]);
    	}
    }
}
