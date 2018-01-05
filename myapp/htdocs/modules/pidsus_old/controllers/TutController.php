<?php

namespace app\modules\pidsus\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use app\modules\pidsus\models\PdsTut;
use app\modules\pidsus\models\PdsTutTersangka;
use app\modules\pidsus\models\PdsDik;
use app\modules\pidsus\models\Status;
use app\modules\pidsus\models\PdsTutTembusan;
use app\modules\pidsus\models\PdsTutPermintaanData;
use app\modules\pidsus\models\PdsTutRenTut;
use app\modules\pidsus\models\KpPegawai;
use app\modules\pidsus\models\KpInstSatker;
use app\modules\pidsus\models\PdsTutJaksa;
use app\modules\pidsus\models\PdsTutSaksi;
use app\modules\pidsus\models\PdsTutSurat;
use app\modules\pidsus\models\PdsDikSurat;
use app\modules\pidsus\models\PdsTutSuratDetail;
use app\modules\pidsus\models\PdsTutSuratSaksi;
use app\modules\pidsus\models\PdsTutSuratJaksa;
use app\modules\pidsus\models\PdsTutSuratSearch;
use app\modules\pidsus\models\PdsTutSuratIsi;
use app\modules\pidsus\models\PdsPasal;
//use app\modules\pidsus\models\PdsTersangka;
use app\modules\pidsus\models\SimkariJenisSurat;

class TutController extends Controller
{

	public function actionCreate()
	{
		$model = new PdsTut();
		$model->penerima_spdp=(string)Yii::$app->user->identity->peg_nik;
		//$model->penandatangan_lap=(string)Yii::$app->user->identity->peg_nik;
		if ($model->load(Yii::$app->request->post())) {
			$model->create_by=(string)Yii::$app->user->identity->username;
			$model->create_ip=(string)$_SERVER['REMOTE_ADDR'];
			$model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
			$model->update_by=(string)Yii::$app->user->identity->username;
        	$model->update_date=date('Y-m-d H:i:s');$model->flag='1';
			$model->id_satker=$_SESSION['idSatkerUser'];
			$model->flag='1';
			$model->is_tut = false;
			$model->save();
			return $this->redirect('index');
		} else {
			$model->create_by=(string)Yii::$app->user->identity->username;
			$model->create_ip=(string)$_SERVER['REMOTE_ADDR'];
			$model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
			$model->update_by=(string)Yii::$app->user->identity->username;
			$model->update_date=date('Y-m-d H:i:s');$model->flag='1';
			$model->id_satker=$_SESSION['idSatkerUser'];
			$model->is_tut = false;
			$model->save();
			
			$model->flag='3';
			$model->save();
			$_SESSION['idPdsTut']=$model->id_pds_tut;
			
			return $this->render('create', [
					'model' => $model,
					'typeSurat' =>'pratut',
					'titleForm'=>'Input Penerimaan SPDP',
			]);
		}
	}
	
	


    public function actionIndex($type='pratut')
    {
    	$modelKpPegawai=KpPegawai::find()->where(['peg_nik'=>(string)Yii::$app->user->identity->peg_nik])->one();
    	$_SESSION['idSatkerUser']=$modelKpPegawai->peg_instakhir;
    	$modelKpInstSatker=KpInstSatker::findBySql('select * from kepegawaian.kp_inst_satker where inst_satkerkd=\''.$modelKpPegawai->peg_instakhir.'\' limit 1')->one();
    	$_SESSION['lokasiUser']=$modelKpInstSatker->inst_lokinst;

    	//$whereQuery="";
    	if($type=='pratut'){
    		$_SESSION['idPdsLid']=null;
    		$_SESSION['idPdsDik']=null;
			$_SESSION['idPdsTut']=null;
			$rawData=Yii::$app->db->createCommand("select * from pidsus.tut_daftar_pekerjaan('".Yii::$app->user->identity->username."','".$_SESSION['idSatkerUser']."','".$_POST['merger_field']."','pratut')")->queryAll();  //idsatker

	    	$dataProvider=new ArrayDataProvider([
	    			'allModels' =>$rawData, 'key' => 'id_pds_tut',

	    			'pagination'=>[
	    					'pageSize'=>10,         //records display
	    			],
	    	]);
	    	//print_r($rawData);
    	}
    	else {

    		$_SESSION['idPdsLid']=null;
    		$_SESSION['idPdsDik']=null;
			$_SESSION['idPdsTut']=null;
    			$rawData=Yii::$app->db->createCommand("select * from pidsus.tut_daftar_pekerjaan('".Yii::$app->user->identity->username."','".$_SESSION['idSatkerUser']."','".$_POST['merger_field']."','tut' ) ")->queryAll();  //idsatker
    		
    		
    			$dataProvider=new ArrayDataProvider([
    					'allModels' =>$rawData, 'key' => 'id_pds_tut',
    				/*	'sort'=>[
    							'attributes'=>[
    							'id_pds_tut', 'no_spdp', 'tgl_spdp', 'status', 'id_status'
	    					],
    					],*/
    					'pagination'=>[
    							'pageSize'=>10,         //records display
    					],
    			]);
    			//print_r($rawData);
    		
    	}
    	 return $this->render('index', [
    			'dataProvider'=>$dataProvider,
    	 		'type'=>$type,
    	]);
    }

