<?php

namespace app\modules\pdsold\controllers;

use Yii;
use app\modules\pdsold\models\PdmAgendaPersidangan;
use app\modules\pdsold\models\PdmAgendaPersidanganSearch;
use app\modules\pdsold\models\PdmMsStatusData;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;

/**
 * PdmAgendaPersidanganController implements the CRUD actions for PdmAgendaPersidangan model.
 */
class PdmAgendaPersidanganController extends Controller
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
     * Lists all PdmAgendaPersidangan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $session        = new Session();
        $id_perkara     = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $searchModel    = new PdmAgendaPersidanganSearch();
        $dataProvider   = $searchModel->search($no_register, Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PdmAgendaPersidangan model.
     * @param string $no_register_perkara
     * @param string $no_agenda
     * @return mixed
     */
    public function actionView($no_register_perkara, $no_agenda)
    {
        return $this->render('view', [
            'model' => $this->findModel($no_register_perkara, $no_agenda),
        ]);
    }

    /**
     * Creates a new PdmAgendaPersidangan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $session        = new Session();
        $id_perkara     = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $model          = new PdmAgendaPersidangan();
        $modelsdg       = PdmMsStatusData::findAll(['is_group'=> 'P-39']);
        $agenda         = "select COALESCE(max(no_agenda),0,1) +1 as hasil from pidum.pdm_agenda_persidangan where no_register_perkara = '$no_register' ";
        $agenda_1       = PdmAgendaPersidangan::findBySql($agenda)->asArray()->one();
        $majelis_hak    = "select * from pidum.pdm_agenda_persidangan order by no_agenda desc limit 1";
        $majelis_hakim1  = PdmAgendaPersidangan::findBySql($majelis_hak)->asArray()->one();
        $majelis_hkm_1  = json_decode($majelis_hakim1[majelis_hakim]);
        $majelis1       = $majelis_hkm_1[0];
        $majelis2       = $majelis_hkm_1[1];
        $penasehat_hkm  = json_decode($majelis_hakim1[penasehat_hukum]);
        $penasehat1     = $penasehat_hkm[0];
        $penasehat2     = $penasehat_hkm[1];
        $panitera       = json_decode($majelis_hakim1[panitera]);
        $panitera1      = $panitera[0];
        $panitera2      = $panitera[1];
//        echo '<pre>';print_r($majelis1);exit();
        
        if ($model->load(Yii::$app->request->post())) {
            try {
                
                if ($_POST['txt_nama_surat2_2'] == ''){
                    $text2                      = json_encode(array([""],[""]));
                }else{
                    $text2                      = json_encode(array($_POST['txt_nama_surat2'],$_POST['txt_nama_surat2_2']));
                }
                $text1                      = json_encode(array($_POST['txt_nama_surat1'],$_POST['txt_nama_surat1_1']));
                
                $text3                      = json_encode(array($_POST['txt_nama_surat3'],$_POST['txt_nama_surat3_3']));
                
//                $agenda                     = "select COALESCE(max(no_agenda),0,1) +1 as hasil from pidum.pdm_agenda_persidangan ";
//                $agenda_1                   = PdmAgendaPersidangan::findBySql($agenda)->asArray()->one();
//                $model->no_agenda           = $agenda_1[hasil];
                $acara                      = PdmMsStatusData::findOne(['is_group'=> 'P-39 ', 'id'=> $_POST['PdmAgendaPersidangan']['acara_sidang']]);
                $model->sidang_ke           = "";
                $model->acara_sidang_ke     = "Sidang ke ".$_POST['PdmAgendaPersidangan']['no_agenda']." / ".$_POST['PdmAgendaPersidangan']['tgl_acara_sidang']." / ".$acara->nama;
                $model->majelis_hakim       = $text1;
                $model->penasehat_hukum     = $text2;
                $model->panitera            = $text3;
                $model->id_kejati           = $kode_kejati;
                $model->id_kejari           = $kode_kejari;
                $model->id_cabjari          = $kode_cabjari;
                $model->updated_by          = $session->get("nik_user"); 
                $model->updated_ip          = $_SERVER['REMOTE_ADDR'];
                $model->created_ip          = $_SERVER['REMOTE_ADDR'];
                $model->created_by          = $session->get("nik_user");
                $model->no_register_perkara = $no_register;
//                echo '<pre>';print_r($model);exit();
                if(!$model->save()){
                        var_dump($model->getErrors());exit;
                       }
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
                    'duration' => 3000, //Integer //3000 default. time for growl to fade out.
                    'icon' => 'glyphicon glyphicon-ok-sign', //String
                    'message' => 'Data Berhasil di Simpan',
                    'title' => 'Simpan Data',
                    'positonY' => 'top', //String // defaults to top, allows top or bottom
                    'positonX' => 'center', //String // defaults to right, allows right, center, left
                    'showProgressbar' => true,
                ]);
                return $this->redirect(['index']);
                
            } catch (Exception $e) {
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
                return $this->redirect('create', [
                    'model'         => $model,
                    'modelsdg'      => $modelsdg,
                    'agenda_1'      => $agenda_1,
                    'majelis1'      => $majelis1,
                    'majelis2'      => $majelis2,
                    'penasehat1'    => $penasehat1,
                    'penasehat2'    => $penasehat2,
                    'panitera1'     => $panitera1,
                    'panitera2'     => $panitera2,
                ]);
            }
        } else {
            return $this->render('create', [
                'model'         => $model,
                'modelsdg'      => $modelsdg,
                'agenda_1'      => $agenda_1,
                'majelis1'      => $majelis1,
                'majelis2'      => $majelis2,
                'penasehat1'    => $penasehat1,
                'penasehat2'    => $penasehat2,
                'panitera1'     => $panitera1,
                'panitera2'     => $panitera2,
            ]);
        }
    }

    /**
     * Updates an existing PdmAgendaPersidangan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $no_register_perkara
     * @param string $no_agenda
     * @return mixed
     */
    public function actionUpdate($no_agenda)
    {
        $session        = new Session();
        $id_perkara     = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $model          = PdmAgendaPersidangan::findOne(['no_agenda'=>$no_agenda]);
        $modelsdg       = PdmMsStatusData::findAll(['is_group'=> 'P-39 ']);
        $majelis_hkm_1  = json_decode($model->majelis_hakim);
        $majelis1       = $majelis_hkm_1[0];
        $majelis2       = $majelis_hkm_1[1];
        $penasehat_hkm  = json_decode($model->penasehat_hukum);
        $penasehat1     = $penasehat_hkm[0];
        $penasehat2     = $penasehat_hkm[1];
        $panitera       = json_decode($model->panitera);
        $panitera1      = $panitera[0];
        $panitera2      = $panitera[1];
//        print_r($majelis1);exit();

        if ($model->load(Yii::$app->request->post())) {
            try {
                
                if ($_POST['txt_nama_surat2_2'] == ''){
                    $text2                      = json_encode(array([""],[""]));
                }else{
                    $text2                      = json_encode(array($_POST['txt_nama_surat2'],$_POST['txt_nama_surat2_2']));
                }
                $text1                      = json_encode(array($_POST['txt_nama_surat1'],$_POST['txt_nama_surat1_1']));
//                $text2                      = json_encode(array($_POST['txt_nama_surat2'],$_POST['txt_nama_surat2_2']));
                $text3                      = json_encode(array($_POST['txt_nama_surat3'],$_POST['txt_nama_surat3_3']));
                
                $acara                      = PdmMsStatusData::findOne(['is_group'=> 'P-39 ', 'id'=> $_POST['PdmAgendaPersidangan']['acara_sidang']]);
                $model->sidang_ke           = "";
                $model->acara_sidang_ke     = "Sidang ke ".$_POST['PdmAgendaPersidangan']['no_agenda']." / ".$_POST['PdmAgendaPersidangan']['tgl_acara_sidang']." / ".$acara->nama;
                $model->majelis_hakim       = $text1;
                $model->penasehat_hukum     = $text2;
                $model->panitera            = $text3;
                $model->no_register_perkara = $no_register;
                if(!$model->save()){
                        var_dump($model->getErrors());exit;
                       }
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
                    'duration' => 3000, //Integer //3000 default. time for growl to fade out.
                    'icon' => 'glyphicon glyphicon-ok-sign', //String
                    'message' => 'Data Berhasil di Simpan',
                    'title' => 'Simpan Data',
                    'positonY' => 'top', //String // defaults to top, allows top or bottom
                    'positonX' => 'center', //String // defaults to right, allows right, center, left
                    'showProgressbar' => true,
                ]);
                return $this->redirect(['index']);
                
            } catch (Exception $e) {
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
                return $this->redirect('update', [
                    'model'         => $model,
                    'modelsdg'      => $modelsdg,
                    'majelis1'      => $majelis1,
                    'majelis2'      => $majelis2,
                    'penasehat1'    => $penasehat1,
                    'penasehat2'    => $penasehat2,
                    'panitera1'     => $panitera1,
                    'panitera2'     => $panitera2,
                ]);
            }
        } else {
            return $this->render('update', [
                'model'         => $model,
                'modelsdg'      => $modelsdg,
                'majelis1'      => $majelis1,
                'majelis2'      => $majelis2,
                'penasehat1'    => $penasehat1,
                'penasehat2'    => $penasehat2,
                'panitera1'     => $panitera1,
                'panitera2'     => $panitera2,
            ]);
        }
    }

    /**
     * Deletes an existing PdmAgendaPersidangan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $no_register_perkara
     * @param string $no_agenda
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
                PdmAgendaPersidangan::deleteAll(['no_agenda' => $id[0]]);
                
            }else{
                for ($i = 0; $i < count($id); $i++) {
                   PdmAgendaPersidangan::deleteAll(['no_agenda' => $id[$i]]);
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

    /**
     * Finds the PdmAgendaPersidangan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $no_register_perkara
     * @param string $no_agenda
     * @return PdmAgendaPersidangan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($no_register_perkara, $no_agenda)
    {
        if (($model = PdmAgendaPersidangan::findOne(['no_register_perkara' => $no_register_perkara, 'no_agenda' => $no_agenda])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
