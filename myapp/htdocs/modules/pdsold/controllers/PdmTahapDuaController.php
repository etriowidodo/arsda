<?php

namespace app\modules\pdsold\controllers;
use Yii;
use app\models\KpInstSatkerSearch;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmGridTahap2;
use app\modules\pdsold\models\PdmGridTahap2Search;
use app\modules\pdsold\models\PdmTahapDua;
use app\modules\pdsold\models\PdmMsSaksi;
use app\modules\pdsold\models\PdmTambahTahap2GridSearch;
use app\modules\pdsold\models\MsTersangkaBerkas;
use app\modules\pdsold\models\MsTersangkaSearch;
use app\modules\pdsold\models\PdmBerkasTahap1;
use yii\helpers\ArrayHelper;
use app\models\MsWarganegara;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
use yii\data\SqlDataProvider;
use app\modules\pdsold\models\MsPedomanSearch;
use app\modules\pdsold\models\MsUUndangSearch;
use app\modules\pdsold\models\MsPasalSearch;
use app\modules\pdsold\models\PdmUuPasalTahap1;
use app\modules\pdsold\models\PdmUuPasalTahap2;
use app\modules\pdsold\models\MsUUndang;
use app\modules\pdsold\models\MsPasal;
use yii\data\ActiveDataProvider;
/**
 * PdmTahapDuaController implements the CRUD actions for PdmTahapDua model.
 */
