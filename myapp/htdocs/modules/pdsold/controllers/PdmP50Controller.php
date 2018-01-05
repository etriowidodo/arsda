<?php

namespace app\modules\pdsold\controllers;

use app\components\GlobalConstMenuComponent;
use app\models\MsSifatSurat;
use app\modules\pdsold\models\PdmJaksaSaksi;
use app\modules\pdsold\models\PdmP50;
use app\modules\pdsold\models\PdmP50Search;
use app\modules\pdsold\models\PdmPasal;
use app\modules\pdsold\models\PdmPkTingRef;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmSysMenu;
use app\modules\pdsold\models\PdmTembusan;
use app\modules\pdsold\models\VwTerdakwa;
use app\modules\pdsold\models\PdmPenandatangan;
use app\modules\pdsold\models\VwTerdakwaT2;
use app\modules\pdsold\models\PdmTembusanP50;
use app\modules\pdsold\models\PdmTahapDua;
use app\modules\pdsold\models\PdmBerkasTahap1;
use app\modules\pdsold\models\PdmPutusanPnTerdakwa;
use app\modules\pdsold\models\PdmPutusanPn;
use Odf;
use Yii;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;


/**
 * PdmP50Controller implements the CRUD actions for PdmP50 model.
 */
class PdmP50Controller extends Controller {

    public $sysMenu;

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

