<?php

namespace app\modules\pdsold\controllers;

use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmSysMenu;
use app\modules\pdsold\models\PdmT4;
use app\modules\pdsold\models\PdmT6;
use app\modules\pdsold\models\PdmBa4;
use app\modules\pdsold\models\PdmT7;
use app\modules\pdsold\models\PdmT6Search;
use app\modules\pdsold\models\PdmTahananPenyidik;
use app\modules\pdsold\models\PdmTembusanT6;
use app\modules\pdsold\models\PdmPenandatangan;
use app\components\ConstSysMenuComponent;
use Odf;
use Yii;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;

/**
 * PdmT6Controller implements the CRUD actions for PdmT6 model.
 */
class PdmT6Controller extends Controller
{
    public function behaviors(){
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
     * Lists all PdmT6 models.
     * @return mixed
     */
    public function actionIndex()
    {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::T6 ]);
        $session = new Session();
        $no_register_perkara = $session->get('no_register_perkara');
        $searchModel = new PdmT6Search();
        $dataProvider = $searchModel->search($no_register_perkara,Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sysMenu'=>  $sysMenu,
        ]);
    }

    /**
     * Displays a single PdmT6 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id){
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmT6 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    
    public function actionCreate()
    {   $session = new Session();
	    $no_register_perkara = $session->get('no_register_perkara');
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::T6 ]);
        $model = new PdmT6();



        if ($model->load(Yii::$app->request->post())) {
        //echo '<pre>';print_r($_POST);exit;
            
            //$seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_t6', 'id_t6', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();
	       //$id_t6 = $seq['generate_pk'];
            $model->no_register_perkara = $no_register_perkara;
            $model->no_surat_t6 = $_POST['PdmT6']['no_surat_t6'];
            $model->dikeluarkan = $_POST['PdmT6']['dikeluarkan'];
            $model->tgl_dikeluarkan     = $_POST['PdmT6']['tgl_dikeluarkan'];
            $model->sifat       = $_POST['PdmT6']['sifat'];
            $model->kepada      = $_POST['PdmT6']['kepada'];
            $model->di_kepada   = $_POST['PdmT6']['di_kepada'];
            $model->id_tersangka   = $_POST['PdmT6']['id_tersangka'];
            $model->alasan   = $_POST['PdmT6']['alasan'];
            $model->karena   = $_POST['PdmT6']['karena'];
            $model->tgl_mulai   = $_POST['PdmT6']['tgl_mulai'];
            $model->tgl_selesai   = $_POST['PdmT6']['tgl_selesai'];
            $model->id_penandatangan   = $_POST['PdmT6']['id_penandatangan'];
            $model->tgl_mulai   = date('Y-m-d', strtotime($_POST['tgl_mulai-pdmt6-tgl_mulai']));
            $model->tgl_selesai = date('Y-m-d', strtotime($_POST['tgl_selesai-pdmt6-tgl_selesai']));

            $model->created_by=\Yii::$app->user->identity->peg_nip;
            $model->created_time=date('Y-m-d H:i:s');
            $model->created_ip = \Yii::$app->getRequest()->getUserIP();

            $model->updated_by=\Yii::$app->user->identity->peg_nip;
            $model->updated_time=date('Y-m-d H:i:s');
            $model->updated_ip = \Yii::$app->getRequest()->getUserIP();

            $model->id_kejati = $session->get('kode_kejati');
            $model->id_kejari = $session->get('kode_kejari');
            $model->id_cabjari = $session->get('kode_cabjari');

            if(isset($_POST['PdmT6']['file_upload'])){
                $model->file_upload = $_POST['PdmT6']['file_upload'];
                $model->uploaded_time = date('Y-m-d H:i:s');
            }
            

            
            if(!$model->save()){
                        var_dump($model->getErrors());echo "t6";exit;
                    }

            /*$NextProcces = array(ConstSysMenuComponent::BA6,ConstSysMenuComponent::T8);
            Yii::$app->globalfunc->getNextProcces($model->id_perkara,$NextProcces); */
            
            PdmTembusanT6::deleteAll(['no_register_perkara' => $no_register_perkara,'no_surat_t6'=>$_POST['PdmT6']['no_surat_t6']]);
            if (isset($_POST['new_tembusan'])) {
                for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                    $modelNewTembusan = new PdmTembusanT6();
                    $modelNewTembusan->no_register_perkara = $no_register_perkara;
                    $modelNewTembusan->no_surat_t6  = $_POST['PdmT6']['no_surat_t6'];
                    $modelNewTembusan->no_urut      = $_POST['new_no_urut'][$i];
                    $modelNewTembusan->tembusan     = $_POST['new_tembusan'][$i];
                    $modelNewTembusan->save();
                }
            }
