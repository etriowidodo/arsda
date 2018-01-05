<?php

namespace app\modules\pdsold\controllers;

use app\modules\pdsold\models\PdmT8;
use app\modules\pdsold\models\PdmTembusan;
use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\VwTerdakwa;
use Odf;
use Yii;
use app\modules\pdsold\models\PdmT15;
use app\modules\pdsold\models\PdmT15Search;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\MsTersangka;
use app\modules\pdsold\models\PdmPenandatangan;
use app\models\MsWarganegara;
//use yii\console\Response;
use yii\db\Exception;
use yii\db\Query;
use yii\web\Response;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
use app\modules\pdsold\models\PdmSysMenu;

/**
 * PdmT15Controller implements the CRUD actions for PdmT15 model.
 */
class PdmT15Controller extends Controller
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
     * Lists all PdmT15 models.
     * @return mixed
     */
    public function actionIndex()
    {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::T15 ]);
        $session = new Session();
        $idPerkara = $session->get('id_perkara');

        $searchModel = new PdmT15Search();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search($idPerkara);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sysMenu' => $sysMenu
        ]);
    }

    /**
     * Displays a single PdmT15 model.
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
     * Creates a new PdmT15 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::T15 ]);
        $session = new Session();
        $idPerkara = $session->get('id_perkara');

        $model = new PdmT15();
        $modelMsTersangka = new MsTersangka();
        $di = PdmSpdp::findOne($idPerkara)->wilayah_kerja;
		// $kerugian ='Kerugian Negara ......../ Akibat yang ditimbulkan......';
        $searchTersangka = new PdmT15Search();
        $dataProviderTersangka = $searchTersangka->searchTersangka($idPerkara);

        //if ($model->load(Yii::$app->request->post()) && $model->save()) {
        if ($model->load(Yii::$app->request->post()) && $modelMsTersangka->load(Yii::$app->request->post())) {
            //return $this->redirect(['view', 'id' => $model->id_t15]);
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_t15', 'id_t15', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();

                // insert tabel pdm_t15
                $model->id_perkara = $idPerkara;
                $model->id_t15 = $seq['generate_pk'];
                $model->id_t8 = PdmT8::findOne(['id_perkara' => $idPerkara])->id_t8;
                $model->flag = '1';
                $model->save();
				
				   Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara,GlobalConstMenuComponent::T15);   

                // insert ciri tersangka ke tabel ms_tersangka
                $modelMsTersangka = MsTersangka::findOne(['id_tersangka' => $model->id_tersangka]);
                $modelMsTersangka->tinggi = $_POST['MsTersangka']['tinggi'];
                $modelMsTersangka->kulit = $_POST['MsTersangka']['kulit'];
                $modelMsTersangka->muka = $_POST['MsTersangka']['muka'];
                $modelMsTersangka->ciri_khusus = $_POST['MsTersangka']['ciri_khusus'];
                $modelMsTersangka->save();

                //Insert tabel tembusan
               // PdmTembusan::deleteAll(['id_perkara' => $model->id_perkara,'kode_table'=>GlobalConstMenuComponent::T15]);
                if (isset($_POST['new_tembusan'])) {
                    for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                        $modelNewTembusan = new PdmTembusan();
                        $modelNewTembusan->id_table = $model->id_t15;
                        $seqTembusan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tembusan', 'id_tembusan', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                        $modelNewTembusan->id_tembusan = $seqTembusan['generate_pk'];
                        $modelNewTembusan->kode_table = GlobalConstMenuComponent::T15;
                        $modelNewTembusan->keterangan = $_POST['new_tembusan'][$i];
                        $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                        $modelNewTembusan->no_urut = $_POST['new_no_urut'][$i];
                        $modelNewTembusan->id_perkara = $model->id_perkara;
                        $modelNewTembusan->nip = null;
                        $modelNewTembusan->save();
                    }
                }

                $transaction->commit();

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

                return $this->redirect(['update', 'id' => $model->id_t15]);
            } catch(Exception $e) {
                $transaction->rollBack();

                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'danger', //String, can only be set to danger, success, warning, info, and growl
                    'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                    'icon' => 'glyphicon glyphicon-ok-sign', //String
                    'message' => 'Data Gagal Disimpan', // String
                    'title' => 'Save', //String
                    'positonY' => 'top', //String // defaults to top, allows top or bottom
                    'positonX' => 'center', //String // defaults to right, allows right, center, left
                    'showProgressbar' => true,
                ]);

                return $this->redirect(['update', 'id' => $model->id_t15]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'modelMsTersangka' => $modelMsTersangka,
                'id' => $idPerkara,
                'di' => $di,
                'dataProviderTersangka' => $dataProviderTersangka,
                'sysMenu' => $sysMenu,
				//'kerugian' =>$kerugian,
            ]);
        }
    }

    /**
     * Updates an existing PdmT15 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        /*
        //$session = new Session();

        /*$id = $session->get('id_perkara');
        if ($id == '' or $id == null) {
            $id = $session->get('id_perkara');
        }*/
        //var_dump($id);exit();
        /*$model = $this->findModel($id);
        if ($model == null) {
            $model = new PdmT15();
        }*/

        /*$modelMsTersangka = $this->findModelTersangka($model->id_tersangka);
        if($modelMsTersangka == null) {
            $modelMsTersangka = new MsTersangka();
            $style = 'display: block';
        } else {
            $tblTersangka = VwTerdakwa::findOne(['id_tersangka'=>$model->id_tersangka]);
            $style = 'display: none';
        }*/
        $model = $this->findModel($id);
        $modelMsTersangka = $this->findModelTersangka($model->id_tersangka);
        if ($modelMsTersangka != null) {
            $tblTersangka = VwTerdakwa::findOne(['id_tersangka' => $model->id_tersangka]);
            $style = 'display: none';
        }
        $di = PdmSpdp::findOne($model->id_perkara)->wilayah_kerja;

        $searchTersangka = new PdmT15Search();
        //$dataProviderTersangka = $searchTersangka->searchTersangka(Yii::$app->request->queryParams);
        $dataProviderTersangka = $searchTersangka->searchTersangka($model->id_perkara);

        if ($model->load(Yii::$app->request->post()) && $modelMsTersangka->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                //update tabel pdm_t15
                $model->flag = '2';
                $model->update();

                // insert ciri tersangka ke tabel ms_tersangka
                $modelMsTersangka = MsTersangka::findOne(['id_tersangka' => $model->id_tersangka]);
                $modelMsTersangka->tinggi = $_POST['MsTersangka']['tinggi'];
                $modelMsTersangka->kulit = $_POST['MsTersangka']['kulit'];
                $modelMsTersangka->muka = $_POST['MsTersangka']['muka'];
                $modelMsTersangka->ciri_khusus = $_POST['MsTersangka']['ciri_khusus'];
                $modelMsTersangka->save();

                //Insert tabel tembusan
                // PdmTembusan::deleteAll(['id_perkara' => $model->id_perkara]);
				PdmTembusan::deleteAll(['id_perkara' => $model->id_perkara,'kode_table'=>GlobalConstMenuComponent::T15]);
                if (isset($_POST['new_tembusan'])) {
                    for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                        $modelNewTembusan = new PdmTembusan();
                        $modelNewTembusan->id_table = $model->id_t15;
                        $seqTembusan = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tembusan', 'id_tembusan', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                        $modelNewTembusan->id_tembusan = $seqTembusan['generate_pk'];
                        $modelNewTembusan->kode_table = GlobalConstMenuComponent::T15;
                        $modelNewTembusan->keterangan = $_POST['new_tembusan'][$i];
                        $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                        $modelNewTembusan->no_urut = $_POST['new_no_urut'][$i];
                        $modelNewTembusan->id_perkara = $model->id_perkara;
                        $modelNewTembusan->nip = null;
                        $modelNewTembusan->save();
                    }
                }

                $transaction->commit();

                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
                    'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                    'icon' => 'glyphicon glyphicon-ok-sign', //String
                    'message' => 'Data Berhasil Diubah', // String
                    'title' => 'Update', //String
                    'positonY' => 'top', //String // defaults to top, allows top or bottom
                    'positonX' => 'center', //String // defaults to right, allows right, center, left
                    'showProgressbar' => true,
                ]);

                return $this->redirect(['update', 'id' => $model->id_t15]);

            } catch(Exception $e) {
                $transaction->rollBack();

                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'danger', //String, can only be set to danger, success, warning, info, and growl
                    'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                    'icon' => 'glyphicon glyphicon-ok-sign', //String
                    'message' => 'Data Gagal Diubah', // String
                    'title' => 'Update', //String
                    'positonY' => 'top', //String // defaults to top, allows top or bottom
                    'positonX' => 'center', //String // defaults to right, allows right, center, left
                    'showProgressbar' => true,
                ]);

                return $this->redirect(['update', 'id' => $model->id_t15]);
            }
        } else {
            return $this->render('update', [
                    'model' => $model,
                    //'id' => $id,
                    'di' => $di,
                    'modelMsTersangka' => $modelMsTersangka,
                    'tblTersangka' => $tblTersangka,
                    'style' => $style,
                    'dataProviderTersangka' => $dataProviderTersangka,
                ]
            );
        }

        /*if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_t15]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }*/
    }

    public function actionGetCiriKhusus()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $id_tersangka = $_POST['idTersangka'];
            $tersangka = MsTersangka::findOne(['id_tersangka' => $id_tersangka]);

            return [
                'tersangka' => $tersangka
            ];
        }
    }

    public function actionCetak($id)
    {
        $odf = new Odf(Yii::$app->params['report-path']."modules/pdsold/template/t15.odt");

        $t15 = PdmT15::findOne($id);
        $spdp = PdmSpdp::findOne(['id_perkara' => $t15->id_perkara]);
        $tersangka = VwTerdakwa::findOne(['id_tersangka'=>$t15->id_tersangka]);
        $ciriciri = MsTersangka::findOne($t15->id_tersangka);
		$warganegara= MsWarganegara::findOne(['id'=> $ciriciri->warganegara]); 
		
		$pangkat = PdmPenandatangan::find()
->select ("a.jabatan as jabatan")
->from ("pidum.pdm_penandatangan a")
->join ('inner join','pidum.pdm_t15 b','a.peg_nik = b.id_penandatangan')
->where ("id_t15='".$id."'")
->one();
        $odf->setVars('Kejaksaan', $pangkat->jabatan);
        $odf->setVars('nomor', $t15->no_surat);
        $odf->setVars('sifat', $t15->sifat);
        $odf->setVars('lampiran', $t15->lampiran);
        $odf->setVars('kepada', $t15->kepada);
        // $odf->setVars('di', $t15->di);
        $odf->setVars('put_pengadilan', $t15->put_pengadilan);
        $odf->setVars('no_registrasi', $t15->no_registrasi);
        $odf->setVars('tgl_registrasi', Yii::$app->globalfunc->ViewIndonesianFormat ($t15->tgl_registrasi));
        $odf->setVars('nm_tersangka', $tersangka->nama);
        $odf->setVars('tgl_kabur',Yii::$app->globalfunc->ViewIndonesianFormat ($t15->tgl_kabur));
        $odf->setVars('tmpt_lahir', $tersangka->tmpt_lahir);
        $odf->setVars('tgl_lahir',Yii::$app->globalfunc->ViewIndonesianFormat ($tersangka->tgl_lahir));
        $odf->setVars('jns_kelamin', $tersangka->is_jkl);
        $odf->setVars('warganegara', $warganegara->nama);
        $odf->setVars('alamat', $tersangka->alamat);
        $odf->setVars('agama', $tersangka->is_agama);
        $odf->setVars('pekerjaan', $tersangka->pekerjaan);
        $odf->setVars('pendidikan', $tersangka->is_pendidikan);
        $odf->setVars('tinggi', $ciriciri->tinggi);
        $odf->setVars('kulit', $ciriciri->kulit);
        $odf->setVars('muka', $ciriciri->muka);
        $odf->setVars('ciri_khusus', $ciriciri->ciri_khusus);
        $odf->setVars('modus', $t15->modus);
        $odf->setVars('kerugian', $t15->kerugian);

        #tembusan
        $query = new Query();
        $query->select('*')
            ->from('pidum.pdm_tembusan')
            ->where("id_perkara='".$t15->id_perkara."' and kode_table ='".GlobalConstMenuComponent::T15."'")
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

    /**
     * Deletes an existing PdmT15 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    //public function actionDelete($id)
    public function actionDelete()
    {
        //if(Yii::$app->request->isAjax) {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $id_t15 = $_POST['hapusIndex'];

            $session = new Session();
            $id_perkara = $session->get('id_perkara');

            if($id_t15 === 'all') {
                PdmT15::updateAll(['flag'=>'3'],'id_perkara=:id_perkara',[':id_perkara'=>$id_perkara]);
            } else {
                for($i=0;$i<count($id_t15);$i++) {
                    $model = $this->findModel($id_t15[$i]);
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
        }
            /*$id_pdmT15 = Yii::$app->request->post('id_pdmt15');
            $model = $this->findModel($id_pdmT15);
            $model->flag = '3';
			
			//notifikasi simpan
            if($model->save(true)) {
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
            } else {
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
        //}

        //$this->findModel($id)->delete();
        //return $this->redirect(['index']);
    }
	
	
    /**
     * Finds the PdmT15 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmT15 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */  
	 
    protected function findModel($id)
    {
        if (($model = PdmT15::findOne(['id_t15' => $id])) !== null)
            return $model;

        /*if (($model = PdmT15::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }*/
    }

    protected function findModelTersangka($id)
    {
        if (($model = MsTersangka::findOne(['id_tersangka' => $id])) !== null)
            return $model;
    }
}
