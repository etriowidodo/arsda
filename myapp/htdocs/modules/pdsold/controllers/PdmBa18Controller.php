<?php

namespace app\modules\pdsold\controllers;

use Yii;
use app\modules\pdsold\models\PdmRb2;
use app\modules\pdsold\models\PdmP48;
use app\modules\pdsold\models\PdmP16a;
use app\modules\pdsold\models\PdmBa18;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmBarbuk;
use app\modules\pdsold\models\PdmSysMenu;
use app\modules\pdsold\models\PdmMsSatuan;
use app\modules\pdsold\models\MsTersangka;
use app\modules\pdsold\models\PdmJaksaSaksi;
use app\modules\pdsold\models\PdmBa18Search;
use app\modules\pdsold\models\PdmMsStatusData;
use app\modules\pdsold\models\PdmJaksaPenerima;
use app\modules\pdsold\models\VwJaksaPenuntutSearch;
use app\modules\pdsold\models\VwTerdakwaT2;
use app\modules\pdsold\models\PdmPutusanPnTerdakwa;
use yii\db\Query;
use yii\web\Session;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use app\components\GlobalConstMenuComponent;

/**
 * PdmBa18Controller implements the CRUD actions for PdmBa18 model.
 */
class PdmBa18Controller extends Controller
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
     * Lists all PdmBa18 models.
     * @return mixed
     */
   public function actionIndex()
   {
        // no need index page so redirect to update
        return $this->redirect('update');
        // $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA18 ]);
        // $searchModel = new PdmBa18Search();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // return $this->render('index', [
        //     'searchModel' => $searchModel,
        //     'dataProvider' => $dataProvider,
        //     'sysMenu' => $sysMenu,
        // ]);
   }

    /**
     * Displays a single PdmBa18 model.
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
     * Creates a new PdmBa18 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA18 ]);

        $session = new Session();
        $id_perkara = $session->get('id_perkara');

        $model = new PdmBa18();

        $searchJPU = new VwJaksaPenuntutSearch();
        $dataJPU = $searchJPU->search2(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_ba18]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'id_perkara' => $id_perkara,
                'sysMenu' => $sysMenu,
				'searchJPU' => $searchJPU,
				'dataJPU' => $dataJPU,
                'sysMenu' => $sysMenu
            ]);
        }
    }

    /**
     * Updates an existing PdmBa18 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA18]);
        $session = new session();
        $id_perkara = $session->get('id_perkara');
        $no_register_perkara = $session->get('no_register_perkara');
        $no_akta = $session->get('no_akta');
        $no_reg_tahanan = $session->get('no_reg_tahanan');
        $no_eksekusi = $session->get('no_eksekusi');

        //echo '<pre>';print_r($no_reg_tahanan);exit;

        $model = $this->findModel($no_eksekusi);
        if ($model == null) {
            $model = new PdmBa18();
        }

        $searchJPU = new VwJaksaPenuntutSearch();
        $dataJPU = $searchJPU->search16a_new(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $data = $_POST['saksi'];
                $model->saksi =  json_encode($data);
                $model->no_eksekusi = $no_eksekusi;
                $model->no_reg_tahanan = $no_reg_tahanan;
                $model->created_time=date('Y-m-d H:i:s');
                $model->created_by=\Yii::$app->user->identity->peg_nip;
                $model->created_ip = \Yii::$app->getRequest()->getUserIP();
                
                $model->updated_by=\Yii::$app->user->identity->peg_nip;
                $model->updated_time=date('Y-m-d H:i:s');
                $model->updated_ip = \Yii::$app->getRequest()->getUserIP();
                if(!$model->save()){
                    var_dump($model->getErrors());exit;
                }else{
                    $transaction->commit();

                    //notifikasi simpan
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
                        'duration' => 3000, //Integer //3000 default. time for growl to fade out.
                        'icon' => 'glyphicon glyphicon-ok-sign', //String
                        'message' => 'Data Berhasil Diubah', // String
                        'title' => 'Ubah Data', //String
                        'positonY' => 'top', //String // defaults to top, allows top or bottom
                        'positonX' => 'center', //String // defaults to right, allows right, center, left
                        'showProgressbar' => true,
                    ]);
                return $this->redirect(['update','no_eksekusi'=>$no_eksekusi]);
                }
            } catch (Exception $e) {
                $transaction->rollBack();

                //notifikasi gagal
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'warning', //String, can only be set to danger, success, warning, info, and growl
                    'duration' => 3000, //Integer //3000 default. time for growl to fade out.
                    'icon' => 'glyphicon glyphicon-ok-sign', //String
                    'message' => 'Terjadi Kesalahan', // String
                    'title' => 'Ubah Data', //String
                    'positonY' => 'top', //String // defaults to top, allows top or bottom
                    'positonX' => 'center', //String // defaults to right, allows right, center, left
                    'showProgressbar' => true,
                ]);

                return $this->redirect(['update']);
            }
        } else {

            return $this->render('update', [
                        'model' => $model,
                        'id_perkara' => $id_perkara,
                        'modelJPenerima' => $modelJPenerima,
                        'modelJSaksi' => $modelJSaksi,
                        'modelBarbuk' => $modelBarbuk,
                        'searchJPU' => $searchJPU,
                        'dataJPU' => $dataJPU,
                        'sysMenu' => $sysMenu,
                        'no_reg_tahanan' => $no_reg_tahanan,
            ]);
        }
    }

    public function actionJpu()
    {
        $searchModel = new VwJaksaPenuntutSearch();
        $dataProvider = $searchModel->search2(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize=5;
        return $this->renderAjax('_m_jaksa', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
        ]);
    }

    public function actionBarbuk()
    {
        if(!empty($_GET['id_barbuk'])){
            $modelBarbuk = PdmBarbuk::findOne(['id' => $_GET['id_barbuk']]);
        }

        if(empty($modelBarbuk)){
            $modelBarbuk = new PdmBarbuk();
        }
        
        $satuan = ArrayHelper::map(PdmMsSatuan::find()->all(), 'id', 'nama');
        $kondisi = ArrayHelper::map(PdmMsStatusData::find()->where(['is_group' => 'KND'])->all(), 'id', 'nama');
        
        return $this->renderAjax('_popBarbuk', [
            'modelBarbuk' => $modelBarbuk,
            'satuan' => $satuan,
            'kondisi' => $kondisi
        ]);
    }
	
    public function actionCetak ($no_eksekusi)
	{
        $session = new session();
        $id_perkara = $session->get('id_perkara');
        $no_register_perkara = $session->get('no_register_perkara');
        $no_akta = $session->get('no_akta');
        $no_reg_tahanan = $session->get('no_reg_tahanan');
        $p48 = PdmP48::findOne(['no_surat'=>$no_eksekusi]);
        $model = $this->findModel($no_eksekusi);
        $spdp = PdmSpdp::findOne($id_perkara);
        $tersangka = VwTerdakwaT2::findOne(['no_register_perkara'=>$no_register_perkara, 'no_reg_tahanan'=>$model->no_reg_tahanan]);
        $putusan = PdmPutusanPnTerdakwa::findOne(['no_surat'=>trim($p48->no_putusan)]);
        //$jaksa = PdmJaksaP16a::findAll(['no_register_perkara'=>$no_register_perkara]);
        //echo '<pre>';print_r(count($jaksa));exit;
        //$listTembusan = PdmTembusanP48::findAll(['no_surat'=>$model->no_surat]);

        return $this->render('cetak', ['model'=>$model,'spdp'=>$spdp,'tersangka'=>$tersangka, 'listPasal'=>$listPasal, 'putusan'=>$putusan ,'p48'=>$p48, 'jaksa'=>$jaksa]);
    }

    /**
     * Deletes an existing PdmBa18 model.
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
     * Finds the PdmBa18 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmBa18 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($no_eksekusi)
    {
        /*if (($model = PdmBa18::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }*/
		if (($model = PdmBa18::findOne(['no_eksekusi' => $no_eksekusi])) !== null) {
            return $model;
        }
    }
    
    protected function findModelBarbuk($id)
    {        
        if(($model = PdmBarbuk::findOne($id)) !== null)
            return $model;
    }
}
