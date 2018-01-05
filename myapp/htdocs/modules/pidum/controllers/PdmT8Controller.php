<?php

namespace app\modules\pidum\controllers;

use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\PdmJaksaSaksi;
use app\modules\pidum\models\PdmJpu;
use app\modules\pidum\models\PdmRp9;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmTembusan;
use app\modules\pidum\models\PdmTahapDua;
use app\modules\pidum\models\PdmBerkasTahap1;
use app\modules\pidum\models\PdmTembusanT8;
use app\modules\pidum\models\VwJaksaPenuntutSearch;
use app\modules\pidum\models\PdmPerpanjanganTahanan;
use app\modules\pidum\models\PdmPenandatangan;
use Yii;
use app\modules\pidum\models\PdmT7;
use app\modules\pidum\models\PdmT8;
use app\modules\pidum\models\PdmMsStatusT8;
use app\modules\pidum\models\PdmJaksaP16a;
use app\modules\pidum\models\PdmJaksaP16aSearch;
use app\modules\pidum\models\PdmT8Search;
use app\modules\pidum\models\VwTerdakwaT2;
use yii\db\Exception;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
use app\modules\pidum\models\PdmSysMenu;
use Odf;

/**
 * PdmT8Controller implements the CRUD actions for PdmT8 model.
 */
