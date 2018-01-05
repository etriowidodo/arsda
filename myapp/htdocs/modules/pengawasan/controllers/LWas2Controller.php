<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\LWas2;
use app\modules\pengawasan\models\LWas2Search;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pengawasan\models\Barbuk;
use app\modules\pengawasan\models\LWas2AK;
use app\modules\pengawasan\models\LWas2Pendapat;
use app\modules\pengawasan\models\LWas2Ptimbangan;
use app\modules\pengawasan\models\LWas2Saran;
use Nasution\Terbilang;
use yii\db\Query;
use Odf;

/**
 * LWas2Controller implements the CRUD actions for LWas2 model.
 */
class LWas2Controller extends Controller
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

    
    public function actionPopupTerlapor(){
        
        $id_register = $_POST['id_register'];
        $id_terlapor = $_POST['id_terlapor'];
        
        $nip = $_POST['nip'];
         $nama = $_POST['nama'];
         $jabatan = $_POST['jabatan'];
     
   
        $view_pemberitahuan = $this->renderAjax('_terlapor', [
            'id_register' => $id_register,
            'id_terlapor' => $id_terlapor,
            'nama' => $nama,
            'nip' => $nip,
            'jabatan' => $jabatan
        ]);
      //   header('Content-Type: application/json; charset=utf-8');
    echo  \yii\helpers\Json::encode(['view_terlapor'=>$view_pemberitahuan]);
       
    
    }
    
    /**
     * Lists all LWas2 models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LWas2Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LWas2 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new LWas2 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $session = Yii::$app->session;
        if (isset($session['was_register']) && !empty($session['was_register'])) {
           $findWas = LWas2::find()->where("id_register = :id and flag <> '3'",[":id"=>$session['was_register']])->asArray()->one();
            if(isset($findWas) && count($findWas > 0)){
                
                  return $this->redirect(['update', 'id' => $findWas['id_l_was_2']]); 
             }else{
        $model = new LWas2();
        
        if ($model->load(Yii::$app->request->post())) {
            
           $barbuk_nama =  $_POST['barbuk_nama'];
           $barbuk_jumlah = $_POST['barbuk_jumlah'];
           $barbuk_satuan = $_POST['barbuk_satuan'];
               // process uploaded image file instance
            $analisa = $_POST['analisa'];
            $kesimpulan = $_POST['kesimpulan'];
            $pendapat = $_POST['pendapat'];
            $halberat = $_POST['halberat'];
            $halringan = $_POST['halringan'];
            
            $peg_nama_saranterlapor = $_POST['peg_nama_saranterlapor'];
            $id_terlapor = $_POST['peg_id_terlapor'];
            $saran_terlapor = $_POST['saran'];
            
           $connection = \Yii::$app->db;
           $transaction = $connection->beginTransaction();
            try {

            if($model->save()){
                   $files = \yii\web\UploadedFile::getInstance($model,'upload_file');
                for($i=0;$i<count($barbuk_nama);$i++){
                    $saveBarbuk = new Barbuk();
                    $saveBarbuk->id_register = $model->id_register;
                    $saveBarbuk->nm_barbuk = $barbuk_nama[$i];
                    $saveBarbuk->jml = $barbuk_jumlah[$i];
                    $saveBarbuk->satuan = $barbuk_satuan[$i];
                    $saveBarbuk->save();
                }
                
                  for($i=0;$i<count($analisa);$i++){
                    $saveAnalisa = new LWas2AK();
                    $saveAnalisa->id_l_was_2 = $model->id_l_was_2;
                    $saveAnalisa->analisa_kesimpulan = 1;
                    $saveAnalisa->isi = $analisa[$i];
                    $saveAnalisa->save();
                }
                
                 for($i=0;$i<count($kesimpulan);$i++){
                    $saveKesimpulan= new LWas2AK();
                    $saveKesimpulan->id_l_was_2 = $model->id_l_was_2;
                    $saveKesimpulan->analisa_kesimpulan = 2;
                    $saveKesimpulan->isi = $kesimpulan[$i];
                    $saveKesimpulan->save();
                }
                
                 for($i=0;$i<count($pendapat);$i++){
                    $savePendapat= new LWas2Pendapat();
                    $savePendapat->id_l_was_2 = $model->id_l_was_2;
                    $savePendapat->pendapat = $pendapat[$i];
                    $savePendapat->save();
                }
                
                for($i=0;$i<count($halberat);$i++){
                    $saveHalBerat= new LWas2Ptimbangan();
                    $saveHalBerat->id_l_was_2 = $model->id_l_was_2;
                    $saveHalBerat->ringan_berat = 1;
                    $saveHalBerat->isi = $halberat[$i];
                    $saveHalBerat->save();
                }
                
                for($i=0;$i<count($halringan);$i++){
                    $saveHalRingan= new LWas2Ptimbangan();
                    $saveHalRingan->id_l_was_2 = $model->id_l_was_2;
                    $saveHalRingan->ringan_berat = 2;
                    $saveHalRingan->isi = $halringan[$i];
                    $saveHalRingan->save();
                }
                
                for($i=0;$i<count($peg_nama_saranterlapor);$i++){
                    $saveSaran= new LWas2Saran();
                    $saveSaran->id_l_was_2 = $model->id_l_was_2;
                    $saveSaran->id_terlapor = $id_terlapor[$i];
                    $saveSaran->tingkat_kd = $saran_terlapor[$i];
                    $saveSaran->save();
                }
                
                 if ($files != false) {
                    $path = \Yii::$app->params['uploadPath'].'l_was_2/'.$files->name;
                    $files->saveAs($path);
                }
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
            return $this->redirect(['update', 'id' => $model->id_l_was_2]);
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
               return $this->render('create', [
                'model' => $model,
                //   'modelTembusan' => $modelTembusan,
                
            ]);
            }
           
            
            } catch(Exception $e) {

                    $transaction->rollback();
            }

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
             }
         }else{
            $this->redirect(\Yii::$app->urlManager->createUrl("pengawasan/dugaan-pelanggaran/index"));
        }
    }

    /**
     * Updates an existing LWas2 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelBarbuk = Barbuk::find()->where("id_register = :id",[":id"=>$model['id_register']])->asArray()->all();
        $modelAnalisa = LWas2AK::find()->where("id_l_was_2 = :id and analisa_kesimpulan = 1 ",[":id"=>$model['id_l_was_2']])->asArray()->all();
         $modelKesimpulan = LWas2AK::find()->where("id_l_was_2 = :id and analisa_kesimpulan = 2",[":id"=>$model['id_l_was_2']])->asArray()->all();
          $modelPendapat = LWas2Pendapat::find()->where("id_l_was_2 = :id ",[":id"=>$model['id_l_was_2']])->asArray()->all();
          $modelPertimbanganBerat = LWas2Ptimbangan::find()->where("id_l_was_2 = :id and ringan_berat =1 ",[":id"=>$model['id_l_was_2']])->asArray()->all();
           $modelPertimbanganRingan = LWas2Ptimbangan::find()->where("id_l_was_2 = :id and ringan_berat =2",[":id"=>$model['id_l_was_2']])->asArray()->all();

               if ($model->load(Yii::$app->request->post())) {
            
           $barbuk_nama =  $_POST['barbuk_nama'];
           $barbuk_jumlah = $_POST['barbuk_jumlah'];
           $barbuk_satuan = $_POST['barbuk_satuan'];
               // process uploaded image file instance
            $analisa = $_POST['analisa'];
            $kesimpulan = $_POST['kesimpulan'];
            $pendapat = $_POST['pendapat'];
            $halberat = $_POST['halberat'];
            $halringan = $_POST['halringan'];
            
            $peg_nama_saranterlapor = $_POST['peg_nama_saranterlapor'];
            $id_terlapor = $_POST['peg_id_terlapor'];
            $saran_terlapor = $_POST['saran'];
            
           $connection = \Yii::$app->db;
           $transaction = $connection->beginTransaction();
            try {

            if($model->save()){
                   $files = \yii\web\UploadedFile::getInstance($model,'upload_file');
                   $deleteBarbuk =  Barbuk::deleteAll("id_register = :id",[":id"=>$model['id_register']]);
                  
                for($i=0;$i<count($barbuk_nama);$i++){
                    $saveBarbuk = new Barbuk();
                    $saveBarbuk->id_register = $model->id_register;
                    $saveBarbuk->nm_barbuk = $barbuk_nama[$i];
                    $saveBarbuk->jml = $barbuk_jumlah[$i];
                    $saveBarbuk->satuan = $barbuk_satuan[$i];
                    $saveBarbuk->save();
                }
                
                $deleteAk = LWas2AK::deleteAll("id_l_was_2 = :id ",[":id"=>$model['id_l_was_2']]);
                  for($i=0;$i<count($analisa);$i++){
                    $saveAnalisa = new LWas2AK();
                    $saveAnalisa->id_l_was_2 = $model->id_l_was_2;
                    $saveAnalisa->analisa_kesimpulan = 1;
                    $saveAnalisa->isi = $analisa[$i];
                    $saveAnalisa->save();
                }
                
                 for($i=0;$i<count($kesimpulan);$i++){
                    $saveKesimpulan= new LWas2AK();
                    $saveKesimpulan->id_l_was_2 = $model->id_l_was_2;
                    $saveKesimpulan->analisa_kesimpulan = 2;
                    $saveKesimpulan->isi = $kesimpulan[$i];
                    $saveKesimpulan->save();
                }
                $deletePendapat = LWas2Pendapat::deleteAll("id_l_was_2 = :id ",[":id"=>$model['id_l_was_2']]);
                 for($i=0;$i<count($pendapat);$i++){
                    $savePendapat= new LWas2Pendapat();
                    $savePendapat->id_l_was_2 = $model->id_l_was_2;
                    $savePendapat->pendapat = $pendapat[$i];
                    $savePendapat->save();
                }
                $deletePertimbangan = LWas2Ptimbangan::deleteAll("id_l_was_2 = :id",[":id"=>$model['id_l_was_2']]);
                for($i=0;$i<count($halberat);$i++){
                    $saveHalBerat= new LWas2Ptimbangan();
                    $saveHalBerat->id_l_was_2 = $model->id_l_was_2;
                    $saveHalBerat->ringan_berat = 1;
                    $saveHalBerat->isi = $halberat[$i];
                    $saveHalBerat->save();
                }
                
                for($i=0;$i<count($halringan);$i++){
                    $saveHalRingan= new LWas2Ptimbangan();
                    $saveHalRingan->id_l_was_2 = $model->id_l_was_2;
                    $saveHalRingan->ringan_berat = 2;
                    $saveHalRingan->isi = $halringan[$i];
                    $saveHalRingan->save();
                }
                $deleteSaran =  LWas2Saran::deleteAll("id_l_was_2 = :id",[":id"=>$model['id_l_was_2']]);
                for($i=0;$i<count($peg_nama_saranterlapor);$i++){
                    $saveSaran= new LWas2Saran();
                    $saveSaran->id_l_was_2 = $model->id_l_was_2;
                    $saveSaran->id_terlapor = $id_terlapor[$i];
                    $saveSaran->tingkat_kd = $saran_terlapor[$i];
                    $saveSaran->save();
                }
                
                if ($files != false && !empty($oldFileName)) { // delete old and overwrite
                    unlink($oldFile);
                    $path = \Yii::$app->params['uploadPath'].'l_was_2/'.$files->name;
                    $files->saveAs($path);
                }
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
            return $this->redirect(['update', 'id' => $model->id_l_was_2]);
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
               return $this->render('update', [
                'model' => $model,
                'modelBarbuk' => $modelBarbuk,
                'modelAnalisa' => $modelAnalisa,
                'modelKesimpulan' => $modelKesimpulan,
                'modelPendapat' => $modelPendapat,
                'modelPertimbanganBerat' => $modelPertimbanganBerat,
                'modelPertimbanganRingan' => $modelPertimbanganRingan,
                
            ]);
            }
           
            
            } catch(Exception $e) {

                    $transaction->rollback();
            }

        } else {
            return $this->render('update', [
                'model' => $model,
                'modelBarbuk' => $modelBarbuk,
                'modelAnalisa' => $modelAnalisa,
                'modelKesimpulan' => $modelKesimpulan,
                'modelPendapat' => $modelPendapat,
                'modelPertimbanganBerat' => $modelPertimbanganBerat,
                'modelPertimbanganRingan' => $modelPertimbanganRingan,
                
            ]);
        }
    }

    /**
     * Deletes an existing LWas2 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
       $id = $_POST['id'];
         $transaction = Yii::$app->db->beginTransaction();
        try {
        $updateData = $this->findModel($id);
        $updateData->flag = 3;
        $updateData->save();
         $transaction->commit();
      
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
        return $this->redirect('create');
          } catch(Exception $e) {
            $transaction->rollBack();

            Yii::$app->getSession()->setFlash('success', [
                'type' => 'danger', //String, can only be set to danger, success, warning, info, and growl
                'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                'icon' => 'glyphicon glyphicon-ok-sign', //String
                'message' => 'Data Gagal Dihapus', // String
                'title' => 'Delete', //String
                'positonY' => 'top', //String // defaults to top, allows top or bottom
                'positonX' => 'center', //String // defaults to right, allows right, center, left
                'showProgressbar' => true,
            ]);

            return $this->redirect('create');
        }
    }

    
     public function actionCetak(){
        
         $id_register = $_GET['id_register'];
         $id_l_was_2 = $_GET['id_l_was_2'];
         $odf = new Odf(Yii::$app->params['reportPengawasan']."lwas2.odt");
          

       
        
        $sql1 = "select b.inst_nama AS kejaksaan,b.inst_lokinst AS di,a.id_register,a.tgl
            from was.l_was_2 a
JOIN kepegawaian.kp_inst_satker b ON a.inst_satkerkd::text = b.inst_satkerkd::text
  
   where  a.id_l_was_2='".$id_l_was_2."' and a.id_register = '".$id_register."'";
        $data = LWas2::findBySql($sql1)->asArray()->one();
       // $data = $command->queryOne(); 
        
      /*         $modelAnalisa = LWas2AK::find()->where("id_l_was_2 = :id and analisa_kesimpulan = 1 ",[":id"=>$model['id_l_was_2']])->asArray()->all();
         $modelKesimpulan = LWas2AK::find()->where("id_l_was_2 = :id and analisa_kesimpulan = 2",[":id"=>$model['id_l_was_2']])->asArray()->all();
          $modelPendapat = LWas2Pendapat::find()->where("id_l_was_2 = :id ",[":id"=>$model['id_l_was_2']])->asArray()->all();
          $modelPertimbanganBerat = LWas2Ptimbangan::find()->where("id_l_was_2 = :id and ringan_berat =1 ",[":id"=>$model['id_l_was_2']])->asArray()->all();
           $modelPertimbanganRingan = LWas2Ptimbangan::find()->where("id_l_was_2 = :id and ringan_berat =2",[":id"=>$model['id_l_was_2']])->asArray()->all();
      */
        
        $sqlTerlapor = new Query;
        $sqlTerlapor->select('b.id_terlapor,a.peg_nama, a.peg_nip_baru, a.jabatan');
        $sqlTerlapor->from("was.v_riwayat_jabatan a");
        $sqlTerlapor->join("inner join", "was.terlapor b", "(a.id=b.id_h_jabatan)");
        $sqlTerlapor->where("b.id_register = :idWas",[":idWas"=>$id_register]);
        $commandTerlapor = $sqlTerlapor->createCommand();
        $dataTerlapor = $commandTerlapor->queryAll(); 
        
        $sqlAnalisa = new Query;
        $sqlAnalisa->select('a.isi');
        $sqlAnalisa->from("was.l_was_2_a_k a");
        $sqlAnalisa->where("a.id_l_was_2 = :idWas and a.analisa_kesimpulan = 1",[":idWas"=>$id_l_was_2]);
        $commandAnalisa = $sqlAnalisa->createCommand();
        $dataAnalisa = $commandAnalisa->queryAll(); 
        
        $sqlKesimpulan = new Query;
        $sqlKesimpulan->select('a.isi');
        $sqlKesimpulan->from("was.l_was_2_a_k a");
        $sqlKesimpulan->where("a.id_l_was_2 = :idWas and a.analisa_kesimpulan = 2",[":idWas"=>$id_l_was_2]);
        $commandKesimpulan = $sqlKesimpulan->createCommand();
        $dataKesimpulan = $commandKesimpulan->queryAll(); 
        
        $dataBerat = LWas2Ptimbangan::find()->where("id_l_was_2 = :id and ringan_berat =1 ",[":id"=>$id_l_was_2])->all();
        $dataRingan = LWas2Ptimbangan::find()->where("id_l_was_2 = :id and ringan_berat =2",[":id"=>$id_l_was_2])->all();
        
        $dataPemeriksa = \app\modules\pengawasan\models\VPemeriksa::find()->where("id_register = :idWas",[":idWas"=>$id_register])->all();
       
        $odf->setVars('kejaksaan', $data['kejaksaan']);
       /* $odf->setVars('kepada',  $data['kepada']);
        $odf->setVars('dari',  $data['dari']);
        $odf->setVars('tanggal',  \Yii::$app->globalfunc->ViewIndonesianFormat($data['tgl_was_21']));
        $odf->setVars('nomor',  $data['no_was_21']);
        $odf->setVars('sifat',  $data['sifat']);
        $odf->setVars('nipTerlapor', $data['nip_terlapor']);
        $odf->setVars('namaTerlapor',  $data['nama_terlapor']);
        $odf->setVars('jabatanTerlapor',  $data['jabatan_terlapor']);
        $odf->setVars('uraianPermasalahan',  $data['uraian']);
        $odf->setVars('keputusanJA',  $data['kputusan_ja']);
        
       
         $terbilang = new Terbilang();
        //  $ini = $was_16a->jml_lampiran." (".$terbilang->convert($was_16a->jml_lampiran).")";
        //  $odf->setVars('jml_lampiran', $ini);
        $odf->setVars('berkas',  $data['jml_lampiran'] .'('.(!empty($data['jml_lampiran'])?$terbilang->convert(trim($data['jml_lampiran'])):'').')');
        */
        $dft_terlapor = $odf->setSegment('terlapor');
        $i = 1;
        foreach($dataTerlapor as $dataTerlapor2){
          $dft_terlapor->i($i);
          $dft_terlapor->namaTerlapor($dataTerlapor2['peg_nama']);
          $dft_terlapor->nipTerlapor($dataTerlapor2['peg_nip_baru']);
          $dft_terlapor->jabatanTerlapor($dataTerlapor2['jabatan']);
          $dft_terlapor->merge();
            $i++;
        }
        $odf->mergeSegment($dft_terlapor);
        
       $dft_analisa = $odf->setSegment('analisa');
        $i = 1;
        foreach($dataAnalisa as $dataAnalisa2){
          $dft_analisa->isiAnalisa($i.". ".$dataAnalisa2['isi']);
          $dft_analisa->merge();
            $i++;
        }
        $odf->mergeSegment($dft_analisa);
        
         $dft_kesimpulan = $odf->setSegment('kesimpulan');
        $i = 1;
        foreach($dataKesimpulan as $dataKesimpulan2){
          $dft_kesimpulan->isiKesimpulan($i.". ".$dataKesimpulan2['isi']);
          $dft_kesimpulan->merge();
            $i++;
        }
        $odf->mergeSegment($dft_kesimpulan);
        
        $dft_halberat = $odf->setSegment('halberat');
        $i = 1;
        foreach($dataBerat as $dataBerat2){
          $dft_halberat->isiBerat($i.". ".$dataBerat2['isi']);
          $dft_halberat->merge();
          $i++;
        }
        $odf->mergeSegment($dft_halberat);
        
        $dft_halringan = $odf->setSegment('halringan');
        $i = 1;
        foreach($dataRingan as $dataRingan2){
          $dft_halringan->isiRingan($i.". ".$dataRingan2['isi']);
          $dft_halringan->merge();
          $i++;
        }
        $odf->mergeSegment($dft_halringan);
        
         $dft_pemeriksa = $odf->setSegment('pemeriksa');
          $dft_dpemeriksa = $odf->setSegment('datapemeriksa');
        $i = 1;
        foreach($dataPemeriksa as $dataPemeriksa2){
          $dft_pemeriksa->isiPemeriksa($i.". ".$dataPemeriksa2['peg_nama']);
          $dft_pemeriksa->merge();
          $dft_dpemeriksa->i($i);
          $dft_dpemeriksa->namaPemeriksa($dataPemeriksa2['peg_nama']);
          $dft_dpemeriksa->nipPemeriksa($dataPemeriksa2['peg_nip']);
          $dft_dpemeriksa->jabatanPemeriksa($dataPemeriksa2['jabatan']);
          $dft_dpemeriksa->merge();
          $i++;
        }
        $odf->mergeSegment($dft_pemeriksa);
        
      
        $odf->mergeSegment($dft_dpemeriksa);
        
        $sql2 = "select c.peg_nama,c.peg_nip,c.jabatan,e.keterangan||' - '||d.bentuk_hukuman as hukdis from was.l_was_2 a
