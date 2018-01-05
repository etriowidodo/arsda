<?php

namespace app\modules\pidum\controllers;

use Yii;
use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\PdmP9;
use app\modules\pidum\models\PdmP9Search;
use app\modules\pidum\models\PdmPanggilanSaksi;
use app\modules\pidum\models\PdmPasal;
use app\modules\pidum\models\PdmPkTingRef;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmSysMenu;
use app\modules\pidum\models\PdmPenandatangan;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;

/**
 * PdmP9Controller implements the CRUD actions for PdmP9 model.
 */
class PdmP9Controller extends Controller
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
     * Lists all PdmP9 models.
     * @return mixed
     */
    public function actionIndex()
    {
	$sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P9]);
        $id_perkara = Yii::$app->session->get('id_perkara');
		
        $searchModel = new PdmP9Search();
        $dataProvider = $searchModel->search($id_perkara,Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'sysMenu' => $sysMenu,
        ]);
    }

    /**
     * Displays a single PdmP9 model.
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
     * Creates a new PdmP9 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P9]);
        $session = new Session();
        $id = $session->get('id_perkara');
        $model = new PdmP9();
        $modelPanggilanSaksi = PdmPanggilanSaksi::findOne(['id_saksi_ahli' => $model->id_panggilan_saksi]);
        if ($modelPanggilanSaksi == null) {
            $modelPanggilanSaksi = new PdmPanggilanSaksi();
        }
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_p9','id_p9', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
	
            if ($modelPanggilanSaksi->id_saksi_ahli == null) {
                $id_perkara_PdmPanggilanSaksi = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_panggilan_saksi', 'id_saksi_ahli', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                $modelPanggilanSaksi = new PdmPanggilanSaksi();
                $modelPanggilanSaksi->id_saksi_ahli = $id_perkara_PdmPanggilanSaksi['generate_pk'];
                $modelPanggilanSaksi->nama = $_POST['PdmPanggilanSaksi']['nama'];
                $modelPanggilanSaksi->alamat = $_POST['PdmPanggilanSaksi']['alamat'];
                $modelPanggilanSaksi->pekerjaan = $_POST['PdmPanggilanSaksi']['pekerjaan'];
                $modelPanggilanSaksi->save();
            } else {

//                $modelPanggilanSaksi = PdmPanggilanSaksi::findOne(['id_saksi_ahli' => $model->id_panggilan_saksi]);
                $modelPanggilanSaksi->flag = '2';
//                $modelPanggilanSaksi->id_saksi_ahli = $id_perkara_PdmPanggilanSaksi['generate_pk'];
                $modelPanggilanSaksi->nama = $_POST['PdmPanggilanSaksi']['nama'];
                $modelPanggilanSaksi->alamat = $_POST['PdmPanggilanSaksi']['alamat'];
                $modelPanggilanSaksi->pekerjaan = $_POST['PdmPanggilanSaksi']['pekerjaan'];
                $modelPanggilanSaksi->save();
            }

            if ($model->id_perkara != null) {
                $model->update();
            } else {
                $model->id_perkara = $id;
                $model->id_p9 = $seq['generate_pk'];
                $model->id_panggilan_saksi = $modelPanggilanSaksi->id_saksi_ahli;
                $model->save();

                Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara, GlobalConstMenuComponent::P9);
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

            // return $this->redirect(['index']);
            return $this->redirect(['update', 'id' => $model->id_p9]);
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'modelPanggilanSaksi' => $modelPanggilanSaksi,
                        'sysMenu' => $sysMenu,
                        'id' => $id
            ]);
        }
    }

    /**
     * Updates an existing PdmP9 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id_p9){	
	$sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P9]);
        $session = new Session();
        $id = $session->get('id_perkara');
        $model = PdmP9::findOne(['id_p9' => $id_p9]);
        
        if ($model == null) {
            $model = new PdmP9();
        }

        $modelSpdp = $this->findModelSpdp($model->id_perkara);

        $modelPanggilanSaksi = PdmPanggilanSaksi::findOne(['id_saksi_ahli' => $model->id_panggilan_saksi]);
        if ($modelPanggilanSaksi == null) {
            $modelPanggilanSaksi = new PdmPanggilanSaksi();
        }


        if ($model->load(Yii::$app->request->post())) {

            $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_p9','id_p9', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
            
            if ($model->id_p9 != null) {
                $model->flag = '2';
                $model->update();
            }
            
            if ($modelPanggilanSaksi->id_saksi_ahli == null) {
                $id_perkara_PdmPanggilanSaksi = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_panggilan_saksi', 'id_saksi_ahli', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                $modelPanggilanSaksi = new PdmPanggilanSaksi();
                $modelPanggilanSaksi->id_saksi_ahli = $id_perkara_PdmPanggilanSaksi['generate_pk'];
                $modelPanggilanSaksi->nama = $_POST['PdmPanggilanSaksi']['nama'];
                $modelPanggilanSaksi->alamat = $_POST['PdmPanggilanSaksi']['alamat'];
                $modelPanggilanSaksi->pekerjaan = $_POST['PdmPanggilanSaksi']['pekerjaan'];
                $modelPanggilanSaksi->save();
            } else {

//                $modelPanggilanSaksi = PdmPanggilanSaksi::findOne(['id_saksi_ahli' => $model->id_panggilan_saksi]);
                $modelPanggilanSaksi->flag = '2';
//                $modelPanggilanSaksi->id_saksi_ahli = $id_perkara_PdmPanggilanSaksi['generate_pk'];
                $modelPanggilanSaksi->nama = $_POST['PdmPanggilanSaksi']['nama'];
                $modelPanggilanSaksi->alamat = $_POST['PdmPanggilanSaksi']['alamat'];
                $modelPanggilanSaksi->pekerjaan = $_POST['PdmPanggilanSaksi']['pekerjaan'];
                $modelPanggilanSaksi->save();
            }		

//            if ($model->id_perkara != null) {
//                //print_r($modelPanggilanSaksi); exit();
//                $id_perkara_PdmPanggilanSaksi = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_panggilan_saksi', 'id_saksi_ahli', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
//                $modelPanggilanSaksi = new PdmPanggilanSaksi();
//                $modelPanggilanSaksi->id_saksi_ahli = $id_perkara_PdmPanggilanSaksi['generate_pk'];
//                $modelPanggilanSaksi->nama = $_POST['PdmPanggilanSaksi']['nama'];
//                $modelPanggilanSaksi->alamat = $_POST['PdmPanggilanSaksi']['alamat'];
//                $modelPanggilanSaksi->pekerjaan = $_POST['PdmPanggilanSaksi']['pekerjaan'];
//                $modelPanggilanSaksi->save();
//
//                $model->update();
//            } else {
//                $model->id_perkara = $id;
//                $model->id_p9 = $seq['generate_pk'];
//                $model->id_panggilan_saksi = $modelPanggilanSaksi->id_saksi_ahli;
//                $model->save();
//
//                $modelPanggilanSaksi = PdmPanggilanSaksi::findOne(['id_saksi_ahli' => $model->id_panggilan_saksi]);
//                $modelPanggilanSaksi->flag = '2';
//                $modelPanggilanSaksi->id_saksi_ahli = $id_perkara_PdmPanggilanSaksi['generate_pk'];
//                $modelPanggilanSaksi->nama = $_POST['PdmPanggilanSaksi']['nama'];
//                $modelPanggilanSaksi->alamat = $_POST['PdmPanggilanSaksi']['alamat'];
//                $modelPanggilanSaksi->pekerjaan = $_POST['PdmPanggilanSaksi']['pekerjaan'];
//                $modelPanggilanSaksi->save();
//
//                Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara, GlobalConstMenuComponent::P9);
//            }


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

            //	return $this->redirect(['update','id'=>$model->id_perkara]);
            return $this->redirect(['update', 'id_p9' => $model->id_p9]);
            //return $this->redirect(['update','id'=>$id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'modelPanggilanSaksi' => $modelPanggilanSaksi,
                        'modelSpdp' => $modelSpdp,
                        'sysMenu' => $sysMenu,
                        'id' => $id,
            ]);
        }
    }

    /**
     * Deletes an existing PdmP9 model.
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

                PdmP9::updateAll(['flag' => '3'], "id_perkara = '" . $id_perkara . "'");
            }else{
                for($i=0;$i<count($id);$i++){
                    PdmP9::updateAll(['flag' => '3'], "id_p9 = '" . $id[$i] . "'");
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
     * Finds the PdmP9 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmP9 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmP9::findOne($id)) !== null) {
            return $model;
        } 
		}
	
	    protected function findModelSpdp($id)
    {
        if (($modelSpdp = PdmSpdp::findOne($id)) !== null) {
            return $modelSpdp;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	
	public function actionCetak($id){$connection = \Yii::$app->db;
                $odf = new \Odf(Yii::$app->params['report-path'] . "modules/pidum/template/p-9.odt");
                $model = PdmP9::findOne(['id_p9' => $id]);
                $spdp = PdmSpdp::findOne(['id_perkara' => $model->id_perkara]);
                $pasal = PdmPasal::findOne(['id_perkara' => $model->id_perkara]);

 $pangkat = PdmPenandatangan::find()
->select ("a.jabatan as jabatan")
->from ("pidum.pdm_penandatangan a")
->join ('inner join','pidum.pdm_p9 b','a.peg_nik = b.id_penandatangan')
->where ("id_p9='".$id."'")
->one();       
                $odf->setVars('Kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
                $odf->setVars('kepala', $pangkat->jabatan);
                $odf->setVars('kepala_isi', ucwords(strtolower(Yii::$app->globalfunc->setKepalaReport($spdp->wilayah_kerja))));
                $odf->setVars('no_sp', $model->no_surat);
                $odf->setVars('hari', Yii::$app->globalfunc->GetNamaHari($model->tgl_panggilan));
                $odf->setVars('kepada', $model->kepada);
                $odf->setVars('tempat', $model->tempat);
                $odf->setVars('jam', $model->jam);
                $odf->setVars('menghadap', $model->menghadap);
                $odf->setVars('sebagai', $model->sebagai);
                $odf->setVars('tgl_panggilan', Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_panggilan));
                $odf->setVars('nomor', $spdp->no_surat);
                $odf->setVars('tgl_terima', Yii::$app->globalfunc->ViewIndonesianFormat($spdp->tgl_terima));
                $odf->setVars('dikeluarkan', ucfirst(strtolower($model->dikeluarkan)));
                $odf->setVars('tgl_surat', Yii::$app->globalfunc->ViewIndonesianFormat($spdp->tgl_surat));
                $odf->setvars('pidana', PdmPkTingRef::findOne($spdp->id_pk_ting_ref)->nama);

                #penanda tangan
                $sql = "SELECT a.nama,a.pangkat,a.jabatan,c.peg_nip_baru FROM "
                        . " pidum.pdm_penandatangan a, pidum.pdm_p9 b , kepegawaian.kp_pegawai c "
                        . "where a.peg_nik = b.id_penandatangan and b.id_penandatangan =c.peg_nik and b.id_perkara='" . $model->id_perkara . "'";
                $SqlExec = $connection->createCommand($sql);
                $penandatangan = $SqlExec->queryOne();
                $odf->setVars('nama_penandatangan', $penandatangan['nama']);
                $odf->setVars('pangkat', preg_replace("/\/ (.*)/", "", $penandatangan['pangkat']));
//                $odf->setVars('pangkat', $penandatangan['pangkat']);
                $odf->setVars('nip_penandatangan', $penandatangan['peg_nip_baru']);

                #list Tersangka
                $dft_tersangka = '';
                $query = new Query;
                $query->select('*')
                        ->from('pidum.ms_tersangka')
                        ->where("id_perkara='" . $model->id_perkara . "'");
                $data = $query->createCommand();
                $listTersangka = $data->queryAll();
                foreach ($listTersangka as $key) {
                    $dft_tersangka .= $key[nama] . ',';
                }
                $xxx= Yii::$app->globalfunc->getDaftarTerdakwa($model->id_perkara);
                
                $odf->setVars('tersangka', $xxx);

                $odf->exportAsAttachedFile('p9.odt');
    }
	
}
