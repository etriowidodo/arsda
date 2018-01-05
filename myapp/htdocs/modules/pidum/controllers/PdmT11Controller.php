<?php

namespace app\modules\pidum\controllers;

use Yii;
use app\modules\pidum\models\PdmT11;
use app\modules\pidum\models\PdmT11Search;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\modules\pidum\models\PdmSpdp;
use yii\web\Session;
use app\modules\pidum\models\PdmTembusan;
use app\modules\pidum\models\PdmPenandatangan;
use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\PdmSysMenu;
use app\modules\pidum\models\PdmJaksaSaksi;
use app\modules\pidum\models\PdmJaksaSaksiSearch;
use app\modules\pidum\models\PdmT8;
use app\modules\pidum\models\PdmTembusanT11;
use app\modules\pidum\models\KpPegawaiSearch;
use app\modules\pidum\models\KpPegawai;
use app\modules\pidum\models\PdmTahapDua;
use app\modules\pidum\models\PdmBerkasTahap1;
use app\modules\pidum\models\VwTerdakwaT2;


use app\modules\pidum\models\PdmJpu;
/**
 * PdmT11Controller implements the CRUD actions for PdmT11 model.
 */
class PdmT11Controller extends Controller
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
     * Lists all PdmT11 models.
     * @return mixed
     */
    public function actionIndex()
    {
        $sysMenu                = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::T11 ]);
        $session                = new Session();
        $id_perkara             = $session->get("id_perkara");
        $no_register_perkara    = $session->get("no_register_perkara");

        $searchModel            = new PdmT11Search();
        $dataProvider           = $searchModel->search($no_register_perkara, Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sysMenu' => $sysMenu
        ]);
    }

    /**
     * Displays a single PdmT11 model.
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
     * Creates a new PdmT11 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $sysMenu                = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::T11 ]);
	$session                = new Session();
        $id_perkara             = $session->get("id_perkara");
        $no_register_perkara    = $session->get("no_register_perkara");
        $kode_kejati            = $session->get('kode_kejati');
        $kode_kejari            = $session->get('kode_kejari');
        $kode_cabjari           = $session->get('kode_cabjari');
        $model                  = new PdmT11();
        $modeltsk               = VwTerdakwaT2::findAll(['no_register_perkara'=>$no_register_perkara]);
        $searchJPU              = new KpPegawaiSearch();
        $dataJPU                = $searchJPU->searchPeg($kode_kejati,Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;

        if ($model->load(Yii::$app->request->post())) {
//            $transaction = Yii::$app->db->beginTransaction();

            try {
                $text1     = $_POST['txt_nama_surat1'];
                $text2     = $_POST['txt_nama_surat2'];
                $enkot     = json_encode(array($_POST['txt_nama_surat'],$_POST['txt_nama_surat1'],$_POST['txt_nama_surat2']));
//                
//                $dekot  = json_decode($enkot);
//                echo '<pre>';print_r($enkot);
//                echo '<pre>';print_r($dekot[1]);
////                echo '<pre>';print_r($text1);
//                exit();
                
                
                $model->no_register_perkara = $no_register_perkara;
                $model->no_surat_t11        = $_POST['PdmT11']['no_surat_t11'];;
                $model->dasar               = $enkot;
                $model->peg_nip             = $_POST['PdmJaksaSaksi']['peg_nip_baru'];
                $model->id_tersangka        = $_POST['PdmT11']['id_tersangka'];
                $model->id_kejati           = $kode_kejati;
                $model->id_kejari           = $kode_kejari;
                $model->id_cabjari          = $kode_cabjari;
                $model->updated_by          = $session->get("nik_user"); 
                $model->updated_ip          = $_SERVER['REMOTE_ADDR'];
                $model->created_ip          = $_SERVER['REMOTE_ADDR'];
                $model->created_by          = $session->get("nik_user");
//                echo '<pre>';print_r($model);exit();
                if($model->save()){
                    
                    PdmTembusanT11::deleteAll(['no_surat_t11' => $model->no_surat_t11]);
                    if (isset($_POST['new_tembusan'])) {
                        for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                            $modelNewTembusan                       = new PdmTembusanT11();
                            $modelNewTembusan->no_register_perkara  = $no_register_perkara;
                            $modelNewTembusan->no_surat_t11         = $model->no_surat_t11;
                            $modelNewTembusan->tembusan             = $_POST['new_tembusan'][$i];
                            $modelNewTembusan->no_urut              = ($i+1);
                            $modelNewTembusan->save();
                        }
                    }
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
                        'duration' => 3000, //Integer //3000 default. time for growl to fade out.
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
                        'type' => 'danger',
                        'duration' => 3000,
                        'icon' => 'fa fa-users',
                        'message' => 'Data Gagal di Ubah',
                        'title' => 'Error',
                        'positonY' => 'top',
                        'positonX' => 'center',
                        'showProgressbar' => true,
                    ]);
                    return $this->redirect('create', [
                    'model'                 => $model,
                    'sysMenu'               => $sysMenu,
                    'no_register_perkara'   => $no_register_perkara,
                    'dataJPU'               => $dataJPU,
                    'searchJPU'             => $searchJPU,
                    'modeltsk'              => $modeltsk,
                    ]);
                }
            } catch (Exception $e) {
                $transaction->rollBack();

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

                return $this->redirect('create', [
                    'model'                 => $model,
                    'sysMenu'               => $sysMenu,
                    'no_register_perkara'   => $no_register_perkara,
                    'dataJPU'               => $dataJPU,
                    'searchJPU'             => $searchJPU,
                    'modeltsk'              => $modeltsk,
                    ]);
            }
        } else {
            return $this->render('create', [
                'model'                 => $model,
                'sysMenu'               => $sysMenu,
                'no_register_perkara'   => $no_register_perkara,
                'dataJPU'               => $dataJPU,
                'searchJPU'             => $searchJPU,
                'modeltsk'              => $modeltsk,
            ]);
        }
    
	}

    /**
     * Updates an existing PdmT11 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($no_surat_t11)
    {
        $sysMenu                = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::T11 ]);
        $model                  = PdmT11::findOne(['no_surat_t11'=>$no_surat_t11]);
//        echo $model->id_tersangka;exit();
        
        $session                = new Session();
        $id_perkara             = $session->get("id_perkara");
        $no_register_perkara    = $session->get("no_register_perkara");
        $kode_kejati            = $session->get('kode_kejati');
        $kode_kejari            = $session->get('kode_kejari');
        $kode_cabjari           = $session->get('kode_cabjari');
        $modeltsk               = VwTerdakwaT2::findAll(['no_register_perkara'=>$no_register_perkara]);
        $dekot                  = json_decode($model->dasar);
        $dasar1                 = $dekot[0];
        $dasar2                 = $dekot[1];
        $dasar3                 = $dekot[2];
        $modelpeg               = KpPegawai::findOne(['peg_nip_baru'=>$model->peg_nip]);
        $searchJPU              = new KpPegawaiSearch();
        $dataJPU                = $searchJPU->searchPeg($kode_kejati,Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;

        if ($model->load(Yii::$app->request->post())){ 
//            $transaction = Yii::$app->db->beginTransaction();

            try{
                $text1                  = $_POST['txt_nama_surat1'];
                $text2                  = $_POST['txt_nama_surat2'];
                $enkot                  = json_encode(array($_POST['txt_nama_surat'],$_POST['txt_nama_surat1'],$_POST['txt_nama_surat2']));
                $model->dasar           = $enkot;
                $no_surat_T11           = $model->no_surat_t11;
                $no_register_perkara    = $model->no_register_perkara;
                if($model->save()){
                    PdmTembusanT11::deleteAll(['no_surat_t11' => $model->no_surat_t11]);
                    if (isset($_POST['new_tembusan'])) {
                        for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                            $modelNewTembusan                       = new PdmTembusanT11();
                            $modelNewTembusan->no_register_perkara  = $no_register_perkara;
                            $modelNewTembusan->no_surat_t11         = $model->no_surat_t11;
                            $modelNewTembusan->tembusan             = $_POST['new_tembusan'][$i];
                            $modelNewTembusan->no_urut              = ($i+1);
                            $modelNewTembusan->save();
                        }
                    }
//                    $transaction->commit();
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
                    return $this->redirect(['index']);
                }else{
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
                    return $this->redirect('update', [
                        'model'                 => $model,
                        'sysMenu'               => $sysMenu,
                        'no_register_perkara'   => $no_register_perkara,
                        'dataJPU'               => $dataJPU,
                        'searchJPU'             => $searchJPU,
                        'dasar1'                => $dasar1,
                        'dasar2'                => $dasar2,
                        'dasar3'                => $dasar3,
                        'modelpeg'              => $modelpeg,
                        'modeltsk'              => $modeltsk,
                    ]);
                }
            }catch (Exception $e){
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
                return $this->redirect('update', [
                    'model'                 => $model,
                    'sysMenu'               => $sysMenu,
                    'no_register_perkara'   => $no_register_perkara,
                    'dataJPU'               => $dataJPU,
                    'searchJPU'             => $searchJPU,
                    'dasar1'                => $dasar1,
                    'dasar2'                => $dasar2,
                    'dasar3'                => $dasar3,
                    'modelpeg'              => $modelpeg,
                    'modeltsk'              => $modeltsk,
                ]);
            }
        } else {
            return $this->render('update', [
                'model'                 => $model,
                'sysMenu'               => $sysMenu,
                'no_register_perkara'   => $no_register_perkara,
                'dataJPU'               => $dataJPU,
                'searchJPU'             => $searchJPU,
                'dasar1'                => $dasar1,
                'dasar2'                => $dasar2,
                'dasar3'                => $dasar3,
                'modelpeg'              => $modelpeg,
                'modeltsk'              => $modeltsk,
            ]);
        }
	}
   

    /**
     * Deletes an existing PdmT11 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
        $connection             = \Yii::$app->db;
        try{
            $id                     = $_POST['hapusIndex'];
            $total                  = count($id);
            $session                = new Session();
            $id_perkara             = $session->get('id_perkara');
            $no_register_perkara    = $session->get('no_register_perkara');

            if($total == 1){
                PdmT11::deleteAll(['no_surat_t11' => $id[0]]);
            }else{
                for($i=0;$i<count($id);$i++){
                    PdmT11::deleteAll(['no_surat_t11' => $id[$i]]);
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

    public function actionCetak($no_surat_t11){
        $id             = rawurldecode($no_surat_t11);
        $T11            = PdmT11::findOne(['no_surat_t11' => $id]);
        $thp_2          = PdmTahapDua::findOne(['no_register_perkara' => $T11->no_register_perkara]);
        $brks_thp_1     = PdmBerkasTahap1::findOne(['id_berkas' => $thp_2->id_berkas]);
        $spdp           = PdmSpdp::findOne(['id_perkara' => $brks_thp_1->id_perkara]);
        $pangkat        = PdmPenandatangan::findOne(['peg_nip_baru' => $T11->id_penandatangan]);
        $modelpeg       = KpPegawai::findOne(['peg_nip_baru'=>$T11->peg_nip]);
        $listTembusan   = PdmTembusanT11::findAll(['no_surat_t11' => $T11->no_surat_t11]);
        $dekot          = json_decode($T11->dasar);
        $dasar1         = $dekot[0];
        $dasar2         = $dekot[1];
        $dasar3         = $dekot[2];
        return $this->render('cetak', ['spdp'=>$spdp,'T11'=>$T11,'pangkat'=>$pangkat,'modelpeg'=>$modelpeg,'listTembusan'=>$listTembusan,'dasar1'=>$dasar1,'dasar2'=>$dasar2,'dasar3'=>$dasar3]);
    }

        public function actionCetak1 ($id_t11) {
        $connection = \Yii::$app->db;
        $odf = new \Odf(Yii::$app->params['report-path']."modules/pidum/template/t11.odt");

        $t11 = PdmT11::findOne(['id_t11' => $id_t11]);
        $spdp = PdmSpdp::findOne(['id_perkara' => $t11->id_perkara]);
        $t8 = PdmT8::findOne(['id_t8' => $t11->id_t8]);
$pangkat = PdmPenandatangan::find()
->select ("a.jabatan as jabatan")
->from ("pidum.pdm_penandatangan a")
->join ('inner join','pidum.pdm_t11 b','a.peg_nik = b.id_penandatangan')
->where ("id_t11='".$id_t11."'")
->one();
        $odf->setVars('Kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
        $odf->setVars('no_print', $t11->no_surat);
        $odf->setVars('kepala', $pangkat->jabatan);

        $odf->setVars('kejaksaan', ucwords(strtolower(Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama)));
        $odf->setVars('tanggal', Yii::$app->globalfunc->ViewIndonesianFormat( $t8->tgl_dikeluarkan));
        $odf->setVars('nomor', $t8->no_surat);
        $odf->setVars('dasar', $t11->dasar);

        $odf->setVars('dokter', $t11->dokter);
        $odf->setVars('tempat_pemeriksaan', $t11->tempat_periksa);

        // $odf->setVars('tgl_sp', Yii::$app->globalfunc->ViewIndonesianFormat( $ba12->tgl_sp));
        // $odf->setVars('tgl_penahanan', Yii::$app->globalfunc->ViewIndonesianFormat( $ba12->tgl_penahanan));
        // $odf->setVars('no_reg_tahanan', $ba12->no_reg_tahanan);
        // $odf->setVars('no_reg_perkara', $ba12->no_reg_perkara);
        // $odf->setVars('no_sp', $ba12->no_sp);
        // $odf->setVars('kepala_rutan', '..................');
        // $odf->setVars('dari_tahanan', MsLokTahanan::findOne($tahanan->id_msloktahanan)->nama);

        // $MsTersangka=MsTersangka::findOne(['id_tersangka' => $ba12->id_tersangka]);
        // $MsAgama=MsAgama::findOne(['id_agama'=> $MsTersangka->id_agama]);
        // $MsPendidikan=MsPendidikan::findOne(['id_pendidikan'=> $MsTersangka->id_pendidikan]);
        // $MsJkl=MsJkl::findOne(['id_jkl'=> $MsTersangka->id_jkl]);
        // $MsWarganegara=MsWarganegara::findOne(['id'=> $MsTersangka->warganegara]);
        
        # tersangka
        // $sql ="SELECT tersangka.* FROM "
        //         . " pidum.pdm_ba12 ba12 LEFT OUTER JOIN pidum.vw_tersangka tersangka ON (ba12.id_perkara = tersangka.id_perkara ) "
        //         . "WHERE ba12.id_perkara='".$ba12->id_perkara."' "
        //         . "ORDER BY id_tersangka "
        //         . "LIMIT 1 ";
        // $model = $connection->createCommand($sql);
        // $tersangka = $model->queryOne();
        // if($tersangka['tgl_lahir']){
        // $umur = Yii::$app->globalfunc->datediff($tersangka['tgl_lahir'],date("Y-m-d"));
        // $tgl_lahir = $umur['years'].' tahun / '.Yii::$app->globalfunc->ViewIndonesianFormat($tersangka['tgl_lahir']);  
        // }else{
        //     $tgl_lahir = '-';
        // }
        // $odf->setVars('namaTersangka', ucfirst(strtolower($tersangka['nama'])));       
        // $odf->setVars('tmpt_lahir', ucfirst(strtolower($tersangka['tmpt_lahir'])));       
        // $odf->setVars('tgl_lahir', $tgl_lahir); 
        // $odf->setVars('jenis_kelamin', ucfirst(strtolower($tersangka['is_jkl']))); 
        // $odf->setVars('warganegara', ucfirst(strtolower($tersangka['warganegara']))); 
        // $odf->setVars('tmpt_tinggal', ucfirst(strtolower($tersangka['alamat']))); 
        // $odf->setVars('agama', ucfirst(strtolower($tersangka['is_agama']))); 
        // $odf->setVars('pekerjaan', ucfirst(strtolower($tersangka['pekerjaan']))); 
        // $odf->setVars('pendidikan', ucfirst(strtolower($tersangka['is_pendidikan']))); 
        
        #jaksa
        $queryLimitJaksa = new Query;
        $queryLimitJaksa->select('kpeg.peg_nip_baru,jpu.nama,jabatan,pangkat')
                        ->from('pidum.pdm_jaksa_saksi jpu, kepegawaian.kp_pegawai kpeg')
                        ->where(" kpeg.peg_nik = jpu.nip and jpu.id_perkara='".$t11->id_perkara."' AND jpu.id_table = '" . $t11->id_t11 . "' AND jpu.code_table='".GlobalConstMenuComponent::T11."'");
        $q_jaksa = $queryLimitJaksa->createCommand();
        $jaksa_penerima = $q_jaksa->queryOne();
        $odf->setVars('nama_jaksa', $jaksa_penerima['nama']);
        $odf->setVars('pangkat_jaksa', preg_replace("/\/ (.*)/", "", $jaksa_penerima['pangkat']));
        $odf->setVars('nip_jaksa', $jaksa_penerima['peg_nip_baru']);

        $odf->setVars('rumah_sakit', $t11->tempat_rs);
        $odf->setVars('tanggal_pemeriksaan', Yii::$app->globalfunc->ViewIndonesianFormat($t11->tgl_pemeriksaan));

        $odf->setVars('dikeluarkan', $t11->dikeluarkan);
        $odf->setVars('tgl_dikeluarkan', Yii::$app->globalfunc->ViewIndonesianFormat($t11->tgl_dikeluarkan));

        #penanda tangan
        $sql ="SELECT a.nama,a.pangkat,a.jabatan,c.peg_nip_baru FROM "
                . " pidum.pdm_penandatangan a, pidum.pdm_t11 b , kepegawaian.kp_pegawai c "
                . "where a.peg_nik = b.id_penandatangan and b.id_penandatangan =c.peg_nik and b.id_perkara='".$t11->id_perkara."'";
        $model = $connection->createCommand($sql);
		$penandatangan = $model->queryOne();
        $odf->setVars('nama_penandatangan', $penandatangan['nama']);       
        $odf->setVars('pangkat', $penandatangan['pangkat']);       
        $odf->setVars('nip_penandatangan', $penandatangan['peg_nip_baru']);

        #tembusan
        $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_tembusan')
                ->where("id_perkara='" . $t11->id_perkara . "' AND kode_table='" . GlobalConstMenuComponent::T11 . "'")
                ->orderby('no_urut');
        $dt_tembusan = $query->createCommand();
        $listTembusan = $dt_tembusan->queryAll();
        $dft_tembusan = $odf->setSegment('tembusan');
        foreach ($listTembusan as $element) {
            $dft_tembusan->urutan_tembusan($element['no_urut']);
            $dft_tembusan->nama_tembusan($element['tembusan']);
            $dft_tembusan->merge();
        }
        $odf->mergeSegment($dft_tembusan);

        $odf->exportAsAttachedFile();   
    }

    protected function findModel($id)
    {
        if (($model = PdmT11::findone($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function findModelSpdp($id)
    {
        if (($modelSpdp = PdmSpdp::findOne($id)) !== null) {
            return $modelSpdp;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
