<?php

namespace app\modules\pidum\controllers;

use app\components\ConstDataComponent;
use app\components\ConstSysMenuComponent;
use app\components\GlobalConstMenuComponent;
use app\models\MsSifatSurat;
use app\modules\pidum\models\PdmB19;
use app\modules\pidum\models\PdmB19Search;
use app\modules\pidum\models\PdmB4;
use app\modules\pidum\models\PdmBa18;
use app\modules\pidum\models\PdmBarbukTambahan;
use app\modules\pidum\models\PdmMsStatusData;
use app\modules\pidum\models\PdmPenandatangan;
use app\modules\pidum\models\PdmSysMenu;
use app\modules\pidum\models\PdmTembusan;
use app\modules\pidum\models\PdmTembusanB19;
use app\modules\pidum\models\PdmBarbukLelang;
use app\modules\pidum\models\PdmBarbuk;
use app\modules\pidum\models\PdmTahapDua;
use app\modules\pidum\models\PdmBerkasTahap1;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmP48;
use app\modules\pidum\models\PdmPutusanPn;
use app\modules\pidum\models\PdmPutusanPnTerdakwa;
use Odf;
use Yii;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;

/**
 * PdmB19Controller implements the CRUD actions for PdmB19 model.
 */
class PdmB19Controller extends Controller {

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
     * Lists all PdmB19 models.
     * @return mixed
     */
    public function actionIndex() {
        $session        = new Session();
        $id_perkara     = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $inst_satkerkd  = $session->get('inst_satkerkd');
        $no_akta        = $session->get('no_akta');
        $no_reg_tahanan = $session->get('no_reg_tahanan');
        $no_eksekusi    = $session->get('no_eksekusi');
        
        $sysMenu        = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::B19]);
        $searchModel    = new PdmB19Search();
        $dataProvider   = $searchModel->search($no_eksekusi, Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'   => $searchModel,
            'dataProvider'  => $dataProvider,
            'sysMenu'       => $sysMenu,
        ]);
    }

    /**
     * Displays a single PdmB19 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmB19 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $session        = new Session();
        $id_perkara     = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $inst_satkerkd  = $session->get('inst_satkerkd');
        $no_akta        = $session->get('no_akta');
        $no_reg_tahanan = $session->get('no_reg_tahanan');
        $no_eksekusi    = $session->get('no_eksekusi');
        
        $model          = new PdmB19();
        $modelbarbuk    = PdmBarbuk::findAll(['no_register_perkara'=>$no_register]);
        $status         = PdmMsStatusData::findAll(['is_group'=> 'B-19' ]);
        $sysMenu        = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::B19]);
        if ($model->load(Yii::$app->request->post())) {
            try {
                
                $model->id_kejati           = $kode_kejati;
                $model->id_kejari           = $kode_kejari;
                $model->id_cabjari          = $kode_cabjari;
                $model->no_register_perkara = $no_register;
                $model->no_akta             = $no_akta;
                $model->no_reg_tahanan      = $no_reg_tahanan;
                $model->no_eksekusi         = $no_eksekusi;
                $model->updated_by          = \Yii::$app->user->identity->peg_nip;
                $model->updated_ip          = \Yii::$app->getRequest()->getUserIP();
                $model->created_ip          = \Yii::$app->getRequest()->getUserIP();
                $model->created_by          = \Yii::$app->user->identity->peg_nip;
                
//                echo '<pre>';print_r($model);exit();
                if($model->save()){
//                    print_r($_POST['pdmBarbukFlag']);exit();
                    for ($n = 0; $n < count($_POST['pdmBarbukNo']); $n++) {
                        $modelBarbukLelang                      = new PdmBarbukLelang();
                        $modelBarbukLelang->no_surat_b19        = $model->no_surat_b19;
                        $modelBarbukLelang->no_register_perkara = $no_register;
                        $modelBarbukLelang->no_eksekusi         = $no_eksekusi;
                        $modelBarbukLelang->nama                = $_POST['pdmBarbukNama'][$n];
                        $modelBarbukLelang->jumlah              = $_POST['pdmBarbukJumlah'][$n];
                        $modelBarbukLelang->id_satuan           = $_POST['pdmBarbukSatuan'][$n];
                        $modelBarbukLelang->sita_dari           = $_POST['pdmBarbukSitaDari'][$n];
                        $modelBarbukLelang->tindakan            = $_POST['pdmBarbukTindakan'][$n];
                        $modelBarbukLelang->id_stat_kondisi     = $_POST['pdmBarbukKondisi'][$n];
//                        $modelBarbukLelang->flag                = $_POST['pdmBarbukFlag'][$n];
                        $modelBarbukLelang->flag                = isset($_POST['pdmBarbukFlag'.$n]) ? 1 : 0;
                        $modelBarbukLelang->no_urut             = ($n+1);
                        if(!$modelBarbukLelang->save()){
                            echo "Tembusan".var_dump($modelBarbukLelang->getErrors());exit;
                        }
                    }
                    
                    if (isset($_POST['new_tembusan'])) {
                        PdmTembusanB19::deleteAll(['no_surat_b19' => $model->no_surat_b19]);
                        for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                            $modelNewTembusan                       = new PdmTembusanB19();
                            $modelNewTembusan->no_surat_b19         = $model->no_surat_b19;
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
                    return $this->redirect('create', [
                        'model'         => $model,
                        'sysMenu'       => $sysMenu,
                        'status'        => $status,
                        'modelbarbuk'   => $modelbarbuk,
                    ]);
                }
            } catch (Exception $ex) {
                echo $ex;exit();
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
                return $this->redirect('create', [
                'model'         => $model,
                'sysMenu'       => $sysMenu,
                'status'        => $status,
                'modelbarbuk'   => $modelbarbuk,
            ]);
            }
        } else {
            return $this->render('create', [
                'model'         => $model,
                'sysMenu'       => $sysMenu,
                'status'        => $status,
                'modelbarbuk'   => $modelbarbuk,
            ]);
        }
    }

    /**
     * Updates an existing PdmB19 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $no_surat       = rawurldecode($id);
        $session        = new Session();
        $id_perkara     = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $inst_satkerkd  = $session->get('inst_satkerkd');
        $no_akta        = $session->get('no_akta');
        $no_reg_tahanan = $session->get('no_reg_tahanan');
        $no_eksekusi    = $session->get('no_eksekusi');
        
        $model          = PdmB19::findOne(['no_surat_b19'=>$no_surat]);
        $modelbarbuk    = PdmBarbukLelang::findAll(['no_surat_b19'=>$no_surat]);
        $status         = PdmMsStatusData::findAll(['is_group'=> 'B-19' ]);
        $sysMenu        = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::B19]);
        if ($model->load(Yii::$app->request->post())) {
            try {
                
                $model->id_kejati           = $kode_kejati;
                $model->id_kejari           = $kode_kejari;
                $model->id_cabjari          = $kode_cabjari;
                $model->no_register_perkara = $no_register;
                $model->no_akta             = $no_akta;
                $model->no_reg_tahanan      = $no_reg_tahanan;
                $model->no_eksekusi         = $no_eksekusi;
                $model->updated_by          = \Yii::$app->user->identity->peg_nip;
                $model->updated_ip          = \Yii::$app->getRequest()->getUserIP();
                $model->created_ip          = \Yii::$app->getRequest()->getUserIP();
                $model->created_by          = \Yii::$app->user->identity->peg_nip;
                
//                echo '<pre>';print_r($model);exit();
                if($model->save()){
//                    print_r($_POST['pdmBarbukFlag']);exit();
                    PdmBarbukLelang::deleteAll(['no_surat_b19' => $model->no_surat_b19]);
                    for ($n = 0; $n < count($_POST['pdmBarbukNo']); $n++) {
                        $modelBarbukLelang                      = new PdmBarbukLelang();
                        $modelBarbukLelang->no_surat_b19        = $model->no_surat_b19;
                        $modelBarbukLelang->no_register_perkara = $no_register;
                        $modelBarbukLelang->no_eksekusi         = $no_eksekusi;
                        $modelBarbukLelang->nama                = $_POST['pdmBarbukNama'][$n];
                        $modelBarbukLelang->jumlah              = $_POST['pdmBarbukJumlah'][$n];
                        $modelBarbukLelang->id_satuan           = $_POST['pdmBarbukSatuan'][$n];
                        $modelBarbukLelang->sita_dari           = $_POST['pdmBarbukSitaDari'][$n];
                        $modelBarbukLelang->tindakan            = $_POST['pdmBarbukTindakan'][$n];
                        $modelBarbukLelang->id_stat_kondisi     = $_POST['pdmBarbukKondisi'][$n];
//                        $modelBarbukLelang->flag                = $_POST['pdmBarbukFlag'][$n];
                        $modelBarbukLelang->flag                = isset($_POST['pdmBarbukFlag'.$n]) ? 1 : 0;
                        $modelBarbukLelang->no_urut             = ($n+1);
                        if(!$modelBarbukLelang->save()){
                            echo "Tembusan".var_dump($modelBarbukLelang->getErrors());exit;
                        }
                    }
                    
                    if (isset($_POST['new_tembusan'])) {
                        PdmTembusanB19::deleteAll(['no_surat_b19' => $model->no_surat_b19]);
                        for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                            $modelNewTembusan                       = new PdmTembusanB19();
                            $modelNewTembusan->no_surat_b19         = $model->no_surat_b19;
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
                        'status'        => $status,
                        'modelbarbuk'   => $modelbarbuk,
                    ]);
                }
            } catch (Exception $ex) {
//                $transaction->rollback();
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
                return $this->redirect('update', [
                    'model'         => $model,
                    'sysMenu'       => $sysMenu,
                    'status'        => $status,
                    'modelbarbuk'   => $modelbarbuk
                ]);
            }
        } else {
            return $this->render('update', [
                'model'         => $model,
                'sysMenu'       => $sysMenu,
                'status'        => $status,
                'modelbarbuk'   => $modelbarbuk
            ]);
        }
    }

    public function actionDelete()
    {
        $id             = $_POST['hapusIndex'];
//        print_r($id);exit();
        $total          = count($id);
        $session        = new Session();
        $id_perkara     = $session->get("id_perkara");
        $no_register    = $session->get('no_register_perkara');
        try {
            if(count($id) <= 1){
                
                PdmB19::deleteAll(['no_surat_b19' => rawurldecode($id[0])]);
                PdmBarbukLelang::deleteAll(['no_surat_b19' => rawurldecode($id[0])]);
                PdmTembusanB19::deleteAll(['no_surat_b19' => rawurldecode($id[0])]);
                
            }else{
                for ($i = 0; $i < count($id); $i++) {
                   PdmB19::deleteAll(['no_surat_b19' => rawurldecode($id[$i])]);
                   PdmBarbukLelang::deleteAll(['no_surat_b19' => rawurldecode($id[$i])]);
                   PdmTembusanB19::deleteAll(['no_surat_b19' => rawurldecode($id[$i])]);
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
    
    public function actionCetak($id) {
        $no_surat_b19   = rawurldecode($id);
        $connection     = \Yii::$app->db;
        $session        = new Session();
        $id_perkara     = $session->get("id_perkara");
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $inst_satkerkd  = $session->get('inst_satkerkd');
        $no_akta        = $session->get('no_akta');
        $no_reg_tahanan = $session->get('no_reg_tahanan');
        $no_eksekusi    = $session->get('no_eksekusi');
        
        $b19            = PdmB19::findOne(['no_surat_b19'=>$no_surat_b19]);
        $thp_2          = PdmTahapDua::findOne(['no_register_perkara' => $b19->no_register_perkara]);
        $brks_thp_1     = PdmBerkasTahap1::findOne(['id_berkas' => $thp_2->id_berkas]);
        $spdp           = PdmSpdp::findOne(['id_perkara' => $brks_thp_1->id_perkara]);
        $pangkat        = PdmPenandatangan::findOne(['peg_nip_baru' => $b19->id_penandatangan]);
        $listTembusan   = PdmTembusanB19::findAll(['no_surat_b19' => $b19->no_surat_b19]);
        $p48            = PdmP48::findOne(['no_surat'=>$no_eksekusi]);
        $putusan_pn     = PdmPutusanPn::findOne(['no_surat'=>$p48->no_putusan]);
        $put_pn_tsk     = PdmPutusanPnTerdakwa::findOne(['no_surat'=>$p48->no_putusan, 'no_reg_tahanan'=>$no_reg_tahanan]);
        $barbuk         = PdmBarbukLelang::findAll(['no_surat_b19'=>$no_surat_b19, 'flag'=> 1]);
        $sifat          = MsSifatSurat::findOne(['id'=>$b19->sifat]);
        $status         = PdmMsStatusData::findOne(['is_group'=> 'B-19', 'id'=>$b19->ms_status_data]);
        
        return $this->render('cetak', [
            'status'        => $status,
            'sifat'         => $sifat,
            'barbuk'        => $barbuk,
            'put_pn_tsk'    => $put_pn_tsk,
            'putusan_pn'    => $putusan_pn,
            'brks_thp_1'    => $brks_thp_1,
            'spdp'          => $spdp,
            'pangkat'       => $pangkat,
            'b19'           => $b19,
            'listTembusan'  => $listTembusan
            ]);
    }
    
    public function actionCetak1($id) {
        $connection = \Yii::$app->db;
        $odf = new Odf(Yii::$app->params['report-path'] . "modules/pidum/template/b19.odt");
	$pangkat = PdmPenandatangan::find()
->select ("a.jabatan as jabatan")
->from ("pidum.pdm_penandatangan a")
->join ('inner join','pidum.pdm_p52 b','a.peg_nik = b.id_penandatangan')
->where ("id_p52='".$id."'")
->one();
        $b19 = Pdmb19::findOne($id);
        $spdp = PdmSpdp::findOne(['id_perkara' => $b19->id_perkara]);
        $statusbarang = PdmMsStatusData::findOne(['id' => $b19->id_msstatusdata, 'is_group' => ConstDataComponent::PerihalB19]);
        $sifat = MsSifatSurat::findOne((int) $b19->sifat)->nama;

        $odf->setVars('Kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
        $odf->setVars('kejaksaan', $pangkat->jabatan);
        $odf->setVars('nomor', $b19->no_surat);
        $odf->setVars('sifat', $sifat);
        $odf->setVars('lampiran', $b19->lampiran);
        $odf->setVars('barang', $statusbarang->nama);
        $odf->setVars('keterangan', $statusbarang->keterangan);
        $odf->setVars('dikeluarkan', $b19->dikeluarkan);
        $odf->setVars('pada_tanggal', Yii::$app->globalfunc->ViewIndonesianFormat($b19->tgl_dikeluarkan));
        $odf->setVars('melalui', $b19->kepada);
        $odf->setVars('ditempat', $b19->di_kepada);
        $odf->setVars('terdiri_dari', Yii::$app->globalfunc->getBarbuk($b19->id_perkara));
        $odf->setVars('nomor', $b19->no_put_pengadilan);
        $odf->setVars('tanggal', Yii::$app->globalfunc->ViewIndonesianFormat($b19->tgl_put_pengadilan));
        $odf->setVars('kepada', $b19->dikembalikan);
        $odf->setVars('harga', $b19->harga);

#penanda tangan
        $sql = "SELECT a.nama,a.pangkat,a.jabatan,c.peg_nip_baru FROM "
                . " pidum.pdm_penandatangan a, pidum.pdm_b19 b , kepegawaian.kp_pegawai c "
                . "where a.peg_nik = b.id_penandatangan and b.id_penandatangan =c.peg_nik and b.id_b19='" . $id . "'";
        $model = $connection->createCommand($sql);
        $penandatangan = $model->queryOne();
        $odf->setVars('nama_penandatangan', $penandatangan['nama']);
        $odf->setVars('pangkat', $penandatangan['pangkat']);
        $odf->setVars('nip_penandatangan', $penandatangan['peg_nip_baru']);

        $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_tembusan')
                ->where("id_perkara='" . $b19->id_perkara . "' AND kode_table='" . GlobalConstMenuComponent::B19 . "'and id_table = '" . $b19->id_b19 . "' order by no_urut");
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

    /**
     * Deletes an existing PdmB19 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */

    /**
     * Finds the PdmB19 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmB19 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PdmB19::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Halaman Yang Anda Cari Tidak Ada.');
        }
    }

}