	public function actionViewreporttut($id)
	{
		$modelPdsTutSurat = PdsTutSurat::findOne($id);
		$modelJenisSurat= SimkariJenisSurat::findOne(trim($modelPdsTutSurat->id_jenis_surat));

		return $this->redirect(str_replace("%7BID_REPORT%7D",$id,$modelJenisSurat->url_report));
		die();
	}

	public function actionViewreport($id)
	{
		$modelPdsTutSurat = PdsTutSurat::findOne($id);
		$modelJenisSurat= SimkariJenisSurat::findOne(trim($modelPdsTutSurat->id_jenis_surat));

		return $this->redirect(str_replace("%7BID_REPORT%7D",$id,$modelJenisSurat->url_report));
		die();
	}



    public function actionDraftlaporan($id)
    {
		$_SESSION['idPdsDik']=$id;
	    $model = $this->findModel($id);        
	        
	        if ($model->load(Yii::$app->request->post())) {
	        	$connection = Yii::$app->db;
	        	$transaction = $connection->beginTransaction();
	        	$model->attributes = Yii::$app->request->post('PdsTut');
	        	$model->update_by=Yii::$app->user->identity->username;
	        	$model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
	        	$model->update_date=date('Y-m-d H:i:s');$model->flag='1';
	        	$model->save();
	        	//print_r($model->getErrors());
	            $transaction->commit();
	            if ($_POST['btnSubmit']=='simpan'){
	            	//return $this->redirect('viewlaporan?id='.$id);
					return $this->redirect('index');
	            }
	            else {
	            	return $this->redirect('viewreporttut?id='.$model->id_pds_tut.'&jenisSurat='.$_POST['btnCetak']);
				//	return $this->redirect('viewreportTut?id='.$model->id_pds_Tut.'&jenisSurat='.$_POST['btnCetak']);
	            }
	        } else {
	            return $this->render('draftlaporan', [
	                'model' => $model,
	                'typeSurat'=>$type,
	            	'titleForm'=>'Update Penerimaan SPDP',
	            ]);
	        }
    }



	  public function actionViewlaporan($id)
    {

    	$_SESSION['idPdsTut']=$id;
		$model = $this->findModelTut($id);
		$modelSatker=KpInstSatker::findBySql('select * from kepegawaian.kp_inst_satker where inst_satkerkd=\''.$model->id_satker.'\' limit 1')->one();
		$_SESSION['noSpdpDik']=$model->no_spdp.'</br>'.$modelSatker->inst_lokinst;
		$_SESSION['idPdsdik']=$model->id_pds_dik_parent;
		$modelTersangkaUpdate=PdsTutTersangka::findBySql('select * from pidsus.pds_tut_tersangka where id_pds_tut_tersangka in (select id_pds_tut_tersangka from pidsus.pds_tut_tersangka where id_pds_tut =\''.$id.'\') and flag=\'1\'')->orderby('update_date')->all();

		if ($model->load(Yii::$app->request->post())) {
			$connection = Yii::$app->db;
			$transaction = $connection->beginTransaction();
			$model->attributes = Yii::$app->request->post('PdsDik');
			$model->update_by=Yii::$app->user->identity->username;
			$model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
			$model->update_date=date('Y-m-d H:i:s');$model->flag='1';
			$model->save();}


	    return $this->render('viewlaporan', [
	                'model' => $model,
    				'modelTersangkaUpdate'=>$modelTersangkaUpdate,
	               // 'typeSurat'=>'1',
	            	'titleForm'=>'view Penerimaan SPDP',
	            ]);
	        
    }
	

