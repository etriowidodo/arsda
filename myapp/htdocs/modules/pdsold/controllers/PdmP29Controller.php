<?php

namespace app\modules\pdsold\controllers;

namespace app\modules\pdsold\controllers;

use Yii;
use app\models\MsJkl;
use app\models\MsAgama;
use app\models\MsWarganegara;
use app\models\MsPendidikan;
use app\modules\pdsold\models\PdmT6;
use app\modules\pdsold\models\PdmT7;
use app\modules\pdsold\models\PdmT8;
use app\modules\pdsold\models\PdmP29;
use app\modules\pdsold\models\PdmRp9;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmMsUu;
use app\modules\pdsold\models\VwTerdakwa;
use app\modules\pdsold\models\PdmSysMenu;
use app\modules\pdsold\models\MsTersangka;
use app\modules\pdsold\models\PdmMsRentut;
use app\modules\pdsold\models\MsLokTahanan;
use app\modules\pdsold\models\PdmP29Search;
use app\modules\pdsold\models\MsUUndangSearch;
use app\modules\pdsold\models\PdmPasalDakwaan;
use app\modules\pdsold\models\PdmAmarPutusP29;
use app\modules\pdsold\models\PdmTahananPenyidik;
use app\modules\pdsold\models\PdmJaksaP16a;
use app\modules\pdsold\models\PdmJaksaP16aSearch;
use app\modules\pdsold\models\PdmTahapDua;
use app\modules\pdsold\models\PdmBerkasTahap1;
use app\modules\pdsold\models\PdmUuPasalTahap2;
use app\modules\pdsold\models\PdmBa4;
use app\modules\pdsold\models\VwTerdakwaT2;
use app\modules\pdsold\models\VwJaksaPenuntutSearch;
use yii\db\Query;
use yii\db\Exception;
use yii\web\Session;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\components\GlobalConstMenuComponent;
use app\components\ConstSysMenuComponent;

/**
 * PdmP29Controller implements the CRUD actions for PdmP29 model.
 */
class PdmP29Controller extends Controller {

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
     * Lists all PdmP29 models.
     * @return mixed
     */
    public function actionIndex() {
        $sysMenu        = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P29]);

        $session        = new Session();
        $id_perkara     = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');

        $searchModel    = new PdmP29Search();
//        $model          = new PdmP29();
        
        $model = PdmP29::findOne(['no_register_perkara'=>$no_register_perkara]);
        if ($model == null) {
            $model = new PdmP29();
        }
