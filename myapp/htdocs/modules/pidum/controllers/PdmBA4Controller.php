<?php

namespace app\modules\pidum\controllers;

use app\modules\pidum\models\PdmT4;
use app\modules\pidum\models\PdmP25;
use app\modules\pidum\models\PdmBa4;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmBerkas;
use app\modules\pidum\models\VwTerdakwa;
use app\modules\pidum\models\PdmSysMenu;
use app\modules\pidum\models\MsTersangka;
use app\modules\pidum\models\PdmTerdakwa;
use app\modules\pidum\models\PdmBa4Search;
use app\modules\pidum\models\PdmP16ASearch;
use app\modules\pidum\models\PdmJaksaSaksi;
use app\modules\pidum\models\PdmTanyaJawab;
use app\modules\pidum\models\PdmTrxPemrosesan;
use app\modules\pidum\models\MsTersangkaSearch;
use app\modules\pidum\models\VwJaksaPenuntutSearch;
use app\modules\pidum\models\PdmTahapDua;
use app\models\MsPendidikan;
use app\models\MsJkl;
use app\models\MsAgama;
use app\models\MsWarganegara;
use yii\helpers\ArrayHelper;
use app\components\GlobalConstMenuComponent;
use Yii;
use yii\web\Controller;
use kartik\widgets\ActiveForm;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
use yii\db\Query;
use yii\data\ActiveDataProvider;

/**
 * PdmBA4Controller implements the CRUD actions for PdmBA4 model.
 */
