<?php

namespace app\modules\pidum\controllers;

use app\components\ConstDataComponent;
use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\PdmD4;
use app\modules\pidum\models\PdmD4Search;
use app\modules\pidum\models\PdmJaksaPenerima;
use app\modules\pidum\models\PdmMsStatusData;
use app\modules\pidum\models\PdmP41;
use app\modules\pidum\models\PdmP48;
use app\modules\pidum\models\PdmPutusanPn;
use app\modules\pidum\models\PdmPutusanPnTerdakwa;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmSysMenu;
use app\modules\pidum\models\PdmTerpanggil;
use app\modules\pidum\models\PdmPenandatangan;
use app\modules\pidum\models\VwJaksaPenuntutSearch;
use app\modules\pidum\models\VwTerdakwaT2;
use Odf;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;
use yii\web\Response;

/**
 * PdmD4Controller implements the CRUD actions for PdmD4 model.
 */
class PdmD4Controller extends Controller {

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
     * Lists all PdmD4 models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new PdmD4Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::D4]);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'sysMenu' => $sysMenu
        ]);
    }

    /**
     * Displays a single PdmD4 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmD4 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new PdmD4();
        $session = new session();
        $id_perkara = $session->get('id_perkara');
        $no_register_perkara = $session->get('no_register_perkara');
        $no_akta = $session->get('no_akta');
        $no_reg_tahanan = $session->get('no_reg_tahanan');
        $no_eksekusi = $session->get('no_eksekusi');

        $modelSpdp = PdmSpdp::findOne($id_perkara);
        $searchJPU = new VwJaksaPenuntutSearch();
        $dataJPU = $searchJPU->search16a_new(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;
        $model->dikeluarkan = Yii::$app->globalfunc->getNamaSatker($modelSpdp->wilayah_kerja)->inst_lokinst;

        $p48 = PdmP48::findOne(['no_surat'=>$no_eksekusi]);
        $putusan = PdmPutusanPn::findOne(['no_surat'=>$p48->no_putusan]);
        $putusanTerdakwa = PdmPutusanPnTerdakwa::findOne(['no_surat'=>$p48->no_putusan]);

        //echo '<pre>';print_r($putusanTerdakwa);exit;


        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                //echo '<pre>';print_r($_POST);exit;
                $model->no_eksekusi  = $no_eksekusi;
                $model->no_reg_tahanan = $no_reg_tahanan;

                $model->created_time=date('Y-m-d H:i:s');
                $model->created_by=\Yii::$app->user->identity->peg_nip;
                $model->created_ip = \Yii::$app->getRequest()->getUserIP();
                
                $model->updated_by=\Yii::$app->user->identity->peg_nip;
                $model->updated_time=date('Y-m-d H:i:s');
                $model->updated_ip = \Yii::$app->getRequest()->getUserIP();

                $model->nama_ttd = $_POST['hdn_nama_penandatangan'];
                $model->pangkat_ttd = $_POST['hdn_pangkat_penandatangan'];
                $model->jabatan_ttd = $_POST['hdn_jabatan_penandatangan'];

                if(!$model->save()){
                        var_dump($model->getErrors());exit;
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
                return $this->redirect(['update', 'no_surat' => $_POST['PdmD4']['no_surat']]);
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
                return $this->redirect('create');
            }
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'sysMenu' => $sysMenu,
                        'modeljakpen' => $modeljakpen,
                        'modelSpdp' => $modelSpdp,
                        'searchJPU' => $searchJPU,
                        'dataJPU' => $dataJPU,
                        'putusan' => $putusan,
                        'putusanTerdakwa' => $putusanTerdakwa,
            ]);
        }
    }

    /**
     * Updates an existing PdmD4 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($no_surat) {
        $session = new session();
        $id_perkara = $session->get('id_perkara');
        $no_register_perkara = $session->get('no_register_perkara');
        $no_akta = $session->get('no_akta');
        $no_reg_tahanan = $session->get('no_reg_tahanan');
        $no_eksekusi = $session->get('no_eksekusi');

        $model = $this->findModel($no_eksekusi,$no_surat);

        $modelSpdp = PdmSpdp::findOne($id_perkara);
        $searchJPU = new VwJaksaPenuntutSearch();
        $dataJPU = $searchJPU->search16a_new(Yii::$app->request->queryParams);
        $dataJPU->pagination->pageSize = 5;
        $model->dikeluarkan = Yii::$app->globalfunc->getNamaSatker($modelSpdp->wilayah_kerja)->inst_lokinst;

        $p48 = PdmP48::findOne(['no_surat'=>$no_eksekusi]);
        $putusan = PdmPutusanPn::findOne(['no_surat'=>$p48->no_putusan]);
        $putusanTerdakwa = PdmPutusanPnTerdakwa::findOne(['no_surat'=>$p48->no_putusan]);

        
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::D4]);

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {


                $model->no_eksekusi  = $no_eksekusi;
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
                    'message' => 'Data Berhasil di Simpan',
                    'title' => 'Simpan Data',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
                return $this->redirect(['update', 'no_surat' => $_POST['PdmD4']['no_surat'] ]);
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
                //return $this->redirect(['update', 'id' => $model->id_d4]);
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'sysMenu' => $sysMenu,
                        'modeljakpen' => $modeljakpen,
                        'modelSpdp' => $modelSpdp,
                        'searchJPU' => $searchJPU,
                        'dataJPU' => $dataJPU,
                        'putusan' => $putusan,
                        'putusanTerdakwa' => $putusanTerdakwa,
            ]);
        }
    }

    /**
     * Deletes an existing PdmD4 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete() {
        $id = $_POST['hapusIndex'];

        for ($i = 0; $i < count($id); $i++) {
            $model = PdmD4::findOne(['id_d4' => $id[$i]]);
            $model->flag = '3';
            $model->update();
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the PdmD4 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmD4 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($no_eksekusi, $no_surat) {
        if (($model = PdmD4::findOne(['no_eksekusi'=>$no_eksekusi, 'no_surat'=>$no_surat])) !== null) {
            return $model;
        } 
    }
    
    
     public function actionCetak($no_surat) {
         $session = new session();
         $id_perkara = $session->get('id_perkara');
         $no_register_perkara = $session->get('no_register_perkara');
         $no_akta = $session->get('no_akta');
         $no_reg_tahanan = $session->get('no_reg_tahanan');
         $no_eksekusi = $session->get('no_eksekusi');
         $spdp = PdmSpdp::findOne(['id_perkara'=>$id_perkara]);
         $no_urut = $no_urut - 1;
         $model = $this->findModel($no_eksekusi,$no_surat);
         $modelSpdp = PdmSpdp::findOne($id_perkara);
         $p48 = PdmP48::findOne(['no_surat'=>$no_eksekusi]);
         $putusan = PdmPutusanPn::findOne(['no_surat'=>$p48->no_putusan]);
         $putusan_terdakwa = PdmPutusanPnTerdakwa::findOne(['no_surat'=>$p48->no_putusan]);
         $tersangka = VwTerdakwaT2::findOne(['no_register_perkara'=>$no_register_perkara, 'no_reg_tahanan'=>$model->no_reg_tahanan]);
         
         //echo '<pre>';print_r($p48);exit;
         return $this->render('cetak', ['tersangka'=>$tersangka, 'p48'=>$p48 ,'model'=>$model, 'spdp'=>$spdp, 'putusan'=>$putusan, 'no_urut'=>$no_urut,'putusan_terdakwa'=>$putusan_terdakwa]);
    }


    public function actionUang(){
        $session = new session();
        $no_register_perkara = $session->get('no_register_perkara');
        $no_reg_tahanan = $session->get('no_reg_tahanan');
        $kode = $_POST['kode'];
        $no_putusan = $_POST['no_putusan'];
        $putusanTerdakwa = PdmPutusanPnTerdakwa::findOne(['no_surat'=>$no_putusan, 'no_register_perkara'=>$no_register_perkara]);
        switch ($kode) {
            case '1':
                $nilai = $putusanTerdakwa->biaya_perkara;
                break;
            
            default:
                $nilai = $putusanTerdakwa->denda;
                break;
        }

        \Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'nilai' => $nilai
        ];

    }
}
