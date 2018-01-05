<?php

namespace app\modules\pdsold\controllers;

use app\components\ConstDataComponent;
use app\components\GlobalConstMenuComponent;
use app\models\MsSifatSurat;
use app\modules\pdsold\models\PdmD1;
use app\modules\pdsold\models\PdmPutusanPn;
use app\modules\pdsold\models\PdmD1Search;
use app\modules\pdsold\models\PdmJaksaPenerima;
use app\modules\pdsold\models\PdmMsStatusData;
use app\modules\pdsold\models\PdmP48;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmSysMenu;
use app\modules\pdsold\models\PdmTerpanggil;
use app\modules\pdsold\models\VwJaksaPenuntutSearch;
use app\modules\pdsold\models\VwTerdakwaT2;
use Odf;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;

/**
 * PdmD1Controller implements the CRUD actions for PdmD1 model.
 */
class PdmD1Controller extends Controller {

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
     * Lists all PdmD1 models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new PdmD1Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::D1]);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'sysMenu' => $sysMenu
        ]);
    }

    /**
     * Displays a single PdmD1 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmD1 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new PdmD1();
        $session = new session();
        $id_perkara = $session->get('id_perkara');
        $no_register_perkara = $session->get('no_register_perkara');
        $no_akta = $session->get('no_akta');
        $no_reg_tahanan = $session->get('no_reg_tahanan');
        $no_eksekusi = $session->get('no_eksekusi');

        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::D1]);
        //$modeljakpen = new PdmJaksaPenerima();
        //$modelSpdp = PdmSpdp::findOne($id);
        $searchJPU = new VwJaksaPenuntutSearch();
        $dataJPU = $searchJPU->search16a_new(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;
        $modelTerpanggil = VwTerdakwaT2::findOne(['no_register_perkara'=>$no_register_perkara, 'no_reg_tahanan'=>$no_reg_tahanan]);
        //echo '<pre>';print_r($modelTerpanggil);exit;
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                //echo '<pre>';print_r($_POST);exit;
                $model->no_eksekusi = $no_eksekusi;
                $model->no_reg_tahanan = $no_reg_tahanan;
                $model->no_register_perkara = $no_register_perkara;
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
                    return $this->redirect(['update', 'no_surat' => $_POST['PdmD1']['no_surat']]);
                }
            } catch (Exception $ex) {
                $transaction->rollback();
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
                return $this->redirect('create');
            }
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'sysMenu' => $sysMenu,
                        'modeljakpen' => $modeljakpen,
                        'modelSpdp' => $modelSpdp,
                        'searchJPU' => $searchJPU,
                        'dataJPU' => $dataJPU,
                        'modelTerpanggil' => $modelTerpanggil
            ]);
        }
    }

    /**
     * Updates an existing PdmD1 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($no_surat) {
        $model = $this->findModel($no_surat);
        $session = new session();
        $id_perkara = $session->get('id_perkara');
        $no_register_perkara = $session->get('no_register_perkara');
        $no_akta = $session->get('no_akta');
        $no_reg_tahanan = $session->get('no_reg_tahanan');
        $no_eksekusi = $session->get('no_eksekusi');

        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::D1]);
        //$modeljakpen = PdmJaksaPenerima::findOne(['id_perkara' => $model->id_perkara, 'code_table' => GlobalConstMenuComponent::D1, 'id_table' => $model->id_d1]);
        $modelTerpanggil = VwTerdakwaT2::findOne(['no_register_perkara'=>$no_register_perkara, 'no_reg_tahanan'=>$no_reg_tahanan]);
        //$modelSpdp = PdmSpdp::findOne($model->id_perkara);
        $searchJPU = new VwJaksaPenuntutSearch();
        $dataJPU = $searchJPU->searchttd(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;
        //$model->hari = Yii::$app->globalfunc->GetNamaHari($model->tgl_relas);
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {

                $model->no_eksekusi = $no_eksekusi;
                $model->no_reg_tahanan = $no_reg_tahanan;
                $model->no_register_perkara = $no_register_perkara;
                if(!$model->update()){
                    var_dump($model->getErrors());exit;
                }else{
                    $transaction->commit();
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'success',
                        'duration' => 3000,
                        'icon' => 'fa fa-users',
                        'message' => 'Data Berhasil di Update',
                        'title' => 'Update Data',
                        'positonY' => 'top',
                        'positonX' => 'center',
                        'showProgressbar' => true,
                    ]);
                    return $this->redirect(['update', 'no_surat' => $model->no_surat]);
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'danger',
                    'duration' => 3000,
                    'icon' => 'fa fa-users',
                    'message' => 'Data Gagal di Update',
                    'title' => 'Error',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
                return $this->redirect(['update', 'no_surat' => $model->no_surat]);
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'sysMenu' => $sysMenu,
                        'modeljakpen' => $modeljakpen,
                        'modelSpdp' => $modelSpdp,
                        'searchJPU' => $searchJPU,
                        'dataJPU' => $dataJPU,
                        'modelTerpanggil' => $modelTerpanggil
            ]);
        }
    }

    /**
     * Deletes an existing PdmD1 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete(){
        $session = new session();
        $no_eksekusi = $session->get('no_eksekusi');
        $id = $_POST['hapusIndex'];

        if(count($id)>1){
            for ($i = 0; $i < count($id); $i++) {
                PdmD1::deleteAll(['no_surat' => $id[$i]]);
            }
        }else{
            PdmD1::deleteAll(['no_eksekusi'=>$no_eksekusi]);
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the PdmD1 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmD1 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */

    protected function findModel($no_surat) {
        if (($model = PdmD1::findOne(['no_surat'=>$no_surat])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionCetak($no_surat) {
        $session = new session();
        $id_perkara = $session->get('id_perkara');
        $no_register_perkara = $session->get('no_register_perkara');
        $no_akta = $session->get('no_akta');
        $no_reg_tahanan = $session->get('no_reg_tahanan');
        $no_eksekusi = $session->get('no_eksekusi');
        $spdp = PdmSpdp::findOne(['id_perkara'=>$id_perkara]);
        
        $model = $this->findModel($no_surat);
        $p48 = PdmP48::findOne(['no_surat'=>$no_eksekusi]);
        $putusan = PdmPutusanPn::findOne(['no_surat'=>$p48->no_putusan]);
        $tersangka = VwTerdakwaT2::findOne(['no_register_perkara'=>$no_register_perkara, 'no_reg_tahanan'=>$model->no_reg_tahanan]);
        
        //echo '<pre>';print_r($p48);exit;
        return $this->render('cetak', ['tersangka'=>$tersangka, 'p48'=>$p48 ,'model'=>$model, 'spdp'=>$spdp, 'putusan'=>$putusan]);
    }

}
