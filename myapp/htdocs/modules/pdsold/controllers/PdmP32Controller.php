<?php

namespace app\modules\pdsold\controllers;

use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\MsAsalsurat;
use app\modules\pdsold\models\MsTersangka;
use app\modules\pdsold\models\PdmBa5;
use app\modules\pdsold\models\PdmP32;
use app\modules\pdsold\models\PdmTembusanP32;
use app\modules\pdsold\models\PdmP32Search;
use app\modules\pdsold\models\PdmJaksaP16a;
//use app\modules\pdsold\models\PdmSpdp;
//use app\modules\pdsold\models\PdmPenandatangan;
use app\modules\pdsold\models\PdmTahapDua;
use Odf;
use Yii;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;

/**
 * PdmP32Controller implements the CRUD actions for PdmP32 model.
 */
class PdmP32Controller extends Controller {

    public function behaviors() {
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
     * Lists all PdmP32 models.
     * @return mixed
     */
    public function actionIndex() {
        
         return $this->redirect('update');
         
//        $searchModel = new pdmP32Search();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//
//        return $this->render('index', [
//                    'searchModel' => $searchModel,
//                    'dataProvider' => $dataProvider,
//        ]);
    }

    /**
     * Displays a single PdmP32 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmP32 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        return $this->redirect('update');
        
//        $model = new PdmP32();
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id_p32]);
//        } else {
//            return $this->render('create', [
//                        'model' => $model,
//            ]);
//        }
    }

    /**
     * Updates an existing PdmP32 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate() {
        $session = new session();
        //$id_perkara = $session->get('id_perkara');
        $no_register_perkara = $session->get('no_register_perkara');
        $ba5 = PdmBa5::findOne(['no_register_perkara'=>$no_register_perkara]);
        //echo '<pre>';print_r($ba5);exit;
        $model = $this->findModel($no_register_perkara);
        if ($model == null) {
            $model = new PdmP32();
        }



        if ($model->load(Yii::$app->request->post())) {
            //echo '<pre>';print_r($_POST);exit;
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($model->no_register_perkara != null) {
                    $model->no_register_perkara = $_POST['no_register_perkara'];
                    $model->no_reg_bukti   = $_POST['no_reg_bukti'];

                    $model->updated_by=\Yii::$app->user->identity->peg_nip;
                    $model->updated_time=date('Y-m-d H:i:s');
                    $model->updated_ip = \Yii::$app->getRequest()->getUserIP();
                } else {
                    $model->no_register_perkara = $_POST['no_register_perkara'];
                    $model->no_reg_bukti   = $_POST['no_reg_bukti'];
                    $model->created_time=date('Y-m-d H:i:s');
                    $model->created_by=\Yii::$app->user->identity->peg_nip;
                    $model->created_ip = \Yii::$app->getRequest()->getUserIP();
                    
                    $model->updated_by=\Yii::$app->user->identity->peg_nip;
                    $model->updated_time=date('Y-m-d H:i:s');
                    $model->updated_ip = \Yii::$app->getRequest()->getUserIP();
                    
                    $model->id_kejati = $session->get('kode_kejati');
                    $model->id_kejari = $session->get('kode_kejari');
                    $model->id_cabjari = $session->get('kode_cabjari');
                }
                if($model->save()||$model->update()){
                    PdmTembusanP32::deleteAll(['no_register_perkara'=>$no_register_perkara]);
                    for ($i=0; $i < count($_POST['new_tembusan']); $i++) { 
                        $modelTembusan = new PdmTembusanP32();
                        $modelTembusan->no_urut = $i+1;
                        $modelTembusan->tembusan =  $_POST['new_tembusan'][$i];
                        $modelTembusan->no_register_perkara = $no_register_perkara;
                        $modelTembusan->no_surat_p32 = $_POST['PdmP32']['no_surat_p32'];
                        if(!$modelTembusan->save()){
                                var_dump($modelTembusan->getErrors());exit;
                               }
                    }
                }else{
                    var_dump($model->getErrors());exit;
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
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'success',
                    'duration' => 3000,
                    'icon' => 'fa fa-users',
                    'message' => 'Data Gagal disimpan',
                    'title' => 'Simpan Data',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
                return $this->redirect('update');
            }
            return $this->redirect('update');
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'ba5' => $ba5,
            ]);
        }
    }

    /**
     * Deletes an existing PdmP32 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete() {
        $session = new session();
        $no_register_perkara = $session->get('no_register_perkara');
         $transaction = Yii::$app->db->beginTransaction();
            try {
                PdmP32::deleteAll(['no_register_perkara'=>$no_register_perkara]);
                $transaction->commit();
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'success',
                    'duration' => 3000,
                    'icon' => 'fa fa-users',
                    'message' => 'Data Berhasil di Hapus',
                    'title' => 'Simpan Data',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
            }catch (Exception $ex) {
                $transaction->rollback();
                Yii::$app->getSession()->setFlash('failed', [
                    'type' => 'warning',
                    'duration' => 3000,
                    'icon' => 'fa fa-users',
                    'message' => 'Data Gagal di Hapus',
                    'title' => 'Simpan Data',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
            }
        return $this->redirect('index');
    }

    /**
     * Finds the PdmP32 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmP32 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PdmP32::findOne(['no_register_perkara' => $id])) !== null) {
            return $model;
//        } else {
//            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCetak($id){
        
        $session = new session();
        $no_register_perkara = $session->get('no_register_perkara');  
        $tersangka = Yii::$app->globalfunc->getListTerdakwaBa4($no_register_perkara);
        $ba5 = PdmBa5::findOne(['no_register_perkara'=>$no_register_perkara]);
        $model = $this->findModel($no_register_perkara);
        $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_uu_pasal_tahap2')
                ->where("no_register_perkara='" . $no_register_perkara . "'");
        $data = $query->createCommand();
        $listPasal = $data->queryAll();
        $jaksa = PdmJaksaP16a::findOne(['no_register_perkara'=>$no_register_perkara]);
        $tahap2 = PdmTahapDua::findOne(['no_register_perkara'=>$no_register_perkara]);
        $listTembusan = PdmTembusanP32::findAll(['no_register_perkara'=>$no_register_perkara]);
        return $this->render('cetak',['session'=>$_SESSION, 'model'=>$model, 'tersangka'=>$tersangka, 'ba5'=>$ba5, 'listPasal'=>$listPasal, 'tahap2'=>$tahap2, 'listTembusan'=>$listTembusan, 'jaksa'=>$jaksa ]);
    }
}
