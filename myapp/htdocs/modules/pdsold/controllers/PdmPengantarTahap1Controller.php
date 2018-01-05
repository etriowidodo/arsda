<?php

namespace app\modules\pdsold\controllers;

use Yii;
use app\components\ConstSysMenuComponent;
use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmSysMenu;
use app\modules\pdsold\models\PdmBerkasTahap1;
use app\modules\pdsold\models\PdmPengantarTahap1;
use app\modules\pdsold\models\PdmPengantarTahap1Search;
use app\modules\pdsold\models\PdmBerkasTahap1Search;
use app\modules\pdsold\models\PdmUuPasalTahap1;
use app\modules\pdsold\models\MsTersangkaBerkas;
use app\modules\pdsold\models\MsJkl;
use app\models\MsWarganegara;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\web\Session;
use Jaspersoft\Client\Client;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;

/**
 * PdmPengantarTahap1Controller implements the CRUD actions for PdmPengantarTahap1 model.
 */
class PdmPengantarTahap1Controller extends Controller
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
     * Lists all PdmPengantarTahap1 models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PdmPengantarTahap1Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PdmPengantarTahap1 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

	 public function actionWn() {
        $searchModel = new MsWarganegara();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 7;
        return $this->renderAjax('_wn',[
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Creates a new PdmPengantarTahap1 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		//Yii::$app->view->params['customParam'] = $kd;
		//$this->view->params['customParam'] = $kd;
		//$sysMenu = PdmSysMenu::findOne(['kd_pengantar' => GlobalConstMenuComponent::CekBerkas ]);
        $session = new Session();
		$model = new PdmPengantarTahap1();
        $id = $session->get('id_perkara');
		$modelSpdp = PdmSpdp::findOne(['id_perkara' => $id]);
		$searchModel = new PdmBerkasTahap1Search();
		$dataProvider = $searchModel->search2(Yii::$app->request->queryParams);
		
        if ($model->load(Yii::$app->request->post()) ) {
		
		$transaction = Yii::$app->db->beginTransaction();
			try{
			
				$files = UploadedFile::getInstance($model, 'file_upload');
				if ($files != false && !empty($files) ) {
					$model->file_upload = preg_replace('/[^A-Za-z0-9\-]/', '',$seq['generate_pk_perkara']) . '.' . $files->extension;
				}
			$modelTersangka->attributes = Yii::$app->request->post('MsTersangkaBerkas');
            $modelPasal->attributes = Yii::$app->request->post('PdmUuPasalTahap1');
			$seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_pengantar_tahap1', 'id_pengantar', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();
			$model->id_pengantar = $seq['generate_pk'];
			$model->id_berkas = "1";
			$model->save();
			
			//SIMPAN UNDANG2
			$undang = $_POST['undang'];

                if(isset($undang)){
                    for($i=0;$i<count($undang);$i++){

                        $pdmPasal1 = new PdmUuPasalTahap1 ();

                        $seqPasal = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_uu_pasal_tahap1', 'id_pasal', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();

                        $pdmPasal1->id_pasal = $seqPasal['generate_pk'];
                        $pdmPasal1->id_pengantar = $seq['generate_pk'];
                        $pdmPasal1->undang = $_POST['undang'][$i];
                        $pdmPasal1->pasal = $_POST['pasal'][$i];
                        $pdmPasal1->save();
						//var_dump($pdmPasal1);exit;
                    }
					}
			//SIMPAN TERSANGKA 
			if (!empty($_POST['MsTersangkaBaru']['nama'])) { // jika MsTersangkaBaru tidak kosong, maka otomatis akan tersimpan
                    for($i=0; $i < count($_POST['MsTersangkaBaru']['nama']); $i++)
                    {
                        $modelTersangka1 = new MsTersangkaBerkas();

                        /*$seqTersangka = Yii::$app->db->createCommand("select public.generate_pk('pidum.ms_tersangka', 'id_tersangka', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();*/
						$seqTersangka = Yii::$app->db->createCommand("select public.generate_pk('pidum.ms_tersangka_berkas','id_tersangka', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();						
						$jml = Yii::$app->db->createCommand(" select count(*) from pidum.ms_tersangka_berkas where id_pengantar = '".$seq['generate_pk']."' ")->queryScalar();

                        $id_tersangka =  $seqTersangka['generate_pk'];
                        $modelTersangka1->id_tersangka = $id_tersangka;
                        $modelTersangka1->id_perkara = $id;
                        $modelTersangka1->tmpt_lahir = $_POST['MsTersangkaBaru']['tmpt_lahir'][$i];
                        $modelTersangka1->tgl_lahir = $_POST['MsTersangkaBaru']['tgl_lahir'][$i];
						$modelTersangka1->umur = $_POST['MsTersangkaBaru']['umur'][$i];
                        $modelTersangka1->alamat = $_POST['MsTersangkaBaru']['alamat'][$i];
                        $modelTersangka1->no_identitas = $_POST['MsTersangkaBaru']['no_identitas'][$i];
                        $modelTersangka1->no_hp = $_POST['MsTersangkaBaru']['no_hp'][$i];
                        $modelTersangka1->warganegara = $_POST['MsTersangkaBaru']['warganegara'][$i];
                        $modelTersangka1->pekerjaan = $_POST['MsTersangkaBaru']['pekerjaan'][$i];
                        $modelTersangka1->suku = $_POST['MsTersangkaBaru']['suku'][$i];
                        $modelTersangka1->nama = $_POST['MsTersangkaBaru']['nama'][$i];
                        $modelTersangka1->id_jkl = $_POST['MsTersangkaBaru']['id_jkl'][$i];
                        $modelTersangka1->id_identitas = $_POST['MsTersangkaBaru']['id_identitas'][$i];
                        $modelTersangka1->id_agama = $_POST['MsTersangkaBaru']['id_agama'][$i];
                        $modelTersangka1->id_pendidikan = $_POST['MsTersangkaBaru']['id_pendidikan'][$i];
                        $modelTersangka1->flag = $_POST['MsTersangkaBaru']['flag'][$i];
                        $modelTersangka1->tinggi = $_POST['MsTersangkaBaru']['tinggi'][$i];
                        $modelTersangka1->kulit = $_POST['MsTersangkaBaru']['kulit'][$i];
                        $modelTersangka1->muka = $_POST['MsTersangkaBaru']['muka'][$i];
                        $modelTersangka1->ciri_khusus = $_POST['MsTersangkaBaru']['ciri_khusus'][$i];                        
                        $data = $_POST['MsTersangkaBaru']['foto'][$i];
                        if(isset($data))
                            {
                                $contents_split = explode(',', $data);
                                $encoded = $contents_split[count($contents_split)-1];
                                $decoded = "";
                                for ($a=0; $a < ceil(strlen($encoded)/256); $a++) 
                                {
                                    $decoded = $decoded . base64_decode(substr($encoded,$a*256,256)); 
                                }
                                $name_foto = '../web/image/upload_file/tersangka_pidum/'.$id_tersangka.'.jpg';
                                $fp =   fopen($name_foto, 'w');
                                        fwrite($fp, $decoded);
                                        fclose($fp);
                               $modelTersangka1->foto = $id_tersangka.'.jpg';
                            }
						$modelTersangka1->no_urut = $jml+1;							
                        $modelTersangka1->is_status = $_POST['MsTersangkaBaru']['is_status'][$i];	
						$modelTersangka1->id_pengantar = $seq['generate_pk'];							
                        if(!$modelTersangka1->save()){
							var_dump($modelTersangka1->getErrors());exit;
						}

                    }
                }
				
			$transaction->commit();
				
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

                return $this->redirect(['../pdsold/pdm-berkas-tahap1/create']);
            }catch (Exception $e){
                $transaction->rollBack();
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'danger',
                    'duration' => 3000,
                    'icon' => 'glyphicon glyphicon-ok-sign', //String
                    'message' => 'Terjadi Kesalahan',
                    'title' => 'Error',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);

                return $this->render('create',[
				'model' => $model,
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
				'modelSpdp' => $modelSpdp,
				'modelTersangka' => $modelTersangka,
                'modelPasal' => $modelPasal,
				]);
				
            }
        } else {
            return $this->render('create', [
                'model' => $model,
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
				'modelSpdp' => $modelSpdp,
				'modelTersangka' => $modelTersangka,
                'modelPasal' => $modelPasal,
            ]);
        }
    }

    public function actionShowPengantar()	
	{

		$session = new Session();
		$model = new PdmPengantarTahap1();
        $id = $session->get('id_perkara');
		$modelSpdp = PdmSpdp::findOne(['id_perkara' => $id]);
		$searchModel = new PdmBerkasTahap1Search();
		$dataProvider = $searchModel->search2(Yii::$app->request->queryParams);
		return $this->renderAjax('_popPengantar', [
				'model' => $model,
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
				'modelSpdp' => $modelSpdp,
				'modelTersangka' => $modelTersangka,
                'modelPasal' => $modelPasal,
				]);
	}
	/**
     * Updates an existing PdmPengantarTahap1 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_pengantar]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PdmPengantarTahap1 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

	public function actionShowTersangka()
    {
        if($_GET['id_tersangka'] != null){
            $modelTersangka = MsTersangkaBerkas::findOne(['id_tersangka' => $_GET['id_tersangka']]);
        }else{
            $modelTersangka = new MsTersangkaBerkas();
			$id_tersangka = '';
        }
        
        $identitas = ArrayHelper::map(\app\models\MsIdentitas::find()->all(), 'id_identitas', 'nama');
        $agama = ArrayHelper::map(\app\models\MsAgama::find()->all(), 'id_agama', 'nama');
        $pendidikan = ArrayHelper::map(\app\models\MsPendidikan::find()->all(), 'id_pendidikan', 'nama');
		$JenisKelamin = ArrayHelper::map(\app\models\MsJkl::find()->all(), 'id_jkl', 'nama');
        $warganegara = ArrayHelper::map(\app\models\MsWarganegara::find()->all(), 'id', 'nama');
        $warganegara_grid = new MsWarganegara();
        
        return $this->renderAjax('_popTersangka', [
            'modelTersangka'    => $modelTersangka,
            'agama'             => $agama,
            'identitas'         => $identitas,
			'JenisKelamin'		=> $JenisKelamin,
            'pendidikan'        => $pendidikan,
            'warganegara'       => $warganegara,
            'warganegara_grid'  => $warganegara_grid

        ]);
    }

     public function actionUpdateTersangka($id)
    {
        $model = MsTersangkaBerkas::findOne(['id_tersangka' => $id]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
          
            $data   = $_POST['MsTersangka']['new_foto'];
            $id     = $_POST['MsTersangka']['id_tersangka'];
            if($data !='')
            { 

                $contents_split = explode(',', $data);
                $encoded = $contents_split[count($contents_split)-1];
                $decoded = "";
                for ($a=0; $a < ceil(strlen($encoded)/256); $a++) 
                {
                    $decoded = $decoded . base64_decode(substr($encoded,$a*256,256)); 
                }
                $name_foto = '../web/image/upload_file/tersangka_pidum/'.$id.'.jpg';
                $fp = fopen($name_foto, 'w');
                      fwrite($fp, $decoded);
                      fclose($fp);  
            }

        }
    }
  
	
	/**
     * Finds the PdmPengantarTahap1 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmPengantarTahap1 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmPengantarTahap1::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
