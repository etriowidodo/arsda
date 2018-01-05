<?php

namespace app\modules\pidum\controllers;

use app\components\GlobalConstMenuComponent;
use app\models\KpInstSatker;
use app\models\KpPegawaiSearch;
use app\modules\pidum\models\PdmBa11;
use app\modules\pidum\models\MsLoktahanan;
use app\modules\pidum\models\PdmPasal;
use app\modules\pidum\models\PdmBA11Search;
use app\modules\pidum\models\PdmJaksaSaksi;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmSysMenu;
use app\modules\pidum\models\VwJaksaPenuntutSearch;
use app\modules\pidum\models\VwTerdakwa;
use app\modules\pidum\models\PdmRp9;
use app\modules\pidum\models\PdmRt3;
use Odf;
use Yii;
use app\models\KpPegawai;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;
use yii\web\UploadedFile;

/**
 * PdmBA11Controller implements the CRUD actions for PdmBA11 model.
 */
class PdmBa11Controller extends Controller {

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
     * Lists all PdmBA11 models.
     * @return mixed
     */
    public function actionIndex()
      {
         $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA11]);
         
        $searchModel = new PdmBA11Search();
        $id_perkara = Yii::$app->session->get('id_perkara');
        $dataProvider = $searchModel->search($id_perkara, Yii::$app->request->queryParams);

        return $this->render('index', [
                    'sysMenu' => $sysMenu,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PdmBA11 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmBA11 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA11]);
        $session = new Session();

        $id = $session->get('id_perkara');
         $model = new PdmBa11();
        
        $modeljaksi = new PdmJaksaSaksi();
        $kepalajaksal = KpInstSatker::findOne(['inst_satkerkd' => $model->asal_satker])->inst_nama;
        
        $modelRp9 = PdmRp9::findOne(['id_perkara' => $model->id_perkara]);
        $modelRt3 = PdmRt3::findOne(['id_perkara' => $model->id_perkara, 'id_tersangka' => $model->id_tersangka]);
        
	$searchJPU = new VwJaksaPenuntutSearch();
        $dataJPU = $searchJPU->search2(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;

        $searchSatker = new PdmBA11Search();
        $dataSatker = $searchSatker->searchsatker(Yii::$app->request->queryParams);
        $dataSatker->pagination->pageSize = 5;
        $oldFileName = $model->uploaded_file;
        $oldFile = (isset($model->uploaded_file) ? Yii::$app->basePath . '/web/image/upload_file/ba11/' . $model->uploaded_file : null);



        if ($model->load(Yii::$app->request->post())) {
            $files = UploadedFile::getInstance($model, 'uploaded_file');
            $model->uploaded_file = $files->name;


            $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_ba11', 'id_ba11', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
            $model->id_perkara = $id;
            $model->id_ba11 = $seq['generate_pk'];
               if ($model->save()) {
                    if ($files != false) {
                        $path = Yii::$app->basePath . '/web/image/upload_file/ba11/' . $files->name;
                        $files->saveAs($path);
                    }
    
                }
           
        if ($modeljaksi->code_table == null) {
       	$modeljaksi1 = new PdmJaksaSaksi();
            $seqjpp = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_jaksa_saksi', 'id_jpp', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
            
            $modeljaksi1->id_jpp = $seqjpp['generate_pk'];
            $modeljaksi1->id_perkara = $id;
            $modeljaksi1->code_table = GlobalConstMenuComponent::BA11;
            $modeljaksi1->id_table = $model->id_ba11;
            $modeljaksi1->flag = '1';
            $modeljaksi1->nama = $_POST['PdmJaksaSaksi']['nama'];
            $modeljaksi1->nip = $_POST['PdmJaksaSaksi']['nip'];
            $modeljaksi1->jabatan = $_POST['PdmJaksaSaksi']['jabatan'];
            $modeljaksi1->pangkat = $_POST['PdmJaksaSaksi']['pangkat'];
            $modeljaksi1->save();
        }else{
        	$modeljaksi->nama = $_POST['PdmJaksaSaksi']['nama'];
        	$modeljaksi->nip = $_POST['PdmJaksaSaksi']['nip'];
        	$modeljaksi->jabatan = $_POST['PdmJaksaSaksi']['jabatan'];
        	$modeljaksi->pangkat = $_POST['PdmJaksaSaksi']['pangkat'];
        	$modeljaksi->update();
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
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'id' => $id,
                        'searchJPU' => $searchJPU,
                        'dataJPU' => $dataJPU,
                        'searchSatker' => $searchSatker,
                        'dataSatker' => $dataSatker,
                        'modeljaksi' => $modeljaksi,
                        'kepalajaksal' => $kepalajaksal,
                        'sysMenu' => $sysMenu,
                'modelRp9'=>$modelRp9,
                'modelRt3'=>$modelRt3,
                                ]);
        }
   
    }
    

    /**
     * Updates an existing PdmBA11 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdatedata($id) {


        $session = new Session();
        $session->destroySession('id_penuntutan');
        $session->set('id_penuntutan', $id);
        return $this->redirect('update');
    }

    public function actionUpdate($id_ba11) {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA11]);
        $session = new Session();

        $id = $session->get('id_perkara');
        $model = PdmBa11::findOne(['id_ba11'=>$id_ba11]);
              
        $modeljaksi = PdmJaksaSaksi::findOne(['id_perkara' => $model->id_perkara, 'id_table' => $model->id_ba11, 'code_table' => GlobalConstMenuComponent::BA11]);
        $kepalajaksal = KpInstSatker::findOne(['inst_satkerkd' => $model->asal_satker])->inst_nama;
		
        if ($model == null) {
            $model = new PdmBa11();
        }
     
        if ($modeljaksi == null) {
            $modeljaksi = new PdmJaksaSaksi();
        }

        $searchJPU = new VwJaksaPenuntutSearch();
        $dataJPU = $searchJPU->search2(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;

        $modelRp9 = PdmRp9::findOne(['id_perkara' => $model->id_perkara]);
        $modelRt3 = PdmRt3::findOne(['id_perkara' => $model->id_perkara, 'id_tersangka' => $model->id_tersangka]);
        
        $searchSatker = new PdmBA11Search();
        $dataSatker = $searchSatker->searchsatker(Yii::$app->request->queryParams);
        $dataSatker->pagination->pageSize = 5;
        $oldFileName = $model->uploaded_file;
        $oldFile = (isset($model->uploaded_file) ? Yii::$app->basePath . '/web/image/upload_file/ba11/' . $model->uploaded_file : null);

        if ($model->load(Yii::$app->request->post())) {

            $files = UploadedFile::getInstance($model, 'uploaded_file');
            $model->uploaded_file = $files->name;

            $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_ba11', 'id_ba11', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
            if ($model->id_perkara != null) {
                
                $model->update();
                $files = UploadedFile::getInstance($model, 'uploaded_file');
                $model->flag = '2';
                if ($model->update()) {
                    if ($files == false) {

                        $model->uploaded_file = $oldFileName;
                    } else {

                        $model->uploaded_file = $files->name;
                    }
                    if ($files != false && !empty($oldFileName)) { // delete old and overwrite
                        unlink($oldFile);
                    }

                   $path = Yii::$app->basePath . '/web/image/upload_file/ba11/' . $files->name;
          
                }
            } else {
                $model->id_perkara = $id;
                $model->id_ba11 = $seq['generate_pk'];
                if ($model->save()) {
                    if ($files != false) {
                        $path = Yii::$app->basePath . '/web/image/upload_file/ba11/' . $files->name;
                        $files->saveAs($path);
                    }
                }
            }
           
        if ($modeljaksi->code_table == null) {
        	$modeljaksi1 = new PdmJaksaSaksi();
            $seqjpp = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_jaksa_saksi', 'id_jpp', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
            
            $modeljaksi1->id_jpp = $seqjpp['generate_pk'];
            $modeljaksi1->id_perkara = $id;
            $modeljaksi1->code_table = GlobalConstMenuComponent::BA11;
            $modeljaksi1->id_table = $model->id_ba11;
            $modeljaksi1->flag = '1';
            $modeljaksi1->nama = $_POST['PdmJaksaSaksi']['nama'];
            $modeljaksi1->nip = $_POST['PdmJaksaSaksi']['nip'];
            $modeljaksi1->jabatan = $_POST['PdmJaksaSaksi']['jabatan'];
            $modeljaksi1->pangkat = $_POST['PdmJaksaSaksi']['pangkat'];
            $modeljaksi1->save();
        }else{
        	$modeljaksi->nama = $_POST['PdmJaksaSaksi']['nama'];
        	$modeljaksi->nip = $_POST['PdmJaksaSaksi']['nip'];
        	$modeljaksi->jabatan = $_POST['PdmJaksaSaksi']['jabatan'];
        	$modeljaksi->pangkat = $_POST['PdmJaksaSaksi']['pangkat'];
        	$modeljaksi->update();
        }
        
//notifikasi simpan
		Yii::$app->getSession()->setFlash('success', [
                'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
                'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                'icon' => 'glyphicon glyphicon-ok-sign', //String
                'message' => 'Data Berhasil Disimpan', // String
                'title' => 'Save', //String
                'positonY' => 'top', //String // defaults to top, allows top or bottom
                'positonX' => 'center', //String // defaults to right, allows right, center, left
                'showProgressbar' => true,
            ]);
            return $this->redirect(['update', 'id_ba11' => $model->id_ba11]);
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'id' => $id,
                        'searchJPU' => $searchJPU,
                        'dataJPU' => $dataJPU,
                        'searchSatker' => $searchSatker,
                        'dataSatker' => $dataSatker,
                        'modeljaksi' => $modeljaksi,
                        'kepalajaksal' => $kepalajaksal,
                        'sysMenu' => $sysMenu,
                        'modelRp9'=>$modelRp9,
                        'modelRt3'=>$modelRt3,
                                ]);
        }
    }

    /**
     * Deletes an existing PdmBA11 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
        try{
            $id = $_POST['hapusIndex'];

            if($id == "all"){
                $session = new Session();
                $id_perkara = $session->get('id_perkara');

                PdmBa11::updateAll(['flag' => '3'], "id_perkara = '" . $id_perkara . "'");
            }else{
                for($i=0;$i<count($id);$i++){
                   PdmBa11::updateAll(['flag' => '3'], "id_ba11 = '" . $id[$i] . "'");
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
        }catch (Exception $e){
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
     * Finds the PdmBA11 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmBA11 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PdmBa11::findOne(['id_ba11' => $id])) !== null) {
            return $model;
      }
    }

    public function actionJpu() {
        $searchModel = new KpPegawaiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;
        return $this->renderAjax('_jpu', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCetak($id_ba11) 
            {
        $odf = new Odf(Yii::$app->params['report-path'] . "modules/pidum/template/ba11.odt");
        
        $pdmBa11 = PdmBa11::findOne(['id_ba11' => $id_ba11]);
        $spdp = PdmSpdp::findOne(['id_perkara' =>$pdmBa11->id_perkara]);
        $tahanan1 =  MsLoktahanan::findOne(['id_loktahanan'=> $pdmBa11->tahanan]);
        $tahanan2 =  MsLoktahanan::findOne(['id_loktahanan'=> $pdmBa11->ke_tahanan]);
        $pasal = PdmPasal::findOne(['id_perkara'=>$pdmBa11->id_perkara]);

        $jaksa = PdmJaksaSaksi::findOne(['id_table' => $pdmBa11->id_ba11, 'code_table' => GlobalConstMenuComponent::BA11]);
		$modelPegawai = KpPegawai::findOne(['peg_nik' => $jaksa->nip]);

        $terdakwa = VwTerdakwa::findOne(['id_perkara' => $pdmBa11->id_perkara, 'id_tersangka' => $pdmBa11->id_tersangka]);

        $odf->setVars('kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
        $odf->setVars('hari', Yii::$app->globalfunc->getNamaHari($pdmBa11->tgl_surat));
        $odf->setVars('tanggal', Yii::$app->globalfunc->ViewIndonesianFormat($pdmBa11->tgl_surat));
        $odf->setVars('tahun', date('Y', strtotime($pdmBa11->tgl_surat)));
        
	$pangkat = explode ('/',$jaksa->pangkat );
        $odf->setVars('nama_jaksa', $jaksa->nama);
        $odf->setVars('nip_jaksa', $modelPegawai->peg_nip_baru);
        $odf->setVars('pangkat_jaksa', $pangkat[0]);

        //terdakwa
        $odf->setVars('nama', ucfirst(strtolower($terdakwa->nama)));
        $odf->setVars('tempat_lahir', ucfirst(strtolower($terdakwa->tmpt_lahir)));
        $umur = Yii::$app->globalfunc->datediff($terdakwa->tgl_lahir, date("Y-m-d"));
        $odf->setVars('tanggal_lahir', $umur['years'] . ' tahun / ' . Yii::$app->globalfunc->ViewIndonesianFormat($terdakwa->tgl_lahir));
        $odf->setVars('jenis_kelamin', ucfirst(strtolower($terdakwa->is_jkl)));
        $odf->setVars('kebangsaan', ucfirst(strtolower($terdakwa->warganegara)));
        $odf->setVars('tempat_tinggal', ucfirst(strtolower($terdakwa->alamat)));
        $odf->setVars('agama', ucfirst(strtolower($terdakwa->is_agama)));
        $odf->setVars('pekerjaan', ucfirst(strtolower($terdakwa->pekerjaan)));
        $odf->setVars('pendidikan', $terdakwa->is_pendidikan);

        $odf->setVars('reg_nomor', $pdmBa11->reg_nomor);
        $odf->setVars('reg_perkara', $pdmBa11->reg_perkara);

        $odf->setVars('nama_penandatangan', $jaksa->nama);
        $odf->setVars('pangkat',  $pangkat[0]);
        $odf->setVars('nip_penandatangan', $modelPegawai->peg_nip_baru);
        $odf->setVars('kepala_rutan', $pdmBa11->kepala_rutan);

        $odf->setVars('nomor', '-');
        $odf->setVars('dari_penahanan', $tahanan1->nama);
        $odf->setVars('penahanan', $tahanan2->nama);
        $odf->setVars('pasal', $pasal->pasal);
        
        $odf->exportAsAttachedFile();
    }

}
