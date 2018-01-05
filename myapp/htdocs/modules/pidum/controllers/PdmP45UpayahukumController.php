<?php

namespace app\modules\pidum\controllers;

use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\PdmP45Upayahukum;
use app\modules\pidum\models\PdmP45UpayahukumSearch;
use app\modules\pidum\models\PdmPkTingRef;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmSysMenu;
use app\modules\pidum\models\PdmTembusan;
use app\modules\pidum\models\PdmPenandatangan;
use app\modules\pidum\models\VwTerdakwaT2;
use app\modules\pidum\models\PdmTembusanP45Upayahukum;
use app\modules\pidum\models\PdmTahapDua;
use app\modules\pidum\models\PdmBerkasTahap1;
use app\models\MsSifatSurat;
use Odf;
use Yii;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;

/**
 * PdmP45UpayahukumController implements the CRUD actions for PdmP45Upayahukum model.
 */
class PdmP45UpayahukumController extends Controller
{
    public $sysMenu;

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

    public function init(){
        $this->sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P45 ]);
    }

    /**
     * Lists all PdmP45Upayahukum models.
     * @return mixed
     */
    public function actionIndex()
    {
        $session        = new Session();
        $id_perkara     = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $no_akta        = $session->get('no_akta');
        $no_reg_tahanan = $session->get('no_reg_tahanan');
        $searchModel    = new PdmP45UpayahukumSearch();
        $dataProvider   = $searchModel->search($no_register,$no_akta,Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sysMenu' => $this->sysMenu
        ]);
    }

    /**
     * Displays a single PdmP45Upayahukum model.
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
     * Creates a new PdmP45Upayahukum model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    	$session        = new Session();
        $id_perkara     = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $no_akta        = $session->get('no_akta');
        $no_reg_tahanan = $session->get('no_reg_tahanan');
        $model          = new PdmP45Upayahukum();
        $modeltsk       = VwTerdakwaT2::findAll(['no_reg_tahanan'=>$no_reg_tahanan]);
        
        if ($model->load(Yii::$app->request->post())) {
//            $transaction = Yii::$app->db->beginTransaction();
            try {
                $amar                       = json_encode($_POST['txt_nama_amar1']);
                $pertimbangan3              = json_encode([$_POST["txt_nama_surat"]]);
                
                
                $model->pertimbangan        = $pertimbangan3;
                $model->menyatakan          = $amar;
                $model->id_kejati           = $kode_kejati;
                $model->id_kejari           = $kode_kejari;
                $model->id_cabjari          = $kode_cabjari;
                $model->no_register_perkara = $no_register;
                $model->menuntut            = "";
                $model->tgl_put_pengadilan  = "";
                $model->no_put_pengadilan   = "";
                $model->put_pengadilan      = "";
                $model->no_akta             = $no_akta;
                $model->id_tersangka        = $no_reg_tahanan;
                $model->updated_by          = \Yii::$app->user->identity->peg_nip;
                $model->updated_ip          = \Yii::$app->getRequest()->getUserIP();
                $model->created_ip          = \Yii::$app->getRequest()->getUserIP();
                $model->created_by          = \Yii::$app->user->identity->peg_nip;
                
//                echo '<pre>';print_r($model);exit();
                if($model->save()){
                    if (isset($_POST['new_tembusan'])) {
                        PdmTembusanP45Upayahukum::deleteAll(['no_surat_p45' => $model->no_surat_p45]);
                        for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                            $modelNewTembusan                       = new PdmTembusanP45Upayahukum();
                            $modelNewTembusan->no_surat_p45         = $model->no_surat_p45;
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
                        'no_register'   => $no_register,
                        'modeltsk'      => $modeltsk,
                        'sysMenu'       => $this->sysMenu
                    ]);
                }
            }catch (Exception $e) {
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
                    'no_register'   => $no_register,
                    'modeltsk'      => $modeltsk,
                    'sysMenu'       => $this->sysMenu
                ]);
//                $transaction->rollback();
            }
        } else {
            return $this->render('create', [
                'model'         => $model,
                'no_register'   => $no_register,
                'modeltsk'      => $modeltsk,
                'sysMenu'       => $this->sysMenu
            ]);
        }
    }

    /**
     * Updates an existing PdmP45Upayahukum model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $session        = new Session();
        $id_perkara     = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $no_akta        = $session->get('no_akta');
        $no_reg_tahanan = $session->get('no_reg_tahanan');
        $modeltsk       = VwTerdakwaT2::findAll(['no_reg_tahanan'=>$no_reg_tahanan]);
        $model          = PdmP45Upayahukum::findOne(['no_surat_p45'=>$id]); 
        $ket_amar       = json_decode($model->menyatakan);

        if ($model->load(Yii::$app->request->post())) {
//        $transaction = Yii::$app->db->beginTransaction();
            try {
                $amar                       = json_encode($_POST['txt_nama_amar1']);
                $pertimbangan3              = json_encode([$_POST["txt_nama_surat"]]);
                
                
                $model->pertimbangan        = $pertimbangan3;
                $model->menyatakan          = $amar;
                $model->menuntut            = "";
                $model->tgl_put_pengadilan  = "";
                $model->no_put_pengadilan   = "";
                $model->put_pengadilan      = "";
                $model->no_akta             = $no_akta;
                $model->id_tersangka        = $no_reg_tahanan;
                
                if($model->save()){
                    if (isset($_POST['new_tembusan'])) {
                        PdmTembusanP45Upayahukum::deleteAll(['no_surat_p45' => $model->no_surat_p45]);
                        for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                            $modelNewTembusan                       = new PdmTembusanP45Upayahukum();
                            $modelNewTembusan->no_surat_p45         = $model->no_surat_p45;
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
                        'no_register'   => $no_register,
                        'modeltsk'      => $modeltsk,
                        'ket_amar'      => $ket_amar,
                        'sysMenu'       => $this->sysMenu
                    ]);
                }
            }catch (Exception $e) {
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
                    'no_register'   => $no_register,
                    'modeltsk'      => $modeltsk,
                    'ket_amar'      => $ket_amar,
                    'sysMenu'       => $this->sysMenu
                ]);
//                $transaction->rollback();
            }
        } else {
            return $this->render('update', [
                'model'         => $model,
                'no_register'   => $no_register,
                'modeltsk'      => $modeltsk,
                'ket_amar'      => $ket_amar,
                'sysMenu'       => $this->sysMenu
            ]);
        }
    }

    /**
     * Deletes an existing PdmP45Upayahukum model.
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
                PdmP45Upayahukum::deleteAll(['no_surat_p45' => $id[0]]);
                
            }else{
                for ($i = 0; $i < count($id); $i++) {
                   PdmP45Upayahukum::deleteAll(['no_surat_p45' => $id[$i]]);
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
     * Finds the PdmP45Upayahukum model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmP45Upayahukum the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmP45Upayahukum::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCetak($id){
        $no_surat_p45   = rawurldecode($id);
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
        $p45            = PdmP45Upayahukum::findOne(['no_surat_p45'=>$no_surat_p45]);
        $thp_2          = PdmTahapDua::findOne(['no_register_perkara' => $p45->no_register_perkara]);
        $brks_thp_1     = PdmBerkasTahap1::findOne(['id_berkas' => $thp_2->id_berkas]);
        $spdp           = PdmSpdp::findOne(['id_perkara' => $brks_thp_1->id_perkara]);
        $pangkat        = PdmPenandatangan::findOne(['peg_nip_baru' => $p45->id_penandatangan]);
        $listTembusan   = PdmTembusanP45Upayahukum::findAll(['no_surat_p45' => $p45->no_surat_p45]);
        $sifat          = MsSifatSurat::findOne(['id'=>$p45->sifat]);
        $pidana         = PdmPkTingRef::findOne(['id' => $spdp->id_pk_ting_ref]);
        $qry_pn         = "select * from pidum.pdm_putusan_pn where no_register_perkara = '".$no_register."' order by tgl_dikeluarkan desc limit 1 ";
        $pn             = PdmP45Upayahukum::findBySql($qry_pn)->asArray()->one();
//        print_r($pn);exit();
        $qry_41_tsk     =   "select a.*, b.*
                            from pidum.pdm_putusan_pn_terdakwa as a
                            left join pidum.vw_terdakwat2 as b on a.no_reg_tahanan = b.no_reg_tahanan
                            where a.no_register_perkara = '".$no_register."' and a.status_rentut = '3' and a.no_reg_tahanan= '".$no_reg_tahanan."' ";
        $p41_tsk        = PdmP45Upayahukum::findBySql($qry_41_tsk)->asArray()->all();
        $pertimbangan1  = json_decode($p45->pertimbangan);
        $modeltsk       = VwTerdakwaT2::findOne(['no_reg_tahanan'=>$no_reg_tahanan]);
//        print_r($pertimbangan1);exit();
        return $this->render('cetak', ['modeltsk'=>$modeltsk,'spdp'=>$spdp,'pangkat'=>$pangkat,'pangkat'=>$pangkat,'p45'=>$p45,'listTembusan'=>$listTembusan,'sifat'=>$sifat,'pidana'=>$pidana,'pn'=>$pn,'p41_tsk'=>$p41_tsk,'pertimbangan1'=>$pertimbangan1]);
    }
   
}
