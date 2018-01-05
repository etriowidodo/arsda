<?php

namespace app\modules\pdsold\controllers;

use Yii;
use app\modules\pdsold\models\PdmT13;
use app\modules\pdsold\models\PdmT13Search;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
use yii\db\Query;
use app\modules\pdsold\models\PdmTembusan;
use app\modules\pdsold\models\PdmT8;
use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmPenandatangan;
use app\modules\pdsold\models\PdmSysMenu;
use app\modules\pdsold\models\MsTersangka;

/**
 * PdmT13Controller implements the CRUD actions for PdmT13 model.
 */
class PdmT13Controller extends Controller {

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
     * Lists all PdmT13 models.
     * @return mixed
     */
    public function actionIndex() {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::T13]);
        $session = new Session();
        $id_perkara = $session->get('id_perkara');
        $searchModel = new PdmT13Search();
        $dataProvider = $searchModel->search($id_perkara,Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'sysMenu'=>$sysMenu,
        ]);
    }

    /**
     * Displays a single PdmT13 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmT13 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::T13]);
        $session = new Session();
        $id = $session->get('id_perkara');
        $model = new PdmT13();
        $t8 = PdmT8::findOne(['id_perkara' => $id]);
        $modelSpdp = $this->findModelSpdp($id);

        if ($model->load(Yii::$app->request->post())) {
            $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_t13', 'id_t13', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
            $model->id_perkara = $id;
            $model->id_t8 = $t8->id_t8;
            $model->id_t13 = $seq['generate_pk'];
            $model->flag = '1';
            $model->save();
            Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara, GlobalConstMenuComponent::T13);
            PdmTembusan::deleteAll(['id_perkara' => $model->id_perkara,'kode_table'=> GlobalConstMenuComponent::T13 ]);
            if (isset($_POST['new_tembusan'])) {
                for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                    $modelNewTembusan = new PdmTembusan();
                    $modelNewTembusan->id_table = $model->id_t13;
                    $seqTembusan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tembusan', 'id_tembusan', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                    $modelNewTembusan->id_tembusan = $seqTembusan['generate_pk'];
                    $modelNewTembusan->kode_table = GlobalConstMenuComponent::T13;
                    $modelNewTembusan->keterangan = $_POST['new_tembusan'][$i];
                    $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                    $modelNewTembusan->no_urut = $_POST['new_no_urut'][$i];
                    $modelNewTembusan->id_perkara = $model->id_perkara;
                    $modelNewTembusan->nip = null;
                    $modelNewTembusan->save();
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

            return $this->redirect(['update', 'id_t13' => $model->id_t13]);
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'id' => $id,
                        't8' => $t8,
                        'modelSpdp' => $modelSpdp,
                        'sysMenu' => $sysMenu
            ]);
        }

    }

    /**
     * Updates an existing PdmT13 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id_t13) {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::T13]);
        $session = new Session();
        $id = $session->get('id_perkara');
        
        
        $model = $this->findModel($id_t13);
        if ($model == null) {
            $model = new PdmT13();
        }
        if (empty($model->id_perkara)) {
            $this->redirect('/pdsold/pdm-t13/index');
        }
        $t8 = PdmT8::findOne(['id_perkara' => $id]);

        $modelSpdp = $this->findModelSpdp($id);

        if ($model->load(Yii::$app->request->post())) {
            $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_t13', 'id_t13', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
            if ($model->id_perkara != null) {
                $model->flag = '2';
                $model->update();
            }


            PdmTembusan::deleteAll(['id_perkara' => $model->id_perkara,'kode_table'=> GlobalConstMenuComponent::T13 ]);
            if (isset($_POST['new_tembusan'])) {
                for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                    $modelNewTembusan = new PdmTembusan();
                    $modelNewTembusan->id_table = $model->id_t13;
                    $seqTembusan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tembusan', 'id_tembusan', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                    $modelNewTembusan->id_tembusan = $seqTembusan['generate_pk'];
                    $modelNewTembusan->kode_table = GlobalConstMenuComponent::T13;
                    $modelNewTembusan->keterangan = $_POST['new_tembusan'][$i];
                    $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                    $modelNewTembusan->no_urut = $_POST['new_no_urut'][$i];
                    $modelNewTembusan->id_perkara = $model->id_perkara;
                    $modelNewTembusan->nip = null;
                    $modelNewTembusan->save();
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

            return $this->redirect(['update', 'id_t13' => $model->id_t13]);
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'id' => $id,
                        't8' => $t8,
                        'modelSpdp' => $modelSpdp,
                        'sysMenu' => $sysMenu,
            ]);
        }
    }

    /**
     * Deletes an existing PdmT13 model.
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
				
				PdmT13::updateAll(['flag' => '3'], "id_perkara = '" . $id_perkara . "'");
            }else{
                for($i=0;$i<count($id);$i++){
                    PdmT13::updateAll(['flag' => '3'], "id_t13 = '" . $id[$i] . "'");
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

    public function actionCetak($id) {


        $connection = \Yii::$app->db;
        $odf = new \Odf(Yii::$app->params['report-path'] . "modules/pdsold/template/t13.odt");
$pangkat = PdmPenandatangan::find()
->select ("a.jabatan as jabatan")
->from ("pidum.pdm_penandatangan a")
->join ('inner join','pidum.pdm_t13 b','a.peg_nik = b.id_penandatangan')
->where ("id_t13='".$id."'")
->one();

        $model = PdmT13::findOne(['id_t13' => $id]);
        $spdp = PdmSpdp::findOne(['id_perkara' => $model->id_perkara]);

        $msTersangka = MsTersangka::findOne(['id_tersangka' => $model->id_tersangka]);
        $odf->setVars('nama', $msTersangka->nama);
        
        
        $odf->setVars('Kejaksaan', Yii::$app->globalfunc->setHeaderReport($spdp));
        $odf->setVars('kepala', $pangkat->jabatan);
        $odf->setVars('nomor', $model->no_surat);
        $odf->setVars('kepada', $model->kepada);
        $odf->setVars('ditempat', $model->tempat);
        $odf->setVars('sp_penahanan', $model->sp_penahanan);
        $odf->setVars('penetapan', $model->penetapan);
        $odf->setVars('no_penahanan', $model->no_penahanan);
        $odf->setVars('keperluan', $model->keperluan);
        $odf->setVars('menghadap', $model->menghadap);
        $odf->setVars('tempat', $model->tempat);
        $odf->setVars('ditempat', $model->tempat);
        $odf->setVars('tanggal', Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_penetapan));
        $odf->setVars('hari', Yii::$app->globalfunc->GetNamaHari($model->tgl_penetapan));
        $odf->setVars('jam', ($model->jam));
        $odf->setVars('tgl_surat', Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_surat));
        $odf->setVars('dikeluarkan', $model->dikeluarkan);


        #tembusan
        $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_tembusan')
                ->where("id_perkara='" . $model->id_perkara . "' AND kode_table='" . GlobalConstMenuComponent::T13 . "'")
                ->orderby('no_urut');
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
                . " pidum.pdm_penandatangan a, pidum.pdm_t13 b , kepegawaian.kp_pegawai c "
                . "where a.peg_nik = b.id_penandatangan and b.id_penandatangan =c.peg_nik and b.id_perkara='" . $model->id_perkara . "'";
        $model = $connection->createCommand($sql);
        $penandatangan = $model->queryOne();
        $odf->setVars('nama_penandatangan', $penandatangan['nama']);
        // $odf->setVars('pangkat', $penandatangan['pangkat']);       
        // $odf->setVars('nip_penandatangan', $penandatangan['peg_nip_baru']);

        $odf->exportAsAttachedFile('t13.odf');
    }

    /**
     * Finds the PdmT13 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmT13 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PdmT13::findOne(['id_t13' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelSpdp($id) {
        if (($modelSpdp = PdmSpdp::findOne($id)) !== null) {
            return $modelSpdp;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