class PdmBa4Controller extends Controller {

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
     * Lists all PdmBA4 models.
     * @return mixed
     */
    public function actionIndex() {
		$sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA4]);
        $no_register_perkara = Yii::$app->session->get('no_register_perkara');
		// echo $no_register_perkara;exit;
        $searchModel = new PdmBa4Search();
        $dataProvider = $searchModel->search($no_register_perkara, Yii::$app->request->queryParams);
        
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
					'sysMenu' => $sysMenu,
        ]);
    }

    /**
     * Displays a single PdmBA4 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmBA4 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
	{
		$sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA4]);
  //       print_r($sysMenu);
		// exit;
		$session = new Session();
        $id_perkara = $session->get("id_perkara");
        $no_register_perkara = $session->get("no_register_perkara");
        $searchJPU = new PdmP16ASearch();
        $dataProviderJPU = $searchJPU->search2($id_perkara,Yii::$app->request->queryParams);
        $dataProviderJPU->pagination->pageSize = 5;

        $searchModel = new MsTersangkaSearch();
        $id_berkas = PdmTahapDua::findOne(['no_register_perkara' => $no_register_perkara]);
          //$dataProvider = $searchModel->search2(Yii::$app->request->queryParams);
        $dataTersangka = $searchModel->searchTersangkaBerkas($id_berkas['id_berkas'],Yii::$app->request->queryParams);
        $dataTersangka->pagination->pageSize = 5;

		$warganegara = ArrayHelper::map(\app\models\MsWarganegara::find()->all(), 'id', 'nama');
        $identitas = ArrayHelper::map(\app\models\MsIdentitas::find()->all(), 'id_identitas', 'nama');
        $agama = ArrayHelper::map(\app\models\MsAgama::find()->all(), 'id_agama', 'nama');
        $pendidikan = ArrayHelper::map(\app\models\MsPendidikan::find()->all(), 'id_pendidikan', 'nama');
        $maxPendidikan = ArrayHelper::map(\app\models\MsPendidikan::find()->all(), 'id_pendidikan', 'umur');
        $JenisKelamin = ArrayHelper::map(\app\models\MsJkl::find()->all(), 'id_jkl', 'nama');
		$model = new PdmBa4();
		$rp9 = PdmTahapDua::findOne($no_register_perkara);
        //echo '<pre>';print_r($rp9);exit;
        
		
		if ($model->load(Yii::$app->request->post())) {
        //     echo '<pre>';

        // print_r($_POST);exit;
              
               $count_pdm_b4_tersangka = PdmBa4::findOne([
                                                    "no_register_perkara"   =>$no_register_perkara,
                                                    "tgl_ba4"               =>$_POST['PdmBa4']['tgl_ba4'],
                                                    "no_urut_tersangka"     =>$_POST['PdmBa4']['no_urut_tersangka']
                                            ]);

               if(count($count_pdm_b4_tersangka)>0){
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'danger',
                    'duration' => 10000,
                    'icon' => 'glyphicon glyphicon-ok-sign', //String
                    'message' => 'Tidak Bisa Menyimpan, Data Sudah Pernah Disimpan Silahkan Isi Dengan Benar Tanggal BA dan No Urut Tersangka berbeda Dengan Data Yang Sudah Pernah Disimpan',
                    'title' => 'Error',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
                  echo "<script>window.history.go(-1);</script>";
                  exit;
               }
               // echo '<pre>';
               //  print_r(count($count_pdm_b4_tersangka));exit;
            $transaction = Yii::$app->db->beginTransaction();

			try{

				$model->no_register_perkara = $no_register_perkara;
				$model->tgl_ba4             = $rp9->tgl_terima;
                $model->nama_ttd            = $_POST['PdmBa4']['nama_ttd'];

                $no_reg_tahanan = $_POST['PdmBa4']['no_reg_tahanan'];
                if($no_reg_tahanan==''){
                    $no_reg_tahanan = uniqid().'^';
                }
                $model->no_reg_tahanan      = $no_reg_tahanan;
                $model->no_urut_tersangka   = $_POST['PdmBa4']['no_urut_tersangka'];
                $model->nama                = $_POST['PdmBa4']['nama'];
                $model->tmpt_lahir          = $_POST['PdmBa4']['tmpt_lahir'];
                $model->tgl_lahir           = $_POST['PdmBa4']['tgl_lahir'];
                $model->umur                = $_POST['PdmBa4']['umur'];
                $model->suku                = $_POST['PdmBa4']['suku'];
                $model->id_identitas        = $_POST['PdmBa4']['id_identitas'];
                $model->no_identitas        = $_POST['PdmBa4']['no_identitas'];
                $model->id_jkl              = $_POST['PdmBa4']['id_jkl'];
                $model->id_agama            = $_POST['PdmBa4']['id_agama'];
                $model->alamat              = $_POST['PdmBa4']['alamat'];
                $model->no_hp               = $_POST['PdmBa4']['no_hp']; 
                $model->id_pendidikan       = $_POST['PdmBa4']['id_pendidikan']; 
                $model->pekerjaan           = $_POST['PdmBa4']['pekerjaan']; 
                $model->warganegara         = $_POST['PdmBa4']['warganegara']; 
                $model->id_penandatangan    = $_POST['PdmBa4']['id_penandatangan']; 
                $model->pangkat_ttd         = $_POST['PdmBa4']['pangkat_ttd']; 
                $model->foto                = $_POST['PdmBa4']['foto']; 
                $model->alasan              = $_POST['PdmBa4']['alasan']; 
                $model->jabatan_ttd         = $_POST['PdmBa4']['jabatan_ttd']; 
                $model->foto                = $_POST['PdmBa4']['foto']; 
                $model->created_by          = $session->get("nik_user"); 
                $model->updated_by          = $session->get("nik_user"); 
                $model->id_kejati           = $session->get("kode_kejati"); 
                $model->id_kejari           = $session->get("kode_kejari"); 
                $model->id_cabjari          = $session->get("kode_cabjari"); 
                $model->id_peneliti         = $_POST['PdmBa4']['id_penandatangan'];                 
                $model->upload_file         = $_POST['PdmBa4']['upload_file']; 
                $id_table                   = $model->no_register_perkara.$model->tgl_ba4.$model->no_urut_tersangka;
                $model->tgl_awal_penyidik   = $_POST['PdmBa4']['tgl_awal_penyidik'];
                $model->tgl_akhir_penyidik  = $_POST['PdmBa4']['tgl_akhir_penyidik']; 
                $model->tgl_awal_kejaksaan  = $_POST['PdmBa4']['tgl_awal_kejaksaan']; 
                $model->tgl_akhir_kejaksaan = $_POST['PdmBa4']['tgl_akhir_kejaksaan']; 
                $model->tgl_awal_pn         = $_POST['PdmBa4']['tgl_awal_pn']; 
                $model->tgl_akhir_pn        = $_POST['PdmBa4']['tgl_akhir_pn'];  
                $model->no_sp_penyidik      = $_POST['PdmBa4']['no_sp_penyidik'];  
                $model->no_sp_jaksa         = $_POST['PdmBa4']['no_sp_jaksa'];  
                $model->no_sp_pn            = $_POST['PdmBa4']['no_sp_pn'];  
                $model->tgl_sp_penyidik     = $_POST['PdmBa4']['tgl_sp_penyidik'];   
                $model->tgl_sp_jaksa        = $_POST['PdmBa4']['tgl_sp_jaksa'];  
                $model->tgl_sp_pn           = $_POST['PdmBa4']['tgl_sp_pn'];  
                $model->jns_penahanan_penyidik  = $_POST['PdmBa4']['jns_penahanan_penyidik'];  
                $model->jns_penahanan_jaksa     = $_POST['PdmBa4']['jns_penahanan_jaksa'];  
                $model->jns_penahanan_pn        = $_POST['PdmBa4']['jns_penahanan_pn'];  
                $model->lokasi_penyidik         = $_POST['PdmBa4']['lokasi_penyidik'];  
                $model->lokasi_jaksa            = $_POST['PdmBa4']['lokasi_jaksa'];  
                $model->lokasi_pn               = $_POST['PdmBa4']['lokasi_pn'];  
                if(!$model->save()){
                    echo $session->get("nik_user"); 
                    echo '<img src="'.$model->foto.'">';
                    echo '<pre>';
                    var_dump($model->getErrors());echo "Ba4";                  
                    print_r($_SESSION);
                    print_r($_POST);exit;
                }

             
				if($model->save()){                  
			
        			$i = 0;
                    PdmTanyaJawab::deleteAll(['kode_table' => GlobalConstMenuComponent::BA4, 'id_table' => $id_table ]);
                    if (isset($_POST['pertanyaan'])) {
                        foreach ($_POST['pertanyaan'] as $key) {
                                $modeltanya = new PdmTanyaJawab();
                                $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tanya_jawab', 'id', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                                    $modeltanya->id = $seq['generate_pk'];
                                    $modeltanya->kode_table = GlobalConstMenuComponent::BA4;
                                    $modeltanya->id_table = $id_table;
                                    $modeltanya->pertanyaan = $_POST['pertanyaan'][$i];
                                    $modeltanya->jawaban = $_POST['jawaban'][$i];
                                    $modeltanya->flag = '1';
                                    $modeltanya->save();
                                $i++;
                            }
                        }
        			
        			$transaction->commit();

                    //simpan
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
                }else{
                    $transaction->rollBack();
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
                    return $this->redirect(['index']);
                }
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
                return $this->redirect(['create']);
            }
			} else {
            return $this->render('create', [
                'model' => $model,	
                'agama'             => $agama,
                'identitas'         => $identitas,
                'JenisKelamin'      => $JenisKelamin,
                'pendidikan'        => $pendidikan,
                'warganegara'       => $warganegara,
                'maxPendidikan'     => $maxPendidikan,                
                'searchJPU'         => $searchJPU,
                'dataProviderJPU'   => $dataProviderJPU,
                'dataTersangka'     => $dataTersangka,	
                'sysMenu'           => $sysMenu,
                'rp9'               => $rp9,
            ]);
        }
			
			
    }

    /**
     * Updates an existing PdmBA4 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($no_register_perkara,$tgl_ba4,$no_urut_tersangka) {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA4]);
  //       print_r($sysMenu);
        // exit;

        $session = new Session();
        $id_perkara = $session->get("id_perkara");
        $searchJPU = new PdmP16aSearch();
        $dataProviderJPU = $searchJPU->search2($id_perkara,Yii::$app->request->queryParams);
        $dataProviderJPU->pagination->pageSize = 5;

        $searchModel = new MsTersangkaSearch();
        $id_berkas = PdmTahapDua::findOne(['no_register_perkara' => $no_register_perkara]);
          //$dataProvider = $searchModel->search2(Yii::$app->request->queryParams);
        $dataTersangka = $searchModel->searchTersangkaBerkas($id_berkas['id_berkas'],Yii::$app->request->queryParams);
        $dataTersangka->pagination->pageSize = 5;

        $warganegara = ArrayHelper::map(\app\models\MsWarganegara::find()->all(), 'id', 'nama');
        $identitas = ArrayHelper::map(\app\models\MsIdentitas::find()->all(), 'id_identitas', 'nama');
        $agama = ArrayHelper::map(\app\models\MsAgama::find()->all(), 'id_agama', 'nama');
        $pendidikan = ArrayHelper::map(\app\models\MsPendidikan::find()->all(), 'id_pendidikan', 'nama');
        $maxPendidikan = ArrayHelper::map(\app\models\MsPendidikan::find()->all(), 'id_pendidikan', 'umur');
        $JenisKelamin = ArrayHelper::map(\app\models\MsJkl::find()->all(), 'id_jkl', 'nama');
        $model  = PdmBa4::findOne([
                                        "no_register_perkara"   => $no_register_perkara,
                                        "tgl_ba4"               => $tgl_ba4,
                                        "no_urut_tersangka"     => $no_urut_tersangka
                                   ]);

        $tanyaJawab = PdmTanyaJawab::findAll([
                                            "id_table"   => $no_register_perkara.$tgl_ba4.$no_urut_tersangka
                                        ]);
        //echo '<pre>';print_r($tanyaJawab);exit;
        $tanyaJawab2 = PdmTanyaJawab::findOne(['id'=>'1133002017000087']);
        $rp9 = PdmTahapDua::findOne($no_register_perkara);
        // echo '<pre>';print_r($tanyaJawab2);exit;

        if ($model->load(Yii::$app->request->post())) {


             $count_pdm_b4_tersangka = PdmBa4::findOne([
                                                    "no_register_perkara"   =>$no_register_perkara,
                                                    "tgl_ba4"               =>$_POST['PdmBa4']['tgl_ba4'],
                                                    "no_urut_tersangka"     =>$_POST['PdmBa4']['no_urut_tersangka']
                                            ]);
             if($tgl_ba4!=$_POST['PdmBa4']['tgl_ba4']||$no_urut_tersangka!=$_POST['PdmBa4']['no_urut_tersangka'])
             {
                 Yii::$app->getSession()->setFlash('success', [
                    'type' => 'danger',
                    'duration' => 10000,
                    'icon' => 'glyphicon glyphicon-ok-sign', //String
                    'message' => 'Tidak Bisa Memperbaharui, Pengguna Agar tidak merubah Tgl Ba atau No Urut Tersangka',
                    'title' => 'Error',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
                  echo "<script>window.history.go(-1);</script>";
                  exit;
             }
        

            $transaction = Yii::$app->db->beginTransaction();
            //echo '<pre>';print_r($_POST);exit;
            try{
                $model->no_register_perkara = $no_register_perkara;
                $model->tgl_ba4             = $rp9->tgl_terima;
                $model->nama_ttd            = $_POST['PdmBa4']['nama_ttd'];
                
                $no_reg_tahanan = $_POST['PdmBa4']['no_reg_tahanan'];
                if($no_reg_tahanan==''){
                    $no_reg_tahanan = uniqid().'^';
                }
                $model->no_reg_tahanan      = $no_reg_tahanan;

                
                $model->no_urut_tersangka   = $_POST['PdmBa4']['no_urut_tersangka'];
                $model->nama                = $_POST['PdmBa4']['nama'];
                $model->tmpt_lahir          = $_POST['PdmBa4']['tmpt_lahir'];
                $model->tgl_lahir           = $_POST['PdmBa4']['tgl_lahir'];
                $model->umur                = $_POST['PdmBa4']['umur'];
                $model->suku                = $_POST['PdmBa4']['suku'];
                $model->id_identitas        = $_POST['PdmBa4']['id_identitas'];
                $model->no_identitas        = $_POST['PdmBa4']['no_identitas'];
                $model->id_jkl              = $_POST['PdmBa4']['id_jkl'];
                $model->id_agama            = $_POST['PdmBa4']['id_agama'];
                $model->alamat              = $_POST['PdmBa4']['alamat'];
                $model->no_hp               = $_POST['PdmBa4']['no_hp']; 
                $model->id_pendidikan       = $_POST['PdmBa4']['id_pendidikan']; 
                $model->pekerjaan           = $_POST['PdmBa4']['pekerjaan']; 
                $model->warganegara         = $_POST['PdmBa4']['warganegara']; 
                $model->id_penandatangan    = $_POST['PdmBa4']['id_penandatangan']; 
                $model->pangkat_ttd         = $_POST['PdmBa4']['pangkat_ttd']; 
                $model->foto                = $_POST['PdmBa4']['foto']; 
                $model->alasan              = $_POST['PdmBa4']['alasan']; 
                $model->jabatan_ttd         = $_POST['PdmBa4']['jabatan_ttd']; 
                $model->foto                = $_POST['PdmBa4']['foto']; 
                $model->created_by          = $session->get("nik_user"); 
                $model->updated_by          = $session->get("nik_user"); 
                $model->id_kejati           = $session->get("kode_kejati"); 
                $model->id_kejari           = $session->get("kode_kejari"); 
                $model->id_cabjari          = $session->get("kode_cabjari"); 
                $model->id_peneliti         = $_POST['PdmBa4']['id_penandatangan']; 
                $model->upload_file         = $_POST['PdmBa4']['upload_file']; 
                $id_table                   = $model->no_register_perkara.$model->tgl_ba4.$model->no_urut_tersangka;
                $model->tgl_awal_penyidik   = $_POST['PdmBa4']['tgl_awal_penyidik'];
                $model->tgl_akhir_penyidik   = $_POST['PdmBa4']['tgl_akhir_penyidik']; 
                $model->tgl_awal_kejaksaan   = $_POST['PdmBa4']['tgl_awal_kejaksaan']; 
                $model->tgl_akhir_kejaksaan   = $_POST['PdmBa4']['tgl_akhir_kejaksaan']; 
                $model->tgl_awal_pn   = $_POST['PdmBa4']['tgl_awal_pn']; 
                $model->tgl_akhir_pn   = $_POST['PdmBa4']['tgl_akhir_pn'];  
                $model->no_sp_penyidik      = $_POST['PdmBa4']['no_sp_penyidik'];  
                $model->no_sp_jaksa         = $_POST['PdmBa4']['no_sp_jaksa'];  
                $model->no_sp_pn            = $_POST['PdmBa4']['no_sp_pn'];  
                $model->tgl_sp_penyidik     = $_POST['PdmBa4']['tgl_sp_penyidik'];   
                $model->tgl_sp_jaksa        = $_POST['PdmBa4']['tgl_sp_jaksa'];  
                $model->tgl_sp_pn           = $_POST['PdmBa4']['tgl_sp_pn'];  
                $model->jns_penahanan_penyidik  = $_POST['PdmBa4']['jns_penahanan_penyidik'];  
                $model->jns_penahanan_jaksa     = $_POST['PdmBa4']['jns_penahanan_jaksa'];  
                $model->jns_penahanan_pn        = $_POST['PdmBa4']['jns_penahanan_pn'];  
                $model->lokasi_penyidik         = $_POST['PdmBa4']['lokasi_penyidik'];  
                $model->lokasi_jaksa            = $_POST['PdmBa4']['lokasi_jaksa'];  
                $model->lokasi_pn               = $_POST['PdmBa4']['lokasi_pn'];  

                if(!$model->save()){
                    echo $session->get("nik_user"); 
                    echo '<img src="'.$model->foto.'">';
                    echo '<pre>';
                    var_dump($model->getErrors());echo "Ba4";                  
                    print_r($_SESSION);
                    print_r($_POST);exit;
                }

                if($model->save()||$model->update()){

                    $i = 0;
                    PdmTanyaJawab::deleteAll(['kode_table' => GlobalConstMenuComponent::BA4, 'id_table' => $id_table ]);
                    if (isset($_POST['pertanyaan'])) {
                        //echo '<pre>';print_r('LLELE');exit;
                        foreach ($_POST['pertanyaan'] as $key) {
                            $modeltanya = new PdmTanyaJawab();
                            $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tanya_jawab', 'id', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                                $modeltanya->id = $seq['generate_pk'];
                                $modeltanya->kode_table = GlobalConstMenuComponent::BA4;
                                $modeltanya->id_table = $id_table;
                                $modeltanya->pertanyaan = $_POST['pertanyaan'][$i];
                                $modeltanya->jawaban = $_POST['jawaban'][$i];
                                $modeltanya->flag = '1';
                                //$modeltanya->save();
                                if(!$modeltanya->save()){
                                    var_dump($modeltanya->getErrors());exit;
                                }
                                $i++;
                            }
                        }

                    $transaction->commit();

                    //simpan
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
                        'duration' => 3000, //Integer //3000 default. time for growl to fade out.
                        'icon' => 'glyphicon glyphicon-ok-sign', //String
                        'message' => 'Data Berhasil di Ubah',
                        'title' => 'Ubah Data',
                        'positonY' => 'top', //String // defaults to top, allows top or bottom
                        'positonX' => 'center', //String // defaults to right, allows right, center, left
                        'showProgressbar' => true,
                    ]);
                    
                    return $this->redirect(['index']);
                }else{
                    $transaction->rollBack();
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'danger',
                        'duration' => 3000,
                        'icon' => 'glyphicon glyphicon-ok-sign', //String
                        'message' => 'Data Gagal di Ubah',
                        'title' => 'Error',
                        'positonY' => 'top',
                        'positonX' => 'center',
                        'showProgressbar' => true,
                    ]);
                   return $this->redirect(['update', 'no_register_perkara'=>$model->no_register_perkara,'tgl_ba4'=>$model->tgl_ba4,'no_urut_tersangka'=>$model->no_urut_tersangka]);
                }
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
                return $this->redirect(['update', 'no_register_perkara'=>$model->no_register_perkara,'tgl_ba4'=>$model->tgl_ba4,'no_urut_tersangka'=>$model->no_urut_tersangka]);
            }
            
        } else {
            return $this->render('update', [
                       'model' => $model,   
                        'agama'             => $agama,
                        'identitas'         => $identitas,
                        'JenisKelamin'      => $JenisKelamin,
                        'pendidikan'        => $pendidikan,
                        'warganegara'       => $warganegara,
                        'maxPendidikan'     => $maxPendidikan,                
                        'searchJPU'         => $searchJPU,
                        'dataProviderJPU'   => $dataProviderJPU,
                        'dataTersangka'     => $dataTersangka,  
                        'tanyaJawab'       => $tanyaJawab,
                        'rp9'               => $rp9,
                        'sysMenu' => $sysMenu,
            ]);
        }
    }
	
	public function actionJpu()
    {
    	$searchModel = new VwJaksaPenuntutSearch();
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    	$dataProvider->pagination->pageSize=10;
    	return $this->renderAjax('_m_jpu', [
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
	
	public function actionCetak($no_register_perkara,$tgl_ba4,$no_urut_tersangka) {
        $sqlnya = "Select a.*,
                            b.nama as warganegara,
                            c.nama as identitas,
                            d.nama as jkl,
                            e.nama as agama,
                            f.nama as pendidikan
                            from pidum.pdm_ba4_tersangka a 
                                left join public.ms_warganegara b on a.warganegara = b.id 
                                left join public.ms_identitas c on a.id_identitas = c.id_identitas 
                                left join public.ms_jkl d on a.id_jkl = d.id_jkl 
                                left join public.ms_agama e on a.id_agama = e.id_agama
                                left join public.ms_pendidikan f on a.id_pendidikan = f.id_pendidikan
                                        where a. no_register_perkara = '".$no_register_perkara."' 
                                            AND tgl_ba4 = '".$tgl_ba4."' 
                                            AND no_urut_tersangka = '".$no_urut_tersangka."'";
        $model  = PdmBa4::findBySql($sqlnya)->asArray()->one();

          $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_tanya_jawab')
                ->where("id_table='". $no_register_perkara.$tgl_ba4.$no_urut_tersangka."'");
        $data = $query->createCommand();
        $tanyaJawab = $data->queryAll();
        $tahapDua = PdmTahapDua::findOne($no_register_perkara);

        $session = new session();
        $id_perkara = $session->get('id_perkara');
        $spdp = $this->findModelSpdp($id_perkara);
        //echo '<pre>';print_r($spdp);exit;

        

        // $tanyaJawab = PdmTanyaJawab::find([
        //                                     "id_table"   => $no_register_perkara.$tgl_ba4.$no_urut_tersangka
         
        //                                ])->asArray()->All();
        // echo '<pre>';
        // print_r($tanyaJawab);
        // echo '<pre>';
        // print_r($model);exit;
        // $model  = PdmBa4::find([
        //                                 "no_register_perkara"   => $no_register_perkara,
        //                                 "tgl_ba4"               => $tgl_ba4,
        //                                 "no_urut_tersangka"     => $no_urut_tersangka
        //                             ])->asArray()->One();
        // echo '<pre>';
        // print_r($model);exit;
		return $this->render('cetak', ['model'=>$model,'tanyaJawab'=>$tanyaJawab, 'tahapDua'=>$tahapDua, 'spdp'=>$spdp]);
	}

        public function actionCetakDraft() {
            $session = new session();
            $id_perkara = $session->get('id_perkara');
            $spdp = $this->findModelSpdp($id_perkara);
            
            $sqlnya = "Select a.*,
                                b.nama as warganegara,
                                c.nama as identitas,
                                d.nama as jkl,
                                e.nama as agama,
                                f.nama as pendidikan
                                from pidum.pdm_ba4_tersangka a 
                                    left join public.ms_warganegara b on a.warganegara = b.id 
                                    left join public.ms_identitas c on a.id_identitas = c.id_identitas 
                                    left join public.ms_jkl d on a.id_jkl = d.id_jkl 
                                    left join public.ms_agama e on a.id_agama = e.id_agama
                                    left join public.ms_pendidikan f on a.id_pendidikan = f.id_pendidikan
                                            where a. no_register_perkara = '' 
                                                AND no_urut_tersangka = 0";
            $model  = PdmBa4::findBySql($sqlnya)->asArray()->one();

            //$query = new Query;
            $sql = "SELECT  DISTINCT pertanyaan,'' as jawaban from pidum.pdm_tanya_jawab where kode_table='BA-4'";
            $data =  \Yii::$app->db->createCommand($sql);
            $tanyaJawab = $data->queryAll();
            // /echo '<pre>';print_r($tanyaJawab);exit;
            $tahapDua = PdmTahapDua::findOne($no_register_perkara);

            return $this->render('cetak', ['model'=>$model,'tanyaJawab'=>$tanyaJawab, 'tahapDua'=>$tahapDua, 'spdp'=>$spdp]);
        }


    /**
     * Deletes an existing PdmBA4 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete() 
	{
		

        $arr= array();
        $id_tahap = $_POST['hapusIndex'][0];

            if($id_tahap=='all'){
                    $id_tahapx=PdmBa4::find()->select("no_register_perkara,tgl_ba4,no_urut_tersangka")->asArray()->all();
                    foreach ($id_tahapx as $key => $value) {
                        $arr[] = $value['no_register_perkara']."#".$value['tgl_ba4']."#".$value['no_urut_tersangka'];
                    }
                    $id_tahap=$arr;
                    // print_r($id_tahap);exit;
            }else{
                $id_tahap = $_POST['hapusIndex'];
                 // print_r($id_tahap);exit;
            }
        //echo '<pre>';print_r($id_tahap);exit;

        $count = 0;
           foreach($id_tahap AS $key_delete => $delete){
             try{
                    $split = explode("#",$delete);

                    PdmBa4::deleteAll(['no_register_perkara' => $split[0],'tgl_ba4'=>$split[1],'no_urut_tersangka'=>$split[2]]);
                    PdmTanyaJawab::deleteAll(['kode_table' => GlobalConstMenuComponent::BA4, 'id_table' => $split[0].$split[1].$split[2]]);
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

        public function actionReferTersangka() {
         $session = new Session();

        $no_register_perkara = $session->get('no_register_perkara');
        $searchModel = new MsTersangkaSearch();
        $id_berkas = PdmTahapDua::findOne(['no_register_perkara' => $no_register_perkara]);
          //$dataProvider = $searchModel->search2(Yii::$app->request->queryParams);
        $dataProvider2 = $searchModel->searchTersangkaBerkas($id_berkas['id_berkas'],Yii::$app->request->queryParams);
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

    /**
     * Finds the PdmBA4 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmBA4 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PdmBa4::findOne(['id_ba4' => $id])) !== null) {
            return $model;
//        } else {
//            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function findModelSpdp($id) {
        if (($modelSpdp = PdmSpdp::findOne($id)) !== null) {
            return $modelSpdp;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	protected function findModelTersangka($id)
    {
        if (($model = MsTersangka::findAll(['id_perkara' => $id])) !== null) {
            return $model;
        }else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
