<?php

namespace app\modules\datun\controllers;
use app\components\GlobalConstMenuComponent;
use app\modules\datun\models\PdmPasal;
use app\modules\datun\models\PdmSpdp;
use app\modules\datun\models\MsPenyidik;
use app\modules\datun\models\MsInstPelakPenyidikan;
use app\modules\datun\models\MsTersangka;
use app\modules\datun\models\MsJkl;
use app\modules\datun\models\PdmPkTingRef;
use app\modules\datun\models\PdmSpdpSearch;
use app\modules\datun\models\PdmStatusSurat;
use app\modules\datun\models\PdmTrxPemrosesan;
use app\modules\datun\models\PdmP16;
use app\modules\datun\models\VwGridPrapenuntutanSearch;
use app\models\MsWarganegara;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Jaspersoft\Client\Client;
use yii\web\Session;
use yii\helpers\ArrayHelper;
use app\components\ConstSysMenuComponent;
use app\models\Images;
use yii\web\UploadedFile;

/**
 * SpdpController implements the CRUD actions for PidumPdmSpdp model.
 */
class PerlawananController extends Controller
{
    /**
     * Lists all PidumPdmSpdp models.
     * @return mixed
     */
    public function actionIndex()
    {
        $session = new Session();

        if(($session->get('id_perkara')) !=""){
            $session->remove('id_perkara');
            $session->remove('nomor_perkara');
            $session->remove('tgl_perkara');
            $session->remove('tgl_terima');
        }

        $searchModel = new VwGridPrapenuntutanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = '15';

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PidumPdmSpdp model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $session = new Session();
        $session->destroySession('id_perkara');
        $session->set('id_perkara', $id);

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
 //<!-- BEGIN CMS_PIDUM001_13 ETRIO WIDODO -->   
    public function actionWn() {
        $searchModel = new MsWarganegara();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 7;
        return $this->renderAjax('_wn',[
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
        ]);
    }
//<!-- END CMS_PIDUM001_13 ETRIO WIDODO -->  
    /**
     * Creates a new PidumPdmSpdp model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $session = new Session();

        if(($session->get('id_perkara')) !=""){
            $session->remove('id_perkara');
            $session->remove('nomor_perkara');
            $session->remove('tgl_perkara');
            $session->remove('tgl_terima');
        }
        
        $model = new PdmSpdp();
        $modelTersangka = new MsTersangka();
        $modelPasal = new PdmPasal();
        
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try{
                                
                $NextProcces = array(ConstSysMenuComponent::P16);
                Yii::$app->globalfunc->getNextProcces($model->id_perkara,$NextProcces); 
                $model->attributes = Yii::$app->request->post('PdmSpdp');
                $modelTersangka->attributes = Yii::$app->request->post('MsTersangka');
                $modelPasal->attributes = Yii::$app->request->post('PdmPasal');
                //bowo #ubah generate PK dengan format kodesatker+no_spdp dan menambah panjang karakter menjadi 56 #27072016
                $noSpdp1 = str_replace("'","''",$model->no_surat);
                $seq = Yii::$app->db->createCommand("select public.generate_pk_perkara('pidum.pdm_spdp', 'id_perkara', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".$noSpdp1."')")->queryOne();   
                $model->id_perkara = $seq['generate_pk_perkara'];
                $model->tempat_kejadian=$_POST['tempat_kejadian'];
                
                $files = UploadedFile::getInstance($model, 'file_upload');
                if ($files != false && !empty($files) ) {
                    $model->file_upload = preg_replace('/[^A-Za-z0-9\-]/', '',$seq['generate_pk_perkara']) . '/spdp.' . $files->extension;
                }
                
                umask(0);
                mkdir(Yii::$app->basePath . '/web/template/pidum_surat/'.preg_replace('/[^A-Za-z0-9\-]/', '',$seq['generate_pk_perkara']));
                chmod(Yii::$app->basePath . '/web/template/pidum_surat/'.preg_replace('/[^A-Za-z0-9\-]/', '',$seq['generate_pk_perkara']), 0777);
                
                if ($model->save()) {
                    if ($files != false && !empty($files) ) {
                        $path = Yii::$app->basePath . '/web/template/pidum_surat/' . preg_replace('/[^A-Za-z0-9\-]/', '',$seq['generate_pk_perkara']) . '/spdp.' . $files->extension;
                        $files->saveAs($path);
                    }
                }else{
                    var_dump($model->getErrors());exit;
                }
                
                if (!empty($_POST['MsTersangkaBaru']['nama'])) { // jika MsTersangkaBaru tidak kosong, maka otomatis akan tersimpan
                    for($i=0; $i < count($_POST['MsTersangkaBaru']['nama']); $i++)
                    {
                        $modelTersangka1 = new MsTersangka();

                        /*$seqTersangka = Yii::$app->db->createCommand("select public.generate_pk('pidum.ms_tersangka', 'id_tersangka', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();*/
                        $seqTersangka = Yii::$app->db->createCommand("select public.generate_pk_tsk('pidum.ms_tersangka', 'id_tersangka', '".$model->id_perkara."')")->queryOne();
                        
                        
                        $id1 = $model->id_perkara;  
                        $jml = Yii::$app->db->createCommand(" select count(*) from pidum.ms_tersangka where id_perkara = '".$id1."' ")->queryScalar();

                        $id_tersangka = $id1."|".($jml+1);//$seqTersangka['generate_pk_tsk'];
                        $modelTersangka1->id_tersangka = $id_tersangka;
                        $modelTersangka1->id_perkara = $model->id_perkara;
                        $modelTersangka1->tmpt_lahir = $_POST['MsTersangkaBaru']['tmpt_lahir'][$i];
                        $modelTersangka1->tgl_lahir = $_POST['MsTersangkaBaru']['tgl_lahir'][$i];
                        $modelTersangka1->umur = $_POST['MsTersangkaBaru']['umur'][$i];
                        $modelTersangka1->alamat = $_POST['MsTersangkaBaru']['alamat'][$i];
                        $modelTersangka1->no_identitas = $_POST['MsTersangkaBaru']['no_identitas'][$i];
                        $modelTersangka1->no_hp = $_POST['MsTersangkaBaru']['no_hp'][$i];
                        $modelTersangka1->warganegara = $_POST['MsTersangkaBaru']['warganegara'][$i];
                        $modelTersangka1->pekerjaan = $_POST['MsTersangkaBaru']['pekerjaan'][$i];
                        $modelTersangka1->suku = $_POST['MsTersangkaBaru']['suku'][$i];
                        $modelTersangka1->nama = $_POST['MsTersangkaBaru']['nama'][$i];
                        $modelTersangka1->id_jkl = $_POST['MsTersangkaBaru']['id_jkl'][$i];
                        $modelTersangka1->id_identitas = $_POST['MsTersangkaBaru']['id_identitas'][$i];
                        $modelTersangka1->id_agama = $_POST['MsTersangkaBaru']['id_agama'][$i];
                        $modelTersangka1->id_pendidikan = $_POST['MsTersangkaBaru']['id_pendidikan'][$i];
                        $modelTersangka1->flag = $_POST['MsTersangkaBaru']['flag'][$i];
                        $modelTersangka1->tinggi = $_POST['MsTersangkaBaru']['tinggi'][$i];
                        $modelTersangka1->kulit = $_POST['MsTersangkaBaru']['kulit'][$i];
                        $modelTersangka1->muka = $_POST['MsTersangkaBaru']['muka'][$i];
                        $modelTersangka1->ciri_khusus = $_POST['MsTersangkaBaru']['ciri_khusus'][$i];                        
                        $data = $_POST['MsTersangkaBaru']['foto'][$i];
                        if(isset($data))
                            {
                                $contents_split = explode(',', $data);
                                $encoded = $contents_split[count($contents_split)-1];
                                $decoded = "";
                                for ($a=0; $a < ceil(strlen($encoded)/256); $a++) 
                                {
                                    $decoded = $decoded . base64_decode(substr($encoded,$a*256,256)); 
                                }
                                $name_foto = '../web/image/upload_file/tersangka_pidum/'.preg_replace('/[^A-Za-z0-9\-]/', '',$id_tersangka).'.jpg';
                                $fp =   fopen($name_foto, 'w');
                                        fwrite($fp, $decoded);
                                        fclose($fp);
                               $modelTersangka1->foto = preg_replace('/[^A-Za-z0-9\-]/', '',$id_tersangka).'.jpg';
                            }
                        $modelTersangka1->is_status = $_POST['MsTersangkaBaru']['is_status'][$i];       
                        if(!$modelTersangka1->save()){
                            var_dump($modelTersangka1->getErrors());exit;
                        }

                    }
                }

                // $trxPemrosesan = new PdmTrxPemrosesan();
                // $trxPemrosesan->id_perkara = $model->id_perkara;
                // $trxPemrosesan->id_sys_menu = '19';
                // $trxPemrosesan->id_user_login = Yii::$app->user->identity->username;
                // $trxPemrosesan->save();

                $transaction->commit();

                if($model->save()){
                    Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara,GlobalConstMenuComponent::SPDP); 
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
                    //return $this->redirect('index');
                    return $this->redirect(['update2', 'id' => $model->id_perkara]);
                }else{
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

            }catch (Exception $e) {
                $transaction->rollback();
            }

        } else {
            return $this->render('create', [
                'model' => $model,
                'modelTersangka' => $modelTersangka,
                'modelPasal' => $modelPasal
            ]);
        }
    }

    /**
     * Updates an existing PidumPdmSpdp model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id, $url)
    {
        //return $this->redirect([$url, 'id' => $id]);

        //Yii::$app->globalfunc->setSessionPerkara($id);
        $session = new Session();
        $session->destroySession('id_perkara');
        $session->set('id_perkara', $id);
        

        return $this->redirect('view', ['id' => $id]);
        /*$model = $this->findModel($id);
        $modelTersangka = new MsTersangka();
        $modelTersangkaUpdate = $this->findModelTersangka($id);
        $modelPasal = new PdmPasal();
        $modelPasalUpdate = $this->findModelPasal($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_perkara]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelTersangka' => $modelTersangka,
                'modelTersangkaUpdate' => $modelTersangkaUpdate,
                'modelPasal' => $modelPasal
            ]);
        }*/
    }
    
    public function actionUpdate2($id)
    {
        // if(isset($_POST['MsTersangkaBaru']['nama']))
        // {
        //  for($i=0; $i < count($_POST['MsTersangkaBaru']['nama']); $i++)
        //  {
        //     $data = $_POST['MsTersangkaBaru']['foto'][$i];

        //     $contents_split = explode(',', $data);
        //     $encoded = $contents_split[count($contents_split)-1];
        //     $decoded = "";
        //     for ($a=0; $a < ceil(strlen($encoded)/256); $a++) 
        //     {
        //         $decoded = $decoded . base64_decode(substr($encoded,$a*256,256)); 
        //     }
        //     $name_foto = '../web/image/upload_file/tersangka_pidum/imagembaixada'.$i.'.jpg';
        //     $fp = fopen($name_foto, 'w');
        //         fwrite($fp, $decoded);
        //         fclose($fp);
        //  }        
        //   exit();          
        // }
                

        $session = new Session();
        $session->destroySession('id_perkara');
        $session->set('id_perkara', $id);
        
        //return $this->redirect([$url, 'id' => $id]);
        $model = $this->findModel($id);
        $session->set('nomor_perkara', $model->no_surat);
        $session->set('tgl_perkara', date('d-m-Y', strtotime($model->tgl_surat)));
        $session->set('tgl_terima', date('d-m-Y', strtotime($model->tgl_terima)));
         //$modelTersangka = new MsTersangka();
        $modelTersangkaUpdate = MsTersangka::find()
                                        ->where('id_perkara=:id_perkara AND flag <>:flag', [':id_perkara' => str_replace("'","''",$model->id_perkara), ':flag' => '3'])
                                        ->all();
        
        $query = " SELECT status FROM pidum.vw_grid_prapenuntutan where id_perkara = '".str_replace("'","''",$model->id_perkara)."' ";      
        $status_perkara = Yii::$app->db->createCommand($query)->queryScalar();  
        
        
        $mst_perkara = PdmPkTingRef::find()
                    ->select ("pdm_mst_perkara_id")
                    ->from ("pidum.pdm_pk_ting_ref a")
                    ->join ('inner join','pidum.pdm_spdp b','a.id = b.id_pk_ting_ref')
                    ->where ("b.id_perkara='".str_replace("'","''",$model->id_perkara)."'")
                    ->one();
        $modelPasal = new PdmPasal();
        $modelPasalUpdate = $this->findModelPasal($id);
        
        
        
        
        
         if ($model->load(Yii::$app->request->post())) {
             
            $files = UploadedFile::getInstance($model, 'file_upload');
            
            $filename = Yii::$app->basePath . '/web/template/pidum_surat/' . preg_replace('/[^A-Za-z0-9\-]/', '',$model->id_perkara) . '/spdp.pdf';
            
            $q_fileupload = " SELECT file_upload FROM pidum.pdm_spdp where id_perkara = '".$model->id_perkara."' ";     
            $file_upload = Yii::$app->db->createCommand($q_fileupload)->queryScalar();  
            $model->tempat_kejadian=$_POST['tempat_kejadian'];
            if ($files == 'null' || empty($files)) { //membedakan antara tidak upload dan hapus upload
                if($file_upload != ''){
                    $model->file_upload = preg_replace('/[^A-Za-z0-9\-]/', '',$model->id_perkara) . '/spdp.' . $files->extension;
                }else{
                    $model->file_upload = '';
                }
            }else{
            
                $model->file_upload = preg_replace('/[^A-Za-z0-9\-]/', '',$model->id_perkara) . '/spdp.' . $files->extension;
            }
        
            $model->save();
            
            if ($files != false) {
            
                if (file_exists($filename)) {
                    chmod($filename,0777);
                    //chown($filename,666);
                    unlink($filename);
                    $files->saveAs($filename);
                } else {
                    $path = Yii::$app->basePath . '/web/template/pidum_surat/' . preg_replace('/[^A-Za-z0-9\-]/', '',$model->id_perkara) . '/spdp.' . $files->extension;
                    $files->saveAs($path);
                }
            }
            
                
             $modelTersangka = Yii::$app->request->post('MsTersangka');

             if (!empty($_POST['MsTersangkaBaru']['nama'])) { // jika MsTersangkaBaru tidak kosong, maka otomatis akan tersimpan
                for($i=0; $i < count($_POST['MsTersangkaBaru']['nama']); $i++){
                    $modelTersangka1 = new MsTersangka();

                   $seqTersangka = Yii::$app->db->createCommand("select public.generate_pk_tsk('pidum.ms_tersangka', 'id_tersangka', '".$model->id_perkara."')")->queryOne();
                   //bowo #11/09/2016 #ubah generate PK id_tersangka (id_perkara+no_urut)
                   $id2 = $model->id_perkara;
                   $jml = Yii::$app->db->createCommand(" select count(*) from pidum.ms_tersangka where id_perkara = '".$id2."' ")->queryScalar();
                    
                    $id_tersangka = $id2."|".($jml+1); //$seqTersangka['generate_pk_tsk'];
                    $modelTersangka1->id_tersangka = $id_tersangka;
                    $modelTersangka1->id_perkara = $model->id_perkara;
                    $modelTersangka1->tmpt_lahir = $_POST['MsTersangkaBaru']['tmpt_lahir'][$i];
                    $modelTersangka1->tgl_lahir = $_POST['MsTersangkaBaru']['tgl_lahir'][$i];
                    $modelTersangka1->umur = $_POST['MsTersangkaBaru']['umur'][$i];
                    $modelTersangka1->alamat = $_POST['MsTersangkaBaru']['alamat'][$i];
                    $modelTersangka1->no_identitas = $_POST['MsTersangkaBaru']['no_identitas'][$i];
                    $modelTersangka1->no_hp = $_POST['MsTersangkaBaru']['no_hp'][$i];
                    $modelTersangka1->warganegara = $_POST['MsTersangkaBaru']['warganegara'][$i];
                    $modelTersangka1->pekerjaan = $_POST['MsTersangkaBaru']['pekerjaan'][$i];
                    $modelTersangka1->suku = $_POST['MsTersangkaBaru']['suku'][$i];
                    $modelTersangka1->nama = $_POST['MsTersangkaBaru']['nama'][$i];
                    $modelTersangka1->id_jkl = $_POST['MsTersangkaBaru']['id_jkl'][$i];
                    $modelTersangka1->id_identitas = $_POST['MsTersangkaBaru']['id_identitas'][$i];
                    $modelTersangka1->id_agama = $_POST['MsTersangkaBaru']['id_agama'][$i];
                    $modelTersangka1->id_pendidikan = $_POST['MsTersangkaBaru']['id_pendidikan'][$i];
                    $modelTersangka1->flag = $_POST['MsTersangkaBaru']['flag'][$i];
                    $modelTersangka1->tinggi = $_POST['MsTersangkaBaru']['tinggi'][$i];
                    $modelTersangka1->kulit = $_POST['MsTersangkaBaru']['kulit'][$i];
                    $modelTersangka1->muka = $_POST['MsTersangkaBaru']['muka'][$i];
                    $modelTersangka1->ciri_khusus = $_POST['MsTersangkaBaru']['ciri_khusus'][$i];
                    //$modelTersangka1->foto = $_POST['MsTersangkaBaru']['foto'][$i];

                    $data = $_POST['MsTersangkaBaru']['foto'][$i];
                    if(isset($data))
                    {
                        $contents_split = explode(',', $data);
                        $encoded = $contents_split[count($contents_split)-1];
                        $decoded = "";
                        for ($a=0; $a < ceil(strlen($encoded)/256); $a++) 
                        {
                            $decoded = $decoded . base64_decode(substr($encoded,$a*256,256)); 
                        }   //preg_replace("/\/ (.*)/", "", $listJaksaSaksi['pangkat'])
                        $name_foto = '../web/image/upload_file/tersangka_pidum/'.str_replace("|", "", preg_replace('/[^A-Za-z0-9\-]/', '',$id_tersangka)).'.jpg';
                        $fp =   fopen($name_foto, 'w');
                                fwrite($fp, $decoded);
                                fclose($fp);
                       $modelTersangka1->foto = str_replace("|", "", preg_replace('/[^A-Za-z0-9\-]/', '',$id_tersangka)).'.jpg';
                    }
                    

                    $modelTersangka1->is_status = $_POST['MsTersangkaBaru']['is_status'][$i];
                    $modelTersangka1->save();
                }
            }

            if(isset($_POST['MsTersangkaUpdate']['nama']))
                {  

                    foreach($_POST['MsTersangkaUpdate']['nama'] as $key => $nama)
                    {
                        $modelTersangka1 = MsTersangka::findOne(['id_tersangka'=>$_POST['MsTersangkaUpdate']['id_tersangka'][$key]]);
                        $modelTersangka1->nama = $nama;
                        $modelTersangka1->id_perkara = $model->id_perkara;
                        $modelTersangka1->tmpt_lahir = $_POST['MsTersangkaUpdate']['tmpt_lahir'][$key];
                        $modelTersangka1->tgl_lahir = $_POST['MsTersangkaUpdate']['tgl_lahir'][$key];
                        $modelTersangka1->umur = $_POST['MsTersangkaUpdate']['umur'][$key];
                        $modelTersangka1->alamat = $_POST['MsTersangkaUpdate']['alamat'][$key];
                        $modelTersangka1->no_identitas = $_POST['MsTersangkaUpdate']['no_identitas'][$key];
                        $modelTersangka1->no_hp = $_POST['MsTersangkaUpdate']['no_hp'][$key];
                        $modelTersangka1->warganegara = $_POST['MsTersangkaUpdate']['warganegara'][$key];
                        $modelTersangka1->pekerjaan = $_POST['MsTersangkaUpdate']['pekerjaan'][$key];
                        $modelTersangka1->suku = $_POST['MsTersangkaUpdate']['suku'][$key];
                        $modelTersangka1->id_jkl = $_POST['MsTersangkaUpdate']['id_jkl'][$key];
                        $modelTersangka1->id_identitas = $_POST['MsTersangkaUpdate']['id_identitas'][$key];
                        $modelTersangka1->id_agama = $_POST['MsTersangkaUpdate']['id_agama'][$key];
                        $modelTersangka1->id_pendidikan = $_POST['MsTersangkaUpdate']['id_pendidikan'][$key];
                        $modelTersangka1->update();
                    }
                }
            
            if(!empty($modelTersangka['nama_update'])){
                $id_tersangka = $modelTersangka['nama_update'];
                for($a=0;$a<count($modelTersangka['nama_update']);$a++){
                    $tersangka = Yii::$app->db->createCommand("DELETE FROM pidum.ms_tersangka WHERE id_tersangka = '$id_tersangka[$a]'");
                    $tersangka->execute();
                }
            }

            return $this->redirect(['update2', 'id' => $model->id_perkara]);
         } else {
         return $this->render('update', [
         'model' => $model,
         'modelTersangka' => $modelTersangka,
         'status_perkara' => $status_perkara,
         'modelTersangkaUpdate' => $modelTersangkaUpdate,
         'mst_perkara' => $mst_perkara->pdm_mst_perkara_id,
         'modelPasal' => $modelPasal
         ]);
        }
    }
    public function actionUpdateBatch()
    {
        
        $modelTersangka1 = MsTersangka::findOne(['id_tersangka'=>'0000002016000002']);
        $modelTersangka1->nama = $ubah;
        $modelTersangka1->update();
    }
    /**
     * Deletes an existing PidumPdmSpdp model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
        $id_tersangka = $_POST['hapusIndex'];
        for($i=0;$i<count($id_tersangka);$i++){
            if($id_tersangka[$i]=='all'){
                
                $connection = \Yii::$app->db;
                $sql_cek = " delete from pidum.pdm_spdp where id_perkara in (select a.id_perkara from pidum.pdm_spdp a inner join pidum.vw_grid_prapenuntutan b on a.id_perkara = b.id_perkara
where b.status = 'SPDP') ";
                $exec_delete = $connection->createCommand($sql_cek);
                $exec_delete->execute();
            }else{
                PdmSpdp::deleteAll(['id_perkara' => $id_tersangka[$i]]);
                PdmP16::deleteAll(['id_perkara' => $id_tersangka[$i]]);
                PdmStatusSurat::deleteAll(['id_perkara' => $id_tersangka[$i]]);
                
                $filename = Yii::$app->basePath . '/web/template/pidum_surat/' . $id_tersangka[$i] . '/spdp.pdf';
                if (file_exists($filename)) {
                    chmod($filename,0777);
                    unlink($filename);
                }
            }
        }
        /*$spdp = $this->findModel($id);
        $spdp->flag = '3';
        $spdp->update();*/

        return $this->redirect(['index']);
    }
    public function actionCekNoSuratSpdp()
    {
        $noSpdp = str_replace(" ","",$_POST['no_surat']); 
        $query = PdmSpdp::find()
        ->where(['REPLACE(no_surat,\' \',\'\')' => $noSpdp])
        ->all();
        echo count($query);
    }
    public function actionShowTersangka()
    {
        if($_GET['id_tersangka'] != null){
            $modelTersangka = MsTersangka::findOne(['id_tersangka' => $_GET['id_tersangka']]);
        }else{
            $modelTersangka = new MsTersangka();
        }
        
        $identitas = ArrayHelper::map(\app\models\MsIdentitas::find()->all(), 'id_identitas', 'nama');
        $agama = ArrayHelper::map(\app\models\MsAgama::find()->all(), 'id_agama', 'nama');
        $pendidikan = ArrayHelper::map(\app\models\MsPendidikan::find()->all(), 'id_pendidikan', 'nama');
        $JenisKelamin = ArrayHelper::map(\app\models\MsJkl::find()->all(), 'id_jkl', 'nama');
        $warganegara = ArrayHelper::map(\app\models\MsWarganegara::find()->all(), 'id', 'nama');
        $warganegara_grid = new MsWarganegara();
        
        return $this->renderAjax('_popTersangka', [
            'modelTersangka'    => $modelTersangka,
            'agama'             => $agama,
            'identitas'         => $identitas,
            'JenisKelamin'      => $JenisKelamin,
            'pendidikan'        => $pendidikan,
            'warganegara'       => $warganegara,
            'warganegara_grid'  => $warganegara_grid

        ]);
    }

    public function actionUpdateTersangka($id)
    {
        $model = MsTersangka::findOne(['id_tersangka' => $id]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
          
           //echo "berhasil";
            $data   = $_POST['MsTersangka']['new_foto'];
            $id     = $_POST['MsTersangka']['id_tersangka'];
            //  if(file_exists('../web/image/upload_file/tersangka_pidum/'.$id.'.jpg'))
            //     {
            //        unlink('../web/image/upload_file/tersangka_pidum/'.$id.'.jpg');
            //        echo 'ada foto'; 
            //     }
            // else
            //     {
            //         echo 'Tidak ada foto';
            //         echo $id.'.jpg';
            //         echo file_exists($id.'.jpg');
            //     }

            if($data !='')
            { 

                $contents_split = explode(',', $data);
                $encoded = $contents_split[count($contents_split)-1];
                $decoded = "";
                for ($a=0; $a < ceil(strlen($encoded)/256); $a++) 
                {
                    $decoded = $decoded . base64_decode(substr($encoded,$a*256,256)); 
                }
                $name_foto = '../web/image/upload_file/tersangka_pidum/'.$id.'.jpg';
                $fp = fopen($name_foto, 'w');
                      fwrite($fp, $decoded);
                      fclose($fp);  
            }
            //echo $_POST['MsTersangka']['foto'];
            //print_r(Yii::$app->request->post());
        }
    }

    public function actionReport(){
        $c = new Client("http://localhost:8080/jasperserver", "jasperadmin", "jasperadmin");
        /* $js = $c->jobService();
        $js->getJob("/reports/PIDUM/hargaResorces");
        $c->setRequestTimeout(60);
        
        $coba = new \Jaspersoft\Dto\Resource\ReportUnit();
        
        $coba->label = 'coba report'; */
        
        $controls = array(
                'kd_propinsi' => ["32"],
                'kd_dati2' => ["16"],
                'thn_resource' => ["2014"] 
        );
        
        
        $report = $c->reportService()->runReport('/reports/PIDUM/hargaResource', 'odt', null, null, $controls);
        
        /* header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename=report.docx');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . strlen($report));
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document'); */
        
        header('Content-Description: File Transfer');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header("Content-Disposition: attachment; filename=coba.odt");
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . strlen($report));
        
        echo $report;
    }

    public function actionPenyidik()
    {
        $option = '';
        $kode_ip = $_POST['kode_ip'];
        $penyidik = MsInstPelakPenyidikan::find()->where(['kode_ip' => $kode_ip])->all();
        foreach ($penyidik as $value) {
            $option .= '<option value="' . $value->kode_ipp . '">' . $value->nama . '</option>';
        }
        echo $option;
    }
    
    /* CR_CMSPDM_001 */
    public function actionShowmstperkara()
    {
        $option = '';
        $id_pdmmstperkara = $_POST['id_pdmmstperkara'];
        $detail_perkara = PdmPkTingRef::find()->where(['pdm_mst_perkara_id' => $id_pdmmstperkara])->all();
        foreach ($detail_perkara as $value) {
            $option .= '<option value="' . $value->id . '">' . $value->nama . '</option>';
        }
        echo $option;
    }


    /**
     * Finds the PidumPdmSpdp model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PidumPdmSpdp the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmSpdp::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelTersangka($id)
    {
        if (($model = MsTersangka::findAll(['id_perkara' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelPasal($id)
    {
        if (($model = PdmPasal::findAll(['id_perkara' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
        public function actiontambahan(){
        $this->render('tambahan');
    }
}
