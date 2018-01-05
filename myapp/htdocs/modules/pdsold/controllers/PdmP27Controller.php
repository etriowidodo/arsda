<?php

namespace app\modules\pdsold\controllers;

use Yii;
use app\modules\pdsold\models\PdmP27;
use app\modules\pdsold\models\PdmP27Search;
use app\modules\pdsold\models\PdmTembusanP27;
use app\modules\pdsold\models\PdmTahapDua;
use app\modules\pdsold\models\PdmBerkasTahap1;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmPenandatangan;
use app\modules\pdsold\models\VwTerdakwaT2;
use app\modules\pdsold\models\PdmConfig;
use app\modules\pdsold\models\PdmUuPasalTahap2;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;

/**
 * PdmP27Controller implements the CRUD actions for PdmP27 model.
 */
class PdmP27Controller extends Controller
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
     * Lists all PdmP27 models.
     * @return mixed
     */
    public function actionIndex()
    {
        $session        = new Session();
        $id_perkara     = $session->get("id_perkara");
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $searchModel    = new PdmP27Search();
        $dataProvider   = $searchModel->search($no_register,Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PdmP27 model.
     * @param string $no_register_perkara
     * @param string $no_surat_p27
     * @return mixed
     */
    public function actionView($no_register_perkara, $no_surat_p27)
    {
        return $this->render('view', [
            'model' => $this->findModel($no_register_perkara, $no_surat_p27),
        ]);
    }

    /**
     * Creates a new PdmP27 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $session        = new Session();
        $id_perkara     = $session->get("id_perkara");
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $inst_satkerkd  = $session->get('inst_satkerkd');
        $model          = new PdmP27();

        if ($model->load(Yii::$app->request->post()) ) {
            try {
                $model->id_kejati           = $kode_kejati;
                $model->id_kejari           = $kode_kejari;
                $model->id_cabjari          = $kode_cabjari;
                $model->no_register_perkara = $no_register;
                $model->updated_by          = $session->get("nik_user"); 
                $model->updated_ip          = $_SERVER['REMOTE_ADDR'];
                $model->created_ip          = $_SERVER['REMOTE_ADDR'];
                $model->created_by          = $session->get("nik_user");
//                echo '<pre>'; print_r($model);exit();
                if ($model->save()) {
                    
                    if (isset($_POST['new_tembusan'])) {
                        PdmTembusanP27::deleteAll(['no_surat_p27' => $model->no_surat_p27]);
                        for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                            $modelNewTembusan                       = new PdmTembusanP27();
                            $modelNewTembusan->no_surat_p27         = $model->no_surat_p27;
                            $modelNewTembusan->no_register_perkara  = $model->no_register_perkara;
                            $modelNewTembusan->tembusan             = $_POST['new_tembusan'][$i];
                            $modelNewTembusan->no_urut              = ($i+1);
                            if(!$modelNewTembusan->save()){
                                echo "Tembusan".var_dump($modelNewTembusan->getErrors());exit;
                            }
                        }
                    }
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
                    
                }else{
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
                    return $this->redirect('create',[
                        'model'         => $model,
                        'no_register'   => $no_register,
                    ]);
                }
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
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
                return $this->redirect('create',[
                    'model'         => $model,
                    'no_register'   => $no_register,
                ]);
            }
        } else {
            return $this->render('create', [
                'model'         => $model,
                'no_register'   => $no_register,
            ]);
        }
    }

    /**
     * Updates an existing PdmP27 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $no_register_perkara
     * @param string $no_surat_p27
     * @return mixed
     */
    public function actionUpdate($no_surat_p27)
    {
        $session        = new Session();
        $id_perkara     = $session->get("id_perkara");
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $inst_satkerkd  = $session->get('inst_satkerkd');
        $model          = PdmP27::findOne(['no_surat_p27'=>$no_surat_p27]);

        if ($model->load(Yii::$app->request->post())) {
            try {
                
                if ($model->save()) {
                    
                    if (isset($_POST['new_tembusan'])) {
                        PdmTembusanP27::deleteAll(['no_surat_p27' => $model->no_surat_p27]);
                        for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                            $modelNewTembusan                       = new PdmTembusanP27();
                            $modelNewTembusan->no_surat_p27         = $model->no_surat_p27;
                            $modelNewTembusan->no_register_perkara  = $model->no_register_perkara;
                            $modelNewTembusan->tembusan             = $_POST['new_tembusan'][$i];
                            $modelNewTembusan->no_urut              = ($i+1);
                            if(!$modelNewTembusan->save()){
                                echo "Tembusan".var_dump($modelNewTembusan->getErrors());exit;
                            }
                        }
                    }
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'success',
                        'duration' => 3000,
                        'icon' => 'fa fa-users',
                        'message' => 'Data Berhasil di Ubah',
                        'title' => 'Simpan Data',
                        'positonY' => 'top',
                        'positonX' => 'center',
                        'showProgressbar' => true,
                    ]);
                    return $this->redirect('index');
                }else{
//                    $transaction->rollback();
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
                    return $this->redirect('update',[
                        'model'         => $model,
                        'no_register'   => $no_register,
                    ]);
                }
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
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
                return $this->redirect('update',[
                    'model'         => $model,
                    'no_register'   => $no_register,
                ]);
            }
                } else {
            return $this->render('update', [
                'model'         => $model,
                'no_register'   => $no_register,
            ]);
        }
    }

    /**
     * Deletes an existing PdmP27 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $no_register_perkara
     * @param string $no_surat_p27
     * @return mixed
     */
    public function actionDelete()
    {
        $id             = $_POST['hapusIndex'];
        $total          = count($id);
        $session        = new Session();
        $id_perkara     = $session->get("id_perkara");
        $no_register    = $session->get('no_register_perkara');
        try {
            if(count($id) <= 1){
                PdmP27::deleteAll(['no_surat_p27' => $id[0]]);
                
            }else{
                for ($i = 0; $i < count($id); $i++) {
                   PdmP27::deleteAll(['no_surat_p27' => $id[$i]]);
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
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
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
    
    public function actionCetak($id){
        $no_surat_p27   = rawurldecode($id);
        $connection     = \Yii::$app->db;
        $session        = new Session();
        $id_perkara     = $session->get("id_perkara");
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $inst_satkerkd  = $session->get('inst_satkerkd');
        $p27            = PdmP27::findOne(['no_surat_p27'=>$no_surat_p27]);
        $thp_2          = PdmTahapDua::findOne(['no_register_perkara' => $p27->no_register_perkara]);
        $brks_thp_1     = PdmBerkasTahap1::findOne(['id_berkas' => $thp_2->id_berkas]);
        $spdp           = PdmSpdp::findOne(['id_perkara' => $brks_thp_1->id_perkara]);
        $pangkat        = PdmPenandatangan::findOne(['peg_nip_baru' => $p27->id_penandatangan]);
        $tersangka      = VwTerdakwaT2::findOne(['no_register_perkara' => $p27->no_register_perkara,'no_urut_tersangka' => $p27->id_tersangka]);
        /*$pdm_config     = PdmConfig::findOne(['kd_satker'=>$inst_satkerkd]);
        $qry_pt         = "select * from pengadilan_tinggi where kode = '".$pdm_config->p_tinggi."' limit 1";
        $qry_pt_1       = $connection->createCommand($qry_pt);
        $pt             = $qry_pt_1->queryOne();*/
        $listTembusan   = PdmTembusanP27::findAll(['no_surat_p27' => $p27->no_surat_p27]);
        $pasal          = PdmUuPasalTahap2::findAll(['no_register_perkara'=>$no_register]);
        
        return $this->render('cetak', ['spdp'=>$spdp,'tersangka'=>$tersangka,'pangkat'=>$pangkat,'p27'=>$p27,'pt'=>$pt,'pasal'=>$pasal,'listTembusan'=>$listTembusan]);
    }

    /**
     * Finds the PdmP27 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $no_register_perkara
     * @param string $no_surat_p27
     * @return PdmP27 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($no_register_perkara, $no_surat_p27)
    {
        if (($model = PdmP27::findOne(['no_register_perkara' => $no_register_perkara, 'no_surat_p27' => $no_surat_p27])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
