<?php

namespace app\modules\pdsold\controllers;

use app\components\GlobalConstMenuComponent;
use app\models\MsSifatSurat;
use app\modules\pdsold\models\PdmP39;
use app\modules\pdsold\models\PdmP39Search;
use app\modules\pdsold\models\PdmAgendaPersidangan;
use app\modules\pdsold\models\PdmP16a;
use app\modules\pdsold\models\PdmPkTingRef;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmBerkasTahap1;
use app\modules\pdsold\models\PdmTahapDua;
use app\modules\pdsold\models\PdmSysMenu;
use app\modules\pdsold\models\PdmTembusan;
use app\modules\pdsold\models\PdmJaksaP16a;
use app\modules\pdsold\models\PdmPenandatangan;
use app\modules\pdsold\models\VwTerdakwaT2;
use app\modules\pdsold\models\PdmTembusanP39;
use Odf;
use Yii;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;
use yii\web\Response;

/**
 * PdmP39Controller implements the CRUD actions for PdmP39 model.
 */
class PdmP39Controller extends Controller {

    public $sysMenu;

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

    public function init() {
        $this->sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P39]);
    }

    /**
     * Lists all PdmP39 models.
     * @return mixed
     */
    public function actionIndex() {
        
        $session        = new Session();
        $id_perkara     = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        
        $searchModel    = new PdmP39Search();
        $dataProvider   = $searchModel->search($no_register,Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel'   => $searchModel,
            'dataProvider'  => $dataProvider,
            'no_register'   => $no_register,
            'sysMenu'       => $this->sysMenu
        ]);
    }

    /**
     * Displays a single PdmP39 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmP39 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    
    public function actionAgenda() {
        $session = new session();    
        $no_register_perkara = $session->get('no_register_perkara');
        $no_agenda      = $_POST['no_agenda'];
//        echo $no_agenda;exit();
        $agenda         = PdmAgendaPersidangan::findOne(['no_register_perkara'=>$no_register_perkara,'no_agenda'=>$no_agenda]);

        $majelis_hkm_1  = json_decode($agenda->majelis_hakim);
        $majelis1       = $majelis_hkm_1[0];
        $majelis2       = $majelis_hkm_1[1];
        
        $penasehat_hkm  = json_decode($agenda->penasehat_hukum);
        $penasehat1     = $penasehat_hkm[0];
        $penasehat2     = $penasehat_hkm[1];
        
        $panitera       = json_decode($agenda->panitera);
        $panitera1      = $panitera[0];
        $panitera2      = $panitera[1];
//        echo $majelis2;exit();
        $majelis2_array='';
        if(count($majelis1)>0){
            foreach ($majelis1 as $datamajelis1){
            $majelis1_array     .= $datamajelis1."#";
            }    
        }
        
        $majelis2_array='';
        if(count($majelis2)>0){
            foreach ($majelis2 as $datamajelis2){
            $majelis2_array     .= $datamajelis2."#";
            }
        }
        
        $penasehat1_array='';
        if(count($penasehat1)>0){
            foreach ($penasehat1 as $datapenasehat1){
                $penasehat1_array     .= $datapenasehat1."#";
            }
        }
        
        $penasehat2_array='';
        if(count($penasehat2)>0){
            foreach ($penasehat2 as $datapenasehat2){
                $penasehat2_array     .= $datapenasehat2."#";
            }
        }
        
        $panitera1_array='';
        if(count($panitera1)>0){
            foreach ($panitera1 as $datapanitera1){
                $panitera1_array     .= $datapanitera1."#";
            }
        }
        
        $panitera2_array='';
        if(count($panitera2)>0){
            foreach ($panitera2 as $datapanitera2){
                $panitera2_array     .= $datapanitera2."#";
            }
        }
        
//        echo $penasehat2_array;exit();
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'acara_sidang'  => $agenda->acara_sidang,
            'sidang_ke'     => $agenda->no_agenda,//$agenda->sidang_ke,
            'uraian_sidang' => $agenda->uraian_sidang,
            'pengunjung'    => $agenda->pengunjung,
            'kesimpulan'    => $agenda->kesimpulan,
            'pendapat'      => $agenda->pendapat,
            'majelis1'      => $majelis1_array,
            'majelis2'      => $majelis2_array,
            'penasehat1'    => $penasehat1_array,
            'penasehat2'    => $penasehat2_array,
            'panitera1'    => $panitera1_array,
            'panitera2'    => $panitera2_array,
        ];
    }
    
    
    public function actionCreate() {
        $sysMenu        = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P39 ]);
        $session        = new Session();
        $id_perkara     = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $sqlag          = " SELECT d.* from pidum.pdm_agenda_persidangan d 
                            WHERE d.no_register_perkara= '".$no_register."' 
                            AND d.no_agenda not in (select c.no_agenda from pidum.pdm_p39 c WHERE c.no_register_perkara= '".$no_register."' )";
        $queryag        = Yii::$app->db->createCommand($sqlag);
        $agenda         = $queryag->queryAll();
        //echo '<pre>';print_r($agenda);exit;



        $qry_p16a       = "select * from pidum.pdm_p16a where no_register_perkara = '".$no_register."' order by tgl_dikeluarkan desc limit 1 ";
        $p16a           = PdmP16a::findBySql($qry_p16a)->asArray()->one();
//        echo $p16a[no_surat_p16a];exit();
        $jaksap16a      = PdmJaksaP16a::findAll(['no_surat_p16a'=>$p16a[no_surat_p16a]]);
        $model          = new PdmP39();

        if ($model->load(Yii::$app->request->post())) {
            try {
                
                if ($_POST['txt_nama_surat4_4'] == ''){
                    $text4                      = json_encode(array([""],[""]));
                }else{
                    $text4                      = json_encode(array($_POST['txt_nama_surat4'],$_POST['txt_nama_surat4_4']));
                }
                $text1                      = json_encode(array($_POST['txt_nama_surat1'],$_POST['txt_nama_surat1_1']));
                $text2                      = json_encode(array($_POST['txt_nama_surat2'],$_POST['txt_nama_surat2_2']));
                $text3                      = json_encode($_POST['txt_nama_surat3']);
//                $text4                      = json_encode(array($_POST['txt_nama_surat4'],$_POST['txt_nama_surat4_4']));
                
                
                $model->acara_sidang        = $_POST['PdmP39']['acara_sidang'];
                $model->hakim               = $text1;
                $model->panitera            = $text2;
                $model->penuntut_umum       = $text3;
                $model->penasihat_hukum     = $text4;
                $model->id_kejati           = $kode_kejati;
                $model->id_kejari           = $kode_kejari;
                $model->id_cabjari          = $kode_cabjari;
                $model->updated_by          = $session->get("nik_user"); 
                $model->updated_ip          = $_SERVER['REMOTE_ADDR'];
                $model->created_ip          = $_SERVER['REMOTE_ADDR'];
                $model->created_by          = $session->get("nik_user");
                $model->no_register_perkara = $no_register;
//                echo '<pre>';print_r($model);exit();
                if($model->save()){
                    if (isset($_POST['new_tembusan'])) {
                        PdmTembusanP39::deleteAll(['no_surat_p39' => $model->no_surat_p39]);
                        for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                            $modelNewTembusan                       = new PdmTembusanP39();
                            $modelNewTembusan->no_surat_p39         = $model->no_surat_p39;
                            $modelNewTembusan->no_register_perkara  = $no_register;
                            $modelNewTembusan->tembusan             = $_POST['new_tembusan'][$i];
                            $modelNewTembusan->no_urut              = ($i+1);
                            if(!$modelNewTembusan->save()){
                                echo "Tembusan".var_dump($modelNewTembusan->getErrors());exit;
                            }
                        }
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

                        return $this->redirect(['update', 'no_surat_p39'=>$model->no_surat_p39]);
                }  else {
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'danger',
                        'duration' => 3000,
                        'icon' => 'glyphicon glyphicon-ok-sign', //String
                        'message' => 'Data Gagal di Simpan',
                        'title' => 'Simpan Data',
                        'positonY' => 'top',
                        'positonX' => 'center',
                        'showProgressbar' => true,
                    ]);
                    return $this->redirect('create', [
                        'model'         => $model,
                        'sysMenu'       => $sysMenu,
                        'no_register'   => $no_register,
                        'agenda'        => $agenda,
                        'jaksap16a'     => $jaksap16a,
                        'p16a'          => $p16a,
                    ]);
                }
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
                    'sysMenu'       => $sysMenu,
                    'no_register'   => $no_register,
                    'agenda'        => $agenda,
                    'jaksap16a'     => $jaksap16a,
                    'p16a'          => $p16a,
                ]);
            }
        } else {
            return $this->render('create', [
                'model'         => $model,
                'sysMenu'       => $sysMenu,
                'no_register'   => $no_register,
                'agenda'        => $agenda,
                'jaksap16a'     => $jaksap16a,
                'p16a'          => $p16a,
            ]);
        }
    }

    /**
     * Updates an existing PdmP39 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($no_surat_p39) {
        $sysMenu        = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P39 ]);
        $session        = new Session();
        $id_perkara     = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        //$agenda         = PdmAgendaPersidangan::findAll(['no_register_perkara'=>$no_register]);
        $sqlag          = " SELECT d.* from pidum.pdm_agenda_persidangan d 
                            WHERE d.no_register_perkara= '".$no_register."'";
        $queryag        = Yii::$app->db->createCommand($sqlag);
        $agenda         = $queryag->queryAll();

        $qry_p16a       = "select * from pidum.pdm_p16a where no_register_perkara = '".$no_register."' order by tgl_dikeluarkan desc limit 1 ";
        $p16a           = PdmP16a::findBySql($qry_p16a)->asArray()->one();
//        echo $p16a[no_surat_p16a];exit();
        $jaksap16a      = PdmJaksaP16a::findAll(['no_surat_p16a'=>$p16a[no_surat_p16a]]);
        $model          = PdmP39::findOne(['no_surat_p39'=>$no_surat_p39]);
        $majelis_hkm_1  = json_decode($model->hakim);
        $majelis1       = $majelis_hkm_1[0];
        $majelis2       = $majelis_hkm_1[1];
        
        $penasehat_hkm  = json_decode($model->penasihat_hukum);
        $penasehat1     = $penasehat_hkm[0];
        $penasehat2     = $penasehat_hkm[1];
        
        $panitera       = json_decode($model->panitera);
        $panitera1      = $panitera[0];
        $panitera2      = $panitera[1];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            try {
                
                if ($_POST['txt_nama_surat4_4'] == ''){
                    $text4                      = json_encode(array([""],[""]));
                }else{
                    $text4                      = json_encode(array($_POST['txt_nama_surat4'],$_POST['txt_nama_surat4_4']));
                }
                $text1                      = json_encode(array($_POST['txt_nama_surat1'],$_POST['txt_nama_surat1_1']));
                $text2                      = json_encode(array($_POST['txt_nama_surat2'],$_POST['txt_nama_surat2_2']));
                $text3                      = json_encode($_POST['txt_nama_surat3']);
//                $text4                      = json_encode(array($_POST['txt_nama_surat4'],$_POST['txt_nama_surat4_4']));
                
                
                $model->acara_sidang        = $_POST['PdmP39']['acara_sidang'];
                $model->hakim               = $text1;
                $model->panitera            = $text2;
                $model->penuntut_umum       = $text3;
                $model->penasihat_hukum     = $text4;
//                echo '<pre>';print_r($model);exit();
                if($model->save()){
                    if (isset($_POST['new_tembusan'])) {
                        PdmTembusanP39::deleteAll(['no_surat_p39' => $model->no_surat_p39]);
                        for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                            $modelNewTembusan                       = new PdmTembusanP39();
                            $modelNewTembusan->no_surat_p39         = $model->no_surat_p39;
                            $modelNewTembusan->no_register_perkara  = $no_register;
                            $modelNewTembusan->tembusan             = $_POST['new_tembusan'][$i];
                            $modelNewTembusan->no_urut              = ($i+1);
                            if(!$modelNewTembusan->save()){
                                echo "Tembusan".var_dump($modelNewTembusan->getErrors());exit;
                            }
                        }
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
                }  else {
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'danger',
                        'duration' => 3000,
                        'icon' => 'glyphicon glyphicon-ok-sign', //String
                        'message' => 'Data Gagal di Simpan',
                        'title' => 'Simpan Data',
                        'positonY' => 'top',
                        'positonX' => 'center',
                        'showProgressbar' => true,
                    ]);
                    return $this->redirect('update', [
                        'model'         => $model,
                        'sysMenu'       => $sysMenu,
                        'no_register'   => $no_register,
                        'agenda'        => $agenda,
                        'jaksap16a'     => $jaksap16a,
                        'p16a'          => $p16a,
                        'majelis1'      => $majelis1,
                        'majelis2'      => $majelis2,
                        'penasehat1'    => $penasehat1,
                        'penasehat2'    => $penasehat2,
                        'panitera1'     => $panitera1,
                        'panitera2'     => $panitera2,
                    ]);
                }
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
                    'sysMenu'       => $sysMenu,
                    'no_register'   => $no_register,
                    'agenda'        => $agenda,
                    'jaksap16a'     => $jaksap16a,
                    'p16a'          => $p16a,
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
                'sysMenu'       => $sysMenu,
                'no_register'   => $no_register,
                'agenda'        => $agenda,
                'jaksap16a'     => $jaksap16a,
                'p16a'          => $p16a,
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
     * Deletes an existing PdmP39 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete() {
        $session = new session();
        $no_register_perkara = $session->get('no_register_perkara');
        $arr= array();
        $id_tahap = $_POST['hapusIndex'][0];
        
            if($id_tahap=='all'){
                    $id_tahapx=PdmP39::find()->select("no_surat_p39")->where(['no_register_perkara'=>$no_register_perkara])->asArray()->all();
                    foreach ($id_tahapx as $key => $value) {
                        $arr[] = $value['no_surat_p39'];
                        
                    }
                    $id_tahap=$arr;
            }else{
                $id_tahap = $_POST['hapusIndex'];
            }

        

        $count = 0;
           foreach($id_tahap AS $key_delete => $delete){
             try{
                    PdmP39::deleteAll(['no_register_perkara' => $no_register_perkara, 'no_surat_p39'=>$delete]);
                }catch (\yii\db\Exception $e) {
                    $count++;
                }
            }
            if($count>0){
                Yii::$app->getSession()->setFlash('success', [
                     'type' => 'danger',
                     'duration' => 5000,
                     'icon' => 'fa fa-users',
                     'message' =>  $count.' Data Berkas Tidak Dapat Dihapus Karena Sudah Digunakan Di Persuratan Lainnya',
                     'title' => 'Error',
                     'positonY' => 'top',
                     'positonX' => 'center',
                     'showProgressbar' => true,
                 ]);
                 return $this->redirect(['index']);
            }

            return $this->redirect(['index']);
    }

    /**
     * Finds the PdmP39 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmP39 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PdmP39::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCetak($id) {
        $no_surat_p39   = rawurldecode($id);
        $connection     = \Yii::$app->db;
        $session        = new Session();
        $id_perkara     = $session->get("id_perkara");
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $inst_satkerkd  = $session->get('inst_satkerkd');
        $p39            = PdmP39::findOne(['no_surat_p39'=>$no_surat_p39]);
        $thp_2          = PdmTahapDua::findOne(['no_register_perkara' => $p39->no_register_perkara]);
        $brks_thp_1     = PdmBerkasTahap1::findOne(['id_berkas' => $thp_2->id_berkas]);
        $spdp           = PdmSpdp::findOne(['id_perkara' => $brks_thp_1->id_perkara]);
        $pangkat        = PdmJaksaP16a::findOne(['nip' => $p39->id_penandatangan]);
        $tersangka      = VwTerdakwaT2::findAll(['no_register_perkara' => $p39->no_register_perkara]);
        $listTembusan   = PdmTembusanP39::findAll(['no_surat_p39' => $p39->no_surat_p39]);
        $sifat          = MsSifatSurat::findOne(['id'=>$p39->sifat]);
        $pidana         = PdmPkTingRef::findOne(['id' => $spdp->id_pk_ting_ref]);
        $qry_p16a       = "select * from pidum.pdm_p16a where no_register_perkara = '".$no_register."' order by tgl_dikeluarkan desc limit 1 ";
        $p16a           = PdmP16a::findBySql($qry_p16a)->asArray()->one();
        $agenda         = PdmAgendaPersidangan::findOne(['no_agenda'=>$p39->no_agenda, 'no_register_perkara'=>$p39->no_register_perkara]);
        
//        echo $p16a[no_surat_p16a];exit();
        $jaksap16a      = PdmJaksaP16a::findAll(['no_surat_p16a'=>$p16a[no_surat_p16a]]);
//        print_r($jaksap16a);exit();
        
        $majelis_hkm_1  = json_decode($p39->hakim);
        $majelis1       = $majelis_hkm_1[0];
        $majelis2       = $majelis_hkm_1[1];
        
        $penasehat_hkm  = json_decode($p39->penasihat_hukum);
        $penasehat1     = $penasehat_hkm[0];
        $penasehat2     = $penasehat_hkm[1];
        
        $panitera       = json_decode($p39->panitera);
        $panitera1      = $panitera[0];
        $panitera2      = $panitera[1];
//        echo count($penasehat2);exit();
        
        return $this->render('cetak', ['spdp'=>$spdp,'tersangka'=>$tersangka,'pangkat'=>$pangkat,'p39'=>$p39,'listTembusan'=>$listTembusan,'sifat'=>$sifat,'pidana'=>$pidana,
                'majelis1'      => $majelis1,
                'majelis2'      => $majelis2,
                'penasehat1'    => $penasehat1,
                'penasehat2'    => $penasehat2,
                'panitera1'     => $panitera1,
                'panitera2'     => $panitera2,
                'agenda'        => $agenda,
                'jaksap16a'     => $jaksap16a
                ]);
    }

}
