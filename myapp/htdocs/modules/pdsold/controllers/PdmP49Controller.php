<?php

namespace app\modules\pdsold\controllers;

use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\PdmP49;
use app\modules\pdsold\models\PdmP49Search;
use app\modules\pdsold\models\PdmPenandatangan;
use app\modules\pdsold\models\PdmTembusanP49;
use app\modules\pdsold\models\PdmTahapDua;
use app\modules\pdsold\models\PdmBerkasTahap1;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmPutusanPn;
use app\modules\pdsold\models\PdmP48;
use app\modules\pdsold\models\PdmPutusanPnTerdakwa;
use app\modules\pdsold\models\PdmBa5;
use Jaspersoft\Client\Client;
use Yii;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;
use app\modules\pdsold\models\PdmSysMenu;
use app\modules\pdsold\models\PdmTembusan;
use app\modules\pdsold\models\VwTerdakwaT2;

/**
 * PdmP49Controller implements the CRUD actions for PdmP49 model.
 */
class PdmP49Controller extends Controller
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
     * Lists all PdmP49 models.
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
        $inst_satkerkd  = $session->get('inst_satkerkd');
        $no_akta        = $session->get('no_akta');
        $no_reg_tahanan = $session->get('no_reg_tahanan');
        $no_eksekusi    = $session->get('no_eksekusi');
        $searchModel    = new PdmP49Search();
        $dataProvider   = $searchModel->search($no_eksekusi,Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PdmP49 model.
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
     * Creates a new PdmP49 model.
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
        $inst_satkerkd  = $session->get('inst_satkerkd');
        $no_akta        = $session->get('no_akta');
        $no_reg_tahanan = $session->get('no_reg_tahanan');
        $no_eksekusi    = $session->get('no_eksekusi');
        $model          = new PdmP49();
        $modeltsk       = VwTerdakwaT2::findOne(['no_reg_tahanan'=>$no_reg_tahanan]);
        
        if ($model->load(Yii::$app->request->post())) {
//            $transaction = Yii::$app->db->beginTransaction();
            try {
//                $model->id_kejati           = $kode_kejati;
//                $model->id_kejari           = $kode_kejari;
//                $model->id_cabjari          = $kode_cabjari;
                $ngingat                    = json_encode($_POST['txt_nama_alasan']);
                $model->mengingat           = $ngingat;
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
                    if (isset($_POST['new_tembusan'])) {
                        PdmTembusanP49::deleteAll(['no_surat_p49' => $model->no_surat_p49]);
                        for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                            $modelNewTembusan                       = new PdmTembusanP49();
                            $modelNewTembusan->no_surat_p49         = $model->no_surat_p49;
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
//                        'sysMenu'       => $this->sysMenu
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
//                    'sysMenu'       => $this->sysMenu
                ]);
//                $transaction->rollback();
            }
        } else {
            return $this->render('create', [
                'model'         => $model,
                'no_register'   => $no_register,
                'modeltsk'      => $modeltsk,
//                'sysMenu'       => $this->sysMenu
            ]);
        }
    }

    /**
     * Updates an existing PdmP49 model.
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
        $inst_satkerkd  = $session->get('inst_satkerkd');
        $no_akta        = $session->get('no_akta');
        $no_reg_tahanan = $session->get('no_reg_tahanan');
        $no_eksekusi    = $session->get('no_eksekusi');
        $modeltsk       = VwTerdakwaT2::findOne(['no_reg_tahanan'=>$no_reg_tahanan]);
        $model          = PdmP49::findOne(['no_surat_p49'=>$id]); 
        $mengingat      = json_decode($model->mengingat);

        if ($model->load(Yii::$app->request->post())) {
//        $transaction = Yii::$app->db->beginTransaction();
            try {
                $ngingat                    = json_encode($_POST['txt_nama_alasan']);
                $model->mengingat           = $ngingat;
                $model->no_register_perkara = $no_register;
                $model->no_akta             = $no_akta;
                $model->no_reg_tahanan      = $no_reg_tahanan;
                $model->no_eksekusi         = $no_eksekusi;
                
                
                if($model->save()){
                    if (isset($_POST['new_tembusan'])) {
                        PdmTembusanP49::deleteAll(['no_surat_p49' => $model->no_surat_p49]);
                        for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                            $modelNewTembusan                       = new PdmTembusanP49();
                            $modelNewTembusan->no_surat_p49         = $model->no_surat_p49;
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
                        'mengingat'     => $mengingat,
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
                    'mengingat'     => $mengingat,
                ]);
//                $transaction->rollback();
            }
        } else {
            return $this->render('update', [
                'model'         => $model,
                'no_register'   => $no_register,
                'modeltsk'      => $modeltsk,
                'mengingat'     => $mengingat,
            ]);
        }
    }

    /**
     * Deletes an existing PdmP49 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
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
                PdmP49::deleteAll(['no_surat_p49' => $id[0]]);
                PdmTembusanP49::deleteAll(['no_surat_p49' => $id[0]]);
                
            }else{
                for ($i = 0; $i < count($id); $i++) {
                   PdmP49::deleteAll(['no_surat_p49' => $id[$i]]);
                   PdmTembusanP49::deleteAll(['no_surat_p49' => $id[$i]]);
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
     * Finds the PdmP49 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmP49 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
         if (($model = PdmP49::findOne(['id_perkara' => $id])) !== null) {
            return $model;
        }
    }
	
    public function actionCetak($id)
    {
        $no_surat_p49   = rawurldecode($id);
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
        
        $p49            = PdmP49::findOne(['no_surat_p49'=>$no_surat_p49]);
        $thp_2          = PdmTahapDua::findOne(['no_register_perkara' => $p49->no_register_perkara]);
        $brks_thp_1     = PdmBerkasTahap1::findOne(['id_berkas' => $thp_2->id_berkas]);
        $spdp           = PdmSpdp::findOne(['id_perkara' => $brks_thp_1->id_perkara]);
        $pangkat        = PdmPenandatangan::findOne(['peg_nip_baru' => $p49->id_penandatangan]);
        $listTembusan   = PdmTembusanP49::findAll(['no_surat_p49' => $p49->no_surat_p49]);
        $tersangka      = VwTerdakwaT2::findOne(['no_reg_tahanan'=>$no_reg_tahanan]);
        $alasan         = json_decode($p49->mengingat);
        $p48            = PdmP48::findOne(['no_surat'=>$no_eksekusi]);
        $putusan_pn     = PdmPutusanPn::findOne(['no_surat'=>$p48->no_putusan]);
        $put_pn_tsk     = PdmPutusanPnTerdakwa::findOne(['no_surat'=>$p48->no_putusan, 'no_reg_tahanan'=>$no_reg_tahanan]);
//        print_r(json_decode($put_pn_tsk->undang_undang));exit();
        $qry_barbuk     =   "select a.*, b.nama as sts_eksekusi
                            from pidum.pdm_barbuk as a
                            left join pidum.pdm_ms_barbuk_eksekusi as b on a.id_ms_barbuk_eksekusi = b.id
                            where a.no_register_perkara = '".$p49->no_register_perkara."' ";
        $barbuk         = PdmPutusanPn::findBySql($qry_barbuk)->asArray()->all();
        $no_barbuk      = PdmBa5::findOne(['no_register_perkara'=>$p49->no_register_perkara]);
        
        return $this->render('cetak', ['no_barbuk'=>$no_barbuk,'barbuk'=>$barbuk,'put_pn_tsk'=>$put_pn_tsk,'putusan_pn'=>$putusan_pn,'alasan'=>$alasan,'brks_thp_1'=>$brks_thp_1,'tersangka'=>$tersangka,'spdp'=>$spdp,'pangkat'=>$pangkat,'pangkat'=>$pangkat,'p49'=>$p49,'listTembusan'=>$listTembusan]);
    }
    
	public function actionCetak1($id)
    {
		$odf = new \Odf(Yii::$app->params['report-path']."modules/pdsold/template/p49.odt");
		
		$connection = \Yii::$app->db;
		$sql =" select a.* "
				. " from pidum.pdm_p49 a "
				. " where a.id_perkara = '$id' ";
        $model = $connection->createCommand($sql);
        $data = $model->queryOne();
		 $pangkat = PdmPenandatangan::find()
->select ("a.jabatan as jabatan")
->from ("pidum.pdm_penandatangan a")
->join ('inner join','pidum.pdm_p49 b','a.peg_nik = b.id_penandatangan')
->where ("id_p49='".$id."'")
->one(); 

		$odf->setVars('nomor', ucfirst($data['no_surat'])); 
		$odf->setVars('pidana', ucfirst(strtolower('-')));  
		$odf->setVars('pasal', ucfirst(strtolower('-'))); 
		$odf->setVars('dari', ucfirst(strtolower('-')));  
		$odf->setVars('sejak', ucfirst(strtolower('-'))); 
		$odf->setVars('nama_penandatangan', ucfirst(strtolower('nama'))); 
		$odf->setVars('pangkat', ucfirst(strtolower('pangkat')));  
		$odf->setVars('nip_penandatangan', ucfirst(strtolower('nip'))); 
		$odf->setVars('ditetapkan', ucfirst(strtolower('ditetapkan'))); 
		$odf->setVars('tanggal', Yii::$app->globalfunc->ViewIndonesianFormat($data['tgl_dikeluarkan'])); 
		$odf->setVars('kejaksaan', ucfirst(Yii::$app->globalfunc->getSatker()->inst_nama)); 
		$odf->setVars('Kejaksaan', $pangkat->jabatan); 
		#tembusan
		$query = new Query;
        $query->select('*')
                ->from('pidum.pdm_tembusan')
                ->where("id_perkara='".$id."' AND kode_table='".GlobalConstMenuComponent::P49."'")
				->orderby('no_urut');
        $dt_tembusan = $query->createCommand();
        $listTembusan = $dt_tembusan->queryAll();
        $dft_tembusan = $odf->setSegment('tembusan');
        foreach($listTembusan as $element){
                $dft_tembusan->urutan_tembusan($element['no_urut']);
                $dft_tembusan->nama_tembusan($element['tembusan']);
                $dft_tembusan->merge();
        }
        $odf->mergeSegment($dft_tembusan);
		
		$odf->exportAsAttachedFile();
	}
}