inner join was.l_was_2_saran b on a.id_l_was_2 = b.id_l_was_2
inner join was.v_terlapor c on c.id_terlapor = b.id_terlapor and a.id_register = c.id_register
inner join was.sp_r_tingkatphd d on b.tingkat_kd = d.tingkat_kd 
inner join was.sp_r_jnsphd e on (d.phd_jns=e.phd_jns)
where d.aturan_hukum='Peraturan Pemerintah RI No. 53 Tahun 2010'  
   and  a.id_l_was_2='".$id_l_was_2."' and a.id_register = '".$id_register."'";
       
        $dataSaran = LWas2::findBySql($sql2)->asArray()->all();
         $dft_saran = $odf->setSegment('saran');
        $i = 1;
        foreach($dataSaran as $dataSaran2){
          $dft_saran->isiSaran($i." Terhadap Terlapor ".$dataSaran2['peg_nama']." , pangkat (Gol) , NIP/NRP. ".$dataSaran2['peg_nip'].", jabatan ".$dataSaran2['jabatan']." menyarankan agar dijatuhi hukuman disiplin ".$dataSaran2['hukdis']);
          $dft_saran->merge();
          $i++;
        }
        $odf->mergeSegment($dft_saran);
       
      /*  $odf->setVars('kesimpulan',  $data['kesimpulan']);
        $odf->setVars('hasilkesimpulan',  $data['hasil_kesimpulan']);
        $odf->setVars('saran',  $data['saran']);
        $odf->setVars('tanggal',  \Yii::$app->globalfunc->ViewIndonesianFormat($data['tgl_was_1']));
        $odf->setVars('tempat',  $data['inst_lokinst']);

        //terlapor
        $dft_terlapor = $odf->setSegment('terlapor');
        foreach($data2 as $dataTerlapor){
            $dft_terlapor->terlaporNama($dataTerlapor['peg_nama']);
            $dft_terlapor->terlaporNip($dataTerlapor['peg_nip']);
            $dft_terlapor->terlaporJabatan($dataTerlapor['jabatan']);
            $dft_terlapor->merge();
        }
        $odf->mergeSegment($dft_terlapor);
        //pelapor
         $dft_pelapor = $odf->setSegment('pelapor');
        foreach($data3 as $dataPelapor){
            $dft_pelapor->pelaporNama($dataPelapor['nama']);
            $dft_pelapor->pelaporAlamat($dataPelapor['alamat']);
           $dft_pelapor->merge();
        }
        $odf->mergeSegment($dft_pelapor);*/
     

       $dugaan = \app\modules\pengawasan\models\DugaanPelanggaran::findBySql("select a.id_register,a.no_register,f.peg_nip_baru||' - '||f.peg_nama||case when f.jml_terlapor > 1 then ' dkk' else '' end as terlapor from was.dugaan_pelanggaran a
inner join kepegawaian.kp_inst_satker b on (a.inst_satkerkd=b.inst_satkerkd)
inner join (
select c.id_terlapor,c.id_register,c.id_h_jabatan,e.peg_nama,e.peg_nip,e.peg_nip_baru,y.jml_terlapor from was.terlapor c
    inner join kepegawaian.kp_h_jabatan d on (c.id_h_jabatan=d.id)
    inner join kepegawaian.kp_pegawai e on (c.peg_nik=e.peg_nik)
        inner join (select z.id_register,min(z.id_terlapor)as id_terlapor,
            count(*) as jml_terlapor from was.terlapor z group by 1)y on (c.id_terlapor=y.id_terlapor)order by 1 asc)f
        on (a.id_register=f.id_register) where a.id_register = :idRegister", [":idRegister"=>$id_register])->asArray()->one();
        $odf->exportAsAttachedFile("LWAS2- ".$dugaan['terlapor'].".odt");
        Yii::$app->end();
    }
    
    /**
     * Finds the LWas2 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return LWas2 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LWas2::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
