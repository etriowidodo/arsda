<?php

namespace app\modules\pidum\controllers;

use Yii;
use app\modules\pidum\models\PdmP42;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmP42Search;
use app\modules\pidum\models\PdmPenandatangan;
use app\modules\pidum\models\VwTerdakwaT2;
use app\modules\pidum\models\PdmMsStatusData;
use app\modules\pidum\models\PdmPenetapanHakim;
use app\modules\pidum\models\PdmP41Terdakwa;
use app\modules\pidum\models\PdmBa5Barbuk;
use app\modules\pidum\models\PdmBarbuk;
use app\modules\pidum\models\PdmJaksaP16a;
use app\modules\pidum\models\PdmP16a;
use app\modules\pidum\models\PdmBerkasTahap1;
use app\modules\pidum\models\PdmTahapDua;
use app\modules\pidum\models\PdmP30;
use app\modules\pidum\models\PdmP29;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
use yii\db\Query;
use app\components\GlobalConstMenuComponent; 

use app\modules\pidum\models\PdmTetapHakim;
use app\modules\pidum\models\PdmSysMenu;

/**
 * PdmP42Controller implements the CRUD actions for PdmP42 model.
 */
class PdmP42Controller extends Controller
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
     * Lists all PdmP42 models.
     * @return mixed
     */
    public function actionIndex()
    {
//        $sysMenu        = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P42]);
//        $session        = new Session();
//        $id_perkara     = $session->get('id_perkara');
//        $no_register    = $session->get('no_register_perkara');
//        $kode_kejati    = $session->get('kode_kejati');
//        $kode_kejari    = $session->get('kode_kejari');
//        $kode_cabjari   = $session->get('kode_cabjari');
//        $modeltsk       = VwTerdakwaT2::findAll(['no_register_perkara'=>$no_register]);
////        echo $no_register;exit();
////        print_r($modeltsk);exit();
//        
//        $searchModel    = new PdmP42Search();   
//        $dataProvider   = $searchModel->search($no_register, Yii::$app->request->queryParams);
//
//        return $this->render('index', [
//            'sysMenu'       => $sysMenu,
//            'searchModel'   => $searchModel,
//            'dataProvider'  => $dataProvider,
//            'no_register'   => $no_register
//        ]);
        
        return $this->redirect('update');
        
    }

    /**
     * Displays a single PdmP42 model.
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
     * Creates a new PdmP42 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {   
        $sysMenu        = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P42 ]);
        $session        = new Session();
        $id_perkara     = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $model          = new PdmP42();
        $modeltsk       = VwTerdakwaT2::findAll(['no_register_perkara'=>$no_register]);
        $modelhkm       = PdmPenetapanHakim::findAll(['no_register_perkara'=>$no_register, 'tentang'=> 1, 'penetapan'=> 'PN']);
//        echo $modelhkm[0]['no_penetapan_hakim'];exit();
        $modelbb        = PdmBarbuk::findAll(['no_register_perkara'=>$no_register]);
        $qry_p16a       = "select * from pidum.pdm_p16a where no_register_perkara = '".$no_register."' order by tgl_dikeluarkan desc limit 1 ";
        $p16a           = PdmP16a::findBySql($qry_p16a)->asArray()->one();
        $jaksap16a      = PdmJaksaP16a::findAll(['no_surat_p16a'=>$p16a[no_surat_p16a]]);

        if ($model->load(Yii::$app->request->post())) {
            try {
                $ketSaksi                   = json_encode($_POST['txt_nama_surat2']);
                $ketAhli                    = json_encode($_POST['txt_nama_surat3']);
                $ketSurat                   = json_encode($_POST['txt_nama_surat4']);
                $ketPetunjuk                = json_encode($_POST['txt_nama_surat5']);
                $ketTerdakwa                = json_encode($_POST['txt_nama_surat6']);
                $ketBarbuk                  = json_encode($_POST['txt_nama_surat7']);
                $unsurPasal                 = json_encode($_POST['txt_nama_surat8']);
                $Memberatkan                = json_encode($_POST['txt_nama_surat9']);
                $Meringankan                = json_encode($_POST['txt_nama_surat10']);
                
                $model->ket_saksi           = $ketSaksi;
                $model->ket_ahli            = $ketAhli;
                $model->ket_surat           = $ketSurat;
                $model->petunjuk            = $ketPetunjuk;
                $model->ket_tersangka       = $ketTerdakwa;
                $model->barbuk              = $ketBarbuk;
                $model->unsur_pasal         = $unsurPasal;
                $model->memberatkan         = $Memberatkan;
                $model->meringankan         = $Meringankan;
                $model->unsur_dakwaan       = $_POST['PdmP42']['unsur_dakwaan'];
                
                $model->id_kejati           = $kode_kejati;
                $model->id_kejari           = $kode_kejari;
                $model->id_cabjari          = $kode_cabjari;
                $model->updated_by          = $session->get("nik_user"); 
                $model->updated_ip          = $_SERVER['REMOTE_ADDR'];
                $model->created_ip          = $_SERVER['REMOTE_ADDR'];
                $model->created_by          = $session->get("nik_user");
                $model->no_register_perkara = $no_register;
//                echo '<pre>';print_r($model);exit();
                $model->save();
                
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
            } catch (Exception $exc) {
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
                        'modeltsk'      => $modeltsk,
                        'modelhkm'      => $modelhkm,
                        'modelbb'       => $modelbb,
                        'jaksap16a'     => $jaksap16a,
                    ]);
                }
          } else {
            return $this->render('create', [
                'model'         => $model,
                'sysMenu'       => $sysMenu,
                'no_register'   => $no_register,
                'modeltsk'      => $modeltsk,
                'modelhkm'      => $modelhkm,
                'modelbb'       => $modelbb,
                'jaksap16a'     => $jaksap16a,
            ]);
        }
    }

    /**
     * Updates an existing PdmP42 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionGetDetPenetapan(){
        $nomor = $_POST['no_tetap'];
        $tetap = PdmPenetapanHakim::findOne(['no_register_perkara'=>$no_register, 'no_penetapan_hakim'=>$nomor]);
    }
    public function actionUpdate()
    { 
        $sysMenu        = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P42 ]);
        $session        = new Session();
        $id_perkara     = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        
        $model          = PdmP42::findOne(['no_register_perkara'=>$no_register]);
        if ($model == null) {
            $model = new PdmP42();
        }
        
        $ket_Saksi      = json_decode($model->ket_saksi);
        $ket_Ahli       = json_decode($model->ket_ahli);
        $ket_Surat      = json_decode($model->ket_surat);
        $ket_Petunjuk   = json_decode($model->petunjuk);
        $ket_Tersangka  = json_decode($model->ket_tersangka);
        $ket_Barbuk     = json_decode($model->barbuk);
        $ket_UnPas      = json_decode($model->unsur_pasal);
        $ket_Member     = json_decode($model->memberatkan);
        $ket_Mering     = json_decode($model->meringankan);
        
        $modelhkm       = PdmPenetapanHakim::findAll(['no_register_perkara'=>$no_register, 'tentang'=> 1]);

        //echo '<pre>';print_r($modelhkm);exit;
        $modeltsk       = VwTerdakwaT2::findAll(['no_register_perkara'=>$no_register]);
//        $modelhkm       = PdmPenetapanHakim::findAll(['no_register_perkara'=>$no_register]);
        $modelbb        = PdmBarbuk::findAll(['no_register_perkara'=>$no_register]);
        $qry_p16a       = "select * from pidum.pdm_p16a where no_register_perkara = '".$no_register."' order by tgl_dikeluarkan desc limit 1 ";
        $p16a           = PdmP16a::findBySql($qry_p16a)->asArray()->one();
        $jaksap16a      = PdmJaksaP16a::findAll(['no_surat_p16a'=>$p16a[no_surat_p16a]]);

        if ($model->load(Yii::$app->request->post())) {
            try {
                $ketSaksi                   = json_encode($_POST['txt_nama_surat2']);
                $ketAhli                    = json_encode($_POST['txt_nama_surat3']);
                $ketSurat                   = json_encode($_POST['txt_nama_surat4']);
                $ketPetunjuk                = json_encode($_POST['txt_nama_surat5']);
                $ketTerdakwa                = json_encode($_POST['txt_nama_surat6']);
                $ketBarbuk                  = json_encode($_POST['txt_nama_surat7']);
                $unsurPasal                 = json_encode($_POST['txt_nama_surat8']);
                $Memberatkan                = json_encode($_POST['txt_nama_surat9']);
                $Meringankan                = json_encode($_POST['txt_nama_surat10']);
                
                $model->ket_saksi           = $ketSaksi;
                $model->ket_ahli            = $ketAhli;
                $model->ket_surat           = $ketSurat;
                $model->petunjuk            = $ketPetunjuk;
                $model->ket_tersangka       = $ketTerdakwa;
                $model->barbuk              = $ketBarbuk;
                $model->unsur_pasal         = $unsurPasal;
                $model->memberatkan         = $Memberatkan;
                $model->meringankan         = $Meringankan;
                $model->unsur_dakwaan       = $_POST['PdmP42']['unsur_dakwaan'];
                $model->file_upload         = $_POST['PdmP42']['file_upload']; 
                
                $model->id_kejati           = $kode_kejati;
                $model->id_kejari           = $kode_kejari;
                $model->id_cabjari          = $kode_cabjari;
                $model->updated_by          = $session->get("nik_user"); 
                $model->updated_ip          = $_SERVER['REMOTE_ADDR'];
                $model->created_ip          = $_SERVER['REMOTE_ADDR'];
                $model->created_by          = $session->get("nik_user");
                $model->no_register_perkara = $no_register;
//                echo '<pre>';print_r($model);exit();
                $model->save();
                
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
            } catch (Exception $exc) {
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
                        'modeltsk'      => $modeltsk,
                        'modelhkm'      => $modelhkm,
                        'modelbb'       => $modelbb,
                        'jaksap16a'     => $jaksap16a,
                        'ket_Saksi'     => $ket_Saksi,
                        'ket_Ahli'      => $ket_Ahli,
                        'ket_Surat'     => $ket_Surat,
                        'ket_Petunjuk'  => $ket_Petunjuk,
                        'ket_Tersangka' => $ket_Tersangka,
                        'ket_Barbuk'    => $ket_Barbuk,
                        'ket_UnPas'     => $ket_UnPas,
                        'ket_Member'    => $ket_Member,
                        'ket_Mering'    => $ket_Mering,
                    ]);
                }
          } else {
            return $this->render('update', [
                'model'         => $model,
                'sysMenu'       => $sysMenu,
                'no_register'   => $no_register,
                'modeltsk'      => $modeltsk,
                'modelhkm'      => $modelhkm,
                'modelbb'       => $modelbb,
                'jaksap16a'     => $jaksap16a,
                'ket_Saksi'     => $ket_Saksi,
                'ket_Ahli'      => $ket_Ahli,
                'ket_Surat'     => $ket_Surat,
                'ket_Petunjuk'  => $ket_Petunjuk,
                'ket_Tersangka' => $ket_Tersangka,
                'ket_Barbuk'    => $ket_Barbuk,
                'ket_UnPas'     => $ket_UnPas,
                'ket_Member'    => $ket_Member,
                'ket_Mering'    => $ket_Mering,
            ]);
        }
    }

    /**
     * Deletes an existing PdmP42 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete(){
        $id             = $_POST['hapusIndex'];
        $total          = count($id);
        $session        = new Session();
        $id_perkara     = $session->get("id_perkara");
        $no_register    = $session->get('no_register_perkara');
        try {
            if(count($id) <= 1){
                PdmP42::deleteAll(['no_surat_p42' => $id[0]]);
                
            }else{
                for ($i = 0; $i < count($id); $i++) {
                   PdmP42::deleteAll(['no_surat_p42' => $id[$i]]);
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
    
    public function actionCetak($id){
        $no_surat_p42   = rawurldecode($id);
        $connection     = \Yii::$app->db;
        $session        = new Session();
        $id_perkara     = $session->get("id_perkara");
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $inst_satkerkd  = $session->get('inst_satkerkd');
        $p42            = PdmP42::findOne(['no_surat_p42'=>$no_surat_p42]);
        $thp_2          = PdmTahapDua::findOne(['no_register_perkara' => $no_register]);
        $brks_thp_1     = PdmBerkasTahap1::findOne(['id_berkas' => $thp_2->id_berkas]);
        $spdp           = PdmSpdp::findOne(['id_perkara' => $brks_thp_1->id_perkara]);
        $tersangka      = VwTerdakwaT2::findAll(['no_register_perkara' => $no_register]);
        $pangkat        = PdmJaksaP16a::findOne(['nip' => $p42->id_penandatangan]);
        $pen_hakim      = PdmPenetapanHakim::findOne(['no_penetapan_hakim'=>$p42->no_penetapan_hakim]);
        $barbukList     = PdmBa5Barbuk::findAll(['no_register_perkara'=>$no_register]);
        $p41            = PdmP41Terdakwa::findAll(['no_register_perkara'=>$no_register, 'status_rentut' => 3]);
//        echo '<pre>';print_r($p41);exit;
        $p30            = PdmP30::findOne(['no_register_perkara'=>$no_register]);
        $p29            = PdmP29::findOne(['no_register_perkara'=>$no_register]);
//        echo '<pre>';print_r($p29);exit;
//        echo $p29->no_register_perkara;exit();
        if ($p29->no_register_perkara != '' && $p30->no_register_perkara == ''){
            $ket    = 'BIASA';
        }else if($p29->no_register_perkara == '' && $p30->no_register_perkara != ''){
            $ket    = 'SINGKAT';
        }
//        echo $ket;exit();
        
        return $this->render('cetak', ['pen_hakim'=>$pen_hakim,'spdp'=>$spdp,'tersangka'=>$tersangka,'pangkat'=>$pangkat, 'p41' => $p41, 'p42'=>$p42,'p30'=>$p30,'p29'=>$p29,'ket'=>$ket, 'barbukList'=>$barbukList]);
    }
    
    public function actionCetak1($no_surat_p16)
    {
        $connection = \Yii::$app->db;
        $odf = new \Odf(Yii::$app->params['report-path']."modules/pidum/template/p42.odt");
                    $pangkat = PdmPenandatangan::find()
->select ("a.jabatan as jabatan")
->from ("pidum.pdm_penandatangan a")
->join ('inner join','pidum.pdm_p42 b','a.peg_nik = b.id_penandatangan')
->where ("id_p42='".$id."'")
->one(); 
        $p42 = PdmP42::findOne(['id_p42'=>$id_p42]);
  
        $spdp = PdmSpdp::findOne(['id_perkara'=>$p42->id_perkara]);
        $pidana = \app\modules\pidum\models\PdmPkTingRef::findOne(['id'=>$spdp->id_pk_ting_ref]);
        $THakim = PdmTetapHakim::findOne(['id_perkara'=>$p42->id_perkara]);
        
        $NoReg =  \app\modules\pidum\models\PdmRp9::findOne(['id_perkara'=>$p42->id_perkara]);
        
        
        $odf->setVars('kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
        $odf->setVars('kepala', $pangkat->jabatan);
        $odf->setVars('no_perkara', $NoReg->no_urut);
        
         #tersangka
        $sql ="SELECT tersangka.* FROM "
                . " pidum.pdm_p42 p42 LEFT OUTER JOIN pidum.vw_tersangka tersangka ON (p42.id_tersangka = tersangka.id_tersangka ) "
                . "WHERE p42.id_tersangka='".$p42->id_tersangka."' "
                . "ORDER BY id_tersangka "
                . "LIMIT 1 ";
        $sqlTersangka = $connection->createCommand($sql);
        $tersangka = $sqlTersangka->queryOne();
        $umur = Yii::$app->globalfunc->datediff($tersangka['tgl_lahir'],date("Y-m-d"));
        $tgl_lahir = $umur['years'].' tahun / '.Yii::$app->globalfunc->ViewIndonesianFormat($tersangka['tgl_lahir']);        
        $odf->setVars('nama_lengkap', ucfirst(strtolower($tersangka['nama'])));       
        $odf->setVars('tempat_lahir', ucfirst(strtolower($tersangka['tmpt_lahir'])));       
        $odf->setVars('tgl_lahir', $tgl_lahir); 
              
        $odf->setVars('jenis_kelamin', ucfirst(strtolower($tersangka['is_jkl']))); 
        $odf->setVars('kebangsaan', ucfirst(strtolower($tersangka['warganegara']))); 
        $odf->setVars('tempat_tinggal', ucfirst(strtolower($tersangka['alamat']))); 
        $odf->setVars('agama', ucfirst(strtolower($tersangka['is_agama']))); 
        $odf->setVars('pekerjaan', ucfirst(strtolower($tersangka['pekerjaan']))); 
        $odf->setVars('pendidikan', ucfirst(strtolower($tersangka['is_pendidikan'])));
        
        $odf->setVars('pengadilan', $THakim->id_msstatusdata);
        $odf->setVars('no', $THakim->no_surat);
        $odf->setVars('tgl_surat', Yii::$app->globalfunc->ViewIndonesianFormat($THakim->tgl_surat));
        $sql ="SELECT ba5.id_msstatusdata "
                . "FROM  pidum.pdm_ba5 ba5 "
                . "WHERE ba5.id_perkara='".$p42->id_perkara."' "
                . "LIMIT 1 ";
        $statusExec = $connection->createCommand($sql);
        $statData = $statusExec->queryOne();
        
        if($statData['id_msstatusdata'] == '1'){ //P29 APB            
            $p31 = \app\modules\pidum\models\PdmP31::findOne(['id_perkara'=>$p42->id_perkara]);
            $tgl_limpah = $p31->tgl_dikeluarkan;
            $no_limpah = $p31->no_surat;
            $listDakwaan = $p42->getDakwaan($p42->id_perkara, $p42->id_tersangka);
            $dakwaan = $listDakwaan[0]['dakwaan'];
            $biaya_perkara = $listDakwaan[0]['biaya_perkara'];
            
        }else{            
            $p32 = \app\modules\pidum\models\PdmP32::findOne(['id_perkara'=>$p42->id_perkara]);
            $tgl_limpah = $p32->tgl_dikeluarkan;
            $no_limpah = $p32->no_surat;
            $p30 = \app\modules\pidum\models\PdmP30::findOne(['id_perkara'=>$p42->id_perkara,'id_tersangka'=>$p42->id_tersangka]);
            $dakwaan = $p30->catatan;
            $biaya_perkara = '0';
        }
        
        $odf->setVars('tgl', $tgl_limpah);
        $odf->setVars('nomor', $no_limpah);
        $odf->setVars('dakwaan',$dakwaan);
        
        $odf->setVars('ket_saksi', $p42->ket_saksi);
        $odf->setvars('ket_ahli', $p42->ket_ahli);
        $odf->setVars('surat', $p42->ket_surat);
        $odf->setVars('petunjuk', $p42->petunjuk);
        $odf->setVars('ket_terdakwa', $p42->ket_tersangka);
        $odf->setVars('barbuk', $p42->barbuk);
     
        $odf->setVars('uraian', $p42->uraian);
        $odf->setVars('unsur_dakwaan', $p42->unsur_dakwaan);
        $odf->setVars('hal_memberatkan', $p42->memberatkan);
        $odf->setVars('hal_meringankan', $p42->meringankan);
        
//        $odf->setVars('pengadilan', 'xxxxxx');
        $odf->setVars('nama', ucfirst(strtolower($tersangka['nama'])));       
//        $odf->setVars('pidana', '-');
        
         #list pasal
        $dft_pasal ='';
        $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_pasal')
                ->where("id_perkara='".$p42->id_perkara."'");
        $data = $query->createCommand();
        $listPasal = $data->queryAll();  
        foreach($listPasal as $key){            
            $dft_pasal .= $key[undang].' '.$key['pasal'].',';
        }
        $dft_pasal= substr_replace($dft_pasal,"",-1);
        $odf->setVars('pasal', $dft_pasal);
        
       
        $odf->setVars('pidana', $pidana->nama);
        $odf->setVars('pengadilan', strtolower(Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_lokinst));
        $odf->setVars('sebesar', $biaya_perkara);
        $odf->setVars('terbilang', Yii::$app->globalfunc->getTerbilang((int)$biaya_perkara));
        
        $odf->setVars('hari', Yii::$app->globalfunc->GetNamaHari($p42->tgl_dikeluarkan));
        $odf->setVars('tgl_keluar', Yii::$app->globalfunc->ViewIndonesianFormat($p42->tgl_dikeluarkan));
        	
		#penanda tangan
        $sql ="SELECT a.nama,a.pangkat,a.jabatan,c.peg_nip_baru FROM "
                . " pidum.pdm_penandatangan a, pidum.pdm_p42 b , kepegawaian.kp_pegawai c "
                . "where a.peg_nik = b.id_penandatangan and b.id_penandatangan =c.peg_nik and b.id_perkara='".$p42->id_perkara."'";
        $model = $connection->createCommand($sql);
		$penandatangan = $model->queryOne();
        $odf->setVars('nama_penandatangan', $penandatangan['nama']);       
        $odf->setVars('pangkat', $penandatangan['pangkat']);       
        $odf->setVars('nip_penandatangan', $penandatangan['peg_nip_baru']);     
	
                        
       $odf->exportAsAttachedFile('p42.odt'); 
        
         }

    /**
     * Finds the PdmP42 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmP42 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmP42::findOne($id)) !== null) {
            return $model;
        }
    }
}
