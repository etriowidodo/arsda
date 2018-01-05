<?php

namespace app\modules\pdsold\controllers;

use Yii;
use app\components\GlobalConstMenuComponent;
use app\models\MsAgama;
use app\models\MsJkl;
use app\models\MsPendidikan;
use app\models\MsWarganegara;
use app\modules\pdsold\models\MsTersangka;
use app\modules\pdsold\models\MsTersangkaSearch;
use app\modules\pdsold\models\PdmJaksaSaksi;
use app\modules\pdsold\models\PdmJaksaP16;
use app\modules\pdsold\models\PdmP16a;
use app\modules\pdsold\models\PdmP16aSearch;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmSysMenu;
use app\modules\pdsold\models\PdmTembusan;
use app\modules\pdsold\models\VwJaksaPenuntutSearch;
use app\modules\pdsold\models\PdmPenandatangan;
use app\modules\pdsold\models\VwTersangka;
use app\modules\pdsold\models\PdmTembusanP16a;
use app\modules\pdsold\models\PdmJaksaP16a;
use app\modules\pdsold\models\PdmPasal;
use app\modules\pdsold\models\PdmTahapDua;
use app\modules\pdsold\models\PdmBerkasTahap1;
use app\modules\pdsold\models\PdmStatusSurat;
use app\modules\pdsold\models\MsPenyidik;
use app\modules\pdsold\models\PdmBa4;
use app\modules\pdsold\models\PdmBa4Search;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;
use yii\web\UploadedFile;

/**
 * PdmP16AController implements the CRUD actions for PdmP16A model.
 */
