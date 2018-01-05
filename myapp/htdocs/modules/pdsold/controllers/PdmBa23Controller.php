<?php

namespace app\modules\pdsold\controllers;

use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\PdmBa23;
use app\modules\pdsold\models\PdmBa23Search;
use app\modules\pdsold\models\PdmJaksaPenerima;
use app\modules\pdsold\models\PdmJaksaSaksi;
use app\modules\pdsold\models\PdmP16a;
use app\modules\pdsold\models\PdmJaksaP16a;
use app\modules\pdsold\models\PdmJaksaP16aSearch;
use app\modules\pdsold\models\PdmTahapDua;
use app\modules\pdsold\models\PdmBerkasTahap1;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmPenandatangan;
use app\modules\pdsold\models\PdmSysMenu;
use app\modules\pdsold\models\VwJaksaPenuntutSearch;
use app\modules\pdsold\models\PdmP48;
use app\modules\pdsold\models\PdmPutusanPn;
use app\modules\pdsold\models\PdmBarbuk;
use Odf;
use Yii;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;

/**
 * PdmBa23Controller implements the CRUD actions for PdmBa23 model.
 */
class PdmBa23Controller extends Controller {

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
     * Lists all PdmBa23 models.
     * @return mixed
     */
    public function actionIndex() {
//        $session        = new Session();
//        $id_perkara     = $session->get('id_perkara');
//        $no_register    = $session->get('no_register_perkara');
//        $kode_kejati    = $session->get('kode_kejati');
//        $kode_kejari    = $session->get('kode_kejari');
//        $kode_cabjari   = $session->get('kode_cabjari');
//        $inst_satkerkd  = $session->get('inst_satkerkd');
//        $no_akta        = $session->get('no_akta');
//        $no_reg_tahanan = $session->get('no_reg_tahanan');
//        $no_eksekusi    = $session->get('no_eksekusi');
//        $searchModel    = new PdmBa23Search();
//        $dataProvider   = $searchModel->search($no_eksekusi, Yii::$app->request->queryParams);
//        $sysMenu        = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA23]);
//
//        return $this->render('index', [
//            'searchModel'   => $searchModel,
//            'dataProvider'  => $dataProvider,
//            'sysMenu'       => $sysMenu
//        ]);
        return $this->redirect('update');
    }