//        $model          = PdmP29::findOne(['no_register_perkara'=>$no_register]);
        $dataProvider   = $searchModel->search($no_register, Yii::$app->request->queryParams);

        return $this->render('index', [
            'sysMenu'       => $sysMenu,
            'searchModel'   => $searchModel,
            'dataProvider'  => $dataProvider,
            'model'         => $model,
        ]);
    }

    /**
     * Displays a single PdmP29 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmP29 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P29]);

        $session        = new Session();
        $id_perkara     = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');

        $model          = new PdmP29();
        $modelJpu       = PdmJaksaP16a::findAll(['no_register_perkara' => $no_register]);
        $ba4tsk         = VwTerdakwaT2::findAll(['no_register_perkara' => $no_register ]);

        //$ba4x = PdmBa4::findAll(['no_register_perkara'=>$no_register]);
        //echo '<pre>';print_r($ba4x);exit;

        $modeljaksi     = PdmJaksaP16a::findOne(['no_register_perkara' => $no_register]);
        $searchJPU      = new VwJaksaPenuntutSearch();
        $dataJPU        = $searchJPU->search16a_new($no_register,Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;
        
        $searchUU       = new MsUUndangSearch();
        $dataUU         = $searchUU->search(Yii::$app->request->queryParams);
        $modeluu        = PdmUuPasalTahap2::findAll(['no_register_perkara'=>$no_register]);
//        echo '<pre>';print_r($modeluu);exit();
        if ($model->load(Yii::$app->request->post())) {
            //$transaction = Yii::$app->db->beginTransaction();
            try{
                //echo '<pre>';print_r($_POST['pdmPenahanan']);exit;
                $riwayat_tahanan            = json_encode([$_POST["pdmPenahanan"]]);

//                    $_POST["pdmNoSurat1"],$_POST["pdmTglSurat1"],$_POST["pdmJenis1"],$_POST["pdmTglAwal1"],$_POST["pdmTglAkhir1"],$_POST["pdmLokasi1"],
//                    $_POST["pdmNoSurat2"],$_POST["pdmTglSurat2"],$_POST["pdmJenis2"],$_POST["pdmTglAwal2"],$_POST["pdmTglAkhir2"],$_POST["pdmLokasi2"],
//                    $_POST["pdmNoSurat3"],$_POST["pdmTglSurat3"],$_POST["pdmJenis3"],$_POST["pdmTglAwal3"],$_POST["pdmTglAkhir3"],$_POST["pdmLokasi3"],
//                    $_POST["pdmNoSurat4"],$_POST["pdmTglSurat4"],$_POST["pdmJenis4"],$_POST["pdmTglAwal4"],$_POST["pdmTglAkhir4"],$_POST["pdmLokasi4"],
//                    $_POST["pdmJenis5"],$_POST["pdmJenis6"]
//                        ]);
//                $riwayat_tahanan            = json_encode($riwayat_tahanan1);
//                echo '<pre>';print_r(json_decode($riwayat_tahanan));exit();
                $model->riwayat_penahanan   = $riwayat_tahanan;
                $model->id_kejati           = $kode_kejati;
                $model->id_kejari           = $kode_kejari;
                $model->id_cabjari          = $kode_cabjari;
                $model->no_register_perkara = $no_register;
                $model->tgl_dikeluarkan     = $_POST['PdmP29']['tgl_dikeluarkan'];
                $model->id_penandatangan    = $_POST['PdmJaksaSaksi']['nip'];
                $model->nama                = $_POST['PdmJaksaSaksi']['nama'];
                $model->pangkat             = $_POST['PdmJaksaSaksi']['pangkat'];
                $model->jabatan             = $_POST['PdmJaksaSaksi']['jabatan'];
                $model->updated_by          = $session->get("nik_user"); 
                $model->updated_ip          = $_SERVER['REMOTE_ADDR'];
                $model->created_ip          = $_SERVER['REMOTE_ADDR'];
                $model->created_by          = $session->get("nik_user");
                $model->file_upload         = $_POST['PdmP29']['file_upload'];
//                echo '<pre>';print_r($model);exit();
                if(!$model->save()){
                        var_dump($model->getErrors());exit;
                       }
                    PdmUuPasalTahap2::deleteAll(['no_register_perkara' => $no_register]);
                    $dakwaan_undang_undang_pengantar_baru = $_POST['MsUndang']['undang'];
                        $no = 0;
                        foreach($dakwaan_undang_undang_pengantar_baru AS $_key_undang_undang => $_dakwaan_undang_undang)
                        {
                            $pdmPasal2 = new PdmUuPasalTahap2();
                            $pdmPasal2->id_pasal                =  Yii::$app->globalfunc->getSatker()->inst_satkerkd.date('Y').$no_register.$no++;
                            $pdmPasal2->no_register_perkara     =  $no_register;
                            $pdmPasal2->undang                  =  $_dakwaan_undang_undang;
                            $pdmPasal2->pasal                   =  $_POST['MsUndang']['pasal'][$_key_undang_undang];
                            $pdmPasal2->dakwaan                 =  $_POST['MsUndang']['dakwaan'][$_key_undang_undang];
                            $pdmPasal2->tentang                 =  $_POST['MsUndang']['tentang'][$_key_undang_undang];


                            /*echo $id.'-'.$pdmPasal2->id_pasal .'-'.$_dakwaan_undang_undang.'-'.$_POST['MsUndang']['pasal'][$_key_undang_undang].'-'.$_POST['MsUndang']['dakwaan'][$_key_undang_undang].'<br>';
                            echo '<pre>';*/
                            // print_r($pdmPasal2);
                            // $pdmPasal2->save();
                                if(!$pdmPasal2->save()){
                                    var_dump($pdmPasal2->getErrors());echo "Gagal Simpan Undang - Undang Saat Update Pengantar";exit;
                                }

                        }
                //$transaction->commit();
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
            }catch (Exception $e){
                echo '<pre>';print_r($e);exit;
                //$transaction->rollBack();
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
                    'sysMenu'       => $sysMenu,
                    'model'         => $model,
                    'modelJpu'      => $modelJpu,
                    'modeljaksi'    => $modeljaksi,
                    'searchJPU'     => $searchJPU,
                    'dataJPU'       => $dataJPU,
                    'no_register'   => $no_register,
                    'ba4tsk'        => $ba4tsk,
                    'modeluu'       => $modeluu,
                    'searchUU'      => $searchUU,
                    'dataUU'        => $dataUU,
                ]);
            }
        } else {
            return $this->render('create', [
                'sysMenu'       => $sysMenu,
                'model'         => $model,
                'modelJpu'      => $modelJpu,
                'modeljaksi'    => $modeljaksi,
                'searchJPU'     => $searchJPU,
                'dataJPU'       => $dataJPU,
                'no_register'   => $no_register,
                'ba4tsk'        => $ba4tsk,
                'modeluu'       => $modeluu,
                'searchUU'      => $searchUU,
                'dataUU'        => $dataUU,
            ]);
        }
    }
    
    public function actionShowPasal(){

        $uu = $_GET['uu'];

        $queryParams = array_merge(array(),Yii::$app->request->queryParams);
        $queryParams["MsPasal"]["uu"] = $uu ;

        $searchPasal = new MsPasalSearch();
        $dataPasal = $searchPasal->search($queryParams);
        
        return $this->renderAjax('_pasal', [
            'searchPasal' => $searchPasal,
            'dataPasal' => $dataPasal,
            'id_uu'     => $uu
        ]);
    }
    
    public function actionReferUndang() {
            $searchModel        = new MsUUndangSearch();
            $jns_tindak_pidana  = $_POST['kode_pidana'];
            if ($jns_tindak_pidana == ''){
                $query = MsUUndang::find();
            }else{
                $query = MsUUndang::find()
                ->where('jns_tindak_pidana = :jns_tindak_pidana', [':jns_tindak_pidana' => $jns_tindak_pidana]);
            }
            
            $dataProvider = new ActiveDataProvider([
               'query' => $query,
            ]);
            $dataProvider->pagination->pageSize = '10';

            return $this->renderAjax('//ms-pasal/_undang', [
                       'searchUU'   => $searchModel,
                       'dataUU'  => $dataProvider
            ]);
        }

        
    public function actionShowPasalDgKodePidana(){
       $uu = $_GET['id_uu'];
       $kode_pidana = $_GET['kode_pidana'];
       $jenis_perkara=$_GET['jenis_perkara'];
       if(isset($_GET['jenis_perkara'])){
           $query = MsPasal::find()
           ->where("id = :id and kode_pidana=:kode_pidana and jenis_perkara=:jenis_perkara",[':id'=>$uu,':kode_pidana'=>$kode_pidana,':jenis_perkara'=>$jenis_perkara]);
       }else{
           $query = MsPasal::find()
           ->where("id = :id and kode_pidana=:kode_pidana",[':id'=>$uu,':kode_pidana'=>$kode_pidana]);
       }
       $searchPasal = new MsPasalSearch();

       $dataProvider = new ActiveDataProvider([
           'query' => $query,
       ]);
       $dataProvider->pagination->pageSize = '10';

       return $this->renderAjax('_pasal', [
           'searchPasal' => $searchPasal,
           'dataPasal' => $dataProvider,
           'id_uu'=>$uu,
           'kode_pidana'=>$kode_pidana,
           'jenis_perkara'=>$jenis_perkara,
       ]);
    }
    
    
    public function actionUnggah() {
        $id_no_surat_p29 = $_POST['no_register_perkara'];
        $id_file_upload = $_POST['PdmP29']['file_upload']; 
//        echo $id_no_surat_p29;exit();
        Yii::$app->db->createCommand()
             ->update('pidum.pdm_p29', ['file_upload' => $id_file_upload], ['no_register_perkara'=>$id_no_surat_p29])
             ->execute();
        return $this->redirect(['index']);
    }

    /**
     * Updates an existing PdmP29 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($no_register) {
        $sysMenu        = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P29]);
        
        $session        = new Session();
        $id_perkara     = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');

        $model          = PdmP29::findOne(['no_register_perkara'=>$no_register]);
        $riwayat        = json_decode($model->riwayat_penahanan);
//        echo '<pre>';print_r($riwayat);exit();

        $ba4tsk         = VwTerdakwaT2::findAll(['no_register_perkara' => $no_register]);
        //echo Yii::$app->globalfunc->clean($ba4tsk->no_reg_tahanan);exit;

        $modelJpu       = PdmJaksaP16a::findAll(['no_register_perkara' => $no_register]);
        $modeljaksi     = PdmJaksaP16a::findOne(['no_register_perkara' => $no_register,'nip'=>$model->id_penandatangan,'nama'=>$model->nama]);
        $searchJPU      = new VwJaksaPenuntutSearch();
        $dataJPU        = $searchJPU->search16a_new($no_register,Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;

        $searchUU       = new MsUUndangSearch();
        $dataUU         = $searchUU->search(Yii::$app->request->queryParams);
        $modeluu        = PdmUuPasalTahap2::findAll(['no_register_perkara'=>$no_register]);
        
        if ($model->load(Yii::$app->request->post())) {
            try{
                //echo '<pre>';print_r($_POST);exit;
                $riwayat_tahanan            = json_encode([$_POST["pdmPenahanan"]]);
                $model->riwayat_penahanan   = $riwayat_tahanan;
                $model->no_register_perkara = $no_register;
                $model->tgl_dikeluarkan     = $_POST['PdmP29']['tgl_dikeluarkan'];
                $model->id_penandatangan    = $_POST['PdmJaksaSaksi']['nip'];
                $model->nama                = $_POST['PdmJaksaSaksi']['nama'];
                $model->pangkat             = $_POST['PdmJaksaSaksi']['pangkat'];
                $model->jabatan             = $_POST['PdmJaksaSaksi']['jabatan'];
                $model->file_upload         = $_POST['PdmP29']['file_upload'];
//                echo '<pre>';print_r($model);exit();
                $model->save();
                PdmUuPasalTahap2::deleteAll(['no_register_perkara' => $no_register]);
                    $dakwaan_undang_undang_pengantar_baru = $_POST['MsUndang']['undang'];
                        $no = 0;
                        foreach($dakwaan_undang_undang_pengantar_baru AS $_key_undang_undang => $_dakwaan_undang_undang)
                        {
                            $pdmPasal2 = new PdmUuPasalTahap2();
                            $pdmPasal2->id_pasal                =  Yii::$app->globalfunc->getSatker()->inst_satkerkd.date('Y').$no_register.$no++;
                            $pdmPasal2->no_register_perkara     =  $no_register;
                            $pdmPasal2->undang                  =  $_dakwaan_undang_undang;
                            $pdmPasal2->pasal                   =  $_POST['MsUndang']['pasal'][$_key_undang_undang];
                            $pdmPasal2->dakwaan                 =  $_POST['MsUndang']['dakwaan'][$_key_undang_undang];
                            $pdmPasal2->tentang                 =  $_POST['MsUndang']['tentang'][$_key_undang_undang];


                            /*echo $id.'-'.$pdmPasal2->id_pasal .'-'.$_dakwaan_undang_undang.'-'.$_POST['MsUndang']['pasal'][$_key_undang_undang].'-'.$_POST['MsUndang']['dakwaan'][$_key_undang_undang].'<br>';
                            echo '<pre>';*/
                            // print_r($pdmPasal2);
                            // $pdmPasal2->save();
                                if(!$pdmPasal2->save()){
                                    var_dump($pdmPasal2->getErrors());echo "Gagal Simpan Undang - Undang Saat Update Pengantar";exit;
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
            }catch (Exception $e){
                $transaction->rollBack();
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
                'sysMenu'       => $sysMenu,
                'model'         => $model,
                'modelJpu'      => $modelJpu,
                'modeljaksi'    => $modeljaksi,
                'searchJPU'     => $searchJPU,
                'dataJPU'       => $dataJPU,
                'ba4tsk'        => $ba4tsk,
                'riwayat'       => $riwayat,
                'modeluu'       => $modeluu,
                'searchUU'      => $searchUU,
                'dataUU'        => $dataUU,
                    ]);
            }
            
        } else {
            return $this->render('update', [
                'sysMenu'       => $sysMenu,
                'model'         => $model,
                'modelJpu'      => $modelJpu,
                'modeljaksi'    => $modeljaksi,
                'searchJPU'     => $searchJPU,
                'dataJPU'       => $dataJPU,
                'ba4tsk'        => $ba4tsk,
                'riwayat'       => $riwayat,
                'modeluu'       => $modeluu,
                'searchUU'      => $searchUU,
                'dataUU'        => $dataUU,
            ]);
        }
    }

    /**
     * Deletes an existing PdmP29 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete() {
        $connection             = \Yii::$app->db;
        try{
            $id                     = $_POST['hapusIndex'];
            $total                  = count($id);
            $session                = new Session();
            $id_perkara             = $session->get('id_perkara');
            $no_register_perkara    = $session->get('no_register_perkara');

            if($total == 1){
                PdmP29::deleteAll(['no_register_perkara' => $id[0]]);
            }else{
                for($i=0;$i<count($id);$i++)
                    PdmP29::deleteAll(['no_register_perkara' => $id[$i]]);
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

    public function actionCetak($id){
        $session        = new Session();
        $id_perkara     = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $connection = \Yii::$app->db;
        $qry_p29_1  = "with tbl_perpanjangan_tahan as (
                                select a.no_register_perkara, a.tgl_ba4, a.no_urut_tersangka, c.id_tersangka, min(c.tgl_mulai) as tgl_mulai, 
                                max(c.tgl_selesai) as tgl_selesai
                                from pidum.pdm_ba4_tersangka a 
                                join pidum.pdm_t7 b on a.no_register_perkara = b.no_register_perkara and a.tgl_ba4 = b.tgl_ba4 
                                        and a.no_urut_tersangka = b.no_urut_tersangka and b.tindakan_status = 1
                                join pidum.pdm_t6 c on b.no_register_perkara = c.no_register_perkara and b.no_reg_tahanan_jaksa = c.id_tersangka 
                                group by a.no_register_perkara, a.tgl_ba4, a.no_urut_tersangka, c.id_tersangka 
                        ), tbl_pengalihan_tahan as (
                                select a.no_register_perkara, a.tgl_ba4, a.no_urut_tersangka, c.no_reg_tahanan_jaksa, min(c.tgl_mulai) as tgl_mulai, 
                                max(c.tgl_selesai) as tgl_selesai
                                from pidum.pdm_ba4_tersangka a
                                join pidum.pdm_t7 b on a.no_register_perkara = b.no_register_perkara and a.tgl_ba4 = b.tgl_ba4 
                                        and a.no_urut_tersangka = b.no_urut_tersangka and b.tindakan_status = 1
                                join pidum.pdm_t7 c on b.no_register_perkara = c.no_register_perkara and b.tgl_ba4 = c.tgl_ba4 
                                        and b.no_urut_tersangka = c.no_urut_tersangka and b.no_reg_tahanan_jaksa = c.no_reg_tahanan_jaksa
                                where c.tindakan_status = 3
                                group by a.no_register_perkara, a.tgl_ba4, a.no_urut_tersangka, c.no_reg_tahanan_jaksa
                        ), tbl_penangguhan_tahan as (
                                select a.no_register_perkara, a.tgl_ba4, a.no_urut_tersangka, b.no_surat_t7, max(c.tgl_penangguhan) as tgl_penangguhan 
                                from pidum.pdm_ba4_tersangka a
                                join pidum.pdm_t7 b on a.no_register_perkara = b.no_register_perkara and a.tgl_ba4 = b.tgl_ba4 
                                        and a.no_urut_tersangka = b.no_urut_tersangka and b.tindakan_status = 1
                                join pidum.pdm_t8 c on b.no_register_perkara = c.no_register_perkara and b.tgl_ba4 = c.tgl_ba4 
                                        and b.no_urut_tersangka = c.id_tersangka and b.no_surat_t7 = c.no_surat_t7 
                                where c.id_ms_status_t8 = 1
                                group by a.no_register_perkara, a.tgl_ba4, a.no_urut_tersangka, b.no_surat_t7 
                        ), tbl_pencabutan_tangguh as (
                                select a.no_register_perkara, a.tgl_ba4, a.no_urut_tersangka, b.no_surat_t7, max(c.tgl_penangguhan) as tgl_pencabutan 
                                from pidum.pdm_ba4_tersangka a
                                join pidum.pdm_t7 b on a.no_register_perkara = b.no_register_perkara and a.tgl_ba4 = b.tgl_ba4 
                                        and a.no_urut_tersangka = b.no_urut_tersangka and b.tindakan_status = 1
                                join pidum.pdm_t8 c on b.no_register_perkara = c.no_register_perkara and b.tgl_ba4 = c.tgl_ba4 
                                        and b.no_urut_tersangka = c.id_tersangka and b.no_surat_t7 = c.no_surat_t7 
                                where c.id_ms_status_t8 = 3
                                group by a.no_register_perkara, a.tgl_ba4, a.no_urut_tersangka, b.no_surat_t7 
                        ), tbl_pengeluaran_tahan as (
                                select a.no_register_perkara, a.tgl_ba4, a.no_urut_tersangka, b.no_surat_t7, max(c.tgl_penangguhan) as tgl_pengeluaran 
                                from pidum.pdm_ba4_tersangka a
                                join pidum.pdm_t7 b on a.no_register_perkara = b.no_register_perkara and a.tgl_ba4 = b.tgl_ba4 
                                        and a.no_urut_tersangka = b.no_urut_tersangka and b.tindakan_status = 1
                                join pidum.pdm_t8 c on b.no_register_perkara = c.no_register_perkara and b.tgl_ba4 = c.tgl_ba4 
                                        and b.no_urut_tersangka = c.id_tersangka and b.no_surat_t7 = c.no_surat_t7 
                                where c.id_ms_status_t8 = 2
                                group by a.no_register_perkara, a.tgl_ba4, a.no_urut_tersangka, b.no_surat_t7 
                        )
                        select a.no_register_perkara, a.nama as nama_tersangka, a.tmpt_lahir, a.umur, a.tgl_lahir, c.nama as jenis_kelamin, d.nama as kewarganegaraan, a.alamat, 
                        e.nama as jenis_agama, a.pekerjaan, f.nama as jenis_pendidikan, b.id_ms_loktahanan, g.nama as lokasi_tahanan, b.tgl_mulai, b.tgl_selesai, 
                        h.tgl_mulai as tgl_mulai_perpanjangan, h.tgl_selesai as tgl_selesai_perpanjangan, 
                        i.tgl_mulai as tgl_mulai_pengalihan, i.tgl_selesai as tgl_selesai_pengalihan, j.tgl_penangguhan, k.tgl_pencabutan, l.tgl_pengeluaran, 
                        a1.dikeluarkan, a1.tgl_dikeluarkan, a1.dakwaan, a1.id_penandatangan, a1.nama, a1.pangkat, a1.jabatan 
                        from pidum.pdm_ba4_tersangka a
                        join pidum.pdm_t7 b on a.no_register_perkara = b.no_register_perkara and a.tgl_ba4 = b.tgl_ba4 
                                and a.no_urut_tersangka = b.no_urut_tersangka and b.tindakan_status = 1
                        join pidum.ms_loktahanan g on b.id_ms_loktahanan = g.id_loktahanan 
                        join pidum.pdm_p29 a1 on a.no_register_perkara = a1.no_register_perkara 
                        left join ms_jkl c on a.id_jkl = c.id_jkl 
                        left join ms_warganegara d on a.warganegara = d.id 
                        left join ms_agama e on a.id_agama = e.id_agama 
                        left join ms_pendidikan f on a.id_pendidikan = f.id_pendidikan 
                        left join tbl_perpanjangan_tahan h on a.no_register_perkara = h.no_register_perkara and a.tgl_ba4 = h.tgl_ba4 
                                and a.no_urut_tersangka = h.no_urut_tersangka 
                        left join tbl_pengalihan_tahan i on a.no_register_perkara = i.no_register_perkara and a.tgl_ba4 = i.tgl_ba4 
                                and a.no_urut_tersangka = i.no_urut_tersangka 
                        left join tbl_penangguhan_tahan j on a.no_register_perkara = j.no_register_perkara and a.tgl_ba4 = j.tgl_ba4 
                                and a.no_urut_tersangka = j.no_urut_tersangka 
                        left join tbl_pencabutan_tangguh k on a.no_register_perkara = k.no_register_perkara and a.tgl_ba4 = k.tgl_ba4 
                                and a.no_urut_tersangka = k.no_urut_tersangka 
                        left join tbl_pengeluaran_tahan l on a.no_register_perkara = l.no_register_perkara and a.tgl_ba4 = l.tgl_ba4 
                                and a.no_urut_tersangka = l.no_urut_tersangka 

                        where a.no_register_perkara = '".$id."' ";
        //echo $qry_p29_1; exit;
        $qry_p29        = PdmP29::findBySql($qry_p29_1)->asArray()->all();
        $p29            = PdmP29::findOne(['no_register_perkara'=>$id]);
        $thp_2          = PdmTahapDua::findOne(['no_register_perkara' => $id]);
        $brks_thp_1     = PdmBerkasTahap1::findOne(['id_berkas' => $thp_2->id_berkas]);
        $spdp           = PdmSpdp::findOne(['id_perkara' => $brks_thp_1->id_perkara]);
        $uupasal        = PdmUuPasalTahap2::findAll(['no_register_perkara'=>$no_register]);
        $terdakwa       = VwTerdakwaT2::findAll(['no_register_perkara'=>$no_register]);
        $riwayat        = json_decode($p29->riwayat_penahanan);
//        echo '<pre>';print_r($uupasal);exit();
        return $this->render('cetak', [
            'uupasal'   => $uupasal,
            'qry_p29'   => $qry_p29,
            'spdp'      => $spdp,
            'id'        => $id,
            'p29'       => $p29,
            'riwayat'   => $riwayat,
            'terdakwa'  => $terdakwa
                ]);
    }

    /**
     * Finds the PdmP29 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmP29 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PdmP29::findOne(['id_p29' => $id])) !== null) {
            return $model;
//        } else {
//            throw new NotFoundHttpException('The requested page does not exist.');
        }else{
            $this->redirect(['index']);
        }
    }

    protected function findModelSpdp($id) {
        if (($modelSpdp = PdmSpdp::findOne(['id_perkara' => $id])) !== null) {
            return $modelSpdp;
        }
    }

    public function getTerdakwa($form, $model, $modelSpdp, $readonly) {
        if($readonly){
            $terdakwa = $form->field($model, 'id_tersangka')->dropDownList(
                            ArrayHelper::map(
                                VwTerdakwa::find()
                                    ->where(['=', 'id_perkara', $modelSpdp->id_perkara])
                                    ->all(), 
                                'id_tersangka',
                                'nama'
                            ),
                            ['prompt' => 'Pilih Terdakwa', 'class' => 'cmb_terdakwa', 'disabled' => true]
                    )->label(false);
        }else{
            $tersangkaP29 = '';
            $listTersangkaP29 = PdmP29::find()
                                ->select('id_tersangka')
                                ->where(['id_perkara' => $modelSpdp->id_perkara])
                                ->andWhere(['<>', 'flag', '3'])
                                ->all();
            for($i = 0; $i < count($listTersangkaP29); $i++){
                $tersangkaP29 .= $listTersangkaP29[$i]->id_tersangka . ', ';
            }
            $tersangkaP29 = preg_replace('/, $/', '', $tersangkaP29);
            $terdakwa = $form->field($model, 'id_tersangka')->dropDownList(
                        ArrayHelper::map(
                            VwTerdakwa::find()
                                ->where(['=', 'id_perkara', $modelSpdp->id_perkara])
                                ->andWhere(['not in', 'id_tersangka', [$tersangkaP29]])
                                ->all(), 
                            'id_tersangka',
                            'nama'
                        ),
                        ['prompt' => 'Pilih Terdakwa', 'class' => 'cmb_terdakwa']
                )->label(false);
        }

        $js = <<< JS
            $('.cmb_terdakwa').change(function(){

            $.ajax({
                type: "POST",
                url: '/pdsold/default/terdakwa',
                data: 'id_tersangka='+$('.cmb_terdakwa').val(),
                success:function(data){
                    console.log(data);
                    $('#data-terdakwa').html(
                        '<div class="form-group">'+
                            '<label class="control-label col-sm-2">Tempat Lahir</label>'+
                            '<div class="col-sm-4">'+data.tmpt_lahir+'</div>'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<label class="control-label col-sm-2">Tanggal Lahir</label>'+
                            '<div class="col-sm-4">'+data.tgl_lahir+'</div>'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<label class="control-label col-sm-2">Jenis Kelamin</label>'+
                            '<div class="col-sm-4">'+data.jns_kelamin+'</div>'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<label class="control-label col-sm-2">Tempat Tinggal</label>'+
                            '<div class="col-sm-4">'+data.alamat+'</div>'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<label class="control-label col-sm-2">Agama</label>'+
                            '<div class="col-sm-4">'+data.agama+'</div>'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<label class="control-label col-sm-2">Pekerjaan</label>'+
                            '<div class="col-sm-4">'+data.pekerjaan+'</div>'+
                        '</div>'+
                        '<div class="form-group">'+
                            '<label class="control-label col-sm-2">Pendidikan</label>'+
                            '<div class="col-sm-4">'+data.pendidikan+'</div>'+
                        '</div>'
                    );
                    $('.no_reg_tahanan').val(data.reg_tahanan);
                    $('.ditahan_sejak').val(data.ditahan_sejak);
                }
            });
            /*$.ajax({ //Process the form using $.ajax()
                type      : 'POST', //Method type
                url       : '/pdsold/default/terdakwa', //Your form processing file URL
                data      : 'aa', //Forms name
                dataType  : 'json',
                success   : function(data) {
                            console.log(data);
            };*/
        });
JS;

        $this->view->registerJs($js);
        return $terdakwa;
    }

}