class PdmP16aController extends Controller {

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
     * Lists all PdmP16A models.
     * @return mixed
     */
    public function actionIndex() {
        $session        = new Session();
        $id_perkara     = $session->get("id_perkara");
        $no_register    = $session->get("no_register_perkara");
        $sysMenu        = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P16A]);
        $searchModel    = new PdmP16ASearch();
        $dataProvider   = $searchModel->search($no_register,Yii::$app->request->queryParams);
        $model          = new PdmP16a();

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'sysMenu' => $sysMenu,
                    'model'=>$model
        ]);
    }
    
    public function actionUnggah() {
        $id_no_surat_p16a = $_POST['no_surat_p16a'];
        $id_file_upload = $_POST['PdmP16a']['file_upload']; 
        Yii::$app->db->createCommand()
             ->update('pidum.pdm_p16a', ['file_upload' => $id_file_upload], ['no_surat_p16a'=>$id_no_surat_p16a])
             ->execute();
        return $this->redirect(['index']);
    }

    /**
     * Displays a single PdmP16A model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmP16A model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//    protected function findModelSpdp($id) {
//        if (($modelSpdp = PdmSpdp::findOne($id)) !== null) {
//            return $modelSpdp;
//        } else {
//            throw new NotFoundHttpException('The requested page does not exist.');
//        }
//    }
    
    protected function findModelTersangka($id) {
        if (($model = MsTersangka::findAll(['id_perkara' => $id])) !== null) {
           // var_dump($model);exit;
			return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelPasal($id) {
        if (($model = PdmPasal::findAll(['id_perkara' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionCreate() {
        $sysMenu        = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P16A]);
        $session        = new Session();
        $id             = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $model          = new PdmP16a();
        $modelttd       = new PdmPenandatangan();
        
        $modelTersangka = PdmBa4::findAll(['no_register_perkara' => $no_register]);
        $modelPasal     = $this->findModelPasal($id);
        $id_perkara = PdmTahapDua::findOne(['no_register_perkara'=>$no_register])->id_perkara;
        $id_p16 = Yii::$app->globalfunc->GetLastP16($id_perkara)->id_p16;
        $modelJpu       = PdmJaksaP16::findAll(['id_p16'=>$id_p16]);

        //echo '<pre>';print_r($modelJpu);exit;

        $searchModelTersangka   = new PdmBa4Search();
        $dataProviderTersangka  = $searchModelTersangka->search($no_register,$no_register);
        $dataProviderTersangka->pagination = ['defaultPageSize' => 10];
        
        if ($modelPasal == null) {
            $modelPasal = new PdmPasal();
        }
        
        $tgl_max        = PdmP16a::findOne(['no_register_perkara' => $no_register])->tgl_dikeluarkan;
        
//        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $jml_pt     = Yii::$app->db->createCommand(" SELECT (count(*)+1) as jml FROM pidum.pdm_p16a WHERE no_register_perkara='".$id."' AND (file_upload is NOT null OR file_upload <> '') ")->queryOne();
                $trim       = explode('-',$_POST['tgl_dikeluarkan-pdmp16a-tgl_dikeluarkan']);
                $tgl        = $trim[2].'-'.$trim[1].'-'.$trim[0];
                $nop16      = str_replace("'","''",$model->no_surat_p16a);//--
                //$seq        = Yii::$app->db->createCommand("select public.generate_pk_perkara('pidum.pdm_p16a', 'no_surat_p16a', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" .$nop16. "')")->queryOne();
                
                if($_POST['hdn_nama_penandatangan'] != ''){
                    $model->nama = $_POST['hdn_nama_penandatangan'];
                    $model->pangkat = $_POST['hdn_pangkat_penandatangan'];
                    $model->jabatan = $_POST['hdn_jabatan_penandatangan'];
                }
                
                $model->no_register_perkara = $no_register;
                
                $model->tgl_dikeluarkan     = $tgl;
                $files                      = UploadedFile::getInstance($model, 'file_upload');
                $file_lama                  = $model->getOldAttributes()['file_upload'];
                if ($files != false && !empty($files) ) {
                    $model->file_upload = preg_replace('/[^A-Za-z0-9\-]/', '',$id) . '/p16_'.$jml_pt['jml'].'.'. $files->extension;
                    $path               = Yii::$app->basePath . '/web/template/pdsold_surat/' . preg_replace('/[^A-Za-z0-9\-]/', '',$id) . '/p16_'.$jml_pt['jml'].'.'. $files->extension;
                    $files->saveAs($path);
                }
                
                $model->id_kejati   = $kode_kejati;
                $model->id_kejari   = $kode_kejari;
                $model->id_cabjari  = $kode_cabjari;
                $model->file_upload = $_POST['PdmP16a']['file_upload']; 
//                echo '<pre>';print_r($model);exit();
//                echo $_POST['PdmP16a']['file_upload']; exit();
                if(!$model->save()){
                    echo "P-16a".var_dump($model->getErrors());exit;
                }
                $jml_is_akhir = Yii::$app->db->createCommand(" select count(*) from pidum.pdm_status_surat where id_sys_menu = 'P-16a' and id_perkara='".$no_register."' ")->queryScalar();
                if($jml_is_akhir < 1){
                    Yii::$app->globalfunc->getSetStatusProcces($id, GlobalConstMenuComponent::P16A);
                    Yii::$app->db->createCommand("UPDATE pidum.pdm_status_surat SET is_akhir='0' WHERE id_sys_menu = 'SPDP' AND id_perkara=:id")
                            ->bindValue(':id', $no_register)
                            ->execute();
                }
                
                $nip        = $_POST['nip_jpu'];
                $nama       = $_POST['nama_jpu'];
                $jabatan    = $_POST['jabatan_jpu'];
                $pangkat    = $_POST['gol_jpu'];
                $no_urut    = $_POST['no_urut'];
                $nip_baru   = $_POST['nip_baru'];
                
                if (!empty($nip)) {
                    PdmJaksaP16a::deleteAll(['no_register_perkara' => $model->no_register_perkara, 'no_surat_p16a' => $model->no_surat_p16a]);
                    for ($i = 0; $i < count($nip); $i++) {
                        $modelJpu1  = new PdmJaksaP16a();
                        
                        $modelJpu1->id_kejati           = $kode_kejati;
                        $modelJpu1->id_kejari           = $kode_kejari;
                        $modelJpu1->id_cabjari          = $kode_cabjari;
                        $modelJpu1->no_register_perkara = $no_register;
                        $modelJpu1->no_surat_p16a       = $model->no_surat_p16a;
                        $modelJpu1->nip                 = $nip_baru[$i];
                        $modelJpu1->nama                = $nama[$i];
                        $modelJpu1->jabatan             = $jabatan[$i];
                        $modelJpu1->pangkat             = $pangkat[$i];
                        $modelJpu1->no_urut             = ($i+1);
                        if(!$modelJpu1->save()){
                            echo "Jaksa".var_dump($modelJpu1->getErrors());exit;
                        }
                    }
                }
                
                //insert tembusan
                if (isset($_POST['new_tembusan'])) {
                    PdmTembusanP16a::deleteAll(['no_surat_p16a' => $model->no_surat_p16a]);
                    for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                        $modelNewTembusan   = new PdmTembusanP16a();
                        $modelNewTembusan->no_surat_p16a        = $model->no_surat_p16a;
                        $modelNewTembusan->no_register_perkara  = $model->no_register_perkara;
                        $modelNewTembusan->tembusan             = $_POST['new_tembusan'][$i];
                        $modelNewTembusan->no_urut              = ($i+1);
                        if(!$modelNewTembusan->save()){
                            echo "Tembusan".var_dump($modelNewTembusan->getErrors());exit;
                        }
                    }
                }
                
                $transaction->commit();
		if(isset($_POST['printToSave'])){
                    if($_POST['printToSave']==1){
                        echo $model->no_surat_p16a;
                    }
                    else {
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
                         return $this->redirect(['index']);
                    }
                }
            }catch (Exception $e) {
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
        }else {
            return $this->render('update', [
                'model' => $model,
//                'modelSpdp' => $modelSpdp,
                'modelTersangka' => $modelTersangka,
                'modelPasal' => $modelPasal,
                'modelJpu' => $modelJpu,
                'sysMenu' => $sysMenu,
                'dataProviderTersangka' => $dataProviderTersangka,
                'tgl_max' => $tgl_max
            ]);
        }
    }   
    
    public function actionCekNoSuratP16a()
    {
        $nop16 = str_replace(" ","",$_POST['no_surat_p16a']);
        $query = PdmP16a::find()
        ->where(['REPLACE(no_surat_p16a,\' \',\'\')' => $nop16])
        ->all();
        echo count($query);
    }

    /**
     * Updates an existing PdmP16A model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionsSaveData() {
        $session = new Session();
        $id = $session->get('no_register_perkara');
        PdmJaksaP16a::deleteAll(['no_register_perkara' => $model->no_register_perkara, 'code_table' => GlobalConstMenuComponent::P16A, 'id_table' => $model->no_surat_p16a]);
        PdmTembusanP16a::deleteAll(['no_register_perkara' => $model->no_register_perkara]);
        $model = new PdmP16a();
    }
    
    public function actionJpu() {
        $searchModel = new VwJaksaPenuntutSearch();
        $dataProvider = $searchModel->search2(Yii::$app->request->queryParams);
        //var_dump ($dataProvider);exit;
        //echo $dataProvider['pangkat'];exit;
        $dataProvider->pagination->pageSize = 5;
            return $this->renderAjax('_jpu', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        }   
        
        
        protected function findModel($id) {
            if (($model = PdmP16a::findOne(['no_surat_p16a' => $id])) !== null) {
             //var_dump($model);exit;
                            return $model;
            }  /*else {
              $model= new PdmP16();
              $model->id_perkara=$id;
              $model->save();
              return $this->findModel($id);
              } */
        }
        
        
        public function actionUpdate($id) {
        $sysMenu        = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P16A]);
        $session        = new Session();
        $id_perkara     = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
        $model          = $this->findModel($id);
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        
        if ($model == null) {
            $model = new PdmP16a();
        }
        
        $modelTersangka = PdmBa4::findAll(['no_register_perkara' => $no_register]);
        $modelPasal     = $this->findModelPasal($id);
        $modelJpu       = PdmJaksaP16a::find()->where(['no_surat_p16a' => $id])->orderBy('no_urut asc')->all();

        $searchModelTersangka   = new PdmBa4Search();
        $dataProviderTersangka  = $searchModelTersangka->search($no_register,$no_register);
        $dataProviderTersangka->pagination = ['defaultPageSize' => 10];

        if ($modelPasal == null) {
            $modelPasal = new PdmPasal();
        }

        if ($model->load(Yii::$app->request->post())) {
//            try {
                $jml_pt = Yii::$app->db->createCommand(" SELECT (count(*)+1) as jml FROM pidum.pdm_p16a WHERE no_register_perkara='".$id_perkara."' AND (file_upload is NOT null OR file_upload <> '') ")->queryOne();
                if($_POST['hdn_nama_penandatangan'] != ''){
                    $model->nama    = $_POST['hdn_nama_penandatangan'];
                    $model->pangkat = $_POST['hdn_pangkat_penandatangan'];
                    $model->jabatan = $_POST['hdn_jabatan_penandatangan'];
                }

                $nip        = $_POST['nip_jpu'];
                $nama       = $_POST['nama_jpu'];
                $jabatan    = $_POST['jabatan_jpu'];
                $pangkat    = $_POST['gol_jpu'];
                $no_urut    = $_POST['no_urut'];
                $nip_baru   = $_POST['nip_baru'];

                // exit();
                //CMS_PIDUM00-EtrioWidodo -Update
                $trim   = explode('-',$_POST['tgl_dikeluarkan-pdmp16a-tgl_dikeluarkan']);
                $tgl    = $trim[2].'-'.$trim[1].'-'.$trim[0];
                //CMS_PIDUM00-EtrioWidodo -Update

                $nop16      = str_replace("'","''",$_POST['PdmP16a']['no_surat_p16a']);
                $seq        = Yii::$app->db->createCommand("select public.generate_pk_perkara('pidum.pdm_p16a', 'no_surat_p16a', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" .$nop16. "')")->queryOne();
    //            $model->no_surat_p16a = $seq['generate_pk_perkara'];

                $files      = UploadedFile::getInstance($model, 'file_upload');
                $file_lama  = $model->getOldAttributes()['file_upload'];

                if ($files != false && !empty($files) ) {
                    if($file_lama !=''){
                        $model->file_upload = $file_lama;
                        $path = Yii::$app->basePath . '/web/template/pdsold_surat/' . $file_lama;
                        $files->saveAs($path);
                    }else{
                        $model->file_upload = preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/p16a_'.$jml_pt['jml'].'.'. $files->extension;
                        $path = Yii::$app->basePath . '/web/template/pdsold_surat/' . preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/p16_'.$jml_pt['jml'].'.'. $files->extension;
                        $files->saveAs($path);
                    }
                }else{
                        $model->file_upload = $file_lama;
                }

    //            $model->no_surat_p16a   = $_POST['no_surat_p16a'];

                $model->file_upload = $_POST['PdmP16a']['file_upload']; 
    //            echo '<pre>'.print_r($model);exit();
                if(!$model->save()){
                    var_dump($model->getErrors());exit;
                }
                
                
                if (!empty($nip_baru)) {
//                        PdmJaksaP16a::deleteAll(['no_register_perkara' => $model->no_register_perkara, 'no_surat_p16a' => $model->no_surat_p16a]);
                                    //Yii::$app->db->createCommand(" DELETE FROM pidum.pdm_jaksa_p16 WHERE id_p16='".$id."' ")->execute();
                                    //echo " DELETE FROM pidum.pdm_jaksa_p16 WHERE id_p16='".$id."' ";exit;
                        for ($i = 0; $i < count($nip_baru); $i++) {
                            $modelJpu1  = new PdmJaksaP16a();
                            $modelJpu1->no_register_perkara = $no_register;
        //                    $modelJpu1->id_jpp = $seq['generate_pk_perkara']."|".($i+1);
                            $modelJpu1->id_kejati           = $kode_kejati;
                            $modelJpu1->id_kejari           = $kode_kejari;
                            $modelJpu1->id_cabjari          = $kode_cabjari;
                            $modelJpu1->no_surat_p16a       = $model->no_surat_p16a;
                            $modelJpu1->nip                 = $nip_baru[$i];
                            $modelJpu1->nama                = $nama[$i];
                            $modelJpu1->jabatan             = $jabatan[$i];
                            $modelJpu1->pangkat             = $pangkat[$i];
                            $modelJpu1->no_urut             = ($i+1);
                            $modelJpu1->update();
                        }

                    }
//                    else{
//                        for ($i = 0; $i < count($nip_baru); $i++) {
//                            $modelJpu1  = new PdmJaksaP16a();
//                            $modelJpu1->no_register_perkara = $no_register;
//        //                    $modelJpu1->id_jpp = $seq['generate_pk_perkara']."|".($i+1);
//                            $modelJpu1->id_kejati           = $kode_kejati;
//                            $modelJpu1->id_kejari           = $kode_kejari;
//                            $modelJpu1->id_cabjari          = $kode_cabjari;
//                            $modelJpu1->no_surat_p16a       = $model->no_surat_p16a;
//                            $modelJpu1->nip                 = $nip_baru[$i];
//                            $modelJpu1->nama                = $nama[$i];
//                            $modelJpu1->jabatan             = $jabatan[$i];
//                            $modelJpu1->pangkat             = $pangkat[$i];
//                            $modelJpu1->no_urut             = ($i+1);
//                            $modelJpu1->save();
//                    }}
                

                

                //Insert tabel tembusan
                if (isset($_POST['new_tembusan'])) {
                    PdmTembusanP16a::deleteAll(['no_surat_p16a' => $model->no_surat_p16a]);
                    for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                        $modelNewTembusan = new PdmTembusanP16a();
                        $modelNewTembusan->no_register_perkara = $no_register;
                        $modelNewTembusan->no_surat_p16a = $model->no_surat_p16a;
                        $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                        $modelNewTembusan->no_urut = ($i+1);
                        if(!$modelNewTembusan->save()){
                            var_dump($modelNewTembusan->getErrors());exit;
                        }
                    }
                }

               if(isset($_POST['printToSave'])){
                   if($_POST['printToSave']==2){
                       echo $model->no_surat_p16a;
                   }else{
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
                        return $this->redirect(['index']);
                    }

                    }

