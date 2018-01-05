<?php

namespace app\modules\pidum\controllers;

use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\PdmPenandatangan;
use app\modules\pidum\models\PdmT8;
use app\modules\pidum\models\VwTersangka;
use Odf;
use Yii;
use app\modules\pidum\models\PdmT10;
use app\modules\pidum\models\PdmT10Search;
use app\modules\pidum\models\MsTersangka;
use app\modules\pidum\models\VwTerdakwaT2;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmTembusan;
use app\modules\pidum\models\PdmTembusanT10;
use app\modules\pidum\models\PdmTahapDua;
use app\modules\pidum\models\PdmBerkasTahap1;
use app\modules\pidum\models\PdmTrxPemrosesan;
use app\modules\pidum\models\VwJaksaPenuntutSearch;
use yii\base\Exception;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;

/**
 * PdmT10Controller implements the CRUD actions for PdmT10 model.
 */
class PdmT10Controller extends Controller
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
     * Lists all PdmT10 models.
     * @return mixed
     */
    public function actionIndex()
    {
        $session                = new Session();
        $id_perkara             = $session->get("id_perkara");
        $no_register_perkara    = $session->get("no_register_perkara");
        $searchModel            = new PdmT10Search();
        $dataProvider           = $searchModel->search($no_register_perkara);
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PdmT10 model.
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
     * Creates a new PdmT10 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $session                = new Session();
        $id_perkara             = $session->get("id_perkara");
        $no_register_perkara    = $session->get("no_register_perkara");
        $kode_kejati            = $session->get('kode_kejati');
        $kode_kejari            = $session->get('kode_kejari');
        $kode_cabjari           = $session->get('kode_cabjari');
        $model                  = new PdmT10();

        if ($model->load(Yii::$app->request->post())) {
//            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->no_register_perkara = $no_register_perkara;
                $model->id_kejati           = $kode_kejati;
                $model->id_kejari           = $kode_kejari;
                $model->id_cabjari          = $kode_cabjari;
                $model->updated_by          = $session->get("nik_user"); 
                $model->updated_ip          = $_SERVER['REMOTE_ADDR'];
                $model->created_ip          = $_SERVER['REMOTE_ADDR'];
                $model->created_by          = $session->get("nik_user");
//                echo '<pre>';print_r($model);exit();
                if ($model->save()) {
                    PdmTembusanT10::deleteAll(['no_surat_t10' => $model->no_surat_t10]);
                    if (isset($_POST['new_tembusan'])) {
                        for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                            $modelNewTembusan               = new PdmTembusanT10();
                            $modelNewTembusan->no_register_perkara  = $model->no_register_perkara;
                            $modelNewTembusan->no_surat_t10         = $model->no_surat_t10;
                            $modelNewTembusan->tembusan             = $_POST['new_tembusan'][$i];
                            $modelNewTembusan->no_urut              = $_POST['new_no_urut'][$i];
                            $modelNewTembusan->save();
                        }
                    }
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
                    
                }else{
//                    $transaction->rollback();
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
                    return $this->redirect('create',[
                        'model'                 => $model,
                        'no_register_perkara'   => $no_register_perkara,
                    ]);
                }
            } catch (Exception $exc) {
//                echo $exc->getTraceAsString();
//                $transaction->rollback();
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'danger',
                    'duration' => 3000,
                    'icon' => 'fa fa-users',
                    'message' => 'Terjadi Kesalahan',
                    'title' => 'Error',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
                return $this->redirect('create',[
                    'model'                 => $model,
                    'no_register_perkara'   => $no_register_perkara,
                ]);
            }
        } else {
            return $this->render('create', [
                'model'                 => $model,
                'no_register_perkara'   => $no_register_perkara,
            ]);
        }
    }

    /**
     * Updates an existing PdmT10 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $session                = new Session();
        $id_perkara             = $session->get("id_perkara");
        $no_register_perkara    = $session->get("no_register_perkara");
        $model                  = PdmT10::findOne(['no_surat_t10'=>$id]);
//        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
//            $transaction = Yii::$app->db->beginTransaction();
            try {
                $no_surat_T10           = $model->no_surat_t10;
                $no_register_perkara    = $model->no_register_perkara;
                if ($model->save()) {
                    
                    if (isset($_POST['new_tembusan'])) {
                        PdmTembusanT10::deleteAll(['no_surat_t10' => $no_surat_T10]);
                        for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                            $modelNewTembusan                       = new PdmTembusanT10();
                            $modelNewTembusan->no_surat_t10         = $model->no_surat_t10;
                            $modelNewTembusan->no_register_perkara  = $model->no_register_perkara;
                            $modelNewTembusan->tembusan             = $_POST['new_tembusan'][$i];
                            $modelNewTembusan->no_urut              = ($i+1);
                            if(!$modelNewTembusan->save()){
                                echo "Tembusan".var_dump($modelNewTembusan->getErrors());exit;
                            }
                        }
                    }
                    
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
                }else{
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
                    return $this->render('update', [
                        'model'                 => $model,
                        'no_register_perkara'   => $no_register_perkara,
                    ]);
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

                return $this->render('update', [
                    'model'                 => $model,
                    'no_register_perkara'   => $no_register_perkara,
                ]);
            } catch(Exception $e) {
//                $transaction->rollBack();
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

                return $this->render('update', [
                    'model'                 => $model,
                    'no_register_perkara'   => $no_register_perkara,
                ]);
            }
            /*$trxPemroresan = PdmTrxPemrosesan::findOne(['id_perkara' => $id]);
            $trxPemroresan->id_perkara = $id;
            $trxPemroresan->id_sys_menu = "91";
            $trxPemroresan->id_user_login = Yii::$app->user->identity->username;
            $trxPemroresan->update();*/
        } else {
            return $this->render('update', [
                'model'                 => $model,
                'no_register_perkara'   => $no_register_perkara,
            ]);
        }
    }

    /**
     * Deletes an existing PdmT10 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
        $connection             = \Yii::$app->db;
        try {
            $id                     = $_POST['hapusIndex'];
            $total                  = count($id);
            $session                = new Session();
            $id_perkara             = $session->get('id_perkara');
            $no_register_perkara    = $session->get('no_register_perkara');

            if($id === 'all') {
                PdmTembusanT10::deleteAll(['no_register_perkara' => $no_register_perkara,'no_surat_t10' => $id[0]]);
//                echo 'idnya '.$id[0];exit();
                PdmT10::deleteAll(['no_surat_t10' => $id[0]]);
            } else {
                for ($i = 0; $i < count($id); $i++) {
                       PdmTembusanT10::deleteAll(['no_register_perkara' => $no_register_perkara,'no_surat_t10' => $id[$i]]);
                       PdmT10::deleteAll(['no_surat_t10' => $id[$i]]);
                    }
            }

//            $transaction->commit();

            Yii::$app->getSession()->setFlash('success', [
                'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
                'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                'icon' => 'glyphicon glyphicon-ok-sign', //String
                'message' => 'Data Berhasil Dihapus', // String
                'title' => 'Delete', //String
                'positonY' => 'top', //String // defaults to top, allows top or bottom
                'positonX' => 'center', //String // defaults to right, allows right, center, left
                'showProgressbar' => true,
            ]);

            return $this->redirect(['index']);
        } catch(Exception $e) {
            $transaction->rollBack();

            Yii::$app->getSession()->setFlash('success', [
                'type' => 'danger', //String, can only be set to danger, success, warning, info, and growl
                'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                'icon' => 'glyphicon glyphicon-ok-sign', //String
                'message' => 'Data Gagal Dihapus', // String
                'title' => 'Delete', //String
                'positonY' => 'top', //String // defaults to top, allows top or bottom
                'positonX' => 'center', //String // defaults to right, allows right, center, left
                'showProgressbar' => true,
            ]);

            return $this->redirect(['index']);
        }

        /*$this->findModel($id)->delete();
        return $this->redirect(['index']);*/
    }
    
    public function actionCetak($id)
    {
        $no_surat_t10   = rawurldecode($id);
        $T10            = PdmT10::findOne(['no_surat_t10' => $no_surat_t10]);
        
        $thp_2          = PdmTahapDua::findOne(['no_register_perkara' => $T10->no_register_perkara]);
        $brks_thp_1     = PdmBerkasTahap1::findOne(['id_berkas' => $thp_2->id_berkas]);
        $spdp           = PdmSpdp::findOne(['id_perkara' => $brks_thp_1->id_perkara]);
        $pangkat        = PdmPenandatangan::findOne(['peg_nip_baru' => $T10->id_penandatangan]);
        $tersangka      = VwTerdakwaT2::findOne(['no_register_perkara' => $T10->no_register_perkara,'no_urut_tersangka' => $T10->id_tersangka]);
        $listTembusan   = PdmTembusanT10::findAll(['no_surat_t10' => $T10->no_surat_t10]);
        return $this->render('cetak', ['spdp'=>$spdp,'T10'=>$T10,'tersangka'=>$tersangka,'listTembusan'=>$listTembusan,'pangkat'=>$pangkat]);
    }
    

    /**
     * Finds the PdmT10 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmT10 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmT10::findOne($id)) !== null)
            return $model;
    }

    protected function getAge($birth_date)
    {
        return floor((time() - strtotime($birth_date))/31556926);
    }
}
