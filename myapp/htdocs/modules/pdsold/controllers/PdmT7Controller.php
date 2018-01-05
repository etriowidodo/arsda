<?php

namespace app\modules\pdsold\controllers;

use Yii;
use app\components\GlobalConstMenuComponent;
use app\models\MsAgama;
use app\models\MsJkl;
use app\models\MsPendidikan;
use app\models\MsWarganegara;
use app\modules\pdsold\models\MsTersangka;
use app\modules\pdsold\models\PdmBA15Search;
use app\modules\pdsold\models\PdmBa15;
use app\modules\pdsold\models\PdmJaksaSaksi;
use app\modules\pdsold\models\PdmMsTindakanStatus;
use app\modules\pdsold\models\PdmNotaPendapatSearch;
use app\modules\pdsold\models\PdmNotaPendapat;
use app\modules\pdsold\models\PdmRp9;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmBa4;
use app\modules\pdsold\models\PdmP16ASearch;
use app\modules\pdsold\models\PdmSysMenu;
use app\modules\pdsold\models\MsTersangkaSearch;
use app\modules\pdsold\models\PdmT7;
use app\modules\pdsold\models\PdmT7Search;
use app\modules\pdsold\models\PdmTembusan;
use app\modules\pdsold\models\PdmTembusanT7;
use app\modules\pdsold\models\PdmJaksaP16a;
use app\modules\pdsold\models\PdmPenandatangan;
use app\modules\pdsold\models\VwJaksaPenuntutSearch;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;

/**
 * PdmT7Controller implements the CRUD actions for pdmt7 model.
 */
