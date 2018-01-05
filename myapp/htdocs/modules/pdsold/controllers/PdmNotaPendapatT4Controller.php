<?php

namespace app\modules\pdsold\controllers;

use Yii;
use app\modules\pdsold\models\PdmNotaPendapatT4;
use app\modules\pdsold\models\PdmNotaPendapatT4Jaksa;
use app\modules\pdsold\models\PdmT4;
use app\modules\pdsold\models\PdmNotaPendapatT4Search;
use app\modules\pdsold\models\PdmJaksaP16;
use app\modules\pdsold\models\PdmJaksaP16Search;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\MsTersangkaPt;
use app\modules\pdsold\models\PdmPerpanjanganTahanan;
use app\modules\pdsold\models\MsInstPelakPenyidikan;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
use yii\web\Response;

/**
 * PdmNotaPendapatT4Controller implements the CRUD actions for PdmNotaPendapatT4 model.
 */
class PdmNotaPendapatT4Controller extends Controller
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
     * Lists all PdmNotaPendapatT4 models.
     * @return mixed
     */
    public function actionIndex()
    {
        $session        = new Session();
        $id_perkara     = $session->get("id_perkara");
        $searchModel    = new PdmNotaPendapatT4Search();
        $dataProvider   = $searchModel->search($id_perkara,Yii::$app->request->queryParams);
        $model          = new PdmNotaPendapatT4;

        return $this->render('index', [
            'searchModel'   => $searchModel,
            'dataProvider'  => $dataProvider,
            'model'         => $model,
        ]);
    }

    /**
     * Displays a single PdmNotaPendapatT4 model.
     * @param string $id_perpanjangan
     * @param integer $id_nota_pendapat
     * @return mixed
     */
    public function actionView($id_perpanjangan, $id_nota_pendapat)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_perpanjangan, $id_nota_pendapat),
        ]);
    }

    /**
     * Creates a new PdmNotaPendapatT4 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $session        = new Session();
        $id             = $session->get("id_perkara");
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $connection     = \Yii::$app->db;
        $model          = new PdmNotaPendapatT4();
        $modelJp16      = PdmNotaPendapatT4Jaksa::find()->where(['id_perpanjangan' => $model->id_perpanjangan,'id_nota_pendapat'=>$model->id_nota_pendapat])->orderBy('id_jaksa asc')->all();

        if ($model->load(Yii::$app->request->post()) ) {
//            $transaction = Yii::$app->db->beginTransaction();
            try {
                $qry_count      = "select max(id_nota_pendapat) + 1 as total from pidum.pdm_nota_pendapat_t4";
                $qry_count1     = $connection->createCommand($qry_count);
                $no_1           = $qry_count1->queryOne();
                if ($no_1['total'] == ''){
                    $qry_count2     = "select count(*) + 1 as total from pidum.pdm_nota_pendapat_t4";
                    $qry_count3     = $connection->createCommand($qry_count2);
                    $no_2           = $qry_count3->queryOne();
                }else{
                    $qry_count      = "select max(id_nota_pendapat) + 1 as total from pidum.pdm_nota_pendapat_t4";
                    $qry_count1     = $connection->createCommand($qry_count);
                    $no_2           = $qry_count1->queryOne();
                }
                
                $model->id_nota_pendapat    = $no_2['total'];
                $model->persetujuan         = $_POST['PdmNotaPendapatT4']['persetujuan'];
                $model->id_perpanjangan     = $_POST['PdmNotaPendapatT4']['id_perpanjangan'];
                $model->tgl_awal_penahanan_oleh_penyidik    = $_POST['PdmNotaPendapatT4']['tgl_awal_penahanan_oleh_penyidik'];
                $model->tgl_akhir_penahanan_oleh_penyidik   = $_POST['PdmNotaPendapatT4']['tgl_akhir_penahanan_oleh_penyidik'];
                $model->tgl_awal_permintaan_perpanjangan    = $_POST['PdmNotaPendapatT4']['tgl_awal_permintaan_perpanjangan'];
                $model->tgl_akhir_permintaan_perpanjangan   = $_POST['PdmNotaPendapatT4']['tgl_akhir_permintaan_perpanjangan'];
                $model->id_kejati           = $kode_kejati;
                $model->id_kejari           = $kode_kejari;
                $model->id_cabjari          = $kode_cabjari;
                $model->id_perkara          = $id;
                $model->updated_by          = $session->get("nik_user"); 
                $model->updated_ip          = $_SERVER['REMOTE_ADDR'];
                $model->created_ip          = $_SERVER['REMOTE_ADDR'];
                $model->created_by          = $session->get("nik_user");
                $pdm_perpanjangan           = PdmPerpanjanganTahanan::findOne(['id_perpanjangan' => $model->id_perpanjangan]);
                $model->no_surat_penahanan  = $pdm_perpanjangan->no_surat_penahanan;
//                echo '<pre>';print_r($model);exit();                
                if ($model->save()) {
                    $id_perpanjangan    = $_POST['PdmNotaPendapatT4']['id_perpanjangan'];
                    $nip                = $_POST['nip_jpu'];
                    $nama               = $_POST['nama_jpu'];
                    $jabatan            = $_POST['jabatan_jpu'];
                    $pangkat            = $_POST['gol_jpu'];
                    $no_urut            = $_POST['no_urut'];
                    $nip_baru           = $_POST['nip_baru'];
                    $no_penahanan       = $pdm_perpanjangan->no_surat_penahanan;
                    if (!empty($nip)) {
                        for ($i = 0; $i < count($nip); $i++) {
                            $modelJpu1  = new PdmNotaPendapatT4Jaksa();
                            $modelJpu1->id_perpanjangan     = $id_perpanjangan;
                            $modelJpu1->id_nota_pendapat    = $no_2['total'];
                            $modelJpu1->updated_by          = $session->get("nik_user"); 
                            $modelJpu1->updated_ip          = $_SERVER['REMOTE_ADDR'];
                            $modelJpu1->created_ip          = $_SERVER['REMOTE_ADDR'];
                            $modelJpu1->created_by          = $session->get("nik_user");
                            $modelJpu1->id_kejati           = $kode_kejati;
                            $modelJpu1->id_kejari           = $kode_kejari;
                            $modelJpu1->id_cabjari          = $kode_cabjari;
                            $modelJpu1->nip_jaksa_p16       = $nip[$i];
                            $modelJpu1->nama_jaksa_p16      = $nama[$i];
                            $modelJpu1->jabatan_jaksa_p16   = $jabatan[$i];
                            $modelJpu1->pangkat_jaksa_p16   = $pangkat[$i];
                            $modelJpu1->id_jaksa            = ($i+1);
                            $modelJpu1->no_surat_penahanan  = $no_penahanan;
                            $modelJpu1->save();
                        }

                    }
                    
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
                    return $this->redirect('index');
                }else {
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
                    return $this->redirect('create',[
                        'model' => $model,
                        'modelJp16' => $modelJp16,
                    ]);
                }
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
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
                return $this->redirect('create',[
                    'model' => $model,
                    'modelJp16' => $modelJp16,
                ]);
                
            }
//            return $this->redirect(['view', 'id_perpanjangan' => $model->id_perpanjangan, 'id_nota_pendapat' => $model->id_nota_pendapat]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'modelJp16' => $modelJp16,
            ]);
        }
    }

    /**
     * Updates an existing PdmNotaPendapatT4 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id_perpanjangan
     * @param integer $id_nota_pendapat
     * @return mixed
     */
    public function actionUpdate($id_nota)
    {
        $session        = new Session();
        $id             = $session->get("id_perkara");
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $model          = PdmNotaPendapatT4::findOne(['id_nota_pendapat'=>$id_nota]);
        $modelJp16      = PdmNotaPendapatT4Jaksa::findAll(['id_nota_pendapat'=>$model->id_nota_pendapat,'id_perpanjangan'=>$model->id_perpanjangan]);
        
//        $model          = $this->findModel($id_nota);
        
//        echo '<pre>';print_r($model);exit();

        if ($model->load(Yii::$app->request->post())) {
            try {
                $model->persetujuan         = $_POST['PdmNotaPendapatT4']['persetujuan'];
                $model->id_perpanjangan     = $_POST['PdmNotaPendapatT4']['id_perpanjangan'];
                $pdm_perpanjangan           = PdmPerpanjanganTahanan::findOne(['id_perpanjangan' => $model->id_perpanjangan]);
                $model->no_surat_penahanan  = $pdm_perpanjangan->no_surat_penahanan;
                $model->tgl_awal_penahanan_oleh_penyidik    = $_POST['PdmNotaPendapatT4']['tgl_awal_penahanan_oleh_penyidik'];
                $model->tgl_akhir_penahanan_oleh_penyidik   = $_POST['PdmNotaPendapatT4']['tgl_akhir_penahanan_oleh_penyidik'];
                $model->tgl_awal_permintaan_perpanjangan    = $_POST['PdmNotaPendapatT4']['tgl_awal_permintaan_perpanjangan'];
                $model->tgl_akhir_permintaan_perpanjangan   = $_POST['PdmNotaPendapatT4']['tgl_akhir_permintaan_perpanjangan'];
//                echo '<pre>';print_r($model);exit();
                if ($model->save()) {
                    $id_perpanjangan    = $_POST['PdmNotaPendapatT4']['id_perpanjangan'];
                    $nip                = $_POST['nip_jpu'];
                    $nama               = $_POST['nama_jpu'];
                    $jabatan            = $_POST['jabatan_jpu'];
                    $pangkat            = $_POST['gol_jpu'];
                    $no_urut            = $_POST['no_urut'];
                    $nip_baru           = $_POST['nip_baru'];
                    $no_penahanan       = $pdm_perpanjangan->no_surat_penahanan;
//                    echo '<pre>';print_r($nip_baru);exit();
                    if (!empty($nip)) {
                        PdmNotaPendapatT4Jaksa::deleteAll(['id_perpanjangan' => $id_perpanjangan,'id_nota_pendapat'=>$model->id_nota_pendapat]);
                        for ($i = 0; $i < count($nip_baru); $i++) {
                            $modelJpu1  = new PdmNotaPendapatT4Jaksa();
                            $modelJpu1->id_perpanjangan     = $id_perpanjangan;
                            $modelJpu1->id_nota_pendapat    = $model->id_nota_pendapat;
                            $modelJpu1->updated_by          = $session->get("nik_user"); 
                            $modelJpu1->updated_ip          = $_SERVER['REMOTE_ADDR'];
                            $modelJpu1->created_ip          = $_SERVER['REMOTE_ADDR'];
                            $modelJpu1->created_by          = $session->get("nik_user");
                            $modelJpu1->id_kejati           = $kode_kejati;
                            $modelJpu1->id_kejari           = $kode_kejari;
                            $modelJpu1->id_cabjari          = $kode_cabjari;
                            $modelJpu1->nip_jaksa_p16       = $nip_baru[$i];
                            $modelJpu1->nama_jaksa_p16      = $nama[$i];
                            $modelJpu1->jabatan_jaksa_p16   = $jabatan[$i];
                            $modelJpu1->pangkat_jaksa_p16   = $pangkat[$i];
                            $modelJpu1->id_jaksa            = ($i+1);
                            $modelJpu1->no_surat_penahanan  = $no_penahanan;
                            $modelJpu1->save();
                        }

                    }
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
                    return $this->redirect('index');
                }else {
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
                    return $this->redirect('update',[
                        'model' => $model,
                        'modelJp16' => $modelJp16,
                    ]);
                }
                
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
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
                return $this->redirect('update',[
                    'model' => $model,
                    'modelJp16' => $modelJp16,
                ]);
            }

//            return $this->redirect(['view', 'id_perpanjangan' => $model->id_perpanjangan, 'id_nota_pendapat' => $model->id_nota_pendapat]);
        } else {
            return $this->render('update', [
                'model'     => $model,
                'modelJp16' => $modelJp16,
            ]);
        }
    }
    
    
    public function actionJpu() {
        $session        = new Session();
        $id_perkara     = $session->get("id_perkara");
//        echo $id_perkara;exit();
//        $model          = PdmJaksaP16::find()->where(['id_perkara' => $id_perkara])->orderBy('no_urut asc')->all();
        $searchModel    = new PdmJaksaP16Search();
        $dataProvider   = $searchModel->search2($id_perkara,Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 5;
        return $this->renderAjax('_jpu', [
            'searchModel'   => $searchModel,
            'dataProvider'  => $dataProvider,
        ]);
    }
    
    

    /**
     * Deletes an existing PdmNotaPendapatT4 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id_perpanjangan
     * @param integer $id_nota_pendapat
     * @return mixed
     */
    public function actionDelete()
    {
        $id             = $_POST['hapusIndex'];
        $total          = count($id);
        $session        = new Session();
        $id_perkara     = $session->get("id_perkara");
        try {
            if(count($id) <= 1){
                PdmNotaPendapatT4Jaksa::deleteAll(['id_nota_pendapat' => $id[0]]);
                PdmNotaPendapatT4::deleteAll(['id_perkara' => $id_perkara,'id_nota_pendapat' => $id[0]]);
                
            }else{
                for ($i = 0; $i < count($id); $i++) {
                   PdmNotaPendapatT4Jaksa::deleteAll(['id_nota_pendapat' => $id[$i]]);
                   PdmNotaPendapatT4::deleteAll(['id_perkara' => $id_perkara,'id_nota_pendapat' => $id[$i]]);
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
        $session        = new Session();
        $id_perkara     = $session->get("id_perkara");
        $nota_t4        = PdmNotaPendapatT4::findOne(['id_nota_pendapat'=>$id]);
        $nota_t4_jaksa  = PdmNotaPendapatT4Jaksa::findAll(['id_nota_pendapat'=>$id,'id_perpanjangan'=>$nota_t4->id_perpanjangan]);
        $tersangka      = MsTersangkaPt::findOne(['id_perpanjangan'=>$nota_t4->id_perpanjangan]);
//        echo '<pre>';print_r($tersangka);exit();
        $spdp           = PdmSpdp::findOne(['id_perkara' => $id_perkara]);
        $penyidik       = MsInstPelakPenyidikan::findOne(['kode_ip'=>$spdp->id_asalsurat,'kode_ipp'=>$spdp->id_penyidik]);
//        echo $id;exit();
        return $this->render('cetak', ['spdp'=>$spdp,'nota_t4'=>$nota_t4,'nota_t4_jaksa'=>$nota_t4_jaksa,'tersangka'=>$tersangka,'penyidik'=>$penyidik]);
    }
    
    public function actionDetail()
    {
//        echo $_POST['id_perpanjangan'];exit();
        $data1        = PdmPerpanjanganTahanan::findOne(['id_perpanjangan'=>$_POST['id_perpanjangan']]);
//        echo '<pre>';print_r($data1);exit;
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'tgl_awal_permintaan_perpanjangan' => ($data1->tgl_mulai_permintaan != null) ? date('Y-m-d', strtotime($data1->tgl_mulai_permintaan)) : '',
            'tgl_awal_permintaan_perpanjangan_disp' => ($data1->tgl_mulai_permintaan != null) ? date('d-m-Y', strtotime($data1->tgl_mulai_permintaan)) : '',
            'tgl_akhir_permintaan_perpanjangan' => ($data1->tgl_selesai_permintaan != null) ? date('Y-m-d', strtotime($data1->tgl_selesai_permintaan)) : '',
            'tgl_akhir_permintaan_perpanjangan_disp' => ($data1->tgl_selesai_permintaan != null) ? date('d-m-Y', strtotime($data1->tgl_selesai_permintaan)) : '',
            'tgl_awal_penahanan_oleh_penyidik' => ($data1->tgl_mulai != null) ? date('Y-m-d', strtotime($data1->tgl_mulai)) : '',
            'tgl_awal_penahanan_oleh_penyidik_disp' => ($data1->tgl_mulai != null) ? date('d-m-Y', strtotime($data1->tgl_mulai)) : '',
            'tgl_akhir_penahanan_oleh_penyidik' => ($data1->tgl_selesai != null) ? date('Y-m-d', strtotime($data1->tgl_selesai)) : '',
            'tgl_akhir_penahanan_oleh_penyidik_disp' => ($data1->tgl_selesai != null) ? date('d-m-Y', strtotime($data1->tgl_selesai)) : '',
            'persetujuan' => $data1->persetujuan,
            'kota' => $data1->lokasi_penahanan
        ];
//        echo '<pre>';print_r($data1);exit;
    }

    /**
     * Finds the PdmNotaPendapatT4 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id_perpanjangan
     * @param integer $id_nota_pendapat
     * @return PdmNotaPendapatT4 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_nota)
    {
        if (($model = PdmNotaPendapatT4::findOne(['id_nota_pendapat' => $id_nota_pendapat])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