    /**
     * Displays a single PdmBa23 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmBa23 model.
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
        $model          = new PdmBa23();
        $sysMenu        = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA23]);
        $modelSpdp      = PdmSpdp::findOne($id);
        $model->wilayah = Yii::$app->globalfunc->getNamaSatker($modelSpdp->wilayah_kerja)->inst_nama;
        $model->lokasi  = Yii::$app->globalfunc->getNamaSatker($modelSpdp->wilayah_kerja)->inst_lokinst;
        
        $searchJPU      = new VwJaksaPenuntutSearch();
        $dataJPU        = $searchJPU->search2(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;
        
        $modelP16A      = PdmP16a::find()->where(['id_perkara' => $id])->orderBy('tgl_dikeluarkan desc')->one();
        $modeljaksi     = PdmJaksaSaksi::find()->where(['id_perkara' => $id, 'code_table' => GlobalConstMenuComponent::P16A, 'id_table' => $modelP16A->id_p16a])->orderBy('no_urut')->All();
        $modeljakpen    = new PdmJaksaPenerima();
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_ba23', 'id_ba23', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                $model->id_perkara = $id;
                $model->id_ba23 = $seq['generate_pk'];
                $model->save();
                Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara, GlobalConstMenuComponent::BA23);
                $seqjpp = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_jaksa_penerima', 'id_jpp', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                $modeljakpen->load(Yii::$app->request->post());
                $modeljakpen->id_jpp = $seqjpp['generate_pk'];
                $modeljakpen->id_perkara = $id;
                $modeljakpen->code_table = GlobalConstMenuComponent::BA23;
                $modeljakpen->id_table = $model->id_ba23;
                $modeljakpen->flag = '1';
                $modeljakpen->save();
//$NextProcces = array(ConstSysMenuComponent::B23);
                //Yii::$app->globalfunc->getNextProcces($model->id_perkara, $NextProcces);
                $no_urut = $_POST["no_urut"];
                if (!empty($_POST['txtnip'])) { //peg_nip_baru
                    $count = 0;
                    foreach ($_POST['txtnip'] as $key) {
                        $query = new Query;
                        $query->select('*')
                                ->from('pidum.vw_jaksa_penuntut')
                                ->where("peg_instakhir='" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "' and peg_nip_baru='" . $key . "'");
                        $command = $query->createCommand();
                        $data = $command->queryAll();
                        $seqjpp = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_jaksa_saksi', 'id_jpp', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                        $modeljaksi2 = new PdmJaksaSaksi();
                        $modeljaksi2->id_jpp = $seqjpp['generate_pk'];
                        $modeljaksi2->id_perkara = $model->id_perkara;
                        $modeljaksi2->code_table = GlobalConstMenuComponent::BA23;
                        $modeljaksi2->id_table = $model->id_ba23;
                        $modeljaksi2->flag = '1';
                        $modeljaksi2->nama = $data[0]['peg_nama'];
                        $modeljaksi2->nip = $data[0]['peg_nip'];
                        $modeljaksi2->peg_nip_baru = $data[0]['peg_nip_baru'];
                        $modeljaksi2->jabatan = $data[0]['jabatan'];
                        $modeljaksi2->pangkat = $data[0]['pangkat'];
                        $modeljaksi2->no_urut = $no_urut[$count];
                        $modeljaksi2->save();
                        $count++;
                    }
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
                return $this->redirect(['update', 'id' => $model->id_ba23]);
            } catch (Exception $ex) {
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
                return $this->redirect('create');
            }
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'sysMenu' => $sysMenu,
                        'modelSpdp' => $modelSpdp,
                        'searchJPU' => $searchJPU,
                        'dataJPU' => $dataJPU,
                        'modeljaksi' => $modeljaksi,
                        'modeljakpen' => $modeljakpen,
            ]);
        }
    }

    /**
     * Updates an existing PdmBa23 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate() {
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
        
        $model = PdmBa23::findOne(['no_eksekusi'=>$no_eksekusi]);
        if ($model == null) {
            $model = new PdmBa23();
        }
        
        $modelJpu       = PdmJaksaP16a::findAll(['no_register_perkara' => $no_register]);
        $modeljaksi     = PdmJaksaP16a::findOne(['no_register_perkara' => $no_register]);
        $searchJPU      = new PdmJaksaP16aSearch();
        $dataJPU        = $searchJPU->search2($no_register,Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;
        
        if ($model->load(Yii::$app->request->post())) {
            try {
                $data = $_POST['saksi'];
                $model->saksi               =  json_encode($data);
                $model->id_penandatangan    = $_POST['PdmJaksaSaksi']['nip'];
                $model->nama                = $_POST['PdmJaksaSaksi']['nama'];
                $model->pangkat             = $_POST['PdmJaksaSaksi']['pangkat'];
                $model->jabatan             = $_POST['PdmJaksaSaksi']['jabatan'];
                $model->id_kejati           = $kode_kejati;
                $model->id_kejari           = $kode_kejari;
                $model->id_cabjari          = $kode_cabjari;
                $model->updated_by          = \Yii::$app->user->identity->peg_nip;
                $model->updated_ip          = \Yii::$app->getRequest()->getUserIP();
                $model->created_ip          = \Yii::$app->getRequest()->getUserIP();
                $model->created_by          = \Yii::$app->user->identity->peg_nip;
                $model->no_register_perkara = $no_register;
                $model->no_akta             = $no_akta;
                $model->no_reg_tahanan      = $no_reg_tahanan;
                $model->no_eksekusi         = $no_eksekusi;
                
                if($model->save()){
//                    var_dump($model->getErrors());exit;
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
                    return $this->redirect('update', [
                        'model'         => $model,
                        'no_eksekusi'   => $no_eksekusi,
                        'sysMenu'       => $sysMenu,
                        'modelJpu'      => $modelJpu,
                        'modeljaksi'    => $modeljaksi,
                        'searchJPU'     => $searchJPU,
                        'dataJPU'       => $dataJPU,
                        'no_reg_tahanan'       => $no_reg_tahanan,
                    ]);
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
                    return $this->redirect(['update','no_eksekusi'=>$no_eksekusi]);
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
                    'no_eksekusi'   => $no_eksekusi,
                    'sysMenu'       => $sysMenu,
                    'modelJpu'      => $modelJpu,
                    'modeljaksi'    => $modeljaksi,
                    'searchJPU'     => $searchJPU,
                    'dataJPU'       => $dataJPU,
                    'no_reg_tahanan'       => $no_reg_tahanan,
                ]);
//                $transaction->rollback();
            }
        } else {
            return $this->render('update', [
                'model'         => $model,
                'no_eksekusi'   => $no_eksekusi,
                'sysMenu'       => $sysMenu,
                'modelJpu'      => $modelJpu,
                'modeljaksi'    => $modeljaksi,
                'searchJPU'     => $searchJPU,
                'dataJPU'       => $dataJPU,
                'no_reg_tahanan'       => $no_reg_tahanan,
            ]);
        }
    }

    /**
     * Deletes an existing PdmBa23 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete() {
        $id = $_POST['hapusIndex'];

        for ($i = 0; $i < count($id); $i++) {
            $model = PdmBa23::findOne(['id_ba23' => $id[$i]]);
            $model->flag = '3';
            $model->update();
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the PdmBa23 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmBa23 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PdmBa23::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionCetak($id) {
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
        
        $ba23            = PdmBa23::findOne(['no_eksekusi'=>$id]);
        $thp_2          = PdmTahapDua::findOne(['no_register_perkara' => $ba23->no_register_perkara]);
        $brks_thp_1     = PdmBerkasTahap1::findOne(['id_berkas' => $thp_2->id_berkas]);
        $spdp           = PdmSpdp::findOne(['id_perkara' => $brks_thp_1->id_perkara]);
        $pangkat        = PdmPenandatangan::findOne(['peg_nip_baru' => $ba23->id_penandatangan]);
        $p48            = PdmP48::findOne(['no_surat'=>$no_eksekusi]);
        $pn             = PdmPutusanPn::findOne(['no_surat'=>$p48->no_putusan]);
        $barbuk         = PdmBarbuk::findAll(['no_register_perkara'=>$no_register, 'id_ms_barbuk_eksekusi' => 3]);
//        echo '<pre>';print_r($barbuk);exit();
        return $this->render('cetak', ['barbuk'=>$barbuk ,'p48'=>$p48,'pn'=>$pn,'ba23'=>$ba23,'spdp'=>$spdp]);
    }
    

}