class PdmT7Controller extends Controller {

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
     * Lists all pdmt7 models.
     * @return mixed
     */
    public function actionIndex() {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::T7]);
        $searchModel = new PdmT7Search();
        $session = new Session();
        $id                     = $session->get('id_perkara');
        $no_register_perkara    = $session->get('no_register_perkara');
        $dataProvider = $searchModel->search($no_register_perkara, Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'sysMenu' => $sysMenu
        ]);
    }

    /**
     * Displays a single pdmt7 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new pdmt7 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::T7]);
        $session = new Session();
        $id = $session->get('id_perkara');
        $no_register_perkara = $session->get('no_register_perkara');
        $model = new PdmT7();
		$searchJPU = new VwJaksaPenuntutSearch();
        $dataProviderJPU = $searchJPU->search16a_new($id,Yii::$app->request->queryParams);
        //echo '<pre>';print_r($dataProviderJPU);exit;
        $dataProviderJPU->pagination->pageSize = 5;

        $queryJpu = new Query;
        $queryJpu->select('a.*')
                ->from('pidum.pdm_jaksa_saksi a')
                ->where(['a.id_perkara' => $id]);
        $modelTersangka =  PdmBa4::findAll(['no_register_perkara'=>$no_register_perkara]);
        // echo '<pre>';    
        // print_r($modelTersangka);exit;
        //$modelJpu = $queryJpu->one();
        //$id_perkara = PdmTahapDua::findOne(['no_register_perkara'=>$no_register])->id_perkara;
        $id_p16 = Yii::$app->globalfunc->GetLastP16a($id)->no_surat_p16a;
        $modelJpu       = PdmJaksaP16a::findAll(['no_surat_p16a'=>$id_p16]);

        $modelTindakanStatus = PdmMsTindakanStatus::find()->all();
        $connection     = \Yii::$app->db;
        $no_register             = $session->get('no_register_perkara');
        $qry_jns                 = "select * from  pidum.pdm_nota_pendapat where no_register_perkara ='".$no_register."'";
        $qry_jns_1               = $connection->createCommand($qry_jns);
        $modelnotaPendapat       = $qry_jns_1->queryAll();
        // var_dump($modelNotaPendapat);exit;

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            //echo '<pre>';print_r($_POST);exit;
                    //print_r((Yii::$app->request->post()));exit;
                    if($_POST['lama20hari'] != ''){
                    	$lama = $_POST['lama20hari'];
                    }else if($_POST['lama5hari'] != ''){
                    	$lama = $_POST['lama5hari'];
                    }else{
                    	$lama = '';
                    }
            try {
                $count_pdm_t7 = PdmT7::findOne([
                                                    "no_register_perkara"       =>$no_register_perkara,
                                                    "no_surat_t7"               =>$_POST['PdmT7']['no_surat_t7'],
                                            ]);
                // echo $count_pdm_t7;exit;
                //    echo '<pre>';
                // print_r($_POST);
                // exit;
               if(count($count_pdm_t7)>0){
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'danger',
                    'duration' => 10000,
                    'icon' => 'glyphicon glyphicon-ok-sign', //String
                    'message' => 'Tidak Bisa Menyimpan, Data Sudah Pernah Disimpan Silahkan Isi Dengan Benar No Surat T7 berbeda Dengan Data Yang Sudah Pernah Disimpan',
                    'title' => 'Error',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
                  echo "<script>window.history.go(-1);</script>";
                  exit;
               }

                $model->no_register_perkara =$no_register_perkara;

                $no_surat = $_POST['PdmT7']['no_surat_t7'];
                if($no_surat==''){
                    $no_surat = uniqid().'^';
                }

                $data_jpu  = array(    'no_urut'           => $_POST['no_urut'],
                                        'nama_jpu'          => $_POST['nama_jpu'],
                                        'nip_baru'          => $_POST['nip_baru'],
                                        'gol_jpu'           => $_POST['gol_jpu'],
                                        'jabatan_jpu'       => $_POST['jabatan_jpu']);
                //echo '<pre>';print_r($data_jpu);exit;
                $model->no_surat_t7         =$no_surat;
                $model->undang              =$_POST['PdmT7']['undang'];
                $model->tahun               =$_POST['PdmT7']['tahun'];
                $model->tentang             =$_POST['PdmT7']['tentang'] ;
                $model->penahanan_dari      =$_POST['PdmT7']['penahanan_dari'] ;
                $model->no_surat_perintah   =$_POST['PdmT7']['no_surat_perintah'] ;
                $model->tgl_srt_perintah    =$_POST['PdmT7']['tgl_srt_perintah'] ;
                $model->tindakan_status     =$_POST['PdmT7']['tindakan_status'];
                $model->nama_tersangka_ba4  =$_POST['PdmT7']['nama_tersangka_ba4'] ;
                //$model->nama_jaksa          =$_POST['PdmT7']['nama_jaksa'] ;
                $model->id_ms_loktahanan    =$_POST['PdmT7']['id_ms_loktahanan'] ;
                $model->lokasi_tahanan      =$_POST['PdmT7']['lokasi_tahanan'] ;
                $model->lama                =$_POST['PdmT7']['lama'] ;
                $model->tgl_mulai           =$_POST['PdmT7']['tgl_mulai'];
                $model->tgl_selesai         =date('Y-m-d', strtotime('+'.($model->lama-1).' days', strtotime($model->tgl_mulai)));
                $model->dikeluarkan         =$_POST['PdmT7']['dikeluarkan'] ;
                $model->tgl_dikeluarkan     =$_POST['PdmT7']['tgl_dikeluarkan'] ;
                $model->id_penandatangan    =$_POST['PdmT7']['id_penandatangan'];
                $model->tgl_ba4             =$_POST['PdmT7']['tgl_ba4'] ;
                $model->no_urut_tersangka   =$_POST['PdmT7']['no_urut_tersangka'] ;
                $model->no_surat_p16a       =$_POST['PdmT7']['no_surat_p16a'] ;
                $model->upload_file         =$_POST['PdmT7']['upload_file'] ;
                $model->id_nota_pendapat       =$_POST['PdmT7']['id_nota_pendapat'] ;
                $model->no_reg_tahanan_jaksa = $_POST['PdmT7']['no_reg_tahanan_jaksa'];
                $model->created_by          = $session->get("nik_user"); 
                $model->updated_by          = $session->get("nik_user"); 
                $model->id_kejati           = $session->get("kode_kejati"); 
                $model->id_kejari           = $session->get("kode_kejari"); 
                $model->id_cabjari          = $session->get("kode_cabjari");

                $model->nama                = $_POST['hdn_nama_penandatangan'];
                $model->pangkat             = $_POST['hdn_pangkat_penandatangan'];
                $model->jabatan             = $_POST['hdn_jabatan_penandatangan'];
                $model->json_jpu            = json_encode($data_jpu);
                if(!isset($_POST['PdmT7']['tindakan_status'])){
                    $model->tindakan_status = 1;
                }

                if ($model->save()) {
                    
                    PdmTembusanT7::deleteAll(['no_register_perkara' => $no_register_perkara, 'no_surat_t7' => $model->no_surat_t7]);
                    if (!empty($_POST['new_tembusan'])) {
                        $a = 1;
                        for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {                           
                            $modelNewTembusan = new PdmTembusanT7();
                            $modelNewTembusan->no_register_perkara = $no_register_perkara;
                            $modelNewTembusan->no_surat_t7         = $model->no_surat_t7;
                            $modelNewTembusan->no_urut             = $a+$i;
                            $modelNewTembusan->tembusan            = $_POST['new_tembusan'][$i];
                            $modelNewTembusan->save();
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
                    var_dump($model->getErrors());echo "Ba4";  exit;
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
                    return $this->redirect('create');
                }
            } catch (Exception $e) {
                $transaction->rollback();
            }
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'modelJpu' => $modelJpu,
                        'modelTindakanStatus' => $modelTindakanStatus,
                        'modelTersangka'    => $modelTersangka,
                        'modelnotaPendapat' => $modelnotaPendapat,
                        'modelSpdp' => $modelSpdp,
                        'searchJPU' => $searchJPU,
                        'dataProviderJPU' => $dataProviderJPU,
                        'sysMenu' => $sysMenu
            ]);
        }
    }

    /**
     * Updates an existing pdmt7 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionJpu() {
            $searchModel = new VwJaksaPenuntutSearch();
            $dataProvider = $searchModel->search16a_new(Yii::$app->request->queryParams);
     //var_dump ($dataProvider);exit;
    //echo $dataProvider['pangkat'];exit;
      $dataProvider->pagination->pageSize = 5;
            return $this->renderAjax('_jpu', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
    }

    public function actionGetNotaPendapat($id){
         $connection     = \Yii::$app->db;
         $qry_jns                 = "select *,(select count(c.*) from pidum.pdm_t7 c where b.no_register_perkara=a.no_register_perkara and b.no_urut_tersangka = a.no_urut_tersangka) as ada from pidum.pdm_nota_pendapat a 
                                        Inner JOIN pidum.pdm_ba4_tersangka b on a.no_register_perkara = b.no_register_perkara 
                                                AND a.no_urut_tersangka = b.no_urut_tersangka
                                        where a.id_nota_pendapat = '".$id."'  ";
        $qry_jns_1               = $connection->createCommand($qry_jns);
        $modelnotaPendapat       = $qry_jns_1->queryAll();
        echo json_encode($modelnotaPendapat);
    }
    public function actionUpdate($no_register_perkara,$no_surat_t7) {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::T7]);

        $session = new Session();
        $id_perkara = $session->get("id_perkara");
        $no_register_perkara = $session->get('no_register_perkara');

         $model  = PdmT7::findOne([
                                        "no_register_perkara"       => $no_register_perkara,
                                        "no_surat_t7"               => $no_surat_t7
                                   ]);
        $searchJPU = new VwJaksaPenuntutSearch();
        $dataProviderJPU = $searchJPU->search16a_new($id,Yii::$app->request->queryParams);
        $dataProviderJPU->pagination->pageSize = 5;

        //$id_perkara = PdmTahapDua::findOne(['no_register_perkara'=>$no_register])->id_perkara;
        $id_p16 = Yii::$app->globalfunc->GetLastP16($id_perkara)->id_p16;
         $modelJpu       = PdmJaksaP16a::findAll(['no_surat_p16a'=>$id_p16]);


        $queryJpu = new Query;
        $queryJpu->select('a.*')
                ->from('pidum.pdm_jaksa_saksi a')
                ->where(['a.id_perkara' => $id]);
        $modelTersangka =  PdmBa4::findAll(['no_register_perkara'=>$no_register_perkara]);
        // echo '<pre>';
        // print_r($modelTersangka);exit;
        $modelJpu = $queryJpu->one();
        $modelTindakanStatus = PdmMsTindakanStatus::find()->all();

        $connection     = \Yii::$app->db;
        $no_register             = $session->get('no_register_perkara');
        $qry_jns                 = "select * from  pidum.pdm_nota_pendapat where no_register_perkara ='".$no_register."'";
        $qry_jns_1               = $connection->createCommand($qry_jns);
        $modelnotaPendapat       = $qry_jns_1->queryAll();

        if ($model->load(Yii::$app->request->post())) {
            // echo '<pre>';
            // print_r($_POST);exit;
            $transaction = Yii::$app->db->beginTransaction();
            try {

                $no_surat = $_POST['PdmT7']['no_surat_t7'];
                if($no_surat==''){
                    $no_surat = uniqid().'^';
                }
                $data_jpu  = array(    'no_urut'           => $_POST['no_urut'],
                                        'nama_jpu'          => $_POST['nama_jpu'],
                                        'nip_baru'          => $_POST['nip_baru'],
                                        'gol_jpu'           => $_POST['gol_jpu'],
                                        'jabatan_jpu'       => $_POST['jabatan_jpu']);

                $model->no_surat_t7         =$no_surat;


                $model->no_reg_tahanan_jaksa=$_POST['PdmT7']['no_reg_tahanan_jaksa'];
                $model->undang              =$_POST['PdmT7']['undang'];
                $model->tahun               =$_POST['PdmT7']['tahun'];
                $model->tentang             =$_POST['PdmT7']['tentang'] ;
                $model->penahanan_dari      =$_POST['PdmT7']['penahanan_dari'] ;
                $model->no_surat_perintah   =$_POST['PdmT7']['no_surat_perintah'] ;
                $model->tgl_srt_perintah    =$_POST['PdmT7']['tgl_srt_perintah'] ;
                $model->tindakan_status     =$_POST['PdmT7']['tindakan_status'];
                $model->nama_tersangka_ba4  =$_POST['PdmT7']['nama_tersangka_ba4'] ;
                //$model->nama_jaksa          =$_POST['PdmT7']['nama_jaksa'] ;
                $model->id_ms_loktahanan    =$_POST['PdmT7']['id_ms_loktahanan'] ;
                $model->lokasi_tahanan      =$_POST['PdmT7']['lokasi_tahanan'] ;
                $model->lama                =$_POST['PdmT7']['lama'] ;
                $model->tgl_mulai           =$_POST['PdmT7']['tgl_mulai'];
                $model->tgl_selesai         =date('Y-m-d', strtotime('+'.($model->lama - 1).' days', strtotime($model->tgl_mulai)));
                $model->dikeluarkan         =$_POST['PdmT7']['dikeluarkan'] ;
                $model->tgl_dikeluarkan     =$_POST['PdmT7']['tgl_dikeluarkan'] ;
                $model->id_penandatangan    =$_POST['PdmT7']['id_penandatangan'];
                $model->tgl_ba4             =$_POST['PdmT7']['tgl_ba4'] ;
                $model->no_urut_tersangka   =$_POST['PdmT7']['no_urut_tersangka'] ;
                $model->no_surat_p16a       =$_POST['PdmT7']['no_surat_p16a'] ;
                $model->upload_file         =$_POST['PdmT7']['upload_file'] ;
                $model->no_jaksa_p16a       =$_POST['PdmT7']['no_jaksa_p16a'] ;
                $model->created_by          = $session->get("nik_user"); 
                $model->updated_by          = $session->get("nik_user"); 
                $model->id_kejati           = $session->get("kode_kejati"); 
                $model->id_kejari           = $session->get("kode_kejari"); 
                $model->id_cabjari          = $session->get("kode_cabjari");
                $model->created_by          = $session->get("nik_user"); 
                $model->updated_by          = $session->get("nik_user"); 
                $model->id_kejati           = $session->get("kode_kejati"); 
                $model->id_kejari           = $session->get("kode_kejari"); 
                $model->id_cabjari          = $session->get("kode_cabjari");
                $model->json_jpu            = json_encode($data_jpu);

                if(!empty($_POST['hdn_nama_penandatangan']) )
                {
                    $model->nama                = $_POST['hdn_nama_penandatangan'];
                    $model->pangkat             = $_POST['hdn_pangkat_penandatangan'];
                    $model->jabatan             = $_POST['hdn_jabatan_penandatangan'];
                }

                if(!isset($_POST['PdmT7']['tindakan_status'])){
                    $model->tindakan_status = 1;
                }
                // echo '<img src="'.$model->upload_file.'">';
                // echo $_POST['hdn_nama_penandatangan'];
                // echo '<pre>';
                // print_r($model);exit;

                if ($model->save() || $model->update()) {

                  
                    
                    PdmTembusanT7::deleteAll(['no_register_perkara' => $no_register_perkara, 'no_surat_t7' => $model->no_surat_t7]);
                    if (!empty($_POST['new_tembusan'])) {
                        $a = 1;
                        for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {                           
                            $modelNewTembusan = new PdmTembusanT7();
                            $modelNewTembusan->no_register_perkara = $no_register_perkara;
                            $modelNewTembusan->no_surat_t7         = $model->no_surat_t7;
                            $modelNewTembusan->no_urut             = $a+$i;
                            $modelNewTembusan->tembusan            = $_POST['new_tembusan'][$i];
                            $modelNewTembusan->save();
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
                    return $this->redirect(['update', 'id' => $model->id_t7]);
                }
            } catch (Exception $e) {
                $transaction->rollback();
                return $this->redirect('index');
            }
        } else {
            return $this->render('update', [

                        'model' => $model,
                        'modelJpu' => $modelJpu,
                        'modelTindakanStatus' => $modelTindakanStatus,
                        'modelTersangka'    => $modelTersangka,
                        'modelnotaPendapat' => $modelnotaPendapat,
                        'modelSpdp' => $modelSpdp,
                        'searchJPU' => $searchJPU,
                        'dataProviderJPU' => $dataProviderJPU,
                        'sysMenu' => $sysMenu
            ]);
        }
    }

    /**
     * Deletes an existing pdmt7 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */

     public function actionReferTersangka() {
         $session = new Session();

        $no_register_perkara = $session->get('no_register_perkara');
        $searchModel = new MsTersangkaSearch();
        $dataProvider2 = $searchModel->searchTersangkaBa4New($no_register_perkara ,Yii::$app->request->queryParams);

        //var_dump ($dataProvider2);exit;
        //echo $dataProvider['id_tersangka'];exit;
        //$dataProvider->pagination->pageSize = 5;
        $dataProvider2->pagination->pageSize = 5;
        return $this->renderAjax('_tersangka', [
                    'searchModel'   => $searchModel,
                    'dataProvider2' => $dataProvider2,
        ]);
    }
    public function actionDelete() {
        // echo 'h';exit;
        $arr= array();
        $id_tahap = $_POST['hapusIndex'][0];

            if($id_tahap=='all'){
                    $id_tahapx=PdmT7::find()->select("no_register_perkara,no_surat_t7")->asArray()->all();
                    foreach ($id_tahapx as $key => $value) {
                        $arr[] = $value['no_register_perkara']."_".$value['no_surat_t7'];
                    }
                    $id_tahap=$arr;
                    
                    // print_r($id_tahap);exit;
            }else{
                $id_tahap = $_POST['hapusIndex'];
                 // print_r($id_tahap);exit;
            }


        $count = 0;
           foreach($id_tahap AS $key_delete => $delete){
             try{
                    $split = explode("_",$delete);
                    PdmT7::deleteAll(['no_register_perkara' => $split[0],'no_surat_t7'=>$split[1]]);
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
     * Finds the pdmt7 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return pdmt7 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = pdmt7::findOne($id)) !== null) {
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

    public function actionCetak($no_register_perkara,$no_surat_t7) {



        $sqlnya = "select a.*,d.no_berkas,d.tgl_berkas,b.kasus_posisi,c.no_reg_tahanan,e.nama as loktahanan,
                    f.jabatan as jabatan_jaksa, f.pangkat as pangkat_jaksa, f.nip As nip_jaksa ,c.*,
                        g.nama as warganegara,
                        h.nama as identitas,
                        i.nama as jkl,
                        j.nama as agama,
                        k.nama as pendidikan,
                        a.nama as nama_ttd_t7,
                        a.pangkat as pangkat_ttd_t7,
                        a.jabatan as jabatan_ttd_t7,
                        a.id_penandatangan as nip_ttd_t7
                    from pidum.pdm_t7 a 
                    left join pidum.pdm_tahap_dua b on a.no_register_perkara = b.no_register_perkara
                    left join pidum.pdm_ba4_tersangka c on a.no_register_perkara = c.no_register_perkara 
                        AND a.tgl_ba4 = c.tgl_ba4 
                        AND a.no_urut_tersangka = c.no_urut_tersangka
                                left join public.ms_warganegara g on c.warganegara = g.id 
                                left join public.ms_identitas h on c.id_identitas = h.id_identitas 
                                left join public.ms_jkl i on c.id_jkl = i.id_jkl 
                                left join public.ms_agama j on c.id_agama = j.id_agama
                                left join public.ms_pendidikan k on c.id_pendidikan = k.id_pendidikan
                    left join pidum.pdm_berkas_tahap1 d on b.id_berkas = d.id_berkas                         
                    left join pidum.ms_loktahanan e on a.id_ms_loktahanan = e.id_loktahanan
                    left join pidum.pdm_jaksa_p16a f on a.no_register_perkara = f.no_register_perkara 
                        And a.no_surat_p16a = f.no_surat_p16a and a.no_jaksa_p16a = f.no_urut
                        where a.no_register_perkara = '".$no_register_perkara."' AND a.no_surat_t7 = '".$no_surat_t7."'";
        $model  = PdmT7::findBySql($sqlnya)->asArray()->one();
        

        $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_tembusan_t7')
                ->where("no_register_perkara='" . $no_register_perkara . "' and no_surat_t7 ='".$no_surat_t7."' ");
        $data = $query->createCommand();
        $tembusan = $data->queryAll();


        // $tembusan = PdmTembusanT7::find([
        //                                     "no_register_perkara"   => $no_register_perkara,
        //                                     "no_surat_t7"           => $no_surat_t7         
        //                                ])->asArray()->All();
        // echo '<pre>';print_r($tembusan);exit;
        // echo '<pre>';
        // print_r($tembusan);exit;
        // echo '<pre>';
        // print_r($model);exit;
        // $model  = PdmBa4::find([
        //                                 "no_register_perkara"   => $no_register_perkara,
        //                                 "tgl_ba4"               => $tgl_ba4,
        //                                 "no_urut_tersangka"     => $no_urut_tersangka
        //                             ])->asArray()->One();
        // echo '<pre>';
        // print_r($model);exit;
        return $this->render('cetak', ['model'=>$model,'tembusan'=>$tembusan]);
    }

}