//            return $this->redirect(['update', 'id' => $model->id_t6]);
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
        } else {
            return $this->render('create', [
                'model' => $model,
                'no_register_perkara'=>$no_register_perkara,
                'sysMenu'=>$sysMenu
            ]);
        }
    }

    /**
     * Updates an existing PdmT6 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::T6]);
        $session = new Session();
        $no_register_perkara = $session->get('no_register_perkara');
        $model = PdmT6::findOne(['no_register_perkara' => $no_register_perkara]);
        if ($model == null) {
            $model = new PdmT6();
        }
        
        //$seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_t6', 'id_t6', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
        //$id_t6 = $seq['generate_pk'];
        if ($model->load(Yii::$app->request->post())) {
            //echo '<pre>';print_r($_POST);exit;
           // $model->upload_file = "file aplot";
            /*if ($model->no_register_perkara != null) {
                $model->update();
            } else {
                $model->id_perkara = $id_perkara;
                $model->id_t6 = $id_t6;
                $model->save();
            }*/
            //echo '<pre>';print_r($_POST['new_tembusan'][1]);exit;
            $model->no_register_perkara = $no_register_perkara;
            $model->no_surat_t6 = $_POST['PdmT6']['no_surat_t6'];
            $model->dikeluarkan = $_POST['PdmT6']['dikeluarkan'];
            $model->tgl_dikeluarkan     = $_POST['PdmT6']['tgl_dikeluarkan'];
            $model->sifat       = $_POST['PdmT6']['sifat'];
            $model->kepada      = $_POST['PdmT6']['kepada'];
            $model->di_kepada   = $_POST['PdmT6']['di_kepada'];
            $model->id_tersangka   = $_POST['PdmT6']['id_tersangka'];
            $model->alasan   = $_POST['PdmT6']['alasan'];
            $model->karena   = $_POST['PdmT6']['karena'];
            $model->tgl_mulai   = $_POST['PdmT6']['tgl_mulai'];
            $model->tgl_selesai   = $_POST['PdmT6']['tgl_selesai'];
            $model->id_penandatangan   = $_POST['PdmT6']['id_penandatangan'];
            $model->tgl_mulai   = date('Y-m-d', strtotime($_POST['tgl_mulai-pdmt6-tgl_mulai']));
            $model->tgl_selesai = date('Y-m-d', strtotime($_POST['tgl_selesai-pdmt6-tgl_selesai']));
            $model->updated_by=\Yii::$app->user->identity->peg_nip;
            $model->updated_time=date('Y-m-d H:i:s');
            $model->updated_ip = \Yii::$app->getRequest()->getUserIP();

            $model->id_kejati = $session->get('kode_kejati');
            $model->id_kejari = $session->get('kode_kejari');
            $model->id_cabjari = $session->get('kode_cabjari');

            if(isset($_POST['PdmT6']['file_upload'])){
                $model->file_upload = $_POST['PdmT6']['file_upload'];
                $model->uploaded_time = date('Y-m-d H:i:s');
            }

            $model->save();
            	
            PdmTembusanT6::deleteAll(['no_register_perkara' => $no_register_perkara,'no_surat_t6'=>$_POST['PdmT6']['no_surat_t6']]);
            if (isset($_POST['new_no_urut'])) {
                for ($i = 0; $i < count($_POST['new_no_urut']); $i++) {
                    $urut = $i+1;
                    $modelNewTembusan = new PdmTembusanT6();
                    $modelNewTembusan->no_register_perkara = $no_register_perkara;
                    $modelNewTembusan->no_surat_t6  = $_POST['PdmT6']['no_surat_t6'];
                    $modelNewTembusan->no_urut      = $urut;
                    $modelNewTembusan->tembusan     = $_POST['new_tembusan'][$i];
                    if(!$modelNewTembusan->save()){
                        var_dump($modelNewTembusan->getErrors());echo "tembusan6";exit;
                    }
                    
                }
            }

            //if ($files != false) {
            //$path = \Yii::$app->params['uploadPath'].'ba11/'.$files->name;
            //$files->saveAs($path);
            //$model->upload_file->saveAs('/uploads/' . $model->upload_file->baseName . '.' . $model->upload_file->extension);
            //}
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
            
            return $this->redirect(['update', 'id' => $model->no_surat_t6]);
        } else {

            return $this->render('update', [
                        'model' => $model,
                        'no_register_perkara' => $no_register_perkara,
                        'sysMenu' => $sysMenu
            ]);
        }
    }

    /**
     * Deletes an existing PdmT6 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
        /*$transaction = Yii::$app->db->beginTransaction();
        try {
            $id_t6 = $_POST['hapusIndex'];

            $session = new Session();
            $id_perkara = $session->get('no_register_perkara');

            if($id_t6 === 'all') {
                PdmT6::updateAll(['flag'=>'3'],'id_perkara=:id_perkara',[':id_perkara'=>$id_perkara]);
            } else {
                for($i=0;$i<count($id_t6);$i++) {
                    $model = $this->findModel($id_t6[$i]);
                    $model->flag = '3';
                    $model->update(true);
                }
            }

            $transaction->commit();

            Yii::$app->getSession()->setFlash('success', [
                'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
                'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                'icon' => 'glyphicon glyphicon-ok-sign', //String
                'message' => 'Data Berhasil Dihapus', // String
                'title' => 'Hapus', //String
                'positonY' => 'top', //String // defaults to top, allows top or bottom
                'positonX' => 'center', //String // defaults to right, allows right, center, left
                'showProgressbar' => true,
            ]);

            return $this->redirect(['index']);
        } catch(Exception $e) {
            $transaction->rollBack();

            Yii::$app->getSession()->setFlash('success', [
                'type' => 'warning', //String, can only be set to danger, success, warning, info, and growl
                'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                'icon' => 'glyphicon glyphicon-ok-sign', //String
                'message' => 'Data Gagal Dihapus', // String
                'title' => 'Hapus', //String
                'positonY' => 'top', //String // defaults to top, allows top or bottom
                'positonX' => 'center', //String // defaults to right, allows right, center, left
                'showProgressbar' => true,
            ]);

            return $this->redirect(['index']);
        
        }*/

        $arr= array();
        $id_tahap = $_POST['hapusIndex'][0];
            if($id_tahap=='all'){
                    $id_tahapx=PdmT6::find()->select("no_register_perkara")->asArray()->all();
                    foreach ($id_tahapx as $key => $value) {
                        $arr[] = $value['no_register_perkara'];
                    }
                    $id_tahap=$arr;
            }else{
                $id_tahap = $_POST['hapusIndex'];
            }


        $count = 0;
           foreach($id_tahap AS $key_delete => $delete){
             try{
                    PdmT6::deleteAll(['no_register_perkara' => $delete]);
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
    
    public function actionCetak($id)
    {
        $session    = new session();
        $no_register_perkara = $session->get('no_register_perkara');
        $id_perkara = $session->get('id_perkara');
        $satker  = $session->get('inst_satkerkd');
        $t6 = PdmT6::findOne(['no_register_perkara'=>$no_register_perkara, 'no_surat_t6'=>$id]);
        $kd_tersangka = $t6['id_tersangka'];
        $spdp   = PdmSpdp::findOne(['id_perkara'=>$session->get('id_perkara')]);
        $ba4 = PdmBa4::findOne(['no_register_perkara'=>$no_register_perkara,'no_reg_tahanan'=>$kd_tersangka]);
        $no_urut = $ba4['no_urut_tersangka'];
        $t7 = PdmT7::findOne(['no_register_perkara'=>$no_register_perkara,'no_urut_tersangka'=>$no_urut]);
        //$t4 = PdmT4::findOne(['id_perkara'=>$id_perkara]);
        //echo '<pre>';print_r($t7);exit;


        
        $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_uu_pasal_tahap2')
                ->where("no_register_perkara='" . $no_register_perkara . "'");
        $data = $query->createCommand();
        $listPasal = $data->queryAll();



        $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_tembusan_t6')
                ->where("no_register_perkara='" . $no_register_perkara . "' and no_surat_t6 ='".$t6->no_surat_t6."' ");
        $data = $query->createCommand();
        $listTembusan = $data->queryAll();
        //echo '<pre>';print_r($listPasal);exit;
        return $this->render('cetak',['session'=>$_SESSION, 't7'=>$t7, 'ba4'=>$ba4, 't6'=>$t6, 'spdp'=>$spdp, 'listPasal'=>$listPasal, 'listTembusan'=>$listTembusan ]);
      /*  $connection = \Yii::$app->db;

        $odf = new Odf(Yii::$app->params['report-path']."modules/pdsold/template/t6.odt");
        
        $pdmT6 = PdmT6::findOne(['id_t6' => $id]);
        $spdp = PdmSpdp::findOne(['id_perkara' => $pdmT6->id_perkara]);
        $tahananPenyidik = PdmTahananPenyidik::findOne(['id_perkara' => $pdmT6->id_perkara, 'id_tersangka' => $pdmT6->id_tersangka]);
        
        $sqlPerpanjangan = "SELECT *
                        FROM pidum.pdm_perpanjangan_tahanan a
                        RIGHT JOIN(
                        select id_perkara, max(tgl_terima) max_tgl
                        from pidum.pdm_perpanjangan_tahanan
                        group by id_perkara)tgl_max ON ( tgl_max.id_perkara = a.id_perkara AND tgl_max.max_tgl = a.tgl_terima)
                        WHERE a.id_perkara='".$pdmT6->id_perkara."'";
        
        $perpanjanganTahanan = $connection->createCommand($sqlPerpanjangan)->queryOne();
        $pdmT4 = PdmT4::findOne(['id_perkara'=>$pdmT6->id_perkara,'id_tersangka'=>$pdmT6->id_tersangka]);
        $pangkat = PdmPenandatangan::find()
->select ("a.jabatan as jabatan")
->from ("pidum.pdm_penandatangan a")
->join ('inner join','pidum.pdm_t6 b','a.peg_nik = b.id_penandatangan')
->where ("id_t6='".$id."'")
->one();
        $odf->setVars('kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
        $odf->setVars('kepala', $pangkat->jabatan);
        $odf->setVars('dikeluarkan', $pdmT6->dikeluarkan);
        $odf->setVars('tgl_dikeluarkan', Yii::$app->globalfunc->ViewIndonesianFormat($pdmT6->tgl_dikeluarkan));
        $odf->setVars('nomor', $pdmT6->no_surat);
        $sifat = \app\models\MsSifatSurat::findOne(['id' => $pdmT6->sifat]);
        $odf->setVars('sifat', $sifat->nama);
        $odf->setVars('lampiran', $pdmT6->lampiran);
        $odf->setVars('kepada', $pdmT6->kepada);
        $odf->setVars('ditempat', $pdmT6->di_kepada);
        $odf->setVars('surat_dari', $spdp->idPenyidik->nama);
               
        $odf->setVars('nomor_penahanan', is_null($perpanjanganTahanan['no_surat'])?'-':$perpanjanganTahanan['no_surat']);
        $odf->setVars('tanggal_penahanan', Yii::$app->globalfunc->ViewIndonesianFormat($perpanjanganTahanan['tgl_surat']));
        $odf->setVars('kejaksaan_perpanjangan', $pdmT4->dikeluarkan);
        $odf->setVars('nomor_perpanjangan', is_null($pdmT4->no_surat)?'-':$pdmT4->no_surat );
        $odf->setVars('tanggal_perpanjangan', is_null($pdmT4->tgl_dikeluarkan)?'-':$pdmT4->tgl_dikeluarkan);
        $Terdakwa = \app\modules\pidum\models\VwTerdakwa::findOne(['id_tersangka'=>$pdmT6->id_tersangka]);
        $odf->setVars('nama_perpanjangan', ucfirst(strtolower($Terdakwa->nama)));
        $hariSelesai = Yii::$app->globalfunc->GetNamaHari($pdmT4->tgl_selesai);
        $odf->setVars('berakhir_pada_perpanjangan', is_null($hariSelesai)?'-':$hariSelesai);
        $tgl_selesai = Yii::$app->globalfunc->ViewIndonesianFormat($pdmT4->tgl_selesai);
        $odf->setVars('tanggal_berakhir', $tgl_selesai);
        $odf->setVars('alasan', $pdmT6->alasan);
        
        
        $odf->setVars('tanggal_mulai', Yii::$app->globalfunc->ViewIndonesianFormat($pdmT6->tgl_mulai));
        $odf->setVars('tanggal_selesai', Yii::$app->globalfunc->ViewIndonesianFormat($pdmT6->tgl_selesai));
        $odf->setVars('karena', $pdmT6->karena);
        $pasal = Yii::$app->globalfunc->getDaftarPasal($pdmT6->id_perkara);
        $odf->setVars('pasal', $pasal);
        //tembusan
        $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_tembusan')
                ->where("id_perkara='".$pdmT6->id_perkara."' AND kode_table='".GlobalConstMenuComponent::T6."'")
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
        
        #penanda tangan
        $sql ="SELECT a.nama,a.pangkat,a.jabatan,c.peg_nip_baru FROM "
                . " pidum.pdm_penandatangan a, pidum.pdm_t6 b , kepegawaian.kp_pegawai c "
                . "where a.peg_nik = b.id_penandatangan and b.id_penandatangan =c.peg_nik and b.id_perkara='".$pdmT6->id_perkara."'";
        $model = $connection->createCommand($sql);
		$penandatangan = $model->queryOne();
        $odf->setVars('nama_penandatangan', $penandatangan['nama']);   
		$pangkat =explode('/',$penandatangan['pangkat']);
        $odf->setVars('pangkat', $pangkat[0]);       
        $odf->setVars('nip_penandatangan', $penandatangan['peg_nip_baru']);      
        
        $odf->exportAsAttachedFile('T6.odf');*/
    }

    /**
     * Finds the PdmT6 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmT6 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        /*if (($model = PdmT6::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }*/
		if (($model = PdmT6::findOne(['id_perkara' => $id])) !== null) {
            return $model;
        }
    }
}
