<?php

namespace app\modules\pidum\controllers;

use Yii;
use app\modules\pidum\models\PdmBa2;
use app\modules\pidum\models\PdmBa2Search;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\MsTersangka;
use app\models\MsPendidikan;
use app\models\MsJkl;
use app\models\MsAgama;
use app\models\MsWarganegara;

use app\modules\pidum\models\PdmMsSaksiAhli;

use app\modules\pidum\models\VwJaksaPenuntutSearch;
use app\modules\pidum\models\PdmJaksaSaksi;
use app\modules\pidum\models\PdmJaksaPenerima;
use app\modules\pidum\models\PdmJpu;
use app\components\GlobalConstMenuComponent;
use yii\db\Query;
use app\modules\pidum\models\PdmTrxPemrosesan;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
use app\modules\pidum\models\PdmSysMenu;
/**
 * PdmBa2Controller implements the CRUD actions for PdmBa2 model.
 */
class PdmBa2Controller extends Controller
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
     * Lists all PdmBa2 models.
     * @return mixed
     */
    public function actionIndex()
    {
        $session = new Session();
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA2]);
        $id_perkara = $session->get('id_perkara');
        $searchModel = new PdmBa2Search();
        $dataProvider = $searchModel->search($id_perkara,Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'sysMenu' =>$sysMenu
        ]);
    }

    /**
     * Displays a single PdmBa2 model.
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
     * Creates a new PdmBa2 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA2]);
        $session = new Session();
        $id_perkara = $session->get('id_perkara');
        $model = new PdmBA2();
        $modelMsSaksi = new PdmMsSaksiAhli();

        $modelTersangka = $this->findModelTersangka($id_perkara);
        $modelSpdp = $this->findModelSpdp($id_perkara);
        $modelpenyidik = PdmJaksaPenerima::findAll(['id_perkara' => $model->id_perkara, 'code_table' => GlobalConstMenuComponent::BA2, 'id_table' => $model->id_ba2]);
        if ($modelpenyidik == null) {
            $modelpenyidik = new PdmJaksaPenerima();
        }
        $modeljaksi = PdmJaksaSaksi::findAll(['id_perkara' => $model->id_perkara, 'code_table' => GlobalConstMenuComponent::BA2, 'id_table' => $model->id_ba2]);

        if ($modeljaksi == null) {
            $modeljaksi = new PdmJaksaSaksi();
        }
        $searchJPU = new VwJaksaPenuntutSearch();
        $dataJPU = $searchJPU->search2(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;

        $modelMsSaksi = PdmMsSaksiAhli::findOne(['id_saksi_ahli' => $model->id_ms_saksi_ahli]);
        if ($modelMsSaksi == null) {
            $modelMsSaksi = new PdmMsSaksiAhli();
        }
        /* print_r($modelMsSaksi);
          exit; */

        if ($model->load(Yii::$app->request->post())) {

            $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_ba2', 'id_ba2', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();

            if ($modelMsSaksi->id_saksi_ahli == null) {
                $id_perkara_MsSaksiAhli = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_ms_saksi_ahli', 'id_saksi_ahli', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                $modelMsSaksi = new PdmMsSaksiAhli();
                $modelMsSaksi->id_saksi_ahli = $id_perkara_MsSaksiAhli['generate_pk'];
                $modelMsSaksi->nama = $_POST['PdmMsSaksiAhli']['nama'];
                $modelMsSaksi->tmpt_lahir = $_POST['PdmMsSaksiAhli']['tmpt_lahir'];
                $modelMsSaksi->tgl_lahir = $_POST['PdmMsSaksiAhli']['tgl_lahir'];
                $modelMsSaksi->id_jkl = $_POST['PdmMsSaksiAhli']['id_jkl'];
                $modelMsSaksi->alamat = $_POST['PdmMsSaksiAhli']['alamat'];
                $modelMsSaksi->warganegara = $_POST['PdmMsSaksiAhli']['warganegara'];
                $modelMsSaksi->id_agama = $_POST['PdmMsSaksiAhli']['id_agama'];
                $modelMsSaksi->pekerjaan = $_POST['PdmMsSaksiAhli']['pekerjaan'];
                $modelMsSaksi->id_pendidikan = $_POST['PdmMsSaksiAhli']['id_pendidikan'];
                $modelMsSaksi->save();
            } else {
                $modelMsSaksi = PdmMsSaksiAhli::findOne(['id_saksi_ahli' => $model->id_ms_saksi_ahli]);
                $modelMsSaksi->flag = '2';
                $modelMsSaksi->nama = $_POST['PdmMsSaksiAhli']['nama'];
                $modelMsSaksi->tmpt_lahir = $_POST['PdmMsSaksiAhli']['tmpt_lahir'];
                $modelMsSaksi->tgl_lahir = $_POST['PdmMsSaksiAhli']['tgl_lahir'];
                $modelMsSaksi->id_jkl = $_POST['PdmMsSaksiAhli']['id_jkl'];
                $modelMsSaksi->alamat = $_POST['PdmMsSaksiAhli']['alamat'];
                $modelMsSaksi->warganegara = $_POST['PdmMsSaksiAhli']['warganegara'];
                $modelMsSaksi->id_agama = $_POST['PdmMsSaksiAhli']['id_agama'];
                $modelMsSaksi->pekerjaan = $_POST['PdmMsSaksiAhli']['pekerjaan'];
                $modelMsSaksi->id_pendidikan = $_POST['PdmMsSaksiAhli']['id_pendidikan'];
                $modelMsSaksi->update();
            }
            $model->id_perkara = $id_perkara;
            $model->id_ba2 = $seq['generate_pk'];
            $model->id_ms_saksi_ahli = $modelMsSaksi->id_saksi_ahli;
            $model->save();

            Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara, GlobalConstMenuComponent::BA2);


            //Jaksa Penyidik
            PdmJaksaPenerima::deleteAll(['id_perkara' => $model->id_perkara, 'code_table' => GlobalConstMenuComponent::BA2, 'id_table' => $model->id_ba2]);
            if (isset($_POST['nip'])) {
                foreach ($_POST['nip'] as $key) {
                    $query = new Query;
                    $query->select('*')
                            ->from('pidum.vw_jaksa_penuntut')
                            ->where("peg_instakhir='" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "' and peg_nik='" . $key . "'");
                    $command = $query->createCommand();
                    $data = $command->queryAll();
                    $seqjpp = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_jaksa_penerima', 'id_jpp', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();

                    $modelpenyidik = new PdmJaksaPenerima();
                    $modelpenyidik->id_jpp = $seqjpp['generate_pk'];
                    $modelpenyidik->id_perkara = $id_perkara;
                    $modelpenyidik->code_table = GlobalConstMenuComponent::BA2;
                    $modelpenyidik->id_table = $model->id_ba2;
                    $modelpenyidik->flag = '1';
                    $modelpenyidik->nama = $data[0]['peg_nama'];
                    $modelpenyidik->nip = $data[0]['peg_nip'];
                    $modelpenyidik->jabatan = $data[0]['jabatan'];
                    $modelpenyidik->pangkat = $data[0]['pangkat'];

                    $modelpenyidik->save();
                }
            }

            //Jaksa Saksi
            PdmJaksaSaksi::deleteAll(['id_perkara' => $model->id_perkara, 'code_table' => GlobalConstMenuComponent::BA2, 'id_table' => $model->id_ba2]);
            if (isset($_POST['txtnip'])) {
                foreach ($_POST['txtnip'] as $key) {
                    $query = new Query;
                    $query->select('*')
                            ->from('pidum.vw_jaksa_penuntut')
                            ->where("peg_instakhir='" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "' and peg_nik='" . $key . "'");
                    $command = $query->createCommand();
                    $data = $command->queryAll();
                    $seqjpp = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_jaksa_saksi', 'id_jpp', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();

                    $modeljaksi = new PdmJaksaSaksi();
                    $modeljaksi->id_jpp = $seqjpp['generate_pk'];
                    $modeljaksi->id_perkara = $id_perkara;
                    $modeljaksi->code_table = GlobalConstMenuComponent::BA2;
                    $modeljaksi->id_table = $model->id_ba2;
                    $modeljaksi->flag = '1';
                    $modeljaksi->nama = $data[0]['peg_nama'];
                    $modeljaksi->nip = $data[0]['peg_nip'];
                    $modeljaksi->jabatan = $data[0]['jabatan'];
                    $modeljaksi->pangkat = $data[0]['pangkat'];

                    $modeljaksi->save();
                }
            }


            //notifkasi simpan
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
            return $this->redirect('index');
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'searchJPU' => $searchJPU,
                        'dataJPU' => $dataJPU,
                        'modeljaksi' => $modeljaksi,
                        'modelpenyidik' => $modelpenyidik,
                        'modelTersangka' => $modelTersangka,
                        'modelSpdp' => $modelSpdp,
                        'modelMsSaksi' => $modelMsSaksi,
                        'sysMenu' => $sysMenu,
                        //	'searchTerdakwa' => $searchTerdakwa,
                        //	'dataTerdakwa' => $dataTerdakwa,
                        'id' => $model->id_ba2,
            ]);
        }
    }

    /**
     * Updates an existing PdmBa2 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
	 
	 
    public function actionUpdate($id_ba2)
    {

        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA2]);
        $session = new Session();
        $id_perkara = $session->get('id_perkara');
        
        if(!empty($id_ba2)){
             $model = $this->findModel($id_ba2);
        }
        if (empty($model->id_perkara)) {
            $this->redirect('/pidum/pdm-ba2/index');
        }
//       var_dump($model->id_perkara);exit;
        $modelMsSaksi = new PdmMsSaksiAhli();

        $modelTersangka = $this->findModelTersangka($model->id_perkara);
        $modelSpdp = $this->findModelSpdp($model->id_perkara);
        $modelpenyidik = PdmJaksaPenerima::findAll(['id_perkara' => $model->id_perkara, 'code_table' => GlobalConstMenuComponent::BA2, 'id_table' => $model->id_ba2]);
        $modeljaksi = PdmJaksaSaksi::findAll(['id_perkara' => $model->id_perkara, 'code_table' => GlobalConstMenuComponent::BA2, 'id_table' => $model->id_ba2]);

        $searchJPU = new VwJaksaPenuntutSearch();
        $dataJPU = $searchJPU->search2(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;

        $modelMsSaksi = PdmMsSaksiAhli::findOne(['id_saksi_ahli' => $model->id_ms_saksi_ahli]);


        if ($model->load(Yii::$app->request->post())) {

            
            if ($modelMsSaksi->id_saksi_ahli == null) {
                $id_perkara_MsSaksiAhli = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_ms_saksi_ahli', 'id_saksi_ahli', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                $modelMsSaksi = new PdmMsSaksiAhli();
                $modelMsSaksi->id_saksi_ahli = $id_perkara_MsSaksiAhli['generate_pk'];
                $modelMsSaksi->nama = $_POST['PdmMsSaksiAhli']['nama'];
                $modelMsSaksi->tmpt_lahir = $_POST['PdmMsSaksiAhli']['tmpt_lahir'];
                $modelMsSaksi->tgl_lahir = $_POST['PdmMsSaksiAhli']['tgl_lahir'];
                $modelMsSaksi->id_jkl = $_POST['PdmMsSaksiAhli']['id_jkl'];
                $modelMsSaksi->alamat = $_POST['PdmMsSaksiAhli']['alamat'];
                $modelMsSaksi->warganegara = $_POST['PdmMsSaksiAhli']['warganegara'];
                $modelMsSaksi->id_agama = $_POST['PdmMsSaksiAhli']['id_agama'];
                $modelMsSaksi->pekerjaan = $_POST['PdmMsSaksiAhli']['pekerjaan'];
                $modelMsSaksi->id_pendidikan = $_POST['PdmMsSaksiAhli']['id_pendidikan'];
                $modelMsSaksi->save();
            } else {
                $modelMsSaksi = PdmMsSaksiAhli::findOne(['id_saksi_ahli' => $model->id_ms_saksi_ahli]);
                $modelMsSaksi->flag = '2';
                $modelMsSaksi->nama = $_POST['PdmMsSaksiAhli']['nama'];
                $modelMsSaksi->tmpt_lahir = $_POST['PdmMsSaksiAhli']['tmpt_lahir'];
                $modelMsSaksi->tgl_lahir = $_POST['PdmMsSaksiAhli']['tgl_lahir'];
                $modelMsSaksi->id_jkl = $_POST['PdmMsSaksiAhli']['id_jkl'];
                $modelMsSaksi->alamat = $_POST['PdmMsSaksiAhli']['alamat'];
                $modelMsSaksi->warganegara = $_POST['PdmMsSaksiAhli']['warganegara'];
                $modelMsSaksi->id_agama = $_POST['PdmMsSaksiAhli']['id_agama'];
                $modelMsSaksi->pekerjaan = $_POST['PdmMsSaksiAhli']['pekerjaan'];
                $modelMsSaksi->id_pendidikan = $_POST['PdmMsSaksiAhli']['id_pendidikan'];
                $modelMsSaksi->update();
            }
//            $id_perkara_ba2 = Pdmba2::findOne(['id_ba2' => $model->id_ba2]);
            $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_ba2', 'id_ba2', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();

            if ($model->id_ba2 != null) {
                $model->lokasi = $_POST['PdmBa2']['lokasi'];
                $model->flag ='2';
                $model->update();
            } else {
                $model->id_perkara = $id_perkara;
                $model->id_ba2 = $seq['generate_pk'];
                $model->id_ms_saksi_ahli = $modelMsSaksi->id_saksi_ahli;
                $model->save();

                Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara, GlobalConstMenuComponent::BA2);
            }

            //Jaksa Penyidik
            PdmJaksaPenerima::deleteAll(['id_perkara' => $model->id_perkara, 'code_table' => GlobalConstMenuComponent::BA2, 'id_table' => $model->id_ba2]);
            if (isset($_POST['nip'])) {
                foreach ($_POST['nip'] as $key) {
                    $query = new Query;
                    $query->select('*')
                            ->from('pidum.vw_jaksa_penuntut')
                            ->where("peg_instakhir='" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "' and peg_nik='" . $key . "'");
                    $command = $query->createCommand();
                    $data = $command->queryAll();
                    $seqjpp = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_jaksa_saksi', 'id_jpp', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();

                    $modelpenyidik = new PdmJaksaPenerima();
                    $modelpenyidik->id_jpp = $seqjpp['generate_pk'];
                    $modelpenyidik->id_perkara = $id_perkara;
                    $modelpenyidik->code_table = GlobalConstMenuComponent::BA2;
                    $modelpenyidik->id_table = $model->id_ba2;
                    $modelpenyidik->flag = '1';
                    $modelpenyidik->nama = $data[0]['peg_nama'];
                    $modelpenyidik->nip = $data[0]['peg_nip'];
                    $modelpenyidik->jabatan = $data[0]['jabatan'];
                    $modelpenyidik->pangkat = $data[0]['pangkat'];

                    $modelpenyidik->save();
                }
            }

            //Jaksa Saksi
            PdmJaksaSaksi::deleteAll(['id_perkara' => $model->id_perkara, 'code_table' => GlobalConstMenuComponent::BA2, 'id_table' => $model->id_ba2]);
            if (isset($_POST['txtnip'])) {
                foreach ($_POST['txtnip'] as $key) {
                    $query = new Query;
                    $query->select('*')
                            ->from('pidum.vw_jaksa_penuntut')
                            ->where("peg_instakhir='" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "' and peg_nik='" . $key . "'");
                    $command = $query->createCommand();
                    $data = $command->queryAll();
                    $seqjpp = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_jaksa_saksi', 'id_jpp', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();

                    $modeljaksi = new PdmJaksaSaksi();
                    $modeljaksi->id_jpp = $seqjpp['generate_pk'];
                    $modeljaksi->id_perkara = $id_perkara;
                    $modeljaksi->code_table = GlobalConstMenuComponent::BA2;
                    $modeljaksi->id_table = $model->id_ba2;
                    $modeljaksi->flag = '1';
                    $modeljaksi->nama = $data[0]['peg_nama'];
                    $modeljaksi->nip = $data[0]['peg_nip'];
                    $modeljaksi->jabatan = $data[0]['jabatan'];
                    $modeljaksi->pangkat = $data[0]['pangkat'];

                    $modeljaksi->save();
                }
            }

            //notifkasi simpan
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

            
            return $this->redirect(['update', 'id_ba2' => $model->id_ba2]);
            
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'searchJPU' => $searchJPU,
                        'dataJPU' => $dataJPU,
                        'modeljaksi' => $modeljaksi,
                        'modelpenyidik' => $modelpenyidik,
                        'modelTersangka' => $modelTersangka,
                        'modelSpdp' => $modelSpdp,
                        'modelMsSaksi' => $modelMsSaksi,
                        'sysMenu' => $sysMenu,
                        //	'searchTerdakwa' => $searchTerdakwa,
                        //	'dataTerdakwa' => $dataTerdakwa,
                        'id' => $id_perkara,
            ]);
        }
    }

    /**
     * Deletes an existing PdmBa2 model.
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

                PdmBa2::updateAll(['flag' => '3'], "id_perkara = '" . $id_perkara . "'");
            }else{
                for($i=0;$i<count($id);$i++){
                    $model = $this->findModel($id[$i]);
                    $model->flag = '3';
                    $model->update();
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
     * Finds the PdmBa2 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmBa2 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmBa2::findOne(['id_ba2' => $id])) !== null) {
            return $model;
        } 
    }
	

	public function actionCetak ($id_perkara, $id_ba2)
	{
		
	    $connection = \Yii::$app->db;
        $odf = new \Odf(Yii::$app->params['report-path']."modules/pidum/template/ba2.odt");

        $spdp = PdmSpdp::findOne(['id_perkara' => $id_perkara]);
        $ba2 = PdmBA2::findOne(['id_perkara' => $id_perkara]);
		$tanggalSurat = Yii::$app->globalfunc->getTanggalBeritaAcara($ba2->tgl_pembuatan);
		
		
		$odf->setVars('Kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
		$odf->setVars('hari', strtolower(Yii::$app->globalfunc->GetNamaHari( $ba2->tgl_pembuatan)));
		$odf->setVars('tgl_pembuatan', $tanggalSurat);
        $odf->setVars('jam', $ba2->jam);
        $odf->setVars('lokasi', $ba2->lokasi);
		//$odf->setVars('pengambilan', $ba2->pengambilan);
		
		$jaksa_saksi=PdmJaksaSaksi::findOne(['id_perkara'=> $id_perkara]);
		$MSsaksiAhli=PdmMsSaksiAhli::findOne(['id_saksi_ahli'=>$ba2->id_ms_saksi_ahli]);
        $warganegara = $MSsaksiAhli->warganegara;
		$MsAgama=MsAgama::findOne(['id_agama'=> $MSsaksiAhli->id_agama]);
		$MsPendidikan=MsPendidikan::findOne(['id_pendidikan'=> $MSsaksiAhli->id_pendidikan]);
		$MsJkl=MsJkl::findOne(['id_jkl'=> $MSsaksiAhli->id_jkl]);
		$MsWarganegara=MsWarganegara::findOne(['id'=> intval($warganegara)]);
		// $odf->setVars('nama', $jaksa_saksi->nama);
		
		 if($MSsaksiAhli['tgl_lahir']){
        $umur = Yii::$app->globalfunc->datediff($MSsaksiAhli['tgl_lahir'],date("Y-m-d"));
        $tgl_lahir = $umur['years'].' tahun / '.Yii::$app->globalfunc->ViewIndonesianFormat($MSsaksiAhli['tgl_lahir']);  
        }else{
            $tgl_lahir = '-';
        }
				
		$odf->setVars('tgl_terima', Yii::$app->globalfunc->ViewIndonesianFormat( $spdp->tgl_terima));
		$odf->setVars('namaSaksi', $MSsaksiAhli->nama);
		$odf->setVars('tmpt_lahir', $MSsaksiAhli->tmpt_lahir);
		$odf->setVars('tgl_lahir',$tgl_lahir);
		$odf->setVars('jenis_kelamin', $MsJkl->nama);
		$odf->setVars('warganegara', $MsWarganegara->nama);
		$odf->setVars('tmpt_tinggal', $MSsaksiAhli->alamat);
		$odf->setVars('agama', $MsAgama->nama);
		$odf->setVars('pekerjaan', $MSsaksiAhli->pekerjaan);
		$odf->setVars('pendidikan', $MsPendidikan->nama);
		
		$odf->setVars('kepercayaan', $MsAgama->nama);
		$odf->setVars('kejaksaan', ucfirst(strtolower(Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama)));
		
		
		
		
		#Jaksa Penerima
		$query = new Query;
        $query->select('pegawai.peg_nip_baru,nama,pangkat,jabatan')
                ->from('pidum.pdm_jaksa_penerima, kepegawaian.kp_pegawai pegawai')
                ->where(" peg_nik=nip and id_perkara='".$id_perkara."' AND code_table='".GlobalConstMenuComponent::BA2."' LIMIT 1" );
        $dt_jaksaPenerima = $query->createCommand();
        $listjaksaPenerima = $dt_jaksaPenerima->queryAll();
        $dft_jaksaPenerima = $odf->setSegment('jaksaPenerima');
		$i=1;
        foreach($listjaksaPenerima as $element){
				$JaksaPenerima = $element[nama];
				$dft_jaksaPenerima->urutan('');
				$dft_jaksaPenerima->nama_pegawai($element['nama']);
                $dft_jaksaPenerima->pangkat($element['pangkat'].' / '.$element['peg_nip_baru']);
				$dft_jaksaPenerima->jabatan($element['jabatan']);
                $dft_jaksaPenerima->merge();
			$i++;
        }
        $odf->mergeSegment($dft_jaksaPenerima);  
		
		$odf->setVars('mengambil_sumpah', $JaksaPenerima);
		$odf->setVars('JaksaPenyidik', $JaksaPenerima);
	
			
	#JaksaSaksi
		$query = new Query;
        $query->select('pegawai.peg_nip_baru,peg_nama,pangkat,jabatan')
                ->from('pidum.pdm_jaksa_saksi jaksa_saksi, kepegawaian.kp_pegawai pegawai')
                ->where(" peg_nik=nip and id_perkara='".$id_perkara."' AND code_table='".GlobalConstMenuComponent::BA2."' AND id_table ='".$id_ba2."'" );
        $dt_jaksaSaksi = $query->createCommand();
        $listjaksaSaksi = $dt_jaksaSaksi->queryAll();
        $dft_jaksaSaksi = $odf->setSegment('jaksaSaksi');
		$i=1;
        foreach($listjaksaSaksi as $element){
				$dft_jaksaSaksi->urutan($i);
				$dft_jaksaSaksi->nama_pegawai($element['peg_nama']);
                $dft_jaksaSaksi->pangkat($element['pangkat'].' / '.$element['peg_nip_baru']);
                $dft_jaksaSaksi->jabatan($element['jabatan']);
                $dft_jaksaSaksi->merge();
			$i++;
        }
        $odf->mergeSegment($dft_jaksaSaksi);  
		  
		#list Tersangka
        $dft_tersangka ='';
        $query = new Query;
        $query->select('*')
                ->from('pidum.ms_tersangka')
                ->where("id_perkara='".$id_perkara."'");
        $data = $query->createCommand();
        $listTersangka = $data->queryAll();  
        foreach($listTersangka as $key){			
            $dft_tersangka .= $key[nama].',';
        }
        $odf->setVars('tersangka', $dft_tersangka);  
		
		$odf->exportAsAttachedFile('BA-2.odt');		
	
		
	}
			
	public function actionJpu()
    {
    	$searchModel = new VwJaksaPenuntutSearch();
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    	$dataProvider->pagination->pageSize=10;
    	return $this->renderAjax('_jpu', [
    			'searchModel' => $searchModel,
    			'dataProvider' => $dataProvider,
    	]);
    }
	public function actionJpu2()
    {
    	$searchModel = new VwJaksaPenuntutSearch();
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    	$dataProvider->pagination->pageSize=10;
    	return $this->renderAjax('_jpupenyidik', [
    			'searchModel' => $searchModel,
    			'dataProvider' => $dataProvider,
    	]);
    }
	
    protected function findModelSpdp($id)
    {
        if (($modelSpdp = PdmSpdp::findOne($id)) !== null) {
            return $modelSpdp;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	protected function findModelTersangka($id)
    {
        if (($modelTersangka = MsTersangka::findAll(['id_perkara' => $id])) !== null) {
            return $modelTersangka;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	
}

