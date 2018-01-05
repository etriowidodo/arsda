<?php

namespace app\modules\pidum\controllers;

use app\components\GlobalConstMenuComponent;
use app\components\ConstSysMenuComponent;
use app\modules\pidum\models\MsTersangka;
use app\modules\pidum\models\PdmP16;
use app\modules\pidum\models\PdmP17;
use app\modules\pidum\models\PdmP17Search;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmTembusanP17;
use app\modules\pidum\models\PdmJaksaP16;
use app\modules\pidum\models\PdmStatusSurat;
use app\modules\pidum\models\VwJaksaPenuntutSearch;
use Yii;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;
use app\modules\pidum\models\PdmSysMenu; //copy 1
use app\modules\pidum\models\PdmPenandatangan;
use yii\web\UploadedFile;
/**
 * PdmP17Controller implements the CRUD actions for PdmP17 model.
 */
class PdmP17Controller extends Controller
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
     * Lists all PdmP17 models.
     * @return mixed
     */
   

    /**
     * Displays a single PdmP17 model.
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
     * Creates a new PdmP17 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        return $this->redirect(['update']);
        // $model = new PdmP17();

        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //     return $this->redirect(['view', 'id' => $model->id_p17]);
        // } else {
        //     return $this->render('create', [
        //         'model' => $model,
        //     ]);
        // }
    }

    /**
     * Updates an existing PdmP17 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionIndex()
    {
		$connection = \Yii::$app->db;
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P17 ]); //copy 2
        $session = new Session();
        
        $id         = $session->get('id_perkara');
        $model      = $this->findModel($id);
        $modelView  = $this->findModelView($id);
        if($model == null)
        {            
            $model = new PdmP17();
			$file_lama = '';
        }else{
			$file_lama = $model->getOldAttributes()['file_upload'];
		}
        if($modelView == null){            
            $model = new PdmP17();
        }
        else
        {
            $model = $modelView;
        }
        
        $modelTersangka = $this->findModelTersangka($id);
        $modelSpdp = $this->findModelSpdp($id);
		$get_p16 = Yii::$app->db->createCommand("select id_p16,max(created_time)  from pidum.pdm_p16 WHERE id_perkara='".$id."' group by id_perkara , id_p16")->queryOne();
		$modelJpu = PdmJaksaP16::find()->where(['id_p16' => $get_p16['id_p16']])->orderBy('no_urut asc')->all();
        

		
		$sql_tersangka = " select nama, to_char(tgl_lahir,'DD-MM-YYYY') tgl_lahir, umur, case when id_jkl='1' then 'Laki-Laki' when id_jkl = '2' then 'Perempuan' else '' end as jns_kelamin
from pidum.ms_tersangka where nama NOT IN (SELECT nama FROM pidum.ms_tersangka_pt WHERE id_perkara = '".$id."') AND id_perkara = '".$id."'";
		$model_tersangka = $connection->createCommand($sql_tersangka);
	    $dataProviderTersangka = $model_tersangka->queryAll();
       
		
        if ($model->load(Yii::$app->request->post())) {
			
            
			//$id_p16 = Yii::$app->db->createCommand(" select max(id_p16) id_p16 from pidum.pdm_p16 where id_perkara='".$id."' ")->queryScalar();

            $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_p17', 'id_p17', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();
			
			$files = UploadedFile::getInstance($model, 'file_upload');
			
			if ($files != false && !empty($files) ) {
				if($file_lama !=''){
					$model->file_upload = preg_replace('/[^A-Za-z0-9\-]/', '',$id) . '/p17.'. $files->extension;
					$path = Yii::$app->basePath . '/web/template/pidum_surat/' . preg_replace('/[^A-Za-z0-9\-]/', '',$id) . '/p17.'.$files->extension;
					$files->saveAs($path);
				}else{
					$model->file_upload = preg_replace('/[^A-Za-z0-9\-]/', '',$id) . '/p17.'. $files->extension;
					$path = Yii::$app->basePath . '/web/template/pidum_surat/' . preg_replace('/[^A-Za-z0-9\-]/', '',$id) . '/p17.'.$files->extension;
					$files->saveAs($path);
				}
			}else{
				$model->file_upload = $file_lama;
			}

            if($model->id_perkara != null){
   
				$model->updated_by=(string)Yii::$app->user->identity->peg_nip;
				$model->updated_time=date('Y-m-d H:i:s');
				$model->updated_ip=(string)$_SERVER['REMOTE_ADDR'];
				if($_POST['hdn_nama_penandatangan'] != ''){
					$model->nama = $_POST['hdn_nama_penandatangan'];
					$model->pangkat = $_POST['hdn_pangkat_penandatangan'];
					$model->jabatan = $_POST['hdn_jabatan_penandatangan'];
				}
                if(!$model->update()){
					var_dump($model->getErrors());exit;
				}
                
            }else{
                $model->id_perkara = $id;
                //$model->id_p16 = $id_p16;
                $model->id_p17 = $id."|".$_POST['PdmP17']['no_surat'];
				$model->created_by=(string)Yii::$app->user->identity->id;
				$model->created_ip=(string)$_SERVER['REMOTE_ADDR'];
				if($_POST['hdn_nama_penandatangan'] != ''){
					$model->nama = $_POST['hdn_nama_penandatangan'];
					$model->pangkat = $_POST['hdn_pangkat_penandatangan'];
					$model->jabatan = $_POST['hdn_jabatan_penandatangan'];
				}
                if(!$model->save()){
					var_dump($model->getErrors());exit;
				}

               // $NextProcces = array(ConstSysMenuComponent::CekBerkas);
                //Yii::$app->globalfunc->getNextProcces($model->id_perkara,$NextProcces);
				
				$jml_is_akhir = Yii::$app->db->createCommand(" select count(*) from pidum.pdm_status_surat where id_sys_menu = 'P-17' and id_perkara='".$id."' ")->queryScalar();
				if($jml_is_akhir < 1){
					Yii::$app->db->createCommand("UPDATE pidum.pdm_status_surat SET is_akhir='0' WHERE  id_perkara=:id")
					->bindValue(':id', $id)
					->execute();
					Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara,GlobalConstMenuComponent::P17);
					
				}
                
            }
			
			if ($files != false && !empty($files) ) {
					$path = Yii::$app->basePath . '/web/template/pidum_surat/' . preg_replace('/[^A-Za-z0-9\-]/', '',$id) . '/p17.'.$files->extension;
					$files->saveAs($path);
			}
			
			$id_p17 = $id."|".$_POST['PdmP17']['no_surat'];
			PdmTembusanP17::deleteAll(['id_p17' => $id_p17]);			
			if(isset($_POST['new_tembusan'])){
				 for($i = 0; $i < count($_POST['new_tembusan']); $i++){
					$modelNewTembusan= new PdmTembusanP17();
					$modelNewTembusan->id_p17 = $id_p17;
					$modelNewTembusan->id_tembusan = $id_p17."|".($i+1);				
					$modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
					$modelNewTembusan->no_urut=($i+1);	   
					if(!$modelNewTembusan->save()){
						var_dump($modelNewTembusan->getErrors());exit;
					}
        		}
        	}
            
            if($model->save()){
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
                //return $this->redirect('index');
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelTersangka' => $modelTersangka,
                'modelSpdp' => $modelSpdp,
                'sysMenu' => $sysMenu, 
				'modelJpu' => $modelJpu,
				'dataProviderTersangka' => $dataProviderTersangka
            ]);
        }
    }

    public function actionCetak($id){
		
        
        $connection = \Yii::$app->db;
        $odf = new \Odf(Yii::$app->params['report-path']."web/template/pidum/p17.odt");
        
        $model = PdmP17::findOne(['id_p17' => $id]);
        $sifat = \app\models\MsSifatSurat::findOne(['id'=>$model->sifat]);
        $spdp = PdmSpdp::findOne(['id_perkara' => $model->id_perkara]);
$pangkat = PdmPenandatangan::find()
->select ("a.jabatan as jabatan")
->from ("pidum.pdm_penandatangan a")
->join ('inner join','pidum.pdm_p17 b','a.peg_nik = b.id_penandatangan')
->where ("id_p17='".$id."'")
->one();

$ttd = PdmPenandatangan::find()
->select ("a.nama as nama,a.pangkat as pangkat,a.peg_nik as peg_nik")
->from ("pidum.pdm_penandatangan a")
->join ('inner join','pidum.pdm_p17 b','a.peg_nik = b.id_penandatangan')
->where ("id_p17='".$id."'")
->one();
        $odf->setVars('Kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
		$rb = $model->sifat;
		if ($rb==2){
			 $odf->setVars('s','R. ');
		}else{
			$odf->setVars('s','B. ');
		}
		
        $odf->setVars('nomor', $model->no_surat);
        $odf->setVars('sifat', $sifat->nama);
        $odf->setVars('lampiran', $model->lampiran);
        $odf->setVars('dikeluarkan', ucfirst(strtolower($model->dikeluarkan)));
        $odf->setVars('tanggal_dikeluarkan', Yii::$app->globalfunc->ViewIndonesianFormat( $model->tgl_dikeluarkan));
        $odf->setVars('kepada', $model->kepada);
        $odf->setVars('di_tempat', $model->di_kepada);
        $odf->setVars('nomor_spdp', $spdp->no_surat);
        $odf->setVars('tgl_spdp', Yii::$app->globalfunc->ViewIndonesianFormat( $spdp->tgl_surat));
        $odf->setVars('tgl_terima', Yii::$app->globalfunc->ViewIndonesianFormat( $spdp->tgl_terima));
        
        #list pasal
        $odf->setVars('pasal', $spdp->undang_pasal);
       
        #list Tersangka
        //$dft_tersangka =Yii::$app->globalfunc->getDaftarTerdakwa($model->id_perkara);
		$dft_tersangka = Yii::$app->globalfunc->getListTerdakwa($model->id_perkara); //bowo #20 juni 2016
        $odf->setVars('tersangka', $dft_tersangka);    

        $daftarTersangka = Yii::$app->globalfunc->getListTerdakwa($model->id_perkara);
        $odf->setVars('peri', $daftarTersangka);	
        
        #tembusan
		$query = new Query;
        $query->select('*')
                ->from('pidum.pdm_tembusan_p17')
                ->where("id_p17='".$id."' ")
                ->orderBy('no_urut');
        $dt_tembusan = $query->createCommand();
        $listTembusan = $dt_tembusan->queryAll();
        $dft_tembusan = $odf->setSegment('tembusan');
		//Danar Urutan tembusan 17-06-2016
        $i=1;
        foreach($listTembusan as $element){
                $dft_tembusan->urutan_tembusan($i++);
                $dft_tembusan->nama_tembusan($element['tembusan']);
                $dft_tembusan->merge();
        }
        $odf->mergeSegment($dft_tembusan);

        //$odf->setVars('kepala', $pangkat->jabatan);

        #penanda tangan
       /*  $sql ="SELECT a.nama,a.pangkat,a.jabatan,c.peg_nip_baru FROM "
                . " pidum.pdm_penandatangan a, pidum.pdm_p17 b , kepegawaian.kp_pegawai c "
                . "where a.peg_nik = b.id_penandatangan and b.id_penandatangan =c.peg_nik and b.id_perkara='".$model->id_perkara."'"; */
			$sql ="SELECT a.nama,a.pangkat,a.jabatan,a.id_penandatangan FROM "
                . "  pidum.pdm_p17 a "
                . "where a.id_perkara='".$model->id_perkara."'";
				
        $model = $connection->createCommand($sql);
	   $penandatangan = $model->queryOne();
        $pangkat = explode('/', $penandatangan['pangkat']);
        $odf->setVars('nama_penandatangan', $penandatangan['nama']);       
        $odf->setVars('pangkat', $penandatangan['pangkat']);       
        $odf->setVars('nip_penandatangan', $penandatangan['id_penandatangan']);       
        $odf->setVars('jabatan', $penandatangan['jabatan']);       
                
        $odf->exportAsAttachedFile('p17.odt');
    }

    /**
     * Deletes an existing PdmP17 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
	 
    public function actionDeleteIt()
    {
		$id = $_GET['id'];
		
		
		$session = new Session();
		$id_perkara = $session->get('id_perkara');
		
		$connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try {
			PdmStatusSurat::deleteAll(['id_perkara' => $id_perkara,'id_sys_menu'=>'P-17']);
			
			Yii::$app->db->createCommand("UPDATE pidum.pdm_status_surat SET is_akhir='1' WHERE (id_sys_menu = 'P-16') AND id_perkara=:id")
			->bindValue(':id', $id_perkara)
			->execute();
			
			PdmP17::deleteAll(['id_p17' => $id]);
			Yii::$app->getSession()->setFlash('success', [
				 'type' => 'success',
				 'duration' => 3000,
				 'icon' => 'fa fa-users',
				 'message' => 'Data Berhasil di Hapuss',
				 'title' => 'Hapus Data',
				 'positonY' => 'top',
				 'positonX' => 'center',
				 'showProgressbar' => true,
				 ]);
			$transaction->commit(); 
		} catch(Exception $e) {
			var_dump($e);exit;
			$transaction->rollback();
		}
		return $this->redirect(['update']);
    }

	 public function actionJpu ()
	 {
		 $searchModel = new VwJaksaPenuntutSearch();
    	$dataProvider = $searchModel->search2(Yii::$app->request->queryParams);
    	$dataProvider->pagination->pageSize=10;
    	return $this->renderAjax('_jpu', [
    			'searchModel' => $searchModel,
    			'dataProvider' => $dataProvider,
    	]);
	 }
    /**
     * Finds the PdmP17 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmP17 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmP17::findOne(['id_perkara' => $id])) !== null) {
            return $model;
        }/* else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }*/
    }
    //BEGIN ETRIO WIDODO
    protected function findModelView($id)
    {
        
        if (($modelView = PdmP17::find()->where("id_perkara='".$id."'")->one()) !== null) {
            return $modelView;
        }
    }
     //END ETRIO WIDODO
    protected function findModelTersangka($id)
    {
        if (($model = MsTersangka::findAll(['id_perkara' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelSpdp($id)
    {
        if (($modelSpdp = PdmSpdp::findOne($id)) !== null) {
            return $modelSpdp;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
