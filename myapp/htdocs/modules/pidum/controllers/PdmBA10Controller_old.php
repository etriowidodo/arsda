<?php

namespace app\modules\pidum\controllers;

use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\VwTersangka;
use app\modules\pidum\models\PdmBa10;
use app\modules\pidum\models\pdmba10Search;
use app\modules\pidum\models\PdmJaksaSaksi;
use app\modules\pidum\models\PdmPasal;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmRp9;
use app\modules\pidum\models\PdmRt3;
use app\modules\pidum\models\VwTerdakwa;
use app\models\KpPegawai;

use Yii;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
use app\modules\pidum\models\PdmT7;
use app\modules\pidum\models\PdmT7Search;
use app\modules\pidum\models\PdmSysMenu;


/**
 * PdmBA10Controller implements the CRUD actions for PdmBA10 model.
 */
class PdmBa10Controller extends Controller {

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
     * Lists all PdmBA10 models.
     * @return mixed
     */
    public function actionIndex() 
    {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA10]);
        
        $searchModel = new pdmba10Search();
        $id_perkara = Yii::$app->session->get('id_perkara');
        $dataProvider = $searchModel->search($id_perkara, Yii::$app->request->queryParams);

        return $this->render('index', [
                    'sysMenu' => $sysMenu,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PdmBA10 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmBA10 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA10 ]); 
        $model = new PdmBa10();
        $id_perkara = Yii::$app->session->get('id_perkara');

        $modelT7 = PdmT7::find()
                        ->where('id_perkara=:id_perkara AND flag IS NOT NULL', 
                            [':id_perkara' => $id_perkara])
                        ->one();

		if ($modelT7 == null) {
            $modelT7 = new PdmT7();
        }

        $modelTerdakwa = VwTersangka::findAll(['id_perkara' => $id_perkara]);

        if ($model->load(Yii::$app->request->post())) {
            $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_ba10', 'id_ba10', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();

            $model->flag='1';
            $model->id_perkara = $id_perkara;
            $model->id_t7 = $modelT7->id_t7;
            $model->id_ba10 = $seq['generate_pk'];

            $model->save();

            //set auto increment on PdmRt3
            Yii::$app->globalfunc->autoIncrementRt3($model);

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
                'modelT7' => $modelT7,
                'sysMenu' => $sysMenu,
                'modelTerdakwa' => $modelTerdakwa
            ]);
        }
    }

    /**
     * Updates an existing PdmBA10 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
  

    public function actionUpdate($id_ba10) 
            {
        
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA10 ]);
        $session = new Session();
        
        $model = PdmBa10::findOne(['id_ba10'=>$id_ba10]);
        $modelT7 = PdmT7::findOne(['id_perkara' => $model->id_perkara]);
		
	if ($modelT7 == null) {
            $modelT7 = new PdmT7();
        }
        $modelTerdakwa = MsTersangka::findAll(['id_perkara' => $model->id_perkara]);
        if ($model->load(Yii::$app->request->post())) {
            $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_ba10', 'id_ba10', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
         
            if ($model->id_perkara != null) {
                $model->flag='2';
                $model->update();
            } else {
                $model->id_perkara = $id;
                $model->id_ba10 = $seq['generate_pk'];

                $model->save();
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
            return $this->redirect(['update', 'id_ba10' => $model->id_ba10]);
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'id' => $id,
                        'modelT7' => $modelT7,
                        'sysMenu' => $sysMenu,
                        'modelTerdakwa' => $modelTerdakwa
            ]);
        }
    }

    /**
     * Deletes an existing PdmBA10 model.
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

                PdmBa10::updateAll(['flag' => '3'], "id_perkara = '" . $id_perkara . "'");
            }else{
                for($i=0;$i<count($id);$i++){
                   PdmBa10::updateAll(['flag' => '3'], "id_ba10 = '" . $id[$i] . "'");
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

    public function actionDataTersangka(){

        $id_tersangka = $_POST['id_tersangka'];
        if (empty($id_tersangka)) {
            $arr = array("status"=>0);
            echo json_encode($arr);
            exit();
        }else{
            $id_perkara = Yii::$app->session->get('id_perkara');
            $queryT7 = new Query();
            $modelT7 = $queryT7->select('a.lama, a.tgl_mulai, a.tgl_selesai, b.nama as jenis_penahanan, c.nama as tahanan')
                ->from('pidum.pdm_t7 a')
                ->innerJoin('pidum.pdm_ms_tindakan_status b on (a.tindakan_status=b.id)')
                ->innerJoin('pidum.ms_loktahanan c on (a.id_ms_loktahanan=c.id_loktahanan)')
                ->where(['a.id_perkara' => $id_perkara, 'a.id_tersangka' => $id_tersangka])->andWhere(['<>', 'a.flag', '3'])->one();
				
            if (empty($modelT7)) {
                $arr = array("status"=>0);
                echo json_encode($arr);
                exit();
            }else{
                echo json_encode($modelT7);
                exit();
            }
        }
    }

    public function actionCetak($id_ba10)
    {
        $odf = new \Odf(Yii::$app->params['report-path']."modules/pidum/template/ba10.odt");
        $pdmBa10 = PdmBa10::findOne(['id_ba10' => $id_ba10]);
        
        $spdp = PdmSpdp::findOne(['id_perkara' => $pdmBa10->id_perkara]);
        $terdakwa = VwTerdakwa::findOne(['id_perkara' => $pdmBa10->id_perkara, 'id_tersangka' => $pdmBa10->id_tersangka]);
       
        $pdmt7 = PdmT7::findOne(['id_perkara' =>$pdmBa10->id_perkara]);
        
        $perkara = PdmRp9::findOne(['id_perkara'=>$pdmBa10->id_perkara]);
        $tahanan = PdmRt3::findOne(['id_perkara'=>$pdmBa10->id_perkara]);
        
      
        $penandaTangan = PdmJaksaSaksi::findOne(['id_perkara' => $pdmBa10->id_perkara, 'code_table' => GlobalConstMenuComponent::T7]);
        $modelPegawai = KpPegawai::findOne(['peg_nik' =>$penandaTangan->nip]);	
        $pdmPasal = PdmPasal::findAll(['id_perkara' => $pdmBa10->id_perkara]);

        foreach ($pdmPasal as $row) {
            $pasal .= $row->pasal . ' ' . $row->undang . ', ';
        }
        $pasal = preg_replace('/, $/', "", $pasal);

        $odf->setVars('Kejaksaan', Yii::$app->globalfunc->getSatker($spdp->wilayah_kerja)->inst_nama);
        $odf->setVars('Kejaksaan_lower', ucwords(strtolower(Yii::$app->globalfunc->setKepalaReport($spdp->wilayah_kerja))));     
        $odf->setVars('hari', Yii::$app->globalfunc->getNamaHari($pdmBa10->tgl_surat));
        $odf->setVars('tanggal', Yii::$app->globalfunc->ViewIndonesianFormat($pdmBa10->tgl_surat));
        $odf->setVars('nomor', $pdmt7->no_surat);
        
        $odf->setVars('tgl_BeritaAcara', Yii::$app->globalfunc->getTanggalBeritaAcara($pdmBa10->tgl_surat));

        //terdakwa
        $odf->setVars('nama', ucfirst(strtolower($terdakwa->nama)));
        $odf->setVars('tempat_lahir', ucfirst(strtolower($terdakwa->tmpt_lahir)));
        $umur = Yii::$app->globalfunc->datediff($terdakwa->tgl_lahir,date("Y-m-d"));
        $odf->setVars('tanggal_lahir', $umur['years'].' tahun / '.Yii::$app->globalfunc->ViewIndonesianFormat($terdakwa->tgl_lahir));
        $odf->setVars('jenis_kelamin', ucfirst(strtolower($terdakwa->is_jkl)));
        $odf->setVars('kebangsaan', ucfirst(strtolower($terdakwa->warganegara)));
        $odf->setVars('tempat_tinggal', ucfirst(strtolower($terdakwa->alamat)));
        $odf->setVars('agama', ucfirst(strtolower($terdakwa->is_agama)));
        $odf->setVars('pekerjaan', ucfirst(strtolower($terdakwa->pekerjaan)));
        $odf->setVars('pendidikan', $terdakwa->is_pendidikan);

        $odf->setVars('reg_tahanan', $tahanan->no_urut);
        $odf->setVars('reg_perkara', $perkara->no_urut);

        $odf->setVars('jenis_penahanan', $pdmt7->tindakanStatus->nama);
        $odf->setVars('tanggal_mulai', Yii::$app->globalfunc->ViewIndonesianFormat($pdmt7->tgl_mulai));
        $odf->setVars('pasal', $pasal);


        $odf->setVars('selama', $pdmt7->lama.' Hari');
        $odf->setVars('tahanan', $pdmt7->lokTahanan->nama);

        $odf->setVars('tersangka', $terdakwa->nama);
        $odf->setVars('kepala_rutan', $pdmBa10->kepala_rutan);
        
        # Penandatangan
        $pangkat = explode ('/',$penandaTangan->pangkat );
        $odf->setVars('nama_penandatangan', $penandaTangan->nama);
        $odf->setVars('nip_penandatangan', $penandaTangan->peg_nip_baru);
        $odf->setVars('pangkat', $pangkat[0]);

        $odf->exportAsAttachedFile('ba10.odt');

    }

    /**
     * Finds the PdmBA10 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmBA10 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PdmBA10::findOne(['id_perkara' => $id])) !== null) {
            return $model;
        }
    }

}
