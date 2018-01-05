<?php

namespace app\modules\pdsold\controllers;


use Yii;
use app\models\MsAgama;
use app\models\MsJkl;
use app\models\MsPendidikan;
use app\models\MsWarganegara;
use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\MsPenyidik;
use app\modules\pdsold\models\MsTersangka;
use app\modules\pdsold\models\PdmBA3Search;
use app\modules\pdsold\models\PdmBa3;
use app\modules\pdsold\models\PdmJaksaPenerima;
use app\modules\pdsold\models\PdmJaksaSaksi;
use app\modules\pdsold\models\PdmJpu;
use app\modules\pdsold\models\PdmMsSaksiAhli;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmSysMenu;
use app\modules\pdsold\models\PdmTrxPemrosesan;
use app\modules\pdsold\models\VwJaksaPenuntutSearch;
use kartik\widgets\ActiveForm;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;

/**
 * PdmBA3Controller implements the CRUD actions for PdmBA3 model.
 */
class PdmBa3Controller extends Controller
{
    public $sysMenu;
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

    public function init() {
        $this->sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA3]);
    }

    /**
     * Lists all PdmBA3 models.
     * @return mixed
     */
    public function actionIndex()
    {
		$idPerkara = Yii::$app->session->get('id_perkara');
		
        $searchModel = new PdmBA3Search();
        $dataProvider = $searchModel->search($idPerkara, Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'sysMenu' => $this->sysMenu
        ]);
    }

    /**
     * Displays a single PdmBA3 model.
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
     * Creates a new PdmBA3 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		   $session = new Session();
		   $id_perkara = $session->get('id_perkara');
		   $model = new PdmBa3();
		   $modelMsSaksi = new PdmMsSaksiAhli();
		   
		   $modelTersangka = $this->findModelTersangka($id_perkara);
		   $modelSpdp = $this->findModelSpdp($id_perkara);
		   $modelpenyidik = PdmJaksaPenerima::findAll(['id_perkara' => $model->id_perkara, 'code_table' => GlobalConstMenuComponent::BA3, 'id_table' => $model->id_ba3]);
		   
		   if ($modelpenyidik == null) {
            $modelpenyidik = new PdmJaksaPenerima();
        }
		
		$modeljaksi = PdmJaksaSaksi::findAll(['id_perkara' => $model->id_perkara, 'code_table' => GlobalConstMenuComponent::BA3, 'id_table' => $model->id_ba3]);
		
		 if ($modeljaksi == null) {
            $modeljaksi = new PdmJaksaSaksi();
        }
		$searchJPU = new VwJaksaPenuntutSearch();
        $dataJPU = $searchJPU->search2(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;
		
		$modelMsSaksi = PdmMsSaksiAhli::findOne(['id_saksi_ahli' => $model->id_ms_saksi_ahli]);
        if ($modelMsSaksi == null) {
            $modelMsSaksi = new PdmMsSaksiAhli();
        }
		
		if ($model->load(Yii::$app->request->post())) {
			
			$seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_ba3', 'id_ba3', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
			
			if ($modelMsSaksi->id_saksi_ahli == null) {
                $id_perkara_MsSaksiAhli = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_ms_saksi_ahli', 'id_saksi_ahli', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                $modelMsSaksi = new PdmMsSaksiAhli();
                $modelMsSaksi->id_saksi_ahli = $id_perkara_MsSaksiAhli['generate_pk'];
                $modelMsSaksi->nama = $_POST['PdmMsSaksiAhli']['nama'];
                $modelMsSaksi->tmpt_lahir = $_POST['PdmMsSaksiAhli']['tmpt_lahir'];
                $modelMsSaksi->tgl_lahir = $_POST['PdmMsSaksiAhli']['tgl_lahir'];
                $modelMsSaksi->id_jkl = $_POST['PdmMsSaksiAhli']['id_jkl'];
                $modelMsSaksi->alamat = $_POST['PdmMsSaksiAhli']['alamat'];
                $modelMsSaksi->warganegara = $_POST['PdmMsSaksiAhli']['warganegara'];
                $modelMsSaksi->id_agama = $_POST['PdmMsSaksiAhli']['id_agama'];
                $modelMsSaksi->pekerjaan = $_POST['PdmMsSaksiAhli']['pekerjaan'];
                $modelMsSaksi->id_pendidikan = $_POST['PdmMsSaksiAhli']['id_pendidikan'];
                $modelMsSaksi->save();
            } else {
				$modelMsSaksi = PdmMsSaksiAhli::findOne(['id_saksi_ahli' => $model->id_ms_saksi_ahli]);
                $modelMsSaksi->flag = '2';
                $modelMsSaksi->nama = $_POST['PdmMsSaksiAhli']['nama'];
                $modelMsSaksi->tmpt_lahir = $_POST['PdmMsSaksiAhli']['tmpt_lahir'];
                $modelMsSaksi->tgl_lahir = $_POST['PdmMsSaksiAhli']['tgl_lahir'];
                $modelMsSaksi->id_jkl = $_POST['PdmMsSaksiAhli']['id_jkl'];
                $modelMsSaksi->alamat = $_POST['PdmMsSaksiAhli']['alamat'];
                $modelMsSaksi->warganegara = $_POST['PdmMsSaksiAhli']['warganegara'];
                $modelMsSaksi->id_agama = $_POST['PdmMsSaksiAhli']['id_agama'];
                $modelMsSaksi->pekerjaan = $_POST['PdmMsSaksiAhli']['pekerjaan'];
                $modelMsSaksi->id_pendidikan = $_POST['PdmMsSaksiAhli']['id_pendidikan'];
                $modelMsSaksi->update();
            }
			
			if ($model->id_ba3 != null) {
                $model->lokasi = $_POST['PdmBa3']['lokasi'];
                $model->flag ='2';
                $model->save();
            } else {
                $model->id_perkara = $id_perkara;
                $model->id_ba3 = $seq['generate_pk'];
				$model->lokasi = $_POST['PdmBa3']['lokasi'];
                $model->id_ms_saksi_ahli = $modelMsSaksi->id_saksi_ahli;
                $model->save();

                Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara, GlobalConstMenuComponent::BA3);
            }
			
			//Jaksa Penyidik
            PdmJaksaPenerima::deleteAll(['id_perkara' => $model->id_perkara, 'code_table' => GlobalConstMenuComponent::BA3, 'id_table' => $model->id_ba3]);
            if (isset($_POST['nip'])) {
                foreach ($_POST['nip'] as $key) {
                    $query = new Query;
                    $query->select('*')
                            ->from('pidum.vw_jaksa_penuntut')
                            ->where("peg_instakhir='" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "' and peg_nik='" . $key . "'");
                    $command = $query->createCommand();
                    $data = $command->queryAll();
                    $seqjpp = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_jaksa_penerima', 'id_jpp', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();

                    $modelpenyidik = new PdmJaksaPenerima();
                    $modelpenyidik->id_jpp = $seqjpp['generate_pk'];
                    $modelpenyidik->id_perkara = $id_perkara;
                    $modelpenyidik->code_table = GlobalConstMenuComponent::BA3;
                    $modelpenyidik->id_table = $model->id_ba3;
                    $modelpenyidik->flag = '1';
                    $modelpenyidik->nama = $data[0]['peg_nama'];
                    $modelpenyidik->nip = $data[0]['peg_nip'];
                    $modelpenyidik->jabatan = $data[0]['jabatan'];
                    $modelpenyidik->pangkat = $data[0]['pangkat'];

                    $modelpenyidik->save();
                }
            }
			
			//Jaksa Saksi
            PdmJaksaSaksi::deleteAll(['id_perkara' => $model->id_perkara, 'code_table' => GlobalConstMenuComponent::BA3, 'id_table' => $model->id_ba3]);
            if (isset($_POST['txtnip'])) {
                foreach ($_POST['txtnip'] as $key) {
                    $query = new Query;
                    $query->select('*')
                            ->from('pidum.vw_jaksa_penuntut')
                            ->where("peg_instakhir='" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "' and peg_nik='" . $key . "'");
                    $command = $query->createCommand();
                    $data = $command->queryAll();
                    $seqjpp = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_jaksa_saksi', 'id_jpp', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();

                    $modeljaksi = new PdmJaksaSaksi();
                    $modeljaksi->id_jpp = $seqjpp['generate_pk'];
                    $modeljaksi->id_perkara = $id_perkara;
                    $modeljaksi->code_table = GlobalConstMenuComponent::BA3;
                    $modeljaksi->id_table = $model->id_ba3;
                    $modeljaksi->flag = '1';
                    $modeljaksi->nama = $data[0]['peg_nama'];
                    $modeljaksi->nip = $data[0]['peg_nip'];
                    $modeljaksi->jabatan = $data[0]['jabatan'];
                    $modeljaksi->pangkat = $data[0]['pangkat'];

                    $modeljaksi->save();
                }
            }
			
			//notifkasi simpan
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
            return $this->redirect('index');
        } else {
            return $this->render('update', [
                        'model' => $model,
						'searchJPU' => $searchJPU,
						'dataJPU' => $dataJPU,
						'modeljaksi' => $modeljaksi, 
						'modelpenyidik' =>$modelpenyidik,
						'modelTersangka' => $modelTersangka,
						'modelSpdp' => $modelSpdp,
						'modelMsSaksi'=>$modelMsSaksi,
						'sysMenu' => $this->sysMenu,
                        'id' => $model->id_ba3,
            ]);
        }
			
	
	}
	
    /**
     * Updates an existing PdmBA3 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate()
    {
		$session = new Session();
		$id = $session->get('id_perkara');
		$model = $this->findModel($id);
		
		if($model == null){
        $model = new PdmBA3();
		}
		
		$modelMsSaksi = new PdmMsSaksiAhli();
	
		$modelTersangka = $this->findModelTersangka($id);
        $modelSpdp = $this->findModelSpdp($id);
		
		//$model->id_ms_saksi_ahli=$_POST['PdmMsSaksiAhli']['id_ms_saksi_ahli'];
		
        //Jaksa Penyidik
        $modelpenyidik = PdmJaksaPenerima::findAll(['id_perkara' => $model->id_perkara, 'code_table' => GlobalConstMenuComponent::BA3, 'id_table' => $model->id_ba3]);

        if ($modelpenyidik  == null) {
           $modelpenyidik  = new PdmJaksaPenerima();
        }
		
		//Jaksa saksi
		$modeljaksi = PdmJaksaSaksi::findAll(['id_perkara' => $model->id_perkara, 'code_table' => GlobalConstMenuComponent::BA3, 'id_table' => $model->id_ba3]);

        if ($modeljaksi == null) {
            $modeljaksi = new PdmJaksaSaksi();
        }
		
		$searchJPU = new VwJaksaPenuntutSearch();
        $dataJPU = $searchJPU->search2(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;
		
		$modelMsSaksi = PdmMsSaksiAhli::findOne(['id_saksi_ahli' => $model->id_ms_saksi_ahli]);
		if ($modelMsSaksi == null) {
            $modelMsSaksi = new PdmMsSaksiAhli();
        }
		
		if ($model->load(Yii::$app->request->post())) {
		$id_ba3 = Pdmba3::findOne(['id_perkara' => $id]);
		$seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_ba3', 'id_ba3', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();
	
		$id_MsSaksiAhli = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_ms_saksi_ahli', 'id_saksi_ahli', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
			
			if($model->id_perkara != null){
			$model->update();
				$modelMsSaksi->flag = '2';
				$modelMsSaksi->nama = $_POST['PdmMsSaksiAhli']['nama'];
				$modelMsSaksi->tmpt_lahir = $_POST['PdmMsSaksiAhli']['tmpt_lahir'];
				$modelMsSaksi->tgl_lahir = $_POST['PdmMsSaksiAhli']['tgl_lahir'];
				$modelMsSaksi->id_jkl = $_POST['PdmMsSaksiAhli']['id_jkl'];
				$modelMsSaksi->alamat = $_POST['PdmMsSaksiAhli']['alamat'];
				$modelMsSaksi->warganegara = $_POST['PdmMsSaksiAhli']['warganegara'];
				$modelMsSaksi->id_agama = $_POST['PdmMsSaksiAhli']['id_agama'];
				$modelMsSaksi->pekerjaan = $_POST['PdmMsSaksiAhli']['pekerjaan'];
				$modelMsSaksi->id_pendidikan = $_POST['PdmMsSaksiAhli']['id_pendidikan'];
				$modelMsSaksi->save();
			
        }else{
				
				$modelMsSaksi = new PdmMsSaksiAhli();
				$modelMsSaksi->id_saksi_ahli = $id_MsSaksiAhli['generate_pk'];
				$modelMsSaksi->nama = $_POST['PdmMsSaksiAhli']['nama'];
				$modelMsSaksi->tmpt_lahir = $_POST['PdmMsSaksiAhli']['tmpt_lahir'];
				$modelMsSaksi->tgl_lahir = $_POST['PdmMsSaksiAhli']['tgl_lahir'];
				$modelMsSaksi->id_jkl = $_POST['PdmMsSaksiAhli']['id_jkl'];
				$modelMsSaksi->alamat = $_POST['PdmMsSaksiAhli']['alamat'];
				$modelMsSaksi->warganegara = $_POST['PdmMsSaksiAhli']['warganegara'];
				$modelMsSaksi->id_agama = $_POST['PdmMsSaksiAhli']['id_agama'];
				$modelMsSaksi->pekerjaan = $_POST['PdmMsSaksiAhli']['pekerjaan'];
				$modelMsSaksi->id_pendidikan = $_POST['PdmMsSaksiAhli']['id_pendidikan'];
				$modelMsSaksi->save();
				
				
				
				$model->id_ms_saksi_ahli = $id_MsSaksiAhli['generate_pk'];
				$modelMsSaksi->id_pendidikan = $_POST['PdmMsSaksiAhli']['id_pendidikan'];
				$modelMsSaksi = new PdmMsSaksiAhli();
				$modelMsSaksi->id_saksi_ahli = $idMsSaksiAhli;
				$modelMsSaksi->nama = $_POST['PdmMsSaksiAhli']['nama'];
				$modelMsSaksi->tmpt_lahir = $_POST['PdmMsSaksiAhli']['tmpt_lahir'];
				$modelMsSaksi->tgl_lahir = $_POST['PdmMsSaksiAhli']['tgl_lahir'];
				$modelMsSaksi->id_jkl = $_POST['PdmMsSaksiAhli']['id_jkl'];
				$modelMsSaksi->alamat = $_POST['PdmMsSaksiAhli']['alamat'];
				$modelMsSaksi->warganegara = $_POST['PdmMsSaksiAhli']['warganegara'];
				$modelMsSaksi->id_agama = $_POST['PdmMsSaksiAhli']['id_agama'];
				$modelMsSaksi->pekerjaan = $_POST['PdmMsSaksiAhli']['pekerjaan'];
				$modelMsSaksi->id_pendidikan = $_POST['PdmMsSaksiAhli']['id_pendidikan'];
				$modelMsSaksi->save();
        }
		
		if ($model->id_ba3 != null) {
                $model->lokasi = $_POST['PdmBa3']['lokasi'];
                $model->flag ='2';
                $model->update();
            } else {
                $model->id_perkara = $id_perkara;
                $model->id_ba3 = $seq['generate_pk'];
                $model->id_ms_saksi_ahli = $modelMsSaksi->id_saksi_ahli;
                $model->save();

                Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara, GlobalConstMenuComponent::BA3);
            }
		
		//Jaksa Penyidik
		PdmJaksaPenerima::deleteAll(['id_perkara' => $model->id_perkara, 'code_table' => GlobalConstMenuComponent::BA3, 'id_table' => $model->id_ba3]);
            if (isset($_POST['nip'])) {
            foreach ($_POST['nip'] as $key) {
            $query = new Query;
            $query->select('*')
            ->from('pidum.vw_jaksa_penuntut')
            ->where("peg_instakhir='" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "' and peg_nik='" . $key . "'");
                    $command = $query->createCommand();
                    $data = $command->queryAll();
                    $seqjpp = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_jaksa_penerima', 'id_jpp', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
					
					$modelpenyidik  = new PdmJaksaPenerima();
				    $modelpenyidik ->id_jpp = $seqjpp['generate_pk'];
					$modelpenyidik ->id_perkara = $id;
                    $modelpenyidik ->code_table = GlobalConstMenuComponent::BA3;
					$modelpenyidik ->id_table = $model->id_ba3;
					$modelpenyidik ->flag = '1';
                    $modelpenyidik ->nama = $data[0]['peg_nama'];
					$modelpenyidik ->nip = $data[0]['peg_nip'];
                    $modelpenyidik ->jabatan = $data[0]['jabatan'];
                    $modelpenyidik ->pangkat = $data[0]['pangkat'];
					$modelpenyidik->save();
					
				}
			}
			
			//Jaksa Saksi
		 PdmJaksaSaksi::deleteAll(['id_perkara' => $model->id_perkara, 'code_table' => GlobalConstMenuComponent::BA3, 'id_table' => $model->id_ba3]);
            if (isset($_POST['txtnip'])) {
            foreach ($_POST['txtnip'] as $key) {
            $query = new Query;
            $query->select('*')
                            ->from('pidum.vw_jaksa_penuntut')
                            ->where("peg_instakhir='" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "' and peg_nik='" . $key . "'");
                    $command = $query->createCommand();
                    $data = $command->queryAll();
                    $seqjpp = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_jaksa_saksi', 'id_jpp', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
					
                    $modeljaksi = new PdmJaksaSaksi();
				    $modeljaksi->id_jpp = $seqjpp['generate_pk'];
					$modeljaksi->id_perkara = $id;
                    $modeljaksi->code_table = GlobalConstMenuComponent::BA3;
                    $modeljaksi->id_table = $model->id_ba3;
                    $modeljaksi->flag = '1';
                    $modeljaksi->nama = $data[0]['peg_nama'];
                    $modeljaksi->nip = $data[0]['peg_nip'];
                    $modeljaksi->jabatan = $data[0]['jabatan'];
                    $modeljaksi->pangkat = $data[0]['pangkat'];
					
                    $modeljaksi->save();
					
				}
			}
			
			//Saksi			
			if($modelMsSaksi->id_saksi_ahli == null){
			}else{
			}
				
			/* $trxPemroresan = PdmTrxPemrosesan::findOne(['id_perkara' => $id]);
            $trxPemroresan->id_perkara = $id;
            $trxPemroresan->id_sys_menu = "61";
            $trxPemroresan->id_user_login = Yii::$app->user->identity->username;
            $trxPemroresan->update(); */
			
			//notifkasi simpan
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
			
			//return $this->redirect(['update','id'=>$model->id_perkara]);
			return $this->redirect(['update','id'=>$id]);
			//return $this->redirect(['view', 'id' => $model->id_ba3]);
			
			} else {
            return $this->render('update', [
                'model' => $model,
				'searchJPU' => $searchJPU,
				'dataJPU' => $dataJPU,
				'modeljaksi' => $modeljaksi, 
				'modelpenyidik' =>$modelpenyidik,
				'modelTersangka' => $modelTersangka,
				'modelSpdp' => $modelSpdp,
				'modelMsSaksi'=>$modelMsSaksi,
				'sysMenu' => $this->sysMenu,
				'id' => $id,
				]);
    }
	
	}
	
    /**
     * Deletes an existing PdmBA3 model.
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
				
				PdmBa3::updateAll(['flag' => '3'], "id_perkara = '" . $id_perkara . "'");
            }else{
                for($i=0;$i<count($id);$i++){
                    PdmBa3::updateAll(['flag' => '3'], "id_ba3 = '" . $id[$i] . "'");
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

    /**
     * Finds the PdmBA3 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmBA3 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
	 
	 public function actionCetak ($id_ba3)
	{
		$connection = \Yii::$app->db;
        $odf = new \Odf(Yii::$app->params['report-path']."modules/pdsold/template/ba3.odt");

		$ba3 = PdmBA3::findOne(['id_ba3' => $id_ba3]);
        $spdp = PdmSpdp::findOne(['id_perkara' => $id_ba3->id_perkara]);
        
		$odf->setVars('Kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
		$odf->setVars('tgl_pembuatan', Yii::$app->globalfunc->getTanggalBeritaAcara($ba3->tgl_pembuatan));  //Yii::$app->globalfunc->ViewIndonesianFormat( $ba3->tgl_pembuatan));
		$odf->setVars('hari', strtolower(Yii::$app->globalfunc->GetNamaHari( $ba3->tgl_pembuatan)));
        $odf->setVars('jam', $ba3->jam);
        $odf->setVars('lokasi', $ba3->lokasi);
		
		$jaksa_saksi=PdmJaksaSaksi::findOne(['id_perkara'=> $id]);
		$penyidik = MsPenyidik::findOne(["id_penyidik" => $spdp->id_penyidik]);
		$MSsaksiAhli=PdmMsSaksiAhli::findOne(['id_saksi_ahli'=>$ba3->id_ms_saksi_ahli]);
		$MsAgama=MsAgama::findOne(['id_agama'=> $MSsaksiAhli->id_agama]);
		$MsPendidikan=MsPendidikan::findOne(['id_pendidikan'=> $MSsaksiAhli->id_pendidikan]);
		if(!$MSsaksiAhli->id_pendidikan){
			$Mspendidikan = '-';
		}else{
			$Mspendidikan = $Mspendidikan->nama;
		}
		
		$MsJkl=MsJkl::findOne(['id_jkl'=> $MSsaksiAhli->id_jkl]);
		if(!$MSsaksiAhli->id_jkl){
			$jnsklmn = '-';
		}else{
			$jnsklmn = $MsJkl->nama;
		}
		
		$MsWarganegara=MsWarganegara::findOne(['id'=> $MSsaksiAhli->warganegara]);
		/*if(!$MSsaksiAhli->warganegara){
			$MsWarganegara = '-';
		}else{
			$Mswarganegara = $Mswarganegara->nama;
		}*/

		$sql ="SELECT tersangka.* FROM "
                . " pidum.pdm_ba3 ba3 LEFT OUTER JOIN pidum.vw_tersangka tersangka ON (ba3.id_perkara = tersangka.id_perkara ) "
                . "WHERE ba3.id_perkara='".$id."' "
                . "ORDER BY id_tersangka "
                . "LIMIT 1 ";
        $model = $connection->createCommand($sql);
        $tersangka = $model->queryOne();
        if($tersangka['tgl_lahir']){
        $umur = Yii::$app->globalfunc->datediff($tersangka['tgl_lahir'],date("Y-m-d"));
        $tgl_lahir = $umur['years'].' tahun / '.Yii::$app->globalfunc->ViewIndonesianFormat($tersangka['tgl_lahir']);  
        }else{
            $tgl_lahir = '-';
        }
		$odf->setVars('namaAhli', $MSsaksiAhli->nama);
		$odf->setVars('tmpt_lahir', $MSsaksiAhli->tmpt_lahir);
		$odf->setVars('tgl_lahir',$tgl_lahir);
		$odf->setVars('jenis_kelamin', $jnsklmn);
		$odf->setVars('warganegara', $Mswarganegara->nama);
		$odf->setVars('tmpt_tinggal', $MSsaksiAhli->alamat);
		$odf->setVars('agama', $MsAgama->nama);
		$odf->setVars('pekerjaan', $MSsaksiAhli->pekerjaan);
		$odf->setVars('pendidikan', $Mspendidikan->nama);
		
		$odf->setVars('kepercayaan', $MsAgama->nama);
		
		#Jaksa Penerima
		$jaksaPenerima = "select a.nama, a.pangkat, a.jabatan, b.peg_nip_baru from pidum.pdm_jaksa_penerima a, kepegawaian.kp_pegawai b where a.nip = b.peg_nip"
                . " and a.code_table = '" . GlobalConstMenuComponent::BA3 . "' and a.id_perkara='" . $ba3->id_perkara . "' and a.id_table='" . $ba3->id_ba3 . "'";
        $jaksaPenerima = $connection->createCommand($jaksaPenerima);
        $jaksaPenerima = $jaksaPenerima->queryOne();
        /*$i = 1;
        $dft_jaksaPenerima = $odf->setSegment('jaksaPenerima');
        foreach ($jaksaPenerima as $key) {
            $dft_jaksaPenerima->urutan($i);
            $dft_jaksaPenerima->nama_pegawai($key['nama']);
            $dft_jaksaPenerima->nip($key['peg_nip_baru']);
            $dft_jaksaPenerima->pangkat($key['pangkat']);
            $dft_jaksaPenerima->jabatan($key['jabatan']);
            $dft_jaksaPenerima->merge();
            $i++;
        }

        $odf->mergeSegment($dft_jaksaPenerima);*/
		
		$pangkat = explode('/', $jaksaPenerima['pangkat']);
		$odf->setVars('mengambil_sumpah', $jaksaPenerima['nama']);
		$odf->setVars('nama_pegawai', $jaksaPenerima['nama']);
		$odf->setVars('nip', $jaksaPenerima['peg_nip_baru']);
		$odf->setVars('pangkat', $pangkat[0]);
		$odf->setVars('jabatan', $jaksaPenerima['jabatan']);
		$odf->setVars('JaksaPenyidik', $jaksaPenerima['nama']);
		
		//var_dump($jaksaPenerima['nama']);exit();
		
		#JaksaSaksi
		 $jaksaSaksi = "select a.nama, a.pangkat, a.jabatan, b.peg_nip_baru from pidum.pdm_jaksa_saksi a, kepegawaian.kp_pegawai b where a.nip = b.peg_nip"
                . " and a.code_table = '" . GlobalConstMenuComponent::BA3 . "' and a.id_perkara='" . $ba3->id_perkara . "' and a.id_table='" . $ba3->id_ba3 . "'";
        $jaksaSaksi = $connection->createCommand($jaksaSaksi);
        $jaksaSaksi = $jaksaSaksi->queryAll();
        $i = 1;
        $dft_jaksaSaksi = $odf->setSegment('jaksaSaksi');
        foreach ($jaksaSaksi as $key) {
            $dft_jaksaSaksi->urutan($i);
            $dft_jaksaSaksi->nama_pegawai($key['nama']);
            $dft_jaksaSaksi->nip($key['peg_nip_baru']);
            $pangkat = explode('/', $jaksaSaksi['pangkat']);
            $dft_jaksaSaksi->jabatan($key['jabatan']);
            $dft_jaksaSaksi->merge();
            $i++;
        }
		$odf->mergeSegment($dft_jaksaSaksi);
		
		#saksi
		 $jaksaSaksi = "select a.nama, a.pangkat, a.jabatan, b.peg_nip_baru from pidum.pdm_jaksa_saksi a, kepegawaian.kp_pegawai b where a.nip = b.peg_nip"
                . " and a.code_table = '" . GlobalConstMenuComponent::BA3 . "' and a.id_perkara='" . $ba3->id_perkara . "' and a.id_table='" . $ba3->id_ba3 . "'";
        $jaksaSaksi = $connection->createCommand($jaksaSaksi);
        $jaksaSaksi = $jaksaSaksi->queryAll();
        $dft_saksi = $odf->setSegment('saksi');
        foreach ($jaksaSaksi as $key) {
            $dft_saksi->nama_pegawai($key['nama']);
            $dft_saksi->merge();
        }

        $odf->mergeSegment($dft_saksi);
		
		#list Tersangka
        $dft_tersangka ='';
        $query = new Query;
        $query->select('*')
                ->from('pidum.ms_tersangka')
                ->where("id_perkara='".$id."'");
        $data = $query->createCommand();
        $listTersangka = $data->queryAll();  
        foreach($listTersangka as $key){			
            $dft_tersangka .= $key[nama].',';
        }
        $odf->setVars('tersangka', $dft_tersangka);  
		
		$odf->exportAsAttachedFile();	
		
	}
	
    protected function findModel($id)
    {
        if (($model = PdmBa3::findOne(['id_perkara' => $id])) !== null) {
            return $model;
        } 
    }
	
	protected function findModelTersangka($id)
    {
        if (($modelTersangka = MsTersangka::findAll(['id_perkara' => $id])) !== null) {
            return $modelTersangka;
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
