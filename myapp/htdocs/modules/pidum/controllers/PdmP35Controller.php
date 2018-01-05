<?php

namespace app\modules\pidum\controllers;

use Odf;
use Yii;
use app\components\GlobalConstMenuComponent;
use app\models\MsSifatSurat;
use app\modules\pidum\models\PdmP35;
use app\modules\pidum\models\PdmP29;
use app\modules\pidum\models\PdmP16a;
use app\modules\pidum\models\PdmTembusanP35;
use app\modules\pidum\models\PdmP35Search;
use app\modules\pidum\models\PdmPkTingRef;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmSysMenu;
use app\modules\pidum\models\PdmTahapDua;
use app\modules\pidum\models\VwTerdakwaT2;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Session;

/**
 * PdmP35Controller implements the CRUD actions for PdmP35 model.
 */
class PdmP35Controller extends DefaultController {

    public $sysMenu;

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

    public function init() {
        $this->sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P35]);
    }

    /**
     * Lists all PdmP35 models.
     * @return mixed
     */
    public function actionIndex() {
        //echo '<pre>';print_r('lelelelel');exit;
        // no need index page so redirect to update
        //return $this->redirect('update');
        $session = new session();
        
        $no_register_perkara = $session->get('no_register_perkara');
        
        $searchModel = new PdmP35Search();
        $dataProvider = $searchModel->search($no_register_perkara,Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'sysMenu' => $this->sysMenu
        ]);
    }

    /**
     * Displays a single PdmP35 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmP35 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $session = new session();
        $no_register_perkara = $session->get('no_register_perkara');
        $model = new PdmP35();
        $modelP29 = PdmP29::findOne(['no_register_perkara'=>$no_register_perkara]);
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            //echo '<pre>';print_r($_POST);exit;
            try {
                $data = array();
                $data['judul'] = $_POST['judul'];
                $data['isi'] = $_POST['isi'];
                $model->dakwaan =  $_POST['PdmP35']['dakwaan'];
                $model->no_register_perkara = $no_register_perkara;
                $model->no_reg_tahanan  = $_POST['PdmP35']['no_reg_tahanan'];
                $model->sifat = $_POST['PdmP35']['sifat'];
                $model->created_time=date('Y-m-d H:i:s');
                $model->created_by=\Yii::$app->user->identity->peg_nip;
                $model->created_ip = \Yii::$app->getRequest()->getUserIP();
                
                $model->nama_ttd = $_POST['hdn_nama_penandatangan'];
                $model->pangkat_ttd = $_POST['hdn_pangkat_penandatangan'];
                $model->jabatan_ttd = $_POST['hdn_jabatan_penandatangan'];
                
                $model->updated_by=\Yii::$app->user->identity->peg_nip;
                $model->updated_time=date('Y-m-d H:i:s');
                $model->updated_ip = \Yii::$app->getRequest()->getUserIP();
                
                $model->id_kejati = $session->get('kode_kejati');
                $model->id_kejari = $session->get('kode_kejari');
                $model->id_cabjari = $session->get('kode_cabjari');
                if($model->save()){
                    //PdmTembusanP35::deleteAll(['no_register_perkara' => $no_register_perkara,'no_surat_p35'=>$_POST['PdmP35']['no_surat_p35']]);
                        if (isset($_POST['new_tembusan'])) {
                            for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                                $modelNewTembusan = new PdmTembusanP35();
                                $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                                $modelNewTembusan->no_urut = $_POST['new_no_urut'][$i];
                                $modelNewTembusan->no_register_perkara = $no_register_perkara;
                                $modelNewTembusan->no_surat_p35 = $_POST['PdmP35']['no_surat_p35'];
                                $modelNewTembusan->save();
                            }
                        }
                }else{
                    var_dump($model->getErrors());exit;
                }

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
                return $this->redirect(['index']);
            } catch (Exception $e) {
                $transaction->rollback();
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
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'no_register_perkara' => $no_register_perkara,
                        'modelP29' => $modelP29,
                        'sysMenu' => $this->sysMenu
            ]);
        }
    }

    /**
     * Updates an existing PdmP35 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {

        $session = new session();
        $no_register_perkara = $session->get('no_register_perkara');
        $model = $this->findModel($no_register_perkara,$id);
        if(empty($model)){
            $model = new PdmP35();
        }


        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {


                $data = array();
                $data['judul'] = $_POST['judul'];
                $data['isi'] = $_POST['isi'];
                $model->dakwaan =  $_POST['PdmP35']['dakwaan'];
                $model->no_register_perkara = $no_register_perkara;
                $model->no_reg_tahanan  = $_POST['PdmP35']['no_reg_tahanan'];

                $model->nama_ttd = $_POST['hdn_nama_penandatangan'];
                $model->pangkat_ttd = $_POST['hdn_pangkat_penandatangan'];
                $model->jabatan_ttd = $_POST['hdn_jabatan_penandatangan'];

                $model->updated_by=\Yii::$app->user->identity->peg_nip;
                $model->updated_time=date('Y-m-d H:i:s');
                $model->updated_ip = \Yii::$app->getRequest()->getUserIP();
                
                if($model->save()||$model->update()){
                    PdmTembusanP35::deleteAll(['no_register_perkara' => $no_register_perkara,'no_surat_p35'=>$_POST['PdmP35']['no_surat_p35']]);
                        if (isset($_POST['new_tembusan'])) {
                            for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                                $modelNewTembusan = new PdmTembusanP35();
                                $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                                $modelNewTembusan->no_urut = $_POST['new_no_urut'][$i];
                                $modelNewTembusan->no_register_perkara = $no_register_perkara;
                                $modelNewTembusan->no_surat_p35 = $_POST['PdmP35']['no_surat_p35'];
                                $modelNewTembusan->save();
                            }
                        }
                }else{
                    var_dump($model->getErrors());exit;
                }

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
                return $this->redirect(['index']);
            } catch (Exception $e) {
                $transaction->rollback();
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
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'no_register_perkara' => $no_register_perkara,
                        'modelP29' => $modelP29,
                        'sysMenu' => $this->sysMenu
            ]);
        }
    }

    /**
     * Updates an existing PdmP35 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
  

    /**
     * Deletes an existing PdmP35 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete() {
        /*$id_tersangka = $_POST['hapusIndex'];

        for ($i = 0; $i < count($id_tersangka); $i++) {
            $spdp = $this->findModel($id_tersangka[$i]);
            $spdp->flag = '3';
            $spdp->update();
        }*/
        $session = new session();
        $no_register_perkara = $session->get('no_register_perkara');
        $arr= array();
        $id_tahap = $_POST['hapusIndex'][0];
        
            if($id_tahap=='all'){
                    $id_tahapx=PdmP35::find()->select("no_surat_p35")->where(['no_register_perkara'=>$no_register_perkara])->asArray()->all();
                    foreach ($id_tahapx as $key => $value) {
                        $arr[] = $value['no_surat_p35'];
                    }
                    $id_tahap=$arr;
            }else{
                $id_tahap = $_POST['hapusIndex'];
            }

        
        $count = 0;
           foreach($id_tahap AS $key_delete => $delete){
             try{
                    PdmP35::deleteAll(['no_register_perkara' => $no_register_perkara, 'no_surat_p35'=>$delete]);
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

     public function actionCetak($id) {
        //$connection = \Yii::$app->db;
        $session = new session();
        $no_register_perkara = $session->get('no_register_perkara');
        $id_perkara = $session->get('id_perkara');
        $spdp = $this->findModelSpdp($id_perkara);

        $model = $this->findModel($no_register_perkara, $id);
        $tersangka = VwTerdakwaT2::findOne(['no_register_perkara'=>$no_register_perkara, 'no_reg_tahanan'=>$model->no_reg_tahanan]);
        $tembusan = PdmTembusanP35::findAll(['no_register_perkara' => $no_register_perkara, 'no_surat_p35'=>$id]);
        $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_uu_pasal_tahap2')
                ->where("no_register_perkara='".$no_register_perkara."' ");
        $data = $query->createCommand();
        $listPasal = $data->queryAll();

        $p16a = PdmP16a::findOne(['no_register_perkara'=>$no_register_perkara]);
        $tahap2 = PdmTahapDua::findOne(['no_register_perkara'=>$no_register_perkara]);
        //echo '<pre>';print_r($model);exit;
        return $this->render('cetak',['session'=>$_SESSION, 'model'=>$model, 'tersangka'=>$tersangka, 'tembusan'=>$tembusan, 'spdp'=>$spdp, 'listPasal'=>$listPasal, 'p16a'=>$p16a, 'tahap2'=>$tahap2,]); 
    }


    /**
     * Finds the PdmP35 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmP35 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($no_register_perkara,$id) {
        if (($model = PdmP35::findOne(['no_register_perkara'=>$no_register_perkara, 'no_surat_p35'=>$id])) !== null) {
            return $model;
        }
    }

    protected function findModelByPerkara($id) {
        if (($model = PdmP35::findOne(['id_perkara' => $id])) !== null) {
            return $model;
        }
    }

    protected function findModelSpdp($id) {
        if (($modelSpdp = PdmSpdp::findOne($id)) !== null) {
            return $modelSpdp;
        } 

   
}
}