    public function actionViewlaporantut($id)
    {

    	$_SESSION['idPdsTut']=$id;

		//echo $id;
    	$model = $this->findModelTut($id);
    	$modelSatker=KpInstSatker::findBySql('select * from kepegawaian.kp_inst_satker where inst_satkerkd=\''.$model->id_satker.'\' limit 1')->one();
    	$_SESSION['noSpdpTut']=$model->no_spdp.'</br>'.$modelSatker->inst_lokinst;
    	$_SESSION['idPdsDik']=$model->id_pds_dik_parent;
    	/*if (($modelDik = PdsDik::findOne($model->id_pds_dik_parent)) !== null) {
    		 $modelSatker=KpInstSatker::findBySql('select * from kepegawaian.kp_inst_satker where inst_satkerkd=\''.$modelTut->id_satker.'\' limit 1')->one();
	    	$_SESSION['noLapTut']=$modelTut->no_lap.'</br>'.$modelSatker->inst_lokinst;
    	}*/

		if ($model->load(Yii::$app->request->post())) {
			$connection = Yii::$app->db;
			$transaction = $connection->beginTransaction();
			$model->attributes = Yii::$app->request->post('PdsDik');
			$model->update_by=Yii::$app->user->identity->username;
			$model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
			$model->update_date=date('Y-m-d H:i:s');$model->flag='1';
			$model->save();}
    	return $this->render('viewlaporantut', [
    			'model' => $model,
    			//'typeSurat'=>'1',
    			'titleForm'=>'view Penerimaan SPDP',
    	]);


    }

    

    
    public function actionDelete($id)
    {
    	PdsTut::findOne($id)->delete();
    	
    	$modelTutJaksa=PdsTutJaksa::find()->where('id_pds_Tut= \''.$id.'\' ')->all();
    	foreach ($modelTutJaksa as $index => $modelTutJaksaRow) {
    		$modelTutJaksaRow->delete();
    	}
    	

    	$modelTutSaksi=PdsTutSaksi::find()->where('id_pds_Tut= \''.$id.'\' ')->all();
    	foreach ($modelTutSaksi as $index => $modelTutSaksiRow) {
    		$modelTutSaksiRow->delete();
    	}

    	$modelTutPermintaanData=PdsTutPermintaanData::find()->where('id_pds_Tut_surat in (select id_pds_Tut_surat from pidsus.pds_Tut_surat where id_pds_Tut=\''.$id.'\' )')->all();
    	foreach ($modelTutPermintaanData as $index => $modelTutPermintaanDataRow) {
    		$modelTutPermintaanDataRow->delete();
    	}

    	$modelPasal=PdsPasal::find()->where('id_pds_Tut_surat in (select id_pds_Tut_surat from pidsus.pds_Tut_surat where id_pds_Tut=\''.$id.'\' )')->all();
    	foreach ($modelPasal as $index => $modelPasalRow) {
    		$modelPasalRow->delete();
    	}

    	/*$modelTersangka=PdsTersangka::find()->where('id_pds_Tut_surat in (select id_pds_Tut_surat from pidsus.pds_Tut_surat where id_pds_Tut=\''.$id.'\' )')->all();
    	foreach ($modelTersangka as $index => $modelTersangkaRow) {
    		$modelTersangkaRow->delete();
    	}
    	 */
    	$modelTutSuratJaksa=PdsTutSuratJaksa::find()->where('id_pds_Tut_surat in (select id_pds_Tut_surat from pidsus.pds_Tut_surat where id_pds_Tut=\''.$id.'\' )')->all();
    	foreach ($modelTutSuratJaksa as $index => $modelTutSuratJaksaRow) {
    		$modelTutSuratJaksaRow->delete();
    	}
    	
    	$modelTutSuratSaksi=PdsTutSuratSaksi::find()->where('id_pds_Tut_surat in (select id_pds_Tut_surat from pidsus.pds_Tut_surat where id_pds_Tut=\''.$id.'\' )')->all();
    	foreach ($modelTutSuratSaksi as $index => $modelTutSuratSaksiRow) {
    		$modelTutSuratSaksiRow->delete();
    	}
    	
    	$modelTutRenTut=PdsTutRenTut::find()->where('id_pds_Tut_surat in (select id_pds_Tut_surat from pidsus.pds_Tut_surat where id_pds_Tut=\''.$id.'\' )')->all();
    	foreach ($modelTutRenTut as $index => $modelTutRenTutRow) {
    		$modelTutRenTutRow->delete();
    	}
    	
    	$modelTembusan=PdsTutTembusan::find()->where('id_pds_Tut_surat in (select id_pds_Tut_surat from pidsus.pds_Tut_surat where id_pds_Tut=\''.$id.'\' )')->all();
    	foreach ($modelTembusan as $index => $modelTembusanRow) {
    		$modelTembusanRow->delete();
    	}
    	
    	$modelSuratIsi=PdsTutSuratIsi::find()->where('id_pds_Tut_surat in (select id_pds_Tut_surat from pidsus.pds_Tut_surat where id_pds_Tut=\''.$id.'\' )')->all();
    	foreach ($modelSuratIsi as $index => $modelSuratIsiRow) {
    		$modelSuratIsiRow->delete();
    	}

    	$modelSuratDetail=PdsTutSuratDetail::find()->where('id_pds_Tut_surat in (select id_pds_Tut_surat from pidsus.pds_Tut_surat where id_pds_Tut=\''.$id.'\' )')->all();
    	foreach ($modelSuratDetail as $index => $modelSuratDetailRow) {
    		$modelSuratDetail->delete();
    	}
    	 
    	$modelSurat=PdsTutSurat::find()->where('id_pds_Tut=\''.$id.'\'')->all();
    	foreach ($modelSurat as $index => $modelSuratRow) {
    		$modelSuratRow->delete();
    	}
    	return $this->redirect(['index']);
    }
    

