<?php

namespace app\modules\pdsold\controllers;

use Yii;
use app\modules\pdsold\models\PdmBa6;
use app\modules\pdsold\models\PdmBa6Search;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;
use app\modules\pdsold\models\PdmSysMenu;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmJaksaSaksi;
use app\modules\pdsold\models\PdmJaksaPenerima;
use app\modules\pdsold\models\KpPegawaiSearch;
use app\modules\pdsold\models\PdmP16a;
use app\modules\pdsold\models\VwJaksaPenuntutSearch;
use app\modules\pdsold\models\VwTerdakwaT2;
use app\modules\pdsold\models\PdmBa5Barbuk;
use app\modules\pdsold\models\PdmBa5;
use app\components\GlobalConstMenuComponent;

/**
 * PdmBa6Controller implements the CRUD actions for PdmBa6 model.
 */
class PdmBa6Controller extends Controller
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
     * Lists all PdmBa6 models.
     * @return mixed
     */
    public function actionIndex()
    {
		
		$session = new session();
		$no_register_perkara = $session->get('no_register_perkara');
		
        $searchModel = new PdmBa6Search();
        $dataProvider = $searchModel->search($no_register_perkara);
		$sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA6 ]);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sysMenu' => $sysMenu,
        ]);
    }

    /**
     * Displays a single PdmBa6 model.
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
     * Creates a new PdmBa6 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PdmBa6();
        $session = new session();
        $id_perkara = $session->get('id_perkara');
        $no_register_perkara = $session->get('no_register_perkara');
		
        $kd_wilayah = PdmSpdp::findOne($id_perkara)->wilayah_kerja;
        $wilayah = Yii::$app->globalfunc->getNamaSatker($kd_wilayah)->inst_nama;
		
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA6 ]);

        $listTersangka = VwTerdakwaT2::findAll(['no_register_perkara'=>$no_register_perkara]);
//        $data_barbuk  = PdmBa5Barbuk::findAll(['no_register_perkara'=>$no_register_perkara]);
        $listBarbuk = PdmBa5Barbuk::findAll(['no_register_perkara'=>$no_register_perkara]);
        $modelBarbuk = PdmBa5Barbuk::find()->where(['no_register_perkara'=>$no_register_perkara])
                                            ->orderBy('no_urut_bb')->all();

        if ($model->load(Yii::$app->request->post()) ) {
             $transaction = Yii::$app->db->beginTransaction();

            try {
            $model->no_register_perkara = $no_register_perkara;
            $model->created_time=date('Y-m-d H:i:s');
            $model->created_by=\Yii::$app->user->identity->peg_nip;
            $model->created_ip = \Yii::$app->getRequest()->getUserIP();
            $model->desk_barbuk = json_encode($_POST['barbuk']);
            $model->updated_by=\Yii::$app->user->identity->peg_nip;
            $model->updated_time=date('Y-m-d H:i:s');
            $model->updated_ip = \Yii::$app->getRequest()->getUserIP();
            
            $model->id_kejati = $session->get('kode_kejati');
            $model->id_kejari = $session->get('kode_kejari');
            $model->id_cabjari = $session->get('kode_cabjari');

            $jaksa = array();
            $jaksa['urut'] = $_POST['no_urut_penerima'];
            $jaksa['nip'] = $_POST['nip_baru_penerima'];
            $jaksa['nama'] = $_POST['nama_jpu_penerima'];
            $jaksa['gol'] = $_POST['gol_jpu_penerima'];
            $jaksa['jabatan'] = $_POST['jabatan_jpu_penerima'];
            $model->jaksa_penerima =  json_encode($jaksa);

            $saksi = array();
            $saksi['urut'] = $_POST['no_urut_saksi'];
            $saksi['nip'] = $_POST['nip_baru_saksi'];
            $saksi['nama'] = $_POST['nama_jpu_saksi'];
            $saksi['gol'] = $_POST['gol_jpu_saksi'];
            $saksi['jabatan'] = $_POST['jabatan_jpu_saksi'];
            $model->jaksa_saksi =  json_encode($saksi);

//            echo '<pre>';print_r($model);exit();
            if(!$model->save()){
                            echo '<pre>';var_dump($model->getErrors());exit;
                    }
                    $transaction->commit();
                     Yii::$app->getSession()->setFlash('success', [
                    'type' => 'success',
                    'duration' => 3000,
                    'icon' => 'fa fa-users',
                    'message' => 'Data Berhasil di Simpan',
                    'title' => 'Ubah Data',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
            return $this->redirect(['index']);
			}catch (Exception $e) {
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'danger',
                    'duration' => 3000,
                    'icon' => 'fa fa-users',
                    'message' => 'Data Gagal di Simpan',
                    'title' => 'Error',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
                $transaction->rollback();
            }
			
        } else {
            return $this->render('create', [
                'model' => $model,
				'sysMenu' => $sysMenu,
				'wilayah' => $wilayah,
				'listTersangka' => $listTersangka,
				'listBarbuk' => $listBarbuk,
				'modelBarbuk' => $modelBarbuk,
            ]);
        }
    }

    public function actionJpupenerima() {
    	$session = new session();
    	$no_register_perkara = $session->get('no_register_perkara');

        $searchModel = new VwJaksaPenuntutSearch();
        $dataProvider = $searchModel->search16a_new($no_register_perkara,Yii::$app->request->queryParams);
		//var_dump($dataProvider);exit;
        $dataProvider->pagination->pageSize = 5;
        return $this->renderAjax('_jpupenerima', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionJpu() {

    	$session = new session();
    	$kode = $session->get('inst_satkerkd');

        $searchModel = new KpPegawaiSearch();
        $dataProvider = $searchModel->searchSaksi(Yii::$app->request->queryParams,$kode);
 //var_dump ($dataProvider);exit;
//echo $dataProvider['pangkat'];exit;
  $dataProvider->pagination->pageSize = 5;
        return $this->renderAjax('_jpu', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing PdmBa6 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
    	$session = new session();
        $id_perkara = $session->get('id_perkara');
        $no_register_perkara = $session->get('no_register_perkara');

        $model = $this->findModel($id,$no_register_perkara);
        $kd_wilayah = PdmSpdp::findOne($id_perkara)->wilayah_kerja;
        $wilayah = Yii::$app->globalfunc->getNamaSatker($kd_wilayah)->inst_nama;
		
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA6 ]);
        
        $listTersangka = VwTerdakwaT2::findAll(['no_register_perkara'=>$no_register_perkara]);
        $data_barbuk  = PdmBa5Barbuk::findAll(['no_register_perkara'=>$no_register_perkara]);
        $modelBarbuk = PdmBa5Barbuk::find()->where(['no_register_perkara'=>$no_register_perkara])
                                            ->orderBy('no_urut_bb')->all();
		
        if ($model->load(Yii::$app->request->post()) ) {
			$transaction = Yii::$app->db->beginTransaction();
            try {

            $model->no_register_perkara = $no_register_perkara;
            $model->updated_by=\Yii::$app->user->identity->peg_nip;
            $model->updated_time=date('Y-m-d H:i:s');
            $model->updated_ip = \Yii::$app->getRequest()->getUserIP();

            $model->desk_barbuk = json_encode($_POST['barbuk']);
			$jaksa = array();
            $jaksa['urut'] = $_POST['no_urut_penerima'];
            $jaksa['nip'] = $_POST['nip_baru_penerima'];
            $jaksa['nama'] = $_POST['nama_jpu_penerima'];
            $jaksa['gol'] = $_POST['gol_jpu_penerima'];
            $jaksa['jabatan'] = $_POST['jabatan_jpu_penerima'];
            $model->jaksa_penerima =  json_encode($jaksa);

            $saksi = array();
            $saksi['urut'] = $_POST['no_urut_saksi'];
            $saksi['nip'] = $_POST['nip_baru_saksi'];
            $saksi['nama'] = $_POST['nama_jpu_saksi'];
            $saksi['gol'] = $_POST['gol_jpu_saksi'];
            $saksi['jabatan'] = $_POST['jabatan_jpu_saksi'];
            $model->jaksa_saksi =  json_encode($saksi);


				$model->update();
				
				$transaction->commit();

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
				} catch (Exception $e) {
                $transaction->rollBack();

                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'danger', //String, can only be set to danger, success, warning, info, and growl
                    'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                    'icon' => 'glyphicon glyphicon-ok-sign', //String
                    'message' => 'Data Gagal Diubah', // String
                    'title' => 'Update', //String
                    'positonY' => 'top', //String // defaults to top, allows top or bottom
                    'positonX' => 'center', //String // defaults to right, allows right, center, left
                    'showProgressbar' => true,
                ]);

                return $this->redirect(['index']);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
				'sysMenu' => $sysMenu,
				'modelJpu' => $modelJpu,
				'modelJpuPenerima' => $modelJpuPenerima,
				'wilayah' => $wilayah,
				'listTersangka' => $listTersangka,
				'data_barbuk' => $data_barbuk,
				'modelBarbuk' => $modelBarbuk,
            ]);
        }
    }

    /**
     * Deletes an existing PdmBa6 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
     public function actionDelete()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $id_ba8 = $_POST['hapusIndex'];

            $session = new Session();
            $id_perkara = $session->get('id_perkara');

            if ($id_ba8 === 'all') {
                PdmBa6::deleteAll('id_perkara=:id_perkara', [':id_perkara' => $id_perkara]);

            
            } else {
                for ($i = 0; $i < count($id_ba8); $i++) {
                    $model = $this->findModel($id_ba8[$i])->delete();

                    
                }
            }

            $transaction->commit();

            Yii::$app->getSession()->setFlash('success', [
                'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
                'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                'icon' => 'glyphicon glyphicon-ok-sign', //String
                'message' => 'Data Berhasil Dihapus', // String
                'title' => 'Delete', //String
                'positonY' => 'top', //String // defaults to top, allows top or bottom
                'positonX' => 'center', //String // defaults to right, allows right, center, left
                'showProgressbar' => true,
            ]);

            return $this->redirect(['index']);
        } catch (Exception $e) {
            $transaction->rollBack();

            Yii::$app->getSession()->setFlash('success', [
                'type' => 'danger', //String, can only be set to danger, success, warning, info, and growl
                'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                'icon' => 'glyphicon glyphicon-ok-sign', //String
                'message' => 'Data Gagal Dihapus', // String
                'title' => 'Delete', //String
                'positonY' => 'top', //String // defaults to top, allows top or bottom
                'positonX' => 'center', //String // defaults to right, allows right, center, left
                'showProgressbar' => true,
            ]);

            return $this->redirect(['index']);
        }
    }


    /**
     * Finds the PdmBa6 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmBa6 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id,$no_register_perkara)
    {
        if (($model = PdmBa6::findOne(['no_register_perkara'=>$no_register_perkara, 'tgl_ba6'=>$id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	public function actionCetak($id)
    {
    	$connection = \Yii::$app->db;
        $session = new session();
        $no_register_perkara = $session->get('no_register_perkara');
        $id_perkara = $session->get('id_perkara');
  
        $model = $this->findModel($id,$no_register_perkara);
        $tersangka = VwTerdakwaT2::findOne(['no_register_perkara'=>$no_register_perkara]);
        $p16a = PdmP16a::findOne(['no_register_perkara'=>$no_register_perkara]);
        $ba5 = PdmBa5::findOne(['no_register_perkara'=>$no_register_perkara]);
        $in                     = json_decode($model->desk_barbuk);
        $modelBarbuk            = PdmBa5Barbuk::find()->where(['no_register_perkara'=>$no_register_perkara])
                                                        ->andWhere(['in','no_urut_bb', $in])->orderBy('no_urut_bb')->all();

        $dft_barbuk = '';
        $tnda = ', ';
        foreach ($modelBarbuk as $key) {
            $dft_barbuk .= Yii::$app->globalfunc->GetDetBarbuk($model->no_register_perkara,$key['no_urut_bb']) . $tnda;
        }
        //$barbuk = PdmBa5Barbuk::findAll(['no_register_perkara'=>$no_register_perkara]);
        return $this->render('cetak',['session'=>$_SESSION, 'model'=>$model, 'tersangka'=>$tersangka, 'p16a'=>$p16a, 'ba5'=>$ba5, 'dft_barbuk'=>$dft_barbuk]);    
	}
}
