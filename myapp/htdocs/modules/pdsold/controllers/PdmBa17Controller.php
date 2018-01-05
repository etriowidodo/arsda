<?php

namespace app\modules\pdsold\controllers;

use Yii;
use app\modules\pdsold\models\PdmBa17;
use app\modules\pdsold\models\PdmBa17Search;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;
use app\modules\pdsold\models\PdmSysMenu;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmTahapDua;
use app\modules\pdsold\models\PdmBerkasTahap1;
use app\modules\pdsold\models\PdmJaksaSaksi;
use app\modules\pdsold\models\PdmJaksaPenerima;
use app\modules\pdsold\models\VwTerdakwaT2;
use app\modules\pdsold\models\PdmJaksaP16a;
use app\modules\pdsold\models\PdmJaksaP16aSearch;
use app\modules\pdsold\models\PdmTembusanBa17;
use app\modules\pdsold\models\PdmP48;
use app\modules\pdsold\models\PdmPutusanPn;
use app\modules\pdsold\models\PdmPutusanPnTerdakwa;
use app\components\GlobalConstMenuComponent;

/**
 * PdmBa17Controller implements the CRUD actions for PdmBa17 model.
 */
class PdmBa17Controller extends Controller
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
     * Lists all PdmBa17 models.
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
		
        $searchModel    = new PdmBa17Search();
        $dataProvider   = $searchModel->search($no_register,Yii::$app->request->queryParams);
        $sysMenu        = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA17 ]);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sysMenu' => $sysMenu,
        ]);
    }

    /**
     * Displays a single PdmBa17 model.
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
     * Creates a new PdmBa17 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $wilayah = Yii::$app->globalfunc->getNamaSatker($kd_wilayah)->inst_nama;
        $session        = new Session();
        $id_perkara     = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $no_akta        = $session->get('no_akta');
        $no_reg_tahanan = $session->get('no_reg_tahanan');
        $model          = new PdmBa17();
        $kd_wilayah     = PdmSpdp::findOne($id)->wilayah_kerja;
        $sysMenu        = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA17 ]);
        $modeltsk       = VwTerdakwaT2::findOne(['no_reg_tahanan'=>$no_reg_tahanan]);
//        $jaksap16       = PdmJaksaP16a::findAll(['no_register_perkara'=>$no_register]);
        $modelJpu       = PdmJaksaP16a::findAll(['no_register_perkara' => $no_register]);
        $modeljaksi     = PdmJaksaP16a::findOne(['no_register_perkara' => $no_register]);
        $searchJPU      = new PdmJaksaP16aSearch();
        $dataJPU        = $searchJPU->search2($no_register,Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;

        if ($model->load(Yii::$app->request->post()) ) {
            try {
                $model->id_penandatangan    = $_POST['PdmJaksaSaksi']['nip'];
                $model->nama                = $_POST['PdmJaksaSaksi']['nama'];
                $model->pangkat             = $_POST['PdmJaksaSaksi']['pangkat'];
                $model->jabatan             = $_POST['PdmJaksaSaksi']['jabatan'];
                $model->no_register_perkara = $no_register;
                $model->id_perkara          = "";
                $model->no_akta             = $no_akta;
                $model->id_tersangka        = $no_reg_tahanan;
                $model->updated_by          = \Yii::$app->user->identity->peg_nip;
                $model->updated_ip          = \Yii::$app->getRequest()->getUserIP();
                $model->created_ip          = \Yii::$app->getRequest()->getUserIP();
                $model->created_by          = \Yii::$app->user->identity->peg_nip;
                echo '<pre>';print_r($model);exit();
                if($model->save()){
                
                    if (isset($_POST['new_tembusan'])) {
                        PdmTembusanBa17::deleteAll(['no_surat_ba17' => $model->no_surat_ba17]);
                        for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                            $modelNewTembusan                       = new PdmTembusanBa17();
                            $modelNewTembusan->no_surat_ba17        = $model->no_surat_ba17;
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
                } else {

                            var_dump($model->getErrors());exit;
                           
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
                        'modeltsk'      => $modeltsk,
                        'wilayah'       => $wilayah,
                        'modelJpu'      => $modelJpu,
                        'modeljaksi'    => $modeljaksi,
                        'searchJPU'     => $searchJPU,
                        'dataJPU'       => $dataJPU,
                    ]);
                }
                
            }catch (Exception $e) {
//                echo $e;exit();
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
                    'modeltsk'      => $modeltsk,
                    'wilayah'       => $wilayah,
                    'modelJpu'      => $modelJpu,
                    'modeljaksi'    => $modeljaksi,
                    'searchJPU'     => $searchJPU,
                    'dataJPU'       => $dataJPU,
                ]);
            }
			
        } else {
            return $this->render('create', [
                'model'         => $model,
                'sysMenu'       => $sysMenu,
                'modeltsk'      => $modeltsk,
                'wilayah'       => $wilayah,
                'modelJpu'      => $modelJpu,
                'modeljaksi'    => $modeljaksi,
                'searchJPU'     => $searchJPU,
                'dataJPU'       => $dataJPU,
            ]);
        }
    }

    /**
     * Updates an existing PdmBa17 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $wilayah = Yii::$app->globalfunc->getNamaSatker($kd_wilayah)->inst_nama;
        $session        = new Session();
        $id_perkara     = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $no_akta        = $session->get('no_akta');
        $no_reg_tahanan = $session->get('no_reg_tahanan');
        $model          = PdmBa17::findOne(['no_surat_ba17'=>$id]);
        $kd_wilayah     = PdmSpdp::findOne($id)->wilayah_kerja;
        $sysMenu        = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA17 ]);
        $modeltsk       = VwTerdakwaT2::findOne(['no_reg_tahanan'=>$no_reg_tahanan]);
//        $jaksap16       = PdmJaksaP16a::findAll(['no_register_perkara'=>$no_register]);
        $modelJpu       = PdmJaksaP16a::findAll(['no_register_perkara' => $no_register]);
        $modeljaksi     = PdmJaksaP16a::findOne(['no_register_perkara' => $no_register,'nip'=>$model->id_penandatangan,'nama'=>$model->nama]);
        $searchJPU      = new PdmJaksaP16aSearch();
        $dataJPU        = $searchJPU->search2($no_register,Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;
		
        if ($model->load(Yii::$app->request->post()) ) {
            try {
                
                $model->id_penandatangan    = $_POST['PdmJaksaSaksi']['nip'];
                $model->nama                = $_POST['PdmJaksaSaksi']['nama'];
                $model->pangkat             = $_POST['PdmJaksaSaksi']['pangkat'];
                $model->jabatan             = $_POST['PdmJaksaSaksi']['jabatan'];
//                echo '<pre>';print_r($model);exit();
                if($model->update()){
                
                    if (isset($_POST['new_tembusan'])) {
                        PdmTembusanBa17::deleteAll(['no_surat_ba17' => $model->no_surat_ba17]);
                        for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                            $modelNewTembusan                       = new PdmTembusanBa17();
                            $modelNewTembusan->no_surat_ba17        = $model->no_surat_ba17;
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
                } else {
////                    echo 'gagal';exit();
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
                        'modeltsk'      => $modeltsk,
                        'wilayah'       => $wilayah,
                        'modelJpu'      => $modelJpu,
                        'modeljaksi'    => $modeljaksi,
                        'searchJPU'     => $searchJPU,
                        'dataJPU'       => $dataJPU,
                    ]);
                }
            } catch (Exception $e) {
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
                    'modeltsk'      => $modeltsk,
                    'wilayah'       => $wilayah,
                    'modelJpu'      => $modelJpu,
                    'modeljaksi'    => $modeljaksi,
                    'searchJPU'     => $searchJPU,
                    'dataJPU'       => $dataJPU,
                ]);
            }
        } else {
            return $this->render('update', [
                'model'         => $model,
                'sysMenu'       => $sysMenu,
                'modeltsk'      => $modeltsk,
                'wilayah'       => $wilayah,
                'modelJpu'      => $modelJpu,
                'modeljaksi'    => $modeljaksi,
                'searchJPU'     => $searchJPU,
                'dataJPU'       => $dataJPU,
            ]);
        }
    }

    /**
     * Deletes an existing PdmBa17 model.
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
                PdmBa17::deleteAll(['no_surat_ba17' => $id[0]]);
                PdmTembusanBa17::deleteAll(['no_surat_ba17' => $id[0]]);
            }else{
                for ($i = 0; $i < count($id); $i++) {
                   PdmBa17::deleteAll(['no_surat_ba17' => $id[$i]]);
                   PdmTembusanBa17::deleteAll(['no_surat_ba17' => $id[$i]]);
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
     * Finds the PdmBa17 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmBa17 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmBa17::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
    
    public function actionCetak($id){
        $no_surat_ba17  = rawurldecode($id);
        $session        = new Session();
        $id_perkara     = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $no_akta        = $session->get('no_akta');
        $no_reg_tahanan = $session->get('no_reg_tahanan');
        $no_eksekusi    = $session->get('no_eksekusi');
        $ba17           = PdmBa17::findOne(['no_surat_ba17'=>$no_surat_ba17]);
        $thp_2          = PdmTahapDua::findOne(['no_register_perkara' => $ba17->no_register_perkara]);
        $brks_thp_1     = PdmBerkasTahap1::findOne(['id_berkas' => $thp_2->id_berkas]);
        $spdp           = PdmSpdp::findOne(['id_perkara' => $brks_thp_1->id_perkara]);
        $listTembusan   = PdmTembusanBa17::findAll(['no_surat_ba17' => $ba17->no_surat_ba17]);
        $modeltsk       = VwTerdakwaT2::findOne(['no_reg_tahanan'=>$no_reg_tahanan]);
        $p48            = PdmP48::findOne(['no_surat'=>$no_eksekusi]);
        $pn             = PdmPutusanPn::findOne(['no_surat'=>$p48->no_putusan]);
//        echo $qry_41_tsk;exit();
//        $qry_41_tsk     =   "select a.*, b.*
//                            from pidum.pdm_putusan_pn_terdakwa as a
//                            left join pidum.vw_terdakwat2 as b on a.no_reg_tahanan = b.no_reg_tahanan
//                            where a.no_register_perkara = '".$no_register."' and a.status_rentut = '3' and a.no_reg_tahanan= '".$no_reg_tahanan."' and a.no_surat= '".$p48->no_putusan."' ";
//        echo $qry_41_tsk;exit();
//        $amar_put       = PdmPutusanPn::findBySql($qry_41_tsk)->asArray()->all();
        $amar_put       = PdmPutusanPnTerdakwa::findAll(['no_register_perkara'=>$no_register, 'status_rentut'=> 3, 'no_reg_tahanan'=>$no_reg_tahanan, 'no_surat'=>$p48->no_putusan]);
        $sts_rentut     = PdmPutusanPnTerdakwa::findOne(['no_register_perkara'=>$no_register, 'status_rentut'=> 3, 'no_reg_tahanan'=>$no_reg_tahanan, 'no_surat'=>$p48->no_putusan]);
        
        return $this->render('cetak', ['sts_rentut'=>$sts_rentut,'amar_put'=>$amar_put,'pn'=>$pn,'p48'=>$p48,'ba17'=>$ba17, 'spdp'=>$spdp, 'listTembusan'=>$listTembusan, 'modeltsk'=>$modeltsk]);
    }
}
