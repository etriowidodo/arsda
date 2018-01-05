<?php

namespace app\modules\pidum\controllers;

use Yii;
use yii\web\Session;
use app\modules\pidum\models\PdmP43;
use app\modules\pidum\models\PdmP43Search;
use app\modules\pidum\models\PdmPenandatangan;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pidum\models\PdmSpdp;
use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\PdmSysMenu;
use yii\db\Query;
use app\modules\pidum\models\PdmTembusan;
use app\modules\pidum\models\PdmPkTingRef;
use app\modules\pidum\models\PdmMsStatusData;
use app\modules\pidum\models\PdmP45;
use app\modules\pidum\models\PdmTembusanP43;
use app\modules\pidum\models\PdmTahapDua;
use app\modules\pidum\models\PdmBerkasTahap1;
use app\modules\pidum\models\PdmP39;
use app\models\MsSifatSurat;

/**
 * PdmP43Controller implements the CRUD actions for PdmP43 model.
 */
class PdmP43Controller extends Controller
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
     * Lists all PdmP43 models.
     * @return mixed
     */
    public function actionIndex()
    {
        $sysMenu        = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P43]);
        $session        = new Session();
        $id_perkara     = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
     	$searchModel    = new PdmP43Search();
        $dataProvider   = $searchModel->search($no_register, Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'   => $searchModel,
            'dataProvider'  => $dataProvider,
            'sysMenu'       => $sysMenu,
        ]);
    }

    /**
     * Displays a single PdmP43 model.
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
     * Creates a new PdmP43 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $sysMenu        = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P43]);
        $session        = new Session();
        $id_perkara     = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $model          = new PdmP43();
        $petunjuk       = PdmMsStatusData::findAll(['is_group'=>'P-43 ']);
	
        if ($model->load(Yii::$app->request->post())) {
            try {
                $amar                       = json_encode($_POST['txt_nama_amar1']);
                $model->amar_tut            = $amar;
                $model->updated_by          = \Yii::$app->user->identity->peg_nip;
                $model->updated_ip          = \Yii::$app->getRequest()->getUserIP();
                $model->created_ip          = \Yii::$app->getRequest()->getUserIP();
                $model->created_by          = \Yii::$app->user->identity->peg_nip;
                $model->id_kejati           = $kode_kejati;
                $model->id_kejari           = $kode_kejari;
                $model->id_cabjari          = $kode_cabjari;
                $model->no_register_perkara = $no_register;
                if($model->save()){
                    
                    if (isset($_POST['new_tembusan'])) {
                        PdmTembusanP43::deleteAll(['no_surat_p43' => $model->no_surat_p43]);
                        for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                            $modelNewTembusan                       = new PdmTembusanP43();
                            $modelNewTembusan->no_surat_p43         = $model->no_surat_p43;
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
                        return $this->redirect(['update', 'id_p43'=>$model->no_surat_p43]);
                } else {
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
                        'modelSpdp' =>$modelSpdp,
                        'petunjuk'  =>$petunjuk,
                        'sysMenu'   => $sysMenu,
                    ]);
                }
                
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
                    'model'     => $model,
                    'modelSpdp' =>$modelSpdp,
                    'petunjuk'  =>$petunjuk,
                    'sysMenu'   => $sysMenu,
                ]);
            }
           // return $this->redirect(['view', 'id' => $model->id_p43]);
        } else {
            return $this->render('create', [
                'model'     => $model,
                'modelSpdp' =>$modelSpdp,
                'petunjuk'  =>$petunjuk,
                'sysMenu'   => $sysMenu,
            ]);
        }
    }

    /**
     * Updates an existing PdmP43 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
	 
	 
    public function actionUpdate($id_p43)
    {
        $sysMenu        = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P43]);
        $session        = new Session();
        $id_perkara     = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $model          = PdmP43::findOne(['no_surat_p43'=>$id_p43]);
        $petunjuk       = PdmMsStatusData::findAll(['is_group'=>'P-43 ']);
        $ket_amar       = json_decode($model->amar_tut);
		
        if ($model->load(Yii::$app->request->post())) {
            try {
                $amar                       = json_encode($_POST['txt_nama_amar1']);
                $model->amar_tut            = $amar;
                $model->updated_by          = \Yii::$app->user->identity->peg_nip;
                $model->updated_ip          = \Yii::$app->getRequest()->getUserIP();
                $model->created_ip          = \Yii::$app->getRequest()->getUserIP();
                $model->created_by          = \Yii::$app->user->identity->peg_nip;
                $model->id_kejati           = $kode_kejati;
                $model->id_kejari           = $kode_kejari;
                $model->id_cabjari          = $kode_cabjari;
                $model->no_register_perkara = $no_register;
                if($model->update()){
                    
                    if (isset($_POST['new_tembusan'])) {
                        PdmTembusanP43::deleteAll(['no_surat_p43' => $model->no_surat_p43]);
                        for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                            $modelNewTembusan                       = new PdmTembusanP43();
                            $modelNewTembusan->no_surat_p43         = $model->no_surat_p43;
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
                        return $this->redirect(['update', 'id_p43'=>$model->no_surat_p43]);
                } else {
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
                        'modelSpdp' =>$modelSpdp,
                        'petunjuk'  =>$petunjuk,
                        'ket_amar'  =>$ket_amar,
                        'sysMenu'   => $sysMenu,
                    ]);
                }
                
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
                    'model'     => $model,
                    'modelSpdp' =>$modelSpdp,
                    'petunjuk'  =>$petunjuk,
                    'ket_amar'  =>$ket_amar,
                    'sysMenu'   => $sysMenu,
                ]);
            }
        }else {
            return $this->render('update', [
                'model'     => $model,
                'modelSpdp' =>$modelSpdp,
                'petunjuk'  =>$petunjuk,
                'ket_amar'  =>$ket_amar,
                'sysMenu'   => $sysMenu,
            ]);
        }
    }

    /**
     * Deletes an existing PdmP43 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
        $session = new session();
        $no_register_perkara = $session->get('no_register_perkara');
        $arr= array();
        $id_tahap = $_POST['hapusIndex'][0];
        
            if($id_tahap=='all'){
                    $id_tahapx=PdmP43::find()->select("no_surat_p43")->where(['no_register_perkara'=>$no_register_perkara])->asArray()->all();
                    foreach ($id_tahapx as $key => $value) {
                        $arr[] = $value['no_surat_p43'];
                        
                    }
                    $id_tahap=$arr;
            }else{
                $id_tahap = $_POST['hapusIndex'];
            }

        $count = 0;
           foreach($id_tahap AS $key_delete => $delete){
             try{
                    PdmP43::deleteAll(['no_register_perkara' => $no_register_perkara, 'no_surat_p43'=>$delete]);
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
    
    
    public function actionCetak($id){
        $connection     = \Yii::$app->db;
        $session        = new Session();
        $id_perkara     = $session->get("id_perkara");
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $inst_satkerkd  = $session->get('inst_satkerkd');
        $p43            = PdmP43::findOne(['no_surat_p43'=>$id]);
        $thp_2          = PdmTahapDua::findOne(['no_register_perkara' => $p43->no_register_perkara]);
        $brks_thp_1     = PdmBerkasTahap1::findOne(['id_berkas' => $thp_2->id_berkas]);
        $spdp           = PdmSpdp::findOne(['id_perkara' => $brks_thp_1->id_perkara]);
        $pangkat        = PdmPenandatangan::findOne(['peg_nip_baru' => $p43->id_penandatangan]);
        $listTembusan   = PdmTembusanP43::findAll(['no_surat_p43' => $p43->no_surat_p43]);
        $sifat          = MsSifatSurat::findOne(['id'=>$p43->sifat]);
        $amar_tut       = json_decode($p43->amar_tut);
        $qry_41_tsk     =   "select a.*, b.*
                            from pidum.pdm_putusan_pn_terdakwa as a
                            left join pidum.vw_terdakwat2 as b on a.no_reg_tahanan = b.no_reg_tahanan
                            where a.no_register_perkara = '".$no_register."' and a.status_rentut = '3'";
        $p41_tsk        = PdmP45::findBySql($qry_41_tsk)->asArray()->all();
//        $qry_sifat      = "select * from pidum.pdm_p39 where no_register_perkara = '".$no_register."' and acara_sidang = '7' order by tgl_dikeluarkan desc limit 1 ";
//        $sifat1         = PdmP39::findBySql($qry_sifat)->asArray()->one();
        $qry_sifat      = "select * from pidum.pdm_p42 where no_register_perkara = '".$no_register."' order by tgl_dikeluarkan desc limit 1 ";
        $sifat1         = PdmP39::findBySql($qry_sifat)->asArray()->one();
//        echo '<pre>';print_r($no_register);exit();
        return $this->render('cetak', ['spdp'=>$spdp,'pangkat'=>$pangkat,'pangkat'=>$pangkat,'p43'=>$p43,'listTembusan'=>$listTembusan,'sifat'=>$sifat,'amar_tut'=>$amar_tut,'sifat1'=>$sifat1,'p41_tsk'=>$p41_tsk]);
    }

    /**
     * Finds the PdmP43 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmP43 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmP43::findOne($id)) !== null) {
            return $model;
        }/*  else {
            throw new NotFoundHttpException('The requested page does not exist.');
        } */
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