    protected function findModel($id)
    {
    	if (($model = PdsTut::findOne($id)) !== null) {
    		return $model;
    	} else {
    		throw new NotFoundHttpException('The requested page does not exist.');
    	}
    }

    
    protected function findModelSurat($id,$modelTut,$typeSurat)
    {	
    	if (($model = PdsTutSurat::find()->where('id_jenis_surat=\''.$typeSurat.'\' and id_pds_tut=\''.$id.'\'')->one()) !== null) {
    		return $model;
    	} else {
    		$model= new PdsTutSurat();
    		$model->id_pds_Tut=$id;
    		$model->id_jenis_surat=$typeSurat;
    		$model->id_status=$modelTut->id_status;
    		$model->create_by=(string)Yii::$app->user->identity->username;
    		$model->save();
    		$this->findModel($id,$modelTut);
    	}
    }
    protected function findModelTut($id)
    {
    	if (($modelTut = PdsTut::findOne($id)) !== null) {
    		return $modelTut;
    	} else {
    		throw new NotFoundHttpException('The requested page does not exist.');
    	}
    }
    
    public function actionLinkForm() {
    	if (Yii::$app->request->isAjax) {
    		Yii::$app->response->format = Response::FORMAT_JSON;
    
    
    		$res = array(
    				'body'    => print_r($_POST, true),
    				'success' => true,
    		);
    
    		return $res;
    	}
    }
    
    public function actionAjax(){
    	return $this->render('ajax', [
    	]);
    }
    
    public function actionShowTersangka()
    {
    	$modelTersangka = new PdsTutTersangka();
    
    	if ($modelTersangka->load(Yii::$app->request->post()) ) {
    		$modelTersangka->id_pds_tut = $idPdsDik=$_SESSION['idPdsTut'];
    		$modelTersangka->create_by=(string)Yii::$app->user->identity->username;
    		$modelTersangka->create_date=date('Y-m-d H:i:s');
    		 
    		$modelTersangka->save();
    		$data['id_pds_tut_tersangka'] = $modelTersangka->id_pds_tut_tersangka;

    		//print_r($modelTersangka->getErrors());
    		echo json_encode($data);
    	}
    	else {
    		return $this->renderAjax('_popTersangka', [
    				'modelTersangka' => $modelTersangka
    		]);
    	}
    }
    
    public function actionEditTersangka($id)
    {
    	$modelTersangka = PdsTutTersangka::find()->where(['id_pds_tut_tersangka'=>$id])->one();
    
    	if ($modelTersangka->load(Yii::$app->request->post()) ) {
    		$modelTersangka->id_pds_tut = $idPdsDik=$_SESSION['idPdsTut'];
    		$modelTersangka->create_by=(string)Yii::$app->user->identity->username;
    		$modelTersangka->create_date=date('Y-m-d H:i:s');
    
    		$modelTersangka->save();
    	}
    	else {
    		return $this->renderAjax('_popTersangkaEdit', [
    				'modelTersangka' => $modelTersangka
    		]);
    	}
    }
    
    public function actionDeleteTersangka($id){
    	$modelTersangka = PdsTutTersangka::find()->where(['id_pds_tut_tersangka'=>$id])->one();
    	$modelTersangka->flag='3';
    	$modelTersangka->update_by=(string)Yii::$app->user->identity->username;
    	$modelTersangka->update_date=date('Y-m-d H:i:s');
    	$modelTersangka->save();
    	
    }
    
}
