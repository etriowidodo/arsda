<?php

namespace app\modules\pdsold\controllers;

use app\modules\pdsold\models\MsTersangka;
use app\modules\pdsold\models\PdmPasal;
use app\modules\pdsold\models\PdmSpdpSearch;
use app\modules\pdsold\models\PdmTrxPemrosesan;
use app\modules\pdsold\models\VwGridPrapenuntutanSearch;
use app\modules\pdsold\models\PdmP13Search;
use app\modules\pdsold\models\PdmP13;
use app\modules\pdsold\models\PdmBa4;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmSysMenu;
use app\modules\pdsold\models\PdmTahapDua;
use app\modules\pdsold\models\PdmBerkasTahap1;
use app\modules\pdsold\models\PdmPenandatangan;
use app\components\GlobalConstMenuComponent;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Jaspersoft\Client\Client;
use yii\web\Session;
use yii\db\Query;
use Odf;

/**
 * SpdpController implements the CRUD actions for PidumPdmSpdp model.
 */
class P13Controller extends Controller
{
    /**
     * Lists all PidumPdmSpdp models.
     * @return mixed
     */
    public function actionIndex()
    {   
        $session        = new Session();
        $id             = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        
        $sysMenu        = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P13]);
//        $idPerkara      = Yii::$app->session->get('id_perkara');
	
        $searchModel    = new PdmP13Search();
        $dataProvider   = $searchModel->search($no_register, Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = '15';

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sysMenu'=>$sysMenu
        ]);
    }

    /**
     * Displays a single PidumPdmSpdp model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $session = new Session();
        $session->destroySession('id_perkara');
        $session->set('id_perkara', $id);

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PidumPdmSpdp model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {  
        $session        = new Session();
        $id             = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');

        $sysMenu        = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P13]);
        $model          = new PdmP13();
        $modelTersangka = PdmBa4::findAll(['no_register_perkara' => $no_register]);

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try{
                $model->attributes = Yii::$app->request->post('PdmP13');
//                $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_p13', 'no_suat_p13', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();
                
                $model->no_register_perkara = $no_register;
                $model->upload_file         = '';
                $model->id_kejati           = $kode_kejati;
                $model->id_kejari           = $kode_kejari;
                $model->id_cabjari          = $kode_cabjari;
                $model->updated_by          = $session->get("nik_user"); 
                $model->updated_ip          = $_SERVER['REMOTE_ADDR'];
                $model->created_by          = $session->get("nik_user"); 
                $model->save();
                $transaction->commit();

                if($model->save()){
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
                }else{
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

            }catch (Exception $e) {
                $transaction->rollback();
            }

        } else {
            return $this->render('create', [
                'model' => $model,
                'modelTersangka' => $modelTersangka,
                'modelPasal' => $modelPasal,
                'sysMenu' =>$sysMenu
            ]);
        }
    }

    /**
     * Updates an existing PidumPdmSpdp model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id, $url)
    {
        
        return $this->redirect([$url, 'id' => $id]);

        Yii::$app->globalfunc->setSessionPerkara($id);
        $session = new Session();
        $session->destroySession('id_perkara');
        $session->set('id_perkara', $id);

        return $this->redirect('view', ['id' => $id]);
        $model = $this->findModel($id);
        // $modelTersangka = new MsTersangka();
        // $modelTersangkaUpdate = $this->findModelTersangka($id);
        // $modelPasal = new PdmPasal();
        // $modelPasalUpdate = $this->findModelPasal($id);
        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_perkara]);
        } else {
            return $this->render('update', [
                'model' => $model,
                // 'modelTersangka' => $modelTersangka,
                // 'modelTersangkaUpdate' => $modelTersangkaUpdate,
                // 'modelPasal' => $modelPasal
            ]);
        }
    }
    
    public function actionUpdate2($id)
    {
        $id1            = rawurldecode($id);
        $sysMenu        = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P13]);
        $session        = new Session();
        $id             = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
        $kode_kejati    = $session->get('kode_kejati');
        $kode_kejari    = $session->get('kode_kejari');
        $kode_cabjari   = $session->get('kode_cabjari');
        $model          = PdmP13::findOne(['no_surat_p13' => $id1]);
        if ($model == null) {
            $model = new PdmP13();
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', [
                'type' => 'success',
                'duration' => 3000,
                'icon' => 'fa fa-users',
                'message' => 'Data Berhasil di Ubah',
                'title' => 'Simpan Data',
                'positonY' => 'top',
                'positonX' => 'center',
                'showProgressbar' => true,
            ]);
//            return $this->redirect(['update2', 'id' => $model->no_surat_p13]); 
            return $this->redirect(['index']); 
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'sysMenu' => $sysMenu,
            ]);
        }
    }

    /**
     * Deletes an existing PidumPdmSpdp model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
        $session        = new Session();
        $id_perkara     = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
        $transaction    = Yii::$app->db->beginTransaction();
        try {
            $id_p13 = $_POST['hapusIndex'];
            if ($id_p13 === 'all') {
                pdmP13::deleteAll('no_register_perkara=:no_register_perkara', [':no_register_perkara' => $no_register],'no_surat_p13=:no_surat_p13', [':no_surat_p13' => $id_p13]);
            } else {
                for ($i = 0; $i < count($id_p13); $i++) {
                    pdmP13::deleteAll(['no_surat_p13' => $id_p13[$i]]);
                }
            }

            $transaction->commit();

            Yii::$app->getSession()->setFlash('success', [
                'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
                'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                'icon' => 'glyphicon glyphicon-ok-sign', //String
                'message' => 'Data Berhasil Dihapus', // String
                'title' => 'Delete', //String
                'positonY' => 'top', //String // defaults to top, allows top or bottom
                'positonX' => 'center', //String // defaults to right, allows right, center, left
                'showProgressbar' => true,
            ]);

            return $this->redirect(['index']);
        } catch (Exception $e) {
            $transaction->rollBack();

            Yii::$app->getSession()->setFlash('success', [
                'type' => 'danger', //String, can only be set to danger, success, warning, info, and growl
                'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                'icon' => 'glyphicon glyphicon-ok-sign', //String
                'message' => 'Data Gagal Dihapus', // String
                'title' => 'Delete', //String
                'positonY' => 'top', //String // defaults to top, allows top or bottom
                'positonX' => 'center', //String // defaults to right, allows right, center, left
                'showProgressbar' => true,
            ]);

            return $this->redirect(['index']);
        }
    }

    public function actionShowTersangka()
    {
       
    }

    /**
     * Finds the PidumPdmSpdp model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PidumPdmSpdp the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmP13::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionCetak($no_surat_p13){
        $id             = rawurldecode($no_surat_p13);
        $session        = new Session();
        $id_perkara     = $session->get('id_perkara');
        $no_register    = $session->get('no_register_perkara');
        $p13            = PdmP13::findOne(['no_surat_p13' => $id]);
        $connection     = \Yii::$app->db;
        
        $thp_2          = PdmTahapDua::findOne(['no_register_perkara' => $p13->no_register_perkara]);
        $brks_thp_1     = PdmBerkasTahap1::findOne(['id_berkas' => $thp_2->id_berkas]);
        $spdp           = PdmSpdp::findOne(['id_perkara' => $brks_thp_1->id_perkara]);
        
        $tersangka      = PdmBa4::findOne(['no_register_perkara' => $p13->no_register_perkara,'no_urut_tersangka' => $p13->id_tersangka]);
        $penandatangan  = PdmPenandatangan::findOne(['peg_nip_baru' => $p13->id_penandatangan]);
        
        return $this->render('cetak', ['spdp'=>$spdp,'p13'=>$p13,'tersangka'=>$tersangka,'penandatangan'=>$penandatangan]);
    }
    
    public function actionCetak1($id_p13){
        
        $connection = \Yii::$app->db;
        $odf = new \Odf(Yii::$app->params['report-path']."modules/pdsold/template/p13.odt");
        
        $model = PdmP13::findOne(['id_p13'=>$id_p13]);
        $spdp = PdmSpdp::findOne(['id_perkara' => $p13->id_perkara]);        
        $pasal = PdmPasal::findOne(['id_perkara'=>$p13->id_perkara]);
        
        $odf->setVars('Kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
		$odf->setVars('kejaksaan', ucwords(strtolower(Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama)));
        $odf->setVars('kepala', Yii::$app->globalfunc->setKepalaReport($spdp->wilayah_kerja));
        $odf->setvars('no_surat', $model->no_surat);
		$odf->setvars('lampiran', $model->lampiran);
		$odf->setvars('kepada', $model->kepada);
		$odf->setvars('tempat', $model->di_kepada);
		$odf->setVars('tanggal', Yii::$app->globalfunc->ViewIndonesianFormat( $model->tgl_dikeluarkan));
		$odf->setVars('tersangka', MsTersangka::findOne(['id_tersangka' => $model->id_tersangka])->nama);
		$odf->setvars('ket_saksi', $model->ket_saksi);
		$odf->setvars('ket_ahli', $model->ket_ahli);
		$odf->setvars('surat-surat', $model->ket_surat);
		$odf->setvars('barang_bukti', $model->petunjuk);
		$odf->setvars('ket_tersangka', $model->ket_tersangka);
		$odf->setvars('fakta_hukum', $model->hukum);
		$odf->setvars('pem_yuridis', $model->yuridis);
		$odf->setvars('kesimpulan', $model->kesimpulan);
		$odf->setvars('saran', $model->saran);
		$odf->setvars('no_sp', $model->no_sp);
		$odf->setVars('tgl_sp', Yii::$app->globalfunc->ViewIndonesianFormat( $model->tgl_sp));
		$odf->setVars('pasalSpdp', PdmSpdp::findOne(['id_perkara' => $model->id_perkara])->undang_pasal);
		
		//$odf->setVars('pasalSpdp', $spdp->undang_pasal);
		
		#penanda tangan
        $sql = "SELECT a.nama,a.pangkat,a.jabatan,c.peg_nip_baru FROM "
                . " pidum.pdm_penandatangan a, pidum.pdm_p13 b , kepegawaian.kp_pegawai c "
                . "where a.peg_nik = b.id_penandatangan and b.id_penandatangan =c.peg_nik and b.id_perkara='" . $model->id_perkara . "'";
        $model = $connection->createCommand($sql);
        $penandatangan = $model->queryOne();
        $odf->setVars('nama_penandatangan', $penandatangan['nama']);
        $odf->setVars('pangkat_penandatangan', $penandatangan['pangkat']);
        $odf->setVars('nip_penandatangan', $penandatangan['peg_nip_baru']);
		
		
        
        $odf->exportAsAttachedFile('P13.odt');
    }

    protected function findModelTersangka($id)
    {
       
    }

    protected function findModelPasal($id)
    {
       
    }
}