//                }catch (Exception $e) {
//                    $transaction->rollback();
//                                     Yii::$app->getSession()->setFlash('success', [
//                            'type' => 'danger',
//                            'duration' => 3000,
//                            'icon' => 'fa fa-users',
//                            'message' => 'Data Gagal di Simpan',
//                            'title' => 'Error',
//                            'positonY' => 'top',
//                            'positonX' => 'center',
//                            'showProgressbar' => true,
//                        ]);
//                        return $this->redirect('create');
//                }
        } else {
            return $this->render('update', [
                        'model' => $model,
//                        'modelSpdp' => $modelSpdp,
                        'modelTersangka' => $modelTersangka,
                        'modelPasal' => $modelPasal,
                        'modelJpu' => $modelJpu,
                        'sysMenu' => $sysMenu,
                        'dataProviderTersangka' => $dataProviderTersangka
            ]);
        }
    }
        
    
    
    public function actionDelete() {
        $id             = $_POST['hapusIndex'];
        $total          = count($id);
        $session        = new Session();
        $id_perkara     = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
//        $total          = Yii::$app->db->createCommand(" select count(*) as total from pidum.pdm_p16a where no_surat_p16a='".$id."' ")->queryOne();
   ;
        $connection     = \Yii::$app->db;
        $transaction    = $connection->beginTransaction();
        try {
            if($total <= 1){ 
                PdmJaksaP16a::deleteAll(['no_surat_p16a' => $id, 'no_register_perkara'=>$no_register]);
                PdmP16a::deleteAll(['no_surat_p16a' => $id]);
                PdmStatusSurat::deleteAll(['id_perkara' => $id_perkara,'id_sys_menu'=>'P-16A']);
            }else{
                if($id == "all"){
                    PdmJaksaP16a::deleteAll(['no_surat_p16a' => $id]);
                    PdmP16a::deleteAll(['no_surat_p16a' => $id]);
                     Yii::$app->db->createCommand("UPDATE pidum.pdm_status_surat SET is_akhir='1' WHERE id_sys_menu = 'SPDP' AND id_perkara=:id")
                            ->bindValue(':id', $id_perkara)
                            ->execute();
                }else{
                   for ($i = 0; $i < count($id); $i++) {
                       PdmJaksaP16a::deleteAll(['no_surat_p16a' => $id[$i]]);
                       PdmP16a::deleteAll(['no_surat_p16a' => $id[$i]]);
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
			$transaction->commit();
		} catch(Exception $e) {
			$transaction->rollback();
		}
		return $this->redirect(['index']);
        }
        
        public function actionCetak($id){
            $session        = new Session();
            $id_perkara     = $session->get('id_perkara');
            $no_register    = $session->get('no_register_perkara');
            $connection     = \Yii::$app->db;
            $p16a           = PdmP16a::findOne(['no_surat_p16a' => $id]);
            $qry_pangkat    = "select pidum.pdm_penandatangan.jabatan 
                              from pidum.pdm_penandatangan, pidum.pdm_p16a
                              where pidum.pdm_penandatangan.peg_nip_baru = pidum.pdm_p16a.id_penandatangan and
                              pidum.pdm_p16a.no_surat_p16a = '".$id."'";
            $pangkat        = PdmP16a::findBySql($qry_pangkat)->asArray()->one();
            
            $thp_2          = PdmTahapDua::findOne(['no_register_perkara' => $p16a->no_register_perkara]);
            $brks_thp_1     = PdmBerkasTahap1::findOne(['id_berkas' => $thp_2->id_berkas]);
            $spdp           = PdmSpdp::findOne(['id_perkara' => $brks_thp_1->id_perkara]);
            $MsPenyidik     = MsPenyidik::findOne(['id_penyidik' => $spdp->id_penyidik]);
            
//            $tersangka      = VwTersangka::find()
//                              ->where('id_perkara=:id_perkara', [':id_perkara' => $brks_thp_1->id_perkara])
//                              ->all();
            
            $tersangkaqry   = "select a.nama, a.tmpt_lahir, a.tgl_lahir, b.nama as id_jkl, c.nama as warganegara, a.alamat, d.nama as id_agama, a.pekerjaan, e.nama as id_pendidikan,a.umur
                            from pidum.pdm_ba4_tersangka a
                            left join ms_jkl b ON a.id_jkl = b.id_jkl
                            left join ms_warganegara c ON a.warganegara = c.id
                            LEFT JOIN ms_agama d ON a.id_agama = d.id_agama
                            LEFT JOIN ms_pendidikan e ON a.id_pendidikan = e.id_pendidikan
                            where no_register_perkara = '".$no_register."'";
            $tersangkaqry1  = $connection->createCommand($tersangkaqry);
            $tersangka      = $tersangkaqry1->queryAll();
            
            $jaksi          = "select * from pidum.pdm_jaksa_p16a where no_surat_p16a = '" . $id . "'";
            $jaksis         = $connection->createCommand($jaksi);
            $jaksiss        = $jaksis->queryAll();
            
            $qryttd         = "SELECT a.nama,a.pangkat,a.jabatan,c.peg_nip_baru 
                               FROM pidum.pdm_penandatangan a, pidum.pdm_p16a b , kepegawaian.kp_pegawai c 
                               where a.peg_nip_baru = b.id_penandatangan and b.id_penandatangan = c.peg_nip_baru and b.no_surat_p16a='" . $p16a->no_surat_p16a . "' and b.id_penandatangan = '" . $p16a->id_penandatangan . "'";
            $model          = $connection->createCommand($qryttd);
            $penandatangan  = $model->queryOne();
            
            $query          = new Query;
            $query  ->select('*')
                    ->from('pidum.pdm_tembusan_p16a')
                    ->where("no_surat_p16a='" .$id. "'");
            $dt_tembusan    = $query->createCommand();
            $listTembusan   = $dt_tembusan->queryAll();
            
            return $this->render('cetak', ['p16a'=>$p16a,'pangkat'=>$pangkat,'spdp'=>$spdp,'MsPenyidik'=>$MsPenyidik,'tersangka'=>$tersangka,'penandatangan'=>$penandatangan,'listTembusan'=>$listTembusan,'jaksiss'=>$jaksiss]);
            
	}
    
    
//
//    /**
//     * Finds the PdmP16A model based on its primary key value.
//     * If the model is not found, a 404 HTTP exception will be thrown.
//     * @param string $id
//     * @return PdmP16A the loaded model
//     * @throws NotFoundHttpException if the model cannot be found
//     */

}
