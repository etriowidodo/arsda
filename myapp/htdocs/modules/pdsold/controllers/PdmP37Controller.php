<?php

namespace app\modules\pdsold\controllers;

use Odf;
use Yii;
use app\components\GlobalConstMenuComponent;
use app\models\MsAgama;
use app\models\MsJkl;
use app\models\MsPendidikan;
use app\models\MsWarganegara;
use app\modules\pidsus\models\KpPegawai;
use app\modules\pdsold\models\PdmJaksaPenerima;
use app\modules\pdsold\models\PdmPenandatangan;
use app\modules\pdsold\models\PdmMsStatusData;
use app\modules\pdsold\models\PdmP37;
use app\modules\pdsold\models\PdmP37Search;
use app\modules\pdsold\models\PdmPanggilanSaksi;
use app\modules\pdsold\models\PdmPasal;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmMsSaksi;
use app\modules\pdsold\models\PdmSysMenu;
use app\modules\pdsold\models\VwTerdakwaT2;
use app\modules\pdsold\models\VwJaksaPenuntutSearch;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Session;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * PdmP37Controller implements the CRUD actions for PdmP37 model.
 */
class PdmP37Controller extends Controller {

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
        $this->sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P37]);
    }

    /**
     * Lists all PdmP37 models.
     * @return mixed
     */
    public function actionIndex() {
        $session = new session();
        $no_register_perkara = $session->get('no_register_perkara');
        $searchModel = new PdmP37Search();

        $dataProvider = $searchModel->search($no_register_perkara,Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'sysMenu' => $this->sysMenu
        ]);
    }

    /**
     * Displays a single PdmP37 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmP37 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new PdmP37();
        $session = new session();
        $id_perkara = $session->get('id_perkara');
        $no_register_perkara = $session->get('no_register_perkara');

        $modelTersangka = VwTerdakwaT2::findAll(['no_register_perkara'=>$no_register_perkara]);
        $searchJPU = new VwJaksaPenuntutSearch();
        $dataJPU = $searchJPU->search16a_new(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;
        
        $vw_saksi       = PdmMsSaksi::findAll(['no_register_perkara'=>$no_register_perkara, 'jenis'=>1]);
        $vw_ahli        = PdmMsSaksi::findAll(['no_register_perkara'=>$no_register_perkara, 'jenis'=>2]);

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            //echo '<pre>';print_r($_POST);exit;
            try {
                
                /*$model->nama_ttd = $_POST['hdn_nama_penandatangan'];
                $model->pangkat_ttd = $_POST['hdn_pangkat_penandatangan'];
                $model->jabatan_ttd = $_POST['hdn_jabatan_penandatangan'];*/
                
                $model->no_reg_tahanan = $_POST['PdmP37']['no_reg_tahanan'];
                $model->no_register_perkara = $no_register_perkara;
                $model->tgl_lahir = $_POST['PdmP37']['tgl_lahir'];
                $model->created_time=date('Y-m-d H:i:s');
                $model->created_by=\Yii::$app->user->identity->peg_nip;
                $model->created_ip = \Yii::$app->getRequest()->getUserIP();
                
                $model->updated_by=\Yii::$app->user->identity->peg_nip;
                $model->updated_time=date('Y-m-d H:i:s');
                $model->updated_ip = \Yii::$app->getRequest()->getUserIP();
                
                $model->id_kejati = $session->get('kode_kejati');
                $model->id_kejari = $session->get('kode_kejari');
                $model->id_cabjari = $session->get('kode_cabjari');
                //echo '<pre>';print_r($model);exit();
                if(!$model->save()){
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
                return $this->redirect(['update', 'id'=>$model->id_p37]);
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
            return $this->render('create', [
                    'model' => $model,
                    'modelSaksi' => $modelSaksi,
                    'modelJaksa' => $modelJaksa,
                    'modelTersangka' => $modelTersangka,
                    'searchJPU' => $searchJPU,
                    'dataJPU' => $dataJPU,
                    'sysMenu' => $this->sysMenu,
                    'vw_ahli'       => $vw_ahli,
                    'vw_saksi'      => $vw_saksi,
            ]);
        }
    }

    /**
     * Updates an existing PdmP37 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {
        
        $session = new session();
        $id_perkara = $session->get('id_perkara');
        $no_register_perkara = $session->get('no_register_perkara');
        $model = $this->findModel($no_register_perkara,$id);

        $modelTersangka = VwTerdakwaT2::findAll(['no_register_perkara'=>$no_register_perkara]);
        $searchJPU = new VwJaksaPenuntutSearch();
        $dataJPU = $searchJPU->search16a_new(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;
        /*$modelSaksi = PdmPanggilanSaksi::findOne(['id_saksi_ahli' => $model->id_saksi_ahli]);

        $modelJaksa = PdmJaksaPenerima::findOne(['id_perkara' => $model->id_perkara, 'code_table' => GlobalConstMenuComponent::P37, 'id_table' => $model->id_p37]);
        if ($modelJaksa == null) {
            $modelJaksa = new PdmJaksaPenerima();
        }
        $searchJPU = new VwJaksaPenuntutSearch();
        $dataJPU = $searchJPU->search16a_new(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;*/
        $vw_saksi       = PdmMsSaksi::findAll(['no_register_perkara'=>$no_register_perkara, 'jenis'=>1]);
        $vw_ahli        = PdmMsSaksi::findAll(['no_register_perkara'=>$no_register_perkara, 'jenis'=>2]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $transaction = Yii::$app->db->beginTransaction();
            // /echo '<pre>';print_r($_POST);exit;
            try {
                
                $model->no_register_perkara = $no_register_perkara;
                $model->tgl_lahir = $_POST['PdmP37']['tgl_lahir'];
                $model->updated_by=\Yii::$app->user->identity->peg_nip;
                $model->updated_time=date('Y-m-d H:i:s');
                $model->updated_ip = \Yii::$app->getRequest()->getUserIP();

                /*$model->nama_ttd = $_POST['hdn_nama_penandatangan'];
                $model->pangkat_ttd = $_POST['hdn_pangkat_penandatangan'];
                $model->jabatan_ttd = $_POST['hdn_jabatan_penandatangan'];*/
                
                if($model->save()||$model->update()){
                        $transaction->commit();
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
                }else{
                    var_dump($model->getErrors());exit;
                }

                /*$modelJaksa->load(Yii::$app->request->post());
                if ($modelJaksa->id_perkara == null) {
                    $seqjpp = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_jaksa_penerima', 'id_jpp', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
                    $modelJaksa->id_jpp = $seqjpp['generate_pk'];
                    $modelJaksa->id_perkara = $model->id_perkara;
                    $modelJaksa->code_table = GlobalConstMenuComponent::P37;
                    $modelJaksa->id_table = $model->id_p37;
                    $modelJaksa->flag = '1';
                    $modelJaksa->save();
                } else {
                    $modelJaksa->update();
                }*/

                
                return $this->redirect(['update', 'id'=>$model->id_p37]);
            } catch (Exception $ex) {
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
                return $this->redirect('index');
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'modelSaksi' => $modelSaksi,
                        'modelJaksa' => $modelJaksa,
                        'modelTersangka' => $modelTersangka,
                        'searchJPU' => $searchJPU,
                        'dataJPU' => $dataJPU,
                        'sysMenu' => $this->sysMenu,
                        'vw_saksi' => $vw_saksi,
                        'vw_ahli' => $vw_ahli,
            ]);
        }
    }

    /**
     * Deletes an existing PdmP37 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */

    public function actionTerdakwa()
    {
        $session = new session();
        $no_register_perkara = $session->get('no_register_perkara');
        $query = new Query;
        $query->select('vwt.*')
                ->from('pidum.vw_terdakwat2 vwt')
                ->where(['vwt.no_reg_tahanan' => $_POST['no_reg_tahanan']])
                ->andWhere(['=', 'vwt.no_register_perkara',$no_register_perkara ]);
        $terdakwa = $query->createCommand();
        $terdakwa = $terdakwa->queryOne();
//        echo '<pre>';print_r($terdakwa);exit;
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'tmpt_lahir' => $terdakwa['tmpt_lahir'],
            'tgl_lahir' => ($terdakwa['tgl_lahir'] != null) ? date('d-m-Y', strtotime($terdakwa['tgl_lahir'])) : '',
            'jns_kelamin' => $terdakwa['id_jkl'],
            'alamat' => $terdakwa['alamat'],
            'agama' => $terdakwa['id_agama'],
            'pekerjaan' => $terdakwa['pekerjaan'],
            'pendidikan' => $terdakwa['id_pendidikan'],
            'ditahan_sejak' => date('d-m-Y', strtotime($terdakwa['tgl_mulai'])),
            'no_reg_tahanan' => $terdakwa['no_reg_tahanan'],
            'no_surat_t8' => $terdakwa['no_surat_t8'],
            'no_register_perkara' => $terdakwa['no_register_perkara'],
            'nama' => $terdakwa['nama'],
            'no_urut_tersangka' => $terdakwa['no_urut_tersangka'],
            'tgl_mulai' => ($terdakwa['tgl_mulai'] != null) ? date('d-m-Y', strtotime($terdakwa['tgl_mulai'])) : '',
            'warganegara' => $terdakwa['id_warganegara'],
            'umur' => $terdakwa['umur']
        ];
    }
    
    public function actionSaksi()
    {
        $session = new session();
        $no_register_perkara = $session->get('no_register_perkara');

        $vw_saksi       = PdmMsSaksi::findOne(['no_register_perkara'=>$no_register_perkara, 'jenis'=>$_POST['jenis'], 'no_urut'=>$_POST['no_reg_tahanan']]);
//        echo '<pre>';print_r($vw_saksi->tmpt_lahir);exit;
        \Yii::$app->response->format = Response::FORMAT_JSON;
//        echo '<pre>';print_r($vw_saksi);exit;
        return [
            'tmpt_lahir' => $vw_saksi->tmpt_lahir,
            'umur' => $vw_saksi->umur,
            'no_urut' => $vw_saksi->no_urut,
            'tgl_lahir' => ($vw_saksi->tgl_lahir != null) ? date('d-m-Y', strtotime($vw_saksi->tgl_lahir)) : '',
            'jns_kelamin' => $vw_saksi->id_jkl,
            'alamat' => $vw_saksi->alamat,
            'agama' => $vw_saksi->id_agama,
            'pekerjaan' => $vw_saksi->pekerjaan,
            'pendidikan' => $vw_saksi->id_pendidikan,
//            'ditahan_sejak' => date('d-m-Y', strtotime($vw_saksi->tgl_mulai)),
//            'no_reg_tahanan' => $vw_saksi->no_reg_tahanan,
//            'no_surat_t8' => $vw_saksi->no_surat_t8,
//            'no_register_perkara' => $vw_saksi->no_register_perkara,
            'nama' => $vw_saksi->nama,
//            'no_urut_tersangka' => $vw_saksi->no_urut_tersangka,
//            'tgl_mulai' => ($vw_saksi->tgl_mulai != null) ? date('d-m-Y', strtotime($vw_saksi->tgl_mulai)) : '',
            'warganegara' => $vw_saksi->warganegara,
//            'umur' => $vw_saksi->umur
        ];
    }


    public function actionDelete() {
        $session = new session();

        $no_register_perkara = $session->get('no_register_perkara');
        $arr= array();
        $id_tahap = $_POST['hapusIndex'][0];
        
            if($id_tahap=='all'){
                    $id_tahapx=PdmP37::find()->select("id_p37")->where(['no_register_perkara'=>$no_register_perkara])->asArray()->all();
                    foreach ($id_tahapx as $key => $value) {
                        $arr[] = $value['id_p37'];
                    }
                    $id_tahap=$arr;
            }else{
                $id_tahap = $_POST['hapusIndex'];
            }
        //echo '<pre>';print_r($id_tahap);exit;
        $count = 0;
           foreach($id_tahap AS $key_delete => $delete){
            //echo '<pre>';print_r($delete);exit;
             try{
                    PdmP37::deleteAll(['no_register_perkara' => $no_register_perkara, 'id_p37'=>$delete]);
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

    /**
     * Finds the PdmP37 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmP37 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($no_register_perkara,$id) {
        if (($model = PdmP37::findOne(['no_register_perkara'=>$no_register_perkara, 'id_p37'=>$id])) !== null) {
            return $model;
        } /*else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }*/
    }

    public function actionCetak($id) {
        //$connection = \Yii::$app->db;
        $session = new session();
        $no_register_perkara = $session->get('no_register_perkara');
        $model = $this->findModel($no_register_perkara,$id);

        //echo '<pre>';print_r($model);exit;
        return $this->render('cetak',['session'=>$_SESSION, 'model'=>$model]); 
    }
}
