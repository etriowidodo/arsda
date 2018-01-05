<?php

namespace app\modules\pdsold\controllers;

use Odf;
use Yii;
use app\components\GlobalConstMenuComponent;
use app\models\KpPegawai;
use app\modules\pdsold\models\PdmJaksaSaksi;
use app\modules\pdsold\models\PdmP46;
use app\modules\pdsold\models\PdmP46Search;
use app\modules\pdsold\models\PdmPasal;
use app\modules\pdsold\models\PdmPkTingRef;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmSysMenu;
use app\modules\pdsold\models\PdmPenandatangan;
use app\modules\pdsold\models\VwJaksaPenuntutSearch;
use app\modules\pdsold\models\VwTerdakwaT2;
use app\modules\pdsold\models\PdmP41Terdakwa;
use app\modules\pdsold\models\PdmPutusanPnTerdakwa;
use app\modules\pdsold\models\PdmPutusanPn;
use app\modules\pdsold\models\PdmUuPasalTahap2;
use app\modules\pdsold\models\PdmMsRentut;
use app\modules\pdsold\models\PdmP45;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Session;
use yii\web\NotFoundHttpException;

/**
 * PdmP46Controller implements the CRUD actions for PdmP46 model.
 */
class PdmP46Controller extends Controller {

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
        $this->sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P46]);
    }

    /**
     * Lists all PdmP46 models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new PdmP46Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'sysMenu' => $this->sysMenu
        ]);
    }

    /**
     * Displays a single PdmP46 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmP46 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new PdmP46();

        $session = new session();
        
        $no_register_perkara = $session->get('no_register_perkara');
        $no_akta = $session->get('no_akta');
        $no_reg_tahanan = $session->get('no_reg_tahanan');
        $terdakwa = VwTerdakwaT2::findOne(['no_register_perkara'=>$no_register_perkara, 'no_reg_tahanan'=>$no_reg_tahanan]);
        //echo '<pre>';print_r($tersangka);exit;
        $modelP41Terdakwa = PdmP41Terdakwa::findOne(['no_register_perkara'=>$no_register_perkara, 'status_rentut'=>3, 'no_reg_tahanan'=>$no_reg_tahanan]);
        $searchJPU = new VwJaksaPenuntutSearch();
        $dataJPU = $searchJPU->search16a_new(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;

        if ($model->load(Yii::$app->request->post())) {
            //echo '<pre>';print_r($_POST);exit;
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->no_register_perkara = $no_register_perkara;
                $model->no_akta =   $no_akta;
                $model->no_reg_tahanan = $no_reg_tahanan;

                $model->created_time=date('Y-m-d H:i:s');
                $model->created_by=\Yii::$app->user->identity->peg_nip;
                $model->created_ip = \Yii::$app->getRequest()->getUserIP();
                
                $model->updated_by=\Yii::$app->user->identity->peg_nip;
                $model->updated_time=date('Y-m-d H:i:s');
                $model->updated_ip = \Yii::$app->getRequest()->getUserIP();

                if(!$model->save()){
                        var_dump($model->getErrors());exit;
                }else{

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
                }
                
            } catch (Exception $e) {
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
            return $this->redirect('index');
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'modelSpdp' => $modelSpdp,
                        'dataJPU' => $dataJPU,
                        'searchJPU' => $searchJPU,
                        'sysMenu' => $this->sysMenu,
                        'modelP41Terdakwa' => $modelP41Terdakwa,
                        'terdakwa' => $terdakwa,
            ]);
        }
    }

    /**
     * Updates an existing PdmP46 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $session = new session();
        
        $no_register_perkara = $session->get('no_register_perkara');
        $id_perkara = $session->get('id_perkara');
        $no_akta = $session->get('no_akta');
        $no_reg_tahanan = $session->get('no_reg_tahanan');
        $model = $this->findModel($no_register_perkara,$id,$no_reg_tahanan);

        $terdakwa = VwTerdakwaT2::findOne(['no_register_perkara'=>$no_register_perkara, 'no_reg_tahanan'=>$no_reg_tahanan]);
        
        $searchJPU = new VwJaksaPenuntutSearch();
        $dataJPU = $searchJPU->search16a_new(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;


        if ($model->load(Yii::$app->request->post())) {
            //echo '<pre>';print_r($_POST);exit;
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->no_register_perkara = $no_register_perkara;
                $model->no_akta =   $no_akta;
                $model->no_reg_tahanan = $no_reg_tahanan;

                $model->updated_by=\Yii::$app->user->identity->peg_nip;
                $model->updated_time=date('Y-m-d H:i:s');
                $model->updated_ip = \Yii::$app->getRequest()->getUserIP();

                if(!$model->update()){
                        var_dump($model->getErrors());exit;
                       }
                $transaction->commit();
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'success',
                    'duration' => 3000,
                    'icon' => 'fa fa-users',
                    'message' => 'Data Berhasil di Ubah',
                    'title' => 'Ubah Data',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
            } catch (Exception $e) {
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
            return $this->redirect('index');
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'modelSpdp' => $modelSpdp,
                        'modeljaksi' => $modeljaksi,
                        'searchJPU' => $searchJPU,
                        'dataJPU' => $dataJPU,
                        'sysMenu' => $this->sysMenu,
                        'terdakwa' => $terdakwa,

            ]);
        }
    }

    /**
     * Deletes an existing PdmP46 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete() {
        $session = new session();
        
        $no_register_perkara = $session->get('no_register_perkara');
        $no_akta = $session->get('no_akta');
        $no_reg_tahanan = $session->get('no_reg_tahanan');
        
        PdmP46::deleteAll(['no_register_perkara'=>$no_register_perkara, 'no_akta'=>$no_akta, 'no_reg_tahanan'=>$no_reg_tahanan]);

        return $this->redirect(['index']);
    }

    /**
     * Finds the PdmP46 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmP46 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($no_register_perkara,$id,$no_reg_tahanan) {
        if (($model = PdmP46::findOne($no_register_perkara,$id,$no_reg_tahanan)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCetak($id) {
        $session = new session();
        
        $no_register_perkara = $session->get('no_register_perkara');
        $no_akta = $session->get('no_akta');
        $no_reg_tahanan = $session->get('no_reg_tahanan');
        $id_perkara = $session->get('id_perkara');

        $model = $this->findModel($no_register_perkara,$id,$no_reg_tahanan);

        $modelSpdp = PdmSpdp::findOne(['id_perkara' => $id_perkara]);

        $putusan_pn_terdakwa = PdmPutusanPnTerdakwa::findOne(['no_register_perkara'=>$no_register_perkara, 'status_rentut'=>3, 'no_reg_tahanan'=>$no_reg_tahanan]);
        $putusan_pn = PdmPutusanPn::findOne(['no_register_perkara'=>$no_register_perkara]);
        $pasal = json_decode($putusan_pn_terdakwa->undang_undang);
        $amar = PdmMsRentut::findOne($putusan_pn_terdakwa->id_ms_rentut)->nama;
        //echo '<pre>';print_r($amar);exit;

        
        $terdakwa = VwTerdakwaT2::findOne(['no_register_perkara'=>$no_register_perkara, 'no_reg_tahanan'=>$no_reg_tahanan]); 

        $listPasal = "";
        $jum = count($pasal->undang);
        foreach ($pasal->undang as $key => $value) {
            $pasal = PdmUuPasalTahap2::find()->select('undang, pasal')->where(['id_pasal'=>$value])->one();
            
            if($jum==1 || $key==0){
                $listPasal .= $pasal->undang.' '.$pasal->pasal;
            }else if($jum==2 && $key == 1){
                $listPasal .= ' dan '.$pasal->undang.' '.$pasal->pasal;
            }else{
                $listPasal .= ', '.$pasal->undang.' '.$pasal->pasal;
            }
        }        
        //echo $listPasal;exit;

        return $this->render('cetak', [
                        'model' => $model,
                        'listPasal' => $listPasal,
                        'tersangka' => $terdakwa,
                        'session' => $_SESSION,
                        'putusan_pn' => $putusan_pn,
                        'putusan_pn_terdakwa' => $putusan_pn_terdakwa,
                        'amar' => $amar,
            ]);
        }
}
