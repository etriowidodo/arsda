<?php

namespace app\modules\pidum\controllers;

use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\MsTersangka;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmTembusan;
use app\modules\pidum\models\PdmSysMenu;
use app\modules\pidum\models\PdmB7;
use app\modules\pidum\models\PdmPkTingRef;
use app\modules\pidum\models\PdmB7Search;
use app\modules\pidum\models\PdmPenandatangan;
use Odf;
use Yii;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;

/**
 * PdmB7Controller implements the CRUD actions for PdmB7 model.
 */
class PdmB7Controller extends Controller
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
     * Lists all PdmB7 models.
     * @return mixed
     */
    public function actionIndex()
    {   
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::B7 ]);
        $session = new Session();
        $id_perkara = $session->get('id_perkara');
        $searchModel = new PdmB7Search();
        $dataProvider = $searchModel->search($id_perkara, Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sysMenu'=>$sysMenu,
        ]);
    }

    /**
     * Displays a single PdmB7 model.
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
     * Creates a new PdmB7 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PdmB7();
        $id = \Yii::$app->session->get('id_perkara');

        $modelSpdp = PdmSpdp::findOne(['id_perkara' => $id]);

        $barbuk = Yii::$app->globalfunc->getBarbuk($id);
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();

            try {

                $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_b7', 'id_b7', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();

                $model->id_perkara = $id;
                $model->id_b7 = $seq['generate_pk'];
                $model->save();

                //PdmTembusan::deleteAll(['id_perkara' => $model->id_perkara,'kode_table'=>GlobalConstMenuComponent::B7]);
                if(!empty($_POST['new_tembusan'])){
                    for($i = 0; $i < count($_POST['new_tembusan']); $i++){
                        $modelNewTembusan= new PdmTembusan();
                        $modelNewTembusan->id_table = $model->id_b7;
                        $seqTembusan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tembusan', 'id_tembusan', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                        $modelNewTembusan->id_tembusan = $seqTembusan['generate_pk'];
                        $modelNewTembusan->kode_table =  GlobalConstMenuComponent::B7;
                        $modelNewTembusan->keterangan = $_POST['new_tembusan'][$i];
                        $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                        $modelNewTembusan->no_urut=$_POST['new_no_urut'][$i];
                        $modelNewTembusan->id_perkara = $model->id_perkara;
                        $modelNewTembusan->nip = null;
                        $modelNewTembusan->save();
                    }
                }

                Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara,GlobalConstMenuComponent::B7);
                $transaction->commit();

                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'success',
                    'duration' => 3000,
                    'icon' => 'fa fa-users',
                    'message' => 'Data Berhasil di Simpan',
                    'title' => 'Ubah Data',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
                return $this->redirect('index');
            }catch (Exception $e) {
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
                $transaction->rollback();
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'modelSpdp' => $modelSpdp,
                'barbuk'=>$barbuk,
            ]);
        }
    }

    /**
     * Updates an existing PdmB7 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $id_perkara = \Yii::$app->session->get('id_perkara');

        $modelSpdp = PdmSpdp::findOne(['id_perkara' => $id_perkara]);
        $barbuk = Yii::$app->globalfunc->getBarbuk($id_perkara);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $transaction = Yii::$app->db->beginTransaction();

            try {

                PdmTembusan::deleteAll(['id_perkara' => $model->id_perkara,'kode_table'=>GlobalConstMenuComponent::B7]);
                if(!empty($_POST['new_tembusan'])){
                    for($i = 0; $i < count($_POST['new_tembusan']); $i++){
                        $modelNewTembusan= new PdmTembusan();
                        $modelNewTembusan->id_table = $model->id_b7;
                        $seqTembusan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tembusan', 'id_tembusan', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                        $modelNewTembusan->id_tembusan = $seqTembusan['generate_pk'];
                        $modelNewTembusan->kode_table =  GlobalConstMenuComponent::B7;
                        $modelNewTembusan->keterangan = $_POST['new_tembusan'][$i];
                        $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                        $modelNewTembusan->no_urut=$_POST['new_no_urut'][$i];
                        $modelNewTembusan->id_perkara = $model->id_perkara;
                        $modelNewTembusan->nip = null;
                        $modelNewTembusan->save();
                    }
                }

                Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara,GlobalConstMenuComponent::B7);
                $transaction->commit();

                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'success',
                    'duration' => 3000,
                    'icon' => 'fa fa-users',
                    'message' => 'Data Berhasil di Simpan',
                    'title' => 'Ubah Data',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
                return $this->redirect('index');
            }catch (Exception $e) {
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
                $transaction->rollback();
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelSpdp' => $modelSpdp,
                'barbuk'=> $barbuk,
            ]);
        }
    }

    /**
     * Deletes an existing PdmB7 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $id_tersangka = $_POST['hapusIndex'];

        for($i=0;$i<count($id_tersangka);$i++){
            $spdp = $this->findModel($id_tersangka[$i]);
            $spdp->flag = '3';
            $spdp->update();
        }

        return $this->redirect(['index']);
    }
	
	public function actionCetak($id_b7)
	{
		$connection = \Yii::$app->db;
		$odf = new Odf(Yii::$app->params['report-path'] . "modules/pidum/template/b7.odt");
		
		$b7 = Pdmb7::findOne($id_b7);
        $spdp = PdmSpdp::findOne(['id_perkara' => $b7->id_perkara]);
        $tersangka = MsTersangka::findone($b7->id_tersangka);
		$pidana = PdmPkTingRef::findOne(['id'=>$spdp->id_pk_ting_ref]);
		     $pangkat = PdmPenandatangan::find()
->select ("a.jabatan as jabatan")
->from ("pidum.pdm_penandatangan a")
->join ('inner join','pidum.pdm_b7 b','a.peg_nik = b.id_penandatangan')
->where ("id_b7='".$id."'")
->one(); 
		$odf->setVars('Kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
		$odf->setVars('kejaksaan', ucwords(strtolower(Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama)));
		$odf->setVars('kepala', $pangkat->jabatan);
		$odf->setVars('nomor', $b7->no_surat);
		$odf->setVars('sifat', $b7->sifat);
		$odf->setVars('lampiran', $b7->lampiran);
		$odf->setVars('kepada', $b7->kepada);
		$odf->setVars('ditempat', $b7->di_kepada);
		$odf->setVars('tindakan', $b7->tindakan);
		$odf->setVars('tersangka', MsTersangka::findOne(['id_tersangka' => $b7->id_tersangka])->nama);
		$odf->setVars('nomor_sp', PdmSpdp::findOne(['id_perkara' => $b7->id_perkara])->no_surat);
		$odf->setVars('tanggal_sp', Yii::$app->globalfunc->ViewindonesianFormat($spdp->tgl_surat));
		$odf->setVars('tgl_dikeluarkan', Yii::$app->globalfunc->ViewindonesianFormat($b7->tgl_dikeluarkan));
		$odf->setVars('dikeluarkan', $b7->dikeluarkan);
		$odf->setVars('perkara_pidana', $pidana->nama);
		$odf->setVars('barbuk', Yii::$app->globalfunc->getBarbuk($b7->id_perkara));
		#berupa
//        $query = new Query();
//        $listSita = $query->select('*')->from('pidum.pdm_b7 a')
//            ->innerJoin('pidum.pdm_barbuk_tambahan b','a.id_b7 = b.id')
//            ->where("a.id_b7='".$b7->id_b7."' AND b.flag <> '3'")
//            ->orderBy('b.id')->all();
//        $i = '1';
//        $dft_sita = $odf->setSegment('berupa');
//        
//		//var_dump($listSita); exit();
//        foreach ($listSita as $berupa) {
//            $dft_sita->no_urut_sita($i);
//            $dft_sita->nama_barang_sita($berupa['nama']);
//            $i++;
//            $dft_sita->merge();
//        }
//        $odf->mergeSegment($dft_sita);
		
		
		#tembusan
        $query = new Query();
        $query->select('*')
            ->from('pidum.pdm_tembusan')
            ->where("id_perkara='" . $b7->id_perkara . "' and kode_table ='" . GlobalConstMenuComponent::B7 . "'");
        $dt_tembusan = $query->createCommand();
        $listTembusan = $dt_tembusan->queryAll();
        $dft_tembusan = $odf->setSegment('tembusan');
        foreach ($listTembusan as $element) {
            $dft_tembusan->urutan_tembusan($element['no_urut']);
            $dft_tembusan->nama_tembusan($element['tembusan']);
            $dft_tembusan->merge();
        }
        $odf->mergeSegment($dft_tembusan);
		
		#penanda tangan
        $sql = "SELECT a.nama,a.pangkat,a.jabatan,c.peg_nip_baru FROM "
                . " pidum.pdm_penandatangan a, pidum.pdm_b7 b , kepegawaian.kp_pegawai c "
                . "where a.peg_nik = b.id_penandatangan and b.id_penandatangan =c.peg_nik and b.id_b7='" . $id_b7 . "'";
        $model = $connection->createCommand($sql);
        $penandatangan = $model->queryOne();
        $odf->setVars('nama_penandatangan', $penandatangan['nama']);
        $odf->setVars('pangkat', $penandatangan['pangkat']);
        $odf->setVars('nip_penandatangan', $penandatangan['peg_nip_baru']);

		 $odf->exportAsAttachedFile();
	}

    /**
     * Finds the PdmB7 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmB7 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmB7::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
