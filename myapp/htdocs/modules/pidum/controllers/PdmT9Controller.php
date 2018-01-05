<?php

namespace app\modules\pidum\controllers;

use app\modules\pidum\models\PdmT9;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmSysMenu;
use app\modules\pidum\models\PdmT9Search;
use app\modules\pidum\models\PdmDetailT9;
use app\modules\pidum\models\VwTersangka;
use app\modules\pidum\models\PdmTembusanT9;
use app\modules\pidum\models\PdmPenandatangan;
use app\modules\pidum\models\PdmTrxPemrosesan;
use app\modules\pidum\models\VwTerdakwaT2;
use app\models\MsSifatSurat;
use Yii;
use yii\db\Query;
use yii\web\Controller;
use app\components\GlobalConstMenuComponent;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;

/**
 * PdmT9Controller implements the CRUD actions for PdmT9 model.
 */
class PdmT9Controller extends Controller {

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
     * Lists all PdmT9 models.
     * @return mixed
     */
    public function actionIndex() {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::T9]);

        $session        = new Session();
        $id_perkara     = $session->get("id_perkara");
        $no_register    = $session->get("no_register_perkara");
        $searchModel    = new PdmT9Search();
        $dataProvider   = $searchModel->search($no_register, Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'sysMenu' => $sysMenu
        ]);
    }

    /**
     * Displays a single PdmT9 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmT9 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::T9]);

        $session = new Session();
        $no_register_perkara = $session->get('no_register_perkara');
        $modelTersangka = VwTerdakwaT2::findAll(['no_register_perkara'=>$no_register_perkara,'tindakan_status'=>1]);
        //echo '<pre>';print_r($terdakwa);exit;
        $model = new PdmT9();
        
        $modelDetailT9 = new PdmDetailT9();

        if ($model->load(Yii::$app->request->post())) {
            // echo '<pre>';print_r($_POST);exit;
            /*$transaction = Yii::$app->db->beginTransaction();
            try {*/
                //$seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_t9', 'id_t9', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();

                $model->no_register_perkara = $no_register_perkara;
                $model->created_time=date('Y-m-d H:i:s');
                $model->created_by=\Yii::$app->user->identity->peg_nip;
                $model->created_ip = \Yii::$app->getRequest()->getUserIP();
                
                $model->updated_by=\Yii::$app->user->identity->peg_nip;
                $model->updated_time=date('Y-m-d H:i:s');
                $model->updated_ip = \Yii::$app->getRequest()->getUserIP();
                if(!$model->save()){
                        var_dump($model->getErrors());exit;
                       }


                //if ($model->save()) {
                    //Yii::$app->globalfunc->getSetStatusProcces($model->no_register_perkara, GlobalConstMenuComponent::T9);

                    //Insert tabel tembusan 
                    //echo '<pre>';print_r($_POST);exit;
                    

                    if (!empty($_POST['DetailT9'])) {
                        for ($i = 0; $i < count($_POST['DetailT9']['no_urut_tersangka']); $i++) {
                            $modelDetailT9 = new PdmDetailT9();
                            $modelDetailT9->no_surat_t9 = $_POST['PdmT9']['no_surat_t9'];
                            $modelDetailT9->no_register_perkara = $no_register_perkara;
                            $modelDetailT9->id_tersangka = $_POST['DetailT9']['no_urut_tersangka'][$i];
                            $modelDetailT9->no_reg_tahanan_jaksa = $_POST['DetailT9']['no_reg_tahanan_jaksa'][$i];
                            $modelDetailT9->nama = $_POST['DetailT9']['nama'][$i];
                            $modelDetailT9->lokasi_tahanan = $_POST['DetailT9']['lokasi_tahanan'][$i];
                            $modelDetailT9->lokasi_pindah = $_POST['DetailT9']['lokasi_pindah'][$i];
                            if(!$modelDetailT9->save()){
                                    var_dump($modelDetailT9->getErrors());exit;
                                   }
                        }
                    }

                    if (!empty($_POST['new_no_urut'])) {
                        for ($i = 0; $i < count($_POST['new_no_urut']); $i++) {
                            $modelNewTembusan = new PdmTembusanT9();
                            $modelNewTembusan->no_surat_t9 = $_POST['PdmT9']['no_surat_t9'];
                            $modelNewTembusan->no_register_perkara = $no_register_perkara;
                            $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                            $modelNewTembusan->no_urut = $i+1;
                            if(!$modelNewTembusan->save()){
                                    var_dump($modelNewTembusan->getErrors());exit;
                                   }
                        }
                    }


                    //$transaction->commit();

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
                    return $this->redirect('index');
                /*} else {
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
                }*/
            /*} catch (Exception $e) {
                $transaction->rollback();
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'danger',
                    'duration' => 3000,
                    'icon' => 'fa fa-users',
                    'message' => 'Terjadi Kesalahan',
                    'title' => 'Error',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
                return $this->redirect('create');
            }*/
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'modelTersangka' => $modelTersangka,
                        'modelDetailT9' => $modelDetailT9,
                        'sysMenu' => $sysMenu
            ]);
        }
    }

    /**
     * Updates an existing PdmT9 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id_t9) {
       
        $session = new session();
        $no_register_perkara = $session->get('no_register_perkara');
        $id                     = $session->get("id_perkara");
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::T9]);
        if (!empty($id_t9)) {
            $model = $this->findModel($id_t9,$no_register_perkara);
             // echo $id_t9;exit;
        }else {
            $this->redirect('/pidum/pdm-t9/index');
        }

         // echo $model->no_surat_t9;exit;

        //$modelTersangka = $model->tersangkaTahanan($model->no_register_perkara);
        $modelTersangka = PdmDetailT9::find()
                ->where(['no_surat_t9' => $model->no_surat_t9, 'no_register_perkara' => $model->no_register_perkara])
                ->orderBy('id_tersangka asc')
                ->all();
                // echo '<pre>';print_r($modelTersangka);exit;

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($model->save() || $model->update()) {

                    if (!empty($_POST['DetailT9'])) {
                        PdmDetailT9::deleteAll(['no_register_perkara'=>$no_register_perkara, 'no_surat_t9'=>$model->no_surat_t9]);
                        for ($i = 0; $i < count($_POST['DetailT9']['no_urut_tersangka']); $i++) {
                            $modelDetailT9 = new PdmDetailT9();
                            $modelDetailT9->no_surat_t9 = $_POST['PdmT9']['no_surat_t9'];
                            $modelDetailT9->no_register_perkara = $no_register_perkara;
                            $modelDetailT9->id_tersangka = $_POST['DetailT9']['no_urut_tersangka'][$i];
                            $modelDetailT9->no_reg_tahanan_jaksa = $_POST['DetailT9']['no_reg_tahanan_jaksa'][$i];
                            $modelDetailT9->nama = $_POST['DetailT9']['nama'][$i];
                            $modelDetailT9->lokasi_tahanan = $_POST['DetailT9']['lokasi_tahanan'][$i];
                            $modelDetailT9->lokasi_pindah = $_POST['DetailT9']['lokasi_pindah'][$i];
                            if(!$modelDetailT9->save()){
                                    var_dump($modelDetailT9->getErrors());exit;
                                   }
                        }
                    }

                    if (!empty($_POST['new_no_urut'])) {
                        PdmTembusanT9::deleteAll(['no_register_perkara' => $no_register_perkara,'no_surat_t9'=>$model->no_surat_t9]);
                        for ($i = 0; $i < count($_POST['new_no_urut']); $i++) {
                            $modelNewTembusan = new PdmTembusanT9();
                            $modelNewTembusan->no_surat_t9 = $_POST['PdmT9']['no_surat_t9'];
                            $modelNewTembusan->no_register_perkara = $no_register_perkara;
                            $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                            $modelNewTembusan->no_urut = $i+1;
                            if(!$modelNewTembusan->save()){
                                    var_dump($modelNewTembusan->getErrors());exit;
                                   }
                        }
                    }

                    $transaction->commit();

                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'success',
                        'duration' => 3000,
                        'icon' => 'fa fa-users',
                        'message' => 'Data Berhasil di Ubah',
                        'title' => 'Ubah Data',
                        'positonY' => 'top',
                        'positonX' => 'center',
                        'showProgressbar' => true,
                    ]);
                    return $this->redirect('index');
                } else {
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'danger',
                        'duration' => 3000,
                        'icon' => 'fa fa-users',
                        'message' => 'Data Gagal di Ubah',
                        'title' => 'Error',
                        'positonY' => 'top',
                        'positonX' => 'center',
                        'showProgressbar' => true,
                    ]);
                    return $this->redirect(['update', 'no_surat_t9' => $model->no_surat_t9]);
                }
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'danger',
                    'duration' => 3000,
                    'icon' => 'fa fa-users',
                    'message' => 'Terjadi Kesalahan',
                    'title' => 'Error',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
                return $this->redirect(['update', 'no_surat_t9' => $model->no_surat_t9]);
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'modelTersangka' => $modelTersangka,
                        'modelDetailT9' => $modelDetailT9,
                        'sysMenu' => $sysMenu
            ]);
        }
    }

    public function actionCetak($id_t9) {

        $session = new session();
        $no_register_perkara = $session->get('no_register_perkara');
        $model = PdmT9::findOne(['no_register_perkara'=>$no_register_perkara, 'no_surat_t9'=>$id_t9]);
        $DetailT9  = PdmDetailT9::findAll(['no_register_perkara'=>$no_register_perkara, 'no_surat_t9'=>$id_t9]);
        $tembusan = PdmTembusanT9::findAll(['no_register_perkara'=>$no_register_perkara, 'no_surat_t9'=>$id_t9]);
        $sifat = MsSifatSurat::findOne(['id'=>$model->sifat]);
        //echo '<pre>';print_r($tembusan);exit;
        return $this->render('cetak', ['model'=>$model, 'DetailT9'=>$DetailT9, 'tembusan'=>$tembusan, 'sifat'=>$sifat]);
    }

    /**
     * Deletes an existing PdmT9 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
     public function actionDelete() {
        $id                     = $_POST['hapusIndex'];
        $total                  = count($id);
        $session                = new Session();
        $id_perkara             = $session->get('id_perkara');
        $no_register_perkara    = $session->get('no_register_perkara');
        $connection             = \Yii::$app->db;
        $transaction            = $connection->beginTransaction();
        try {
            
            if($total['total'] <= 1){
                PdmTembusanT9::deleteAll(['no_register_perkara' => $no_register_perkara,'no_surat_t9' => $id[0]]);
//                echo 'idnya '.$id[0];exit();
                PdmT9::deleteAll(['no_surat_t9' => $id[0]]);
            }else{
                if($id == "all"){
                    PdmTembusanT9::deleteAll(['no_register_perkara' => $no_register_perkara,'no_surat_t9' => $id]);
                    PdmT9::deleteAll(['no_surat_t9' => $id]);
//                     Yii::$app->db->createCommand("UPDATE pidum.pdm_status_surat SET is_akhir='1' WHERE id_sys_menu = 'SPDP' AND id_perkara=:id")
//                            ->bindValue(':id', $id_perkara)
//                            ->execute();
                }else{
                   for ($i = 0; $i < count($id); $i++) {
                       PdmTembusanT9::deleteAll(['no_register_perkara' => $no_register_perkara,'no_surat_t9' => $id[$i]]);
                       PdmT9::deleteAll(['no_surat_t9' => $id[$i]]);
                    }
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
        } catch (Exception $e) {
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
     * Finds the PdmT9 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmT9 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id,$no_register_perkara) {

        if (($model = PdmT9::findOne(['no_register_perkara'=>$no_register_perkara, 'no_surat_t9'=>$id])) !== null) {
            return $model;
        }
    }

}