class PdmT8Controller extends Controller {

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
     * Lists all PdmT8 models.
     * @return mixed
     */
    public function actionIndex() {
        $session                = new Session();
        $id_perkara             = $session->get("id_perkara");
        $no_register_perkara    = $session->get("no_register_perkara");
        
        $sysMenu                = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::T8]);
        $searchModel            = new PdmT8Search();
        $dataProvider           = $searchModel->search($no_register_perkara, Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel'   => $searchModel,
                    'dataProvider'  => $dataProvider,
                    'sysMenu'       => $sysMenu
        ]);
    }

    /**
     * Displays a single PdmT8 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmT8 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $session                = new Session();
        $id                     = $session->get("id_perkara");
        $no_register_perkara    = $session->get("no_register_perkara");
        $sysMenu                = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::T8]);
        $model                  = new PdmT8();
        $no_surat_t7            = PdmT7::findOne(['no_register_perkara' => $no_register_perkara]);
        $modelSpdp              = $this->findModelSpdp($id);
        $modelRp9               = PdmRp9::findOne(['id_perkara' => $id]);
        
        $kode_kejati            = $session->get('kode_kejati');
        $kode_kejari            = $session->get('kode_kejari');
        $kode_cabjari           = $session->get('kode_cabjari');
        $modeljaksi             = PdmJaksaP16a::findOne(['no_register_perkara' => $no_register_perkara]);
        $searchJPU              = new PdmJaksaP16aSearch();
        $dataJPU                = $searchJPU->search2($no_register_perkara,Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;

        if ($model->load(Yii::$app->request->post())) {

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $seq        = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_t8', 'no_surat_t8', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                $no_surat   = PdmT7::findOne(['no_register_perkara' => $no_register_perkara,'no_urut_tersangka'=>$model->id_tersangka]);
                
                $model->no_surat_t7         = $no_surat->no_surat_t7;
                $model->tgl_ba4             = $no_surat->tgl_ba4;
                $model->tgl_penahanan           = $no_surat->tgl_mulai;
                $model->no_register_perkara = $no_register_perkara;
                $model->no_surat_p16a       = $_POST['PdmJaksaSaksi']['no_surat_p16a'];
                $model->no_urut_jaksa_p16a  = $_POST['PdmJaksaSaksi']['no_urut'];
                $model->id_kejati           = $kode_kejati;
                $model->id_kejari           = $kode_kejari;
                $model->id_cabjari          = $kode_cabjari;
                $model->updated_by          = $session->get("nik_user");
                $model->updated_time        = date("Y-m-d H:i:s");
                $model->updated_ip          = $_SERVER['REMOTE_ADDR'];

                $model->created_ip          = $_SERVER['REMOTE_ADDR'];
                $model->created_by          = $session->get("nik_user"); 
                $model->updated_time         = date("Y-m-d H:i:s");
                /*if(!$model->save()){
                        var_dump($model->getErrors());exit;
                       }*/
                

                if ($model->save()) {
                    
                    if (isset($_POST['new_tembusan'])) {
                        PdmTembusanT8::deleteAll(['no_surat_t8' => $model->no_surat_t8]);
                        for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                            $modelNewTembusan   = new PdmTembusanT8();
                            $modelNewTembusan->no_surat_t8        = $model->no_surat_t8;
                            $modelNewTembusan->no_register_perkara  = $model->no_register_perkara;
                            $modelNewTembusan->tembusan             = $_POST['new_tembusan'][$i];
                            $modelNewTembusan->no_urut              = ($i+1);
                            if(!$modelNewTembusan->save()){
                                echo "Tembusan".var_dump($modelNewTembusan->getErrors());exit;
                            }
                        }
                    }

                    Yii::$app->globalfunc->getSetStatusProcces($id, GlobalConstMenuComponent::T8);

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
                    return $this->redirect('index');
                } else {

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
                return $this->redirect('create');
            }
        } else {
            return $this->render('create', [
                'model'                 => $model,
                'modelRp9'              => $modelRp9,
                'modelSpdp'             => $modelSpdp,
                'searchJPU'             => $searchJPU,
                'dataJPU'               => $dataJPU,
                'sysMenu'               => $sysMenu,
                'no_surat_t7'           => $no_surat_t7,
                'no_register_perkara'   => $no_register_perkara,
                'modeljaksi'            => $modeljaksi,
            ]);
        }
    }

    /**
     * Updates an existing PdmT8 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($no_surat_t8) {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::T8]);
        if (!empty($no_surat_t8)) {
            $model = $this->findModel($no_surat_t8);
        }
        
        if (empty($model->no_surat_t8)) {
            $this->redirect('/pidum/pdm-t8/index');
        }

        $session = new Session();
//        $session->destroySession('id_perkara');
//        $session->set('id_perkara', $model->id_perkara);
        $id                     = $session->get("id_perkara");
        $no_register_perkara    = $session->get("no_register_perkara");
        
        $modeljaksi             = PdmJaksaP16a::findOne(['no_surat_p16a'=>$model->no_surat_p16a,'no_urut'=>$model->no_urut_jaksa_p16a]);
        $modelSpdp              = $this->findModelSpdp($id);
        $modelRp9               = PdmRp9::findOne(['id_perkara' => $id]);

        $searchJPU              = new PdmJaksaP16aSearch();
        $dataJPU                = $searchJPU->search2($no_register_perkara,Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if($_POST['PdmJaksaSaksi']['no_surat_p16a'] != ''){
                    $model->no_surat_p16a       = $_POST['PdmJaksaSaksi']['no_surat_p16a'];
                    $model->no_urut_jaksa_p16a  = $_POST['PdmJaksaSaksi']['no_urut'];
                }else{
                    
                }
//                $model->no_surat_p16a       = $_POST['PdmJaksaSaksi']['no_surat_p16a'];
//                $model->no_urut_jaksa_p16a  = $_POST['PdmJaksaSaksi']['no_urut'];
                if ($model->save() || $model->update()) {
                    
                    if (isset($_POST['new_tembusan'])) {
                        PdmTembusanT8::deleteAll(['no_surat_t8' => $model->no_surat_t8]);
                        for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                            $modelNewTembusan   = new PdmTembusanT8();
                            $modelNewTembusan->no_surat_t8        = $model->no_surat_t8;
                            $modelNewTembusan->no_register_perkara  = $model->no_register_perkara;
                            $modelNewTembusan->tembusan             = $_POST['new_tembusan'][$i];
                            $modelNewTembusan->no_urut              = ($i+1);
                            if(!$modelNewTembusan->save()){
                                echo "Tembusan".var_dump($modelNewTembusan->getErrors());exit;
                            }
                        }
                    }

//                    Yii::$app->globalfunc->getSetStatusProcces($model->no_register_perkara, GlobalConstMenuComponent::T8);

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
                    return $this->redirect(['update', 'no_surat_t8' => $model->no_surat_t8]);
                }
            } catch (Exception $e) {
//                echo $e;exit();
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
                return $this->redirect(['update', 'no_surat_t8' => $model->no_surat_t8]);
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'modelRp9' => $modelRp9,
                        'modelSpdp' => $modelSpdp,
                        'modeljaksi' => $modeljaksi,
                        'searchJPU' => $searchJPU,
                        'dataJPU' => $dataJPU,
                        'sysMenu' => $sysMenu,
                        'no_register_perkara' => $no_register_perkara
            ]);
        }
    }

    /**
     * Deletes an existing PdmT8 model.
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
                PdmTembusanT8::deleteAll(['no_register_perkara' => $no_register_perkara,'no_surat_t8' => $id[0]]);
//                echo 'idnya '.$id[0];exit();
                PdmT8::deleteAll(['no_surat_t8' => $id[0]]);
            }else{
                if($id == "all"){
                    PdmTembusanT8::deleteAll(['no_register_perkara' => $no_register_perkara,'no_surat_t8' => $id]);
                    PdmT8::deleteAll(['no_surat_t8' => $id]);
//                     Yii::$app->db->createCommand("UPDATE pidum.pdm_status_surat SET is_akhir='1' WHERE id_sys_menu = 'SPDP' AND id_perkara=:id")
//                            ->bindValue(':id', $id_perkara)
//                            ->execute();
                }else{
                   for ($i = 0; $i < count($id); $i++) {
                       PdmTembusanT8::deleteAll(['no_register_perkara' => $no_register_perkara,'no_surat_t8' => $id[$i]]);
                       PdmT8::deleteAll(['no_surat_t8' => $id[$i]]);
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
    
    public function actionCetak($id) {
        $T8             = PdmT8::findOne(['no_surat_t8' => $id]);
        $T7             = PdmT7::findOne(['no_surat_t7' => $T8->no_surat_t7]);
        
        $thp_2          = PdmTahapDua::findOne(['no_register_perkara' => $T8->no_register_perkara]);
        $brks_thp_1     = PdmBerkasTahap1::findOne(['id_berkas' => $thp_2->id_berkas]);
        $spdp           = PdmSpdp::findOne(['id_perkara' => $brks_thp_1->id_perkara]);
        
        $pangkat        = PdmPenandatangan::findOne(['peg_nip_baru' => $T8->id_penandatangan]);
        $sts_t8         = PdmMsStatusT8::findOne(['id' => $T8->id_ms_status_t8]);
        $jaksa          = PdmJaksaP16a::findOne(['no_surat_p16a' => $T8->no_surat_p16a,'no_urut' => $T8->no_urut_jaksa_p16a]);
        $tersangka      = VwTerdakwaT2::findOne(['no_register_perkara' => $T8->no_register_perkara,'no_urut_tersangka' => $T8->id_tersangka]);
        $listTembusan   = PdmTembusanT8::findAll(['no_surat_t8' => $T8->no_surat_t8]);
        
        return $this->render('cetak', ['spdp'=>$spdp,'sts_t8'=>$sts_t8,'T8'=>$T8,'pangkat'=>$pangkat,'T7'=>$T7,'brks_thp_1'=>$brks_thp_1,'jaksa'=>$jaksa,'tersangka'=>$tersangka,'listTembusan'=>$listTembusan]);
    }


    /**
     * Finds the PdmT8 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmT8 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PdmT8::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelSpdp($id) {
        if (($modelSpdp = PdmSpdp::findOne(['id_perkara' => $id])) !== null) {
            return $modelSpdp;
        }
    }

}