class PdmTahapDuaController extends Controller
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
     * Lists all PdmTahapDua models.
     * @return mixed
     */
    public function actionIndex()
    {   
        $session = new Session();
        //$id_perkara = $session->get('id_perkara');
        $session->remove('id_perkara');
        $session->remove('no_akta');
        $session->remove('id_berkas');
        $session->remove('perilaku_berkas');
        $session->remove('no_register_perkara');
        $session->remove('no_reg_tahanan');
        $session->remove('no_eksekusi');
        $session->remove('no_pengantar');
        
        $searchModel = new PdmGridTahap2Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
/*
        $searchModelt = new PdmTambahTahap2GridSearch();
        $dataProvidert = $searchModelt->search(Yii::$app->request->queryParams);*/

        // var_dump($dataProvider);exit();
        

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            /*'searchModelt' => $searchModelt,
            'dataProvidert' => $dataProvidert,*/
        ]);
    }

    /**
     * Displays a single PdmTahapDua model.
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
     * Creates a new PdmTahapDua model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

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
    public function actionCreate2($id,$berkas){
        $session = new Session();
        $session->destroySession('id_perkara');
        $session->set('id_perkara', $id);
        $session->set('id_berkas', $berkas);

        $model = new PdmTahapDua();

        $searchModelt = new PdmTambahTahap2GridSearch();
        $dataProvidert = $searchModelt->search(Yii::$app->request->queryParams);

       /* $modelJaksa=PdsTutSuratJaksa::find()->where('id_pds_tut_surat=\''.$model->id_pds_tut_surat.'\' order by no_urut')->all();*/
        
       	$searchUuTahap1	= new PdmUuPasalTahap1();
       	$modelUuTahap1	= PdmUuPasalTahap1::find(['id_berkas'=> $berkas])->all();
       	// /print_r($modelUuTahap1);exit;

        $searchUU = new MsUUndangSearch();
        $dataUU = $searchUU->search(Yii::$app->request->queryParams);
        $modelUuTahap1    = PdmUuPasalTahap1::find()
                          ->where(['id_pengantar' => $idPengantar])
                          ->all();

         //$modeluu = PdmUuPasalTahap2::find(['no_register_perkara'=>$id])->asArray()->all();
        //echo '<pre>';print_r($modeluu);exit;
                //if(count($modeluu)==0){
                        $sql="select b.* from pidum.pdm_pengantar_tahap1 a 
                        left join pidum.pdm_uu_pasal_tahap1 b on a.id_pengantar=b.id_pengantar
                        where a.id_berkas='$berkas'";

                        $modeluu=Yii::$app->db->createCommand($sql)->queryAll();
                //}

        //var_dump($session->get('id_berkas'));exit;

        // $id_perkara = Yii::$app->session->get('id_perkara');      

        $modelSpdp = PdmSpdp::findOne(['id_perkara' => $id]);

        if ($model->load(Yii::$app->request->post())) {
            //echo '<pre>';print_r($_POST);exit;
            $transaction = Yii::$app->db->beginTransaction();
            try {
                    
                $model->no_register_perkara = $_POST['PdmTahapDua']['no_register_perkara'];
                $model->kasus_posisi    = $_POST['PdmTahapDua']['kasus_posisi'];
                $model->tgl_pengiriman  = date('Y-m-d', strtotime($_POST['tgl_pengiriman-pdmtahapdua-tgl_pengiriman']));
                $model->tgl_terima  = date('Y-m-d', strtotime($_POST['tgl_terima-pdmtahapdua-tgl_terima']));
                $model->id_perkara = $id;
                $model->id_berkas  = $berkas;
                $model->created_time=date('Y-m-d H:i:s');
                $model->created_by=\Yii::$app->user->identity->peg_nip;
                $model->created_ip = \Yii::$app->getRequest()->getUserIP();

                $model->updated_by=\Yii::$app->user->identity->peg_nip;
                $model->updated_time=date('Y-m-d H:i:s');
                $model->updated_ip = \Yii::$app->getRequest()->getUserIP();

                $model->id_kejati = $session->get('kode_kejati');
                $model->id_kejari = $session->get('kode_kejari');
                $model->id_cabjari = $session->get('kode_cabjari');


                if ($model->save()){
                    $dakwaan_undang_undang_pengantar_baru = $_POST['MsUndang']['undang'];
                    $no = 0;

                    PdmUuPasalTahap2::deleteAll(['no_register_perkara'=>$no_register_perkara]);
                    foreach($dakwaan_undang_undang_pengantar_baru AS $_key_undang_undang => $_dakwaan_undang_undang){
                         $pdmPasal2 = new PdmUuPasalTahap2();
                         $pdmPasal2->id_pasal                =  Yii::$app->globalfunc->getSatker()->inst_satkerkd.date('Y').$id.$no++;
                         $pdmPasal2->no_register_perkara     =  $model->no_register_perkara;
                         $pdmPasal2->undang                  =  $_dakwaan_undang_undang;
                         $pdmPasal2->pasal                   =  $_POST['MsUndang']['pasal'][$_key_undang_undang];
                         $pdmPasal2->dakwaan                 =  $_POST['MsUndang']['dakwaan'][$_key_undang_undang];
                         $pdmPasal2->tentang                 =  $_POST['MsUndang']['tentang'][$_key_undang_undang];
                             if(!$pdmPasal2->save()){
                                 var_dump($pdmPasal2->getErrors());echo "Gagal Simpan Undang - Undang Saat Update Pengantar";exit;
                             }

                    }

                    
                    PdmMsSaksi::deleteAll(['no_register_perkara'=>$model->no_register_perkara]);
                    $saksi = $_POST['MssaksiBaru']['saksi'];
                     if(!empty($saksi)){

                         foreach ($saksi as $ksaksi=>$kvalue) {
                          $modelSaksi = new PdmMsSaksi();
                          //$modelSaksi->id_saksi = $ksaksi;
                          $modelSaksi->no_register_perkara = $_POST['PdmTahapDua']['no_register_perkara'];
                          $modelSaksi->jenis = 1;
                             foreach ($kvalue as $key2 => $val2) {
                                  //echo '<pre>';print_r($ksaksi.'----'.$key2.' ISI  '.$val2[0]).'LOELEOEOO';
                                  if($val2!=='' && $key2 !=='unix'){
                                      $modelSaksi->$key2 = $val2[0];
                                  }
                                  if($key2 == 'tgl_lahir'){
                                      $modelSaksi->tgl_lahir = date("Y-m-d", strtotime($val2[0]));
                                  }
                             
                             }

                             if(!$modelSaksi->save()){
                                  var_dump($modelSaksi->getErrors());exit;
                              }
                         }
                    }
                    


                    $ahli = $_POST['MssaksiBaru']['ahli'];
                    if(!empty($ahli)){
                         foreach ($ahli as $kahli=>$ahlivalue) {
                             $modelSaksi = new PdmMsSaksi();
                             //$modelSaksi->id_saksi = $ksaksi;
                             $modelSaksi->no_register_perkara = $_POST['PdmTahapDua']['no_register_perkara'];
                             $modelSaksi->jenis = 2;
                                foreach ($ahlivalue as $keyahli => $val2) {
                                     //echo '<pre>';print_r($ksaksi.'----'.$key2.' ISI  '.$val2[0]).'LOELEOEOO';
                                     if($val2!=='' && $keyahli !=='unix'){
                                         $modelSaksi->$keyahli = $val2[0];
                                     }
                                     if($keyahli == 'tgl_lahir'){
                                         $modelSaksi->tgl_lahir = date("Y-m-d", strtotime($val2[0]));
                                     }
                                
                                }
                                
                                if(!$modelSaksi->save()){
                                     var_dump($modelSaksi->getErrors());exit;
                                 }
                         }
                    }

                    

                    $modelSpdp1 = $modelSpdp;
                    $modelSpdp1->id_satker_tujuan = $_POST['id_satker_tujuan'];
                    $modelSpdp1->update();

                    $transaction->commit();

                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
                        'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                        'icon' => 'glyphicon glyphicon-ok-sign', //String
                        'message' => 'Data Berhasil Disimpan', // String
                        'title' => 'Simpan Data', //String
                        'positonY' => 'top', //String // defaults to top, allows top or bottom
                        'positonX' => 'center', //String // defaults to right, allows right, center, left
                        'showProgressbar' => true,
                    ]);

                    return $this->redirect(['index']);
                }else{
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'danger', //String, can only be set to danger, success, warning, info, and growl
                        'duration' => 3000, //Integer //3000 default. time for growl to fade out.
                        'icon' => 'glyphicon glyphicon-ok-sign', //String
                        'message' => 'Data Gagal Disimpan', // String
                        'title' => 'Simpan Data', //String
                        'positonY' => 'top', //String // defaults to top, allows top or bottom
                        'positonX' => 'center', //String // defaults to right, allows right, center, left
                        'showProgressbar' => true,
                    ]);

                    return $this->redirect(['create']);
                    // $error = \kartik\widgets\ActiveForm::validate($model);
                    // print_r($error);
                    //  echo $model->getError();
                }
            } catch(Exception $e) {
                $transaction->rollBack();

                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'danger', //String, can only be set to danger, success, warning, info, and growl
                    'duration' => 3000, //Integer //3000 default. time for growl to fade out.
                    'icon' => 'glyphicon glyphicon-ok-sign', //String
                    'message' => 'Terjadi Kesalahan', // String
                    'title' => 'Error', //String
                    'positonY' => 'top', //String // defaults to top, allows top or bottom
                    'positonX' => 'center', //String // defaults to right, allows right, center, left
                    'showProgressbar' => true,
                ]);

                return $this->redirect(['create']);
            }
        } else {
            return $this->render('create', [
                'modeluu'=> $modeluu,
                'model' => $model,
                'modelSpdp' => $modelSpdp,
                'modelPasal' => $modelPasal,
                'searchUU' => $searchUU,
                'dataUU' => $dataUU,
                'modelUuTahap1'=>$modelUuTahap1,
                'modelJaksa' => $modelJaksa,
                'searchModelt' => $searchModelt,
                'dataProvidert' => $dataProvidert,
                'modelSaksi'=>$modelSaksi,
                'modelAhli'=>$modelAhli,
            ]);
        }
    }


    public function actionCreate()
    {

	    $session = new Session();
        $session->remove('id_perkara');
        $model = new PdmTahapDua();
        


        $searchModelt = new PdmTambahTahap2GridSearch();
        $dataProvidert = $searchModelt->search(Yii::$app->request->queryParams);

       /* $modelJaksa=PdsTutSuratJaksa::find()->where('id_pds_tut_surat=\''.$model->id_pds_tut_surat.'\' order by no_urut')->all();*/
        
        $searchUU = new MsUUndangSearch();
        $dataUU = $searchUU->search(Yii::$app->request->queryParams);
        $modelUuTahap1    = PdmUuPasalTahap1::find()
                          ->where(['id_pengantar' => $idPengantar])
                          ->all();
        $modeluu = PdmUuPasalTahap2::find(['no_register_perkara'=>$id])->asArray()->all();
        
                if(count($modeluu)==0){
                        $sql="select b.* from pidum.pdm_pengantar_tahap1 a 
                        left join pidum.pdm_uu_pasal_tahap1 b on a.id_pengantar=b.id_pengantar
                        where a.id_berkas='$berkas'";

                        $modeluu=Yii::$app->db->createCommand($sql)->queryAll();
                }
        //echo '<pre>';print_r($modeluu);exit;
        //var_dump($session->get('id_berkas'));exit;

        // $id_perkara = Yii::$app->session->get('id_perkara');      

        $modelSpdp = PdmSpdp::findOne(['id_perkara' => $id_perkara]);

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tahap_dua', 'id', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();
                    
                $model->id = $seq['generate_pk'];
    			$model->id_perkara = $id_perkara;
                $model->id_berkas  = $id_berkas;

        		if ($model->save()){
                    
                    $modelSpdp1 = $modelSpdp;
                    $modelSpdp1->id_satker_tujuan = $_POST['id_satker_tujuan'];
                    $modelSpdp1->update();

                    $transaction->commit();

                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
                        'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                        'icon' => 'glyphicon glyphicon-ok-sign', //String
                        'message' => 'Data Berhasil Disimpan', // String
                        'title' => 'Simpan Data', //String
                        'positonY' => 'top', //String // defaults to top, allows top or bottom
                        'positonX' => 'center', //String // defaults to right, allows right, center, left
                        'showProgressbar' => true,
                    ]);

                    return $this->redirect(['index']);
                }else{
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'danger', //String, can only be set to danger, success, warning, info, and growl
                        'duration' => 3000, //Integer //3000 default. time for growl to fade out.
                        'icon' => 'glyphicon glyphicon-ok-sign', //String
                        'message' => 'Data Gagal Disimpan', // String
                        'title' => 'Simpan Data', //String
                        'positonY' => 'top', //String // defaults to top, allows top or bottom
                        'positonX' => 'center', //String // defaults to right, allows right, center, left
                        'showProgressbar' => true,
                    ]);

                    return $this->redirect(['create']);
                    // $error = \kartik\widgets\ActiveForm::validate($model);
                    // print_r($error);
        			//	echo $model->getError();
    			}
            } catch(Exception $e) {
                $transaction->rollBack();

                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'danger', //String, can only be set to danger, success, warning, info, and growl
                    'duration' => 3000, //Integer //3000 default. time for growl to fade out.
                    'icon' => 'glyphicon glyphicon-ok-sign', //String
                    'message' => 'Terjadi Kesalahan', // String
                    'title' => 'Error', //String
                    'positonY' => 'top', //String // defaults to top, allows top or bottom
                    'positonX' => 'center', //String // defaults to right, allows right, center, left
                    'showProgressbar' => true,
                ]);

                return $this->redirect(['create']);
            }
        } else {
            return $this->render('create', [
                'modeluu'=> '',
                'model' => $model,
                'modelSpdp' => $modelSpdp,
                'modelPasal' => '',//$modelPasal,
                'searchUU' => $searchUU,
                'dataUU' => $dataUU,
                'modelUuTahap1'=>'',//$modelUuTahap1,
                'modelJaksa' => $modelJaksa,
                'searchModelt' => $searchModelt,
                'dataProvidert' => $dataProvidert,
            ]);
        }
    }

    /**
     * Updates an existing PdmTahapDua model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id,$berkas)
    {
        $modelberkas = PdmBerkasTahap1::findOne($berkas);
        $session = new Session();
        $session->destroySession('id_perkara');
        $session->destroySession('no_register_perkara');
        $session->destroySession('no_reg_tahanan');
        $session->destroySession('no_eksekusi');
        $session->destroySession('id_berkas');
        $session->destroySession('prilaku_berkas');
        



        $searchUU = new MsUUndangSearch();
        $dataUU = $searchUU->search(Yii::$app->request->queryParams);
        $modelUuTahap1    = PdmUuPasalTahap1::find()
                          ->where(['id_pengantar' => $idPengantar])
                          ->all();

        //TAHAP DUA
        $sql="select * from pidum.pdm_uu_pasal_tahap2 a where a.no_register_perkara='$id'";
        $modeluu = Yii::$app->db->createCommand($sql)->queryAll();
        
				if(count($modeluu)==0){
						$sql="select b.* from pidum.pdm_pengantar_tahap1 a 
						left join pidum.pdm_uu_pasal_tahap1 b on a.id_pengantar=b.id_pengantar
						where a.id_berkas='$berkas'";

						$modeluu=Yii::$app->db->createCommand($sql)->queryAll();
				}
        
       	

        $model = $this->findModel($id);
        
        if(empty($model)){
            return $this->redirect(['index']);
        }

        $session->set('id_perkara', $model->id_perkara);
        $session->set('no_register_perkara', $id);

        // /echo '<pre>';print_r($model);exit;

        $searchModelt = new PdmTambahTahap2GridSearch();
        $dataProvidert = $searchModelt->search(Yii::$app->request->queryParams);

        $modelSpdp = PdmSpdp::findOne(['id_perkara' => $modelberkas->id_perkara]);

        
        $searchUU = new MsUUndangSearch();
        $dataUU = $searchUU->search(Yii::$app->request->queryParams);
        $modelUuTahap1    = PdmUuPasalTahap1::find()
                          ->where(['id_pengantar' => $idPengantar])
                          ->all();

        $modelSaksi = PdmMsSaksi::find()->where(['no_register_perkara'=>$model->no_register_perkara, 'jenis'=>1])->orderBy('no_urut')->all();
        $modelAhli = PdmMsSaksi::find()->where(['no_register_perkara'=>$model->no_register_perkara, 'jenis'=>2])->orderBy('no_urut')->all();
        //echo '<pre>';print_r($modelAhli);exit;
        if ($model->load(Yii::$app->request->post())) {

            //echo '<pre>';print_r($_POST);exit;

            $modeluu = PdmUuPasalTahap2::deleteAll(['no_register_perkara'=>$id]);
            $transaction = Yii::$app->db->beginTransaction();
            try {
            		
                $no_reg = $_POST['PdmTahapDua']['no_register_perkara'];
                $xxx = substr($no_reg,(strlen($no_reg)-1),1);
                $model->no_register_perkara     = $no_reg;
                $model->kasus_posisi    = $_POST['PdmTahapDua']['kasus_posisi'];
                //echo '<pre>';print_r($model->kasus_posisi);exit;
                $model->tgl_pengiriman  = date('Y-m-d', strtotime($_POST['tgl_pengiriman-pdmtahapdua-tgl_pengiriman']));
                $model->tgl_terima  = date('Y-m-d', strtotime($_POST['tgl_terima-pdmtahapdua-tgl_terima']));
                $model->updated_by  =\Yii::$app->user->identity->peg_nip;
                $model->updated_time=date('Y-m-d H:i:s');
                $model->updated_ip  = \Yii::$app->getRequest()->getUserIP();

                $model->id_kejati   = $session->get('kode_kejati');
                $model->id_kejari   = $session->get('kode_kejari');
                $model->id_cabjari  = $session->get('kode_cabjari');

                //echo '<pre>';print_r($model->no_register_perkara);exit;
                if ($model->update() || $model->save()){

                  //TRIGGER P16A
                  if($xxx!=='^'){
                    $p16 = "INSERT into   pidum.pdm_trx_pemrosesan (id_perkara ,id_sys_menu,id_user_login,no_register_perkara)
                            values('$model->id_perkara',20,'tahap-dua','$no_reg')";
                    //echo '<pre>';print_r('LOL');exit;
                    Yii::$app->db->createCommand($p16)->execute();
                  }

                //Insert Undang-Undang Yang baru jika pengantar di update;
                   $dakwaan_undang_undang_pengantar_baru = $_POST['MsUndang']['undang'];
                   $no = 0;
                   PdmUuPasalTahap2::deleteAll(['no_register_perkara'=>$no_register_perkara]);
                   foreach($dakwaan_undang_undang_pengantar_baru AS $_key_undang_undang => $_dakwaan_undang_undang)
                   {
                    
                        $pdmPasal2 = new PdmUuPasalTahap2();
                        $pdmPasal2->id_pasal                =  Yii::$app->globalfunc->getSatker()->inst_satkerkd.date('Y').$id.$no++;
                        $pdmPasal2->no_register_perkara     =  $model->no_register_perkara;
                        $pdmPasal2->undang                  =  $_dakwaan_undang_undang;
                        $pdmPasal2->pasal                   =  $_POST['MsUndang']['pasal'][$_key_undang_undang];
                        $pdmPasal2->dakwaan                 =  $_POST['MsUndang']['dakwaan'][$_key_undang_undang];
                        $pdmPasal2->tentang                 =  $_POST['MsUndang']['tentang'][$_key_undang_undang];

                            if(!$pdmPasal2->save()){
                                var_dump($pdmPasal2->getErrors());echo "Gagal Simpan Undang - Undang Saat Update Pengantar";exit;
                            }

                   }
                //End Insert Undang-Undang yang baru jika pengantar di update;

                   PdmMsSaksi::deleteAll(['no_register_perkara'=>$model->no_register_perkara]);
                   $saksi = $_POST['MssaksiBaru']['saksi'];
                    if(!empty($saksi)){

                        foreach ($saksi as $ksaksi=>$kvalue) {
                         $modelSaksi = new PdmMsSaksi();
                         //$modelSaksi->id_saksi = $ksaksi;
                         $modelSaksi->no_register_perkara = $_POST['PdmTahapDua']['no_register_perkara'];
                         $modelSaksi->jenis = 1;
                            foreach ($kvalue as $key2 => $val2) {
                                 //echo '<pre>';print_r($ksaksi.'----'.$key2.' ISI  '.$val2[0]).'LOELEOEOO';
                                 if($val2!=='' && $key2 !=='unix'){
                                     $modelSaksi->$key2 = $val2[0];
                                 }
                                 if($key2 == 'tgl_lahir'){
                                     $modelSaksi->tgl_lahir = date("Y-m-d", strtotime($val2[0]));
                                 }
                            
                            }

                            if(!$modelSaksi->save()){
                                 var_dump($modelSaksi->getErrors());exit;
                             }
                        }
                   }
                   


                   $ahli = $_POST['MssaksiBaru']['ahli'];
                   if(!empty($ahli)){
                        foreach ($ahli as $kahli=>$ahlivalue) {
                            $modelSaksi = new PdmMsSaksi();
                            //$modelSaksi->id_saksi = $ksaksi;
                            $modelSaksi->no_register_perkara = $_POST['PdmTahapDua']['no_register_perkara'];
                            $modelSaksi->jenis = 2;
                               foreach ($ahlivalue as $keyahli => $val2) {
                                    //echo '<pre>';print_r($ksaksi.'----'.$key2.' ISI  '.$val2[0]).'LOELEOEOO';
                                    if($val2!=='' && $keyahli !=='unix'){
                                        $modelSaksi->$keyahli = $val2[0];
                                    }
                                    if($keyahli == 'tgl_lahir'){
                                        $modelSaksi->tgl_lahir = date("Y-m-d", strtotime($val2[0]));
                                    }
                               
                               }
                               
                               if(!$modelSaksi->save()){
                                    var_dump($modelSaksi->getErrors());exit;
                                }
                        }
                   }
                    

                    $modelSpdp1 = $modelSpdp;
                    //$modelSpdp1->id_satker_tujuan = $_POST['id_satker_tujuan'];
                    $modelSpdp1->update();

                    $transaction->commit();

                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
                        'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                        'icon' => 'glyphicon glyphicon-ok-sign', //String
                        'message' => 'Data Berhasil Diubah', // String
                        'title' => 'Ubah Data', //String
                        'positonY' => 'top', //String // defaults to top, allows top or bottom
                        'positonX' => 'center', //String // defaults to right, allows right, center, left
                        'showProgressbar' => true,
                    ]);

                    return $this->redirect(['index']);
                }else{
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'danger', //String, can only be set to danger, success, warning, info, and growl
                        'duration' => 3000, //Integer //3000 default. time for growl to fade out.
                        'icon' => 'glyphicon glyphicon-ok-sign', //String
                        'message' => 'Data Gagal Diubah', // String
                        'title' => 'Ubah Data', //String
                        'positonY' => 'top', //String // defaults to top, allows top or bottom
                        'positonX' => 'center', //String // defaults to right, allows right, center, left
                        'showProgressbar' => true,
                    ]);

                    //return $this->redirect(['update', 'id' => $model->$id]);
                    return $this->redirect(['index']);
                }
            } catch(Exception $e) {
                $transaction->rollBack();

                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'danger', //String, can only be set to danger, success, warning, info, and growl
                    'duration' => 3000, //Integer //3000 default. time for growl to fade out.
                    'icon' => 'glyphicon glyphicon-ok-sign', //String
                    'message' => 'Terjadi Kesalahan', // String
                    'title' => 'Error', //String
                    'positonY' => 'top', //String // defaults to top, allows top or bottom
                    'positonX' => 'center', //String // defaults to right, allows right, center, left
                    'showProgressbar' => true,
                ]);

                //return $this->redirect(['update', 'id' => $model->id]);
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('update', [
            	'modeluu'=> $modeluu,
                'model' => $model,
                'modelSpdp' => $modelSpdp,
                'modelPasal' => $modelPasal,
                'searchUU' => $searchUU,
                'dataUU' => $dataUU,
                //'modelUuTahap1'=>$modelUuTahap1,
                'searchModelt' => $searchModelt,
                'dataProvidert'=>$dataProvidert,
                'modelSaksi'=>$modelSaksi,
                'modelAhli'=>$modelAhli,
                
            ]);
        }
    }

    /**
     * Deletes an existing PdmTahapDua model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
 
        $arr= array();
        $id_tahap = $_POST['hapusIndex'][0];
        if(!empty($id_tahap)){
              if($id_tahap=='all'){
                  $id_tahapx=PdmTahapDua::find()->select("no_register_perkara")->asArray()->all();
                  foreach ($id_tahapx as $key => $value) {
                    $arr[] = $value['no_register_perkara'];
                  }
                  $id_tahap=$arr;
              }else{
                     $id_tahap = $_POST['hapusIndex'];
                 }


             $count = 0;
                foreach($id_tahap AS $key_delete => $delete){
                  try{
                         PdmTahapDua::deleteAll(['no_register_perkara' => $delete]);
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
        }
     		return $this->redirect(['index']);

    }

    public function actionSatker($kd)
    {
        $searchModel = new KpInstSatkerSearch();
        $dataProvider = $searchModel->searchKodeSatker($kd, Yii::$app->request->queryParams);
        return $this->renderAjax('_m_satker', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
        ]);
    }

    public function actionWn() {
        $searchModel = new MsWarganegara();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;
        return $this->renderAjax('_wn',[
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
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
       /*if(isset($_GET['jenis_perkara'])){
           $query = MsPasal::find()
           ->where("id = :id and kode_pidana=:kode_pidana and jenis_perkara=:jenis_perkara",[':id'=>$uu,':kode_pidana'=>$kode_pidana,':jenis_perkara'=>$jenis_perkara]);
       }else{
           $query = MsPasal::find()
           ->where("id = :id and kode_pidana=:kode_pidana",[':id'=>$uu,':kode_pidana'=>$kode_pidana]);
       }*/

       if(isset($_GET['jenis_perkara'])){
           $query = MsPasal::find()
           ->where("kode_pidana=:kode_pidana and jenis_perkara=:jenis_perkara",[':kode_pidana'=>$kode_pidana,':jenis_perkara'=>$jenis_perkara]);
       }else{
           $query = MsPasal::find()
           ->where("kode_pidana=:kode_pidana",[':kode_pidana'=>$kode_pidana]);
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
    public function actionReferTersangka() {
        $searchModel = new MsTersangkaSearch();
        $session = new Session();
        $id_perkara = $session->get('id_perkara');
  //$dataProvider = $searchModel->search2(Yii::$app->request->queryParams);
        $dataProvider2 = $searchModel->searchTersangkaUnion('');
//var_dump ($dataProvider2);exit;
//echo $dataProvider['id_tersangka'];exit;
//$dataProvider->pagination->pageSize = 5;
        $dataProvider2->pagination->pageSize = 5;
        return $this->renderAjax('_tersangka', [
                    'searchModel'   => $searchModel,
                    'dataProvider'  => $dataProvider,
                    'dataProvider2' => $dataProvider2,
        ]);
    }
    public function actionShowTersangka(){
    $idTersangka=$_GET['id_tersangka'];
        if($idTersangka !=""){
            $modelTersangka = MsTersangkaBerkas::findOne(['id_tersangka' => $_GET['id_tersangka']]);
        }else{
            $modelTersangka = new MsTersangkaBerkas();
            $id_tersangka = '';
        }

        $identitas = ArrayHelper::map(\app\models\MsIdentitas::find()->all(), 'id_identitas', 'nama');
        $agama = ArrayHelper::map(\app\models\MsAgama::find()->all(), 'id_agama', 'nama');
        $pendidikan = ArrayHelper::map(\app\models\MsPendidikan::find()->all(), 'id_pendidikan', 'nama');
        $maxPendidikan = ArrayHelper::map(\app\models\MsPendidikan::find()->all(), 'id_pendidikan', 'umur');
        $JenisKelamin = ArrayHelper::map(\app\models\MsJkl::find()->all(), 'id_jkl', 'nama');
        $warganegara = ArrayHelper::map(\app\models\MsWarganegara::find()->all(), 'id', 'nama');
        $warganegara_grid = new MsWarganegara();
         //echo '<pre>';print_r($modelTersangka);exit;

        return $this->renderAjax('_popTersangka', [
            'modelTersangka'    => $modelTersangka,
            'agama'             => $agama,
            'identitas'         => $identitas,
            'JenisKelamin'      => $JenisKelamin,
            'pendidikan'        => $pendidikan,
            'warganegara'       => $warganegara,
            'warganegara_grid'  => $warganegara_grid,
            'maxPendidikan'     => $maxPendidikan

        ]);
    }

    public function actionShowSaksi(){
     $idsaksi=$_GET['id_saksi'];
        if($idsaksi !=""){
            $modelsaksi = PdmMsSaksi::findOne(['id_saksi' => $_GET['id_saksi']]);
        }else{
            $modelsaksi = new PdmMsSaksi();
            $id_saksi = '';
        }

        $identitas = ArrayHelper::map(\app\models\MsIdentitas::find()->all(), 'id_identitas', 'nama');
        $agama = ArrayHelper::map(\app\models\MsAgama::find()->all(), 'id_agama', 'nama');
        $pendidikan = ArrayHelper::map(\app\models\MsPendidikan::find()->all(), 'id_pendidikan', 'nama');
        $maxPendidikan = ArrayHelper::map(\app\models\MsPendidikan::find()->all(), 'id_pendidikan', 'umur');
        $JenisKelamin = ArrayHelper::map(\app\models\MsJkl::find()->all(), 'id_jkl', 'nama');
        $warganegara = ArrayHelper::map(\app\models\MsWarganegara::find()->all(), 'id', 'nama');
        $warganegara_grid = new MsWarganegara();

        return $this->renderAjax('_popsaksi', [
            'modelsaksi'    => $modelsaksi,
            'agama'             => $agama,
            'identitas'         => $identitas,
            'JenisKelamin'      => $JenisKelamin,
            'pendidikan'        => $pendidikan,
            'warganegara'       => $warganegara,
            'warganegara_grid'  => $warganegara_grid,
            'maxPendidikan'     => $maxPendidikan

        ]);
    }
    /**
     * Finds the PdmTahapDua model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmTahapDua the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmTahapDua::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