    public function init() {
        $this->sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P50]);
    }

    /**
     * Lists all PdmP50 models.
     * @return mixed
     */
    public function actionIndex() {
        $session        = new Session();
        $id_perkara     = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $no_akta        = $session->get('no_akta');
        $no_reg_tahanan = $session->get('no_reg_tahanan');
        
        $searchModel    = new PdmP50Search();
        $dataProvider = $searchModel->search($no_register,$no_akta,Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'sysMenu' => $this->sysMenu
        ]);
    }

    /**
     * Displays a single PdmP50 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmP50 model.
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
        $no_akta        = $session->get('no_akta');
        $no_reg_tahanan = $session->get('no_reg_tahanan');
        $model          = new PdmP50();
        $modelSpdp      = PdmSpdp::findOne(['id_perkara' => $id_perkara]);
        $terdakwa       = VwTerdakwaT2::findOne(['no_reg_tahanan'=>$no_reg_tahanan]);
        $putusan_pn_tsk = PdmPutusanPnTerdakwa::findOne(['no_reg_tahanan'=>$no_reg_tahanan]);
        $putusan_pn     = PdmPutusanPn::findOne(['no_surat'=>$putusan_pn_tsk->no_surat]);
//        print_r($putusan_pn);exit();
        if ($model->load(Yii::$app->request->post())) {
//            $transaction = Yii::$app->db->beginTransaction();
            try {
                $alasan                     = json_encode($_POST['txt_nama_alasan']);
                $model->uraian              = $alasan;
                $model->put_pengadilan      = $putusan_pn->pengadilan;
                $model->no_put_pengadilan   = $putusan_pn->no_surat;
                $model->tgl_put_pengadilan  = $putusan_pn->tgl_dikeluarkan;
                $model->tgl_pelaksanaan     = $putusan_pn->tgl_dikeluarkan;
                $model->id_tersangka        = $no_reg_tahanan;
//                $model->id_kejati           = $kode_kejati;
//                $model->id_kejari           = $kode_kejari;
//                $model->id_cabjari          = $kode_cabjari;
                $model->no_surat            = $_POST['PdmP50']['no_surat_p50'];
                $model->flag                = "";
                $model->no_register_perkara = $no_register;
                $model->no_akta             = $no_akta;
                $model->no_reg_tahanan      = $no_reg_tahanan;
                $model->updated_by          = \Yii::$app->user->identity->peg_nip;
                $model->updated_ip          = \Yii::$app->getRequest()->getUserIP();
                $model->created_ip          = \Yii::$app->getRequest()->getUserIP();
                $model->created_by          = \Yii::$app->user->identity->peg_nip;
//                echo '<pre>';print_r($model);exit();
                if($model->save()){
                    if (isset($_POST['new_tembusan'])) {
                        PdmTembusanP50::deleteAll(['no_surat_p50' => $model->no_surat_p50]);
                        for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                            $modelNewTembusan                       = new PdmTembusanP50();
                            $modelNewTembusan->no_surat_p50         = $model->no_surat_p50;
                            $modelNewTembusan->no_register_perkara  = $no_register;
                            $modelNewTembusan->tembusan             = $_POST['new_tembusan'][$i];
                            $modelNewTembusan->no_urut              = ($i+1);
                            if(!$modelNewTembusan->save()){
                                echo "Tembusan".var_dump($modelNewTembusan->getErrors());exit;
                            }
                        }
                    }
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'success',
                        'duration' => 3000,
                        'icon' => 'fa fa-users',
                        'message' => 'Data Berhasil di Simpan',
                        'title' => 'Ubah Data',
                        'positonY' => 'top',
                        'positonX' => 'center',
                        'showProgressbar' => true,
                    ]);
                    return $this->redirect('index');
                    
                } else{
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
                        'model'     => $model,
                        'modelSpdp' => $modelSpdp,
                        'terdakwa'  => $terdakwa,
                        'sysMenu'   => $this->sysMenu
                    ]);
                }
//                Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara, GlobalConstMenuComponent::B7);
//                $transaction->commit();
            } catch (Exception $e) {
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
                    'model'     => $model,
                    'modelSpdp' => $modelSpdp,
                    'terdakwa'  => $terdakwa,
                    'sysMenu'   => $this->sysMenu
                ]);
            }
        } else {
            return $this->render('create', [
                'model'     => $model,
                'modelSpdp' => $modelSpdp,
                'terdakwa'  => $terdakwa,
                'sysMenu'   => $this->sysMenu
            ]);
        }
    }

    /**
     * Updates an existing PdmP50 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $session        = new Session();
        $id_perkara     = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $no_akta        = $session->get('no_akta');
        $no_reg_tahanan = $session->get('no_reg_tahanan');
        $model          = PdmP50::findOne(['no_surat_p50'=>$id]);
        $modelSpdp      = PdmSpdp::findOne(['id_perkara' => $id_perkara]);
        $terdakwa       = VwTerdakwaT2::findOne(['no_reg_tahanan'=>$no_reg_tahanan]);
        $alasan         = json_decode($model->uraian);
        
        if ($model->load(Yii::$app->request->post())) {
//            $transaction = Yii::$app->db->beginTransaction();
            try {
                $alasan                     = json_encode($_POST['txt_nama_alasan']);
                $model->uraian              = $alasan;
                $model->id_tersangka        = $no_reg_tahanan;
//                $model->id_kejati           = $kode_kejati;
//                $model->id_kejari           = $kode_kejari;
//                $model->id_cabjari          = $kode_cabjari;
                $model->no_surat            = $_POST['PdmP50']['no_surat_p50'];
//                echo '<pre>';print_r($model);exit();
                if($model->update()){
                    if (isset($_POST['new_tembusan'])) {
                        PdmTembusanP50::deleteAll(['no_surat_p50' => $model->no_surat_p50]);
                        for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                            $modelNewTembusan                       = new PdmTembusanP50();
                            $modelNewTembusan->no_surat_p50         = $model->no_surat_p50;
                            $modelNewTembusan->no_register_perkara  = $no_register;
                            $modelNewTembusan->tembusan             = $_POST['new_tembusan'][$i];
                            $modelNewTembusan->no_urut              = ($i+1);
                            if(!$modelNewTembusan->save()){
                                echo "Tembusan".var_dump($modelNewTembusan->getErrors());exit;
                            }
                        }
                    }
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'success',
                        'duration' => 3000,
                        'icon' => 'fa fa-users',
                        'message' => 'Data Berhasil di Simpan',
                        'title' => 'Ubah Data',
                        'positonY' => 'top',
                        'positonX' => 'center',
                        'showProgressbar' => true,
                    ]);
                    return $this->redirect('index');
                    
                } else{
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
                        'model'     => $model,
                        'modelSpdp' => $modelSpdp,
                        'terdakwa'  => $terdakwa,
                        'alasan'    => $alasan,
                        'sysMenu'   => $this->sysMenu
                    ]);
                }
//                Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara, GlobalConstMenuComponent::B7);
//                $transaction->commit();
            } catch (Exception $e) {
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
                    'model'     => $model,
                    'modelSpdp' => $modelSpdp,
                    'terdakwa'  => $terdakwa,
                    'alasan'    => $alasan,
                    'sysMenu'   => $this->sysMenu
                ]);
            }
        } else {
            return $this->render('update', [
                'model'     => $model,
                'modelSpdp' => $modelSpdp,
                'terdakwa'  => $terdakwa,
                'alasan'    => $alasan,
                'sysMenu'   => $this->sysMenu
            ]);
        }
    }

    /**
     * Deletes an existing PdmP50 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete() 
    {
        $id             = $_POST['hapusIndex'];
        $total          = count($id);
        $session        = new Session();
        $id_perkara     = $session->get("id_perkara");
        $no_register    = $session->get('no_register_perkara');
        try {
            if(count($id) <= 1){
                PdmP50::deleteAll(['no_surat_p50' => $id[0]]);
                PdmTembusanP50::deleteAll(['no_surat_p50' => $id[0]]);
                
            }else{
                for ($i = 0; $i < count($id); $i++) {
                   PdmP50::deleteAll(['no_surat_p50' => $id[$i]]);
                   PdmTembusanP50::deleteAll(['no_surat_p50' => $id[$i]]);
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

    /**
     * Finds the PdmP50 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmP50 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PdmP50::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCetak($id) {
        $session        = new Session();
        $id_perkara     = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $no_akta        = $session->get('no_akta');
        $no_reg_tahanan = $session->get('no_reg_tahanan');
        $p50            = PdmP50::findOne(['no_surat_p50'=>$id]);
        $thp_2          = PdmTahapDua::findOne(['no_register_perkara' => $p50->no_register_perkara]);
        $brks_thp_1     = PdmBerkasTahap1::findOne(['id_berkas' => $thp_2->id_berkas]);
        $spdp           = PdmSpdp::findOne(['id_perkara' => $brks_thp_1->id_perkara]);
        $pangkat        = PdmPenandatangan::findOne(['peg_nip_baru' => $p50->id_penandatangan]);
        $listTembusan   = PdmTembusanP50::findAll(['no_surat_p50' => $p50->no_surat_p50]);
        $sifat          = MsSifatSurat::findOne(['id'=>$p50->sifat]);
        $tersangka      = VwTerdakwaT2::findOne(['no_reg_tahanan'=>$no_reg_tahanan]);
        $alasan         = json_decode($p50->uraian);
        $putusan_pn_tsk = PdmPutusanPnTerdakwa::findOne(['no_reg_tahanan'=>$no_reg_tahanan]);
        $putusan_pn     = PdmPutusanPn::findOne(['no_surat'=>$putusan_pn_tsk->no_surat]);
        
        $qry_41_tsk     =   "select a.*, b.*
                            from pidum.pdm_putusan_pn_terdakwa as a
                            left join pidum.vw_terdakwat2 as b on a.no_reg_tahanan = b.no_reg_tahanan
                            where a.no_reg_tahanan = '".$no_reg_tahanan."' and a.status_rentut = '3'";
        $p41_tsk        = PdmPutusanPnTerdakwa::findBySql($qry_41_tsk)->asArray()->all();
        
        return $this->render('cetak', ['putusan_pn'=>$putusan_pn,'p41_tsk'=>$p41_tsk,'alasan'=>$alasan,'spdp'=>$spdp,'pangkat'=>$pangkat,'p50'=>$p50,'listTembusan'=>$listTembusan,'sifat'=>$sifat,'tersangka'=>$tersangka]);
    }

}
